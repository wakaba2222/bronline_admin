<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Mypage extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/index.tpl';

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrRank'] = Tag_CustomerInfo::get_customer_rank($objCustomer->customer->getRank());

		$arrResult['total'] = Tag_CustomerInfo::get_purchase_amount($objCustomer->customer->getCustomerId());
		
		$order_date = '';
		
		$order_date = Tag_CustomerInfo::get_last_order($objCustomer->customer->getCustomerId());
//		var_dump($order_date);
		
		if ($order_date == '')
			$order_date = Tag_CustomerInfo::get_last_by($objCustomer->customer->getCustomerId());

		if ($order_date != '')
			$arrResult['next_date'] = date('Y年m月d日', strtotime($order_date.' +1year'));
		else
			$arrResult['next_date'] = '';


		$arrResult['next_total'] = $arrResult['arrCustomer']['purchase_amount'] - $arrResult['total'];
		$arrTemp = Tag_Master::get_master('mtb_customer_rank');
		$arrRank = array();
		foreach($arrTemp as $temp)
		{
			$arrRank[$temp['id']] = strtoupper($temp['name']);
		}
		$arrResult['next_stage'] = $arrRank[$objCustomer->customer->getRank()+1];

		$y = date('Y');
		$format = $y.'-m-d 00:00:00';
		$before = date($format, strtotime($arrResult['arrCustomer']['create_date']));
		$after = date('Y-m-d 00:00:00', strtotime($before." +0 year"));

		$arrResult['rank_date'] = date('Y-m-d 00:00:00', strtotime($after));
		$arrResult['update_date'] = date('Y-m-d 00:00:00', strtotime($after." +30 days"));

		$arrResult['debug'] = $debug;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_historylist()
	{
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/history_list.tpl';

		$page		= Input::param('page', 1);		// 取得ページ
		$view		= Input::param('view', 10);	// 並び替え
		$arrResult['arrHistory'] = Tag_Order::get_order($objCustomer->customer->getCustomerId(), $page, '', $view);
		
		$arrTemp = array();
		foreach($arrResult['arrHistory'] as $history)
		{
			if (intVal(date('Ymd',strtotime($history['create_date']))) >= 20191001)
				$tax = 1.10;
			else
				$tax = 1.08;
			
			$history['tax_rate'] = $tax;
			$arrTemp[] = $history;
		}
		$arrResult['arrHistory'] = $arrTemp;

		$arrTemp = array();
		foreach(Tag_Order::getPayment() as $payment)
		{
			$arrTemp[$payment['id']] = $payment['name'];
		}
		$arrResult['arrPayment'] = $arrTemp;

		$arrResult['page'] = $page;
		$arrResult['max'] = ceil(Tag_Order::get_order_count($objCustomer->customer->getCustomerId())/$view);

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrRank'] = Tag_CustomerInfo::get_customer_rank($objCustomer->customer->getRank());

		$arrResult['debug'] = $debug;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_deliv()
	{
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin?shopping=1');
		}

		$tpl = 'smarty/mypage/shopping.tpl';

		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();
		$arrResult['arrDeliv'] = Tag_CustomerInfo::get_deliv($objCustomer->customer->getCustomerId());
		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_delivadd()
	{
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/shoppingadd.tpl';

		if (count(Input::post()) > 0)
		{
//			var_dump(Input::post());
			$ret = Tag_CustomerInfo::set_deliv($objCustomer->customer->getCustomerId(), Input::post());
//			var_dump($ret);
			return Response::redirect('/mypage/');
		}

		if (Input::get('id') != '')
			$arrResult['arrDeliv'] = Tag_CustomerInfo::get_deliv($objCustomer->customer->getCustomerId(), Input::get('id'));
		else if (Input::get('del_id') != '')
		{
			Tag_CustomerInfo::delete_deliv($objCustomer->customer->getCustomerId(), Input::get('del_id'));
			return Response::redirect('/mypage/');
		}
		else
			$arrResult['arrDeliv'] = array('id'=>'', 'customer_id'=>'', 'name01'=>'', 'name02'=>'', 'kana01'=>'', 'kana02'=>'', 'zip01'=>'', 'zip02'=>'',
			'pref'=>'', 'addr01'=>'', 'addr02'=>'', 'tel01'=>'', 'tel02'=>'', 'tel03'=>'','fax01'=>'', 'fax02'=>'', 'company'=>'', 'department'=>'');

		$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_history()
	{
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/history.tpl';

		$id		= Input::param('detail');		// 取得ページ
		$page		= Input::param('page', 1);		// 取得ページ
		$view		= Input::param('view', 10);	// 並び替え
		$arrHistory = Tag_Order::get_order($objCustomer->customer->getCustomerId(),  $page, "id = {$id}", $view);
		$arrDetailTemp = Tag_Order::get_order_detail($arrHistory[0]['order_id']);
		$arrOrderDeliv = Tag_Order::get_order_deliv($arrHistory[0]['customer_id'], $arrHistory[0]['customer_deliv_id']);
		$arrDetail = array();
		foreach($arrDetailTemp as $d)
		{
			$image = Tag_Item::get_detail_images($d['product_id'], 'first = 1');
			$d['image'] = '';
			if (count($image) > 0)
			{
//				var_dump('/var/www/bronline/public/upload/images/'.$d['shop_mode'].'/'.$image[0]['path']);
//				var_dump($d);
//				$d['image'] = $image[0]['path'];
				if (file_exists('/var/www/bronline/public/upload/images/'.$d['shop_id'].'/'.$image[0]['path']))
					$d['image'] = $image[0]['path'];
				else
					$d['image'] = '';
			}
			$detail = Tag_Item::get_detail($d['product_id'],true);
			$d['brand_name'] = $detail['brand_name'];
			$d['brand_name_kana'] = $detail['brand_name_kana'];
			$arrDetail[] = $d;
		}
		$arrResult['arrHistory'] = $arrHistory[0];

		if (intVal(date('Ymd',strtotime($arrResult['arrHistory']['create_date']))) >= 20191001)
			$tax = 1.10;
		else
			$tax = 1.08;
		
		$arrResult['tax_rate'] = $tax;

		$arrResult['arrDetail'] = $arrDetail;
		$arrResult['arrOrderDeliv'] = $arrOrderDeliv[0];
		$arrTemp = array();
		foreach(Tag_Order::getPayment() as $payment)
		{
			$arrTemp[$payment['id']] = $payment['name'];
		}
		$arrResult['arrPayment'] = $arrTemp;

		$arrResult['page'] = $page;
		$arrResult['max'] = ceil(Tag_Order::get_order_count($objCustomer->customer->getCustomerId())/$view);

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrRank'] = Tag_CustomerInfo::get_customer_rank($objCustomer->customer->getRank());
		$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();

		$arrResult['debug'] = $debug;
		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_historylist2()
	{
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/history_list2.tpl';

		$page		= Input::param('page', 1);		// 取得ページ
		$view		= Input::param('view', 10);	// 並び替え
		$arrResult['arrHistory'] = Tag_Order::get_history_order($objCustomer->customer->getCustomerId(), $page, '', $view);
//var_dump($arrResult['arrHistory']);
		$arrTemp = array();
//		foreach(Tag_Order::getPayment() as $payment)
//		{
//			$arrTemp[$payment['id']] = $payment['name'];
//		}
		$arrTemp[4] = "代金引換";
		$arrTemp[5] = "クレジットカード";
		$arrTemp[6] = "アマゾンペイ";
		$arrTemp[3] = "銀行振込";
		$arrResult['arrPayment'] = $arrTemp;

		$arrResult['page'] = $page;
		$arrResult['max'] = ceil(Tag_Order::get_history_order_count($objCustomer->customer->getCustomerId())/$view);

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrRank'] = Tag_CustomerInfo::get_customer_rank($objCustomer->customer->getRank());

		$arrResult['debug'] = $debug;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_history2()
	{
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/mypage/history2.tpl';

		$id		= Input::param('detail');		// 取得ページ
		$page		= Input::param('page', 1);		// 取得ページ
		$view		= Input::param('view', 10);	// 並び替え
		$arrHistory = Tag_Order::get_history_order($objCustomer->customer->getCustomerId(),  $page, "order_id = {$id}", $view);
		$arrDetailTemp = Tag_Order::get_history_order_detail($arrHistory[0]['order_id']);
//		$arrOrderDeliv = Tag_Order::get_order_deliv($arrHistory[0]['customer_id'], $arrHistory[0]['customer_deliv_id']);
		$arrDetail = array();
		foreach($arrDetailTemp as $d)
		{
//			var_dump($d['product_code']);
			$product_id = Tag_Item::get_product_id($d['product_code']);
			if ($product_id != 0)
			{
				$image = Tag_Item::get_detail_images($d['product_id'], 'first = 1');
				if (file_exists('/var/www/bronline/public/upload/images/'.$d['shop_mode'].'/'.$image[0]['path']))
					$d['image'] = $image[0]['path'];
				else
					$d['image'] = '';
			}
			$detail = Tag_Item::get_detail($d['product_id']);
// 			$d['brand_name'] = $detail['brand_name'];
// 			$d['brand_name_kana'] = $detail['brand_name_kana'];
			$d['color_name'] = $d['classcategory_name1'];
			$d['size_name'] = $d['classcategory_name2'];
			$arrDetail[] = $d;
		}
		$arrTemp = $arrHistory[0];
// 		print("<pre>");
// 		var_dump($arrTemp);
// 		print("/<pre>");
// 		exit;
		$arrTemp['msg_card'] = $arrTemp['msg_card_msg'];
		$arrTemp['card'] = $arrTemp['msg_card'];
		$arrResult['arrHistory'] = $arrTemp;
		$arrResult['arrDetail'] = $arrDetail;
//		$arrResult['arrOrderDeliv'] = $arrOrderDeliv[0];
		$arrTemp = array();
//		foreach(Tag_Order::getPayment() as $payment)
//		{
//			$arrTemp[$payment['id']] = $payment['name'];
//		}
		$arrTemp[4] = "代金引換";
		$arrTemp[5] = "クレジットカード";
		$arrTemp[6] = "アマゾンペイ";
		$arrTemp[3] = "銀行振込";
		$arrResult['arrPayment'] = $arrTemp;

		$arrResult['page'] = $page;
		$arrResult['max'] = ceil(Tag_Order::get_order_count($objCustomer->customer->getCustomerId())/$view);

		$arrResult['arrCustomer'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['arrRank'] = Tag_CustomerInfo::get_customer_rank($objCustomer->customer->getRank());
		$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();

		$arrResult['debug'] = $debug;
		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}



	/**
	 * マイページ 登録情報 編集（初期表示）
	 * @return unknown
	 */
	public function action_memberedit() {
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

		// ユーザーデータ取得
		$arrCustomer = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrCustomer['email2'] = $arrCustomer['email'];
		$arrCustomer['year'] = date('Y', strtotime($arrCustomer['birth']));
		$arrCustomer['month'] = date('m', strtotime($arrCustomer['birth']));
		$arrCustomer['day'] = date('d', strtotime($arrCustomer['birth']));
		$arrCustomer['password'] = "";
		$arrCustomer['password2'] = "";
		$arrCustomer['reminder_answer'] = "";

		$arrResult['arrForm'] = $arrCustomer;
		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/mypage/member_edit.tpl';

		$arrResult["arrError"] = array();
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * マイページ 登録情報 編集（入力チェック）
	 * @return unknown
	 */
	public function post_memberedit() {
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}


		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('name01', 'お名前（姓）')->add_rule('required');
		$val->add('name02', 'お名前（名）')->add_rule('required');
		$val->add('kana01', 'フリガナ（セイ）')->add_rule('required')->add_rule('kana_only');
		$val->add('kana02', 'フリガナ（メイ）')->add_rule('required')->add_rule('kana_only');
		$val->add('company', '会社名');
		$val->add('department', '部署名');
		$val->add('zip01', '郵便番号1')->add_rule('required')->add_rule('exact_length', 3)->add_rule('number_only');
		$val->add('zip02', '郵便番号2')->add_rule('required')->add_rule('exact_length', 4)->add_rule('number_only');
		$val->add('pref', '都道府県')->add_rule('required_select');
		$val->add('addr01', '市区町村・番地')->add_rule('required');
		$val->add('addr02', 'ビル/マンション名・部屋番号');
		$val->add('tel01', '電話番号')->add_rule('required')->add_rule('number_only');
		if( Input::post('email') == Input::post('email_before') && Input::post('email2') == Input::post('email_before')) {
			$val->add('email', 'メールアドレス');
			$val->add('email2', 'メールアドレス（確認用）');
		} else {
			$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('customer_unique_email');
			$val->add('email2', 'メールアドレス（確認用）')->add_rule('required')->add_rule('valid_email')->add_rule('match_field','email');
		}
		$val->add('email_before', '変更前メールアドレス');
		$val->add('sex', '性別')->add_rule('required_select');
		$val->add('year', '生年月日（年）')->add_rule('required');
		$val->add('month', '生年月日（月）')->add_rule('required');
		$val->add('day', '生年月日（日）')->add_rule('required');
		if( Input::post('password') == "" ) {
			$val->add('password', 'パスワード');
			$val->add('password2', 'パスワード（確認用）');
		} else {
			$val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass');
			$val->add('password2', 'パスワード（確認用）')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass')->add_rule('match_field','password');
		}
		$val->add('reminder', '質問')->add_rule('required_select');
		if( Input::post('reminder_answer') == "" ) {
			$val->add('reminder_answer', '質問の答え');
		} else {
			$val->add('reminder_answer', '質問の答え')->add_rule('required');
		}


		$val->add('mailmaga_flg', 'メールマガジン購読')->add_rule('required_select');

		$arrResult['transactionid'] = Tag_Session::getToken();

		if( $val->run()) {
			// バリデーションエラーなし
			$arrResult["arrForm"] = $val->input();

			$tpl = 'smarty/mypage/member_confirm.tpl';

		} else {
			// バリデーションエラーあり
			$errors = $val->error();

			$arrError = array();
			foreach($errors as $f => $error )
			{
				$arrError[$f] = $error->get_message();
			}
			$arrResult["arrError"] = $arrError;

			/*
			 echo "<pre>";
			 print_r($arrError);
			 echo "</pre>";
			 */

			$arrResult["arrForm"] = $val->input();

			$tpl = 'smarty/mypage/member_edit.tpl';
		}

		return View_Smarty::forge( $tpl, $arrResult, true );
	}


	/**
	 * マイページ 登録情報 確認＆更新
	 * @return unknown
	 */
	public function action_memberconfirm() {
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		// 修正するボタンの場合編集画面を表示
		if( Input::post('btnSubmit') == 'return' ) {
			// マスタデータ取得
			$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

			$arrResult["arrForm"] = Input::post();
			$arrResult["arrError"] = array();
			$arrResult['transactionid'] = Tag_Session::getToken();

			$tpl = 'smarty/mypage/member_edit.tpl';
			return View_Smarty::forge( $tpl, $arrResult, true );
		}


		$arrUpdate = array();
		$arrUpdate['name01'] = Input::post('name01');
		$arrUpdate['name02'] = Input::post('name02');
		$arrUpdate['kana01'] = Input::post('kana01');
		$arrUpdate['kana02'] = Input::post('kana02');
		$arrUpdate['zip01'] = Input::post('zip01');
		$arrUpdate['zip02'] = Input::post('zip02');
		$arrUpdate['pref'] = Input::post('pref');
		$arrUpdate['addr01'] = Input::post('addr01');
		$arrUpdate['addr02'] = Input::post('addr02');
		$arrUpdate['email'] = Input::post('email');
		$arrUpdate['tel01'] = Input::post('tel01');
		$arrUpdate['sex'] = Input::post('sex');
		$arrUpdate['birth'] = Input::post('year').'/'.Input::post('month').'/'.Input::post('day');
		$arrUpdate['reminder'] = Input::post('reminder');
		//$arrUpdate['reminder_answer'] = Input::post('reminder_answer');

		if(  Input::post('reminder_answer') != "" ) {
			$sql  = "SELECT salt FROM dtb_customer WHERE customer_id = ".$objCustomer->customer->getCustomerId();
			$query = DB::query($sql);
			$arrRet = $query->execute()->as_array();
			$salt = $arrRet[0]['salt'];

			$arrUpdate['reminder_answer'] = $objCustomer->sfGetHashString(Input::post('reminder_answer'), $salt);
		}

		$arrUpdate['mailmaga_flg'] = Input::post('mailmaga_flg');
		$arrUpdate['company'] = Input::post('company');
		$arrUpdate['department'] = Input::post('department');
		$arrUpdate['update_date'] = date('Y-m-d H:i:s');

		if(  Input::post('password') != "" ) {
			$secret_key = "";
			do {
				$secret_key = $objCustomer->gfMakePassword(8);
				$exists = DB::select()->from('dtb_customer')->where('secret_key', $secret_key)->where('del_flg', 0)->execute()->as_array();
			} while ($exists);

			$salt = $objCustomer->gfMakePassword(10);
			$password = $objCustomer->sfGetHashString(Input::post('password'), $salt);

			$arrUpdate['salt'] = $salt;
			$arrUpdate['secret_key'] = $secret_key;
			$arrUpdate['password'] = $objCustomer->sfGetHashString(Input::post('password'), $salt);

			$arrUpdate['reminder_answer'] = $objCustomer->sfGetHashString(Input::post('reminder_answer'), $salt);
		}



		// アップデート
		$objUpdate = DB::update('dtb_customer');

		foreach ( $arrUpdate as $col => $val ) {
			$objUpdate->value( $col, $val );
		}
		$result = $objUpdate->where('customer_id', $objCustomer->customer->getCustomerId())->execute();


		if( 0 < $result ){
			// 成功
			// ユーザー情報を取得し直してセッションにセット
			$res = DB::select('dtb_customer.*', 'dtb_point.point')->from('dtb_customer')
					->join('dtb_point', 'LEFT')->on('dtb_customer.customer_id', '=', 'dtb_point.customer_id')
					->where('dtb_customer.customer_id', $objCustomer->customer->getCustomerId())->execute()->as_array();
			$arrCustomer = $res[0];

			// ユーザー情報をセッションに格納
			$objCustomer->customer->setName01($arrCustomer['name01']);
			$objCustomer->customer->setName02($arrCustomer['name02']);
			$objCustomer->setSession();

			$tpl = 'smarty/mypage/member_complete.tpl';

			return View_Smarty::forge( $tpl, $arrResult, true);

		} else {
			// 失敗
			return Response::redirect('/admin/error', 'location', 301);
			//echo "会員情報の変更に失敗しました";
			//exit;
		}
	}



	/**
	 * マイページ 退会 確認（初期表示）
	 * @return unknown
	 */
	public function action_unsubscribe() {
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$arrResult['arrForm'] = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/mypage/unsubscribe.tpl';

		$arrResult["arrError"] = array();
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * マイページ 退会
	 * @return unknown
	 */
	public function post_unsubscribe() {
		$debug = array();
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		// アップデート
		$result = DB::update('dtb_customer')->value('del_flg', 1)->value('update_date', date('Y-m-d H:i:s'))->where('customer_id', $objCustomer->customer->getCustomerId())->execute();

		if( $result == 1 ) {
			// 退会完了
			Tag_customerctrl::clearSession();

			$tpl = 'smarty/mypage/unsubscribe_complete.tpl';
			return View_Smarty::forge( $tpl, $arrResult, true);

		} else {
			// 失敗
			return Response::redirect('/error', 'location', 301);
			//echo "退会処理に失敗しました";
			//exit;
		}
	}



	/**
	 * マイページ お気に入り
	 * @return unknown
	 */
	public function action_Wishlist() {
		$debug = array();
		$arrResult = array();

		$post_per_page	= 30;
		$page			= Input::param('page', 1);
		$arrResult['page'] = $page;

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		$objWishlist = new Tag_Wishlistctrl();
		$where = "";
		if ($objCustomer->customer->getCustomerId() == '')
		{
			$ids = implode(',', $objWishlist->get_wish_product_id_list_cookie());
//Profiler::console($ids);
			if( $ids != "" ) {
				$where = " A.product_id in (".$ids.") ";
				$arrResult['arrData'] = $objWishlist->get_mypage_wish_list('0', $page, $post_per_page, $where);
			} else {
				// cookieに情報が無いとき
				$arrResult['arrData'] = array('arrWishData' => array());
			}
//			return Response::redirect('/signin/');
		}
		else
			$arrResult['arrData'] = $objWishlist->get_mypage_wish_list($objCustomer->customer->getCustomerId(), $page, $post_per_page);


		$tpl = 'smarty/mypage/wishlist.tpl';

		$arrResult["arrError"] = array();
		$arrResult['debug'] = $debug;

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		return View_Smarty::forge( $tpl, $arrResult, false );
	}




	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('home/404'), 404);
//        return View_Smarty::forge('smarty/404.tpl');
//		return Response::forge(Presenter::forge('home/404'), 404);
	}
}

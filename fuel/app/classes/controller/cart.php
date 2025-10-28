<?php
//var_dump(VENDORPATH);
//exit;
//require_once VENDORPATH.'/autoload.php';
//use Amazon\Pay\API\Client as Client;
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

class Controller_Cart extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
//		var_dump($_SESSION);
//exit;
		if (isset($_SESSION['complete']))
		{
			unset($_SESSION['complete']);
		}

		$arrResult = array();
//		var_dump(Input::param());

		$tpl = 'smarty/cart/index.tpl';

		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();

		$arrResult['arrItems'] = $cartctrl->cart->getOrderDetail();
//var_dump($arrResult['arrItems']);
		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		$arrResult['stockerror'] = Tag_Session::get('CART_ERROR');
		Tag_Session::delete('CART_ERROR');
		

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
		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$arrResult['sale_flg'] = 0;
		$arrResult['vip_sale_flg'] = 0;
		$arrResult['sale_par'] = 0;
		if ($start_date <= $now && $end_date >= $now)
		{
			$arrResult['sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$arrResult['vip_sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['vip_sale'];
		}
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

	public function action_subscribe()
	{
		$debug = array();

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

		/*
		echo "<pre>";
		print_r($arrResult["arrReminder"]);
		echo "</pre>";
		*/

		$arrResult["arrForm"] = array();
		$arrResult["arrError"] = array();

		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/cart/subscribe.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}

	public function post_subscribe()
	{
		if (!$this->doValidToken())
		{
			return Response::forge(View::forge('home/404'), 404);
		}

		$debug = array();
		$arrResult = array();

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
		$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email');
		$val->add('email2', 'メールアドレス（確認用）')->add_rule('required')->add_rule('valid_email')->add_rule('match_field','email');
		$val->add('sex', '性別')->add_rule('required_select');
		$val->add('year', '生年月日（年）');//->add_rule('required');
		$val->add('month', '生年月日（月）');//->add_rule('required');
		$val->add('day', '生年月日（日）');//->add_rule('required');
// 		$val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass');
// 		$val->add('password2', 'パスワード（確認用）')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass')->add_rule('match_field','password');
// 		$val->add('reminder', '質問')->add_rule('required_select');
// 		$val->add('reminder_answer', '質問の答え')->add_rule('required');
// 		$val->add('mailmaga_flg', 'メールマガジン購読')->add_rule('required_select');
		Profiler::console(Input::param());

		if (Input::param('login_memory') == '1')
		{
			$val->add('other_name01', 'お名前（姓）')->add_rule('required');
			$val->add('other_name02', 'お名前（名）')->add_rule('required');
			$val->add('other_kana01', 'フリガナ（セイ）')->add_rule('required')->add_rule('kana_only');
			$val->add('other_kana02', 'フリガナ（メイ）')->add_rule('required')->add_rule('kana_only');
			$val->add('other_company', '会社名');
			$val->add('other_department', '部署名');
			$val->add('other_zip01', '郵便番号1')->add_rule('required')->add_rule('exact_length', 3)->add_rule('number_only');
			$val->add('other_zip02', '郵便番号2')->add_rule('required')->add_rule('exact_length', 4)->add_rule('number_only');
			$val->add('other_pref', '都道府県')->add_rule('required_select');
			$val->add('other_addr01', '市区町村・番地')->add_rule('required');
			$val->add('other_addr02', 'ビル/マンション名・部屋番号');
			$val->add('other_tel01', '電話番号')->add_rule('required')->add_rule('number_only');
		}

		$arrResult['transactionid'] = Tag_Session::getToken();

			$cart_ctrl = new Tag_Cartctrl();
			$cart_ctrl->getSession();
		if( $val->run()) {
			// バリデーションエラーなし
			$arrResult["arrForm"] = $val->input();

			if (count($cart_ctrl->cart->getOrderDetail()) == 0) {
				return Response::redirect('/cart/');
	
	// 			// エラー画面へ遷移する予定
	// 			echo 'SESSIONが取得できませんでした';
	// 			exit;
			}
			$objCustomer = new Tag_customerctrl();
			$objCustomer->getSession();
			
			$cart_ctrl->cart->setMemberId(0);
			$cart_ctrl->cart->setCustomerDelivId(0);
			
			$cart_ctrl->cart->setCustomerName(Input::param('name01'));
			$cart_ctrl->cart->setCustomerName2(Input::param('name02'));
			$cart_ctrl->cart->setCustomerKana(Input::param('kana01'));
			$cart_ctrl->cart->setCustomerKana2(Input::param('kana02'));
			$cart_ctrl->cart->setCompany(Input::param('company'));
			$cart_ctrl->cart->setSection(Input::param('department'));
			$cart_ctrl->cart->setZip(Input::param('zip01'));
			$cart_ctrl->cart->setZip2(Input::param('zip02'));
			$cart_ctrl->cart->setPref(Input::param('pref'));
			$cart_ctrl->cart->setAddress(Input::param('addr01'));
			$cart_ctrl->cart->setAddress2(Input::param('addr02'));
			$cart_ctrl->cart->setTelNumber(Input::param('tel01'));
			$cart_ctrl->cart->setCustomerEmail(Input::param('email'));
			$cart_ctrl->cart->setAmount($cart_ctrl->cart->getTotalPricePaymentWithTax());
			$cart_ctrl->cart->setOrderId( Tag_Order::get_order_id() );

			if (Input::param('login_memory'))
			{
				$cart_ctrl->cart->setOtherFlg(Input::param('login_memory'));
				$cart_ctrl->cart->setOtherName(Input::param('other_name01'));
				$cart_ctrl->cart->setOtherName2(Input::param('other_name02'));
				$cart_ctrl->cart->setOtherKana(Input::param('other_kana01'));
				$cart_ctrl->cart->setOtherKana2(Input::param('other_kana02'));
				$cart_ctrl->cart->setOtherCompany(Input::param('other_company'));
				$cart_ctrl->cart->setOtherSection(Input::param('other_department'));
				$cart_ctrl->cart->setOtherZip(Input::param('other_zip01'));
				$cart_ctrl->cart->setOtherZip2(Input::param('other_zip02'));
				$cart_ctrl->cart->setOtherPref(Input::param('other_pref'));
				$cart_ctrl->cart->setOtherAddress(Input::param('other_addr01'));
				$cart_ctrl->cart->setOtherAddress2(Input::param('other_addr02'));
				$cart_ctrl->cart->setOtherTelNumber(Input::param('other_tel01'));
			}
$arrResult['total_price'] = $cart_ctrl->cart->getTotalPricePayment(false,true);
			// カート情報をセッションに設定
			$cart_ctrl->setSession();

			// セッションより入力状態を復元
			$arrResult['type_01'] = ( $cart_ctrl->cart->getPaymentType() == "1" ) ? "checked='checked'" : '';
			$arrResult['type_02'] = ( $cart_ctrl->cart->getPaymentType() == "2" ) ? "checked='checked'" : '';
			$arrResult['type_03'] = ( $cart_ctrl->cart->getPaymentType() == "3" ) ? "checked='checked'" : '';
//			$arrResult['type_04'] = ( $cart_ctrl->cart->getPaymentType() == "4" ) ? "checked='checked'" : '';
			if ($arrResult['total_price']+330 > 300000)
				$arrResult['type_04'] = '';
			else
				$arrResult['type_04'] = ( $cart_ctrl->cart->getPaymentType() == "4" ) ? "checked='checked'" : '';
			$arrResult['type_05'] = ( $cart_ctrl->cart->getPaymentType() == "5" ) ? "checked='checked'" : '';
	
			$arrResult['coupon_cd'] = $cart_ctrl->cart->getCouponCd();
	
			$arrResult['point_use_yes'] = '';
			$arrResult['point_use_no'] = "checked='checked'";
			$arrResult['point_use'] = '';
			$arrResult['point_use_disabled'] = "disabled='true'";
			if ( $cart_ctrl->cart->getPointUseYN() == "1" ) {
				$arrResult['point_use_yes'] = "checked='checked'";
				$arrResult['point_use_no'] = '';
				$arrResult['point_use'] = $cart_ctrl->cart->getPointUse();
				$arrResult['point_use_disabled'] = '';
			}
	
			$arrResult['specification_yes'] = '';
			$arrResult['specification_no'] = "checked='checked'";
			if ( $cart_ctrl->cart->getSpecification() == "1" ) {
				$arrResult['specification_yes'] = "checked='checked'";
				$arrResult['specification_no'] = '';
			}
	
			$arrResult['receipt_name'] = $cart_ctrl->cart->getReceiptName();
			$arrResult['receipt_tadashi'] = $cart_ctrl->cart->getReceiptTadashi();
	
			$arrResult['simple_package_0'] = "selected=''";
			$arrResult['simple_package_1'] = '';
			if ( $cart_ctrl->cart->getSimplePackage() == '1' ) {
				$arrResult['simple_package_0'] = '';
				$arrResult['simple_package_1'] = "selected=''";
			}
	
			$arrResult['lapping_0'] = "selected=''";
			$arrResult['lapping_1'] = '';
			if ( $cart_ctrl->cart->getLapping() == '1' ) {
				$arrResult['lapping_0'] = "";
				$arrResult['lapping_1'] = "selected=''";
			}
	
			$arrResult['msg_card_0'] = "selected=''";
			$arrResult['msg_card_1'] = '';
			$arrResult['msg_card_dtl'] = '';
			$arrResult['msg_card_dtl_disabled'] = "disabled='true'";
			if ( $cart_ctrl->cart->getMsgCard() == '1' ) {
				$arrResult['msg_card_0'] = '';
				$arrResult['msg_card_1'] = "selected=''";
				$arrResult['msg_card_dtl'] = $cart_ctrl->cart->getMsgCardDtl();
				$arrResult['msg_card_dtl_disabled'] = '';
			}
	
			$arrResult['msg_contact'] = $cart_ctrl->cart->getMsgContact();
			// suzuki add ↓↓↓↓↓
			$arrResult['payment_back_url'] = PAYMENT_BACK_URL;
			// suzuki add ↑↑↑↑↑
	
$arrResult['customer_email'] = $cart_ctrl->cart->getCustomerEmail();
$arrResult['customer_id'] = 0;
			$tpl = 'smarty/cart/payment.tpl';
//			return Response::redirect('/cart/payment');

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

			$tpl = 'smarty/cart/subscribe.tpl';
		}

		$payOff = 0;
		$reservation = 0;

		$arrCartTemp = array();		
		foreach($cart_ctrl->cart->getOrderDetail() as $d)
		{
			$count = $d->getQuantity();
			$pid = $d->getProductId();
			$p = $d->getPrice();
			$arrTemp = array();
			$arrTemp['quantity'] = $count;
			$arrTemp['price'] = $p;
			$arrTemp['pid'] = $pid;
			$arrCartTemp[] = $arrTemp;

			if ($payOff == 0)
				$payOff = $d->getPayOff();
			if ($reservation == 0)
				$reservation = $d->getReservation();
		}
$arrResult['cartinfo'] = $arrCartTemp;
//print("<pre>");
//var_dump($arrResult['cartinfo']);
//print("</pre>");
//exit;
//print("</pre>");

		$cupon_view = 1;
		$arrResult['cupon_view'] = $cupon_view;
		$arrResult['guest'] = '1';
		$arrResult['pay_off'] = $payOff;
		$arrResult['reservation'] = $reservation;
//print("<pre>");
//var_dump($arrResult);
//print("</pre>");

		return View_Smarty::forge( $tpl, $arrResult, true );
	}

	public function action_shoppingadd()
	{
		$arrResult = array();
		
		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();
		
		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin/');
		}

		$tpl = 'smarty/cart/shoppingadd.tpl';
		
		if (count(Input::post()) > 0)
		{
//			var_dump(Input::post());
			$ret = Tag_CustomerInfo::set_deliv($objCustomer->customer->getCustomerId(), Input::post());
//			var_dump($ret);
			return Response::redirect('/cart/shopping/');
		}
		
		if (Input::get('id') != '')
			$arrResult['arrDeliv'] = Tag_CustomerInfo::get_deliv($objCustomer->customer->getCustomerId(), Input::get('id'));
		else if (Input::get('del_id') != '')
		{
			Tag_CustomerInfo::delete_deliv($objCustomer->customer->getCustomerId(), Input::get('del_id'));
			return Response::redirect('/cart/shopping/');
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

	public function action_shopping()
	{
		$arrResult = array();

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();
		
		if ($objCustomer->customer->getCustomerId() == '')
		{
			return Response::redirect('/signin?shopping=1');
		}

		$tpl = 'smarty/cart/shopping.tpl';

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
	
	public function after($response)
	{
		$now = date('Y-m-d');
		$arrTemp = array();
		for($i = 3;$i < 10;$i++)
		{
			$arrTemp[$i-2] = date('Y年m月d日', strtotime($now.' +'.$i.' day'));
		}
		$response->set('arrDate', $arrTemp);
//		$arrResult['delivery_date'] = $arrTemp;
		
		$arrRet = Tag_Cartctrl::get_delivtime();
		$arrTemp = array();
		foreach($arrRet as $temp)
		{
			$arrTemp[$temp['time_id']] = $temp['deliv_time'];
		}
		$response->set('arrTime', $arrTemp);

		return parent::after($response);
	}
	
	public function action_payment()
	{
		$arrResult = array();

		$tpl = 'smarty/cart/payment.tpl';
		
		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$arrResult['sale_flg'] = 0;
		$arrResult['vip_sale_flg'] = 0;
		$arrResult['sale_par'] = 0;

		if ($start_date <= $now && $end_date >= $now)
		{
			$arrResult['sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$arrResult['vip_sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['vip_sale'];
		}
//		var_dump($arrRet);

		// suzuki add ↓↓↓↓↓
		// カート情報のオブジェクト作成と初期化
		$cart_ctrl = new Tag_Cartctrl();
		$cart_ctrl->getSession();
		if (count($cart_ctrl->cart->getOrderDetail()) == 0) {
			return Response::redirect('/cart/');

// 			// エラー画面へ遷移する予定
// 			echo 'SESSIONが取得できませんでした';
// 			exit;
		}
		$payOff = 0;
		$reservation = 0;
		foreach($cart_ctrl->cart->getOrderDetail() as $d)
		{
			$count = $d->getQuantity();
			$stock = Tag_Item::get_product_stock($d->getProductId(), $d->getProductCode());
			if ($stock < $count)
			{
				Tag_Session::set('CART_ERROR', $d->getName().'は在庫が無くなっています。調整してください。');
				return Response::redirect('/cart/');
			}
			if ($payOff == 0)
				$payOff = $d->getPayOff();
			if ($reservation == 0)
				$reservation = $d->getReservation();
		}

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();
		
		if ($objCustomer->customer->getCustomerId() != '')
		{
//			var_dump(Tag_Order::get_order_id());
			if (Input::post('add') != '0' && Input::post('add') != null)
			{
				$arrDeliv = Tag_CustomerInfo::get_deliv($objCustomer->customer->getCustomerId(), Input::post('add'));
				$cart_ctrl->cart->setCustomerDelivId(Input::post('add'));
				
				$cart_ctrl->cart->setMemberId($arrDeliv['customer_id']);
				$cart_ctrl->cart->setCustomerName($arrDeliv['name01']);
				$cart_ctrl->cart->setCustomerName2($arrDeliv['name02']);
				$cart_ctrl->cart->setCustomerKana($arrDeliv['kana01']);
				$cart_ctrl->cart->setCustomerKana2($arrDeliv['kana02']);
				$cart_ctrl->cart->setCompany($arrDeliv['company']);
				$cart_ctrl->cart->setSection($arrDeliv['department']);
				$cart_ctrl->cart->setZip($arrDeliv['zip01']);
				$cart_ctrl->cart->setZip2($arrDeliv['zip02']);
				$cart_ctrl->cart->setPref($arrDeliv['pref']);
				$cart_ctrl->cart->setAddress($arrDeliv['addr01']);
				$cart_ctrl->cart->setAddress2($arrDeliv['addr02']);
				$cart_ctrl->cart->setTelNumber($arrDeliv['tel01']);
				$cart_ctrl->cart->setAmount($cart_ctrl->cart->getTotalPricePaymentWithTax());
				$cart_ctrl->cart->setOrderId( Tag_Order::get_order_id() );
			}
			else
			{
				$customer = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
				// カート情報の作成
	//			date_default_timezone_set('Asia/Tokyo');
	//			$cart_ctrl->cart->setOrderId( date('YmdHis') );
				$cart_ctrl->cart->setCustomerDelivId(0);
				// 購入者情報
				$cart_ctrl->cart->setMemberId($customer['customer_id']);
				$cart_ctrl->cart->setCustomerName($customer['name01']);
				$cart_ctrl->cart->setCustomerName2($customer['name02']);
				$cart_ctrl->cart->setCustomerKana($customer['kana01']);
				$cart_ctrl->cart->setCustomerKana2($customer['kana02']);
				$cart_ctrl->cart->setCompany($customer['company']);
				$cart_ctrl->cart->setSection($customer['department']);
				$cart_ctrl->cart->setZip($customer['zip01']);
				$cart_ctrl->cart->setZip2($customer['zip02']);
				$cart_ctrl->cart->setPref($customer['pref']);
				$cart_ctrl->cart->setAddress($customer['addr01']);
				$cart_ctrl->cart->setAddress2($customer['addr02']);
				$cart_ctrl->cart->setTelNumber($customer['tel01']);
				$cart_ctrl->cart->setAmount($cart_ctrl->cart->getTotalPricePaymentWithTax());
				$cart_ctrl->cart->setOrderId( Tag_Order::get_order_id() );
			}
			Profiler::console($cart_ctrl->cart);
			// カート情報をセッションに設定
			$cart_ctrl->setSession();
		}

$arrResult['total_price'] = $cart_ctrl->cart->getTotalPricePayment(false,true);
if (false){
		// *******************************************************
		// PAYMENT画面に来る前に作成されている予定？のカート情報
		// *******************************************************
		if ( $cart_ctrl->cart->getOrderId() == '' ) {
			// カート情報の作成
			date_default_timezone_set('Asia/Tokyo');
			$cart_ctrl->cart->setOrderId( date('YmdHis') );
			$cart_ctrl->cart->setAmount( 129999 );
			$cart_ctrl->cart->setMemberId( 'member002' );
			// 購入者情報
			$cart_ctrl->cart->setCustomerName( '田中　太郎' );
			$cart_ctrl->cart->setCustomerKana( 'タナカ　タロウ' );
			$cart_ctrl->cart->setCompany( '株式会社TANAKA' );
			$cart_ctrl->cart->setSection( '総務部' );
			$cart_ctrl->cart->setZip( '101-0001' );
			$cart_ctrl->cart->setAddress( '東京都千代田区本町1-1-1' );
			$cart_ctrl->cart->setTelNumber( '03-1234-5678' );

			// 商品情報
			$order_detail = array();
			$detail1 = new Tag_Cartorderdetail();
			$detail1->setName( '人気ショップ' );
			$detail1->setName( 'ニットジャケット' );
			$detail1->setPrice( 43333 );
			$detail1->setSize( 'Lサイズ' );
			$detail1->setColor( 'BLACK' );
			$detail1->setQuantity( 1 );
			$order_detail[] = $detail1;
			//
			$detail2 = new Tag_Cartorderdetail();
			$detail2->setName( '人気ショップ' );
			$detail2->setName( 'ニットジャケット' );
			$detail2->setPrice( 86666 );
			$detail2->setSize( 'Mサイズ' );
			$detail2->setColor( 'WHITE' );
			$detail2->setQuantity( 2 );
			$order_detail[] = $detail2;
			$cart_ctrl->cart->setOrderDetail( $order_detail );
			// カート情報をセッションに設定
			$cart_ctrl->setSession();
		}
}
		// *******************************************************
	
		// セッションより入力状態を復元
		$arrResult['type_01'] = ( $cart_ctrl->cart->getPaymentType() == "1" ) ? "checked='checked'" : '';
		$arrResult['type_02'] = ( $cart_ctrl->cart->getPaymentType() == "2" ) ? "checked='checked'" : '';
		$arrResult['type_03'] = ( $cart_ctrl->cart->getPaymentType() == "3" ) ? "checked='checked'" : '';
		if ($arrResult['total_price']+330 > 300000)
			$arrResult['type_04'] = '';
		else
			$arrResult['type_04'] = ( $cart_ctrl->cart->getPaymentType() == "4" ) ? "checked='checked'" : '';
		$arrResult['type_05'] = ( $cart_ctrl->cart->getPaymentType() == "5" ) ? "checked='checked'" : '';

		$arrResult['coupon_cd'] = $cart_ctrl->cart->getCouponCd();

		$arrResult['point_use_yes'] = '';
		$arrResult['point_use_no'] = "checked='checked'";
		$arrResult['point_use'] = '';
		$arrResult['point_use_disabled'] = "disabled='true'";
		if ( $cart_ctrl->cart->getPointUseYN() == "1" ) {
			$arrResult['point_use_yes'] = "checked='checked'";
			$arrResult['point_use_no'] = '';
			$arrResult['point_use'] = $cart_ctrl->cart->getPointUse();
			$arrResult['point_use_disabled'] = '';
		}

		$arrResult['specification_yes'] = '';
		$arrResult['specification_no'] = "checked='checked'";
		if ( $cart_ctrl->cart->getSpecification() == "1" ) {
			$arrResult['specification_yes'] = "checked='checked'";
			$arrResult['specification_no'] = '';
		}

		$arrResult['receipt_name'] = $cart_ctrl->cart->getReceiptName();
		$arrResult['receipt_tadashi'] = $cart_ctrl->cart->getReceiptTadashi();

		$arrResult['simple_package_0'] = "selected=''";
		$arrResult['simple_package_1'] = '';
		if ( $cart_ctrl->cart->getSimplePackage() == '1' ) {
			$arrResult['simple_package_0'] = '';
			$arrResult['simple_package_1'] = "selected=''";
		}

		$arrResult['lapping_0'] = "selected=''";
		$arrResult['lapping_1'] = '';
		if ( $cart_ctrl->cart->getLapping() == '1' ) {
			$arrResult['lapping_0'] = "";
			$arrResult['lapping_1'] = "selected=''";
		}

		$arrResult['msg_card_0'] = "selected=''";
		$arrResult['msg_card_1'] = '';
		$arrResult['msg_card_dtl'] = '';
		$arrResult['msg_card_dtl_disabled'] = "disabled='true'";
		if ( $cart_ctrl->cart->getMsgCard() == '1' ) {
			$arrResult['msg_card_0'] = '';
			$arrResult['msg_card_1'] = "selected=''";
			$arrResult['msg_card_dtl'] = $cart_ctrl->cart->getMsgCardDtl();
			$arrResult['msg_card_dtl_disabled'] = '';
		}

		$arrResult['customer_id'] = $objCustomer->customer->getCustomerId();
		$arrResult['msg_contact'] = $cart_ctrl->cart->getMsgContact();
		$arrResult['payment_back_url'] = PAYMENT_BACK_URL;
		$arrResult['customer_email'] = $cart_ctrl->cart->getCustomerEmail();
		if ($objCustomer->customer->getCustomerId() != 0)
		{
			$customer = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
			$arrResult['customer_email'] = $customer['email'];
//			var_dump($customer);
		}
		// suzuki add ↑↑↑↑↑
		$cupon_view = 0;
		if ($objCustomer->customer->getName01() != '')
		{
			$cupon_view = 1;
			if ($objCustomer->customer->getSaleStatus() == 0 || $objCustomer->customer->getSaleStatus() == -1)
			{
//				$cupon_view = 1;
			}
			else if ($objCustomer->customer->getSaleStatus() == 1 && $arrResult['sale_flg'] == 1)
			{
				$cupon_view = 0;
			}
			else if ($objCustomer->customer->getSaleStatus() == 2 && $arrResult['vip_sale_flg'] == 1)
			{
				$cupon_view = 0;
			}
		}

		$arrCartTemp = array();		
		foreach($cart_ctrl->cart->getOrderDetail() as $d)
		{
			$count = $d->getQuantity();
			$pid = $d->getProductId();
			$p = $d->getPrice();
			$arrTemp = array();
			$arrTemp['quantity'] = $count;
			$arrTemp['price'] = $p;
			$arrTemp['pid'] = $pid;
			$arrCartTemp[] = $arrTemp;
		}
$arrResult['cartinfo'] = $arrCartTemp;
//print("<pre>");
//var_dump($arrResult['cartinfo']);
//print("</pre>");
//exit;
//print("</pre>");
		$arrResult['cupon_view'] = $cupon_view;
		$arrResult['pay_off'] = $payOff;
		$arrResult['reservation'] = $reservation;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_confirm()
	{
		$arrResult = array();
		$tpl = 'smarty/cart/confirm.tpl';

		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$arrResult['sale_flg'] = 0;
		$arrResult['vip_sale_flg'] = 0;
		$arrResult['sale_par'] = 0;

		if ($start_date <= $now && $end_date >= $now)
		{
			$arrResult['sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$arrResult['vip_sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['vip_sale'];
		}
//var_dump($arrResult['sale_flg']);
//var_dump($arrResult['vip_sale_flg']);
//var_dump($arrResult['sale_par']);

		// suzuki add ↓↓↓↓↓
		// カート情報のオブジェクト作成とセッション読み込み
		$cart_ctrl = new Tag_Cartctrl();
		$cart_ctrl->getSession();
		if (count($cart_ctrl->cart->getOrderDetail()) == 0) {
			return Response::redirect('/cart/');

// 			// エラー画面へ遷移する予定
// 			echo 'SESSIONが取得できませんでした';
// 			exit;
		}
		foreach($cart_ctrl->cart->getOrderDetail() as $d)
		{
			$count = $d->getQuantity();
			$stock = Tag_Item::get_product_stock($d->getProductId(), $d->getProductCode());
			if ($stock < $count)
			{
				Tag_Session::set('CART_ERROR', $d->getName().'は在庫が無くなっています。調整してください。');
				return Response::redirect('/cart/');
			}
		}

		// 入力情報のセッション追加
		if ( Input::post('payment_type') != null ) {
			$arrRet = Tag_Cartctrl::get_delivtime();
			$arrTemp = array();
			foreach($arrRet as $temp)
			{
				$arrTemp[$temp['time_id']] = $temp['deliv_time'];
			}
			if (Input::post('delivery_time') != '')
				$cart_ctrl->cart->setDelivTime($arrTemp[Input::post('delivery_time')]);
	
			$now = date('Y-m-d');
			$arrTemp = array();
			for($i = 3;$i < 10;$i++)
			{
				$arrTemp[$i-2] = date('Y-m-d', strtotime($now.' +'.$i.' day'));
			}
			if (Input::post('delivery_day') != '')
				$cart_ctrl->cart->setDelivDate($arrTemp[Input::post('delivery_day')]);
			$cart_ctrl->cart->setPaymentType( Input::post('payment_type') );
			$cart_ctrl->cart->setCouponCd( Input::post('cupon_code') );
			$cart_ctrl->cart->setPointUse( Input::post('point_use') );
			$cart_ctrl->cart->setPointUseYN( Input::post('point_use_yn') );
			$cart_ctrl->cart->setSpecification( Input::post('specification') );
			$cart_ctrl->cart->setReceiptName( Input::post('receipt_name') );
			$cart_ctrl->cart->setReceiptTadashi( Input::post('receipt_tadashi') );
			$cart_ctrl->cart->setSimplePackage( Input::post('simple_package') );
			$cart_ctrl->cart->setLapping( Input::post('lapping') );
			$cart_ctrl->cart->setMsgCard( Input::post('msg_card') );
			$cart_ctrl->cart->setMsgCardDtl( Input::post('msg_card_dtl') );
			$cart_ctrl->cart->setMsgContact( Input::post('msg_contact') );
			$cart_ctrl->cart->setAmount($cart_ctrl->cart->getTotalPricePaymentWithTax());
			$cart_ctrl->setSession();
		}

		$pay = new Tag_Paymentapi();

		// 注文情報
		$arrResult['order_id'] = $cart_ctrl->cart->getOrderId();
		$arrResult['amount'] = $cart_ctrl->cart->getAmount();
		$arrResult['point_add'] = $cart_ctrl->cart->getTotalPoint();
		$arrResult['deliv_fee'] = $cart_ctrl->cart->getDelivFee();
		$arrResult['fee'] = $cart_ctrl->cart->getFee();

		if ( $cart_ctrl->cart->getPointUse() > 0 ) {
			$arrResult['point_use_amount'] = '- ¥'.number_format($cart_ctrl->cart->getPointUse());
		}else{
			$arrResult['point_use_amount'] = '¥0';
		}
		if ( $cart_ctrl->cart->getLapping() == 1  ) {
			$arrResult['lapping_amount'] = GIFT_FEE;
		}else{
			$arrResult['lapping_amount'] = '0';
		}
		$arrResult['member_id'] = $cart_ctrl->cart->getMemberId();
		if ($cart_ctrl->cart->getOtherFlg())
		{
			$arrResult['customer_name'] = $cart_ctrl->cart->getOtherName().$cart_ctrl->cart->getOtherName2();
			$arrResult['customer_kana'] = $cart_ctrl->cart->getOtherKana().$cart_ctrl->cart->getOtherKana2();
			$arrResult['company'] = $cart_ctrl->cart->getOtherCompany();
			$arrResult['section'] = $cart_ctrl->cart->getOtherSection();
			$arrResult['zip'] = $cart_ctrl->cart->getOtherZip().'-'.$cart_ctrl->cart->getOtherZip2();
			$arrResult['address'] = Tag_CustomerInfo::get_Pref($cart_ctrl->cart->getOtherPref()).$cart_ctrl->cart->getOtherAddress().$cart_ctrl->cart->getOtherAddress2();
			$arrResult['tel_number'] = $cart_ctrl->cart->getOtherTelNumber();
		}
		else
		{
			$arrResult['customer_name'] = $cart_ctrl->cart->getCustomerName().$cart_ctrl->cart->getCustomerName2();
			$arrResult['customer_kana'] = $cart_ctrl->cart->getCustomerKana().$cart_ctrl->cart->getCustomerKana2();
			$arrResult['company'] = $cart_ctrl->cart->getCompany();
			$arrResult['section'] = $cart_ctrl->cart->getSection();
			$arrResult['zip'] = $cart_ctrl->cart->getZip().'-'.$cart_ctrl->cart->getZip2();
			$arrResult['address'] = Tag_CustomerInfo::get_Pref($cart_ctrl->cart->getPref()).$cart_ctrl->cart->getAddress().$cart_ctrl->cart->getAddress2();
			$arrResult['tel_number'] = $cart_ctrl->cart->getTelNumber();
		}

		switch( $cart_ctrl->cart->getPaymentType() ) {
			case '1':
				$arrResult['paymemt_type_str'] = 'クレジットカード決済';
				break;
			case '2':
				$arrResult['paymemt_type_str'] = '銀行振込';
				break;
			case '3':
				$arrResult['paymemt_type_str'] = 'アマゾンペイ';
				break;
			case '4':
				$arrResult['paymemt_type_str'] = '代金引換';
				break;
			case '5':
				$arrResult['paymemt_type_str'] = '楽天ペイ';
				break;
			default:
				$arrResult['paymemt_type_str'] = '';
			break;
		}
		$arrResult['payment_type'] = $cart_ctrl->cart->getPaymentType();
		$arrResult['delivery_day'] = Input::post('delivery_day');
		$arrResult['delivery_time'] = Input::post('delivery_time');
		$arrResult['specification_str'] = ( $cart_ctrl->cart->getSpecification() == "0" ) ? '同封しない' : '同封する';
		$arrResult['receipt_name'] = $cart_ctrl->cart->getReceiptName();
		$arrResult['receipt_tadashi'] = $cart_ctrl->cart->getReceiptTadashi();
		$arrResult['simple_package'] = ( $cart_ctrl->cart->getSimplePackage() == "0" ) ? '希望しない' : '希望する';
		$arrResult['lapping'] = ( $cart_ctrl->cart->getLapping() == "0" ) ? '希望しない' : '希望する';
		$arrResult['msg_card_str'] = ( $cart_ctrl->cart->getMsgCard() == "0" ) ? '希望しない' : '希望する<br>内容：';
		$arrResult['msg_card_dtl'] = $cart_ctrl->cart->getMsgCardDtl();
		$arrResult['msg_contact'] = $cart_ctrl->cart->getMsgContact();
		$arrResult['coupon_product'] = 0;
		$arrResult['coupon_price'] = 0;
		if ($cart_ctrl->cart->getCouponA() != '')
			$arrResult['coupon_price'] = $cart_ctrl->cart->getCouponA();
		else if ($cart_ctrl->cart->getCouponB() != '')
			$arrResult['coupon_price'] = $cart_ctrl->cart->getTotalPricePayment(false) - $cart_ctrl->cart->getTotalPricePayment();
		else if ($cart_ctrl->cart->getCouponC() != '')
		{
//			$arrResult['coupon_price'] = $cart_ctrl->cart->getTotalPricePayment(false) - $cart_ctrl->cart->getTotalPricePayment();
			$free_detail = Tag_Item::get_detail($cart_ctrl->cart->getCouponC());
			$arrResult['coupon_product'] = $free_detail['name'];
		}

		else if (!($arrResult['vip_sale_flg'] == 0 && $arrResult['sale_flg'] == 0))
		{
			$arrResult['arrExclude'] = array('name'=>'','shop'=>'','products'=>'');
			$arrResult['coupon_price'] = $cart_ctrl->cart->getSalePrice(true);
		}
//exit;
/*
if ($cart_ctrl->cart->getPaymentType() == "4")
{
	if ($cart_ctrl->cart->getTotalPricePaymentWithTax()+330 > 300000)
	{
		$cart_ctrl->cart->setPaymentType(0);
		$arrResult['payment_err'] = "代金引換は30万以上の場合選択できません。";
		return Response::redirect('/cart/payment');
	}
}
*/
		// GMO情報
		$gmo = $pay->gmoGetLinkTypeInfo();
		$inp = array(
			'order_id' => $cart_ctrl->cart->getOrderId(),	// オーダーID
			'amount' => $cart_ctrl->cart->getAmount(),		// 金額
			'member_id' => $cart_ctrl->cart->getMemberId(),	// 会員ID
			'template_no' => 1,				// 1:PC、2:スマホ
			'response_url' => GMO_RESPONSE_URL,
			'cancel_url' => GMO_CANCEL_URL,
			'item_name' => 'ファション洋品一式'	// 楽天ペイ用の商品名
			);
		$arrResult['gmo_entry_param'] = $pay->gmoGetMultiEntryParam( $inp, $cart_ctrl->cart->getPaymentType() );
		$arrResult['url_multi_entry'] = ( $cart_ctrl->cart->getPaymentType() == "1" || $cart_ctrl->cart->getPaymentType() == "5" ) ? $gmo['url_multi_entry'] : GMO_COMPLETE_URL;

		// AmazonPay情報
		$ama = $pay->amazonGetWidgetInfo();
		$arrResult['url_widget_js'] = $ama['url_widget_js'];
		$arrResult['url_amazonpay'] = AMA_AMAZONPAY_URL;
		$arrResult['client_id'] = $ama['client_id'];
		$arrResult['merchant_id'] = $ama['merchant_id'];

		$arrResult['btn_disp_non_amazonpay'] = ( $cart_ctrl->cart->getPaymentType() == "3" ) ? 'display:none' : '';
		$arrResult['btn_disp_amazonpay'] =  ( $cart_ctrl->cart->getPaymentType() == "3" ) ? '' : 'display:none';
Log::debug(var_export($arrResult, true));

		// suzuki add ↑↑↑↑↑
		Profiler::console($cart_ctrl->cart);

		$arrResult['arrItems'] = $cart_ctrl->cart->getOrderDetail();
		$arrResult['arrOrder'] = $cart_ctrl->cart;

		$arrCuponData = Tag_Campaign::get_check($cart_ctrl->cart->getMemberId(), Input::post('cupon_code'), $cart_ctrl->cart->getTotalPricePaymentWithTax());
//print('<pre>');
//var_dump($arrCuponData);
//var_dump(Input::post('cupon_code'));
//print('</pre>');
//exit;
		if (Input::post('cupon_code') != '' && $arrCuponData != '' && count($arrCuponData) > 0)
		{
			$arrCuponData = $arrCuponData[0];
			$not_products = explode(',', $arrCuponData['not_products']);
			$not_shops = explode(',', $arrCuponData['not_shops']);
			
			$details = $cart_ctrl->cart->getOrderDetail();
			
			$arrExclude = array();
			foreach($details as $detail)
			{
				$f = false;
				foreach($not_products as $pid)
				{
					if ($detail->getProductId() == $pid)
					{
						$f = true;
						$arrExclude['name'][] = $detail->getName();
					}
				}
				foreach($not_shops as $s)
				{
					if (Tag_Shop::get_shop_id($detail->getShop()) == $s)
					{
						$f = true;
						$arrRet = Tag_Shop::get_shopdetail("A.login_id = '".$detail->getShop()."'");
						if (count($arrRet) > 0)
						{
							$arrExclude['shop'][] = $arrRet[0]['shop_name'];
						}
					}
				}
				if (!$f)
				{
					$arrExclude['products'][] = $detail->getName();
				}
			}
			if (count($arrExclude) > 0)
			{
				if (!isset($arrExclude['name']))
					$arrExclude['name'] = '';
				if (!isset($arrExclude['shop']))
					$arrExclude['shop'] = '';
				if (!isset($arrExclude['products']))
					$arrExclude['products'] = '';
				$arrResult['arrExclude'] = $arrExclude;
			}
			
		}
		if (!isset($arrResult['arrExclude']))
		{
			$arrResult['arrExclude'] = array('name'=>'','shop'=>'','products'=>'');
		}
//		else
//		{
//			return Response::redirect('/cart/payment');
//		}
//print('<pre>');
//var_dump($arrResult);
//print('</pre>');
//exit;
		$server_name = str_replace('origin', 'www', $_SERVER['HTTP_HOST']);
		$arrResult['HTTP_ORIGIN'] = $server_name;//$_SERVER['HTTP_ORIGIN'];

		$amazonpay_config = array(
		    'public_key_id' => Config::get('paymentapi.public_key_id'),//'SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR',  // RSA Public Key ID (this 
		    'private_key'   => Config::get('paymentapi.private_key'),//'/var/www/bronline/fuel/app/config/keys/AmazonPay_SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR.pem',       
		    'sandbox'       => Config::get('paymentapi.amazon_sandbox'),                        // true (Sandbox) or false (Production) boolean
		    'region'        => Config::get('paymentapi.amazon_region')                         // Must be one of: 'us', 'eu', 'jp' 
		);

	    $client = new Amazon\Pay\API\Client($amazonpay_config);
	    $signature = $client->generateButtonSignature($this->get_payload());

		$arrResult['payload'] = $this->get_payload();
		$arrResult['signature'] = $signature;
		$arrResult['public_key_id'] = Config::get('paymentapi.public_key_id');
		$arrResult['amazon_sandbox'] = Config::get('paymentapi.amazon_sandbox');
		$arrResult['amazon_merchant_id'] = Config::get('paymentapi.amazon_merchant_id');

		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();
		if ($objCustomer->customer->getCustomerId() != 0)
		{
			$customer = Tag_CustomerInfo::get_customer($objCustomer->customer->getCustomerId());
			$arrResult['customer_email'] = $customer['email'];
			$arrResult['customer'] = $customer;
//			var_dump($customer);
		}

//print('<pre>');
//var_dump($arrResult['customer']);
//var_dump($_SERVER);
////var_dump($arrResult['arrExclude']);
////var_dump(Input::post('cupon_code'));
//print('</pre>');
//exit;
//exit;
		$cart_ctrl->setSession();
		return View_Smarty::forge( $tpl, $arrResult, false );
	}
		
	public function get_payload()
	{
		$server_name = 'https://'.str_replace('origin', 'www', $_SERVER['HTTP_HOST']);
		$server_url = $server_name . '/cart/amazon';

		$payload = '{"storeId":"'.Config::get('paymentapi.amazon_client_id').'","webCheckoutDetails":{"checkoutReviewReturnUrl":"'.$server_url.'","checkoutResultReturnUrl":"'.$server_name.'/cart/complete"},"scopes":["name","email","phoneNumber","postalCode","shippingAddress","billingAddress"]}';
		return $payload;
	}

	public function action_complete()
	{
		$arrResult = array();

		$tpl = 'smarty/cart/complete.tpl';

		// suzuki add ↓↓↓↓↓
		$error_msg = "決済が正常に完了できませんでした";
		
		$arrResult['msg1'] = 'ご購入いただきましてありがとうございました。決済が完了致しました。';
		$arrResult['msg2'] = 'ただいま、ご注文の確認メールをお送りさせていただきました。<br>万一、ご確認メールが届かない場合は、トラブルの可能性もありますので大変お手数ではございますが、お問い合わせフォーム、またはお電話にてお問い合わせくださいませ。今後ともご愛顧賜りますようよろしくお願い申し上げます。';

		$cart_ctrl = new Tag_Cartctrl();

		if (isset($_SESSION['complete']) && $_SESSION['complete'] == true)
		{
			$arrResult['msg1'] = "購入完了しています。";
			return View_Smarty::forge( $tpl, $arrResult, false );
		}

		if (count($_POST) > 0 && !isset($_POST['ErrCode']) && !isset($_POST['OrderID']))
		{
			$cart_ctrl->getSession();
 			if (count($cart_ctrl->cart->getOrderDetail()) == 0)
 			{
		 			echo 'SESSIONが取得できませんでした';
		 			exit;
 			}
 		}
 		else
		{
//			return Response::redirect('/cart/');
			if (isset($_POST['OrderID']) && $_POST['OrderID'] != '' && isset($_POST['ErrCode']) && $_POST['ErrCode'] == "")
			{
				$arrRet2 = DB::select()->from('dtb_order')->where('order_id',$_POST['OrderID'])->execute()->as_array();
				if (count($arrRet2) > 0)
				{
					$arrResult['msg1'] = "購入完了しています。";
					return View_Smarty::forge( $tpl, $arrResult, false );
				}

				$arrRet = DB::select()->from('dtb_order_temp')->where('order_id',$_POST['OrderID'])->execute()->as_array();

//print("<pre>");
////$session = Session::instance();
////var_dump(session_id('29b3455f36db689cfc595da580a4f436'));
////Session::read();
//var_dump($_POST);
//var_dump($arrRet);
//var_dump($cart_ctrl->cart->getOrderDetail());
//print("</pre>");
//exit;

				
				if (count($arrRet) > 0)
				{
					Log::info('セッションの復帰');
					$cust = htmlspecialchars_decode($arrRet[0]['customer']);
					if ($cust !== false)
						$_SESSION['customer'] = $cust;
//					$_SESSION['cart_order'] = htmlspecialchars_decode($arrRet[0]['cart_data']);
					$c = htmlspecialchars_decode($arrRet[0]['cart_data']);
					$data = preg_replace_callback('!s:(\d+):"([\s\S]*?)";!', function($m) {
					  return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
					}, $c);
					$_SESSION['cart_order'] = $data;
					$cart_ctrl->getSession();
//print("<pre>");
////$session = Session::instance();
////var_dump(session_id('29b3455f36db689cfc595da580a4f436'));
////Session::read();
//var_dump(unserialize(htmlspecialchars_decode($arrRet[0]['cart_data'])));
//var_dump($cart_ctrl->cart);
//var_dump($cart_ctrl->cart->getOrderDetail());
//print("</pre>");
//exit;
				}
				else
				{
		 			echo 'SESSIONが取得できませんでした';
		 			exit;
				}
			}
			else
			{
				Log::info('セッションの復帰　クレジット以外');
				$cart_ctrl->getSession();
			}


 			// エラー画面へ遷移する予定
// 			echo 'SESSIONが取得できませんでした';
// 			exit;
		}

// 		foreach($cart_ctrl->cart->getOrderDetail() as $d)
// 		{
// 			$count = $d->getQuantity();
// 			$stock = Tag_Item::get_product_stock($d->getProductId(), $d->getProductCode());
// 			if ($stock < $count)
// 			{
// 				Tag_Session::set('CART_ERROR', $d->getName.'は在庫が無くなっています。調整してください。');
// 				return Response::redirect('/cart/');
// 			}
// 		}

		$pay = new Tag_Paymentapi();
		////////////////////////////////////
		//AmazonPay決済を行う
		////////////////////////////////////
		// OrderReferenceIdが、nullでもなく''でもない場合
		$send = false;

		$session_id = '';
		if (isset($_GET['amazonCheckoutSessionId']))
			$session_id = $_GET['amazonCheckoutSessionId'];

//		if ( !empty( Input::post('orderReferenceId') ) ) {
		if ( !empty( $session_id ) )
		{
			$amazonpay_config = array(
			    'public_key_id' => Config::get('paymentapi.public_key_id'),//'SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR',  // RSA Public Key ID (this 
			    'private_key'   => Config::get('paymentapi.private_key'),//'/var/www/bronline/fuel/app/config/keys/AmazonPay_SANDBOX-AFQJAJ7X3EDY3X5RD24UUYAR.pem',       
			    'sandbox'       => Config::get('paymentapi.amazon_sandbox'),                        // true (Sandbox) or false (Production) boolean
			    'region'        => Config::get('paymentapi.amazon_region')                         // Must be one of: 'us', 'eu', 'jp' 
			);
		    $payload = array(
		        'chargeAmount' => array(
		            'amount' => $cart_ctrl->cart->getAmount(),
		            'currencyCode' => "JPY"
		            ),
		        'totalOrderAmount' => array(
		            'amount' => $cart_ctrl->cart->getAmount(),
		            'currencyCode' => "JPY"
		            )
		    );
	        $client = new Amazon\Pay\API\Client($amazonpay_config);

	        $result = $client->completeCheckoutSession($session_id, $payload);
	        $json_result = json_decode($result['response']);
//print("<pre>");
//var_dump($json_result);
//print("</pre>");
//exit;
	        $state = $json_result->statusDetails->state;

			if ($state == 'Completed')
			{
				Tag_Order::set_order($json_result);
				$send = true;
			}
			else	//エラー時の処理
			{
				$arrResult['msg1'] = $json_result->statusDetails->reasonCode;
				$arrResult['msg2'] = $json_result->statusDetails->reasonDescription;
			}
//Log::debug(Input::post('orderReferenceId'));
			// 認証で取得したorderReferenceIdとaccessTokenを使用して決済処理を行う
/*
			$inp = array(
							'order_reference_id' => Input::post('orderReferenceId'),
							'access_token' => Input::post('accessToken'),
							'order_id' => $cart_ctrl->cart->getOrderId(),
							'amount' => $cart_ctrl->cart->getAmount() );
			// 仮売上（与信枠確保）処理を呼び出す
			$res = $pay->amazonAuthorize( $inp );
			$inp['amazon_authorization_id'] = $res['amazon_authorization_id'];
			$res = $pay->amazonCapture( $inp );
			// エラーが返却された場合はエラーメッセージを表示させる
			if ( $res['error'] == true ) {
				$arrResult['msg1'] = $error_msg;
				$arrResult['msg2'] = $res['error_id'].'('.$res['error_msg'].')';
			} else {
				Tag_Order::set_order($res);
				$send = true;
				//$arrResult['uthorizationId'] = $res['amazon_authorization_id'];
			}
*/
		////////////////////////////////////
		// クレジットカード決済結果を取得する
		////////////////////////////////////
		} else if ($cart_ctrl->cart->getPaymentType() == '1' || $cart_ctrl->cart->getPaymentType() == '5') {
			// リンクタイプの戻り値チェック
//var_dump($cart_ctrl->cart->getPaymentType());
//print("<br>");
//var_dump(Input::post('PayType'));
//print("<br>");

			if( Input::post('PayType') != null ) {
				$res = $pay->gmoResponseCheck( Input::post() );
//var_dump($res);
				// エラーが返却された場合はエラーメッセージを表示させる
				if ($res['error'] == true) {
					$arrResult['msg1'] = $error_msg;
					$arrResult['msg2'] = $res['error_id'].'('.$res['error_msg'].')';
				}
				else
				{
					Tag_Order::set_order($res);
					$send = true;
				}
			}
//exit;
		} 
		else if ($cart_ctrl->cart->getPaymentType() == '2' || $cart_ctrl->cart->getPaymentType() == '4')
		{
			Tag_Order::set_order();
			$send = true;
		}

		if ($send)
		{		
			Tag_Mail::order_mail($cart_ctrl->cart->getMemberId(), $cart_ctrl->cart, $cart_ctrl->cart->getOrderId());
			usleep(300000);
						
			Tag_Mail::order_mail_crossmall($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), 'guji'); 
			usleep(300000);
			Tag_Mail::order_mail_crossmall($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), 'ring'); 
			usleep(300000);
			Tag_Mail::order_mail_nextmail($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), 'sugawaraltd'); 
			usleep(300000);
			Tag_Mail::order_mail_crossmall($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), 'altoediritto'); 
			usleep(300000);
			Tag_Mail::order_mail_crossmall($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), 'biglietta'); 
			usleep(300000);

	        $arrShops = Tag_Cartctrl::get_allshop();
	        foreach($arrShops as $s)
	        {
				Tag_Mail::order_mail_shopmail($cart_ctrl->cart, $cart_ctrl->cart->getOrderId(), $s['shop_id']); 
				usleep(300000);

				if ($s['stock_type'] == SMAREGI)
					Tag_Smaregi::shop_tran($s['shop_id'], $cart_ctrl);
			}
			
		}
		$arrTemp = Tag_Master::get_master('mtb_payment');
		$arrPayments = array();
		foreach($arrTemp as $t)
		{
			$arrPayments[$t['id']] = $t['name'];
		}

		if (isset($_POST['ErrCode']) && $_POST['ErrCode'] == "")
		{
			if ($cart_ctrl->cart->getPaymentType() == 2 || $cart_ctrl->cart->getPaymentType() == 4)
				$arrResult['msg1'] = 'ご購入いただきましてありがとうございました。';
			else
				$arrResult['msg1'] = 'ご購入いただきましてありがとうございました。決済が完了致しました。';
			$arrResult['msg1'] .= "<br><br><span>ご購入金額：".number_format($cart_ctrl->cart->getTotalPricePaymentWithTax())."円</span>";
			$arrResult['msg1'] .= "<br><span>お支払い方法：".$arrPayments[$cart_ctrl->cart->getPaymentType()]."</span>";
		}
		else if (!isset($_POST['ErrCode']))
		{
			if ($cart_ctrl->cart->getPaymentType() == 2 || $cart_ctrl->cart->getPaymentType() == 4)
				$arrResult['msg1'] = 'ご購入いただきましてありがとうございました。';
			else
				$arrResult['msg1'] = 'ご購入いただきましてありがとうございました。決済が完了致しました。';
			$arrResult['msg1'] .= "<br><br><span>ご購入金額：".number_format($cart_ctrl->cart->getTotalPricePaymentWithTax())."円</span>";
			$arrResult['msg1'] .= "<br><span>お支払い方法：".$arrPayments[$cart_ctrl->cart->getPaymentType()]."</span>";
		}
		else
		{
			$arrResult['msg1'] = "決済を取り消ししました。";
			$arrResult['msg1'] .= "<br>".$_POST['ErrInfo'];
		}
		
//		var_dump($cart_ctrl->cart->getPaymentType());
		$cart_ctrl->clearSession();
		// suzuki add ↑↑↑↑↑
		$_SESSION['complete'] = true;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_amazon()
	{
		$arrResult = array();

		$tpl = 'smarty/cart/amazon.tpl';

		// suzuki add ↓↓↓↓↓
		$cart_ctrl = new Tag_Cartctrl();
		$cart_ctrl->getSession();
		if (count($cart_ctrl->cart->getOrderDetail()) == 0) {
			return Response::redirect('/cart/');
			// エラー画面へ遷移する予定
// 			echo 'SESSIONが取得できませんでした';
// 			exit;
		}

		$pay = new Tag_Paymentapi();
		$ama = $pay->amazonGetWidgetInfo();

		$arrResult['url_widget_js'] = $ama['url_widget_js'];
		$arrResult['url_signin_cancel'] = AMAZONPAY_SIGNIN_CANCEL_URL;
		$arrResult['client_id'] = $ama['client_id'];
		$arrResult['merchant_id'] = $ama['merchant_id'];
		// セッションから取得
		$arrResult['order_id'] = $cart_ctrl->cart->getOrderId();
		$arrResult['amount'] = $cart_ctrl->cart->getAmount();
		// suzuki add ↑↑↑↑↑

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

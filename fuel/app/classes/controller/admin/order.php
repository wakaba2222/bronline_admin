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
include (__DIR__.'/../../tag/cartctrl.php');

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Admin_Order extends ControllerAdmin
{
	public function action_index()
	{
		$this->init_param();
		$post = Input::param();
//		var_dump($post);
		if (!isset($post['search_send_status']))
			$post['search_send_status'] = 1;

		$page = Input::param('page','1');
		$shop_id = Tag_Session::get('shop_id');
		$shop = Tag_Session::getShop();

		if (Input::method() == 'GET')
		{
			if (Input::param('page','') == '')
			{
				Tag_Session::set('ORDER_SELECT', $post);
			}
			else
			{
				$post = Tag_Session::get('ORDER_SELECT');
			}

			if (!isset($post['search_sorderyear']))
			{
				$post['search_sorderyear'] = date('Y', strtotime('-6 months'));
				$post['search_sordermonth'] = date('n', strtotime('-6 months'));
				$post['search_sorderday'] = date('j', strtotime('-6 months'));
			}
		}
		else
		{
			if (Input::param('mode') == 'csv' || Input::param('mode') == 'csv2' || Input::param('mode') == 'csvx')
			{
				$post = Tag_Session::get('ORDER_SELECT');
			}
			else if (Input::param('page','') == '')
			{
				Tag_Session::set('ORDER_SELECT', $post);
			}
		}
		
//var_dump(Input::method());
//var_dump($post);
// var_dump(Tag_Session::get('ORDER_SELECT'));
//exit;
		$this->arrResult['csvx'] = '';
		$where = " A.del_flg = 0 ";

		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_order_date':
				{
					if (isset($post['search_order_date']) && $post['search_order_date'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.create_date >= '".$post['search_order_date']."'";
						$this->setFormParams('arrForm', 'search_order_date', $post['search_order_date'], '10');
						$this->setFormParams('arrForm', 'search_sorderyear', $post['search_sorderyear'], '10');
						$this->setFormParams('arrForm', 'search_sordermonth', $post['search_sordermonth'], '10');
						$this->setFormParams('arrForm', 'search_sorderday', $post['search_sorderday'], '10');
					}
					break;
				}
				case 'search_sorderyear':
				{
					if (!isset($post['search_order_date']) || $post['search_order_date'] == '')
					{
						if (isset($post['search_sorderyear']) && $post['search_sorderyear'] != '')
						{
							if (!preg_match("/^[0-9]+$/", $post['search_sorderyear']))
							{
								break;
							}
							if (!preg_match("/^[0-9]+$/", $post['search_sordermonth']))
							{
								break;
							}
							if (!preg_match("/^[0-9]+$/", $post['search_sorderday']))
							{
								break;
							}
							if ($where != "")
								$where .= " AND ";
							$where .= " A.create_date >= '".$post['search_sorderyear'].'-'.$post['search_sordermonth'].'-'.$post['search_sorderday']." 00:00:00' ";
							$this->setFormParams('arrForm', 'search_sorderyear', $post['search_sorderyear'], '10');
							$this->setFormParams('arrForm', 'search_sordermonth', $post['search_sordermonth'], '10');
							$this->setFormParams('arrForm', 'search_sorderday', $post['search_sorderday'], '10');
						}
					}
					break;
				}
				case 'search_eorderyear':
				{
					if ($post['search_eorderyear'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_eorderyear']))
						{
							break;
						}
						if (!preg_match("/^[0-9]+$/", $post['search_eordermonth']))
						{
							break;
						}
						if (!preg_match("/^[0-9]+$/", $post['search_eorderday']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.create_date <= '".$post['search_eorderyear'].'-'.$post['search_eordermonth'].'-'.$post['search_eorderday']." 23:59:59' ";
						$this->setFormParams('arrForm', 'search_eorderyear', $post['search_eorderyear'], '10');
						$this->setFormParams('arrForm', 'search_eordermonth', $post['search_eordermonth'], '10');
						$this->setFormParams('arrForm', 'search_eorderday', $post['search_eorderday'], '10');
					}
					break;
				}
				case 'search_send_status':
				{
					if (isset($post['search_send_status']) && $post['search_send_status'] == 1)
					{
						if ($where != '')
							$where .= " AND ";
						$where .= " A.status <> 5 ";
					}
					$this->setFormParams('arrForm', 'search_send_status', $post['search_send_status'], '');
					break;
				}
				case 'search_order_id1':
				{
					if ($post['search_order_id1'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_order_id1']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.order_id >= ".$post['search_order_id1'];
						$this->setFormParams('arrForm', 'search_order_id1', $post['search_order_id1'], '10');
					}
					break;
				}
				case 'search_order_id2':
				{
					if ($post['search_order_id2'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_order_id2']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.order_id <= ".$post['search_order_id2'];
						$this->setFormParams('arrForm', 'search_order_id2', $post['search_order_id2'], '10');
					}
					break;
				}
				case 'search_total1':
				{
					if ($post['search_total1'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_total1']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.payment_total >= ".$post['search_total1'];
						$this->setFormParams('arrForm', 'search_total1', $post['search_total1'], '10');
					}
					break;
				}
				case 'search_total2':
				{
					if ($post['search_total2'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_total2']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.payment_total <= ".$post['search_total2'];
						$this->setFormParams('arrForm', 'search_total2', $post['search_total2'], '10');
					}
					break;
				}
				case 'search_order_email':
				{
					if ($post['search_order_email'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$where .= " (B.email like '%".$post['search_order_email']."%') ";
//						$where .= " OR B.name02 like '%".$post['search_order_email']."%')";
						$this->setFormParams('arrForm', 'search_order_email', $post['search_order_email'], '100');
					}
					break;
				}
				case 'search_order_name':
				{
					if ($post['search_order_name'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$order_name = str_replace(' ', '', $post['search_order_name']);
						$order_name = str_replace('　', '', $order_name);
						$where .= " A.customer_id in (select customer_id from dtb_customer where concat(name01,name02) like '%".$order_name."%') ";
//						$where .= " (B.name01 like '%".$post['search_order_name']."%'";
//						$where .= " OR B.name02 like '%".$post['search_order_name']."%')";
						$this->setFormParams('arrForm', 'search_order_name', $post['search_order_name'], '10');
					}
					break;
				}
				case 'search_shipping_name':
				{
					if ($post['search_shipping_name'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$order_name = str_replace(' ', '', $post['search_shipping_name']);
						$order_name = str_replace('　', '', $order_name);
						$where .= " A.order_id in (select order_id from dtb_order_deliv where concat(name01,name02) like '%".$order_name."%') ";
//						$where .= " (B.name01 like '%".$post['search_order_name']."%'";
//						$where .= " OR B.name02 like '%".$post['search_order_name']."%')";
						$this->setFormParams('arrForm', 'search_shipping_name', $post['search_shipping_name'], '10');
					}
					break;
				}
				case 'search_order_kana':
				{
					if ($post['search_order_kana'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$order_name = str_replace(' ', '', $post['search_order_kana']);
						$order_name = str_replace('　', '', $order_name);
						$where .= " A.customer_id in (select customer_id from dtb_customer where concat(kana01,kana02) like '%".$order_name."%') ";
//						$where .= " (B.kana01 like '%".$post['search_order_kana']."%'";
//						$where .= " OR B.kana02 like '%".$post['search_order_kana']."%')";
						$this->setFormParams('arrForm', 'search_order_kana', $post['search_order_kana'], '10');
					}
					break;
				}
				case 'search_shipping_kana':
				{
					if ($post['search_shipping_kana'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$order_name = str_replace(' ', '', $post['search_shipping_kana']);
						$order_name = str_replace('　', '', $order_name);
						$where .= " A.order_id in (select order_id from dtb_order_deliv where concat(kana01,kana02) like '%".$order_name."%') ";
//						$where .= " (B.kana01 like '%".$post['search_order_kana']."%'";
//						$where .= " OR B.kana02 like '%".$post['search_order_kana']."%')";
						$this->setFormParams('arrForm', 'search_shipping_kana', $post['search_shipping_kana'], '10');
					}
					break;
				}
				case 'search_order_tel':
				{
					if ($post['search_order_tel'] != '')
					{
//						if (!preg_match("/^[0-9]+$/", $post['search_order_name']))
//						{
//							break;
//						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.customer_id in (select customer_id from dtb_customer where tel01 like '%".$post['search_order_tel']."%') ";
//						$where .= " (B.tel01 = '".$post['search_order_tel']."')";
//						$where .= " OR B.tel02 like '%".$post['search_order_tel']."%')";
						$this->setFormParams('arrForm', 'search_order_tel', $post['search_order_tel'], '15');
					}
					break;
				}
				case 'search_order_status':
				{
					if ($post['search_order_status'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_order_status']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.status = '".$post['search_order_status']."' ";
						$this->setFormParams('arrForm', 'search_order_status', $post['search_order_status'], '20');
					}
					break;
				}
				case 'search_product_statuses':
				{
					if (count($post['search_product_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_product_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_product_statuses', $post['search_product_statuses'], '');
					break;
				}
				case 'search_name':
				{
					if ($post['search_name'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.name like '%".$post['search_name']."%' ";
						$this->setFormParams('arrForm', 'search_name', $post['search_name'], '50');
					}
					break;
				}
				case 'search_group_code':
				{
					if ($post['search_group_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '".$post['search_group_code']."%' ";
						$this->setFormParams('arrForm', 'search_group_code', $post['search_group_code'], '15');
					}
					break;
				}
				case 'search_category_id':
				{
					if ($post['search_category_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_category_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " G.category_id = '".$post['search_category_id']."' ";
						$this->setFormParams('arrForm', 'search_category_id', $post['search_category_id'], '');
					}
					break;
				}
				case 'search_smaregi_product_id':
				{
					if ($where != "")
						$where .= " AND ";
					$where .= " A.product_id = ".$post['search_smaregi_product_id'];
					$this->setFormParams('arrForm', 'search_smaregi_product_id', $post['search_smaregi_product_id'], '10');
					break;
				}
				case 'search_stock':
				{
					if ($post['search_stock'] != 0)
					{
						if ($post['search_stock'] == '1')
							$where .= " D.stock <> 0 ";
						else
							$where .= " D.stock = 0 ";

						$this->setFormParams('arrForm', 'search_stock', $post['search_stock'], '');
						break;
					}
				}
				case 'search_product_name':
				{
					if (isset($post['search_product_name']) && $post['search_product_name'] != '')
					{
						if ($where != '')
							$where .= " AND ";
						$where .= " A.order_id in (select order_id from dtb_order_detail where product_name like '%".$post['search_product_name']."%') ";
					}
					$this->setFormParams('arrForm', 'search_product_name', $post['search_product_name'], '');
					break;
				}
				case 'search_payment_id':
				{
					if (count($post['search_payment_id']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_payment_id'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.payment_id = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_payment_id', $post['search_payment_id'], '');
					break;
				}
			}
		}

		if( $shop_id != ''  && $shop_id != 1) {
			if ($where != "")
				$where .= " AND ";

			$where .= " EXISTS ( ";
			$where .= "		SELECT * FROM dtb_order_detail AS OD ";
			$where .= "		JOIN dtb_shop AS ODS ON OD.shop_id = ODS.login_id ";
			$where .= "		WHERE OD.order_id = A.order_id AND ODS.id = ".$shop_id;
			$where .= "	) ";
		}


		if ($where != '')
			$where = ' AND '.$where;

		$arrRet = Tag_Order::get_order_all2($page, $where, 0);
		$count = count($arrRet);
		$this->arrResult['max'] = ceil($count / 200);
		$this->arrResult['count'] = $count;
		$this->arrResult['page'] = $page;

		$arrCSVX = Tag_Order::get_order_all2($page, $where." and A.status <> 3 and A.status <> 12 and A.status <> 13 and A.status <> 14 ", 0);

			$pc = 5;
			if ($page - $pc <= 0)
				$this->arrResult['pstart'] = 1;
			else
				$this->arrResult['pstart'] = $page - $pc;
			if ($page + $pc > $this->arrResult['max'])
				$this->arrResult['pend'] = $this->arrResult['max'];
			else
				$this->arrResult['pend'] = $page + $pc;

		$arrTemp = Tag_Order::get_order_all2($page, $where, 200);
//add by waka
		$arrTemp2 = array();
		foreach($arrTemp as $temp)
		{
			$customer = array();
			if ($temp['customer_id'] != '0')
			{
				$customer = Tag_CustomerInfo::get_customer($temp['customer_id']);
				$temp['name01'] = $customer['name01'];
				$temp['name02'] = $customer['name02'];
				$temp['kana01'] = $customer['kana01'];
				$temp['kana02'] = $customer['kana02'];
			}
			$arrTemp3 = Tag_Order::get_order_detail($temp['order_id']);
			$temp['reservation_flg'] = 0;
			foreach($arrTemp3 as $ttt)
			{
				if ($ttt['reservation_flg'] >= 1)
				{
					$temp['reservation_flg'] = $ttt['reservation_flg'];
					break;
				}
			}
			$arrTemp2[] = $temp;
		}

		$this->arrResult['arrResults'] = $arrTemp2;

		$arrShopResult = array();
		foreach($arrTemp2 as $r)
		{
			$arrDetail = Tag_Order::get_order_detail($r['order_id']);
			foreach($arrDetail as $detail)
			{
				if ($detail['shop_id'] == $shop)
				{
					if (!isset($arrShopResult[$r['order_id']]))
						$arrShopResult[$r['order_id']] = 0;
					$arrShopResult[$r['order_id']] += round(intval($detail['price']) * intval($detail['quantity']) * ((100 + TAX_RATE) / 100));
				}
			}
		}
		$this->arrResult['arrShopResult'] = $arrShopResult;
		$this->arrResult['shop'] = $shop;

		//$this->arrResult['arrForm'] = $post;
		$this->arrResult['arrPageMax'] = "";
		$this->arrResult['arrHidden'] = "";
//var_dump($arrTemp2);
//var_dump($this->arrResult['arrForm']['search_send_status']);
		if (Input::param('mode') == 'csv2')
		{
			$arrTemp2 = Tag_Order::get_order_all2($page, $where, 0);
//			$keys = array('注文日時','注文番号','対応状況','会員ID','お名前(姓)','お名前(名)','メールアドレス','都道府県','住所1','加算ポイント','使用ポイント','お支払い合計','支払い方法','合計');
			$keys = array('注文日時','注文番号','対応状況','会員ID','お名前(姓)','お名前(名)','メールアドレス','都道府県','住所1','加算ポイント','使用ポイント','クーポンコード','値引き','お支払い合計','支払い方法','合計');
			$cols = array();
			foreach ($keys as $v)
			{
				$cols[] = $v;
			}
			$csv_data = array();
			array_push($csv_data, $cols);

//var_dump(Tag_Session::get('ORDER_SELECT'));
//var_dump($_POST);exit;

			foreach($arrTemp2 as $temp)
			{
				$customer = array();
				if ($temp['customer_id'] != '0')
					$customer = Tag_CustomerInfo::get_customer($temp['customer_id']);
				$data = array();
				$data[] = $temp['create_date'];
				$data[] = $temp['order_id'];
				$data[] = $temp['status'];
				$data[] = $temp['customer_id'];
				$data[] = $temp['name01'];
				$data[] = $temp['name02'];
				if (count($customer) > 0)
					$data[] = $customer['email'];
				else
					$data[] = $temp['email'];
				if ($temp['pref'] != '0')
					$data[] = $this->arrResult['arrPref'][$temp['pref']];
				else
					$data[] = '';
				$data[] = $temp['addr01'];
				$data[] = $temp['add_point'];
				$data[] = $temp['use_point'];
				$data[] = $temp['coupon'];
				$data[] = $temp['discount'];
				$data[] = $temp['payment_total'];//-$temp['use_point'];
				$data[] = $this->arrResult['arrPayments'][$temp['payment_id']];
				$data[] = $temp['payment_total'];
				array_push($csv_data, $data);
			}

			$this->response = new Response();
			$this->response->set_header('Content-Type', 'application/csv');
			$this->response->set_header('Content-Disposition', 'attachment; filename="'.$shop.'_order_'.date('Ymd').'.csv"');
			echo Format::forge($csv_data)->to_csv();
			$this->response->send(true);
			return exit();
		}
		else if (Input::param('mode') == 'csv3')
		{
			$where .= " AND A.status <> 3 ";
			$arrTemp2 = Tag_Order::get_order_all3($page, $where, 0);
			$keys = array(
				'お客様管理番号',
				'送り状種別',
				'クール区分',
				'伝票番号', 
				'出荷予定日', 
				'お届け予定日', 
				'配達時間帯', 
				'お届け先コード', 
				'お届け先電話番号', 
				'お届け先電話番号枝番', 
				'お届け先郵便番号', 
				'お届け先住所', 
				'お届け先アパートマンション',
				'お届け先会社・部門１', 
				'お届け先会社・部門２', 
				'お届け先名','お届け先名（カナ）',
				'敬称',
				'ご依頼主コード',
				'ご依頼主電話番号',
				'ご依頼主電話番号枝番',
				'ご依頼主郵便番号',
				'ご依頼主住所',
				'ご依頼主アパートマンション',
				'ご依頼主名',
				'ご依頼主名（カナ）',
				'品名コード１',
				'品名１',
				'品名コード２',
				'品名２',
				'荷扱い１',
				'荷扱い２',
				'記事',
				'コレクト代金引換額(税込)',
				'内消費税額等',
				'止置き',
				'営業所コード',
				'発行枚数',
				'個数口表示フラグ',
				'請求先顧客コード',
				'請求先分類コード',
				'運賃管理番号',
				'クロネコwebコレクトデータ登録',
				'クロネコwebコレクト加盟店番号',
				'クロネコwebコレクト申込受付番号１',
				'クロネコwebコレクト申込受付番号２',
				'クロネコwebコレクト申込受付番号３',
				'お届け予定ｅメール利用区分',
				'お届け予定ｅメールe-mailアドレス',
				'入力機種',
				'お届け予定ｅメールメッセージ',
				'お届け完了ｅメール利用区分',
				'お届け完了ｅメールe-mailアドレス',
				'お届け完了ｅメールメッセージ',
				'クロネコ収納代行利用区分',
				'予備',
				'収納代行請求金額(税込)',
				'収納代行内消費税額等',
				'収納代行請求先郵便番号',
				'収納代行請求先住所',
				'収納代行請求先住所（アパートマンション名）',
				'収納代行請求先会社・部門名１',
				'収納代行請求先会社・部門名２',
				'収納代行請求先名(漢字)',
				'収納代行請求先名(カナ)',
				'収納代行問合せ先名(漢字)',
				'収納代行問合せ先郵便番号',
				'収納代行問合せ先住所',
				'収納代行問合せ先住所（アパートマンション名）',
				'収納代行問合せ先電話番号',
				'収納代行管理番号',
				'収納代行品名',
				'収納代行備考',
				'複数口くくりキー',
				'検索キータイトル1',
				'検索キー1',
				'検索キータイトル2',
				'検索キー2',
				'検索キータイトル3',
				'検索キー3',
				'検索キータイトル4',
				'検索キー4',
				'検索キータイトル5',
				'検索キー5',
				'予備',
				'予備',
				'投函予定メール利用区分',
				'投函予定メールe-mailアドレス',
				'投函予定メールメッセージ',
				'投函完了メール（お届け先宛）利用区分',
				'投函完了メール（お届け先宛）e-mailアドレス',
				'投函完了メール（お届け先宛）メールメッセージ',
				'投函完了メール（ご依頼主宛）利用区分',
				'投函完了メール（ご依頼主宛）e-mailアドレス',
				'投函完了メール（ご依頼主宛）メールメッセージ',
			);
			$cols = array();
			foreach ($keys as $v)
			{
				$cols[] = $v;
			}
			$csv_data = array();
			array_push($csv_data, $cols);

//var_dump(Tag_Session::get('ORDER_SELECT'));
//var_dump($_POST);exit;

			foreach($arrTemp2 as $temp)
			{
				
				array_push($csv_data, $temp);
			}

			$this->response = new Response();
			$this->response->set_header('Content-Type', 'application/csv');
			$this->response->set_header('Content-Disposition', 'attachment; filename="'.$shop.'_order_'.date('Ymd').'.csv"');
			echo Format::forge($csv_data)->to_csv();
			$this->response->send(true);
			return exit();
		}
		else if (Input::param('mode') == 'csv')
		{
			if ($shop == 'brshop')
			{
				$keys = array('注文日時','注文番号','対応状況','会員ID','お名前(姓)','お名前(名)','メールアドレス','都道府県','住所1','加算ポイント','使用ポイント','お支払い合計','値引き','支払い方法','合計','個別金額','商品名','商品コード','規格1','規格2','商品ID','購入数','セールフラグ','店舗名');
				$cols = array();
				foreach ($keys as $v)
				{
					$cols[] = $v;
				}
				$csv_data = array();
				array_push($csv_data, $cols);

				$arrTemp2 = Tag_Order::get_order_all2($page, $where, 0);
				foreach($arrTemp2 as $temp)
				{
					$customer = array();
					if ($temp['customer_id'] != '0')
						$customer = Tag_CustomerInfo::get_customer($temp['customer_id']);
					$data = array();
					$data[] = $temp['create_date'];
					$data[] = $temp['order_id'];
					$data[] = $temp['status'];
					$data[] = $temp['customer_id'];
					$data[] = $temp['name01'];
					$data[] = $temp['name02'];
					if (count($customer) > 0)
						$data[] = $customer['email'];
					else
						$data[] = $temp['customer_email'];
					if ($temp['pref'] != '0')
						$data[] = $this->arrResult['arrPref'][$temp['pref']];
					else
						$data[] = '';
					$data[] = $temp['addr01'];
					$data[] = $temp['add_point'];
					$data[] = $temp['use_point'];
					$data[] = $temp['payment_total'];//-$temp['use_point'];
					$data[] = $temp['discount'];//-$temp['use_point'];
					$data[] = $this->arrResult['arrPayments'][$temp['payment_id']];
					$data[] = $temp['payment_total'];

					$arrTemp3 = Tag_Order::get_order_detail($temp['order_id']);
//					'個別金額','商品名','商品コード','購入数'
					foreach($arrTemp3 as $detail)
					{
						$data_all = array();
						$data_all = $data;
						$data_all[] = $detail['price'];
						$data_all[] = $detail['product_name'];
						$data_all[] = $detail['product_code'];
						$data_all[] = $detail['size_name'];
						$data_all[] = $detail['color_name'];
						$data_all[] = $detail['product_id'];
						$data_all[] = $detail['quantity'];
						$data_all[] = $detail['sale_status'];
						$data_all[] = $detail['shop_id'];
						array_push($csv_data, $data_all);
					}
				}
			}
			else
			{
				$keys = array('注文日時','注文番号','支払い方法','個別金額','商品名','商品コード','規格1','規格2','商品ID','購入数','値引き','セールフラグ','店舗名');
				$cols = array();
				foreach ($keys as $v)
				{
					$cols[] = $v;
				}
				$csv_data = array();
				array_push($csv_data, $cols);

				$arrTemp2 = Tag_Order::get_order_all2($page, $where, 0);
				foreach($arrTemp2 as $temp)
				{
					$data = array();
					$data[] = $temp['create_date'];
					$data[] = $temp['order_id'];
//					$data[] = $temp['customer_id'];
					$data[] = $this->arrResult['arrPayments'][$temp['payment_id']];

					$arrTemp3 = Tag_Order::get_order_detail($temp['order_id'], $shop_id);
					foreach($arrTemp3 as $detail)
					{
						$data_all = array();
						$data_all = $data;
						$data_all[] = $detail['price'];
						$data_all[] = $detail['product_name'];
						$data_all[] = $detail['product_code'];
						$data_all[] = $detail['size_name'];
						$data_all[] = $detail['color_name'];
						$data_all[] = $detail['product_id'];
						$data_all[] = $detail['quantity'];
						$data_all[] = $temp['discount'];
						$data_all[] = $detail['sale_status'];
						$data_all[] = $detail['shop_id'];
						array_push($csv_data, $data_all);
					}
				}
			}

			$this->response = new Response();
			$this->response->set_header('Content-Type', 'application/csv');
			$this->response->set_header('Content-Disposition', 'attachment; filename="'.$shop.'_order_'.date('Ymd').'.csv"');
			echo Format::forge($csv_data)->to_csv();
			$this->response->send(true);
			return exit();
		}
//		else if (Input::param('mode') == 'csvx')
//		{
//			$this->arrResult['csvx'] = 'csvx';
//			$csvx = array();
//			foreach($arrCSVX as $c)
//			{
//				$csvx[] = $c['order_id'];
//			}
//			$this->arrResult['ret_csvx'] = $csvx;
//		}
		$this->arrResult['csvx'] = 'csvx';
		$csvx = array();
		foreach($arrCSVX as $c)
		{
			$csvx[] = $c['order_id'];
		}
		$this->arrResult['ret_csvx'] = $csvx;

		$this->tpl = 'smarty/admin/order/index.tpl';
		return $this->view;
	}

	private function update_data($arrForm)
	{
// 		print("<pre>");
// 		var_dump($arrForm);
// 		print("</pre>");
// 		exit;

		$update = DB::update('dtb_order');
		$arrOrder = array();
		$arrOrder['status'] = $arrForm['status'];
		$arrOrder['send_number'] = $arrForm['send_number'];
		$arrOrder['update_date'] = date('Y-m-d H:i:s');
		$arrOrder['deliv_time'] = $arrForm['deliv_time'];
		$arrOrder['deliv_date'] = $arrForm['deliv_date'];

		$arrOrder['recepit_atena'] = $arrForm['recepit_atena'];
		$arrOrder['detail_statement'] = $arrForm['detail_statement'];
		$arrOrder['receipt_tadashi'] = $arrForm['receipt_tadashi'];
		$arrOrder['packing'] = $arrForm['packing'];

		if ($arrForm['status'] == 6)
		{
//			$arrOrder['commit_date'] = date('Y-m-d H:i:s');
		}
		else if ($arrForm['status'] == 5)
		{
//add waka by 2024.10.28
			$arrOrder['send_date'] = date('Y-m-d H:i:s');
			if (isset($arrForm['customer_id']) && $arrForm['customer_id'] != 0)
			{
				$order = Tag_Order::get_order_info($arrForm['order_id']);

	        	$sql = "update dtb_customer set last_buy_date = '{$order[0]['create_date']}' where customer_id = '{$order[0]['customer_id']}'";
		        $query = DB::query($sql);
		        $query->execute();
			}
		}
		else if ($arrForm['status'] == 9 || $arrForm['status'] == 17)
		{
			if (isset($arrForm['customer_id']) && $arrForm['customer_id'] != 0)
			{
				$order = Tag_Order::get_order_info($arrForm['order_id']);

	        	$sql = "update dtb_customer set last_buy_date = '{$order[0]['create_date']}' where customer_id = '{$order[0]['customer_id']}'";
		        $query = DB::query($sql);
		        $query->execute();
			}
		}
		else if ($arrForm['status'] == 3)
		{
			$authority = Tag_Session::get('authority');
			if ($authority == 0)
				$shop = 'brshop';

			if (isset($arrForm['customer_id']) && $arrForm['customer_id'] != 0)
			{
				$arrDate = array();
				$sql = "select create_date from dtb_order where order_id <> {$arrForm['order_id']} and customer_id = {$arrForm['customer_id']} and (status = 5 or status = 9 or status = 17) order by create_date desc limit 1";
		        $query = DB::query($sql);
		        $arrDate = $query->execute()->as_array();
		        
		        if (count($arrDate) > 0)
		        {
		        	$sql = "update dtb_customer set last_buy_date = '{$arrDate[0]['create_date']}' where customer_id = '{$arrForm['customer_id']}'";
			        $query = DB::query($sql);
			        $query->execute();
		        }
			}		        

			$sql = "select * from dtb_smaregi_order where order_id = {$arrForm['order_id']} and shop_url = '{$shop}'";
			$arrRet = DB::query($sql)->execute()->as_array();
			$id = 0;
			if (count($arrRet) > 0)
			{
				$smaregi = $arrRet[0];
				$id = $smaregi['id'];
				unset($smaregi['id']);
			}

			if ($id != 0)
			{
				$smaregi_order = Tag_Order::get_order_info($arrForm['order_id']);

				$res = Tag_Smaregi::shop_tran_admin($shop, $smaregi_order[0], 1);
//				var_dump($res);
				Log::info($res);
				if ($res != false)
				{
	 				$sql = "delete from dtb_smaregi_order where id = {$id}";
	 				DB::query($sql)->execute();

					$arrDetail = Tag_Order::get_order_detail($arrForm['order_id']);

					foreach($arrDetail as $od)
					{
//						var_dump($od);
						$stock = '+'.$od['quantity'];
						Tag_Item::setStock($od['product_id'], $od['product_code'], $od['color_code'], $od['size_code'], $stock);
//						var_dump(DB::last_query());
Log::debug(DB::last_query());
					}

					$sql = "select * from dtb_smaregi_order where order_id = {$arrForm['order_id']} and shop_url = 'astilehouse' ";
					$arrRet = DB::query($sql)->execute()->as_array();
					$id = 0;
					if (count($arrRet) > 0)
					{
						$smaregi = $arrRet[0];
						$id = $smaregi['id'];
						unset($smaregi['id']);
					}
					if ($id != 0)
					{
						$res = Tag_Smaregi::shop_tran_admin('astilehouse', $smaregi_order[0], 1);
		 				$sql = "delete from dtb_smaregi_order where id = {$id}";
		 				DB::query($sql)->execute();
		 			}


	// 				$sql = "select * from dtb_smaregi_order where order_id = {$order_id} and shop_url = '{$shop_url}'";
	// 				$arrRet = DB::query($sql)->execute()->as_array();
	// 				if (count($arrRet) > 0)
	// 				{
	// 					$smaregi = $arrRet[0];
	// 				}
				}
				else
				{
					Log::info('smaregi cancel error -> '.$arrForm['order_id'].'::'.$res);
				}
			}
		}

		if (($arrForm['status'] != 5 && $arrForm['status'] != 9 && $arrForm['status'] != 17 && $arrForm['status'] != 3) && isset($arrForm['customer_id']) && $arrForm['customer_id'] != 0)
		{
        	$sql = "update dtb_customer set last_buy_date = '{$arrForm['last_buy_date']}' where customer_id = '{$arrForm['customer_id']}'";
	        $query = DB::query($sql);
	        $query->execute();
		}

		if ($arrOrder['deliv_date'] == '')
			$arrOrder['deliv_date'] = null;
		$update->set($arrOrder)->where('order_id', '=', $arrForm['order_id']);
// 		var_dump($update->compile());
		$update->execute();
//var_dump($arrOrder);

		if (!isset($arrForm['customer_id']) || (isset($arrForm['customer_id']) && $arrForm['customer_id'] == 0))
		{
			$order_data = array();
			$order_data['name01'] = $arrForm['name01'];
			$order_data['name02'] = $arrForm['name02'];
			$order_data['kana01'] = $arrForm['kana01'];
			$order_data['kana02'] = $arrForm['kana02'];
			$order_data['email'] = $arrForm['email'];
			$order_data['tel01'] = $arrForm['tel01'];
			$order_data['zip01'] = $arrForm['zip01'];
			$order_data['zip02'] = $arrForm['zip02'];
			$order_data['pref'] = $arrForm['pref'];
			$order_data['addr01'] = $arrForm['addr01'];
			$order_data['addr02'] = $arrForm['addr02'];

//			$order_data['order_id'] = $arrForm['order_id'];
			$update_deliv = DB::update('dtb_order_deliv');
			$update_deliv->set($order_data)->where('order_id', '=', $arrForm['order_id'])->and_where('email', '!=', '');
			$update_deliv->execute();

			$order_data = array();
			$order_data['name01'] = $arrForm['arrDeliv']['name01'];
			$order_data['name02'] = $arrForm['arrDeliv']['name02'];
			$order_data['kana01'] = $arrForm['arrDeliv']['kana01'];
			$order_data['kana02'] = $arrForm['arrDeliv']['kana02'];
//			$order_data['email'] = $arrForm['email'];
			$order_data['tel01'] = $arrForm['arrDeliv']['tel01'];
			$order_data['zip01'] = $arrForm['arrDeliv']['zip01'];
			$order_data['zip02'] = $arrForm['arrDeliv']['zip02'];
			$order_data['pref'] = $arrForm['arrDeliv']['pref'];
			$order_data['addr01'] = $arrForm['arrDeliv']['addr01'];
			$order_data['addr02'] = $arrForm['arrDeliv']['addr02'];
			$update_deliv = DB::update('dtb_order_deliv');
			$update_deliv->set($order_data)->where('order_id', '=', $arrForm['order_id'])->and_where('email', '=', NULL);
			$update_deliv->execute();
		}
		else if (isset($arrForm['customer_id']) && $arrForm['customer_id'] != 0)
		{
//print("<pre>");
//var_dump($arrForm);
			$order_data = array();
			$order_data['name01'] = $arrForm['arrDeliv']['name01'];
			$order_data['name02'] = $arrForm['arrDeliv']['name02'];
			$order_data['kana01'] = $arrForm['arrDeliv']['kana01'];
			$order_data['kana02'] = $arrForm['arrDeliv']['kana02'];
//			$order_data['email'] = $arrForm['email'];
			$order_data['tel01'] = $arrForm['arrDeliv']['tel01'];
			$order_data['zip01'] = $arrForm['arrDeliv']['zip01'];
			$order_data['zip02'] = $arrForm['arrDeliv']['zip02'];
			$order_data['pref'] = $arrForm['arrDeliv']['pref'];
			$order_data['addr01'] = $arrForm['arrDeliv']['addr01'];
			$order_data['addr02'] = $arrForm['arrDeliv']['addr02'];
			$update_deliv = DB::update('dtb_order_deliv');
			$update_deliv->set($order_data)->where('order_id', '=', $arrForm['order_id']);
			$update_deliv->execute();
//var_dump(DB::last_query());
//print("</pre>");
//
//exit;

			$order = Tag_Order::get_order_info($arrForm['order_id']);
			$order = $order[0];
			if ($arrForm['status'] == 3)
			{
				Tag_Point::set_point($order['customer_id'], $order['add_point']*-1, POINT_LOG_CANCEL, $order['order_id']);
				if ($order['use_point'] > 0)
					Tag_Point::set_point($order['customer_id'], $order['use_point'], POINT_LOG_ADD, $order['order_id']);
				Tag_Point::del_temp_point($order['customer_id'], $order['order_id'], $order['add_point']);
				Tag_CustomerInfo::set_use_point($order['customer_id'], $order['use_point']*-1);
			}
		}

        $arrShops = Tag_Cartctrl::get_allshop();

		if ($arrForm['status'] == 3)
		{
	        foreach($arrShops as $s)
	        {
	        	if (isset($arrForm['customer_id']))
		        	$customer_id = $arrForm['customer_id'];
		        else
		        	$customer_id = 0;
				Tag_Mail::order_mail_shopmail_admin($customer_id, $arrForm['order_id'], $s['shop_id'], true);
			}
		}





//		print("</pre>");
//
//exit;
		Response::redirect('/admin/order/');
	}

	public function action_edit()
	{
	 	$arrTemp = Tag_Master::get_master('mtb_customer_rank');
	 	$arrRank = array();
	 	foreach($arrTemp as $temp)
	 	{
	 		$arrRank[$temp['id']] = $temp['name'];
	 	}
	 	$this->arrResult['arrRank'] = $arrRank;

		$arrForm = Input::param();
		$shop_id = Tag_Session::get('shop_id');


		if (isset($arrForm['mode']) && $arrForm['mode'] == 'update')
			$this->update_data($arrForm);


		$arrOrder = Tag_Order::get_order_info($arrForm['order_id']);
		if ($arrOrder[0]['customer_id'] == 0)
		{
			$arrDeliv1 = Tag_Order::get_order_deliv2($arrForm['order_id'], true, true);
			$arrDeliv = Tag_Order::get_order_deliv2($arrForm['order_id'], true, false);
			if (count($arrDeliv) == 0)
			{
				$arrDeliv = $arrDeliv1;
			}
		}
		else
		{
			if ($arrOrder[0]['customer_deliv_id'] != '0')
			{
				$arrDeliv = Tag_Order::get_order_deliv($arrOrder[0]['customer_id'], $arrOrder[0]['customer_deliv_id']);
//var_dump($arrDeliv);
//exit;
				if (count($arrDeliv) == 0)
				{
					$arrDeliv = Tag_Order::get_order_deliv2($arrForm['order_id']);
				}
				else
				{
					$arrDeliv[0]['email'] = '';
				}
			}
			else
			{
				$arrDeliv = Tag_Order::get_order_deliv2($arrForm['order_id']);
			}
		}
		$authority = Tag_Session::get('authority');
		if ($authority == 0)
			$arrDetail = Tag_Order::get_order_detail($arrForm['order_id']);
		else
			$arrDetail = Tag_Order::get_order_detail($arrForm['order_id'], $shop_id);
		$arrForm = array_merge($arrOrder[0], $arrForm);
// 		var_dump($arrForm);
// 		exit;

		$status = $arrForm['status'];

		if (isset($arrDeliv1[0]))
			$arrForm = array_merge($arrForm, $arrDeliv1[0]);
		else
			$arrForm = array_merge($arrForm, $arrDeliv[0]);

		$arrForm['status'] = $status;

		$this->arrResult['arrForm'] = $arrForm;
		$this->arrResult['arrDetail'] = $arrDetail;
		$this->arrResult['arrDeliv'] = $arrDeliv[0];


		if ($arrForm['customer_id'] != '0')
		{
			$customer = Tag_CustomerInfo::get_customer($arrForm['customer_id']);

			$this->arrResult['customer'] = $customer;
//var_dump($customer);
		}

		// クーポン対象商品のチェック
		if ($arrOrder[0]['coupon'] != '')
		{
			$arrCoupon = Tag_Campaign::get_check2($arrOrder[0]['customer_id'], $arrOrder[0]['coupon'],$arrOrder[0]['total']+$arrOrder[0]['tax']);

//			print("<pre>");
//			var_dump($arrCoupon);
//			var_dump($arrOrder[0]['customer_id']);
//			var_dump($arrOrder[0]['coupon']);
//			print("</pre>");
//exit;
			$arrNotShop = explode(',', $arrCoupon[0]['not_shops']);
			$arrNotProduct = explode(',', $arrCoupon[0]['not_products']);
			
			$arrTemp = array();
			foreach($arrDetail as $detail)
			{
				$detail['sale'] = 1;
				foreach($arrNotShop as $shop)
				{
					if (Tag_Shop::get_shop_id($detail['shop_id']) == $shop)
					{
						$detail['sale'] = 0;
					}
				}
				foreach($arrNotProduct as $product)
				{
					if ($detail['product_id'] == $product)
					{
						$detail['sale'] = 0;
					}
				}
				$arrTemp[] = $detail;
			}
			unset($this->arrResult['arrDetail']);
			$this->arrResult['arrDetail'] = $arrTemp;

		}
		else
		{
			$arrTemp = array();
			foreach($arrDetail as $detail)
			{
				$detail['sale'] = 0;
				$arrTemp[] = $detail;
			}
			unset($this->arrResult['arrDetail']);
			$this->arrResult['arrDetail'] = $arrTemp;
		}

		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$this->arrResult['sale_flg'] = 0;
		$this->arrResult['vip_sale_flg'] = 0;
		$this->arrResult['sale_par'] = 0;

		if ($start_date <= $now && $end_date >= $now)
		{
			$this->arrResult['sale_flg'] = 1;
			$this->arrResult['sale_par'] = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$this->arrResult['vip_sale_flg'] = 1;
			$this->arrResult['sale_par'] = $arrSales['vip_sale'];
		}

		$this->tpl = 'smarty/admin/order/edit.tpl';
		return $this->view;
	}

	public function post_regist()
	{
//		var_dump('post_regist');
		$arrForm = Input::post();

// 		print('<pre>');
// 		var_dump($arrForm);
// 		print('</pre>');
// exit;
		$order_id = Tag_Order::set_new_order($arrForm);
		$arrOrder = Tag_Order::get_order_info($order_id);
		$arrOrder = $arrOrder[0];
		Tag_Mail::order_mail_crossmall_admin($arrForm['customer_id'], $order_id, 'guji');
		Tag_Mail::order_mail_crossmall_admin($arrForm['customer_id'], $order_id, 'ring');
		Tag_Mail::order_mail_nextmail_admin($arrForm['customer_id'], $order_id, 'sugawaraltd');
		Tag_Mail::order_mail_crossmall_admin($arrForm['customer_id'], $order_id, 'altoediritto');
		Tag_Mail::order_mail_crossmall_admin($arrForm['customer_id'], $order_id, 'biglietta');

		$arrOrderDetail = Tag_Order::get_order_detail($order_id);

		if ($arrForm['status'] == 1)
			Controller_Api::send_order($arrOrderDetail);

		$arrForm['order_id'] = $order_id;
        $arrShops = Tag_Cartctrl::get_allshop();
        foreach($arrShops as $s)
        {
			Tag_Mail::order_mail_shopmail_admin($arrForm['customer_id'], $order_id, $s['shop_id']);

			if ($s['stock_type'] == SMAREGI)
				Tag_Smaregi::shop_tran_admin($s['shop_id'], $arrOrder);
		}

		Response::redirect('/admin/order/edit?order_id='.$order_id);

		$arrDetail = array();
		$arrDeliv = array();
		$now = date('Y-m-d H:i:s');

		$this->arrResult['arrForm'] = $arrForm;
		$this->arrResult['arrDetail'] = $arrDetail;
		$this->arrResult['arrDeliv'] = $arrDeliv;

		$this->tpl = 'smarty/admin/order/regist.tpl';
		return $this->view;
	}

	public function get_regist()
	{
//		var_dump('get_regist');
		$arrForm = Input::param();
		$arrDetail = array();
		$arrDeliv = array();
		$now = date('Y-m-d H:i:s');

		$arrForm = array(
			'status'=>'1',
			'customer_id'=>'0',
			'email'=>'',
			'pref'=>'',
			'detail_statement'=>'',
			'packing'=>'',
			'card'=>'',
			'create_date'=>$now,
			'deliv_time'=>'',
			'deliv_date'=>'',
			'payment_id'=>'',
			'deliv_pref'=>'',
			'send_number'=>'',
		);
		$arrDeliv = array(
			'status'=>'0',
			'customer_id'=>'',
			'email'=>'',
			'pref'=>'',
			'detail_statement'=>'',
			'packing'=>'',
			'card'=>'',
			'customer_id'=>'',
			'customer_id'=>'',
			'customer_id'=>'',
		);
		$this->arrResult['arrForm'] = $arrForm;
		$this->arrResult['arrDetail'] = $arrDetail;
		$this->arrResult['arrDeliv'] = $arrDeliv;


// 		if ($arrForm['customer_id'] != '0')
// 		{
// 			$customer = Tag_CustomerInfo::get_customer($arrForm['customer_id']);
//
// 			$this->arrResult['customer'] = $customer;
// 		}
//var_dump($_SESSION);
		$this->tpl = 'smarty/admin/order/regist.tpl';
		return $this->view;
	}

	/**
	 * PRODUCT一覧 取得
	 *
	 * @return unknown
	 */
	public function action_index2()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$arrResult['entry'] = $post_id;
		$this->tpl = 'smarty/admin/product/index.tpl';

// 		$view = View::forge('layout');
//		$this->view->header = View_Smarty::forge( $tpl, $arrResult, false );

		$post = Input::param();

//		var_dump($post);

		$where = "";
		$order = " create_date DESC ";


		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_sorderyear':
				{
					if ($post['search_sorderyear'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_sorderyear']))
						{
							break;
						}
						if (!preg_match("/^[0-9]+$/", $post['search_sordermonth']))
						{
							break;
						}
						if (!preg_match("/^[0-9]+$/", $post['search_sorderday']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.create_date >= '".$post['search_sorderyear'].'-'.$post['search_sordermonth'].'-'.$post['search_sorderday']."' ";
						$this->setFormParams('arrForm', 'search_sorderyear', $post['search_sorderyear'], '10');
						$this->setFormParams('arrForm', 'search_sordermonth', $post['search_sordermonth'], '10');
						$this->setFormParams('arrForm', 'search_sorderday', $post['search_sorderday'], '10');
					}
					break;
				}
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.product_id = ".$post['search_product_id'];
						$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '10');
					}
					break;
				}
				case 'search_product_code':
				{
					if ($post['search_product_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " D.product_code like '".$post['search_product_code']."%' ";
						$this->setFormParams('arrForm', 'search_product_code', $post['search_product_code'], '20');
					}
					break;
				}
				case 'search_send_status':
				{
					if (count($post['search_send_status']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_send_status'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.status <> 5 ";
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_send_status', $post['search_send_status'], '');
					break;
				}
				case 'search_name':
				{
					if ($post['search_name'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.name like '%".$post['search_name']."%' ";
						$this->setFormParams('arrForm', 'search_name', $post['search_name'], '50');
					}
					break;
				}
				case 'search_group_code':
				{
					if ($post['search_group_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '".$post['search_group_code']."%' ";
						$this->setFormParams('arrForm', 'search_group_code', $post['search_group_code'], '15');
					}
					break;
				}
				case 'search_category_id':
				{
					if ($post['search_category_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_category_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " G.category_id = '".$post['search_category_id']."' ";
						$this->setFormParams('arrForm', 'search_category_id', $post['search_category_id'], '');
					}
					break;
				}
				case 'search_smaregi_product_id':
				{
					if ($where != "")
						$where .= " AND ";
					$where .= " A.product_id = ".$post['search_smaregi_product_id'];
					$this->setFormParams('arrForm', 'search_smaregi_product_id', $post['search_smaregi_product_id'], '10');
					break;
				}
				case 'search_stock':
				{
					if ($post['search_stock'] != 0)
					{
						if ($post['search_stock'] == '1')
							$where .= " D.stock <> 0 ";
						else
							$where .= " D.stock = 0 ";

						$this->setFormParams('arrForm', 'search_stock', $post['search_stock'], '');
						break;
					}
				}
				case 'search_payment_id':
				{
					if (count($post['search_payment_id']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_payment_id'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.payment_id = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_payment_id', $post['search_payment_id'], '');
					break;
				}
			}
		}
//var_dump($where);
//exit;

		$arrData = Tag_Item::get_allitems($where);
		$this->setData($arrData);

		return $this->view;
	}

	public function before()
	{
		parent::before();

		$arrTemp = Tag_Master::get_master('mtb_order_status');
		$arrORDERSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrORDERSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrORDERSTATUS'] = $arrORDERSTATUS;

		$arrTemp = Tag_Master::get_master('mtb_order_status_color');
		$arrORDERSTATUS_COLOR = array();
		foreach($arrTemp as $t)
		{
			$arrORDERSTATUS_COLOR[$t['id']] = $t['name'];
		}
		$this->arrResult['arrORDERSTATUS_COLOR'] = $arrORDERSTATUS_COLOR;

		$arrTemp = Tag_Master::get_master('mtb_payment');
		$arrPayments = array();
		foreach($arrTemp as $t)
		{
			$arrPayments[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPayments'] = $arrPayments;

		$arrTemp = Tag_Master::get_master('mtb_status');
		$arrSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrSTATUS'] = $arrSTATUS;

		$arrTemp = Tag_Master::get_master('mtb_pref');
		$arrPref = array();
		foreach($arrTemp as $t)
		{
			$arrPref[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPref'] = $arrPref;

		$arrTemp = Tag_Master::get_master('mtb_status_color');
		$arrPRODUCTSTATUS_COLOR = array();
		foreach($arrTemp as $t)
		{
			$arrPRODUCTSTATUS_COLOR[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPRODUCTSTATUS_COLOR'] = $arrPRODUCTSTATUS_COLOR;

		$arrTemp = Tag_Order::get_deliv_time();
		$arrDelivTime = array();
		foreach($arrTemp as $t)
		{
			$arrDelivTime[$t['deliv_time']] = $t['deliv_time'];
		}
		//var_dump($arrDelivTime);
		$this->arrResult['arrDelivTime'] = $arrDelivTime;


// 		$arrCatList = $this->setItemParam(Tag_Item::get_categories('parent_category_id <> 0'), 'category_id', 'name');
// 		$this->arrResult['arrCatList'] = $arrCatList;
//var_dump($this->arrResult);exit;
//		var_dump(Tag_Campaign::get_uniqcode());

	}


	public function init_param()
	{
		$this->arrResult['arrRegistYear'] = Tag_Master::get_year();
		$this->arrResult['arrMonth'] = Tag_Master::get_month();
		$this->arrResult['arrDay'] = Tag_Master::get_day();
		$this->arrResult['arrEndYear'] = Tag_Master::get_year();
		$this->arrResult['arrEndMonth'] = Tag_Master::get_month();
		$this->arrResult['arrEndDay'] = Tag_Master::get_day();

		$this->setFormParams('arrForm','search_order_id1', '', '');
		$this->setFormParams('arrForm','search_order_id2', '', '');
		$this->setFormParams('arrForm','search_order_status', '', '');
		$this->setFormParams('arrForm','search_order_name', '', '');
		$this->setFormParams('arrForm','search_order_kana', '', '');
		$this->setFormParams('arrForm','search_order_email', '', '');
		$this->setFormParams('arrForm','search_order_tel', '', '');
		$this->setFormParams('arrForm','search_payment_id', '', '');
		$this->setFormParams('arrForm','search_sorderyear', '', '');
		$this->setFormParams('arrForm','search_order_date', '', '');
		$this->setFormParams('arrForm','search_sordermonth', '', '');
		$this->setFormParams('arrForm','search_sorderday', '', '');
		$this->setFormParams('arrForm','search_eorderyear', '', '');
		$this->setFormParams('arrForm','search_eordermonth', '', '');
		$this->setFormParams('arrForm','search_eorderday', '', '');
		$this->setFormParams('arrForm','search_send_status', '1', '');
		$this->setFormParams('arrForm','search_total1', '', '');
		$this->setFormParams('arrForm','search_total2', '', '');
		$this->setFormParams('arrForm','search_product_name', '', '');
		$this->setFormParams('arrForm','search_page_max', '', '');

		$this->arrResult['arrErr']['search_order_id1'] = "";
		$this->arrResult['arrErr']['search_order_id2'] = "";
		$this->arrResult['arrErr']['search_order_status'] = "";
		$this->arrResult['arrErr']['search_order_name'] = "";
		$this->arrResult['arrErr']['search_order_email'] = "";
		$this->arrResult['arrErr']['search_order_kana'] = "";
		$this->arrResult['arrErr']['search_payment_id'] = "";
		$this->arrResult['arrErr']['search_order_date'] = "";
		$this->arrResult['arrErr']['search_sorderyear'] = "";
		$this->arrResult['arrErr']['search_sordermonth'] = "";
		$this->arrResult['arrErr']['search_sorderday'] = "";
		$this->arrResult['arrErr']['search_eorderyear'] = "";
		$this->arrResult['arrErr']['search_eordermonth'] = "";
		$this->arrResult['arrErr']['search_eorderday'] = "";
		$this->arrResult['arrErr']['search_send_status'] = "";
		$this->arrResult['arrErr']['search_total1'] = "";
		$this->arrResult['arrErr']['search_total2'] = "";
		$this->arrResult['arrErr']['search_product_name'] = "";
		$this->arrResult['arrErr']['search_page_max'] = "";
	}



	public function action_mail() {

		$post = Input::param();
		$mode = Input::param('mode', '');

		//var_dump($post);

		$order_id_array = Input::param('order_id', '');
		if( $order_id_array == '' ) {
			$order_id_array = Input::param('order_id_array', '');
		}

		$arrForm = array();
		$arrForm['template_id']		= Input::param('template_id', '');
		$arrForm['subject']			= Input::param('subject', '');
		$arrForm['mail_header']		= Input::param('mail_header', '');
		$arrForm['mail_body']		= Input::param('mail_body', '');
		$arrForm['mail_footer']		= Input::param('mail_footer', '');
		$arrForm['flg_order']		= Input::param('flg_order', '');

		$this->arrResult['msg'] = "";
		$this->arrResult['arrSearchHidden'] = array();
		$this->arrResult['order_id_array'] = $order_id_array;
		$arrOrderId = explode(',', $order_id_array);
		$this->arrResult['order_id_count'] = count($arrOrderId);

		$sql  = "SELECT * FROM dtb_mail_template where del_flg = 0 ";
		$sql .= " order by rank ";
		$query = DB::query($sql);
		$arrMailTempleate = $query->execute()->as_array();
		$this->arrResult['arrMailTemplete'] = $arrMailTempleate;

		if( $mode == 'confirm' ) {

			foreach ( $arrOrderId as $order_id ) {
				$order = Tag_Order::get_order_info($order_id);

				$customer_id = $order[0]["customer_id"];

				$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ", 10, true);
				/*
				 if ($customer_id != 0)
				 $arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
				 else {
				 $arrOrderDeliv = Tag_Order::get_order_deliv2($order_id);
				 if( count($arrOrderDeliv) == 0) {
				 return false;
				 }
				 $arrCustomer = $arrOrderDeliv[0];
				 }
				 */
				 $arrFreeProducts = array();
				 if ($customer_id != 0)
				 {
				 	$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
				 	$arrResult['arrCustomer'] = $arrCustomer;
				 	$arrCoupon = Tag_Campaign::get_check($customer_id, $arrOrder[0]['coupon'],$arrOrder[0]['payment_total']);
				 	if (is_array($arrCoupon) && count($arrCoupon) > 0)
				 	{
				 		$arrFreeProducts = explode(',', $arrCoupon[0]['product_ids']);
				 	}
				 }
				 else
				 {
				 	$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true,true);
			 		$arrCustomer = $arrOrderDeliv[0];
				 	$arrDeliv = Tag_Order::get_order_deliv2($order_id, true);
//var_dump($arrDeliv);exit;
				 	if (count($arrDeliv) == 0)
				 	{
				 		$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
					 	$arrDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
				 		if( count($arrOrderDeliv) == 0)
				 		{
				 			return false;
				 		}
				 		$arrCustomer = $arrOrderDeliv[0];
				 	}
				 }

				 // 受注情報も付ける場合
				 if( $arrForm['flg_order'] ) {
				 	$arrOrder = $arrOrder[0];
				 	$arrOrderDetail = Tag_Order::get_order_detail($order_id);
					if ($customer_id != 0)
					{
						$arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);
						if (count($arrDeliv) == 0)
						{
							$arrDeliv = Tag_Order::get_order_deliv2($order_id);
						}
						$arrDeliv = Tag_Order::get_order_deliv2($order_id);
					}
//					 	$arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);
				 	$arrPayment = Tag_Order::getPayment();
				 	$arrTemp = array();
				 	foreach($arrPayment as $p)
				 	{
				 		$arrTemp[$p['id']] = $p['name'];
				 	}
				 	$arrPayment = $arrTemp;

				 	$arrResult['arrPayment'] = $arrPayment;
				 	$arrResult['arrOrder'] = $arrOrder;

				 	$arrTemp = array();
				 	$arrFree = array();
				 	foreach($arrOrderDetail as $od)
				 	{
				 		foreach($arrFreeProducts as $pid)
				 		{
				 			if ($pid == $od['product_id'])
				 			{
				 				$arrFree['name'] = $od['product_name'];
				 				$arrFree['price'] = $od['price'];
				 			}
				 		}
				 		$od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
				 		$details = Tag_Item::get_detail_sku($od['product_id'], true);

				 		$detail = Tag_Item::get_detail($od['product_id'],true);
				 		$brands = Tag_Item::get_brand(true);

				 		foreach($details as $d)
				 		{
				 			if ($d['size_name'] == null && ($d['size_code'] == '999' || $d['size_code'] == ''))
				 				$d['size_code'] = null;
			 				if ($d['color_code'] == $od['color_code'] && $d['size_code'] == $od['size_code'])
			 				{
			 					foreach($brands as $b)
			 					{
			 						if ($detail['brand_id'] == $b['id'])
			 						{
			 							$od['brand'] = $b['name'];
			 							break;
			 						}
			 					}
			 					$od['product_code'] = $d['product_code'];
			 					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
			 					break;
			 				}
			 				else
			 				{
			 					foreach($brands as $b)
			 					{
			 						if ($detail['brand_id'] == $b['id'])
			 						{
			 							$od['brand'] = $b['name'];
			 							break;
			 						}
			 					}
			 					$od['product_code'] = $d['product_code'];
			 					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
//			 					break;
			 				}
				 		}
				 		$arrTemp[] = $od;
				 	}
				 	$arrOrderDetail = $arrTemp;

//					$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
//					$arrSales = $arrSales[0];
//					$now = date('YmdHis');
//					
//					$start_date = date('YmdHis', strtotime($arrSales['start_date']));
//					$end_date = date('YmdHis', strtotime($arrSales['end_date']));
//					$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
//					$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
//					$sale_flg = 0;
//					$vip_sale_flg = 0;
//					$sale_par = 0;
//			
//					if ($start_date <= $now && $end_date >= $now)
//					{
//						$sale_flg = 1;
//						$sale_par = $arrSales['sale'];
//					}
//					else if ($vip_start_date <= $now && $vip_end_date >= $now)
//					{
//						$vip_sale_flg = 1;
//						$sale_par = $arrSales['vip_sale'];
//					}
					$arrResult['customer_sale_status'] = 0;
					if ($customer_id != 0)
					{
						$customer = Tag_CustomerInfo::get_customer($customer_id);
						$arrResult['customer_sale_status'] = $customer['sale_status'];
					}

				 	$arrTemp = Tag_Master::get_master('mtb_customer_rank');
				 	$arrRank = array();
				 	foreach($arrTemp as $temp)
				 	{
				 		$arrRank[$temp['id']] = $temp['name'];
				 	}
				 	$arrResult['arrFree'] = $arrFree;
				 	$arrResult['arrRank'] = $arrRank;
				 	$arrResult['arrOrderDetail'] = $arrOrderDetail;
				 	$arrResult['arrDeliv'] = $arrDeliv;
				 	$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();
				 }
				 // print('<pre>');
				 // var_dump($arrResult);
				 // var_dump($arrForm['flg_order']);
				 // var_dump($arrFree);
				 // print('</pre>');
				 // exit;

				 // 置換
				 $arrForm = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrForm);
				 $arrForm = str_replace('[@date]', date('Y年m月d日'), $arrForm);

				 $arrForm['toAddress'] = $arrCustomer['email'];
				 $arrResult['arrForm'] = $arrForm;

				 $this->arrResult = array_merge( $this->arrResult, $arrResult);

			}

			$this->tpl = 'smarty/admin/order/mail_confirm.tpl';

		} elseif( $mode == 'send' ) {

			$arrForm['mail_send_body']	= Input::param('mail_send_body', '');
			$arrResult['arrForm'] = $arrForm;

			$tpl = 'smarty/email/general_mail.tpl';

			$email = Email::forge();
			$email->header('Content-Transfer-Encoding', 'base64');
			$email->from(ORDER_MAIL_FROM);
			$email->to(Input::param('toAddress', ''));
			$email->cc(ORDER_MAIL_FROM);
			$email->subject($arrForm['subject']);
			$email->body(\View_Smarty::forge($tpl, $arrResult, false));

			$history = array();
			$history['order_id'] = Input::param('order_id_array', '');
			$emails = $email->get_to();
			$tos = array();
			foreach($emails as $k=>$m)
			{
				$tos[] = $k;
			}
			$history['to_email'] = implode(',', $tos);
			$history['subject'] = $email->get_subject();
			$history['body'] = $email->get_body();
			$query = DB::insert('dtb_mail_history');
			$query->set($history);
			$query->execute();

			$email->send();

			$this->arrResult['msg']	= "メール送信が完了いたしました。";

			$this->tpl = 'smarty/admin/order/mail.tpl';

		} elseif( $mode == 'template' ) {

			if( $arrForm['template_id'] != "" ) {
				$sql  = "SELECT * FROM dtb_mail_template";
				$sql .= " WHERE id = {$arrForm['template_id']}";
				$sql .= " order by rank ";
				$query = DB::query($sql);
				$arrTempleate = $query->execute()->as_array();

				if( 0 < count($arrTempleate)) {
					$arrForm['subject']		= $arrTempleate[0]['subject'];
					$arrForm['mail_header']	= $arrTempleate[0]['header'];
					$arrForm['mail_footer']	= $arrTempleate[0]['footer'];
				}
			} else {
				$arrForm['subject']		= '';
				$arrForm['mail_header']	= '';
				$arrForm['mail_footer']	= '';
			}

			$this->tpl = 'smarty/admin/order/mail.tpl';

		} else {

			$sql  = "SELECT * FROM dtb_mail_history";
			$sql .= " where order_id = {$arrOrderId[0]}";
			$sql .= " order by create_date ";
			$query = DB::query($sql);
			$arrMailHistory = $query->execute()->as_array();
			foreach ( $arrMailHistory as &$history ) {
				$history['subject_decode'] = iconv_mime_decode($history['subject']);
			}
			$this->arrResult['arrMailHistory'] = $arrMailHistory;

			$this->tpl = 'smarty/admin/order/mail.tpl';

		}

		$sql  = "SELECT * FROM dtb_mail_history";
		$sql .= " where order_id = {$arrOrderId[0]}";
		$sql .= " order by create_date ";
		$query = DB::query($sql);
		$arrMailHistory = $query->execute()->as_array();
		foreach ( $arrMailHistory as &$history ) {
			$history['subject_decode'] = iconv_mime_decode($history['subject']);
		}
		$this->arrResult['arrMailHistory'] = $arrMailHistory;

		$this->arrResult['arrForm'] = $arrForm;
		return $this->view;
	}



	public function action_changestatus() {

		$post = Input::param();
		$order_status = Input::param('status_change', '');

		if( $order_status != "" ) {
			foreach( $post['status_order_id'] as $order_id ) {
				$result = DB::update('dtb_order')->value('status', $order_status)->value('update_date', date('Y-m-d H:i:s'))->where('order_id', $order_id)->execute();
			}
		}
//waka by 2024.10.28
		$order = Tag_Order::get_order_info($order_id);
		
		if (isset($order[0]['customer_id']) && $order[0]['customer_id'] != 0)
		{
			if ($order_status == 5 || $order_status == 9 || $order_status == 17)
			{
	        	$sql = "update dtb_customer set last_buy_date = '{$order[0]['create_date']}' where customer_id = '{$order[0]['customer_id']}' and last_buy_date < '{$order[0]['create_date']}'";
		        $query = DB::query($sql);
		        $query->execute();
			}
		}

		Response::redirect('/admin/order');
	}

	public function action_numbercsv() {

		$post = Input::param();
//		$order_status = Input::param('status_change', '');

		$file_tmp1  = $_FILES["number_csv"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
//var_dump($file_tmp1);

		$csv1 = array();
		$file = fopen($file_tmp1, 'r');
//var_dump($file);
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
//			if ($cnt == 0)
//			{
//				$csv_key = $data;
//				//var_dump($csv_key);
//				$cnt++;
//			}
//			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv1[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

//var_dump($csv_key);
//var_dump($csv1);

		foreach($csv1 as $csv)
		{
			$order_id = $csv[0];
			$sql = "select dtb_customer.email,dtb_order.status from dtb_order left join dtb_customer on dtb_order.customer_id = dtb_customer.customer_id where order_id = '{$order_id}'";
			$arrRet = DB::query($sql)->execute()->as_array();
			
			if (count($arrRet) > 0)
			{
				if ($arrRet[0]['status'] != '5')
				{
					$email = '';
					if ($arrRet[0]['email'] == '')
					{
						$sql = "select email from dtb_order_deliv where order_id = '{$order_id}'";
						$arrRet = DB::query($sql)->execute()->as_array();
					}
					$email = $arrRet[0]['email'];
		
					if ($email != '')
					{
	//print("<pre>");
	//var_dump($csv[0].':'.$arrRet[0]['status'].':'.$email);
	//print("</pre>");
						//メール送信
						$this->send_mail($order_id, $email, $csv[4], $csv[3]);
	
						$result = DB::update('dtb_order')->value('send_date', $csv[4])->value('send_number',$csv[3])->value('status', '5')->value('update_date', date('Y-m-d H:i:s'))->where('order_id', $order_id)->execute();

//waka by 2024.10.28
						$order = Tag_Order::get_order_info($order_id);
						if (isset($order[0]['customer_id']) && $order[0]['customer_id'] != 0)
						{
				        	$sql = "update dtb_customer set last_buy_date = '{$order[0]['create_date']}' where customer_id = '{$order[0]['customer_id']}' and last_buy_date < '{$order[0]['create_date']}'";
					        $query = DB::query($sql);
					        $query->execute();
						}

					}				
				}
			}
		}

//exit;
//		if( $order_status != "" ) {
//			foreach( $post['status_order_id'] as $order_id ) {
//				$result = DB::update('dtb_order')->value('status', $order_status)->value('update_date', date('Y-m-d H:i:s'))->where('order_id', $order_id)->execute();
//			}
//		}


//		$result = DB::update('dtb_order')->value('send_number', $order_status)->value('update_date', date('Y-m-d H:i:s'))->where('order_id', $order_id)->execute();
//exit;
		Response::redirect('/admin/order');
	}
	
	public function send_mail($order_id, $to, $send_date, $send_number) {

		$arrForm = array();
		$arrForm['template_id']		= '34';

		$sql  = "SELECT * FROM dtb_mail_template";
		$sql .= " WHERE id = {$arrForm['template_id']}";
		$sql .= " order by rank ";
		$query = DB::query($sql);
		$arrTempleate = $query->execute()->as_array();

		if (0 < count($arrTempleate))
		{
			$arrForm['subject']		= $arrTempleate[0]['subject'];
			$arrForm['tpl_header']	= $arrTempleate[0]['header'];
			$arrForm['tpl_footer']	= $arrTempleate[0]['footer'];
		}

//		$arrForm['mail_send_body']	= Input::param('mail_send_body', '');
		$order = Tag_Order::get_order_info($order_id);

		$customer_id = $order[0]["customer_id"];

		$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ", 10, true);
		 $arrFreeProducts = array();
		 if ($customer_id != 0)
		 {
		 	$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
		 	$arrResult['arrCustomer'] = $arrCustomer;
		 	$arrCoupon = Tag_Campaign::get_check($customer_id, $arrOrder[0]['coupon'],$arrOrder[0]['payment_total']);
		 	if (is_array($arrCoupon) && count($arrCoupon) > 0)
		 	{
		 		$arrFreeProducts = explode(',', $arrCoupon[0]['product_ids']);
		 	}
		 }
		 else
		 {
		 	$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true,true);
	 		$arrCustomer = $arrOrderDeliv[0];
		 	$arrDeliv = Tag_Order::get_order_deliv2($order_id, true);
//var_dump($arrDeliv);exit;
		 	if (count($arrDeliv) == 0)
		 	{
		 		$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
			 	$arrDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
		 		if( count($arrOrderDeliv) == 0)
		 		{
		 			return false;
		 		}
		 		$arrCustomer = $arrOrderDeliv[0];
		 	}
		 }

		 // 受注情報も付ける場合
		 if (true) {
		 	$arrOrder = $arrOrder[0];
		 	$arrOrderDetail = Tag_Order::get_order_detail($order_id);
			if ($customer_id != 0)
				$arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);
//					 	$arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);
			if (count($arrDeliv) == 0)
			{
				$arrDeliv = Tag_Order::get_order_deliv2($order_id);
			}
		 	$arrPayment = Tag_Order::getPayment();
		 	$arrTemp = array();
		 	foreach($arrPayment as $p)
		 	{
		 		$arrTemp[$p['id']] = $p['name'];
		 	}
		 	$arrPayment = $arrTemp;

		 	$arrResult['arrPayment'] = $arrPayment;
		 	$arrResult['arrOrder'] = $arrOrder;

		 	$arrTemp = array();
		 	$arrFree = array();
		 	foreach($arrOrderDetail as $od)
		 	{
		 		foreach($arrFreeProducts as $pid)
		 		{
		 			if ($pid == $od['product_id'])
		 			{
		 				$arrFree['name'] = $od['product_name'];
		 				$arrFree['price'] = $od['price'];
		 			}
		 		}
		 		$od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
		 		$details = Tag_Item::get_detail_sku($od['product_id'], true);

		 		$detail = Tag_Item::get_detail($od['product_id'],true);
		 		$brands = Tag_Item::get_brand(true);

		 		foreach($details as $d)
		 		{
		 			if ($d['size_name'] == null && ($d['size_code'] == '999' || $d['size_code'] == ''))
		 				$d['size_code'] = null;
	 				if ($d['color_code'] == $od['color_code'] && $d['size_code'] == $od['size_code'])
	 				{
	 					foreach($brands as $b)
	 					{
	 						if ($detail['brand_id'] == $b['id'])
	 						{
	 							$od['brand'] = $b['name'];
	 							break;
	 						}
	 					}
	 					$od['product_code'] = $d['product_code'];
	 					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
	 					break;
	 				}
	 				else
	 				{
	 					foreach($brands as $b)
	 					{
	 						if ($detail['brand_id'] == $b['id'])
	 						{
	 							$od['brand'] = $b['name'];
	 							break;
	 						}
	 					}
	 					$od['product_code'] = $d['product_code'];
	 					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
//			 					break;
	 				}
		 		}
		 		$arrTemp[] = $od;
		 	}
		 	$arrOrderDetail = $arrTemp;

		 	$arrTemp = Tag_Master::get_master('mtb_customer_rank');
		 	$arrRank = array();
		 	foreach($arrTemp as $temp)
		 	{
		 		$arrRank[$temp['id']] = $temp['name'];
		 	}
		 	$arrResult['arrFree'] = $arrFree;
		 	$arrResult['arrRank'] = $arrRank;
		 	$arrResult['arrOrderDetail'] = $arrOrderDetail;
		 	$arrResult['arrDeliv'] = $arrDeliv;
		 	$arrResult['arrPref'] = Tag_CustomerInfo::get_Pref();
		 }

		 // 置換
		 $arrForm = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrForm);
//		 $arrForm = str_replace('[@date]', date('Y年m月d日', strtotime($send_date)), $arrForm);
		 $arrForm = str_replace('[@date]の', '', $arrForm);
		 if ($arrOrder['recepit_atena'] != '')
		 {
			 $arrForm = str_replace('ご注文頂きました商品は、', 'ご注文頂きました商品は領収書同封のうえ、', $arrForm);
		 }
		 if ($arrOrder['deliv_date'] != '')
		 {
//		 	●日(●曜日)●着指定で
		 	$week = array('0'=>'(日曜日)','1'=>'(月曜日)','2'=>'(火曜日)','3'=>'(水曜日)','4'=>'(木曜日)','5'=>'(金曜日)','6'=>'(土曜日)');
		 	$w = date('w', strtotime($arrOrder['deliv_date']));
		 	$d = date('d日', strtotime($arrOrder['deliv_date']));
			$arrForm = str_replace('●日(●曜日)●着指定で', $d.$week[$w].'着で', $arrForm);
		 }
		 if ($arrOrder['deliv_time'] != '')
		 {
		 	$t = $arrOrder['deliv_time'];
			$arrForm = str_replace('着で', '着で'.$t.'を指定し', $arrForm);
		 }
 		 $msg_card = '';
 		 if ($arrOrder['packing'] != '0' && $arrOrder['gift_price'] != '0')
 		 {
 		 	$packing = '';
		 	if ($arrOrder['card'] != '0')
			 	$msg_card = '（メッセージカード付き）';
			if ($arrOrder['packing'] != '0')
	 		 	$packing = PHP_EOL.'また、簡易包装にご協力いただきありがとうございます。';
			$arrForm = str_replace('発送致します。', '発送いたします。'.PHP_EOL.'ご要望いただいたギフトラッピングを施しております。'.$msg_card.$packing, $arrForm);
 		 }
		 elseif ($arrOrder['gift_price'] != '0')
		 {
		 	if ($arrOrder['card'] != '0')
			 	$msg_card = '（メッセージカード付き）';
			$arrForm = str_replace('発送致します。', '発送いたします。'.PHP_EOL.'ご要望いただいたギフトラッピングを施しております。'.$msg_card, $arrForm);
		 }

		 
		 $arrForm = str_replace('担当: ●', '', $arrForm);
		 $arrForm = str_replace('●●●●-●●●●-●●●●', $send_number, $arrForm);
		 
		 $arrForm['toAddress'] = $arrCustomer['email'];
		 $arrResult['arrForm'] = $arrForm;
		$arrResult['tpl_header'] = $arrForm['tpl_header'];
		$arrResult['tpl_footer'] = $arrForm['tpl_footer'];
//print("<pre>");
//var_dump($arrForm);
//print("</pre>");
		$tpl = 'smarty/email/order_mail.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$email->to($to);
		$email->cc(ORDER_MAIL_FROM);
		$email->subject($arrForm['subject']);
		$email->body(\View_Smarty::forge($tpl, $arrResult, false));

		$history = array();
		$history['order_id'] = $order_id;
		$emails = $email->get_to();
		$tos = array();
		foreach($emails as $k=>$m)
		{
			$tos[] = $k;
		}
		$history['to_email'] = implode(',', $tos);
		$history['subject'] = $email->get_subject();
		$history['body'] = $email->get_body();
		$query = DB::insert('dtb_mail_history');
		$query->set($history);
		$query->execute();

		$email->send();

		$this->arrResult['msg']	= "メール送信が完了いたしました。";
	}

	

	public function action_tools()
	{
		$cart_data = array();
		if (Input::param('mode') == 'order_temp')
		{
			$order_id = Input::param('order_id');
			
			if (ctype_digit($order_id))
			{
				$sql = "select * from dtb_order_temp where order_id = '{$order_id}'";
				$arrRet = DB::query($sql)->execute()->as_array();
				
				if (count($arrRet) > 0)
				{
					$arrOrder = $arrRet[0];
					$cart_data = unserialize(htmlspecialchars_decode($arrOrder['cart_data']));
					$details = $cart_data->getOrderDetail();
//					print("<pre>");
//					var_dump($cart_data);
//					foreach($cart_data->getOrderDetail() as $detail)
//					{
//						var_dump($detail);
//					}
//					print("</pre>");
				}
			}
		}
		
		
		$tpl = 'smarty/admin/order/tools.tpl';
		return View_Smarty::forge( $tpl, array('cart_data'=>$cart_data), false );
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

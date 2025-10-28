<?php
class Tag_Order
{
	function __construct()
	{
	}

	public static function getPayment()
	{
		$sql = "SELECT * FROM mtb_payment";
		$order = " ORDER BY rank ASC";
		$query = DB::query($sql.$order);
		$arrRet = $query->execute()->as_array();

		return $arrRet;
	}

	public static function get_order_detail($order_id, $shop_id = "")
	{
		$sql = "SELECT A.* FROM dtb_order_detail AS A";
		if( $shop_id != "" ) {
			$sql .= " JOIN dtb_shop AS B ON A.shop_id = B.login_id ";
		}
		$where = " WHERE A.order_id = ".$order_id;
		if( $shop_id != "" ) {
			$where .= " AND B.id = ".$shop_id;
		}


		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();

		return $arrRet;
	}

	public static function get_deliv_time($deliv_id = 1)
	{
		$sql = "SELECT * FROM dtb_delivtime";
		$where = " WHERE deliv_id = ".$deliv_id;
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();

		return $arrRet;
	}

	public static function get_order_deliv($customer_id, $deliv_id)
	{
		if ($deliv_id == 0)
		{
			$sql = "SELECT * FROM dtb_customer";
			$where = " WHERE customer_id = {$customer_id}";
			$query = DB::query($sql.$where);
			$arrRet = $query->execute()->as_array();
		}
		else if ($customer_id != 0)
		{
			$sql = "SELECT * FROM dtb_other_deliv";
			$where = " WHERE id = {$deliv_id}";
			$query = DB::query($sql.$where);
			$arrRet = $query->execute()->as_array();
		}

		return $arrRet;
	}
	
	public static function get_order_count($customer_id)
	{
		$sql = "SELECT * FROM dtb_order";
		$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3";
		$order = " ORDER BY create_date DESC ";
		$query = DB::query($sql.$where.$order);
		$arrRet = $query->execute()->as_array();

		return count($arrRet);		
	}

	public static function get_order_info($order_id)
	{
		$sql = "SELECT * FROM dtb_order";
		$sql .= " where order_id = {$order_id}";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}
	public static function get_order_deliv2($order_id, $guest = false, $order = false)
	{
		if ($guest == true && $order == false)
		{
			$sql = "SELECT * FROM dtb_order_deliv where order_id = {$order_id} and email is NULL";
		}
		else if ($guest == true && $order == true)
		{
			$sql = "SELECT * FROM dtb_order_deliv where order_id = {$order_id} and email is not NULL";
		}
		else
			$sql = "SELECT * FROM dtb_order_deliv where order_id = {$order_id} ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_order($customer_id, $page = 1, $where = '', $view = 10, $cancel = false)
	{
		$sql = "SELECT * FROM dtb_order";
		if ($where != '' && $cancel == false)
		{
			$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3 AND ".$where;
		}
		else if ($cancel)
		{
			$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND ".$where;
		}
		else
			$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3 ";
		$order = " ORDER BY create_date DESC ";
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}
	
	public static function get_order_all2($page = 1, $where = '', $view = 25)
	{
		$sql = "SELECT *,case when B.customer_id != 0 then (select email from dtb_customer where customer_id = A.customer_id) else B.email end as customer_email FROM dtb_order as A ";
		$sql .= " JOIN dtb_order_deliv as B ON A.order_id = B.order_id ";
		if ($where != '')
			$where = " WHERE A.del_flg = 0 and (B.customer_id <> 0 or  (B.customer_id = 0 and B.email is not NULL)) ".$where;
//			$where = " WHERE A.del_flg = 0 ".$where;
		else
			$where = " WHERE A.del_flg = 0  and (B.customer_id <> 0 or  (B.customer_id = 0 and B.email is not NULL)) ";
		$order = " group by A.order_id ORDER BY A.create_date DESC ";
//var_dump($sql);
//var_dump($where);
//var_dump($order);
//exit;
		$limit = '';
		if ($view != 0)
		{
			$p = ($page - 1) * $view;
			$limit = " LIMIT {$p},{$view}";
		}
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_order_all3($page = 1, $where = '', $view = 25)
	{
		$tax_rate = TAX_RATE;
		$d = date('Y/m/d');
		$sql = "select A.order_id, case when A.payment_id = 4 then '2' else '0' end as kind, '' as C1, '' as C2, '{$d}', DATE_FORMAT(A.deliv_date,'%Y/%m/%d'),";
		$sql .= "case when A.deliv_time = '午前' then '0812' when A.deliv_time = '14時～16時' then '1416' when A.deliv_time = '16時～18時' then '1618' when A.deliv_time = '18時～20時' then '1820' when A.deliv_time = '19時～21時' then '1921' else '' end as deliv_time,";
		$sql .= "'' as C3, B.tel01, '' as C4, concat(B.zip01,B.zip02) as zip, concat((select name from mtb_pref where id = B.pref),B.addr01) as addr, ";
		$sql .= " B.addr02, '' as company, '' as department, concat(B.name01,' ',B.name02) as name, '' as kana, '' as C6, ";
		$sql .= " '0001', '0367211124', '' as C7, '1500001', '東京都渋谷区神宮前3-35-16', 'ルナーハウスパート4ビル4階', 'B.R.ONLINE', 'ﾋﾞｰｱｰﾙｵﾝﾗｲﾝ', '' as C70, '衣類、靴、アイウェア、香水など' as C71, '' as C8, ";
		$sql .= " case WHEN concat(B.name01,' ',B.name02) = concat(C.name01,' ',C.name02) THEN '' WHEN (A.customer_id = 0 AND (concat(B.name01,' ',B.name02) != concat(D.name01,' ',D.name02))) THEN concat(D.name01,' ',D.name02,' 様からお届けです') WHEN A.customer_id = 0 THEN '' ELSE concat(C.name01,' ',C.name02,' 様からお届けです') END as C9, 'ワレ物注意', ";
		$sql .= " '' as C10, case when A.payment_id = 2 then '★' else '' end as ginko_kind, case when payment_id = 4 then A.payment_total else '' end as collect, ";
		$sql .= " TRUNCATE((A.total+A.deliv_fee)*({$tax_rate}/100),0) as tax, '' as C11, '' as C12, '' as C13, '2' as C14, '0354148885', '' as C15, '01' as C16, ";
		$sql .= " '' as C17,'' as C18,'' as C19,'' as C20,'' as C21,'' as C22,'' as C23,'' as C24,'' as C25,'' as C26,'' as C27,'' as C28,'' as C29,'' as C30,'' as C31,'' as C32,'' as C33,'' as C34,'' as C35,'' as C36,'' as C37,'' as C38,'' as C39,'' as C40,'' as C41,'' as C42,";
		$sql .= "'' as C43,'' as C44,'' as C45,'' as C46,'' as C47,'' as C48,'' as C49,'' as C50,'' as C51,'' as C52,'' as C53,'' as C54,'' as C55,'' as C56,'' as C57,'' as C58,'' as C59,'' as C60,'' as C61,'' as C62,'' as C63,'' as C64,'' as C65,'' as C66,'' as C67,'' as C68 ";
		$sql .= " from dtb_order as A join dtb_order_deliv as B on A.order_id = B.order_id join dtb_customer as C on A.customer_id = C.customer_id OR A.customer_id = 0";
		$sql .= " left join dtb_order_deliv as D on A.order_id = D.order_id and D.email != '' ";
//		$sql .= " from dtb_order as A join (select * from dtb_order_deliv order by id desc) as B on A.order_id = B.order_id ";
		
		if ($where != '')
			$where = " WHERE A.del_flg = 0 and B.id = (select MAX(id) from dtb_order_deliv where order_id = A.order_id) ".$where;
//			$where = " WHERE A.del_flg = 0 ".$where;
		else
			$where = " WHERE A.del_flg = 0  and B.id = (select MAX(id) from dtb_order_deliv where order_id = A.order_id) ";
		$order = " group by A.order_id ORDER BY A.create_date DESC ";
//print("<pre>");
//var_dump($sql);
//var_dump($where);
//var_dump($order);
//print("</pre>");
//exit;
		$limit = '';
		if ($view != 0)
		{
			$p = ($page - 1) * $view;
			$limit = " LIMIT {$p},{$view}";
		}
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_order_all($page = 1, $where = '', $view = 50)
	{
		$sql = "SELECT * FROM dtb_order as A ";
		$sql .= "LEFT JOIN dtb_order_deliv as B ON A.order_id = B.order_id";
		if ($where != '')
			$where = " WHERE A.del_flg = 0 ".$where;
		else
			$where = " WHERE del_flg = 0 ";
		$order = " ORDER BY create_date DESC ";
//var_dump($sql);exit;
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}
	
	public static function get_order_id()
	{
		$cart_ctrl = new Tag_Cartctrl();
		$cart_ctrl->getSession();
		
		$cart = serialize($cart_ctrl->cart);

		$c = htmlspecialchars($cart, ENT_QUOTES);
		$sql = "INSERT INTO dtb_order_temp (cart_data,session_id) values ('{$c}', '{$_SESSION['TRANSACTION_ID']}')";
		$query = DB::query($sql);
		$ret = $query->execute();
		return $ret[0];
	}

	public static function set_order($res = '')
	{
		$cart_ctrl = new Tag_Cartctrl();
		$cart_ctrl->getSession();

		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$sale_flg = 0;
		$vip_sale_flg = 0;
		$sale_par = 0;

		if ($start_date <= $now && $end_date >= $now)
		{
			$sale_flg = 1;
			$sale_par = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$vip_sale_flg = 1;
			$sale_par = $arrSales['vip_sale'];
		}


		$query = DB::insert('dtb_order');
		$arrOrder = array();
		$arrOrder['order_id'] = $cart_ctrl->cart->getOrderId();
		$arrOrder['customer_id'] = $cart_ctrl->cart->getMemberId();

		$arrOrder['customer_sale_status'] = 0;
		if ($cart_ctrl->cart->getMemberId() != 0)
		{
			$customer = Tag_CustomerInfo::get_customer($cart_ctrl->cart->getMemberId());
			if ($sale_flg == 1 && $customer['sale_status'] == 1)
				$arrOrder['customer_sale_status'] = $customer['sale_status'];
			else if ($vip_sale_flg == 1 && $customer['sale_status'] == 2)
				$arrOrder['customer_sale_status'] = $customer['sale_status'];
		}

		$arrOrder['payment_id'] = $cart_ctrl->cart->getPaymentType();
		$arrOrder['total'] = $cart_ctrl->cart->getTotalPrice();
		$arrOrder['tax'] = $cart_ctrl->cart->getTotalTax();
		$arrOrder['payment_total'] = $cart_ctrl->cart->getTotalPricePaymentWithTax();
		$arrOrder['coupon'] = $cart_ctrl->cart->getCouponCd();
//var_dump($cart_ctrl->cart->getTotalPricePayment(false));
//var_dump($cart_ctrl->cart->getTotalPricePayment());
//exit;
		$arrOrder['discount'] = $cart_ctrl->cart->getTotalPricePayment(false) - $cart_ctrl->cart->getTotalPricePayment();
		if ($sale_flg || $vip_sale_flg)
			$arrOrder['discount'] = Tag_Util::taxin_cal($arrOrder['discount']);
		$arrOrder['memo'] = $cart_ctrl->cart->getMsgContact();
		$arrOrder['msg_card'] = $cart_ctrl->cart->getMsgCardDtl();
		$arrOrder['card'] = $cart_ctrl->cart->getMsgCard();
		$arrOrder['receipt_tadashi'] = $cart_ctrl->cart->getReceiptTadashi();
		$arrOrder['add_point'] = $cart_ctrl->cart->getTotalPoint();
		$arrOrder['use_point'] = $cart_ctrl->cart->getPointUse();
		$arrOrder['payment_memo'] = serialize($res);
		$arrOrder['deliv_id'] = 1;
		if ($cart_ctrl->cart->getDelivDate() != '')
			$arrOrder['deliv_date'] = date('Y-m-d', strtotime($cart_ctrl->cart->getDelivDate()));
		else
			$arrOrder['deliv_date'] = null;
		if ($cart_ctrl->cart->getDelivTime() != '')
			$arrOrder['deliv_time'] = $cart_ctrl->cart->getDelivTime();
		else
			$arrOrder['deliv_time'] = '';
		$arrOrder['deliv_fee'] = $cart_ctrl->cart->getDelivFee();
		$arrOrder['fee'] = $cart_ctrl->cart->getFee();
		$arrOrder['gift'] = $cart_ctrl->cart->getLapping();
		if ($cart_ctrl->cart->getLapping() == '1')
			$arrOrder['gift_price'] = 300;
		else
			$arrOrder['gift_price'] = 0;
		$arrOrder['packing'] = $cart_ctrl->cart->getSimplePackage();
		$arrOrder['recepit_atena'] = $cart_ctrl->cart->getReceiptName();
		$arrOrder['detail_statement'] = $cart_ctrl->cart->getSpecification();
		$arrOrder['customer_deliv_id'] = $cart_ctrl->cart->getCustomerDelivId();
		
		$query->set($arrOrder);
		$query->execute();

		$customer_id = $cart_ctrl->cart->getMemberId();

		if ($customer_id != 0)
		{
		 	$order_id = $cart_ctrl->cart->getOrderId();
			if ($cart_ctrl->cart->getPointUse() > 0)
			{
				$point = $cart_ctrl->cart->getPointUse();
				Tag_CustomerInfo::set_use_point($customer_id, $point);
				$point = $point  * -1;
			 	$status = POINT_LOG_USE;
				Tag_Point::set_point($customer_id, $point, $status, $order_id);
				$cust_ctrl = new Tag_customerctrl();
				$cust_ctrl->getSession();
				$cus_point = $cust_ctrl->customer->getPoint();
				$cus_point -= $cart_ctrl->cart->getPointUse();
				$cust_ctrl->customer->setPoint($cus_point);
				$cust_ctrl->setSession();
			}
			$point = $cart_ctrl->cart->getTotalPoint();
		 	$status = POINT_LOG_ISSUE;
			Tag_Point::set_point($customer_id, $point, $status, $order_id);
			Tag_Point::set_temp_point($customer_id, $order_id, $point);
		}

		$detail = $cart_ctrl->cart->getOrderDetail();
//		$query = DB::insert('dtb_order_detail');
		$c = 1;
		foreach($detail as $d)
		{
			$query = DB::insert('dtb_order_detail');
			$arrDetail = array();
			$arrDetail['order_id'] = $cart_ctrl->cart->getOrderId();
			$arrDetail['order_detail_id'] =$c++;
			$arrDetail['product_id'] = $d->getProductId();
			$arrDetail['product_name'] = $d->getName();
			$arrDetail['product_code'] = $d->getProductCode();
			$arrDetail['size_name'] = $d->getSize();
			$arrDetail['size_code'] = $d->getSizeCode();
			$arrDetail['color_name'] = $d->getColor();
			$arrDetail['color_code'] = $d->getColorCode();
			$arrDetail['price'] = $d->getPrice();
			$arrDetail['quantity'] = $d->getQuantity();
			$arrDetail['shop_id'] = $d->getShop();
			$arrDetail['org_shop'] = $d->getOrgShop();
			$arrDetail['point_rate'] = $d->getPointRate();
			$arrDetail['sale_status'] = $d->getSaleStatus();
			$arrDetail['sale_rate'] = $d->getSaleRate();
			$arrDetail['reservation_flg'] = $d->getReservation();
			$query->set($arrDetail);
			$query->execute();
			$query->reset();

			Log::debug(var_export($d, true));
			$stock = ($d->getQuantity()*-1);
			Log::debug("stock(".$arrDetail['product_code']."):".$stock);
			Tag_Item::setStock($d->getProductId(), $d->getProductCode(), $d->getColorCode(), $d->getSizeCode(), $stock);
		}

		$query = DB::insert('dtb_order_deliv');
		$arrOrderDeliv = array();
		$arrOrderDeliv['customer_id'] = $cart_ctrl->cart->getMemberId();
		$arrOrderDeliv['name01'] = $cart_ctrl->cart->getCustomerName();
		$arrOrderDeliv['name02'] = $cart_ctrl->cart->getCustomerName2();
		$arrOrderDeliv['kana01'] = $cart_ctrl->cart->getCustomerKana();
		$arrOrderDeliv['kana02'] = $cart_ctrl->cart->getCustomerKana2();
		$arrOrderDeliv['zip01'] = $cart_ctrl->cart->getZip();
		$arrOrderDeliv['zip02'] = $cart_ctrl->cart->getZip2();
		$arrOrderDeliv['pref'] = $cart_ctrl->cart->getPref();
		$arrOrderDeliv['addr01'] = $cart_ctrl->cart->getAddress();
		$arrOrderDeliv['addr02'] = $cart_ctrl->cart->getAddress2();
		$arrOrderDeliv['tel01'] = $cart_ctrl->cart->getTelNumber();
		$arrOrderDeliv['company'] = $cart_ctrl->cart->getCompany();
		$arrOrderDeliv['department'] = $cart_ctrl->cart->getSection();
		$arrOrderDeliv['email'] = $cart_ctrl->cart->getCustomerEmail();
		$arrOrderDeliv['order_id'] = $cart_ctrl->cart->getOrderId();
		$query->set($arrOrderDeliv);
		$query->execute();

		if ($cart_ctrl->cart->getMemberId() == 0 && $cart_ctrl->cart->getOtherFlg())
		{
		$query = DB::insert('dtb_order_deliv');
		$arrOrderDeliv = array();
		$arrOrderDeliv['customer_id'] = $cart_ctrl->cart->getMemberId();
		$arrOrderDeliv['name01'] = $cart_ctrl->cart->getOtherName();
		$arrOrderDeliv['name02'] = $cart_ctrl->cart->getOtherName2();
		$arrOrderDeliv['kana01'] = $cart_ctrl->cart->getOtherKana();
		$arrOrderDeliv['kana02'] = $cart_ctrl->cart->getOtherKana2();
		$arrOrderDeliv['zip01'] = $cart_ctrl->cart->getOtherZip();
		$arrOrderDeliv['zip02'] = $cart_ctrl->cart->getOtherZip2();
		$arrOrderDeliv['pref'] = $cart_ctrl->cart->getOtherPref();
		$arrOrderDeliv['addr01'] = $cart_ctrl->cart->getOtherAddress();
		$arrOrderDeliv['addr02'] = $cart_ctrl->cart->getOtherAddress2();
		$arrOrderDeliv['tel01'] = $cart_ctrl->cart->getOtherTelNumber();
		$arrOrderDeliv['company'] = $cart_ctrl->cart->getOtherCompany();
		$arrOrderDeliv['department'] = $cart_ctrl->cart->getOtherSection();
//		$arrOrderDeliv['email'] = $cart_ctrl->cart->getCustomerEmail();
		$arrOrderDeliv['order_id'] = $cart_ctrl->cart->getOrderId();
		$query->set($arrOrderDeliv);
		$query->execute();
		}

		if ($arrOrder['coupon'] != '')
		{
			$email = $cart_ctrl->cart->getCustomerEmail();
			if ($email == '')
			{
				$email = $customer['email'];
			}
			$sql = "INSERT INTO dtb_buylog (mail,customer_id,coupon_code) values ('{$email}', '{$customer_id}', '{$arrOrder['coupon']}')";
			$query = DB::query($sql);
			$ret = $query->execute();
		}

		return true;
	}

	public static function set_new_order($order = array())
	{
		$query = DB::insert('dtb_order_temp');
		$query->set(array());
		$ret = $query->execute();

		$order_id = $ret[0];

		$arrDetail = array();
		$query = DB::insert('dtb_order');
		$arrOrder = array();
		$arrOrder['order_id'] = $order_id;
		$arrOrder['customer_id'] = $order['customer_id'];
		$arrOrder['payment_id'] = $order['payment_id'];
		$arrOrder['total'] = $order['subtotal_a'];
		if (isset($order['use_point']) && $order['use_point'] != '')
			$arrOrder['payment_total'] = $order['payment_total']-$order['use_point'];
		else
			$arrOrder['payment_total'] = $order['payment_total'];
		$arrOrder['coupon'] = '';
		if ($order['discount'] == '')
			$order['discount'] = 0;
		$arrOrder['discount'] = $order['discount'];
//		if ($order['use_point'] != '')
//			$arrOrder['discount'] = $order['use_point'];
		$arrOrder['memo'] = '';
		$arrOrder['msg_card'] = $order['msg_card'];
		$arrOrder['card'] = $order['card'];
		$arrOrder['receipt_tadashi'] = $order['receipt_tadashi'];
		$arrOrder['add_point'] = $order['add_point'];
		if ($order['use_point'] == '')
			$order['use_point'] = 0;
		$arrOrder['use_point'] = $order['use_point'];
		$arrOrder['payment_memo'] = '';
		$arrOrder['deliv_id'] = 1;
		if ($order['deliv_date'] != '')
			$arrOrder['deliv_date'] = $order['deliv_date'];
		$arrOrder['deliv_time'] = $order['deliv_time'];
		if ($order['deliv_fee'] != '')
			$arrOrder['deliv_fee'] = $order['deliv_fee'];
		if ($order['fee'] != '')
			$arrOrder['fee'] = $order['fee'];
		$arrOrder['gift'] = $order['gift'];
		if ($order['gift_price'] != '')
			$arrOrder['gift_price'] = $order['gift_price'];
		$arrOrder['packing'] = $order['packing'];
		$arrOrder['recepit_atena'] = $order['recepit_atena'];
		$arrOrder['detail_statement'] = $order['detail_statement'];
		$arrOrder['customer_deliv_id'] = 0;//$order['customer_deliv_id'];

		$tax = 0;
		$discount = $arrOrder['discount'];
		if ($discount == '')
			$discount = 0;
		$subtotal_price = 0;
		if (!isset($order['arrProduct']))
			$order['arrProduct'] = array();
		foreach($order['arrProduct'] as $product_code=>$val)
		{
			$quantity = $val['quantity'];
			$arrProduct = Tag_Item::get_product_sku($product_code);
			$arrProduct['quantity'] = $quantity;
			$subtotal = $arrProduct['price01'] * $quantity;
//			if ($subtotal - $discount >= 0)
//			{
//				$subtotal -= $discount;
//				$discount = 0;
//			}
//			else
//			{
//				$subtotal = 0;
//				$discount -= $subtotal;
//			}
			$subtotal_price += $subtotal;

			$tax += Tag_Util::tax_cal($subtotal);
			$arrDetail[] = $arrProduct;
		}
		if ($order['fee'] == '')
			$order['fee'] = 0;
		if ($order['gift_price'] == '')
			$order['gift_price'] = 0;
		if ($order['deliv_fee'] == '')
			$order['deliv_fee'] = 0;
		$arrOrder['tax'] = $tax + Tag_Util::tax_cal($order['fee']) + Tag_Util::tax_cal($order['gift_price']) + Tag_Util::tax_cal($order['deliv_fee']);
		
		$query->set($arrOrder);
		$ret = $query->execute();
//		$order_id = $ret[0];
// var_dump($ret);
// exit;
		$customer_id = $order['customer_id'];

		if ($customer_id != 0)
		{
//		 	$order_id = $cart_ctrl->cart->getOrderId();
			if ($order['use_point'] > 0)
			{
				$point = $order['use_point'];
				Tag_CustomerInfo::set_use_point($customer_id, $point);
				$point = $point  * -1;
			 	$status = POINT_LOG_USE;
				Tag_Point::set_point($customer_id, $point, $status, $order_id);
			}
			$point = $order['add_point'];
		 	$status = POINT_LOG_ISSUE;
			Tag_Point::set_point($customer_id, $point, $status, $order_id);
			Tag_Point::set_temp_point($customer_id, $order_id, $point);
		}

		$c = 1;
		foreach($arrDetail as $d)
		{
			$query = DB::insert('dtb_order_detail');
			$arrDetail = array();
			$arrDetail['order_id'] = $order_id;
			$arrDetail['order_detail_id'] = $c++;
			$arrDetail['product_id'] = $d['product_id'];
			$arrDetail['product_name'] = $d['name'];
			$arrDetail['product_code'] = $d['product_code'];
			$arrDetail['size_name'] = $d['size_name'];
			$arrDetail['size_code'] = $d['size_code'];
			$arrDetail['color_name'] = $d['color_name'];
			$arrDetail['color_code'] = $d['color_code'];
			$arrDetail['price'] = $d['price01'];
			$arrDetail['quantity'] = $d['quantity'];
			$arrDetail['shop_id'] = $d['shop_url'];
//			$arrDetail['org_shop'] = $d['shop_url'];
			$arrDetail['point_rate'] = $d['point_rate'];
			if (!isset($d['sale_status']))
				$d['sale_status'] = 0;
			$arrDetail['sale_status'] = $d['sale_status'];
			if (!isset($d['sale_rate']))
				$d['sale_rate'] = 0;
			$arrDetail['sale_rate'] = $d['sale_rate'];
			$query->set($arrDetail);
			$query->execute();
			$query->reset();

			Log::debug(var_export($d, true));
			$stock = ($d['quantity'] * -1);
			Log::debug("stock(".$arrDetail['product_code']."):".$stock);
			Tag_Item::setStock($d['product_id'], $d['product_code'], $d['color_code'], $d['size_code'], $stock);
		}

		if ($customer_id != 0)
		{
			$query = DB::insert('dtb_order_deliv');
			$arrOrderDeliv = array();
			$arrOrderDeliv['customer_id'] = $customer_id;
//var_dump($order);
//exit;
			if ($order['deliv_name01'] != '')
				$arrOrderDeliv['name01'] = $order['deliv_name01'];
			else
				$arrOrderDeliv['name01'] = $order['name01'];
			if ($order['deliv_name02'] != '')
				$arrOrderDeliv['name02'] = $order['deliv_name02'];
			else
				$arrOrderDeliv['name02'] = $order['name02'];
			if ($order['deliv_kana01'] != '')
				$arrOrderDeliv['kana01'] = $order['deliv_kana01'];
			else
				$arrOrderDeliv['kana01'] = $order['kana01'];
			if ($order['deliv_kana02'] != '')
				$arrOrderDeliv['kana02'] = $order['deliv_kana02'];
			else
				$arrOrderDeliv['kana02'] = $order['kana02'];
	
			if ($order['deliv_zip01'] != '')
				$arrOrderDeliv['zip01'] = $order['deliv_zip01'];
			else
				$arrOrderDeliv['zip01'] = $order['zip01'];
			if ($order['deliv_zip02'] != '')
				$arrOrderDeliv['zip02'] = $order['deliv_zip02'];
			else
				$arrOrderDeliv['zip02'] = $order['zip02'];
			if ($order['deliv_pref'] != '')
				$arrOrderDeliv['pref'] = $order['deliv_pref'];
			else
				$arrOrderDeliv['pref'] = $order['pref'];
			if ($order['deliv_addr01'] != '')
				$arrOrderDeliv['addr01'] = $order['deliv_addr01'];
			else
				$arrOrderDeliv['addr01'] = $order['addr01'];
			if ($order['deliv_addr02'] != '')
				$arrOrderDeliv['addr02'] = $order['deliv_addr02'];
			else
				$arrOrderDeliv['addr02'] = $order['addr02'];
			if ($order['deliv_tel01'] != '')
				$arrOrderDeliv['tel01'] = $order['deliv_tel01'];
			else
				$arrOrderDeliv['tel01'] = $order['tel01'];
			if ($order['deliv_tel01'] != '')
				$arrOrderDeliv['tel01'] = $order['deliv_tel01'];
			else
				$arrOrderDeliv['tel01'] = $order['tel01'];
			$arrOrderDeliv['email'] =$order['email'];
			$arrOrderDeliv['order_id'] = $order_id;
	
			$query->set($arrOrderDeliv);
			$query->execute();
		}
		else
		{
			$query = DB::insert('dtb_order_deliv');
			$arrOrderDeliv = array();
			$arrOrderDeliv['customer_id'] = $customer_id;
			$arrOrderDeliv['name01'] = $order['name01'];
			$arrOrderDeliv['name02'] = $order['name02'];
			$arrOrderDeliv['kana01'] = $order['kana01'];
			$arrOrderDeliv['kana02'] = $order['kana02'];
			$arrOrderDeliv['zip01'] = $order['zip01'];
			$arrOrderDeliv['zip02'] = $order['zip02'];
			$arrOrderDeliv['pref'] = $order['pref'];
			$arrOrderDeliv['addr01'] = $order['addr01'];
			$arrOrderDeliv['addr02'] = $order['addr02'];
			$arrOrderDeliv['tel01'] = $order['tel01'];
			$arrOrderDeliv['email'] =$order['email'];
			$arrOrderDeliv['order_id'] = $order_id;
	
			$query->set($arrOrderDeliv);
			$query->execute();

			$query2 = DB::insert('dtb_order_deliv');
			$arrOrderDeliv2 = array();
			$arrOrderDeliv2['customer_id'] = $customer_id;
			$arrOrderDeliv2['name01'] = $order['deliv_name01'];
			$arrOrderDeliv2['name02'] = $order['deliv_name02'];
			$arrOrderDeliv2['kana01'] = $order['deliv_kana01'];
			$arrOrderDeliv2['kana02'] = $order['deliv_kana02'];
			$arrOrderDeliv2['zip01'] = $order['deliv_zip01'];
			$arrOrderDeliv2['zip02'] = $order['deliv_zip02'];
			$arrOrderDeliv2['pref'] = $order['deliv_pref'];
			$arrOrderDeliv2['addr01'] = $order['deliv_addr01'];
			$arrOrderDeliv2['addr02'] = $order['deliv_addr02'];
			$arrOrderDeliv2['tel01'] = $order['deliv_tel01'];
			$arrOrderDeliv2['tel01'] = $order['deliv_tel01'];
			$arrOrderDeliv2['email'] = NULL;
			$arrOrderDeliv2['order_id'] = $order_id;
			$query2->set($arrOrderDeliv2);
			$query2->execute();
		}
		

		return $order_id;
	}

	public static function get_history_order_count($customer_id)
	{
		$sql = "SELECT * FROM dtb_history_order";
		$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3";
		$order = " ORDER BY create_date DESC ";
		$query = DB::query($sql.$where.$order);
		$arrRet = $query->execute()->as_array();

		return count($arrRet);		
	}

	public static function get_history_order($customer_id, $page = 1, $where = '', $view = 10)
	{
		$sql = "SELECT * FROM dtb_history_order";
		if ($where != '')
			$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3 AND ".$where;
		else
			$where = " WHERE customer_id = {$customer_id} AND del_flg = 0 AND status <> 3 ";
		$order = " ORDER BY create_date DESC ";
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
		
//		var_dump($sql.$where.$order.$limit);
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_history_order_detail($order_id)
	{
		$sql = "SELECT * FROM dtb_history_order_detail";
		$where = " WHERE order_id = ".$order_id;
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();

		return $arrRet;
	}
}

<?php

class Tag_Mail
{
	function __construct()
	{
	}

    public static function order_mail_crossmall($cart, $order_id, $shop = 'guji')
	{
        $arrOrder = Tag_Order::get_order($cart->getMemberId(), 1, " order_id = {$order_id} ");
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrCrossmall = Tag_Cartctrl::get_shop_mail($shop);

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id']);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					Log::debug("switch_property:".$detail['switch_property']);
					if ($detail['switch_property'] == 1)
					{
						$size = $od['size_name'];
						$color = $od['color_name'];
						$od['size_name'] = $color;
						$od['color_name'] = $size;
					}
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$od['size_name'] = mb_ereg_replace('〜','〜', $od['size_name']);
			$od['color_name'] = mb_ereg_replace('〜','〜', $od['color_name']);
			
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$registData = array();
		$registData['arrProduct'] = $arrOrderDetail;
		$registData['subtotal'] = $subtotal;
		$registData['order_id'] = $order_id;
		$registData['create_date'] = $arrOrder['create_date'];
		$registData['tax'] = $tax;
		$registData['total'] = $subtotal+$tax;
		$arrResult['registData'] = $registData;

		if ($shop == 'guji')
			$tpl = 'smarty/email/order_crossmall_mail.tpl';
		else if ($shop == 'altoediritto')
			$tpl = 'smarty/email/order_crossmall_mail_alto.tpl';
		else
			$tpl = 'smarty/email/order_crossmall_mail_ring.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrCrossmall['notify_email']);
Log::debug($arrCrossmall['notify_email']);
		$email->to($to);
		$email->subject("BR在庫連動");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}

    public static function order_mail_crossmall_admin($customer_id, $order_id, $shop = 'guji')
	{
        $arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrCrossmall = Tag_Cartctrl::get_shop_mail($shop);

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id']);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					Log::debug("switch_property:".$detail['switch_property']);
					if ($detail['switch_property'] == 1)
					{
						$size = $od['size_name'];
						$color = $od['color_name'];
						$od['size_name'] = $color;
						$od['color_name'] = $size;
					}
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$od['size_name'] = mb_ereg_replace('〜','〜', $od['size_name']);
			$od['color_name'] = mb_ereg_replace('〜','〜', $od['color_name']);
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$registData = array();
		$registData['arrProduct'] = $arrOrderDetail;
		$registData['subtotal'] = $subtotal;
		$registData['order_id'] = $order_id;
		$registData['create_date'] = $arrOrder['create_date'];
		$registData['tax'] = $tax;
		$registData['total'] = $subtotal+$tax;
		$arrResult['registData'] = $registData;

		if ($shop == 'guji')
			$tpl = 'smarty/email/order_crossmall_mail.tpl';
		else if ($shop == 'altoediritto')
			$tpl = 'smarty/email/order_crossmall_mail_alto.tpl';
		else
			$tpl = 'smarty/email/order_crossmall_mail_ring.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrCrossmall['notify_email']);
Log::debug($arrCrossmall['notify_email']);
		$email->to($to);
		$email->subject("BR在庫連動");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}


	public static function order_mail_crossmall_order_id($order_id, $shop = 'guji')
	{

		$order = Tag_Order::get_order_info($order_id);
		if( $order == "") {
			return false;
		}

		$customer_id = $order[0]["customer_id"];

		$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
		$arrOrder = $arrOrder[0];
		$arrOrderDetail = Tag_Order::get_order_detail($order_id);
		$arrCrossmall = Tag_Cartctrl::get_shop_mail($shop);

		$arrTemp = array();
		$subtotal = 0;
		$tax = 0;
		foreach($arrOrderDetail as $od)
		{
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
				$od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
				$details = Tag_Item::get_detail_sku($od['product_id'],true);

				$detail = Tag_Item::get_detail($od['product_id']);
				$brands = Tag_Item::get_brand(true);
				foreach($details as $d)
				{
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
						Log::debug("switch_property:".$detail['switch_property']);
						if ($detail['switch_property'] == 1)
						{
							$size = $od['size_name'];
							$color = $od['color_name'];
							$od['size_name'] = $color;
							$od['color_name'] = $size;
						}
						//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
						break;
					}
				}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
				$od['size_name'] = mb_ereg_replace('〜','〜', $od['size_name']);
				$od['color_name'] = mb_ereg_replace('〜','〜', $od['color_name']);
				$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
			$arrOrderDetail = $arrTemp;
			$registData = array();
			$registData['arrProduct'] = $arrOrderDetail;
			$registData['subtotal'] = $subtotal;
			$registData['order_id'] = $order_id;
			$registData['create_date'] = $arrOrder['create_date'];
			$registData['tax'] = $tax;
			$registData['total'] = $subtotal+$tax;
			$arrResult['registData'] = $registData;

			if ($shop == 'guji')
				$tpl = 'smarty/email/order_crossmall_mail.tpl';
			else if ($shop == 'altoediritto')
				$tpl = 'smarty/email/order_crossmall_mail_alto.tpl';
			else
				$tpl = 'smarty/email/order_crossmall_mail_ring.tpl';

					$email = Email::forge();
					$email->header('Content-Transfer-Encoding', 'base64');
					$email->from(ORDER_MAIL_FROM);
					$to = explode(',', $arrCrossmall['notify_email']);
					Log::debug($arrCrossmall['notify_email']);
					$email->to($to);
					$email->subject("BR在庫連動");
					$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

					// 		// メール送信（管理者宛て）
					// 		$tpl = 'smarty/email/order_mail.tpl';
					//
					// 		$email = Email::forge();
					// 		$email->from(ORDER_MAIL_FROM);
					// 		$email->to(ORDER_MAIL_TO_ADMIN);
					// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
					// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
					// 		$email->send();

					return true;
	}



    public static function order_mail_shopmail($cart, $order_id, $shop = '')
	{
    	Log::debug('order_mail_shopmail');
        $arrOrder = Tag_Order::get_order($cart->getMemberId(), 1, " order_id = {$order_id} ");
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrShop = Tag_Cartctrl::get_shop_mail($shop);
// var_dump($shop);
// var_dump($arrShop);
// exit;
        if ($arrShop['email'] == ''/* || $arrShop['shop_id'] == 'brshop'*/)
        	return;

		$arrResult['customer_sale_status'] = 0;
		if ($cart->getMemberId() != 0)
		{
			$customer = Tag_CustomerInfo::get_customer($cart->getMemberId());
			$arrResult['arrCustomer'] = $customer;
			$arrResult['customer_sale_status'] = $customer['sale_status'];
		}

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id']);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					$od['price02'] = '';
					$od['shop_name'] = $arrShop['shop_name'];
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$arrResult['arrShopData'] = $arrOrderDetail;
        $arrResult['arrOrderDetail'] = $arrOrderDetail;

		$arrOrder['tax_in'] = TAX_RATE;
		$arrOrder['subtotal'] = $subtotal;
		$arrOrder['tax'] = $tax;
		$arrOrder['shop_name'] = $arrShop['shop_name'];
		$arrOrder['shop_id'] = $arrShop['shop_id'];
		$arrOrder['total'] = $subtotal+$tax;
		$arrResult['arrOrder'] = $arrOrder;

		$tpl = 'smarty/email/order_shop_mail.tpl';
// var_dump($arrOrderDetail);
// exit;

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrShop['email']);
		$email->to($to);
		$email->subject('受注番号:'.$order_id.' '."在庫確認メール");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}

    public static function order_mail_shopmail_admin($customer_id, $order_id, $shop = '', $cancel = false)
	{
    	Log::debug('order_mail_shopmail');
        $arrOrder = Tag_Order::get_order_info($order_id);
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrShop = Tag_Cartctrl::get_shop_mail($shop);
// var_dump($shop);
// var_dump($arrShop);
// exit;
        if ($arrShop['email'] == '' || $arrShop['shop_id'] == 'brshop')
        	return;

//		$arrResult['customer_sale_status'] = 0;
//		if ($customer_id != 0)
//		{
//			$customer = Tag_CustomerInfo::get_customer($customer_id);
//			$arrResult['customer_sale_status'] = $customer['sale_status'];
//		}

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id'], true);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					$od['price02'] = '';
					$od['shop_name'] = $arrShop['shop_name'];
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$arrResult['arrShopData'] = $arrOrderDetail;
        $arrResult['arrOrderDetail'] = $arrOrderDetail;

		$arrOrder['tax_in'] = TAX_RATE;
		$arrOrder['subtotal'] = $subtotal;
		$arrOrder['tax'] = $tax;
		$arrOrder['shop_name'] = $arrShop['shop_name'];
		$arrOrder['shop_id'] = $arrShop['shop_id'];
		$arrOrder['total'] = $subtotal+$tax;
		$arrResult['arrOrder'] = $arrOrder;

		$tpl = 'smarty/email/order_shop_mail.tpl';
// var_dump($arrOrderDetail);
// exit;

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrShop['email']);
		$email->to($to);
		if ($cancel)
			$email->subject('受注番号:'.$order_id.' '."キャンセル（在庫戻し）メール");
		else
			$email->subject('受注番号:'.$order_id.' '."在庫確認メール");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}


	public static function order_mail_shopmail_order_id($order_id, $shop = '')
	{
		Log::debug('order_mail_shopmail');

		$order = Tag_Order::get_order_info($order_id);
		if( $order == "") {
			return false;
		}

		$customer_id = $order[0]["customer_id"];
		$arrResult['customer_sale_status'] = 0;
		if ($customer_id != 0)
		{
			$customer = Tag_CustomerInfo::get_customer($customer_id);
			$arrResult['customer_sale_status'] = $customer['sale_status'];
		}

		$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
		$arrOrder = $arrOrder[0];
		$arrOrderDetail = Tag_Order::get_order_detail($order_id);

		$arrShop = Tag_Cartctrl::get_shop_mail($shop);
		// var_dump($shop);
		// var_dump($arrShop);
		// exit;
		if ($arrShop['email'] == '' || $arrShop['shop_id'] == 'brshop')
			return;

			$arrTemp = array();
			$subtotal = 0;
			$tax = 0;
			foreach($arrOrderDetail as $od)
			{
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
					$od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
					$details = Tag_Item::get_detail_sku($od['product_id'],true);

					$detail = Tag_Item::get_detail($od['product_id']);
					$brands = Tag_Item::get_brand(true);
					foreach($details as $d)
					{
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
							$od['price02'] = '';
							$od['shop_name'] = $arrShop['shop_name'];
							//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
							break;
						}
					}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
					$arrTemp[] = $od;
			}
			if (count($arrTemp) == 0)
				return;
				$arrOrderDetail = $arrTemp;
				$arrResult['arrShopData'] = $arrOrderDetail;
		        $arrResult['arrOrderDetail'] = $arrOrderDetail;

				$arrOrder['tax_in'] = TAX_RATE;
				$arrOrder['subtotal'] = $subtotal;
				$arrOrder['tax'] = $tax;
				$arrOrder['shop_name'] = $arrShop['shop_name'];
				$arrOrder['shop_id'] = $arrShop['shop_id'];
				$arrOrder['total'] = $subtotal+$tax;
				$arrResult['arrOrder'] = $arrOrder;

				$tpl = 'smarty/email/order_shop_mail.tpl';
				// var_dump($arrOrderDetail);
				// exit;

				$email = Email::forge();
				$email->header('Content-Transfer-Encoding', 'base64');
				$email->from(ORDER_MAIL_FROM);
				$to = explode(',', $arrShop['email']);
				$email->to($to);
				$email->subject('受注番号:'.$order_id.' '."在庫確認メール");
				$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

				// 		// メール送信（管理者宛て）
				// 		$tpl = 'smarty/email/order_mail.tpl';
				//
				// 		$email = Email::forge();
				// 		$email->from(ORDER_MAIL_FROM);
				// 		$email->to(ORDER_MAIL_TO_ADMIN);
				// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
				// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
				// 		$email->send();

				return true;
	}



   public static function order_mail_nextmail($cart, $order_id, $shop = '')
	{
    	Log::debug('order_mail_nextmail');
        $arrOrder = Tag_Order::get_order($cart->getMemberId(), 1, " order_id = {$order_id} ");
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrShop = Tag_Cartctrl::get_shop_mail($shop);
// var_dump($shop);
// var_dump($arrShop);
// exit;
        if ($arrShop == '' || $arrShop['email'] == '' || $arrShop['shop_id'] == 'brshop')
        	return;

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id']);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					$od['price02'] = '';
					$od['shop_name'] = $arrShop['shop_name'];
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$arrResult['arrShopData'] = $arrOrderDetail;

		$arrOrder['tax_in'] = TAX_RATE;
		$arrOrder['subtotal'] = $subtotal;
		$arrOrder['tax'] = $tax;
		$arrOrder['shop_name'] = $arrShop['shop_name'];
		$arrOrder['shop_id'] = $arrShop['shop_id'];
		$arrOrder['total'] = $subtotal+$tax;
		$arrResult['arrOrder'] = $arrOrder;

		$tpl = 'smarty/email/next_order_mail.tpl';
// var_dump($arrOrderDetail);
// exit;


		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrShop['notify_email']);
		$email->to($to);
		$email->subject("NE受注取り込み用メール");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}

   public static function order_mail_nextmail_admin($customer_id, $order_id, $shop = '')
	{
    	Log::debug('order_mail_nextmail');
        $arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
        $arrShop = Tag_Cartctrl::get_shop_mail($shop);
// var_dump($shop);
// var_dump($arrShop);
// exit;
        if ($arrShop == '' || $arrShop['email'] == '' || $arrShop['shop_id'] == 'brshop')
        	return;

        $arrTemp = array();
        $subtotal = 0;
        $tax = 0;
        foreach($arrOrderDetail as $od)
        {
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
	        $od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
			$details = Tag_Item::get_detail_sku($od['product_id'],true);

			$detail = Tag_Item::get_detail($od['product_id']);
			$brands = Tag_Item::get_brand(true);
			foreach($details as $d)
			{
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
					$od['price02'] = '';
					$od['shop_name'] = $arrShop['shop_name'];
//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
					break;
				}
			}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
			$arrTemp[] = $od;
		}
		if (count($arrTemp) == 0)
			return;
		$arrOrderDetail = $arrTemp;
		$arrResult['arrShopData'] = $arrOrderDetail;

		$arrOrder['tax_in'] = TAX_RATE;
		$arrOrder['subtotal'] = $subtotal;
		$arrOrder['tax'] = $tax;
		$arrOrder['shop_name'] = $arrShop['shop_name'];
		$arrOrder['shop_id'] = $arrShop['shop_id'];
		$arrOrder['total'] = $subtotal+$tax;
		$arrResult['arrOrder'] = $arrOrder;

		$tpl = 'smarty/email/next_order_mail.tpl';
// var_dump($arrOrderDetail);
// exit;


		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$to = explode(',', $arrShop['notify_email']);
		$email->to($to);
		$email->subject("NE受注取り込み用メール");
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

// 		// メール送信（管理者宛て）
// 		$tpl = 'smarty/email/order_mail.tpl';
//
// 		$email = Email::forge();
// 		$email->from(ORDER_MAIL_FROM);
// 		$email->to(ORDER_MAIL_TO_ADMIN);
// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
// 		$email->send();

		return;
	}



	public static function order_mail_nextmail_order_id($order_id, $shop = '')
	{
		Log::debug('order_mail_nextmail');

		$order = Tag_Order::get_order_info($order_id);
		if( $order == "") {
			return false;
		}

		$customer_id = $order[0]["customer_id"];

		$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
		$arrOrder = $arrOrder[0];
		$arrOrderDetail = Tag_Order::get_order_detail($order_id);

		$arrShop = Tag_Cartctrl::get_shop_mail($shop);
		// var_dump($shop);
		// var_dump($arrShop);
		// exit;
		if ($arrShop == '' || $arrShop['email'] == '' || $arrShop['shop_id'] == 'brshop')
			return;

			$arrTemp = array();
			$subtotal = 0;
			$tax = 0;
			foreach($arrOrderDetail as $od)
			{
        	if ($od['org_shop'] == $shop)
        	{
        	}
        	else
        	{
	        	if ($shop != $od['shop_id'])
    	    		continue;
    	    	if ($od['org_shop'] != $shop && $od['org_shop'] != '')
    	    		continue;
    	    }
					$od['shop_name'] = Tag_Item::get_shop($od['shop_id']);
					$details = Tag_Item::get_detail_sku($od['product_id'],true);

					$detail = Tag_Item::get_detail($od['product_id']);
					$brands = Tag_Item::get_brand(true);
					foreach($details as $d)
					{
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
							$od['price02'] = '';
							$od['shop_name'] = $arrShop['shop_name'];
							//					$od['product_url_id'] = 'https://'.DOMAIN.'/mall/'.$od['shop_id'].'/item?detail='.$od['product_id'];
							break;
						}
					}
			$subtotal += $od['price'] * $od['quantity'];
			$tax += ($od['price'] * $od['quantity'])*(TAX_RATE/100);
					$arrTemp[] = $od;
			}
			if (count($arrTemp) == 0)
				return;
				$arrOrderDetail = $arrTemp;
				$arrResult['arrShopData'] = $arrOrderDetail;

				$arrOrder['tax_in'] = TAX_RATE;
				$arrOrder['subtotal'] = $subtotal;
				$arrOrder['tax'] = $tax;
				$arrOrder['shop_name'] = $arrShop['shop_name'];
				$arrOrder['shop_id'] = $arrShop['shop_id'];
				$arrOrder['total'] = $subtotal+$tax;
				$arrResult['arrOrder'] = $arrOrder;

				$tpl = 'smarty/email/next_order_mail.tpl';
				// var_dump($arrOrderDetail);
				// exit;


				$email = Email::forge();
				$email->header('Content-Transfer-Encoding', 'base64');
				$email->from(ORDER_MAIL_FROM);
				$to = explode(',', $arrShop['notify_email']);
				$email->to($to);
				$email->subject("NE受注取り込み用メール");
				$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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

				// 		// メール送信（管理者宛て）
				// 		$tpl = 'smarty/email/order_mail.tpl';
				//
				// 		$email = Email::forge();
				// 		$email->from(ORDER_MAIL_FROM);
				// 		$email->to(ORDER_MAIL_TO_ADMIN);
				// 		$email->subject(ORDER_MAIL_TITLE_ADMIN);
				// 		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
				// 		$email->send();

				return true;
	}


    public static function order_mail($customer_id, $cart, $order_id)
    {
    	Log::debug('order_mail');
        $arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");
		$arrResult['customer_sale_status'] = 0;
        if ($customer_id != 0)
        {
	        $arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
	        $arrResult['arrCustomer'] = $arrCustomer;
			$arrResult['customer_sale_status'] = $arrCustomer['sale_status'];
	    }
	    else {
	    	$arrCustomer['email']  = $cart->getCustomerEmail();
	    	$arrCustomer['name01'] = $cart->getCustomerName();
	    	$arrCustomer['name02'] = $cart->getCustomerName2();
	    }
        $arrOrder = $arrOrder[0];
        $arrOrderDetail = Tag_Order::get_order_detail($order_id);
			$arrFreeProducts = array();
        if ($customer_id == 0)
        {
			$arrDeliv = Tag_Order::get_order_deliv2($order_id, true);
			if (count($arrDeliv) == 0)
				$arrDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
		}
		else
		{
	        $arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);

			$arrCoupon = Tag_Campaign::get_check($customer_id, $arrOrder['coupon']);
			if (is_array($arrCoupon) && count($arrCoupon) > 0)
			{
				$arrFreeProducts = explode(',', $arrCoupon[0]['product_ids']);
			}
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

			$detail = Tag_Item::get_detail($od['product_id']);
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
        $arrResult['tpl_header'] = '';
        $arrResult['tpl_footer'] = '';

        $sql  = "SELECT * FROM dtb_mail_template";
        $sql .= " WHERE id = ".ORDER_MAIL_TEMPLATE_ID;
        $sql .= " order by rank ";
        $query = DB::query($sql);
        $arrTempleate = $query->execute()->as_array();

        if( 0 < count($arrTempleate)) {
        	$arrResult['tpl_header'] = $arrTempleate[0]['header'];
        	$arrResult['tpl_footer'] = $arrTempleate[0]['footer'];
        }

        // 置換
        $arrResult['tpl_header'] = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrResult['tpl_header']);
        $arrResult['tpl_footer'] = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrResult['tpl_footer']);

		$tpl = 'smarty/email/order_mail.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$email->to($arrCustomer['email']);
		$email->cc(ORDER_MAIL_TO_ADMIN);
//		$email->cc("maildealer-23@mdbellgw.maildealer.jp");
		$email->subject(ORDER_MAIL_TITLE_ADMIN);
		$email->body(\View_Smarty::forge($tpl, $arrResult, false));

		$history = array();
		$history['order_id'] = $order_id;
// 		var_dump($email->get_to());
// 		exit;
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

		// メール送信（管理者宛て）	→　管理者は cc に設定
		/*
		$tpl = 'smarty/email/order_mail.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(ORDER_MAIL_FROM);
		$email->to(ORDER_MAIL_TO_ADMIN);
		$email->subject(ORDER_MAIL_TITLE_ADMIN);
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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
		*/

		return;
    }



    public static function order_mail_order_id($order_id)
    {
    	Log::debug('order_mail');

    	$order = Tag_Order::get_order_info($order_id);
    	if( $order == "") {
    		return false;
    	}

    	$customer_id = $order[0]["customer_id"];

    	$arrOrder = Tag_Order::get_order($customer_id, 1, " order_id = {$order_id} ");

			$arrFreeProducts = array();
		$arrResult['customer_sale_status'] = 0;
    	if ($customer_id != 0)
    	{
    		$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
	        $arrResult['arrCustomer'] = $arrCustomer;
			$arrResult['customer_sale_status'] = $arrCustomer['sale_status'];
			$arrCoupon = Tag_Campaign::get_check($customer_id, $arrOrder[0]['coupon']);
			if (is_array($arrCoupon) && count($arrCoupon) > 0)
			{
				$arrFreeProducts = explode(',', $arrCoupon[0]['product_ids']);
			}
		}
   		else 
   		{
   			$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true);
			$arrDeliv = Tag_Order::get_order_deliv2($order_id, true);
			if (count($arrOrderDeliv) == 0)
				$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id, true, true);
   			if( count($arrOrderDeliv) == 0) {
   				return false;
   			}
   			$arrCustomer = $arrOrderDeliv[0];
   		}


    			$arrOrder = $arrOrder[0];
    			$arrOrderDetail = Tag_Order::get_order_detail($order_id);
    			$arrDeliv = Tag_Order::get_order_deliv($customer_id, $arrOrder['customer_deliv_id']);
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

    				$detail = Tag_Item::get_detail($od['product_id']);
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
		$arrResult['arrRank'] = $arrRank;
		$arrResult['arrFree'] = $arrFree;
    			$arrResult['arrOrderDetail'] = $arrOrderDetail;
    			$arrResult['arrDeliv'] = $arrDeliv;
    			$arrResult['tpl_header'] = '';
    			$arrResult['tpl_footer'] = '';

    			$sql  = "SELECT * FROM dtb_mail_template";
    			$sql .= " WHERE id = ".ORDER_MAIL_TEMPLATE_ID;
    			$sql .= " order by rank ";
    			$query = DB::query($sql);
    			$arrTempleate = $query->execute()->as_array();

    			if( 0 < count($arrTempleate)) {
    				$arrResult['tpl_header'] = $arrTempleate[0]['header'];
    				$arrResult['tpl_footer'] = $arrTempleate[0]['footer'];
    			}

    			// 置換
    			$arrResult['tpl_header'] = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrResult['tpl_header']);
    			$arrResult['tpl_footer'] = str_replace('[[name]]', $arrCustomer['name01'].' '.$arrCustomer['name02'], $arrResult['tpl_footer']);

    			$tpl = 'smarty/email/order_mail.tpl';

    			$email = Email::forge();
				$email->header('Content-Transfer-Encoding', 'base64');
    			$email->from(ORDER_MAIL_FROM);
    			$email->to($arrCustomer['email']);
    			$email->cc(ORDER_MAIL_TO_ADMIN);
    			$email->subject(ORDER_MAIL_TITLE_ADMIN);
    			$email->body(\View_Smarty::forge($tpl, $arrResult, false));

    			$history = array();
    			$history['order_id'] = $order_id;
    			// 		var_dump($email->get_to());
    			// 		exit;
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

    			// メール送信（管理者宛て）	→　管理者は cc に設定
    			/*
    			$tpl = 'smarty/email/order_mail.tpl';

    			$email = Email::forge();
				$email->header('Content-Transfer-Encoding', 'base64');
    			$email->from(ORDER_MAIL_FROM);
    			$email->to(ORDER_MAIL_TO_ADMIN);
				$email->subject(ORDER_MAIL_TITLE_ADMIN);
    			$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

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
    			*/

    			return true;

    }
}
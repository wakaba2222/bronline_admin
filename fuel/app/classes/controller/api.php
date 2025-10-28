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
define('API_TOKEN', 'z2QJQMENzvzLEq5wzJpkr8d2vWEq2SQ4');

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Api extends Controller_Rest
{
	public function action_keyword()
	{
		Log::debug('action_keyword', true);
		$access_flg = Input::param('type','');
		if ($access_flg == '')
		{
	        return $this->response(array(
	            'keyword' => '',
	        ));
        }
		$sql = "SELECT keyword,count(keyword) as cnt FROM `dtb_suggest` where access = {$access_flg} group by keyword order by cnt desc limit 50";
		$arrRet = DB::query($sql)->execute()->as_array();
		
		$keyword = array();
		foreach($arrRet as $ret)
		{
			$keyword[] = $ret['keyword'];
		}

        return $this->response(array(
            'keyword' => $keyword,
        ));
	}

	public function action_regist_smaregi_order()
	{
		Log::debug('action_regist_smaregi_order', true);
		$order_id = Input::param('order_id','0');
		$shop_url = Input::param('shop_url','0');
		$cancel = Input::param('cancel','0');

		$sql = "select * from dtb_smaregi_order where order_id = {$order_id} and shop_url = '{$shop_url}'";
		$arrRet = DB::query($sql)->execute()->as_array();
		$id = 0;
		if (count($arrRet) > 0)
		{
			$smaregi = $arrRet[0];
			$id = $smaregi['id'];
			unset($smaregi['id']);
		}
		else
		{
// 	        return $this->response(array(
// 	            'smaregi' => array(),
// 	        ));
		}


		$sql = "select * from dtb_order where order_id = {$order_id}";
		$arrRet = DB::query($sql)->execute()->as_array();
		$arrOrder = $arrRet[0];
		$arrOrder['subtotal_a'] = $arrOrder['total'];
		Log::debug($shop_url." shop_tran_admin()", true);
		$res = Tag_Smaregi::shop_tran_admin($shop_url, $arrOrder, $cancel);
		Log::debug($res);
		Log::debug($shop_url." shop_tran_admin()", true);

		if ($res != false)
		{
			$sql = "delete from dtb_smaregi_order where id = {$id}";
			DB::query($sql)->execute();
			
			$sql = "select * from dtb_smaregi_order where smaregi_order_id is not NULL and order_id = {$order_id} and shop_url = '{$shop_url}'";
			$arrRet = DB::query($sql)->execute()->as_array();
			if (count($arrRet) > 0)
			{
				$smaregi = $arrRet[0];
			}
		}
        return $this->response(array(
            'smaregi' => $smaregi,
            'res'=>$res,
        ));
	}

	public function action_search_order()
	{
		Log::debug('action_search_order', true);
		$order_id = Input::param('order_id','0');
		$shop_url = Input::param('shop_url','0');
		$sql = "select * from dtb_smaregi_order where smaregi_order_id is not NULL and order_id = {$order_id} and shop_url = '{$shop_url}'";
		$arrRet = DB::query($sql)->execute()->as_array();
		
		$smaregi = array('order_id'=>-1);
		if (count($arrRet) > 0)
		{
			$smaregi = $arrRet[0];
		}

        return $this->response(array(
            'smaregi' => $smaregi,
        ));
	}
	
    public function get_clearviewd()
    {
    	Tag_Session::clearCheckItem();
    }

	public function get_customer()
	{
		$authority = Tag_Session::get('authority');
		if ($authority != '0')
		{
	        return $this->response(array(
	            'customer' => '',
	        ));
		}
		$customer_id = Input::param('customer_id', '0');
		
		$customer = Tag_CustomerInfo::get_customer($customer_id);

        return $this->response(array(
            'customer' => $customer,
        ));
	}

	public function get_product()
	{
		$authority = Tag_Session::get('authority');
		if ($authority != '0')
		{
	        return $this->response(array(
	            'product' => '',
	        ));
		}
		$product_code = Input::param('product_code', '0');
		
		$product = Tag_Item::get_product_sku($product_code);

        return $this->response(array(
            'product' => $product,
            'authority'=>$authority,
        ));
	}
	
	public function post_addimg()
	{
// 		var_dump(Input::param());
		$file_tmp  = $_FILES["image"]["tmp_name"];
		$file_save = REAL_UPLOAD_IMAGE_PATH . "temp/" .date('YmdHis').'_'. $_FILES["image"]["name"];
		$result = @move_uploaded_file($file_tmp, $file_save);
		$perm_num = 666;
		$perm     = sprintf ( "%04d", $perm_num );
		@chmod($file_save,octdec ( $perm ));

		if ($result === true)
		{
			$file_save = UPLOAD_IMAGE_PATH . "temp/" .date('YmdHis').'_'. $_FILES["image"]["name"];
			$ret = array("img"=>$file_save);
			 $this->response($ret);
// 
// 			echo json_encode($ret);
		}
// 		else
// 			echo "NG";
	}
	public function post_addpimg()
	{
// 		$str = $_FILES["file"]["tmp_name"];
// 		var_dump($_FILES["file"]["tmp_name"]);

		$file_tmp  = $_FILES["file"]["tmp_name"];
		$file_save = REAL_UPLOAD_IMAGE_PATH . "detail_image/" . date('YmdHis').'_'.$_FILES["file"]["name"];
		$result = @move_uploaded_file($file_tmp, $file_save);

		if ($result === true)
		{
			$file_save = UPLOAD_IMAGE_PATH . "detail_image/" . date('YmdHis').'_'.$_FILES["file"]["name"];
			$ret = array("url"=>$file_save);
			 $this->response($ret);
// 
// 			echo json_encode($ret);
		}
//		else
//		{
// 		else
// 			echo "NG";
//		$ret = array('str'=>$file_save);
//		 $this->response($ret);
//		}
	}

	public function get_delcart()
	{
		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();

		$arrTemp = $cartctrl->cart->getOrderDetail();
		$cartctrl->cart->order_detail = array();
		foreach($arrTemp as $d)
		{
			if ($d->getProductId() == Input::param('product_id') && $d->getSizeCode() == Input::param('size_code') && $d->getColorCode() == Input::param('color_code'))
			{
			}
			else
			{
				$cartctrl->cart->setOrderDetail($d);
			}
		}
		
		$cartctrl->setSession();

		$count = 0;		
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			$count += $d->getQuantity();
		}

        return $this->response(array(
            'quantity' => $count,
        ));
	}
	
    public function get_setcart()
    {
		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();

		$found = false;
		$err = '';
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			if ($d->getProductId() == Input::param('product_id') && $d->getSizeCode() == Input::param('size_code') && $d->getColorCode() == Input::param('color_code'))
			{
				$found = true;
				$quantity = $d->getQuantity();
				
				$arrSKU = Tag_Item::get_detail_sku(Input::param('product_id'));
				$stock = 0;
				foreach($arrSKU as $p)
				{
					if ($d->getSizeCode() == $p['size_code'] && $d->getColorCode() == $p['color_code'])
					{
						$stock = $p['stock'];
					}
				}
				if ($stock >= Input::param('quantity'))
				{
					$d->setQuantity(Input::param('quantity'));
				}
				else
				{
					$err = '指定した数量分の在庫がありません。';
				}
				break;
			}
		}
		
		$cartctrl->setSession();

		$count = 0;		
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			$count += $d->getQuantity();
		}
//		$count = count($cartctrl->cart->getOrderDetail());
//var_dump($cartctrl->cart->getOrderDetail());

        return $this->response(array(
            'quantity' => $count,
            'err'=>$err,
        ));
    }

    public function get_addcart()
    {
		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();

		$arrSKU = Tag_Item::get_detail_sku(Input::param('product_id'));
		$sku = array();
		foreach($arrSKU as $s)
		{
			if ($s['color_code'] == Input::param('color_code') && $s['size_code'] == Input::param('size_code'))
			{
				$sku = $s;
				break;
			}
		}

		$not = 0;
		$found = false;
		$payoff = 0;
		$reservation = false;
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			if ($d->getProductId() == Input::param('product_id') && $d->getSizeCode() == Input::param('size_code') && $d->getColorCode() == Input::param('color_code') && $d->getShop() == Input::param('shop_url'))
			{
				$found = true;
				$quantity = $d->getQuantity();
				if ($sku['stock'] > ($quantity+Input::param('quantity')))
					$d->setQuantity($quantity + Input::param('quantity'));
				break;
			}
//			else
//			{
//				if ($d->getReservation() == 1)
//					$not = 2;
//				else if ($d->getReservation() == 2)
//					$not = 4;
//			}
		}
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			if ($d->getReservation() == 1 || $d->getReservation() == 2)
				$reservation = $d->getReservation();
		}


		if (!$found)
		{
			$detail = new Tag_Cartorderdetail();
 			$arrSKU = Tag_Item::get_detail_sku(Input::param('product_id'));
 			$arrProduct = Tag_Item::get_detail(Input::param('product_id'), false, Input::param('shop_url'));
 			
			if ($reservation >= 1)
			{
				if ($reservation == 1)
				{
					if ($arrProduct['reservation_flg'] != 1 && $arrProduct['pay_off'] == 0)
						$not = 1;
					else if($arrProduct['reservation_flg'] != 1 && $arrProduct['pay_off'] == 1)
						$not = 0;
					else if ($arrProduct['reservation_flg'] == 1 && Input::param('product_id') != $d->getProductId())
						$not = 2;
				}
				elseif ($d->getReservation() == 2)
				{
					if ($arrProduct['reservation_flg'] != 2 && $arrProduct['pay_off'] == 0)
						$not = 3;
					else if($arrProduct['reservation_flg'] != 2 && $arrProduct['pay_off'] == 1)
						$not = 0;
					else if ($arrProduct['reservation_flg'] == 2 && Input::param('product_id') != $d->getProductId())
						$not = 4;
				}

			}
			elseif(count($cartctrl->cart->getOrderDetail()) > 0)
			{
				foreach($cartctrl->cart->getOrderDetail() as $d)
				{
					if ($d->getPayOff() == 1)
						$payoff++;
				}

				if ($arrProduct['reservation_flg'] == 1 && $payoff < count($cartctrl->cart->getOrderDetail()))
					$not = 2;
				elseif ($arrProduct['reservation_flg'] == 2 && $payoff < count($cartctrl->cart->getOrderDetail()))
					$not = 4;
			}

			if ($not == 0)
			{
				$arrImage = Tag_Item::get_detail_images(Input::param('product_id'));
	// 			var_dump($arrSKU);exit;
	 			$sku = array();
				foreach($arrSKU as $s)
				{
					if ($s['color_code'] == Input::param('color_code') && $s['size_code'] == Input::param('size_code'))
					{
						$sku = $s;
						break;
					}
				}
	 			$detail->setProductCode($sku['product_code']);
	 			$detail->setBrandName($arrProduct['brand_name']);
	 			$detail->setBrandNameKana($arrProduct['brand_name_kana']);
	 			$detail->setName($arrProduct['name']);
	 			$detail->setPrice($arrProduct['price01']);
				$detail->setImage($arrImage);
	 			$detail->setSize($sku['size_name']);
	 			$detail->setColor($sku['color_name']);
	// 			$detail->setShop($arrProduct['login_id']);
	 			$detail->setShop($arrProduct['login_id']);
	 			$detail->setOrgShop($arrProduct['org_shop']);
	
	 			$detail->setPayOff($arrProduct['pay_off']);
	 			$detail->setReservation($arrProduct['reservation_flg']);
	
				$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
				$arrSales = $arrSales[0];
				$now = date('YmdHis');
				
				$start_date = date('YmdHis', strtotime($arrSales['start_date']));
				$end_date = date('YmdHis', strtotime($arrSales['end_date']));
				$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
				$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
				$sale_flg = 0;
				$sale_par = 0;
				if ($start_date <= $now && $end_date >= $now)
				{
					$sale_flg = 1;
					$sale_par = $arrSales['sale'];
				}
				else if ($vip_start_date <= $now && $vip_end_date >= $now)
				{
					$sale_flg = 1;
					$sale_par = $arrSales['vip_sale'];
				}
	
	
	 			$detail->setSaleStatus($arrProduct['sale_status']);
	 			$detail->setSaleRate($sale_par);
	
				$detail->setProductId(Input::param('product_id'));
				$detail->setSizeCode(Input::param('size_code'));
				$detail->setColorCode(Input::param('color_code'));
				$quantity = $detail->getQuantity();
				$detail->setQuantity($quantity + Input::param('quantity'));
				$cartctrl->cart->setOrderDetail($detail);
			}
		}
		else
		{
 			$arrProduct = Tag_Item::get_detail(Input::param('product_id'), false, Input::param('shop_url'));

			if ($reservation >= 1)
			{
				if ($reservation == 1)
				{
					if ($arrProduct['reservation_flg'] != 1 && $arrProduct['pay_off'] == 0)
						$not = 1;
					else if($arrProduct['reservation_flg'] != 1 && $arrProduct['pay_off'] == 1)
						$not = 0;
				}
				elseif ($reservation == 2)
				{
					if ($arrProduct['reservation_flg'] != 2 && $arrProduct['pay_off'] == 0)
						$not = 3;
					else if($arrProduct['reservation_flg'] != 2 && $arrProduct['pay_off'] == 1)
						$not = 0;
				}

			}
			elseif(count($cartctrl->cart->getOrderDetail()) > 0)
			{
				foreach($cartctrl->cart->getOrderDetail() as $d)
				{
					if ($d->getPayOff() == 1)
						$payoff++;
				}

				if ($arrProduct['reservation_flg'] == 1 && $payoff < count($cartctrl->cart->getOrderDetail()))
					$not = 2;
				elseif ($arrProduct['reservation_flg'] == 2 && $payoff < count($cartctrl->cart->getOrderDetail()))
					$not = 4;
			}
		}
//var_dump($not);
//var_dump($reservation);
//var_dump($payoff);
//var_dump(count($cartctrl->cart->getOrderDetail()));
		$cartctrl->setSession();

		$error = '';
		$count = 0;
		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			$count += $d->getQuantity();
		}

		if ($not == 1)
			$error = 'カート内に受注生産商品が入っているため、予約商品、通常商品をカートに入れることができません。'.'受注生産商品のご注文を完了していただいたのち、改めて予約商品、通常商品をカートに入れてください。'.'<br><br>'.'※お直しメニューは受注生産商品と一緒に購入可能です。';
		else if ($not == 2)
			$error = '受注生産商品は、他の商品とカートに入れることができません。';
		else if ($not == 3)
			$error = 'カート内に予約商品が入っているため、受注生産商品、通常商品をカートに入れることができません。'.'予約商品のご注文を完了していただいたのち、改めて受注生産商品、通常商品をカートに入れてください。'.'<br><br>'.'※お直しメニューは予約商品と一緒に購入可能です。';
		else if ($not == 4)
			$error = '予約商品は、他の商品とカートに入れることができません。';

//		$count = count($cartctrl->cart->getOrderDetail());
//var_dump($cartctrl->cart->getOrderDetail());

        return $this->response(array(
            'quantity' => $count,
            'error' => $error,
        ));
    }
    public function get_couponcheck()
    {
    	$coupon = Input::param('coupon','');
    	$customer_id = Input::param('customer_id','');
    	$price = Input::param('price',0);
    	$cartinfo = Input::param('cartinfo','');
    	if ($coupon == '')
    		return '';

    	$arrTemp = Tag_Campaign::get_check($customer_id, $coupon, $price);
		$total = 0;
		$not_products = array();
    	if ($arrTemp != '' && count($arrTemp) > 0)
    	{
			$not_products = explode(',', $arrTemp[0]['not_products']);
			$not_shops = explode(',', $arrTemp[0]['not_shops']);

			$total = 0;
			foreach($cartinfo as $detail)
			{
				$f = false;
				foreach($not_products as $pid)
				{
					if ($detail['pid'] == $pid)
					{
						$f = true;
					}
//					else
//					{
//						foreach($not_shops as $shop)
//						{
//							$arrProducts = Tag_Item::get_detail($detail['pid']);
//							if (count($arrProducts) > 0)
//							{
//								$id = Tag_Shop::get_shop_id($arrProducts['login_id']);
//								if ($shop == $id)
//								{
//									$f = true;
//								}
//							}
//						}
//					}
				}
				if ($f == false)
				{
					foreach($not_shops as $shop)
					{
						$arrProducts = Tag_Item::get_detail($detail['pid']);
						if (count($arrProducts) > 0)
						{
							$id = Tag_Shop::get_shop_id($arrProducts['login_id']);
							if ($shop == $id)
							{
								$f = true;
							}
						}
					}
				}
				if (!$f)
				{
					$total += intval($detail['price'])*intval($detail['quantity']);
				}
			}
    	}
//    	var_dump($total);
//    	var_dump($cartinfo);
//    	var_dump($not_products);
//    	var_dump($not_shops);
//    	if ($total == 0 && count($arrTemp) == 0)
    	if ($total == 0)
    		$total = -2;

    	$arrRet = Tag_Campaign::get_check($customer_id, $coupon, $total);

//    	var_dump($arrRet);
//    	exit;
    	$discount = "";
    	$discount_p = "";
    	$product_ids = "";
    	if ($arrRet != '' && count($arrRet) > 0)
    	{
			if ($arrRet[0]['discount'] != '')
				$discount = $arrRet[0]['discount'];
			if ($arrRet[0]['discount_p'] != '')
				$discount_p = $arrRet[0]['discount_p'];
			if ($arrRet[0]['product_ids'] != '')
				$product_ids = $arrRet[0]['product_ids'];
    	}

//		if ($f && ($total < $discount))
//		{
//			$discount = 0;
//		}
    	
    	
        return $this->response(array(
            'discount' => $discount,
            'discount_p' => $discount_p,
            'product_ids' => $product_ids,
            'total' => $total,
            'not_products' => $not_products,
            'arrRet' => $arrRet,
        ));
    }

    public function get_couponcheck2()
    {
    	$coupon = Input::param('coupon','');
    	$customer_id = Input::param('customer_id','');
    	$email = Input::param('email','');
    	if ($coupon == '')
    		return '';

    	$ret = Tag_Campaign::get_check3($customer_id, $email, $coupon);    	
    	
        return $this->response(array(
            'err' => $ret,
        ));
    }

    public function get_clearcart()
    {
		$cartctrl = new Tag_Cartctrl();
		$cartctrl->clearSession();
		
        return $this->response(array(
        ));
    }


    //在庫同期
    public function action_receive_stock()
    {
    	$token = Input::param('token','');
    	if ($token == '')
    	{
    		$token = Input::json('token', '');
    	}
    	$product_code = Input::param('product_code','');
    	if ($product_code == '')
    	{
    		$product_code = Input::json('product_code', '');
    	}
    	$stock = Input::param('stock','');
    	if ($stock == '')
    	{
    		$stock = Input::json('stock', '');
    	}
    	$update_date = Input::param('update_date','');
    	if ($update_date == '')
    	{
    		$update_date = Input::json('update_date', '');
    	}
    	
    	$this->debug('token:'.$token);
    	$this->debug('product_code:'.$product_code);
    	$this->debug('stock:'.$stock);
    	$this->debug('update_date:'.$update_date);
    	
    	if ($token != API_TOKEN)
    	{
	    	$this->debug('token error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'token error.',
	        ));
    	}
    	if ($product_code == '')
    	{
	    	$this->debug('product_code error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'product_code error.',
	        ));
    	}
    	if ($stock == '' || !is_numeric($stock))
    	{
	    	$this->debug('stock error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'stock error.',
	        ));
    	}
    	if ($update_date == '')
    	{
	    	$this->debug('update_date error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'update_date error.',
	        ));
    	}

		$sql = "UPDATE dtb_product_sku set stock = {$stock} ";
		$sql .= " WHERE product_code = '{$product_code}' ";
		$query = DB::query($sql);
		$arrRet = $query->execute();

    	$this->debug('stock update.');
    	
        return $this->response(array(
            'ret' => 'ok',
        ));
    }

    //在庫同期一括
    public function action_receive_all_stock()
    {
		set_time_limit(300);

    	$token = Input::param('token','');
    	if ($token == '')
    	{
    		$token = Input::json('token', '');
    	}
    	
    	$this->debug('token:'.$token);
    	
    	if ($token != API_TOKEN)
    	{
	    	$this->debug('token error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'token error.',
	        ));
    	}

    	$fname = Input::param('fname','');
    	if ($fname == '')
    	{
    		$fname = Input::json('fname', '');
    	}
    	$this->debug('fname:'.$fname);

		$filepath = __DIR__.'/../../logs/csv/'.$fname;
		if ($fname == '')
		{
	    	$this->debug('filename:empty or not exsist.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'filename empty or not exsist.',
	        ));
		}
		else if (!file_exists($filepath))
		{
	    	$this->debug('filename:empty or not exsist.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'filename empty or not exsist.',
	        ));
		}

		//ファイルの読み込み
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);

		
		if (mb_detect_encoding(file_get_contents($filepath),"UTF-8, sjis-win") === false)
		{
			return;
		}
		$enc = mb_detect_encoding(file_get_contents($filepath),"UTF-8, sjis-win");
		
		$buffer = mb_convert_encoding(file_get_contents($filepath), "UTF-8", $enc);
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);


		$cnt = 0;
		$csv = array();
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);


		foreach($csv as $c)
		{
			$sql = "UPDATE dtb_product_sku set stock = {$c['stock']} ";
			$sql .= " WHERE product_code = '{$c['product_code']}' ";
			$query = DB::query($sql);
			$arrRet = $query->execute();
		}


//		@chmod('/home/gentedimare/'.$fname, 0644);		
		@copy(__DIR__.'/../../logs/csv/'.$fname, __DIR__.'/../../logs/old/'.$fname);
		
		//展開
		
		//ループでの処理実行



//		$sql = "UPDATE dtb_product_sku set stock = {$stock}, update_date = '{$update_date}' ";
//		$sql .= " WHERE product_code = {$product_code} ";
//		$query = DB::query($sql);
//		$arrRet = $query->execute();

    	$this->debug('stock update.');
    	
        return $this->response(array(
            'ret' => 'ok',
        ));
    }

	//商品登録
	public function action_receive_products()
	{

//print("<pre>");	
//var_dump(Input::json('token',''));
//var_dump($this->request);
//print("</pre>");	
//exit;
		set_time_limit(300);

    	$token = Input::param('token','');
    	if ($token == '')
    	{
    		$token = Input::json('token', '');
    	}
    	
    	$this->debug('token:'.$token);
    	if ($token != API_TOKEN)
    	{
	    	$this->debug('token error.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'token error.',
	        ));
    	}

    	$fname = Input::param('fname','');
    	if ($fname == '')
    	{
    		$fname = Input::json('fname', '');
    	}
    	$this->debug('fname:'.$fname);
    	
    	$ret = Controller_Admin_Product::post_upload_byfile(__DIR__.'/../../logs/csv/'.$fname);

    	$this->debug('product regist1.');

		if (!$ret)
		{
	    	$this->debug('filename:empty or not exsist.');
	        return $this->response(array(
	            'ret' => 'ng',
	            'msg' => 'filename empty or not exsist.',
	        ));
		}

//		@chmod('/home/gentedimare/'.$fname, 0644);		
		@copy(__DIR__.'/../../logs/csv/'.$fname, __DIR__.'/../../logs/old/'.$fname);

    	$this->debug('product regist.2');
        return $this->response(array(
            'ret' => 'ok',
        ));
	}

	//商品購入
	public static function send_order($Order)
	{
//print("<pre>");	
//var_dump($Order);
//print("</pre>");	
//exit;
//		$Order['order_id'] = '123456';
		
		$now = date('Y-m-d H:i:s');
		$data = array(
		    'token'        => '92f58af9e83e4b17b654e7a3b12b8e09',
		    'order_no' => 'BR'.$Order[0]['order_id'],
//		    'customer' => array(
//		    	'name01' => 'BR',
//		    	'name02' => 'ONLINE',
//		    	'kana01' => '',
//		    	'kana02' => '',
//		    	'email' => 'info@bronline.jp',
//		    	'phone_number' => '0367211124',
//		    	'postal_code' => '1500001',
//		    	'pref' => '東京都',
//		    	'addr01' => '渋谷区',
//		    	'addr02' => '神宮前3-35-16',
//		    ),
		    'order_date' => $now,
		);
		
		$items = array();
		$total = 0;
		foreach($Order as $detail)
		{
			if ($detail['shop_id'] == 'gentedimare')
			{
				$d = array();
				$d['product_code'] = $detail['product_code'];
				$d['product_name'] = $detail['product_name'];
				$d['quantity'] = $detail['quantity'];
				$d['price'] = $detail['price'];
				$total += intval($detail['price']) * intval($detail['quantity']);
				$items[] = $d;
			}
		}
		
		if (count($items) == 0)
			return;
//		$items = array(
//			'product_code' => 'PRD001',
//			'product_name' => 'テスト商品',
//			'quantity' => '1',
//			'price' => '1000',
//		);
		$data['items'] = $items;
		$data['total'] = $total;
		 
		$json = json_encode( $data );


		$ch = curl_init();
		 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'https://gentedimare.jp/br-order-api/receive');
		 
		$result = curl_exec( $ch );
		 
		curl_close($ch);
		//$result;
		//var_dump( $result );
//		print("<pre>");
//		$res_json = json_decode( $result, true );
//		var_dump( $result );
//		var_dump( $res_json );
//		print("</pre>");
	}
	
	public function debug($str)
	{	
		$fp = fopen(__DIR__.'/../../logs/api/gent_api_'.date('Ymd').".log", "a");
		if ($fp)
		{
			fputs($fp, date("Y-m-d H:i:s").",");
			fputs($fp, print_r($str, true));
			fputs($fp, ",");
			fputs($fp, $_SERVER['REQUEST_URI']);
			fputs($fp, ",");
//			fputs($fp, $_SERVER['HTTP_X_FORWARDED_FOR']);
//			fputs($fp, ",");
			fputs($fp, $_SERVER['PHP_SELF']);
			fputs($fp, ",");
			fputs($fp, session_id());
			fputs($fp, PHP_EOL);
			fclose($fp);
		}
		
		return;
	}
}

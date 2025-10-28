<?php
class Tag_Smaregi
{
	function __construct()
	{
	}

	public function action_smaregi_get()
	{
//		Log::debug(json_encode(Input::param('params')));
		
		$temp = json_decode(str_replace('\\"', '"', Input::param('params')), true);
		$shop = Input::param('shop_id');
// mb_language("Japanese");
// $temp2 = '\\u30d5\\u30e9';
//  var_dump($this->unicode_encode($temp2));
//  exit;
//		$ttt = json_decode('{"result":{"TransactionHead":1,"TransactionHeadIds":["952"],"TransactionDetail":1}}', true);
		
//		var_dump($ttt['result']['TransactionHeadIds'][0]);
//		var_dump($temp);
 		Log::debug(Input::param('proc_name'), true);
 		Log::debug("smaregi get", true);
 		Log::debug(var_export($shop, true), true);
 		Log::debug(var_export($temp, true), true);
		
		switch(Input::param('proc_name'))
		{
			case 'product_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(var_export($data, true),true);
				Tag_Smaregi::set_product($data);
				break;
			}
			case 'stock_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(json_encode($data), true);
				Tag_Smaregi::set_stock($data, $shop);
				break;
			}
			case 'transaction_send':
			{
				break;
			}
			case 'customer_send':
			{
				break;
			}
			default:
				break;
		}

		$tpl = 'smarty/smaregi/index.tpl';



// 		//カートの数更新
// 		$cartctrl = new Tag_Cartctrl();
// 		$cartctrl->getSession();
// 		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		return View_Smarty::forge( $tpl, array(), false );
	}

	public static function push_smaregi($shop, $update_product)
	{
		$where = "A.login_id = '{$shop}'";
		$arrRet = Tag_Shop::get_shopdetail($where);
//var_dump($arrRet);

		if (count($arrRet) == 0)
			return;
	
		$product_ids = implode(',', $update_product);
	
		$shop_id = $arrRet[0]['id'];
		$sql = "select distinct A.*,C.*,B.*,D.* from dtb_products as A join dtb_product_sku as B ON A.product_id = B.dtb_products_product_id left join dtb_smaregi_product as C ON C.product_code = B.product_code ";
		$sql .= " join dtb_product_price as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " WHERE A.shop_id = '{$shop_id}' and A.del_flg = 0 and A.product_id in ({$product_ids}) ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
 //var_dump($sql);
//  var_dump($arrRet);
// exit;	
		$smaregi_id = 0;
		foreach($arrRet as $ret)
		{
			$arrItem = array();
// 			if ($ret['smaregi_product_id'] == '')
// 			{
// 				continue;
// 			}
// 			var_dump($ret['smaregi_product_id']);
// 			var_dump($ret['product_id']);
// 			var_dump($ret['product_code']);
			if ($ret['smaregi_product_id'] != '')
				$arrItem['productId'] = $ret['smaregi_product_id'];
			else
			{
				if ($smaregi_id == 0)
				{
					$sql = "select max(smaregi_product_id) as smaregi_product_id from dtb_smaregi_product where shop_id = '{$shop}'";
					$query = DB::query($sql);
					$arrRets = $query->execute()->as_array();
					if (count($arrRets) > 0)
					{
						$smaregi_id = $arrRets[0]['smaregi_product_id'] + 1;
// 						$arrItem['productId'] = $ret['smaregi_product_id'];
//						var_dump($sql);
					}
				}
				else
					$smaregi_id++;
				$arrItem['productId'] = $smaregi_id;
// 				$query = DB::insert('dtb_smaregi_product');
// 				$query->set($arrSmaregi)->execute();
// 				DB::commit_transaction();
			}
// 			var_dump($arrItem['productId']);
// 			exit;
			usleep(500000);

			$res = Tag_Smaregi::select($ret['product_code'], $shop);
//			$res = Tag_Smaregi::select('2300000570014aaaaa', $shop);
//var_dump("<br>ref:".$res."<br>");
			if ($res != false)
			{
				$result = json_decode($res,true);
//var_dump($result);exit;

				if ($result['total_count'] > 0)
				{
					$smaregi_product_id = $result['result'][0]['productId'];

					DB::delete('dtb_smaregi_product')->where('product_code', '=', $ret['product_code'])->and_where('smaregi_product_id', '=', $smaregi_product_id)->execute(); 				
					$ret['smaregi_product_id'] = $smaregi_product_id;
					$arrSmaregi = array();
					$arrSmaregi['smaregi_product_id'] = $ret['smaregi_product_id'];
					$arrSmaregi['size_name'] = $ret['size_name'];
					$arrSmaregi['color_name'] = $ret['color_name'];
	// 				$arrSmaregi['color_code'] = $ret['color_code'];
	// 				$arrSmaregi['size_code'] = $ret['size_code'];
					$arrSmaregi['product_code'] = $ret['product_code'];
					$arrSmaregi['dtb_product_sku_id'] = $ret['id'];
					$arrSmaregi['product_name'] = $ret['name'];
					$arrSmaregi['shop_id'] = $shop;
					$arrSmaregi['stock'] = $ret['stock'];
					$arrSmaregi['attribute'] = $ret['attribute'];
					$query = DB::insert('dtb_smaregi_product');
					$query->set($arrSmaregi)->execute();
				}
				else
				{
// 					$ret['smaregi_product_id'] = $smaregi_id;
// 					$arrItem['productId'] = $ret['smaregi_product_id'];
// var_dump($arrItem);
// exit;
					$arrSmaregi = array();
					$arrRets = array();
//					$arrRets = DB::query("select * from dtb_smaregi_product where product_code = '{$ret['product_code']}' and smaregi_product_id = {$arrItem['productId']} and shop_id = '{$shop}'")->execute()->as_array();
					$arrRets = DB::query("select * from dtb_smaregi_product where product_code = '{$ret['product_code']}' and shop_id = '{$shop}'")->execute()->as_array();
					if (count($arrRets) == 0)
					{
						$arrSmaregi['smaregi_product_id'] = $smaregi_id;//$ret['smaregi_product_id'];
						$arrSmaregi['size_name'] = $ret['size_name'];
						$arrSmaregi['color_name'] = $ret['color_name'];
		// 				$arrSmaregi['color_code'] = $ret['color_code'];
		// 				$arrSmaregi['size_code'] = $ret['size_code'];
						$arrSmaregi['product_code'] = $ret['product_code'];
						$arrSmaregi['dtb_product_sku_id'] = $ret['id'];
						$arrSmaregi['product_name'] = $ret['name'];
						$arrSmaregi['shop_id'] = $shop;
						$arrSmaregi['stock'] = $ret['stock'];
						$arrSmaregi['attribute'] = $ret['attribute'];
						$query = DB::insert('dtb_smaregi_product');
						$query->set($arrSmaregi)->execute();
					}
//				}

//					$arrItem['productId'] = $ret['smaregi_product_id'];
					$arrItem['categoryId'] = $ret['category_id'];
					$arrItem['productCode'] = $ret['product_code'];
					$arrItem['productName'] = $ret['name'];
					$arrItem['productKana'] = $ret['name_kana'];
					$arrItem['price'] = $ret['price01'];
					$arrItem['cost'] = $ret['cost_price'];
					$arrItem['stockControlDivision'] = $ret['stockControlDivision'];
					$arrItem['description'] = mb_substr($ret['info'],0, 200);
					if ($shop == 'brshop')
					{
						$arrItem['size'] = $ret['size_name'];
						$arrItem['color'] = $ret['color_name'];
						$arrItem['attribute'] = $ret['attribute'];
					}
					$arrItem['groupCode'] = $ret['group_code'];
		// 			$arrItem['taxDivision'] = 1;
		// 			$arrItem['productPriceDivision'] = 1;
					$res = Tag_Smaregi::regist($shop, $arrItem);
					$result = json_decode($res,true);
					$s = array();
					$s['shop_id'] = $arrSmaregi['shop_id'];
					$s['productId'] = $arrItem['productId'];
					$s['stockAmount'] = $arrSmaregi['stock'];
					usleep(500000);
	 				Tag_Smaregi::regist_stock($s, 2, "1", "05");
//var_dump("<br>regist:".$res."<br>");

				}
			}
			Log::debug($shop.': smaregi regist.');
			Log::debug($res);
		}
	
	}

	public static function select($product_code, $shop)
	{
		$send_data = array(
		    'proc_name' => 'product_ref',
		    'params' => '{"conditions":[{"productCode":"'.$product_code.'"}],"table_name":"Product"}',
		    //'params' => '{"conditions":[{"productId":"113"}],"table_name":"Product"}',
		);
		$res = Tag_Smaregi::send_api($shop, $send_data);
		
		return $res;
	}

	public static function regist($shop, $data_val, $tbl = 'Product')
	{
		$tbl_data = array();
		$send_data = array();
		$tbl_data['table_name'] = $tbl;
		
		$data = array();

		switch($tbl)
		{
			case 'Product':
				$data['salesDivision'] = 0;
				$data['stockControlDivision'] = 0;
				$data['taxDivision'] = 1;
				$data['productPriceDivision'] = 1;
				$data['displayFlag'] = 1;
				break;
			case 'Customer':
				break;
			case 'Category':
				break;
		}
		
		foreach($data_val as $k => $v)
		{
			$data[$k] = $v;
		}
		$data['customerPrice'] = null;
		
		$tbl_data['rows'] = $data;

		if ($tbl == 'Product')
		{
			$send_data = array(
			    'proc_name' => 'product_upd',
			    'params' => '{ "proc_info":{"proc_division":"U" },"data":[{"table_name":"Product","rows":['.json_encode($tbl_data['rows']).']}]}',
			);
		}
		else if ($tbl == 'Customer')
		{
			$send_data = array(
			    'proc_name' => 'customer_upd',
			    'params' => '{ "proc_info":{"proc_division":"U" },"data":[{"table_name":"Customer","rows":['.json_encode($tbl_data['rows']).']}]}',
			);
		}
		else if ($tbl == 'Category')
		{
			$send_data = array(
			    'proc_name' => 'category_upd',
			    'params' => '{ "proc_info":{"proc_division":"U" },"data":[{"table_name":"Category","rows":['.json_encode($tbl_data['rows']).']}]}',
			);
		}

		$res = Tag_Smaregi::send_api($shop, $send_data);

		return $res;
	}


	public static function unicode_decode($str) {
	  return preg_replace_callback("/((?:[^\x09\x0A\x0D\x20-\x7E]{3})+)/", "Tag_Smaregi::decode_callback", $str);
	}
	 
	public static function decode_callback($matches) {
	  $char = mb_convert_encoding($matches[1], "UTF-16", "UTF-8");
	  $escaped = "";
	  for ($i = 0, $l = strlen($char); $i < $l; $i += 2) {
	    $escaped .=  "\u" . sprintf("%02x%02x", ord($char[$i]), ord($char[$i+1]));
	  }
	  return $escaped;
	}
	 
	// 文字列のユニコードエンコードを行う
	public static function unicode_encode($str) {
	  return preg_replace_callback("/\\\\u([0-9a-zA-Z]{4})/", "Tag_Smaregi::encode_callback", $str);
	}
	 
	public static function encode_callback($matches) {
	  $char = mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UTF-16");
	  return $char;
	}

	public static function set_product($data)
	{
		Log::debug(var_export($data, true), true);
		$now = date('Y-m-d H:i:s');
		
		if (!is_array($data))
			return;
		foreach($data as $d)
		{
			$pname = Tag_Smaregi::unicode_encode($d['productName']);
			$pattribute = Tag_Smaregi::unicode_encode($d['attribute']);
			//Log::debug(str_replace('\\\\', '\\', $d['productName']));
			$sql = "UPDATE dtb_smaregi_product set product_code = '{$d['productCode']}', update_date = '{$now}', product_name = '{$pname}', attribute = '{$pattribute}' ";
			$sql .= " WHERE smaregi_product_id = {$d['productId']} ";
			$query = DB::query($sql);
			$arrRet = $query->execute();

			$sql = "UPDATE dtb_product_sku set product_code = '{$d['productCode']}', attribute = '{$pattribute}' ";
			$sql .= " WHERE product_code = (select product_code from dtb_smaregi_product where smaregi_product_id = {$d['productId']} LIMIT 1) ";
			$query = DB::query($sql);
			$arrRet = $query->execute();

			$sql = "UPDATE dtb_products set group_code = '{$d['groupCode']}', category_id = '{$d['categoryId']}',  name = '{$pname}' ";
			$sql .= " WHERE product_id in (select dtb_products_product_id from dtb_product_sku where product_code = '{$d['productCode']}') ";
			$query = DB::query($sql);
			$arrRet = $query->execute();
		}
	}
	public static function set_stock($data, $shop)
	{
		Log::debug(var_export($data, true), true);
		$now = date('Y-m-d H:i:s');
		
		foreach($data as $d)
		{
			if ($d['storeId'] == 2 || $d['storeId'] == 3)
				continue;
			$sql = "UPDATE dtb_smaregi_product set stock = {$d['stockAmount']}, update_date = '{$now}' ";
			$sql .= " WHERE smaregi_product_id = {$d['productId']}  and shop_id = '{$shop}'";
			$query = DB::query($sql);
			$arrRet = $query->execute();

			$sql = "UPDATE dtb_product_sku set stock = {$d['stockAmount']} ";
			$sql .= " WHERE product_code in (select product_code from dtb_smaregi_product where smaregi_product_id = {$d['productId']} and shop_id = '{$shop}') ";
			$query = DB::query($sql);
			$arrRet = $query->execute();
		}
	}
	public static function regist_stock($data_val, $mode = "1", $sid = "1", $division = "15")
	{		
		$shop = $data_val['shop_id'];
		unset($data_val['shop_id']);
		
		$tbl_data = array();
		$tbl_data['table_name'] = 'Stock';
		
		$data['storeId'] = $sid;
		$data['stockDivision'] = $division;

		foreach($data_val as $k => $v)
		{
//print_r($this->smaregi_pkeys[$k]);
			$data[$k] = $v;
		}

		$tbl_data['rows'] = $data;

		if ($mode == "1")
		{
			$send_data = array(
			    'proc_name' => 'stock_upd',
			    'params' => '{ "proc_info":{"proc_division":"U","proc_detail_division":"1" },"data":[{"table_name":"Stock","rows":['.json_encode($tbl_data['rows']).']}]}',
			);
		}
		else
		{
			$send_data = array(
			    'proc_name' => 'stock_upd',
			    'params' => '{ "proc_info":{"proc_division":"U","proc_detail_division":"2" },"data":[{"table_name":"Stock","rows":['.json_encode($tbl_data['rows']).']}]}',
			);
		}
//print_r($send_data);
//$fp = fopen("/var/www/vhosts/".$_SERVER['HTTP_HOST']."/html/smaregi/push".date("Ymd").".txt","a+");
//fwrite($fp,$_POST['proc_name']);
//if ($_POST['proc_name'] == 'product_send')
// 	fwrite($fp,date("Ymd H:i:s"));
// 	fwrite($fp,"   ".$send_data['proc_name'].PHP_EOL);
// 	fwrite($fp,"   ".$send_data['params'].PHP_EOL);
// 	fwrite($fp,"   ".$data_val['smaregi_product_id'].PHP_EOL);
// 	fwrite($fp,"   ".$data['productId'].PHP_EOL);
		$res = Tag_Smaregi::send_api($shop, $send_data);

//		$url = SMAREGI_URL;
// 		$url = SC_Helper_DB_Ex::getSmaregiURL($this->shop_mode);
// 		$headers = array(
//		    'X_contract_id: '.CONTRACT_ID,
//		    'X_access_token: '.ACCESS_TOKEN,
// 		    'X_contract_id: '.SC_Helper_DB_Ex::getSmaregiContractId($this->shop_mode),
// 		    'X_access_token: '.SC_Helper_DB_Ex::getSmaregiAccessToken($this->shop_mode),
// 		    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
// 		);
// 		$options = array('http' => array(
// 		    'method' => 'POST',
// 		    'content' => http_build_query($send_data),
// 		    'header' => implode("\r\n", $headers),
// 		));
// 
// 		$res = file_get_contents($url, false, stream_context_create($options));
// 		$result = json_decode($res);
//  		Log::debug(var_export($result, true));
/*		
		if ($res == '')
		{
			fwrite($fp,"wait".PHP_EOL);
			sleep(1);
			$res = file_get_contents($url, false, stream_context_create($options));
		}
		if ($res == '')
		{
			fwrite($fp,"wait".PHP_EOL);
			sleep(1);
			$res = file_get_contents($url, false, stream_context_create($options));
		}
		if ($res == '')
		{
			fwrite($fp,"wait".PHP_EOL);
			sleep(1);
			$res = file_get_contents($url, false, stream_context_create($options));
		}
		
	fwrite($fp,"   ".$res.PHP_EOL);
fclose($fp);
*/
	}

	public static function set_smaregi_order($smaregi_order_id, $order_id, $shop = 'brshop')
	{
		Log::debug($smaregi_order_id." : ".$order_id." : ".$shop, true);
		$query = DB::insert('dtb_smaregi_order');
		
		$smaregi = array();
		$smaregi['smaregi_order_id'] = $smaregi_order_id;
		$smaregi['order_id'] = $order_id;
		$smaregi['shop_url'] = $shop;
		$query->set($smaregi);
		$query->execute();

		Log::debug(var_export(DB::last_query(), true), true);
	}
	public static function get_smaregi_id($product_id, $color_code, $size_code)
	{
		$sql = "SELECT C.smaregi_product_id, C.product_code FROM dtb_products as A";
		$sql .= " JOIN dtb_product_sku as B ON A.product_id = B.dtb_products_product_id";
		$sql .= " JOIN dtb_smaregi_product as C ON C.product_code = B.product_code ";
		$where = " WHERE A.product_id = {$product_id} and C.smaregi_product_id  is not NULL "; 
		if ($size_code != '')
			$where .= " AND B.size_code = '{$size_code}' ";
		if ($color_code != '')
			$where .= " AND B.color_code = '{$color_code}' ";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
		Log::debug(DB::last_query());

		if (count($arrRet) > 0)
			return $arrRet[0];
		else
			return array();
	}
	public static function shop_tran($shop, $cart_ctrl)
	{
			Log::debug($shop." shop_tran()", true);

			$arrDval = array();

			$subtotal = 0;
			$smaregi_p = array();
			$detail = Tag_Order::get_order_detail($cart_ctrl->cart->getOrderId());
			$c = 1;
			foreach($detail as $d)
			{
				if ($shop != 'brshop')
				{
					if ($d['shop_id'] != $shop &&  $d['org_shop'] != $shop)
						continue;
				}
				
				$data_dval = array();
				$data_dval['transactionDetailId'] = $d['order_detail_id'];
				$data_dval['transactionDetailDivision'] = 1;
				$smaregi = Tag_Smaregi::get_smaregi_id($d['product_id'], $d['color_code'], $d['size_code']);
				
				if ($shop != 'brshop' && count($smaregi) == 0)
					continue;
	//		Profiler::console(DB::last_query());
	//			var_dump(DB::last_query());exit;
 				if (count($smaregi) != 0)
 				{
 					if ($d['shop_id'] == $shop || $d['org_shop'] == $shop)
 					{
						$data_dval['productId'] = $smaregi['smaregi_product_id'];		//商品ID
						$data_dval['productCode'] = $smaregi['product_code'];
					}
					$data_dval['productName'] = mb_substr($d['product_name'], 0, 80);
				}
				else
				{
					$data_dval['productCode'] = mb_substr($d['product_code'], 0, 20);
					$data_dval['productName'] = mb_substr($d['product_name'].' / '.$d['color_name'].' / '.$d['size_name'], 0, 80);
				}
				$data_dval['taxDivision'] = '1';
				$data_dval['price'] = $d['price'];
				$data_dval['salesPrice'] = $d['price'];
				$data_dval['quantity'] = $d['quantity'];
				if ($d['shop_id'] == 'brshop' || $d['org_shop'] == 'brshop')
					$data_dval['categoryId'] = Tag_Item::get_detail_category($d['product_id']);
				else
					$data_dval['categoryId'] = Tag_Item::get_shop_category($d['shop_id']);
				$data_dval['salesDivision'] = '0';
				$subtotal += $d['price']*$d['quantity'];
				
 				if (count($smaregi) != 0)
 				{
 					$arrTemp = array();
 					$arrTemp['productCode'] = $d['product_code'];
 					$arrTemp['quantity'] = $d['quantity'];
 					$arrTemp['productId'] = $smaregi['smaregi_product_id'];
 					$arrTemp['stockAmount'] = $d['quantity'];
 					$arrTemp['shop_id'] = $d['shop_id'];
 					$smaregi_p[] = $arrTemp;
 				}
				
				$arrDval[] = $data_dval;
			}

			if ($shop == 'brshop')
			{
				$data_val = array();
				$data_val['transactionHeadDivision'] = 1;
				$data_val['sumDivision'] = 2;
				$data_val['cancelDivision'] = 0;
//				$data_val['total'] =Tag_Util::taxin_cal($cart_ctrl->cart->getTotalPrice()) - $cart_ctrl->cart->getPointUse() + Tag_Util::taxin_cal($cart_ctrl->cart->getDelivfee()) + Tag_Util::taxin_cal($cart_ctrl->cart->getFee()) + Tag_Util::taxin_cal($cart_ctrl->cart->getLapping());
				$data_val['total'] = $cart_ctrl->cart->getTotalPricePayment(true, true);
				$dis_flg = false;
				$dis = $cart_ctrl->cart->getCouponA();
				if ($dis == 0)
				{
					$dis = $cart_ctrl->cart->getCouponB();
					if ($dis == 0)
					{
						$dis = $cart_ctrl->cart->getDiscount();
						if ($cart_ctrl->cart->getCouponCd() == null)
							$dis_flg = false;
						else
							$dis_flg = true;
					}
					else
					{
						$dis = $cart_ctrl->cart->getTotalPricePayment(false, true) - $cart_ctrl->cart->getTotalPricePayment(true, true);
					}
				}
				$data_val['subtotalDiscountPrice'] = $dis;//+ $cart_ctrl->cart->get;	//小計値引き
				if ($dis_flg)
					$data_val['subtotal'] = $cart_ctrl->cart->getTotalPrice(true) + $dis;// + $cart_ctrl->cart->getDiscount();
				else
					$data_val['subtotal'] = $cart_ctrl->cart->getTotalPrice(true);// + $cart_ctrl->cart->getDiscount();
				$data_val['pointDiscount'] =  $cart_ctrl->cart->getPointUse();		//ポイント値引き
				$data_val['taxExclude'] = Tag_Util::tax_cal($cart_ctrl->cart->getTotalPrice());		//外税
				$data_val['taxInclude'] = 0;		//内税
				$data_val['storeId'] = '2';
				$data_val['terminalId'] = '999';
				//$data_val['customerId'] = ;
				$data_val['terminalTranId'] = $cart_ctrl->cart->getOrderId();		//order_id
				$data_val['terminalTranDateTime'] = date('Y-m-d H:i:s');		//購入日時
				$data_val['sumDateTime'] = date('Y-m-d');		//購入日時
		//		$data_val['customerRank'] = '';		//会員ランク	
				$data_val['carriage'] = Tag_Util::taxin_cal($cart_ctrl->cart->getDelivfee());		//送料
				if ($cart_ctrl->cart->getLapping())
					$data_val['commission'] = Tag_Util::taxin_cal($cart_ctrl->cart->getFee()) + Tag_Util::taxin_cal(GIFT_FEE);	//手数料
				else
					$data_val['commission'] = Tag_Util::taxin_cal($cart_ctrl->cart->getFee());	//手数料
				$data_val['sellDivision'] = '1';
			}
			else
			{
				$data_val = array();
				$data_val['transactionHeadDivision'] = 1;
				$data_val['sumDivision'] = 2;
				$data_val['cancelDivision'] = 0;
				$data_val['subtotal'] = $subtotal;
				$data_val['subtotalDiscountPrice'] = 0;	//小計値引き
				$data_val['pointDiscount'] = 0;		//ポイント値引き
				$data_val['total'] =Tag_Util::taxin_cal($subtotal);
				$data_val['taxExclude'] = Tag_Util::tax_cal($subtotal);		//外税
				$data_val['taxInclude'] = 0;		//内税
				$data_val['storeId'] = '2';
				$data_val['terminalId'] = '999';
		//		$data_val['customerId'] = '';
				$data_val['terminalTranId'] = $cart_ctrl->cart->getOrderId();		//order_id
				$data_val['terminalTranDateTime'] = date('Y-m-d H:i:s');		//購入日時
				$data_val['sumDateTime'] = date('Y-m-d');		//購入日時
		//		$data_val['customerRank'] = '';		//会員ランク	
				$data_val['carriage'] = '0';		//送料
				$data_val['commission'] = '0';	//手数料
				$data_val['sellDivision'] = '1';
			}

			Log::debug(var_export($arrDval, true), true);
			Log::debug(count($arrDval)." arrDval count", true);

			if (count($arrDval) > 0)
			{
				$res = Tag_Smaregi::regist_transaction($data_val, $arrDval, $shop);
				$result = json_decode($res, true);
			
				$smaregi_order_id = $result['result']['TransactionHeadIds'][0];
				Log::debug($smaregi_order_id, true);
				Tag_Smaregi::set_smaregi_order($smaregi_order_id, $cart_ctrl->cart->getOrderId(), $shop);
				foreach($smaregi_p as $s)
				{
					if ($shop == $s['shop_id'])
					{
						Log::debug(var_export($s, true), true);
		 				Tag_Smaregi::regist_stock($s, 2, "2", "05");
		 				$s['stockAmount'] = $s['stockAmount'] * -1;
		 				Tag_Smaregi::regist_stock($s, 2, "1", "04");
		 			}
	 			}

			}
	}
	
	public static function shop_tran_admin($shop, $arrOrder, $cancelDivision = 0)
	{
			Log::debug($shop." shop_tran_admin()", true);

			$arrDval = array();

			$subtotal = 0;
			$smaregi_p = array();
			$detail = Tag_Order::get_order_detail($arrOrder['order_id']);
			foreach($detail as $d)
			{
				if ($shop != 'brshop')
				{
					Log::debug($d['shop_id']."::".$shop);
					if ($d['shop_id'] != $shop)
						continue;
				}
				
				$data_dval = array();
				if ($d['order_detail_id'] == null)
					$data_dval['transactionDetailId'] = $d['id'];
				else
					$data_dval['transactionDetailId'] = $d['order_detail_id'];
				if ($cancelDivision == 0)
					$data_dval['transactionDetailDivision'] = 1;
				else
					$data_dval['transactionDetailDivision'] = 2;
				$smaregi = Tag_Smaregi::get_smaregi_id($d['product_id'], $d['color_code'], $d['size_code']);
				
				if ($shop != 'brshop' && count($smaregi) == 0)
				{
					Log::debug($shop."::".count($smaregi));
					continue;
				}
	//		Profiler::console(DB::last_query());
	//			var_dump(DB::last_query());exit;
 				if (count($smaregi) != 0)
 				{
 					if ($d['shop_id'] == $shop)
 					{
						$data_dval['productId'] = $smaregi['smaregi_product_id'];		//商品ID
						$data_dval['productCode'] = $smaregi['product_code'];
					}
					$data_dval['productName'] = mb_substr($d['product_name'], 0, 80);
					Log::debug(var_export($data_dval, true), true);
				}
				else
				{
					$data_dval['productCode'] = mb_substr($d['product_code'], 0, 20);
					$data_dval['productName'] = mb_substr($d['product_name'].' / '.$d['color_name'].' / '.$d['size_name'], 0, 80);
				}
				$data_dval['taxDivision'] = '1';
				$data_dval['price'] = $d['price'];
				$data_dval['salesPrice'] = $d['price'];
				$data_dval['quantity'] = $d['quantity'];
				if ($d['shop_id'] == 'brshop')
					$data_dval['categoryId'] = Tag_Item::get_detail_category($d['product_id']);
				else
					$data_dval['categoryId'] = Tag_Item::get_shop_category($d['shop_id']);
				$data_dval['salesDivision'] = '0';
				$subtotal += $d['price']*$d['quantity'];
				
 				if (count($smaregi) != 0)
 				{
 					$arrTemp = array();
 					$arrTemp['productCode'] = $d['product_code'];
 					$arrTemp['quantity'] = $d['quantity'];
 					$arrTemp['productId'] = $smaregi['smaregi_product_id'];
 					$arrTemp['stockAmount'] = $d['quantity'];
 					$arrTemp['shop_id'] = $d['shop_id'];
 					$smaregi_p[] = $arrTemp;
 				}
				
				$arrDval[] = $data_dval;
			}
			
			if ($cancelDivision == 0)
				$cancel_price = 1;
			else
				$cancel_price = -1;

			if ($shop == 'brshop')
			{
				if ($arrOrder['discount'] == '')
					$arrOrder['discount'] = 0;
				if ($arrOrder['use_point'] == '')
					$arrOrder['use_point'] = 0;
				if ($arrOrder['gift_price'] == '')
					$arrOrder['gift_price'] = 0;
				if ($arrOrder['fee'] == '')
					$arrOrder['fee'] = 0;
				if ($arrOrder['deliv_fee'] == '')
					$arrOrder['deliv_fee'] = 0;

				$data_val = array();
				$data_val['transactionHeadDivision'] = 1;
				$data_val['sumDivision'] = 2;
				$data_val['cancelDivision'] = 0;
				if ($cancelDivision == 0)
					$data_val['subtotal'] = $arrOrder['total'] * $cancel_price;
				else
					$data_val['subtotal'] = ($arrOrder['total']/*+$arrOrder['discount']*/) * $cancel_price;
				
				if ($cancelDivision == 1)
					$data_val['subtotalDiscountPrice'] = Tag_Util::taxin_cal($arrOrder['discount']) * $cancel_price;//$arrOrder['discount'];//Tag_Util::taxin_cal($arrOrder['discount'])/* * $cancel_price*/;	//小計値引き
				else
					$data_val['subtotalDiscountPrice'] = Tag_Util::taxin_cal($arrOrder['discount']) * $cancel_price;	//小計値引き

				if ($cancelDivision == 0)
					$data_val['pointDiscount'] = $arrOrder['use_point'] * $cancel_price;		//ポイント値引き
				else
					$data_val['pointDiscount'] = $arrOrder['use_point'] * $cancel_price;		//ポイント値引き
				if ($cancelDivision == 0)
					$data_val['total'] = (Tag_Util::taxin_cal($arrOrder['total'] - $arrOrder['discount']) + Tag_Util::taxin_cal($arrOrder['deliv_fee']) + Tag_Util::taxin_cal($arrOrder['fee']) + Tag_Util::taxin_cal($arrOrder['gift_price']) - $arrOrder['use_point']) * $cancel_price;
				else
					$data_val['total'] = (Tag_Util::taxin_cal($arrOrder['total']) - Tag_Util::taxin_cal($arrOrder['discount']) - $arrOrder['use_point'] + Tag_Util::taxin_cal($arrOrder['deliv_fee']) + Tag_Util::taxin_cal($arrOrder['fee']) + Tag_Util::taxin_cal($arrOrder['gift_price'])) * $cancel_price;
				if ($cancelDivision == 0)
					$data_val['taxExclude'] = Tag_Util::tax_cal($arrOrder['total']) * $cancel_price;		//外税
				else
					$data_val['taxExclude'] = Tag_Util::tax_cal($arrOrder['total']) * $cancel_price;		//外税
				$data_val['taxInclude'] = 0;		//内税
				$data_val['storeId'] = '2';
				$data_val['terminalId'] = '999';
		//		$data_val['customerId'] = '';
				$data_val['terminalTranId'] = $arrOrder['order_id'];		//order_id
				if ($cancelDivision == 0)
					$data_val['terminalTranDateTime'] = date('Y-m-d H:i:s', strtotime($arrOrder['create_date']));		//購入日時
				else
					$data_val['terminalTranDateTime'] =  date('Y-m-d H:i:s', strtotime($arrOrder['create_date'].' +2 minute'));

				$data_val['sumDateTime'] = date('Y-m-d', strtotime($arrOrder['create_date']));		//購入日時
		//		$data_val['customerRank'] = '';		//会員ランク	
				$data_val['carriage'] = Tag_Util::taxin_cal($arrOrder['deliv_fee']) * $cancel_price;		//送料
				$data_val['commission'] = (Tag_Util::taxin_cal($arrOrder['fee']) + Tag_Util::taxin_cal($arrOrder['gift_price'])) * $cancel_price;	//手数料
				$data_val['sellDivision'] = '1';
				if ($cancelDivision != 0)
				{
					$sql = "select smaregi_order_id from dtb_smaregi_order where order_id = {$arrOrder['order_id']} and shop_url = '{$shop}'";
					$arrRet = DB::query($sql)->execute()->as_array();
					if (count($arrRet) > 0)
					{
						$data_val['disposeServerTransactionHeadId'] = intVal($arrRet[0]['smaregi_order_id']);
						$data_val['disposeDivision'] = 2;
					}
					else
						return 0;
				}
			}
			else
			{
				$data_val = array();
				$data_val['transactionHeadDivision'] = 1;
				$data_val['sumDivision'] = 2;
				$data_val['cancelDivision'] = 0;
				$data_val['subtotal'] = $subtotal * $cancel_price;
				$data_val['subtotalDiscountPrice'] = 0;	//小計値引き
				$data_val['pointDiscount'] = 0;		//ポイント値引き
				$data_val['total'] =Tag_Util::taxin_cal($subtotal) * $cancel_price;
				$data_val['taxExclude'] = Tag_Util::tax_cal($subtotal) * $cancel_price;		//外税
				$data_val['taxInclude'] = 0;		//内税
				$data_val['storeId'] = '2';
				$data_val['terminalId'] = '999';
		//		$data_val['customerId'] = '';
				$data_val['terminalTranId'] = $arrOrder['order_id'];		//order_id
				if ($cancelDivision == 0)
					$data_val['terminalTranDateTime'] = date('Y-m-d H:i:s', strtotime($arrOrder['create_date']));		//購入日時
				else
					$data_val['terminalTranDateTime'] =  date('Y-m-d H:i:s', strtotime($arrOrder['create_date'].' +1 minute'));
				$data_val['sumDateTime'] = date('Y-m-d', strtotime($arrOrder['create_date']));		//購入日時
		//		$data_val['customerRank'] = '';		//会員ランク	
				$data_val['carriage'] = '0';		//送料
				$data_val['commission'] = '0';	//手数料
				$data_val['sellDivision'] = '1';
				if ($cancelDivision != 0)
				{
					$sql = "select smaregi_order_id from dtb_smaregi_order where order_id = {$arrOrder['order_id']} and shop_url = '{$shop}'";
					$arrRet = DB::query($sql)->execute()->as_array();
					if (count($arrRet) > 0)
					{
						$data_val['disposeServerTransactionHeadId'] = intVal($arrRet[0]['smaregi_order_id']);
						$data_val['disposeDivision'] = 2;
					}
					else
						return 0;
				}
			}

			Log::debug(var_export($arrDval, true), true);
			Log::debug(count($arrDval)." arrDval count", true);

			$res = 0;
			if (count($arrDval) > 0)
			{
				$res = Tag_Smaregi::regist_transaction($data_val, $arrDval, $shop);
				$result = json_decode($res, true);
			
				$smaregi_order_id = $result['result']['TransactionHeadIds'][0];
				Log::debug($smaregi_order_id, true);
				if ($cancelDivision == 0)
					Tag_Smaregi::set_smaregi_order($smaregi_order_id, $arrOrder['order_id'], $shop);
// 				else
// 					Tag_Smaregi::set_smaregi_order($smaregi_order_id, $arrOrder['order_id'], $shop);
				foreach($smaregi_p as $s)
				{
					if ($shop == $s['shop_id'])
					{
						if ($cancelDivision == 0)
						{
							Log::debug(var_export($s, true), true);
			 				Tag_Smaregi::regist_stock($s, 2, "2", "05");
			 				$s['stockAmount'] = $s['stockAmount'] * -1;
			 				Tag_Smaregi::regist_stock($s, 2, "1", "04");
			 			}
			 			else
			 			{
							Log::debug(var_export($s, true), true);
			 				Tag_Smaregi::regist_stock($s, 2, "1", "05");
			 				$s['stockAmount'] = $s['stockAmount'] * -1;
			 				Tag_Smaregi::regist_stock($s, 2, "2", "04");
			 			}
		 			}
	 			}
				return $res;
			}
	}

	
	public static function regist_transaction($data_val, $data_dval, $shop = 'brshop')
	{
		$tbl_data = array();
		$tbl_data['table_name'] = 'TransactionHead';
/*
		$data_val['transactionHeadDivision'] = 1;
		$data_val['sumDivision'] = 2;
		$data_val['cancelDivision'] = 0;
		$data_val['subtotal'] = 16000;
		$data_val['subtotalDiscountPrice'] = 0;	//小計値引き
		$data_val['pointDiscount'] = 0;		//ポイント値引き
		$data_val['total'] = 17280;
		$data_val['taxExclude'] = 1280;		//外税
		$data_val['taxInclude'] = 0;		//内税
		$data_val['storeId'] = '2';
		$data_val['terminalId'] = '999';
//		$data_val['customerId'] = '';
		$data_val['terminalTranId'] = '3';		//order_id
		$data_val['terminalTranDateTime'] = date('Y-m-d H:i:s');		//購入日時
		$data_val['sumDateTime'] = date('Y-m-d');		//購入日時
//		$data_val['customerRank'] = '';		//会員ランク	
		$data_val['carriage'] = '0';		//送料
		$data_val['commission'] = '0';	//手数料
		$data_val['sellDivision'] = '1';


		$data_dval['transactionDetailId'] = '999';
		$data_dval['transactionDetailDivision'] = 1;
		$data_dval['productId'] = '29576';		//商品ID
		$data_dval['productCode'] = '20063720140184509999';
		$data_dval['productName'] = 'フランコ バッシ / ジャカード タイ(シルク)/U18I-E07/8';
		$data_dval['taxDivision'] = '1';
		$data_dval['price'] = '16000';
		$data_dval['salesPrice'] = '16000';
		$data_dval['quantity'] = '1';
		$data_dval['categoryId'] = '72';
		$data_dval['salesDivision'] = '0';
*/		

		$tbl_data['rows'] = $data_val;
		$tbl_data2['rows'] = $data_dval;

		$send_data = array(
		    'proc_name' => 'transaction_upd',
		    'params' => '{ "proc_info":{"proc_division":"U"},"data":[{"table_name":"TransactionHead","rows":['.json_encode($tbl_data['rows']).']},{"table_name":"TransactionDetail","rows":'.json_encode($tbl_data2['rows']).'}]}',
		);
		$res = Tag_Smaregi::send_api($shop, $send_data);
// 		$result = json_decode($res);
//  		Log::debug(var_export($result, true));

		return $res;
	}
	public static function regist_category($data)
	{
		$tbl = 'Category';
		$tbl_data['table_name'] = $tbl;
		//$tbl_data['rows'] = $data;
		$tbl_data['rows'] = array('categoryId'=>'1', 'categoryCode'=>'1', 'categoryName'=>'TESTTEST2');

		$send_data = array(
		    'proc_name' => 'category_upd',
	    	'params' => '{ "proc_info":{"proc_division":"U" },"data":[{"table_name":"Category","rows":['.json_encode($tbl_data['rows']).']}]}',
		);
		$res = Tag_Smaregi::send_api($shop, $send_data);
		
		return $res;
	}
	public static function send_api($shop, $send_data)
	{
		$arrTemp = Tag_Shop::get_shopdetail("A.login_id = '{$shop}'", 'B');
// 		var_dump($shopinfo);
// 		exit;
		if (count($arrTemp) == 0)
		{
			Log::debug($shop." Shop unknown.", true);
			return;
		}
		$shopinfo = $arrTemp[0];
		Log::debug($shop." name send_api.", true);
		Log::debug(var_export($shopinfo, true), true);
		Log::debug(var_export($send_data, true), true);
		
		$headers = array(
		    'X_contract_id: '.$shopinfo['login_id'],
		    'X_access_token: '.$shopinfo['secure_code'],
// 		    'X_contract_id: {$smaregiInfo['login_id']}',
// 		    'X_access_token: {$smaregiInfo['secure_code']}',
		    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
		);
		$options = array('http' => array(
		    'method' => 'POST',
		    'content' => http_build_query($send_data),
		    'header' => implode("\r\n", $headers),
		    'timeout' => 5,
		));

		$url = $shopinfo['url'];
// var_dump($url);
// exit;
		$res = @file_get_contents($url, false, stream_context_create($options));

	    preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
	    $statusCode = (int)$matches[1];
 		Log::debug($statusCode, true);
	    if ($statusCode !== 200) {
	    }
//var_dump($res);
 		$result = json_decode($res);
 		Log::debug(var_export($result, true), true);
 		
 		return $res;
	}
}

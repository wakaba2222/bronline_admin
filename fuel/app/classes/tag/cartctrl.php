<?php

// カート内情報操作
class Tag_Cartctrl
{
    public $cart;
    
    public function __construct()
    {
        $this->cart = new Tag_Cartorder();
    }

    public static function get_delivfee($deliv_id = '1')
    {
		$sql = " SELECT * FROM dtb_delivfee WHERE deliv_id = {$deliv_id}";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();

        if (count($arrRet) > 0)
            return $arrRet;
        return '';
    }
    
    public static function get_delivtime()
    {
		$sql = " SELECT * FROM dtb_delivtime";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();

        if (count($arrRet) > 0)
            return $arrRet;
        return '';
    }
    
    public static function get_allshop()
    {
		$sql = " SELECT B.stock_type,B.email,A.shop_name,A.login_id as shop_id from dtb_shop as A join dtb_stock_type as B ON A.dtb_stock_type_id = B.stock_type AND A.id = B.shop_id";
		$where = " WHERE shop_status <> 0 ";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();

        if (count($arrRet) > 0)
            return $arrRet;
        return '';
    }

    public static function get_shop_mail($shop)
    {
		$sql = " SELECT B.notify_email,B.stock_type,B.email,A.shop_name,A.login_id as shop_id from dtb_shop as A join dtb_stock_type as B ON A.dtb_stock_type_id = B.stock_type AND A.id = B.shop_id";
		$where = " WHERE A.login_id = '{$shop}'  AND shop_status <> 0";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();

        if (count($arrRet) > 0)
            return $arrRet[0];
        return '';
    }

    public function setSession()
    {
        //Session::set( 'cart_order', serialize( $this->cart ) );
        $_SESSION['cart_order'] = serialize( $this->cart );

		$cart = serialize($this->cart);
		$customer = @$_SESSION['customer'];
		
		if ($this->cart->getOrderId() != '')
		{
			$c = htmlspecialchars($cart, ENT_QUOTES);
			if ($customer != '')
				$customer = htmlspecialchars($customer, ENT_QUOTES);
//			$sql = "UPDATE dtb_order_temp SET cart_data = '{$c}' WHERE order_id = '{$this->cart->getOrderId()}'";
			$sql = "UPDATE dtb_order_temp SET cart_data = '{$c}', customer = '{$customer}' WHERE order_id = '{$this->cart->getOrderId()}'";
			$query = DB::query($sql);
			$ret = $query->execute();
		}
    }

    public function getSession()
    {
//$_SESSION['TRANSACTION_ID'] = null;
//unset($_SESSION['TRANSACTION_ID']);
//var_dump($_SESSION);
//        $this->cart = unserialize( Session::get( 'cart_order' ) );
        if ( isset( $_SESSION['cart_order']) && $_SESSION['cart_order'] != '' ) {
            $this->cart = unserialize( $_SESSION['cart_order'] );
        } else { 
        }
    }

    public function clearSession()
    {
        //unset($_SESSION['cart_order']);
        $_SESSION['cart_order'] = serialize( new Tag_Cartorder() );
    }
}

// カート内注文詳細情報
class Tag_Cartorderdetail
{
    private $product_id;// 商品ID
    private $product_code;// 商品ID
    private $shop;      // ショップ名
    private $orgshop;      // ショップ名
    private $brand_name;      // ブランド名
    private $brand_name_kana;      // ブランド名
    private $name;      // 商品名
    private $price;     // 価格
    private $image;
    private $size;      // サイズ
    private $color;     // 色
    private $size_code;      // サイズ
    private $color_code;     // 色
    private $quantity;  // 数量
    private $point_rate;  // ポイント
    private $sale_status;
    private $sale_rate;
    private $pay_off;	//お直し商品フラグ
    private $reservation_flg;	//予約商品フラグ

    public function setReservation( $reservation_flg )
    {
        $this->reservation_flg = $reservation_flg;
    }
    public function getReservation()
    {
        return $this->reservation_flg;
    }
    
    public function setPayOff( $pay_off )
    {
        $this->pay_off = $pay_off;
    }
    public function getPayOff()
    {
        return $this->pay_off;
    }

    public function setSaleStatus( $sale_status )
    {
        $this->sale_status = $sale_status;
    }
    public function getSaleStatus()
    {
        return $this->sale_status;
    }
    public function setSaleRate( $sale_rate )
    {
        $this->sale_rate = $sale_rate;
    }
    public function getSaleRate()
    {
        return $this->sale_rate;
    }


    public function setBrandName( $brand_name )
    {
        $this->brand_name = $brand_name;
    }
    public function getBrandName()
    {
        return $this->brand_name;
    }
    public function setBrandNameKana( $brand_name_kana )
    {
        $this->brand_name_kana = $brand_name_kana;
    }
    public function getBrandNameKana()
    {
        return $this->brand_name;
    }

    public function setImage( $image )
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }

    public function setPointRate( $point_rate )
    {
        $this->point_rate = $point_rate;
    }
    public function getPointRate()
    {
        if ($this->point_rate == '')
            $this->point_rate = 0;
        return $this->point_rate;
    }

    public function setProductCode( $product_code )
    {
        $this->product_code = $product_code;
    }
    public function getProductCode()
    {
        return $this->product_code;
    }
    // 商品ID(Setter/Getter)
    public function setProductId( $product_id )
    {
        $this->product_id = $product_id;
    }
    public function getProductId()
    {
        return $this->product_id;
    }
    // ショップ名(Setter/Getter)
    public function setShop( $shop )
    {
        $this->shop = $shop;
    }
    public function getShop()
    {
        return $this->shop;
    }
    // ショップ名(Setter/Getter)
    public function setOrgShop( $orgshop )
    {
        $this->orgshop = $orgshop;
    }
    public function getOrgShop()
    {
        return $this->orgshop;
    }
    // 商品名(Setter/Getter)
    public function setName( $name )
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    // 価格(Setter/Getter)
    public function setPrice( $price )
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    // サイズ(Setter/Getter)
    public function setSize( $size )
    {
        $this->size = $size;
    }
    public function getSize()
    {
        return $this->size;
    }
    public function getSizeCode()
    {
        return $this->size_code;
    }
    public function setSizeCode( $size_code )
    {
        $this->size_code = $size_code;
    }
    // 色(Setter/Getter)
    public function setColor( $color )
    {
        $this->color = $color;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setColorCode( $color_code )
    {
        $this->color_code = $color_code;
    }
    public function getColorCode()
    {
        return $this->color_code;
    }
    // 数量(Setter/Getter)
    public function setQuantity( $quantity )
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

    // 初期化
    public function __construct()
    {
        $this->product_id = ''; // 商品ID
        $this->shop = '';       // ショップ名
        $this->name = '';       // 商品名
        $this->price = 0;       // 価格
        $this->size = '';       // サイズ
        $this->color = '';      // 色
        $this->quantity = 0;    // 数量
        $this->sale_rate = 0;    // 数量
        $this->sale_status = 0;    // 数量
    }
}

// カート内注文情報
class Tag_Cartorder
{
    // 決済情報
    private $amount;        // 決済総額
    private $order_id;      // 注文番号（システム）
    
    private $payment_type;  // 決済方法
    private $coupon_cd;     // クーポンコード
    private $discount;     // クーポンコード
    public $discount_price;     // クーポンコード
    private $point_use_yn;  // ポイント使用
    private $point_use;     // ポイント数
    private $point_add;     // ポイント数
    private $specification; // 明細書
    private $receipt_name;  // 領収書宛名
    private $receipt_tadashi;   // 領収書但し
    private $simple_package;    // 簡易包装
    private $lapping;       // ギフトラッピング
    private $msg_card;      // メッセージカード
    private $msg_card_dtl;  // メッセージカード（内容）
    private $msg_contact;   // ご希望・ご連絡等

    // 会員情報
    private $member_id;     // 会員番号

    // GMOペイメント個別情報


    // 楽天ペイ個別情報


    // AmazonPay個別情報
    private $order_reference_id;    // Amazonログインで取得したOrderReferenceID
    private $access_token;          // Amazonログインで取得したAccessToken

    // 送付先情報
    private $customer_name;
    private $customer_name2;
    private $customer_kana;
    private $customer_kana2;
    private $company;
    private $pref;
    private $section;
    private $zip;
    private $zip2;
    private $address;
    private $address2;
    private $tel_number;
    private $email;
    private $customer_deliv_id;
    private $deliv_time;
    private $deliv_date;

    private $other_name;
    private $other_name2;
    private $other_kana;
    private $other_kana2;
    private $other_company;
    private $other_pref;
    private $other_section;
    private $other_zip;
    private $other_zip2;
    private $other_address;
    private $other_address2;
    private $other_tel_number;
    private $login_memory;

    public function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->discount_price = $discount;
    }
    public function getDiscount()
    {
        return $this->discount;
    }
    public function setPref( $pref )
    {
        $this->pref = $pref;
    }
    public function getPref()
    {
        return $this->pref;
    }
    // 配送先(Setter/Getter)
    public function setOtherPref( $other_pref )
    {
        $this->other_pref = $other_pref;
    }
    public function getOtherPref()
    {
        return $this->other_pref;
    }
    public function setOtherFlg( $login_memory )
    {
        $this->login_memory = $login_memory;
    }
    public function getOtherFlg()
    {
        return $this->login_memory;
    }
    public function setOtherTelNumber( $other_tel_number )
    {
        $this->other_tel_number = $other_tel_number;
    }
    public function getOtherTelNumber()
    {
        return $this->other_tel_number;
    }
    public function setOtherAddress( $other_address )
    {
        $this->other_address = $other_address;
    }
    public function getOtherAddress()
    {
        return $this->other_address;
    }
    public function setOtherAddress2( $other_address2 )
    {
        $this->other_address2 = $other_address2;
    }
    public function getOtherAddress2()
    {
        return $this->other_address2;
    }
    public function setOtherZip( $other_zip )
    {
        $this->other_zip = $other_zip;
    }
    public function getOtherZip()
    {
        return $this->other_zip;
    }
    public function setOtherZip2( $other_zip2 )
    {
        $this->other_zip2 = $other_zip2;
    }
    public function getOtherZip2()
    {
        return $this->other_zip2;
    }
    public function setOtherSection( $other_section )
    {
        $this->other_section = $other_section;
    }
    public function getOtherSection()
    {
        return $this->other_section;
    }
    public function setOtherCompany( $other_company )
    {
        $this->other_company = $other_company;
    }
    public function getOtherCompany()
    {
        return $this->other_company;
    }
    public function setOtherName( $other_name )
    {
        $this->other_name = $other_name;
    }
    public function getOtherName()
    {
        return $this->other_name;
    }
    public function setOtherName2( $other_name2 )
    {
        $this->other_name2 = $other_name2;
    }
    public function getOtherName2()
    {
        return $this->other_name2;
    }
    public function setOtherKana( $other_kana )
    {
        $this->other_kana = $other_kana;
    }
    public function getOtherKana()
    {
        return $this->other_kana;
    }
    public function setOtherKana2( $other_kana2 )
    {
        $this->other_kana2 = $other_kana2;
    }
    public function getOtherKana2()
    {
        return $this->other_kana2;
    }


 
    // 購入商品情報
    public $order_detail;

    public function getDelivFee()
    {
        $total = $this->getTotalPrice(true, true, false);

        $maxfee = 5000;
        $now = date('Ymd');
        
//        if ($now >= 20230401)
//        	$maxfee = 10000;
        
        if ($total >= $maxfee)
            return 0;

        $arrRet = Tag_Cartctrl::get_delivfee();
        $arrDelivFee = array();
        foreach($arrRet as $ret)
        {
            $arrDelivFee[$ret['pref']] = $ret['fee'];
        }
        //var_dump($this->getPref());exit;
        return $arrDelivFee[$this->getPref()];
    }
    
    public function getFee()
    {
        if ($this->getPaymentType() == 4)
            return 300;
        else
            return 0;
    }

    public function getTotalTax()
    {
        $total = $this->getTotalPricePayment(true, true) - $this->getTotalPricePayment(true, false);
//        $total = floor($this->getTotalPricePayment() * ((TAX_RATE)/100));
//         print("<pre>TAX:");
//         var_dump($total);
//         
//         print("</pre>");

        return $total;
    }

    public function getTotalPricePaymentWithTax()
    {
        $total = $this->getTotalPricePayment(true, true);
//         print("<pre>TOTAL:");
//         var_dump($total);
//         
//         print("</pre>");
        
        return $total;
    }
    public function getCouponA()
    {
        $discount = 0;
        if ($this->getCouponCd() != '')
        {
            $customer_id = $this->getMemberId();
            $arrRet = Tag_Campaign::get_check($customer_id, $this->getCouponCd(),-1);
            if (count($arrRet) > 0)
            {
                $discount = $arrRet[0]['discount'];
                $discount_p = $arrRet[0]['discount_p'];
                $product_ids = $arrRet[0]['product_ids'];
                
                if ($discount != '')
                {
                    return $discount;
                }
                else
                    return $discount;
            }
        }
        return $discount;
    }
    public function getCouponB()
    {
        $discount_p = 0;
        if ($this->getCouponCd() != '')
        {
            $customer_id = $this->getMemberId();
            $arrRet = Tag_Campaign::get_check($customer_id, $this->getCouponCd(),-1);
            
            if (count($arrRet) > 0)
            {
                $discount = $arrRet[0]['discount'];
                $discount_p = $arrRet[0]['discount_p'];
                $product_ids = $arrRet[0]['product_ids'];
                
                if ($discount_p != '')
                {
                    return $discount_p;
                }
                else
                    return $discount_p;
            }
        }
        return $discount_p;
    }
    public function getCouponC()
    {
        $product_ids = "";
        if ($this->getCouponCd() != '')
        {
            $customer_id = $this->getMemberId();
            $arrRet = Tag_Campaign::get_check($customer_id, $this->getCouponCd(),-1);
            
            if (count($arrRet) > 0)
            {
                $discount = $arrRet[0]['discount'];
                $discount_p = $arrRet[0]['discount_p'];
                $product_ids = $arrRet[0]['product_ids'];
                
                if ($product_ids != '')
                {
                    return $product_ids;
                }
            }
        }
        return $product_ids;
    }
    public function getCouponD()
    {
        $product_ids = "";
        $arrTemp = array();
        if ($this->getCouponCd() != '')
        {
            $customer_id = $this->getMemberId();
            $arrRet = Tag_Campaign::get_check($customer_id, $this->getCouponCd(),-1);
            
            $arrTemp = array();
            if (count($arrRet) > 0)
            {
                $products = explode(',', $arrRet[0]['not_products']);
                $shops = explode(',', $arrRet[0]['not_shops']);
                
                $arrTemp['not_products'] = $products;
                $arrTemp['not_shops'] = $shops;
            }
        }
        return $arrTemp;
    }
    public function getTotalPricePayment($discount = true, $tax = false)
    {
        $this->setDiscount(0);
        $total = $this->getTotalPrice($discount, $tax, true, $exclude);
//var_dump($discount);
        if ($discount)
        {
            $dis = $this->getDiscount();
            $this->setDiscount($dis + $this->getCouponA());
//            var_dump("A:".($dis + $this->getCouponA()));
            $total -= $this->getCouponA();
            $discount_p = $this->getCouponB();
            if ($discount_p > 0)
            {
                $totalp = floor($total * ($discount_p/100));
                $dis = $this->getDiscount();
                $this->setDiscount($dis + $totalp);
//              var_dump("B:".($this->getDiscount()));
                $total -= $totalp;
            }

			$total -= $this->getSalePrice($tax);
			$this->setDiscount($this->getSalePrice($tax));
            
//print('<pre>');
//var_dump($tax);
//var_dump($total);
//print('</pre>');
        }

        $total -= $this->getPointUse();
        if ($tax)
            $total += Tag_Util::taxin_cal($this->getDelivFee());
        else
            $total += $this->getDelivFee();

        if ($tax)
            $total += Tag_Util::taxin_cal($this->getFee());
        else
            $total += $this->getFee();
        
        if ($this->getLapping())
        {
            if ($tax)
                $total += Tag_Util::taxin_cal(GIFT_FEE);
            else
                $total += GIFT_FEE;
        }
        
        return $total + $exclude;
//        return $total;
    }
    
    public function getSalePrice($tax)
    {
        $customer_id = $this->getMemberId();
        
        if ($customer_id == 0 && $customer_id == '')
        	return 0;

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

		$customer = Tag_CustomerInfo::get_customer($customer_id);
		$sale_status = $customer['sale_status'];
		
		if (($sale_status == 1 && $sale_flg == 1) || ($sale_status == 2 && $vip_sale_flg == 1))
		{
	        $total = 0;
	        $discount_price = 0;
	        foreach($this->order_detail as $detail)
	        {
				if ($detail->getSaleStatus() >= 1 && $sale_status == $detail->getSaleStatus())
				{
					$price = Tag_Util::sale_cal($detail->getPrice(), $detail->getSaleRate());
					$total += $price * $detail->getQuantity();
					
					$p = floor($detail->getPrice() * ($detail->getSaleRate()/100));
					$discount_price += $p * $detail->getQuantity();
				}
	        }
	        
	        if ($tax)
		        return Tag_Util::taxin_cal($discount_price);
		    else
		        return $discount_price;
		}
		else
			return 0;
    }

    public function getSalePrice2($id, $tax)
    {
        $customer_id = $this->getMemberId();
        
        if ($customer_id == 0 && $customer_id == '')
        	return 0;

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

		$customer = Tag_CustomerInfo::get_customer($customer_id);
		$sale_status = $customer['sale_status'];
		
		if (($sale_status == 1 && $sale_flg == 1) || ($sale_status == 2 && $vip_sale_flg == 1))
		{
	        $total = 0;
	        $discount_price = 0;
	        foreach($this->order_detail as $detail)
	        {
	        	if ($id != $detail->getProductCode())
	        		continue;
				if ($detail->getSaleStatus() >= 1 && $sale_status == $detail->getSaleStatus())
				{
					$price = Tag_Util::sale_cal($detail->getPrice(), $detail->getSaleRate());
					$total += $price * $detail->getQuantity();
					
					$p = floor($detail->getPrice() * ($detail->getSaleRate()/100));
					$discount_price += $p * $detail->getQuantity();
				}
	        }
	        
	        if ($tax)
		        return Tag_Util::taxin_cal($discount_price);
		    else
		        return $discount_price;
		}
		else
			return 0;
    }

    public function getTotalPrice($discount = true, $tax = false, $ex = false, &$exclude = 0)
    {
        $this->setDiscount(0);
        $product_ids = array();
        if ($discount)
        {
            $product_ids = $this->getCouponC();
            if ($product_ids != '')
            {
                $product_ids = explode(',', $product_ids);
            }
            else
                $product_ids = array();

			$this->setDiscount($this->getSalePrice($tax));
        }
        
        $arrRet = $this->getCouponD();
        
        $not_products = array();
        $not_shops = array();

		if ($ex)
		{
			if (count($arrRet) > 0)
			{
				$not_products = $arrRet['not_products'];
				$not_shops = $arrRet['not_shops'];
			}
		}
//print('<pre>');
//var_dump($not_products);
//var_dump($this->order_detail);
//print('</pre>');
//exit;
        $customer_id = $this->getMemberId();
        
        $sale_status = 0;
        if ($customer_id != '' && $customer_id != 0)
        {
			$customer = Tag_CustomerInfo::get_customer($customer_id);
			$sale_status = $customer['sale_status'];
        }

        $total = 0;
        $discount_price = 0;
        foreach($this->order_detail as $detail)
        {
            $f = false;
            foreach($product_ids as $pid)
            {
                if ($pid == $detail->getProductId())
                {
                    $f = true;
                    $dis = $this->getDiscount();
                    $this->setDiscount($dis + $detail->getPrice());
//                    var_dump("C:".($dis + $this->getCouponA()));
                    break;
                }
            }

            $ff = false;
			if ($ex)
			{
	            foreach($not_products as $ppid)
	            {
					if ($detail->getProductId() == $ppid)
					{
						$ff = true;
					}
	            }
	            foreach($not_shops as $sid)
	            {
					if (Tag_Shop::get_shop_id($detail->getShop()) == $sid)
					{
						$ff = true;
					}
	            }
			}
//print('<pre>');
//var_dump($detail->getShop());
//var_dump($f);
//var_dump($ff);
//print('</pre>');
//exit;
//var_dump($tax);
//print('<pre>');
//var_dump($detail);
//print('</pre>');

            if ($tax)
            {
                if (!$f && !$ff)
                {
                	if ($detail->getSaleStatus() >= 1 && $sale_status == $detail->getSaleStatus())
                	{
//	                	$price = floor($detail->getPrice()*((100-$detail->getSaleRate())/100));
//print('<pre>');
//var_dump($price);
//print('</pre>');
//	                    $total += Tag_Util::taxin_cal($price * $detail->getQuantity());
	                    $total += Tag_Util::taxin_cal($detail->getPrice() * $detail->getQuantity());
                	}
                	else
                	{
	                    $total += Tag_Util::taxin_cal($detail->getPrice() * $detail->getQuantity());
                	}
                }
//                else
//                    $total += Tag_Util::taxin_cal($detail->getPrice() * ($detail->getQuantity()) - 1);
//                    $total += Tag_Util::taxin_cal($detail->getPrice() * ($detail->getQuantity()));

                if ($ff)
                {
                    $exclude += Tag_Util::taxin_cal($detail->getPrice() * $detail->getQuantity());
                }
            }
            else
            {
                if (!$f && !$ff)
                    $total += $detail->getPrice() * $detail->getQuantity();
//                else
//                    $total += $detail->getPrice() * ($detail->getQuantity() - 1);
//                    $total += $detail->getPrice() * ($detail->getQuantity());
                if ($ff)
                {
                    $exclude += $detail->getPrice() * $detail->getQuantity();
                }
            }
        }
//print('<pre>');
//var_dump($total);
//print('</pre>');
        
        return $total;
    }

    public function getTotalPoint()
    {
        $total = 0;
        $total_all = 0;
        $point = 0;
        $use = $this->getPointUse();
//        var_dump($use);
        foreach($this->order_detail as $detail)
        {
            $total = $detail->getPrice() * $detail->getQuantity();
            $total_all += $total;
            if ($total <= $use)
            {
                $use -= $total;
                $total = 0;
            }
            else if ($total > $use)
            {
                $total -= $use;
                $use = 0;
            }
            $c_id = $this->getMemberId();
            $p_rate = Tag_Item::get_point_rate($detail->getProductId());
            if ($c_id != 0 && $p_rate != 0)
            {
                $customer = Tag_CustomerInfo::get_customer($c_id);
                $c_rate = $customer['point_rate'];
                if ($c_rate > $p_rate)
                    $p_rate = $c_rate;
    
// var_dump($use);
				$dis = $this->getSalePrice2($detail->getProductCode(), false);
				$total -= $dis;
                $point += floor($total * ($p_rate / 100));
            }
        }

        $c_id = $this->getMemberId();
        if ($c_id > 0)
        {
	        $customer = Tag_CustomerInfo::get_customer($c_id);
	        $c_rate = $customer['point_rate'];
	
			$total_all -= $this->getCouponA();
			$total_all -= $this->getPointUse();
			$dis = $this->getSalePrice2($detail->getProductCode(), false);
			$total_all -= $dis;
			$point = floor($total_all * ($c_rate / 100));
        }
//var_dump($point_a);
// print("<pre>");
// var_dump($c_id);
// var_dump($c_rate);
// var_dump($total_all);
// print("<br>");
// var_dump($dis);
// print("<br>");
// var_dump($point);
// print("</pre>");

        $this->setPointAdd($point);
        return $point;
    }


    // 配送先(Setter/Getter)
    public function setCustomerEmail( $email )
    {
        $this->email = $email;
    }
    public function getCustomerEmail()
    {
        return $this->email;
    }

    // 配送先(Setter/Getter)
    public function setCustomerDelivId( $customer_deliv_id )
    {
        $this->customer_deliv_id = $customer_deliv_id;
    }
    public function getCustomerDelivId()
    {
        return $this->customer_deliv_id;
    }
    // 注文番号(Setter/Getter)
    public function setOrderId( $order_id )
    {
        $this->order_id = $order_id;
    }
    public function getOrderId()
    {
        return $this->order_id;
    }
    // 決済総額(Setter/Getter)
    public function setAmount( $amount )
    {
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    // 決済方法(Setter/Getter)
    public function setPaymentType( $payment_type )
    {
        $this->payment_type = $payment_type;
    }
    public function getPaymentType()
    {
        return $this->payment_type;
    }
    // クーポンコード(Setter/Getter)
    public function setCouponCd( $coupon_cd )
    {
        $this->coupon_cd = $coupon_cd;
    }
    public function getCouponCd()
    {
        return $this->coupon_cd;
    }
    // ポイント使用(Setter/Getter)
    public function setPointUseYN( $point_use_yn )
    {
        $this->point_use_yn = $point_use_yn;
    }
    public function getPointUseYN()
    {
        return $this->point_use_yn;
    }
    // ポイント数(Setter/Getter)
    public function setPointUse( $point_use )
    {
        $this->point_use = $point_use;
    }
    public function getPointUse()
    {
        if ($this->point_use == '')
            $this->point_use = 0;
        return $this->point_use;
    }
    // 加算ポイント数(Setter/Getter)
    public function setPointAdd( $point_add )
    {
        $this->point_add = $point_add;
    }
    public function getPointAdd()
    {
        if ($this->point_add == '')
            $this->point_add = 0;
        return $this->point_add;
    }
    // 明細書(Setter/Getter)
    public function setSpecification( $specification )
    {
        $this->specification = $specification;
    }
    public function getSpecification()
    {
        return $this->specification;
    }
    public function setDelivTime( $deliv_time )
    {
        $this->deliv_time = $deliv_time;
    }
    public function getDelivTime()
    {
        return $this->deliv_time;
    }
    public function setDelivDate( $deliv_date )
    {
        $this->deliv_date = $deliv_date;
    }
    public function getDelivDate()
    {
        return $this->deliv_date;
    }
    // 領収書宛名(Setter/Getter)
    public function setReceiptName( $receipt_name )
    {
        $this->receipt_name = $receipt_name;
    }
    public function getReceiptName()
    {
        return $this->receipt_name;
    }
    // 領収書但し(Setter/Getter)
    public function setReceiptTadashi( $receipt_tadashi )
    {
        $this->receipt_tadashi = $receipt_tadashi;
    }
    public function getReceiptTadashi()
    {
        return $this->receipt_tadashi;
    }
    // 簡易包装(Setter/Getter)
    public function setSimplePackage( $simple_package )
    {
        $this->simple_package = $simple_package;
    }
    public function getSimplePackage()
    {
        return $this->simple_package;
    }
    // ギフトラッピング(Setter/Getter)
    public function setLapping( $lapping )
    {
        $this->lapping = $lapping;
    }
    public function getLapping()
    {
        return $this->lapping;
    }
    // メッセージカード(Setter/Getter)
    public function setMsgCard( $msg_card )
    {
        $this->msg_card = $msg_card;
    }
    public function getMsgCard()
    {
        return $this->msg_card;
    }
    // メッセージカード内容(Setter/Getter)
    public function setMsgCardDtl( $msg_card_dtl )
    {
        $this->msg_card_dtl = $msg_card_dtl;
    }
    public function getMsgCardDtl()
    {
        return $this->msg_card_dtl;
    }
    // ご希望・ご連絡等(Setter/Getter)
    public function setMsgContact( $msg_contact )
    {
        $this->msg_contact = $msg_contact;
    }
    public function getMsgContact()
    {
        return $this->msg_contact;
    }
    // 会員番号(Setter/Getter)
    public function setMemberId( $member_id )
    {
        $this->member_id = $member_id;
    }
    public function getMemberId()
    {
        return $this->member_id;
    }
    // AmazonPay OrderReferenceId(Setter/Getter)
    public function setOrderReferenceId( $order_reference_id )
    {
        $this->order_reference_id = $order_reference_id;
    }
    public function getOrderReferenceId()
    {
        return $this->order_reference_id;
    }
    // AmazonPay AccessToken(Setter/Getter)
    public function setAccessToken( $access_token )
    {
        $this->access_token = $access_token;
    }
    public function getAccessToken()
    {
        return $this->access_token;
    }
    // 名前(Setter/Getter)
    public function setCustomerName( $customer_name )
    {
        $this->customer_name = $customer_name;
    }
    public function getCustomerName()
    {
        return $this->customer_name;
    }
    public function setCustomerName2( $customer_name2 )
    {
        $this->customer_name2 = $customer_name2;
    }
    public function getCustomerName2()
    {
        return $this->customer_name2;
    }
    // 名前(Setter/Getter)
    public function setCustomerKana( $customer_kana )
    {
        $this->customer_kana = $customer_kana;
    }
    public function getCustomerKana()
    {
        return $this->customer_kana;
    }
    public function setCustomerKana2( $customer_kana2 )
    {
        $this->customer_kana2 = $customer_kana2;
    }
    public function getCustomerKana2()
    {
        return $this->customer_kana2;
    }
    // 郵便番号(Setter/Getter)
    public function setZip( $zip )
    {
        $this->zip = $zip;
    }
    public function getZip()
    {
        return $this->zip;
    }
    public function setZip2( $zip2 )
    {
        $this->zip2 = $zip2;
    }
    public function getZip2()
    {
        return $this->zip2;
    }
    // 住所(Setter/Getter)
    public function setAddress( $address )
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress2( $address2 )
    {
        $this->address2 = $address2;
    }
    public function getAddress2()
    {
        return $this->address2;
    }
    // 電話番号(Setter/Getter)
    public function setTelNumber( $tel_number )
    {
        $this->tel_number = $tel_number;
    }
    public function getTelNumber()
    {
        return $this->tel_number;
    }
    // 会社名(Setter/Getter)
    public function setCompany( $company )
    {
        $this->company = $company;
    }
    public function getCompany()
    {
        return $this->company;
    }
    // 部署名(Setter/Getter)
    public function setSection( $section )
    {
        $this->section = $section;
    }
    public function getSection()
    {
        return $this->section;
    }
    // 購入商品情報(Setter/Getter)
    public function setOrderDetail( $detail )
    {
        $this->order_detail[] = $detail;
    }
    public function getOrderDetail()
    {
        return $this->order_detail;
    }

    // 初期化
    public function __construct()
    {
        // 決済情報
        $this->amount = 0;
        $this->order_id = '';

        $this->payment_type = '';
        $this->coupon_cd = '';
        $this->point_use_yn = '';
        $this->point_use = 0;
        $this->specification = '';
        $this->receipt_name = '';
        $this->receipt_tadashi = '';
        $this->simple_package = 0;
        $this->lapping = 0;
        $this->msg_card = 0;
        $this->msg_card_dtl = '';
        $this->msg_contact = '';
    
        // 会員情報
        $this->member_id = '';

        // GMOペイメント個別情報

        // 楽天ペイ個別情報

        // AmazonPay個別情報
        $this->order_reference_id = '';
        $this->access_token = '';

        // 送付先情報
        $this->customer_name = '';
        $this->customer_kana = '';
        $this->company = '';
        $this->section = '';
        $this->zip = '';
        $this->address = '';
        $this->tel_number = '';

        // 購入商品情報
        $this->order_detail = array();
    }
}
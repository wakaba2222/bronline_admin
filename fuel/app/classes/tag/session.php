<?php

class Tag_Session
{
	var $transactionid;

	function __construct()
	{
	}
	
	public static function setCheckItem($product_id)
    {
        $products = array();
        if (isset($_SESSION[CHECK_PRODUCTS]) && $_SESSION[CHECK_PRODUCTS] != '')
        {
            $products = unserialize($_SESSION[CHECK_PRODUCTS]);
        }
        
        $f = false;
        foreach($products as $p)
        {
            if ($p == $product_id)
                $f = true;
        }
        if (!$f)
            $products[] = $product_id;

        $_SESSION[CHECK_PRODUCTS] = serialize($products);
        Tag_Item::set_recommend($product_id, serialize($products));
    }
	public static function getCheckItem()
    {
        $products = array();
        if (isset($_SESSION[CHECK_PRODUCTS]) && $_SESSION[CHECK_PRODUCTS] != '')
        {
            $products = unserialize($_SESSION[CHECK_PRODUCTS]);
        }
        return $products;
    }

	public static function clearCheckItem()
    {
        unset($_SESSION[CHECK_PRODUCTS]);
    }

	public static function getToken()
	{
        if (empty($_SESSION[TRANSACTION_ID_NAME])) {
            $_SESSION[TRANSACTION_ID_NAME] = self::createToken();
        }
        return $_SESSION[TRANSACTION_ID_NAME];
	}

    public static function createToken()
    {
        return sha1(uniqid(rand(), true));
    }

    public static function getShop()
    {
    	if (isset($_SESSION['shop']))
	        return $_SESSION['shop'];
	    else
	    	return '';
    }

    public static function getShopType()
    {
    	if (isset($_SESSION['stock_type']))
	        return $_SESSION['stock_type'];
	    else
	    	return '';
    }

    public static function setShop($shop)
    {
        $_SESSION['shop'] = $shop;
    }

    public static function setShopType($stock_type)
    {
        $_SESSION['stock_type'] = $stock_type;
    }
    
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return null;        
    }

    public static function delete($key)
    {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    public static function isValidToken($is_unset = false)
    {
        // token の妥当性チェック
        $ret = false;
        if (isset($_REQUEST[TRANSACTION_ID_NAME]))
        {
            $ret = $_REQUEST[TRANSACTION_ID_NAME] === $_SESSION[TRANSACTION_ID_NAME];
        }
        else
            $ret = true;

        if (empty($_REQUEST[TRANSACTION_ID_NAME]) || empty($_SESSION[TRANSACTION_ID_NAME])) {
            $ret = false;
        }

//        if ($is_unset || $ret === false) {
//            SC_Helper_Session_Ex::destroyToken();
//        }

        return $ret;
    }
}
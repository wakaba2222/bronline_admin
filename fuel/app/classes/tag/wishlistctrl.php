<?php
class Tag_Wishlistctrl
{
	function __construct()
	{
	}

	/**
	 * お気に入り追加
	 * @param unknown $customer_id		顧客ID
	 * @param unknown $product_id		商品ID
	 * @return unknown
	 */
	public static function add_wish( $customer_id, $product_id ) {

		$ret = "";
		try {
			if( !self::is_regist_db($customer_id, $product_id)) {
				$sql = "INSERT INTO dtb_wishlist ( customer_id, product_id, create_date ) VALUES ( '{$customer_id}', '{$product_id}', '".date('Y-m-d H:i:s')."' ) ";
				$query = DB::query($sql);
				$ret = $query->execute();
			}
		} catch( Exception $e ) {
			$ret = $e->getMessage();
		}
		return $ret;
	}


	/**
	 * お気に入り削除
	 * @param unknown $customer_id		顧客ID
	 * @param unknown $product_id		商品ID
	 * @return unknown
	 */
	public static function del_wish( $customer_id, $product_id ) {

		try {
			$sql = "DELETE FROM dtb_wishlist ";
			$where = " WHERE customer_id = {$customer_id} AND product_id = {$product_id}";
			$query = DB::query($sql.$where);
			$ret = $query->execute();

		} catch( Exception $e ) {
			$ret = $e->getMessage();
		}
		return $ret;
	}


	/**
	 * お気に入りがDBに登録されているか
	 * @param unknown $customer_id		顧客ID
	 * @param unknown $product_id		商品ID
	 * @return boolean					true（登録あり）/ false（登録なし）
	 */
	public static function is_regist_db( $customer_id, $product_id ) {
		$sql = "SELECT * FROM dtb_wishlist ";
		$where = " WHERE customer_id = {$customer_id} AND product_id = {$product_id}";
		$query = DB::query($sql.$where);
		$ret = $query->execute();

		if( 0 < count($ret)) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * お気に入り一覧取得
	 * 		order_by : 登録日降順
	 * @param unknown $customer_id		顧客ID
	 * @return unknown
	 */
	public static function get_wish_list( $customer_id ) {

		$sql = "SELECT * FROM dtb_wishlist ";
		$where = " WHERE customer_id = {$customer_id}";
		$order = " ORDER BY create_date DESC ";
		$query = DB::query($sql.$where.$order);
		$arrRet= $query->execute()->as_array();

		return $arrRet;
	}


	/**
	 * お気に入り一覧商品ID取得（DB）
	 * 		order_by : 登録日降順
	 * @param unknown $customer_id		顧客ID
	 * @return unknown
	 */
	public static function get_wish_product_id_list( $customer_id ) {

		$sql = "SELECT * FROM dtb_wishlist ";
		$where = " WHERE customer_id = {$customer_id}";
		$order = " ORDER BY create_date DESC ";
		$query = DB::query($sql.$where.$order);
		$ret = $query->execute()->as_array();

		$arrRet = array();
		foreach ($ret as $r ) {
			$arrRet[] = $r['product_id'];
		}

		return $arrRet;
	}


	/**
	 * お気に入り一覧商品ID取得（cookie）
	 * @return unknown
	 */
	public static function get_wish_product_id_list_cookie() {

		$arrRet = array();

		$strPid = Cookie::get('pid', "");

		$arrTmp = array();
		if($strPid != "") {
			$arrTmp = explode(',', $strPid);
		}
		foreach ( $arrTmp as $k => $v ) {
			if( $v != "") {
				$arrRet[] = $v;
			}
		}

		return $arrRet;
	}



	/**
	 * お気に入り一覧取得（mypage表示）
	 * @param unknown $customer_id		顧客ID
	 * @param unknown $page				取得ページ
	 * @param unknown $post_per_page	１ページ取得数
	 * @return unknown
	 */
	public static function get_mypage_wish_list( $customer_id, $page = 1, $post_per_page = 30, $where = '' ) {

		// 取得ページ
		$offset = ($page -1) * $post_per_page;

		$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM dtb_products as A JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id ";
		if ($customer_id != '0')
		{
			$sql .= " JOIN dtb_wishlist as F ON A.product_id = F.product_id ";
			$where = " WHERE F.customer_id = {$customer_id} AND first = 1 ";
		}
		else
		{
			$where = " WHERE first = 1 AND ".$where;
		}
		$group = " GROUP BY A.product_id ";
		if ($customer_id != '0')
			$order = " ORDER BY F.create_date DESC ";
		else
			$order = " ORDER BY A.update_date DESC ";
		$limit = " LIMIT ".$offset.", ".$post_per_page;

		$query = DB::query($sql.$where.$group.$order.$limit);
		$arrRet = $query->execute()->as_array();

		$query2 = DB::query("SELECT FOUND_ROWS()");
		$arrRet2 = $query2->execute()->as_array();
		$maxCount = $arrRet2[0]['FOUND_ROWS()'];

		// 戻り値設定
		$arrResult = array();
		$arrResult["arrWishData"] = $arrRet;
		$arrResult["recordNum"] = count($arrRet);
		$arrResult["maxRecordNum"] = $maxCount;
		$arrResult["pageNum"] = $page;
		$arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

		/*
		echo "<pre>";
		print_r($arrResult);
		echo "</pre>";
		*/

		return $arrResult;
	}


	/**
	 * cookieのお気に入りをDBに登録
	 * 		ログイン時に使用
	 * @param unknown $customer_id
	 */
	public static function add_wish_cookie2db( $customer_id ) {

		// cookieからお気に入り取得
		$arrPid = self::get_wish_product_id_list_cookie();

		// DBに追加
		foreach ( $arrPid as $product_id ) {
			self::add_wish($customer_id, $product_id);
		}

		// DBのお気に入りをcookieに書き込み
		self::set_wish_db2cookie($customer_id);
	}


	/**
	 * DBのお気に入りをcookieに書き込む
	 * @param unknown $customer_id
	 */
	public static function set_wish_db2cookie( $customer_id ) {
		// DBからお気に入り取得
		$newArrPid = self::get_wish_product_id_list($customer_id);
		$newStrPid = implode(',', $newArrPid);

		// cookieに書き込み
		Cookie::set('pid', $newStrPid, null, '/');
	}


}

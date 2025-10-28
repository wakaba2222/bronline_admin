<?php

class Brvalidate {

	/**
	 * dtb_customer にメールアドレスが登録されていないかチェックする
	 *
	 * @param unknown $val
	 * @return boolean
	 */
	public static function _validation_customer_unique_email( $val )
	{
		$result = DB::select()->from('dtb_customer')->where('email', $val)->where('del_flg', 0)->execute()->as_array();

		if( 0 < count($result)) {
			return false;
		} else {
			return true;
		}
	}


	/**
	 * 必須チェック
	 * 		required をチェック内容は一緒
	 * 		エラーメッセージを「選択されていません」にするため
	 * @param unknown $val
	 * @return boolean
	 */
	public static function _validation_required_select($val)
	{
		return ! ($val === false or $val === null or $val === '' or $val === array());
	}


	/**
	 * カナ文字チェック
	 * @param unknown $val
	 * @param unknown $options
	 * @return unknown
	 */
	public static function _validation_kana_only($val, $options = null)
	{
		mb_regex_encoding("UTF-8");
		return mb_ereg("^[ァ-ヶー 　]+$", $val);
	}


	/**
	 * 数字チェック
	 * @param unknown $val
	 * @param unknown $options
	 * @return boolean
	 */
	public static function _validation_number_only($val, $options = null)
	{
		if(preg_match('/^[0-9]+$/', $val))
		{
			return true;
		} else {
			return false;
		}
	}


	/**
	 * 半角英数チェック
	 * @param unknown $val
	 * @param unknown $options
	 * @return boolean
	 */
	public static function _validation_ipass($val, $options = null)
	{
		if(preg_match('/^[a-zA-Z0-9]+$/', $val))
		{
			return true;
		} else {
			return false;
		}
	}


}
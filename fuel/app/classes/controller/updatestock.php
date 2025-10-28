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

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_UpdateStock extends ControllerPage
{
	/**
	 * ご注文について
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

try {
  $store_cd = Input::param('StoreAccount');
  $code = Input::param('Code');
  $stock = Input::param('Stock');
  $ts = Input::param('ts');
  $sig = Input::param('sig');

  $result_str = '<?xml version="1.0" encoding="EUC-JP"?>';
  $result_str .= '<ShoppingUpdateStock version="1.0">';
  $result_str .= '<ResultSet TotalResult="1">';
  $result_str .= '<Request>';
  $result_str .= '<Argument Name="StoreAccount" Value="' . $store_cd . '" />';
  $result_str .= '<Argument Name="Code" Value="' . $code . '" />';
  $result_str .= '<Argument Name="Stock" Value="' . $stock . '" />';
  $result_str .= '<Argument Name="ts" Value="' . $ts . '" />';
  $result_str .= '<Argument Name="sig" Value="' . $sig . '" />';
  $result_str .= '</Request>';

  if (($store_cd == '') || ($code == '') || ($ts == '') || ($sig == '')) {
    $result_str .= '<Result No="1">';
    $result_str .= '<Processed>1</Processed>';
    $result_str .= '</Result>';
    $result_str .= '<Message>パラメータが不足しています[2.11c]</Message>';
  } else {
    //パラメータチェック
    $sign_array = array();
    array_push($sign_array, "StoreAccount=" . $store_cd);
    array_push($sign_array, "Code=" . $code);
    array_push($sign_array, "Stock=" . $stock);
    array_push($sign_array, "ts=" . $ts);
    $md5_data = md5(implode("&",$sign_array) . "1234567890");

		$sql = "select * from dtb_product_sku where id = {$code} ";
		$arrRet = DB::query($sql)->execute()->as_array();
		
		if (count($arrRet) == 0)
		{
	        $result_str .= '<Result No="1">';
	        $result_str .= '<Processed>1</Processed>';
	        $result_str .= '</Result>';
	        $result_str .= '<Message>該当の商品がありません[2.11c]</Message>';
		}
		else
		{
	        $sqlval = array();
	
	        if ($stock == '') {
	          $sqlval['stock'] = null;
	          $sqlval['stock_unlimited'] = 1;
	        } else {
	        	//インジェクション対策で数値にキャスト
	//          $sqlval['stock'] = $stock;
	          $sqlval['stock'] = intval($stock);
	        }
	//        $where = "product_code = '$code'";
	//        $where = "product_class_id = $code";
			$ret = DB::update('dtb_product_sku')->set($sqlval)->where('id', '=', $code)->execute();
				
	        if ($ret == '1') {
	          $result_str .= '<Result No="1">';
	          $result_str .= '<Processed>0</Processed>';
	          $result_str .= '</Result>';
	        } else if ($ret == '0') {
	          $result_str .= '<Result No="1">';
	          $result_str .= '<Processed>0</Processed>';
	          $result_str .= '</Result>';
	        } else {
	          $result_str .= '<Result No="1">';
	          $result_str .= '<Processed>1</Processed>';
	          $result_str .= '</Result>';
	          $result_str .= '<Message>在庫数の更新に失敗しました[2.11c]</Message>';
	        }
        }
		$result_str .= '</ResultSet>';
		$result_str .= '</ShoppingUpdateStock>';

}
} catch (Exception $e){
  $errMsg = $e->getMessage();
  $result_str = '<?xml version="1.0" encoding="EUC-JP"?>';
  $result_str .= '<ShoppingUpdateStock version="1.0">';
  $result_str .= '<ResultSet TotalResult="1">';
  $result_str .= '<Request>';
  $result_str .= '<Argument Name="StoreAccount" Value="' . $store_cd . '" />';
  $result_str .= '<Argument Name="Code" Value="' . $code . '" />';
  $result_str .= '<Argument Name="Stock" Value="' . $stock . '" />';
  $result_str .= '<Argument Name=".ts" Value="' . $ts . '" />';
  $result_str .= '<Argument Name=".sig" Value="' . $sig . '" />';
  $result_str .= '</Request>';
  $result_str .= '<Result No="1">';
  $result_str .= '<Processed>1</Processed>';
  $result_str .= '</Result>';
  $result_str .= '<Message>' . $errMsg . '</Message>';
  $result_str .= '</ResultSet>';
  $result_str .= '</ShoppingUpdateStock>';
}

		$arrResult['msg'] = $result_str;
		
		$tpl = 'smarty/next/index.tpl';
		
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
		//return Response::forge(Presenter::forge('home/404'), 404);
        return View_Smarty::forge('smarty/misc/404.tpl');
		//		return Response::forge(Presenter::forge('home/404'), 404);
	}
}

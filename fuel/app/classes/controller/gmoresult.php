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
class Controller_GmoResult extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$arrResult = array();
		
//		var_dump(Input::param());

		if (Input::method() == 'POST')
		{
			$keys = array(
				'ShopID',
				'ShopPass',
				'AccessID',
				'OrderID',
				'Status',
				'JobCd',
				'Amount',
				'Tax',
				'Currency',
				'Method',
				'PayTimes',
				'TranID',
				'Approve',
				'TranDate',
				'ErrCode',
				'ErrInfo',
				'PayType',
				'Forward',
				'AccessPass'
				);

			$post = Input::param();
			
			$arrItem = array();
			foreach($keys as $k)
			{
				$arrItem[$k] = $post[$k];
			}

			$arrResult['ret'] = "0";
			$arrRet = DB::insert('dtb_gmo_result')->set($arrItem)->execute();
			if (!$arrRet)
				$arrResult['ret'] = "1";
		}
		else
		{
			$arrResult['ret'] = "1";
		}

		$tpl = 'smarty/gmo/index.tpl';

		return View_Smarty::forge( $tpl, $arrResult, false );
	}
}

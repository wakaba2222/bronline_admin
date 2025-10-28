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
class Controller_Guide extends ControllerPage
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

		$tpl = 'smarty/guide/index.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_stage()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/stage.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * お支払いについて
	 *
	 * @return unknown
	 */
	public function action_payment()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/payment.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * 送料・お届け
	 *
	 * @return unknown
	 */
	public function action_delivery()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/delivery.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * 返品・交換
	 *
	 * @return unknown
	 */
	public function action_return()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/return.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * サイズガイド
	 *
	 * @return unknown
	 */
	public function action_size()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/size.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * ポイントについて
	 *
	 * @return unknown
	 */
	public function action_point()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/guide/point.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

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

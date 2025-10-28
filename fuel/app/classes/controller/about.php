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
class Controller_About extends ControllerPage
{
	/**
	 * B.R.ONLINEについて
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/index.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	public function action_ad()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/ad.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	public function action_recruit()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/recruit.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

	/**
	 * B.R.MALL出店について
	 *
	 * @return unknown
	 */
	public function action_partner()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/partner.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * 利用規約
	 *
	 * @return unknown
	 */
	public function action_terms()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/terms.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * 個人情報保護方針
	 *
	 * @return unknown
	 */
	public function action_privacy()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/privacy.tpl';

		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	/**
	 * 特定商取引法に基づく表記
	 *
	 * @return unknown
	 */
	public function action_legal()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/about/legal.tpl';

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

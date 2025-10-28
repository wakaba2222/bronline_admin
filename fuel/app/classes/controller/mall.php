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
class Controller_Mall extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$tpl = 'smarty/mall/index.tpl';

		// ショップアカウントのユーザーIDを取得
		$arrShopUserId = array();
		$arrShopUser = get_shop_user_list( "", 1);
		foreach ( $arrShopUser['arrUsers'] as $user ) {
			$arrShopUserId[] = $user['ID'];
		}

		try
		{
			$cache = hash('sha256', 'u'.serialize($arrShopUserId));
//var_dump($cache);
			return Cache::get('mall'.$cache);
		}
		catch(\CacheNotFoundException $e)
		{
			Cache::delete('mall'.$cache);
		}

		$user_id = implode(",", $arrShopUserId);

		$arrResult['arrStyleSnap'] = get_style_snap_list( 12, 1, "", implode(",", $arrShopUserId));			// STYLE SNAP
//		$arrResult['arrEditorsChoice'] = get_editors_choice_list( 12, 1, "", implode(",", $arrShopUserId));	// EDITORS CHOICE
		$arrResult['arrBlog'] = get_blog_article_list( 12, 1, "", "");				// BLOG 12記事

		$arrResult['justin'] = Tag_Item::get_justin();	//Justinの取得
		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		Cache::set('mall'.$cache,View_Smarty::forge( $tpl, $arrResult, false ),120);

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	public function action_shoptop()
	{
		$debug = array();
		$arrResult = array();

		$shop		= Uri::segment(2);
		$arrResult['shop_url'] = $shop;
		$arrResult['shop_name'] = $shop;		//:TODO 後で、EC側で管理しているショップ名を入れる
		$arrShop = Tag_Shop::get_shopdetail("A.login_id = '".$shop."'");
//		var_dump($arrShop);
		if (@$arrShop[0]['shop_status'] == 0)
			Response::redirect('/404', 'location', 301);
		else if (!isset($arrShop[0]))
			Response::redirect('/404', 'location', 301);



		// ショップアカウントのユーザーIDを取得
		$arrShopUserId = array();
		$arrShopUser = get_shop_user_list( $shop, 1);
		foreach ( $arrShopUser['arrUsers'] as $user ) {
			$arrShopUserId[] = $user['ID'];
		}
		$user_id = implode(",", $arrShopUserId);

		// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得
		$arrResult['article_num'] = get_article_num($user_id);


		$page		= Input::param('page', 1);		// FEATURE 取得ページ
		$order		= Input::param('order', '');	// FEATURE 並び替え
		$arrResult['page'] = $page;
		$arrResult['order'] = $order;

		if (@$arrShop[0]['shop_status'] == '1')
			$tpl = 'smarty/mall/brshop/index.tpl';
		else if (@$arrShop[0]['shop_status'] == '2')
		{
//var_dump(@$arrShop[0]['shop_status']);
			$tpl = 'smarty/mall/'.$shop.'/standingby.tpl';
//var_dump($tpl);
			if (file_exists(dirname( __FILE__ )."/../../views/".$tpl))
				$tpl = 'smarty/mall/'.$shop.'/standingby.tpl';
			else
				$tpl = 'smarty/mall/brshop/index.tpl';
		}

		$arrResult['arrFeature'] = get_feature_list( 5, $page, $order, "", $user_id, 1);	// FEATURE 1ページ5記事
		$arrResult['arrStyleSnap'] = get_style_snap_list( 12, 1, "", $user_id);				// STYLE SNAP 12記事
//		$arrResult['arrEditorsChoice'] = get_editors_choice_list( 12, 1, "", $user_id);		// EDITORS CHOICE 12記事
		$arrResult['arrBlog'] = get_blog_article_list( 12, 1, "", $user_id);				// BLOG 12記事

		$arrResult['justin'] = Tag_Item::get_justin(" AND C.login_id = '".$shop."' ");	//Justinの取得
		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['debug'] = $debug;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}

}

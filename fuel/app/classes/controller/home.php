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
class Controller_Home extends ControllerPage
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

		$page		= Input::param('page', 1);		// FEATURE 取得ページ
		$order		= Input::param('order', '');	// FEATURE 並び替え
		$arrResult['page'] = $page;
		$arrResult['order'] = $order;

		$tpl = 'smarty/index.tpl';

		try
		{
			$cache = hash('sha256', 'p'.$page.'o'.$order);
			return Cache::get('home'.$cache);
		}
		catch(\CacheNotFoundException $e)
		{
			Cache::delete('home'.$cache);
		}
// 		//カートの数更新
// 		$cartctrl = new Tag_Cartctrl();
// 		$cartctrl->getSession();
// 		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		$arrResult['arrFeature'] = get_feature_list( 5, $page, $order);		// FEATURE 1ページ5記事
		$arrResult['arrStyleSnap'] = get_style_snap_list( 12 );				// STYLE SNAP 12記事
//		$arrResult['arrEditorsChoice'] = get_editors_choice_list( 12 );		// EDITORS CHOICE 12記事
		$arrResult['arrBlog'] = get_blog_article_list( 12, $page, "", "" );	// 1ページ12記事

//var_dump($arrResult['arrStyleSnap']);


		$arrResult['justin'] = Tag_Item::get_justin();	//Justinの取得
		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得

		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		$arrResult['debug'] = $debug;

		Cache::set('home'.$cache,View_Smarty::forge( $tpl, $arrResult, false ),120);

		return View_Smarty::forge( $tpl, $arrResult, false );
	}
/*
	public function action_index_test()
	{
//$start = microtime(true);

		$debug = array();
		$arrResult = array();

		$page		= Input::param('page', 1);		// FEATURE 取得ページ
		$order		= Input::param('order', '');	// FEATURE 並び替え
		$arrResult['page'] = $page;
		$arrResult['order'] = $order;

		$tpl = 'smarty/index.tpl';

		try
		{
			$cache = hash('sha256', 'p'.$page.'o'.$order);

			return Cache::get('home'.$cache);
		}
		catch(\CacheNotFoundException $e)
		{
			Cache::delete('home'.$cache);
		}
//		$cache = 'p'.$page.'o'.$order;
//var_dump($cache);

// 		//カートの数更新
// 		$cartctrl = new Tag_Cartctrl();
// 		$cartctrl->getSession();
// 		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());
		$redis = Redis_Db::forge();
//var_dump($redis);		
		$time = date('YmdHis');
		$dest_time = @$redis->get('feature_time'.$cache);
		
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('feature'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = get_feature_list( 5, $page, $order);		// FEATURE 1ページ5記事
			
			$redis->set('feature'.$cache, serialize($arrRet));
			$redis->set('feature_time'.$cache, date('YmdHis'));
		}
		$arrResult['arrFeature'] = $arrRet;

//		$arrResult['arrFeature'] = get_feature_list( 5, $page, $order);		// FEATURE 1ページ5記事

//$end = microtime(true);
//$sec = (float)($end - $start);
//$this->debug('SET 1 処理時間 = ' . $sec . ' 秒 '.session_id());

		$time = date('YmdHis');
		$dest_time = @$redis->get('style_snap_time'.$cache);
		
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('style_snap'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = get_style_snap_list( 12 );				// STYLE SNAP 12記事
			
			$redis->set('style_snap'.$cache, serialize($arrRet));
			$redis->set('style_snap_time'.$cache, date('YmdHis'));
		}
		$arrResult['arrStyleSnap'] = $arrRet;
//		$arrResult['arrStyleSnap'] = get_style_snap_list( 12 );				// STYLE SNAP 12記事

//		$arrResult['arrEditorsChoice'] = get_editors_choice_list( 12 );		// EDITORS CHOICE 12記事
//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 2 処理時間 = ' . $sec . ' 秒 '.session_id());

		$time = date('YmdHis');
		$dest_time = @$redis->get('blog_time'.$cache);
		
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('blog'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 2.5 処理時間 = ' . $sec . ' 秒 '.session_id());
			$arrRet = get_blog_article_list( 12, $page, "", "" );	// 1ページ12記事
			
			$redis->set('blog'.$cache, serialize($arrRet));
			$redis->set('blog_time'.$cache, date('YmdHis'));
		}
		$arrResult['arrBlog'] = $arrRet;
//		$arrResult['arrBlog'] = get_blog_article_list( 12, $page, "", "" );	// 1ページ12記事

//var_dump($arrResult['arrStyleSnap']);

//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 3 処理時間 = ' . $sec . ' 秒 '.session_id());

		$time = date('YmdHis');
		$dest_time = @$redis->get('justin_time'.$cache);
		
		if (($time - $dest_time) <= 90)
		{
			$arrRet = @unserialize($redis->get('justin'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 3.5 処理時間 = ' . $sec . ' 秒 '.session_id());
			$arrRet = Tag_Item::get_justin();	//Justinの取得
//		Log::debug(DB::last_query());
//$this->debug(DB::last_query());
//$this->debug(PHP_EOL.'SET 3.5 処理時間 = ' . $sec . ' 秒 '.session_id());
			
			$redis->set('justin'.$cache, serialize($arrRet));
			$redis->set('justin_time'.$cache, date('YmdHis'));
		}
		$arrResult['justin'] = $arrRet;
//		$arrResult['justin'] = Tag_Item::get_justin();	//Justinの取得

//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 4 処理時間 = ' . $sec . ' 秒 '.session_id());

		$time = date('YmdHis');
		$dest_time = @$redis->get('attention_time'.$cache);
		
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('attention'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = get_attention();	// ATTENTIONの取得
			
			$redis->set('attention'.$cache, serialize($arrRet));
			$redis->set('attention_time'.$cache, date('YmdHis'));
		}
		$arrResult['attention'] = $arrRet;
//		$arrResult['attention'] = get_attention();	// ATTENTIONの取得

		$time = date('YmdHis');
		$dest_time = @$redis->get('pickup_time'.$cache);
		
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('pickup'.$cache));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = get_pickup();		// PICK UPの取得
			
			$redis->set('pickup'.$cache, serialize($arrRet));
			$redis->set('pickup_time'.$cache, date('YmdHis'));
		}
		$arrResult['arrPickup'] = $arrRet;
//		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得

//		$arrResult['debug'] = $debug;
//$end = microtime(true);
//$sec = ($end - $start);
//$this->debug('SET 5 処理時間 = ' . $sec . ' 秒 '.session_id().PHP_EOL);

		Cache::set('home'.$cache,View_Smarty::forge( $tpl, $arrResult, false ),120);

		return View_Smarty::forge( $tpl, $arrResult, false );
	}
*/





	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
//		return Response::forge(Presenter::forge('home/404'), 404);
		return View_Smarty::forge('smarty/misc/404.tpl');
//		return Response::forge(Presenter::forge('home/404'), 404);
	}


	public function action_401()
	{
		return View_Smarty::forge('smarty/misc/401.tpl');
	}


	public function action_403()
	{
		return View_Smarty::forge('smarty/misc/403.tpl');
	}


	public function action_500()
	{
		return View_Smarty::forge('smarty/misc/500.tpl');
	}


	public function action_503()
	{
		return View_Smarty::forge('smarty/misc/503.tpl');
	}

	public function debug($str)
	{	
		$fp = fopen("/var/www/bronline/fuel/app/logs/recv".date('Ymd').".log", "a");
		if ($fp)
		{
			fputs($fp, date("Y-m-d H:i:s").":");
			fputs($fp, print_r($str, true));
			fputs($fp, PHP_EOL);
			fclose($fp);
		}
		
		return;
	}

}

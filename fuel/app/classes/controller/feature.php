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
class Controller_Feature extends ControllerPage
{
	/**
	 * FEATURE 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$page		= Input::param('page', 1);		// 関連記事ページ
		$page2		= Input::param('page2', 1);		// 最新記事ページ
		$inner_page	= Input::param('p', 1);			// ページ内ページ
		$order		= Input::param('order', '');
		$user_id	= Input::param('user_id', "");
		$preview	= Input::param('preview', false);
		//$shop_url	= $this->param('shop');
		//$shop_name	= "";

		if( $this->shop_url != "") {
			//$shopData = get_br_shop_url($this->shop_url);
			//$shop_name = $shopData['post_title'];

			// ショップアカウントのユーザーIDを取得
			$arrShopUserId = array();
			$arrShopUser = get_shop_user_list( $this->shop_url, 1);
			foreach ( $arrShopUser['arrUsers'] as $user ) {
				$arrShopUserId[] = $user['ID'];
			}
			$user_id = implode(",", $arrShopUserId);

			// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得
			$arrResult['article_num'] = get_article_num($user_id);
		}

		$arrResult['entry'] = $post_id;
		$arrResult['page'] = $page;
		$arrResult['page2'] = $page2;
		$arrResult['p'] = $inner_page;
		$arrResult['order'] = $order;
		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;

		try
		{
			$cache = hash('sha256', 'p'.$post_id.'u'.@$user_id.'p'.$page.'p2'.$page2.'o'.$order.'pp'.$inner_page.'s'.$this->shop_url);
//			var_dump($cache);

			return Cache::get('feature'.$cache);
		}
		catch(\CacheNotFoundException $e)
		{
			Cache::delete('feature'.$cache);
		}

		if( $post_id != 0 ) {
			// 詳細
			// 記事が表示された時（ログイン中、ロボットを除く）表示カウントのアップを行う
			//if(!is_user_logged_in() && !is_robots()):
			postViewCountUp($post_id);
			//endif;

			$data = get_feature($post_id, $inner_page, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;
			$serise = $data['serise'];

			$arrTags = json_decode(json_encode(get_the_tags($post_id)), true);
			$arrResult['arrTags'] = $arrTags;


			$tags = array();
			if( is_array($arrTags)) {
				foreach ( $arrTags as $tag ) {
					$tags[] = $tag['name'];
				}
			}

			// meta情報設定
			$description = mb_substr(str_replace('"', "”", str_replace(PHP_EOL, '', strip_tags($data['content']))), 0, META_DESCRIPTION_LENGTH);
			$this->meta['description']		= $description;
			$this->meta['keyword'] 			= is_array($tags) ? implode(',', $tags) : $arrTags;
			$this->meta['og_title']			= str_replace('[BR]', '', $data['title2']);
			$this->meta['og_description']	= $description;
			$this->meta['og_image']			= $data['main_image_url'];



			$tags = array();
			if( is_array($arrTags)) {
				$cnt = 3;
				foreach ( $arrTags as $tag ) {
					if ($cnt-- == 0)
						break;
						$tags[] = $tag['name'];
				}
			}

			// TODO: 関連記事取得時にタグ選択はEC側でタグ表示順の管理ができてから実装
			/*
			$arrSearchTags = array();
			if( $this->shop_name != "" ) {
				$arrSearchTags[] = $this->shop_name;
			}
			if( is_array($arrResult['arrTags']) && 0 < count($arrResult['arrTags'])) {
				foreach ( array_slice( $arrResult['arrTags'], 0, 4) as $tag ) {
					$arrSearchTags[] = $tag['name'];
				}
			}
			*/
//var_dump($tags);
			$arrResult['arrRelatedShop'] = Tag_Item::get_related($tags, $this->shop_url);		// ショップの関連取得
			$arrResult['arrRelatedMall'] = Tag_Item::get_related($tags);						// ショップの関連取得
//var_dump($arrResult['arrRelatedShop']);
//var_dump($arrResult['arrRelatedMall']);
			// 広告（仮）
			/*
			$arrAd = array();
			$ad = get_br_ad(998);
			if( $ad != "") {
				$arrAd[] = $ad;
			}
			$arrResult['ad'] = $arrAd;
			*/

			if( $this->shop_url != "" ) {
				// ショップ内はグローバルに表示しない記事も表示させる
				$arrResult['arrRelated'] = get_feature_related_list( $serise, $tags, 3, $page, 1);	// 関連記事
				$arrResult['arrLatest'] = get_feature_list( 3, $page2, 1);							// 最新記事：全グローバル記事の中で、新しい順
				$tpl = 'smarty/mall/brshop/feature/detail.tpl';
			} else {
				$arrResult['arrRelated'] = get_feature_related_list( $serise, $tags, 3, $page);		// 関連記事
				$arrResult['arrLatest'] = get_feature_list( 3, $page2);								// 最新記事：全グローバル記事（表示させないにチェックした記事を除く）の中で、新しい順
				$tpl = 'smarty/feature/detail.tpl';
			}
//var_dump($arrResult['arrLatest']['arrPosts'][1]);
		} else {
			// 一覧

			// meta情報設定
			$description = "FEATURE一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;

			$cahce = 'p'.$page.'o'.$order.'u'.$user_id;
			if( $this->shop_url != "" ) {
				// ショップ内
				$tpl = 'smarty/mall/brshop/feature/index.tpl';

				$redis = Redis_Db::forge();
				
				$time = date('YmdHis');
				$dest_time = @$redis->get('feature1_time'.$cahce);
				
				if (($time - $dest_time) <= 120)
				{
					$arrRet = @unserialize($redis->get('feature1'.$cahce));
				}
				else
					$arrRet = '';

				if ($arrRet == '')
				{
					$arrRet = get_feature_list( 12, $page, $order, "", $user_id, 1);	// 1ページ12記事
					
					$redis->set('feature1'.$cahce, serialize($arrRet));
					$redis->set('feature1_time'.$cahce, date('YmdHis'));
				}
				$arrResult['arrData'] = $arrRet;
			} else {
				$tpl = 'smarty/feature/index.tpl';

				$redis = Redis_Db::forge();
				
				$time = date('YmdHis');
				$dest_time = @$redis->get('feature2_time'.$cahce);
				
				if (($time - $dest_time) <= 120)
				{
					$arrRet = @unserialize($redis->get('feature2'.$cahce));
				}
				else
					$arrRet = '';

				if ($arrRet == '')
				{
					$arrRet = get_feature_list( 12, $page, $order, "", $user_id);	// 1ページ12記事
					
					$redis->set('feature2'.$cahce, serialize($arrRet));
					$redis->set('feature2_time'.$cahce, date('YmdHis'));
				}
				$arrResult['arrData'] = $arrRet;
			}

		}

		//$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		//$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
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

		Cache::set('feature'.$cache,View_Smarty::forge( $tpl, $arrResult, false ),120);

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

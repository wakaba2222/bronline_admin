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
class Controller_Stylesnap extends ControllerPage
{
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
		$check = str_replace("'", '"', $check);
		
		return $check;			
	}
	/**
	 * STYLE SNAP 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$page		= Input::param('page', 1);
		$page2		= Input::param('page2', 1);		// 関連記事ページ
		$user_id	= Input::param('user_id', "");
		$preview	= Input::param('preview', false);
		//$shop_url	= $this->param('shop');
		$page = intVal($this->sunitz($page));
		$page2 = intVal($this->sunitz($page2));
		$post_id = $this->sunitz($post_id);
		$preview = $this->sunitz($preview);
		$user_id = $this->sunitz($user_id);

		if( $user_id == "" && $this->shop_url != "") {
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
		$arrResult['user_id'] = $user_id;
		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;


		if( $post_id != 0 ) {
			// 詳細
			// 記事が表示された時（ログイン中、ロボットを除く）表示カウントのアップを行う
			//if(!is_user_logged_in() && !is_robots()):
			postViewCountUp($post_id);
			//endif;

			$data = get_style_snap($post_id, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;

			// 関連記事取得
			$per_page = Agent::is_smartphone() ? 4 : 5;		// スマホ時は４件
			$arrResult['arrRelated'] = get_style_snap_related_list( $per_page, $page2, $user_id);
			// ユーザー情報取得
			$arrResult['user'] = get_br_user($data['post_author']);
			// タグ一覧取得
			$arrTags = json_decode(json_encode(get_the_tags($post_id)), true);
			$arrResult['arrTags'] = $arrTags;

			$tags = array();
			if( is_array($arrTags)) {
				foreach ( $arrTags as $tag ) {
					$tags[] = $tag['name'];
				}
			}

			// 広告（仮）
			/*
			$arrAd = array();
			$ad = get_br_ad(998);
			if( $ad != "") {
				$arrAd[] = $ad;
			}
			$arrResult['ad'] = $arrAd;
			*/


			// meta情報設定
			$description = mb_substr(str_replace('"', "”", str_replace(PHP_EOL, '', strip_tags($data['content']))), 0, META_DESCRIPTION_LENGTH);
			$og_image = "";
			if ( preg_match( '/<img.*?src\s*=\s*[\"|\'](.*?)[\"|\'].*?>/i', $data['content'], $images ) ){
				// 本文画像の１枚めを取得
				if ( is_array( $images ) && isset( $images[1] ) ) {
					$og_image = $images[1];
				}
			} else {
				// 本文内に画像がない場合はアイキャッチ画像
				$og_image = $data['thumb_url'];
			}
			$this->meta['description']		= $description;
			$this->meta['keyword'] 			= is_array($tags) ? implode(',', $tags) : $arrTags;
			$this->meta['og_title']			= $data['post_title'];
			$this->meta['og_description']	= $description;
			$this->meta['og_image']			= $og_image;


			$tags = array();
			if( is_array($arrTags)) {
				$cnt = 3;
				foreach ( $arrTags as $tag ) {
					if ($cnt-- == 0)
						break;
						$tags[] = $tag['name'];
				}
			}

			if( $this->shop_url != "" ) {
				$arrResult['arrRelatedItem'] = Tag_Item::get_related($tags, $this->shop_url);		// ショップの関連取得
				$tpl = 'smarty/mall/brshop/style_snap/detail.tpl';
			} else {
				$arrResult['arrRelatedItem'] = Tag_Item::get_related($tags);		// 関連取得
				$tpl = 'smarty/style_snap/detail.tpl';
			}

		} else {
			// 一覧

			// meta情報設定
			$description = "STYLE SNAP一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;


			if( $this->shop_url != "" ) {
				$tpl = 'smarty/mall/brshop/style_snap/index.tpl';
			} else {
				$tpl = 'smarty/style_snap/index.tpl';
			}

			$redis = Redis_Db::forge();
			
			$cahce = 'p'.$page.'u'.$user_id;
			$time = date('YmdHis');
			$dest_time = @$redis->get('stylesnap_time'.$cahce);
			
			if (($time - $dest_time) <= 120)
			{
				$arrRet = @unserialize($redis->get('stylesnap'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				$arrRet = get_style_snap_list( 30, $page, "", $user_id);	// 1ページ30記事
				
				$redis->set('stylesnap'.$cahce, serialize($arrRet));
				$redis->set('stylesnap_time'.$cahce, date('YmdHis'));
			}
			$arrResult['arrData'] = $arrRet;
//			$arrResult['arrData'] = get_style_snap_list( 30, $page, "", $user_id);	// 1ページ30記事


			$redis = Redis_Db::forge();
			
			$cahce = 'p'.$page.'u'.$user_id;
			$time = date('YmdHis');
			$dest_time = @$redis->get('stylesnapshop_time'.$cahce);
			
			if (($time - $dest_time) <= 120)
			{
				$arrRet = @unserialize($redis->get('stylesnapshop'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				// 各ショップ記事件数リスト（画面左のショップリストの表示・非表示に使用）
				$arrShop = Tag_Item::get_shoplist();
				$arrShopArticleNum = array();
				foreach ( $arrShop as $shop ) {
					$arrShopUserId = array();
					$arrShopUser = get_shop_user_list( $shop['login_id'], 1);
					foreach ( $arrShopUser['arrUsers'] as $user ) {
						$arrShopUserId[] = $user['ID'];
					}
					$shop_user_id = implode(",", $arrShopUserId);
	
					// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得し
					$arrArticles = get_article_num($shop_user_id);
					if( 0 < $arrArticles ) {
						if( array_key_exists('stylesnap', $arrArticles)) {
							$arrShopArticleNum[$shop['login_id']] = $arrArticles['stylesnap'];
						} else {
							$arrShopArticleNum[$shop['login_id']] = 0;
						}
					} else {
						$arrShopArticleNum[$shop['login_id']] = 0;
					}
				}
				$arrRet = $arrShopArticleNum;
				
				$redis->set('stylesnapshop'.$cahce, serialize($arrRet));
				$redis->set('stylesnapshop_time'.$cahce, date('YmdHis'));
			}
			$arrResult['arrShopArticleNum'] = $arrRet;
/*
			// 各ショップ記事件数リスト（画面左のショップリストの表示・非表示に使用）
			$arrShop = Tag_Item::get_shoplist();
			$arrShopArticleNum = array();
			foreach ( $arrShop as $shop ) {
				$arrShopUserId = array();
				$arrShopUser = get_shop_user_list( $shop['login_id'], 1);
				foreach ( $arrShopUser['arrUsers'] as $user ) {
					$arrShopUserId[] = $user['ID'];
				}
				$shop_user_id = implode(",", $arrShopUserId);

				// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得し
				$arrArticles = get_article_num($shop_user_id);
				if( 0 < $arrArticles ) {
					if( array_key_exists('stylesnap', $arrArticles)) {
						$arrShopArticleNum[$shop['login_id']] = $arrArticles['stylesnap'];
					} else {
						$arrShopArticleNum[$shop['login_id']] = 0;
					}
				} else {
					$arrShopArticleNum[$shop['login_id']] = 0;
				}
			}
			$arrResult['arrShopArticleNum'] = $arrShopArticleNum;
*/
		}

		//$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		//$arrResult['arrPickup'] = get_pickup();
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

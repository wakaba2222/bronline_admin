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
class Controller_Editorschoice extends ControllerPage
{
	/**
	 * EDITORS CHOICE 取得
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

		if( $this->shop_url != "") {
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

			$data = get_editors_choice($post_id, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;

			// 関連記事取得
			$per_page = Agent::is_smartphone() ? 4 : 5;		// スマホ時は４件
			$arrResult['arrRelated'] = get_editors_choice_related_list( $per_page, $page2, $user_id);
			// 前後の記事ID、タイトル取得
			$arrResult['prev_next'] = get_br_post_prev_next($post_id, "editorschoice", $user_id);
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


			if( $this->shop_url != "" ) {
				$arrResult['arrRelatedItem'] = Tag_Item::get_related($tags, $this->shop_url);		// ショップの関連取得
				$tpl = 'smarty/mall/brshop/editors_choice/detail.tpl';
			} else {
				$arrResult['arrRelatedItem'] = Tag_Item::get_related($tags);		// 関連取得
				$tpl = 'smarty/editors_choice/detail.tpl';
			}

		} else {
			// 一覧

			// meta情報設定
			$description = "EDITORS' CHOICE一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;


			if( $this->shop_url != "" ) {
				$tpl = 'smarty/mall/brshop/editors_choice/index.tpl';

			} else {
				$tpl = 'smarty/editors_choice/index.tpl';
			}

			$arrResult['arrData'] = get_editors_choice_list( 30, $page, "", $user_id);	// 1ページ30記事


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
					if( array_key_exists('editorschoice', $arrArticles)) {
						$arrShopArticleNum[$shop['login_id']] = $arrArticles['editorschoice'];
					} else {
						$arrShopArticleNum[$shop['login_id']] = 0;
					}
				} else {
					$arrShopArticleNum[$shop['login_id']] = 0;
				}
			}
			$arrResult['arrShopArticleNum'] = $arrShopArticleNum;
		}

		//$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		//$arrResult['arrPickup'] = get_pickup();
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

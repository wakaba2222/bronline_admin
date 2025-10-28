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
class Controller_Blog extends ControllerPage
{
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
		$check = str_replace("'", '"', $check);
		
		return $check;			
	}
	/**
	 * BLOG 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$page		= Input::param('page', 1);
		$page2		= Input::param('page2', 1);
		$user_id	= Input::param('user_id', "");
		$y			= Input::param('y', 0);
		$m			= Input::param('m', 0);
		$preview	= Input::param('preview', false);
		//$shop_url	= $this->param('shop');
		
		$page = intVal($this->sunitz($page));
		$page2 = intVal($this->sunitz($page2));
		$post_id = $this->sunitz($post_id);
		$preview = $this->sunitz($preview);
		$user_id = $this->sunitz($user_id);
		$y = intVal($this->sunitz($y));
		$m = intVal($this->sunitz($m));

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
//			var_dump($this->shop_url);
//			var_dump($arrShopUser);
		}

		$arrResult['entry'] = $post_id;
		$arrResult['page'] = $page;
		$arrResult['page2'] = $page2;
		$arrResult['user_id'] = $user_id;
		$arrResult['y'] = $y;
		$arrResult['y'] = $m;
		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;

		if( $post_id != 0 ) {
			// 詳細
			// 記事が表示された時（ログイン中、ロボットを除く）表示カウントのアップを行う
			//if(!is_user_logged_in() && !is_robots()):
			postViewCountUp($post_id);
			//endif;

			$data = get_blog($post_id, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;
			$user_id = $data['user_id'];

			// 前後の記事ID、タイトルを取得
			$arrResult['prev_next'] = get_br_post_prev_next($post_id, "post", $user_id);
			// 関連記事取得
			$arrResult['arrRelated'] = get_blog_related_list( $user_id, 5);
			// ユーザー情報取得
			$arrResult['user'] = get_br_user($user_id);
			// ブログカレンダー取得
			$arrResult['calendar'] = get_blog_calendar_html($post_id, $user_id, $y, $m);



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
			$arrKeyword = array();
			$arrKeyword[] = $arrResult['user']['last_name'].$arrResult['user']['first_name'];
			if($arrResult['user']['name_en'] != "") {
				$arrKeyword[] = $arrResult['user']['name_en'];
			}
			if($arrResult['user']['shop_name'] != "") {
				$arrKeyword[] = $arrResult['user']['shop_name'];
			}

			$this->meta['description']		= $description;
			$this->meta['keyword'] 			= implode(',', $arrKeyword);
			$this->meta['og_title']			= $data['post_title'];
			$this->meta['og_description']	= $description;
			$this->meta['og_image']			= $og_image;


			if( $this->shop_url != "" ) {
				$tpl = 'smarty/mall/brshop/blog/detail.tpl';
			} else {
				$tpl = 'smarty/blog/detail.tpl';
			}

		} else {
			// 一覧

			// meta情報設定
			$description = "BLOG一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;


			if( $this->shop_url != "" ) {
				// ショップ情報取得
				$arrResult['shop'] = array();		// TODO:ショップ情報はEC側で設定

				$tpl = 'smarty/mall/brshop/blog/index.tpl';

			} else {
				$tpl = 'smarty/blog/index.tpl';
			}

			$arrResult['arrData'] = get_blog_article_list( 12, $page, "", $user_id );	// 1ページ12記事

			// ユーザー情報取得
			$arrResult['user'] = get_br_user($user_id);
			// ブログカレンダー取得
			$arrResult['calendar'] = get_blog_calendar_html($post_id, $user_id, $y, $m);
			// 関連記事取得
			$arrResult['arrRelated'] = get_blog_related_list( $user_id, 5);

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

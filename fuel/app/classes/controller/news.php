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
class Controller_News extends ControllerPage
{
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
		$check = str_replace("'", '"', $check);
		
		return $check;			
	}
	/**
	 * NEWS 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$page		= Input::param('page', 1);
		$preview	= Input::param('preview', false);

		$page = intVal($this->sunitz($page));
		$post_id = $this->sunitz($post_id);
		$preview = $this->sunitz($preview);

		$arrResult['entry'] = $post_id;
		$arrResult['page'] = $page;

		if( $post_id != 0 ) {
			// 詳細
			// 記事が表示された時（ログイン中、ロボットを除く）表示カウントのアップを行う
			//if(!is_user_logged_in() && !is_robots()):
			postViewCountUp($post_id);
			//endif;

			$data = get_news($post_id, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;


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
			$this->meta['keyword'] 			= $data['post_title'];
			$this->meta['og_title']			= $data['post_title'];
			$this->meta['og_description']	= $description;
			$this->meta['og_image']			= $og_image;


			$tpl = 'smarty/news/detail.tpl';

		} else {
			// 一覧

			// meta情報設定
			$description = "NEWS一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;


			$tpl = 'smarty/news/index.tpl';
			$arrResult['arrData'] = get_news_list( 10, $page );	// 1ページ10記事（仮）

		}

		$arrResult['arrPickup'] = get_pickup();
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

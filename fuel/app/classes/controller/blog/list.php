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
class Controller_Blog_List extends ControllerPage
{
	/**
	 * BLOG MEMBER 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$arrResult['entry'] = $post_id;

		if( $post_id != 0 ) {
			// 詳細
			// 記事が表示された時（ログイン中、ロボットを除く）表示カウントのアップを行う
			//if(!is_user_logged_in() && !is_robots()):
			postViewCountUp($post_id);
			//endif;
			/*
			$tpl = 'smarty/blog/detail.tpl';
			$arrResult['post'] = get_blog($post_id);
			$arrResult['arrTags'] = json_decode(json_encode(get_the_tags($post_id)), true);
			*/

		} else {
			// 一覧

			// meta情報設定
			$description = "BLOG MEMBER一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;


			$tpl = 'smarty/blog/list.tpl';
			$arrTemp = get_blog_member_list();
			$arrRet = Tag_Shop::get_shoplist('popup_flg <> 0');
//			var_dump($arrRet);
//			var_dump($arrTemp);
			$arrResult['arrData'] = array();
			$arrUsers = array();
//			$arrResult['arrData'] = $arrTemp;

			foreach($arrTemp['arrUsers'] as $temp)
			{
//				var_dump($temp);
				$flg = false;
				foreach($arrRet as $ret)
				{
					if ($ret['login_id'] == $temp['user_login'])
					{
						$flg = true;
						break;
					}
				}
				if (!$flg)
					$arrUsers['arrUsers'][] = $temp;
			}
			$arrResult['arrData'] = $arrUsers;

		}

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
		return Response::forge(Presenter::forge('home/404'), 404);
		//        return View_Smarty::forge('smarty/404.tpl');
		//		return Response::forge(Presenter::forge('home/404'), 404);
	}
}

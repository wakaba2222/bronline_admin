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
class Controller_Admin_Brand extends ControllerAdmin
{
	public function action_index()
	{
		$post = Input::param();
//		var_dump($post);
		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		$mode = Input::post('mode', '');
		if( $mode == 'edit' )
		{
			try {
				DB::start_transaction();

				// テーブル削除
				DBUtil::truncate_table('dtb_brand_list');

				// 記事タグinsert
				$arrTagName = Input::post('article_tag_name');
				$arrTagRank = Input::post('article_rank_name');
				foreach ( $arrTagName as $idx => $name )
				{
					if($name != "") {
						$insert = array();
//						$insert['keyword']	= stripslashes(htmlspecialchars($name));
						$insert['keyword']	= stripslashes($name);
						$insert['rank']		= $arrTagRank[$idx];
						DB::insert('dtb_brand_list')->set($insert)->execute();
					}
				}

				// アイテムタグinsert
				DB::commit_transaction();

			} catch ( Exception $e ) {
				DB::rollback_transaction();
				$this->arrResult["arrMsg"][] = '更新に失敗しました。';
			}
		}

		$this->arrResult["arrArticleTag"]	= DB::select()->from('dtb_brand_list')->order_by('rank', 'asc')->execute()->as_array();


		$this->tpl = 'smarty/admin/brand/index.tpl';
		return $this->view;
	}

	public function before() {
		parent::before();

		$this->arrResult["arrError"] = array();
		$this->arrResult["arrMsg"] = array();
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

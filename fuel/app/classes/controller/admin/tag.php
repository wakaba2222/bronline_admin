<?php
use Oil\Exception;

class Controller_Admin_Tag extends ControllerAdmin
{

	public function before() {
		parent::before();

		$this->arrResult["arrError"] = array();
		$this->arrResult["arrMsg"] = array();
	}


	/**
	 * 初期画面
	 */
	public function action_index()
	{
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
				DBUtil::truncate_table('dtb_pickup');

				// 記事タグinsert
				$arrTagName = Input::post('article_tag_name');
				$arrTagRank = Input::post('article_tag_rank');
				foreach ( $arrTagName as $idx => $name )
				{
					if($name != "") {
						$insert = array();
						$insert['keyword']	= $name;
						$insert['rank']		= $arrTagRank[$idx];
						$insert['kind']		= 1;
						DB::insert('dtb_pickup')->set($insert)->execute();
					}
				}

				// アイテムタグinsert
				$arrTagName = Input::post('item_tag_name');
				$arrTagRank = Input::post('item_tag_rank');
				foreach ( $arrTagName as $idx => $name )
				{
					if($name != "") {
						$insert = array();
						$insert['keyword']	= $name;
						$insert['rank']		= $arrTagRank[$idx];
						$insert['kind']		= 2;
						DB::insert('dtb_pickup')->set($insert)->execute();
					}
				}

				DB::commit_transaction();

			} catch ( Exception $e ) {
				DB::rollback_transaction();
				$this->arrResult["arrMsg"][] = '更新に失敗しました。';
			}
		}

		$this->arrResult["arrArticleTag"]	= DB::select()->from('dtb_pickup')->where('kind', 1)->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrItemTag"]		= DB::select()->from('dtb_pickup')->where('kind', 2)->order_by('rank', 'asc')->execute()->as_array();

		$this->tpl = 'smarty/admin/tag/index.tpl';
		return $this->view;
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

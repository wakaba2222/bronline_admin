<?php
use Oil\Exception;

class Controller_Admin_Mailset extends ControllerAdmin
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

//var_dump(Input::param());

		$table_name = 'dtb_mail_template';
		$where = array('del_flg', '=', '0');
		$order = 'rank';
		$columns = Tag_Util::get_columns($table_name);
		foreach($columns as $c)
		{
			$column[] = $c['Field'];
		}
		//var_dump($column);exit;
		
		$arrRet = Tag_Util::get_table($column, $table_name, $where, $order);
//		var_dump($arrRet);exit;

		$arrMailTEMPLATE = array();
		foreach($arrRet as $ret)
		{
			$arrMailTEMPLATE[$ret['id']] = $ret['name'];
		}

		$arrTemp = array();
		$template_id = Input::param('template_id', '');
		$mode = Input::param('mode', '');
		if ($template_id != '' && $mode != '')
		{
			foreach($arrRet as $ret)
			{
				if ($ret['id'] == $template_id)
				{
					$arrTemp = $ret;
					break;
				}
			}
		}
		$arrTemp['template_id'] = $template_id;

		if ($mode == 'regist')
		{
			$arrItem = $arrTemp;
			unset($arrItem['template_id']);
			unset($arrItem['id']);
			$query = DB::update($table_name);
			$arrItem['subject'] = Input::param('subject');
			$arrItem['header'] = Input::param('header');
			$arrItem['footer'] = Input::param('footer');
			$arrTemp['subject'] = Input::param('subject');
			$arrTemp['header'] = Input::param('header');
			$arrTemp['footer'] = Input::param('footer');
			
			$query->set($arrItem)->where('id', $template_id)->execute();
		}

		$this->arrResult["arrForm"] = $arrTemp;
//		var_dump($this->arrResult["arrForm"]);exit;
		$this->arrResult["arrMailTEMPLATE"] = $arrMailTEMPLATE;

		$this->tpl = 'smarty/admin/basis/mail.tpl';
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

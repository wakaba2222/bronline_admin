<?php
use Oil\Exception;

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
class Controller_Admin_Delivery extends ControllerAdmin
{

	public function before() {
		parent::before();

		// マスタデータ取得
		$this->arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();

		$this->arrResult["arrError"] = array();
	}


	/**
	 * 配送先登録画面
	 */
	public function action_index()
	{
		$deliv_id = 1;		// ヤマト固定のため

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		$arrDelivTime = DB::select()->from('dtb_delivtime')->where('deliv_id', $deliv_id)->order_by('time_id', 'ASC')->execute()->as_array();
		$arrDelivFee  = DB::select()->from('dtb_delivfee')->where('deliv_id', $deliv_id)->order_by('pref', 'ASC')->execute()->as_array();

		$this->arrResult["arrForm"]['deliv_id'] = $deliv_id;
		$this->arrResult["arrDelivTime"] = $arrDelivTime;
		$this->arrResult["arrDelivFee"] = $arrDelivFee;

		$this->tpl = 'smarty/admin/basis/delivery_input.tpl';
		return $this->view;
	}


	/**
	 * 配送先入力チェック～DB更新
	 */
	public function action_edit()
	{
		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		$mode = Input::post('mode', '');

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('deliv_time', 'お届け時間');
		$val->add('deliv_fee', '配送料');

		if( $val->run()) {
			// バリデーションエラーなし









		} else {
			// バリデーションエラーあり
			$errors = $val->error();

			$arrError = array();
			foreach($errors as $f => $error )
			{
				$arrError[$f] = $error->get_message();
			}
			$this->arrResult["arrError"] = $arrError;

			$this->tpl = 'smarty/admin/basis/delivery_input.tpl';
		}

		$this->arrResult["arrForm"] = $val->input();

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

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
class Controller_Admin_Coupon extends ControllerAdmin
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_tools()
	{
		$tpl = 'smarty/coupon/index.tpl';
		return View_Smarty::forge( $tpl, array(), false );
	}

	public function post_tools()
	{
		$tpl = 'smarty/coupon/index.tpl';
		
		$order_id = Input::param('order_id','');

		if ($order_id == '')
			$err = '指定された受注がありません。';
		else
		{
			$table_name = 'dtb_order_deliv';
			$query = DB::select_array(array('customer_id','email'))->from($table_name)->where('order_id',$order_id);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				$data = $arrRet[0];
				
				if ($data['email'] == null)
				{
					$query = DB::select_array(array('customer_id','email'))->from('dtb_customer')->where('customer_id',$data['customer_id']);
					$arrRet2 = $query->execute()->as_array();
					if (count($arrRet2) > 0)
					{
						$data = $arrRet2[0];
					}
				}

				$table_name = 'dtb_buylog';
				$query = DB::delete($table_name)->where('customer_id',$data['customer_id'])->and_where('mail',$data['email']);
				$query->execute();
				
				$err = '指定されたクーポン使用履歴は削除されました。';
			}
			else
				$err = '指定された受注がありません。';
		}
		
		
		
		return View_Smarty::forge( $tpl, array('err'=>$err,), false );
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

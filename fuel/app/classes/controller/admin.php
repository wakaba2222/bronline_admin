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
class Controller_Admin extends ControllerAdmin
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		Tag_Session::delete('authority');
		Tag_Session::delete('shop_id');
		Tag_Session::delete('shop');
		Tag_Session::delete('stock_type');
		Tag_Session::delete('search_product');
		Tag_Session::delete('shop_admin');
		Tag_Session::delete('shop_mode');
		Tag_Session::delete('login_name');
		Tag_Session::delete('TRANSACTION_ID');
		Tag_Session::delete('author');
		Tag_Session::delete('BACK_DATA');
		$debug = array();
		$arrResult = array();

		$query = DB::select()->from('dtb_member')->execute();
//    	var_dump($query);
    
///		$arrResult['TPL_URLPATH'] = Config::get('define.image.img_path');
		$arrResult['transactionid'] = Tag_Session::getToken();


		$this->tpl = 'smarty/admin/login.tpl';
		return $this->view;
	}

	public function before()
	{
		$this->view = View_Smarty::forge('smarty/admin/login_frame.tpl');
	}

	public function action_csvupload()
	{
		$debug = array();
		$arrResult = array();

		if (is_uploaded_file($_FILES['csv_file']['tmp_name']))
		{
			$enc_filepath = $_FILES["file_name"]["tmp_name"];
			$csv = new Tag_CsvUpload();
			$csv->upload($enc_filepath);
		}


	}
	public function action_logout()
	{
		Tag_Session::delete('authority');
		Tag_Session::delete('shop_id');
		Tag_Session::delete('shop');
		Tag_Session::delete('stock_type');
		Tag_Session::delete('search_product');
		Tag_Session::delete('shop_admin');
		Tag_Session::delete('shop_mode');
		Tag_Session::delete('login_name');
		Tag_Session::delete('TRANSACTION_ID');
		Tag_Session::delete('author');
		Tag_Session::delete('BACK_DATA');

		Response::redirect('/admin/');
	}
	
	public function action_login()
	{
        if (/*!$this->doValidToken(true) || */$this->getMode() != 'login')
        {
			Response::redirect('/admin/error');
        }

		$post = Input::post();

		$pass = hash_hmac('sha256', $post['password'], false);
		//var_dump($pass);exit;
		$sql = "SELECT login_id FROM dtb_member WHERE login_id = '{$post['login_id']}' AND password = '{$pass}'";
		$query = DB::query($sql);
		$arrRet = $query->execute();
		
		if (count($arrRet) <= 0)
		{
			$ret = $this->check($post);
			if (count($ret) <= 0)
			{
				$this->arrResult['error'] = "ID またはパスワードに誤りがあります。";
				$this->tpl = 'smarty/admin/login.tpl';
				return $this->view;
			}
			else
			{
//				ini_set( 'session.gc_maxlifetime', 3600 );  // 秒(デフォルト:1440)
//				ini_set( 'session.gc_divisor', 100 );  // 秒(デフォルト:1440)
				Tag_Session::set('author', $ret[0]['shop_name']);
				if ($ret[0]['login_id'] == 'brshop')
					Tag_Session::set('authority', '0');
				else
					Tag_Session::set('authority', '1');

				Tag_Session::setShop($ret[0]['login_id']);
				Tag_Session::setShopType($ret[0]['dtb_stock_type_id']);
				Tag_Session::set('shop_id', $ret[0]['id']);
				
				Response::redirect('/admin/product');
			}
		}
		else
		{
			Tag_Session::set('author', '管理者');
			Tag_Session::set('authority', '0');
			Tag_Session::setShopType(0);
			Tag_Session::set('shop_id', '');
			Tag_Session::set('shop', '');
//var_dump($_SESSION);exit;			
			Response::redirect('/admin/product');
		}
	}

	public function check($post)
	{
		$pass = hash_hmac('sha256', $post['password'], false);
		$sql = "SELECT * FROM dtb_shop WHERE login_id = '{$post['login_id']}' AND login_pass = '{$pass}'";
		$query = DB::query($sql);
		$arrRet = $query->execute();
		
		return $arrRet;
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

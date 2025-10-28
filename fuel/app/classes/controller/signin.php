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
//require_once APPPATH.'classes/tag/customerctrl.php';

class Controller_Signin extends ControllerPage
{
	/**
	 * サインイン画面初期表示
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$arrResult["arrForm"] = array();
		$arrResult["arrError"] = array();

		if (Input::param('logout') == '1')
		{
			// お気に入りをcookieからDBに登録
			$objCustomer = new Tag_customerctrl();
			$objCustomer->getSession();

			$objWishlistctrl = new Tag_Wishlistctrl();
			$objWishlistctrl->set_wish_db2cookie($objCustomer->customer->getCustomerId());

			Tag_customerctrl::clearSession();
			return Response::redirect('/');
		}
		$tpl = 'smarty/signin/index.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}


	/**
	 * サインイン処理
	 *
	 * @return unknown
	 */
	public function post_index()
	{
		$debug = array();
		$arrResult = array();

		$customer = new Tag_customerctrl();

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email');
		$val->add('password', 'パスワード')->add_rule('required');
		$val->add('login_memory', 'ログインしたままにする');

		if( $val->run()) {
			// バリデーションエラーなし
			$arrResult["arrForm"] = $val->input();
			$arrResult["arrError"] = array();

			if( $customer_id = $customer->chkPassword( $val->input('email'), $val->input('password'))) {
				// パスワードチェック成功：ログイン処理
				$res = DB::select('dtb_customer.*', 'dtb_point.point')->from('dtb_customer')
						->join('dtb_point', 'LEFT')->on('dtb_customer.customer_id', '=', 'dtb_point.customer_id')
						->where('dtb_customer.customer_id', $customer_id)->execute()->as_array();
				$arrCustomer = $res[0];

				$arrTemp = Tag_CustomerInfo::get_customer($customer_id);

				// ユーザー情報をセッションに格納
				$customer->customer->setCustomerId($customer_id);
				$customer->customer->setName01($arrCustomer['name01']);
				$customer->customer->setName02($arrCustomer['name02']);
				$customer->customer->setPoint(($arrCustomer['point'] == "") ? 0 : $arrCustomer['point']);
				$customer->customer->setPointRate(($arrTemp['point_rate'] == "") ? 0 : $arrTemp['point_rate']);
				$customer->customer->setRank($arrCustomer['customer_rank']);
				$customer->customer->setSaleStatus($arrCustomer['sale_status']);
				$customer->customer->setLoginMemory($val->input('login_memory'));
				$customer->setSession();

				$url_flg = Input::param('shopping');

				// お気に入りをcookieからDBに登録
				$objWishlistctrl = new Tag_Wishlistctrl();
				$objWishlistctrl->add_wish_cookie2db($customer_id);


				if($url_flg == 1)
					Response::redirect('/cart/shopping');		// ログイン後画面
				else
					Response::redirect('/mypage/');		// ログイン後画面

			} else {
				// パスワードチェックエラー
				//return Response::redirect('/admin/error', 'location', 301);
				return View_Smarty::forge('smarty/misc/401.tpl');

				//$arrResult["arrError"] = "※メールアドレス、またはパスワードが違います";
				//$tpl = 'smarty/signin/index.tpl';
			}

		} else {
			// バリデーションエラーあり
			$errors = $val->error();

			$arrError = array();
			foreach($errors as $f => $error )
			{
				$arrError[$f] = $error->get_message();
			}
			$arrResult["arrError"] = $arrError;

			/*
			echo "<pre>";
			print_r($arrError);
			echo "</pre>";
			*/

			$arrResult["arrForm"] = $val->input();

			$tpl = 'smarty/signin/index.tpl';
		}

		return View_Smarty::forge( $tpl, $arrResult, true );
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

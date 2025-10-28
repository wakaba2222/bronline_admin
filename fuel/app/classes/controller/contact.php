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

class Controller_Contact extends ControllerPage
{
	/**
	 * お問い合わせフォーム（入力＋電話案内）
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();

		/*
		echo "<pre>";
		print_r($arrResult["arrReminder"]);
		echo "</pre>";
		*/

		$arrResult["arrForm"] = Input::post();
		$arrResult["arrError"] = array();

		$arrResult['transactionid'] = Tag_Session::getToken();

		$product_id = Input::param('product_id', "");
		$product_name = Input::param('product_name', "");

//var_dump($product_id);
		if ($product_id != '' && $product_name == '')
		{
			$product_id = htmlspecialchars($product_id, ENT_QUOTES);
			$arrResult['arrItem'] = Tag_Item::get_detail($product_id, false, '');
//			var_dump($arrResult['arrItem']);
			$tpl = 'smarty/contact/index2.tpl';
		}
		else
			$tpl = 'smarty/contact/index.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}


	/**
	 * お問い合わせフォーム（入力チェック）
	 *
	 * @return unknown
	 */
	public function post_confirm()
	{
		if (!$this->doValidToken())
		{
			return Response::forge(View::forge('home/404'), 404);
		}

		$debug = array();
		$arrResult = array();

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('name01', 'お名前（姓）')->add_rule('required');
		$val->add('name02', 'お名前（名）')->add_rule('required');
		$val->add('kana01', 'フリガナ（セイ）')->add_rule('required')->add_rule('kana_only');
		$val->add('kana02', 'フリガナ（メイ）')->add_rule('required')->add_rule('kana_only');
//		$val->add('company', '会社名');
//		$val->add('department', '部署名');
//		if( $val->input('zip01') == "" ) {
//			$val->add('zip01', '郵便番号1');
//		} else {
//			$val->add('zip01', '郵便番号1')->add_rule('exact_length', 3)->add_rule('number_only');
//		}
//		if( $val->input('zip02') == "" ) {
//			$val->add('zip02', '郵便番号2');
//		} else {
//			$val->add('zip02', '郵便番号2')->add_rule('exact_length', 4)->add_rule('number_only');
//		}
		$val->add('pref', '都道府県');
//		$val->add('addr01', '市区町村・番地');
//		$val->add('addr02', 'ビル/マンション名・部屋番号');
		if( $val->input('tel01') == "" ) {
			$val->add('tel01', '電話番号');
		} else {
			$val->add('tel01', '電話番号')->add_rule('number_only');
		}
		$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email');
		$val->add('email2', 'メールアドレス（確認用）')->add_rule('required')->add_rule('valid_email')->add_rule('match_field','email');
		$val->add('body', 'お問い合わせ内容')->add_rule('required');

		$arrResult['transactionid'] = Tag_Session::getToken();
		$mode = Input::param('mode', "");
		$product_id = Input::param('product_id', "");

		if ($product_id != '')
		{
			$product_id = htmlspecialchars($product_id, ENT_QUOTES);
			$arrResult['arrItem'] = Tag_Item::get_detail($product_id, false, '');
		}

		if( $val->run()) {
			// バリデーションエラーなし
			$arrResult["arrForm"] = $val->input();

			if ($mode == 'reserve')
				$tpl = 'smarty/contact/confirm2.tpl';
			else
				$tpl = 'smarty/contact/confirm.tpl';

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

			if ($mode == 'reserve')
				$tpl = 'smarty/contact/index2.tpl';
			else
				$tpl = 'smarty/contact/index.tpl';
		}

		return View_Smarty::forge( $tpl, $arrResult, true );
	}


	/**
	 * お問い合わせフォーム（確認）
	 *
	 * @return unknown
	 */
	public function post_complete()
	{
		$debug = array();
		$arrResult = array();

		if (!$this->doValidToken())
		{
			return Response::forge(View::forge('home/404'), 404);
		}


		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrForm"] = Input::post();

		$mode = Input::param('mode', "");
		$product_id = Input::param('product_id', "");
		// 修正するボタンの場合編集画面を表示
		if( Input::post('btnSubmit') == 'return' ) {
			$arrResult["arrError"] = array();
			$arrResult['transactionid'] = Tag_Session::getToken();

			if ($product_id != '')
			{
				$product_id = htmlspecialchars($product_id, ENT_QUOTES);
				$arrResult['arrItem'] = Tag_Item::get_detail($product_id, false, '');
			}

			if ($mode == 'reserve')
				$tpl = 'smarty/contact/index2.tpl';
			else
				$tpl = 'smarty/contact/index.tpl';
			return View_Smarty::forge( $tpl, $arrResult, true );
		}

		// メール送信（問い合わせ者宛）
		if ($mode == 'reserve')
			$tpl = 'smarty/email/contact_to_inquirer2.tpl';
		else
			$tpl = 'smarty/email/contact_to_inquirer.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(CONTACT_MAIL_FROM);
		$email->to(Input::post('email'));
		if ($mode == 'reserve')
			$email->subject("B.R.ONLINE ご予約");
		else
			$email->subject(CONTACT_MAIL_TITLE_INQUIRER);
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

		$history = array();
//		$history['order_id'] = "";
		$emails = $email->get_to();
		$tos = array();
		foreach($emails as $k=>$m)
		{
			$tos[] = $k;
		}
		$history['to_email'] = implode(',', $tos);
		$history['subject'] = $email->get_subject();
		$history['body'] = $email->get_body();
		$query = DB::insert('dtb_mail_history');
		$query->set($history);
		$query->execute();

		$email->send();


		// メール送信（管理者宛て）
		if ($mode == 'reserve')
			$tpl = 'smarty/email/contact_to_admin2.tpl';
		else
			$tpl = 'smarty/email/contact_to_admin.tpl';

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(CONTACT_MAIL_FROM);
		$email->to(CONTACT_MAIL_TO_ADMIN);
		if ($mode == 'reserve')
			$email->subject("B.R.ONLINE ご予約がありました");
		else
			$email->subject(CONTACT_MAIL_TITLE_ADMIN);
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

		$history = array();
//		$history['order_id'] = "";
		$emails = $email->get_to();
		$tos = array();
		foreach($emails as $k=>$m)
		{
			$tos[] = $k;
		}
		$history['to_email'] = implode(',', $tos);
		$history['subject'] = $email->get_subject();
		$history['body'] = $email->get_body();
		$query = DB::insert('dtb_mail_history');
		$query->set($history);
		$query->execute();

		$email->send();

		if ($mode == 'reserve')
			$tpl = 'smarty/contact/complete2.tpl';
		else
			$tpl = 'smarty/contact/complete.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
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

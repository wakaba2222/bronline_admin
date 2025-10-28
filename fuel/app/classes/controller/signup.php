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

class Controller_Signup extends ControllerPage
{
	/**
	 * ショッピング会員登録（規約）
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/signup/index.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}


	/**
	 * ショッピング会員登録（入力画面初期表示）
	 *
	 * @return unknown
	 */
	public function action_subscribe()
	{
		$debug = array();

		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

		/*
		echo "<pre>";
		print_r($arrResult["arrReminder"]);
		echo "</pre>";
		*/

		$arrResult["arrForm"] = array();
		$arrResult["arrError"] = array();

		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/signup/subscribe.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}


	/**
	 * ショッピング会員登録（入力チェック）
	 *
	 * @return unknown
	 */
	public function post_subscribe()
	{
		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		$debug = array();
		$arrResult = array();

		$arrResult["arrForm"] = array();
		$arrResult["arrError"] = array();

		// マスタデータ取得
		$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

		$arrResult['transactionid'] = Tag_Session::getToken();

		$tpl = 'smarty/signup/subscribe.tpl';

		if( Input::post('btnSubmit') != 'index' ) {
			$val = Validation::forge();
			$val->add_callable('Brvalidate');
			$val->add('name01', 'お名前（姓）')->add_rule('required');
			$val->add('name02', 'お名前（名）')->add_rule('required');
			$val->add('kana01', 'フリガナ（セイ）')->add_rule('required')->add_rule('kana_only');
			$val->add('kana02', 'フリガナ（メイ）')->add_rule('required')->add_rule('kana_only');
			$val->add('company', '会社名');
			$val->add('department', '部署名');
			$val->add('zip01', '郵便番号1')->add_rule('required')->add_rule('exact_length', 3)->add_rule('number_only');
			$val->add('zip02', '郵便番号2')->add_rule('required')->add_rule('exact_length', 4)->add_rule('number_only');
			$val->add('pref', '都道府県')->add_rule('required_select');
			$val->add('addr01', '市区町村・番地')->add_rule('required');
			$val->add('addr02', 'ビル/マンション名・部屋番号');
			$val->add('tel01', '電話番号')->add_rule('required')->add_rule('number_only');
			$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('customer_unique_email');
			$val->add('email2', 'メールアドレス（確認用）')->add_rule('required')->add_rule('valid_email')->add_rule('match_field','email');
			$val->add('sex', '性別')->add_rule('required_select');
			$val->add('year', '生年月日（年）')->add_rule('required');
			$val->add('month', '生年月日（月）')->add_rule('required');
			$val->add('day', '生年月日（日）')->add_rule('required');
			$val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass');
			$val->add('password2', 'パスワード（確認用）')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass')->add_rule('match_field','password');
			$val->add('reminder', '質問')->add_rule('required_select');
			$val->add('reminder_answer', '質問の答え')->add_rule('required');
			$val->add('mailmaga_flg', 'メールマガジン購読')->add_rule('required_select');

			$arrResult['transactionid'] = Tag_Session::getToken();

			if( $val->run()) {
				// バリデーションエラーなし
				$arrResult["arrForm"] = $val->input();

				$tpl = 'smarty/signup/confirm.tpl';

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
			}
		}

		return View_Smarty::forge( $tpl, $arrResult, true );
	}


	/**
	 * ショッピング会員登録（確認）
	 *
	 * @return unknown
	 */
	public function post_confirm()
	{
		$debug = array();
		$arrResult = array();

		if (!$this->doValidToken())
		{
			return Response::redirect('/error', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		// 修正するボタンの場合編集画面を表示
		if( Input::post('btnSubmit') == 'return' ) {
			// マスタデータ取得
			$arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
			$arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();

			$arrResult["arrForm"] = Input::post();
			$arrResult["arrError"] = array();
			$arrResult['transactionid'] = Tag_Session::getToken();

			$tpl = 'smarty/signup/subscribe.tpl';
			return View_Smarty::forge( $tpl, $arrResult, true );
		}


		$customer = new Tag_customerctrl();

		$secret_key = "";
		do {
			$secret_key = $customer->gfMakePassword(8);
			$exists = DB::select()->from('dtb_customer')->where('secret_key', $secret_key)->where('del_flg', 0)->execute()->as_array();
		} while ($exists);

		$salt = $customer->gfMakePassword(10);


		$arrInsert = array();
		$arrInsert['customer_rank'] = 1;		// 仮
		$arrInsert['name01'] = Input::post('name01');
		$arrInsert['name02'] = Input::post('name02');
		$arrInsert['kana01'] = Input::post('kana01');
		$arrInsert['kana02'] = Input::post('kana02');
		$arrInsert['zip01'] = Input::post('zip01');
		$arrInsert['zip02'] = Input::post('zip02');
		$arrInsert['pref'] = Input::post('pref');
		$arrInsert['addr01'] = Input::post('addr01');
		$arrInsert['addr02'] = Input::post('addr02');
		$arrInsert['email'] = Input::post('email');
		$arrInsert['tel01'] = Input::post('tel01');
		$arrInsert['sex'] = Input::post('sex');
		$arrInsert['birth'] = Input::post('year').'/'.Input::post('month').'/'.Input::post('day');
		$arrInsert['password'] = $customer->sfGetHashString(Input::post('password'), $salt);
		$arrInsert['reminder'] = Input::post('reminder');
		//$arrInsert['reminder_answer'] = Input::post('reminder_answer');
		$arrInsert['reminder_answer'] = $customer->sfGetHashString(Input::post('reminder_answer'), $salt);
		$arrInsert['salt'] = $salt;
		$arrInsert['secret_key'] = $secret_key;
		$arrInsert['status'] = 1;				// 仮会員
		$arrInsert['create_date'] = date('Y-m-d H:i:s');
		$arrInsert['del_flg'] = 0;
		$arrInsert['mailmaga_flg'] = Input::post('mailmaga_flg');
		$arrInsert['company'] = Input::post('company');
		$arrInsert['department'] = Input::post('department');

		// インサート
		$result = DB::insert('dtb_customer')->set($arrInsert)->execute();

		if( 0 < $result[1] ){
			// 成功
			$customer_id = $result[0];
			$res = DB::select()->from('dtb_customer')->where('customer_id', $customer_id)->execute()->as_array();
			$arrCustomer = $res[0];

			// メール送信
			$tpl = 'smarty/email/signup_temp_menber.tpl';
			$arrResult["arrForm"] = $arrCustomer;
			$arrResult['registurl'] = (empty($_SERVER["HTTPS"]) ? "http://" : "https://")."www.bronline.jp"."/signup/complete?id=".$arrCustomer['customer_id']."&sk=".$arrCustomer['secret_key'];

			$email = Email::forge();
			$email->header('Content-Transfer-Encoding', 'base64');
			$email->from(CUSTOMER_TEMP_MAIL_FROM);
			$email->to($arrCustomer['email']);
			$email->subject(CUSTOMER_TEMP_MAIL_TITLE);
			$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

			$history = array();
			$history['order_id'] = 0;
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

			Response::redirect('signup/completepre?pre=1');

		} else {
			// 失敗
			return Response::redirect('/error', 'location', 301);
			//echo "会員登録に失敗しました";
			//exit;
		}
	}


	/**
	 * ショッピング会員登録（仮登録完了）
	 *
	 * @return unknown
	 */
	public function action_completepre()
	{
		$debug = array();
		$arrResult = array();

		if (Input::get('pre') != 1)
		{
			return Response::redirect('/error/404', 'location', 301);
			//return Response::forge(View::forge('home/404'), 404);
		}

		$tpl = 'smarty/signup/complete_pre.tpl';

		return View_Smarty::forge( $tpl, $arrResult, true);
	}


	/**
	 * ショッピング会員登録（本登録完了）
	 *
	 * @return unknown
	 */
	public function action_complete()
	{
		$debug = array();
		$arrResult = array();


		$customer_id = Input::get('id');
		$secret_key = Input::get('sk');

		if( $customer_id != "" && $secret_key != "" ) {
			// アップデート
			$result = DB::update('dtb_customer')->value('status', 2)->value('update_date', date('Y-m-d H:i:s'))
								->where('customer_id', $customer_id)
								->where('secret_key', $secret_key)
								->where('status', 1)
								->where('del_flg', 0)->execute();

			if( $result == 1 ) {
				// 本登録完了
				$tpl = 'smarty/signup/complete.tpl';

				return View_Smarty::forge( $tpl, $arrResult, true);
			}
		}

		// エラー画面へ
		return View_Smarty::forge('smarty/misc/401.tpl');
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

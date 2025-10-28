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
class Controller_MailSend extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		/*
		$tpl = 'smarty/test.tpl';
		$subject = "TEST";
//		$body = "テストメールです。";
		$to = "nianyan2222@i.softbank.jp";
		$to2 = "hwakaba2222@gmail.com";
		$from = 'bradmin';
$body = <<<EOT
テステスト　テステス様

B.R.ONLINE

お客様の仮会員登録の受付けが完了致しました。
下記のURLのリンクから本会員手続きにお進みください。

以上です。

EOT;

		$body .= PHP_EOL.'https://www.bronline.jp/signup/complete?id=6639&sk=r55aef778308c3gKPstGdH'.PHP_EOL;
		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from($from);
		$email->to($to);
		$email->to($to2);
		$email->subject($subject);
		$email->body($body);
		$email->pipelining(true);
		$email->send();
		*/



		$to			= 'pidepiper-2008@i.softbank.jp';
		//$to			= 'kaihatsu.test2016@gmail.com';
		$from		= 'bronline@bronline.jp';
		$cc			= '';
		$bcc		= '';
		$subject	= 'テストメール送信';
		$body		= 'ほげほげ';
/*
		$body = <<<EOT
テステスト　テステス様

B.R.ONLINE

お客様の仮会員登録の受付けが完了致しました。
下記のURLのリンクから本会員手続きにお進みください。

以上です。

EOT;
*/

		//$customer_id = 24;
		$customer_id = 10974;
		$res = DB::select()->from('dtb_customer')->where('customer_id', $customer_id)->execute()->as_array();
		$arrCustomer = $res[0];

		// メール送信
		$tpl = 'smarty/email/signup_temp_menber.tpl';
		$arrResult["arrForm"] = $arrCustomer;
		$arrResult['registurl'] = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"]."/signup/complete?id=".$arrCustomer['customer_id']."&sk=".$arrCustomer['secret_key'];
		//$arrResult['registurl'] = "https://www.bronline.jp/";

		$email = Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		$email->from(CUSTOMER_TEMP_MAIL_FROM);
		$email->to('pidepiper-2008@i.softbank.jp');
		//$email->to($arrCustomer['email']);
		$email->subject(CUSTOMER_TEMP_MAIL_TITLE);
		$email->body(\View_Smarty::forge( $tpl, $arrResult, false));
		
		$body = $email->get_body();
		
		$email->send();
		$email = null;
/*
		$retSend = $this->mailSend($to, $from, $cc, $bcc, $subject, $body);
		if( $retSend ) {
			echo "送信成功";
		} else {
			echo "送信失敗";
		}
*/
		$tpl = 'smarty/test.tpl';
		return View_Smarty::forge( $tpl, array(), false );
	}



	function mailSend( $to, $from, $cc, $bcc, $subject, $body )
	{
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		$headers = array();
		//$headers['MIME-Version']	= '1.0';
		//$headers['Content-Type']	= 'text/plain; charset=UTF-8';
		//$headers['Content-Type']	= 'text/plain; charset=iso-2022-JP';
		//$headers['Content-Transfer-Encoding']	= 'base64';
		//$headers['Content-Transfer-Encoding']	= '7bit';
		//$headers['Content-Transfer-Encoding']	= '8bit';
		$headers['From']			= $from;
		//$headers['From']			= mb_encode_mimeheader($from);
		$headers['Return-Path']		= $from;
		//$headers['Return-Path']		= mb_encode_mimeheader($from);
		//$headers['Subject']			= mb_encode_mimeheader($subject);
		foreach ($headers as $key => $val) {
			$arrheader[] = $key . ': ' . $val;
		}
		$strHeader = implode("\n", $arrheader);

		$message = $body;
		var_dump($message);
		echo "<br/>";

		$message = mb_convert_encoding($message, "iso-2022-JP", "UTF-8");
		var_dump($message);
		echo "<br/>";

		//$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject, "iso-2022-JP", "UTF-8"))."?=";
		//$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS","UTF-8"))."?=";

		//$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP-MS');
		//$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP');
		
		//$subject = mb_convert_encoding($subject,'utf-8',mb_detect_encoding($subject));
		$subject = mb_convert_encoding($subject, "iso-2022-JP", "UTF-8");
		$subject = base64_encode($subject);
		//$subject = mb_encode_mimeheader($subject);

		//$subject = mb_convert_encoding($subject, "iso-2022-JP", "UTF-8");
		//$subject = mb_convert_encoding($subject, "JIS", "UTF-8");
		//$subject = base64_encode($subject);
		//$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP-MS');
		//$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP');
		$subject = '=?ISO-2022-JP?B?'.$subject.'?=';
		var_dump($subject);
		echo "<br/>";

		mb_send_mail('kaihatsu.test2016@gmail.com', $subject, 'MB:'.$message, $strHeader );
		mb_send_mail('kaihatsu.test2016@gmail.com', $subject, 'MB2:'.$message, $strHeader, '-f '.$from );
		mail('kaihatsu.test2016@gmail.com', $subject, $message, $strHeader );

		$retSend = mb_send_mail('pidepiper-2008@i.softbank.jp', $subject, 'MB:'.$message, $strHeader );
		mb_send_mail('pidepiper-2008@i.softbank.jp', $subject, 'MB2:'.$message, $strHeader, '-f '.$from );
		mail('pidepiper-2008@i.softbank.jp', $subject, $message, $strHeader );

		return $retSend;

	}





	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
//		return Response::forge(Presenter::forge('home/404'), 404);
		return View_Smarty::forge('smarty/misc/404.tpl');
//		return Response::forge(Presenter::forge('home/404'), 404);
	}


	public function action_401()
	{
		return View_Smarty::forge('smarty/misc/401.tpl');
	}


	public function action_403()
	{
		return View_Smarty::forge('smarty/misc/403.tpl');
	}


	public function action_500()
	{
		return View_Smarty::forge('smarty/misc/500.tpl');
	}


	public function action_503()
	{
		return View_Smarty::forge('smarty/misc/503.tpl');
	}


}

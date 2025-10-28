<?php

class Tag_CronMail
{
	function __construct()
	{
	}
	
	public static function send($ret, $template_id)
	{
		echo 'send'.PHP_EOL;

		$customer = $ret;
		
		$arrTemplate = Tag_Master::get_master('mtb_template_path');
		$tpl = '';
		foreach($arrTemplate as $temp)
		{
			if ($template_id == $temp['id'])
			{
				$tpl = $temp['name'];
				break;
			}
		}
		if ($template_id == 50)
			$id = 29;
		else
			$id = 30;

		$sql = "select * from dtb_mail_template where id = {$id}";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        $mail_temp = $arrRet[0];

		echo $tpl.PHP_EOL;
		echo $mail_temp['name'].PHP_EOL;

		$arrResult = array();
		$arrResult['tpl_header'] = $mail_temp['header'];
		$arrResult['tpl_footer'] = $mail_temp['footer'];
		$arrResult['customer'] = $customer;
		
		echo $mail_temp['name'].PHP_EOL;
		
		$email = \Email::forge();
		$email->header('Content-Transfer-Encoding', 'base64');
		echo CUSTOMER_TEMP_MAIL_FROM.PHP_EOL;
		$email->from(CUSTOMER_TEMP_MAIL_FROM);
		echo $customer['email'].PHP_EOL;
		echo $mail_temp['subject'].PHP_EOL;
		$email->to($customer['email']);
		$email->subject($mail_temp['subject']);
		$email->body(\View_Smarty::forge($tpl, $arrResult, false));
		$email->send();
		echo $mail_temp['name'];
		echo '送信完了'.PHP_EOL;


		//メール送信
//		echo $customer['name01'].$customer['name02'];
	}
}

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
class Controller_Admin_Mail extends ControllerAdmin
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

		$mail_type = Input::post('mail_type', '');
		$order_id = Input::post('order_id', '');

		if( $order_id != "" && $mail_type != "" ) {
			switch ( $mail_type ) {
				case 1:
					// 受注メール
					if( Tag_Mail::order_mail_order_id($order_id)) {
						$this->arrResult["arrMsg"][] = "[order_id : {$order_id}]　受注メール送信完了";
					} else {
						$this->arrResult["arrError"][] = "[order_id : {$order_id}]　受注メール送信エラー";
					}
					break;

				case 2:
					// ショップ受注
					$arrShops = Tag_Cartctrl::get_allshop();
					foreach($arrShops as $s)
					{
						$shop = $s['shop_id'];
						if( Tag_Mail::order_mail_shopmail_order_id($order_id, $shop)) {
							$this->arrResult["arrMsg"][] = "[order_id : {$order_id}]　{$shop} ショップ受注メール送信完了";
						} else {
							$this->arrResult["arrError"][] = "[order_id : {$order_id}]　{$shop} ショップ受注メール送信エラー";
						}
					}
					break;

				case 3:
					// クロスモール
					$shop = "guji";
					if( Tag_Mail::order_mail_crossmall_order_id($order_id, $shop)) {
						$this->arrResult["arrMsg"][] = "[order_id : {$order_id}]　{$shop} クロスモール連携メール送信完了";
					} else {
						$this->arrResult["arrError"][] = "[order_id : {$order_id}]　{$shop} クロスモール連携メール送信エラー";
					}
					$shop = "ring";
					if( Tag_Mail::order_mail_crossmall_order_id($order_id, $shop)) {
						$this->arrResult["arrMsg"][] = "[order_id : {$order_id}]　{$shop} クロスモール連携メール送信完了";
					} else {
						$this->arrResult["arrError"][] = "[order_id : {$order_id}]　{$shop} クロスモール連携メール送信エラー";
					}
					break;

				case 4:
					// ネクストエンジン
					$shop = "newsugawara";
					if( Tag_Mail::order_mail_nextmail_order_id($order_id, $shop)) {
						$this->arrResult["arrMsg"][] = "[order_id : {$order_id}]　{$shop} ネクストエンジン連携メール送信完了";
					} else {
						$this->arrResult["arrError"][] = "[order_id : {$order_id}]　{$shop} ネクストエンジン連携メール送信エラー";
					}
					break;

				default:

					$this->arrResult["arrError"][] = "メールタイプが不正です。";
			}
		}

		$this->tpl = 'smarty/admin/mail/index2.tpl';
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

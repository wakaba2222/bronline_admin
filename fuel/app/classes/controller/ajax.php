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
class Controller_Ajax extends Controller_Rest
{

	/**
	 * お気に入り追加
	 * @return unknown
	 */
	public function action_addwish()
	{
		$result = "";

		$customer_id = Input::json('customer_id');
		$product_id = Input::json('product_id');

		if( $customer_id != "" && $product_id != "" ) {
			$objWishlistctrl = new Tag_Wishlistctrl();
			$result = $objWishlistctrl->add_wish($customer_id, $product_id);
		}

		$this->format = 'json';
		$json = ['result' => $result];
		return $this->response($json);
	}


	/**
	 * お気に入り削除
	 * @return unknown
	 */
	public function action_delwish()
	{
		$result = "";

		$customer_id = Input::json('customer_id');
		$product_id = Input::json('product_id');

		if( $customer_id != "" && $product_id != "" ) {
			$objWishlistctrl = new Tag_Wishlistctrl();
			$result = $objWishlistctrl->del_wish($customer_id, $product_id);
		}

		$this->format = 'json';
		$json = ['result' => $result];
		return $this->response($json);
	}


}

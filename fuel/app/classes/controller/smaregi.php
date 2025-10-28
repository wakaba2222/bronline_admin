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
class Controller_Smaregi extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_smaregi_get()
	{
//		Log::debug(json_encode(Input::param('params')));
		
		$temp = json_decode(str_replace('\\"', '"', Input::param('params')), true);
		$shop = Input::param('shop_id');
// mb_language("Japanese");
// $temp2 = '\\u30d5\\u30e9';
//  var_dump($this->unicode_encode($temp2));
//  exit;
//		$ttt = json_decode('{"result":{"TransactionHead":1,"TransactionHeadIds":["952"],"TransactionDetail":1}}', true);
		
//		var_dump($ttt['result']['TransactionHeadIds'][0]);
//		var_dump($temp);
 		Log::debug(Input::param('proc_name'));
 		Log::debug("smaregi get");
 		Log::debug(var_export($shop, true));
 		Log::debug(var_export($temp, true));
		
		switch(Input::param('proc_name'))
		{
			case 'product_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(var_export($data, true));
				Tag_Smaregi::set_product($data);
				break;
			}
			case 'stock_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(json_encode($data));
				Tag_Smaregi::set_stock($data, $shop);
				break;
			}
			case 'transaction_send':
			{
				break;
			}
			case 'customer_send':
			{
				break;
			}
			default:
				break;
		}

		$tpl = 'smarty/smaregi/index.tpl';



// 		//カートの数更新
// 		$cartctrl = new Tag_Cartctrl();
// 		$cartctrl->getSession();
// 		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		return View_Smarty::forge( $tpl, array(), false );
	}
	public function action_index()
	{
//		Log::debug(json_encode(Input::param('params')));
		
		$temp = json_decode(str_replace('\\"', '"', Input::param('params')), true);
		$shop = Input::param('shop_id', 'brshop');
//		$shop = Input::param('shop_id');
// mb_language("Japanese");
// $temp2 = '\\u30d5\\u30e9';
//  var_dump($this->unicode_encode($temp2));
//  exit;
//		$ttt = json_decode('{"result":{"TransactionHead":1,"TransactionHeadIds":["952"],"TransactionDetail":1}}', true);
		
//		var_dump($ttt['result']['TransactionHeadIds'][0]);
//		var_dump($temp);
 		Log::debug(Input::param('proc_name'));
 		Log::debug("smaregi get");
 		Log::debug(var_export($shop, true));
 		Log::debug(var_export($temp, true));
		
		switch(Input::param('proc_name'))
		{
			case 'product_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(var_export($data, true));
				Tag_Smaregi::set_product($data);
				break;
			}
			case 'stock_send':
			{
				$tbl = "Product";
				$data = $temp['data'][0]['rows'];
				Log::debug(json_encode($data));
				Tag_Smaregi::set_stock($data, $shop);
				break;
			}
			case 'transaction_send':
			{
				break;
			}
			case 'customer_send':
			{
				break;
			}
			default:
				break;
		}

		$tpl = 'smarty/smaregi/index.tpl';



// 		//カートの数更新
// 		$cartctrl = new Tag_Cartctrl();
// 		$cartctrl->getSession();
// 		$arrResult['cart_count'] = count($cartctrl->cart->getOrderDetail());

		return View_Smarty::forge( $tpl, array(), false );
	}

//	public function action_tools()
//	{
//		$tpl = 'smarty/smaregi/index.tpl';
//		return View_Smarty::forge( $tpl, array(), false );
//	}
//	
//	public function action_regist()
//	{
//		Tag_Smaregi::regist_category(array());
// 	}
//		
//	function action_registtran()
//	{
//		Tag_Smaregi::regist_transaction(array(),array());
//	}


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

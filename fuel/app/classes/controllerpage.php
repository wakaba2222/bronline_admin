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

class ControllerPage extends Controller
{
	/**
	 * @var  Request  The current Request object
	 */
	public $request;

	/**
	 * @var  Integer  The default response status
	 */
	public $response_status = 200;

	protected $shop_name = '';
	protected $shop_url = '';
	protected $meta = '';

	/**
	 * Sets the controller request object.
	 *
	 * @param   \Request $request  The current request object
	 */
	public function __construct(\Request $request)
	{
		$this->request = $request;
	}

	/**
	 * This method gets called before the action is called
	 */
	public function before()
	{
// 		var_dump(Uri::segment(2));
// 		var_dump(Uri::segment(3));
		$this->shop_url = Uri::segment(2);
		$this->shop_name = '';
		$urls = Input::param();

// 		$shop_name = Tag_Item::get_shop($this->shop_url);
		//var_dump($this->shop_url);
// 		if (count($shop_name) == 0 && $this->shop_url != null)
// 		{
// 			//$this->response_status = 404;
// 			Response::redirect('/');
// 		}

//   		$shop_name = Tag_Item::get_shop($this->shop_url);
// 		if (count($shop_name) == 0 && Uri::segment(1) == 'mall')
// 		{
// 			return Response::redirect('/404/');
//  		}
		if ($this->param('shop') != '')
		{
			$url = $this->param('shop');
			if (strpos('/', $url) !== false)
			{
				$url = explode('/', $url);
				$url = $url[count($url)-1];
			}

			$this->shop_url = Uri::segment(2);
			$this->shop_name = Tag_Item::get_shop($this->shop_url);
			Profiler::console($this->shop_name);
		}
		else if (count($urls) > 0)
		{
			Profiler::console($urls);
			foreach($urls as $k=>$v)
			{
				$url = $k;
				if (strpos($url, '/mall/') !== false)
				{
					$url = explode('/', $url);
					$url = $url[2];
					$this->shop_url = Uri::segment(2);
					$this->shop_name = Tag_Item::get_shop($this->shop_url);
					Profiler::console($this->shop_name);
				}
			}
		}

		$this->meta = array('description' => '', 'keyword' => '', 'og_title' => '', 'og_description' => '', 'og_url' => '', 'og_image' => '', 'og_site_name' => '');
//		$this->meta['og_url'] = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$this->meta['og_url'] = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . "www.bronline.jp" . $_SERVER["REQUEST_URI"];
		$this->meta['og_site_name'] = META_SITE_NAME;
	}

	/**
	 * This method gets called after the action is called
	 * @param \Response|string $response
	 * @return \Response
	 */
	public function after($response)
	{
$start = microtime(true);
// 		print("<pre>");
// 		var_dump($this->response_status);
// 		var_dump($response->status);
// 		print("</pre>");
// 		exit;
// 		$shop_name = array();
// 		$shop_name = Tag_Item::get_shop($this->shop_url);
// 		print("<pre>");
// 		var_dump($this->shop_url);
// 		var_dump($shop_name);
// 		print("</pre>");
// 		exit;
// 		if (count($shop_name) == 0 && $this->shop_url != null)
// 		{
//			$response->status = 404;
//			return $response;
			//$this->response_status = 404;
// 			return Response::redirect('/error');
// 	//		Response::redirect('/');
// 		}

		if (isset($response->status) && $response->status == 404)
		{
			if ( ! $response instanceof Response)
			{
				$headers = array(
				'X-Frame-Options'=>'DENY',
				'X-XSS-Protection'=>'1',
				'X-Content-Type-Options'=>'nosniff',
//				'Cache-Control'=>'maxage=3600',
//				'Pragma'=>'public',
//				'expires'=>'',
				);
				$response = \Response::forge($response, $this->response_status, $headers);
			}


			/*
			echo "<pre>";
			print_r($response->body);
			echo "</pre>";
			*/

			return $response;
		}
		$objCustomer = new Tag_customerctrl();
		$objCustomer->getSession();

		$arrCustomer = array();
		$arrCustomer["customer_id"] = $objCustomer->customer->getCustomerId();
		$arrCustomer["name"] = $objCustomer->customer->getName01().$objCustomer->customer->getName02();
		$arrCustomer["point"] = $objCustomer->customer->getPoint();
		$arrCustomer["point_rate"] = $objCustomer->customer->getPointRate();
		$arrCustomer["rank"] = $objCustomer->customer->getRank();
		$arrCustomer["sale_status"] = $objCustomer->customer->getSaleStatus();

		$response->set('customer', $arrCustomer);

		$response->set('week', array('日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'));

		//カートの数更新
		$cartctrl = new Tag_Cartctrl();
		$cartctrl->getSession();
		$count = 0;

		foreach($cartctrl->cart->getOrderDetail() as $d)
		{
			$count += $d->getQuantity();
		}
		$response->set('cart_count',$count);

		if ($this->shop_url != '')
		{
			$sql = "select id from dtb_shop where login_id = '{$this->shop_url}' ";
			$ret = DB::query($sql)->execute()->as_array();
			$where = '';
			if (count($ret) > 0)
				$where = " shop_id = '{$ret[0]['id']}' ";
			$arrCategory = Tag_Item::get_category('', $where);
		}
		else
			$arrCategory = Tag_Item::get_category();

		$arrCategory2 = Tag_Item::get_category();

		$response->set('arrCategory2', $arrCategory2);
		$response->set('arrCategory', $arrCategory);
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER START 処理時間 = ' . $sec . ' 秒 '.session_id());

		$category = "";
		$cat = Input::param('cat', '');
		if ($cat != '')
		{
			$cat = str_replace('::', '&', $cat);
			$arrRet = Tag_Item::get_category_item($cat);
			if (count($arrRet) > 0)
			{
				if (isset($arrRet['parent_name']))
				{
					$category = $arrRet['parent_name'];
					$subcategory = $arrRet['category_name'];
					$filter = 'on';
				}
				else
				{
					$category = $arrRet['category_name'];
				}
			}
		}

		if ($category == "")
			$category = Input::param('category');
		$arrSubCategory = array();
		if ($category != '')
		{
			$arrSubCategory = Tag_Item::get_category2(urldecode($category));
		}
		$response->set('arrSubCategory', $arrSubCategory);
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 2 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		//Profiler::console($arrCategory);
		//var_dump(Tag_Item::get_category2($category));
		//var_dump(DB::last_query());

		//ブランド
// 		if ($this->shop_url != '')
// 			$arrTemp = Tag_Item::get_brand(true);
// 		else
//		if ($this->shop_url != '')
//		{
//			$where = " shop_url = '{$this->shop_url}' group by name ";
//			$arrTemp = Tag_Item::get_brand_like($where);
//		}
//		else
//			$arrTemp = Tag_Item::get_brand();

		$redis = Redis_Db::forge();
		
		$cahce = '';
		$time = date('YmdHis');
		$dest_time = @$redis->get('afterbrand_time'.$cahce);
		$c = 0;
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('afterbrand'.$cahce));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			if ($this->shop_url != '')
			{
				$where = " shop_url = '{$this->shop_url}' group by name ";
				$arrRet = Tag_Item::get_brand_like($where);
			}
			else
				$arrRet = Tag_Item::get_brand();
			
			$redis->set('afterbrand'.$cahce, serialize($arrRet));
			$redis->set('afterbrand_time'.$cahce, date('YmdHis'));
		}
		$arrTemp = $arrRet;
			
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 2.1 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		$redis = Redis_Db::forge();
		
		$cahce = '';
		$time = date('YmdHis');
		$dest_time = @$redis->get('afterbrand2_time'.$cahce);
		$c = 0;
		if (($time - $dest_time) <= 120)
		{
			$arrRet = @unserialize($redis->get('afterbrand2'.$cahce));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = Tag_Item::get_brand();
			
			$redis->set('afterbrand2'.$cahce, serialize($arrRet));
			$redis->set('afterbrand2_time'.$cahce, date('YmdHis'));
		}
		$arrTemp2 = $arrRet;
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 2.2 START 処理時間 = ' . $sec . ' 秒 '.session_id());

//		$arrTemp2 = Tag_Item::get_brand();
//		$arrTemp = array();
		$arrBrand = array();
		$brand = Input::param('brand');
		$brands = explode(',', stripslashes($brand));
//		var_dump($arrTemp);
//print("<pre>");
		foreach($arrTemp as $b)
		{
			//var_dump($b['id'].':'.$b['name'].'::'.Tag_Item::get_brand_cnt($b['id'], $this->shop_url));
			if (Tag_Item::get_brand_cnt($b['id'], Tag_Shop::get_shop_id($this->shop_url)) == 0)
				continue;
			$ac = '';
			foreach($brands as $s)
			{
				if ($b['name'] == $s)
					$ac = '1';
			}
			$b['active'] = $ac;
			$b['name'] = urlencode($b['name']);
			$arrBrand[] = $b;
		}
		$response->set('arrBrand2', $arrTemp2);
		$response->set('arrBrand', $arrBrand);
		$response->set('brands', $brands);
//		Profiler::console($arrBrand);
//print("</pre>");
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 3 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		//サイズ
		$arrTemp = Tag_Item::get_size();
		$arrSize = array();
		$size = Input::param('size');
		$sizes = explode(',', $size);
//		Profiler::console($sizes);
		foreach($arrTemp as $b)
		{
			$ac = '';
			foreach($sizes as $s)
			{
				if ($b['name'] == $s)
					$ac = '1';
			}
			$b['active'] = $ac;
			$arrSize[] = $b;
		}
		$response->set('arrSize', $arrSize);
		$response->set('sizes', $sizes);

		//カラー
		$arrTemp = Tag_Item::get_color();
		$arrColor = array();
		$color = Input::param('color');
		$colors = explode(',', $color);
		foreach($arrTemp as $b)
		{
			$ac = '';
			foreach($colors as $s)
			{
				if ($b['name'] == $s)
					$ac = '1';
			}
			$b['active'] = $ac;
			$arrColor[] = $b;
		}
		$response->set('arrColor', $arrColor);
		$response->set('colors', $colors);

		// shop
		$arrTemp = Tag_Item::get_shoplist();
		$arrShop = array();
		$arrShop2 = array();
		$shop = Input::param('shopn');
		$shops = explode(',', $shop);
		$shoplist = array();
		foreach($arrTemp as $b)
		{
			$ac = '';
			foreach($shops as $s)
			{
				if ($b['login_id'] == $s)
				{
					$ac = '1';
					$shoplist[$b['login_id']] = $b['shop_name'];
				}
			}
			$b['active'] = $ac;
			if ($b['login_id'] != 'specialstore' && $b['login_id'] != 'specialstore2' && $b['login_id'] != 'specialstore3')
			{
				$arrShop[] = $b;
			}
//			$arrShop[] = $b;
		}
//		var_dump($arrShop);
		$response->set('arrShop', $arrShop);
//		$response->set('arrShop2', $arrShop2);
		$response->set('shops', $shoplist);
		//Profiler::console($arrShop);
		$arrTemp = Tag_Item::get_shoplist(' AND A.popup_flg = 1');
		$popup = array();
		if (count($arrTemp) > 0)
		{
			$popup = $arrTemp;
		}
		Profiler::console($arrTemp);
		$response->set('arrPopup', $popup);
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 4 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		// お気に入り
		$arrWish = array();
		$objWishlistctrl = new Tag_Wishlistctrl();
		if( $objCustomer->customer->getCustomerId() != "" ) {
			// ログインしている場合はDBから取得
			$arrWish = $objWishlistctrl->get_wish_product_id_list($objCustomer->customer->getCustomerId());
		} else {
			// ログインしていない場合はCookieから取得
			$arrWish = $objWishlistctrl->get_wish_product_id_list_cookie();
		}
		$response->set('arrWish', $arrWish);

		$arrCheckItem = Tag_Item::get_check_items();		// チェックアイテムの取得
		$response->set('arrCheckItem', $arrCheckItem);
//		Profiler::console($arrCheckItem);

		$attention = get_news_list(999,1,"1");	// ATTENTIONの取得
		$attention2 = get_news_list(8,1);	// ATTENTIONの取得
//var_dump($attention);
		$response->set('attention', $attention);
		$response->set('attention2', $attention2);
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 5 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		$redis = Redis_Db::forge();
		
		$cahce = '';
		$time = date('YmdHis');
		$dest_time = @$redis->get('pickup2_time'.$cahce);
		$c = 0;
		if (($time - $dest_time) <= 300)
		{
			$arrRet = @unserialize($redis->get('pickup2'.$cahce));
		}
		else
			$arrRet = '';

		if ($arrRet == '')
		{
			$arrRet = get_pickup();		// PICK UPの取得
			
			$redis->set('pickup2'.$cahce, serialize($arrRet));
			$redis->set('pickup2_time'.$cahce, date('YmdHis'));
		}
		$arrPickup = $arrRet;


//		$arrPickup = get_pickup();		// PICK UPの取得
		$response->set('arrPickup', $arrPickup);
		$response->set('sp', Agent::is_smartphone());
		$response->set('meta', $this->meta);
		if ($this->shop_url)
			$response->set('urls', Uri::segment(3));
		else
			$response->set('urls', Uri::segment(1));

//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER 6 START 処理時間 = ' . $sec . ' 秒 '.session_id());

		$sql = "select * from dtb_ads";
		$arrRet = DB::query($sql)->execute()->as_array();
		$arrAds = $arrRet[0];
		$response->set('arrAds', $arrAds);

		// Make sure the $response is a Response object
		if ( ! $response instanceof Response)
		{
				$headers = array(
				'X-Frame-Options'=>'DENY',
				'X-XSS-Protection'=>'1',
				'X-Content-Type-Options'=>'nosniff',
//				'Cache-Control'=>'maxage=3600',
//				'Pragma'=>'public',
//				'expires'=>date(DATE_RFC2822,strtotime('+300 seconds')),
//				'expires'=>'',
//				'Pragma'=>'public',
				);
				$response = \Response::forge($response, $this->response_status, $headers);
		}
//$end = microtime(true);
//$sec = (float)((float)$end - (float)$start);
//$this->debug('SET AFTER END 処理時間 = ' . $sec . ' 秒 '.session_id());

		/*
		echo "<pre>";
		print_r($response->body);
		echo "</pre>";
		*/

		return $response;
	}

	/**
	 * This method returns the named parameter requested, or all of them
	 * if no parameter is given.
	 *
	 * @param   string  $param    The name of the parameter
	 * @param   mixed   $default  Default value
	 * @return  mixed
	 */
	public function param($param, $default = null)
	{
		return $this->request->param($param, $default);
	}

	/**
	 * This method returns all of the named parameters.
	 *
	 * @return  array
	 */
	public function params()
	{
		return $this->request->params();
	}

    public function doValidToken($is_admin = false)
    {
        if ($is_admin)
        {
            $mode = $this->getMode();
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (!Tag_Session::isValidToken(false))
                {
                	return false;
//                    SC_Utils_Ex::sfDispError(INVALID_MOVE_ERRORR);
//                    SC_Response_Ex::actionExit();
                }
            }
        }
        else
        {
        	if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET')
            {
                if (!Tag_Session::isValidToken(false))
                {
                	return false;
//                     SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, '', true);
//                     SC_Response_Ex::actionExit();
                }
             }
        }

        return true;
    }

    function getMode() {
        $pattern = '/^[a-zA-Z0-9_]+$/';
        $mode = null;
        if (isset($_GET['mode']) && preg_match($pattern, $_GET['mode'])) {
            $mode =  $_GET['mode'];
        } elseif (isset($_POST['mode']) && preg_match($pattern, $_POST['mode'])) {
            $mode = $_POST['mode'];
        }
        return $mode;
    }

	public function action_404()
	{
		return View_Smarty::forge('smarty/misc/404.tpl');
		//        return View_Smarty::forge('smarty/404.tpl');
		//		return Response::forge(Presenter::forge('home/404'), 404);
	}
	public function debug($str)
	{
//		return;
//		$fp = fopen("/var/www/bronline/fuel/app/logs/after".date('Ymd').".log", "a");
//		if ($fp)
//		{
//			fputs($fp, date("Y-m-d H:i:s").":");
//			fputs($fp, print_r($str, true));
//			fputs($fp, PHP_EOL);
//			fclose($fp);
//		}
//		
//		return;
	}
}

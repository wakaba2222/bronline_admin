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
class Controller_Item extends ControllerPage
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
//		$check = str_replace("'", '"', $check);
		
		return $check;			
	}
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$product_id = Input::param('detail');
		$page		= Input::param('page', 1);		// 取得ページ
		$order		= Input::param('order', 'update_date');	// 並び替え
		$view		= Input::param('view', '');	// 並び替え
		$filter		= Input::param('filter', 'off');	// 並び替え
		$category		= urldecode(Input::param('category', ''));	// 並び替え
		$subcategory		= Input::param('subcategory', '');	// 並び替え
		$brand		= Input::param('brand', '');	// 並び替え
		$size		= Input::param('size', '');	// 並び替え
		$color		= Input::param('color', '');	// 並び替え
		$shop		= Input::param('shop', '');	// 並び替え
		$shopn		= Input::param('shopn', '');	// 並び替え
		$cat		= Input::param('cat', '');	// 並び替え
		$page2		= Input::param('page2', 1);		// 関連記事ページ
		$sale		= Input::param('sale_status', 0);	//セール対象
		$sale_pre		= Input::param('sale_status_pre', 0);	//セール対象
		$arrResult['arrView'] = Tag_Item::get_product_view();
		if ($view == '')
			$view = $arrResult['arrView'][0]['name'];

		$view = $this->sunitz($view);
		$arrResult['view'] = urldecode($view);

		$page = $this->sunitz($page);
		$arrResult['page'] = urldecode($page);

		$order = $this->sunitz($order);
		$arrResult['order'] = urldecode($order);

		$filter = $this->sunitz($filter);
		$arrResult['filter'] = urldecode($filter);

		$category = $this->sunitz($category);
		$arrResult['category'] = urldecode($category);

		$size = $this->sunitz($size);
		$arrResult['size'] = urldecode($size);

		$brand = $this->sunitz($brand);
		$arrResult['brand'] = $brand;

		$color = $this->sunitz($color);
		$arrResult['color'] = urldecode($color);

//		$category = $this->sunitz($category);
//		$arrResult['category'] = urldecode($category);

		$subcategory = $this->sunitz($subcategory);
		$arrResult['subcategory'] = urldecode($subcategory);

		$shopn = $this->sunitz($shopn);
		$arrResult['shopn'] = urldecode($shopn);

		$shop = $this->sunitz($shop);
		$arrResult['shop'] = urldecode($shop);

		$page2 = $this->sunitz($page2);
		$arrResult['page2'] = $page2;

		$sale = $this->sunitz($sale);
		$arrResult['sale'] = urldecode($sale);

		if ($sale_pre != $sale)
		{
			$page = 1;
			$page2 = 1;
			$arrResult['page'] = 1;
			$arrResult['page2'] = 1;
		}
//		if ($sale != 0 && $page)
//		{
//			$page = 1;
//			$page2 = 1;
//			$arrResult['page'] = 1;
//			$arrResult['page2'] = 1;
//		}

//		$arrResult['view'] = urldecode($view);
//		$arrResult['page'] = urldecode($page);
//		$arrResult['order'] = urldecode($order);
//		$arrResult['filter'] = urldecode($filter);
//		$arrResult['category'] = urldecode($category);
//		$arrResult['size'] = urldecode($size);
//		$arrResult['brand'] = $brand;
//		$arrResult['color'] = urldecode($color);
//		$arrResult['category'] = urldecode($category);
//		$arrResult['subcategory'] = urldecode($subcategory);
//		$arrResult['shopn'] = urldecode($shopn);
//		$arrResult['shop'] = urldecode($shop);
//		$arrResult['page2'] = $page2;

// 		var_dump($brand);
		Profiler::console($brand);
// exit;


		if( $this->shop_url != "") {
			// ショップアカウントのユーザーIDを取得
			$arrShopUserId = array();
			$arrShopUser = get_shop_user_list( $this->shop_url, 1);
			foreach ( $arrShopUser['arrUsers'] as $user ) {
				$arrShopUserId[] = $user['ID'];
			}
			$user_id = implode(",", $arrShopUserId);

			// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得
			$arrResult['article_num'] = get_article_num($user_id);
		}

//var_dump($product_id);
//exit;

		$arrSales = Tag_Basis::get_basis(array('sale','start_date','end_date','vip_sale','vip_start_date','vip_end_date'), 'dtb_sales');
		$arrSales = $arrSales[0];
		$now = date('YmdHis');
		
		$start_date = date('YmdHis', strtotime($arrSales['start_date']));
		$end_date = date('YmdHis', strtotime($arrSales['end_date']));
		$vip_start_date = date('YmdHis', strtotime($arrSales['vip_start_date']));
		$vip_end_date = date('YmdHis', strtotime($arrSales['vip_end_date']));
		$arrResult['sale_flg'] = 0;
		$arrResult['vip_sale_flg'] = 0;
		$arrResult['sale_par'] = 0;
		if ($start_date <= $now && $end_date >= $now)
		{
			$arrResult['sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['sale'];
		}
		else if ($vip_start_date <= $now && $vip_end_date >= $now)
		{
			$arrResult['vip_sale_flg'] = 1;
			$arrResult['sale_par'] = $arrSales['vip_sale'];
		}
//var_dump($arrResult['sale_par']);


		if ($product_id != '')
		{
			$product_id = htmlspecialchars($product_id, ENT_QUOTES);
			if (!preg_match("/^[a-zA-Z0-9]+$/", $product_id))
			{
	 			return Response::redirect('/404/');
			}

			try
			{
				$cache = hash('sha256', 'p'.$page.'o'.$order.'pid'.$product_id.'sl'.$sale);
				$cache_key = 'itemdetail';
				return Cache::get($cache_key.$cache);
			}
			catch(\CacheNotFoundException $e)
			{
				Cache::delete('itemdetail'.$cache);
			}

			Log::debug(__FUNCTION__.'product_id:'.$product_id, true);
			Tag_Session::setCheckItem($product_id);
			$arrResult['arrItem'] = Tag_Item::get_detail($product_id, false, $this->shop_url);
			Log::debug('detail '.$product_id.' '.count($arrResult['arrItem']));
			if (count($arrResult['arrItem']) > 0)
			{
				$arrResult['arrItem']['info'] = nl2br(html_entity_decode($arrResult['arrItem']['info']));
				$arrResult['arrItem']['size_text'] = html_entity_decode($arrResult['arrItem']['size_text']);
 //var_dump($product_id);exit;
//Profiler::console($arrResult['arrItem']);
// var_dump($arrResult['arrItem']);
// exit;
				$arrResult['arrImages'] = Tag_Item::get_detail_images($product_id);
				$arrResult['arrSku'] = Tag_Item::get_detail_sku($product_id);
				$arrShopUserId = array();
				$arrShopUser = get_shop_user_list( $this->shop_url, 1);
				foreach ( $arrShopUser['arrUsers'] as $user ) {
					$arrShopUserId[] = $user['ID'];
				}
				$user_id = implode(",", $arrShopUserId);

				$arrResult['arrRelated2'] = get_feature_list(3, 1, "", "", $user_id , 1);		// 関連記事

				$size_option = array();
				$color_option = array();
				$options = array();
				foreach($arrResult['arrSku'] as $option)
				{
					$size_option[$option['size_code']] = $option['size_name'];
					$color_option[$option['color_code']] = $option['color_name'];
					$options['size'][$option['size_code']][] = $option['color_code'];
					$options['color'][$option['color_code']][] = $option['size_code'];
				}
				ksort($size_option);
				$arrResult['size_option'] = $size_option;
				$arrResult['color_option'] = $color_option;
				$arrResult['options'] = json_encode($options,true);
// 				var_dump($size_option);
// 				var_dump($color_option);



				// meta情報設定
				$description = mb_substr(str_replace('"', "”", str_replace(PHP_EOL, '', strip_tags($arrResult['arrItem']['info']))), 0, META_DESCRIPTION_LENGTH);
				$og_image = "";
				if( 0 < count($arrResult['arrImages']) ) {
					$og_image = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] ."/upload/images/".$arrResult['arrItem']['login_id']."/".$arrResult['arrImages'][0]['path'];
				}
				$arrKeyword = array();
				$arrKeyword[] = $arrResult['arrItem']['name'];
				$arrKeyword[] = $arrResult['arrItem']['brand_name'];
				$arrKeyword[] = $arrResult['arrItem']['brand_name_kana'];
				$this->meta['description']		= $description;
				$this->meta['keyword'] 			= implode(',', $arrKeyword);
				$this->meta['og_title']			= $arrResult['arrItem']['name'];
				$this->meta['og_description']	= $description;
				$this->meta['og_image']			= $og_image;

//var_dump($arrShop);
				$tpl = 'smarty/item/detail.tpl';

				$arrShop = Tag_Shop::get_shopdetail("A.login_id = '".$this->shop_url."'");
				if (@$arrShop[0]['shop_status'] == 2)
				{					
					$tpl2 = 'smarty/mall/'.$this->shop_url.'/standingby.tpl';
					if (file_exists(dirname( __FILE__ )."../../views/".$tpl2))
			 			return Response::redirect('/mall/'.$this->shop_url.'/');
				}

				if ($this->shop_url != '')
				{
					$arrResult['url'] = 'mall/'.$this->shop_url.'/item?';
				}
				else
				{
					$arrResult['url'] = 'item?';
				}
			}
			else
			{
	 			return Response::redirect('/404/');
// 				$tpl = 'smarty/404.tpl';
// 				return View_Smarty::forge( $tpl, $arrResult, false );
			}
		}
		else
		{
			$cache_key = 'item';
			
			$orderby = 'update_date desc';
			if ($order == 'update_date')
				$orderby = 'update_date desc';
			else if ($order == 'price_asc')
				$orderby = 'price01 asc';
			else if ($order == 'price_desc')
				$orderby = 'price01 desc';
			$where = '';

			try
			{
				$cache = hash('sha256', 'p'.$page.'o'.$orderby.'c'.$cat.'cate'.$category.'sub'.$subcategory.'co'.$color.'s'.$size.'b'.$brand.'sh'.$shopn.'shop'.$this->shop_url.'sl'.$sale);
				return Cache::get($cache_key.$cache);
			}
			catch(\CacheNotFoundException $e)
			{
				Cache::delete('itemdetail'.$cache);
			}

			if ($cat != '')
			{
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
						$category = $arrRet['parent_name'];
						$filter = 'on';
					}
				}
			}

			//カテゴリ関連
			if ($category != '' && $subcategory == '')
			{
				$category_id = Tag_Item::get_category_id($category);
				if (!preg_match("/^[a-zA-Z0-9]+$/", $category_id))
				{
		 			return Response::redirect('/404/');
				}
				else if ($category_id == 0)
				{
		 			return Response::redirect('/404/');
				}

				$where .= " (H.category_id = '{$category_id}' OR H.parent_category_id = '{$category_id}') ";
			}
			else if ($subcategory != '')
			{
				$category_id = Tag_Item::get_category_id($subcategory, true);
				if (!preg_match("/^[a-zA-Z0-9]+$/", $category_id))
				{
		 			return Response::redirect('/404/');
				}
				else if ($category_id == 0)
				{
		 			return Response::redirect('/404/');
				}
				$where .= " (H.category_id = '{$category_id}' OR H.parent_category_id = '{$category_id}') ";
			}

			if ($color != '')
			{
				$colors = explode(',', $color);
				$target_color = '';
				foreach($colors as $c)
				{
					if ($c == '')
						continue;
					$arrRet = Tag_Item::get_color($c);
					if (count($arrRet) > 0)
					{
						if ($target_color != '')
							$target_color .= ',';
						$target_color .= $arrRet[0]['pattern'];
					}
				}
				$target_color = str_replace(',', "','", $target_color);
				if ($where != '')
					$where .= " AND ";
				$where .= " (D.color_name in ('{$target_color}')) ";
			}

			if ($size != '')
			{
				$sizes = explode(',', $size);
				$target_size = '';
				foreach($sizes as $c)
				{
					if ($c == '')
						continue;
					$arrRet = Tag_Item::get_size($c);
					if (count($arrRet) > 0)
					{
						if ($target_size != '')
							$target_size .= ',';
						$target_size .= $arrRet[0]['pattern'];
					}
				}
				$target_size = str_replace(',', "','", $target_size);
				if ($where != '')
					$where .= " AND ";
				$where .= " (D.size_name in ('{$target_size}')) ";
			}

			if ($brand != '')
			{
				$target_brand = str_replace(',', "','", $brand);
				if ($where != '')
					$where .= " AND ";
				$where .= " (I.name in ('{$target_brand}')) ";
			}

			if ($shopn != '')
			{
				$target_shop = str_replace(',', "','", $shopn);
				if ($where != '')
					$where .= " AND ";
				$where .= " (C.login_id in ('{$target_shop}')) ";
			}
			if ($this->shop_url != '')
			{
				if ($where != '')
					$where .= " AND ";
				$where .= " (C.login_id in ('{$this->shop_url}')) ";
			}
			$objCustomer = new Tag_customerctrl();
			$objCustomer->getSession();
//var_dump($objCustomer->customer->getSaleStatus());
//var_dump($arrResult['sale_flg']);
//var_dump($arrResult['vip_sale_flg']);
//var_dump($sale);

			if ($sale != 0 && (($objCustomer->customer->getSaleStatus() == 1 && $arrResult['sale_flg'] == 1) || ($objCustomer->customer->getSaleStatus() == 2 && $arrResult['vip_sale_flg'] == 1)))
			{
				if ($where != '')
					$where .= " AND ";
				$where .= " A.sale_status = ".$sale." ";
			}
			else if ($sale != 0)
			{
				if ($where != '')
					$where .= " AND ";
				$where .= " A.sale_status = -1 ";
			}
//var_dump($arrResult['page']);
// 			Profiler::console($this->shop_url);


			$item_cnt = 0;
			$arrResult['items'] = Tag_Item::get_items($where, $orderby, $page, $view, false, $item_cnt);
			$arrResult['max'] = @ceil($item_cnt/$view);
			
			if ($arrResult['max'] == 0)
				$arrResult['max'] = 1;

//var_dump($arrResult['max']);
//var_dump($view);
//var_dump($page);
//var_dump($item_cnt);

			$pc = 5;
			if ($page - $pc <= 0)
				$arrResult['pstart'] = 1;
			else
				$arrResult['pstart'] = $page - $pc;
			if ($page + $pc >=  $arrResult['max'])
				$arrResult['pend'] = $arrResult['max'];
			else
				$arrResult['pend'] = $page + $pc;
// var_dump($arrResult['pstart']);
// var_dump($arrResult['pend']);
// 		print("<pre>");
// 		var_dump(Tag_Item::get_item_count());
// 		var_dump($arrResult['items']);
// 		print("</pre>");

			$tpl = 'smarty/item/index.tpl';
			if ($this->shop_url != '')
			{
				$arrResult['url'] = 'mall/'.$this->shop_url.'/item?';
				$tpl = 'smarty/mall/brshop/item/index.tpl';

				$arrShop = Tag_Shop::get_shopdetail("A.login_id = '".$this->shop_url."'");
				if (@$arrShop[0]['shop_status'] == 2)
		 			return Response::redirect('/mall/'.$this->shop_url.'/');
			}
			else
			{
				$arrResult['url'] = 'item?';
			}



			// meta情報設定
			$description = "ITEM一覧";
			$this->meta['description']		= $description;
			$this->meta['og_title']			= $description;
			$this->meta['og_description']	= $description;

		}

		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;
//		Profiler::console($arrResult);

		$arrResult['transactionid'] = Tag_Session::getToken();

		$per_page = Agent::is_smartphone() ? 4 : 5;		// スマホ時は４件
		$arrShopUserId = array();
		$arrShopUser = get_shop_user_list( $this->shop_url, 1);
		foreach ( $arrShopUser['arrUsers'] as $user ) {
			$arrShopUserId[] = $user['ID'];
		}
		$user_id = implode(",", $arrShopUserId);
		$arrResult['arrRelated'] = get_style_snap_related_list($per_page, $page2, $user_id);
// 		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
// 		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得

		$arrSpecialStore = Tag_Shop::get_shoplist("A.login_id like 'specialstore%' and A.shop_status = 1");
		$arrTemp = array();
		$sort_by_last_modify = function($a, $b){
		    return filemtime($b) - filemtime($a);
		};
		foreach($arrSpecialStore as $sp)
		{
			$path = '/common/images/showcase_shop/'.$sp['login_id'].'/';
			$dir = glob("/var/www/bronline/public/".$path.'*') ;
			usort($dir, $sort_by_last_modify);
			$sp['img'] = $path.basename($dir[0]);
			$arrTemp[] = $sp;
		}
//		print("<pre>");
//		var_dump($arrTemp);
//		print("</pre>");
		$arrResult['arrSpecial'] = $arrTemp;
		$arrResult['debug'] = $debug;

		$tags = array();
		if ($product_id != '')
		{
			$arrTemp = Tag_Item::get_tag($product_id);
			$cnt = 3;
			foreach($arrTemp as $t)
			{
				if ($cnt-- == 0)
					break;
				$tags[] = $t['tag'];
			}
		}
		if (count($tags) > 0)
		{
			$arrResult['arrRelatedShop'] = Tag_Item::get_related($tags, $this->shop_url);		// ショップの関連取得
			$arrResult['arrRelatedMall'] = Tag_Item::get_related($tags, $this->shop_url, true);		// ショップの関連取得
		}
		else
		{
			$arrResult['arrRelatedShop'] = array();
			$arrResult['arrRelatedMall'] = array();
		}
		if ($product_id != '')
			$arrResult['arrRecommend'] = Tag_Item::get_recommend($product_id);
//		$arrResult['arrRecommend'] = array();
// Profiler::console($tags);
// Profiler::console($this->shop_url);
// Profiler::console(count($arrResult['arrRelatedShop']));
// Profiler::console(count($arrResult['arrRecommend']));

		$arrResult['listpage'] = 0;
		Profiler::console('Item count('.Tag_Item::get_item_count().')');
		
		Cache::set($cache_key.$cache,View_Smarty::forge( $tpl, $arrResult, false ),120);

		return View_Smarty::forge( $tpl, $arrResult, false );
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

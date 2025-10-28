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
class Controller_Justin extends ControllerPage
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

		$page		= Input::param('page', 1);		// 取得ページ
		$order		= Input::param('order', 'update_date');	// 並び替え
		$view		= Input::param('view', '');	// 並び替え
		$filter		= Input::param('filter', 'off');	// 並び替え
		$category		= Input::param('category', '');	// 並び替え
		$subcategory		= Input::param('subcategory', '');	// 並び替え
		$brand		= Input::param('brand', '');	// 並び替え
		$size		= Input::param('size', '');	// 並び替え
		$color		= Input::param('color', '');	// 並び替え
		$shop		= Input::param('shop', '');	// 並び替え
		$shopn		= Input::param('shopn', '');	// 並び替え
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
		$arrResult['brand'] = urldecode($brand);

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

		$sale = $this->sunitz($sale);
		$arrResult['sale'] = urldecode($sale);
//		$page2 = $this->sunitz($page2);
//		$arrResult['page'] = $page2;
		if ($sale_pre != $sale)
		{
			$page = 1;
//			$page2 = 1;
			$arrResult['page'] = 1;
//			$arrResult['page2'] = 1;
		}


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


		$where = '';

// var_dump(count($arrRet));
//var_dump($arrResult);

			$orderby = 'update_date desc';
			if ($order == 'update_date')
				$orderby = 'update_date desc';
			else if ($order == 'price_asc')
				$orderby = 'price01 asc';
			else if ($order == 'price_desc')
				$orderby = 'price01 desc';

			$where = 'status_flg = 1';//' EXISTS (SELECT status_flg FROM dtb_product_status WHERE status_flg = 1 AND product_id  = A.product_id) ';

			//カテゴリ関連
			if ($category != '' && $subcategory == '')
			{
				if ($where != '')
					$where .= " AND ";
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
				$category_id = Tag_Item::get_category_id($subcategory);
				if (!preg_match("/^[a-zA-Z0-9]+$/", $category_id))
				{
		 			return Response::redirect('/404/');
				}
				else if ($category_id == 0)
				{
		 			return Response::redirect('/404/');
				}
				if ($where != '')
					$where .= " AND ";
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
					if ($target_color != '')
						$target_color .= ',';
					$target_color .= $arrRet[0]['pattern'];
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
					if ($target_size != '')
						$target_size .= ',';
					$target_size .= $arrRet[0]['pattern'];
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

			$arrResult['items'] = Tag_Item::get_items($where, $orderby, $page, $view, false, $item_cnt);
			$arrResult['max'] = ceil($item_cnt/$view);

			$pc = 5;
			if ($page - $pc <= 0)
				$arrResult['pstart'] = 1;
			else
				$arrResult['pstart'] = $page - $pc;
			if ($page + $pc >=  $arrResult['max'])
				$arrResult['pend'] = $arrResult['max'];
			else
				$arrResult['pend'] = $page + $pc;

			$arrShop = Tag_Shop::get_shopdetail("A.login_id = '".$this->shop_url."'");
			if (@$arrShop[0]['shop_status'] == 2)
	 			return Response::redirect('/mall/'.$this->shop_url.'/');

			$tpl = 'smarty/justin/index.tpl';
			if ($this->shop_url != '')
			{
				$arrResult['url'] = 'mall/'.$this->shop_url.'/justin?';
				$tpl = 'smarty/mall/brshop/justin/index.tpl';
			}
			else
			{
				$arrResult['url'] = 'justin?';
			}

//		$arrResult['url'] = 'justin';
		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;
//		$arrResult['attention'] = get_attention();	// ATTENTIONの取得
//		$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
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
		$arrResult['listpage'] = 0;

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

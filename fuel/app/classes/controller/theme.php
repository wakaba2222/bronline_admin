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
class Controller_Theme extends ControllerPage
{
	/**
	 * THEME 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$theme_id	= Input::param('filters', "");
		$preview	= Input::param('preview', false);

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
		$arrResult['view'] = urldecode($view);
		$arrResult['page'] = urldecode($page);
		$arrResult['order'] = urldecode($order);
		$arrResult['filter'] = urldecode($filter);
		$arrResult['category'] = urldecode($category);
		$arrResult['size'] = urldecode($size);
		$arrResult['brand'] = urldecode($brand);
		$arrResult['color'] = urldecode($color);
		$arrResult['category'] = urldecode($category);
		$arrResult['subcategory'] = urldecode($subcategory);
		$arrResult['shopn'] = urldecode($shopn);
		$arrResult['shop'] = urldecode($shop);

//		$sale = $this->sunitz($sale);
		$arrResult['sale'] = urldecode($sale);

		if ($sale_pre != $sale)
		{
			$page = 1;
//			$page2 = 1;
			$arrResult['page'] = 1;
//			$arrResult['page2'] = 1;
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
		
		$arrResult['filters'] = $theme_id;

		if( $theme_id != "" ) {

			$data = get_br_theme($theme_id, $preview);

			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;

		$where = '';

// var_dump(count($arrRet));
// var_dump($arrResult);

			$orderby = 'update_date desc';
			if ($order == 'update_date')
				$orderby = 'update_date desc';
			else if ($order == 'price_asc')
				$orderby = 'price01 asc';
			else if ($order == 'price_desc')
				$orderby = 'price01 desc';

			$where = ' status = 2 ';//' EXISTS (SELECT status_flg FROM dtb_product_status WHERE status_flg = 1 AND product_id  = A.product_id) ';

			//カテゴリ関連
			if ($category != '' && $subcategory == '')
			{
				if ($where != '')
					$where .= " AND ";
				$category_id = Tag_Item::get_category_id($category);
				$where .= " (H.category_id = '{$category_id}' OR H.parent_category_id = '{$category_id}') ";
			}
			else if ($subcategory != '')
			{
				$category_id = Tag_Item::get_category_id($subcategory);
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
			
			if ($where != '')
				$where .= " AND theme_id = {$theme_id} ";
			else
				$where .= " theme_id = {$theme_id} ";
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
//var_dump($where);
			$arrResult['items'] = Tag_Item::get_items($where, $orderby, $page, $view, true, $item_cnt);
//var_dump(DB::last_query());
			$arrResult['max'] = ceil($item_cnt/$view);

			if ($this->shop_url != '')
			{
				$arrResult['url'] = 'mall/'.$this->shop_url.'/theme?';
				$tpl = 'smarty/mall/brshop/theme/detail.tpl';
			}
			else
			{
				$arrResult['url'] = 'theme?';
			}


			$tpl = 'smarty/theme/detail.tpl';

		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;
			$arrResult['attention'] = get_attention();	// ATTENTIONの取得
			$arrResult['arrPickup'] = get_pickup();
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

		} else {
			// テーマ一覧のようなページは無いので、IDが無い場合はとりあえずトップに
			return Response::redirect('/');
		}
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

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
class Controller_Brand extends ControllerPage
{
	/**
	 * BAND 取得
	 *
	 * @return unknown
	 */
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
//		$check = str_replace("'", '"', $check);
		
		return $check;			
	}

	public function action_index()
	{
$start = microtime(true);
		$debug = array();
		$arrResult = array();

		$brand_code	= Input::param('filters', "");
		$filters	= Input::param('filters', "");
		$page		= Input::param('page', 1);
		$preview	= Input::param('preview', false);
		$shop_url	= $this->param('shop');

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

		$reload		= Input::param('reload', 0);

		$arrResult['arrView'] = Tag_Item::get_product_view();
		if ($view == '')
			$view = $arrResult['arrView'][0]['name'];

		$filters = $this->sunitz($filters);
		if (strpos($filters, ';') !== false || strpos($filters, '=') !== false)
			$filters = '';
//var_dump($brand);
//var_dump($brand_code);
		$arrResult['filters'] = urldecode($filters);
//var_dump($arrResult['filters']);

		$brand_code = $this->sunitz($brand_code);
		if (strpos($brand_code, ';') !== false || strpos($brand_code, '=') !== false)
			$brand_code = '';

		$view = intVal($this->sunitz($view));
		$arrResult['view'] = urldecode($view);

		$page = intVal($this->sunitz($page));
		$arrResult['page'] = urldecode($page);

		$order = $this->sunitz($order);
		if (strpos($order, ';') !== false || strpos($order, '=') !== false)
			$order = 'update_date';

		$arrResult['order'] = urldecode($order);

		$filter = $this->sunitz($filter);
		if (strpos($filter, ';') !== false || strpos($filter, '=') !== false)
			$filter = 'off';
		$arrResult['filter'] = urldecode($filter);

		$category = $this->sunitz($category);
		if (strpos($category, ';') !== false || strpos($category, '=') !== false)
			$category = '';
		$arrResult['category'] = urldecode($category);

		$size = intVal($this->sunitz($size));
		$arrResult['size'] = urldecode($size);

		$brand = $this->sunitz($brand);
		if (strpos($brand, ';') !== false || strpos($brand, '=') !== false)
			$brand = '';
		$arrResult['brand'] = urldecode($brand);

		$color = $this->sunitz($color);
		if (strpos($color, ';') !== false || strpos($color, '=') !== false)
			$color = '';
		$arrResult['color'] = urldecode($color);

//		$category = $this->sunitz($category);
//		$arrResult['category'] = urldecode($category);

		$subcategory = $this->sunitz($subcategory);
		if (strpos($subcategory, ';') !== false || strpos($subcategory, '=') !== false)
			$subcategory = '';
		$arrResult['subcategory'] = urldecode($subcategory);

		$shopn = $this->sunitz($shopn);
		if (strpos($shopn, ';') !== false || strpos($shopn, '=') !== false)
			$shopn = '';
		$arrResult['shopn'] = urldecode($shopn);

		$shop = $this->sunitz($shop);
		if (strpos($shop, ';') !== false || strpos($shop, '=') !== false)
			$shop = '';
		$arrResult['shop'] = urldecode($shop);

		$sale = $this->sunitz($sale);
		$arrResult['sale'] = urldecode($sale);

		if ($sale_pre != $sale)
		{
			$page = 1;
			$arrResult['page'] = 1;
		}

		if( $shop_url != "") {
			// ショップアカウントのユーザーIDを取得
			$arrShopUserId = array();
			$arrShopUser = get_shop_user_list( $shop_url, 1);
			foreach ( $arrShopUser['arrUsers'] as $user ) {
				$arrShopUserId[] = $user['ID'];
			}
			$user_id = implode(",", $arrShopUserId);

			// FEATURE, STYLE SNAP, EDITORS CHOICE, BLOG の記事件数を取得
			$arrResult['article_num'] = get_article_num($user_id);
		}
$end = microtime(true);
$sec = (float)((float)$end - (float)$start);
$this->debug('SET BRAND START 処理時間 = ' . $sec . ' 秒 '.session_id());

		//$arrResult['filter'] = $brand_code;
		$arrResult['page'] = $page;
		$arrResult['shop_url'] = $this->shop_url;
		$arrResult['shop_name'] = $this->shop_name;

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

		try
		{
			$cache = hash('sha256', 'ft'.$arrResult['filters'].'u'.@$user_id.'p'.$page.'v'.$view.'o'.$order.'b'.$brand_code.'s'.$shop_url.'sf'.$arrResult['sale_flg'].'vsf'.$arrResult['vip_sale_flg']);
//			var_dump($cache);

			if ($reload == 0)
				return Cache::get('brand'.$cache);
		}
		catch(\CacheNotFoundException $e)
		{
			Cache::delete('brand'.$cache);
		}

//var_dump($cache);
		if( $brand_code != "" ) {

			$brands = explode(':::', $brand_code);
//var_dump($brand_code);
//var_dump($brands);


			// 詳細
			//mb_ereg_replace("\\\\","",$brands[1]);
//			$data = get_br_brand_name(mb_ereg_replace("", "",$brands[1]), $preview);
//var_dump($brand_code);
//exit;
//var_dump($brands);
//			$branda = explode(',', stripslashes($brands[1]));
			$branda[0] = stripslashes($brands[1]);
//			$branda[0] = htmlspecialchars(mb_ereg_replace('-and-', '&', $branda[0]));
			$branda[0] = mb_ereg_replace('-and-', '&', $branda[0]);
 			$brands[1] = urldecode($branda[0]);
//var_dump($branda);
//exit;

			$brands[1] = mb_ereg_replace('^C $', 'C+', $brands[1]);
			$brands[1] = mb_ereg_replace('FIORENTINI BAKER', 'FIORENTINI+BAKER', $brands[1]);
			//$brands[1] = mb_ereg_replace('…', '', $brands[1]);

 			$branda = htmlspecialchars($brands[1]);
//var_dump($branda);
 			$branda = htmlspecialchars_decode($brands[1]);
//var_dump($branda);
//exit;
//			if ($brands[0] == '276')
//var_dump($branda);
/*
			$redis = Redis_Db::forge();
			
			$cahce = 'ba'.$branda.'p'.$preview;
			$time = date('YmdHis');
			$dest_time = @$redis->get('brandA_time'.$cahce);
			$c = 0;
			if (($time - $dest_time) <= 30)
			{
				$arrRet = @unserialize($redis->get('brandA'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				$arrRet = get_br_brand_name($branda, $preview);
				
				$redis->set('brandA'.$cahce, serialize($arrRet));
				$redis->set('brandA_time'.$cahce, date('YmdHis'));
			}
			$data = $arrRet;
*/
			$data = get_br_brand_name($branda, $preview);
//var_dump($data);

//			$data = get_br_brand_name($brands[1], $preview);
//$branda = mb_ereg_replace("\\\\","",$brands[1]);
//var_dump($data);
//exit;
//var_dump(htmlspecialchars_decode($brands[1], ENT_QUOTES));
			if( $data == false ) {
				return $this->action_404();
			}

			$arrResult['post'] = $data;
			$arrResult['brand_detail'] = 1;

			$orderby = 'update_date desc';
			if ($order == 'update_date')
				$orderby = 'update_date desc';
			else if ($order == 'price_asc')
				$orderby = 'price01 asc';
			else if ($order == 'price_desc')
				$orderby = 'price01 desc';

			$where = " name in ('".mb_ereg_replace("'", "\\'", $brands[1])."') ";
//			$where = " name in ('".$brands[1]."')";
//exit;
//			$where = htmlspecialchars(mb_ereg_replace('&', '&', $where));
//var_dump($brands);			
//var_dump(htmlspecialchars($where));
//$where2 = " name in ('PAUL&SHARK') ";
//var_dump($where2);
//			$arrRet2 = Tag_Item::get_brand_like2('PAUL&SHARK');
/*
			$redis = Redis_Db::forge();
			
			$cahce = 'ba'.$branda.'p'.$preview.'w'.serialize($where);
			$time = date('YmdHis');
			$dest_time = @$redis->get('brandA2_time'.$cahce);
			$c = 0;
			if (($time - $dest_time) <= 30)
			{
				$arrRet = @unserialize($redis->get('brandA2'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				$arrRet = Tag_Item::get_brand_like($where);
				
				$redis->set('brandA2'.$cahce, serialize($arrRet));
				$redis->set('brandA2_time'.$cahce, date('YmdHis'));
			}
*/
			$arrRet = Tag_Item::get_brand_like($where);
//var_dump(DB::last_query());			
//var_dump($arrRet2);			
$end = microtime(true);
$sec = (float)((float)$end - (float)$start);
$this->debug('SET BRAND 2 処理時間 = ' . $sec . ' 秒 '.session_id());
			$where = "";
			foreach($arrRet as $ret)
			{
				if ($where != '')
					$where .= " or ";
				$n = mb_ereg_replace("'", "\\'", $ret['name']);
				$where .= " (I.name = '{$n}' and I.code = '{$ret['code']}') ";
			}
//var_dump($where);
			if ($where != '')
				$where = "(".$where.")";
//			$where = " I.code = '{$brand_code}' ";

			//カテゴリ関連
			if ($category != '' && $subcategory == '')
			{
				$category_id = Tag_Item::get_category_id($category);
				$where .= " AND (H.category_id = '{$category_id}' OR H.parent_category_id = '{$category_id}') ";
			}
			else if ($subcategory != '')
			{
				$category_id = Tag_Item::get_category_id($subcategory);
				$where .= " AND (H.category_id = '{$category_id}' OR H.parent_category_id = '{$category_id}') ";
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
//var_dump($where);
//exit;
//var_dump(DB::last_query());			
//exit;
//			$items = Tag_Item::get_items($where, $orderby, $page, $view);
/*
			$redis = Redis_Db::forge();
			
			$cahce = 'p'.$page.'v'.$view.'o'.$orderby.'w'.serialize($where);
			$time = date('YmdHis');
			$dest_time = @$redis->get('brand_time'.$cahce);
			$c = 0;
			if (($time - $dest_time) <= 30)
			{
				$arrRet = @unserialize($redis->get('brand'.$cahce));
				$c = @unserialize($redis->get('brandmax'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				$arrRet = Tag_Item::get_items2($c, $where, $orderby, $page, $view);
				
				$redis->set('brand'.$cahce, serialize($arrRet));
				$redis->set('brandmax'.$cahce, serialize($c));
				$redis->set('brand_time'.$cahce, date('YmdHis'));
			}
			$arrResult['items'] = $arrRet;
*/
			$arrResult['items'] = Tag_Item::get_items2($c, $where, $orderby, $page, $view);

			$max_p = ceil($c/$view);
			$arrResult['max'] = $max_p;//ceil(Tag_Item::get_item_count($where, $orderby)/$view);
			$arrResult['url'] = 'brand?filter='.$brand_code.'&';
//var_dump($arrResult['page']);
//print("<pre>".$c."</pre>");
//var_dump($max_p);
//Tag_Item::get_items($where, $orderby, $page, $view);
//var_dump(Tag_Item::get_item_count($where, $orderby));

			$pc = 5;
			if ($page - $pc <= 0)
				$arrResult['pstart'] = 1;
			else
				$arrResult['pstart'] = $page - $pc;
			if ($page + $pc >=  $arrResult['max'])
				$arrResult['pend'] = $arrResult['max'];
			else
				$arrResult['pend'] = $page + $pc;

			if( $shop_url != "" ) {
				$tpl = 'smarty/mall/brshop/brand/detail.tpl';
			} else {
				$tpl = 'smarty/brand/detail.tpl';
			}
$end = microtime(true);
$sec = (float)((float)$end - (float)$start);
$this->debug('SET BRAND 3END 処理時間 = ' . $sec . ' 秒 '.session_id());

		} else {
			$arrResult['url'] = '';
			$keys = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'NUMERIC');
			// 一覧
			if( $shop_url != "" ) {
				foreach($keys as $k)
				{
/*
					$redis = Redis_Db::forge();
					
					$cahce = 'k'.$k.'s'.$shop_url;
					$time = date('YmdHis');
					$dest_time = @$redis->get('brandkey_time'.$cahce);
					$c = 0;
					if (($time - $dest_time) <= 30)
					{
						$arrRet = @unserialize($redis->get('brandkey'.$cahce));
					}
					else
						$arrRet = '';
		
					if ($arrRet == '')
					{
						$arrRet = Tag_Item::get_brandlist($k, $shop_url);
						
						$redis->set('brandkey'.$cahce, serialize($arrRet));
						$redis->set('brandkey_time'.$cahce, date('YmdHis'));
					}
					$arrTemp[$k] = $arrRet;
*/
					$arrTemp[$k] = Tag_Item::get_brandlist($k, $shop_url);
				}
				$tpl = 'smarty/mall/brshop/brand/index.tpl';

			} else {
				foreach($keys as $k)
				{
/*
					$redis = Redis_Db::forge();
					
					$cahce = 'k'.$k;
					$time = date('YmdHis');
					$dest_time = @$redis->get('brandkey2_time'.$cahce);
					$c = 0;
					if (($time - $dest_time) <= 30)
					{
						$arrRet = @unserialize($redis->get('brandkey2'.$cahce));
					}
					else
						$arrRet = '';
		
					if ($arrRet == '')
					{
						$arrRet = Tag_Item::get_brandlist($k);
						
						$redis->set('brandkey2'.$cahce, serialize($arrRet));
						$redis->set('brandkey2_time'.$cahce, date('YmdHis'));
					}
					$arrTemp[$k] = $arrRet;
*/
					$arrTemp[$k] = Tag_Item::get_brandlist($k);
				}
				$tpl = 'smarty/brand/index.tpl';
			}
			$arrB = array();
			foreach($keys as $k)
			{
				$arrB[$k] = array();
				foreach($arrTemp[$k] as $temp)
				{
					$sql = "select count(*) as cnt from dtb_products as A join dtb_brand as B on B.id = A.brand_id where B.name_kana = '".$temp['name_kana']."' and A.del_flg = 0";
	
					$query = DB::query($sql)->execute()->as_array();
					if ($query[0]['cnt'] != 0)
						$arrB[$k][] = $temp;
				}
			}
/*
			$redis = Redis_Db::forge();
			
			$cahce = '';
			$time = date('YmdHis');
			$dest_time = @$redis->get('brandB_time'.$cahce);
			$c = 0;
			if (($time - $dest_time) <= 30)
			{
				$arrRet = @unserialize($redis->get('brandB'.$cahce));
			}
			else
				$arrRet = '';

			if ($arrRet == '')
			{
				$arrB = array();
				foreach($keys as $k)
				{
					$arrB[$k] = array();
					foreach($arrTemp[$k] as $temp)
					{
						$sql = "select count(*) as cnt from dtb_products as A join dtb_brand as B on B.id = A.brand_id where B.name_kana = '".$temp['name_kana']."' and A.del_flg = 0";
		
						$query = DB::query($sql)->execute()->as_array();
						if ($query[0]['cnt'] != 0)
							$arrB[$k][] = $temp;
					}
				}
				$arrRet = $arrB;
				
				$redis->set('brandB'.$cahce, serialize($arrRet));
				$redis->set('brandB_time'.$cahce, date('YmdHis'));
			}
			$arrResult['arrBrandList'] = $arrRet;
*/
$end = microtime(true);
$sec = (float)((float)$end - (float)$start);
$this->debug('SET BRAND 4END 処理時間 = ' . $sec . ' 秒 '.session_id());
//var_dump(session_id());			
			$arrResult['arrBrandList'] = $arrTemp;
			$arrResult['arrBrandList'] = $arrB;
		//Profiler::console($arrTemp);
		}

		//$arrResult['attention'] = get_attention();	// ATTENTIONの取得
		//$arrResult['arrPickup'] = get_pickup();		// PICK UPの取得
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


		Cache::set('brand'.$cache,View_Smarty::forge( $tpl, $arrResult, false ),86400);

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
		//return Response::forge(Presenter::forge('home/404'), 404);
        return View_Smarty::forge('smarty/misc/404.tpl');
		//		return Response::forge(Presenter::forge('home/404'), 404);
	}
	public function debug($str)
	{	
		$fp = fopen("/var/www/bronline/fuel/app/logs/brand".date('Ymd').".log", "a");
		if ($fp)
		{
			fputs($fp, date("Y-m-d H:i:s").":");
			fputs($fp, print_r($str, true));
			fputs($fp, PHP_EOL);
			fclose($fp);
		}
		
		return;
	}
}

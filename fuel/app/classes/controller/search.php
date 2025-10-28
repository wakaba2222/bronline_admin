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
class Controller_Search extends ControllerPage
{
	/**
	 * SEARCH
	 *
	 * @return unknown
	 */
	public function sunitz($check)
	{
		$check = str_replace('\\', "", $check);
		$check = str_replace("'", '"', $check);
		
		return $check;			
	}
	public function action_index()
	{
		$debug = array();
		$arrResult = array();

		$article		= Input::param('article', '');			// タグ
		$word_article	= Input::param('word_article', '');
		$item			= Input::param('item', '');				// タグ
		$word_item		= Input::param('word_item', '');
		$page			= Input::param('page', 1);
		$arrResult['article'] = urldecode($article);
		$arrResult['word_article'] = urldecode($word_article);
		$arrResult['item'] = urldecode($item);
		$arrResult['word_item'] = urldecode($word_item);
		$arrResult['page'] = $page;

		if( $article != "" || $word_article != "" ) {
			// 記事検索
			$tpl = 'smarty/search/article.tpl';
//			var_dump($article);
			$target_article = mb_ereg_replace('C ', 'C+', $article);
			$target_article = str_replace(' ', '　', $target_article);
			$target_word_article = str_replace(' ', '　', $word_article);
			$this->setKeyword($target_word_article, 1);
// var_dump($target_article);
// var_dump($target_word_article);
			//$target_word_article = $target_article;
			$arrResult['arrData'] = get_search_article( $page, $target_article, $target_word_article);

			if( $article != "" ) {
				$arrResult['title'] = $target_article;
			} else if( $word_article != "" ) {
				$arrResult['title'] = $word_article;
			} else {
				$arrResult['title'] ="";
			}

		} else if( $item != "" || $word_item != "" ) {
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
		$cat		= Input::param('cat', '');	// 並び替え
		$sale		= Input::param('sale_status', 0);	//セール対象
		$sale_pre		= Input::param('sale_status_pre', 0);	//セール対象

		if ($sale_pre != $sale)
		{
			$page = 1;
//			$page2 = 1;
			$arrResult['page'] = 1;
//			$arrResult['page2'] = 1;
		}

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

//		$arrResult['view'] = urldecode($view);
//		$arrResult['page'] = urldecode($page);
//		$arrResult['order'] = urldecode($order);
//		$arrResult['filter'] = urldecode($filter);
//		$arrResult['category'] = urldecode($category);
//		$arrResult['size'] = urldecode($size);
//		$arrResult['brand'] = urldecode($brand);
//		$arrResult['color'] = urldecode($color);
//		$arrResult['category'] = urldecode($category);
//		$arrResult['subcategory'] = urldecode($subcategory);
//		$arrResult['shopn'] = urldecode($shopn);
//		$arrResult['shop'] = urldecode($shop);

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
//var_dump($vip_start_date);
//var_dump($vip_end_date);
//var_dump($now);
//var_dump($arrResult['vip_sale_flg']);
//var_dump($arrResult['sale_par']);

		$word_item = $this->sunitz($word_item);
		$arrResult['word_item'] = urldecode($word_item);
		if ($item != '')
		{
			$item = $this->sunitz($item);
			$arrResult['word_item'] = urldecode($item);
		}

		$this->setKeyword($word_item, 2);

			$orderby = 'update_date desc';
			if ($order == 'update_date')
				$orderby = 'update_date desc';
			else if ($order == 'price_asc')
				$orderby = 'price01 asc';
			else if ($order == 'price_desc')
				$orderby = 'price01 desc';

			$where = '';

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
				$category_id = Tag_Item::get_category_id($subcategory);
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
//var_dump($category);
//var_dump($category_id);
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

			// 商品検索
			$tpl = 'smarty/search/item.tpl';
			if ($item != "")
			{
				$arrResult['url'] = 'search?item='.$item.'&';
				$where = "";
				if ($shopn != '')
				{
					$shopn = trim($shopn);
					$ss = explode(',',$shopn);
					foreach($ss as $s)
					{
						if ($where != '')
							$where .= ',';
						$where .= "'".$s."'";
					}
					$where = " C.login_id in ({$where}) ";
				}
				$arrResult['max'] = ceil(Tag_Item::search(array($item), $orderby, $page, $view, true)/$view);
				$arrResult['items'] = Tag_Item::search(array($item), $orderby, $page, $view);
			}
			else
			{
				$arrResult['url'] = 'search?word_item='.$word_item.'&';
				$word_item = mb_ereg_replace('　', ' ', $word_item);
//				$word_item = urlencode($word_item);
//				$word_item = mb_ereg_replace('C+', 'C ', $word_item);
				$word_item = trim($word_item);
				$words = explode(' ',  $word_item);
//				$where2 = "";
//				if ($shopn != '')
//				{
//					$shopn = trim($shopn);
//					$ss = explode(',',$shopn);
//					foreach($ss as $s)
//					{
//						if ($where2 != '')
//							$where2 .= ',';
//						$where2 .= "'".$s."'";
//					}
//					$where2 = " C.login_id in ({$where}) ";
//				}
//				if ($where != '' && $where2 != '')
//					$where .= ' AND '.$where2;
//				else if ($where2 != '')
//					$where = $where2;
//var_dump($where);
				$arrResult['max'] = ceil(Tag_Item::search($words, $orderby, $page, $view, true,$where)/$view);
				$arrResult['items'] = Tag_Item::search($words, $orderby, $page, $view, false,$where);
			}

			$pc = 5;
			if ($page - $pc <= 0)
				$arrResult['pstart'] = 1;
			else
				$arrResult['pstart'] = $page - $pc;
			if ($page + $pc >=  $arrResult['max'])
				$arrResult['pend'] = $arrResult['max'];
			else
				$arrResult['pend'] = $page + $pc;

			if( $item != "" ) {
				$arrResult['title'] = $item;
			} else if( $word_item != "" ) {
				$arrResult['title'] = $word_item;
			} else {
				$arrResult['title'] ="";
			}
		} else {
			// 検索画面
			$tpl = 'smarty/search/index.tpl';
			$arrResult['arrKiji'] = Tag_Item::get_pickup('1');
			$arrResult['arrItemw'] = Tag_Item::get_pickup('2');
//			Profiler::console($arrResult['arrKiji']);

			$arrResult['arrKijiTag'] = DB::select()->from('dtb_pickup_keyword')->where('kind', 1)->order_by('count', 'desc')->limit(10)->execute()->as_array();
			$arrResult['arrItemwTag'] = DB::select()->from('dtb_pickup_keyword')->where('kind', 2)->order_by('count', 'desc')->limit(10)->execute()->as_array();

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
		$arrResult['listpage'] = 0;

		return View_Smarty::forge( $tpl, $arrResult, false );
	}


	public function setKeyword($word, $type)
	{
		if ($word == '')
			return;
		$arrItem = array();
		$arrItem['keyword'] = $word;
		$arrItem['access'] = $type;
		DB::insert("dtb_suggest")->set($arrItem)->execute();
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

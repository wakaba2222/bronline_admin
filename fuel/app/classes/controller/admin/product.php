<?php
use Fuel\Core\Response;

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
class Controller_Admin_Product extends ControllerAdmin
{
	/**
	 * PRODUCT一覧 取得
	 *
	 * @return unknown
	 */
	public function action_index()
	{
//		var_dump(Input::param());
		//ダミー
// 		Tag_Session::setShop('brshop');
// 		Tag_Session::setShopType('1');
		Tag_Session::delete('BACK_DATA');
		Tag_Session::delete('mode');
// 		foreach($_SESSION as $k=>$v)
// 		{
// 			if (strpos($k, 'search_') !== false)
// 			{
// 				Tag_Session::delete($k);
// 			}
// 		}

		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$arrResult['entry'] = $post_id;
		$this->tpl = 'smarty/admin/product/index.tpl';

// 		$view = View::forge('layout');
//		$this->view->header = View_Smarty::forge( $tpl, $arrResult, false );

		if (Input::method() == "GET")
		{
			$post = Tag_Session::get('search_product');

			if ($post == null)
			{
				$post = Input::param();
				Tag_Session::set('search_product', $post);
			}
		}
		else
		{
			$post = Input::param();
			Tag_Session::set('search_product', $post);
		}

		$page = Input::param('page','1');
		
		Tag_Session::set('PAGE', $page);
//var_dump($url);


//		var_dump($post);

		$shop_id = Tag_Session::get('shop_id');
		$shop = Tag_Session::getShop();
// 		var_dump($shop_id);
// 		var_dump($shop);
		$where = '';
		if ($shop_id != '')
			$where = "shop_id = {$shop_id}";
		$order = " create_date DESC ";


		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (strpos($post['search_product_id'], '~') > 0)
						{
							$ids = explode('~', $post['search_product_id']);
							if(is_array($ids) && count($ids) == 2)
							{
								if ($where != "")
									$where .= " AND ";
								$where .= " (A.product_id >= ".$ids[0]." and "." A.product_id <= ".$ids[1].") ";
								$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '30');
							}
							else
								break;
							
						}
						else if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						else
						{
							if ($where != "")
								$where .= " AND ";
							$where .= " A.product_id = ".$post['search_product_id'];
							$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '30');
						}
					}
					break;
				}
				case 'search_product_code':
				{
					if ($post['search_product_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " D.product_code like '%".$post['search_product_code']."%' ";
						$this->setFormParams('arrForm', 'search_product_code', $post['search_product_code'], '20');
					}
					break;
				}
				case 'search_product_statuses':
				{
					if (count($post['search_product_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_product_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_product_statuses', $post['search_product_statuses'], '');
					break;
				}
				case 'search_sale_statuses':
				{
					if (!isset($post['search_sale_statuses']))
						$post['search_sale_statuses'] = array();
					if (count($post['search_sale_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_sale_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " A.product_id in (select product_id from dtb_products where ";
						else
							$where .= " OR ";
						$where .= " A.sale_status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_sale_statuses', $post['search_sale_statuses'], '');
					break;
				}
				case 'search_reservation':
				{
					if (!isset($post['search_reservation']))
						$post['search_reservation'] = array();
					if (count($post['search_reservation']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_reservation'] as $s)
					{
						if ($cnt == 0)
							$where .= " A.product_id in (select product_id from dtb_products where ";
						else
							$where .= " OR ";
						$where .= " dtb_products.reservation_flg = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_reservation', $post['search_reservation'], '');
					break;
				}
				case 'search_payoff':
				{
					if (!isset($post['search_payoff']))
						$post['search_payoff'] = array();
					if (count($post['search_payoff']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_payoff'] as $s)
					{
						if ($cnt == 0)
							$where .= " A.product_id in (select product_id from dtb_products where ";
						else
							$where .= " OR ";
						$where .= " dtb_products.pay_off = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";
					$this->setFormParams('arrForm', 'search_payoff', $post['search_payoff'], '');
					break;
				}
				case 'search_name':
				{
					if ($post['search_name'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.name like '%".$post['search_name']."%' ";
						$this->setFormParams('arrForm', 'search_name', $post['search_name'], '50');
					}
					break;
				}
				case 'search_group_code':
				{
					if ($post['search_group_code'] != '')
					{
// 						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
// 						{
// 							break;
// 						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '%".$post['search_group_code']."%' ";
						$this->setFormParams('arrForm', 'search_group_code', $post['search_group_code'], '15');
					}
					break;
				}
				case 'search_category_id':
				{
					if ($post['search_category_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_category_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.category_id = '".$post['search_category_id']."' ";
						$this->setFormParams('arrForm', 'search_category_id', $post['search_category_id'], '');
					}
					break;
				}
				case 'search_smaregi_product_id':
				{
					if ($where != "")
						$where .= " AND ";
					$where .= " A.product_id = ".$post['search_smaregi_product_id'];
					$this->setFormParams('arrForm', 'search_smaregi_product_id', $post['search_smaregi_product_id'], '10');
					break;
				}
				case 'search_stock':
				{
					if ($post['search_stock'] != 0)
					{
						if ($where != "")
							$where .= " AND ";
						if ($post['search_stock'] == '1')
							$where .= " D.stock <> 0 ";
						else
							$where .= " D.stock = 0 ";

						$this->setFormParams('arrForm', 'search_stock', $post['search_stock'], '');
						break;
					}
				}
			}
		}

		$arrData = Tag_Item::get_allitems($where, 'update_date DESC, group_code', $page, 25);
//var_dump(DB::last_query());
		$this->setData($arrData);

		$arrRet = DB::query("SELECT FOUND_ROWS()")->execute();
		$count = $arrRet[0]['FOUND_ROWS()'];
//		$count = count(Tag_Item::get_allitems($where, 'update_date DESC', 1, 0));
//		var_dump(Tag_Item::get_allitems($where, 'update_date DESC', 1, 0));
		$this->arrResult['max'] = ceil($count / 25);
		$this->arrResult['count'] = $count;
		$this->arrResult['page'] = $page;

			$pc = 5;
			if ($page - $pc <= 0)
				$this->arrResult['pstart'] = 1;
			else
				$this->arrResult['pstart'] = $page - $pc;
			if ($page + $pc > $this->arrResult['max'])
				$this->arrResult['pend'] = $this->arrResult['max'];
			else
				$this->arrResult['pend'] = $page + $pc;

		Log::debug(DB::last_query());

		return $this->view;
	}

	public function action_category()
	{
		$post = Input::param();

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		$mode = Input::post('mode', '');
		if( $mode == 'edit' )
		{


//print("<pre>");
		try {
			foreach($post['parent_category']['category_id'] as $k=>$category)
			{
				DB::start_transaction();
				$query = DB::update('dtb_category');
				
				$update = array();
				$name = $post['parent_category']['name'][$k];
				$view_flg = $post['parent_category']['view_flg'][$k];
				$sort_no = $post['parent_category']['sort_no'][$k];
				$parent_category_id = $post['parent_category']['parent_category_id'][$k];
				$another_name = $post['parent_category']['another_name'][$k];

				$update['name'] = $name;
				$update['view_flg'] = $view_flg;
				$update['sort_no'] = $sort_no;
				$update['parent_category_id'] = $parent_category_id;
				$update['another_name'] = $another_name;
			
				$query->where('category_id',$category)->set($update)->execute();
				DB::commit_transaction();
				$query->reset();
			//var_dump($k.':'.$name);
			}
		} catch ( Exception $e ) {
			DB::rollback_transaction();
			$this->arrResult["arrMsg"][] = '更新に失敗しました。';
		}

		try {
			foreach($post['category']['category_id'] as $k=>$category)
			{
				DB::start_transaction();
				$query = DB::update('dtb_category');
				
				$update = array();
				$name = $post['category']['name'][$k];
				$view_flg = $post['category']['view_flg'][$k];
				$sort_no = $post['category']['sort_no'][$k];
				$parent_category_id = $post['category']['parent_category_id'][$k];
				$another_name = $post['category']['another_name'][$k];

				$update['name'] = $name;
				$update['view_flg'] = $view_flg;
				$update['sort_no'] = $sort_no;
				$update['parent_category_id'] = $parent_category_id;
				$update['another_name'] = $another_name;
			
				$query->where('category_id',$category)->set($update)->execute();
				DB::commit_transaction();
				$query->reset();
			}
		} catch ( Exception $e ) {
			DB::rollback_transaction();
			$this->arrResult["arrMsg"][] = '更新に失敗しました。';
		}
//print("</pre>");
//exit;
//name
//view_flg
//sort_no
//another_name
//parent_category_id
//category_id
/*
			try {
				DB::start_transaction();

				// テーブル削除
				DBUtil::truncate_table('dtb_brand_list');

				// 記事タグinsert
				$arrTagName = Input::post('article_tag_name');
				$arrTagRank = Input::post('article_rank_name');
				$arrVisible = Input::post('article_visible_name');
				foreach ( $arrTagName as $idx => $name )
				{
					if($name != "") {
						$insert = array();
//						$insert['keyword']	= stripslashes(htmlspecialchars($name));
						$insert['keyword']	= stripslashes($name);
						$insert['rank']		= $arrTagRank[$idx];
						$insert['visible'] = $arrVisible[$idx];
						DB::insert('dtb_brand_list')->set($insert)->execute();
					}
				}

				// アイテムタグinsert
				DB::commit_transaction();

			} catch ( Exception $e ) {
				DB::rollback_transaction();
				$this->arrResult["arrMsg"][] = '更新に失敗しました。';
			}
*/
		}
		$where = "parent_category_id <> 0 and del_flg = 0";
		$arrTemp = Tag_Item::get_categories($where);
		$arrCategory = array();
		$arrParent = array();

		$where = "parent_category_id = 0 and del_flg = 0";
		$arrTemp2 = Tag_Item::get_categories($where);
		foreach($arrTemp2 as $ret)
		{
			$arrParent[$ret['category_id']]['parent_category_id']= $ret['parent_category_id'];
			$arrParent[$ret['category_id']]['name']= $ret['name'];
			$arrParent[$ret['category_id']]['another_name']= $ret['another_name'];
			$arrParent[$ret['category_id']]['sort_no']= $ret['sort_no'];
			$arrParent[$ret['category_id']]['view_flg']= $ret['view_flg'];
			$arrParent[$ret['category_id']]['category']= array();
		}
		foreach($arrTemp as $ret)
		{
			$t = array();
			$t['parent_category_id']= $ret['parent_category_id'];
			$t['category_id']= $ret['category_id'];
			$t['name']= $ret['name'];
			$t['another_name']= $ret['another_name'];
			$t['sort_no']= $ret['sort_no'];
			$t['view_flg']= $ret['view_flg'];

			$arrParent[$ret['parent_category_id']]['category'][] = $t;
		}
//print("<pre>");
//var_dump($arrParent);
//print("</pre>");
//exit;

		$this->arrResult['arrParent'] = $arrParent;


//		$where = "";
//		$arrCategory = Tag_Item::get_categories($where);
		$this->arrResult['arrCategory'] = $arrTemp;
//		$this->arrResult["arrArticleTag"]	= DB::select()->from('dtb_brand_list')->order_by('rank', 'asc')->execute()->as_array();

		$this->arrResult["arrError"] = array();
		$this->arrResult["arrMsg"] = array();

		$this->tpl = 'smarty/admin/product/category.tpl';
		return $this->view;
	}

	public function action_brand()
	{
		$tbl_name = "dtb_brand";
		$id = Input::param('id', '');

//var_dump(Input::method());
		if (Input::method() == 'POST')
		{
			$post = Input::param();
//var_dump($post);
			if ($post['mode'] == 'confirm')
			{
				$arrPost = array();
				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
				$arrPost['name_kana'] = $post['name_kana'];
				$arrPost['id'] = $post['id'];
				$arrPost['rank'] = 1;
				$arrPost['shop_url'] = Tag_Session::getShop();
				if ($arrPost['code'] == '')
					$arrPost['code'] = Tag_Item::get_uniqcode();
				if ($arrPost['id'] == '')
					unset($arrPost['id']);
				$arrPost['del_flg'] = '0';
				$id = '';
				Tag_Item::set_table($arrPost, $tbl_name);
			}
			else if ($post['mode'] == 'delete')
			{
				$arrPost = array();
				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
				$arrPost['id'] = $post['id'];
				$arrPost['rank'] = 1;
				$arrPost['del_flg'] = 1;
				$id = '';
				Tag_Item::set_table($arrPost, $tbl_name);
			}
			else if ($post['mode'] == 'pre_edit')
			{
				$arrPost = array();
				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
				$arrPost['name_kana'] = $post['name_kana'];
				$arrPost['id'] = $post['id'];
				$id = $post['id'];
				$arrPost['rank'] = 1;
				$arrPost['shop_url'] = Tag_Session::getShop();
			}
		}

		$arrTemp = Tag_Item::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
			$this->arrResult['arrForm'][$column['Field']] = '';
		}

		$where = "";
		if ($id != '')
		{
			$where = array("id"=>$id);
			$arrRet = Tag_Item::get_table($arrColumns, $tbl_name, $where);
			$this->arrResult['arrForm'] = $arrRet[0];
		}
		$arrRet = Tag_Item::get_table($arrColumns, $tbl_name, array('del_flg'=>0, 'shop_url'=>Tag_Session::getShop()));
//var_dump(DB::last_query());
		$this->arrResult['arrBrand'] = $arrRet;
		$this->arrResult['id'] = '';

//	var_dump($this->arrResult['arrBrand']);
		//exit;
		$this->tpl = 'smarty/admin/product/brand.tpl';
		return $this->view;
	}

	public function action_theme()
	{
		$tbl_name = "dtb_theme";
		$id = Input::param('id', '');

//var_dump(Input::method());
		if (Input::method() == 'POST')
		{
			$post = Input::param();
//var_dump($post);
			if ($post['mode'] == 'confirm')
			{
				$arrPost = array();
//				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
//				$arrPost['name_kana'] = $post['name_kana'];
				$arrPost['id'] = $post['id'];
				$arrPost['rank'] = 1;
//				$arrPost['shop_url'] = Tag_Session::getShop();
// 				if ($arrPost['code'] == '')
// 					$arrPost['code'] = Tag_Item::get_uniqcode();
				if ($arrPost['id'] == '')
					unset($arrPost['id']);
				$arrPost['del_flg'] = '0';
				$id = '';
				Tag_Item::set_table($arrPost, $tbl_name);
				del_br_theme($post['id']);
				add_br_theme($post['name'], $post['id']);
			}
			else if ($post['mode'] == 'delete')
			{
				$arrPost = array();
//				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
				$arrPost['id'] = $post['id'];
				$arrPost['rank'] = 1;
				$arrPost['del_flg'] = 1;
				$id = '';
				Tag_Item::set_table($arrPost, $tbl_name);
				del_br_theme($post['id']);
			}
			else if ($post['mode'] == 'pre_edit')
			{
				$arrPost = array();
//				$arrPost['code'] = $post['code'];
				$arrPost['name'] = $post['name'];
//				$arrPost['name_kana'] = $post['name_kana'];
				$arrPost['id'] = $post['id'];
				$id = $post['id'];
				$arrPost['rank'] = 1;
//				$arrPost['shop_url'] = Tag_Session::getShop();
			}
		}

		$arrTemp = Tag_Item::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
			$this->arrResult['arrForm'][$column['Field']] = '';
		}

		$where = "";
		if ($id != '')
		{
			$where = array("id"=>$id);
			$arrRet = Tag_Item::get_table($arrColumns, $tbl_name, $where);
			$this->arrResult['arrForm'] = $arrRet[0];
		}
		$arrRet = Tag_Item::get_table($arrColumns, $tbl_name, array('del_flg'=>0));
//var_dump(DB::last_query());
		$this->arrResult['arrTheme'] = $arrRet;
		$this->arrResult['id'] = '';

//	var_dump($this->arrResult['arrBrand']);
		//exit;
		$this->tpl = 'smarty/admin/product/theme.tpl';
		return $this->view;
	}

	public function before()
	{
		parent::before();

		$arrTemp = Tag_Master::get_master('mtb_status');
		$arrSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrSTATUS'] = $arrSTATUS;

		$arrSALESTATUS = array();
		$arrSALESTATUS[0] = "通常商品";
		$arrSALESTATUS[1] = "セール商品";
//		$arrSALESTATUS[2] = "VIPシークレット商品";
		$this->arrResult['arrSALESTATUS'] = $arrSALESTATUS;


		$arrPayOff = array();
		$arrPayOff[0] = "通常商品";
		$arrPayOff[1] = "お直し商品";
		$this->arrResult['arrPayOff'] = $arrPayOff;
		$arrResevation = array();
		$arrResevation[0] = "通常商品";
		$arrResevation[1] = "完全受注生産";
		$arrResevation[2] = "予約商品";
		$this->arrResult['arrResevation'] = $arrResevation;

		$arrTemp = Tag_Master::get_master('mtb_status_color');
		$arrPRODUCTSTATUS_COLOR = array();
		foreach($arrTemp as $t)
		{
			$arrPRODUCTSTATUS_COLOR[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPRODUCTSTATUS_COLOR'] = $arrPRODUCTSTATUS_COLOR;

		$this->arrResult['arrStartYear'] = Tag_Master::get_year();
		$this->arrResult['arrStartMonth'] = Tag_Master::get_month();
		$this->arrResult['arrStartDay'] = Tag_Master::get_day();
		$this->arrResult['arrEndYear'] = Tag_Master::get_year();
		$this->arrResult['arrEndMonth'] = Tag_Master::get_month();
		$this->arrResult['arrEndDay'] = Tag_Master::get_day();

		$this->setFormParams('arrForm','search_startyear', '', '');
		$this->setFormParams('arrForm','search_startmonth', '', '');
		$this->setFormParams('arrForm','search_startday', '', '');
		$this->setFormParams('arrForm','search_endyear', '', '');
		$this->setFormParams('arrForm','search_endmonth', '', '');
		$this->setFormParams('arrForm','search_endday', '', '');
		$this->setFormParams('arrForm','search_group_view', '', '');
		$this->setFormParams('arrForm','search_product_id', '', '');
		$this->setFormParams('arrForm','search_smaregi_product_id', '', '');
		$this->setFormParams('arrForm','search_product_statuses', '', '');
		$this->setFormParams('arrForm','search_sale_statuses', '', '');
		$this->setFormParams('arrForm','search_category_id', '', '');
		$this->setFormParams('arrForm','search_product_code', '', '');
		$this->setFormParams('arrForm','search_name', '', '');
		$this->setFormParams('arrForm','search_group_code', '', '');
		$this->setFormParams('arrForm','search_stock', '', '');
		$this->setFormParams('arrForm','search_payoff', '', '');
		$this->setFormParams('arrForm','search_reservation', '', '');

		$this->setFormParams('arrErr','search_startyear', '', '');
		$this->setFormParams('arrErr','search_startmonth', '', '');
		$this->setFormParams('arrErr','search_startday', '', '');

//		$arrCatList = $this->setItemParam(Tag_Item::get_categories('parent_category_id <> 0'), 'category_id', 'name');
//		$this->arrResult['arrCatList'] = $arrCatList;
		$where = "parent_category_id <> 0 and view_flg = 0";
		$arrTemp = Tag_Item::get_categories($where);
		$arrCategory = array();
		$arrParent = array();

		$where = "parent_category_id = 0 and view_flg = 0";
		$arrTemp2 = Tag_Item::get_categories($where);
		foreach($arrTemp2 as $ret)
		{
			if ($ret['another_name'] != '')
				$arrParent[$ret['category_id']]['name']= $ret['another_name'];
			else
				$arrParent[$ret['category_id']]['name']= $ret['name'];
			$arrParent[$ret['category_id']]['category']= array();
		}
		foreach($arrTemp as $ret)
		{
			$t = array();
			if ($ret['another_name'] != '')
				$t[$ret['category_id']] = $ret['another_name'];
			else
				$t[$ret['category_id']] = $ret['name'];

			if ($ret['another_name'] != '')
				$arrCategory[$ret['category_id']] = $ret['another_name'];
			else
				$arrCategory[$ret['category_id']] = $ret['name'];
			$arrParent[$ret['parent_category_id']]['category'][] = $t;
		}
		$this->arrResult['arrParent'] = $arrParent;

//var_dump($_SESSION);
		//$sql="select id from dtb_shop where login_id = {$_SESSION['']}";
		$shop_id = 0;
		$stock_type = 0;
		if (isset($_SESSION['stock_type']))
			$stock_type = $_SESSION['stock_type'];
		if (isset($_SESSION['shop_id']))
			$shop_id = $_SESSION['shop_id'];

		$this->keys = array(
			'product_id'=>'商品ID',
			'category_id'=>'カテゴリID',
			'product_code'=>'商品コード',
			'status_flg'=>'NEWフラグ',
			'tag'=>'商品タグ',
			'name'=>'商品名(現状CSVと同じようにこちらにすべて入力でも問題ありません)',
			'name_en'=>'商品名（英語）',
			'name_kana'=>'商品名（カナ）',
			'price01'=>'販売金額',
			'price02'=>'会員価格（予備）',
			'info'=>'商品説明',
			'comment'=>'コメント（予備）',
			'status'=>'公開ステータス（1:非公開　2:公開　3:先行）',
			'del_flg'=>'削除フラグ（1で削除）',
			'create_date'=>'作成日時　未入力は自動',
			'view_date'=>'公開日時　statusが公開の場合に公開時間から表示されます',
			'close_date'=>'終了日時　日時を過ぎると非表示になります',
			'product_status_id'=>'編集不可項目',
			'group_code'=>'グループコード',
			'shop_id'=>$shop_id,
			'brand_id'=>'ブランドID',
			'theme_id'=>'テーマID',
			'point_rate'=>'ポイント付与率',
			'update_date'=>'更新日時',
			'season'=>'シーズン',
			'material'=>'素材',
			'size_text'=>'サイズ表',
			'remarks'=>'備考',
			'country'=>'原産国',
			'switch_property'=>'クロスモール のみ使用（0を指定）',
			'id'=>'編集不可項目',
			'size_code'=>'サイズコード',
			'size_name'=>'サイズ名',
			'color_code'=>'カラーコード',
			'color_name'=>'カラー名',
			'stock'=>'在庫',
			'dtb_products_product_id'=>'編集不可項目',
			'stock_type'=>$stock_type,
			'cost_price'=>'原価',
			'sale_status'=>'セール区分',
			'attribute'=>'規格（スマレジ項目）',
//			'reservation_flg'=>'予約商品フラグ',
//			'pay_off'=>'お直しフラグ',
		);

		if ($shop_id == '9' || $shop_id == '6' || $shop_id == '37')	//sugawaraltd,guji系,gente  || $shop_id == '7' || $shop_id == '21'
		{
			$this->keys['images'] = '登録画像一覧（カンマ区切り）';
		}

		$this->arrResult['csv_no'] = $this->keys;

		$this->keys2 = array(
			'product_id'=>'商品ID',
//			'group_code'=>'グループコード',
			'shop_id'=>$shop_id,
			'sale_status'=>'セール区分（0:通常 1:シークレット 2:VIPシークレット）',
		);

		$this->arrResult['csv_no2'] = $this->keys2;

		$this->keys3 = array(
//			'product_id'=>'商品ID',
			'group_code'=>'グループコード',
			'shop_id'=>$shop_id,
			'sale_status'=>'セール区分（0:通常 1:シークレット 2:VIPシークレット）',
		);

		$this->arrResult['csv_no3'] = $this->keys3;

		$this->keys4 = array(
			'product_id'=>'商品ID',
//			'group_code'=>'グループコード',
			'shop_id'=>$shop_id,
			'theme_id'=>'テーマID',
		);

		$this->arrResult['theme'] = $this->keys4;

//var_dump($_SESSION);
		$tbl_name = "dtb_brand";
		$arrRet = Tag_Item::get_brand(true);
		$arrBrand = array();
		foreach($arrRet as $ret)
		{
			if ($ret['shop_url'] == Tag_Session::get('shop'))
			{
				$arrBrand[] = $ret;
			}
		}
		$this->arrResult['arrBrand'] = $arrBrand;

		$arrRet2 = Tag_Item::get_categories("category_id >= 600 and category_id < 700");
		$this->arrResult['arrCategory'] = $arrRet2;

		$tbl_name = "dtb_theme";
		$arrTheme = Tag_Item::get_table(array('id', 'name'), $tbl_name, array('del_flg'=>0));
		$this->arrResult['arrTheme'] = $arrTheme;
		
//		var_dump(Tag_Campaign::get_uniqcode());

	}

	function action_nextdownload()
	{
		$shop_id = "";
		if( isset($_SESSION['shop_id'])) {
			$shop_id = $_SESSION['shop_id'];
		}
		$shop = Tag_Session::getShop();
		
		$keys = array("product_class_id", "product_code", "price01", "name");

		$cols = array();
		foreach ($keys as $k) {
			$cols[] = $k;
		}

		$csv_data = array();
		array_push($csv_data, $cols);

		$sql  = "select ";
		$sql .= " B.id ";
		$sql .= ",B.product_code ";
		$sql .= ",C.price01 ";
		$sql .= ",A.name ";

		$sql .= " from dtb_products as A ";
		$sql .= " join dtb_product_sku as B on A.product_id = B.dtb_products_product_id ";
		$sql .= " join dtb_product_price as C on A.product_id = C.dtb_products_product_id ";
		//$sql .= " join dtb_product_tag as E on A.product_id = E.dtb_products_product_id ";

		if( $shop_id != "") {
			$sql .= " where A.shop_id = ".$shop_id;
		}
		$sql .= " order by A.create_date ";
		$query = DB::query($sql);
		$arrData = $query->execute()->as_array();

		foreach ($arrData as $data) {
			foreach ( $data as &$col ) {
				$col = htmlspecialchars($col);
			}

			array_push($csv_data, $data);
		}

		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$shop.'_'.date('Ymd').'.csv"');
		echo Format::forge($csv_data)->to_csv();
		$this->response->send(true);

		return exit();
	}


	function action_download()
	{
		ini_set('memory_limit','2048M');
		$shop_id = "";
		if( isset($_SESSION['shop_id'])) {
			$shop_id = $_SESSION['shop_id'];
		}
		$shop = Tag_Session::getShop();

		$cols = array();
		foreach ($this->keys as $k => $v ) {
			$cols[] = $k;
		}

		$csv_data = array();
		array_push($csv_data, $cols);

		$sql  = "select ";
		$sql .= " A.product_id ";
		$sql .= ",A.category_id ";
		$sql .= ",B.product_code ";
		$sql .= ",D.status_flg ";
		$sql .= ",(select group_concat(tag) from dtb_product_tag where dtb_products_product_id = A.product_id ) as tag ";
		$sql .= ",A.name ";
		$sql .= ",A.name_en ";
		$sql .= ",A.name_kana ";
		$sql .= ",C.price01 ";
		$sql .= ",C.price02 ";
		$sql .= ",A.info ";
		$sql .= ",A.comment ";
		$sql .= ",A.status ";
		$sql .= ",A.del_flg ";
		$sql .= ",A.create_date ";
		$sql .= ",A.view_date ";
		$sql .= ",A.close_date ";
		$sql .= ",A.product_status_id ";
		$sql .= ",A.group_code ";
		$sql .= ",A.shop_id ";
		$sql .= ",A.brand_id ";
		$sql .= ",A.theme_id ";
		$sql .= ",A.point_rate ";
		$sql .= ",A.update_date ";
		$sql .= ",A.season ";
		$sql .= ",A.material ";
		$sql .= ",A.size_text ";
		$sql .= ",A.remarks ";
		$sql .= ",A.country ";
		$sql .= ",A.switch_property ";
		$sql .= ",B.id ";
		$sql .= ",B.size_code ";
		$sql .= ",B.size_name ";
		$sql .= ",B.color_code ";
		$sql .= ",B.color_name ";
		$sql .= ",B.stock ";
		$sql .= ",B.dtb_products_product_id ";
		$sql .= ",B.stock_type ";
		$sql .= ",C.cost_price ";
		$sql .= ",A.sale_status ";
		$sql .= ",B.attribute ";
//		$sql .= ",A.reservation_flg ";
//		$sql .= ",A.pay_off ";

		$sql .= " from dtb_products as A ";
		$sql .= " join dtb_product_sku as B on A.product_id = B.dtb_products_product_id ";
		$sql .= " join dtb_product_price as C on A.product_id = C.dtb_products_product_id ";
		$sql .= " left join dtb_product_status as D on A.product_id = D.product_id ";
		//$sql .= " join dtb_product_tag as E on A.product_id = E.dtb_products_product_id ";

		$where = " where A.del_flg = 0 ";

		$post = Tag_Session::get('search_product');
		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (strpos($post['search_product_id'], '~') > 0)
						{
							$ids = explode('~', $post['search_product_id']);
							if(is_array($ids) && count($ids) == 2)
							{
								if ($where != "")
									$where .= " AND ";
								$where .= " (A.product_id >= ".$ids[0]." and "." A.product_id <= ".$ids[1].") ";
							}
							else
								break;
							
						}
						else if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						else
						{
							if ($where != "")
								$where .= " AND ";
							$where .= " A.product_id = ".$post['search_product_id'];
						}
					}
					break;
				}
				case 'search_product_code':
				{
					if ($post['search_product_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " B.product_code like '%".$post['search_product_code']."%' ";
					}
					break;
				}
				case 'search_product_statuses':
				{
					if (count($post['search_product_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_product_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";
					break;
				}
				case 'search_name':
				{
					if ($post['search_name'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.name like '%".$post['search_name']."%' ";
					}
					break;
				}
				case 'search_group_code':
				{
					if ($post['search_group_code'] != '')
					{
// 						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
// 						{
// 							break;
// 						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '%".$post['search_group_code']."%' ";
					}
					break;
				}
				case 'search_category_id':
				{
					if ($post['search_category_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_category_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.category_id = '".$post['search_category_id']."' ";
					}
					break;
				}
				case 'search_stock':
				{
					if ($post['search_stock'] != 0)
					{
						if ($where != "")
							$where .= " AND ";
						if ($post['search_stock'] == '1')
							$where .= " B.stock <> 0 ";
						else
							$where .= " B.stock = 0 ";

						break;
					}
				}
				case 'search_reservation':
				{
					if (!isset($post['search_reservation']))
						$post['search_reservation'] = array();
					if (count($post['search_reservation']) && $where != "")
						$where .= " OR ";

					$cnt = 0;
					foreach($post['search_reservation'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.reservation_flg = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_reservation', $post['search_reservation'], '');
					break;
				}
				case 'search_payoff':
				{
					if (!isset($post['search_payoff']))
						$post['search_payoff'] = array();
					if (count($post['search_payoff']) && $where != "")
						$where .= " OR ";

					$cnt = 0;
					foreach($post['search_payoff'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.pay_off = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_payoff', $post['search_payoff'], '');
					break;
				}
				case 'search_sale_statuses':
				{
					if (!isset($post['search_sale_statuses']))
						$post['search_sale_statuses'] = array();
					if (count($post['search_sale_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_sale_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.sale_status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";

					$this->setFormParams('arrForm', 'search_sale_statuses', $post['search_sale_statuses'], '');
					break;
				}
			}
		}

		if($shop_id != "") {
			$where .= " and A.shop_id = ".$shop_id;
		}

		$sql .= $where;
		$sql .= " group by B.product_code order by create_date ";
		$query = DB::query($sql);
		$arrData = $query->execute()->as_array();
//var_dump($sql);
//var_dump($arrData);
//exit;

		foreach ($arrData as $data) {
			foreach ( $data as &$col ) {
				$col = htmlspecialchars($col);
			}

			array_push($csv_data, $data);
		}

		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$shop.'_'.date('Ymd').'.csv"');
		echo Format::forge($csv_data)->to_csv();
		$this->response->send(true);

		return exit();
	}

	function action_upload()
	{

		$this->tpl = 'smarty/admin/product/upload.tpl';
		return $this->view;
	}

	function action_uploadtheme()
	{

		$this->tpl = 'smarty/admin/product/upload_theme.tpl';
		return $this->view;
	}

	function action_uploadsale()
	{

		$this->tpl = 'smarty/admin/product/upload_sale.tpl';
		return $this->view;
	}
	function action_uploadsale2()
	{

		$this->tpl = 'smarty/admin/product/upload_sale2.tpl';
		return $this->view;
	}

	function action_uploaddel()
	{

		$this->arrResult['csv_result'] = array();
		$this->tpl = 'smarty/admin/product/uploaddel.tpl';
		return $this->view;
	}

	function action_uploaddel2()
	{

		$this->arrResult['csv_result'] = array();
		$this->tpl = 'smarty/admin/product/uploaddel2.tpl';
		return $this->view;
	}

	function action_productstock()
	{

		$this->arrResult['csv_result'] = array();
		$this->tpl = 'smarty/admin/product/productstock.tpl';
		return $this->view;
	}

	//no_product
	function action_noproduct()
	{
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);

		$this->tpl = 'smarty/admin/product/noproduct.tpl';
		
		$arrTemp = Tag_Shop::get_shoplist();
		$arrShop = array();
		$arrShop[0] = "ALL";
		foreach($arrTemp as $temp)
		{
			$arrShop[$temp['id']] = $temp['shop_name'];
		}
		$this->arrResult['arrShop'] = $arrShop;

		$this->arrResult['arrProducts'] = array();
//var_dump($_POST);

		if (count($_POST) > 0)
		{
			if (isset($_POST['search_price']) && $_POST['search_price'] != '')
				$where = " A.del_flg = 0 and B.price01 <= {$_POST['search_price']} ";
			else
				$where = " A.del_flg = 0 ";
			
			if (isset($_POST['search_product_statuses']))
			{
				$where .= " and ";				
				$where .= " A.status in (";
				$temp = "";
				if (is_array($_POST['search_product_statuses']))
				{
					foreach($_POST['search_product_statuses'] as $st)
					{
						if($temp != "")
							$temp .= ",";
						$temp .= $st;
					}
				}
				else
					$temp = $_POST['search_product_statuses'];
					
				$where .= $temp.")";
			}
			
			if ($_POST['search_shop'] != 0)
			{
				$where .= " and ";
				$where .= " shop_id = '{$_POST['search_shop']}' ";
			}

			if ($_POST['search_product_code'] != '')
			{
				$where .= " and ";
				$where .= " group_code like '{$_POST['search_product_code']}%' ";
			}
			
			$query = DB::query("SELECT A.product_id, A.name, A.status, B.price01 from dtb_products as A join dtb_product_price as B on A.product_id = B.dtb_products_product_id where ".$where);
			$arrRet = $query->execute()->as_array();
			
			$noproducts = "";
			foreach($arrRet as $ret)
			{
				if ($noproducts != "")
					$noproducts .= ",";
				$noproducts .= $ret['product_id'];
			}
			
			$this->arrResult['arrProducts'] = $arrRet;
			$this->arrResult['noproducts'] = $noproducts;
			$this->arrResult['arrPost'] = $_POST;
				
			if ($_POST['mode'] == 'download')
			{
				$csv_data = array();
				
				$this->response = new Response();
				$this->response->set_header('Content-Type', 'application/csv');
				$this->response->set_header('Content-Disposition', 'attachment; filename="noproduct_'.date('Ymd').'.csv"');
				echo Format::forge($arrRet)->to_csv();
				$this->response->send(true);
				return exit();
			}

		}
		
		
		return $this->view;
	}

	function post_rakutenupload()
	{
		$file_tmp1  = $_FILES["csv_file1"]["tmp_name"];
		$file_tmp2  = $_FILES["csv_file2"]["tmp_name"];
// 		$file_save = REAL_UPLOAD_IMAGE_PATH . "temp/" . $_FILES["csv_file"]["name"];
// 		$result = @move_uploaded_file($file_tmp, $file_save);
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);

		$csv1 = array();
		$csv2 = array();

		$file = fopen($file_tmp1, 'r');
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv1[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

		$file = fopen($file_tmp2, 'r');
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv2[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

//var_dump($csv1);
//var_dump($csv2);
//exit;

		$create = $this->createCSV2($csv1, $csv2);

//			var_dump(count($create));
//		foreach($create as $c)
//		{
//			var_dump(count($c));
//			if (is_array($c))
//			{
//				var_dump($c);
//			}
//		}
//
//exit;
// 		$download = $this->createCSV($create);
		
    	$fname = APPPATH."tmp/from_rakuten_product_csv_".date("YmdHis").".csv";
		$download_file = $this->saveCSV($create, $fname);
    	$fname2 = Tag_Session::get('shop')."_product_csv_".date("YmdHis").".csv";

		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$fname2.'"');
//		echo Format::forge($download)->to_csv();
		readfile($download_file);
		$this->response->send(true);

		exit;

	}

    function createCSV2($arrCSV1,$arrCSV2)
    {
    	$createCSV = array();
		$keys = array(
			'product_id',
			'category_id',
			'product_code',
			'status_flg',
			'tag',
			'name',
			'name_en',
			'name_kana',
			'price01',
			'price02',
			'cost_price',
			'info',
			'comment',
			'status',
			'del_flg',
			'create_date',
			'view_date',
			'close_date',
			'product_status_id',
			'group_code',
			'shop_id',
			'brand_id',
			'theme_id',
			'point_rate',
			'update_date',
			'season',
			'material',
			'size_text',
			'remarks',
			'country',
			'switch_property',
			'id',
			'size_code',
			'size_name',
			'color_code',
			'color_name',
			'stock',
			'dtb_products_product_id',
			'stock_type',
		);
    	$createCSV[] = $keys;
//    	var_dump($arrCSV1[1]);exit;
    	foreach($arrCSV1 as $csv1)
    	{
    		if (count($csv1) == 1)
    			continue;
   			$p_code = $csv1[1];
   			$arrSKU = array();
   			$cc = 0;
   			
   			foreach($arrCSV2 as $sku)
   			{
	    		if (count($sku) == 1)
	    		{
//	    			$cc++;
	    			continue;
	    		}
//print("<pre>");
//var_dump($p_code.':'.$sku[1]);   			
//print("</pre>");
   				if ($sku[1] == $p_code)
   					$arrSKU[] = $sku;
   				$cc++;
   			}


   			$c = 0;
   			foreach($arrSKU as $sku)
   			{
		    	$arrCSV = array();
	   			$c++;
    			for($cnt = 0;$cnt < count($keys);$cnt++)
	    		{
	
		    		if ($cnt == 2)	//SKUコード
		    		{
		    			$arrCSV[$cnt] = $sku[1].'-'.$c;
		    		}
		    		else if($cnt == 1)	//部門ID
		    		{
		    			$arrCSV[$cnt] = "0";
		    		}
		    		else if($cnt == 3)	//NEW
		    		{
		    			$arrCSV[$cnt] = "1";
		    		}
		    		else if($cnt == 5)	//商品名
		    		{
		    			$arrCSV[$cnt] = $csv1[7];
		    		}
		    		else if($cnt == 8)	//商品価格
		    		{
		    			$arrCSV[$cnt] = $csv1[8];
		    		}
		    		else if($cnt == 9)	//商品価格
		    		{
		    			$arrCSV[$cnt] = 0;
		    		}
		    		else if($cnt == 10)	//商品価格
		    		{
		    			$arrCSV[$cnt] = 0;
		    		}
		    		else if($cnt == 11)	//商品説明
		    		{
		    			$arrCSV[$cnt] = htmlspecialchars($csv1[23]);
		    		}
		    		else if($cnt == 13)	//status
		    		{
		    			$arrCSV[$cnt] = 1;
		    		}
		    		else if($cnt == 32)	//サイズコード
		    		{
		    			$arrCSV[$cnt] = $sku[6];
		    		}
		    		else if($cnt == 33)	//サイズ名
		    		{
		    			$arrCSV[$cnt] = $sku[7];
		    		}
		    		else if($cnt == 34)	//カラーコード
		    		{
		    			$arrCSV[$cnt] = $sku[4];
		    		}
		    		else if($cnt == 35)	//カラー名
		    		{
		    			$arrCSV[$cnt] = $sku[5];
		    		}
		    		else if($cnt == 36)	//stock
		    		{
		    			$arrCSV[$cnt] = $sku[10];
		    		}
		    		else if($cnt == 19)	//グループコード
		    		{
		    			$arrCSV[$cnt] = $sku[1];
		    		}
		    		else if($cnt == 20)	//shop_id
		    		{
		    			$arrCSV[$cnt] = Tag_Session::get('shop_id');
		    		}
		    		else if($cnt == 21)	//brand_id
		    		{
		    			$arrCSV[$cnt] = 0;
		    		}
		    		else if($cnt == 23)	//ポイント付与率
		    		{
		    			$arrCSV[$cnt] = "1";
		    		}
		    		else if($cnt == 38)	//kurosumo-ru
		    		{
		    			$arrCSV[$cnt] = "0";
		    		}
		    		else
		    		{
			    		$arrCSV[$cnt] = "";
		    		}
	    		}
	    		$createCSV[] = $arrCSV;
//	    		var_dump(count($createCSV));
//	    		var_dump(count($arrCSV));
//	    		if (count($createCSV) == 10)
//	    			exit;
   			}
    	}
//    	exit;
    	return $createCSV;
    }

	function getCsvArray($filename, $enc = 'sjis-win')
	{
		$file = fopen($filename, 'r');
		$cnt = 0;
		$csv_key = array();
		$csv = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', $enc);
				}
//				exit;
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
		
		return $csv;
	}

	function post_crossupload()
	{
		ini_set('memory_limit', '512M');
		ini_set('auto_detect_line_endings', true);

		$keys = array(
			'product_id',
			'category_id',
			'product_code',
			'status_flg',
			'tag',
			'name',
			'name_en',
			'name_kana',
			'price01',
			'price02',
			'info',
			'comment',
			'status',
			'del_flg',
			'create_date',
			'view_date',
			'close_date',
			'product_status_id',
			'group_code',
			'shop_id',
			'brand_id',
			'theme_id',
			'point_rate',
			'update_date',
			'season',
			'material',
			'size_text',
			'remarks',
			'country',
			'switch_property',
			'id',
			'size_code',
			'size_name',
			'color_code',
			'color_name',
			'stock',
			'dtb_products_product_id',
			'stock_type',
			'cost_price',
			'sale_status',
			'attribute',
			'images',
		);

		$file_tmp1  = $_FILES["csv_file1"]["tmp_name"];
		$file_tmp5  = $_FILES["csv_file5"]["tmp_name"];

		$file_tmp2  = $_FILES["csv_file2"]["tmp_name"];
		$file_tmp3  = $_FILES["csv_file3"]["tmp_name"];
		$file_tmp4  = $_FILES["csv_file4"]["tmp_name"];

//		$csv_category = array();
		$csv_category = $this->getCsvArray($file_tmp5, 'UTF-8');
		$csv_fcategory = $this->getCsvArray($file_tmp1);
		
		$f_category = array();
		foreach($csv_fcategory as $fc)
		{
			foreach($csv_category as $c)
			{
				if ($fc[3] == $c[0])
				{
					if ($c[1] != '')
					{
						$f_category[$fc[1]] = $c[1];	//SKU - category_id
						break;
					}
				}
			}
		}

		$csv_goods = $this->getCsvArray($file_tmp2);
		$csv_sku = $this->getCsvArray($file_tmp3);
		
		$csv_image = array();
		if ($file_tmp4)
			$csv_image = $this->getCsvArray($file_tmp4);
		
		define("IMG_PATH", "https://image.rakuten.co.jp/ginlet/cabinet");
		$product_images = array();
		$img_key = array(22,25,28,31,34,37,40,43,46,49,52,55,58,61,64,67,70,73,76,79);
		foreach($csv_image as $image)
		{
			if ($image[22] != '')
			{
				foreach($img_key as $k)
				{
					if ($image[$k] == '')
						continue;

					$fnames = '';
					$url = IMG_PATH.$image[$k];
					$file = @file_get_contents($url);
					$fname = basename($image[$k]);
					$exts = explode('.', $fname);
					if (is_array($exts))
					{
						if (!isset($exts[1]))
						{
							var_dump($k);
							var_dump($url);
							var_dump($fname);
							exit;
						}
						
						$fn = $exts[0];
						$ext = $exts[1];
					}
	
					if ($file)
					{
						$fnames = $this->image_save($fn, $ext, $file);
					}
					if ($k == 22)
						$product_images[$image[1]] = $fnames;
					else
					$product_images[$image[1]] .= ','.$fnames;
				}
			}
		}
//var_dump($fnames);
//exit;				
//var_dump($product_images);
//exit;				
		
		$products = array();		
		$products_size = array();		
		$products_color = array();	
		foreach($csv_sku as $sku)
		{
			$pk = array();
			if ($sku[3] != '')
			{
				$pk['size_name'] = $sku[2];
				$pk['size_code'] = $sku[3];
				$products_size[$sku[1]][] = $pk;
			}
			else if ($sku[5] != '')
			{
				$pk['color_name'] = $sku[4];
				$pk['color_code'] = $sku[5];
				$products_color[$sku[1]][] = $pk;
			}
		}
		
		$psku = array();
		foreach($products_size as $k => $size)
		{
			foreach($size as $s)
			{
				$p = array();
				$p['code'] = $k.$s['size_code'];
				$p['size_name'] = $s['size_name'];
				$p['size_code'] = $s['size_code'];
				$psku[$k][] = $p;
			}
		}

		$arrTemp = array();
		foreach($products_color as $k => $color)
		{
			foreach($color as $c)
			{
				foreach($psku[$k] as $ps)
				{
					$ps['code'] = $ps['code'].$c['color_code'];
					$ps['color_name'] = $c['color_name'];
					$ps['color_code'] = $c['color_code'];
					$arrTemp[$k][] = $ps;
				}
			}
		}
		
//print('<pre>');
////var_dump($csv_category);
////var_dump($csv_fcategory);
//var_dump($arrTemp);
//print('</pre>');
//exit;

		foreach($csv_sku as $sku)
		{
			$product_sku = array();

			$v1 = $sku[3];
			$v2 = $sku[5];
			$product_sku['code'] = $sku[1].$v1.$v2;
			$product_sku['size_name'] = $sku[2];
			$product_sku['size_code'] = $sku[3];
			$product_sku['color_name'] = $sku[4];
			$product_sku['color_code'] = $sku[5];
			
			$products[$sku[1]][] = $product_sku;
		}
//print('<pre>');
////var_dump($csv_category);
////var_dump($csv_fcategory);
//var_dump($f_category);
//print('</pre>');
//exit;

		$create_products = array();
		foreach($arrTemp as $k => $vs)
		{
			foreach($csv_goods as $goods)
			{
				$p = array();
				if ($k == $goods[1])
				{
					foreach($vs as $v)
					{
						$p['product_code'] = $v['code'];
						$p['name'] = $goods[4];
						$brand = explode("（",$goods[5]);
						$b_name = str_replace("'", "''", $brand[0]);
						$arrBrand = Tag_Item::get_brand_like("name like '".$b_name."%' and shop_url = '".Tag_Session::get('shop')."'");
//var_dump($brand);
//var_dump($arrBrand[0]['id']);
//exit;
						$p['brand_id'] = '0';
						if (count($arrBrand) > 0)
							$p['brand_id'] = $arrBrand[0]['id'];
/*
						if ($p['brand_id'] == '0')
						{
			    			if (Tag_Session::get('shop') == 'guji')
			    			{
								$arrRet = Tag_Item::get_brand_like("name = 'guji' and shop_url = 'guji'");
								if (count($arrRet) > 0)
					    			$brand_id = $arrRet[0]['id'];
			    			}
				    		else if (Tag_Session::get('shop') == 'biglietta')
				    		{
								$arrRet = Tag_Item::get_brand_like("name = 'biglietta' and shop_url = 'biglietta'");
								$default = $arrRet[0]['id'];
								$bname = '';
								
								if (isset($arrCSV1[4]))
								{
									$bnames = explode('/',$arrCSV1[4]);
									if (isset($bnames[1]))
									{
										$bname = str_replace('（', '(', $bnames[1]);
										$pos = strpos($bname, '(');
										$bname = substr($bname, 0, $pos);
									}
								}
								if ($bname != '')
								{
									$bname = str_replace("'", "''", $bname);
									$arrRet = Tag_Item::get_brand_like("name = '{$bname}' and shop_url = 'biglietta'");
								}
								
								if (count($arrRet) > 0)
					    			$brand_id = $arrRet[0]['id'];
					    		else
					    			$brand_id = $default;
				    		}
							$p['brand_id'] = $brand_id;
						}
*/
						$p['status_flg'] = '1';
						$p['price01'] = $goods[7];
						$p['price02'] = 0;
						$p['info'] = str_replace(PHP_EOL, "", nl2br($this->getInfo($goods[41])));
/*
if ($p['product_code'] == '121557000450102')
{
$data = $goods[41];
$start = strpos($data, '<!--ItemDescription-->');
$end = strpos($data, '<!--Staff voice-->', $start);

$txt = substr($data, $start, ($end - $start));

print("<pre>");
	var_dump($txt);
	var_dump(trim(strip_tags($txt)));
	var_dump($p['info']);
print("</pre>");
	exit;
}
*/
						$p['group_code'] = $goods[1];
						$p['status'] = 3;
						$p['del_flg'] = 0;
						$p['shop_id'] = Tag_Session::get('shop_id');
						$p['point_rate'] = "";
						$p['switch_property'] = 0;
						$p['season'] = $this->getSeason($goods[41]);
						$p['material'] = $this->getMaterial($goods[41]);
						$p['size_text'] = $this->getSizeText($goods[41]);
						$p['remarks'] = $this->getRemarks($goods[41]);
						$p['country'] = $this->getCountory($goods[41]);//htmlspecialchars($goods[41],ENT_QUOTES)
						$p['size_code'] = $v['size_code'];
						$p['size_name'] = $v['size_name'];
						$p['color_code'] = $v['color_code'];
						$p['color_name'] = $v['color_name'];
						$p['comment'] = $this->getComment($goods[41]);
						$p['stock'] = 0;
						$p['stock_type'] = 2;
						$p['cost_price'] = 0;
						$p['category_id'] = @$f_category[$goods[1]];
						$p['images'] = @$product_images[$goods[1]];
						
						$create_products[] = $p;
					}
				}
			}
		}

		$create = array();
		$create[] = $keys;
		foreach($create_products as $c)
		{
			$data = array();
			foreach($keys as $key)
			{
				foreach($c as $k => $v)
				{
					if ($key == $k)
					{
						$f = true;
						$data[$key] = $c[$key];
						break;
					}
					else
						$data[$key] = '';
				}
			}
			$create[] = $data;
		}

//print('<pre>');
////var_dump($csv_category);
////var_dump($csv_fcategory);
//var_dump($create);
//print('</pre>');
//exit;

    	$fname = APPPATH."tmp/product_csv_".date("YmdHis").".csv";
		$download_file = $this->saveCSV($create, $fname);
    	$fname2 = Tag_Session::get('shop')."_product_csv_".date("YmdHis").".csv";

		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$fname2.'"');
//		echo Format::forge($download)->to_csv();
		readfile($download_file);
		$this->response->send(true);

		exit;

//print('<pre>');
////var_dump($csv_category);
////var_dump($csv_fcategory);
//var_dump($create_products);
//print('</pre>');
//exit;




	}

	function getInfo($data)
	{
		$start = strpos($data, '<!--ItemDescription-->');
		$end = strpos($data, '<!--Staff voice-->', $start);
		
		$txt = substr($data, $start, ($end - $start));

		return trim(strip_tags($txt));
	}

	function getComment($data)
	{
		$base = strpos($data, '<!--Staff voice-->') + strlen('<!--Staff voice-->');
		$start = strpos($data, '<div class="staffv_box"><!--■-->', $base);
		$end = strpos($data, '<!--size-->', $base);
		
		$txt = substr($data, $start, ($end - $start));
		
//print("<pre>");
//var_dump($start);
//var_dump($end);
//var_dump(trim($txt));
//print("</pre>");
//exit;
		return trim(strip_tags($txt));
	}

	function getSizeText($data)
	{
		$base = strpos($data, '<!--size-->') + strlen('<!--size-->');
		$start = strpos($data, '<section id="item_size"><!--■-->', $base) + strlen('<section id="item_size"><!--■-->');
		$end = strpos($data, '</table>', $base) + strlen('</table>');
		
		$txt = substr($data, $start, ($end - $start));
		
//print("<pre>");
//var_dump($start);
//var_dump($end);
//var_dump(trim($txt));
//print("</pre>");
//exit;
//		return trim(strip_tags($txt));
		return htmlspecialchars(trim($txt),ENT_QUOTES);
	}

	function getMaterial($data)
	{
		$base = strpos($data, '<td bgcolor="#eeeeee" width="25%"><font size="-1">素材</font></td>') + strlen('<td bgcolor="#eeeeee" width="25%"><font size="-1">素材</font></td>');
		$start = strpos($data, '<td><font size="-1">', $base);
		$end = strpos($data, '</font></td>', $base);
		
		$txt = substr($data, $start, ($end - $start));
		
		return trim(strip_tags($txt));
	}

	function getCountory($data)
	{
		$base = strpos($data, '<td bgcolor="#eeeeee" width="25%"><font size="-1">生産国</font></td>') + strlen('<td bgcolor="#eeeeee" width="25%"><font size="-1">生産国</font></td>');
		$start = strpos($data, '<td><font size="-1">', $base);
		$end = strpos($data, '</font></td>', $base);
		
		$txt = substr($data, $start, ($end - $start));
		
		return strip_tags($txt);
	}

	function getSeason($data)
	{
		$base = strpos($data, '<td bgcolor="#eeeeee" width="25%"><font size="-1">シーズン</font></td>') + strlen('<td bgcolor="#eeeeee" width="25%"><font size="-1">シーズン</font></td>');
		$start = strpos($data, '<td><font size="-1">', $base);
		$end = strpos($data, '</font></td>', $base);
		
		$txt = substr($data, $start, ($end - $start));
		
		return strip_tags($txt);
	}

	function getRemarks($data)
	{
		$base = strpos($data, '<td bgcolor="#eeeeee" width="25%"><font size="-1">付属品</font></td>') + strlen('<td bgcolor="#eeeeee" width="25%"><font size="-1">付属品</font></td>');
		$start = strpos($data, '<td><font size="-1">', $base);
		$end = strpos($data, '</font></td>', $base);
		
		$txt = substr($data, $start, ($end - $start));
		
//print("<pre>");
//var_dump($start);
//var_dump($end);
//var_dump(trim(strip_tags($txt)));
//print("</pre>");
//exit;
		$txt = trim(strip_tags($txt));
		
		if ($txt == '無し')
			$txt = '付属品なし';
		return $txt;
	}

	
	function post_crossupload2()
	{
		$file_tmp1  = $_FILES["csv_file1"]["tmp_name"];
		$file_tmp2  = $_FILES["csv_file2"]["tmp_name"];
// 		$file_save = REAL_UPLOAD_IMAGE_PATH . "temp/" . $_FILES["csv_file"]["name"];
// 		$result = @move_uploaded_file($file_tmp, $file_save);
		ini_set('memory_limit', '512M');
		ini_set('auto_detect_line_endings', true);

		$csv1 = array();
		$csv2 = array();

		$file = fopen($file_tmp1, 'r');
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv1[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

		$file = fopen($file_tmp2, 'r');
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
//					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv2[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

//var_dump($csv1);
//var_dump($csv2);
//exit;

		$create = $this->createCSV($csv1, $csv2, $_POST['csv_date']);

// 		$download = $this->createCSV($create);
		
    	$fname = APPPATH."tmp/product_csv_".date("YmdHis").".csv";
		$download_file = $this->saveCSV($create, $fname);
    	$fname2 = Tag_Session::get('shop')."_product_csv_".date("YmdHis").".csv";

		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$fname2.'"');
//		echo Format::forge($download)->to_csv();
		readfile($download_file);
		$this->response->send(true);

		exit;

	}

	function post_copyupload()
	{
		$file_tmp1  = $_FILES["csv_file1"]["tmp_name"];
		ini_set('memory_limit', '512M');
		ini_set('auto_detect_line_endings', true);

		$csv1 = array();

		$file = fopen($file_tmp1, 'r');
		$cnt = 0;
		$csv_key = array();
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);
				$csv_temp = array();
				foreach($data as $k=>$v)
				{
//					var_dump($csv_key[$k]);
					$csv_temp[$csv_key[$k]] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
//					$csv_temp[] = mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
//				exit;
				$csv1[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

//var_dump($csv1);
//var_dump($csv2);
//exit;

		foreach($csv1 as $c)
		{
			$query = DB::query("SELECT * from dtb_product_copy where shop_url = '{Tag_Session::getShop()}' and product_id = {$c['product_id']} ");
			$arrRet = $query->execute()->as_array();
			
			if (count($arrRet) == 0)
			{
				$arrItem = array();
				$arrItem['dtb_products_product_id'] = $c['product_id'];
				$arrItem['product_id'] = $c['product_id'];
				$arrItem['org_shop'] = $c['shop'];
				$arrItem['shop_url'] = Tag_Session::getShop();
				$ins = DB::insert('dtb_product_copy');
				$ins->set($arrItem)->execute();				
			}
		}

		$this->arrResult['error2'] = "コピー品の登録を完了しました。";

		$this->tpl = 'smarty/admin/product/upload.tpl';
		return $this->view;


	}
	
    function saveCSV($arrOutCSV, $fname)
    {    	
        $fp = fopen($fname, 'w+');

        if (!$fp) {
            $this->errFlag = true;
            $this->addRowErr('', '※ ファイルの作成に失敗しました。');
            return "";
        }
        
        $cc = 0;
        foreach($arrOutCSV as $csv)
        {
//        	$cc++;
//        	var_dump($cc);
	        $first = true;
//			if ($cc == 2)
//				var_dump($csv);
        	foreach($csv as $item)
        	{
        		if ($first)
        		{
					fwrite($fp, '"'.mb_convert_encoding($item,"SJIS","UTF-8").'"');
					$first = false;
        		}
				else
				{
//					var_dump($item);
//					if (is_array($item))
//					{
//						var_dump($item);
//						exit;
//					}
					fwrite($fp, ',"'.mb_convert_encoding($item,"SJIS","UTF-8").'"');
				}
        	}
			fwrite($fp, PHP_EOL);
        }

		fclose($fp);
		
		return $fname;
    }

    function createCSV($arrCSV1,$arrCSV2, $csv_date = "")
    {
//    	SC_Utils::sfPrintR("TEST1");
    	$createCSV = array();
		$keys = array(
			'product_id',
			'category_id',
			'product_code',
			'status_flg',
			'tag',
			'name',
			'name_en',
			'name_kana',
			'price01',
			'price02',
			'cost_price',
			'info',
			'comment',
			'status',
			'del_flg',
			'create_date',
			'view_date',
			'close_date',
			'product_status_id',
			'group_code',
			'shop_id',
			'brand_id',
			'theme_id',
			'point_rate',
			'update_date',
			'season',
			'material',
			'size_text',
			'remarks',
			'country',
			'switch_property',
			'id',
			'size_code',
			'size_name',
			'color_code',
			'color_name',
			'stock',
			'dtb_products_product_id',
			'stock_type'
		);
    	$createCSV[] = $keys;
    	
    	if ($csv_date != "")
	    	$csv_date = date("Ymd", strtotime($csv_date));

// var_dump($csv_date);
 //var_dump($arrCSV1);
//exit;// var_dump($csv_date);

    	foreach($arrCSV1 as $csv1)
    	{
// var_dump($csv1[0]);
// exit;
    		if ($csv_date == '' || intVal(date("Ymd",strtotime($csv1[3]))) >= intVal($csv_date))
    		{
	    		foreach($arrCSV2 as $csv2)
	    		{
// var_dump(count($csv2));
// exit;
	    			if ($csv1[0] == $csv2[0])
	    			{
//	    				SC_Utils::sfPrintR($csv1[0].":".$csv2[0]);
			    		$createCSV[] = $this->createOne($csv1,$csv2);
	    			}
	    		}
    		}
    	}

		return $createCSV;
    }

    function createOne($arrCSV1,$arrCSV2)
    {
		$keys = array(
			'product_id',
			'category_id',
			'product_code',
			'status_flg',
			'tag',
			'name',
			'name_en',
			'name_kana',
			'price01',
			'price02',
			'info',
			'comment',
			'status',
			'del_flg',
			'create_date',
			'view_date',
			'close_date',
			'product_status_id',
			'group_code',
			'shop_id',
			'brand_id',
			'theme_id',
			'point_rate',
			'update_date',
			'season',
			'material',
			'size_text',
			'remarks',
			'country',
			'switch_property',
			'id',
			'size_code',
			'size_name',
			'color_code',
			'color_name',
			'stock',
			'dtb_products_product_id',
			'stock_type',
			'cost_price'
		);
    	$arrCSV = array();
    	for($cnt = 0;$cnt < count($keys);$cnt++)
    	{
    		if ($cnt == 2)	//SKUコード
    		{
    			$arrCSV[$cnt] = $arrCSV2[1];
    		}
    		else if($cnt == 1)	//部門ID
    		{
    			$arrCSV[$cnt] = "0";
    		}
    		else if($cnt == 3)	//部門ID
    		{
    			$arrCSV[$cnt] = "1";
    		}
    		else if($cnt == 5)	//商品名
    		{
    			$arrCSV[$cnt] = $arrCSV1[1];
    		}
    		else if($cnt == 8)	//商品価格
    		{
    			$arrCSV[$cnt] = $arrCSV1[2];
    		}
    		else if($cnt == 9)	//商品価格
    		{
    			$arrCSV[$cnt] = 0;
    		}
    		else if($cnt == 10)	//商品価格
    		{
    			$arrCSV[$cnt] = 0;
    		}
    		else if($cnt == 11)	//商品情報
    		{
    			if (isset($arrCSV1[5]))
	    			$arrCSV[$cnt] = htmlspecialchars($arrCSV1[5],ENT_QUOTES);
	    		else
	    			$arrCSV[$cnt] = '';
    		}
    		else if($cnt == 12)	//商品情報
    		{
    			if (isset($arrCSV1[6]))
	    			$arrCSV[$cnt] = htmlspecialchars($arrCSV1[6],ENT_QUOTES);
	    		else
	    			$arrCSV[$cnt] = '';
    		}
    		else if($cnt == 13)	//status
    		{
    			$arrCSV[$cnt] = 1;
    		}
    		else if($cnt == 32)	//サイズコード
    		{
    			$arrCSV[$cnt] = $arrCSV2[2];
    		}
    		else if($cnt == 33)	//サイズ名
    		{
    			$arrCSV[$cnt] = $arrCSV2[3];
    		}
    		else if($cnt == 34)	//カラーコード
    		{
    			$arrCSV[$cnt] = $arrCSV2[4];
    		}
    		else if($cnt == 35)	//カラー名
    		{
    			$arrCSV[$cnt] = $arrCSV2[5];
    		}
    		else if($cnt == 36)	//stock
    		{
    			$arrCSV[$cnt] = 0;
    		}
    		else if($cnt == 30)	//stock
    		{
    			$arrCSV[$cnt] = 0;
    		}
    		else if($cnt == 19)	//グループコード
    		{
    			$arrCSV[$cnt] = $arrCSV1[0];
    		}
    		else if($cnt == 20)	//shop_id
    		{
    			$arrCSV[$cnt] = Tag_Session::get('shop_id');
    		}
    		else if($cnt == 21)	//brand_id
    		{
    			if (Tag_Session::get('shop') == 'guji')
    			{
					$arrRet = Tag_Item::get_brand_like("name = 'guji' and shop_url = 'guji'");
					if (count($arrRet) > 0)
		    			$arrCSV[$cnt] = $arrRet[0]['id'];
    			}
	    		else if (Tag_Session::get('shop') == 'biglietta')
	    		{
					$arrRet = Tag_Item::get_brand_like("name = 'biglietta' and shop_url = 'biglietta'");
					$default = $arrRet[0]['id'];
					$bname = '';
					
					if (isset($arrCSV1[4]))
					{
						$bnames = explode('/',$arrCSV1[4]);
						if (isset($bnames[1]))
						{
							$bname = str_replace('（', '(', $bnames[1]);
							$pos = strpos($bname, '(');
							$bname = substr($bname, 0, $pos);
						}
					}
					if ($bname != '')
					{
						$bname = str_replace("'", "''", $bname);
						$arrRet = Tag_Item::get_brand_like("name = '{$bname}' and shop_url = 'biglietta'");
					}
					
					if (count($arrRet) > 0)
		    			$arrCSV[$cnt] = $arrRet[0]['id'];
		    		else
		    			$arrCSV[$cnt] = $default;
	    		}
	    		else
	    			$arrCSV[$cnt] = 0;
    		}
    		else if($cnt == 23)	//ポイント付与率
    		{
    			$arrCSV[$cnt] = "1";
    		}
    		else if($cnt == 38)	//kurosumo-ru
    		{
    			$arrCSV[$cnt] = "2";
    		}
    		else
    		{
	    		$arrCSV[$cnt] = "";
    		}
    	}
    	return $arrCSV;
    }

	function post_uploadtheme()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
//		$shop = $_SESSION['shop_id'];
//		if ($shop == '')
//			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('product_id', 'shop_id', 'theme_id');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/upload_theme.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		$arrTheme = DB::select('*')->from('dtb_theme')->where('del_flg','0')->as_assoc()->execute();
		
		$themeCheck = array();
		$themeCheck[0] = 0;
		foreach($arrTheme as $theme)
		{
			$themeCheck[$theme['id']] = $theme['id'];
		}
		
//var_dump($themeCheck);
//var_dump($csv);
//exit;
		$err = false;
		foreach($csv as $c)
		{
			$cnt++;
//var_dump($cnt.":".$err);
			if (isset($themeCheck[$c['theme_id']]) && $themeCheck[$c['theme_id']] == $c['theme_id'])
			{
				$ret = DB::update('dtb_products')->value('theme_id', $c['theme_id'])->where('product_id', $c['product_id'])->where('shop_id', $c['shop_id'])->execute();
				if ($ret)
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新しました。";
				else
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新失敗しました。";
			}
			else
			{
				$err = true;
				$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新失敗しました。（theme_id ".$c['theme_id']." が存在しません）";
			}
		}
//var_dump($err);
		if (!$err)
			$this->arrResult['error'] = "処理が完了しました。";
		else
			$this->arrResult['error'] = "処理に失敗した行があります。";
		$this->arrResult['err'] = $err;
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/upload_theme.tpl';
		return $this->view;
	}

	function post_uploadsale()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('id', 'shop_id', 'sale_status');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/upload_sale.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			if(isset($c['shop_id']) && $shop == $c['shop_id'])
			{
				$ret = DB::update('dtb_products')->value('sale_status', $c['sale_status'])->where('product_id', $c['product_id'])->where('shop_id', $c['shop_id'])->execute();
				if ($ret)
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新しました。";
				else
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新失敗しました。";
			}
			else
			{
				$result[] = $cnt."行目　商品ID: ".$c['product_id']." 更新失敗しました。（shop_idが間違っています）";
			}
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/upload_sale.tpl';
		return $this->view;
	}

	function post_uploadsale2()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('group_code', 'shop_id', 'sale_status');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/upload_sale2.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			if(isset($c['shop_id']) && $shop == $c['shop_id'])
			{
				$ret = DB::update('dtb_products')->value('sale_status', $c['sale_status'])->where('shop_id', $c['shop_id'])->where('group_code', $c['group_code'])->execute();
				if ($ret)
					$result[] = $cnt."行目　グループコード: ".$c['group_code']." 更新しました。";
				else
					$result[] = $cnt."行目　グループコード: ".$c['group_code']." 更新失敗しました。";
			}
			else
			{
				$result[] = $cnt."行目　グループコード: ".$c['group_code']." 更新失敗しました。（shop_idが間違っています）";
			}
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/upload_sale2.tpl';
		return $this->view;
	}

	function post_uploaddel2()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('product_id', 'del_flg', 'shop_id');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/uploaddel2.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			if(isset($c['shop_id']) && $shop == $c['shop_id'])
			{
				$del_flg = 1;
				if ($c['del_flg'] != '')
					$del_flg = $c['del_flg'];

				$ret = DB::update('dtb_products')->value('del_flg', $del_flg)->value('update_date', date('Y-m-d H:i:s'))->where('product_id', $c['product_id'])->where('shop_id', $c['shop_id'])->execute();
				if ($ret)
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 削除しました。";
				else
					$result[] = $cnt."行目　商品ID: ".$c['product_id']." 削除失敗しました。";
			}
			else
			{
				$result[] = $cnt."行目　商品ID: ".$c['product_id']." 削除失敗しました。（shop_idが間違っています）";
			}
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/uploaddel2.tpl';
		return $this->view;
	}
	

	function post_productstock()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('product_code', 'stock', 'shop_id');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/productstock.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			if(isset($c['shop_id']) && $shop == $c['shop_id'])
			{
				$stock = 0;
				if ($c['stock'] != '')
					$stock = $c['stock'];

				$ret = '';
				$ret = DB::query("select count(*) as cnt from dtb_product_sku join dtb_products on dtb_product_sku.dtb_products_product_id = dtb_products.product_id where product_code = '".$c['product_code']."' and del_flg = 0 and shop_id = ".$c['shop_id'])->execute()->as_array();
//				$result[] = $cnt."行目　商品コード: ".$c['product_code']." 在庫更新しました。 在庫数（".$ret[0]['cnt']."）";

				if ($ret[0]['cnt'] == '1')
				{

					$ret = DB::update('dtb_product_sku')->join('dtb_products')->on('dtb_product_sku.dtb_products_product_id', '=', 'dtb_products.product_id')
					->value('stock', $stock)
//					->value('update_date', date('Y-m-d H:i:s'))
					->where('product_code', $c['product_code'])
					->where('del_flg', 0)->where('shop_id', $c['shop_id'])->execute();
					$result[] = $cnt."行目　商品コード: ".$c['product_code']." 在庫更新しました。 在庫数（".$stock."）";
				}
				else
				{
					$result[] = $cnt."行目　商品コード: ".$c['product_code']." 対象の商品コードが存在しませんでした。";
				}
//				if ($ret)
//					$result[] = $cnt."行目　商品コード: ".$c['product_code']." 在庫更新しました。";
//				else
//					$result[] = $cnt."行目　商品コード: ".$c['product_code']." 在庫更新しました。";
			}
			else
			{
				$result[] = $cnt."行目　商品コード: ".$c['product_code']." 在庫更新に失敗しました。（shop_idが間違っています）";
			}
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/productstock.tpl';
		return $this->view;
	}

	function post_uploaddel()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('group_code', 'del_flg', 'shop_id');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/product/uploaddel.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			if(isset($c['shop_id']) && $shop == $c['shop_id'])
			{
				$del_flg = 1;
				if ($c['del_flg'] != '')
					$del_flg = $c['del_flg'];

				$ret = DB::update('dtb_products')->value('del_flg', $del_flg)->value('update_date', date('Y-m-d H:i:s'))->where('group_code', $c['group_code'])->where('shop_id', $c['shop_id'])->execute();
				if ($ret)
					$result[] = $cnt."行目　グループコード: ".$c['group_code']." 削除しました。";
				else
					$result[] = $cnt."行目　グループコード: ".$c['group_code']." 削除失敗しました。";
			}
			else
			{
				$result[] = $cnt."行目　グループコード: ".$c['group_code']." 削除失敗しました。（shop_idが間違っています）";
			}
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/product/uploaddel.tpl';
		return $this->view;
	}
	
	public function image_save($fname, $ext, $file)
	{	
		$fpath = $fname."_".microtime(true).".".$ext;
		$fp = fopen("/var/www/bronline/public/upload/images/".Tag_Session::get('shop')."/".$fpath, "a");
		if ($fp)
		{
			fputs($fp, $file);
			fclose($fp);
		}
		
		return $fpath;
	}

	function post_upload()
	{

		$update = false;
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
// 		$file_save = REAL_UPLOAD_IMAGE_PATH . "temp/" . $_FILES["csv_file"]["name"];
// 		$result = @move_uploaded_file($file_tmp, $file_save);
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);

// 		var_dump ($file_tmp);
// 		exit;
		$shop = $_SESSION['shop'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		if (mb_detect_encoding(file_get_contents($file_tmp),"UTF-8, sjis-win") === false)
		{
			return;
		}
		$enc = mb_detect_encoding(file_get_contents($file_tmp),"UTF-8, sjis-win");
		
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", $enc);
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();
//print("<pre>");
//setlocale(LC_ALL, 'ja_JP.Shift_JIS');
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

//var_dump ($csv);
//exit;

		$keys = array('name', 'name_en', 'name_kana', 'info', 'comment', 'status', 'del_flg', 'create_date', 'view_date', 'close_date', 'product_status_id', 'group_code', 'shop_id', 'brand_id', 'category_id', 'theme_id', 'point_rate', 'update_date', 'season', 'material', 'size_text', 'remarks', 'country','product_id', 'switch_property','attribute','images');
		if (count($csv_key) != count($keys))
		{
// 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
// 			$this->tpl = 'smarty/admin/product/upload.tpl';
// 			return $this->view;
		}

		$update_product = array();
		$keys2 = array('path');
		$arrItems = array();
		$arrProductId = array();
		$arrImages = array();
			$update = false;
		foreach($csv as $c)
		{
//			if (!isset($c['group_code']))
//			{
//print("<pre>");
//				var_dump($c['tag']);
//print("</pre>");
//				exit;
//			}
//print("<pre>");
//var_dump($c);
//print("</pre>");
//exit;
			$group_code = $c['group_code'];
			$arrItem = array();
			foreach($keys as $k)
			{
				if (isset($c[$k]) && $c[$k] == 'NULL')
					$c[$k] = null;
				switch($k)
				{
					case 'remarks':
					case 'country':
					case 'material':
					case 'group_code':
					case 'group_code':
					case 'season':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'size_text':
					{
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'status_flg':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 1;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'point_rate':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 1;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'price02':
					case 'price01':
					case 'cost_price':
					case 'theme_id':
					case 'del_flg':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 0;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'create_date':
					{
						if ($c[$k] != '' && $c[$k] != 'NULL')
							$arrItem[$k] = $c[$k];
						else
							$arrItem[$k] = date('Y-m-d H:i:s');
						break;
					}
					case 'name':
					{
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'product_id':
					case 'status':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'comment':
					case 'info':
					{
// 						$c['main_comment'] = str_replace('􏲪', '', $c['main_comment']);
// 						$c['main_comment'] = str_replace('􏲮', '', $c['main_comment']);
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'shop_id':
					{
						$arrItem[$k] = $c[$k];
						/*
						$sql = "SELECT * FROM dtb_shop WHERE login_id = '{$shop}'";
						$query = DB::query($sql);
						$arrRet = $query->execute()->as_array();
						$arrItem[$k] = $arrRet[0]['id'];
						*/
						break;
					}
					case 'category_id':
					{
						$arrItem[$k] = $c[$k];
// 						$arrItem[$k] = 0;
// 						$arrItem['theme_id'] = 0;
// 						if ($c[$k] > 1000)
// 							$arrItem['theme_id'] = $c[$k];
// 						else
// 							$arrItem[$k] = $c[$k];
 						break;
					}
					case 'brand_id':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'switch_property':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'images':
					{
						if (!isset($arrImages[$group_code]))
						{
							if (isset($c[$k]))
								$arrImages[$group_code] = explode(',', $c[$k]);
						}
						break;
					}
				}
			}
// print('<pre>');
//print("<pre>");
//var_dump($arrImages);
//print("</pre>");
//exit;
			if (!isset($arrItems[$group_code]))
			{
				$g_code = $arrItem['group_code'];
				$sql = "SELECT product_id from dtb_products where group_code = '{$g_code}' and del_flg = 0";
				$arrRet = DB::query($sql)->execute()->as_array();
//print("<pre>");
//var_dump($arrRet);
//print("</pre>");
//exit;
				if (count($arrRet) > 0)
				{
					if ($arrItem['product_id'] != '')
						$product_id = $arrItem['product_id'];
					else
						$product_id = $arrRet[0]['product_id'];
//					$product_id = $arrRet[0]['product_id'];
					$update = true;
//var_dump($arrRet);
//var_dump("<br>".$g_code."<br>");
//var_dump($product_id."<br>");
//var_dump($product_id."<br>");
//exit;
				}
				else
				{
					unset($arrItem['product_id']);
			 		$query = DB::insert('dtb_products');
			 		$query->set($arrItem);
					$arrRet = $query->execute();
					$product_id = $arrRet[0];
				}

				$update_product[] = $product_id;
				$c['product_id'] = $product_id;

				$arrItems[$group_code][] = $c;
 //var_dump('add:'.$group_code.'::'.$c['product_code']);
			}
			else
			{
				$c['product_id'] = $product_id;
				$arrItems[$group_code][] = $c;
 //var_dump('add2:'.$group_code.'::'.$c['product_code']);
			}
		}
// print('<pre>');
// var_dump($arrImages);
// print('</pre>');
// exit;
		foreach($arrItems as $group_code=>$cs)
		{
			$tag_flg = false;
			foreach($cs as $c)
			{
				$product_id = $c['product_id'];
				Log::debug($product_id);
				$sql = "SELECT * FROM dtb_brand WHERE id = '{$c['brand_id']}' and shop_url = '{$shop}'";
				$query_s = DB::query($sql);
				$arrRet = $query_s->execute()->as_array();
				$brand_name = '';
				$brand_kana = '';
				if (count($arrRet) > 0)
				{
					$brand_name = $arrRet[0]['name'];
					$brand_kana = $arrRet[0]['name_kana'];
				}

				//タグ
//				$arrRet = $insert->execute();
// 				if ($brand_name != '')
// 				{
// 					$arrTags = array();
// 					$arrTags['tag'] = $brand_name;
// 	 				$arrTags['dtb_products_product_id'] = $product_id;
// 					$query = DB::insert('dtb_product_tag');
// 			 		$query->set($arrTags);
// 					$arrRet = $query->execute();
// 				}
// 				$arrTags = array();
// 				$arrTags['dtb_products_product_id'] = $product_id;
// 				$arrTags['tag'] = htmlspecialchars($c['name'],ENT_QUOTES);
// print('<pre>');
// var_dump($update);
// print('</pre>');
// exit;

				if (count($arrImages) > 0)
				{
					$sql2 = "SELECT * from dtb_images where dtb_products_product_id = '{$product_id}'";
					$arrRet9 = DB::query($sql2)->execute()->as_array();
					if (count($arrRet9) > 0)
					{
						$sqldel = "DELETE from dtb_images where dtb_products_product_id = '{$product_id}'";
						DB::query($sqldel)->execute();
	
						if (isset($arrImages[$group_code]))
						{
							$first = 1;
							foreach($arrImages[$group_code] as $path)
							{
								$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
								$query = DB::query($sql);
								$arrRet = $query->execute();
								$first++;
							}
						}
					}
					else
					{
						//イメージ
						if (isset($arrImages[$group_code]))
						{
							$first = 1;
							foreach($arrImages[$group_code] as $path)
							{
								$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
								$query = DB::query($sql);
								$arrRet = $query->execute();
								$first++;
							}
						}
					}
				}
				if (!$update)
				{
					if (!$tag_flg)
					{
					$sql = "INSERT INTO dtb_product_tag (dtb_products_product_id, tag) SELECT product_id, name from dtb_products where product_id = ".$product_id;
					$query = DB::query($sql);
					$arrRet = $query->execute();
					Log::debug(DB::last_query());
					if ($brand_name != '')
					{
						if ($shop == 'biglietta')
						{
							$arrTags = array();
							$arrTags['tag'] = $brand_name;
			 				$arrTags['dtb_products_product_id'] = $product_id;
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = 'レディース';
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = 'ビリエッタ';
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = 'グジ';
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = $shop;
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = 'guji';
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();

							$arrTags['tag'] = $brand_kana;
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();
						}
						else
						{
							$arrTags = array();
							$arrTags['tag'] = $brand_name;
			 				$arrTags['dtb_products_product_id'] = $product_id;
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();
						}
					}
					$tag_flg = true;
					}

					//金額
					$arrPrice = array();
					if ($c['price01'] == 'NULL' || $c['price01'] == '')
						$c['price01'] = 0;
					$arrPrice['price01'] = $c['price01'];
					if ($c['price02'] == 'NULL' || $c['price02'] == '')
						$c['price02'] = 0;
					$arrPrice['price02'] = $c['price02'];
	 				if (isset($c['cost_price']))
	 					$c['cost_price'] = $c['cost_price'];
	 				else
	 					$c['cost_price'] = 0;
					$arrPrice['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_price');
			 		$query->set($arrPrice);
					$arrRet = $query->execute();

					//カテゴリ
					$arrCategory = array();
					$arrCategory['category_id'] = $c['category_id'];
					$arrCategory['product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_category');
			 		$query->set($arrCategory);
					$arrRet = $query->execute();

//					イメージ
//					if (isset($arrImages[$group_code]))
//					{
//						$first = 1;
//						foreach($arrImages[$group_code] as $path)
//						{
//							$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
//							$query = DB::query($sql);
//							$arrRet = $query->execute();
//							$first++;
//						}
//					}
				}
				else
				{
					$sql = "SELECT id from dtb_product_price where dtb_products_product_id = '{$product_id}'";
					$arrRet = DB::query($sql)->execute()->as_array();
					if (count($arrRet) > 0)
					{
						DB::delete('dtb_product_price')->where('dtb_products_product_id','=',$product_id)->execute();
					}
					//金額
					$arrPrice = array();
					if ($c['price01'] == 'NULL' || $c['price01'] == '')
						$c['price01'] = 0;
					$arrPrice['price01'] = $c['price01'];
					if ($c['price02'] == 'NULL' || $c['price02'] == '')
						$c['price02'] = 0;
					$arrPrice['price02'] = $c['price02'];
	 				if (isset($c['cost_price']) && $c['cost_price'] != '')
	 					$c['cost_price'] = $c['cost_price'];
	 				else
	 					$c['cost_price'] = 0;
					$arrPrice['cost_price'] = $c['cost_price'];
					$arrPrice['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_price');
			 		$query->set($arrPrice);
					$arrRet = $query->execute();

					$arrProduct = array();
					foreach($keys as $kk)
					{
						if ($kk != 'product_id' && $kk != 'images')
						{
							if (isset($cs[0][$kk]) && $cs[0][$kk] != '')
							{
								if ($cs[0][$kk] != 'NULL')
									$arrProduct[$kk] = htmlspecialchars_decode($cs[0][$kk]);
							}
						}
					}
//					var_dump($keys);
//					var_dump($arrProduct);exit;

					$tags = explode(',', $c['tag']);
					
					DB::delete('dtb_product_tag')->where('dtb_products_product_id','=',$product_id)->execute();
					
					foreach($tags as $tag)
					{
						$arrTags = array();
						$arrTags['tag'] = $tag;
		 				$arrTags['dtb_products_product_id'] = $product_id;
						$query = DB::insert('dtb_product_tag');
				 		$query->set($arrTags);
						$arrRet = $query->execute();
					}
					
		 			$query = DB::update('dtb_products');
		 			$query->where('product_id','=',$product_id);
			 		$arrRet = $query->set($arrProduct)->execute();
				}

				//sku
				$sql = "SELECT id from dtb_product_sku where product_code = '{$c['product_code']}'";
				$arrRet = DB::query($sql)->execute()->as_array();
				$ret_del = 0;
				if (count($arrRet) > 0)
				{
					$ret_del = DB::delete('dtb_product_sku')->where('dtb_products_product_id','=',$product_id)->and_where('product_code', '=', $c['product_code'])->execute();
				}
// 				if (count($arrRet) == 0)
// 				{
					$arrProduct = array();
					if ($c['switch_property'] == '1' && $ret_del == 0)
					{
						$arrProduct['color_name'] = $c['size_name'];
						$arrProduct['size_name'] = $c['color_name'];
						$arrProduct['color_code'] = $c['size_code'];
						$arrProduct['size_code'] = $c['color_code'];
					}
					else
					{
						$arrProduct['color_name'] = $c['color_name'];
						$arrProduct['size_name'] = $c['size_name'];
						$arrProduct['color_code'] = $c['color_code'];
						$arrProduct['size_code'] = $c['size_code'];
					}
					if ($c['stock'] == 'NULL')
						$c['stock'] = 0;
					$arrProduct['stock'] = $c['stock'];
					if ($shop == 'brshop')
						$arrProduct['stock_type'] = 1;
					else if ($shop == 'guji' || $shop == 'ring' || $shop == 'biglietta')
						$arrProduct['stock_type'] = 2;
					else if ($shop == 'sugawaraltd')
						$arrProduct['stock_type'] = 3;
					else
						$arrProduct['stock_type'] = 0;
					$arrProduct['product_code'] = $c['product_code'];
					if (isset($c['attribute']))
						$arrProduct['attribute'] = $c['attribute'];
					$arrProduct['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_sku');
			 		$query->set($arrProduct);
					$arrRet = $query->execute();
//				}

				$arrStatus = array();
				if ($c['status_flg'] == '')
					$c['status_flg'] = 1;
				$arrStatus['status_flg'] = $c['status_flg'];
				$arrStatus['product_id'] = $product_id;

				DB::delete('dtb_product_status')->where('product_id','=',$product_id)->execute();
				
	 			$query = DB::insert('dtb_product_status');
		 		$query->set($arrStatus);
				$arrRet = $query->execute();	
			}
		}

		if ($shop == 'brshop')
		{
			Tag_Smaregi::push_smaregi($shop, $update_product);
		}

		$this->arrResult['error'] = "登録完了しました。";

		$this->tpl = 'smarty/admin/product/upload.tpl';
		return $this->view;

	}


	public static function post_upload_byfile($fname, $shop = 'gentedimare')
	{

		$update = false;
		$file_tmp  = $fname;//$_FILES["csv_file"]["tmp_name"];
// 		$file_save = REAL_UPLOAD_IMAGE_PATH . "temp/" . $_FILES["csv_file"]["name"];
// 		$result = @move_uploaded_file($file_tmp, $file_save);
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);

// 		var_dump ($file_tmp);
// 		exit;
//		$shop = $_SESSION['shop'];
		if ($shop == '')
			return false;
		if ($file_tmp == '')
			return false;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		if (mb_detect_encoding(file_get_contents($file_tmp),"UTF-8, sjis-win") === false)
		{
			return;
		}
		$enc = mb_detect_encoding(file_get_contents($file_tmp),"UTF-8, sjis-win");
		
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", $enc);
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();
//print("<pre>");
//setlocale(LC_ALL, 'ja_JP.Shift_JIS');
		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);

		$keys = array('name', 'name_en', 'name_kana', 'info', 'comment', 'status', 'del_flg', 'create_date', 'view_date', 'close_date', 'product_status_id', 'group_code', 'shop_id', 'brand_id', 'category_id', 'theme_id', 'point_rate', 'update_date', 'season', 'material', 'size_text', 'remarks', 'country','product_id', 'switch_property','attribute','images');
		if (count($csv_key) != count($keys))
		{
// 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
// 			$this->tpl = 'smarty/admin/product/upload.tpl';
// 			return $this->view;
		}

		$update_product = array();
		$keys2 = array('path');
		$arrItems = array();
		$arrProductId = array();
		$arrImages = array();
			$update = false;
		foreach($csv as $c)
		{
//			if (!isset($c['group_code']))
//			{
//print("<pre>");
//				var_dump($c['tag']);
//print("</pre>");
//				exit;
//			}
//print("<pre>");
//var_dump($c);
//print("</pre>");
//exit;
			$group_code = $c['group_code'];
			$arrItem = array();
			foreach($keys as $k)
			{
				if (isset($c[$k]) && $c[$k] == 'NULL')
					$c[$k] = null;
				switch($k)
				{
					case 'remarks':
					case 'country':
					case 'material':
					case 'group_code':
					case 'group_code':
					case 'season':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'size_text':
					{
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'status_flg':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 1;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'point_rate':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 1;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'price02':
					case 'price01':
					case 'cost_price':
					case 'theme_id':
					case 'del_flg':
					{
						if ($c[$k] == '')
							$arrItem[$k] = 0;
						else
							$arrItem[$k] = $c[$k];
						break;
					}
					case 'create_date':
					{
						if ($c[$k] != '' && $c[$k] != 'NULL')
							$arrItem[$k] = $c[$k];
						else
							$arrItem[$k] = date('Y-m-d H:i:s');
						break;
					}
					case 'name':
					{
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'product_id':
					case 'status':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'comment':
					case 'info':
					{
// 						$c['main_comment'] = str_replace('􏲪', '', $c['main_comment']);
// 						$c['main_comment'] = str_replace('􏲮', '', $c['main_comment']);
						$arrItem[$k] = htmlspecialchars_decode($c[$k]);
						break;
					}
					case 'shop_id':
					{
						$arrItem[$k] = $c[$k];
						/*
						$sql = "SELECT * FROM dtb_shop WHERE login_id = '{$shop}'";
						$query = DB::query($sql);
						$arrRet = $query->execute()->as_array();
						$arrItem[$k] = $arrRet[0]['id'];
						*/
						break;
					}
					case 'category_id':
					{
						$arrItem[$k] = $c[$k];
// 						$arrItem[$k] = 0;
// 						$arrItem['theme_id'] = 0;
// 						if ($c[$k] > 1000)
// 							$arrItem['theme_id'] = $c[$k];
// 						else
// 							$arrItem[$k] = $c[$k];
 						break;
					}
					case 'brand_id':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'switch_property':
					{
						$arrItem[$k] = $c[$k];
						break;
					}
					case 'images':
					{
						if (!isset($arrImages[$group_code]))
						{
							if (isset($c[$k]))
								$arrImages[$group_code] = explode(',', $c[$k]);
						}
						break;
					}
				}
			}
// print('<pre>');
//print("<pre>");
//var_dump($arrImages);
//print("</pre>");
//exit;
Log::debug("byfile start.");
Log::debug(print_r($arrImages, true));
			if (!isset($arrItems[$group_code]))
			{
				$g_code = $arrItem['group_code'];
				$sql = "SELECT product_id from dtb_products where group_code = '{$g_code}' and del_flg = 0 and shop_id = {$arrItem['shop_id']}";
				$arrRet = DB::query($sql)->execute()->as_array();
//print("<pre>");
//var_dump($arrRet);
//print("</pre>");
//exit;
Log::debug("group_code");
Log::debug(print_r($arrRet, true));
				if (count($arrRet) > 0)
				{
					if ($arrItem['product_id'] != '')
						$product_id = $arrItem['product_id'];
					else
						$product_id = $arrRet[0]['product_id'];
//					$product_id = $arrRet[0]['product_id'];
//				Log::debug("test:".$product_id);
					$update = true;
//var_dump($arrRet);
//var_dump("<br>".$g_code."<br>");
//var_dump($product_id."<br>");
//var_dump($product_id."<br>");
//exit;
				}
				else
				{
					unset($arrItem['product_id']);
			 		$query = DB::insert('dtb_products');
			 		$query->set($arrItem);
					$arrRet = $query->execute();
					$product_id = $arrRet[0];
					$update = false;
				}

				$update_product[] = $product_id;
				$c['product_id'] = $product_id;

				$arrItems[$group_code][] = $c;
 //var_dump('add:'.$group_code.'::'.$c['product_code']);
			}
			else
			{
				$c['product_id'] = $product_id;
				$arrItems[$group_code][] = $c;
 //var_dump('add2:'.$group_code.'::'.$c['product_code']);
			}
		}
// print('<pre>');
// var_dump($arrImages);
// print('</pre>');
// exit;
if ($update)
Log::debug("update is true.");
else
Log::debug("update is false.");

		foreach($arrItems as $group_code=>$cs)
		{
			foreach($cs as $c)
			{
				$product_id = $c['product_id'];
				Log::debug($product_id);
				$sql = "SELECT * FROM dtb_brand WHERE id = '{$c['brand_id']}' and shop_url = '{$shop}'";
				$query_s = DB::query($sql);
				$arrRet = $query_s->execute()->as_array();
				$brand_name = '';
				$brand_kana = '';
				if (count($arrRet) > 0)
				{
					$brand_name = $arrRet[0]['name'];
					$brand_kana = $arrRet[0]['name_kana'];
				}

				//タグ
//				$arrRet = $insert->execute();
// 				if ($brand_name != '')
// 				{
// 					$arrTags = array();
// 					$arrTags['tag'] = $brand_name;
// 	 				$arrTags['dtb_products_product_id'] = $product_id;
// 					$query = DB::insert('dtb_product_tag');
// 			 		$query->set($arrTags);
// 					$arrRet = $query->execute();
// 				}
// 				$arrTags = array();
// 				$arrTags['dtb_products_product_id'] = $product_id;
// 				$arrTags['tag'] = htmlspecialchars($c['name'],ENT_QUOTES);
// print('<pre>');
// var_dump($update);
// print('</pre>');
// exit;

if ($update)
Log::debug("update is true.");
else
Log::debug("update is false.");

				if (!$update)
				{
	Log::debug("dtb_images start");
					$sql2 = "SELECT * from dtb_images where dtb_products_product_id = '{$product_id}'";
					$arrRet9 = DB::query($sql2)->execute()->as_array();
	Log::debug(count($arrRet9));
					if (count($arrRet9) > 0)
					{
						$sqldel = "DELETE from dtb_images where dtb_products_product_id = '{$product_id}'";
						DB::query($sqldel)->execute();
	
	Log::debug("delete.");
	Log::debug($group_code);
	//Log::debug($arrImages[$group_code]);
	
						if (isset($arrImages[$group_code]))
						{
							$first = 1;
							foreach($arrImages[$group_code] as $path)
							{
								$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
								$query = DB::query($sql);
								$arrRet = $query->execute();
								$first++;
							}
						}
					}
					else
					{
	Log::debug("new.");
	Log::debug($group_code);
	//Log::debug($arrImages[$group_code]);
						//イメージ
						if (isset($arrImages[$group_code]))
						{
							$first = 1;
							foreach($arrImages[$group_code] as $path)
							{
								$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
								$query = DB::query($sql);
								$arrRet = $query->execute();
								$first++;
							}
						}
					}
					if ($shop == 'gentedimare')
					{
						$tags = explode(',', $c['tag']);
						
						DB::delete('dtb_product_tag')->where('dtb_products_product_id','=',$product_id)->execute();
						
						foreach($tags as $tag)
						{
							$arrTags = array();
							$arrTags['tag'] = $tag;
			 				$arrTags['dtb_products_product_id'] = $product_id;
							$query = DB::insert('dtb_product_tag');
					 		$query->set($arrTags);
							$arrRet = $query->execute();
						}
					}
				}
				
Log::debug("dtb_images end");
Log::debug("update is ".$update);
				if (!$update)
				{
					if ($shop != 'gentedimare')
					{
						$sql = "INSERT INTO dtb_product_tag (dtb_products_product_id, tag) SELECT product_id, name from dtb_products where product_id = ".$product_id;
						$query = DB::query($sql);
						$arrRet = $query->execute();
						Log::debug(DB::last_query());
						if ($brand_name != '')
						{
							if ($shop == 'biglietta')
							{
								$arrTags = array();
								$arrTags['tag'] = $brand_name;
				 				$arrTags['dtb_products_product_id'] = $product_id;
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = 'レディース';
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = 'ビリエッタ';
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = 'グジ';
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = $shop;
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = 'guji';
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
	
								$arrTags['tag'] = $brand_kana;
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
							}
							else
							{
								$arrTags = array();
								$arrTags['tag'] = $brand_name;
				 				$arrTags['dtb_products_product_id'] = $product_id;
								$query = DB::insert('dtb_product_tag');
						 		$query->set($arrTags);
								$arrRet = $query->execute();
							}
						}
					}

					//金額
					$arrPrice = array();
					if ($c['price01'] == 'NULL' || $c['price01'] == '')
						$c['price01'] = 0;
					$arrPrice['price01'] = $c['price01'];
					if ($c['price02'] == 'NULL' || $c['price02'] == '')
						$c['price02'] = 0;
					$arrPrice['price02'] = $c['price02'];
	 				if (isset($c['cost_price']))
	 					$c['cost_price'] = $c['cost_price'];
	 				else
	 					$c['cost_price'] = 0;
					$arrPrice['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_price');
			 		$query->set($arrPrice);
					$arrRet = $query->execute();

					//カテゴリ
					$arrCategory = array();
					$arrCategory['category_id'] = $c['category_id'];
					$arrCategory['product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_category');
			 		$query->set($arrCategory);
					$arrRet = $query->execute();

//					イメージ
//					if (isset($arrImages[$group_code]))
//					{
//						$first = 1;
//						foreach($arrImages[$group_code] as $path)
//						{
//							$sql = "INSERT INTO dtb_images (path, first, dtb_products_product_id) values ('{$path}', '{$first}', '{$product_id}')";
//							$query = DB::query($sql);
//							$arrRet = $query->execute();
//							$first++;
//						}
//					}
				}
				else
				{
Log::debug("update!");
					continue;

					$sql = "SELECT id from dtb_product_price where dtb_products_product_id = '{$product_id}'";
					$arrRet = DB::query($sql)->execute()->as_array();
					if (count($arrRet) > 0)
					{
						DB::delete('dtb_product_price')->where('dtb_products_product_id','=',$product_id)->execute();
					}
					//金額
					$arrPrice = array();
					if ($c['price01'] == 'NULL' || $c['price01'] == '')
						$c['price01'] = 0;
					$arrPrice['price01'] = $c['price01'];
					if ($c['price02'] == 'NULL' || $c['price02'] == '')
						$c['price02'] = 0;
					$arrPrice['price02'] = $c['price02'];
	 				if (isset($c['cost_price']) && $c['cost_price'] != '')
	 					$c['cost_price'] = $c['cost_price'];
	 				else
	 					$c['cost_price'] = 0;
					$arrPrice['cost_price'] = $c['cost_price'];
					$arrPrice['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_price');
			 		$query->set($arrPrice);
					$arrRet = $query->execute();

					$arrProduct = array();
					foreach($keys as $kk)
					{
						if ($kk != 'product_id' && $kk != 'images')
						{
							if (isset($cs[0][$kk]) && $cs[0][$kk] != '')
							{
								if ($cs[0][$kk] != 'NULL')
									$arrProduct[$kk] = htmlspecialchars_decode($cs[0][$kk]);
							}
						}
					}
//					var_dump($keys);
//					var_dump($arrProduct);exit;

					$tags = explode(',', $c['tag']);
					
					DB::delete('dtb_product_tag')->where('dtb_products_product_id','=',$product_id)->execute();
					
					foreach($tags as $tag)
					{
						$arrTags = array();
						$arrTags['tag'] = $tag;
		 				$arrTags['dtb_products_product_id'] = $product_id;
						$query = DB::insert('dtb_product_tag');
				 		$query->set($arrTags);
						$arrRet = $query->execute();
					}
					
		 			$query = DB::update('dtb_products');
		 			$query->where('product_id','=',$product_id);
			 		$arrRet = $query->set($arrProduct)->execute();
				}

				//sku
				$sql = "SELECT id from dtb_product_sku where product_code = '{$c['product_code']}'";
				$arrRet = DB::query($sql)->execute()->as_array();
				$ret_del = 0;
				if (count($arrRet) > 0)
				{
					$ret_del = DB::delete('dtb_product_sku')->where('dtb_products_product_id','=',$product_id)->and_where('product_code', '=', $c['product_code'])->execute();
				}
// 				if (count($arrRet) == 0)
// 				{
					$arrProduct = array();
					if ($c['switch_property'] == '1' && $ret_del == 0)
					{
						$arrProduct['color_name'] = $c['size_name'];
						$arrProduct['size_name'] = $c['color_name'];
						$arrProduct['color_code'] = $c['size_code'];
						$arrProduct['size_code'] = $c['color_code'];
					}
					else
					{
						$arrProduct['color_name'] = $c['color_name'];
						$arrProduct['size_name'] = $c['size_name'];
						$arrProduct['color_code'] = $c['color_code'];
						$arrProduct['size_code'] = $c['size_code'];
					}
					if ($c['stock'] == 'NULL')
						$c['stock'] = 0;
					$arrProduct['stock'] = $c['stock'];
					if ($shop == 'brshop')
						$arrProduct['stock_type'] = 1;
					else if ($shop == 'guji' || $shop == 'ring' || $shop == 'biglietta')
						$arrProduct['stock_type'] = 2;
					else if ($shop == 'sugawaraltd')
						$arrProduct['stock_type'] = 3;
					else
						$arrProduct['stock_type'] = 0;
					$arrProduct['product_code'] = $c['product_code'];
					if (isset($c['attribute']))
						$arrProduct['attribute'] = $c['attribute'];
					$arrProduct['dtb_products_product_id'] = $product_id;
		 			$query = DB::insert('dtb_product_sku');
			 		$query->set($arrProduct);
					$arrRet = $query->execute();
//				}

				$arrStatus = array();
				if ($c['status_flg'] == '')
					$c['status_flg'] = 1;
				$arrStatus['status_flg'] = $c['status_flg'];
				$arrStatus['product_id'] = $product_id;

				DB::delete('dtb_product_status')->where('product_id','=',$product_id)->execute();
				
	 			$query = DB::insert('dtb_product_status');
		 		$query->set($arrStatus);
				$arrRet = $query->execute();	
			}
		}

		if ($shop == 'brshop')
		{
			Tag_Smaregi::push_smaregi($shop, $update_product);
		}

//		$this->arrResult['error'] = "登録完了しました。";

//		$this->tpl = 'smarty/admin/product/upload.tpl';
		return true;

	}

	function action_delete() {

		$product_id = Input::param('product_id', 0);

		if( $product_id != 0 ) {
			$result = DB::update('dtb_products')->value('del_flg', 1)->value('update_date', date('Y-m-d H:i:s'))->where('product_id', $product_id)->execute();
		}

		Response::redirect('/admin/product');
	}

	function action_del() {

		$shop_id = "";
		if( isset($_SESSION['shop_id'])) {
			$shop_id = $_SESSION['shop_id'];
		}
		$shop = Tag_Session::getShop();

		$where = " where A.del_flg = 0 ";

		$post = Tag_Session::get('search_product');
		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (strpos($post['search_product_id'], '~') > 0)
						{
							$ids = explode('~', $post['search_product_id']);
							if(is_array($ids) && count($ids) == 2)
							{
								if ($where != "")
									$where .= " AND ";
								$where .= " (A.product_id >= ".$ids[0]." and "." A.product_id <= ".$ids[1].") ";
							}
							else
								break;
							
						}
						else if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						else
						{
							if ($where != "")
								$where .= " AND ";
							$where .= " A.product_id = ".$post['search_product_id'];
						}
					}
					break;
				}
				case 'search_product_code':
				{
					if ($post['search_product_code'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " B.product_code like '%".$post['search_product_code']."%' ";
					}
					break;
				}
				case 'search_product_statuses':
				{
					if (count($post['search_product_statuses']) && $where != "")
						$where .= " AND ";

					$cnt = 0;
					foreach($post['search_product_statuses'] as $s)
					{
						if ($cnt == 0)
							$where .= " ( ";
						else
							$where .= " OR ";
						$where .= " A.status = ".$s;
						$cnt++;
					}
					if ($cnt != 0)
						$where .= " ) ";
					break;
				}
				case 'search_name':
				{
					if ($post['search_name'] != '')
					{
						if ($where != "")
							$where .= " AND ";
						$where .= " A.name like '%".$post['search_name']."%' ";
					}
					break;
				}
				case 'search_group_code':
				{
					if ($post['search_group_code'] != '')
					{
// 						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
// 						{
// 							break;
// 						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '%".$post['search_group_code']."%' ";
					}
					break;
				}
				case 'search_category_id':
				{
					if ($post['search_category_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_category_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.category_id = '".$post['search_category_id']."' ";
					}
					break;
				}
				case 'search_stock':
				{
					if ($post['search_stock'] != 0)
					{
						if ($where != "")
							$where .= " AND ";
						if ($post['search_stock'] == '1')
							$where .= " B.stock <> 0 ";
						else
							$where .= " B.stock = 0 ";

						break;
					}
				}
			}
		}

		if($shop_id != "") {
			$where .= " and A.shop_id = ".$shop_id;
		}

		$sql = "update dtb_products as A set del_flg = 1, update_date = CURRENT_TIMESTAMP() ";
		$sql .= $where;
		$query = DB::query($sql)->execute();
		
//		var_dump($sql);
//		exit;
		
//		$arrData = $query->execute()->as_array();

//		if( $product_id != 0 ) {
//			$result = DB::update('dtb_products')->value('del_flg', 1)->value('update_date', date('Y-m-d H:i:s'))->where('product_id', $product_id)->execute();
//		}

		Response::redirect('/admin/product');
	}

	function action_brand2()
	{
		$this->tpl = 'smarty/admin/product/brand.tpl';
		return $this->view;
	}

	function action_copy()
	{
		Tag_Session::delete('BACK_DATA2');
		Tag_Session::delete('mode2');

		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$arrResult['entry'] = $post_id;
		$this->tpl = 'smarty/admin/product/product_copy.tpl';

		if (Input::method() == "GET")
		{
			$post = Tag_Session::get('search_product2');

			if ($post == null)
			{
				$post = Input::param();
				Tag_Session::set('search_product2', $post);
			}
		}
		else
		{
			$post = Input::param();
			Tag_Session::set('search_product2', $post);
		}

		$page = Input::param('page','1');

//		var_dump($post);

		$shop_id = Tag_Session::get('shop_id');
		$shop = Tag_Session::getShop();
		$where = '';
		if ($shop_id != '')
			$where = "C.login_id = '{$shop}' and A.org_shop != C.login_id";

		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (strpos($post['search_product_id'], '~') > 0)
						{
							$ids = explode('~', $post['search_product_id']);
							if(is_array($ids) && count($ids) == 2)
							{
								if ($where != "")
									$where .= " AND ";
								$where .= " (A.product_id >= ".$ids[0]." and "." A.product_id <= ".$ids[1].") ";
								$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '30');
							}
							else
								break;
							
						}
						else if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						else
						{
							if ($where != "")
								$where .= " AND ";
							$where .= " A.product_id = ".$post['search_product_id'];
							$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '30');
						}
					}
					break;
				}
			}
		}

		$arrData = Tag_Item::get_allitems2($where, 'update_date DESC, group_code', $page, 25);
		$this->setData($arrData);

		$arrRet = DB::query("SELECT FOUND_ROWS()")->execute();
		$count = $arrRet[0]['FOUND_ROWS()'];

//		$count = count(Tag_Item::get_allitems2($where, 'update_date DESC', 1, 0));
//		var_dump(Tag_Item::get_allitems($where, 'update_date DESC', 1, 0));
		$this->arrResult['max'] = ceil($count / 25);
		$this->arrResult['count'] = $count;
		$this->arrResult['page'] = $page;

			$pc = 5;
			if ($page - $pc <= 0)
				$this->arrResult['pstart'] = 1;
			else
				$this->arrResult['pstart'] = $page - $pc;
			if ($page + $pc > $this->arrResult['max'])
				$this->arrResult['pend'] = $this->arrResult['max'];
			else
				$this->arrResult['pend'] = $page + $pc;

//		$arrData = Tag_Item::get_allitems2($where, 'update_date DESC, group_code', $page, 25);
//		$this->setData($arrData);
//		var_dump(DB::last_query());


		$this->tpl = 'smarty/admin/product/product_copy.tpl';
		return $this->view;
	}

	function action_copydelete() {

		$product_id = Input::param('product_id', 0);
//var_dump($product_id);
		if( $product_id != 0 ) {
			$result = DB::delete('dtb_product_copy')->where('product_id', $product_id)->and_where('shop_url', Tag_Session::getShop())->execute();
		}

		Response::redirect('/admin/product/copy');
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

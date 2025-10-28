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
class Controller_Admin_Campaign extends ControllerAdmin
{
	public function action_index()
	{
		$post = Input::param();
//		var_dump($post);
		


		$this->tpl = 'smarty/admin/order/index.tpl';
		return $this->view;
	}

	/**
	 * PRODUCT一覧 取得
	 *
	 * @return unknown
	 */
	public function action_index2()
	{
		$debug = array();
		$arrResult = array();

		$post_id	= Input::param('entry', 0);
		$arrResult['entry'] = $post_id;
		$this->tpl = 'smarty/admin/product/index.tpl';
		
// 		$view = View::forge('layout');
//		$this->view->header = View_Smarty::forge( $tpl, $arrResult, false );

		$post = Input::param();

//		var_dump($post);
		
		$where = "";
		$order = " create_date DESC ";


		foreach($post as $k=>$v)
		{
			switch($k)
			{
				case 'search_product_id':
				{
					if ($post['search_product_id'] != '')
					{
						if (!preg_match("/^[0-9]+$/", $post['search_product_id']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.product_id = ".$post['search_product_id'];
						$this->setFormParams('arrForm', 'search_product_id', $post['search_product_id'], '10');
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
						$where .= " D.product_code like '".$post['search_product_code']."%' ";
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
						if (!preg_match("/^[0-9]+$/", $post['search_group_code']))
						{
							break;
						}
						if ($where != "")
							$where .= " AND ";
						$where .= " A.group_code like '".$post['search_group_code']."%' ";
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
						$where .= " G.category_id = '".$post['search_category_id']."' ";
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



		$arrData = Tag_Item::get_allitems($where);
		$this->setData($arrData);

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

		$this->setFormParams('arrForm','product_id', '', '');
		$this->setFormParams('arrForm','product_class_id', '', '');
		$this->setFormParams('arrForm','smaregi_product_id', '', '');
		$this->setFormParams('arrForm','select_recommend_no', '', '');
		$this->setFormParams('arrForm','wear_shop_id', '', '');
		$this->setFormParams('arrForm','recomment_shop_id', '', '');
		$this->setFormParams('arrForm','search_smaregi_product_id', '', '');
		$this->setFormParams('arrForm','search_product_statuses', '', '');
		$this->setFormParams('arrForm','search_category_id', '', '');
		$this->setFormParams('arrForm','search_product_code', '', '');
		$this->setFormParams('arrForm','search_name', '', '');
		$this->setFormParams('arrForm','search_group_code', '', '');
		$this->setFormParams('arrForm','search_stock', '', '');

		$this->setFormParams('arrErr','search_startyear', '', '');
		$this->setFormParams('arrErr','search_startmonth', '', '');
		$this->setFormParams('arrErr','search_startday', '', '');
		
		$arrCatList = $this->setItemParam(Tag_Item::get_categories('parent_category_id <> 0'), 'category_id', 'name');
		$this->arrResult['arrCatList'] = $arrCatList;

//		var_dump(Tag_Campaign::get_uniqcode());

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

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
class Controller_Admin_Basis extends ControllerAdmin
{
	public function action_index()
	{
// 		$post = Input::param();
//
// 		$arrTemp = Tag_Shop::get_shoplist();
// 		$this->arrResult['arrShop'] = $arrTemp;
//
//
// 		$this->tpl = 'smarty/admin/basis/index.tpl';
		return $this->action_point();
	}

	public function action_point()
	{
		if (Input::post())
		{
			$post = Input::post();
			Tag_Basis::set_table($post['arrForm']);
		}

		$tbl_name = "dtb_basis";
		$arrTemp = Tag_Basis::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
		}

		$arrRet = Tag_Basis::get_basis($arrColumns);
		$this->arrResult['arrForm'] = $arrRet[0];
//		var_dump($this->arrResult);
		//exit;
		$this->tpl = 'smarty/admin/basis/point.tpl';
		return $this->view;
	}

	public function action_campaign()
	{
		$tbl_name = "dtb_campaign";
		$id = Input::param('id', '');

		if (Input::post())
		{
			$post = Input::post();
			if ($post['mode'] == 'confirm')
			{
				$arrPost = $post['arrForm'];
				if ($arrPost['code'] == '')
					$arrPost['code'] = Tag_Basis::get_uniqcode();
				if ($arrPost['id'] == '')
					unset($arrPost['id']);
				$arrPost['del_flg'] = '0';
				$id = '';
				if (@$arrPost['not_shops'] != '')
				{
					$arrPost['not_shops'] = implode(',', @$arrPost['not_shops']);
				}
			}
			else if ($post['mode'] == 'delete')
			{
				$arrPost = $post['arrForm'];
				$arrPost['del_flg'] = 1;
				$id = '';
			}
//		print('<pre>');
//		var_dump($arrPost);
//		print('</pre>');
//		exit;
			Tag_Basis::set_table($arrPost, $tbl_name);
		}

		$arrTemp = Tag_Basis::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
			$this->arrResult['arrForm'][$column['Field']] = '';
		}

		$where = '';
		if ($id != '')
		{
			$where = array("id"=>$id);
			$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, $where);
			$this->arrResult['arrForm'] = $arrRet[0];
		}
		$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, array('del_flg'=>0));

//		print('<pre>');
//		var_dump($this->arrResult['arrForm']);
//		print('</pre>');
		
		$arrShops = Tag_Shop::get_shopdetail('shop_status >= 1');
		$this->arrResult['shops'] = $arrShops;

		$arrTemp = array();
		foreach($arrShops as $shop)
		{
			$arrTemp[$shop['id']] = 0;
		}
		
		if ($this->arrResult['arrForm']['not_shops'] != '')
		{
			$ps = explode(',', $this->arrResult['arrForm']['not_shops']);
			if (is_array($ps))
			{
				foreach($ps as $p)
				{
					$arrTemp[$p] = 1;
				}
			}
			else
				$arrTemp[$ps] = 1;
		}
		
		$this->arrResult['notshops'] = $arrTemp;
				
		$this->arrResult['arrCampaign'] = $arrRet;

		$this->tpl = 'smarty/admin/basis/campaign.tpl';
		return $this->view;
	}

	public function action_campaign_none()
	{
		$tbl_name = "dtb_campaign";
		$id = Input::param('id', '');

		if (Input::post())
		{
			$post = Input::post();
			if ($post['mode'] == 'confirm')
			{
				$arrPost = $post['arrForm'];
				if ($arrPost['code'] == '')
					$arrPost['code'] = Tag_Basis::get_uniqcode();
				if ($arrPost['id'] == '')
					unset($arrPost['id']);
				$arrPost['del_flg'] = '0';
				$id = '';
				if ($arrPost['not_shops'] != '')
				{
					$arrPost['not_shops'] = implode(',', $arrPost['not_shops']);
				}
			}
			else if ($post['mode'] == 'delete')
			{
				$arrPost = $post['arrForm'];
				$arrPost['del_flg'] = 1;
				$id = '';
			}
//		print('<pre>');
//		var_dump($arrPost);
//		print('</pre>');
//		exit;
			Tag_Basis::set_table($arrPost, $tbl_name);
		}

		$arrTemp = Tag_Basis::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
			$this->arrResult['arrForm'][$column['Field']] = '';
		}

		$where = '';
		if ($id != '')
		{
			$where = array("id"=>$id);
			$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, $where);
			$this->arrResult['arrForm'] = $arrRet[0];
		}
		$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, array('del_flg'=>0));

//		print('<pre>');
//		var_dump($this->arrResult['arrForm']);
//		print('</pre>');
		
		$arrShops = Tag_Shop::get_shopdetail('shop_status >= 1');
		$this->arrResult['shops'] = $arrShops;

		$arrTemp = array();
		foreach($arrShops as $shop)
		{
			$arrTemp[$shop['id']] = 0;
		}
		
		if ($this->arrResult['arrForm']['not_shops'] != '')
		{
			$ps = explode(',', $this->arrResult['arrForm']['not_shops']);
			if (is_array($ps))
			{
				foreach($ps as $p)
				{
					$arrTemp[$p] = 1;
				}
			}
			else
				$arrTemp[$ps] = 1;
		}
		
		$this->arrResult['notshops'] = $arrTemp;
				
		$this->arrResult['arrCampaign'] = $arrRet;
		
		$details = array();
		$k = array();
		if ($this->arrResult['arrForm']['not_products'] != '')
		{
			$products = explode(',', $this->arrResult['arrForm']['not_products']);
			
			foreach($products as $p)
			{
				$d = Tag_Item::get_detail($p, true);
				if (count($d) > 0)
					$details[$p] = $d;//Tag_Item::get_detail($p, true);
			}
		}
		
		$k = array_column($details, 'shop_id');
		@array_multisort($k, SORT_ASC, $details);

		$this->arrResult['details'] = $details;

		$this->tpl = 'smarty/admin/basis/campaign-none.tpl';
		return $this->view;
	}

	public function before()
	{
		parent::before();

		$this->arrResult['arrTypes'] = array('0'=>'会員専用', '1'=>'会員ランク用', '2'=>'一般用');
		$this->arrResult['arrDiscountTypes'] = array('0'=>'値引き', '1'=>'値引き（％）', '2'=>'対象商品無料');
		$arrTemp = Tag_Master::get_master('mtb_customer_rank');
		$arrCustomerRank = array();
		foreach($arrTemp as $t)
		{
			$arrCustomerRank[$t['id']] = $t['name'];
		}
		$this->arrResult['arrCustomerRank'] = $arrCustomerRank;
	}


	/**
	 * 配送先登録画面
	 */
	public function action_delivery()
	{
		$deliv_id = 1;		// ヤマト固定のため

		$this->arrResult["arrErr"] = "";

		if (Input::post())
		{
			$post = Input::post();
			$arrDelivTime = $post['deliv_time'];
			$arrDelivFee = $post['deliv_fee'];

			try {
				DB::start_transaction();

				DB::delete('dtb_delivtime')->where('deliv_id', $deliv_id)->execute();
				$time_id =1;
				foreach ( $arrDelivTime as $delivTime ) {
					if( $delivTime == "") {
						continue;
					}
					$arrInsert = array();
					$arrInsert['deliv_id'] = $deliv_id;
					$arrInsert['time_id'] = $time_id;
					$arrInsert['deliv_time'] = $delivTime;

					DB::insert('dtb_delivtime')->set($arrInsert)->execute();
					$time_id++;
				}

				DB::delete('dtb_delivfee')->where('deliv_id', $deliv_id)->execute();
				$fee_id = 1;
				foreach ( $arrDelivFee as $pref => $fee ) {
					$arrInsert = array();
					$arrInsert['deliv_id'] = $deliv_id;
					$arrInsert['fee_id'] = $fee_id;
					$arrInsert['fee'] = $fee;
					$arrInsert['pref'] = $pref;

					DB::insert('dtb_delivfee')->set($arrInsert)->execute();
					$fee_id++;
				}

				DB::commit_transaction();

			} catch ( Exception $e ) {
				DB::rollback_transaction();
			}
		}

		$this->arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrDelivTime"] = DB::select()->from('dtb_delivtime')->where('deliv_id', $deliv_id)->order_by('time_id', 'ASC')->execute()->as_array();
		$this->arrResult["arrDelivFee"]  = DB::select()->from('dtb_delivfee')->where('deliv_id', $deliv_id)->order_by('pref', 'ASC')->execute()->as_array();

		$this->arrResult["arrForm"]['deliv_id'] = $deliv_id;

		$this->tpl = 'smarty/admin/basis/delivery_input.tpl';
		return $this->view;
	}

	public function action_sales()
	{
		$tbl_name = "dtb_sales";
		$id = Input::param('id', '');

		if (Input::post())
		{
			$post = Input::post();
			if ($post['mode'] == 'confirm')
			{
				$arrPost = $post['arrForm'];
//				if ($arrPost['code'] == '')
//					$arrPost['code'] = Tag_Basis::get_uniqcode();
//				if ($arrPost['id'] == '')
//					unset($arrPost['id']);
//				$arrPost['del_flg'] = '0';
//				$id = '';
//				if ($arrPost['not_shops'] != '')
//				{
//					$arrPost['not_shops'] = implode(',', $arrPost['not_shops']);
//				}
			}
//		print('<pre>');
//		var_dump($arrPost);
//		print('</pre>');
//		exit;
			Tag_Basis::set_table($arrPost, $tbl_name);
		}

		$arrTemp = Tag_Basis::get_columns($tbl_name);
		$arrColumns = array();
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
			$this->arrResult['arrErr'][$column['Field']] = '';
			$this->arrResult['arrForm'][$column['Field']] = '';
		}

//		$where = '';
//		if ($id != '')
//		{
//			$where = array("id"=>$id);
//			$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, $where);
//			$this->arrResult['arrForm'] = $arrRet[0];
//		}
		$arrRet = Tag_Basis::get_basis($arrColumns, $tbl_name, array());

//		var_dump($arrTemp);
//		var_dump($arrRet);
//		var_dump($this->arrResult['arrForm']);
//		
		$this->arrResult['arrForm'] = $arrRet[0];
//		print('<pre>');
//		var_dump($this->arrResult['arrForm']);
//		print('</pre>');

		$this->tpl = 'smarty/admin/basis/sales.tpl';
		return $this->view;
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

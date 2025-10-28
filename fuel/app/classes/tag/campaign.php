<?php
class Tag_Campaign
{
	function __construct()
	{
	}

	public static function get_uniqcode()
	{
		$id = uniqid(mt_rand(),true);
	    $id = md5(sha1($id));
		$id = substr(hexdec($id), 0, 15);
		$id = substr($id, 2,12);
		
		return $id;
	}

	public static function get_check($customer_id, $coupon, $price = 0)
	{
		$table_name = 'dtb_campaign';
		if ($price == -1)
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 ";
		else
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 AND use_price <= ".$price." ";
    	$now = date('Y-m-d H:i:s');
    	
    	if ($customer_id != '' && $customer_id != '0')
    	{
	    	$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
	    	$rank = $arrCustomer['customer_rank'];
	    	//会員専用
    		$where = " AND campaign_type = 0 AND code = '{$coupon}' AND (customer_ids like '%{$customer_id}%') ";
    		$where2 = " AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 1 AND code = '{$coupon}' AND (customer_rank = '{$rank}') ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
    	else
    	{
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
    		$where2 = " AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
		return array();
	}
	public static function get_check2($customer_id, $coupon, $price = 0)
	{
		$table_name = 'dtb_campaign';
		if ($price == -1)
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 ";
		else
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND use_price <= ".$price." ";
    	
    	if ($customer_id != '')
    	{
	    	$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
	    	if ($customer_id > 0)
		    	$rank = $arrCustomer['customer_rank'];
		    else
		    	$rank = 0;
	    	//会員専用
    		$where = " AND campaign_type = 0 AND code = '{$coupon}' AND (customer_ids like '%{$customer_id}%') ";
    		$where2 = "";//" AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 1 AND code = '{$coupon}' AND (customer_rank = '{$rank}') ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
    	else
    	{
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
    		$where2 = "";//" AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
		return array();
	}

	public static function get_check3($customer_id, $email, $coupon)
	{
		$table_name = 'dtb_campaign';
		$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 AND code = '{$coupon}' ";

		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
		{
			if ($arrRet[0]['use_onece'] == '1')
			{
				$table_name = 'dtb_buylog';
				$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND customer_id = {$customer_id} AND mail = '{$email}' and coupon_code = '{$coupon}' ";
		
				$query = DB::query($sql);
				$arrRet = $query->execute()->as_array();
				if (count($arrRet) > 0)
				{
					return false;
				}
			}
		}
		return true;
	}
	
	public static function get_check4($customer_id, $coupon, $price = 0, $cartinfo = '')
	{
		$table_name = 'dtb_campaign';
		if ($price == -1)
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 ";
		else
			$sql = "SELECT * FROM {$table_name} WHERE del_flg = 0 AND status = 1 AND use_price <= ".$price." ";
    	$now = date('Y-m-d H:i:s');
    	
    	if ($customer_id != '')
    	{
	    	$arrCustomer = Tag_CustomerInfo::get_customer($customer_id);
	    	$rank = $arrCustomer['customer_rank'];
	    	//会員専用
    		$where = " AND campaign_type = 0 AND code = '{$coupon}' AND (customer_ids like '%{$customer_id}%') ";
    		$where2 = " AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 1 AND code = '{$coupon}' AND (customer_rank = '{$rank}') ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
    	else
    	{
			$where = " AND campaign_type = 2 AND code = '{$coupon}' ";
    		$where2 = " AND ((start_date <= '{$now}' AND end_date >= '{$now}') OR (start_date <= '{$now}' AND end_date is NULL) OR (start_date is NULL AND end_date <= '{$now}') OR (start_date is NULL AND end_date is NULL)) ";
			$query = DB::query($sql.$where.$where2);
			$arrRet = $query->execute()->as_array();
			if (count($arrRet) > 0)
			{
				return $arrRet;
			}
    	}
		return array();
	}

	public static function get_campaign($column)
	{
		$table_name = 'dtb_campaign';
		$arrRet = DB::select_array($column)->from($table_name)->execute()->as_array();
		return $arrRet;
	}

	public static function set_campaign($column)
	{
		$table_name = 'dtb_campaign';
		$query = DB::insert($table_name);
		$query->set($column);
		list($insert_id, $rows_affected) = $query->execute();
		
		return $insert_id;
	}

	public static function update_campaign($column, $where = array())
	{
		$table_name = 'dtb_campaign';
		$query = DB::update($table_name);
		$query->set($column);
		
		if (count($where) > 0)
			$query->where($where);

		$arrRet = $query->execute();
		
		return $arrRet;
	}
}
?>
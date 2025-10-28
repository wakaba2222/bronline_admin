<?php
class Tag_CustomerInfo
{
	function __construct()
	{
	}

	public static function get_purchase_amount($customer_id)
	{
			$arrCustomer = DB::select(
					'dtb_customer.*',
					array('mtb_customer_rank.name', 'rank_name'),
					'dtb_stage.point_rate',
					'dtb_point.point'
					)->from('dtb_customer')
					->join('dtb_point', 'left')->on('dtb_customer.customer_id', '=', 'dtb_point.customer_id')
					->join('dtb_stage', 'left')->on('dtb_customer.customer_rank', '=', 'dtb_stage.stage_rank')
					->join('mtb_customer_rank', 'left')->on('dtb_customer.customer_rank', '=', 'mtb_customer_rank.id')
					->where('dtb_customer.customer_id', $customer_id)->execute()->as_array();

		$y = date('Y') - 1;
		$format = $y.'-m-d 00:00:00';
		$before = date($format, strtotime($arrCustomer[0]['create_date']));
		$after = date('Y-m-d 00:00:00', strtotime($before." +1 year"));
		
		if (date('Ymd',strtotime($after)) < date('Ymd'))
		{
			$y = date('Y');
			$format = $y.'-m-d 00:00:00';
			$before = date($format, strtotime($arrCustomer[0]['create_date']));
			$after = date('Y-m-d 00:00:00', strtotime($before." +1 year"));
		}
		
//var_dump(date('Ymd',strtotime($format)));
$prev_before = date('Y-m-d 00:00:00', strtotime($before." -1 year"));
//var_dump($prev_before);
//var_dump($before);
//		$this->arrResult['payment_total_prev'] = DB::query("select SUM(payment_total) as total from (select SUM(payment_total) as payment_total,customer_id from dtb_order where status = 5 and del_flg = 0 and create_date >= '{$prev_before}' and create_date <= '{$before}' group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where status = 5 and del_flg = 0 group by customer_id) as A where customer_id = ".$customer_id)->execute()->as_array();
//var_dump($this->arrResult['payment_total_prev']);
//		$before = $arrCustomer[0]['create_date'];
		$arrRet = DB::query("select SUM(payment_total) as total from (select SUM(payment_total) as payment_total,customer_id from dtb_order where status = 5 and del_flg = 0 and create_date >= '{$before}' and create_date <= '{$after}' group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where status = 5 and del_flg = 0 and create_date >= '{$before}' and create_date <= '{$after}' group by customer_id) as A where customer_id = ".$customer_id)->execute()->as_array();
//		return $total;
//var_dump($arrRet);
/*
		$sql = "SELECT SUM(total) as total FROM dtb_order as A ";
		$where = "WHERE A.customer_id = {$customer_id} and A.del_flg = 0 and A.status <> 3 and A.status <> 7";
		
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
*/
		if (count($arrRet) > 0)
			return $arrRet[0]['total'];
		else
			return 0;
	}
	public static function get_last_by($customer_id)
	{
		$sql = "SELECT last_buy_date from dtb_customer where customer_id = {$customer_id} and del_flg = 0";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();

		if (count($arrRet) > 0)
			return $arrRet[0]['last_buy_date'];

		return '';
	}

	public static function get_last_order($customer_id)
	{
		$sql = "SELECT create_date from dtb_order where customer_id = {$customer_id} and del_flg = 0 and status <> 3 and status <> 7 order by create_date desc";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();

		if (count($arrRet) > 0)
			return $arrRet[0]['create_date'];

		return '';
	}

	public static function set_use_point($customer_id, $point)
	{
		$sql = "select point from dtb_point where customer_id = {$customer_id}";
		$arrRet = DB::query($sql)->execute()->as_array();
		$before = 0;
		if (count($arrRet) > 0)
		{
			$before = $arrRet[0]['point'];
		}
		$arrPoint = array();
		$query = DB::update('dtb_point');
		$arrPoint['point'] = $before - $point;
		$query->set($arrPoint);
		$query->where('customer_id','=',$customer_id);
		$query->execute();
	}
	
	public static function get_customer($customer_id)
	{
		$sql = "SELECT A.*,B.point_flg,C.point_rate,B.point,C.purchase_amount FROM dtb_customer as A";
		$sql .= " LEFT JOIN dtb_point as B ON A.customer_id = B.customer_id";
		$sql .= " JOIN dtb_stage as C ON A.customer_rank = C.stage_rank";		
		$where = " WHERE A.customer_id = {$customer_id}";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet[0];
		else
			return array();
	}

	public static function set_deliv($customer_id, $arrDeliv)
	{
		if (isset($arrDeliv['id']) && $arrDeliv['id'] != '')
		{
			$id = $arrDeliv['id'];
			unset($arrDeliv['id']);
			$arrDeliv['customer_id'] = $customer_id;
			$query = DB::update('dtb_other_deliv');
			$query->set($arrDeliv)->where('id',$id);
		}
		else
		{
			$arrDeliv['customer_id'] = $customer_id;
			$query = DB::insert('dtb_other_deliv');
			$query->set($arrDeliv);
		}
		return $query->execute();
	}

	public static function delete_deliv($customer_id, $deliv_id = '')
	{
		$query = DB::delete('dtb_other_deliv')->where('id', $deliv_id);
		
		return $query->execute();
	}
	public static function get_deliv($customer_id, $deliv_id = '')
	{
		$sql = "SELECT * FROM dtb_other_deliv";
		if ($deliv_id != '')
			$where = " WHERE customer_id = {$customer_id} AND id = {$deliv_id}";
		else
			$where = " WHERE customer_id = {$customer_id}";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) == 1 && $deliv_id != '')
			return $arrRet[0];
		else if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}
	public static function get_customer_rank($rank_id)
	{
		$sql = "SELECT A.name,B.point_rate,B.stage_rank, B.purchase_amount FROM mtb_customer_rank as A ";
		$sql .= "JOIN dtb_stage as B ON A.id = B.stage_rank ";
		$where = " WHERE A.id = {$rank_id} ";

		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
		
		return $arrRet[0];
	}

	public static function get_Pref($pref_id = '')
	{
		$sql = "SELECT id,name FROM mtb_pref";
		$where = '';
		if ($pref_id != '')
			$where = " WHERE id = {$pref_id}";
		$query = DB::query($sql.$where);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) == 1)
			return $arrRet[0]['name'];
		else if (count($arrRet) > 0)
		{
			$arrTemp = array();
			foreach($arrRet as $ret)
			{
				$arrTemp[$ret['id']] = $ret['name'];
			}
			return $arrTemp;
		}
		else
			return array();
	}
}
<?php
class Tag_Point
{
// define('POINT_LOG_ISSUE', '1');		// 仮発行
// define('POINT_LOG_ENABLE', '2');	// 有効昇華
// define('POINT_LOG_USE', '3');		// 利用
// define('POINT_LOG_ADD', '4');		// 加算（管理画面から）
// define('POINT_LOG_SUB', '5');		// 減算（管理画面から）
// define('POINT_LOG_CANCEL', '6');	// キャンセル（仮発行時のみ減算）
// define('POINT_LOG_LOST', '7');		// 失効（購入から1年365日）
// define('POINT_LOG_TEMP_LOST', '8');	// 失効
// define('POINT_LOG_ISSUE_SHOP', '9');	// 仮発行(SHOP用)
	function __construct()
	{
	}

	public static function set_point($customer_id, $point, $status, $order_id = 0)
	{
		$table_name = 'dtb_point_log';
		$column['customer_id'] = $customer_id;
		$column['order_id'] = $order_id;
		$column['point'] = $point;
		$column['status'] = $status;
		
		$query = DB::insert($table_name);
		$query->set($column);
		$query->execute();
	}
	
	public static function set_temp_point($customer_id, $order_id, $point)
	{
		$temp = array();
		$temp['customer_id'] = $customer_id;
		$temp['order_id'] = $order_id;
		$temp['point'] = $point;
//		$temp['create_date'] = $create_date;

		$table_name = "dtb_temp_point";
		$query = DB::insert($table_name);
		$query->set($temp);
		$query->execute();
	}
	
	public static function del_temp_point($customer_id, $order_id, $point)
	{
		$temp = array();
		$temp['customer_id'] = $customer_id;
		$temp['order_id'] = $order_id;
		$temp['point'] = $point;
//		$temp['create_date'] = $create_date;

		$table_name = "dtb_temp_point";
		$query = DB::delete($table_name)->where('customer_id', '=', $customer_id)->and_where('order_id', '=', $order_id);
		$query->execute();
	}
}
?>
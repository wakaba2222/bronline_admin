<?php
class Tag_Shop
{
	function __construct()
	{
	}

	public static function set_table($data, $table_name = 'dtb_products')
	{
		$sql = "REPLACE INTO ".$table_name." ";
		$columns = "";
		$values = "";
		
		foreach($data as $k=>$v)
		{
			if ($v == null)
				continue;
				
			if ($columns != "")
				$columns .= ",";
			$columns .= $k;
			
			if ($values != "")
				$values .= "','";
			$values .= $v;
		}
		$sql .= "(".$columns.")";
		$sql .= " VALUES ('".$values."')";
		$sql = str_replace("'NULL'", "NULL", $sql);
// var_dump($sql);
// exit;
		$query = DB::query($sql);
		$arrRet = $query->execute();
		
		return $arrRet;
	}
	
	public static function get_shop_id($shop)
	{
		$sql = "SELECT id FROM dtb_shop where login_id = '{$shop}' ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		
		if (count($arrRet) > 0)
		{
			return $arrRet[0]['id'];
		}
		return 0;
	}

	public static function get_shopdetail($where = '',  $table = 'A', $order = 'A.rank')
	{
		$sql = "SELECT {$table}.* FROM dtb_shop as A";
		$sql .= " LEFT JOIN dtb_stock_type as B ON A.dtb_stock_type_id = B.stock_type AND A.id = B.shop_id";
		
		if ($order != '')
			$order = ' order by '.$order;
		
		$def_where = 	" WHERE A.del_flg = 0 ";
		if ($where != '')
		{
			$where = $def_where.'  AND '.$where;
		}
		else
		{
			$where = $def_where;
		}
	
		$query = DB::query($sql.$where.$order);
		$arrRet = $query->execute()->as_array();
//  		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);
		
		return $arrRet;
	}
	
	public static function get_shoplist($where = '', $order = 'A.rank', $page = 1, $view = '100')
	{
		//
		$sql = "SELECT A.* FROM dtb_shop as A";
		$sql .= " LEFT JOIN dtb_stock_type as B ON A.dtb_stock_type_id = B.id";
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		
		if ($order != '')
			$order = ' order by '.$order;
		
		$def_where = 	" WHERE A.del_flg = 0 ";
		if ($where != '')
		{
			$where = $def_where.'  AND '.$where;
		}
		else
		{
			$where = $def_where;
		}
	
		$query = DB::query($sql.$where.$order.$limit);
		$arrRet = $query->execute()->as_array();
// 		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);
		
		return $arrRet;
	}
}
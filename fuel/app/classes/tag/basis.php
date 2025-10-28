<?php
class Tag_Basis
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

	public static function get_columns($table_name)
	{
		$sql = " DESCRIBE {$table_name} ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		return $arrRet;
	}
	
	public static function get_basis($column, $table_name = 'dtb_basis', $where = '')
	{
		$query = DB::select_array($column)->from($table_name);
		if ($where != '')
			$query->where($where);
		$arrRet = $query->execute()->as_array();
		//var_dump(DB::last_query());
		return $arrRet;
	}

	public static function set_table($data, $table_name = 'dtb_basis')
	{
		$sql = "REPLACE INTO ".$table_name." ";
		$columns = "";
		$values = "";
		
		foreach($data as $k=>$v)
		{
			if ($columns != "")
				$columns .= ",";
			$columns .= $k;
			
			if ($values != "")
				$values .= "','";
			
			if ($v == '')
				$values .= 'NULL';
			else
				$values .= $v;
		}
		$sql .= "(".$columns.")";
		$sql .= " VALUES ('".$values."')";
		$sql = str_replace("'NULL'", "NULL", $sql);
//var_dump($sql);
// exit;
		$query = DB::query($sql);
		$arrRet = $query->execute();
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
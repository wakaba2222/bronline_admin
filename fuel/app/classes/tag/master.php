<?php
class Tag_Master
{
	function __construct()
	{
	}

	public static function get_year($start = -5, $end = 5)
	{
		$arrRet = array();
		$now = intVal(date('Y'));
		for($i = ($now + $start);$i < ($now + $end);$i++)
		{
			$arrRet[$i] = $i;
		}
		return $arrRet;
	}

	public static function get_month()
	{
		$arrRet = array();
		$now = date('m');
		for($i = 0;$i < 12;$i++)
		{
			$arrRet[$i+1] = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
		}
		
		return $arrRet;
	}

	public static function get_day()
	{
		$arrRet = array();
		$now = date('m');
		for($i = 0;$i < 31;$i++)
		{
			$arrRet[$i+1] = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
		}
		
		return $arrRet;
	}

	public static function get_master($table_name, $column = array('id','name','rank'))
	{
		$arrRet = DB::select_array($column)->from($table_name)->order_by('rank')->execute()->as_array();
		return $arrRet;
	}

	public static function set_master($table_name, $column)
	{
		$query = DB::insert($table_name);
		$query->set($column);
		list($insert_id, $rows_affected) = $query->execute();
		
		return $insert_id;
	}

	public static function update_master($table_name, $column, $where = array())
	{
		$query = DB::update($table_name);
		$query->set($column);
		
		if (count($where) > 0)
			$query->where($where);

		$arrRet = $query->execute();
		
		return $arrRet;
	}
}
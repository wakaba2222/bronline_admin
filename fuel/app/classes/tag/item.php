<?php
class Tag_Item
{
	function __construct()
	{
	}

	public static function getDatabase()
	{
		$key = array(
			1 => 'default',
			2 => 'default',
		);
		
		$r = random_int(1, 2);
		
		return $key[$r];
	}

	public static function setStock($product_id, $product_code, $color_code, $size_code, $stock)
	{
		$sql = "UPDATE dtb_product_sku set stock = stock {$stock} ";
		$sql .= " WHERE dtb_products_product_id = {$product_id} AND product_code = '{$product_code}' ";
		$sql .= " AND (color_code = '{$color_code}' OR color_code is NULL) AND (size_code = '{$size_code}' OR size_code is NULL)";
		$query = DB::query($sql);
		$arrRet = $query->execute();
  		Log::debug(DB::last_query());
  		Log::debug(var_export($arrRet, true));

/*
		$query = DB::update('dtb_product_sku');
		$query->set(array('stock'=>$stock));
		$query->where('prodcut_id',$product_id);
		$query->and_where('product_code',$product_code);
		$query->and_where('color_code',$color_code);
		$query->and_where('size_code',$size_code);
		$quert->execute();
*/
		Profiler::console(DB::last_query());
	}
	
	public static function get_table($column, $table_name = '', $where = '')
	{
		$query = DB::select_array($column)->from($table_name);
		if ($where != '')
			$query->where($where);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		//var_dump(DB::last_query());
		Profiler::console(DB::last_query());
		return $arrRet;
	}

	public static function get_product_stock($product_id, $product_code)
	{
		$sql = "SELECT stock FROM dtb_product_sku as A";
		$sql .= " WHERE A.dtb_products_product_id = '{$product_id}' and A.product_code = '{$product_code}' ";

		$db = Tag_Item::getDatabase();
		$query = DB::query($sql);
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		if (count($arrRet) > 0)
		{
			return $arrRet[0]['stock'];
		}
		else
			return 0;
	}

	public static function get_product_sku($product_code)
	{
		$sql = "SELECT A.*,B.sale_status,B.name, B.product_id,B.point_rate,D.login_id as shop_url,C.price01 FROM dtb_product_sku as A join dtb_products as B on A.dtb_products_product_id = B.product_id";
		$sql .= " JOIN dtb_product_price as C on C.dtb_products_product_id = B.product_id "; 
		$sql .= " JOIN dtb_shop as D on B.shop_id = D.id "; 
		$sql .= " WHERE B.del_flg = 0 and A.product_code = '{$product_code}' ";

		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		if (count($arrRet) > 0)
		{
			return $arrRet[0];
		}
		else
			return 0;
	}

	public static function search($tags = array(), $orderby, $page  = 1, $view = '', $count = false, $where = '', $name = true)
	{
		$query = DB::select('dtb_products_product_id')->from('dtb_product_tag')->join('dtb_products')->on('dtb_product_tag.dtb_products_product_id', '=', 'dtb_products.product_id');
		
		foreach($tags as $t)
		{
			$query->or_where('tag', 'like', ''.$t.'%');
			if ($name)
				$query->or_where('name', 'like', '%'.$t.'%');
		}
		$query->group_by('dtb_products_product_id');
		$sql = $query->compile();
//		$arrRet = $query->execute()->as_array();
//Profiler::console($arrRet);
//		Profiler::console($sql);
//var_dump(DB::last_query());
// 		$ids = array();
// 		foreach($arrRet as $ret)
// 		{
// 			$ids[] = $ret['dtb_products_product_id'];
// 		}
		if ($where != '')
			$where .= ' AND ';
		$where .= ' A.product_id in ('.$sql.') ';
//		($where = '', $order = '', $page = 1, $view = '')
		if ($count)
		{
			return Tag_Item::get_item_count($where, $orderby);
		}

		$arrRet = Tag_Item::get_items($where, $orderby, $page, $view);
// 		$query = DB::select()->from('dtb_products');
// 		$query->where('product_id','in',$arrRet);
// 		$arrRet = $query->execute()->as_array();
		//var_dump(DB::last_query());
		Profiler::console(DB::last_query());
		
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_pickup($kind = '1')
	{
		$arrPickup = array();
		$query = DB::select()->from('dtb_pickup');
		$query->where('kind','=',$kind);
		$query->order_by('rank');
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		foreach($arrRet as $ret)
			$arrPickup[] = $ret;

		$query = DB::select()->from('dtb_pickup_keyword');
		if ($kind != '2')
		{
			$query->where('kind','<>','2');
		}
		else
			$query->where('kind','=',$kind);
		$query->order_by('rank');
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		foreach($arrRet as $ret)
			$arrPickup[] = $ret;
//Profiler::console($arrRet2);		
		Profiler::console(DB::last_query());

//		Profiler::console(DB::last_query());
		if (count($arrPickup) > 0)
			return $arrPickup;
		else
			return array();
	}

	public static function get_related($tags = array(), $shop = '', $not = false)
	{
		$where = '';
		if ($shop != '' && $not == false)
			$where = " C.login_id = '{$shop}' ";
		else if ($shop != '' && $not == true)
			$where = " C.login_id <> '{$shop}' ";
		$arrProducts = Tag_Item::search($tags, ' update_date desc ', 1, 20, false, $where, false);
		
		Profiler::console('get_related');
		Profiler::console(DB::last_query());
//		var_dump(DB::last_query());
		return $arrProducts;
		
	}

	public static function set_recommend($product_id, $products)
	{
		$sql = "select * from dtb_products where product_id = {$product_id}";
		$db = Tag_Item::getDatabase();
		$arrRet = DB::query($sql)->execute($db)->as_array();
		if (count($arrRet) == 0)
			return;
		$query = DB::insert('dtb_recommend_item');
		$arrItem = array();
		$arrItem['product_id'] = $product_id;
		$arrItem['products'] = $products;
		$query->set($arrItem);
		$query->execute();
		Profiler::console(DB::last_query());
	}

	public static function insert_table($tbl_name, $arrItem)
	{
		$query = DB::insert($tbl_name);
		$query->set($arrItem);
// 		$sql = $query->compile();
// 		var_dump($sql);
// 		exit;
		$query->execute();
		//var_dump(DB::last_query());
		Profiler::console(DB::last_query());
	}

	public static function delete_table($tbl_name, $key, $id)
	{
		$query = DB::delete($tbl_name);
		$query->where($key, $id);
// 		$sql = $query->compile();
// 		var_dump($sql);
// 		exit;

		$query->execute();
		//Profiler::console();
		Profiler::console(DB::last_query());
	}
	
	public static function set_table($data, $table_name = 'dtb_products')
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
				$values .= "NULL";
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
		Profiler::console(DB::last_query());
	}
	
	public static function get_columns($table_name)
	{
		$sql = " DESCRIBE {$table_name} ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		return $arrRet;
	}

	public static function get_recommend($product_id)
	{
		$sql = " SELECT * from dtb_recommend_item ";
		$where = " WHERE product_id in (".$product_id.") ORDER BY create_date desc LIMIT 20";
		$query = DB::query($sql.$where);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();

//var_dump($arrRet);
//exit;
		
		$arrRecommend = array();
		foreach($arrRet as $ret)
		{
			$ids = array();
			if (isset($ret['products']))
				$ids = @unserialize($ret['products']);
			
			if ($ids == null)
				$ids = array();
				
//var_dump($ids);
//exit;
			foreach($ids as $id)
			{
				if ($product_id != $id)
				{
					if (ctype_digit($id))
						$arrRecommend[$id] = $id;
				}
			}
		}

//		srand((float) microtime() * 10000000);
//		if (count($arrRecommend) > 100)
//		{
//			$randRecommend = array_rand($arrRecommend, 100);
//			$arrRecommend = $randRecommend;
//		}

		$product_ids = implode(',', $arrRecommend);
		$product_ids = trim($product_ids);
		$product_ids = str_replace("\'A=0", '', $product_ids);
		$product_ids = str_replace("\'A=0", '', $product_ids);
		$product_ids = preg_replace('/[^0-9],/', '', $product_ids);
		$arrRet = array();
//		var_dump($product_ids);
//		exit;
		if ($product_ids != '')
		{
			$where = " A.product_id in (".$product_ids.") ";
			$arrRet = Tag_Item::get_items($where, ' update_date desc ', 1, 10);
//		var_dump($where);exit;
		}
		Profiler::console(DB::last_query());
		
		return $arrRet;
		
	}

	public static function get_tag($product_id = '')
	{
		$sql = "SELECT * FROM dtb_product_tag as A";
		$sql .= " WHERE A.dtb_products_product_id = '{$product_id}' ";
		$sql .= " order by id";

		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());

		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_shop($where = '')
	{
		$sql = "SELECT A.shop_name,A.login_id FROM dtb_shop as A";
		$sql .= " WHERE A.login_id = '{$where}' ";
		$sql .= " order by rank";

		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();

		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet[0]['shop_name'];
		else
			return array();
	}

	public static function get_shoplist($where = '')
	{
		$sql = "SELECT A.shop_name,A.login_id,A.logo_img,A.popup_flg FROM dtb_shop as A WHERE shop_status <> 0 ";//AND popup_flg = 0 ";
		$sql .= $where;
		$sql .= " order by popup_flg asc,rank";

		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());

		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

// 	public static function get_brand_cnt($id)
// 	{
// 		$sql = "select count(*) as cnt from dtb_products as A join  dtb_brand as B on B.id = A.brand_id where A.brand_id = {$id}  and B.shop_url <> 'chosenone' ";
// 		$query = DB::query($sql);
// 		$arrRet = $query->execute()->as_array();
// 		
// 		if (count($arrRet) > 0)
// 		{
// 			return $arrRet[0]['cnt'];
// 		}
// 		return 0;
// 	}
	public static function get_brand_cnt($id, $shop = '')
	{
		$sql = "select count(*) as cnt from dtb_products as A join dtb_brand as B on B.id = A.brand_id where A.brand_id = {$id} ";
		if ($shop != '')
			$sql .= " and A.shop_id = '{$shop}' ";
		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		Profiler::console($arrRet);
		
		if (count($arrRet) > 0)
		{
			return $arrRet[0]['cnt'];
		}
		return 0;
	}
	
	public static function get_brand_like($where = "")
	{
//		$query = DB::select()->from('dtb_brand');
//		if ($where != '')
//			$query->where($where);
//		$arrRet = $query->execute();
//var_dump($arrRet);			

		$sql = "select * from dtb_brand where del_flg = 0 ";
		if ($where != '')
			$sql .= ' and '.$where;
		$query = DB::query($sql);
//var_dump($sql);			
//var_dump($query);			
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		return $arrRet;
	}

	public static function get_brand_like2($where = "")
	{
		$query = DB::select()->from('dtb_brand');
		if ($where != '')
			$query->where('name', 'like', $where.'%')->and_where('del_flg','=',0);
//		$arrRet = $query->execute();
//var_dump($arrRet);			

//		$sql = "select * from dtb_brand where del_flg = 0 ";
//		if ($where != '')
//			$sql .= ' and '.$where;
//		$query = DB::query($sql);
//var_dump($sql);			
//var_dump($query);			
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		return $arrRet;
	}
	
	public static function get_brandlist($where = '', $shop = '')
	{
		$sql = "SELECT A.name,A.name_kana,A.code FROM dtb_brand as A";
		if ($shop != '')
		{
			$sql .= " join dtb_products as B ON B.brand_id = A.id";
			$sql .= " join dtb_shop as C ON C.id = B.shop_id";
			if ($where == 'NUMERIC')
 				$sql .= " where C.login_id = '{$shop}' AND A.name REGEXP '^(0|1|2|3|4|5|6|7|8|9)' AND A.del_flg = 0 ";
 			else
	 			$sql .= " where C.login_id = '{$shop}' AND A.name like '{$where}%' AND A.del_flg = 0 ";
		}
		else
		{
			$sql .= " join dtb_products as B ON B.brand_id = A.id";
			if ($where == 'NUMERIC')
 				$sql .= " where A.name REGEXP '^(0|1|2|3|4|5|6|7|8|9)' AND A.del_flg = 0 and A.name not in (select name from dtb_brand where shop_url = 'chosenone') ";
 			else
				$sql .= " where A.name like '{$where}%' AND A.del_flg = 0 and A.name not in (select name from dtb_brand where shop_url = 'chosenone') ";
		}
		$sql .= " group by A.name";
		$sql .= " order by A.name";
		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
//if ($where == 'E')
//{
//print("<pre>");
//var_dump($sql);		
//var_dump($where);		
//var_dump($arrRet);		
//print("</pre>");
//}
		$arrTemp = array();
		foreach($arrRet as $ret)
		{
			$data = get_br_brand_name($ret['name'], false);
//if (strpos($ret['name'], 'EGR') !== false)
//{
//print("<pre>");
//var_dump($ret['name']);		
//var_dump($data);		
//print("</pre>");
//}

			if ($data != false)
			{
				$ret['code'] = $data['brand_code'];
				$arrTemp[] = $ret;
			}
		}
//		var_dump($arrTemp);
		$arrRet = $arrTemp;
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_category_item($category = '')
	{
		$sql = "SELECT * FROM dtb_category";
		if ($category != '')
		{
			$cname = ($category);
			$where = " WHERE del_flg = 0 AND name = '{$cname}'";
			$query = DB::query($sql.$where);
			$db = Tag_Item::getDatabase();
			$arrRet = $query->execute($db)->as_array();
// Profiler::console(DB::last_query());
// Profiler::console($arrRet);
			
			if (count($arrRet) == 0)
				return array();
			
			$arrRet2 = array();
			if ($arrRet[0]['parent_category_id'] != '')
			{
				$where = " WHERE del_flg = 0 AND category_id = ".$arrRet[0]['parent_category_id'];
				$query = DB::query($sql.$where);
				$db = Tag_Item::getDatabase();
				$arrRet2 = $query->execute($db)->as_array();
			}
// Profiler::console(DB::last_query());
// Profiler::console($arrRet2);
		Profiler::console(DB::last_query());

			$arrTemp = array();
			if (count($arrRet2) > 0)
			{
				$arrTemp['category_name'] = $arrRet[0]['name'];
				$arrTemp['parent_name'] = $arrRet2[0]['name'];
				return $arrTemp;
			}
			else
			{
				$arrTemp['category_name'] = $arrRet[0]['name'];
				return $arrTemp;
			}
		}
		return array();
	}

	public static function get_categories($where = '')
	{
		$sql = " SELECT * FROM dtb_category ";
		$order = " ORDER BY sort_no ASC ";
		
		if ($where != '')
			$where = ' WHERE '.$where;
		
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_category($category = '', $where = '')
	{

		if ($category != '')
		{
			$sql = "SELECT A.* FROM dtb_category as A ";
//			$sql .= "JOIN dtb_category as B ON B.category_id = A.parent_category_id ";
// 			$where = "WHERE A.del_flg = 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_product_category on dtb_product_sku.dtb_products_product_id = dtb_product_category.product_id where stock > 0 group by category_id)";
// 			$where .= " AND B.parent_category_id = (select category_id from dtb_category where name = '{$category}')";
// 			$where .= " GROUP BY B.category_id ";
//			$where = " WHERE A.del_flg = 0 AND A.parent_category_id in (select category_id from dtb_category where name = '{$category}' and parent_category_id <> 0)";
//			$order = " ORDER BY category_id ASC ";
			$where = " WHERE A.del_flg = 0 AND A.parent_category_id in (select category_id from dtb_category where name = '{$category}' and parent_category_id <> 0) and A.view_flg = 0 ";
			$order = " ORDER BY sort_no ASC ";
		}
		else
		{
			$sql = "SELECT B.* FROM dtb_category as A ";
			$sql .= "JOIN dtb_category as B ON B.category_id = A.parent_category_id ";
			if ($where != '')
				$where = "WHERE A.del_flg = 0 and A.category_id <> 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_products on dtb_product_sku.dtb_products_product_id = dtb_products.product_id where stock > 0 and {$where} group by category_id)";
			else
			{
				$where = "WHERE A.del_flg = 0 and A.category_id <> 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_products on dtb_product_sku.dtb_products_product_id = dtb_products.product_id where stock > 0 group by category_id)";
//				$where .= " or A.parent_category_id = 0 ";
			}
			
			$where .= " and A.view_flg = 0 GROUP BY B.category_id ";
//			$where = " WHERE del_flg = 0 AND parent_category_id = 0";
			$order = " ORDER BY sort_no ASC";//,category_id DESC
		}
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_category2($category = '', $where = '')
	{

		if ($category != '')
		{
			$sql = "SELECT A.* FROM dtb_category as A ";
//			$sql .= "JOIN dtb_category as B ON B.category_id = A.parent_category_id ";
// 			$where = "WHERE A.del_flg = 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_product_category on dtb_product_sku.dtb_products_product_id = dtb_product_category.product_id where stock > 0 group by category_id)";
// 			$where .= " AND B.parent_category_id = (select category_id from dtb_category where name = '{$category}')";
// 			$where .= " GROUP BY B.category_id ";
			$where = " WHERE A.del_flg = 0 AND A.parent_category_id in (select category_id from dtb_category where name = '{$category}' and parent_category_id = 0) and A.view_flg = 0 ";
			$order = " ORDER BY sort_no ASC ";
		}
		else
		{
			$sql = "SELECT B.* FROM dtb_category as A ";
			$sql .= "JOIN dtb_category as B ON B.category_id = A.parent_category_id ";
			if ($where != '')
				$where = "WHERE A.del_flg = 0 and A.category_id <> 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_products on dtb_product_sku.dtb_products_product_id = dtb_products.product_id where stock > 0 and {$where} group by category_id)";
			else
				$where = "WHERE A.del_flg = 0 and A.category_id <> 0 AND A.category_id in (select category_id from dtb_product_sku join dtb_products on dtb_product_sku.dtb_products_product_id = dtb_products.product_id where stock > 0 group by category_id)";
			
			$where .= " and A.view_flg = 0 GROUP BY B.category_id ";
//			$where = " WHERE del_flg = 0 AND parent_category_id = 0";
			$order = " ORDER BY sort_no ASC";
		}
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_size($size = '')
	{
		$sql = "SELECT * FROM mtb_size";
		if ($size != '')
		{
			$where = " WHERE name = '{$size}' ";
			$order = " ORDER BY rank ASC";
		}
		else
		{
			$where = '';
			$order = " ORDER BY rank ASC";
		}
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_color($color = '')
	{
		$sql = "SELECT * FROM mtb_color";
		if ($color != '')
		{
			$where = " WHERE name = '{$color}' ";
			$order = " ORDER BY rank ASC";
		}
		else
		{
			$where = '';
			$order = " ORDER BY rank ASC";
		}
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_brand($all = false)
	{
//		$key = array("UN METRE PRODUCTIONS","ARIANNA","GRENSON","BRIGLIA1949","POST IMPERIAL","ANDREA FENZI","LE GRAMME","Franca Perugia","FERRANTE","ATELIER F&B","19 andrea's 47","BARENA","ADRIANO MENEGHETTI","BePositive","tomas maier","CHAMBORD SELLIER","Crockett&Jones","CARE LABEL","ALESSANDRO GHERARDI","SeaGreen","ROSSIGNOL","other","PB0110","BREUER","Norlha","ALFREDO BERETTA","VANGHER","CUISSE DE GRENOUILLE","jimi roos");
		if ($all)
			$sql = "SELECT distinct * FROM dtb_brand ";
		else
			$sql = "SELECT distinct * FROM dtb_brand join dtb_brand_list on dtb_brand.name = dtb_brand_list.keyword ";

		if ($all)
			$where = " WHERE del_flg = 0 ";
		else
			$where = " WHERE del_flg = 0  and shop_url <> 'chosenone' ";
		if ($all)
			$order = " ORDER BY dtb_brand.rank";
		else
			$order = " GROUP BY dtb_brand.name ORDER BY dtb_brand_list.rank";
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
//		var_dump(DB::last_query());
		
		return $arrRet;
//		Profiler::console(DB::last_query());
//		if (count($arrRet) > 0)
//		{
//			$arrTemp = array();
//			foreach($key as $k)
//			{
//				foreach($arrRet as $ret)
//				{
//					if ($k == $ret['name'])
//					{
//						$arrTemp[] = $ret;
//						break;
//					}
//				}
//			}
//			return $arrTemp;
//		}
//		else
//			return array();
	}

	public static function get_shop_category($shop)
	{
		$keys = array(
		'leon'=>'91',
		'astilehouse'=>'92',
		'guji'=>'93',
		'ring'=>'94',
		'thestorebymaidens'=>'95',
		'leon'=>'96',
		'forzastyleshop'=>'97',
		'eskape'=>'98',
		'chosenone'=>'99',
		'sugawaraltd'=>'100',
		'duvetica'=>'101',
		'lanificiob'=>'102',
		'nanouniverse'=>'103',
		'pellemorbida'=>'104',
		'youfirst'=>'105',
		'altoediritto'=>'106',
		'lanzzo'=>'107',
		'colonyclothing'=>'108',
		'dormeuil'=>'109',
		'specialstore'=>'110',
		'isetanmens'=>'111',
		'biglietta'=>'112',
		'damiani'=>'113',
		'moorerginza'=>'114',
		'store_1piu1uguale3'=>'115',
		'nounstore'=>'116',
		'dieffekinloch'=>'117',
		'aoure'=>'118',
		'specialstore2'=>'119',
		'specialstore3'=>'120',
		'specialstore4'=>'401',
		'stools'=>'121',
		'replay'=>'122',
		'essenza'=>'400',
		'gentedimare'=>'402',
		);
		return $keys[$shop];
// 		$sql = "SELECT B.category_id FROM dtb_products as A";
// 		$sql .= " JOIN dtb_product_category as B ON A.product_id = B.product_id";
// 		$where = " WHERE A.product_id = ".$product_id;
// 		$query = DB::query($sql.$where);
// 		$arrRet = $query->execute()->as_array();
// 		Profiler::console(DB::last_query());
// 		
// 		if (count($arrRet) > 0)
// 			return $arrRet[0]['category_id'];
// 		else
// 			return array();
	}

	public static function get_detail_category($product_id)
	{
		$sql = "SELECT A.category_id FROM dtb_products as A";
//		$sql .= " JOIN dtb_product_category as B ON A.product_id = B.product_id";
		$where = " WHERE A.product_id = ".$product_id;
		$query = DB::query($sql.$where);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		if (count($arrRet) > 0)
			return $arrRet[0]['category_id'];
		else
			return array();
	}

	public static function get_detail_sku($product_id, $all = false)
	{
		$sql = "SELECT *,case when size_name is NULL then '' else size_code end as size_code FROM dtb_product_sku";
		if ($all)
			$where = " WHERE dtb_products_product_id = {$product_id} ";
		else
			$where = " WHERE dtb_products_product_id = {$product_id} and stock > 0 ";
		$order = " order by product_code ";
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		if (count($arrRet) > 0)
			return $arrRet;
		else
			return array();
	}

	public static function get_detail_images($product_id, $where = '')
	{
		$sql = "SELECT * FROM dtb_images";
		if ($where != '')
			$where = " WHERE dtb_products_product_id = {$product_id} AND ". $where;
		else
			$where = " WHERE dtb_products_product_id = {$product_id}";
		$order = " ORDER BY first ASC";
		$query = DB::query($sql.$where.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		return $arrRet;
	}

	public static function get_product_id($product_code)
	{
		$sql = "SELECT * FROM dtb_product_sku as A";
		$sql .= " join dtb_products as B on A.dtb_products_product_id = B.product_id ";
		$sql .= " where B.del_flg = 0 and A.product_code = '{$product_code}'";
		$order = " LIMIT 1 ";
		$query = DB::query($sql.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();

		if (count($arrRet) > 0)
		{
			return $arrRet[0]['product_id'];
		}
		
		return 0;
	}

	public static function get_product_view()
	{
		$sql = "SELECT * FROM mtb_product_view";
		$order = " ORDER BY rank ASC";
		$query = DB::query($sql.$order);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		return $arrRet;
	}

	public static function get_check_items()
	{
		$products = Tag_Session::getCheckItem();
		
		if (count($products) == 0)
			return array();
		
		$products = implode(',', $products);
		Profiler::console($products);
		
		$sql = "SELECT A.*,G.name as category_name,B.*,C.*,D.*,E.*,F.*,H.*,I.name as brand_name, A.product_id as product_id FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url) as A JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
// 		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_shop as C ON (A.cshop_id = C.id OR A.shop_id = C.id) AND C.shop_status <> 0 JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_category as F ON A.product_id = F.product_id";
		$sql .= " JOIN dtb_category as G ON F.category_id = G.category_id";
		$sql .= " LEFT JOIN dtb_product_status as H ON A.product_id = H.product_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id WHERE first = 1";
		$where = " AND A.product_id in ( {$products} ) ";
		$group = " GROUP BY A.product_id ";
		$query = DB::query($sql.$where.$group);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		$products = Tag_Session::getCheckItem();
		$arrTemp = array();
		foreach($products as $p)
		{
			foreach($arrRet as $ret)
			{
				if ($p == $ret['product_id'])
				{
					$arrTemp[] = $ret;
					break;
				}
			}
		}
		
		Profiler::console(count($arrTemp));
		Profiler::console(DB::last_query());
		return $arrTemp;
		
		
		return array();
	}

	public static function get_point_rate($product_id)
	{
		$sql = "SELECT point_rate FROM dtb_products where product_id = {$product_id}";
		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		Profiler::console(DB::last_query());
		
		return $arrRet[0]['point_rate'];
	}

	public static function get_status_flg($product_id)
	{
		$sql = "SELECT status_flg FROM dtb_product_status where product_id = {$product_id}";
		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		if (count($arrRet) > 0)
			return $arrRet[0]['status_flg'];
		else
			return 0;
	}

	public static function get_copy_products($product_id, $admin = false, $shop = '')
	{
		$sql = "SELECT G.*,A.*,B.*,C.*,D.name as brand_name,D.name_kana as brand_name_kana,D.code as brand_code,G.name as category_name FROM dtb_products as A";
		$sql .= " JOIN dtb_shop as B ON A.shop_id = B.id";
		$sql .= " JOIN dtb_product_price as C ON A.product_id = C.dtb_products_product_id";
		$sql .= " JOIN dtb_brand as D ON A.brand_id = D.id";
//		$sql .= " JOIN dtb_product_category as F ON A.product_id = F.product_id";
		$sql .= " JOIN dtb_category as G ON A.category_id = G.category_id";
		$where = '';
		if ($admin)
			$where = " WHERE A.product_id in ('{$product_id}') and A.del_flg = 0 ";
		else
			$where = " WHERE A.status <> 1 AND A.product_id in ('{$product_id}')  and A.del_flg = 0 ";

// 		if ($shop != '')
// 		{
// 			if ($where == '')
// 				$where .= " WHERE B.login_id = '{$shop}' ";
// 			else
// 				$where .= " AND B.login_id = '{$shop}' ";
// 		}
		$where .= " AND exists (select * from dtb_product_copy where product_id = {$product_id} and shop_url = '{$shop}') ";
		$group = " GROUP BY A.product_id";
// var_dump($sql.$where.$group.$shop);
// exit;
		$query = DB::query($sql.$where.$group);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet[0];
		else
			return array();
	}
	
	public static function get_detail($product_id, $admin = false, $shop = '')
	{
// 		$sql = "SELECT G.*,A.*,B.*,C.*,D.name as brand_name,D.name_kana as brand_name_kana,D.code as brand_code,G.name as category_name FROM dtb_products as A";
// 		$sql .= " JOIN dtb_shop as B ON A.shop_id = B.id";
// 		$sql .= " JOIN dtb_product_price as C ON A.product_id = C.dtb_products_product_id";
// 		$sql .= " JOIN dtb_brand as D ON A.brand_id = D.id";
// //		$sql .= " JOIN dtb_product_category as F ON A.product_id = F.product_id";
// 		$sql .= " JOIN dtb_category as G ON A.category_id = G.category_id";

		$sql = "SELECT G.*,A.*,B.*,C.*,D.name as brand_name,D.name_kana as brand_name_kana,D.code as brand_code,G.name as category_name FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url) as A";

//		$sql = "SELECT G.*,A.*,B.*,C.*,D.name as brand_name,D.name_kana as brand_name_kana,D.code as brand_code,G.name as category_name FROM (select AA.*,CC.id as cshop_id,BB.org_shop,BB.status as copy_status from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url) as A";

		if ($admin)
			$sql .= " JOIN dtb_shop as B ON (A.cshop_id = B.id OR A.shop_id = B.id) ";//AND B.shop_status <> 0 ";
		else
			$sql .= " JOIN dtb_shop as B ON (A.cshop_id = B.id OR A.shop_id = B.id) AND B.shop_status <> 0 ";
		$sql .= " JOIN dtb_product_price as C ON A.product_id = C.dtb_products_product_id";
		$sql .= " JOIN dtb_brand as D ON A.brand_id = D.id";
//		$sql .= " JOIN dtb_product_category as F ON A.product_id = F.product_id";
		$sql .= " JOIN dtb_category as G ON A.category_id = G.category_id";

		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$where = '';
		if ($admin)
			$where = " WHERE A.product_id in ('{$product_id}') ";
		else
//	modify 2021.1.4		$where = " WHERE A.status <> 1 AND A.product_id in ({$product_id})  and A.del_flg = 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
			$where = " WHERE ((A.status = 2 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}')) OR A.status = 3) AND A.product_id in ('{$product_id}')  and A.del_flg = 0 ";

		if ($shop != '')
		{
			if ($where == '')
				$where .= " WHERE B.login_id = '{$shop}' ";
			else
				$where .= " AND B.login_id = '{$shop}' ";
		}
		$group = " GROUP BY A.product_id";
		$query = DB::query($sql.$where.$group);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
			return $arrRet[0];
		else
			return array();
	}
	
	public static function get_justin($where_in = '')
	{
		// とりあえず最新のものを表示（本来はNEWステータスのもののみ）
		//
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT A.*,G.name as category_name,B.*,C.*,D.*,E.*,H.*,I.name as brand_name,A.product_id as product_id FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url) as A JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
		$sql .= " JOIN dtb_shop as C ON (A.cshop_id = C.id OR A.shop_id = C.id)  AND C.shop_status <> 0 JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id ";
//		$sql .= " JOIN dtb_product_category as F ON A.product_id = F.product_id";
		$sql .= " JOIN dtb_category as G ON A.category_id = G.category_id";
		$sql .= " left JOIN dtb_product_status as H ON A.product_id = H.product_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id WHERE first = 1";
		$where = " AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') AND A.status = 2 and A.del_flg = 0 and D.stock > 0 ".$where_in;
		$group = " GROUP BY A.product_id ";
		$orderby = " ORDER BY status_flg desc, A.update_date desc limit 20";
		$query = DB::query($sql.$where.$group.$orderby);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
//var_dump($sql.$where.$group.$orderby);		
//		Log::debug(DB::last_query());
//		Profiler::console($arrRet);

		return $arrRet;
	}

	public static function get_category_id($word, $sub = false)
	{
		$word = urldecode($word);
		$sql = "SELECT category_id,parent_category_id FROM dtb_category WHERE name = '{$word}'";
		$query = DB::query($sql);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();

		Profiler::console(DB::last_query());
		if (count($arrRet) > 0)
		{
			if (!$sub)
			{
				if (count($arrRet) == 1)
					return $arrRet[0]['category_id'];
				else
				{
					foreach($arrRet as $ret)
					{
						if ($ret['parent_category_id'] == '0')
							return $ret['category_id'];
					}
				}
			}
			else
			{
				return $arrRet[0]['category_id'];
			}
		}
		else
			return 0;
	}

	public static function get_items2(&$count = 0, $where = '', $order = '', $page = 1, $view = '', $theme = false)
	{
		// とりあえず最新のものを表示（本来はNEWステータスのもののみ）
		//
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT SQL_CALC_FOUND_ROWS A.*,B.*,C.*,D.*,I.name as category_name,I.name as brand_name, I.id as brand_id,MIN(D.stock) as min_stock, MAX(D.stock) as max_stock,E.*,F.*,A.product_id as product_id ";
		$sql .= " FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url  where AA.del_flg = 0 AND AA.status = 2) as A ";
		$sql .= " JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id ";
		$sql .= " JOIN dtb_shop as C ON (A.cshop_id = C.id OR A.shop_id = C.id)  AND C.shop_status <> 0";
		$sql .= " JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id";
//		$sql .= " JOIN dtb_product_category as G ON A.product_id = G.product_id";
		$sql .= " JOIN dtb_category as H ON A.category_id = H.category_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
//		$sql .= " JOIN dtb_smaregi_product as S ON S.brand_id = I.id";
		//$sql .= " JOIN dtb_product_sku as J ON A.product_id = J.dtb_products_product_id";
		$sql .= " LEFT JOIN dtb_product_status as F ON A.product_id = F.product_id";
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		
		$groupby = ' GROUP BY A.product_id ';
		if ($order != '')
			$order = ' order by '.$order;
		
		if ($theme)
			$def_where = 	" WHERE A.del_flg = 0 AND A.status <> 1 AND B.first = 1 AND D.stock > 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
		else
			$def_where = 	" WHERE A.del_flg = 0 AND A.status = 2 AND B.first = 1 AND D.stock > 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
// 		$def_where .= " AND (select MIN(stock) as min_stock, MAX(stock) as max_stock from dtb_product_sku where dtb_products_product_id = A.product_id group by dtb_products_product_id) as stocks";
// 		$def_where .= " AND stocks.min_stock != 0";
		if ($where != '')
		{
//				$where = $def_where.'  AND '.$where;
			if (strpos($where, 'select') === false)
				$where = $def_where.'  AND '.$where . " AND ((A.org_shop is NULL) OR (A.org_shop is not NULL AND A.org_shop != C.login_id) OR A.org_shop = C.login_id) ";
			else
				$where = $def_where.'  AND '.$where . " AND (A.org_shop is NULL OR A.org_shop = C.login_id) ";
	//var_dump($where);
		}
		else
		{
			$where = $def_where . " AND (A.org_shop is NULL OR A.org_shop = C.login_id) ";
		}
	
		$query = DB::query($sql.$where.$groupby.$order.$limit);
		
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
//		Profiler::console(DB::last_query());
// 		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);

//		$sql = "SELECT FOUND_ROWS()";
		$query2 = DB::query($sql.$where.$groupby.$order);
		$arrRet2 = $query2->execute($db)->as_array();

		$count = count($arrRet2);
		return $arrRet;
	}

	public static function get_item_count($where = '', $order = '')
	{
		$sql = "SELECT FOUND_ROWS()";
/*
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT A.product_id,MIN(D.stock) as min_stock, MAX(D.stock) as max_stock FROM dtb_products as A JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id  AND C.shop_status <> 0";
		$sql .= " JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id";
//		$sql .= " JOIN dtb_product_category as G ON A.product_id = G.product_id";
		$sql .= " JOIN dtb_category as H ON A.category_id = H.category_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
		//$sql .= " JOIN dtb_product_sku as J ON A.product_id = J.dtb_products_product_id";
		$sql .= " LEFT JOIN dtb_product_status as F ON A.product_id = F.product_id";
		$groupby = ' GROUP BY A.product_id ';
		if ($order != '')
			$order = ' order by '.$order;
		$def_where = 	" WHERE A.del_flg = 0 AND A.status = 2 AND B.first = 1 AND D.stock > 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
// 		$def_where .= " AND (select MIN(stock) as min_stock, MAX(stock) as max_stock from dtb_product_sku where dtb_products_product_id = A.product_id group by dtb_products_product_id) as stocks";
// 		$def_where .= " AND stocks.min_stock != 0";
		if ($where != '')
		{
			$where = $def_where.'  AND '.$where;
		}
		else
		{
			$where = $def_where;
		}
		$query = DB::query($sql.$where.$groupby.$order);
*/	
		$arrRet = DB::query($sql)->execute();
//		Profiler::console(DB::last_query());
//		var_dump($arrRet);
		return $arrRet[0]['FOUND_ROWS()'];
	}

	public static function get_items($where = '', $order = '', $page = 1, $view = '', $theme = false, &$item_cnt = 0)
	{
		// とりあえず最新のものを表示（本来はNEWステータスのもののみ）
		//
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT SQL_CALC_FOUND_ROWS A.*,B.*,C.*,D.*,I.name as category_name,I.name as brand_name, I.id as brand_id,MIN(D.stock) as min_stock, MAX(D.stock) as max_stock,E.*,F.*,A.product_id as product_id ";
//		$sql .= " FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url  where AA.del_flg = 0 AND AA.status = 2) as A ";
		$sql .= " FROM dtb_products as A ";
		$sql .= " JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id ";
//		$sql .= " JOIN dtb_shop as C ON (A.cshop_id = C.id OR A.shop_id = C.id)  AND C.shop_status <> 0";
		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id  AND C.shop_status <> 0";
		$sql .= " JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id";
//		$sql .= " JOIN dtb_product_category as G ON A.product_id = G.product_id";
		$sql .= " JOIN dtb_category as H ON A.category_id = H.category_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
//		$sql .= " JOIN dtb_smaregi_product as S ON S.brand_id = I.id";
		//$sql .= " JOIN dtb_product_sku as J ON A.product_id = J.dtb_products_product_id";
		$sql .= " LEFT JOIN dtb_product_status as F ON A.product_id = F.product_id";
		$p = ($page - 1) * $view;
		$limit = " LIMIT {$p},{$view}";
		
		$groupby = ' GROUP BY A.product_id ';
		if ($order != '')
			$order = ' order by '.$order;
		
		if ($theme)
			$def_where = 	" WHERE A.del_flg = 0 AND A.status <> 1 AND B.first = 1 AND D.stock > 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
		else
			$def_where = 	" WHERE A.del_flg = 0 AND A.status = 2 AND B.first = 1 AND D.stock > 0 AND (A.view_date is NULL OR A.view_date <= '{$now}') AND (A.close_date is NULL OR A.close_date > '{$now}') ";
// 		$def_where .= " AND (select MIN(stock) as min_stock, MAX(stock) as max_stock from dtb_product_sku where dtb_products_product_id = A.product_id group by dtb_products_product_id) as stocks";
// 		$def_where .= " AND stocks.min_stock != 0";
		if ($where != '')
		{
//				$where = $def_where.'  AND '.$where;
			if (strpos($where, 'select') === false)
				$where = $def_where.'  AND '.$where;// . " AND ((A.org_shop is NULL) OR (A.org_shop is not NULL AND A.org_shop != C.login_id) OR A.org_shop = C.login_id) ";
			else
				$where = $def_where.'  AND '.$where;// . " AND (A.org_shop is NULL OR A.org_shop = C.login_id) ";
	//var_dump($where);
		}
		else
		{
			$where = $def_where;// . " AND (A.org_shop is NULL OR A.org_shop = C.login_id) ";
		}
	
		$query = DB::query($sql.$where.$groupby.$order.$limit);
		
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
		
		$sql = "SELECT FOUND_ROWS()";
		$query2 = DB::query($sql);
		$arrCount = $query2->execute($db);
		$item_cnt = $arrCount[0]['FOUND_ROWS()'];

		Profiler::console(DB::last_query());
// 		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);
		
		return $arrRet;
	}

	public static function get_allitems($where = '', $order = '', $page = 1, $view = '100')
	{
		// とりあえず最新のものを表示（本来はNEWステータスのもののみ）
		//
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT SQL_CALC_FOUND_ROWS A.*,B.*,C.*,D.*,H.name as category_name,I.name as brand_name, I.id as brand_id,MIN(D.stock) as min_stock, MAX(D.stock) as max_stock,E.*,F.*,A.product_id as product_id FROM dtb_products as A left JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id";
		$sql .= " JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id";
//		$sql .= " JOIN dtb_product_category as G ON A.product_id = G.product_id";
		$sql .= " JOIN dtb_category as H ON A.category_id = H.category_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
		//$sql .= " JOIN dtb_product_sku as J ON A.product_id = J.dtb_products_product_id";
		$sql .= " LEFT JOIN dtb_product_status as F ON A.product_id = F.product_id";
		
		$limit = '';
		$def_where = 	" WHERE A.del_flg = 0 AND (B.first = 1 or B.first is NULL) ";
		if ($view != 0)
		{
			$p = ($page - 1) * $view;
			$limit = " LIMIT {$p},{$view}";
			$def_where = 	" WHERE A.del_flg = 0 ";
		}
		
		$groupby = ' GROUP BY A.product_id ';
		if ($order != '')
			$order = ' order by '.$order;
		
// 		$def_where = 	" WHERE A.del_flg = 0 AND B.first = 1 ";
		if ($where != '')
		{
			$where = $def_where.'  AND '.$where;
		}
		else
		{
			$where = $def_where;
		}
	
		$query = DB::query($sql.$where.$groupby.$order.$limit);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
 		Profiler::console('get_allitems');
 		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);
//var_dump(DB::last_query());
		
		return $arrRet;
	}

	public static function get_allitems2($where = '', $order = '', $page = 1, $view = '100')
	{
		// とりあえず最新のものを表示（本来はNEWステータスのもののみ）
		//
		$now = date('Y-m-d H:i:s');// WHERE view_date <= '{$now}
		$sql = "SELECT SQL_CALC_FOUND_ROWS A.*,B.*,C.*,D.*,H.name as category_name,I.name as brand_name, I.id as brand_id,MIN(D.stock) as min_stock, MAX(D.stock) as max_stock,E.*,F.*,A.product_id as product_id ";
		$sql .= " FROM (select AA.*,CC.id as cshop_id,BB.org_shop from dtb_products as AA left join dtb_product_copy as BB on AA.product_id = BB.product_id left join dtb_shop as CC on CC.login_id = BB.shop_url) as A ";
		$sql .= " left JOIN dtb_images as B ON A.product_id = B.dtb_products_product_id";
//		$sql .= " JOIN dtb_shop as C ON A.shop_id = C.id";
		$sql .= " JOIN dtb_shop as C ON (A.cshop_id = C.id OR A.shop_id = C.id)  AND C.shop_status <> 0";
		$sql .= " JOIN dtb_product_sku as D ON A.product_id = D.dtb_products_product_id";
		$sql .= " JOIN dtb_product_price as E ON A.product_id = E.dtb_products_product_id";
//		$sql .= " JOIN dtb_product_category as G ON A.product_id = G.product_id";
		$sql .= " JOIN dtb_category as H ON A.category_id = H.category_id";
		$sql .= " JOIN dtb_brand as I ON A.brand_id = I.id";
		//$sql .= " JOIN dtb_product_sku as J ON A.product_id = J.dtb_products_product_id";
		$sql .= " LEFT JOIN dtb_product_status as F ON A.product_id = F.product_id";
		
		$limit = '';
		$def_where = 	" WHERE A.del_flg = 0 AND (B.first = 1 or B.first is NULL) ";
		if ($view != 0)
		{
			$p = ($page - 1) * $view;
			$limit = " LIMIT {$p},{$view}";
			$def_where = 	" WHERE A.del_flg = 0 ";
		}
		
		$groupby = ' GROUP BY A.product_id ';
		if ($order != '')
			$order = ' order by '.$order;
		
// 		$def_where = 	" WHERE A.del_flg = 0 AND B.first = 1 ";
		if ($where != '')
		{
			$where = $def_where.'  AND '.$where;
		}
		else
		{
			$where = $def_where;
		}
	
		$query = DB::query($sql.$where.$groupby.$order.$limit);
		$db = Tag_Item::getDatabase();
		$arrRet = $query->execute($db)->as_array();
 		Profiler::console('get_allitems');
 		Profiler::console(DB::last_query());
// 		Profiler::console($arrRet);
//var_dump(DB::last_query());
		
		return $arrRet;
	}
}

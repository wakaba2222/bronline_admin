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
class Controller_Admin_ProductEdit extends ControllerAdmin
{
	public function action_index()
	{
		$post = Input::param();

		$product_id = Input::param('product_id','');
		
		$page = Tag_Session::get('PAGE');
//var_dump($page);
		$mode = Tag_Session::get('mode');
		if ($mode == 'confirm_return')
		{
 			$arrTemp = Tag_Session::get('BACK_DATA');
			Tag_Session::delete('BACK_DATA');
			Tag_Session::delete('mode');
			foreach($arrTemp as $k=>$v)
			{
				if ($k == 'arrProduct')
				{
					$arrTemp2 = array();
					foreach($v as $kk=>$vv)
					{
						$vv = str_replace('\\','', $vv);
						$arrTemp2[$kk] = $vv;
					}
					$arrTemp[$k] = $arrTemp2;
				}
			}
 			foreach($arrTemp as $k=>$v)
 			{
 				if ($k == 'arrProductCode')
 				{
 					$c = count($v['product_code']);
 					$arrSKU = array();
 					$arrProductCode = array();
 					for($i = 0;$i < $c;$i++)
 					{
 						if ($v['product_code'][$i] == '')
 							continue;
 						$arrSKU['product_code'] = $v['product_code'][$i];
 						$arrSKU['color_code'] = $v['color_code'][$i];
 						$arrSKU['color_name'] = $v['color_name'][$i];
 						$arrSKU['size_code'] = $v['size_code'][$i];
 						$arrSKU['size_name'] = $v['size_name'][$i];
 						$arrSKU['stock'] = $v['stock'][$i];
 						$arrSKU['attribute'] = $arrTemp['arrProduct']['attribute'];
 						$arrProductCode[] = $arrSKU;
 					}
		 			$this->arrResult[$k] = $arrProductCode;
 				}
 				else if ($k == 'arrTag')
 				{
 					foreach($v['tag'] as $kk=>$vv)
 					{
 						if ($vv == '')
 							continue;
 						$this->arrResult[$k][$kk] = $vv;
 					}
 				}
 				else if ($k == 'arrImages')
 				{
 					$c = count($v['images']);
 					$arrIMG = array();
 					$arrImage = array();
 					for($i = 0;$i < $c;$i++)
 					{
 						if ($v['images'][$i] == '')
 							continue;
 						$imgs = explode('/', $v['images'][$i]);
 						$arrIMG['path'] = $imgs[count($imgs)-1];
 						$arrIMG['tag'] = $v['tags'][$i];
 						$arrIMG['comment'] = $v['comment'][$i];
 						$arrImage[] = $arrIMG;
 					}
		 			$this->arrResult[$k] = $arrImage;
 				}
 				else
		 			$this->arrResult[$k] = $v;
	 		}
 			$product_id = $arrTemp['arrProduct']['product_id'];
			$where = "parent_category_id <> 0";
			$category_id = Tag_Item::get_detail_category($product_id);
			$arrTemp = Tag_Item::get_categories($where);
			$arrCategory = array();
			foreach($arrTemp as $ret)
			{
				$arrCategory[$ret['category_id']] = $ret['name'];
			}
			$this->arrResult['arrCategory'] = $arrCategory;
			$this->arrResult['category_id'] = $category_id;
			$this->arrResult['shop'] = Tag_Session::getShop();
			//ブランド情報
			$arrTemp = Tag_Item::get_brand(true);

		$arrTemp2 = array();
		foreach($arrTemp as $temp)
		{
			$temp['sort_name'] = strtolower($temp['name']);
			$arrTemp2[] = $temp;
		}
		$arrTemp = $arrTemp2;

		array_multisort(array_column($arrTemp, 'sort_name'), SORT_ASC, $arrTemp);
//var_dump($arrTemp);
		$arrBrand = array();
		foreach($arrTemp as $temp)
		{
		    if ($temp['shop_url'] == $this->arrResult['shop'] )
    		    $arrBrand[] = $temp;
		}
		$this->arrResult['arrBrand'] = $arrBrand;
// 			var_dump($this->arrResult['arrImages']);
// 			exit;

			$this->tpl = 'smarty/admin/product/product.tpl';
			return $this->view;
		}
// 		var_dump($_SESSION);
// 		var_dump(Session::get_flash('mode'));
// 		var_dump(Session::get_flash('product_id'));
// 		var_dump($product_id);

		if ($product_id == '')
		{
			Response::redirect('/admin/product', 'location');
		}
		if (Tag_Session::get('mode') != 'confirm_return')
		{
	        if (!$this->doValidToken(true) || $this->getMode() != 'pre_edit')
	        {
				Response::redirect('/admin/error', 'location', 301);
	        }
		}
		
		//商品情報
		$arrTemp2 = Tag_Item::get_detail_sku($product_id,true);
		$arrTemp = Tag_Item::get_detail($product_id, true);
//		var_dump(DB::last_query());
		$status_flg = Tag_Item::get_status_flg($product_id);
//		var_dump($arrTemp);exit;
		$arrTemp['status_flg'] = $status_flg;
		if (isset($arrTemp2[0]['attribute']) && $arrTemp2[0]['attribute'] != '')
			$arrTemp['attribute'] = $arrTemp2[0]['attribute'];
		$this->arrResult['arrProduct'] = $arrTemp;
		//var_dump($this->arrResult['arrProduct']);exit;
		//ブランド情報
		$this->arrResult['shop'] = Tag_Session::getShop();
		$arrTemp = Tag_Item::get_brand(true);

		$arrTemp2 = array();
		foreach($arrTemp as $temp)
		{
			$temp['sort_name'] = strtolower($temp['name']);
			$arrTemp2[] = $temp;
		}
		$arrTemp = $arrTemp2;

		array_multisort(array_column($arrTemp, 'sort_name'), SORT_ASC, $arrTemp);

		$arrBrand = array();
		foreach($arrTemp as $temp)
		{
		    if ($temp['shop_url'] == $this->arrResult['shop'])
    		    $arrBrand[] = $temp;
		}
		$this->arrResult['arrBrand'] = $arrBrand;
		//カラー、サイズ情報
		$arrTemp = Tag_Item::get_detail_sku($product_id,true);
		$arrSize = array();
		$arrColor = array();
		$arrProductCode = array();
		foreach($arrTemp as $ret)
		{
			$arrSKU = array();
			$arrSKU['product_code'] = $ret['product_code'];
			$arrSKU['size_code'] = $ret['size_code'];
			$arrSKU['size_name'] = $ret['size_name'];
			$arrSKU['color_code'] = $ret['color_code'];
			$arrSKU['color_name'] = $ret['color_name'];
			$arrSKU['stock'] = $ret['stock'];
			$arrProductCode[] = $arrSKU;
		}
		$this->arrResult['arrProductCode'] = $arrProductCode;

		$where = "parent_category_id <> 0 and view_flg = 0";
		$category_id = Tag_Item::get_detail_category($product_id);
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
//print("<pre>");
//var_dump($arrParent);
//var_dump($arrCategory);
//print("</pre>");
//exit;
		$this->arrResult['arrParent'] = $arrParent;
		$this->arrResult['arrCategory'] = $arrCategory;
		$this->arrResult['category_id'] = $category_id;
		$this->arrResult['shop'] = Tag_Session::getShop();
		
		$arrTemp = Tag_Item::get_tag($product_id);
		$arrTag = array();
		foreach($arrTemp as $ret)
		{
			$arrTag[$ret['id']] = $ret['tag'];
		}
		$this->arrResult['arrTag'] = $arrTag;

		$arrTemp = Tag_Item::get_detail_images($product_id);
		$this->arrResult['arrImages'] = $arrTemp;
// var_dump($this->arrResult['arrImages']);
// var_dump($this->arrResult['arrBrand']);


		$this->tpl = 'smarty/admin/product/product.tpl';
		return $this->view;
	}

	public function action_confirm()
	{
		
		$post = Input::param();
		$files = Input::file('movies_img_tmp');
		
//		foreach($post as $k=>$v)
//		{
//			if ($k == 'arrProduct')
//			{
//				$arrTemp = array();
//				foreach($v as $kk=>$vv)
//				{
//					$vv = str_replace('\\','', $vv);
//					$arrTemp[$kk] = $vv;
//				}
//				$post[$k] = $arrTemp;
//			}
//		}
//		$post['arrImages']
		
		$post['arrProduct']['movies_img'] = "";
		
		if (isset($files["tmp_name"]) && $files["tmp_name"] != '')
		{
//var_dump(REAL_UPLOAD_IMAGE_PATH.'/'.Tag_Session::getShop());
//exit;
			$file_tmp  = $files["tmp_name"];

			@mkdir(REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop());
			$perm_num = 757;
			$perm     = sprintf ( "%04d", $perm_num );
			@chmod(REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop(),octdec ( $perm ));

			$file_save = REAL_UPLOAD_IMAGE_PATH .Tag_Session::getShop(). "/". date('YmdHis').'_'.$files["name"];
			$result = @move_uploaded_file($file_tmp, $file_save);
			$perm_num = 666;
			$perm     = sprintf ( "%04d", $perm_num );
			@chmod($file_save,octdec ( $perm ));
			if ($result === true)
			{
				$file_save = date('YmdHis').'_'.$files["name"];
				$post['arrProduct']['movies_img'] = $file_save;
			}
		}
//var_dump($post);
//var_dump($files);
//exit;
//		var_dump($post);
		//exit;
		if ($post['mode'] == 'confirm_return')
		{
// 			$back_data = Session::get_flash('BACK_DATA');
// 			var_dump($back_data);
// 			exit;
			Tag_Session::set('mode',$post['mode']);
//			Session::set_flash('BACK_DATA', $back_data);
// 			Session::keep_flash('BACK_DATA');
			$this->tpl = 'smarty/admin/product/product.tpl';
			//Response::redirect_back('/admin/product', 'location');
			Response::redirect('/admin/productedit');
			
		}
		else if ($post['mode'] == 'confirm')
		{
//		print("<pre><p>confirm</p>");
 			$arrBack = Tag_Session::get('BACK_DATA');
// 			if ($post['movies_img'] != '')
// 				$arrBack['movies_img'] = $post['movies_img'];
// 			var_dump($arrBack);
			$this->getData('dtb_products', 'arrProduct', $arrBack);
			$this->getData('dtb_product_category', 'category_id', $arrBack);
			$this->getData('dtb_product_sku', 'arrProductCode', $arrBack);
			$this->getData('dtb_images', 'arrImages', $arrBack);
			$this->getData('dtb_product_tag', 'arrTag', $arrBack);
			$this->getData('dtb_product_status', 'arrProduct', $arrBack);
			$this->getData('dtb_product_price', 'arrProduct', $arrBack);

//			$this->getData('dtb_products', 'movies_img', $arrBack);
//		var_dump($arrBack);

			$this->arrResult['product_page'] = Tag_Session::get('PAGE');
			//Session::delete('BACK_DATA');
			$this->tpl = 'smarty/admin/product/complete.tpl';
			return $this->view;
						
// 			foreach($arrTemp as $k=>$v)
// 			{
// 			}
			
// 		print("</pre>");
// 			exit;
		}
		else
		{
//			var_dump("CONFIRM DATA");
			Tag_Session::set('BACK_DATA', $post);
//			$test = Session::get('BACK_DATA');
//			var_dump($post);
		}

		foreach($post as $k=>$p)
		{
//			$this->arrResult['arrHidden'][$k] = $p;
//			$this->arrResult['arrProduct'][$k] = $p;
			$this->arrResult[$k] = $p;
		}
		
		//ブランド情報
		$this->arrResult['shop'] = Tag_Session::getShop();
		$arrTemp = Tag_Item::get_brand(true);
		$arrTemp2 = array();
		foreach($arrTemp as $temp)
		{
			$temp['sort_name'] = strtolower($temp['name']);
			$arrTemp2[] = $temp;
		}
		$arrTemp = $arrTemp2;

		array_multisort(array_column($arrTemp, 'sort_name'), SORT_ASC, $arrTemp);
		$arrBrand = array();
		foreach($arrTemp as $temp)
		{
		    if ($temp['shop_url'] == $this->arrResult['shop'] )
    		    $arrBrand[] = $temp;
		}
		$this->arrResult['arrBrand'] = $arrBrand;
		$where = "parent_category_id <> 0";
		$arrTemp = Tag_Item::get_categories($where);
		$arrCategory = array();
		foreach($arrTemp as $ret)
		{
			$arrCategory[$ret['category_id']] = $ret['name'];
		}
		$this->arrResult['arrCategory'] = $arrCategory;

//		var_dump($this->arrResult['arrProduct']);



		$this->tpl = 'smarty/admin/product/product_confirm.tpl';
		return $this->view;
	}

	public function getData($tbl_name, $key_name, $arrBack)
	{
		$arrTemp = Tag_Item::get_columns($tbl_name);
		foreach($arrTemp as $column)
		{
			$arrColumns[] = $column['Field'];
		}
		$product_id = $arrBack['arrProduct']['product_id'];

		switch($tbl_name)
		{
			case 'dtb_product_category':
			{
				Tag_Item::delete_table($tbl_name, 'product_id', $product_id);
				$arrItem = array();
				$arrItem['product_id'] = $product_id;
				$arrItem['category_id'] = $arrBack['category_id'];
				Tag_Item::insert_table($tbl_name, $arrItem);

			    break;
			}
			case 'dtb_product_price':
			{
				$arrData = array();
				Tag_Item::delete_table($tbl_name, 'dtb_products_product_id', $product_id);
				$arrItem = array();
				$arrItem['dtb_products_product_id'] = $product_id;
				$arrItem['price01'] = $arrBack['arrProduct']['price01'];
				$arrItem['cost_price'] = $arrBack['arrProduct']['cost_price'];
				Tag_Item::insert_table($tbl_name, $arrItem);

				break;
			}
			case 'dtb_product_status':
			{
				Tag_Item::delete_table($tbl_name, 'product_id', $product_id);
				if (isset($arrBack['arrProduct']['status_flg']))
				{
    				$arrItem = array();
    				$arrItem['product_id'] = $product_id;
    				$arrItem['status_flg'] = $arrBack['arrProduct']['status_flg'];
    				Tag_Item::insert_table($tbl_name, $arrItem);
    			}

			    break;
			}
			case 'dtb_images':
			{
				$arrData = array();
				Tag_Item::delete_table($tbl_name, 'dtb_products_product_id', $product_id);
				if (!isset($arrBack[$key_name]['images']))
				    break;
				$c = count($arrBack[$key_name]['images']);
				for($i = 0;$i < $c;$i++)
				{
					if ($arrBack[$key_name]['images'][$i] == '')
						continue;
						
					$arrImages = array();
					$path = explode('/', $arrBack[$key_name]['images'][$i]);
// print('<pre>');
// var_dump($arrBack[$key_name]['images'][$i]);
// var_dump(REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop().'/'.$path[count($path)-1]);
// var_dump(strpos($arrBack[$key_name]['images'][$i], '/temp'));
					if (strpos($arrBack[$key_name]['images'][$i], '/temp') !== false)
					{
					    $p = str_replace('/upload/images/', REAL_UPLOAD_IMAGE_PATH, $arrBack[$key_name]['images'][$i]);

						@mkdir(REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop());
						$perm_num = 757;
						$perm     = sprintf ( "%04d", $perm_num );
						@chmod(REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop(),octdec ( $perm ));
			
						@rename($p, REAL_UPLOAD_IMAGE_PATH.Tag_Session::getShop().'/'.$path[count($path)-1]);
					}
					$arrImages['path'] = $path[count($path)-1];
					$arrImages['tag'] = $arrBack[$key_name]['tags'][$i];
					$arrImages['comment'] = $arrBack[$key_name]['comment'][$i];
					$arrImages['first'] = $i+1;
					$arrImages['dtb_products_product_id'] = $product_id;
//  print('<pre>');
//  var_dump($arrImages);
//  print('</pre>');
					Tag_Item::insert_table($tbl_name, $arrImages);
				}
				break;
			}
			case 'dtb_product_tag':
			{
				$arrData = array();
				Tag_Item::delete_table($tbl_name, 'dtb_products_product_id', $product_id);
				$c = count($arrBack[$key_name]['tag']);
				foreach($arrBack[$key_name]['tag'] as $k=>$v)
//				for($i = 0;$i < $c;$i++)
				{
					if ($v == '')
						continue;
// 					if ($arrBack[$key_name]['tag'][$i] == '')
// 						continue;
					$arrTag = array();
					$arrTag['tag'] = $v;
					$arrTag['dtb_products_product_id'] = $product_id;
					Tag_Item::insert_table($tbl_name, $arrTag);
				}

				break;
			}
			case 'dtb_product_sku':
			{
				$arrData = array();
				Tag_Item::delete_table($tbl_name, 'dtb_products_product_id', $product_id);
				$c = count($arrBack[$key_name]['product_code']);

				$arrPrev = array();
				for($i = 0;$i < $c;$i++)
				{
					if ($arrBack[$key_name]['product_code'][$i] == '')
						continue;
					
					$same = false;
					foreach($arrPrev as $prev)
					{
						if ($prev['product_code'] == $arrBack[$key_name]['product_code'][$i])
						{
							$same = true;
							break;
						}
					}
					if ($same)
						continue;

					$arrSKU = array();
					$arrSKU['product_code'] = $arrBack[$key_name]['product_code'][$i];
					$arrSKU['color_code'] = $arrBack[$key_name]['color_code'][$i];
					$arrSKU['color_name'] = $arrBack[$key_name]['color_name'][$i];
					$arrSKU['size_code'] = $arrBack[$key_name]['size_code'][$i];
					$arrSKU['size_name'] = $arrBack[$key_name]['size_name'][$i];
					$arrSKU['stock'] = $arrBack[$key_name]['stock'][$i];
					$arrSKU['attribute'] = $arrBack['arrProduct']['attribute'];
					$arrSKU['stock_type'] = Tag_Session::getShopType();
					$arrSKU['dtb_products_product_id'] = $product_id;
					Tag_Item::insert_table($tbl_name, $arrSKU);
					$query = DB::query("select id from dtb_product_sku where product_code = '{$arrSKU['product_code']}' ");
					$arrRet = $query->execute()->as_array();
					$product_sku_id = $arrRet[0]['id'];

					if (Tag_Session::getShopType() == SMAREGI)
					{
    					$smaregi_id = Tag_Smaregi::get_smaregi_id($product_id, $arrSKU['color_code'], $arrSKU['size_code']);
    					
    					if (count($smaregi_id) > 0)
    					{
    					    $arrSKU['smaregi_product_id'] = $smaregi_id['smaregi_product_id'];
    					}
    					else
    					{
    					    $shop = Tag_Session::getShop();
        					$sql = "select max(smaregi_product_id) as smaregi_product_id from dtb_smaregi_product where shop_id = '{$shop}'";
        					$query = DB::query($sql);
        					$arrRets = $query->execute()->as_array();
        					if (count($arrRets) > 0)
        					{
        					    $arrSKU['smaregi_product_id'] = $arrRets[0]['smaregi_product_id'] + 1;
        // 						$arrItem['productId'] = $ret['smaregi_product_id'];
        //						var_dump($sql);
        					}
        					$arrSmaregi = array();
        					$arrSmaregi['smaregi_product_id'] = $arrSKU['smaregi_product_id'];
        					$arrSmaregi['size_name'] = $arrSKU['size_name'];
        					$arrSmaregi['color_name'] = $arrSKU['color_name'];
        	// 				$arrSmaregi['color_code'] = $ret['color_code'];
        	// 				$arrSmaregi['size_code'] = $ret['size_code'];
        					$arrSmaregi['product_code'] = $arrSKU['product_code'];
        					$arrSmaregi['dtb_product_sku_id'] = $product_sku_id;
        					$arrSmaregi['product_name'] = $arrBack['arrProduct']['name'];
        					$arrSmaregi['attribute'] = $arrSKU['attribute'];
        					$arrSmaregi['shop_id'] = $shop;
        					$arrSmaregi['stock'] = $arrSKU['stock'];
        					$query = DB::insert('dtb_smaregi_product');
        					$query->set($arrSmaregi)->execute();
    					}
					    $arrSKU['category_id'] = $arrBack['category_id'];
					    $arrSKU['cost_price'] = $arrBack['arrProduct']['cost_price'];
					    $arrSKU['price01'] = $arrBack['arrProduct']['price01'];
					    $arrSKU['stockControlDivision'] = $arrBack['arrProduct']['stockControlDivision'];
					    $arrSKU['info'] = $arrBack['arrProduct']['info'];
					    $arrSKU['comment'] = $arrBack['arrProduct']['comment'];
					    $arrSKU['name'] = $arrBack['arrProduct']['name'];
					    $arrSKU['name_kana'] = $arrBack['arrProduct']['name_kana'];
					    $arrSKU['group_code'] = $arrBack['arrProduct']['group_code'];
                        $this->smaregi_regist(Tag_Session::getShop(), $arrSKU);

    					$s = array();
    					$smaregi_id = Tag_Smaregi::get_smaregi_id($product_id, $arrSKU['color_code'], $arrSKU['size_code']);
    					if (count($smaregi_id) > 0)
    					{
        					$s['shop_id'] = Tag_Session::getShop();
        					$s['productId'] = $smaregi_id['smaregi_product_id'];
        					if ($arrSKU['stock'] == '')
        					    $arrSKU['stock'] = 0;
        					$s['stockAmount'] = $arrSKU['stock'];
        					usleep(500000);
// var_dump("count:".$i);
// var_dump($arrSKU);
        	 				Tag_Smaregi::regist_stock($s, "1", "1", "15");
        	 			}
        	 			$arrPrev[] = $arrSKU;
    	 			}
				}
//print("</pre>");
//exit;
				break;
			}
			case 'dtb_products':
			{
//var_dump($arrBack['arrProduct']['product_id']);
				$arrProduct = Tag_Item::get_detail($product_id,true);
//var_dump($arrColumns);
//var_dump($arrBack);

				if ($arrBack != '')
				{
					$arrData = array();
					foreach($arrColumns as $key)
					{
						foreach($arrBack[$key_name] as $k=>$v)
						{
							if ($k == $key)
							{
								$arrData[$key] = $v;
							}
						}
						if (!isset($arrData[$key]))
						{
							if ($arrProduct[$key] == null)
								$arrData[$key] = 'NULL';
							else
							    $arrData[$key] = $arrProduct[$key];
						}
					}

					if ($arrData['update_date'] == '')
    					$arrData['update_date'] = date('Y-m-d H:i:s');
					if ($arrData['brand_id'] == null)
    					$arrData['brand_id'] = '0';
//var_dump($arrBack['category_id']);
    				$arrData['category_id'] = $arrBack['category_id'];
					Tag_Item::set_table($arrData);
				}
				break;
			}
		}
	}

    public function smaregi_regist($shop, $ret)
    {
        if (isset($ret['smaregi_product_id']))
        	$arrItem['productId'] = $ret['smaregi_product_id'];
    	$arrItem['categoryId'] = $ret['category_id'];
    	$arrItem['productCode'] = $ret['product_code'];
    	$arrItem['productName'] = mb_substr($ret['name'],0, 84);
    	$arrItem['productKana'] = $ret['name_kana'];
    	$arrItem['price'] = $ret['price01'];
    	$arrItem['cost'] = $ret['cost_price'];
    	$arrItem['stockControlDivision'] = $ret['stockControlDivision'];
    	$arrItem['description'] = mb_substr($ret['info'],0, 200);
    	if ($shop == 'brshop')
    	{
    		$arrItem['size'] = $ret['size_name'];
    		$arrItem['color'] = $ret['color_name'];
	    	$arrItem['attribute'] = $ret['attribute'];
    	}
    	$arrItem['groupCode'] = $ret['group_code'];
    // 			$arrItem['taxDivision'] = 1;
    // 			$arrItem['productPriceDivision'] = 1;
    	$res = Tag_Smaregi::regist($shop, $arrItem);
    	$result = json_decode($res,true);
//     	$s = array();
//     	$s['shop_id'] = $arrSmaregi['shop_id'];
//     	$s['productId'] = $arrItem['productId'];
//     	$s['stockAmount'] = $arrSmaregi['stock'];
//     	usleep(500000);
//     	Tag_Smaregi::regist_stock($s, 2, "1", "05");
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

		$tbl_name = "dtb_theme";
		$arrTheme = Tag_Item::get_table(array('id', 'name'), $tbl_name, array('del_flg'=>0));
		$this->arrResult['arrTheme'] = $arrTheme;

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

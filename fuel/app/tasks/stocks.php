<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;

class Stocks
{
    public function run($n = '')
    {
    	define("SHOP_MODE","sugawaraltd");
    	define("STOCK_FILE","/ne_api_sdk_php/log/stock_just".date('Ymd').".log");
    	$path1 = "/var/www/bronline/public";
    	
    	$fp = fopen($path1.STOCK_FILE, 'a+');
    	// 失敗した場合はエラー表示
    	if (!$fp) {
    	    return;
    	}

        $sql = "select A.id,A.product_code,A.stock from dtb_product_sku as A join dtb_products as B on A.dtb_products_product_id = B.product_id where B.shop_id = 9 and B.del_flg = 0";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
    
    	if (count($arrRet) > 0)
    	{
    //		$arrStockResult = array();
    		$url = HTTP_URL."ne_api_sdk_php/api_brnext.php?product_code=1";
    		$res = file_get_contents($url);
    		if ($res != 'null')
    		{
    			$arrResult = json_decode($res,true);
    		}
    		else
    		{
    			$this->outLog($fp,"NE","RESULT FAIL.");
            	fclose($fp);
    			return;
    		}
    		
    		foreach($arrRet as $ret)
    		{
    //			SC_Utils::sfPrintR($url.$ret['product_code']);
    //			$this->outLog($fp, $res, $url.$ret['product_code']);
    //print_r($res);
    
    			$f = false;
    			foreach($arrResult as $ne)
    			{
    				if ($ret['product_code'] == $ne['stock_goods_id'])
    				{
    					$sqlval['stock'] = $ne['stock_free_quantity'];
//     					$sqlval['update_date'] = 'now()';
    					$where = "id = ?";
    	
    	                $sql = "update dtb_product_sku set stock = {$sqlval['stock']} where id = {$ret['id']}";
    	                $this->outLog($fp,'[NE]'.$ret['product_code'],$sql);
//                		$query = DB::query($sql);
    	
    					$this->outLog($fp,'[NE]'.$ret['product_code'],$sqlval['stock']);
    					$this->outLog($fp,'[CUBE]'.$ret['product_code'],$ret['stock']);
    					$f = true;
    				}
    				if ($f) break;
    			}
    		}
    	}
    	fclose($fp);
    }

    function outLog($fp, $name, $data)
    {
    	print($name.":".$data."<br>");
    	fwrite($fp,date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL);
    }
}
?>
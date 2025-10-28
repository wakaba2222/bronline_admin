<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;

class Crossmall
{
    public function run($shop = '')
    {
        if ($shop == '')
        {
            echo "not shop name. error.".PHP_EOL;
            return;
        }
//         $shop
//     	define("SHOP_MODE","guji");
    	$path1 = "/var/www/bronline/public";
        define("STOCK_PATH",$path1."/crossmall/".$shop."/upload/csv/");
        define("STOCK_FILE","stock.csv");
        define("CSV_LINE_MAX",10000);
    	
        $fp = fopen(STOCK_PATH.STOCK_FILE, 'r');
        // 失敗した場合はエラー表示
        if (!$fp) {
            return;
        }

        $arrCSV = array();
        $line_count = 0;
        $all_line_checked = false;

        while (!feof($fp)) {
            $arrCSV = fgetcsv($fp, CSV_LINE_MAX);
        //SC_Utils::sfPrintR($arrCSV);
            // 全行入力チェック後に、ファイルポインターを先頭に戻す
            if (feof($fp) && !$all_line_checked) {
                rewind($fp);
                $line_count = 0;
                $all_line_checked = true;
                break;
            }

            // 行カウント
            $line_count++;
            // ヘッダ行はスキップ
            if ($line_count == 1) {
                continue;
            }
            // 空行はスキップ
            if (empty($arrCSV)) {
                continue;
            }

            $arrVal = array();
            $arrVal['product_code'] = $arrCSV[0];
            $arrVal['stock'] = $arrCSV[1];
            
        	$this->updateStock($arrVal,$shop);
        }
        fclose($fp);

        rename(STOCK_PATH.STOCK_FILE, STOCK_PATH.date("YmdHis")."_stock.csv");
    }

    function updateStock($arrVal,$shop)
    {
        $product_code = $arrVal['product_code'];
        unset($arrVal['product_code']);
        
        $arrRet = DB::select('id')->from('dtb_shop')->where('login_id','=',$shop)->execute()->as_array();
        $shop_id = 0;
        if (count($arrRet) > 0)
            $shop_id = $arrRet[0]['id'];
        
        if ($shop_id == 0)
        {
            echo "unknown shop.".PHP_EOL;
            return;
        }
		$query = DB::update('dtb_product_sku')->join('dtb_products','INNER')->on('dtb_products_product_id', '=', 'product_id');
		$query->and_where('dtb_product_sku.product_code','=',$product_code);
		$query->and_where('dtb_products.shop_id','=',$shop_id);
		$query->set($arrVal);
		$query->execute();
//		echo DB::last_query();
    }

    function sendMail($to, $subject, $body, $from='')
    {
    	mb_language("japanese");
    	mb_internal_encoding("utf-8");
    	mb_send_mail($to, $subject, $body, "From:".$from.PHP_EOL);
    }

    function outLog($name,$data,&$send_data)
    {
    //	print_r($data);
    	$send_data .= date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
    	
    	$fp = fopen(SMA_DIR."stock".date("Ymd").".txt","a+");
    	fwrite($fp,date("Ymd H:i:s"));
    	fwrite($fp,"   ".$name.":".$data.PHP_EOL);
    	fclose($fp);
    }
}
?>
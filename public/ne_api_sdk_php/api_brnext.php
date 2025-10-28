<?php
/**
 * メイン機能と連携するアプリのサンプルです。
 *
 * @since 2013/10/10
 * @copyright Hamee Corp. All Rights Reserved.
 *
*/
define("SHOP_NAME", "B.R.MALL店");

$_GET['receive_id'] = nl2br(htmlspecialchars($_GET['receive_id']));
$_GET['receive_id'] = mb_ereg_replace("[^A-Za-z0-9]","",$_GET['receive_id']);
$_GET['retry'] = nl2br(htmlspecialchars($_GET['retry']));
$_GET['retry'] = mb_ereg_replace("[^0-9]","",$_GET['retry']);

//追加
$_GET['product_code'] = nl2br(htmlspecialchars($_GET['product_code']));
$_GET['product_code'] = mb_ereg_replace("[^A-Za-z0-9-]","",$_GET['product_code']);

$receive_id = $_GET['receive_id'];
$retry = $_GET['retry'];
$product_code = $_GET['product_code'];	//追加

//パラメータを一時的にセッションに保持しておく
session_start();
if (!isset($_SESSION['receive_id']))
	$receive_id = $_GET['receive_id'];
else
	$_SESSION['receive_id'] = $receive_id;

if (!isset($_SESSION['retry']))
	$retry = $_GET['retry'];
else
	$_SESSION['retry'] = $retry;

if (!isset($_SESSION['refresh']))
	$refresh = $_GET['refresh'];
else
	$_SESSION['refresh'] = $refresh;

//追加
if (!isset($_SESSION['product_code']))
	$product_code = $_GET['product_code'];
else
	$_SESSION['product_code'] = $product_code;

//print_r($_GET);
//print_r($receive_id);exit;

require_once('./neApiClient.php') ;
//$quantity = 1;
//$receive_next_id = '1';
//$create_date = '2016-06-16 11:35:19';
//$update_date = '2016-06-16 11:50:54';

// この値を「アプリを作る->API->テスト環境設定」の値に更新して下さい。
// (アプリを販売する場合は本番環境設定の値に更新して下さい)
// このサンプルでは、利用者情報とマスタ情報にアクセスするため、許可して下さい。

// TEST
//define('CLIENT_ID','2MtSORLm5iPWEu') ;
//define('CLIENT_SECRET', 'EST1BvKmgqk7OF3hYxerjuLInMlcHiWtAXR6ZNa5') ;

define('CLIENT_ID','vNRgi3IldbnSu9') ;
define('CLIENT_SECRET', 'Jft1H94LUkZ2AmQYn5BCVIPcEhSGjl8DgNarOuXM') ;

// 本SDKは、ネクストエンジンログインが必要になるとネクストエンジンのログイン画面に
// リダイレクトします。ログイン成功後に、リダイレクトしたい
// アプリケーションサーバーのURIを指定して下さい。
// 呼び出すAPI毎にリダイレクト先を変更したい場合は、apiExecuteの引数に指定して下さい。
$path1 = dirname(__FILE__);
$path1 .= "/token.dat";
$path2 = dirname(__FILE__);
$path2 .= "/rtoken.dat";

$pathinfo = pathinfo(strtok($_SERVER['REQUEST_URI'],'?')) ;
$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$pathinfo['dirname'].'/'.$pathinfo['basename'] ;

$a_token = NULL;
$r_token = NULL;

$fp = fopen($path1,"r");
if ($fp)
{
	$a_token = fread($fp, filesize($path1));
	fclose($fp);
}
$fp = fopen($path2,"r");
if ($fp)
{
	$r_token = fread($fp, filesize($path2));
	fclose($fp);
}

//$ret_code = file_get_contents("https://base.next-engine.org/users/sign_in/?client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&redirect_uri=".$redirect_uri);
//


//$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, $redirect_uri, '74c927cd4ea63e05936c1c54ca6e0e5f6149f59f5b22a44495bea4869dc1ca1653a5c3a4602c21bcfbccfacf67cd4c7f14802902f5f2934caec29b05849306c9', '5ee74f7549c08ee4a611c88acbcd6ef5b4538fdb6f14f93d4c191755ea28b43a3eda06bd55505412da2f623ca4b491c48e6c79263e09ddf3c16497ffa191ae03') ;

if (($refresh && $receive_id == 0) || ($a_token == NULL && $r_token == NULL))
	$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, $redirect_uri) ;
else if ($refresh)
	$client = new neApiClient(CLIENT_ID, CLIENT_SECRET) ;
else
	$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, NULL, $a_token, $r_token) ;
//var_dump(date("Y-m-d H:i:s").PHP_EOL);
//var_dump($client->_access_token);
//var_dump($client->_refresh_token);
//var_dump($client);
//exit;
//$query['client_id'] = CLIENT_ID;
//$query['client_secret'] = CLIENT_SECRET;
//$query['redirect_uri'] = NULL;
//$ret = $client->apiExecuteNoRequiredLogin('/users/sign_in/') ;

//$ret = $client->apiExecuteNoRequiredLogin('/api_neauth') ;
//print_r($ret);
//print_r($redirect_uri);
//exit;

////////////////////////////////////////////////////////////////////////////////
// 契約企業一覧を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
//$under_contract_company = $client->apiExecuteNoRequiredLogin('/api_app/company') ;

////////////////////////////////////////////////////////////////////////////////
// 利用者情報を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
//$user = $client->apiExecute('/api_v1_login_user/info') ;

////////////////////////////////////////////////////////////////////////////////
// 商品マスタ情報を取得するサンプル
////////////////////////////////////////////////////////////////////////////////
//$query = array() ;
// 検索結果のフィールド：商品コード、商品名、商品区分名、在庫数、引当数、フリー在庫数
//$query['fields'] = 'stock_goods_id, stock_quantity' ;
// 検索条件：商品コードがredで終了している、かつ商品マスタの作成日が2013/10/31の20時より前
//$query['goods_id-like'] = '%red' ;
//$query['stock_goods_id-eq'] = $scode;
// 検索は0～50件まで
//$query['offset'] = '0' ;
//$query['limit'] = '50' ;

// アクセス制限中はアクセス制限が終了するまで待つ。
// (1以外/省略時にアクセス制限になった場合はエラーのレスポンスが返却される)
//$query['wait_flag'] = '1' ;

// 検索対象の総件数を取得
//$goods_cnt = $client->apiExecute('/api_v1_master_stock/count', $query) ;
// 検索実行
//$goods = $client->apiExecute('/api_v1_master_stock/search', $query) ;

//$query2 = array() ;
//$query2['data'] = "syohin_code,sire_code,jan_code,maker_name,maker_kana,maker_jyusyo,maker_yubin_bangou,kataban,iro,syohin_name,gaikoku_syohin_name,syohin_kbn,toriatukai_kbn,genka_tnk,hyoji_tnk,baika_tnk,gaikoku_baika_tnk,kake_ritu,omosa,haba,okuyuki,takasa,yusou_kbn,syohin_status_kbn,hatubai_bi,zaiko_teisu,hachu_ten,lot,keisai_tantou,keisai_bi,bikou,daihyo_syohin_code,visible_flg,mail_tag,tag,location,mail_send_flg,mail_send_num,gift_ok_flg,size,org_select1,org_select2,org_select3,org_select4,org_select5,org_select6,org_select7,org_select8,org_select9,org_select10,org1,org2,org3,org4,org5,org6,org7,org8,org9,org10,org11,org12,org13,org14,org15,org16,org17,org18,org19,org20,maker_kataban,zaiko_threshold,orosi_threshold,hasou_houhou_kbn,hasoumoto_code,zaiko_su,yoyaku_zaiko_su,nyusyukko_riyu,hit_syohin_alert_quantity,nouki_kbn,nouki_sitei_bi,syohin_setumei_html,syohin_setumei_text,spec_html,spec_text,chui_jiko_html,chui_jiko_text,syohin_jyotai_kbn,syohin_jyotai_setumei,category_code_yauc,category_text,image_url_http,image_alt".PHP_EOL;
//$query2['data'] .= $scode.",,,,,,,,,,,0,0,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,".$quantity.",,,,,,,,,,,,,,,,," ;
//$query2['data_type'] = 'csv';
//$goods2 = $client->apiExecute('/api_v1_master_goods/upload', $query2) ;

// リトライ用のデータパス
$path = dirname(__FILE__);
$path .= "/retry/retry".date("YmdHis").".dat";

//受注一括登録パターンのIDを取得しておく（CSVパターンは１通りしか登録しない）
$query = array();
$query['fields'] = "receive_order_upload_pattern_id,receive_order_upload_pattern_name,receive_order_upload_pattern_format_id,receive_order_upload_pattern_shop_id";
$query['receive_order_upload_pattern_name-eq'] = SHOP_NAME;
$result1 = $client->apiExecute('/api_v1_receiveorder_uploadpattern/info', $query) ;

//if ($result1['result'] == 'error')
//{
//	$client = new neApiClient(CLIENT_ID, CLIENT_SECRET, $redirect_uri, NULL, $r_token);
//	$result1 = $client->apiExecute('/api_v1_receiveorder_uploadpattern/info', $query);
//}
//var_dump($result1);

$pattern_id = 6;//念のため、デフォルトの値を入れておく
if ($result1['result'] == "success")
{
//	if (isset($result1['data'][0]['receive_order_upload_pattern_name']) && ($result1['data'][0]['receive_order_upload_pattern_name']) == "B.R.MALL店")
//		$pattern_id = $result1['data'][0]['receive_order_upload_pattern_id'];
	$pattern_id = 6;//念のため、デフォルトの値を入れておく
}
//var_dump($path1);
if ($result1['result'] == "success")
{
	$fp = @fopen($path1,"w+");
	if ($fp)
	{
		fwrite($fp,$result1['access_token']);
		fclose($fp);
		chmod($path1,0666);
	}
	$fp = @fopen($path2,"w+");
	if ($fp)
	{
		fwrite($fp,$result1['refresh_token']);
		fclose($fp);
		chmod($path2,0666);
	}
}

if (isset($product_code) && $product_code != '')
{
//	print_r('商品在庫検索<br>');
	
	$query = array() ;
	// 検索結果のフィールド：商品コード、商品名、商品区分名、在庫数、引当数、フリー在庫数
	$query['fields'] = 'stock_goods_id, stock_quantity, stock_allocation_quantity, stock_free_quantity' ;
	// 検索条件：商品コードがredで終了している、かつ商品マスタの作成日が2013/10/31の20時より前
	//$query['goods_id-like'] = '%%' ;
	if ($product_code != '1')
	{
		$query['stock_goods_id-eq'] = $product_code;
		// 検索は0～50件まで
		$query['offset'] = '0' ;
		$query['limit'] = '1' ;
	}
	
	// アクセス制限中はアクセス制限が終了するまで待つ。
	// (1以外/省略時にアクセス制限になった場合はエラーのレスポンスが返却される)
	$query['wait_flag'] = '1' ;
	
	// 検索対象の総件数を取得
//	$goods_cnt = $client->apiExecute('/api_v1_master_stock/count', $query) ;
	// 検索実行
	$goods = $client->apiExecute('/api_v1_master_stock/search', $query) ;

	if ($goods['result'] == 'success')
	{
		if ($goods['result'] == "success")
		{
			$fp = @fopen($path1,"w+");
			if ($fp)
			{
				fwrite($fp,$goods['access_token']);
				fclose($fp);
				chmod($path1,0666);
			}
			$fp = @fopen($path2,"w+");
			if ($fp)
			{
				fwrite($fp,$goods['refresh_token']);
				fclose($fp);
				chmod($path2,0666);
			}
		}

		$ret = json_encode($goods['data']);
		print($ret);
	}
	else
		print("-1");

//	var_dump($goods_cnt);
//	print("<br>");
//	var_dump($goods);
//	print("<br>");
	
	//$query2 = array() ;
	//$query2['data'] = "syohin_code,sire_code,jan_code,maker_name,maker_kana,maker_jyusyo,maker_yubin_bangou,kataban,iro,syohin_name,gaikoku_syohin_name,syohin_kbn,toriatukai_kbn,genka_tnk,hyoji_tnk,baika_tnk,gaikoku_baika_tnk,kake_ritu,omosa,haba,okuyuki,takasa,yusou_kbn,syohin_status_kbn,hatubai_bi,zaiko_teisu,hachu_ten,lot,keisai_tantou,keisai_bi,bikou,daihyo_syohin_code,visible_flg,mail_tag,tag,location,mail_send_flg,mail_send_num,gift_ok_flg,size,org_select1,org_select2,org_select3,org_select4,org_select5,org_select6,org_select7,org_select8,org_select9,org_select10,org1,org2,org3,org4,org5,org6,org7,org8,org9,org10,org11,org12,org13,org14,org15,org16,org17,org18,org19,org20,maker_kataban,zaiko_threshold,orosi_threshold,hasou_houhou_kbn,hasoumoto_code,zaiko_su,yoyaku_zaiko_su,nyusyukko_riyu,hit_syohin_alert_quantity,nouki_kbn,nouki_sitei_bi,syohin_setumei_html,syohin_setumei_text,spec_html,spec_text,chui_jiko_html,chui_jiko_text,syohin_jyotai_kbn,syohin_jyotai_setumei,category_code_yauc,category_text,image_url_http,image_alt".PHP_EOL;
	//$query2['data'] .= $scode.",,,,,,,,,,,0,0,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,".$quantity.",,,,,,,,,,,,,,,,," ;
	//$query2['data_type'] = 'csv';
	//$goods2 = $client->apiExecute('/api_v1_master_goods/upload', $query2) ;
	
	exit;
}

//受注データを取得
$query = array();
$query['fields'] = "receive_order_id,receive_order_date,receive_order_purchaser_zip_code,receive_order_purchaser_address1,receive_order_purchaser_address2,receive_order_purchaser_name,";
$query['fields'] .= "receive_order_purchaser_kana,receive_order_purchaser_tel,receive_order_purchaser_mail_address,receive_order_consignee_zip_code,receive_order_consignee_address1,";
$query['fields'] .= "receive_order_consignee_address2,receive_order_consignee_name,receive_order_consignee_kana,receive_order_consignee_tel,receive_order_payment_method_name,receive_order_delivery_name,";
$query['fields'] .= "receive_order_goods_amount,receive_order_tax_amount,receive_order_delivery_fee_amount,receive_order_charge_amount,receive_order_point_amount,receive_order_other_amount,";
$query['fields'] .= "receive_order_total_amount,receive_order_gift_flag,receive_order_hope_delivery_time_slot_name,receive_order_hope_delivery_date,receive_order_worker_text,receive_order_note,receive_order_send_date,receive_order_customer_type_id,receive_order_customer_id";
$query['fields'] .= ",receive_order_shop_cut_form_id,receive_order_creation_date,receive_order_last_modified_date";
$query['receive_order_shop_cut_form_id-eq'] = $receive_id;
$result1 = $client->apiExecute('/api_v1_receiveorder_base/search', $query) ;

if ($result1['result'] == "success")
{
	$fp = @fopen($path1,"w+");
	if ($fp)
	{
		fwrite($fp,$result1['access_token']);
		fclose($fp);
		chmod($path1,0666);
	}
	$fp = @fopen($path2,"w+");
	if ($fp)
	{
		fwrite($fp,$result1['refresh_token']);
		fclose($fp);
		chmod($path2,0666);
	}
}

//var_dump($receive_id);
//
//var_dump($result1);

//受注明細を取得
$query = array();
$query['fields'] = "receive_order_row_goods_name,receive_order_row_goods_id,receive_order_row_unit_price,receive_order_row_quantity,receive_order_row_goods_option";
$query['receive_order_shop_cut_form_id-eq'] = $receive_id;
$result2 = $client->apiExecute('/api_v1_receiveorder_row/search', $query) ;

//var_dump($result2);
if ($result2['result'] == "success")
{
	$fp = @fopen($path1,"w+");
	if ($fp)
	{
		fwrite($fp,$result2['access_token']);
		fclose($fp);
		chmod($path1,0666);
	}
	$fp = @fopen($path2,"w+");
	if ($fp)
	{
		fwrite($fp,$result2['refresh_token']);
		fclose($fp);
		chmod($path2,0666);
	}
}


$retry_flg = false;

if ($retry == '1')	// 1の場合にはすでに受注一括登録処理済みなので一括登録処理はしない
	$retry_flg = true;

if ($result1['result'] == "success" && $result2['result'] == "success")
{
	foreach($result1['data'] as $rev_data)
	{
		//キャンセル処理を行う
		$query = array();
		$query['receive_order_id'] = $rev_data['receive_order_id'];
		//$query['receive_order_last_modified_date'] = date('Y-m-d H:m:s');
		if ($rev_data['receive_order_last_modified_date'] != null)
			$query['receive_order_last_modified_date'] = $rev_data['receive_order_last_modified_date'];
		else
			$query['receive_order_last_modified_date'] = $rev_data['receive_order_creation_date'];
		$query['receive_order_shipped_update_flag'] = 1;
	
		$query['data'] = '<?xml version="1.0" encoding="utf-8"?>';
		$query['data'] .= '<root><receiveorder_base><receive_order_shop_cut_form_id>'.$rev_data['receive_order_shop_cut_form_id'].'</receive_order_shop_cut_form_id>';
		$query['data'] .= '<receive_order_date>'.$rev_data['receive_order_creation_date'].'</receive_order_date><receive_order_cancel_type_id>1</receive_order_cancel_type_id></receiveorder_base></root>';	
		//$query['data'] .= '<receiveorder_row><receive_order_row_goods_id>'
		$result = $client->apiExecute('/api_v1_receiveorder_base/update', $query) ;
//var_dump($result);
		if ($result['result'] == "success")
		{
			$fp = @fopen($path1,"w+");
			if ($fp)
			{
				fwrite($fp,$result['access_token']);
				fclose($fp);
				chmod($path1,0666);
			}
			$fp = @fopen($path2,"w+");
			if ($fp)
			{
				fwrite($fp,$result['refresh_token']);
				fclose($fp);
				chmod($path2,0666);
			}
		}
	
		if (is_array($result))
		{
			//キャンセル処理で失敗した場合の処理
			if ($result['result'] == "error" && $retry_flg == false)
			{
				$retry_flg = true;
				//キャンセルできなかった場合は受注一括登録処理を行う
				order_regist($client, $pattern_id, $rev_data, $result2);

				// リトライ用に伝票番号を出力する
				if ($receive_id != null && $receive_id != 0)
				{
					$fp = fopen($path,"w+");
					if ($fp)
					{
						fwrite($fp,$receive_id);
						fclose($fp);
						chmod($path,0666);
					}
				}
				print("false");
			}
			else if ($result['result'] == "error")
			{
				//キャンセル処理が失敗した場合
				print("false");
			}
			else if ($result['result'] == "success")
			{
				//キャンセル処理が成功した場合
				print("true");
			}
		}
		else
		{
			// リトライ用に伝票番号を出力する
			if ($receive_id != null && $receive_id != 0)
			{
				$fp = fopen($path,"w+");
				if ($fp)
				{
					fwrite($fp,$receive_id);
					fclose($fp);
					chmod($path,0666);
				}
			}
			print("false");
		}	
	}
}
else
{
	// リトライ用に伝票番号を出力する
	$fp = fopen($path,"w+");
	if ($fp)
	{
		fwrite($fp,$receive_id);
		fclose($fp);
		chmod($path,0666);
	}
	print("false");
}
//セッションデータは削除する
unset($_SESSION['receive_id']);
unset($_SESSION['retry']);


//受注一括登録処理
function order_regist($client, $pattern_id, $rev_data, $rev_details)
{
	$keys1 = array("receive_order_shop_cut_form_id","receive_order_date","receive_order_purchaser_zip_code","receive_order_purchaser_address1","receive_order_purchaser_address2","receive_order_purchaser_name",
	"receive_order_purchaser_kana","receive_order_purchaser_tel","receive_order_purchaser_mail_address","receive_order_consignee_zip_code","receive_order_consignee_address1",
	"receive_order_consignee_address2","receive_order_consignee_name","receive_order_consignee_kana","receive_order_consignee_tel","receive_order_payment_method_name","receive_order_delivery_name",
	"receive_order_goods_amount","receive_order_tax_amount","receive_order_delivery_fee_amount","receive_order_charge_amount","receive_order_point_amount","receive_order_other_amount",
	"receive_order_total_amount","receive_order_gift_flag","receive_order_hope_delivery_time_slot_name","receive_order_hope_delivery_date","receive_order_worker_text","receive_order_note");
	
	$keys2 = array("receive_order_row_goods_name","receive_order_row_goods_id","receive_order_row_unit_price","receive_order_row_quantity","receive_order_row_goods_option");
	$keys3 = array("receive_order_send_date","receive_order_customer_type_id","receive_order_customer_id");

	// ステータスの変更をするため、受注一括登録処理を行う
//print("<br>order_regist<br>");
	
	$data = "";
	$data2 = "";
	$data3 = "";
	foreach($keys1 as $k)
	{
		if ($k == "receive_order_date")
		{
			$data .= date("Y/m/d H:i:s", strtotime($rev_data[$k])).",";
		}
		else
			$data .= $rev_data[$k].",";
	}
	foreach($keys3 as $k)
	{
		if ($k == "receive_order_send_date")
		{
			if ($rev_data[$k] == '')
				$data3 .= "0";
			else
				$data3 .= "1";
		}
		else
		{
			$data3 .= ",".$rev_data[$k];
		}
	}

	foreach($rev_details['data'] as $rev_detail)
	{
		$data2 = "";
		foreach($keys2 as $k)
		{
			$data2 .= $rev_detail[$k].",";
		}
		$query = array();
		$query['receive_order_upload_pattern_id'] = $pattern_id;
		$query['data_1'] = "店舗伝票番号,受注日,受注郵便番号,受注住所１,受注住所２,受注名,受注名カナ,受注電話番号,受注メールアドレス,発送郵便番号,発送先住所１,発送先住所２,発送先名,発送先カナ,発送電話番号,支払方法,発送方法,商品計,税金,発送料,手数料,ポイント,その他費用,合計金額,ギフトフラグ,時間帯指定,日付指定,作業者欄,備考,商品名,商品コード,商品価格,受注数量,商品オプション,出荷済フラグ,顧客区分,顧客コード".PHP_EOL;
		$query['data_type_1'] = 'csv';
		$query['data_1'] .= $data.$data2.$data3.PHP_EOL;
		$result = $client->apiExecute('/api_v1_receiveorder_base/upload', $query) ;

		if ($result['result'] == "success")
		{
			$fp = @fopen($path1,"w+");
			if ($fp)
			{
				fwrite($fp,$result['access_token']);
				fclose($fp);
				chmod($path1,0666);
			}
			$fp = @fopen($path2,"w+");
			if ($fp)
			{
				fwrite($fp,$result['refresh_token']);
				fclose($fp);
				chmod($path2,0666);
			}
		}
//		var_dump($query['data_1']);
//		var_dump($result);
	}
}
?>
<!--
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
		</script>
	</head>
	<body>
		<pre><?php var_dump($user) ; ?></pre>
		<pre><?php var_dump($goods2) ; ?></pre>
	</body>
</html>
-->
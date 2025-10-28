<?php

$path = dirname(__FILE__);
$files = array();

if ($dir = opendir($path)) {
    while (($file = readdir($dir)) !== false) {
        if ($file != "." && $file != "..") {
        	if ($file != 'retry.php')
	            $files[] = $file;
        }
    } 
    closedir($dir);
}


//print_r($files);
//exit;

foreach($files as $f)
{
	$receive_id = 0;
	$fp = null;
	$fp = fopen($path."/".$f,"r");
	if ($fp)
	{
		$receive_id = fread($fp, filesize($path."/".$f));
		fclose($fp);
		print("<br>del:".$path."/".$f);
		unlink($path."/".$f);
	}
	
	if ($receive_id == 0)
	{
		print("<br>rev:".$receive_id);
		continue;
	}
	else
	{
		$ret = null;
$url = "https://demo:testtest@dev.bronline.jp/ne_api_sdk_php/api_brnext.php?retry=1&receive_id=".$receive_id;
$options['ssl']['verify_peer']=false;
$options['ssl']['verify_peer_name']=false;
$ret = file_get_contents($url, false, stream_context_create($options));
//		$ret = file_get_contents(");
		print("<br>ret:[".$ret."]");

//		print(strlen($ret));
//		print("<br>".strpos($ret,"true"));
		if (strpos($ret,"true") == 0)
		{
			print("<br>OK");
			continue;
		}
		else
		{
			$new_path = $path."/retry".date("YmdHis").".dat";
			print("<br>NG:".$new_path);
			$fp = fopen($new_path,"w+");
			if ($fp)
			{
				fwrite($fp,$receive_id);
				fclose($fp);
				chmod($new_path,0666);
			}
			sleep(1);
		}
	}
}

?>
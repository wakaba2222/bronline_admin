<?php
$url = "https://demo:testtest@dev.bronline.jp/ne_api_sdk_php/api_brnext.php?receive_id=0";
$options['ssl']['verify_peer']=false;
$options['ssl']['verify_peer_name']=false;
$response = file_get_contents($url, false, stream_context_create($options));

var_dump($response);
?>

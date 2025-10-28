<?php
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=”UTF-8">
 
 		<!-- ↓Amazon Pay JavaScript -->
 		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    	<script type='text/javascript'>
       		let clientId = "<?php echo $ama['client_id'] ?>"; 
      		let sellerId = "<?php echo $ama['merchant_id'] ?>";
    
			// Amazonログインコールバック
      		window.onAmazonLoginReady = function() {
        		amazon.Login.setClientId(clientId);
        		amazon.Login.setUseCookie(false); //popup=falseにときに必要
      		};
			// Amazonペイメントコールバック
      		window.onAmazonPaymentsReady = function() {
      			// ボタン表示
        		showLoginButton();
      		};
			// AmazonPayボタン
      		function showLoginButton() {
       			var authRequest;
          		OffAmazonPayments.Button(
          			"AmazonPayButton",
          			sellerId, {
            			type:  "PwA",	// LwA
            			color: "Gold",	// LightGray、DarkGray
            			size:  "small",	// medium、large、x-large
            			// 認証
            			authorization: function() {
              				loginOptions = {
              					scope: "profile payments:widget payments:shipping_address",
              					popup: true
              				};
              				// loginOptions = {scope: "profile payments:widget payments:shipping_address", popup: false};
              				// 決済金額（amount）、注文番号（order_id）は本番ではセッションで渡す？
              				authRequest = amazon.Login.authorize (
              					loginOptions,
              					"https://dev.bronline.jp/paytest/amazon?amount=<?php echo $amount ?>&order_id=<?php echo $order_id ?>"
              				);
            			},
            			onError: function(error) {
                			//document.getElementById("errorCode").innerHTML = error.getErrorCode();
                			//document.getElementById("errorMessage").innerHTML = error.getErrorMessage();
            			}
					}
				);
      		}
		</script>

		<!-- ウィジェット追加 -->
    	<script type='text/javascript' src="<?php echo $ama['url_widget_js'] ?>" async="async">
 		</script>

 		<script type='text/javascript'>
 			document.getElementById('Logout'].onclick = function() {
 				amazon.Login.logout();
 			}
		</script>
		<!-- ↑Amazon Pay JavaScript -->
 		
	</head>

	<script>
	</script>

	<body>

<?php
	// 処理結果の確認
	if ( isset( $link_res['error'] ) ) {
		if ( $link_res['error'] == true ) {
			echo 'エラー詳細コード：'.$link_res['error_id'].'<br>';
		} else {
			echo 'オーダーID['.$order_id.']は正常に処理されました。<br>';
		}
		echo '<pre>';
		print_r( $link_res );
		echo '</pre>';
	}
?>
注文番号　：<?php echo $order_id ?><br>
お支払金額：<?php echo $amount ?><br>
<br>
		<form action="#" method="POST">
			<input type="radio" name="template" value="pc" <?php echo ( $template_no == '1' ) ? 'checked' : '' ?>>PC
			<input type="radio" name="template" value="sp" <?php echo ( $template_no == '2' ) ? 'checked' : '' ?>>スマホ
			<button type="submit">リンクタイプ切替</button>
		</form>

		<br><br><br>
		<form action="<?php echo $gmo['url_multi_entry'] ?>" method="POST">
<?php
	// GMOリンクタイプ購入ページのパラメータ
	echo $gmo_entry_param;
?>
			<button type="submit">GMOクレジットカード購入画面へ進む</button>
		</form>

		<br><br><br>
		<form action="<?php echo $gmo['url_member_edit'] ?>" method="POST">
<?php
	// GMOリンクタイプカード編集ページの呼び出し
	echo $gmo_member_param;
?>
			<button type="submit">GMOカード編集画面へ進む</button>
		</form>

		<br><br><br>
		<!-- AmazonPayボタンの配置 -->
        <div id="AmazonPayButton"></div>
        <label style="font-size: 14px;line-height: 23px;">Amazonアカウントにご登録の住所・クレジットカード情報を利用して、簡単にご注文が出来ます。<br></label>
		
		<br><br><br>
		<form action="https://dev.bronline.jp/paytest/shop"  method="POST">
			<button type="submit">ショップ管理画面の機能へ</button>
			<BR>
		</form>

<?php
//phpinfo();
?>
	</body>
</html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=”UTF-8">
	</head>

	<script>
	</script>

	<body>
		<?php echo $method ?>で呼び出し<br>
		<pre>
		<?php print_r( $debug ) ?><br>
		<?php print_r( $err_list ) ?><br>
		</pre>
		<?php echo $label ?>

		<!-- 取引照会に必要なタグ：OrderID -->
		<form action="#" method="post">
オーダーID<input type="text" name="OrderID" value="<?php echo $order_id ?>"><BR>
			<button type="submit" name="search_trade">GMO照会</button>
			<BR>
		</form>
		<br>

		<!-- 取引変更に必要なタグ：AccessID、AccessID、JobCd -->
		<form action="#" method="post">
オーダーID<input type="text" name="OrderID" value="<?php echo $order_id ?>"><BR>
取引ID<input type="text" name="AccessID" value="<?php echo $access_id ?>"><BR>
取引パスワード<input type="text" name="AccessPass" value="<?php echo $access_pass ?>"><BR>
金額（実売上時のみ）<input type="text" name="Amount" value=""><BR>
処理区分
			<select name="JobCd">
				<option value="SALES">SALSE:実売上</option>
				<option value="VOID">VOID:取消</option>
				<option value="RETURN">RETURN:返品</option>
				<option value="RETURNX">RETURNX:月跨返品</option>
			</select>
			<br>
			<button type="submit" name="alter_tran">GMO取引変更</button>
			<br>
		</form>
		<br><br>


		<!-- Amazon売上請求に必要なタグ：amazonAuthorizationId、amount -->
		<form action="#" method="post">
AmazonオーソリID<input type="text" name="amazonAuthorizationId" value=""><br>
売上請求金額<input type="text" name="amount" value=""><br>
			<button type="submit" name="amazon_capture">Amazon売上請求</button>
			<BR>
		</form>
		<br>

		<!-- Amazon返金リクエストに必要なタグ：amazonOrderReferenceId -->
		<form action="#" method="post">
AmazonオーダーID<input type="text" name="amazonOrderReferenceId" value=""><br>
			<button type="submit" name="amazon_cancel">Amazon取消</button>
			<BR>
		</form>
		<br>



		<!-- Amazon返金リクエストに必要なタグ：amazonCaptureId、amount -->
		<form action="#" method="post">
Amazon売上請求ID<input type="text" name="amazonCaptureId" value="<?php echo $amazonCaptureId ?>"><br>
返金金額<input type="text" name="amount" value="<?php echo $amount ?>"><br>
			<button type="submit" name="amazon_refund">Amazon返金リクエスト</button>
			<BR>
		</form>
		<br>

		<!-- Amazon返金状態確認に必要なタグ：amazonRefundId -->
		<form action="#" method="post">
Amazon返金ID<input type="text" name="amazonRefundId" value="<?php echo $amazonRefundId ?>" readonly><br>
返金状態<input type="text" name="refundState" value="<?php echo $refundState ?>" readonly><br>
			<button type="submit" name="amazon_refund_status">Amazon返金状態確認</button>
			<BR>
		</form>
		<br><br>

		<!-- Amazon一括返金リクエストに必要なタグ：amazonCaptureId、amount -->
		<form action="#" method="post">
			<button type="submit" name="amazon_refund_once">Amazon一括返金リクエスト</button>
			<BR>
		</form>
		<br>

		<form action="https://dev.bronline.jp/paytest" method="POST">
			<button type="submit">ユーザ購入画面へもどる</button>
		</form>
	</body>
</html>
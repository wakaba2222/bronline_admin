<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>決済APIテスト</title>
</head>
<body>
		{$test}
		<form action="" method="POST">
			<input type="radio" name="template" value="pc" <?php echo $template_pc ?>PC
			<input type="radio" name="template" value="sp" <?php echo $template_sp ?>スマホ
			<button type="submit">リンクタイプ切替</button>
		</form>

		<br><br><br>
		<form action="" method="POST">
			<button type="submit">GMOクレジットカード購入画面へ進む</button>
		</form>

		<br><br><br>
		<form action="" method="POST">
			<button type="submit">GMOカード編集画面へ進む</button>
		</form>

		<br><br><br>
		<!-- AmazonPayボタンの配置 -->
        <div id="AmazonPayButton"></div>
		
		<br><br><br>
		<form action=""  method="POST">
			<button type="submit">ショップ管理画面の機能へ</button>
			<BR>
		</form>


</body>
</html>
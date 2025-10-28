<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>WPテスト</title>
</head>
<body>

<div>
	<h3><!--{%$title%}--></h3>
	<!--{%$arrData|@debug_print_var%}-->
	<hr/>
	<!--{%$arrTags|@debug_print_var%}-->
</div>

<div>
	<hr/>
	<h3>DEBUG</h3>
	<!--{%$debug|@debug_print_var%}-->
</div>

</body>
</html>
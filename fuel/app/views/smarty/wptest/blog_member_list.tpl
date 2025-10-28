<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>WPテスト</title>
</head>
<body>

<div>
	<h3><!--{%$title%}--></h3>
	<p>取得レコード数 / 総レコード数：<!--{%$arrData['recordNum']%}--> / <!--{%$arrData['maxRecordNum']%}--></p>
	<p>ページ数 / 総ページ数：<!--{%$arrData['pageNum']%}--> / <!--{%$arrData['maxPageNum']%}--></p>
	<ul>
		<!--{%foreach $arrData['arrUsers'] as $user%}-->
		<li>
			<!--{%if $user['image_url'] != ""%}-->
				<img src="<!--{%$user['image_url']%}-->" width="150" />
			<!--{%/if%}-->
			<p>著者：<a href="?entry=<!--{%$user['last_id']%}-->" ><!--{%$user['last_name']%}--> <!--{%$user['first_name']%}--></a>（<!--{%$user['nickname']%}-->）</p>
			<p>リスト肩書き：<!--{%$user['list_degree']%}--></p>
			<!--{%if $user['last_date'] != ""%}-->
				<p>最新記事日付：<!--{%$user['last_date']|date_format:"%Y.%m.%d"%}-->（ID=<!--{%$user['last_id']%}-->）</p>
			<!--{%else%}-->
				<p>最新記事日付：記事なし</p>
			<!--{%/if%}-->
			<p>ショップ：<!--{%$user['shop_name']%}--></p>
			<p>ショップアカウントフラグ：<!--{%$user['flg_shop']%}--></p>
			<hr/>
		</li>
		<!--{%/foreach%}-->
	</ul>
</div>

<div>
	<hr/>
	<h3>DEBUG</h3>
	<!--{%$debug|@debug_print_var%}-->
</div>

</body>
</html>
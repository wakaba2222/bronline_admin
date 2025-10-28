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
		<!--{%foreach $arrData['arrPosts'] as $post%}-->
		<li>
			<!--{%if $post['thumb_url'] != ""%}-->
				<img src="<!--{%$post['thumb_url']%}-->" width="150" />
			<!--{%/if%}-->
			<p>タイトル：<a href="?entry=<!--{%$post['ID']%}-->" ><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></a></p>
			<p>サブタイトル：<!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></p>
			<p>日付：<!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
			<p>著者：<!--{%$post['first_name']%}-->　<!--{%$post['last_name']%}-->（<!--{%$post['nickname']%}-->）</p>
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
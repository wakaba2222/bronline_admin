<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/news/">NEWS</a></li>
		<li class="arrow">＞</li>
		<li><!--{%$post['post_title']%}--></li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">NEWS</h2>
</section>
<div class="wrap_contents sub">
	<div class="news_detail">
		<div class="tit">
			<h3><!--{%$post['post_title']%}--></h2>
			<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
			<div class="addthis_inline_share_toolbox_g5mc"></div>
		</div>
		<div class="txt_area">
			<!--{%$post['content']%}-->
		</div>
		<a href="#" onclick="history.back(); return false;" class="back_sys block">戻る</a>
	</div>
</div>

<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li>NEWS</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">NEWS</h2>
</section>
<div class="wrap_contents sub">
	<div class="news_list">
		<!--{%foreach $arrData['arrPosts'] as $post%}-->
		<a href="?entry=<!--{%$post['ID']%}-->">
			<p class="news_thum">
			<!--{%if $post['thumb_url'] != ""%}-->
				<img src="<!--{%$post['thumb_url']%}-->">
			<!--{%else%}-->
				<img src="/common/images/news/thum_news_01.jpg">
			<!--{%/if%}-->
			</p>
			<p class="news_tit"><!--{%$post['post_title']%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></p>
		</a>
		<!--{%/foreach%}-->
	</div>
	<!--{%if 1 < $arrData['maxPageNum']%}-->
		<div class="pager">
		<!--{%if 2 <= $arrData['pageNum']%}-->
			<a class="prev" href="?page=<!--{%$arrData['pageNum']-1%}-->"><span></span></a>
		<!--{%/if%}-->
		<!--{%assign var=from_page value=$arrData['pageNum']-1%}-->
		<!--{%assign var=to_page value=$arrData['pageNum']+1%}-->
		<!--{%if $from_page < 1%}-->
			<!--{%assign var=from_page value=1%}-->
			<!--{%assign var=to_page value=$to_page+1%}-->
		<!--{%/if%}-->
		<!--{%if $arrData['maxPageNum'] < $to_page%}-->
			<!--{%assign var=from_page value=$from_page-1%}-->
			<!--{%assign var=to_page value=$arrData['maxPageNum']%}-->
		<!--{%/if%}-->
		<!--{%if $from_page < 1%}-->
			<!--{%assign var=from_page value=1%}-->
		<!--{%/if%}-->
		<!--{%if $arrData['maxPageNum'] < $to_page%}-->
			<!--{%assign var=to_page value=$arrData['maxPageNum']%}-->
		<!--{%/if%}-->

		<!--{%if 1 < $from_page%}-->
			<a href="?page=1">1</a>
			<p>…</p>
		<!--{%/if%}-->
		<!--{%for $p=$from_page to $to_page %}-->
			<a class="<!--{%if $p == $arrData['pageNum']%}-->active<!--{%/if%}-->" href="?page=<!--{%$p%}-->"><!--{%$p%}--></a>
		<!--{%/for%}-->
		<!--{%if $to_page < $arrData['maxPageNum']%}-->
			<p>…</p>
			<a href="?page=<!--{%$arrData['maxPageNum']%}-->"><!--{%$arrData['maxPageNum']%}--></a>
		<!--{%/if%}-->
		<!--{%if $arrData['pageNum'] < $arrData['maxPageNum']%}-->
			<a class="next" href="?page=<!--{%$arrData['pageNum']+1%}-->"><span></span></a>
		<!--{%/if%}-->
		</div>
	<!--{%/if%}-->
</div>

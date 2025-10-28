<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/search/">SEARCH</a></li>
		<li class="arrow">＞</li>
		<li>“ <!--{%$title%}--> ”</li>
	</ul>
</div>
<section class="tit_page search">
	<h2>“ <!--{%$title%}--> ”</h2>
</section>
<!--{%if 0 < count($arrData['arrPosts'])%}-->
	<section class="grid_container">
		<!--{%*$arrData['arrPosts']|@debug_print_var*%}-->
		<!--{%foreach $arrData['arrPosts'] as $post%}-->
			<!--{%if $post['shop_url'] != ""%}-->
			<a class="grid" href="/mall/<!--{%$post['shop_url']%}-->/<!--{%$post['post_type']%}-->/?entry=<!--{%$post['ID']%}-->">
			<!--{%else%}-->
			<a class="grid" href="/<!--{%$post['post_type']%}-->/?entry=<!--{%$post['ID']%}-->">
			<!--{%/if%}-->
				<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':'<br/>'%}-->">
				<div class="tit_search_result">
					<!--{%if $post['post_type'] == 'feature'%}-->
						<!--{%assign var='ttl' value=$post['title2']|replace:'[BR]':'<br/>' %}-->
						<!--{%assign var='subttl' value=$post['post_title']|replace:'[BR]':'<br/>' %}-->
					<!--{%else%}-->
						<!--{%assign var='ttl' value=$post['post_title']|replace:'[BR]':'<br/>' %}-->
						<!--{%assign var='subttl' value=$post['shop_name'] %}-->
					<!--{%/if%}-->
					<h3><span class="times"><!--{%$subttl%}--></span><!--{%$ttl%}--></h3>
					<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
				</div>
			</a>
		<!--{%/foreach%}-->
	</section>
	<!--{%if 1 < $arrData['maxPageNum']%}-->
		<!--{%assign var=query value=""%}-->
		<!--{%if $article != ""%}-->
			<!--{%assign var=query value="`$query`&article=`$article|escape:"url"`"%}-->
		<!--{%/if%}-->
		<!--{%if $word_article != ""%}-->
			<!--{%assign var=query value="`$query`&word_article=`$word_article|escape:"url"`"%}-->
		<!--{%/if%}-->

		<div class="pager search_result">
		<!--{%if 2 <= $arrData['pageNum']%}-->
			<a class="prev" href="?page=<!--{%$arrData['pageNum']-1%}--><!--{%$query%}-->"><span></span></a>
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
			<a href="?page=1<!--{%$query%}-->">1</a>
			<p>…</p>
		<!--{%/if%}-->
		<!--{%for $p=$from_page to $to_page %}-->
			<a class="<!--{%if $p == $arrData['pageNum']%}-->active<!--{%/if%}-->" href="?page=<!--{%$p%}--><!--{%$query%}-->"><!--{%$p%}--></a>
		<!--{%/for%}-->
		<!--{%if $to_page < $arrData['maxPageNum']%}-->
			<p>…</p>
			<a href="?page=<!--{%$arrData['maxPageNum']%}--><!--{%$query%}-->"><!--{%$arrData['maxPageNum']%}--></a>
		<!--{%/if%}-->
		<!--{%if $arrData['pageNum'] < $arrData['maxPageNum']%}-->
			<a class="next" href="?page=<!--{%$arrData['pageNum']+1%}--><!--{%$query%}-->"><span></span></a>
		<!--{%/if%}-->
		</div>
	<!--{%/if%}-->
<!--{%else%}-->
	<section class="search_result_noarticle">
		<p class="no_article t-center">該当する記事が見つかりませんでした。</p>
		<a href="javascript:void(0)" onclick="javascript:history.back()" class="back_sys block">戻る</a>
	</section>
<!--{%/if%}-->


<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<!--{%if isset($shop_url) && $shop_url != ""%}-->
		<li class="arrow">＞</li>
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<!--{%/if%}-->
		<li class="arrow">＞</li>
		<li>FEATURE</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">FEATURE</h2>
</section>
<section class="sec_2col l_grey under">
	<div class="wrap_contents clearfix">
		<div class="col_left">
			<div class="head_01 clearfix">
				<h2 class="times"><!--{%if $order =="rank"%}-->RANKING<!--{%else%}-->LATEST<!--{%/if%}--></h2>
				<ul class="times fr block">
					<li><a href="<!--{%$mallurl%}-->/feature/" class="<!--{%if $order ==""%}-->active<!--{%/if%}-->">LATEST</a></li>
					<li><a href="<!--{%$mallurl%}-->/feature/?order=rank" class="<!--{%if $order =="rank"%}-->active<!--{%/if%}-->">RANKING</a></li>
				</ul>
			</div>
			<div class="load_list">
				<!--{%foreach $arrData['arrPosts'] as $post%}-->
					<!--{%if $post['flg_shop']%}-->
					<a class="cel_feature block" href="/mall/<!--{%$post['shop_url']%}-->/feature/?entry=<!--{%$post['ID']%}-->">
					<!--{%else%}-->
					<a class="cel_feature block" href="/feature/?entry=<!--{%$post['ID']%}-->">
					<!--{%/if%}-->
						<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
						<div class="tit_feature">
							<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
							<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
						</div>
					</a>
				<!--{%/foreach%}-->
			</div>
			<!--{%if 1 < $arrData['maxPageNum']%}-->
				<!--{%if $arrData['pageNum'] == ""%}-->
					<!--{%assign var=next_page value=1%}-->
				<!--{%else%}-->
					<!--{%assign var=next_page value=$arrData['pageNum']+1%}-->
				<!--{%/if%}-->
				<a id="btn_more" href="<!--{%$mallurl%}-->/feature/?page=<!--{%$next_page%}-->&order=<!--{%$order%}-->" class="btn_more times" onclick="return false;">LOAD MORE<i class="icon-arrow_down"></i></a>
				<input type="hidden" id="loading_max_page" value="<!--{%$arrData['maxPageNum']%}-->" />
			<!--{%/if%}-->
			<p id="loading" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
		</div>

		<!--{%include file='smarty/common/include/feature_side.tpl'%}-->
	</div>
</section>

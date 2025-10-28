<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_2col l_grey">
	<div class="wrap_contents clearfix">
		<div class="col_left">
			<div class="head_01 clearfix">
				<h2 class="times">FEATURE</h2>
				<ul class="times fr block">
					<li><a href="" data-order="" class="btn_order <!--{%if $order ==""%}-->active<!--{%/if%}-->" onclick="return false;">LATEST</a></li>
					<li><a href="" data-order="rank" class="btn_order <!--{%if $order =="rank"%}-->active<!--{%/if%}-->" onclick="return false;">RANKING</a></li>
					<li>|</li>
					<li><a href="<!--{%$mallurl%}-->/feature/" class="btn_viewall"><i class="icon-list"></i> VIEW ALL</a></li>
				</ul>
			</div>
			<div class="load_list">
				<!--{%foreach $arrFeature['arrPosts'] as $post%}-->
					<!--{%if $post['flg_shop']%}-->
					<a class="cel_feature block" href="/mall/<!--{%$post['shop_url']%}-->/feature/?entry=<!--{%$post['ID']%}-->">
					<!--{%else%}-->
					<a class="cel_feature block" href="/feature/?entry=<!--{%$post['ID']%}-->">
					<!--{%/if%}-->
						<img class="block" src="<!--{%$post['thumb_url']|replace:'dev':'www'%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
						<div class="tit_feature">
							<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
							<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
							<p class="intro"><!--{%$post['content_excerpt']%}-->…</p>
						</div>
					</a>
				<!--{%/foreach%}-->
			</div>
			<!--{%if 1 < $arrFeature['maxPageNum']%}-->
				<!--{%if $arrFeature['pageNum'] == ""%}-->
					<!--{%assign var=next_page value=1%}-->
				<!--{%else%}-->
					<!--{%assign var=next_page value=$arrFeature['pageNum']+1%}-->
				<!--{%/if%}-->
				<a id="btn_more" href="/?page=<!--{%$next_page%}-->&order=<!--{%$order%}-->" class="btn_more times">LOAD MORE<i class="icon-arrow_down"></i></a>
				<input type="hidden" id="loading_max_page" value="<!--{%$arrFeature['maxPageNum']%}-->" />
			<!--{%/if%}-->
			<p id="loading" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
		</div>

		<!--{%include file='smarty/common/include/feature_side.tpl'%}-->
	</div>
</section>

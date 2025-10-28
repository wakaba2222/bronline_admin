<!--{%if 0 < count($arrRelated['arrPosts'])%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_slide justin related">
	<div class="wrap_contents">
		<div class="head_01 tit_jp clearfix">
			<h2 class="">関連スナップ</h2>
			<a href="/stylesnap/" class="fr btn_jp">STYLE SNAP TOP</a>
		</div>
		<div class="slide_justin related">
			<!--{%foreach $arrRelated['arrPosts'] as $post%}-->
			<div class="load_list2">
				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="/mall/<!--{%$post['shop_url']%}-->/stylesnap/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="/stylesnap/?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img src="<!--{%$post['thumb_url']%}-->">
					<p class="shop_snap times"><!--{%$post['last_name']%}--> <!--{%$post['first_name']%}--></p>
					<div class="tit_snap"><!--{%$post['post_title']%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></div>
				</a>
			</div>
			<!--{%/foreach%}-->
			<!--{%if 1 < $arrRelated['maxPageNum']%}-->
				<!--{%if $arrRelated['pageNum'] == ""%}-->
					<!--{%assign var=next_page2 value=1%}-->
				<!--{%else%}-->
					<!--{%assign var=next_page2 value=$arrRelated['pageNum']+1%}-->
				<!--{%/if%}-->
				<!--{%if isset($entry) %}-->
				<a id="btn_more2" href="<!--{%$mallurl%}-->/stylesnap/?entry=<!--{%$entry%}-->&page2=<!--{%$next_page2%}-->" class="btn_more times sp_portrait_only">LOAD MORE<i class="icon-arrow_down"></i></a>
				<!--{%else%}-->
				<a id="btn_more2" href="<!--{%$mallurl%}-->/item/?detail=<!--{%$arrItem.product_id%}-->&page2=<!--{%$next_page2%}-->" class="btn_more times sp_portrait_only">LOAD MORE<i class="icon-arrow_down"></i></a>
				<!--{%/if%}-->
				<input type="hidden" id="loading_max_page2" value="<!--{%$arrRelated['maxPageNum']%}-->" />
			<!--{%/if%}-->
			<p id="loading2" class="t-center loading sp_portrait_only"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
		</div>
	</div>
</section>
<!--{%/if%}-->

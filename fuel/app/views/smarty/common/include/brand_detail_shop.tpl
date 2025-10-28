<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/brand/">BRAND</a></li>
		<li class="arrow">＞</li>
		<li><!--{%$post['post_title']%}--></li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times"><!--{%$post['post_title']%}--></h2>
</section>
<div class="wrap_itemlist clearfix">
<!--{%if $post['post_content'] != ""%}-->
<section class="introduction">
	<!--{%if $post['image_url'] != ""%}-->
	<div class="mainvisual"><img src="<!--{%$post['image_url']%}-->" alt="<!--{%$post['post_title']%}-->"></div>
	<!--{%/if%}-->
	<div class="txt_area">
		<h3><!--{%$post['post_title']%}-->　<span>/　<!--{%$post['brand_kana']%}--></span></h3>
		<div class="entry">
			<!--{%$post['post_content']%}-->
		</div>
	</div>
</section>
<!--{%/if%}-->
<!--{%if $filter == 'off'%}-->
<!--{%include file='smarty/common/include/item/filter_off.tpl'%}-->
<!--{%else%}-->
<!--{%include file='smarty/common/include/item/filter_on.tpl'%}-->
<!--{%/if%}-->
<!--{%include file='smarty/common/include/item/sort.tpl'%}-->
<!--{%include file='smarty/common/include/item/list.tpl'%}-->
</div>
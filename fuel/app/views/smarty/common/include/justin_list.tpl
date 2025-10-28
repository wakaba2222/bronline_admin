<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<!--{%if $shop_url != ""%}-->
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<li class="arrow">＞</li>
		<!--{%/if%}-->
		<li>JUST IN</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">JUST IN</h2>
</section>
<div class="wrap_itemlist clearfix">
<!--{%if $filter == 'off'%}-->
<!--{%include file='smarty/common/include/item/filter_off.tpl'%}-->
<!--{%else%}-->
<!--{%include file='smarty/common/include/item/filter_on.tpl'%}-->
<!--{%/if%}-->
<!--{%include file='smarty/common/include/item/sort.tpl'%}-->
<!--{%include file='smarty/common/include/item/list.tpl'%}-->
</div>
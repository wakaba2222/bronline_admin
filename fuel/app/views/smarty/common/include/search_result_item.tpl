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
<div class="wrap_itemlist clearfix">
<!--{%if $filter == 'off'%}-->
<!--{%include file='smarty/common/include/item/filter_off.tpl'%}-->
<!--{%else%}-->
<!--{%include file='smarty/common/include/item/filter_on.tpl'%}-->
<!--{%/if%}-->
<!--{%include file='smarty/common/include/item/sort.tpl'%}-->
<!--{%include file='smarty/common/include/item/list.tpl'%}-->
</div>

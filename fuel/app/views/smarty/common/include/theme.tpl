<div class="wrap_itemlist clearfix">
<section class="introduction">
	<div class="mainvisual"><img src="<!--{%$post['image_url']%}-->" alt="<!--{%$post['post_title']%}-->"></div>
	<div class="txt_area">
		<h3><!--{%$post['post_title']%}--></h3>
		<div class="entry">
			<!--{%$post['post_content']%}-->
		</div>
	</div>
</section>
<!--{%if $filter == 'off'%}-->
<!--{%include file='smarty/common/include/item/filter_off.tpl'%}-->
<!--{%else%}-->
<!--{%include file='smarty/common/include/item/filter_on.tpl'%}-->
<!--{%/if%}-->
<!--{%include file='smarty/common/include/item/sort.tpl'%}-->
<!--{%include file='smarty/common/include/item/list.tpl'%}-->
</div>
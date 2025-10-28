<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/adbnr_big.tpl'%}-->
<!--{%include file='smarty/common/include/brshop/header_comming_shop.tpl'%}-->
<!--{%include file='smarty/common/include/attention.tpl'%}-->
<div id="comingsoon" class="t-center">
	<h3 class="times">Coming Soon</h3>
	<p class="bold">SPECIAL STOREは現在閉店中です<br>次回の開催まで楽しみにお待ちください</p>
	<a href="/" class="submit_sys block">トップページへ</a>
</div>
<!--{%include file='smarty/common/include/brshop/adbnr_middle_shop.tpl'%}-->
<!--{%include file='smarty/common/include/brshop/feature_under_shop.tpl'%}-->
<!--{%include file='smarty/common/include/adbnr_2col.tpl'%}-->
<!--{%include file='smarty/common/include/style_snap.tpl'%}-->
<!--{%*include file='smarty/common/include/editors_choice.tpl'*%}-->
<!--{%include file='smarty/common/include/blog_renew.tpl'%}-->
<!--{%*include file='smarty/common/include/blog_shoptop.tpl'*%}-->

<!--{%*
<!--{%if ($arrFeature['arrPosts']|count) == 0%}-->
		<!--{%assign var=inc_side_url value="/var/www/bronline/fuel/app/views/smarty/nofeature/`$shop_url`.tpl"%}-->
		<!--{%if file_exists($inc_side_url)%}-->
		<!--{%include file=$inc_side_url%}-->
		<!--{%/if%}-->
<!--{%/if%}-->
*%}-->

<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

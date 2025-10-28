<!-- viewed -->
<!--{%if $arrCheckItem|count%}-->
<section class="sec_slide justin">
	<div class="wrap_contents">
		<div class="head_01 tit_jp clearfix">
			<h2 class="">チェックしたアイテム</h2>
			<a id="clearview" href="javascript:void(0);" class="fr btn_jp">削除する</a>
		</div>

		<div class="slide_justin owl-carousel noloop">
<!--{%foreach from=$arrCheckItem item=arrProduct%}-->
			<div>
				<p class="new mont_medi"><!--{%if $arrProduct.status_flg == '1'%}-->NEW<!--{%/if%}--></p>
				<p class="like_item <!--{%if $arrProduct.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrProduct.product_id%}-->"></p>
				<a class="block" href="/mall/<!--{%if $arrProduct.org_shop%}--><!--{%$arrProduct.org_shop%}--><!--{%else%}--><!--{%$arrProduct.login_id%}--><!--{%/if%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
				<div class="wrap_thum_outer">
						<div class="wrap_thum_inner">
							<img src="/upload/images/<!--{%if $arrProduct.org_shop%}--><!--{%$arrProduct.org_shop%}--><!--{%else%}--><!--{%$arrProduct.login_id%}--><!--{%/if%}-->/<!--{%$arrProduct.path%}-->" alt="<!--{%$arrProduct.title%}-->"/>
						</div>
				</div>
					<div class="tit_justin">
						<p class="brand"><!--{%$arrProduct.brand_name%}--></p>
						<p class="category"><!--{%$arrProduct.name%}--></p>
						<p class="price">¥<!--{%number_format(Tag_Util::taxin_cal($arrProduct.price01))%}--></p>
						<p class="shop times"><!--{%$arrProduct.shop_name%}--></p>
					</div>
				</a>
			</div>
<!--{%/foreach%}-->
	</div>
</section>
<script type="text/javascript" src="/common/js/cart.js"></script>
<script>
$(function(){
	$('#clearview').click(function(){
		var url = "/api/clearviewd.json";

		var data = {};
		var res = sendApi(url, data, view);
	});
});
function view(data)
{
	location.reload();
}
</script>
<!--{%/if%}-->
<!-- viewed -->
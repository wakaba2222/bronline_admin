<!--{%if $arrRelatedItem|count%}-->
<section class="sec_slide justin related">
	<div class="wrap_contents">
		<div class="head_01 tit_jp clearfix">
			<h2 class="">関連するアイテム</h2>
		</div>
		<div class="slide_justin related">
<!--{%foreach key=key from=$arrRelatedItem item=arrProduct%}-->
<!--{%if $sp%}-->
<!--{%if $key < 6%}-->
			<div>
				<p class="new mont_medi"><!--{%if $arrProduct.status_flg == '1'%}-->NEW<!--{%/if%}--></p>
				<p class="like_item <!--{%if $arrProduct.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrProduct.product_id%}-->"></p>
				<a class="block" href="/mall/<!--{%$arrProduct.login_id%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
					<div class="wrap_thum_outer">
						<div class="wrap_thum_inner">
							<img src="/upload/images/<!--{%$arrProduct.login_id%}-->/<!--{%$arrProduct.path%}-->" alt="<!--{%$arrProduct.title%}-->"/>
						</div>
					</div>
					<div class="tit_justin">
					<!--{%*
						<p class="brand"><!--{%$arrProduct.name%}--></p>
						<p class="category"><!--{%$arrProduct.category_name%}--></p>
						<p class="price">¥<!--{%number_format($arrProduct.price01)%}--></p>
						<p class="shop times"><!--{%$arrProduct.shop_name%}--></p>
					*%}-->
					<p class="brand"><!--{%$arrProduct.brand_name%}--></p>
					<p class="category"><!--{%$arrProduct.name%}--></p>
					<p class="price">¥<!--{%number_format(Tag_Util::taxin_cal($arrProduct.price01))%}--></p>
					<p class="shop times"><!--{%$arrProduct.shop_name%}--></p>
					</div>
				</a>
			</div>
<!--{%elseif $key < 10%}-->
			<div class="sp_hidden">
				<p class="new mont_medi"><!--{%if $arrProduct.status_flg == '1'%}-->NEW<!--{%/if%}--></p>
				<p class="like_item <!--{%if $arrProduct.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrProduct.product_id%}-->"></p>
				<a class="block" href="/mall/<!--{%$arrProduct.login_id%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
					<div class="wrap_thum_outer">
						<div class="wrap_thum_inner">
							<img src="/upload/images/<!--{%$arrProduct.login_id%}-->/<!--{%$arrProduct.path%}-->" alt="<!--{%$arrProduct.title%}-->"/>
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
<!--{%/if%}-->

<!--{%else%}-->
<!--{%if $key < 10%}-->
			<div>
				<p class="new mont_medi"><!--{%if $arrProduct.status_flg == '1'%}-->NEW<!--{%/if%}--></p>
				<p class="like_item <!--{%if $arrProduct.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrProduct.product_id%}-->"></p>
				<a class="block" href="/mall/<!--{%$arrProduct.login_id%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
					<div class="wrap_thum_outer">
						<div class="wrap_thum_inner">
							<img src="/upload/images/<!--{%$arrProduct.login_id%}-->/<!--{%$arrProduct.path%}-->" alt="<!--{%$arrProduct.title%}-->"/>
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
<!--{%/if%}-->
<!--{%/if%}-->
<!--{%/foreach%}-->
<!--{%*
			<a class="btn_more times sp_portrait_only" id="sp_more_btn">LOAD MORE<i class="icon-arrow_down"></i></a>
			<p class="t-center loading sp_portrait_only" id="sp_more_load"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
*%}-->
		</div>
	</div>
</section>
<!--{%/if%}-->

<!--{%if $sp%}-->
<script>
$(function(){
	$('.sp_hidden').hide();
	$('#sp_more_load').hide();
	var cnt = <!--{%$arrRelatedItem|count%}-->;
	if (cnt <= 6)
	{
		$('#sp_more_btn').hide();
	}

	$('#sp_more_btn').click(function(){
		$('#sp_more_btn').hide();
		$('.sp_hidden').show();
	});
});
</script>
<!--{%/if%}-->

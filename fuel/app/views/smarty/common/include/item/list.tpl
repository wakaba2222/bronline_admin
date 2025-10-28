<style>
.sale
{
	position: absolute;
    top: 15px;
    left: 15px;
    z-index: 3;
    font-size: 11px;
    line-height: 1.6;
    letter-spacing: 1.0px;
    color: #fff;
    background: #D0021B;
    padding: 0 5px 0px 6px;
}
.price.sales
{
    color: #D0021B;
    background: #fff;
}
.price.sales span
{
	font-size:9px;
}
</style>
<p>
</p>
<section class="list_item">
	<div class="clearfix">
		<!--{%foreach from=$items item=arrProduct%}-->
		<div class="matchHeight">
			<!--{%if $arrProduct.sale_status == 1 && $sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 1%}-->
			<p class="mont_medi sale">シークレットセール対象</p>
			<!--{%elseif $arrProduct.sale_status == 2 && $vip_sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 2%}-->
			<p class="mont_medi sale">VIPシークレットセール対象</p>
			<!--{%else%}-->
			<p class="new mont_medi"><!--{%if $arrProduct.status_flg == '1'%}-->NEW<!--{%/if%}--></p>
			<!--{%/if%}-->
			<p class="like_item <!--{%if $arrProduct.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrProduct.product_id%}-->"></p>
			<!--{%if $shop_url|default:""%}-->
			<a class="block" href="/mall/<!--{%$arrProduct.login_id%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
			<!--{%else%}-->
			<a class="block" href="/mall/<!--{%if $arrProduct.org_shop%}--><!--{%$arrProduct.org_shop%}--><!--{%else%}--><!--{%$arrProduct.login_id%}--><!--{%/if%}-->/item/?detail=<!--{%$arrProduct.product_id%}-->">
			<!--{%/if%}-->
			
				<div class="wrap_thum_outer">
					<div class="wrap_thum_inner">
						<img src="/upload/images/<!--{%if $arrProduct.org_shop%}--><!--{%$arrProduct.org_shop%}--><!--{%else%}--><!--{%$arrProduct.login_id%}--><!--{%/if%}-->/<!--{%$arrProduct.path%}-->" alt="<!--{%$arrProduct.title%}-->"/>
					</div>
				</div>
				<div class="tit_justin">
					<p class="brand"><!--{%$arrProduct.brand_name%}--></p>
					<p class="category"><!--{%$arrProduct.name%}--></p>
			<!--{%if $arrProduct.sale_status == 1 && $sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 1%}-->
						<p class="price sales">¥<!--{%number_format(Tag_Util::sale_cal($arrProduct.price01, $sale_par))%}-->　<span><!--{%$sale_par%}-->%OFF</span></p>
			<!--{%elseif $arrProduct.sale_status == 2 && $vip_sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 2%}-->
						<p class="price sales">¥<!--{%number_format(Tag_Util::sale_cal($arrProduct.price01, $sale_par))%}-->　<span><!--{%$sale_par%}-->%OFF</span></p>
			<!--{%else%}-->
						<p class="price">¥<!--{%number_format(Tag_Util::taxin_cal($arrProduct.price01))%}--></p>
			<!--{%/if%}-->
					<!--{%if $shop_url|default:""%}-->
					<p class="shop times"><!--{%Tag_Item::get_shop($arrProduct.login_id)%}--></p>
					<!--{%else%}-->
					<p class="shop times"><!--{%if $arrProduct.org_shop%}--><!--{%Tag_Item::get_shop($arrProduct.org_shop)%}--><!--{%else%}--><!--{%Tag_Item::get_shop($arrProduct.login_id)%}--><!--{%/if%}--></p>
					<!--{%/if%}-->
				</div>
			</a>
		</div>
		<!--{%foreachelse%}-->
		<p class="no_item t-center">お探しの商品が見つかりませんでした。</p>
	    <a href="javascript:void(0)" onclick="javascript:history.back()" class="back_sys block">戻る</a>
		<!--{%/foreach%}-->
	</div>
	<!--{%if $max > 1%}-->
		<div class="pager">
			<!--{%if 2 <= $page%}-->
				<a class="prev" href="javascript:search('page', <!--{%$page-1%}-->);"><span></span></a>
			<!--{%/if%}-->
			<!--{%assign var=from_page value=$page-1%}-->
			<!--{%assign var=to_page value=$page+1%}-->
			<!--{%if $from_page < 1%}-->
				<!--{%assign var=from_page value=1%}-->
				<!--{%assign var=to_page value=$to_page+1%}-->
			<!--{%/if%}-->
			<!--{%if $max < $to_page%}-->
				<!--{%assign var=from_page value=$from_page-1%}-->
				<!--{%assign var=to_page value=$max%}-->
			<!--{%/if%}-->
			<!--{%if $from_page < 1%}-->
				<!--{%assign var=from_page value=1%}-->
			<!--{%/if%}-->
			<!--{%if $max < $to_page%}-->
				<!--{%assign var=to_page value=$max%}-->
			<!--{%/if%}-->
			<!--{%if 1 < $from_page%}-->
				<a href="javascript:search('page', 1);">1</a>
				<p>…</p>
			<!--{%/if%}-->
			<!--{%for $p=$from_page to $to_page %}-->
				<a class="<!--{%if $p == $page%}-->active<!--{%/if%}-->" href="javascript:search('page', <!--{%$p%}-->);"><!--{%$p%}--></a>
			<!--{%/for%}-->
			<!--{%if $to_page < $max%}-->
				<p>…</p>
				<a href="javascript:search('page', <!--{%$max%}-->);"><!--{%$max%}--></a>
			<!--{%/if%}-->
			<!--{%if $page < $max%}-->
				<a class="next" href="javascript:search('page', <!--{%$page+1%}-->);"><span></span></a>
			<!--{%/if%}-->
		</div>
	<!--{%/if%}-->
</section>
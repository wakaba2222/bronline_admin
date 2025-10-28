<section class="sec_slide justin">
	<div class="wrap_contents">
		<div class="head_01 clearfix sp_portrait_none">
			<h2 class="times">JUST IN</h2>
			<!--{%if $shop_url|default:""%}-->
			<a href="/mall/<!--{%$shop_url%}-->/justin" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
			<!--{%else%}-->
			<a href="/justin" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
			<!--{%/if%}-->
		</div>
		<div class="head_01 t-center sp_portrait_only">
			<h2 class="times">ITEM</h2>
		</div>
		<div class="item_menu sp_portrait_only">
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">JUST IN</span>　/　新着アイテム一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li class="all"><a href="/justin/">ALL ITEMS</a></li>
					<!--{%foreach from=$arrShop item=shop%}-->
					<li><a href="/mall/<!--{%$shop.login_id%}-->/justin/"><!--{%$shop.shop_name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">ITEM</span>　/　アイテムカテゴリ一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li class="all"><a href="/item/">ALL ITEMS</a></li>
					<!--{%foreach from=$arrCategory item=cate%}-->
					<li><a href="/item?category=<!--{%$cate.name%}-->&filter=on"><!--{%$cate.name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">BRAND</span>　/　ブランド一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li class="all"><a href="/brand/">ALL BLAND LIST</a></li>
					<!--{%foreach from=$arrBrand item=brand%}-->
					<li><a href="/brand/?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&amp;':'-and-'%}-->"><!--{%$brand.name|urldecode%}--></a></li>
					<!--{%/foreach%}-->
					<li><a href="/brand/">その他ブランド</a></li>
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">B.R.MALL</span>　/　ショップリスト</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<!--{%foreach from=$arrShop item=shop%}-->
					<li><a href="/mall/<!--{%$shop.login_id%}-->/item/"><!--{%$shop.shop_name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
		</div>
		<!--{%if $justin|count%}-->
		<div class="slide_justin owl-carousel <!--{%if count($justin) < 5 %}--> noloop <!--{%else%}--> loop <!--{%/if%}-->">
		<!--{%foreach from=$justin item=arrProduct%}-->
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
		<!--{%/if%}-->
	</div>
</section>

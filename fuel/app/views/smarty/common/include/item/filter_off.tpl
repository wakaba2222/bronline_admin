<section class="filter" <!--{%* if $url == 'theme?'%}-->style="display:none;"<!--{%/if *%}-->>
	<h3>絞り込む <i class="icon-arrow_down"></i></h3>
	<div class="wrap_filter">
		<div class="item_menu">
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">アイテム</span></p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li class="all"><a href="/<!--{%$url%}-->">ALL ITEMS</a></li>
					<!--{%foreach from=$arrCategory item=cate%}-->
					<li><a href="javascript:addSearch('<!--{%$cate.name%}-->')"><!--{%if $cate.another_name%}--><!--{%$cate.another_name%}--><!--{%else%}--><!--{%$cate.name%}--><!--{%/if%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">サイズ</span></p>
					<p class="plus<!--{%if $size%}--> open<!--{%/if%}-->"><span></span><span></span></p>
				</div>
				<ul<!--{%if $size%}--> style="display: block"<!--{%/if%}-->>
					<li class="all"><a href="javascript:addSizeSearch('')">ALL</a></li>
					<!--{%foreach from=$arrSize item=s%}-->
					<li><a href="javascript:addSizeSearch('<!--{%$s.name%}-->')" <!--{%if $s.active%}-->class="active"<!--{%/if%}-->><!--{%$s.name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
			<!--{%if !isset($brand_detail)%}-->
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">ブランド</span></p>
					<p class="plus<!--{%if $brand%}--> open<!--{%/if%}-->"><span></span><span></span></p>
				</div>
				<ul<!--{%if $brand%}--> style="display: block"<!--{%/if%}-->>
					<li class="all"><a href="javascript:addBrandSearch('')">ALL</a></li>
					<!--{%foreach from=$arrBrand item=brand%}-->
					<li><a id="brand<!--{%$brand.id%}-->" href="javascript:addBrandSearch('brand<!--{%$brand.id%}-->')" <!--{%if $brand.active%}-->class="active"<!--{%/if%}-->><!--{%$brand.name|urldecode%}--></a></li>
					<!--{%/foreach%}-->
					<li><a href="/brand/">その他ブランド</a></li>
				</ul>
			</div>
			<!--{%/if%}-->
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">カラー</span></p>
					<p class="plus<!--{%if $color%}--> open<!--{%/if%}-->"><span></span><span></span></p>
				</div>
				<ul<!--{%if $color%}--> style="display: block"<!--{%/if%}-->>
					<li class="all"><a href="javascript:addColorSearch('')">ALL</a></li>
					<!--{%foreach from=$arrColor item=c%}-->
					<li><a href="javascript:addColorSearch('<!--{%$c.name%}-->')" <!--{%if $c.active%}-->class="active"<!--{%/if%}-->><!--{%$c.name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p><span class="bold">ショップリスト</span></p>
					<p class="plus open"><span></span><span></span></p>
				</div>
				<ul style="display: block">
					<!--{%if $shop_url|default:"" && $urls == 'item'%}-->
						<li class="all"><a href="/item/">ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
						<li><a href="/mall/<!--{%$shop.login_id%}-->/item/" <!--{%if $shop.active%}-->class="active"<!--{%/if%}-->><!--{%$shop.shop_name%}--></a></li>
						<!--{%/foreach%}-->
					<!--{%elseif $urls == 'theme'%}-->
						<li class="all"><a href="/<!--{%$urls%}-->/?filters=<!--{%$filters%}-->">ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
						<li><a href="/mall/<!--{%$shop.login_id%}-->/<!--{%$urls%}-->/?filters=<!--{%$filters%}-->" <!--{%if $shop.active%}-->class="active"<!--{%/if%}-->><!--{%$shop.shop_name%}--></a></li>
						<!--{%/foreach%}-->
					<!--{%else if $urls == 'search'%}-->
						<li class="all"><a href="javascript:addShopSearch('')">ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
						<li><a href="javascript:addShopSearch('<!--{%$shop.login_id%}-->')" <!--{%if $shop.active%}-->class="active"<!--{%/if%}-->><!--{%$shop.shop_name%}--></a></li>
						<!--{%/foreach%}-->
					<!--{%else%}-->
						<li class="all"><a href="/<!--{%$urls%}-->/">ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
						<!--{%if $filters|default:""%}-->
						<li><a href="/mall/<!--{%$shop.login_id%}-->/<!--{%$urls%}-->/?filters=<!--{%$filters%}-->" <!--{%if $shop.active || $shop_url == $shop.login_id%}-->class="active"<!--{%/if%}-->><!--{%$shop.shop_name%}--></a></li>
						<!--{%else%}-->
						<li><a href="/mall/<!--{%$shop.login_id%}-->/<!--{%$urls%}-->/" <!--{%if $shop.active%}-->class="active"<!--{%/if%}-->><!--{%$shop.shop_name%}--></a></li>
						<!--{%/if%}-->
						<!--{%/foreach%}-->
					<!--{%/if%}-->
				</ul>
			</div>
		</div>
	</div>
	<!--{%include file='smarty/common/include/item/side_bnr_pc.tpl'%}-->
</section>
<form method="get" action="?" id="filter_form">
<input type="hidden" name="category" id="category" value="<!--{%$category%}-->"/>
<input type="hidden" name="subcategory" id="subcategory" value="<!--{%$subcategory%}-->"/>
<input type="hidden" name="brand" id="brand" value="<!--{%$brand%}-->"/>
<input type="hidden" name="size" id="size" value="<!--{%$size%}-->"/>
<input type="hidden" name="color" id="color" value="<!--{%$color%}-->"/>
<input type="hidden" name="shopn" id="shop" value="<!--{%$shopn%}-->"/>
<input type="hidden" name="filter" id="filter" value="on"/>
<input type="hidden" name="word_item" id="word_item" value="<!--{%$word_item%}-->"/>
<input type="hidden" name="filters" id="filters" value="<!--{%if isset($filters)%}--><!--{%$filters%}--><!--{%/if%}-->"/>
</form>
<script>
function checkFilter()
{
	$('#filter').val('off');

	if ($('#category').val() != '')
		$('#filter').val('on');
	if ($('#subcategory').val() != '')
		$('#filter').val('on');
	if ($('#brand').val() != '')
		$('#filter').val('on');
	if ($('#size').val() != '')
		$('#filter').val('on');
	if ($('#color').val() != '')
		$('#filter').val('on');
	if ($('#shop').val() != '')
		$('#filter').val('on');
}
function addSearchSub(word, sub)
{
	if (sub != undefined)
	{
		$('#subcategory').val(encodeURIComponent(word));
	}
	else
	{
		$('#category').val(encodeURIComponent(word));
		$('#subcategory').val('');
	}
	$('#filter_form').submit();
}
function delSizeSearch(word)
{
		var str = $('#size').val();
		str = str.replace(word+",", "");
		$('#size').val(str);
	checkFilter();
	$('#filter_form').submit();
}
function addSizeSearch(word)
{
	if (word == '')
		$('#size').val('');
	else
	{
		var str = $('#size').val();
		str += word + ",";
		$('#size').val(str);
	}

	$('#filter_form').submit();
}
function delBrandSearch(word)
{
		var str = $('#brand').val();
		str = str.replace(word+",", "");
		$('#brand').val(str);

	checkFilter();
	$('#filter_form').submit();
}
function addBrandSearch(bid)
{
	var word = $('#'+bid).text();
	
	if (word == '')
		$('#brand').val('');
	else
	{
		word = word;
		var str = $('#brand').val();
		str += word + ",";
		$('#brand').val(str);
	}

	$('#filter_form').submit();
}
function delColorSearch(word)
{
		var str = $('#color').val();
		str = str.replace(word+",", "");
		$('#color').val(str);

	checkFilter();
	$('#filter_form').submit();
}
function addColorSearch(word)
{
	if (word == '')
		$('#color').val('');
	else
	{
		var str = $('#color').val();
		str += word + ",";
		$('#color').val(str);
	}

	$('#filter_form').submit();
}
function delShopSearch(word)
{
		var str = $('#shop').val();
		str = str.replace(word+",", "");
		$('#shop').val(str);

	checkFilter();
	$('#filter_form').submit();
}
function addShopSearch(word)
{
	var filters = $('#filters').val();
	if (filters != '')
	{
		location.href = '/mall/'+word+'/brand?filters='+filters;
		return;
	}
	if (word == '')
		$('#shop').val('');
	else
	{
		var str = $('#shop').val();
		str += word + ",";
		$('#shop').val(str);
	}

	$('#filter_form').submit();
}
function addSearch(word)
{
	$('#category').val(encodeURIComponent(word));
	$('#subcategory').val('');
	$('#brand').val('');
	$('#size').val('');
	$('#color').val('');
	$('#shop').val('');
	$('#filter_form').submit();
}
</script>

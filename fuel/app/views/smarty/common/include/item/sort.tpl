<form method="get" action="?" id="filter_form_page">
<input type="hidden" name="order" id="order" value="<!--{%$order%}-->"/>
<input type="hidden" name="view" id="view" value="<!--{%$view%}-->"/>
<input type="hidden" name="page" id="page" value="<!--{%$page%}-->"/>
<input type="hidden" name="category" id="category" value="<!--{%$category%}-->"/>
<input type="hidden" name="subcategory" id="subcategory" value="<!--{%$subcategory%}-->"/>
<input type="hidden" name="brand" id="brand" value="<!--{%$brand%}-->"/>
<input type="hidden" name="size" id="size" value="<!--{%$size%}-->"/>
<input type="hidden" name="color" id="color" value="<!--{%$color%}-->"/>
<input type="hidden" name="shopn" id="shop" value="<!--{%$shopn%}-->"/>
<input type="hidden" name="word_item" id="word_item" value="<!--{%$word_item%}-->"/>
<input type="hidden" name="filter" id="filter" value="on"/>
<input type="hidden" name="filters" id="filters" value="<!--{%if isset($filters)%}--><!--{%$filters%}--><!--{%/if%}-->"/>
<input type="hidden" name="sale_status" id="sale_status" value="<!--{%$sale%}-->"/>
<input type="hidden" name="sale_status_pre" id="sale_status_pre" value="<!--{%$sale%}-->"/>
</form>
<section class="sort clearfix">
<!--{%if (($customer['sale_status'] == 1 && $sale_flg == 1) || ($customer['sale_status'] == 2 && $vip_sale_flg == 1)) %}-->
	<h3>並び順・件数・価格 <i class="icon-arrow_down"></i></h3>
<!--{%else%}-->
	<h3>並び順・件数 <i class="icon-arrow_down"></i></h3>
<!--{%/if%}-->
	<div class="wrap_sort">
		<div class="item_menu">
			<div>
				<div class="tit_item_menu">
					<p>並び順 / <!--{%if $order == 'update_date'%}-->新着順<!--{%elseif $order == 'price_desc'%}-->価格が高い順<!--{%else%}-->価格が安い順<!--{%/if%}--></p>
					<p class="arrow_down"><span></span></p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li><a href="javascript:search('order','update_date');" <!--{%if $order == 'update_date'%}-->class="active"<!--{%/if%}-->>新着順</a></li>
					<li><a href="javascript:search('order','price_desc');" <!--{%if $order == 'price_desc'%}-->class="active"<!--{%/if%}-->>価格が高い順</a></li>
					<li><a href="javascript:search('order','price_asc');" <!--{%if $order == 'price_asc'%}-->class="active"<!--{%/if%}-->>価格が低い順</a></li>
				</ul>
			</div>
			<div>
				<div class="tit_item_menu">
					<p>表示件数 / <!--{%$view%}-->件</p>
					<p class="arrow_down"><span></span></p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<!--{%foreach from=$arrView item=v%}-->
					<!--{%if $url != 'theme?'%}-->
<!--{%*					<li><a href="/<!--{%$url%}-->view=<!--{%$v.name%}-->" <!--{%if $v.name == $view%}-->class="active"<!--{%/if%}-->>表示件数 <!--{%$v.name%}-->件</a></li>*%}-->
					<li><a href="javascript:search('view','<!--{%$v.name%}-->');" <!--{%if $v.name == $view%}-->class="active"<!--{%/if%}-->>表示件数 <!--{%$v.name%}-->件</a></li>
					<!--{%else%}-->
<!--{%*					<li><a href="/<!--{%$url%}-->filters=<!--{%$filters%}-->&view=<!--{%$v.name%}-->" <!--{%if $v.name == $view%}-->class="active"<!--{%/if%}-->>表示件数 <!--{%$v.name%}-->件</a></li>*%}-->
					<li><a href="javascript:search('view','<!--{%$v.name%}-->');" <!--{%if $v.name == $view%}-->class="active"<!--{%/if%}-->>表示件数 <!--{%$v.name%}-->件</a></li>
					<!--{%/if%}-->
					<!--{%/foreach%}-->
				</ul>
			</div>
<!--{%if (($customer['sale_status'] == 1 && $sale_flg == 1) || ($customer['sale_status'] == 2 && $vip_sale_flg == 1)) %}-->
			<div>
				<div class="tit_item_menu">
					<p>価格タイプ</p>
					<p class="arrow_down"><span></span></p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul>
					<li><a href="javascript:search('sale_status','0');" <!--{%if $sale == 0%}-->class="active"<!--{%/if%}-->>通常表示</a></li>
					<li><a href="javascript:search('sale_status','<!--{%$customer['sale_status']%}-->');" <!--{%if $sale == $customer['sale_status']%}-->class="active"<!--{%/if%}-->>セール対象商品</a></li>
				</ul>
			</div>
<!--{%/if%}-->
		</div>
	</div>
	<script>
	function search(id, val)
	{
		$('#'+id).val(val);
		$('#filter_form_page').submit();
		/*
		var str = "";
		str += 'order='+$('#order').val();
		str += '&view='+$('#view').val();
		str += '&page='+$('#page').val();
		location.href="/<!--{%$url%}-->"+str;
		*/
	}
	</script>
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
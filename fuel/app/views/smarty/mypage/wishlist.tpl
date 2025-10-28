<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">WISH LIST</h2>
</section>

<div class="wrap_itemlist clearfix">
<section class="list_item wishlist">
	<!--{%*$arrData|@debug_print_var*%}-->
	<!--{%if 0 < count($arrData['arrWishData'])%}-->
		<div class="clearfix">
			<!--{%foreach $arrData['arrWishData'] as $data%}-->
			<div class="matchHeight">
				<p class="wish_delete" data-pid="<!--{%$data['product_id']%}-->"><span class="close thick"></span> 削除</p>
				<a class="block" href="/mall/<!--{%$data['login_id']%}-->/item/?detail=<!--{%$data['product_id']%}-->">
					<img src="/upload/images/<!--{%$data['login_id']%}-->/<!--{%$data['path']%}-->" alt="<!--{%$data['title']%}-->">
					<div class="tit_justin">
						<p class="brand"><!--{%$data['name']%}--></p>
						<p class="category">ニットジャケット</p>
						<p class="price">¥<!--{%number_format($data['price01'])%}--></p>
						<p class="shop times"><!--{%$data['shop_name']%}--></p>
					</div>
				</a>
			</div>
			<!--{%/foreach%}-->
		</div>
		<!--{%if 1 < $arrData['maxPageNum']%}-->
			<div class="pager">
			<!--{%if 2 <= $arrData['pageNum']%}-->
				<a class="prev" href="?page=<!--{%$arrData['pageNum']-1%}-->"><span></span></a>
			<!--{%/if%}-->
			<!--{%assign var=from_page value=$arrData['pageNum']-1%}-->
			<!--{%assign var=to_page value=$arrData['pageNum']+1%}-->
			<!--{%if $from_page < 1%}-->
				<!--{%assign var=from_page value=1%}-->
				<!--{%assign var=to_page value=$to_page+1%}-->
			<!--{%/if%}-->
			<!--{%if $arrData['maxPageNum'] < $to_page%}-->
				<!--{%assign var=from_page value=$from_page-1%}-->
				<!--{%assign var=to_page value=$arrData['maxPageNum']%}-->
			<!--{%/if%}-->
			<!--{%if $from_page < 1%}-->
				<!--{%assign var=from_page value=1%}-->
			<!--{%/if%}-->
			<!--{%if $arrData['maxPageNum'] < $to_page%}-->
				<!--{%assign var=to_page value=$arrData['maxPageNum']%}-->
			<!--{%/if%}-->

			<!--{%if 1 < $from_page%}-->
				<a href="?page=1">1</a>
				<p>…</p>
			<!--{%/if%}-->
			<!--{%for $p=$from_page to $to_page %}-->
				<a class="<!--{%if $p == $arrData['pageNum']%}-->active<!--{%/if%}-->" href="?page=<!--{%$p%}-->"><!--{%$p%}--></a>
			<!--{%/for%}-->
			<!--{%if $to_page < $arrData['maxPageNum']%}-->
				<p>…</p>
				<a href="?page=<!--{%$arrData['maxPageNum']%}-->"><!--{%$arrData['maxPageNum']%}--></a>
			<!--{%/if%}-->
			<!--{%if $arrData['pageNum'] < $arrData['maxPageNum']%}-->
				<a class="next" href="?page=<!--{%$arrData['pageNum']+1%}-->"><span></span></a>
			<!--{%/if%}-->
			</div>
		<!--{%/if%}-->
		<a href="#" onclick="history.back(); return false;" class="back_sys block wishlist">戻る</a>
	<!--{%else%}-->
		<p class="none_wishlist">現在お気に入りの商品はございません。</p>
		<div class="btn_area">
			<a href="#" onclick="history.back(); return false;" class="back_sys block">戻る</a>
		</div>
	<!--{%/if%}-->
</section>

</div>

<!--{%include file='smarty/common/include/viewed.tpl'%}-->
<!--{%include file='smarty/common/include/pickup.tpl'%}-->
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

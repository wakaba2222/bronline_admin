<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li>EDITORS' CHOICE</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">EDITORS' CHOICE</h2>
</section>
<div class="wrap_itemlist clearfix">
	<section class="filter style_snap">
		<h3>ショップで絞り込む <i class="icon-arrow_down"></i></h3>
		<div class="wrap_filter">
			<div class="item_menu">
				<div>
					<div class="tit_item_menu">
						<p><span class="bold">ショップリスト</span></p>
						<p class="plus open"><span></span><span></span></p>
					</div>
					<ul style="display: block">
						<li class="all" ><a href="/editorschoice/" class="<!--{%if $shop_url == ''%}--> active <!--{%/if%}-->" >ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
							<!--{%if 0 < $arrShopArticleNum[$shop.login_id]%}-->
							<li><a href="/mall/<!--{%$shop.login_id%}-->/editorschoice/" class="<!--{%if $shop.login_id == $shop_url%}--> active <!--{%/if%}-->" ><!--{%$shop.shop_name%}--></a></li>
							<!--{%/if%}-->
						<!--{%/foreach%}-->
					</ul>
				</div>
			</div>
		</div>
		<!--{%include file='smarty/common/include/item/side_bnr_pc.tpl'%}-->
	</section>
	<section class="list_item style_snap">
		<div class="clearfix">
			<!--{%foreach $arrData['arrPosts'] as $post%}-->
			<div class="matchHeight">
				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="/mall/<!--{%$post['shop_url']%}-->/editorschoice/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img src="<!--{%$post['thumb_url']%}-->">
					<p class="shop_editor times"><!--{%$post['last_name']%}--> <!--{%$post['first_name']%}--></p>
					<div class="tit_editor"><!--{%$post['post_title']%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></div>
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
	</section>
</div>
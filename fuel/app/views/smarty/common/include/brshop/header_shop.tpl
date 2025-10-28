<header>
	<!--{%include file='smarty/common/include/wrap_header.tpl'%}-->
</header>
<ul class="gnav times">
	<li><a href="/justin/">JUST IN</a></li>
	<li><a href="/item/">ITEM</a></li>
	<li><a href="/brand/">BRAND</a></li>
	<li><a href="/feature/">FEATURE</a></li>
	<li><a href="/stylesnap/">STYLE SNAP</a></li>
<!--	<li><a href="/editorschoice/">EDITORS’ CHOICE</a></li> -->
	<li><a href="/blog/">BLOG</a></li>
	<li>|</li>
	<li><a href="/mall/">B.R.MALL</a></li>
</ul>
<div class="shadow fixedsticky"></div>
<div id="header_shop" class="fixedsticky">
	<div class="wrap_contents clearfix">
		<h2 class="inline_b"><a href="/mall/<!--{%$shop_url%}-->/" class="inline_b"><img src="/common/images/mall/<!--{%$shop_url%}-->/logo.svg" alt="<!--{%$shop_name%}-->"></a></h2>
		<p class="mont fr label_popup">POP UP SHOP</p>
<!--{%*
		<div class="toggle_shopmenu"><i class="icon-arrow_down"></i></div>
		<div class="shop_menu">
			<ul>
				<li>
					<div class="toggle">
						<a href="/mall/<!--{%$shop_url%}-->/justin/" class="tit_menu block"><span class="bold">JUST IN</span> / 新着アイテム一覧</a>
					</div>
				</li>
				<li>
					<div class="toggle">
						<p class="tit_menu"><span class="bold">ITEM</span> / アイテムカテゴリ一覧</p>
						<p class="plus"><span></span><span></span></p>
					</div>
					<ul class="menulist_shop">
						<li class="all"><a href="/mall/<!--{%$shop_url%}-->/item/">ALL ITEMS</a></li>
						<!--{%foreach from=$arrCategory item=cate%}-->
						<li><a href="/mall/<!--{%$shop_url%}-->/item?category=<!--{%$cate.name%}-->&filter=on"><!--{%$cate.name%}--></a></li>
						<!--{%/foreach%}-->
					</ul>
				</li>
				<li>
					<div class="toggle">
						<p class="tit_menu"><span class="bold">BRAND</span> / ブランド一覧</p>
						<p class="plus"><span></span><span></span></p>
					</div>
					<ul class="menulist_shop">
						<li class="all"><a href="/mall/<!--{%$shop_url%}-->/brand/">ALL BRAND LIST</a></li>
						<!--{%foreach from=$arrBrand item=brand%}-->
						<li><a href="/mall/<!--{%$shop_url%}-->/brand/?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|urldecode|replace:'&':'-and-'%}-->"><!--{%$brand.name|urldecode%}--></a></li>
						<!--{%/foreach%}-->
						<li><a href="/mall/<!--{%$shop_url%}-->/brand/">その他ブランド</a></li>
					</ul>
				</li>
				<!--{%if isset($article_num['feature']) && 0 < $article_num['feature']%}-->
				<li>
					<div class="toggle">
						<a href="/mall/<!--{%$shop_url%}-->/feature/" class="tit_menu block"><span class="bold">FEATURE</span> / 特集</a>
					</div>
				</li>
				<!--{%/if%}-->
				<!--{%if isset($article_num['stylesnap']) && 0 < $article_num['stylesnap']%}-->
				<li>
					<div class="toggle">
						<a href="/mall/<!--{%$shop_url%}-->/stylesnap/" class="tit_menu block"><span class="bold">STYLE SNAP</span> / スタイリング</a>
					</div>
				</li>
				<!--{%/if%}-->
				<!--{%if isset($article_num['editorschoice']) && 0 < $article_num['editorschoice']%}-->
				<li>
					<div class="toggle">
						<a href="/mall/<!--{%$shop_url%}-->/editorschoice/" class="tit_menu block"><span class="bold">EDITORS' CHOICE</span> / エディターオススメ</a>
					</div>
				</li>
				<!--{%/if%}-->
				<!--{%if isset($article_num['post']) && 0 < $article_num['post']%}-->
				<li>
					<div class="toggle">
						<a href="/mall/<!--{%$shop_url%}-->/blog/" class="tit_menu block"><span class="bold">BLOG</span> / ブログ</a>
					</div>
				</li>
				<!--{%/if%}-->
			</ul>
		</div>
*%}-->
	</div>
</div>
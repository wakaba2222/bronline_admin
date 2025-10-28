<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li>BRAND</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">BRAND</h2>
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
						<li class="all"><a href="/brand">ALL</a></li>
						<!--{%foreach from=$arrShop item=shop%}-->
						<li><a href="/mall/<!--{%$shop.login_id%}-->/brand/"><!--{%$shop.shop_name%}--></a></li>
						<!--{%/foreach%}-->
					</ul>
				</div>
			</div>
		</div>
		<!--{%include file='smarty/common/include/item/side_bnr_pc.tpl'%}-->
	</section>
	<section class="list_item style_snap">
		<ul class="alphabet">
			<li><a href="#A">A</a></li>
			<li><a href="#B">B</a></li>
			<li><a href="#C">C</a></li>
			<li><a href="#D">D</a></li>
			<li><a href="#E">E</a></li>
			<li><a href="#F">F</a></li>
			<li><a href="#G">G</a></li>
			<li><a href="#H">H</a></li>
			<li><a href="#I">I</a></li>
			<li><a href="#J">J</a></li>
			<li><a href="#K">K</a></li>
			<li><a href="#L">L</a></li>
			<li><a href="#M">M</a></li>
			<li><a href="#N">N</a></li>
			<li><a href="#O">O</a></li>
			<li><a href="#P">P</a></li>
			<li><a href="#Q">Q</a></li>
			<li><a href="#R">R</a></li>
			<li><a href="#S">S</a></li>
			<li><a href="#T">T</a></li>
			<li><a href="#U">U</a></li>
			<li><a href="#V">V</a></li>
			<li><a href="#W">W</a></li>
			<li><a href="#X">X</a></li>
			<li><a href="#Y">Y</a></li>
			<li><a href="#Z">Z</a></li>
			<li><a href="#other">その他</a></li>
		</ul>
		<div id="A" class="wrap_brand_list">
			<h3 class="os">A</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['A'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="B" class="wrap_brand_list">
			<h3 class="os">B</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['B'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="C" class="wrap_brand_list">
			<h3 class="os">C</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['C'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="D" class="wrap_brand_list">
			<h3 class="os">D</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['D'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="E" class="wrap_brand_list">
			<h3 class="os">E</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['E'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="F" class="wrap_brand_list">
			<h3 class="os">F</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['F'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="G" class="wrap_brand_list">
			<h3 class="os">G</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['G'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="H" class="wrap_brand_list">
			<h3 class="os">H</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['H'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="I" class="wrap_brand_list">
			<h3 class="os">I</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['I'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="J" class="wrap_brand_list">
			<h3 class="os">J</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['J'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="K" class="wrap_brand_list">
			<h3 class="os">K</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['K'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="L" class="wrap_brand_list">
			<h3 class="os">L</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['L'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="M" class="wrap_brand_list">
			<h3 class="os">M</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['M'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="N" class="wrap_brand_list">
			<h3 class="os">N</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['N'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="O" class="wrap_brand_list">
			<h3 class="os">O</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['O'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="P" class="wrap_brand_list">
			<h3 class="os">P</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['P'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="Q" class="wrap_brand_list">
			<h3 class="os">Q</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['Q'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="R" class="wrap_brand_list">
			<h3 class="os">R</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['R'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="S" class="wrap_brand_list">
			<h3 class="os">S</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['S'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="T" class="wrap_brand_list">
			<h3 class="os">T</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['T'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="U" class="wrap_brand_list">
			<h3 class="os">U</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['U'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="V" class="wrap_brand_list">
			<h3 class="os">V</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['V'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="W" class="wrap_brand_list">
			<h3 class="os">W</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['W'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="X" class="wrap_brand_list">
			<h3 class="os">X</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['X'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="Y" class="wrap_brand_list">
			<h3 class="os">Y</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['Y'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="Z" class="wrap_brand_list">
			<h3 class="os">Z</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['Z'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
		<div id="other" class="wrap_brand_list">
			<h3 class="bold">その他</h3>
			<div class="brand_list">
			<!--{%foreach from=$arrBrandList['NUMERIC'] item=brand%}-->
				<a href="?filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->" class="block">
					<p><!--{%$brand.name%}--></p>
					<span><!--{%$brand.name_kana%}--></span>
				</a>
			<!--{%/foreach%}-->
			</div>
		</div>
	</section>
</div>
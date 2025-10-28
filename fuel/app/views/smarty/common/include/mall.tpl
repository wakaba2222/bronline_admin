<section class="sec_slide l_purple">
	<div class="wrap_contents">
		<div class="head_01 t-center mall_logo">
			<h2><img src="/common/images/logo/brmall_logo.svg" alt="B.R.MALL"><span class="times">SHOP LIST</span></h2>
			<p class="sub">洗練された大人のファッションアイテムを中心に<br>ライフスタイルを提案するショッピングモール</p>
		</div>
		<div class="slide_mall owl-carousel">
			<!--{%foreach from=$arrShop item=shop key=key name=shoploop%}-->
			<!--{%if ($key % 12) == 0%}-->
			<div class="wrap_shop">
			<!--{%/if%}-->
				<a class="shop_logo hovernone" <!--{%if $shop.popup_flg == 1%}-->style="display:none;"<!--{%/if%}--> href="/mall/<!--{%$shop.login_id%}-->/"><img src="/common/images/mall/<!--{%$shop.login_id%}-->/<!--{%$shop.logo_img%}-->"/></a>
			<!--{%if ($key % 12) == 11 || $smarty.foreach.shoploop.last%}-->
			</div>
			<!--{%/if%}-->
			<!--{%/foreach%}-->
<!--{%*
			<div class="wrap_shop">
			<!--{%foreach from=$arrShop item=shop key=key%}-->
			<!--{%if $key >= 12%}-->
				<a class="shop_logo hovernone" href="/mall/<!--{%$shop.login_id%}-->/"><img src="/common/images/mall/<!--{%$shop.login_id%}-->/<!--{%$shop.logo_img%}-->"/></a>
			<!--{%/if%}-->
			<!--{%/foreach%}-->
			</div>
*%}-->
		</div>
		<a href="/mall/" class="block t-center btn_shopping times"><i class="icon-cart_wh"></i>　ENJOY SHOPPING !</a>
		<!--POPUP出店中のみ ここから-->
		<!--<h3 class="mont t-center popup">POP UP SHOP</h3>
		<div class="slide_popup owl-carousel">
			<a href="/mall/damiani/" class="wrap_popup">
				<div class="thum_popup"><img src="/common/images/mall/damiani/bnr_popup.jpg" alt="DAMIANI POP UP SHOP"></div>
				<div class="popup_detail matchHeight">
					<div>
						<h4>DAMIANI POP UP SHOP</h4>
						<p class="txt">1924年、イタリア宝飾の街 ヴァレンツァで創業した＜ダミアーニ＞。一世紀近く続くメゾンの発展を支えてきたのは、その独創性とデザイン、そしてクラフツマンシップ。ここに代々受け継がれてきたジュエリーに対する深い情熱が加わり、メイド・イン・イタリーの高級宝飾品として世界的に認められている＜ダミアーニ＞が、メゾンジュエリーとして初となるB.R.ONLINEのPOP UP SHOPを開催します。</p>
						<p class="date">開催期間：<br>2020年10月15日〜2020年11月16日</p>
					</div>
				</div>
			</a>
		</div>-->
		<!--{%if $arrPopup|count%}-->
		<!--{%/if%}-->
		<!--POPUP出店中のみ ここまで-->
	</div>
</section>

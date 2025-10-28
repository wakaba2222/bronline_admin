<style>
html{scroll-behavior: smooth;}
.go-top.show:hover
{
	background:#ccc;
}
.go-top.show {
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    filter: alpha(opacity=70);
    opacity: .7;
    visibility: visible;
    bottom: 2%;
    display:none;
}
.go-top {
    position: fixed !important;
    right: 15px;
    bottom: -60px;
    color: #fff;
    display: block;
    font-size: 22px;
    line-height: 25px;
    text-align: center;
    width: 40px;
    height: 40px;
    visibility: hidden;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    filter: alpha(opacity=0);
    opacity: 0;
    z-index: 9999;
    cursor: pointer;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 50%;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
    background:#878787;
}
.go-top.show img
{
	width:15px;
}
/*
@media screen and (max-width:698px)
{
	.go-top
	{
	    width: 40px;
	    height: 40px;
	    line-height: 25px;
	    right: 15px;
	}
}
*/
</style>
<script>
$(function(){
	$(window).on('scroll', function(){
		if ($(window).scrollTop() > 300)
		{
			$(".go-top").fadeIn(300);
		}
		else
		{
			$(".go-top").fadeOut(300);
		}
	});
	var title = $(".tit_page h2").text();
	if (title == "PAYMENT")
	{
		$(".go-top.show img").css("position", "relative");
		$(".go-top.show img").css("top", "15px");
	}
});
</script>
<a class="go-top show" href="#top"><img src="/common/images/system/arrow.png" alt="arrow" /></a>
<footer>
	<div class="d_purple">
		<div class="wrap_contents flogo clearfix">
			<h1><img src="/common/images/logo/bronline_logo_wh.svg" alt="B.R.ONLINE"></h1>
			<ul>
				<li class="times">FOLLOW US</li>
				<li><a href="https://www.facebook.com/bronline.jp/" target="_blank"><i class="icon-facebook"></i></a></li>
				<li><a href="https://twitter.com/bronlinejp" target="_blank"><i class="icon-twitter"></i></a></li>
				<li><a href="https://www.instagram.com/b.r.online/" target="_blank"><i class="icon-instagram"></i></a></li>
				<li><a href="https://www.pinterest.jp/bronline/" target="_blank"><i class="icon-pinterest"></i></a></li>
				<li><a href="https://www.youtube.com/channel/UCUWtuyVjeMQygQiy3adHb1g" target="_blank"><i class="icon-youtube"></i></a></li>
				<li><a href="https://lin.ee/EIPUOqx" target="_blank"><!--<i class="icon-line"></i>--><img src="/common/images/ico/svg/icon_line3.svg" style="width:30px;"></a></li>
			</ul>
		</div>
		<div class="wrap_contents fmenu">
			<div class="col_fmenu">
				<h3 class="times">CONTENTS<p class="plus sp_portrait_only"><span></span><span></span></p></h3>
				<ul>
					<li><a href="/justin/">新着アイテム一覧</a></li>
					<li><a href="/item/">アイテムカテゴリ一覧</a></li>
					<li><a href="/brand/">ブランド一覧</a></li>
					<li><a href="/feature/">特集</a></li>
					<li><a href="/stylesnap/">スタイリング</a></li>
					<!--<li><a href="/editorschoice/">エディターオススメ</a></li>-->
					<li><a href="/mall/">B.R.MALLショップ一覧</a></li>
					<li><a href="/blog/">ブログ</a></li>
					<li><a href="/news/">おしらせ</a></li>
				</ul>
			</div>
			<div class="col_fmenu">
				<h3 class="times">SHOPPING GUIDE<p class="plus sp_portrait_only"><span></span><span></span></p></h3>
				<ul>
					<li><a href="/guide/">ご注文について</a></li>
					<li><a href="/guide/payment/">お支払いについて</a></li>
					<li><a href="/guide/delivery/">送料・お届け</a></li>
					<li><a href="/guide/return/">返品・交換</a></li>
					<!--<li><a href="/guide/size/">サイズガイド</a></li>-->
					<li><a href="/guide/faq.php">よくあるご質問</a></li>
					<li>—</li>
					<li><a href="/signup/">ショッピング会員登録</a></li>
					<li><a href="/guide/point/">ポイントについて</a></li>
					<li><a href="/guide/stage/">会員ステージについて</a></li>
				</ul>
			</div>
			<div class="col_fmenu">
				<h3 class="times">ABOUT US<p class="plus sp_portrait_only"><span></span><span></span></p></h3>
				<ul>
					<li><a href="/about/">B.R.ONLINEについて</a></li>
					<li><a href="/about/#aboutmall">B.R.MALLについて</a></li>
					<li><a href="/about/#mallopen">B.R.MALL出店について</a></li>
					<li><a href="/about/#ad">広告掲載について</a></li>
					<li><a href="/about/#company">運営会社（会社概要）</a></li>
					<li><a href="/about/recruit/">求人情報</a></li>
					<li>—</li>
					<li><a href="/about/terms/">利用規約</a></li>
					<li><a href="/about/privacy/">個人情報保護方針</a></li>
					<li><a href="/about/legal/">特定商取引法に基づく表記</a></li>
				</ul>
			</div>
			<div class="col_fmenu">
				<h3 class="times">CONTACT US<p class="plus sp_portrait_only"><span></span><span></span></p></h3>
				<ul>
					<!--<li><a href="/contact/"><i class="icon-mail"></i>　各種お問い合わせ</a></li>-->
					<li><a href="/contact/"><i class="icon-phone"></i>　お問い合わせフォーム</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="wrap_contents">
			<p class="left">2018 © B.R.ONLINE All rights reserved.</p>
			<p class="right">Site Designed by <a href="http://launch.jp/" target="_blank" class="underline">launch inc.</a></p>
		</div>
	</div>
</footer>
<div id="overlay"></div>
</div>

<nav class="drawer-nav">
	<div class="inner hidden">
		<ul class="drawer-menu">
			<li class="logo">
				<div class="close"><span></span></div>
				<a href="/"><img src="/common/images/logo/bronline_logo.svg" alt="B.R.ONLINE"></a>
			</li>

			<!--{%if $customer['name'] == ""%}-->
			<!-- ゲスト -->
			<li>
				<ul class="guest">
					<li class="name_guest">ゲスト<span>さま</span></li>
					<li class="signup"><a href="/signup/">SIGN UP <span>/ 新規会員登録</span></a></li>
				</ul>
			</li>
			<li class="membermenu">
				<ul>
					<li><a href="/signin/">ログイン</a></li>
					<li>|</li>
					<li><a href="/mypage/wishlist">お気に入り</a></li>
				</ul>
			</li>
			<!--{%else%}-->
				<!--{%if $customer['rank'] == 1 %}-->
					<!--{%* メンバーSTANDARD *%}-->
					<!--{%assign var=col value=""%}-->
					<!--{%assign var=rankname value="STANDARD"%}-->

				<!--{%else if $customer['rank'] == 2 %}-->
					<!--{%* メンバーGOLD *%}-->
					<!--{%assign var=col value="gold"%}-->
					<!--{%assign var=rankname value="GOLD"%}-->

				<!--{%else if $customer['rank'] == 3 %}-->
					<!--{%* メンバーPLATINUM *%}-->
					<!--{%assign var=col value="platinum"%}-->
					<!--{%assign var=rankname value="PLATINUM"%}-->

				<!--{%else if $customer['rank'] == 4 %}-->
					<!--{%* メンバーDIAMOND *%}-->
					<!--{%assign var=col value="diamond"%}-->
					<!--{%assign var=rankname value="DIAMOND"%}-->

				<!--{%else if $customer['rank'] == 5 %}-->
					<!--{%* メンバーULTIMATE *%}-->
					<!--{%assign var=col value="ultimate"%}-->
					<!--{%assign var=rankname value="ULTIMATE"%}-->

				<!--{%/if%}-->

			<li class="member <!--{%$col%}-->">
				<ul class="status clearfix">
					<li class="name" id="sidemenu_customer_id" data-cid="<!--{%$customer['customer_id']%}-->"><!--{%$customer['name']%}--> <span>さま</span></li>
					<li class="stage mont"><!--{%$rankname%}--></li>
				</ul>
				<ul class="area_point">
					<li class="point os"><!--{%$customer['point']%}--> <span>point</span></li>
					<li class="percent">ポイント還元率　<span class="os"><!--{%$customer['point_rate']%}--></span>　%</li>
				</ul>
			</li>

			<li class="membermenu">
				<ul>
					<li><a href="/signin?logout=1">ログアウト</a></li>
					<li>|</li>
					<li><a href="/mypage/">マイページ</a></li>
					<li>|</li>
					<li><a href="/mypage/wishlist">お気に入り</a></li>
				</ul>
			</li>
			<!--{%/if%}-->
			<!--<li class="special_bnr">
				<a href="" class="block"><img src="/common/images/bnr/adbnr_slidemenu_special.jpg" alt="特別先行発売"></a>
			</li>-->
			<li class="top_mainmenu"></li>
			<li class="mainmenu">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">JUST IN</span> / 新着アイテム一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li class="all"><a href="/justin/?m=2">ALL ITEMS</a></li>
					<!--{%foreach from=$arrShop item=shop%}-->
					<li><a href="/mall/<!--{%$shop.login_id%}-->/justin/?m=2"><!--{%$shop.shop_name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">ITEM</span> / アイテムカテゴリ一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li class="all"><a href="/item/">ALL ITEMS</a></li>
					<!--{%foreach from=$arrCategory2 item=cate%}-->
						<!--{%if isset($shop_url) && $shop_url != ""%}-->
						<li><a href="/mall/<!--{%$shop_url%}-->/item?m=2&category=<!--{%$cate.name%}-->&filter=on"><!--{%$cate.name%}--></a></li>
						<!--{%else%}-->
						<li><a href="/item?m=2&category=<!--{%$cate.name%}-->&filter=on"><!--{%$cate.name%}--></a></li>
						<!--{%/if%}-->
					<!--{%/foreach%}-->
				</ul>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">BRAND</span> / ブランド一覧</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li class="all"><a class="drawer-dropdown-menu-item" href="/brand/">ALL BLAND LIST</a></li>
					<!--{%foreach from=$arrBrand2 item=brand%}-->
						<!--{%if isset($shop_url) && $shop_url != ""%}-->
						<li><a class="drawer-dropdown-menu-item" href="/mall/<!--{%$shop_url%}-->/brand/?m=2&filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->"><!--{%$brand.name|urldecode%}--></a></li>
						<!--{%else%}-->
						<li><a class="drawer-dropdown-menu-item" href="/brand/?m=2&filters=<!--{%$brand.code%}-->:::<!--{%$brand.name|replace:'&':'-and-'%}-->"><!--{%$brand.name%}--></a></li>
						<!--{%/if%}-->
					<!--{%/foreach%}-->
				</ul>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<a href="/feature/?m=2" class="tit_menu block"><span class="bold">FEATURE</span> / 特集</a>
				</div>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<a href="/stylesnap/?m=2" class="tit_menu block"><span class="bold">STYLE SNAP</span> / スタイリング</a>
				</div>
				<hr>
			</li>
			<!--<li class="mainmenu">
				<div class="toggle">
					<a href="/editorschoice/" class="tit_menu block"><span class="bold">EDITORS' CHOICE</span> / エディターオススメ</a>
				</div>
				<hr>
			</li>-->
			<li class="mainmenu">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">B.R.MALL</span> / ショップリスト</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li class="all"><a class="drawer-dropdown-menu-item" href="/mall/">B.R.MALL TOP</a></li>
					<!--{%foreach from=$arrShop item=shop%}-->
					<li><a class="drawer-dropdown-menu-item" href="/mall/<!--{%$shop.login_id%}-->/?m=2"><!--{%$shop.shop_name%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<a href="/blog/?m=2" class="tit_menu block"><span class="bold">BLOG</span> / ブログ</a>
				</div>
				<hr>
			</li>
			<li class="mainmenu">
				<div class="toggle">
					<a href="/news/?m=2" class="tit_menu block"><span class="bold">NEWS</span> / おしらせ</a>
				</div>
				<hr>
			</li>
			<li class="bottom_mainmenu"></li>
			<!--<li class="adbnr">
				<a href="" target="" class="hovernone block"><img src="/common/images/bnr/adbnr_slidemenu_sample.jpg" alt=""></a>
				<a href="" target="" class="hovernone block"><img src="/common/images/bnr/adbnr_slidemenu_sample.jpg" alt=""></a>
			</li>-->
			<li class="top_submenu"></li>
			<li class="mainmenu sub">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">SHOPPING GUIDE</span> / ご利用ガイド</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li><a class="drawer-dropdown-menu-item" href="/guide/">ご注文について</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/guide/payment/">お支払いについて</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/guide/delivery/">送料・お届け</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/guide/return/">返品・交換</a></li>
					<!--<li><a class="drawer-dropdown-menu-item" href="/guide/size/">サイズガイド</a></li>-->
					<li><a class="drawer-dropdown-menu-item" href="/guide/faq.php">よくあるご質問</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/guide/point/">ポイントについて</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/guide/stage/">会員ステージについて</a></li>
				</ul>
				<hr>
			</li>
			<li class="mainmenu sub">
				<div class="toggle">
					<a href="/signup/" class="tit_menu block"><span class="bold">SIGN UP</span> / ショッピング会員登録</a>
				</div>
				<hr>
			</li>
			<li class="mainmenu sub">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">ABOUT US</span> / B.R.ONLINEについて</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<li><a class="drawer-dropdown-menu-item" href="/about/">B.R.ONLINEについて</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/#aboutmall">B.R.MALLについて</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/#mallopen">B.R.MALL出店について</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/#ad">広告掲載について</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/#company">運営会社（会社概要）</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/recruit/">求人情報</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/terms/">利用規約</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/privacy/">個人情報保護方針</a></li>
					<li><a class="drawer-dropdown-menu-item" href="/about/legal/">特定商取引法に基づく表記</a></li>
				</ul>
				<hr>
			</li>
			<li class="mainmenu sub">
				<div class="toggle">
					<p class="tit_menu"><span class="bold">CONTACT US</span> / お問い合わせ</p>
					<p class="plus"><span></span><span></span></p>
				</div>
				<ul class="menulist drawer-dropdown-menu">
					<!--<li><a class="drawer-dropdown-menu-item" href="/contact/">各種お問い合わせ</a></li>-->
					<li><a class="drawer-dropdown-menu-item" href="/contact/">お問い合わせフォーム</a></li>
				</ul>
				<hr>
			</li>
			<li class="bottom_submenu"></li>
			<li class="followus t-center">
				<p class="times">FOLLOW US</p>
				<ul class="sns">
					<li><a href="https://www.facebook.com/bronline.jp/" target="_blank"><i class="icon-facebook"></i></a></li>
					<li><a href="https://twitter.com/bronlinejp" target="_blank"><i class="icon-twitter"></i></a></li>
					<li><a href="https://www.instagram.com/b.r.online/" target="_blank"><i class="icon-instagram"></i></a></li>
					<li><a href="https://www.pinterest.jp/bronline/" target="_blank"><i class="icon-pinterest"></i></a></li>
					<li><a href="https://www.youtube.com/channel/UCUWtuyVjeMQygQiy3adHb1g" target="_blank"><i class="icon-youtube"></i></a></li>
					<li><a href="https://lin.ee/EIPUOqx" target="_blank"><!--<i class="icon-line"></i>--><img src="/common/images/ico/svg/icon_line4.svg" style="width:30px;vertical-align: inherit;margin-bottom: -2px;"></a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>


<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/common/js/stickyfill.min.js"></script>
<script src="/common/js/owl/owl.carousel.min.js"></script>
<!--{%if $listpage|default:"1"%}-->
<script src="/common/js/jquery-match-height.js"></script>
<!--{%/if%}-->
<!--{%if Agent::is_smartphone() == false%}-->
<script src="/common/js/jquery-match-height.js"></script>
<script>
$(function(){
	$(window).on('load resize', function(){
		$('.matchHeight').matchHeight();
	});
});
</script>
<!--{%/if%}-->
<script src="/common/js/jquery.autopager-1.0.0.js"></script>
<script src="/common/js/common.js"></script>
<script src="/common/js/autopager.js"></script>
<script src="/common/js/jquery.cookie.js"></script>

<!--{%if $customer['customer_id'] == "" %}-->
<script src="/common/js/wishlist-cookie.js"></script>
<!--{%else%}-->
<script src="/common/js/wishlist.js"></script>
<!--{%/if%}-->

<!-- 各記事の詳細ページ & 商品の詳細ページのみ -->
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a370cb7f0cda35b"></script>

<!-- 商品の詳細ページのみ -->
<script src="/common/js/slider-pro/jquery.sliderPro.min.js"></script>
<script src="/common/js/photoswipe/jquery.photoswipe-global.js"></script>

<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script>
$(function () {
	$('#zip1').jpostal({
		click : '#btn',
		postcode : [
			'#zip1',
			'#zip2'
		],
		address : {
			'#address1'  : '%3',
			'#address2'  : '%4%5'
		}
	});
	$('#other_zip1').jpostal({
		click : '#other_btn',
		postcode : [
			'#other_zip1',
			'#other_zip2'
		],
		address : {
			'#other_address1'  : '%3',
			'#other_address2'  : '%4%5'
		}
	});
});
</script>
<script>
    var elem = document.querySelectorAll('.fixedsticky');
    Stickyfill.add(elem);
</script>
</body>
</html>
<style>
.attention
{
	text-align:center;
	color:#e40000;
	font-size:120%;
}
</style>
<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
<!--{%*
		<li><a href="/mall/<!--{%$arrItem.login_id%}-->/"><!--{%$arrItem.shop_name%}--></a></li>
*%}-->
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$arrItem.login_id%}-->/item/">ITEM</a></li>
		<li class="arrow">＞</li>
		<li><!--{%$arrItem.name%}--></li>
	</ul>
</div>
<style>
.img-comment
{
	position:absolute;
	bottom:30px;
	left:50%;
	transform:translateX(-50%);
	font-size:14px;
	font-weight:normal;
	padding:0 15px;
    text-align: center;
    color:#444444;
    line-height: 1.2;
    width:95%;
/*
	background: #fff;
    margin: auto;
    padding: 10px 0;
    height:45px;
*/
}
@media screen and (max-width: 450px)
{
	.sp-buttons
	{
		bottom:0;
	}
	.img-comment
	{
		position:absolute;
		bottom:30px;
		left:50%;
		transform:translateX(-50%);
		font-size:13px;
		font-weight:normal;
		padding:0 15px;
	    text-align: center;
	    color:#444444;
		width: 95%;
	    line-height: 1.2;
	/*
		background: #fff;
	    margin: auto;
	    padding: 10px 0;
	    height:45px;
	*/
	}
}
</style>
<style>
.sale
{
/*
	position: absolute;
    top: 15px;
    left: 15px;
    z-index: 3;
*/
    font-size: 11px;
    line-height: 1.6;
    letter-spacing: 1.0px;
    color: #fff;
    background: #D0021B;
    padding: 0 5px 0px 6px;
	display:inline-block;
}
.reserve
{
    font-size: 11px;
    line-height: 1.6;
    letter-spacing: 1.0px;
    color: navy;
    background: #ccc;
    padding: 0 5px 0px 6px;
	display:inline-block;
}
span.sale.black
{
	display:inline-block;
	text-decoration: line-through;
    color: #000;
    background: #fff;
}
.fl.price.sale, .fl.price.sale span
{
    color: #D0021B;
    background: #fff;
}
.rev_pc
{
	display:block;
}
.rev_sp
{
	display:none;
}

@media screen and (max-width: 450px)
{
	.rev_pc
	{
		display:none;
	}
	.rev_sp
	{
		display:block;
	}
}
</style>

<div class="wrap_item_detail clearfix">
	<section class="fr name_area">
	<!--{%*
		<a href="/mall/<!--{%$shop_url%}-->/brand/?filters=<!--{%$arrItem.brand_code%}-->:::<!--{%$arrItem.brand_name|replace:'&':'-and-'%}-->" target="_blank" class="brandname times"><!--{%$arrItem.brand_name%}--> <span class="min">/ <!--{%$arrItem.brand_name_kana%}--></a>
	*%}-->
		<a href="/brand/?filters=<!--{%$arrItem.brand_code%}-->:::<!--{%$arrItem.brand_name|replace:'&':'-and-'%}-->" target="_blank" class="brandname times"><!--{%$arrItem.brand_name%}--> <span class="min">/ <!--{%$arrItem.brand_name_kana%}--></a>
		<h3 class="itemname"><!--{%$arrItem.name%}--><!--{%if $arrItem.name_en%}--> / <!--{%$arrItem.name_en%}--><!--{%/if%}--><!--{%if $arrItem.name_kana%}--> / <!--{%$arrItem.name_kana%}--><!--{%/if%}--></h3>
<!--{%if $arrItem.sale_status == 1 && $sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 1%}-->
			<p class="mont_medi sale">シークレットセール対象</p>　<span class="sale black">¥<!--{%number_format(Tag_Util::taxin_cal($arrItem.price01))%}--></span><br>
		<div class="clearfix">
			<p class="fl price sale">¥<!--{%number_format(Tag_Util::sale_cal($arrItem.price01,$sale_par))%}--><span> （税込） <!--{%$sale_par%}-->％OFF</span></p>
		</div>
		<div class="clearfix">
			<p class="fl price sale" style="font-size:14px;">※セール商品は返品・交換不可</p>
		</div>		
<!--{%elseif $arrItem.sale_status == 2 && $vip_sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 2%}-->
			<p class="mont_medi sale">VIPシークレットセール対象</p>　<span class="sale black">¥<!--{%number_format(Tag_Util::taxin_cal($arrItem.price01))%}--></span>
		<div class="clearfix">
			<p class="fl price sale">¥<!--{%number_format(Tag_Util::sale_cal($arrItem.price01,$sale_par))%}--><span> （税込） <!--{%$sale_par%}-->％OFF</span></p>
		</div>
		<div class="clearfix">
			<p class="fl price sale" style="font-size:14px;">※セール商品は返品・交換不可</p>
		</div>		
<!--{%elseif $arrItem.reservation_flg == 1%}-->
			<p class="mont_medi reserve" style="color:#c85267;">完全受注生産</p>
		<div class="clearfix">
			<p class="fl price">¥<!--{%number_format(Tag_Util::taxin_cal($arrItem.price01))%}--><span> （税込）</span></p>
			<p class="fr like_item_detail <!--{%if $arrItem.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrItem.product_id%}-->"></p>
		</div>
<!--{%elseif $arrItem.reservation_flg == 2%}-->
			<p class="mont_medi reserve">予約商品</p>
		<div class="clearfix">
			<p class="fl price">¥<!--{%number_format(Tag_Util::taxin_cal($arrItem.price01))%}--><span> （税込）</span></p>
			<p class="fr like_item_detail <!--{%if $arrItem.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrItem.product_id%}-->"></p>
		</div>
<!--{%else%}-->
		<div class="clearfix">
			<p class="fl price">¥<!--{%number_format(Tag_Util::taxin_cal($arrItem.price01))%}--><span> （税込）</span></p>
			<p class="fr like_item_detail <!--{%if $arrItem.product_id|in_array:$arrWish%}--> active <!--{%/if%}-->" data-pid="<!--{%$arrItem.product_id%}-->"></p>
		</div>
<!--{%/if%}-->
<!--{%if $arrItem.reservation_flg == 1 && $arrItem.reservation_text1 != ''%}-->
<div class="rev_pc" style="margin:20px auto 0;background:#fff9f4;padding:20px;border-radius:6px;">
<!--{%$arrItem.reservation_text1%}-->
</div>
<!--{%elseif $arrItem.reservation_flg == 2 && $arrItem.production_text1 != ''%}-->
<div class="rev_pc" style="margin:20px auto 0;background:#fff9f4;padding:20px;border-radius:6px;">
<!--{%$arrItem.production_text1%}-->
</div>
<!--{%/if%}-->
	</section>
	<section class="fl">
		<div id="slide_item_detail" class="slider-pro">
			<div class="sp-slides item_slide">
			<!--{%foreach from=$arrImages item=img name=imgkey%}-->
				<div class="sp-slide"><img class="sp-image" src="/upload/images/<!--{%if $arrItem.org_shop%}--><!--{%$arrItem.org_shop%}--><!--{%else%}--><!--{%$arrItem.login_id%}--><!--{%/if%}-->/<!--{%$img.path%}-->" />
				<div class="img-comment"><p><!--{%$img.comment%}--></p></div>
				</div>
			<!--{%/foreach%}-->
			<!--{%if $arrItem.movies%}-->
			<div class="sp-slide"><div class="movie"><div class="top"></div><iframe class="sp-video" src="https://player.vimeo.com/video/<!--{%$arrItem.movies%}-->?autoplay=1&loop=1&muted=1" width="533" height="711" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div></div>
			<!--{%/if%}-->
			</div>
			<div class="sp-thumbnails">
			<!--{%foreach from=$arrImages item=img name=imgkey%}-->
				<div class="sp-thumbnail"><img src="/upload/images/<!--{%if $arrItem.org_shop%}--><!--{%$arrItem.org_shop%}--><!--{%else%}--><!--{%$arrItem.login_id%}--><!--{%/if%}-->/<!--{%$img.path%}-->"/></div>
			<!--{%/foreach%}-->
			<!--{%if $arrItem.movies%}-->
				<div class="sp-thumbnail movie"><img src="/upload/images/<!--{%if $arrItem.org_shop%}--><!--{%$arrItem.org_shop%}--><!--{%else%}--><!--{%$arrItem.login_id%}--><!--{%/if%}-->/<!--{%$arrItem.movies_img%}-->"/></div>
			<!--{%/if%}-->
			</div>
		</div>
		<!--{%if $arrItem.comment != '<p><br></p>' && $arrItem.comment != '<br>'%}-->
		<div class="staff_comments">
			<h3 class="mont_medi">SHOP STAFF COMMENTS</h3>
			<hr class="short">
			<!--{%$arrItem.comment|nl2br%}-->
		</div>
		<!--{%/if%}-->
	</section>
	<section class="fr">

<!--{%if $arrItem.reservation_flg == 1 && $arrItem.reservation_text1 != ''%}-->
<div class="rev_sp" style="margin:20px 30px;background:#fff9f4;padding:20px;border-radius:6px;">
<!--{%$arrItem.reservation_text1%}-->
</div>
<!--{%elseif $arrItem.reservation_flg == 2 && $arrItem.production_text1 != ''%}-->
<div class="rev_sp" style="margin:20px 30px;background:#fff9f4;padding:20px;border-radius:6px;">
<!--{%$arrItem.production_text1%}-->
</div>
<!--{%/if%}-->
		<div class="cart_area l_purple">
			<form method="post" action="?">
	            <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
	            <input type="hidden" name="mode" value="addcart" />
				<!--{%foreach from=$color_option item=item key=code name=color%}-->
				<!--{%if $smarty.foreach.color.first%}-->
					<!--{%if $item != ''%}-->
				<div class="wrap_select">
					<select class="" id="color_code">
						<option disabled selected value="">
						カラー
						</option>
					<!--{%/if%}-->
				<!--{%/if%}-->
						<!--{%if $item != ''%}-->
						<option value="<!--{%$code%}-->"><!--{%$item%}--></option>
						<!--{%/if%}-->
				<!--{%if $smarty.foreach.color.last%}-->
					<!--{%if $item != ''%}-->
					</select>
				</div>
					<!--{%/if%}-->
				<!--{%/if%}-->
				<!--{%/foreach%}-->
	
				<!--{%foreach from=$size_option key=code item=item name=size%}-->
				<!--{%if $smarty.foreach.size.first%}-->
					<!--{%if $item != ''%}-->
				<div class="wrap_select">
					<select class="" id="size_code">
						<option disabled selected value="">
						サイズ
						</option>
					<!--{%/if%}-->
				<!--{%/if%}-->
						<!--{%if $item != ''%}-->
						<option value="<!--{%$code%}-->"><!--{%$item%}--></option>
						<!--{%/if%}-->
				<!--{%if $smarty.foreach.size.last%}-->
					<!--{%if $item != ''%}-->
					</select>
				</div>
					<!--{%/if%}-->
				<!--{%/if%}-->
				<!--{%/foreach%}-->
				<!--{%if $color_option|count == 0 && $size_option|count == 0%}-->
				<div class="btn_addcart soldout times">SOLD OUT</div>
				<!--{%else%}-->
<!--{%*
					<!--{%if $arrItem.product_id >= 48553 && $arrItem.product_id <= 48556%}--> 
						<button id="contact_addcart" type="button" class="times btn_addcart">RESERVATION</button>
*%}-->

					<!--{%if $arrItem.reservation_flg == 1%}-->
						<button id="btn_addcart" type="button" class="times btn_addcart" style="font-family:'Hiragino Kaku Gothic ProN','メイリオ';">予約する</button>
					<!--{%elseif $arrItem.reservation_flg == 2%}-->
						<button id="btn_addcart" type="button" class="times btn_addcart" style="font-family:'Hiragino Kaku Gothic ProN','メイリオ';">予約する</button>
					<!--{%else%}-->			
						<button id="btn_addcart" type="button" class="times btn_addcart" style="font-family:'Hiragino Kaku Gothic ProN','メイリオ';">カートに入れる</button>
					<!--{%/if%}-->
				<!--{%/if%}-->
				<div class="added_cart">
					<p id="added_error"></p>
					<p class="close added"><span></span></p>
					<div class="wrap_added_btn" style="display:none;">
						<a href="/cart/" class="btn_added" style="display:none;">カートを見る</a>
						<p class="btn_added close">買い物を続ける</p>
					</div>
				</div>
				<p class="attention">オプションを選択してください。</p>
	<div style="margin-top: 25px;"><script type="text/javascript">var _fj_prot = (("https:" == document.location.protocol) ? "https" : "http");
	document.write(unescape("%3Cscript src='"+_fj_prot+"://www.fromjapanlimited.com/js/bn.js' type='text/javascript'%3E%3C/script%3E"));
	</script><script type="text/javascript">var _fj_bnParam = {
	'merchant':'GM-316-49973852'
	};try{_fj_bnDrow();}catch(err){}</script></div>
			</form>
			<div class="contact">
				<p class="item_no">商品番号： <span class="copyBtn copyTarget"><!--{%$arrItem.group_code%}--></span><span class="copy-success">コピーしました !</span></p>
				<!--{%assign var=inc_side_url value="/var/www/bronline/fuel/app/views/smarty/attention/mall_`$shop_url`_detail_attention.tpl"%}-->
				<!--{%if file_exists($inc_side_url)%}-->
				<!--{%include file=$inc_side_url%}-->
				<!--{%/if%}-->
	<!--{%*
				<p>こちらのアイテムはB.R.SHOPの出品商品となります。記載事項以外のアイテム詳細につきましては、 「商品番号を明記の上」 下記フォームよりお問い合わせ下さい。</p>
				<p><a href="/contact/" target="_blank">B.R.MALL お問い合わせフォーム</a></p>
				<p>ご試着や店舗でのご購入につきましては、下記よりお問い合わせ下さい。</p>
				<p>【取扱店お問い合わせ】<br>TEL： 03-5414-8885 （平日・土日祝 12時〜20時）</p>
	*%}-->
	<div style="margin-top: 25px;"><script type="text/javascript">var _fj_prot = (("https:" == document.location.protocol) ? "https" : "http");
	document.write(unescape("%3Cscript src='"+_fj_prot+"://www.fromjapanlimited.com/js/bn.js' type='text/javascript'%3E%3C/script%3E"));
	</script><script type="text/javascript">var _fj_bnParam = {
	'merchant':'GM-316-49973852'
	};try{_fj_bnDrow();}catch(err){}</script></div>
			</div>
		</div>
		<section class="comment_area_new">
<!--{%if $arrItem.reservation_flg == 1 && $arrItem.reservation_text2 != ''%}-->
<div class="txt_area" style="margin-bottom:60px;padding-bottom:60px;border-bottom:solid 1px #ccc;">
<!--{%$arrItem.reservation_text2%}-->
</div>
<!--{%elseif $arrItem.reservation_flg == 2 && $arrItem.production_text2 != ''%}-->
<div class="txt_area" style="margin-bottom:60px;padding-bottom:60px;border-bottom:solid 1px #ccc;">
<!--{%$arrItem.production_text2%}-->
</div>

<!--{%*
<div class="txt_area">
<p style="padding:40px 0;">
【予約商品に関する注意事項】<br>
・お客さま都合によるキャンセルは承りかねます。<br>
・受付期間　XXXXX<br>
・その他の予約商品、通常商品との同時決済はできません。<br>
・メーカー側の都合で生産数量が減産となった場合、予約の受付順に応じて予約受付金をお返しいたします。予めご了承くださいませ。<br>
・今後通常販売を行う可能性もございます。<br>
・銀行振込のお客様は XXXXX のお振込みが確認できた場合、予約完了となります。<br>
・代金引換でのご注文は承っておりません。<br>

</p>
</div>
*%}-->
<!--{%/if%}-->
			<div class="txt_area">
			<!--{%$arrItem.info|nl2br%}-->
			</div>

		<!--{%if $arrItem.comment != '<p><br></p>' && $arrItem.comment != '<br>'%}-->
			<div class="staff_comments sp">
				<h3 class="mont_medi">SHOP STAFF COMMENTS</h3>
				<hr class="short">
				<!--{%$arrItem.comment|nl2br%}-->
			</div>
		<!--{%/if%}-->
			<div class="info_item_detail">
				<dl>
					<dt>商品番号</dt>
					<dd>：　<!--{%$arrItem.group_code%}--><!--{%*$arrSku[0].product_code*%}--></dd>
				</dl>
				<dl>
					<dt>ブランド</dt>
					<!--{%*
					<dd>：　<a href="/mall/<!--{%$shop_url%}-->/brand/?filters=<!--{%$arrItem.brand_code%}-->:::<!--{%$arrItem.brand_name|replace:'&':'-and-'%}-->" target="_blank"><!--{%$arrItem.brand_name%}--></a></dd>
					*%}-->
					<dd>：　<a href="/brand/?filters=<!--{%$arrItem.brand_code%}-->:::<!--{%$arrItem.brand_name|replace:'&':'-and-'%}-->" target="_blank"><!--{%$arrItem.brand_name%}--></a></dd>
				</dl>
				<dl>
					<dt>カテゴリ</dt>
					<dd>：　<a href="/item?category=<!--{%$arrItem.category_name|replace:'&':'::'%}-->&filter=on" target="_blank"><!--{%$arrItem.category_name%}--></a></dd>
				</dl>
				<dl>
					<dt>シーズン</dt>
					<dd>：　				<!--{%$arrItem.season%}--></dd>
				</dl>
				<dl>
					<dt>素材</dt>
					<dd>：　<!--{%$arrItem.material%}--></dd>
				</dl>
				<dl class="accordion">
					<dt>サイズ<p class="plus"><span></span><span></span></p></dt>
					<dd>
					<!--{%$arrItem.size_text%}-->
						<p id="guide_open" class="bold underline">SIZE GUIDE</p>
						<p id="chart_open" class="bold underline">SIZE CHART</p>
						<!--{%include file='smarty/common/include/overlay_guide.tpl'%}-->
					</dd>
				</dl>
				<dl class="accordion">
					<dt>備考<p class="plus"><span></span><span></span></p></dt>
					<dd>
						<ul>
							<li>原産国 ：　<!--{%$arrItem.country%}--></li>
							<!--{%if $arrItem.remarks != ""%}-->
							<li><!--{%$arrItem.remarks%}--></li>
							<!--{%/if%}-->
							<li><a href="/item/?category=%25E3%2582%25B5%25E3%2582%25A4%25E3%2582%25BA%25E7%259B%25B4%25E3%2581%2597&subcategory=&brand=&size=&color=&shopn=&filter=on&filters=" target="_blank">商品のお直しをご希望の方はコチラ</a></li>
							<li>サイズスペックは各サイズよりランダムに選んだ一個体のお直し前の実寸値となります。商品により誤差がある場合がございます。</li>
							<li>ディスプレイにより、実物と色、イメージが異なる事がございます。あらかじめご了承ください。</li>
							<li>こちらの商品は、実店舗と在庫の共有をさせていただいております。ご注文後に実在庫の確認をさせていただきますので、場合によっては完売となってしまう事がございます。商品の手配ができない場合は、改めてご連絡をさせていただきます。</li>
						</ul>
					</dd>
				</dl>
			</div>
			<!--<dl class="share">
				<dt class="mont_medi">SHARE</dt>
				<dd><div class="addthis_inline_share_toolbox_g5mc"></div></dd>
			</dl>-->
		</section>
	</section>
</div>
<script>
	function copyText () {
		var $target = document.querySelector('.copyTarget');
		if (!$target) {
			return false;
		}
		var range = document.createRange();
		range.selectNode($target);
		window.getSelection().removeAllRanges();
		window.getSelection().addRange(range);
		document.execCommand('copy');
		$('.copy-success').fadeIn(100);
		setTimeout(function(){
	        $('.copy-success').fadeOut(200);
	    },1200);
		return false;
	}
	document.querySelector('.copyBtn').addEventListener('click', copyText, false);
</script>
<script type="text/javascript" src="/common/js/cart.js"></script>
<script>
$(function(){
	<!--{%if $arrItem.comment == ''%}-->
	staff_move();
	<!--{%/if%}-->
	$('.attention').hide();
	$('#contact_addcart').click(function(){
		if (check_option() == true)
			location.href = '/contact/?product_id=<!--{%$arrItem.product_id%}-->';
		else
		{
			$('.attention').show();
			return false;
		}
	});
	$('#btn_addcart').click(function(){
		$('.attention').hide();
		if (check_option() == true)
		{
			var url = "/api/addcart.json";
			var _product_id = '<!--{%$smarty.get.detail%}-->';
			var _color_code = $('#color_code').val();
			var _size_code = $('#size_code').val();
			var _shop_url = '<!--{%$shop_url%}-->';

			var data = {product_id : _product_id, color_code : _color_code,size_code : _size_code,quantity : 1, shop_url : _shop_url};
			var res = sendApi(url, data, cart_view);

			$('.added_cart').fadeIn();
		}
		else
		{
			$('.attention').show();
			return false;
		}
	});
	$('#size_code').change(function(){
		var size_code = $(this).val();
		size_check(size_code);
	});
	$('#color_code').change(function(){
		var color_code = $(this).val();
		color_check(color_code);
	});
	
	check_select();
});

function check_select()
{
	var color_cnt = $('#color_code').children().length;
	var size_cnt = $('#size_code').children().length;
	var val = '';
	if (color_cnt == 2)
	{
		$('#color_code option').each(function(){
			if ($(this).val() != null)
				val = $(this).val();
		});
		
		$('#color_code').val(val);
		var size_cnt2 = $('#size_code').children().length;
		var val2 = '';

		if (size_cnt2 == 2)
		{
			$('#size_code option').each(function(){
				if ($(this).val() != null)
					val2 = $(this).val();
			});
			
			$('#size_code').val(val2);
		}
	}
	else if (size_cnt == 2)
	{
		$('#size_code option').each(function(){
			if ($(this).val() != null)
				val = $(this).val();
		});
		
		$('#size_code').val(val);
		var color_cnt2 = $('#color_code').children().length;
		var val2 = '';

		if (color_cnt2 == 2)
		{
			$('#color_code option').each(function(){
				if ($(this).val() != null)
					val2 = $(this).val();
			});
			
			$('#color_code').val(val2);
		}
	}
}

function cart_view(data)
{
	if (data != false)
	{
		console.log(JSON.stringify(data));
		console.log(data.error);
		
		if (data.error == '')
		{
			$('.btn_added').show();
			$('.btn_added.close').css('margin-left','4%');
			$('.num_cart').text(data.quantity);
			$('#added_error').text('カートに商品が追加されました');
			$('.wrap_added_btn').show();
		}
		else
		{
			$('.btn_added').hide();
			$('.btn_added.close').css('margin','0');
			$('.btn_added.close').show();
			$('#added_error').html(data.error);
			$('.wrap_added_btn').show();
		}
			
	}
}

function check_option()
{
	var color_cnt = $('#color_code').children().length;
	var size_cnt = $('#size_code').children().length;
	if (size_cnt > 1 && color_cnt > 1)
	{
		var color_val = $('#color_code').val();
		var size_val = $('#size_code').val();

		if (color_val != null && size_val != null)
			return true;
	}
	else if (color_cnt > 1)
	{
		var color_val = $('#color_code').val();

		if (color_val != null)
			return true;
	}
	else if (size_cnt > 1)
	{
		var size_val = $('#size_code').val();

		if (size_val != null)
			return true;
	}

	return false;
}
function staff_move()
{
	if ($('#staff-voice').prop("outerHTML") != undefined)
	{
		var html = $('#staff-voice').prop("outerHTML");
		$('#staff-voice').remove();
		//$('.staff_comments').empty();
		$('.staff_comments').append(html);
	}
	else
	{
		$('.staff_comments').hide();
	}
}
var options = JSON.stringify(<!--{%$options%}-->);
options = JSON.parse(options);
console.log(options);
function color_check(color_code)
{
	var size_list = options.color[color_code];
//	console.log(size_list);
	//$('#size_code').empty();
	
	$('#size_code option').attr('disabled','true');
	for(i = 0;i < size_list.length;i++)
	{
		var size = size_list[i];
//		console.log(size);
//		console.log($('#size_code option'));
		var c = 0;
		$('#size_code option').each(function(){
//			$(this).attr('disabled','true');
//			console.log($(this).val() + ':' + size);
			if ($(this).val() == size)
				$(this).removeAttr('disabled');
		});
	}
}
function size_check(size_code)
{
	var color_list = options.size[size_code];
//	console.log(size_list);
	//$('#size_code').empty();
	
	$('#color_code option').attr('disabled','true');
	for(i = 0;i < color_list.length;i++)
	{
		var color = color_list[i];
//		console.log(size);
//		console.log($('#color_code option'));
		var c = 0;
		$('#color_code option').each(function(){
//			$(this).attr('disabled','true');
//			console.log($(this).val() + ':' + size)
			if ($(this).val() == color)
				$(this).removeAttr('disabled');
		});
	}
}
</script>

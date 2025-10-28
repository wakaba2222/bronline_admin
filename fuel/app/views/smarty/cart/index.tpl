<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<!--{%*
<div id="size_overlay" style="display: block;"></div>

<div id="guide_main" class="wrap_size" style="display: block;">
	<div class="close" style="right:15px;left:auto;"><span></span></div>
	<div class="hidden t-center" style="height: 100%;">
		<div>
			<div class="wrap_cartinfo">
				<section class="tit_page"><h2 class="times">INFORMATION</h2></section>
				<h3>ショッピングガイド変更のお知らせ</h3>
				<p class="info_cart">
					平素よりB.R.ONLINEをご利用いただき、ありがとうございます。<br>この度、2021年7月1日付けで「ショッピングガイド」を一部変更させていただきました。<br><br>
					■変更点<br><br>
					領収書について<br>
					<a href="https://www.bronline.jp/guide/payment/#receipt" target="_blank"><span style="text-decoration:underline;">詳細はこちらよりご確認ください。</span></a><br>
					<br>
				</p>
			</div>
		</div>
	</div>
</div>
<div id="size_overlay" style="display: block;"></div>

<div id="guide_main" class="wrap_size" style="display: block;">
	<div class="close"><span></span></div>
	<div class="hidden t-center" style="height: 100%;">
		<div>
			<div class="wrap_cartinfo">
				<section class="tit_page"><h2 class="times">INFORMATION</h2></section>
				<h3>年末年始の営業について</h3>
				<p class="info_cart">
					発送休業期間<br>2020年12月28日（月）〜2021年1月2日（土）<br><br>お問い合わせ対応休業期間<br>2020年12月28日（月）〜2021年1月2日（土）<br><br>
					<span class="bold">12月27日（日曜日）以降の<br>ご注文・お問い合わせ・返品交換のご対応に関しては<br>1月3日（日曜日）より順次対応いたします。</span><br><br>ご迷惑をおかけいたしますが<br class="pc_none">ご理解のほどお願い申し上げます。
				</p>
			</div>
		</div>
	</div>
</div>

<div id="size_overlay" style="display: block;"></div>

<div id="guide_main" class="wrap_size" style="display: block;">
	<div class="close"><span></span></div>
	<div class="hidden t-center" style="height: 100%;">
		<div>
			<div class="wrap_cartinfo">
				<section class="tit_page"><h2 class="times">INFORMATION</h2></section>
				<h3>【メールが届かない場合についてのお知らせ】</h3>
				<p class="info_cart">
					ここ数週間、ご注文後にメールが届かない、途中からメールが届かなくなったという内容のお問い合わせが増えております。<br>
弊社では商品の発送完了までの状況を都度メールでご連絡さしあげております。<br>
ご注文完了メール受信後、2〜3日たっても以後のご案内が届かない場合は（ご注文完了メールが届かない場合も）、お手数ですが弊社ホームページ下部にある「CONTACT US」内の「お問い合わせフォーム」よりご連絡ください。<br>
また、お手数ですが弊社ドメイン「＠bronline.jp」の受信許可設定をお願いいたします。<br><br>
お手数をおかけし申し訳ございませんが、よろしくお願い申し上げます。<br>
				</p>
			</div>
		</div>
	</div>
</div>
*%}-->

<section class="tit_page">
	<h2 class="times">SHOPPING CART</h2>
</section>
<div class="wrap_contents sub">
<!--{%if $stockerror%}-->
<p class="attention"><!--{%$stockerror%}--></p>
<!--{%/if%}-->
	<form>
<!--{%foreach from=$arrItems item=item name=cart%}-->
	<!--{%if $smarty.foreach.cart.first%}-->
		<table class="cart">
			<tr>
				<th>商品</th>
				<th>個数</th>
				<th>小計</th>
			</tr>
	<!--{%/if%}-->
			<tr>
				<td>
					<div class="box_item">
						<!--{%assign var=image value=$item->getImage()%}-->
						<img class="block fl" src="/upload/images/<!--{%if $item->getOrgShop()%}--><!--{%$item->getOrgShop()%}--><!--{%else%}--><!--{%$item->getShop()%}--><!--{%/if%}-->/<!--{%$image[0].path%}-->">
						<div class="item_detail fr">
<!--{%if $item->getSaleStatus() == 1 && $sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 1%}-->
						<p class="red">【シークレットセール対象商品】</p>
<!--{%elseif $item->getSaleStatus() == 2 && $vip_sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 2%}-->
						<p class="red">【VIPシークレットセール対象商品】</p>
<!--{%/if%}-->
							<p class="bold"><!--{%$item->getBrandName()%}--> / <!--{%$item->getBrandNameKana()%}--></p>
							<p class="bold"><!--{%$item->getName()%}--></p>
							<p class="bold">¥<!--{%number_format(Tag_Util::taxin_cal($item->getPrice()))%}--><span style="font-size:11px;font-weight:normal;">&nbsp;(税込)</span></p>
							<!--{%if $item->getColor() != ''%}-->
							<dl>
								<dt class="bold">カラー：</dt>
								<dd><!--{%$item->getColor()%}--></dd>
							</dl>
							<!--{%/if%}-->
							<!--{%if $item->getSize() != ''%}-->
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd><!--{%$item->getSize()%}--></dd>
							</dl>
							<!--{%/if%}-->
						</div>
					</div>
				</td>
				<td>
					<div class="wrap_select">
						<select name="number" class="number">
							<option value="1" <!--{%if $item->getQuantity() == 1%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">1</option>
							<option value="2" <!--{%if $item->getQuantity() == 2%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">2</option>
							<option value="3" <!--{%if $item->getQuantity() == 3%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">3</option>
							<option value="4" <!--{%if $item->getQuantity() == 4%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">4</option>
							<option value="5" <!--{%if $item->getQuantity() == 5%}-->selected<!--{%/if%}--> data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">5</option>
						</select>
					</div>
				</td>
				<td class="border_none">
<!--{%if $item->getSaleStatus() == 1 && $sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 1%}-->
 					<p class="price sale bold">¥<!--{%((($item->getPrice()*((100-$sale_par)/100))*$item->getQuantity())*((TAX_RATE+100)/100))|floor|number_format%}--></p>
<!--{%elseif $item->getSaleStatus() == 2 && $vip_sale_flg == 1 && $customer['name'] != "" && $customer['sale_status'] == 2%}-->
 					<p class="price sale bold">¥<!--{%((($item->getPrice()*((100-$sale_par)/100))*$item->getQuantity())*((TAX_RATE+100)/100))|floor|number_format%}--></p>
<!--{%else%}-->
 					<p class="price bold">¥<!--{%(($item->getPrice()*$item->getQuantity())*((TAX_RATE+100)/100))|floor|number_format%}--></p>
<!--{%/if%}-->
					<a class="del_btn underline block" href="javascript:void(0);" data-id="<!--{%$item->getProductId()%}-->" data-color="<!--{%$item->getColorCode()%}-->" data-size="<!--{%$item->getSizeCode()%}-->">削除</a>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
	<!--{%if $smarty.foreach.cart.last%}-->
		</table>
		<p class="announcement_cart"><a href="/guide/payment/">お支払いについて</a> / <a href="/guide/delivery/">送料・お届け</a> / <a href="/guide/return/">返品・交換</a></p>
	<!--{%/if%}-->
<!--{%/foreach%}-->
<!--{%if $arrItems|count%}-->
		<div class="btn_area">
			<!--{%if $customer%}-->
				<a href="/cart/shopping/" class="submit_sys block confirm">ログインして購入</a>
			<!--{%else%}-->
				<a href="/signin/" class="submit_sys block confirm">ログインして購入</a>
			<!--{%/if%}-->
			<a href="/signup/" class="submit_sys block confirm b_purple">会員登録して購入</a>
			<a class="submit_sys block confirm guest" href="/cart/subscribe">会員登録せずに購入</a>
			<hr>
			<a class="back_sys block" href="/">買い物を続ける</a>
		</div>
<!--{%else%}-->
		<p class="no_item t-center">現在カート内に商品はございません。</p>
		<div class="btn_area">
			<a class="back_sys block" href="/">買い物を続ける</a>
		</div>
<!--{%/if%}-->
	</form>
<!--
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
-->
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/viewed.tpl'%}-->
<!--{%include file='smarty/common/include/pickup.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->
<script>
$(function(){
	$('.number').change(function(){
			var url = "/api/setcart.json";
			var _product_id = $("option:selected", this).data("id");
			var _color_code = $("option:selected", this).data("color");
			var _size_code = $("option:selected", this).data("size");
			var data = {product_id : _product_id, color_code : _color_code,size_code : _size_code,quantity : $(this).val()};
			var res = sendApi(url, data, cart_view);			
	});
	$('.del_btn').click(function(){
			var url = "/api/delcart.json";
			var _product_id = $(this).data("id");
			var _color_code = $(this).data("color");
			var _size_code = $(this).data("size");
			var data = {product_id : _product_id, color_code : _color_code,size_code : _size_code,quantity : 0};
			var res = sendApi(url, data, cart_reload);
	});
});
function cart_reload(data)
{
	location.reload();
}
function cart_view(data)
{
	if (data != false)
	{
		console.log(JSON.stringify(data));

		if (data.err != '')
		{
			alert(data.err);
		}
		else
		{
			$('.num_cart').text(data.quantity);
		}
	}
	location.reload();
}
</script>
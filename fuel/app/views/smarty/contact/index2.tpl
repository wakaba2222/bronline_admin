<style>
table.form td .mb2
{
	margin-bottom:0px;
}
table.form td input.mb2
{
	margin-bottom:2px;
}
#address1
{
	height:49.59px;
}
</style>


<!--{%if !($arrItem.product_id >= 48553 && $arrItem.product_id <= 48556)%}-->
<script>
location.href = '/contact/';
</script>
<!--{%/if%}-->


<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">RESERVATION</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<p class="mb60">下記の商品のご予約をいたします。</h3>
		<p>
		商品名：<!--{%$arrItem.name%}--><br>
		商品番号：<!--{%$arrItem.group_code%}--><br>
		</p>
<!--
  	<table class="contact_info">
      <tr>
        <th>B.R.ONLINEご利用に関するお問い合わせ<span>(利用方法や返品・交換依頼等)</span></th>
        <td>03-6721-1124<span>(無休／12時〜19時)</span></td>
      </tr>
      <tr>
        <th>B.R.SHOP直営店へのお問い合わせ<span>(商品やサイズ・店舗開催中フェア等)</th>
        <td>03-5414-8885<span>(無休／12時〜19時)</span></td>
      </tr>
    </table>
-->
	</div>

  <div class="intro" id="form_contact">
		<h3>ご予約フォーム</h3>
		<p>下記項目にご入力ください。「<span class="red">※</span>」印は入力必須項目です。入力後、ページ下の「次へ」ボタンをクリックしてください。</p>
	</div>

	<form name="form1" method="post" action="confirm" >
		<input type="hidden" name="mode" value="reserve"/>
		<input type="hidden" name="product_id" value="<!--{%$arrItem.product_id%}-->"/>
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
		<!--{%*$arrForm|@debug_print_var*%}-->
		<!--{%*$arrError|@debug_print_var*%}-->
		<table class="form">
			<tr>
				<th>お名前 <span class="red">※</span></th>
				<td><input placeholder="姓" type="text" class="col2 ph" name="name01" value="<!--{%if array_key_exists('name01', $arrForm) %}--><!--{%$arrForm['name01']%}--><!--{%/if%}-->" >
					<input placeholder="名" type="text" class="col2 ph" name="name02" value="<!--{%if array_key_exists('name02', $arrForm) %}--><!--{%$arrForm['name02']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('name01', $arrError) || array_key_exists('name02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('name01', $arrError) %}--><!--{%$arrError['name01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('name02', $arrError) %}--><!--{%$arrError['name02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr><th>フリガナ <span class="red">※</span></th>
				<td><input placeholder="セイ" type="text" class="col2 ph" name="kana01" value="<!--{%if array_key_exists('kana01', $arrForm) %}--><!--{%$arrForm['kana01']%}--><!--{%/if%}-->" >
					<input placeholder="メイ" type="text" class="col2 ph" name="kana02" value="<!--{%if array_key_exists('kana02', $arrForm) %}--><!--{%$arrForm['kana02']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('kana01', $arrError) || array_key_exists('kana02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('kana01', $arrError) %}--><!--{%$arrError['kana01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('kana02', $arrError) %}--><!--{%$arrError['kana02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
<!--{%*
			<tr><th>会社名</th><td><input type="text" class="col1" name="company" value="<!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}-->"></td></tr>
			<tr><th>部署名</th><td><input type="text" class="col1" name="department" value="<!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}-->"></td></tr>
			<tr>
				<th>郵便番号</th>
				<td>
					<input type="text" id="zip1" class="col4" name="zip01" value="<!--{%if array_key_exists('zip01', $arrForm) %}--><!--{%$arrForm['zip01']%}--><!--{%/if%}-->" >
					<input type="text" id="zip2" class="col4" name="zip02" value="<!--{%if array_key_exists('zip02', $arrForm) %}--><!--{%$arrForm['zip02']%}--><!--{%/if%}-->" >
					<input type="button" id="btn" name="btn" value="住所自動入力" class="btn_zip">
					<a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="search_zip">郵便番号検索</a>
				</td>
			</tr>
*%}-->
			<!--{%if array_key_exists('zip01', $arrError) || array_key_exists('zip02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('zip01', $arrError) %}--><!--{%$arrError['zip01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('zip02', $arrError) %}--><!--{%$arrError['zip02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>お住まいの都道府県</th>
				<td>
					<div class="wrap_select col2 mb2">
						<select name="pref" id="address1" class="col1">
							<option disabled selected>都道府県を選択</option>
							<!--{%foreach $arrPref as $pref %}-->
							<option value="<!--{%$pref['id']%}-->" <!--{%if array_key_exists('pref', $arrForm) && $arrForm['pref'] == $pref['id'] %}-->selected<!--{%/if%}-->><!--{%$pref['name']%}--></option>
							<!--{%/foreach%}-->
						</select>
					</div>
<!--{%*
					<input type="text" id="address2" class="col1 mb2 ph" name="addr01" placeholder="市区町村・番地" value="<!--{%if array_key_exists('addr01', $arrForm) %}--><!--{%$arrForm['addr01']%}--><!--{%/if%}-->" >
					<input type="text" class="col1 ph" name="addr02" placeholder="ビル/マンション名・部屋番号" value="<!--{%if array_key_exists('addr02', $arrForm) %}--><!--{%$arrForm['addr02']%}--><!--{%/if%}-->" >
*%}-->
				</td>
			</tr>
			<!--{%if array_key_exists('pref', $arrError) || array_key_exists('addr01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('pref', $arrError) %}--><!--{%$arrError['pref']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('addr01', $arrError) %}--><!--{%$arrError['addr01']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr><th>電話番号</th><td><input type="tel" class="col1 ph" name="tel01" placeholder="ハイフン無し数字" value="<!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}-->" ></td></tr>
			<!--{%if array_key_exists('tel01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['tel01']%}--></p></td></tr>
			<!--{%/if%}-->
			<tr><th>メールアドレス <span class="red">※</span> <br class="sp_none">(半角英数)</th>
				<td><input type="mail" class="col1 mb2" name="email" value="<!--{%if array_key_exists('email', $arrForm) %}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" >
				<input type="mail" placeholder="確認のため、もう一度入力してください" class="col1 ph" name="email2" value="<!--{%if array_key_exists('email2', $arrForm) %}--><!--{%$arrForm['email2']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('email', $arrError) || array_key_exists('email2', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('email', $arrError) %}--><!--{%$arrError['email']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('email2', $arrError) %}--><!--{%$arrError['email2']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr><th>ご予約内容 <span class="red">※</span></th><td><textarea class="contact-msg" name="body"><!--{%if array_key_exists('body', $arrForm) %}--><!--{%$arrForm['body']%}--><!--{%else%}-->商品名：<!--{%$arrItem.name%}-->
商品番号：<!--{%$arrItem.group_code%}-->
<!--{%/if%}--></textarea>
</td></tr>
			<!--{%if array_key_exists('body', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['body']%}--></p></td></tr>
			<!--{%/if%}-->
		</table>
		<button type="submit" class="submit_sys block">次へ</button>
	</form>
<!--{%*
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
*%}-->
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

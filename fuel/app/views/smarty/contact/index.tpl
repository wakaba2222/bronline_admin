<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<!--{%*
<div id="size_overlay" style="display: block;"></div>

<div id="guide" class="wrap_size" style="display: block;">
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
*%}-->

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

<section class="tit_page">
	<h2 class="times">CONTACT</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<h3>お問い合わせの前に</h3>
		<p class="mb60">
			お客様のメール受信設定により、弊社からの返信メールが届かないことがございます。ご利用前に以下弊社ドメインからのメール受信設定をお願いします。<br>
			※設定方法はご利用の端末やメールシステムにより異なります<br>
			受信許可ドメイン：@bronline.jp<br><br>
			<a href="/guide/faq.php" class="bold underline">よくあるご質問はこちら</a>
		</p>
    <!--<h3 class="contact_info_tit">お電話でのお問い合わせ</h3>
  	<table class="contact_info">
      <tr>
        <th>B.R.ONLINEご利用に関するお問い合わせ<span>(利用方法や返品・交換依頼等)</span></th>
        <td>03-6721-1124<span>(無休／12時〜19時)</span></td>
      </tr>
      <tr>
        <th>B.R.SHOP直営店へのお問い合わせ<span>(商品やサイズ・店舗開催中フェア等)</th>
        <td>03-5414-8885<span>(無休／12時〜19時)</span></td>
      </tr>
    </table>-->
	</div>

  <div class="intro" id="form_contact">
		<!--<h3>お問い合わせフォーム</h3>-->
		<p>下記項目にご入力ください。「<span class="red">※</span>」印は入力必須項目です。入力後、ページ下の「次へ」ボタンをクリックしてください。</p>
	</div>

	<form name="form1" method="post" action="confirm" >
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
			<tr><th>お問い合わせ内容 <span class="red">※</span></th><td><textarea class="contact-msg" name="body"><!--{%if array_key_exists('body', $arrForm) %}--><!--{%$arrForm['body']%}--><!--{%else%}-->商品名：<!--{%$smarty.get.product_name%}--><!--{%$smarty.const.PHP_EOL%}-->商品URL：https://www.bronline.jp/mall/<!--{%$smarty.get.shop_id%}-->/item/?detail=<!--{%$smarty.get.product_id%}--><!--{%$smarty.const.PHP_EOL%}--><!--{%/if%}--></textarea></td></tr>
			<!--{%*
			<tr><th>お問い合わせ内容 <span class="red">※</span></th><td><textarea class="contact-msg" name="body"><!--{%if array_key_exists('body', $arrForm) %}--><!--{%$arrForm['body']%}--><!--{%/if%}--></textarea></td></tr>
			*%}-->
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

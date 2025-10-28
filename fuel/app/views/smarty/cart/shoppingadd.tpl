<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SHIPPING</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>お届け先の修正・追加</h3>
  	<p>下記項目にご入力ください。「<span class="red">※</span>」印は入力必須項目です。<br>
    	入力後、ページ下の「次へ」ボタンをクリックしてください。</p>
  </div>
	<form action="?" method="post">
	<!--{%if $arrDeliv.id%}-->
	<input type="hidden" name="id" value="<!--{%$arrDeliv.id%}-->"/>
	<!--{%/if%}-->
		<table class="form">
			<tr>
				<th>お名前 <span class="red">※</span></th>
				<td><input placeholder="姓" type="text" class="col2 ph" name="name01" value="<!--{%$arrDeliv.name01%}-->" required><input placeholder="名" type="text" class="col2 ph" name="name02" value="<!--{%$arrDeliv.name02%}-->" required></td>
			</tr>
			<tr><th>フリガナ <span class="red">※</span></th><td><input placeholder="セイ" type="text" class="col2 ph" name="kana01" value="<!--{%$arrDeliv.kana01%}-->" required><input placeholder="メイ" type="text" class="col2 ph" name="kana02" value="<!--{%$arrDeliv.kana02%}-->" required></td></tr>
<!--
			<tr><th>会社名</th><td><input type="text" class="col1" name="company" value="<!--{%$arrDeliv.company%}-->"></td></tr>
			<tr><th>部署名</th><td><input type="text" class="col1" name="department" value="<!--{%$arrDeliv.department%}-->"></td></tr>
-->
			<tr>
				<th>郵便番号 <span class="red">※</span></th>
				<td>
					<input type="text" id="zip1" class="col4" name="zip01" value="<!--{%$arrDeliv.zip01%}-->" required>
					<input type="text" id="zip2" class="col4" name="zip02" value="<!--{%$arrDeliv.zip02%}-->" required>
					<input type="button" id="btn" name="btn" value="住所自動入力" class="btn_zip">
					<a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="search_zip">郵便番号検索</a>
				</td>
			</tr>
			<tr>
				<th>住所 <span class="red">※</span></th>
				<td>
					<div class="wrap_select col2 mb2">
						<select name="pref" id="address1" class="col1">
							<option disabled selected>都道府県を選択</option>
							<!--{%foreach from=$arrPref key=id item=pref%}-->
							<option value="<!--{%$id%}-->" <!--{%if $arrDeliv.pref == $pref%}-->selected<!--{%/if%}-->><!--{%$pref%}--></option>
							<!--{%/foreach%}-->
						</select>
					</div>
					<input type="text" id="address2" class="col1 mb2 ph" name="addr01" value="<!--{%$arrDeliv.addr01%}-->" placeholder="市区町村・番地" required>
					<input type="text" class="col1 ph" name="addr02" value="<!--{%$arrDeliv.addr02%}-->" placeholder="ビル/マンション名・部屋番号">
				</td>
			</tr>
			<tr><th>電話番号 <span class="red">※</span></th><td><input type="tel" class="col1 ph" name="tel01" value="<!--{%$arrDeliv.tel01%}-->" placeholder="ハイフン無し数字" required></td></tr>
		</table>
    <div class="btn_area">
			<button class="submit_sys block confirm" type="submit">登録する</button>
			<a class="back_sys block" href="/cart/shopping">戻る</a>
		</div>
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
<!--{%include file='smarty/common/include/footer.tpl'%}-->

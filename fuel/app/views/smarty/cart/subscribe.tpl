<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SHIPPING</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>お客様情報の入力</h3>
  	<p>下記項目にご入力ください。「<span class="red">※</span>」印は入力必須項目です。<br><span class="bold">ドメイン指定受信をされている等、弊社からのメールが届かない場合がございます。ご注文の際は必ず「@bronline.jp」からのメールを受信できるようご設定をお願い致します。</span></p>
  </div>
	<form name="form1" method="post" action="subscribe" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
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
			<tr>
				<th>郵便番号 <span class="red">※</span></th>
				<td>
					<input type="text" id="zip1" class="col4" name="zip01" value="<!--{%if array_key_exists('zip01', $arrForm) %}--><!--{%$arrForm['zip01']%}--><!--{%/if%}-->" >
					<input type="text" id="zip2" class="col4" name="zip02" value="<!--{%if array_key_exists('zip02', $arrForm) %}--><!--{%$arrForm['zip02']%}--><!--{%/if%}-->" >
					<input type="button" id="btn" name="btn" value="住所自動入力" class="btn_zip">
					<a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="search_zip">郵便番号検索</a>
				</td>
			</tr>
			<!--{%if array_key_exists('zip01', $arrError) || array_key_exists('zip02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('zip01', $arrError) %}--><!--{%$arrError['zip01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('zip02', $arrError) %}--><!--{%$arrError['zip02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>住所 <span class="red">※</span></th>
				<td>
					<div class="wrap_select col2 mb2">
						<select name="pref" id="address1" class="col1">
							<option disabled selected>都道府県を選択</option>
							<!--{%foreach $arrPref as $pref %}-->
							<option value="<!--{%$pref['id']%}-->" <!--{%if array_key_exists('pref', $arrForm) && $arrForm['pref'] == $pref['id'] %}-->selected<!--{%/if%}-->><!--{%$pref['name']%}--></option>
							<!--{%/foreach%}-->
						</select>
					</div>
					<input type="text" id="address2" class="col1 mb2 ph" name="addr01" placeholder="市区町村・番地" value="<!--{%if array_key_exists('addr01', $arrForm) %}--><!--{%$arrForm['addr01']%}--><!--{%/if%}-->" >
					<input type="text" class="col1 ph" name="addr02" placeholder="ビル/マンション名・部屋番号" value="<!--{%if array_key_exists('addr02', $arrForm) %}--><!--{%$arrForm['addr02']%}--><!--{%/if%}-->" >
				</td>
			</tr>
			<!--{%if array_key_exists('pref', $arrError) || array_key_exists('addr01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('pref', $arrError) %}--><!--{%$arrError['pref']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('addr01', $arrError) %}--><!--{%$arrError['addr01']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
<!--
			<tr><th>配送先会社名</th><td><input type="text" class="col1" name="company" value="<!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}-->"></td></tr>
			<tr><th>配送先部署名</th><td><input type="text" class="col1" name="department" value="<!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}-->"></td></tr>
-->
			<tr><th>電話番号 <span class="red">※</span></th><td><input type="tel" class="col1 ph" name="tel01" placeholder="ハイフン無し数字" value="<!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}-->" ></td></tr>
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
			<tr>
				<th>性別 <span class="red">※</span></th>
				<td>
					<!--{%foreach $arrSex as $sex %}-->
					<div class="wrap_radio col3">
						<input type="radio"  name="sex" value="<!--{%$sex['id']%}-->" id="sex<!--{%$sex['id']%}-->" <!--{%if array_key_exists('sex', $arrForm) && $arrForm['sex'] == $sex['id'] %}-->checked<!--{%/if%}--> >
						<label for="sex<!--{%$sex['id']%}-->"><!--{%$sex['name']%}--></label>
					</div>
					<!--{%/foreach%}-->
				</td>
			</tr>
			<!--{%if array_key_exists('sex', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['sex']%}--></p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>生年月日</th>
				<td>
					<div class="wrap_select col3">
						<!--{%assign var=select_y value=1980%}-->
						<!--{%if array_key_exists('year', $arrForm)%}-->
							<!--{%assign var=select_y value=$arrForm['year']%}-->
						<!--{%/if%}-->
						<select name="year" class="col1">
							<option disabled selected>年</option>
							<!--{%for $y=1900 to 2030%}-->
							<option value="<!--{%$y%}-->" <!--{%if $select_y == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
							<!--{%/for%}-->
						</select>
					</div>
					<div class="wrap_select col3">
						<select name="month" class="col1">
							<option disabled selected>月</option>
							<!--{%for $m=1 to 12%}-->
							<option value="<!--{%$m%}-->" <!--{%if array_key_exists('month', $arrForm) && $arrForm['month'] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
							<!--{%/for%}-->
						</select>
					</div>
					<div class="wrap_select col3">
						<select name="day" class="col1">
							<option disabled selected>日</option>
							<!--{%for $d=1 to 31%}-->
							<option value="<!--{%$d%}-->" <!--{%if array_key_exists('day', $arrForm) && $arrForm['day'] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
							<!--{%/for%}-->
						</select>
					</div>
				</td>
			</tr>
			<!--{%if array_key_exists('year', $arrError) || array_key_exists('month', $arrError) || array_key_exists('day', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('year', $arrError) %}--><!--{%$arrError['year']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('month', $arrError) %}--><!--{%$arrError['month']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('day', $arrError) %}--><!--{%$arrError['day']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
		</table>
    <div class="wrap_check border"><input type="checkbox" name="login_memory" id="login_memory" value="1"><label for="login_memory"> 上記以外の配送先を希望される方はチェックを入れ、下記フォームにご入力下さい。</label></div>
    <div class="send-option">
		  <table class="form">
			<tr>
				<th>お名前 <span class="red">※</span></th>
				<td><input placeholder="姓" type="text" class="col2 ph" name="other_name01" value="<!--{%if array_key_exists('other_name01', $arrForm) %}--><!--{%$arrForm['other_name01']%}--><!--{%/if%}-->" >
					<input placeholder="名" type="text" class="col2 ph" name="other_name02" value="<!--{%if array_key_exists('other_name02', $arrForm) %}--><!--{%$arrForm['other_name02']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('name01', $arrError) || array_key_exists('name02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('other_name01', $arrError) %}--><!--{%$arrError['other_name01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('other_name02', $arrError) %}--><!--{%$arrError['other_name02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr><th>フリガナ <span class="red">※</span></th>
				<td><input placeholder="セイ" type="text" class="col2 ph" name="other_kana01" value="<!--{%if array_key_exists('other_kana01', $arrForm) %}--><!--{%$arrForm['other_kana01']%}--><!--{%/if%}-->" >
					<input placeholder="メイ" type="text" class="col2 ph" name="other_kana02" value="<!--{%if array_key_exists('other_kana02', $arrForm) %}--><!--{%$arrForm['other_kana02']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('other_kana01', $arrError) || array_key_exists('other_kana02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('other_kana01', $arrError) %}--><!--{%$arrError['other_kana01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('other_kana02', $arrError) %}--><!--{%$arrError['other_kana02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>郵便番号 <span class="red">※</span></th>
				<td>
					<input type="text" id="other_zip1" class="col4" name="other_zip01" value="<!--{%if array_key_exists('zip01', $arrForm) %}--><!--{%$arrForm['zip01']%}--><!--{%/if%}-->" >
					<input type="text" id="other_zip2" class="col4" name="other_zip02" value="<!--{%if array_key_exists('zip02', $arrForm) %}--><!--{%$arrForm['zip02']%}--><!--{%/if%}-->" >
					<input type="button" id="other_btn" name="other_btn" value="住所自動入力" class="btn_zip">
					<a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="search_zip">郵便番号検索</a>
				</td>
			</tr>
			<!--{%if array_key_exists('zip01', $arrError) || array_key_exists('zip02', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('other_zip01', $arrError) %}--><!--{%$arrError['other_zip01']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('other_zip02', $arrError) %}--><!--{%$arrError['other_zip02']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>住所 <span class="red">※</span></th>
				<td>
					<div class="wrap_select col2 mb2">
						<select name="other_pref" id="other_address1" class="col1">
							<option disabled selected>都道府県を選択</option>
							<!--{%foreach $arrPref as $pref %}-->
							<option value="<!--{%$pref['id']%}-->" <!--{%if array_key_exists('pref', $arrForm) && $arrForm['pref'] == $pref['id'] %}-->selected<!--{%/if%}-->><!--{%$pref['name']%}--></option>
							<!--{%/foreach%}-->
						</select>
					</div>
					<input type="text" id="other_address2" class="col1 mb2 ph" name="other_addr01" placeholder="市区町村・番地" value="<!--{%if array_key_exists('other_addr01', $arrForm) %}--><!--{%$arrForm['other_addr01']%}--><!--{%/if%}-->" >
					<input type="text" class="col1 ph" name="other_addr02" placeholder="ビル/マンション名・部屋番号" value="<!--{%if array_key_exists('other_addr02', $arrForm) %}--><!--{%$arrForm['other_addr02']%}--><!--{%/if%}-->" >
				</td>
			</tr>
			<!--{%if array_key_exists('other_pref', $arrError) || array_key_exists('other_addr01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('other_pref', $arrError) %}--><!--{%$arrError['other_pref']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('other_addr01', $arrError) %}--><!--{%$arrError['other_addr01']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
<!--
			<tr><th>配送先会社名</th><td><input type="text" class="col1" name="other_company" value="<!--{%if array_key_exists('other_company', $arrForm) %}--><!--{%$arrForm['other_company']%}--><!--{%/if%}-->"></td></tr>
			<tr><th>配送先部署名</th><td><input type="text" class="col1" name="other_department" value="<!--{%if array_key_exists('other_department', $arrForm) %}--><!--{%$arrForm['other_department']%}--><!--{%/if%}-->"></td></tr>
-->
			<tr><th>電話番号 <span class="red">※</span></th><td><input type="tel" class="col1 ph" name="other_tel01" placeholder="ハイフン無し数字" value="<!--{%if array_key_exists('other_tel01', $arrForm) %}--><!--{%$arrForm['other_tel01']%}--><!--{%/if%}-->" ></td></tr>
			<!--{%if array_key_exists('other_tel01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['other_tel01']%}--></p></td></tr>
			<!--{%/if%}-->
		</table>
    </div>
		<button class="submit_sys block">次へ</button>
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

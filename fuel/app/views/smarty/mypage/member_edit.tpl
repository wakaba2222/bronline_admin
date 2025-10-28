<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">MY PAGE</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>会員情報の変更</h3>
  	<p>下記項目にご入力ください。「<span class="red">※</span>」印は入力必須項目です。<br>
    	入力後、ページ下の「入力内容の確認へ進む」ボタンをクリックしてください。</p>
  </div>
	<form name="form1" method="post" action="memberedit" >
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
<!--
			<tr><th>会社名</th><td><input type="text" class="col1" name="company" value="<!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}-->"></td></tr>
			<tr><th>部署名</th><td><input type="text" class="col1" name="department" value="<!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}-->"></td></tr>
-->
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
							<option disabled>都道府県を選択</option>
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
			<tr><th>電話番号 <span class="red">※</span></th><td><input type="tel" class="col1 ph" name="tel01" placeholder="ハイフン無し数字" value="<!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}-->" ></td></tr>
			<!--{%if array_key_exists('tel01', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['tel01']%}--></p></td></tr>
			<!--{%/if%}-->
			<tr><th>メールアドレス <span class="red">※</span> <br class="sp_none">(半角英数)</th>
				<td><input type="mail" class="col1 mb2" name="email" value="<!--{%if array_key_exists('email', $arrForm) %}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" >
					<input type="mail" placeholder="確認のため、もう一度入力してください" class="col1 ph" name="email2" value="<!--{%if array_key_exists('email2', $arrForm) %}--><!--{%$arrForm['email2']%}--><!--{%/if%}-->" >
					<input type="hidden" name="email_before" value="<!--{%if array_key_exists('email_before', $arrForm) %}--><!--{%$arrForm['email_before']%}--><!--{%else%}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" ></td>
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
				<th>生年月日 <span class="red">※</span></th>
				<td>
					<div class="wrap_select col3">
						<select name="year" class="col1">
							<option disabled selected>年</option>
							<!--{%for $y=1900 to 2030%}-->
							<option value="<!--{%$y%}-->" <!--{%if array_key_exists('year', $arrForm) && $arrForm['year'] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
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
			<tr><th>変更を希望する場合のパスワード(半角英数)</th>
				<td><input type="password" placeholder="変更希望の場合のみご入力ください（８桁以上の半角英数）"class="col1 mb2 ph" name="password" value="<!--{%if array_key_exists('password', $arrForm) %}--><!--{%$arrForm['password']%}--><!--{%/if%}-->" >
					<input type="password" placeholder="８桁以上の半角英数（再入力）" class="col1 ph" name="password2" value="<!--{%if array_key_exists('password2', $arrForm) %}--><!--{%$arrForm['password2']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('password', $arrError) || array_key_exists('password2', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('password', $arrError) %}--><!--{%$arrError['password']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('password2', $arrError) %}--><!--{%$arrError['password2']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>パスワードを忘れた時のヒント <span class="red">※</span></th>
				<td>
					<div class="wrap_select col2 mb2">
						<select name="reminder" id="reminder" class="col1">
							<option disabled selected>質問を選択</option>
							<!--{%foreach $arrReminder as $reminder %}-->
							<option value="<!--{%$reminder['id']%}-->" <!--{%if array_key_exists('reminder', $arrForm) && $arrForm['reminder'] == $reminder['id'] %}-->selected<!--{%/if%}-->><!--{%$reminder['name']%}--></option>
							<!--{%/foreach%}-->
						</select>
					</div>
					<input type="text" id="reminder_answer" class="col1 mb2 ph" name="reminder_answer" placeholder="変更希望の場合のみご入力ください" value="<!--{%if array_key_exists('reminder_answer', $arrForm) %}--><!--{%$arrForm['reminder_answer']%}--><!--{%/if%}-->" >
				</td>
			</tr>
			<!--{%if array_key_exists('reminder', $arrError) || array_key_exists('reminder_answer', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('reminder', $arrError) %}--><!--{%$arrError['reminder']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('reminder_answer', $arrError) %}--><!--{%$arrError['reminder_answer']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
			<tr>
				<th>メールマガジン購読 <span class="red">※</span></th>
				<td>
					<!--{%foreach $arrMagazineType as $type %}-->
					<div class="wrap_radio col3">
						<input type="radio"  name="mailmaga_flg" value="<!--{%$type['id']%}-->" id="magazinetype<!--{%$type['id']%}-->" <!--{%if array_key_exists('mailmaga_flg', $arrForm) && $arrForm['mailmaga_flg'] == $type['id'] %}-->checked<!--{%/if%}--> >
						<label for="magazinetype<!--{%$type['id']%}-->"><!--{%$type['name']%}--></label>
					</div>
					<!--{%/foreach%}-->
				</td>
			</tr>
			<!--{%if array_key_exists('mailmaga_flg', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red"><!--{%$arrError['mailmaga_flg']%}--></p></td></tr>
			<!--{%/if%}-->

		</table>
	    <div class="btn_area">
			<button type="submit" class="submit_sys block confirm">入力内容の確認へ進む</button>
			<a href="/mypage/" class="back_sys block">戻る</a>
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

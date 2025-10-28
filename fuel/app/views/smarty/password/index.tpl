<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page cntr">
	<h2 class="times">REMIND ACCOUNT</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<h3>登録情報をお忘れの方へ</h3>
		<p>会員登録したときの、メールアドレスと生年月日を入力して、「送信する」を選択してください。「<span class="red">※</span>」印は入力必須項目です。パスワード再設定ページへのリンクを記載したメールをお送りいたします。</p>
	</div>
	<form name="form1" method="post" action="send" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
	    <table class="form">
      		<tr><th>メールアドレス <span class="red">※</span></th>
      			<td><input type="mail" class="col1 mb2" name="email" value="<!--{%if array_key_exists('email', $arrForm) %}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" ></td>
      		</tr>
			<!--{%if array_key_exists('email', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('email', $arrError) %}--><!--{%$arrError['email']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
      		<tr>
				<th>電話番号 <span class="red">※</span></th>
      			<td><input type="text" class="col1 mb2" name="tel01" value="<!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if false%}-->
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
			<!--{%/if%}-->
		</table>
	    <div class="btn_area">
			<button type="submit" class="submit_sys block confirm">送信する</button>
			<a href="/signin/" class="back_sys block">戻る</a>
		</div>
	</form>
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

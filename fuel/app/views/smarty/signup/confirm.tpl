<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SIGN UP</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<h3>お客様情報の確認</h3>
		<p>下記の内容で送信してもよろしいでしょうか？<br>よろしければ、ページ下の「会員登録を完了する」ボタンをクリックしてください。</p>
	</div>
	<form name="form1" method="post" action="confirm" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
		<!--{%*$arrForm|@debug_print_var*%}-->
		<!--{%foreach $arrForm as $name => $val%}-->
			<input type="hidden" name="<!--{%$name%}-->" value="<!--{%$val%}-->" >
		<!--{%/foreach%}-->
		<table class="form confirm">
			<tr>
				<th>お名前</th>
				<td><!--{%$arrForm['name01']%}-->　<!--{%$arrForm['name02']%}--></td>
			</tr>
			<tr>
				<th>フリガナ</th>
				<td><!--{%$arrForm['kana01']%}-->　<!--{%$arrForm['kana02']%}--></td>
			</tr>
<!--
			<tr>
				<th>会社名</th>
				<td><!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}--></td>
			</tr>
			<tr>
				<th>部署名</th>
				<td><!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}--></td>
			</tr>
-->
			<tr>
				<th>郵便番号</th>
				<td><!--{%$arrForm['zip01']%}--> <!--{%$arrForm['zip02']%}--></td>
			</tr>
			<tr>
				<th>住所</th>
				<!--{%foreach $arrPref as $pref %}-->
					<!--{%if $arrForm['pref'] == $pref['id']%}-->
						<!--{%assign var=pref_name value=$pref['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
				<td><!--{%$pref_name%}-->　<!--{%$arrForm['addr01']%}-->　<!--{%if array_key_exists('addr02', $arrForm) %}--><!--{%$arrForm['addr02']%}--><!--{%/if%}--></td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td><!--{%$arrForm['tel01']%}--></td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td><!--{%$arrForm['email']%}--></td>
			</tr>
			<tr>
				<th>性別</th>
				<!--{%foreach $arrSex as $sex %}-->
					<!--{%if $arrForm['sex'] == $sex['id']%}-->
						<!--{%assign var=sex_name value=$sex['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
				<td><!--{%$sex_name%}--></td>
			</tr>
			<tr>
				<th>生年月日</th>
				<td><!--{%$arrForm['year']%}-->年<!--{%$arrForm['month']%}-->月<!--{%$arrForm['day']%}-->日</td>
			</tr>
			<tr>
				<th>パスワードを忘れた時のヒント</th>
				<!--{%foreach $arrReminder as $reminder %}-->
					<!--{%if $arrForm['reminder'] == $reminder['id']%}-->
						<!--{%assign var=reminder_name value=$reminder['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
				<td>質問：　<!--{%$reminder_name%}--><br>答え：　<!--{%$arrForm['reminder_answer']%}--></td>
			</tr>
			<tr>
				<th>メールマガジン購読</th>
				<!--{%foreach $arrMagazineType as $type %}-->
					<!--{%if $arrForm['mailmaga_flg'] == $type['id']%}-->
						<!--{%assign var=mailmaga_name value=$type['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
				<td><!--{%$mailmaga_name%}--></td>
			</tr>
		</table>
		<button type="submit" name="btnSubmit" value="regist" class="submit_sys block confirm">会員登録を完了する</button>
		<button type="submit" name="btnSubmit" value="return" class="back_sys block">入力内容を修正する</button>
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

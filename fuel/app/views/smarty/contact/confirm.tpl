<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">CONTACT</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
    <h3 class="contact_info_tit">お問い合わせ内容の確認</h3>
    <p>下記の内容で送信してもよろしいでしょうか？<br>
      よろしければ、ページ下の「送信する」ボタンをクリックしてください。</p>
	</div>

	<form name="form1" method="post" action="complete" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
		<!--{%*$arrForm|@debug_print_var*%}-->
		<!--{%foreach $arrForm as $name => $val%}-->
			<input type="hidden" name="<!--{%$name%}-->" value="<!--{%$val%}-->" >
		<!--{%/foreach%}-->
		<table class="form confirm">
			<tbody><tr>
				<th>お名前</th>
				<td><!--{%$arrForm['name01']%}-->　<!--{%$arrForm['name02']%}--></td>
			</tr>
			<tr>
				<th>フリガナ</th>
				<td><!--{%$arrForm['kana01']%}-->　<!--{%$arrForm['kana02']%}--></td>
			</tr>
<!--{%*
			<tr>
				<th>会社名</th>
				<td><!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}--></td>
			</tr>
			<tr>
				<th>部署名</th>
				<td><!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}--></td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td><!--{%if array_key_exists('zip01', $arrForm) %}--><!--{%$arrForm['zip01']%}--><!--{%/if%}--> <!--{%if array_key_exists('zip02', $arrForm) %}--><!--{%$arrForm['zip02']%}--><!--{%/if%}--></td>
			</tr>
*%}-->
			<tr>
				<th>お住まいの都道府県</th>
				<!--{%assign var=pref_name value=""%}-->
				<!--{%foreach $arrPref as $pref %}-->
					<!--{%if $arrForm['pref'] == $pref['id']%}-->
						<!--{%assign var=pref_name value=$pref['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
				<td><!--{%$pref_name%}--></td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td><!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}--></td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td><!--{%$arrForm['email']%}--></td>
			</tr>
			<tr>
				<th>お問い合わせ内容</th>
				<td class="contact-msg"><!--{%$arrForm['body']|nl2br%}--></td>
			</tr>
		</tbody></table>
		<button type="submit" name="btnSubmit" value="regist" class="submit_sys block confirm">送信する</button>
		<button type="submit" name="btnSubmit" value="return" class="back_sys block">入力内容を修正する</button>
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

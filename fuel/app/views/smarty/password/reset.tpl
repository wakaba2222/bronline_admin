<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page cntr">
	<h2 class="times">REMIND ACCOUNT</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<h3>パスワード再設定</h3>
		<p>パスワードを再設定します。8桁以上の半角英数で、新しいパスワードをご入力ください。<br><span class="red">※ 新しくパスワードを発行いたしますので、お忘れになったパスワードはご利用できなくなります。</span></p>
	</div>
	<form name="form1" method="post" action="complete" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
		<input type="hidden" name="customer_id" value="<!--{%if array_key_exists('customer_id', $arrForm) %}--><!--{%$arrForm['customer_id']%}--><!--{%/if%}-->" />
	    <table class="form">
			<tr><th>新しいパスワード <span class="red">※</span></th>
				<td><input type="password" placeholder="8桁以上の半角英数"class="col1 mb2 ph" name="password" value="<!--{%if array_key_exists('password', $arrForm) %}--><!--{%$arrForm['password']%}--><!--{%/if%}-->" ></td>
			</tr>
			<tr><th>確認用 <span class="red">※</span></th>
				<td><input type="password" placeholder="確認のため再度入力してください"class="col1 mb2 ph" name="password2" value="<!--{%if array_key_exists('password2', $arrForm) %}--><!--{%$arrForm['password2']%}--><!--{%/if%}-->" ></td>
			</tr>
			<!--{%if array_key_exists('password', $arrError) || array_key_exists('password2', $arrError) %}-->
			<tr class="form_error"><th></th><td><p class="error red">
				<!--{%if array_key_exists('password', $arrError) %}--><!--{%$arrError['password']%}--><br><!--{%/if%}-->
				<!--{%if array_key_exists('password2', $arrError) %}--><!--{%$arrError['password2']%}--><!--{%/if%}-->
			</p></td></tr>
			<!--{%/if%}-->
		</table>
    	<div class="btn_area">
			<button type="submit" class="submit_sys block">登録する</button>
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

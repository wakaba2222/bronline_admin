<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">MY PAGE</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
    <h3>退会手続き</h3>
    <p>会員を退会される場合は、「退会する」ボタンをクリックしてください。</p>
	</div>
	<form name="form1" method="post" action="unsubscribe" >
		<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />

		<div class="msg-bloc unsubscribe">
			<h4>※ 退会手続きが完了した時点で、現在保存されている購入履歴や、お届け先などの会員情報がすべて削除されます。</h4>
		</div>
		<p class="last-msg">退会手続きを実行してもよろしいでしょうか？</p>
		<button type="submit" class="submit_sys block confirm">退会する</button>
		<a href="/mypage/"><button class="back_sys block">戻る</button></a>
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

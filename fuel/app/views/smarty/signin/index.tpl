<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SIGN IN</h2>
</section>
<div class="wrap_contents sub">
	<div class="intro">
		<h3>会員登録がお済みの方</h3>
		<div class="login">
			<form class="wrap_btn" name="form1" method="post" action="" >
				<!--{%*$arrError|@debug_print_var*%}-->
				<!--{%if 0 < count($arrError)%}-->
				<p class="red form_error">
					<!--{%foreach $arrError as $errmsg %}-->
						<!--{%$errmsg%}--><br/>
					<!--{%/foreach%}-->
				</p>
				<!--{%/if%}-->
				<dl>
					<dt>メールアドレス</dt>
					<dd><input type="mail" class="col1" name="email"></dd>
					<dt>パスワード</dt>
					<dd><input type="password" class="col1" name="password"></dd>
				</dl>
				<div class="wrap_check"><input type="checkbox" name="login_memory" id="login_memory" value="1"><label for="login_memory"> ログインしたままにする</label></div>
				<input type="hidden" name="login_memory" value="0">
				<button type="submit" class="submit_sys block">ログイン</button>
				<p class="reminder">※ <a href="/password/" class="underline">パスワードを忘れた方はこちら</a></p>
			</form>
		</div>
	</div>
	<div class="intro">
		<h3>まだ会員登録されていない方</h3>
		<div class="login">
			<p class="txt">会員登録をすると、<a href="/guide/point.php" class="underline red">ポイントプログラム</a>をご利用いただけるとともに、ご購入履歴や、ポイント獲得状況がわかる、便利なMyページをご利用いただけます。また、ログインするだけで、毎回お名前や住所を入力することなくスムーズにお買い物をお楽しみいただけます。</p>
			<div class="wrap_btn"><a href="/signup/" class="submit_sys block">新規会員登録</a></div>
		</div>
	</div>
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

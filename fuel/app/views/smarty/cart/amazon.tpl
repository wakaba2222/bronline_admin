<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">Amazon pay</h2>
</section>
<div class="wrap_contents sub">
<form name="form1" action="./complete" method="POST">
	<div>
		<h5>お届け先・お支払い方法の選択</h5>
		<input type="hidden" name="orderReferenceId" id="orderReferenceId" value="" />
		<input type="hidden" name="accessToken" id="accessToken" value="" />

		<div id="addressBookWidgetDiv" style="height:250px"></div>
		<div id="walletWidgetDiv" style="height:250px"></div>
	</div>

	<div class="btn_area">
		<br>
		<button class="submit_sys block confirm">購入する</button>
		<a href="" class="back_sys block" onclick="document.form1.action='./confirm';document.form1.submit();">戻る</a>
	</div>	

  <!--<a href="/"><button class="submit_sys block">トップページへ</button></a>-->
<!--
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
-->
</from>
</div>

<script type='text/javascript'>
	function getURLParameter(name, source) {
			return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
											'([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
	}

	var error = getURLParameter("error", location.search);
	if (typeof error === 'string' && error.match(/^access_denied/)) {
		console.log('Amazonアカウントでのサインインをキャンセルされたため、戻る');
		window.location.href = '<!--{%$url_signin_cancel%}-->';
	}
</script>

<script type='text/javascript'>

let clientId = "<!--{%$client_id%}-->"; 
let sellerId = "<!--{%$merchant_id%}-->";


	// get access token
	function getURLParameter(name, source) {
		return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
									'([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
	}
	//popup=trueにする場合
	var accessToken = getURLParameter("access_token", location.href);
	// popup=falseにする場合
	// var accessToken = getURLParameter("access_token", location.hash);
	// if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
	//     document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;secure";
	// }

	window.onAmazonLoginReady = function() {
		amazon.Login.setClientId(clientId);
		amazon.Login.setUseCookie(false); //popup=falseにときに必要

		if (accessToken) {
			document.getElementById("accessToken").value = accessToken;
		}
	};

	window.onAmazonPaymentsReady = function() {
		showAddressBookWidget();
	};

	function showAddressBookWidget() {
		// AddressBook
		new OffAmazonPayments.Widgets.AddressBook({
			sellerId: sellerId,

			onReady: function (orderReference) {
				var orderReferenceId = orderReference.getAmazonOrderReferenceId();

				document.getElementById("orderReferenceId").value = orderReferenceId;						
				// Wallet
				showWalletWidget(orderReferenceId);
			},
			onAddressSelect: function (orderReference) {    // 住所選択時
				// お届け先の住所が変更された時に呼び出されます、ここで手数料などの再計算ができます。
			},
			design: {
				designMode: 'responsive'
			},
			onError: function (error) {
				console.log('OffAmazonPayments.Widgets.AddressBook', error.getErrorCode(), error.getErrorMessage());
			}
		}).bind("addressBookWidgetDiv");
	}

	function showWalletWidget(orderReferenceId) {
		// Wallet
		new OffAmazonPayments.Widgets.Wallet({
			sellerId: sellerId,
			amazonOrderReferenceId: orderReferenceId,
			onReady: function(orderReference) {
				console.log(orderReference.getAmazonOrderReferenceId());
			},
			onPaymentSelect: function() {   // 支払方法選択
			},
			design: {
				designMode: 'responsive'
			},
			onError: function(error) {
				console.log('OffAmazonPayments.Widgets.Wallet', error.getErrorCode(), error.getErrorMessage());
			}
		}).bind("walletWidgetDiv");
	}

</script>

<script type="text/javascript" src="<!--{%$url_widget_js%}-->" async></script>


<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

<style>
.attention
{
	color:red;
}
</style>

<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->

<script>
var total = <!--{%$total_price+330%}-->;
$(function(){
	$('#lapping').change(function(){
		if ($(this).val() == 1 && $('#type_04').prop('checked') == true)
		{
			if (total+330 > 300000)
			{
				$('#payerr').show();
				$('#payerr2').show();
				$(this).val(0);
				$('#type_04').prop('checked',false);
			}
		}
		else
		{
			$('#payerr').hide();
			$('#payerr2').hide();
		}
	});
	$('input[name=payment_type]').change(function(){
		if ($('#type_04').prop('checked') == true)
		{
			if ($('#lapping').val() == 1)
			{
				if (total+330+330 > 300000)
				{
					$('#payerr').show();
					$('#payerr2').show();
					$('#type_04').prop('checked',false);
					$('#lapping').val(0);
				}
			}
		}
		else
		{
			$('#payerr2').hide();
			$('#payerr').hide();
		}
	});
	$('#payerr').hide();
	$('#payerr2').hide();
});
</script>
<section class="tit_page">
	<h2 class="times">PAYMENT</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>お支払い方法・お届け日時の指定</h3>
  </div>

	<!-- suzuki mod start -->
	<form method="post" action="/cart/confirm">
	<!-- suzuki mod end -->

<!-- suzuki del start
  <div class="payment sub-title">
    <p>配送業者</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="add" value="add_01" id="add_01" required="" checked="checked">
						<label for="add_01"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">ヤマト運輸</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
-->
  <div class="payment sub-title">
    <p>お支払い方法</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki mod smartytag -->
						<input type="radio" name="payment_type" value="1" id="type_01" required="" <!--{%$type_01%}-->>
						<label for="type_01"></label>
  				</div>
				</td>
				<td class="payment_info border_none">

          <ul class="drawer-menu">
            <li class="mainmenu">
              <div class="toggle">
                <p class="tit_menu">クレジットカード決済</p>
                <p class="plus"><span></span><span></span></p>
              </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
<!-- suzuki del start
                <img class="rpay" src="/common/images/ico/card.jpg">
-->
                <p>
	                一括、分割（3,5,6,10,12,15,18,20,24回）、リボ払い<br>
					※ 2回払い、ボーナス一括払いはご利用頂けません。<br>
					※ ご利用のカードにより異なるケースがございます。<br>
					※ デビットカードをご利用の場合<br>
					デビットカードご利用の決済は、ご利用金額がお客様の預金口座から即時引落となります。ご注文キャンセル、返品等のご返金には日数を要します。ご返金時期について弊社では分かりかねますので、発行カード会社にお問い合わせください。
				</p>
              </div>
            </li>
          </ul>
            </li>
          </ul>

				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki mod smartytag -->
						<input type="radio" name="payment_type" value="2" id="type_02" required="" <!--{%$type_02%}-->>
						<label for="type_02"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <p class="tit_menu">銀行振込</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>
	                ご注文日から3営業日以内（土、日、祝日は除く）に下記振込先へご入金ください。<br>
					＜お振込指定口座＞<br>
					みずほ銀行 青山支店 普通口座 2006926<br>
					口座名 ： カ)ビー.アール.ティー<br>
					※ 振込口座情報はご注文確認メールにも記載いたします。
				</p>
              </div>
            </li>
          </ul>
        </ul>
        </div>
				</td>
			</tr>
<!--{%if $pay_off == 0 && $reservation == 0 %}-->
      <tr <!--{%if ($total_price+330) > 300000%}-->style="display:none;"<!--{%/if%}-->><td colspan="2" class="border_none"><hr></td></tr>
			<tr <!--{%if ($total_price+330) > 300000%}-->style="display:none;"<!--{%/if%}-->>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki mod smartytag -->
						<input type="radio" name="payment_type" value="4" id="type_04" required="" <!--{%$type_04%}-->>
						<label for="type_04"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <p class="tit_menu">代金引換</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>
                代引き手数料が300円（税抜）かかります。
				</p>
              </div>
            </li>
          </ul>
        </ul>
        </div>
				</td>
			</tr>
<!--{%/if%}-->
<!--{%*if $customer_email == 'hwakaba2222@gmail.com'*%}-->
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki mod smartytag -->
						<input type="radio" name="payment_type" value="3" id="type_03" required="" <!--{%$type_03%}-->>
						<label for="type_03"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <img src="/common/images/system/pay_amazon@2x.png" alt="amazon pay" class="icon">
            <p class="tit_menu pos01">アマゾンペイ</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>Amazonにアカウントをお持ちのお客様は、Amazon.co.jpにご登録のお支払い方法を利用してお買い物が可能です。また、B.R.ONLINE会員様はB.R.ONLINEのポイントが貯まります。B.R.ONLINEでの使用も可能です。<br>※Amazonポイントとは連携しておりません。</p>
              </div>
            </li>
          </ul>
          </li>
        </ul>
				</td>
			</tr>
<!--{%*/if*%}-->
<!--{%if $smarty.const.USE_RAKUTEN%}-->
      <tr>
      <td colspan="2" class="border_none"><hr></td></tr>

			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="5" id="type_05" required="" <!--{%$type_05%}-->>
						<label for="type_05"></label>
  				</div>
				</td>
<td class="payment_info border_none">
<ul class="drawer-menu">
<li class="mainmenu">
<div class="toggle">
<img src="https://checkout.rakuten.co.jp/rpay/logo/rpaylogo_r_30088.png" alt="楽天Pay" class="icon rakuten">
<p class="tit_menu pos02">楽天ペイ（旧：楽天ID決済）</p>
<p class="plus"><span></span><span></span></p>
</div>
<ul class="menulist drawer-dropdown-menu" style="display: none;">
<li>
<div>
<p>いつもの楽天IDとパスワードを使ってスムーズなお支払いが可能です。<br>
楽天ポイントが貯まる・使える！「簡単」「あんしん」「お得」な楽天ペイをご利用ください。</p>
<a href="https://checkout.rakuten.co.jp/" target="_blank" class="block"><img src="https://checkout.rakuten.co.jp/p/common/img/rpay/img_cardface_v7_1.gif" alt="" class="rpay"></a>
</div>
</li>
</ul>
</li>
</ul>
</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
<!--{%/if%}-->
<!--
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="payment_type" value="type_04" id="type_05" required="">
						<label for="type_05"></label>
  				</div>
				</td>
				<td class="payment_info border_none">
        <ul class="drawer-menu">
          <li class="mainmenu">
            <div class="toggle">
            <img src="/common/images/system/pay_apple@2x.png" alt="Apple Pay" class="icon">
            <p class="tit_menu pos01">Apple Pay</p>
            <p class="plus"><span></span><span></span></p>
          </div>
            <ul class="menulist drawer-dropdown-menu" style="display: none;">
            <li>
              <div>
                <p>いつもの楽天IDとパスワードを使ってスムーズなお支払いが可能です。<br>
                楽天ポイントが貯まる・使える！「簡単」「あんしん」「お得」な楽天ペイをご利用ください。</p>
                <img src="common/images/system/pay_rpay_bnr@2x.png" alt="" class="rpay">
              </div>
            </li>
          </ul>
          </li>
        </ul>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
-->
		</tbody>
  </table>
  <p class="attention" id="payerr2">代金引換は30万以上の場合選択できません。</p>

<!--{%if $customer_id == 0%}-->
<!--{%if $customer['name'] == '' || ($customer['name'] != '' && $cupon_view == 1)%}-->
  <div class="payment sub-title" id="cupon_code">
    <p>クーポンコード</p>
  </div>
  <table class="option payment">
    <tbody>
			<tr>
				<td class="payment_info cupon">
					<!-- suzuki del required="" add value="" -->
					<input type="text" class="cupon_code" name="cupon_code" placeholder="例　ABc12345efGh678（半角英数字）" value="<!--{%$coupon_cd%}-->">
					<p class="attention coupon" style="display:none;">入力されたクーポンコードは無効です。</p>
				</td>
			</tr>
		</tbody>
  </table>
<!--{%/if%}-->
<!--{%/if%}-->
<!--{%if $guest|default:'' == ''%}-->
  <div class="payment sub-title">
    <p>ポイントのご使用</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki add smartytag&onclick="" -->
						<input type="radio" name="point_use_yn" value="1" id="point_use_yes" required="" <!--{%$point_use_yes%}--> onclick="document.getElementById('point_use').disabled=''">
						<label for="point_use_yes"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="mb20">現在の有効ポイント：　<span class="bold"><!--{%$customer.point%}--></span> ポイント</p>
						<!-- suzuki add id="point_use" disabled="true" value="" -->
						<input type="text" class="point_use" name="point_use" placeholder="0" required="" id="point_use" <!--{%$point_use_disabled%}--> value="<!--{%$point_use%}-->"> <span class="bold">ポイントを使用する</span>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki add checked="checked" smartytag&onclick="" -->
						<input type="radio" name="point_use_yn" value="0" id="point_use_no" required="" <!--{%$point_use_no%}--> onclick="document.getElementById('point_use').disabled='true'">
						<label for="point_use_no"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">ポイントを使用しない</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">「1ポイントを1円」として使用する事ができます。<br>
    使用する場合は、「ポイントを使用する」にチェックを入れた後、使用するポイントをご記入ください。</p>
<!--{%/if%}-->

  <div class="payment sub-title">
    <p>お届け日時の指定</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td class="payment_heading">配達希望日</td>
				<td class="payment_info">
          <div class="wrap_select">
						<select name="delivery_day" id="delivery_day" class="col1">
							<option value="" selected="">指定しない</option>
<!--{* 04/06 mod.
							<!--{%foreach from=$arrDate key=k item=deliv%}-->
							<option value="<!--{%$k%}-->"><!--{%$deliv%}--></option>
							<!--{%/foreach%}-->
*}-->
<!-- suzuki del start
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
							<option value="">0000年00月00日</option>
-->
						</select>
					</div>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td class="payment_heading">お届け時間</td>
				<td class="payment_info">
          <div class="wrap_select">
						<select name="delivery_time" id="delivery_time" class="col1">
							<option value="" selected="">指定しない</option>
							<!--{%foreach from=$arrTime key=key item=time%}-->
							<option value="<!--{%$key%}-->"><!--{%$time%}--></option>
							<!--{%/foreach%}-->
<!-- suzuki del start
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
							<option value="">00:00〜00:00</option>
-->
						</select>
					</div>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p style="color:red;">当面の間、配達希望日の指定受付を休止しております。時間指定は可能です。</p>
  <p class="repletion">お届け日・お届け時間はあくまで目安となっております。指定をいただいても交通事情等により遅れる場合もございます。<!--<br><span class="bold red">年末年始は配達日時指定をうけたまわることができません。ご不便をおかけし恐縮ですがご理解ご了承のほどお願い申し上げます。</span>--></p>

  <div class="payment sub-title" id="payment_title">
    <p>明細書</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki add smartytag -->
						<input type="radio" name="specification" value="1" id="specification_yes" required="" <!--{%$specification_yes%}-->>
						<label for="specification_yes"></label>
  				</div>
				</td>
				<td class="payment_info">
  				<p class="bold">お買い上げ明細を同封する</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<!-- suzuki add smartytag -->
						<input type="radio" name="specification" value="0" id="specification_no" required="" <!--{%$specification_no%}-->>
						<label for="specification_no"></label>
  				</div>
				</td>
				<td class="payment_info">
	  				<p class="bold">お買い上げ明細を同封しない</p>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">プレゼントなど、明細の同封が不要の場合は、「お買い上げ明細を同封しない」にチェックをつけてください。</p>

<script>
$(function(){
	$('#receipt_select').change(function(){
		var v = $(this).val();
		
		if (v == 'その他')
			$('#receipt_tadashi2').show();
		else
			$('#receipt_tadashi2').hide();
		
		$('#receipt_tadashi').val(v);
	});
	
	$('input[name="payment_type"]').change(function(){
		var v = $(this).val();
		
		v = $('input[name="payment_type"]:checked').val();
		
		if (v == 4)
		{
			$('#receipt_select').val('');
			$('#receipt_name').val('');
			$('#receipt_tadashi').val('');
			$('#receipt_tadashi2').val('');
			$('#recipent_area').hide();
		}
		else
			$('#recipent_area').show();
		
	});
	
	$('input[name="payment_type"]').change();
	$('#receipt_select').change();
});
/*
function val_check()
{
	$('.cupon_code').blur();
	setTimeout("val_check2()",1000);
}
*/
function val_check()
{
	$('.cupon_code').blur();
	if (!btn_check)
	{
		alert('クーポンコードを確認してください。');
		location.hash = 'cupon_code';
		return false;
	}

	var v = $('#receipt_select').val();
	
	if (v == 'その他')
		$('#receipt_tadashi').val($('#receipt_tadashi2').val());

	if (v != '')
	{
		if ($('#receipt_name').val() == '')
		{
			$('#receipt_name_err').text('領収書宛名を入力してください。');
			location.hash = '#payment_title';
			return false;
		}
	}

	return true;
}
</script>

  <div class="payment sub-title">
    <p>領収書</p>
  </div>
<div id="recipent_area">
  <table class="option payment none-mb">
    <tbody>
			<tr>
				<td class="payment_heading">領収書宛名</td>
				<td class="payment_info">
					<!-- suzuki add value="" -->
  				<input type="text" class="receipt" name="receipt_name" id="receipt_name" placeholder="例　株式会社○○○○○" value="<!--{%$receipt_name%}-->">
  				<span id="receipt_name_err" class="red"></span>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">領収書但し</td>
				<td class="payment_info">
				<input type="hidden" name="receipt_tadashi" id="receipt_tadashi" value="" />
  				<div class="wrap_select">
						<select name="receipt_select" id="receipt_select" class="col1">
							<option value="" <!--{%if $receipt_tadashi|default:"" == ''%}-->selected<!--{%/if%}-->>選択してください</option>
							<option value="お品代として" <!--{%if $receipt_tadashi|default:"" == 'お品代として'%}-->selected<!--{%/if%}-->>お品代として</option>
							<option value="贈答品代として" <!--{%if $receipt_tadashi|default:"" == '贈答品代として'%}-->selected<!--{%/if%}-->>贈答品代として</option>
							<option value="衣装代として" <!--{%if $receipt_tadashi|default:"" == '衣装代として'%}-->selected<!--{%/if%}-->>衣装代として</option>
							<option value="サンプル代として" <!--{%if $receipt_tadashi|default:"" == 'サンプル代として'%}-->selected<!--{%/if%}-->>サンプル代として</option>
							<option value="その他" <!--{%if $receipt_tadashi|default:"" != 'サンプル代として' && $receipt_tadashi|default:"お品代として" != 'お品代として' && $receipt_tadashi|default:"お品代として" != '贈答品代として' && $receipt_tadashi|default:"お品代として" != '衣装代として'%}-->selected<!--{%/if%}-->>その他</option>
							<!-- suzuki mod end -->
							</select>
					</div><br>
					<!-- suzuki add value="" -->
  				<input type="text" class="receipt" name="receipt_tadashi2" id="receipt_tadashi2" placeholder="例　お品代として" value="<!--{%if $receipt_tadashi|default:"" != '' && $receipt_tadashi|default:"" != 'お品代として' && $receipt_tadashi|default:"" != '贈答品代として' && $receipt_tadashi|default:"" != '衣装代として'%}--><!--{%$receipt_tadashi%}--><!--{%/if%}-->">
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
</div>
<p class="repletion">
領収書には「交付を受ける者の氏名または名称（宛名）」「取引年月日（ご注文日）」「取引金額（税込）」「取引内容（但し書き）」「税率毎に区分した合計金額」「税率毎に区分した税額」「発行者（株式会社ビー・アール・ティー）」「登録番号」を記載しております。<br><span class="attention">代金引換の場合、領収書の発行はしておりません。ヤマト運輸が発行するお客様控え（代引金額領収書）が領収書となります。</span><br>
領収書について詳細は<a href="https://www.bronline.jp/guide/payment/#receipt" target="_blank" style="text-decoration:underline;">こちら</a>をご確認ください。</p>

  <div class="payment sub-title">
    <p>ギフトラッピング</p>
  </div>
  <table class="option payment giftwrapping">
    <tbody>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">ギフトラッピング</td>
				<td class="payment_info">
  				<div class="wrap_select gift">
						<!-- suzuki mod start name&id="delivery_day"->"lapping" -->
						<select name="lapping" id="lapping" class="col1">
							<!-- suzuki mod start value set&smartytag -->
							<option value="0" <!--{%$lapping_0%}-->>ギフトラッピングなし</option>
							<option value="1" <!--{%$lapping_1%}-->>ギフトラッピングする</option>
							<!-- suzuki mod end -->
							</select>
					</div>
				<span class="gift">（有料：330円）</span>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
			<tr>
        <td class="payment_heading">メッセージカード</td>
				<td class="payment_info">
  				<div class="wrap_select gift">
						<!-- suzuki mod start name&id="delivery_day"->"msg_card" add onChange-->
						<select name="msg_card" id="msg_card" class="col1" onChange="document.getElementById('msg_card_dtl').disabled=(this.value=='0')">
							<!-- suzuki mod start value set&smartytag -->
							<option value="0" <!--{%$msg_card_0%}-->>メッセージカードなし</option>
							<option value="1" <!--{%$msg_card_1%}-->>メッセージカードあり</option>
						</select>
					</div>
				<span class="gift">（無料）</span>
						<!-- suzuki mod start name=""->"msg_card_dtl" add id&value -->
						<textarea class="msg gift" name="msg_card_dtl" id="msg_card_dtl" maxlength="50" placeholder="メッセージの内容をご記入ください（50字以内）" <!--{%$msg_card_dtl_disabled%}--> required=""><!--{%$msg_card_dtl%}--></textarea>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="attention" id="payerr">代金引換は30万以上の場合選択できません。</p>

	<div class="payment sub-title">
    	<p>その他</p>
	</div>
<table class="option payment none-mb">
    <tbody>
			<tr>
				<td class="payment_heading">簡易梱包</td>
				<td class="payment_info">
  				<div class="wrap_select">
						<!-- suzuki mod start name&id="delivery_day"->"simple_package" -->
						<select name="simple_package" id="simple_package" class="col1">
							<!-- suzuki mod start value set&smartytag -->
							<option value="0" <!--{%$simple_package_0%}-->>簡易梱包を希望しない</option>
							<option value="1" <!--{%$simple_package_1%}-->>簡易梱包を希望する</option>
						</select>
					</div>

				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion">商品発送時、ダンボール箱ではなく紙袋に入れてお届けします。ジャケットやバッグ、香水等ワレ物など、簡易梱包ができないお品もありますので予めご了承ください。</p>

  <div class="payment sub-title">
    <p>備考</p>
  </div>
  <table class="option payment none-mb">
    <tbody>
			<tr>
        <td class="payment_heading">ご希望・ご連絡等</td>
				<td class="payment_info">
						<!-- suzuki mod start name&id=""->"msg_contact" add value -->
						<textarea class="msg contact" name="msg_contact" maxlength="100" placeholder="その他お問い合わせ事項がございましたら、こちらにご入力ください。"><!--{%$msg_contact%}--></textarea>
				</td>
			</tr>
      <tr><td colspan="2" class="border_none"><hr></td></tr>
		</tbody>
  </table>
  <p class="repletion" style="color:red;">お直しは全て別料金となります。必ず<a href="https://www.bronline.jp/item/?category=%25E3%2582%25B5%25E3%2582%25A4%25E3%2582%25BA%25E7%259B%25B4%25E3%2581%2597&subcategory=&brand=&size=&color=&shopn=&filter=on&word_item=&filters=" target="_blank" class="bold underline" style="color:red;">お直しメニュー</a>から希望のサービスをカートに入れて商品と一緒にご購入ください。寸法はこちらの備考欄にご入力ください。代金引換は後払いとなるためお受けできません。またメニューに無いお直しはうけたまわることができませんので何卒ご了承ください。 </p>
	<!-- </form> suzuki move -->

    <div class="btn_area">
			<button class="submit_sys block confirm" type="submit" onclick="if (val_check()) return true; else return false;">次へ</button>
			<a href="" class="back_sys block" onclick="location.href='<!--{%$payment_back_url%}-->';">戻る</a>
		</div>
	</form><!-- suzuki move -->
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
<script type="text/javascript" src="/common/js/cart.js"></script>
<script>
$(function(){
	$('#point_use').change(function(){
		var max_point = <!--{%$customer.point%}-->;
		var point = $(this).val();

		if (point < 0)
			$(this).val(0);
		if (max_point < point)
		{
			$(this).val(max_point);
		}
	});
	$('.cupon_code').blur(function(){
			var url = "/api/couponcheck.json";
			var _customer_id = '<!--{%$customer_id%}-->';
			var _coupon = $('.cupon_code').val();
			var _cartinfo = <!--{%$cartinfo|json_encode%}-->;
	
			var data = {customer_id : _customer_id, coupon : _coupon, price : <!--{%$total_price%}-->, cartinfo : _cartinfo};
			var res = sendApi2(url, data, coupon_view);
	});
	
	if ($('.cupon_code').val() != '')
	{
		$('.cupon_code').blur();
	}
});

var btn_check = true;

function coupon_view2(data)
{
console.log('coupon_view2');
console.log(data);
	if (data != undefined)
	{
		if (data.err == false)
		{
			$('.coupon').show();
			btn_check = false;
			location.hash="cupon_code";
		}
		else
		{
			$('.coupon').hide();
			btn_check = true;
		}
	}
	else
	{
		$('.coupon').hide();
		btn_check = true;
	}
}

function coupon_view(data)
{
console.log('coupon_view');
console.log(data);
	if (data != undefined)
	{
//		console.log(JSON.stringify(data));
		console.log(data.discount);
		console.log(data.discount_p);
		if (data.discount == '' && data.discount_p == '' && data.product_ids == '')
		{
			$('.coupon').show();
			btn_check = false;
			location.hash="cupon_code";
		}
		else
		{
			$('.coupon').hide();
			btn_check = true;
		}
	}
	else
	{
		$('.coupon').hide();
		btn_check = true;
	}
	
console.log(btn_check);
	if (btn_check)
	{
		var url = "/api/couponcheck2.json";
		var _customer_id = '<!--{%$customer_id%}-->';
		var _email = '<!--{%$customer_email%}-->';
		var _coupon = $('.cupon_code').val();

		var data = {customer_id : _customer_id, email : _email, coupon : _coupon};
		res = sendApi2(url, data, coupon_view2);
	}
}
function sendApi2(hostUrl, param, callback)
{
		console.log(hostUrl);
		console.log(param);
//		setTimeout("displayLoading()", 100);
		_res = null;
		$.ajax({
            url: hostUrl,
            type:'GET',
            dataType: 'json',
			cache: false,
            async:false,
            data : param,
            timeout:30000,
        }).done(function(data) {

			console.log(data);
			if (data.result != undefined)
			{
				if (data.result.status != 0)
				{
					alert("データ取得でエラーがありました。");
					return false;
				}
			}
			else
			{
			}

			if (callback != undefined)
				callback(data);
			
			return true;

        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
        	/*
                 alert(XMLHttpRequest.status);
                 alert(textStatus);
                 alert(errorThrown.message);
             */
                 console.log("Status:"+XMLHttpRequest.status+"Text:"+textStatus+"Msg:"+errorThrown.message);
                 
			if (callback != undefined)
			{
				callback(undefined);
			}
//			setTimeout("removeLoading()", 500);
        }).always(function(data) {
				_res = data;
//				setTimeout("removeLoading()", 500);
    	})
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-addon.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-ja.js"></script>
<link rel="stylesheet" href="/admin_common/css/jquery-ui-timepicker-addon.css">
<script src="/admin_common/js/datepicker-ja.js"></script>
<script type="text/javascript">
<!--
    function fnEdit(customer_id) {
        document.form1.action = '<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->customer/edit.php';
        document.form1.mode.value = "edit"
        document.form1['customer_id'].value = customer_id;
        document.form1.submit();
        return false;
    }

    function fnCopyFromOrderData() {
        df = document.form1;
        df['shipping_name01[0]'].value = df.order_name01.value;
        df['shipping_name02[0]'].value = df.order_name02.value;
        df['shipping_kana01[0]'].value = df.order_kana01.value;
        df['shipping_kana02[0]'].value = df.order_kana02.value;
        df['shipping_zip01[0]'].value = df.order_zip01.value;
        df['shipping_zip02[0]'].value = df.order_zip02.value;
        df['shipping_tel01[0]'].value = df.order_tel01.value;
        df['shipping_tel02[0]'].value = df.order_tel02.value;
        df['shipping_tel03[0]'].value = df.order_tel03.value;
        df['shipping_pref[0]'].value = df.order_pref.value;
        df['shipping_addr01[0]'].value = df.order_addr01.value;
        df['shipping_addr02[0]'].value = df.order_addr02.value;
    }

    function fnFormConfirm() {
        if (fnConfirm()) {
            document.form1.submit();
        }
    }

    function fnMultiple() {
        win03('<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->order/multiple.php', 'multiple', '600', '500');
        document.form1.anchor_key.value = "shipping";
        document.form1.mode.value = "multiple";
        document.form1.submit();
        return false;
    }

    function fnAppendShipping() {
        document.form1.anchor_key.value = "shipping";
        document.form1.mode.value = "append_shipping";
        document.form1.submit();
        return false;
    }
$(function(){
    $(document).on("click", ".del", function(){
        $(this).parent().empty();
    });
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:1,
		showOtherMonths: true,
/*		selectOtherMonths: true,*/
/*		minDate: new Date(<!--{%$year%}-->,<!--{%$month-1%}-->,<!--{%$day%}-->),*/
		showOn: "both",
		buttonText: "カレンダーを表示",
/*		timeFormat: "HH:mm",
		stepMinute: 10,*/
	});
	$('.datepicker2').datetimepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:1,
		showOtherMonths: true,
/*		selectOtherMonths: true,*/
/*		minDate: new Date(<!--{%$year%}-->,<!--{%$month-1%}-->,<!--{%$day%}-->),*/
		showOn: "both",
		buttonText: "カレンダーを表示",
		timeFormat: "HH:mm:ss",
		stepMinute: 10,
	});
});

//-->
</script>
<form name="form1" id="form1" method="post" enctype="multipart/form-data" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="order_id" value="<!--{%$arrForm.order_id%}-->" />
<input type="hidden" name="edit_customer_id" value="" />
<input type="hidden" name="anchor_key" value="" />
<input type="hidden" id="mode" name="mode" value="update" />
<input type="hidden" id="add_product_id" name="add_product_id" value="" />
<input type="hidden" id="add_product_class_id" name="add_product_class_id" value="" />
<input type="hidden" id="edit_product_id" name="edit_product_id" value="" />
<input type="hidden" id="edit_product_class_id" name="edit_product_class_id" value="" />
<input type="hidden" id="no" name="no" value="" />
<input type="hidden" id="delete_no" name="delete_no" value="" />
<!--{foreach key=key item=item from=$arrSearchHidden}-->
    <!--{if is_array($item)}-->
        <!--{foreach item=c_item from=$item}-->
        <input type="hidden" name="<!--{$key|h}-->[]" value="<!--{$c_item|h}-->" />
        <!--{/foreach}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key|h}-->" value="<!--{$item|h}-->" />
    <!--{/if}-->
<!--{/foreach}-->

<div id="order" class="contents-main">
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnChangeAction('/admin/order/');$('#form1').submit();"><span class="btn-prev">検索画面に戻る</span></a></li>
        	<!--{%if $smarty.SESSION.authority == 0%}-->
            <li><a class="btn-action" href="javascript:;" onclick="return fnFormConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
            <!--{%/if%}-->
        </ul>
    </div>

    <!--▼お客様情報ここから-->
    <table class="form">

	<!--{%if $smarty.SESSION.authority == 0%}-->
        <!--{if $tpl_mode != 'add'}-->
        <tr>
            <th>帳票出力</th>
            <td><a class="btn-normal" href="javascript:;" onclick="win02('/admin/pdf.php?order_id=<!--{%$arrForm.order_id|h%}-->','pdf','615','650'); return false;">帳票出力</a></td>
        </tr>
        <!--{/if}-->
    <!--{%/if%}-->

        <tr>
            <th>注文番号</th>
            <td><!--{%$arrForm.order_id%}--></td>
        </tr>
        <tr>
            <th>受注日</th>
            <td><!--{%$arrForm.create_date|date_format:"%Y-%m-%d %H:%M:%s"%}--></td>
        </tr>
        <tr>
            <th>対応状況</th>
            <td>
                <!--{%assign var=key value="status"%}-->
	                <span class="attention"></span>
	                <select name="<!--{%$key%}-->">
	                    <option value="">選択してください</option>
	                    <!--{%html_options options=$arrORDERSTATUS selected=$arrForm[$key]%}-->
	                </select><br />
            </td>
        </tr>
        <tr>
            <th>入金日</th>
            <td><!--{%$arrForm.commit_date|default:"未入金"|h%}--></td>
        </tr>
        <tr>
            <th>発送日</th>
            <td><!--{%$arrForm.send_date|default:"未発送"|h%}--></td>
        </tr>
        <tr>
            <th>伝票番号</th>
            <td><input type="text" name="send_number" value="<!--{%$arrForm.send_number|default:""|h%}-->" size="15" class="box15" /></td>
        </tr>
        <tr>
            <th>支払方法</th>
            <td>
            	<!--{%foreach $arrPayments as $k=>$pay%}-->
            		<!--{%if $arrForm.payment_id == $k%}-->
            			<!--{%$pay%}-->
            		<!--{%/if%}-->
            	<!--{%/foreach%}-->
            </td>
        </tr>
    </table>

<!--{%if $smarty.SESSION.authority == 0%}-->
    <h2>注文者情報</h2><p>会員の場合には情報は変更されません。</p>

    <table class="form">
        <tr>
            <th>顧客ID</th>
            <td>
                <!--{%if $arrForm.customer_id > 0%}-->
                    <!--{%$arrForm.customer_id|h%}-->
                    <input type="hidden" name="customer_id" value="<!--{%$arrForm.customer_id|h%}-->" />
                <!--{%else%}-->
                    (非会員)
                <!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>会員ランク</th>
            <td>
                <!--{%if $arrForm.customer_id > 0%}-->
					<!--{%foreach $arrRank as $k=>$v%}-->
						<!--{%if $customer.customer_rank == $k%}-->
							<!--{%$v|upper%}-->
						<!--{%/if%}-->
					<!--{%/foreach%}-->
				<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>お名前</th>
            <td>
                <!--{%assign var=key1 value="name01"%}-->
                <!--{%assign var=key2 value="name02"%}-->
                <!--{%if $arrForm.customer_id > 0%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer[$key1]%}-->" size="15" class="box15" />
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$customer[$key2]%}-->" size="15" class="box15" />
                <!--{%else%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]%}-->" size="15" class="box15" />
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]%}-->" size="15" class="box15" />
                <!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>お名前(フリガナ)</th>
            <td>
                <!--{%assign var=key1 value="kana01"%}-->
                <!--{%assign var=key2 value="kana02"%}-->
                <!--{%if $arrForm.customer_id > 0%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer[$key1]|h%}-->" size="15" class="box15" />
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$customer[$key2]|h%}-->" size="15" class="box15" />
                <!--{%else%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="15" class="box15" />
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="15" class="box15" />
				<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>
                <!--{%assign var=key1 value="email"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <!--{%if $arrForm[$key1]%}-->
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="30" class="box30" />
                <!--{%else%}-->
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer.email|h%}-->" size="30" class="box30" />
                <!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>TEL</th>
            <td>
                <!--{%assign var=key1 value="tel01"%}-->
                <!--{%if $arrForm.customer_id > 0%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer[$key1]|h%}-->" size="20" class="box20" />
                <!--{%else%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="20" class="box20" />
				<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>住所</th>
            <td>
                <!--{%assign var=key1 value="zip01"%}-->
                <!--{%assign var=key2 value="zip02"%}-->

                <!--{%if $arrForm.customer_id > 0%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                〒
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer[$key1]|h%}-->" size="6" class="box6" />
                -
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$customer[$key2]|h%}-->" size="6" class="box6" />
                <!--{%assign var=key value="pref"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select class="top" name="<!--{%$key%}-->">
                    <option value="" selected="">都道府県を選択</option>
                    <!--{%html_options options=$arrPref selected=$customer[$key]%}-->
                </select><br />
                <!--{%assign var=key value="addr01"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$customer[$key]%}-->" size="60" class="box60 top"  /><br />
                <!--{%assign var=key value="addr02"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$customer[$key]%}-->" size="60" class="box60" />

                <!--{%else%}-->

                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                〒
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="6" class="box6" />
                -
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="6" class="box6" />
                <!--{%assign var=key value="pref"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select class="top" name="<!--{%$key%}-->">
                    <option value="" selected="">都道府県を選択</option>
                    <!--{%html_options options=$arrPref selected=$arrForm[$key]%}-->
                </select><br />
                <!--{%assign var=key value="addr01"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]%}-->" size="60" class="box60 top"  /><br />
                <!--{%assign var=key value="addr02"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]%}-->" size="60" class="box60" />
				<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>備考</th>
            <td><!--{%$arrForm.memo|h|nl2br%}--></td>
        </tr>
        <tr>
            <th>現在ポイント</th>
            <td>
                <!--{%if $arrForm.customer_id > 0%}-->
                    <!--{%$customer.point|number_format%}-->
                    pt
                <!--{%else%}-->
                    (非会員)
            <!--{%/if%}-->
            </td>
        </tr>
		<!--{%if $arrForm.customer_id > 0%}-->
        <tr>
            <th>最終購入日<br><span class="red">ステータスが発送済み、オーダー、入荷待ちでは保存されません。（注文日で保存されます）</span></th>
            <td>
                <!--{%assign var=key1 value="last_buy_date"%}-->
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$customer[$key1]|date_format:"%Y-%m-%d %H:%M:%S"|h%}-->" size="20" class="box20 datepicker2" />
            </td>
        </tr>
		<!--{%/if%}-->
<!--{%*
        <tr>
            <th>アクセス端末</th>
            <td><!--{$arrDeviceType[$arrForm.device_type_id.value]|h}--></td>
        </tr>
*%}-->
    </table>
<!--{%/if%}-->
    <!--▲お客様情報ここまで-->

    <!--▼受注商品情報ここから-->
    <a name="order_products"></a>
    <h2 id="order_products">
        受注商品情報
    </h2>
    <table class="list" id="order-edit-products">
        <tr>
            <th style="width:150px;">セール対象</th>
            <th class="id">商品コード</th>
            <th class="name">商品名/カラー/サイズ</th>
            <th class="price">単価</th>
            <th class="qty">数量</th>
            <th class="price">税込み価格</th>
            <th class="price">小計</th>
        </tr>
<!--{%assign var=subtotal value=0%}-->
<!--{%foreach from=$arrDetail item=item key=key%}-->
<!--{%if $item.sale%}-->
        <tr style="background-color:#884444;">
			<td>セール対象商品</td>
<!--{%elseif $item.reservation_flg == 1%}-->
        <tr style="background-color:#ede3f2;">
        <!--{%if $arrForm.customer_sale_status >= 1%}-->
        <!--{%if $item.sale_status == 1 && $arrForm.customer_sale_status == 1%}-->
			<td>シークレットセール対象品<br>完全受注生産商品</td>
        <!--{%elseif $item.sale_status == 2 && $arrForm.customer_sale_status == 2%}-->
			<td>VIPシークレットセール対象品<br>完全受注生産商品</td>
        <!--{%else%}-->
			<td>完全受注生産商品</td>
		<!--{%/if%}-->
		<!--{%else%}-->
			<td>完全受注生産商品</td>
		<!--{%/if%}-->
<!--{%elseif $item.reservation_flg == 2%}-->
        <tr style="background-color:#f8e5f1;">
        <!--{%if $arrForm.customer_sale_status >= 1%}-->
        <!--{%if $item.sale_status == 1 && $arrForm.customer_sale_status == 1%}-->
			<td>シークレットセール対象品<br>予約商品</td>
        <!--{%elseif $item.sale_status == 2 && $arrForm.customer_sale_status == 2%}-->
			<td>VIPシークレットセール対象品<br>予約商品</td>
        <!--{%else%}-->
			<td>予約商品</td>
		<!--{%/if%}-->
		<!--{%else%}-->
			<td>予約商品</td>		
		<!--{%/if%}-->
<!--{%else%}-->
        <tr>
        <!--{%if $arrForm.customer_sale_status >= 1%}-->
        <!--{%if $item.sale_status == 1 && $arrForm.customer_sale_status == 1%}-->
			<td>シークレットセール対象品</td>
        <!--{%elseif $item.sale_status == 2 && $arrForm.customer_sale_status == 2%}-->
			<td>VIPシークレットセール対象品</td>
        <!--{%else%}-->
			<td></td>
		<!--{%/if%}-->
		<!--{%else%}-->
			<td></td>		
		<!--{%/if%}-->
<!--{%/if%}-->
            <td>
                <!--{%$item.product_code%}-->
                <input type="hidden" name="product_code[]" value="<!--{%$item.product_code%}-->" id="product_code_<!--{%$key%}-->" />
            </td>
            <td>
                <!--{%$item.product_name|strip_tags:false%}--> / <!--{%$item.color_name%}--> / <!--{%$item.size_name%}-->
            </td>
            <td align="center">
                <!--{%$item.price%}-->
            </td>
            <td align="center">
                <!--{%$item.quantity%}-->
            </td>
            <td class="right"><!--{%Tag_Util::taxin_cal($item.price)|number_format%}--> 円</td>
            <td class="right"><!--{%Tag_Util::taxin_cal($item.price*$item.quantity)|number_format%}--> 円</td>
        </tr>
<!--{%assign var=subtotal value="`$subtotal+Tag_Util::taxin_cal($item.price*$item.quantity)`"%}-->
<!--{%/foreach%}-->

        <tr>
            <th colspan="5" class="column right">小計</th>
            <td class="right"><!--{%$subtotal|number_format%}-->円</td>
        </tr>
	<!--{%if $smarty.SESSION.authority == 0%}-->
        <tr>
            <th colspan="5" class="column right">調整額</th>
            <td class="right">
                <!--{%assign var=key value="discount"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" disabled="disabled" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">送料</th>
            <td class="right">
                <!--{%assign var=key value="deliv_fee"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" disabled="disabled" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">手数料</th>
            <td class="right">
                <!--{%assign var=key value="fee"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" disabled="disabled" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">ギフトラッピング</th>
            <td class="right">
                <!--{%assign var=key value="gift_price"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" disabled="disabled" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">合計</th>
            <td class="right">
                <span class="attention"><!--{$arrErr.total}--></span>
                <!--{%$arrForm.total|number_format%}--> 円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">お支払い合計</th>
            <td class="right">
                <span class="attention"><!--{$arrErr.payment_total}--></span>
                <!--{%$arrForm.payment_total|default:"0"|number_format%}-->
                円
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">明細書</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="detail_statement"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select name="<!--{%$key%}-->">
                <option value="1" <!--{%if $arrForm[$key] == 1%}-->selected<!--{%/if%}-->>同封する</option>
                <option value="0" <!--{%if $arrForm[$key] == 0%}-->selected<!--{%/if%}-->>同封しない</option>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">領収書　宛名</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="recepit_atena"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" />
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">領収書　但し</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="receipt_tadashi"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" />
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">簡易包装</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="packing"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select name="<!--{%$key%}-->">
                <option value="1" <!--{%if $arrForm[$key] == 1%}-->selected<!--{%/if%}-->>ダンボール箱を希望する</option>
                <option value="0" <!--{%if $arrForm[$key] == 0%}-->selected<!--{%/if%}-->>紙袋を希望する</option>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">メッセージカード</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="card"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <!--{%if $arrForm[$key]|h%}-->希望する<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th colspan="2" class="column right">メッセージカード内容</th>
            <td colspan="4" class="right">
                <!--{%assign var=key value="msg_card"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <!--{%$arrForm[$key]|h%}-->
            </td>
        </tr>
           <tr>
               <th colspan="5" class="column right">使用ポイント</th>
               <td class="right">
                   <!--{%assign var=key value="use_point"%}-->
                   <span class="attention"><!--{$arrErr[$key]}--></span>
                   <input type="text" name="<!--{%$key%}-->" disabled="disabled" value="<!--{%$arrForm[$key]|default:0|h%}-->" size="5" class="box6" />
                   pt
               </td>
           </tr>
           <tr>
               <th colspan="5" class="column right">加算ポイント</th>
               <td class="right">
                   <!--{%$arrForm.add_point|number_format|default:0%}-->
                   pt
               </td>
           </tr>
	<!--{%/if%}-->
    </table>

<!--{%if $smarty.SESSION.authority == 0%}-->
    <h2>お届け先情報<h2>

        <table class="form">
        <tr>
            <th>お名前</th>
            <td>
                <!--{%assign var=key1 value="name01"%}-->
                <!--{%assign var=key2 value="name02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="arrDeliv[<!--{%$key1%}-->]" value="<!--{%$arrDeliv[$key1]%}-->" size="15" class="box15" />
                <input type="text" name="arrDeliv[<!--{%$key2%}-->]" value="<!--{%$arrDeliv[$key2]%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>お名前(フリガナ)</th>
            <td>
                <!--{%assign var=key1 value="kana01"%}-->
                <!--{%assign var=key2 value="kana02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" name="arrDeliv[<!--{%$key1%}-->]" value="<!--{%$arrDeliv[$key1]|h%}-->" size="15" class="box15" />
                <input type="text" name="arrDeliv[<!--{%$key2%}-->]" value="<!--{%$arrDeliv[$key2]|h%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>TEL</th>
            <td>
                <!--{%assign var=key1 value="tel01"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <input type="text" name="arrDeliv[<!--{%$key1%}-->]" value="<!--{%$arrDeliv[$key1]|h%}-->" size="20" class="box20" />
            </td>
        </tr>
        <tr>
            <th>住所</th>
            <td>
                <!--{%assign var=key1 value="zip01"%}-->
                <!--{%assign var=key2 value="zip02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                〒
                <input type="text" name="arrDeliv[<!--{%$key1%}-->]" value="<!--{%$arrDeliv[$key1]|h%}-->" size="6" class="box6" />
                -
                <input type="text" name="arrDeliv[<!--{%$key2%}-->]" value="<!--{%$arrDeliv[$key2]|h%}-->" size="6" class="box6" />
                <!--{%assign var=key value="pref"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select class="top" name="arrDeliv[<!--{%$key%}-->]">
                    <option value="" selected="">都道府県を選択</option>
                    <!--{%html_options options=$arrPref selected=$arrDeliv[$key]%}-->
                </select><br />
                <!--{%assign var=key value="addr01"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="arrDeliv[<!--{%$key%}-->]" value="<!--{%$arrDeliv[$key]%}-->" size="60" class="box60 top"  /><br />
                <!--{%assign var=key value="addr02"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="arrDeliv[<!--{%$key%}-->]" value="<!--{%$arrDeliv[$key]%}-->" size="60" class="box60" />
            </td>
        </tr>
            <tr>
                <th>お届け時間</th>
                <td>
                    <!--{assign var=key value="time_id"}-->
                    <span class="attention"></span>
                    <select name="deliv_time">
                        <option value="" selected="0">指定無し</option>
                        <!--{%html_options options=$arrDelivTime selected=$arrForm.deliv_time%}-->
                    </select>
                </td>
            </tr>
            <tr>
                <th>お届け日</th>
                <td>
                <input type="text" name="deliv_date" value="<!--{%$arrForm.deliv_date|default:""|date_format:"%Y-%m-%d"%}-->" maxlength="10" size="60" class="box60 datepicker" />
                </td>
            </tr>
        </table>


<!--{%if false%}-->
    <!--{assign var=key value="shipping_quantity"}-->
    <input type="hidden" name="<!--{$key}-->" value="<!--{$arrForm[$key].value|h}-->" />
    <!--▼お届け先情報ここから-->
<!--{if !$shop_mode}-->
    <a name="shipping"></a>
    <h2>お届け先情報
    <!--{if $arrForm.shipping_quantity.value <= 1}-->
        <a class="btn-normal" href="javascript:;" onclick="fnCopyFromOrderData();">お客様情報へお届けする</a>
    <!--{/if}-->
<!--{*
        <a class="btn-normal" href="javascript:;"  onclick="fnAppendShipping();">お届け先を新規追加</a>
        <a class="btn-normal" href="javascript:;" onclick="fnMultiple();">複数のお届け先を指定する</a>
*}-->
    </h2>

    <!--{foreach name=shipping from=$arrAllShipping item=arrShipping key=shipping_index}-->
        <!--{if $arrForm.shipping_quantity.value > 1}-->
            <h3>お届け先<!--{$smarty.foreach.shipping.iteration}--></h3>
        <!--{/if}-->
        <!--{assign var=key value="shipping_id"}-->
        <input type="hidden" name="<!--{$key}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key]|default:"0"|h}-->" id="<!--{$key}-->_<!--{$shipping_index}-->" />
        <!--{if $arrForm.shipping_quantity.value > 1}-->
            <!--{assign var=product_quantity value="shipping_product_quantity"}-->
            <input type="hidden" name="<!--{$product_quantity}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$product_quantity]|h}-->" />

            <!--{if count($arrShipping.shipment_product_class_id) > 0}-->
                <table class="list" id="order-edit-products">
                    <tr>
                        <th class="id">商品コード</th>
                        <th class="name">商品名/規格1/規格2</th>
                        <th class="price">単価</th>
                        <th class="qty">数量</th>
                    </tr>
                    <!--{section name=item loop=$arrShipping.shipment_product_class_id|@count}-->
                        <!--{assign var=item_index value="`$smarty.section.item.index`"}-->

                        <tr>
                            <td>
                                <!--{assign var=key value="shipment_product_class_id"}-->
                                <input type="hidden" name="<!--{$key}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key][$item_index]|h}-->" />
                                <!--{assign var=key value="shipment_product_code"}-->
                                <input type="hidden" name="<!--{$key}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key][$item_index]|h}-->" />
                                <!--{$arrShipping[$key][$item_index]|h}-->
                            </td>
                            <td>
                                <!--{assign var=key1 value="shipment_product_name"}-->
                                <!--{assign var=key2 value="shipment_classcategory_name1"}-->
                                <!--{assign var=key3 value="shipment_classcategory_name2"}-->
                                <!--{*## 追加規格 ADD BEGIN ##*}-->
                                <!--{assign var=key4 value="shipment_extra_info"}-->
                                <!--{*## 追加規格 ADD END ##*}-->
                                <input type="hidden" name="<!--{$key1}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key1][$item_index]|h}-->" />
                                <input type="hidden" name="<!--{$key2}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key2][$item_index]|h}-->" />
                                <input type="hidden" name="<!--{$key3}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key3][$item_index]|h}-->" />
                                <!--{*## 追加規格 MDF BEGIN ##*}-->
                                <!--{if $arrShipExtra[$shipping_index][$item_index]|@count > 0}-->
                                    <!--{assign var=key value="extra_info"}-->
                                    <!--{section name=extra loop=$arrShipExtra[$shipping_index][$item_index]}-->
                                        <!--{assign var=exidx value=`$smarty.section.extra.index`}-->
                                        <input type="hidden" name="<!--{$key4}-->[<!--{$shipping_index}-->][<!--{$item_index}-->][<!--{$exidx}-->][extra_class_name]" value="<!--{$arrShipExtra[$shipping_index][$item_index][$exidx].extra_class_name}-->" />
                                        <input type="hidden" name="<!--{$key4}-->[<!--{$shipping_index}-->][<!--{$item_index}-->][<!--{$exidx}-->][extra_classcategory_name]" value="<!--{$arrShipExtra[$shipping_index][$item_index][$exidx].extra_classcategory_name}-->" />
                                    <!--{/section}-->
                                <!--{/if}-->
                                <!--{$arrShipping[$key1][$item_index]|h}-->
                                <p style="font-size:11px; margin:3px 0;">
                                <!--{$arrShipping[$key2][$item_index]|default:"(なし)"|h}-->/<!--{$arrShipping[$key3][$item_index]|default:"(なし)"|h}--><br />
                                <!--{if $arrShipExtra[$shipping_index][$item_index]|@count > 0}-->
                                    <!--{assign var=key value="extra_info"}-->
                                    <!--{section name=extra loop=$arrShipExtra[$shipping_index][$item_index]}-->
                                        <!--{assign var=exidx value=`$smarty.section.extra.index`}-->
                                        <!--{$arrShipExtra[$shipping_index][$item_index][$exidx].extra_class_name}-->：&nbsp;<!--{$arrShipExtra[$shipping_index][$item_index][$exidx].extra_classcategory_name}--><br />
                                    <!--{/section}-->
                                <!--{/if}-->
                                </p>
                                <!--{*## 追加規格 MDF END ##*}-->
                            </td>
                            <td class="right">
                                <!--{assign var=key value="shipment_price"}-->
                                <!--{$arrShipping[$key][$item_index]|sfCalcIncTax:$arrInfo.tax:$arrInfo.tax_rule|number_format}-->円
                                <input type="hidden" name="<!--{$key}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key][$item_index]|h}-->" />
                            </td>
                            <td class="right">
                                <!--{assign var=key value="shipment_quantity"}-->
                                <!--{$arrShipping[$key][$item_index]|h}-->
                                <input type="hidden" name="<!--{$key}-->[<!--{$shipping_index}-->][<!--{$item_index}-->]" value="<!--{$arrShipping[$key][$item_index]|h}-->" />
                            </td>
                        </tr>
                    <!--{/section}-->
                </table>
            <!--{/if}-->
        <!--{/if}-->

<!--{if $smarty.foreach.shipping.iteration == 1}-->
        <table class="form">
            <tr>
                <th>お名前</th>
                <td>
                    <!--{assign var=key1 value="shipping_name01"}-->
                    <!--{assign var=key2 value="shipping_name02"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--><!--{$arrErr[$key2][$shipping_index]}--></span>
                    <input type="text" name="<!--{$key1}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key1]|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->" size="15" class="box15" />
                    <input type="text" name="<!--{$key2}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key2]|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->" size="15" class="box15" />
                </td>
            </tr>
            <tr>
                <th>お名前(フリガナ)</th>
                <td>
                    <!--{assign var=key1 value="shipping_kana01"}-->
                    <!--{assign var=key2 value="shipping_kana02"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--><!--{$arrErr[$key2][$shipping_index]}--></span>
                    <input type="text" name="<!--{$key1}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key1]|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->" size="15" class="box15" />
                    <input type="text" name="<!--{$key2}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key2]|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->" size="15" class="box15" />
                </td>
            </tr>
            <tr>
                <th>TEL</th>
                <td>
                    <!--{assign var=key1 value="shipping_tel01"}-->
                    <!--{assign var=key2 value="shipping_tel02"}-->
                    <!--{assign var=key3 value="shipping_tel03"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key2][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key3][$shipping_index]}--></span>
                    <input type="text" name="<!--{$key1}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key1]|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->" size="6" class="box6" /> -
                    <input type="text" name="<!--{$key2}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key2]|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->" size="6" class="box6" /> -
                    <input type="text" name="<!--{$key3}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key3]|h}-->" maxlength="<!--{$arrForm[$key3].length}-->" style="<!--{$arrErr[$key3][$shipping_index]|sfGetErrorColor}-->" size="6" class="box6" />
                </td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
                    <!--{assign var=key1 value="shipping_zip01"}-->
                    <!--{assign var=key2 value="shipping_zip02"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--><!--{$arrErr[$key2][$shipping_index]}--></span>
                    〒
                    <input type="text" name="<!--{$key1}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key1]|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->" size="6" class="box6" />
                    -
                    <input type="text" name="<!--{$key2}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key2]|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->" size="6" class="box6" />
                    <a class="btn-normal" href="javascript:;" name="address_input" onclick="fnCallAddress('<!--{$smarty.const.INPUT_ZIP_URLPATH}-->', 'shipping_zip01[<!--{$shipping_index}-->]', 'shipping_zip02[<!--{$shipping_index}-->]', 'shipping_pref[<!--{$shipping_index}-->]', 'shipping_addr01[<!--{$shipping_index}-->]'); return false;">住所入力</a><br />
                    <!--{assign var=key value="shipping_pref"}-->
                    <span class="attention"><!--{$arrErr[$key][$shipping_index]}--></span>
                    <select class="top" name="<!--{$key}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key][$shipping_index]|sfGetErrorColor}-->">
                        <option value="" selected="">都道府県を選択</option>
                        <!--{html_options options=$arrPref selected=$arrShipping[$key]}-->
                    </select><br />
                    <!--{assign var=key value="shipping_addr01"}-->
                    <span class="attention"><!--{$arrErr[$key][$shipping_index]}--></span>
                    <input type="text" name="<!--{$key}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key]|h}-->" size="60" class="box60 top" maxlength="<!--{$arrForm[$key].length}-->" style="<!--{$arrErr[$key][$shipping_index]|sfGetErrorColor}-->" /><br />
                    <!--{assign var=key value="shipping_addr02"}-->
                    <span class="attention"><!--{$arrErr[$key][$shipping_index]}--></span>
                    <input type="text" name="<!--{$key}-->[<!--{$shipping_index}-->]" value="<!--{$arrShipping[$key]|h}-->" size="60" class="box60" maxlength="<!--{$arrForm[$key].length}-->" style="<!--{$arrErr[$key][$shipping_index]|sfGetErrorColor}-->" />
                </td>
            </tr>
            <tr>
                <th>お届け時間</th>
                <td>
                    <!--{assign var=key value="time_id"}-->
                    <span class="attention"><!--{$arrErr[$key][$shipping_index]}--></span>
                    <select name="<!--{$key}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key][$shipping_index]|sfGetErrorColor}-->">
                        <option value="" selected="0">指定無し</option>
                        <!--{html_options options=$arrDelivTime selected=$arrShipping[$key]}-->
                    </select>
                </td>
            </tr>
            <tr>
                <th>お届け日</th>
                <td>
                    <!--{assign var=key1 value="shipping_date_year"}-->
                    <!--{assign var=key2 value="shipping_date_month"}-->
                    <!--{assign var=key3 value="shipping_date_day"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key2][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key3][$shipping_index]}--></span>
                    <select name="<!--{$key1}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrYearShippingDate selected=$arrShipping[$key1]|default:""}-->
                    </select>年
                    <select name="<!--{$key2}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrMonthShippingDate selected=$arrShipping[$key2]|default:""}-->
                    </select>月
                    <select name="<!--{$key3}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key3][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrDayShippingDate selected=$arrShipping[$key3]|default:""}-->
                    </select>日
                </td>
            </tr>
<!--{*
            <tr>
                <th>店舗制作予定日</th>
                <td>
                    <!--{assign var=key1 value="making_date_year"}-->
                    <!--{assign var=key2 value="making_date_month"}-->
                    <!--{assign var=key3 value="making_date_day"}-->
                    <span class="attention"><!--{$arrErr[$key1][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key2][$shipping_index]}--></span>
                    <span class="attention"><!--{$arrErr[$key3][$shipping_index]}--></span>
                    <select name="<!--{$key1}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key1][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrYearShippingDate selected=$arrShipping[$key1]|default:""}-->
                    </select>年
                    <select name="<!--{$key2}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key2][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrMonthShippingDate selected=$arrShipping[$key2]|default:""}-->
                    </select>月
                    <select name="<!--{$key3}-->[<!--{$shipping_index}-->]" style="<!--{$arrErr[$key3][$shipping_index]|sfGetErrorColor}-->">
                        <!--{html_options options=$arrDayShippingDate selected=$arrShipping[$key3]|default:""}-->
                    </select>日
                </td>
            </tr>
*}-->

        </table>
<!--{/if}-->
    <!--{/foreach}-->
    <!--▲お届け先情報ここまで-->

    <a name="deliv"></a>
    <table class="form">
        <tr>
            <th>配送業者<br /><span class="attention">(配送業者の変更に伴う送料の変更は手動にてお願いします。)</span></th>
            <td>
                <!--{assign var=key value="deliv_id"}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select name="<!--{$key}-->" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" onchange="fnModeSubmit('deliv','anchor_key','deliv');">
                    <option value="" selected="">選択してください</option>
                    <!--{html_options options=$arrDeliv selected=$arrForm[$key].value}-->
                </select>
            </td>
        </tr>
        <tr>
<!--{*
            <th>お支払方法<br /><span class="attention">(お支払方法の変更に伴う手数料の変更は手動にてお願いします。)</span></th>
*}-->
            <th>お支払方法<br /><span class="attention">(お支払方法の変更行えません。行う場合はキャセンルしてから受注登録してください。)</span></th>
            <td>
                <!--{assign var=key value="payment_id"}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select name="<!--{$key}-->" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" onchange="fnModeSubmit('payment','anchor_key','deliv');" <!--{if $tpl_mode != 'add'}-->disabled="true"<!--{/if}-->>
                    <option value="" selected="">選択してください</option>
                    <!--{html_options options=$arrPayment selected=$arrForm[$key].value}-->
                </select>
            </td>
        </tr>

        <!--{if $arrForm.payment_info|@count > 0}-->
        <tr>
            <th><!--{$arrForm.payment_type}-->情報</th>
            <td>
                <!--{foreach key=key item=item from=$arrForm.payment_info}-->
                <!--{if $key != "title"}--><!--{if $item.name != ""}--><!--{$item.name}-->：<!--{/if}--><!--{$item.value}--><br/><!--{/if}-->
                <!--{/foreach}-->
            </td>
        </tr>
        <!--{/if}-->

        <tr>
            <th>メモ</th>
            <td>
                <!--{assign var=key value="note"}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <textarea name="<!--{$key}-->" maxlength="<!--{$arrForm[$key].length}-->" cols="80" rows="6" class="area80" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" ><!--{$arrForm[$key].value|h}--></textarea>
            </td>
        </tr>
    </table>
    <!--▲受注商品情報ここまで-->
<!--{/if}-->
<!--{%/if%}-->
<!--{%/if%}-->
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnChangeAction('/admin/order/');$('#form1').submit();"><span class="btn-prev">検索画面に戻る</span></a></li>
        	<!--{%if $smarty.SESSION.authority == 0%}-->
            <li><a class="btn-action" href="javascript:;" onclick="return fnFormConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
            <!--{%/if%}-->
        </ul>
    </div>
</div>
<div id="multiple"></div>
</form>

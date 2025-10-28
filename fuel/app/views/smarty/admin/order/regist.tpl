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
            $('#subtotal_a').val(0);
            total_calc();
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
});

//-->
</script>
<form name="form1" id="form1" method="post" enctype="multipart/form-data" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="order_id" value="<!--{%$arrForm.order_id.value|h%}-->" />
<input type="hidden" name="edit_customer_id" value="" />
<input type="hidden" name="anchor_key" value="" />
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

    <!--▼お客様情報ここから-->
    <table class="form">
<!--{%*
        <!--{if $tpl_mode != 'add'}-->
        <tr>
            <th>帳票出力</th>
            <td><a class="btn-normal" href="javascript:;" onclick="win02('pdf.php?order_id=<!--{$arrForm.order_id.value|h}-->','pdf','615','650'); return false;">帳票出力</a></td>
        </tr>
        <!--{/if}-->
*%}-->
        <tr>
            <th>注文番号</th>
            <td><!--{%$arrForm.order_id%}--></td>
        </tr>
        <tr>
            <th>受注日</th>
            <td>
            <input type="hidden" name="create_date" value="<!--{%$arrForm.create_date%}-->">
            <!--{%$arrForm.create_date%}-->
            </td>
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
    </table>

    <h2>注文者情報</h2>

    <table class="form">
        <tr>
            <th>顧客ID</th>
            <td>
                <input type="hidden" name="customer_id" id="customer_id_in" value="<!--{%$arrForm.customer_id%}-->">
                <div id="customer_id">
                    (非会員)
                </div>
                検索ID：<input type="text" name="customer" id="customer" value=""><button type="button" id="customer_btn">顧客検索</button>
            </td>
        </tr>
        <tr>
            <th>お名前</th>
            <td>
                <!--{%assign var=key1 value="name01"%}-->
                <!--{%assign var=key2 value="name02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]%}-->" size="15" class="box15" />
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>お名前(フリガナ)</th>
            <td>
                <!--{%assign var=key1 value="kana01"%}-->
                <!--{%assign var=key2 value="kana02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="15" class="box15" />
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>
                <!--{%assign var=key1 value="email"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <!--{%if $arrForm[$key1]%}-->
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="30" class="box30" />
                <!--{%else%}-->
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$customer.email|h%}-->" size="30" class="box30" />
                <!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>TEL</th>
            <td>
                <!--{%assign var=key1 value="tel01"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="20" class="box20" />
            </td>
        </tr>
        <tr>
            <th>住所</th>
            <td>
                <!--{%assign var=key1 value="zip01"%}-->
                <!--{%assign var=key2 value="zip02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                〒
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="6" class="box6" />
                -
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="6" class="box6" />
                <!--{%assign var=key value="pref"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select class="top" id="<!--{%$key%}-->" name="<!--{%$key%}-->">
                    <option value="" selected="">都道府県を選択</option>
                    <!--{%html_options options=$arrPref selected=$arrForm[$key]%}-->
                </select><br />
                <!--{%assign var=key value="addr01"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="60" class="box60 top"  /><br />
                <!--{%assign var=key value="addr02"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="60" class="box60" />
            </td>
        </tr>
        <tr>
            <th>備考</th>
            <td><!--{%$arrForm.memo|h|nl2br%}--></td>
        </tr>
        <tr>
            <th>現在ポイント</th>
            <td id="point">
                <!--{%if $arrForm.customer_id > 0%}-->
                    <!--{%$customer.point|number_format%}-->
                    pt
                <!--{%else%}-->
                    (非会員)
            <!--{%/if%}-->
            </td>
        </tr>
<!--{%*
        <tr>
            <th>アクセス端末</th>
            <td><!--{$arrDeviceType[$arrForm.device_type_id.value]|h}--></td>
        </tr>
*%}-->
    </table>
                <input type="hidden" name="point_view" id="point_view" value="">
                <input type="hidden" name="point_rate" id="point_rate" value="">

    <!--▲お客様情報ここまで-->

    <!--▼受注商品情報ここから-->
    <a name="order_products"></a>
    <h2 id="order_products">
        受注商品情報
    </h2>
    <p>商品追加:<input type="text" name="product_code" id="product_code">
    <button type="button" id="product_btn">追加</button>
    <button type="button" id="product_del_btn">削除</button>
    <button type="button" id="product_calc_btn">再計算</button>
    </p>
    <table class="list" id="order-edit-products">
        <tr>
            <th class="id">商品コード</th>
            <th class="name">商品名/カラー/サイズ</th>
            <th class="price">単価</th>
            <th class="qty">数量</th>
            <th class="price">税込み価格</th>
            <th class="price">小計</th>
        </tr>
        <tbody id="product_view">
        </tbody>
        <tr>
            <th colspan="5" class="column right">小計</th>
            <td class="right" id="subtotal_area">
            <input type="hidden" name="subtotal_a" id="subtotal_a" value="0">
            <span id="subtotal"><!--{%$subtotal|number_format%}--></span>円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">調整額</th>
            <td class="right">
                <!--{%assign var=key value="discount"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="discount" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円(税込)
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">送料</th>
            <td class="right">
                <!--{%assign var=key value="deliv_fee"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="deliv_fee" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円(税抜)
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">手数料</th>
            <td class="right">
                <!--{%assign var=key value="fee"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="fee" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円(税抜)
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">ギフトラッピング</th>
            <td class="right">
            <input type="hidden" name="gift" value="0" id="gift">
                <!--{%assign var=key value="gift_price"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="gift_price" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="5" class="box6" />
                円(税抜)
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">合計</th>
            <td class="right">
                <span class="attention"><!--{$arrErr.total}--></span>
                <input type="text" id="total" name="total" value="" readonly>円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">お支払い合計</th>
            <td class="right">
                <span class="attention"><!--{$arrErr.payment_total}--></span>
                <input type="text" id="payment_total" name="payment_total" value="" readonly>円
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">明細書</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="detail_statement"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select id="<!--{%$key%}-->" name="<!--{%$key%}-->">
                <option value="0" <!--{%if $arrForm[$key]|h == 0%}-->selected<!--{%/if%}-->>同封なし</option>
                <option value=1" <!--{%if $arrForm[$key]|h == 1%}-->selected<!--{%/if%}-->>同封する</option>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">領収書　宛名</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="recepit_atena"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" id="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->">
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">領収書　但し</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="receipt_tadashi"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{%$key%}-->" id="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->">
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">簡易包装</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="packing"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select id="<!--{%$key%}-->" name="<!--{%$key%}-->">
                <option value="0" <!--{%if $arrForm[$key]|h == 0%}-->selected<!--{%/if%}-->>希望なし</option>
                <option value=1" <!--{%if $arrForm[$key]|h == 1%}-->selected<!--{%/if%}-->>希望する</option>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">メッセージカード</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="card"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select id="<!--{%$key%}-->" name="<!--{%$key%}-->">
                <option value="0" <!--{%if $arrForm[$key]|h == 0%}-->selected<!--{%/if%}-->>希望なし</option>
                <option value=1" <!--{%if $arrForm[$key]|h == 1%}-->selected<!--{%/if%}-->>希望する</option>
                </select>
            </td>
        </tr>
        <tr>
            <th colspan="5" class="column right">メッセージカード内容</th>
            <td colspan="1" class="right">
                <!--{%assign var=key value="msg_card"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <textarea name="<!--{%$key%}-->" id="<!--{%$key%}-->" cols="10" rows="10"><!--{%$arrForm[$key]|nl2br%}--></textarea>
            </td>
        </tr>
            <tr>
                <th colspan="5" class="column right">使用ポイント</th>
                <td class="right">
                    <!--{%assign var=key value="use_point"%}-->
                    <span class="attention"><!--{$arrErr[$key]}--></span>
                    <input type="text" name="<!--{%$key%}-->" id="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->">
                    pt
                </td>
            </tr>
            <tr>
                <th colspan="5" class="column right">加算ポイント</th>
                <td class="right">
                <!--{%assign var=key value="add_point"%}-->
                <input type="text" name="<!--{%$key%}-->" id="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->">
                    pt
                </td>
            </tr>
    </table>
    <h2>お支払い情報<h2>
    <select name="payment_id">
    <!--{%html_options options=$arrPayments selected=$arrForm.payment_id%}-->
    </select>

    <h2>お届け先情報<h2>
    <p><button id="copy_btn" type="button">注文者情報コピー</button></p>
        <table class="form">
        <tr>
            <th>お名前</th>
            <td>
                <!--{%assign var=key1 value="deliv_name01"%}-->
                <!--{%assign var=key2 value="deliv_name02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]%}-->" size="15" class="box15" />
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>お名前(フリガナ)</th>
            <td>
                <!--{%assign var=key1 value="deliv_kana01"%}-->
                <!--{%assign var=key2 value="deliv_kana02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="15" class="box15" />
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="15" class="box15" />
            </td>
        </tr>
        <tr>
            <th>TEL</th>
            <td>
                <!--{%assign var=key1 value="deliv_tel01"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--></span>
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="20" class="box20" />
            </td>
        </tr>
        <tr>
            <th>住所</th>
            <td>
                <!--{%assign var=key1 value="deliv_zip01"%}-->
                <!--{%assign var=key2 value="deliv_zip02"%}-->
                <span class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></span>
                〒
                <input type="text" id="<!--{%$key1%}-->" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1]|h%}-->" size="6" class="box6" />
                -
                <input type="text" id="<!--{%$key2%}-->" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2]|h%}-->" size="6" class="box6" />
                <!--{%assign var=key value="deliv_pref"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select class="top" id="<!--{%$key%}-->" name="<!--{%$key%}-->">
                    <option value="" selected="">都道府県を選択</option>
                    <!--{%html_options options=$arrPref selected=$arrForm.deliv_pref%}-->
                </select><br />
                <!--{%assign var=key value="deliv_addr01"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="60" class="box60 top"  /><br />
                <!--{%assign var=key value="deliv_addr02"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" size="60" class="box60" />
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


    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnChangeAction('/admin/order/');$('#form1').submit();"><span class="btn-prev">検索画面に戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="return fnFormConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
<div id="multiple"></div>
</form>

<script type="text/javascript" src="/common/js/cart.js"></script>
<script>
$(function(){
    $('#customer_btn').click(function(){
        customer_search();
    });
    $('#product_btn').click(function(){
        product_search();
    });
    $('#product_del_btn').click(function(){
        product_del();
    });
    $('#copy_btn').click(function(){
        copy_customer();
    });
    $('#product_calc_btn').click(function(){
        total_calc();
    });
    $('#gift_fee').change(function(){
        var gift = $(this).val();
        if (gift != '')
            $('#gist').val(gift);
    });
    init_product();
});

function init_product()
{
    $('#add_point').val(0);
    <!--{%if array_key_exists('arrProduct', $arrForm)%}-->
    <!--{%foreach from=$arrForm.arrProduct item=item key=key%}-->
    product_search2('<!--{%$key%}-->');
    $('#arrProduct[<!--{%$key%}-->][quantity]').val(<!--{%$key.quantity%}-->);
    <!--{%/foreach%}-->
    <!--{%/if%}-->
}

var use_point_flg = -1;
function total_calc()
{
use_point_flg = -1;
        var tax = <!--{%$smarty.const.TAX_RATE%}-->;
        var _subtotal = 0;
        $('#add_point').val(0);
        $('.product_list').each(function(){
            var pcode = $(this).attr('id').replace('product_list_','');
            _subtotal += calc_product(pcode);
        });
        $('#subtotal').text(_subtotal);
        
        var _discount = $('#discount').val();
        if (_discount == '')
            _discount = 0;
        _discount = parseInt(_discount,10);
//        _discount = _discount*((tax+100)/100);
        var _deliv_fee = $('#deliv_fee').val();
        if (_deliv_fee == '')
            _deliv_fee = 0;
        _deliv_fee = parseInt(_deliv_fee,10);
        var _fee = $('#fee').val();
        if (_fee == '')
            _fee = 0;
        _fee = parseInt(_fee,10);
        var _gift_price = $('#gift_price').val();
        if (_gift_price == '')
            _gift_price = 0;
        _gift_price = parseInt(_gift_price,10);
        
        var _total = _subtotal - _discount;
        $('#total').val(_total);
        $('#subtotal').text(_subtotal);
        _total += Math.round(_deliv_fee*((tax+100)/100)) + Math.round(_fee*((tax+100)/100)) + Math.round(_gift_price*((tax+100)/100));
        $('#payment_total').val(_total);
}

function product_search()
{    
	var url = "/api/product.json";
    var _product_code = $('#product_code').val();

    console.log($('#product_list_'+_product_code).length);
    if ($('#product_list_'+_product_code).length > 0)
    {
        alert("すでに登録されています。");
        return;
    }
	var param = {product_code : _product_code};
	var res = sendApi(url, param, product_view);
}

function product_search2(code)
{    
	var url = "/api/product.json";
    var _product_code = code;

    console.log($('#product_list_'+_product_code).length);
    
    if ($('#product_list_'+_product_code).length > 0)
    {
        alert("すでに登録されています。");
        return;
    }
	var param = {product_code : _product_code};
	var res = sendApi(url, param, product_view);
}

function copy_customer()
{
    console.log('copy_customer');
    var _name01 = $('#name01').val();
    var _name02 = $('#name02').val();
    var _kana01 = $('#kana01').val();
    var _kana02 = $('#kana02').val();
//    var _email = $('#email').val();
    var _tel01 = $('#tel01').val();
    var _zip01 = $('#zip01').val();
    var _zip02 = $('#zip02').val();
    var _pref = $('#pref').val();
    var _addr01 = $('#addr01').val();
    var _addr02 = $('#addr02').val();
    
    $('#deliv_name01').val(_name01);
    $('#deliv_name02').val(_name02);
    $('#deliv_kana01').val(_kana01);
    $('#deliv_kana02').val(_kana02);
    $('#deliv_tel01').val(_tel01);
    $('#deliv_zip01').val(_zip01);
    $('#deliv_zip02').val(_zip02);
    $('#deliv_pref').val(_pref);
    $('#deliv_addr01').val(_addr01);
    $('#deliv_addr02').val(_addr02);
}
function customer_search()
{
	var url = "/api/customer.json";
	var _customer_id = $('#customer').val();

	var param = {customer_id : _customer_id};
	var res = sendApi(url, param, customer_view);
	
//	return false;
}

function product_view(data)
{
    if (data == false || data == undefined || data == null)
    {
        alert('商品は見つかりませんでした。');
        return;
    }
    
    var product = data.product;
    if (product == 0)
    {
        alert('商品は見つかりませんでした。');
        return;
    }
    if (product.stock == 0)
    {
        alert('商品の在庫がありませんでした。');
        return;
    }
    
    _product_code = product.product_code.trim();
    product.product_code = product.product_code.trim().replace('.','_');
    
    var str = '<tr class="product_list" id="product_list_'+product.product_code+'" point_rate="'+product.point_rate+'">';
    str += '<input type="hidden" name="arrProduct['+_product_code+']" value="'+_product_code+'">';
    str += '<td>商品コード：'+_product_code+'<br>商品ID：'+product.product_id+'</td>';
    str += '<td>'+product.name+' / '+product.color_name+' / '+product.size_name+'</td>';
    str += '<td align="center" id="price_'+product.product_code+'">'+product.price01+'</td>';
    str += '<td align="center"><input type="text" name="arrProduct['+_product_code+'][quantity]" id="quantity_'+product.product_code+'" value="1"></td>';
    str += '<td class="right"><span id="pricetax_'+product.product_code+'"></span>円</td>';
    str += '<td class="right"><span id="subtotal_'+product.product_code+'"></span>円</td></tr>';
    $('#product_view').append(str);
    
    calc_product(product.product_code);
}

function product_del()
{
    var pcode = $('#product_code').val();
    
    $('#product_list_'+pcode).remove();
}

function calc_product(product_code)
{
    var _point_rate = $('#product_list_'+product_code).attr('point_rate');

    var _u_point_rate = $('#point_rate').val();

    var _use_point = $('#use_point').val();
    if (use_point_flg == -1)
	    use_point_flg = _use_point;
    
    if (_use_point == '')
    	_use_point = 0;

    if (_u_point_rate == '' || _u_point_rate == undefined || _u_point_rate == null || _u_point_rate == 0)
    	_u_point_rate = 0;
    	
    if (_point_rate == '')
        _point_rate = 0;

    if (_point_rate < _u_point_rate)
    	_point_rate = _u_point_rate;

    _point_rate = parseInt(_point_rate,10);
    var _quantity = $('#quantity_'+product_code).val();
    var _price = $('#price_'+product_code).text();
    var tax = <!--{%$smarty.const.TAX_RATE%}-->;
    var _pricetax = Math.round((_price) * ((tax+100)/100));
    var _subtotal = Math.round((_price*_quantity) * ((tax+100)/100));
    
    var _point_total = $('#add_point').val();
    if (_point_total == '')
        _point_total = 0;
    _point_total = parseInt(_point_total,10);
    var _point = 0;
    console.log('use_point_flg:'+use_point_flg);
    if (use_point_flg > 0)
    {
	    if ((_price*_quantity) < use_point_flg)
	    {
	    	use_point_flg = use_point_flg - (_price*_quantity);
 console.log('use_point:'+use_point_flg);
		    _point = Math.round(((_price*_quantity)-use_point_flg) * ((_point_rate)/100));
	    }
	    else
	    {
		    _point = Math.round(((_price*_quantity)-use_point_flg) * ((_point_rate)/100));
	    	use_point_flg = 0;
	    }
	    
 console.log('use_point2:'+use_point_flg);
    }
    else
    {
	    _point = Math.round(((_price*_quantity)) * ((_point_rate)/100));
    }
    console.log(_price);
    console.log(_quantity);
    console.log(_point_rate);
    console.log((_point_rate+100)/100);
    console.log(_quantity*_price);
    console.log('point:'+_point_total);
    console.log('point_area:'+_point);
    console.log('point_area2:'+use_point_flg);
    $('#add_point').val(_point_total+_point);
    console.log(product_code);
    console.log(_pricetax);
    
    console.log(_subtotal);
    $('#pricetax_'+product_code).text(_pricetax);
    $('#subtotal_'+product_code).text(_subtotal);
    
    var _sub = $('#subtotal_a').val();
    _sub = parseInt(_sub,10);
    _sub += _price*_quantity;
    $('#subtotal_a').val(_sub);
    
    return _subtotal;
}

function customer_view(data)
{
//	console.log(JSON.parse(data));
    $('#customer_id').empty();
        
	if (data != false)
	{
		console.log(JSON.stringify(data));
		
		var customer = data.customer;

		$('#customer_id_in').val(customer.customer_id);
		$('#customer_id').text(customer.customer_id);
		$('#name01').val(customer.name01);
		$('#name02').val(customer.name02);
		$('#kana01').val(customer.kana01);
		$('#kana02').val(customer.kana02);
		$('#email').val(customer.email);
		$('#tel01').val(customer.tel01);
		$('#zip01').val(customer.zip01);
		$('#zip02').val(customer.zip02);
		var pref = customer.pref;
		$('#pref').val(pref);
		$('#addr01').val(customer.addr01);
		$('#addr02').val(customer.addr02);
		$('#point').text(customer.point);
		$('#point_rate').val(customer.point_rate);
		$('#point_view').val(customer.point);
	}
}
</script>

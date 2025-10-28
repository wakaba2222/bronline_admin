<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-addon.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-ja.js"></script>
<link rel="stylesheet" href="/admin_common/css/jquery-ui-timepicker-addon.css">
<script src="/admin_common/js/datepicker-ja.js"></script>
<script src="/admin_common/js/Sortable.js"></script>
<script>
$(function(){
    $(document).on("click", ".del", function(){
        $(this).parent().empty();
    });
	$('.datetimepicker').datetimepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:2,
		showOtherMonths: true,
/*		selectOtherMonths: true,*/
/*		minDate: new Date(<!--{%$year%}-->,<!--{%$month-1%}-->,<!--{%$day%}-->),*/
		showOn: "both",
		buttonText: "カレンダーを表示",
		timeFormat: "HH:mm",
		stepMinute: 10,
	});

    Sortable.create($('ul#image_area')[0]);
});

function view(id)
{
    location.href = "/admin/basis/campaign_none?id="+id;
}
</script>

<!--{%*
<form name="point_form" id="point_form" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode"id="mode" value="confirm" />
<input type="hidden" name="arrForm[id]" id="id" value="<!--{%$arrForm.id%}-->" />
<div id="basis" class="contents-main">
    <table>
        <tr>
            <th>クーポンコード</th>
            <td>
                <!--{%assign var=key value="code"%}-->
                    <span class="attention"><!--{%$arrErr.code%}--></span>
                <input readonly type="text" name="arrForm[code]" value="<!--{%$arrForm[$key]%}-->" maxlength="15" size="20" class="box20" />
            </td>
        </tr>
        <tr>
            <th>開始日</th>
            <td>
                <!--{%assign var=key value="start_date"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[start_date]" value="<!--{%$arrForm.start_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="" size="20" class="box20 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>終了日</th>
            <td>
                <!--{%assign var=key value="end_date"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[end_date]" value="<!--{%$arrForm.end_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="" size="20" class="box20 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>ステータス</th>
            <td>
                <!--{%assign var=key value="status"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <label><input type="radio" name="arrForm[status]" value="0" <!--{%if $arrForm.status == 0%}-->checked<!--{%/if%}-->/>無効</label>
                <label><input type="radio" name="arrForm[status]" value="1" <!--{%if $arrForm.status == 1%}-->checked<!--{%/if%}-->/>有効</label>
            </td>
        </tr>
        <tr>
            <th>クーポンタイプ</th>
            <td>
                <!--{%assign var=key value="campaign_type"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                    <select name="arrForm[campaign_type]">
                    <option value="">選択してください</value>
                    <!--{%foreach from=$arrTypes item=item key=keys%}-->
                    <option value="<!--{%$keys%}-->" <!--{%if $arrForm[$key] == $keys%}-->selected<!--{%/if%}-->><!--{%$item%}--></value>
                    <!--{%/foreach%}-->
                    </select>
            </td>
        </tr>
        <tr class="">
            <th>会員ID</th>
            <td>
                <!--{%assign var=key value="customer_ids"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[customer_ids]" value="<!--{%$arrForm.customer_ids|default:""%}-->" maxlength="" size="20" class="box20" />
                <span>会員IDを入力　複数会員は「,」区切りで入力</span>
            </td>
        </tr>
        <tr>
            <th>会員ランク</th>
            <td>
                <!--{%assign var=key value="customer_rank"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                    <select name="arrForm[customer_rank]">
                    <option value="">選択してください</value>
                    <!--{%foreach from=$arrCustomerRank item=item key=keys%}-->
                    <option value="<!--{%$keys%}-->" <!--{%if $arrForm[$key] == $keys%}-->selected<!--{%/if%}-->><!--{%$item%}--></value>
                    <!--{%/foreach%}-->
                    </select>
            </td>
        </tr>
        <tr class="discount_type1">
            <th>割引金額</th>
            <td>
                <!--{%assign var=key value="discount"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[discount]" value="<!--{%$arrForm.discount|default:""%}-->" maxlength="" size="6" class="box6" />円
            </td>
        </tr>
        <tr class="discount_type2">
            <th>割引（％）</th>
            <td>
                <!--{%assign var=key value="discount_p"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[discount_p]" value="<!--{%$arrForm.discount_p|default:""%}-->" maxlength="" size="6" class="box6" />％
            </td>
        </tr>
        <tr class="discount_type3">
            <th>商品無料</th>
            <td>
                <!--{%assign var=key value="product_ids"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                商品ID：<input type="text" name="arrForm[product_ids]" value="<!--{%$arrForm.product_ids|default:""%}-->" maxlength="" size="20" class="box20" />
                <span>商品IDを入力　複数商品は「,」区切りで入力</span>
            </td>
        </tr>
        <tr class="discount_type3">
            <th>対象外商品</th>
            <td>
                <!--{%assign var=key value="not_products"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                商品ID：<input type="text" name="arrForm[not_products]" value="<!--{%$arrForm.not_products|default:""%}-->" maxlength="" size="20" class="box20" />
                <span>商品IDを入力　複数商品は「,」区切りで入力</span>
            </td>
        </tr>
        <tr class="discount_type3">
            <th>対象外ショップ</th>
            <td>
                <!--{%assign var=key value="not_shops"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%foreach from=$shops item=shop%}-->
                <!--{%assign var=id value="`$shop.id`"%}-->
                <label><input type="checkbox" name="arrForm[not_shops][]" value="<!--{%$shop.id%}-->" <!--{%if $notshops[$id]%}-->checked<!--{%/if%}-->/> <!--{%$shop.shop_name%}--></label><br>
                <!--{%/foreach%}-->
            </td>
        </tr>

    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('point_form', 'confirm', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
<hr>
*%}-->
<table>
    <tr>
        <th>ステータス</th>
        <th>クーポンコード</th>
        <th>開始日</th>
        <th>終了日</th>
        <th>クーポンタイプ</th>
        <th>会員ID</th>
        <th>会員ランク</th>
        <th>割引額</th>
        <th>割引（％）</th>
        <th>商品無料</th>
        <th>参照</th>
    </tr>
    <!--{%foreach from=$arrCampaign item=campaign%}-->
    <tr>
        <td><!--{%if $campaign.status%}-->有効<!--{%else%}-->無効<!--{%/if%}--></td>
        <td><!--{%$campaign.code|h%}--></td>
        <td><!--{%$campaign.start_date|default:""|date_format:"%Y-%m-%d %H:%M"%}--></td>
        <td><!--{%$campaign.end_date|default:""|date_format:"%Y-%m-%d %H:%M"%}--></td>
        <td><!--{%$arrTypes[$campaign.campaign_type]%}--></td>
        <td><!--{%$campaign.customer_ids|h%}--></td>
        <td><!--{%$arrCustomerRank[$campaign.customer_rank]%}--></td>
        <td><!--{%$campaign.discount|number_format%}-->円</td>
        <td><!--{%$campaign.discount_p|number_format%}-->％</td>
        <td><!--{%$campaign.product_ids%}--></td>
        <td><a href="javascript:view(<!--{%$campaign.id%}-->)">参照</a></td>
    </tr>
    <!--{%/foreach%}-->
</table>
</div>

<div id="basis" class="contents-main" style="margin:40px auto;padding-bottom:40px;">
    <table>
        <tr>
            <th>クーポンコード</th>
            <td>
                <!--{%assign var=key value="code"%}-->
                <!--{%$arrForm[$key]%}-->
            </td>
        </tr>
        <tr>
            <th>開始日</th>
            <td>
                <!--{%assign var=key value="start_date"%}-->
                <!--{%$arrForm.start_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->
            </td>
        </tr>
        <tr>
            <th>終了日</th>
            <td>
                <!--{%assign var=key value="end_date"%}-->
                <!--{%$arrForm.end_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->
            </td>
        </tr>
        <tr class="discount_type3">
            <th>対象外商品</th>
            <td>
            <!--{%$details|@count%}--> 件<br>
            <!--{%foreach from=$details item=p key=key%}-->
            [番号]：<!--{%$key%}--><br>
            [商品ID]：<!--{%$p.product_id%}--><br>
            [ショップ名]：<!--{%$p.shop_name%}--><br>
            [グループコード]：<!--{%$p.group_code%}--><br>
            [商品名]：<!--{%$p.name%}--><br><br>
            <hr style="display:block;">
            <!--{%/foreach%}-->
            </td>
        </tr>
        <tr class="discount_type3">
            <th>対象外ショップ</th>
            <td>
                <!--{%assign var=key value="not_shops"%}-->
                <!--{%foreach from=$shops item=shop%}-->
                <!--{%assign var=id value="`$shop.id`"%}-->
				<!--{%if $notshops[$id]%}--><!--{%$shop.shop_name%}--><br><!--{%/if%}-->
                <!--{%/foreach%}-->
            </td>
        </tr>
	</table>
<p>END</p>
</div>

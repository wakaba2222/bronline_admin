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

function del(id)
{
    if (confirm("[ "+id+" ]のクーポンを削除します。よろしいですか？"))
    {
        $('#mode').val('delete');
        $('#id').val(id);
        $('#point_form').submit();
    }
}
function edit(id)
{
    location.href = "/admin/basis/sales?id="+id;
}
</script>

<form name="point_form" id="point_form" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode"id="mode" value="confirm" />
<input type="hidden" name="arrForm[id]" id="id" value="<!--{%$arrForm.id%}-->" />
<div id="basis" class="contents-main">
    <table>
    <caption>VIPシークレットセール対象品</caption>
        <tr>
            <th>割引率</th>
            <td>
                <!--{%assign var=key value="vip_sale"%}-->
                    <span class="attention"><!--{%$arrErr.vip_sale%}--></span>
                <input type="text" name="arrForm[vip_sale]" value="<!--{%$arrForm[$key]%}-->" maxlength="15" size="20" class="box20" />
            </td>
        </tr>
        <tr>
            <th>開始日</th>
            <td>
                <!--{%assign var=key value="vip_start_date"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[vip_start_date]" value="<!--{%$arrForm.vip_start_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="" size="20" class="box20 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>終了日</th>
            <td>
                <!--{%assign var=key value="vip_end_date"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[vip_end_date]" value="<!--{%$arrForm.vip_end_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="" size="20" class="box20 datetimepicker" />
            </td>
        </tr>
	</table>

    <table>
    <caption>シークレットセール対象品</caption>
        <tr>
            <th>割引率</th>
            <td>
                <!--{%assign var=key value="sale"%}-->
                    <span class="attention"><!--{%$arrErr.sale%}--></span>
                <input type="text" name="arrForm[sale]" value="<!--{%$arrForm[$key]%}-->" maxlength="15" size="20" class="box20" />
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
	</table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('point_form', 'confirm', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

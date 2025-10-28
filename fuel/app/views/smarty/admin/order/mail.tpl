<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="confirm" />
<input type="hidden" name="order_id_array" value="<!--{%$order_id_array%}-->" />
<!--{%foreach key=key item=item from=$arrSearchHidden%}-->
    <!--{%if is_array($item)%}-->
        <!--{%foreach item=c_item from=$item%}-->
        <input type="hidden" name="<!--{%$key|h%}-->[]" value="<!--{%$c_item|h%}-->" />
        <!--{%/foreach%}-->
    <!--{%else%}-->
        <input type="hidden" name="<!--{%$key|h%}-->" value="<!--{%$item|h%}-->" />
    <!--{%/if%}-->
<!--{%/foreach%}-->
<div id="order" class="contents-main">
    <h2>個別通知</h2>

    <!--{%if $order_id_count == 1%}-->
    <table class="list">
        <tr>
            <th>処理日</th>
            <th>宛先</th>
            <th>件名</th>
        </tr>
        <!--{%foreach $arrMailHistory as $mailHistory%}-->
        <tr class="center">
            <td><!--{%$mailHistory['create_date']|date_format:'%Y/%m/%d %H:%M:%S'%}--></td>
            <td><!--{%$mailHistory['to_email']%}--></td>
            <td><!--{%$mailHistory['subject_decode']|h%}--></td>
        </tr>
        <!--{%/foreach%}-->
    </table>
    <!--{%/if%}-->

	<!--{%if $msg != ""%}-->
		<p><b>★<!--{%$msg%}--></b></p>
	<!--{%/if%}-->
    <table class="form">
        <tr>
            <th>テンプレート<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="template_id"%}-->
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <select id="template_id" name="template_id" style="" >
	                <option value="" <!--{%if $arrForm[$key] == ''%}-->selected<!--{%/if%}--> >選択してください</option>
	                <!--{%foreach $arrMailTemplete as $template %}-->
		                <option value="<!--{%$template['id']%}-->" <!--{%if $arrForm[$key] == $template['id']%}-->selected<!--{%/if%}--> ><!--{%$template['name']%}--></option>
	                <!--{%/foreach%}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>メールタイトル<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="subject"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key]|h%}-->" maxlength="" style="" size="30" class="box30" />
            </td>
        </tr>
        <tr>
            <th>ヘッダー</th>
            <td>
                <!--{%assign var=key value="mail_header"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <textarea id="<!--{%$key%}-->" name="<!--{%$key%}-->" maxlength="" style="" cols="75" rows="12" class="area75"><!--{%$arrForm[$key]|h%}--></textarea>
            </td>
        </tr>
<!--{%*
        <tr>
            <th>本文</th>
            <td>
                <!--{%assign var=key value="mail_body"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <textarea id="<!--{%$key%}-->" name="<!--{%$key%}-->" maxlength="" style="" cols="75" rows="12" class="area75"><!--{%$arrForm[$key]|h%}--></textarea>
            </td>
        </tr>
*%}-->
        <tr>
            <th>受注情報</th>
            <td>
                <!--{%assign var=key value="flg_order"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="hidden" name="<!--{%$key%}-->" value="0" />
                <input type="checkbox" name="<!--{%$key%}-->" value="1"  <!--{%if $arrForm[$key] == 1 || $arrForm[$key]|default:"" == '' %}-->checked<!--{%/if%}--> />受注情報を追加する
            </td>
        </tr>
        <tr>
            <th>フッター</th>
            <td>
                <!--{%assign var=key value="mail_footer"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <textarea id="<!--{%$key%}-->" name="<!--{%$key%}-->" maxlength="" style="" cols="75" rows="12" class="area75"><!--{%$arrForm[$key]|h%}--></textarea>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a id="btnReturn" class="btn-action" href="javascript:;" onclick=""><span class="btn-prev">検索結果へ戻る</span></a></li>
            <li><a id="btnSubmit" class="btn-action" href="javascript:;"  onclick=""><span class="btn-next">送信内容を確認</span></a></li>
        </ul>
    </div>
</div>
</form>
<script type="text/javascript">
$(function () {

	$("#btnSubmit").on("click", function() {
		if( $("#template_id").val() == "" ) {
			alert("テンプレートを選択してください。");
			return false;
		}

		if( $("#subject").val() == "" ) {
			alert("メールタイトルを入力してください。");
			return false;
		}

		$("#mode").val('confirm');
		$("#form1").submit();
	});

	$("#template_id").on("change", function() {
		$("#mode").val('template');
		$("#form1").submit();
	});


	$("#btnReturn").on("click", function() {
		$("#form1").attr('action', '/admin/order/');
		$("#mode").val('search');
		$("#form1").submit();
	});

});
</script>

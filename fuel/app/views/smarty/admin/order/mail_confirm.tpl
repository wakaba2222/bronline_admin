<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="send" />
<input type="hidden" name="order_id_array" value="<!--{%$order_id_array%}-->" />
<!--{%foreach key=key item=item from=$arrForm%}-->
<input type="hidden" name="<!--{%$key%}-->" value="<!--{%$item|h%}-->" />
<!--{%/foreach%}-->
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

    <!--{%if $order_id_count > 1%}-->
    <span class="red">※本文は1通分の例です。受注情報は各メールごとに異なります</span><br /><br />
    <!--{%/if%}-->
    <table class="form">
        <tr>
            <th>件名</th>
            <td><!--{%$arrForm['subject']%}--></td>
        </tr>
        <tr>
            <th>本文</th>
            <td>
           		<textarea name="mail_send_body"  style="width:640px; height:640px;"><!--{%$arrForm['mail_header']|h%}--><!--{%$arrForm['mail_body']|h%}-->
<!--{%if $arrForm['flg_order'] == 1%}-->
<!--{%if $arrForm['template_id'] == 1%}-->
<!--{%include file='smarty/email/order_mail.tpl'%}-->
<!--{%else%}-->
<!--{%include file='smarty/email/order_mailx.tpl'%}-->
<!--{%/if%}-->
<!--{%/if%}-->
<!--{%$arrForm['mail_footer']|h%}-->
</textarea>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a id="btnReturn" class="btn-action" href="javascript:;"><span class="btn-prev">前のページへ戻る</span></a></li>
            <li><a id="btnMailSend" class="btn-action" href="javascript:;"><span class="btn-next">メール送信</span></a></li>
        </ul>
    </div>
</div>
</form>
<script>
var cl = false;
$(document).ready(function(){
	$("#btnMailSend").on("click", function() {
		$("#form1").submit();
	});


	$("#btnReturn").on("click", function() {
		$("#mode").val("return");
		$("#form1").submit();
	});
});
</script>

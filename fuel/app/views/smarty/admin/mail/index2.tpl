<script type="text/javascript">
<!--
    function fnFormModeSubmit() {
    	if(confirm("送信しても宜しいですか")) {
        	$("#form1").submit();
    	}
        return false;
    }

//-->
</script>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="send" />
<div id="basis" class="contents-main">
    <h2>メール送信</h2>
    <table>
    	<tr>
    		<th>送信メール種類</th>
    		<td>
    			<select name="mail_type" >
    				<option value="">選択</option>
					<option value="1">受注メール</option>
					<option value="2">ショップ受注</option>
					<option value="3">クロスモール</option>
					<option value="4">ネクストエンジン</option>
    			</select>
    		</td>
    	</tr>
    	<tr>
    		<th>order_id</th>
    		<td><input name="order_id" value="" /></td>
    	</tr>
    </table>

    <!--{%if 0 < count($arrError)%}-->
		<!--{%foreach $arrError as $err %}-->
			<p class="err"><!--{%$err%}--></p>
		<!--{%/foreach%}-->
	<!--{%/if%}-->
    <!--{%if 0 < count($arrMsg)%}-->
		<!--{%foreach $arrMsg as $msg %}-->
			<p class=""><!--{%$msg%}--></p>
		<!--{%/foreach%}-->
	<!--{%/if%}-->
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'send', '', ''); return false;"><span class="btn-next">メール送信する</span></a></li>
        </ul>
    </div>
</div>
</form>

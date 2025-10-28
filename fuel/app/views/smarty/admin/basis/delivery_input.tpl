<script type="text/javascript">
<!--
    function fnSetDelivFee() {
		$(".deliv_fee").val($("#fee_all").val());
    }

    function fnFormModeSubmit() {
    	if(confirm("登録しても宜しいですか")) {
        	$("#form1").submit();
    	}
        return false;
    }

//-->
</script>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="edit" />
<input type="hidden" name="deliv_id" value="<!--{%$arrForm['deliv_id']%}-->" />
<div id="basis" class="contents-main">
    <h2>配送方法登録</h2>
    <table>
        <!--{%for $index=1 to 16 %}-->
	        <!--{%if $index <= count($arrDelivTime)%}-->
	        	<!--{%assign var=time value=$arrDelivTime[$index-1]['deliv_time'] %}-->
	        <!--{%else%}-->
	        	<!--{%assign var=time value=''%}-->
	        <!--{%/if%}-->

        	<!--{%if ($index % 2) %}-->
	        <tr>
	        <!--{%/if%}-->
	        	<th>お届け時間<!--{%$index%}--></th>
		        <td><input type="text" class="deliv_time" name="deliv_time[]" value="<!--{%$time%}-->" maxlength="" style="" size="20" class="box20" /></td>
        	<!--{%if !($index % 2) %}-->
	        </tr>
	        <!--{%/if%}-->
        <!--{%/for%}-->
    </table>

    <h2>配送料登録</h2>
    <div class="btn">※全国一律送料 <input type="text" id="fee_all" name="fee_all" class="box10" /> 円に設定する　<a class="btn-normal" href="javascript:;" onclick="fnSetDelivFee(); return false;"><span>反映</span></a></div>
	<!--{%*$arrErr|@debug_print_var*%}-->
    <table>
       <!--{%foreach $arrPref as $pref%}-->
			<!--{%foreach $arrDelivFee as $delivFee%}-->
	        	<!--{%if $delivFee['pref'] == $pref['id'] %}-->
		        	<!--{%assign var=fee value=$delivFee['fee'] %}-->
		        <!--{%/if%}-->
			<!--{%/foreach%}-->


        	<!--{%*assign var=fee value=$arrDelivFee[$pref['id']]['fee'] *%}-->

        	<!--{%if ($pref['id'] % 2) %}-->
	        <tr>
	        <!--{%/if%}-->
	        	<th><!--{%$pref['name']%}--></th>
		        <td><input type="text" class="deliv_fee" name="deliv_fee[<!--{%$pref['id']%}-->]" value="<!--{%$fee%}-->" maxlength="" style="" size="20" class="box20" /> 円</td>
        	<!--{%if !($pref['id'] % 2) %}-->
	        </tr>
	        <!--{%/if%}-->
        <!--{%/foreach%}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'edit', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

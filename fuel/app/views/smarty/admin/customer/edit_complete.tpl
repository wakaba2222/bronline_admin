<script type="text/javascript">
<!--
	function fnReturn() {
		$("#form1").attr("action", "./index.php");
		$("#form1").submit();
	    return false;
	}
//-->
</script>

<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="complete_return" />

    <!-- 検索条件の保持 -->
    <!--{%foreach $arrSearch as $k => $v%}-->
    	<!--{%if $k|mb_strpos:'search_' === 0%}-->
			<!--{%if is_array($v)%}-->
			    <!--{%foreach $v as $k2 => $v2%}-->
			    <input type="hidden" name="<!--{%$k%}-->[]" value="<!--{%$v2%}-->" />
			    <!--{%/foreach%}-->
			<!--{%else%}-->
			    <input type="hidden" name="<!--{%$k%}-->" value="<!--{%$v%}-->" />
			<!--{%/if%}-->
		<!--{%/if%}-->
	<!--{%/foreach%}-->

    <div id="complete">
        <div class="complete-top"></div>
        <div class="contents">
            <div class="message">
                <!--{%$msg%}-->
            </div>
        </div>
        <div class="btn-area-top"></div>
        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="return fnReturn();"><span class="btn-prev">検索結果へ戻る</span></a></li>
            </ul>
        </div>
        <div class="btn-area-bottom"></div>
    </div>
</form>

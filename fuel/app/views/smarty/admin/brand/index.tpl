<script type="text/javascript">
<!--
    function fnFormModeSubmit() {
    	if(confirm("更新しても宜しいですか")) {
        	$("#form1").submit();
    	}
        return false;
    }

//-->
</script>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="edit" />
<div id="basis" class="contents-main">
	<!--{%foreach $arrMsg as $msg%}-->
		<p><!--{%$msg%}--></p>
	<!--{%/foreach%}-->
    <h2>ブランド名</h2>
    <table>
    	<tr>
    		<th class="box50">ブランド名</th>
<!--    		<th style="width:auto;">優先度</th> -->
    	</tr>
    	<!--{%for $cnt=0 to count($arrArticleTag)%}-->
   			<!--{%assign var='tag_name' value=''%}-->
   			<!--{%assign var='rank_name' value=''%}-->
    		<!--{%if $cnt < count($arrArticleTag)%}-->
    			<!--{%assign var='tag_name' value=$arrArticleTag[$cnt]['keyword']%}-->
    			<!--{%assign var='rank_name' value=$arrArticleTag[$cnt]['rank']%}-->
    		<!--{%/if%}-->
    	<tr>
    		<td><input name="article_tag_name[]" class="box45" value="<!--{%$tag_name%}-->" />表示順番：<input name="article_rank_name[]" class="box15" value="<!--{%$rank_name%}-->" /></td>
    	</tr>
    	<!--{%/for%}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit(); return false;"><span class="btn-next">更新</span></a></li>
        </ul>
    </div>
</div>
</form>

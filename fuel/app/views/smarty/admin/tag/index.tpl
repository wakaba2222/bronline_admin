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
    <h2>記事タグ</h2>
    <table>
    	<tr>
    		<th class="box50">タグ</th>
    		<th style="width:auto;">優先度</th>
    	</tr>
    	<!--{%for $cnt=0 to 9%}-->
   			<!--{%assign var='tag_name' value=''%}-->
   			<!--{%assign var='tag_rank' value=''%}-->
    		<!--{%if $cnt < count($arrArticleTag)%}-->
    			<!--{%assign var='tag_name' value=$arrArticleTag[$cnt]['keyword']%}-->
    			<!--{%assign var='tag_rank' value=$arrArticleTag[$cnt]['rank']%}-->
    		<!--{%/if%}-->
    	<tr>
    		<td><input name="article_tag_name[]" class="box45" value="<!--{%$tag_name%}-->" /></td>
    		<td><input name="article_tag_rank[]" class="box6"  value="<!--{%$tag_rank%}-->" /></td>
    	</tr>
    	<!--{%/for%}-->
    </table>

    <h2>アイテムタグ</h2>
    <table>
    	<tr>
    		<th class="box50">タグ</th>
    		<th style="width:auto;">優先度</th>
    	</tr>
    	<!--{%for $cnt=0 to 9%}-->
   			<!--{%assign var='tag_name' value=''%}-->
   			<!--{%assign var='tag_rank' value=''%}-->
    		<!--{%if $cnt < count($arrItemTag)%}-->
    			<!--{%assign var='tag_name' value=$arrItemTag[$cnt]['keyword']%}-->
    			<!--{%assign var='tag_rank' value=$arrItemTag[$cnt]['rank']%}-->
    		<!--{%/if%}-->
    	<tr>
    		<td><input name="item_tag_name[]" class="box45" value="<!--{%$tag_name%}-->" /></td>
    		<td><input name="item_tag_rank[]" class="box6"  value="<!--{%$tag_rank%}-->" /></td>
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

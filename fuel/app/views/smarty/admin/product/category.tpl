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
<style>
input
{
	width:80%;
}
.parent
{
	background:#4444ee;
}
.child
{
	background:#7799ff;
}
.none
{
	background:#cccccc;
}
.parent_category
{
	background:#4444ee;
	border:none;
}
.child_category
{
	background:#7799ff;
	border:none;
}
.child_category_gray
{
	background:#cccccc;
	border:none;
}
</style>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="edit" />
<div id="basis" class="contents-main">
	<!--{%foreach $arrMsg as $msg%}-->
		<p><!--{%$msg%}--></p>
	<!--{%/foreach%}-->
    <h2>カテゴリ名</h2>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit(); return false;"><span class="btn-next">更新</span></a></li>
        </ul>
    </div>

    <table>
    	<tr>
    		<th class="">カテゴリID</th>
    		<th class="">親カテゴリID</th>
    		<th class="box50">カテゴリ名</th>
    		<th class="box50">カテゴリ別名</th>
    		<th class="box50">並び順No</th>
    		<th class="box50">表示フラグ(0：表示　1：非表示</th>
    	</tr>
		<!--{%foreach from=$arrParent key=key item=item%}-->
    	<tr class="parent">
	   		<td>
				<input class="parent_category" type="text" name="parent_category[category_id][]" id="xx" value="<!--{%$key%}-->" readonly>
	   		</td>
	   		<td>
				<input class="parent_category" type="text" name="parent_category[parent_category_id][]" id="xx" value="<!--{%$item.parent_category_id%}-->" readonly>
	   		</td>
	   		<td>
				<input type="text" name="parent_category[name][]" id="xx" value="<!--{%$item.name%}-->">
	   		</td>
	   		<td>
				<input type="text" name="parent_category[another_name][]" id="xx" value="<!--{%$item.another_name%}-->">
	   		</td>
	   		<td>
				<input type="text" name="parent_category[sort_no][]" id="xx" value="<!--{%$item.sort_no%}-->">
	   		</td>
	   		<td>
				<input type="text" name="parent_category[view_flg][]" id="xx" value="<!--{%$item.view_flg%}-->">
	   		</td>
    	</tr>
		<!--{%foreach from=$item.category item=item2%}-->
		<!--{%if $item2.view_flg == 1%}-->
    	<tr class="none">
    	<!--{%else%}-->
    	<tr class="child">
    	<!--{%/if%}-->
	   		<td>
		<!--{%if $item2.view_flg == 1%}-->
				<input class="child_category_gray" type="text" name="category[category_id][]" id="xx" value="<!--{%$item2.category_id%}-->" readonly>
    	<!--{%else%}-->
				<input class="child_category" type="text" name="category[category_id][]" id="xx" value="<!--{%$item2.category_id%}-->" readonly>
    	<!--{%/if%}-->
	   		</td>
	   		<td>
		<!--{%if $item2.view_flg == 1%}-->
				<input type="text" class="child_category_gray" name="category[parent_category_id][]" id="xx" value="<!--{%$item2.parent_category_id%}-->" readonly>
    	<!--{%else%}-->
				<input type="text" class="child_category" name="category[parent_category_id][]" id="xx" value="<!--{%$item2.parent_category_id%}-->" readonly>
    	<!--{%/if%}-->
	   		</td>
	   		<td>
				<input type="text" name="category[name][]" id="xx" value="<!--{%$item2.name%}-->">
	   		</td>
	   		<td>
				<input type="text" name="category[another_name][]" id="xx" value="<!--{%$item2.another_name%}-->">
	   		</td>
	   		<td>
				<input type="text" name="category[sort_no][]" id="xx" value="<!--{%$item2.sort_no%}-->">
	   		</td>
	   		<td>
				<input type="text" name="category[view_flg][]" id="xx" value="<!--{%$item2.view_flg%}-->">
	   		</td>
    	</tr>
		<!--{%/foreach%}-->
		<!--{%/foreach%}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit(); return false;"><span class="btn-next">更新</span></a></li>
        </ul>
    </div>
</div>
</form>

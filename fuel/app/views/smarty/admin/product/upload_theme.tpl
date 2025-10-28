<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />
<div id="products" class="contents-main">
<p style="color:red;"><!--{%$error%}--></p>        
<!--{%if $err|default:false%}-->
<p style="color:red;">
<!--{%foreach from=$csv_result item=item%}-->
<!--{%$item%}-->
<!--{%/foreach%}-->
</p>
<!--{%/if%}-->
    <!--▼登録テーブルここから-->
    <table>
        <tr>
            <th>CSVファイル</th>
            <td>
                <input type="file" name="csv_file" size="40" /><span class="attention">(1行目タイトル行)</span>
            </td>
        </tr>
        <tr>
            <th>登録情報</th>
            <td>
                <!--{%foreach name=title key=key item=item from=$theme%}-->
                    <!--{%$smarty.foreach.title.iteration%}-->項目：<!--{%$key%}-->：<!--{%$item%}--><br>
                <!--{%/foreach%}-->
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
    <!--▲登録テーブルここまで-->
</div>
</form>

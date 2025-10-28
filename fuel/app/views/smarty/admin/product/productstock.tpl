<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />
<div id="products" class="contents-main">
<p style="color:red;"><!--{%$error%}--></p>
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
                1項目：product_code：商品コード<br>
                2項目：stock：在庫数<br>
                3項目：shop_id：ショップID<br>
        </td>
        </tr>
    </table>
<!--{%if $csv_result|@count %}-->
<div>
	<!--{%foreach $csv_result as $ret%}-->
	<p><!--{%$ret%}--></p>
	<!--{%/foreach%}-->
</div>
<!--{%/if%}-->
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で更新する</span></a></li>
        </ul>
    </div>
    <!--▲登録テーブルここまで-->
</div>
</form>

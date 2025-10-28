<form name="form1" id="form1" method="post" action="/admin/csvupload" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />
<div id="products" class="contents-main">
    <!--▼登録テーブルここから-->
    <table>
        <tr>
            <th>CSVファイル</th>
            <td>
                <!--{%if $arrErr.csv_file%}-->
                    <span class="attention"><!--{%$arrErr.csv_file%}--></span>
                <!--{%/if%}-->
                <input type="file" name="csv_file" size="40" /><span class="attention">(1行目タイトル行)</span>
            </td>
        </tr>
<!--{%if false%}-->
        <tr>
            <th>複製商品について</th>
            <td>
            複製商品の場合、複製品ショップIDに下記のショップ毎のIDを入力してください。<br>
            <!--{%section name=cnt loop=$allShops%}-->
            <!--{%if $smarty.session.member_id != $allShops[cnt].member_id%}-->
            [<!--{%$allShops[cnt].member_id%}-->]  <!--{%$allShops[cnt].name%}--><br>
            <!--{%/if%}-->
            <!--{%/section%}-->
<!--{%*
            [3]  Tremezzo Stile（Mens）<br>
            [5]  Tremezzo Stile（Womens）<br>
            [6]  TIE YOUR TIE<br>
            [7]  L'ANTICO GUARDAROBA<br>
            [8]  SUGAWARA LTD.<br>
            [9]  BOGLIOLI<br>
            [12] guji<br>
            [14] ring<br>
            [13] LEON出張所<br>
*%}-->
            </td>
        </tr>
<!--{%/if%}-->
        <tr>
            <th>登録情報</th>
            <td>
            <!--{%if false%}-->
                <!--{%foreach name=title key=key item=item from=$arrTitle%}-->
                    <!--{%$smarty.foreach.title.iteration%}-->項目：<!--{%$item%}--><br />
                <!--{%/foreach%}-->
            <!--{%/if%}-->
            </td>
        </tr>
    </table>
    <!--▲登録テーブルここまで-->
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

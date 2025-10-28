<!--{%if $smarty.session.stock_type == 2 and $smarty.session.shop != 'altoediritto' and $smarty.session.shop != 'ring' and $smarty.session.shop != 'biglietta'%}-->
<form name="form2" id="form2" method="post" action="/admin/product/crossupload?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />

    <p>クロスモール </p>
    <table>
        <tbody><tr>
            <th>CSVファイル</th>

            <td>
<!--
                商品情報<input type="file" name="csv_file1" size="40"><span class="attention">(1行目タイトル行)</span><br>
                SKU情報<input type="file" name="csv_file2" size="40"><span class="attention">(1行目タイトル行)</span><br>
                指定日付<input type="text" name="csv_date" size="40">例：2014-09-07<span class="attention">(指定日付以降のデータを対象とします)</span>
                <p style="border-bottom:1px solid #ccc;padding:5px;margin-bottom:10px;"></p>
-->
                フューチャーショップ「category.csv」<input type="file" name="csv_file1" size="40"><span class="attention">(1行目タイトル行)</span><br>
                フューチャーショップ「goods.csv」<input type="file" name="csv_file2" size="40"><span class="attention">(1行目タイトル行)</span><br>
                フューチャーショップ「goodsVariationConfirm.csv」<input type="file" name="csv_file3" size="40"><span class="attention">(1行目タイトル行)</span><br>
                楽天「normal-item.csv」<input type="file" name="csv_file4" size="40"><span class="attention">(1行目タイトル行)</span><br>
                BRカテゴリ対応情報<input type="file" name="csv_file5" size="40"><span class="attention">(1行目タイトル行)</span><br>
            </td>
        </tr>
<!--
        <tr>
            <th>商品情報</th>
            <td>
                                    1項目：商品コード<br>
                                    2項目：商品名<br>
                                    3項目：売上単価(税別)<br>
                            </td>
        </tr>
        <tr>
            <th>SKU情報</th>
            <td>
                                    1項目：商品コード<br>
                                    2項目：商品SKUコード<br>
                                    3項目：属性１コード<br>
                                    4項目：属性１名<br>
                                    5項目：属性２コード<br>
                                    6項目：属性２名<br>
                            </td>
        </tr>
-->
    </tbody></table>
        
    <div class="btn-area" style="margin:0 auto 40px;">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で生成する</span></a></li>
        </ul>
    </div>

</form>
<!--{%elseif $smarty.session.shop == 'altoediritto' or $smarty.session.shop == 'ring' or $smarty.session.shop == 'biglietta'%}-->
<form name="form2" id="form2" method="post" action="/admin/product/crossupload2?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />

    <p>クロスモール </p>
    <table>
        <tbody><tr>
            <th>CSVファイル</th>
            <td>
                商品情報<input type="file" name="csv_file1" size="40"><span class="attention">(1行目タイトル行)</span><br>
                SKU情報<input type="file" name="csv_file2" size="40"><span class="attention">(1行目タイトル行)</span><br>
                指定日付<input type="text" name="csv_date" size="40">例：2014-09-07<span class="attention">(指定日付以降のデータを対象とします)</span>
            </td>
        </tr>

        <tr>
            <th>商品情報</th>
            <td>
                                    1項目：商品コード<br>
                                    2項目：商品名<br>
                                    3項目：売上単価(税別)<br>
                            </td>
        </tr>
        <tr>
            <th>SKU情報</th>
            <td>
                                    1項目：商品コード<br>
                                    2項目：商品SKUコード<br>
                                    3項目：属性１コード<br>
                                    4項目：属性１名<br>
                                    5項目：属性２コード<br>
                                    6項目：属性２名<br>
                            </td>
        </tr>
    </tbody></table>
        
    <div class="btn-area" style="margin:0 auto 40px;">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で生成する</span></a></li>
        </ul>
    </div>

</form>
<!--{%*
<form name="form4" id="form4" method="post" action="/admin/product/rakutenupload?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />

    <p>楽天CSV変換</p>
    <table>
        <tbody><tr>
            <th>CSVファイル</th>
            <td>
                ITEM CSV<input type="file" name="csv_file1" size="40"><span class="attention">(1行目タイトル行)</span><br>
                SELECT CSV<input type="file" name="csv_file2" size="40"><span class="attention">(1行目タイトル行)</span><br>
            </td>
        </tr>

    </tbody></table>
        
    <div class="btn-area" style="margin:0 auto 40px;">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form4', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で生成する</span></a></li>
        </ul>
    </div>

</form>
*%}-->
<!--{%elseif $smarty.session.shop == 'forzastyleshop'%}-->
<form name="form3" id="form3" method="post" action="/admin/product/copyupload?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />
<p style="color:red;"><!--{%$error2%}--></p>

    <p>コピー品アップロード</p>
    <table>
        <tbody><tr>
            <th>CSVファイル</th>
            <td>
                商品情報<input type="file" name="csv_file1" size="40"><span class="attention">(1行目タイトル行)</span><br>
            </td>
        </tr>

        <tr>
            <th>商品情報</th>
            <td>
                                    1項目：コピー元商品ID<br>
                                    2項目：コピー元ショップ名（brshop, guji, astilehouse, sugawaraltd, etc...）<br>
                            </td>
        </tr>
    </tbody></table>
        
    <div class="btn-area" style="margin:0 auto 40px;">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form3', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

</form>
<!--{%/if%}-->

<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data"">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="csv_upload" />
<div id="products" class="contents-main">
<p style="color:red;"><!--{%$error%}--></p>
    <a href="#brand">ブランド情報を確認する</a>
        
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
                <!--{%foreach name=title key=key item=item from=$csv_no%}-->
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
    <p id="brand">ブランド一覧</p>
    <table>
    <tr>
        <th>brand_id</th>
        <th>brand_name</th>
        <th>brand_code</th>
    </tr>
    <!--{%foreach from=$arrBrand item=item%}-->
    <tr>
    <td><!--{%$item.id%}--></td><td><!--{%$item.name%}--></td><td><!--{%$item.code%}--></td>
    </tr>
    <!--{%/foreach%}-->
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

<!--{%if $smarty.session.shop == 'biglietta'%}-->

    <p id="brand">カテゴリ一覧</p>
    <table>
    <tr>
        <th>category_id</th>
        <th>category_name</th>
        <th>category_code</th>
    </tr>
    <!--{%foreach from=$arrCategory item=item%}-->
    <tr>
    <td><!--{%$item.category_id%}--></td><td><!--{%$item.name%}--></td><td><!--{%$item.category_code%}--></td>
    </tr>
    <!--{%/foreach%}-->
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'csv_upload', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
<!--{%/if%}-->

</div>
</form>

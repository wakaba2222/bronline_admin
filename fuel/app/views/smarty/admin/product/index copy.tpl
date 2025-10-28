<script type="text/javascript">
// URLの表示非表示切り替え
function lfnDispChange(){
    inner_id = 'switch';

    cnt = document.form1.item_cnt.value;

    if($('#disp_url1').css("display") == 'none'){
        for (i = 1; i <= cnt; i++) {
            disp_id = 'disp_url'+i;
            $('#' + disp_id).css("display", "");

            disp_id = 'disp_cat'+i;
            $('#' + disp_id).css("display", "none");

            $('#' + inner_id).html('    URL <a href="#" onClick="lfnDispChange();"> &gt;&gt; カテゴリ表示<\/a>');
        }
    }else{
        for (i = 1; i <= cnt; i++) {
            disp_id = 'disp_url'+i;
            $('#' + disp_id).css("display", "none");

            disp_id = 'disp_cat'+i;
            $('#' + disp_id).css("display", "");

            $('#' + inner_id).html('    カテゴリ <a href="#" onClick="lfnDispChange();"> &gt;&gt; URL表示<\/a>');
        }
    }

}

</script>

<!--{%if $shop_mode == 'newsugawara'%}-->
<script>
// formのターゲットを自分に戻す
function fnTargetSelf(){
    document.form_csv.target = "_self";
}
</script>
<form name="form_csv" id="form_csv" method="post" action="/admin/contents/csv_sql.php?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="confirm">
<input type="hidden" name="sql_id" value="2">
<input type="hidden" name="csv_output_id" value="">
<input type="hidden" name="select_table" value="">
</form>
<!--{%/if%}-->


<div id="products" class="contents-main">
<form name="search_form" id="search_form" method="post" action="?">
    <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="search" />
    <h2>検索条件設定</h2>

    <!--検索条件設定テーブルここから-->
    <table>
        <tr>
            <th>主商品</th>
            <td colspan="4">
                <!--{%assign var=key value="search_group_view"%}-->
                <!--{%if isset($arrErr[$key])%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <label><input type="radio" name="<!--{%$key%}-->" value="1" <!--{%if $arrForm[$key].value == '' || $arrForm[$key].value == '1'%}-->checked<!--{%/if%}--> />主商品のみ検索対象</label>
                <label><input type="radio" name="<!--{%$key%}-->" value="0" <!--{%if $arrForm[$key].value == '0'%}-->checked<!--{%/if%}--> />すべて検索対象</label>
            </td>
        </tr>
        <tr>
            <th>商品ID</th>
            <td>
                <!--{%assign var=key value="search_product_id"%}-->
                <!--{%if $arrErr[$key]%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="<!--{%$arrErr[$key]%}-->" size="30" class="box30"/>
            </td>
            <th>スマレジ商品ID</th>
            <td>
                <!--{%assign var=key value="search_smaregi_product_id"%}-->
                <!--{%if $arrErr[$key]%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="<!--{%$arrErr[$key]%}-->" size="30" class="box30"/>
            </td>
        </tr>
        <tr>
            <th>商品コード</th>
            <td>
                <!--{%assign var=key value="search_product_code"%}-->
                <!--{%if $arrErr[$key]%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="<!--{%$arrErr[$key]%}-->" size="30" class="box30" />
            </td>
            <th>商品名</th>
            <td>
                <!--{%assign var=key value="search_name"%}-->
                <!--{%if $arrErr[$key]%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="<!--{%$arrErr[$key]%}-->" size="30" class="box30" />
            </td>
        </tr>
<!--{%if $outsize_shop%}-->
        <tr>
            <th>グループコード</th>
            <td>
                <!--{%assign var=key value="search_group_code"%}-->
                <!--{%if $arrErr[$key]%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%/if%}-->
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="<!--{%$arrErr[$key]%}-->" size="30" class="box30" />
            </td>
        </tr>
<!--{%/if%}-->
        <tr>
            <th>部門</th>
            <td>
                <!--{%assign var=key value="search_category_id"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <select name="<!--{%$key%}-->" style="<!--{%$arrErr[$key]%}-->">
                <option value="">選択してください</option>
                <!--{%html_options options=$arrCatList selected=$arrForm[$key].value%}-->
                </select>
            </td>
            <th>種別</th>
            <td>
                <!--{%assign var=key value="search_status"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <!--{%html_checkboxes name="$key" options=$arrDISP selected=$arrForm[$key].value%}-->
            </td>
        </tr>
        <tr>
            <th>在庫</th>
            <td>
                <!--{%assign var=key value="search_stock"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <label><input type="radio" value="0" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 0 || $arrForm[$key].value == ''%}-->checked<!--{%/if%}--> />すべて</label>
                <label><input type="radio" value="1" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 1%}-->checked<!--{%/if%}--> />在庫あり</label>
                <label><input type="radio" value="2" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 2%}-->checked<!--{%/if%}--> />在庫なし</label>
            </td>
        </tr>
        <tr>
            <th>登録・更新日</th>
            <td colspan="3">
                <!--{%if $arrErr.search_startyear || $arrErr.search_endyear%}-->
                    <span class="attention"><!--{%$arrErr.search_startyear%}--></span>
                    <span class="attention"><!--{%$arrErr.search_endyear%}--></span>
                <!--{%/if%}-->
                <select name="search_startyear" style="<!--{%$arrErr.search_startyear%}-->">
                <option value="">----</option>
                <!--{%html_options options=$arrStartYear selected=$arrForm.search_startyear.value%}-->
                </select>年
                <select name="search_startmonth" style="<!--{%$arrErr.search_startyear%}-->">
                <option value="">--</option>
                <!--{%html_options options=$arrStartMonth selected=$arrForm.search_startmonth.value%}-->
                </select>月
                <select name="search_startday" style="<!--{%$arrErr.search_startyear%}-->">
                <option value="">--</option>
                <!--{%html_options options=$arrStartDay selected=$arrForm.search_startday.value%}-->
                </select>日～
                <select name="search_endyear" style="<!--{%$arrErr.search_endyear%}-->">
                <option value="">----</option>
                <!--{%html_options options=$arrEndYear selected=$arrForm.search_endyear.value%}-->
                </select>年
                <select name="search_endmonth" style="<!--{%$arrErr.search_endyear%}-->">
                <option value="">--</option>
                <!--{%html_options options=$arrEndMonth selected=$arrForm.search_endmonth.value%}-->
                </select>月
                <select name="search_endday" style="<!--{%$arrErr.search_endyear%}-->">
                <option value="">--</option>
                <!--{%html_options options=$arrEndDay selected=$arrForm.search_endday.value%}-->
                </select>日
            </td>
        </tr>
<!--{%*
        <tr>
            <th>商品ステータス</th>
            <td colspan="3">
            <!--{%assign var=key value="search_product_statuses"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <!--{%html_checkboxes name="$key" options=$arrSTATUS selected=$arrForm[$key].value%}-->
            </td>
        </tr>
*%}-->
    </table>
    <div class="btn">
        <p class="page_rows">検索結果表示件数
        <!--{%assign var=key value="search_page_max"%}-->
        <!--{%if $arrErr[$key]%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
        <!--{%/if%}-->
        <select name="<!--{%$key%}-->" style="<!--{%$arrErr[$key]%}-->">
            <!--{%html_options options=$arrPageMax selected=$arrForm.search_page_max.value%}-->
        </select> 件</p>

<!--{%*
<!--{%if $shop_mode == 'newsugawara'%}-->
<div>
<p>ネクストエンジン用取扱商品一覧出力
<a class="btn-normal" href="javascript:;" name="stock_update" onclick="if ($('#search_product_code').val()=='' && $('#search_group_code').val()=='') {alert('商品コード、またはグループコードを指定してください。');return false;} fnFormModeSubmit('search_form','stock_update','',''); return false;"><span>在庫同期</span></a>
<br>
<span style="color:red;">現在のネクストエンジンの在庫と同期します。<br>
検索項目は「商品コード」、「グループコード」のみ有効です。
</span>
<!--{%if $arrStockResult%}-->
<br>同期結果<br>
<!--{%section name=cnt loop=$arrStockResult%}-->
商品コード：<!--{%$arrStockResult[cnt]%}-->　同期しました。<br>
<!--{%/section%}-->
<!--{%/if%}-->
</p>
</div>
<!--{%/if%}-->
*%}-->

        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'search', '', ''); return false;"><span class="btn-next">この条件で検索する</span></a></li>
            </ul>
        </div>

    </div>
    <!--検索条件設定テーブルここまで-->
</form>  


<!--{%if count($arrErr) == 0 and ($smarty.post.mode == 'search' or $smarty.post.mode == 'delete')%}-->

<!--★★検索結果一覧★★-->
<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="search" />
    <input type="hidden" name="product_id" value="" />
    <input type="hidden" name="category_id" value="" />
	<input type="hidden" name="shop_mode" id="shop_mode" value="" />
    <!--{%foreach key=key item=item from=$arrHidden%}-->
        <!--{%if is_array($item)%}-->
            <!--{%foreach item=c_item from=$item%}-->
            <input type="hidden" name="<!--{%$key%}-->[]" value="<!--{%$c_item%}-->" />
            <!--{%/foreach%}-->
        <!--{%else%}-->
            <input type="hidden" name="<!--{%$key%}-->" value="<!--{%$item%}-->" />
        <!--{%/if%}-->
    <!--{%/foreach%}-->
    <h2>検索結果一覧</h2>
    <div class="btn">
        <span class="attention"><!--検索結果数--><!--{%$tpl_linemax%}-->件</span>&nbsp;が該当しました。
        <!--検索結果-->
        <!--{%if $smarty.const.ADMIN_MODE == '1'%}-->
            <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('delete_all','',''); return false;">検索結果をすべて削除</a>
        <!--{%/if%}-->
        <a class="btn-tool" href="javascript:;" onclick="fnModeSubmit('csv','',''); return false;">CSV ダウンロード</a>
        <a class="btn-tool" href="../contents/csv.php?tpl_subno_csv=product">CSV 出力項目設定</a>
        <!--{%assign var=key value="search_group_view"%}-->
		<!--{%if $arrForm[$key].value == '' || $arrForm[$key].value == '1'%}-->
        <a class="btn-tool" href="javascript:;" onclick="fnModeSubmit('outlet','',''); return false;"><!--{%if $outlet%}-->ショップへ戻す<!--{%else%}-->アウトレットへ移行<!--{%/if%}--></a>
        <!--{%/if%}-->

<!--{%if $shop_mode == 'newsugawara'%}-->
<div>
<p>ネクストエンジン用取扱商品一覧出力
<a class="btn-normal" href="javascript:;" name="csv" onclick="fnTargetSelf(); fnFormModeSubmit('form_csv','csv_output','csv_output_id',1); return false;"><span>CSV出力</span></a>
<br>
<span style="color:red;">検索実行後にCSV出力することで検索条件が有効となります。<br>
※スマレジ商品ID、在庫は検索条件の対象外です。<br>
</span>
</p>
</div>
<!--{%/if%}-->

    </div>
    <!--{%if count($arrProducts) > 0%}-->

        <!--{%include file=$tpl_pager%}-->

        <!--検索結果表示テーブル-->
        <table class="list" id="products-search-result">
            <colgroup width="5%">
            <colgroup width="4%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="8%">
            <colgroup width="8%">
            <colgroup width="7%">
            <colgroup width="25%">
            <colgroup width="4%">
            <colgroup width="4%">
            <colgroup width="4%">
            <colgroup width="4%">
<!--{%*            <colgroup width="4%">*%}-->
            <colgroup width="4%">
<!--{%*            <colgroup width="4%">*%}-->
            <tr>
            <!--{%assign var=key value="search_group_view"%}-->
			<!--{%if $arrForm[$key].value == '' || $arrForm[$key].value == '1'%}-->
                <th rowspan="3"><!--{%if $outlet%}-->ショップへ戻す<!--{%else%}-->アウトレットへ移行<!--{%/if%}--></th>
            <!--{%/if%}-->
                <th rowspan="3">商品ID</th>
                <th rowspan="3">主商品</th>
                <th rowspan="3">スマレジ商品ID</th>
                <th rowspan="3">商品画像</th>
                <th rowspan="1">商品コード</th>
                <th rowspan="3">価格(円)</th>
                <th>商品名</th>
                <th rowspan="3">在庫</th>
                <th rowspan="3">種別</th>
                <th rowspan="3">編集</th>
                <th rowspan="3">確認</th>
<!--{%*
                <!--{%if $smarty.const.OPTION_CLASS_REGIST == 1%}-->
                <th rowspan="3">規格</th>
                <!--{%/if%}-->

                <!--{%if $smarty.const.USE_EXTRA_CLASS == 1%}-->
                <th rowspan="3">追加規格</th>
                <!--{%/if%}-->
                <th rowspan="3">複製</th>
*%}-->
                <!--{%*## 追加規格 ADD END ##*%}-->
                <th rowspan="3">削除</th>
            </tr>
            <tr>
                <th rowspan="2">グループコード</th>
<!--{%*                <th nowrap><a href="#" onClick="lfnDispChange(); return false;">カテゴリ ⇔ URL</a></th> *%}-->
                <th nowrap>カテゴリ</th>
            </tr>
            <tr>
                <th nowrap>商品詳細</th>
            </tr>

            <!--{%section name=cnt loop=$arrProducts%}-->
                <!--▼商品<!--{%$smarty.section.cnt.iteration%}-->-->
                <!--{%assign var=status value="`$arrProducts[cnt].status`"%}-->
                <tr style="background:<!--{%$arrPRODUCTSTATUS_COLOR[$status]%}-->;">
		            <!--{%assign var=key value="search_group_view"%}-->
					<!--{%if $arrForm[$key].value == '' || $arrForm[$key].value == '1'%}-->
                    <td class="id" rowspan="3"><label><input type="checkbox" value="<!--{%$arrProducts[cnt].product_id%}-->" name="outlet[]" /></label></td>
                    <!--{%/if%}-->
                    <td class="id" rowspan="3"><!--{%if $arrProducts[cnt].product_ids%}--><!--{%$arrProducts[cnt].product_ids%}--><!--{%else%}--><!--{%$arrProducts[cnt].product_id%}--><!--{%/if%}--></td>
                    <td class="id" rowspan="3"><!--{%if $arrProducts[cnt].group_view == '1'%}-->主<!--{%/if%}--></td>
                    <td class="id" rowspan="3"><!--{%$arrProducts[cnt].smaregi_product_id%}--></td>
                    <td class="thumbnail" rowspan="3">
                    <img src="<!--{%$smarty.const.ROOT_URLPATH%}-->resize_image.php?image=<!--{%$arrProducts[cnt].main_list_image|sfNoImageMainList%}-->&amp;width=65&amp;height=65">            </td>
                    <td rowspan="1"><!--{%$arrProducts[cnt].product_code_min%}-->
                        <!--{%if $arrProducts[cnt].product_code_min != $arrProducts[cnt].product_code_max%}-->
                            <br />～ <!--{%$arrProducts[cnt].product_code_max%}-->
                        <!--{%/if%}-->            </td>
                    <!--{%* 価格 *%}-->
                    <td rowspan="3" class="right">
                    <!--{%if $arrProducts[cnt].price02_min%}-->
                        <!--{%$arrProducts[cnt].price02_min|number_format%}-->
                        <!--{%if $arrProducts[cnt].price02_min != $arrProducts[cnt].price02_max%}-->
                            <br />～ <!--{%$arrProducts[cnt].price02_max|number_format%}-->
                        <!--{%/if%}-->
                    <!--{%else%}-->
                        <!--{%$arrProducts[cnt].price01_min|number_format%}-->
                        <!--{%if $arrProducts[cnt].price01_min != $arrProducts[cnt].price01_max%}-->
                            <br />～ <!--{%$arrProducts[cnt].price01_max|number_format%}-->
                        <!--{%/if%}-->
                    <!--{%/if%}-->
                    </td>
                    <td><!--{%$arrProducts[cnt].name%}--><!--{%if $arrProducts[cnt].name2%}--> / <!--{%$arrProducts[cnt].name2%}--><!--{%/if%}--></td>
                    <!--{%* 在庫 *%}-->
                    <!--{%* XXX 複数規格でかつ、全ての在庫数量が等しい場合は先頭に「各」と入れたれたら良いと思う。 *%}-->
                    <td class="menu" rowspan="3">
                        <!--{%if $arrProducts[cnt].stock_unlimited_min%}-->無制限<!--{%else%}--><!--{%$arrProducts[cnt].stock_min|number_format%}--><!--{%/if%}-->
                        <!--{%if $arrProducts[cnt].stock_unlimited_min != $arrProducts[cnt].stock_unlimited_max || $arrProducts[cnt].stock_min != $arrProducts[cnt].stock_max%}-->
                            <br />～ <!--{%if $arrProducts[cnt].stock_unlimited_max%}-->無制限<!--{%else%}--><!--{%$arrProducts[cnt].stock_max|number_format%}--><!--{%/if%}-->
                        <!--{%/if%}-->            </td>
                    <!--{%* 表示 *%}-->
                    <!--{%assign var=key value=$arrProducts[cnt].status%}-->
                    <td class="menu" rowspan="3"><!--{%$arrDISP[$key]%}--></td>
                    <td class="menu" rowspan="3"><span class="icon_edit"><a href="<!--{%$smarty.const.ROOT_URLPATH%}-->" onclick="$('#shop_mode').val('<!--{%$arrProducts[cnt].shop_name%}-->');fnChangeAction('./product.php'); fnModeSubmit('pre_edit', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;" >編集</a></span></td>
                    <td class="menu" rowspan="3"><span class="icon_confirm"><a href="<!--{%$smarty.const.HTTP_URL|sfTrimURL%}-->/products/detail.php?product_id=<!--{%$arrProducts[cnt].product_id%}-->&amp;admin=on&amp;shop_mode=<!--{%$shop_mode%}-->" target="_blank">確認</a></span></td>
<!--{%*

                    <!--{%if $smarty.const.OPTION_CLASS_REGIST == 1%}-->
                    <td class="menu" rowspan="3"><span class="icon_class"><a href="<!--{%$smarty.const.ROOT_URLPATH%}-->" onclick="fnChangeAction('./product_class.php'); fnModeSubmit('pre_edit', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;" >規格</a></span></td>
                    <!--{%/if%}-->

                    <!--{%if $smarty.const.USE_EXTRA_CLASS == 1%}-->
                    <td class="menu" rowspan="3"><span class="icon_class"><a href="<!--{%$smarty.const.ROOT_URLPATH%}-->" onclick="fnChangeAction('./product_extra_class.php'); fnModeSubmit('pre_edit', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;" >追加規格</a></span></td>
                    <!--{%/if%}-->
*%}-->
                    <td class="menu" rowspan="3"><span class="icon_delete"><a href="<!--{%$smarty.const.ROOT_URLPATH%}-->" onclick="fnSetFormValue('category_id', '<!--{%$arrProducts[cnt].category_id%}-->'); fnModeSubmit('delete', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;">削除</a></span></td>
<!--{%*
                    <td class="menu" rowspan="2"><span class="icon_copy"><a href="<!--{%$smarty.const.ROOT_URLPATH%}-->" onclick="fnChangeAction('./product.php'); fnModeSubmit('copy', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;" >複製</a></span></td>
*%}-->
                </tr>
                <tr style="background:<!--{%$arrPRODUCTSTATUS_COLOR[$status]%}-->;">
                    <td rowspan="2"><!--{%$arrProducts[cnt].group_code%}--></td>
                    <td><div style="overflow:scroll;height:100px;">
                        <!--{%* カテゴリ名 *%}-->
                        <div id="disp_cat<!--{%$smarty.section.cnt.iteration%}-->" style="display:<!--{%$cat_flg%}-->">
                            <!--{%foreach from=$arrProducts[cnt].categories item=category_id name=categories%}-->
                                <!--{%$arrCatList[$category_id]|sfTrim%}-->
                                <!--{%if !$smarty.foreach.categories.last%}--><br /><!--{%/if%}-->
                            <!--{%/foreach%}-->
                        </div>

                        <!--{%* URL *%}-->
                        <div id="disp_url<!--{%$smarty.section.cnt.iteration%}-->" style="display:none">
                            <!--{%$smarty.const.HTTP_URL|sfTrimURL%}-->/products/detail.php?product_id=<!--{%$arrProducts[cnt].product_id%}-->
                        </div></div>
                    </td>
                </tr>
                <tr style="background:<!--{%$arrPRODUCTSTATUS_COLOR[$status]%}-->;">
                    <td>
                    	<div style="overflow:scroll;height:100px;">
                            <!--{%$arrProducts[cnt].main_comment%}-->
                        </div>
                    </td>
                </tr>
                <!--▲商品<!--{%$smarty.section.cnt.iteration%}-->-->
            <!--{%/section%}-->
        </table>
        <input type="hidden" name="item_cnt" value="<!--{%$arrProducts|@count%}-->" />
        <!--検索結果表示テーブル-->
    <!--{%/if%}-->

</form>

<!--★★検索結果一覧★★-->        
<!--{%/if%}-->
</div>

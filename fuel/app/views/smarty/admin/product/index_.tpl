<style>
.pager
{
    margin:10px auto;
}
.pager a
{
   padding:5px;
}
.pager a.active
{
    font-weight:bold;
    background-color:black;
    color:white!important;
    padding:5px;
}
</style>
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

<div id="products" class="contents-main">
<form name="search_form" id="search_form" method="post" action="?">
    <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="search" />
    <h2>検索条件設定</h2>

    <!--検索条件設定テーブルここから-->
    <table>
        <tr>
            <th>商品ID</th>
            <td colspan="3">
                <!--{%assign var=key value="search_product_id"%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" style="" size="30" class="box30"/>
            </td>
<!--{%*
            <th>スマレジ商品ID</th>
            <td>
                <!--{%assign var=key value="search_smaregi_product_id"%}-->
                <input type="text" name="<!--{%$key%}-->" value="" maxlength="" style="" size="30" class="box30"/>
            </td>
*%}-->
        </tr>
        <tr>
            <th>商品コード</th>
            <td>
                <!--{%assign var=key value="search_product_code"%}-->
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
            <th>商品名</th>
            <td>
                <!--{%assign var=key value="search_name"%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
        </tr>
        <tr>
            <th>グループコード</th>
            <td>
                <!--{%assign var=key value="search_group_code"%}-->
                <input type="text" id="<!--{%$key%}-->" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
        </tr>
        <tr>
            <th>部門</th>
            <td colspan="3">
                <!--{%assign var=key value="search_category_id"%}-->
                <select name="<!--{%$key%}-->">
                <option value="">選択してください</option>
                <!--{%html_options options=$arrCatList selected=$arrForm[$key].value%}-->
                </select>
            </td>
<!--{%*
            <th>種別</th>
            <td>
                <!--{%assign var=key value="search_status"%}-->
                <span class="attention"></span>
                <!--{%html_checkboxes name="$key" options=$arrDISP selected=$arrForm[$key].value%}-->
            </td>
*%}-->
        </tr>
        <tr>
            <th>在庫</th>
            <td>
                <!--{%assign var=key value="search_stock"%}-->
                <label><input type="radio" value="0" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 0 || $arrForm[$key].value == ''%}-->checked<!--{%/if%}--> />すべて</label>
                <label><input type="radio" value="1" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 1%}-->checked<!--{%/if%}--> />在庫あり</label>
                <label><input type="radio" value="2" name="<!--{%$key%}-->" <!--{%if $arrForm[$key].value == 2%}-->checked<!--{%/if%}--> />在庫なし</label>
            </td>
        </tr>
        <tr>
            <th>登録・更新日</th>
            <td colspan="3">
                <select name="search_startyear">
                <option value="">----</option>
                <!--{%html_options options=$arrStartYear selected=$arrForm.search_startyear.value%}-->
                </select>年
                <select name="search_startmonth">
                <option value="">--</option>
                <!--{%html_options options=$arrStartMonth selected=$arrForm.search_startmonth.value%}-->
                </select>月
                <select name="search_startday">
                <option value="">--</option>
                <!--{%html_options options=$arrStartDay selected=$arrForm.search_startday.value%}-->
                </select>日～
                <select name="search_endyear">
                <option value="">----</option>
                <!--{%html_options options=$arrEndYear selected=$arrForm.search_endyear.value%}-->
                </select>年
                <select name="search_endmonth">
                <option value="">--</option>
                <!--{%html_options options=$arrEndMonth selected=$arrForm.search_endmonth.value%}-->
                </select>月
                <select name="search_endday">
                <option value="">--</option>
                <!--{%html_options options=$arrEndDay selected=$arrForm.search_endday.value%}-->
                </select>日
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td colspan="3">
            <!--{%assign var=key value="search_product_statuses"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <!--{%html_checkboxes name="$key" options=$arrSTATUS selected=$arrForm[$key].value%}-->
            </td>
        </tr>
    </table>
    <div class="btn">

        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'search', '', ''); return false;"><span class="btn-next">この条件で検索する</span></a></li>
            </ul>
        </div>

    </div>
    <!--検索条件設定テーブルここまで-->
</form>


<!--★★検索結果一覧★★-->
<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="search" />
    <input type="hidden" name="product_id" value="" />
    <input type="hidden" name="category_id" value="" />
	<input type="hidden" name="shop_mode" id="shop_mode" value="" />
    <!--{%*foreach key=key item=item from=$arrHidden*%}-->
        <!--{%*if is_array($item)*%}-->
            <!--{%*foreach item=c_item from=$item*%}-->
            <input type="hidden" name="<!--{%$key%}-->[]" value="<!--{%*$c_item*%}-->" />
            <!--{%*/foreach*%}-->
        <!--{%*else*%}-->
            <input type="hidden" name="<!--{%$key%}-->" value="<!--{%*$item*%}-->" />
        <!--{%*/if*%}-->
    <!--{%*/foreach*%}-->
    <h2>検索結果一覧</h2>
    <div class="btn">
        <span class="attention"><!--検索結果数--><!--{%$count%}-->件</span>&nbsp;が該当しました。
        <!--検索結果-->
        <a class="btn-tool" href="javascript:;" onclick="fnModeSubmit('csv','',''); return false;">CSV ダウンロード</a>
        <a class="btn-tool" href="../contents/csv.php?tpl_subno_csv=product">CSV 出力項目設定</a>
    </div>
    <div class="pager">
        <a href="/admin/product?page=1">先頭</a>
        <!--{%section loop=$max name=pages%}-->
        <a <!--{%if $page == $smarty.section.pages.iteration%}-->class="active"<!--{%/if%}--> href="/admin/product?page=<!--{%$smarty.section.pages.iteration%}-->"><!--{%$smarty.section.pages.iteration%}--></a>
        <!--{%/section%}-->
        <a href="/admin/product?page=<!--{%$max%}-->">最後</a>
    </div>
    <!--{%if count($arrProducts) > 0%}-->

        <!--{%*include file=$tpl_pager*%}-->

        <!--検索結果表示テーブル-->
        <table class="list" id="products-search-result">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <colgroup width="5%">
            <tr>
                <th rowspan="1">商品ID</th>
                <th rowspan="1">スマレジ商品ID</th>
                <th nowrap>公開日/公開終了日</th>
                <th nowrap>カテゴリ</th>
                <th nowrap>ブランド</th>
                <th rowspan="1">商品画像</th>
                <th rowspan="1">商品コード</th>
                <th rowspan="1">価格(円)</th>
                <th>商品名</th>
                <th nowrap>商品詳細</th>
                <th rowspan="1">在庫</th>
                <th rowspan="1">編集</th>
                <th rowspan="1">確認</th>
                <th rowspan="1">削除</th>
            </tr>

            <!--{%section name=cnt loop=$arrProducts%}-->
                <!--▼商品<!--{%*$smarty.section.cnt.iteration*%}-->-->
                <!--{%assign var=status value="`$arrProducts[cnt].status`"%}-->
                <tr style="background:<!--{%$arrPRODUCTSTATUS_COLOR[$status]%}-->;">
                    <td class="id" rowspan="1"><!--{%$arrProducts[cnt].product_id%}--></td>
                    <td class="id" rowspan="1"><!--{%if array_key_exists('smaregi_product_id', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].smaregi_product_id%}--><!--{%/if%}--></td>
                    <td class="id" rowspan="1">
                    <!--{%if array_key_exists('view_date', $arrProducts[cnt]) && $arrProducts[cnt].view_date != ''%}--><!--{%$arrProducts[cnt].view_date|date_format:"%Y.%m.%d"|default:""%}-->〜<!--{%/if%}-->
                    <!--{%if array_key_exists('close_date', $arrProducts[cnt]) && $arrProducts[cnt].close_date != ''%}--><!--{%$arrProducts[cnt].close_date|date_format:"%Y.%m.%d"|default:""%}--><!--{%/if%}-->
                    </td>
                    <td class="id" rowspan="1"><!--{%$arrProducts[cnt].category_name%}--></td>
                    <td class="id" rowspan="1"><!--{%if array_key_exists('brand_name', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].brand_name%}--><!--{%/if%}--></td>
                    <td class="thumbnail" rowspan="1">
                    <img src="/upload/images/<!--{%$arrProducts[cnt].login_id%}-->/<!--{%$arrProducts[cnt].path%}-->" width="65" height="65"></td>
                    <td rowspan="1"><!--{%if array_key_exists('product_code', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].product_code%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('price01', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].price01|number_format%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('name', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].name%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('info', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].info|mb_truncate%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('min_stock', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].min_stock%}--><!--{%if $arrProducts[cnt].min_stock != $arrProducts[cnt].max_stock%}-->〜<!--{%$arrProducts[cnt].max_stock%}--><!--{%/if%}--><!--{%/if%}--></td>
                    <!--{%* 表示 *%}-->
                    <td class="menu" rowspan="1"><span class="icon_edit"><a href="<!--{%*$smarty.const.ROOT_URLPATH*%}-->" onclick="fnChangeAction('/admin/productedit'); fnModeSubmit('pre_edit', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;" >編集</a></span></td>
                    <td class="menu" rowspan="1"><span class="icon_confirm"><a href="<!--{%*$smarty.const.HTTP_URL|sfTrimURL*%}-->/products/detail.php?product_id=<!--{%*$arrProducts[cnt].product_id*%}-->&amp;admin=on&amp;shop_mode=<!--{%*$shop_mode*%}-->" target="_blank">確認</a></span></td>
                    <td class="menu" rowspan="1"><span class="icon_delete"><a href="<!--{%*$smarty.const.ROOT_URLPATH*%}-->" onclick="fnChangeAction('/admin/product/delete'); fnModeSubmit('delete', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;">削除</a></span></td>
                </tr>
                <!--▲商品<!--{%*$smarty.section.cnt.iteration*%}-->-->
            <!--{%/section%}-->
        </table>
        <input type="hidden" name="item_cnt" value="<!--{%*$arrProducts|@count*%}-->" />
        <!--検索結果表示テーブル-->
    <!--{%/if%}-->

</form>

<!--★★検索結果一覧★★-->
</div>

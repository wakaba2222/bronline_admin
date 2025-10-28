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
<!--        <a class="btn-tool" href="javascript:;" onclick="fnChangeAction('/admin/product/download'); fnModeSubmit('download', '', ''); return false;">CSV ダウンロード</a> -->
        <!--{*<a class="btn-tool" href="../contents/csv.php?tpl_subno_csv=product">CSV 出力項目設定</a>*}-->
    </div>
    <div class="pager">
        <a href="/admin/product/copy?page=1">先頭</a>
		<!--{%section name=cnt loop=$max%}-->
		<!--{%if $pstart <= $smarty.section.cnt.iteration && $pend >= $smarty.section.cnt.iteration%}-->
		<a <!--{%if $page == $smarty.section.cnt.iteration%}-->class="active"<!--{%/if%}--> href="/admin/product/copy?page=<!--{%$smarty.section.cnt.iteration%}-->"><!--{%$smarty.section.cnt.iteration%}--></a>
		<!--{%/if%}-->
		<!--{%/section%}-->
        <a href="/admin/product/copy?page=<!--{%$max%}-->">最後</a>
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
            <tr>
                <th rowspan="1">商品ID</th>
                <th rowspan="1">ショップ</th>
                <th nowrap>公開日/公開終了日</th>
                <th nowrap>カテゴリ</th>
                <th nowrap>ブランド</th>
                <th rowspan="1">商品画像</th>
                <th rowspan="1">商品コード</th>
                <th rowspan="1">価格(円)</th>
                <th>商品名</th>
                <th nowrap>商品詳細</th>
                <th rowspan="1">在庫</th>
                <th rowspan="1">確認</th>
                <th rowspan="1">削除</th>
            </tr>

            <!--{%section name=cnt loop=$arrProducts%}-->
                <!--▼商品<!--{%*$smarty.section.cnt.iteration*%}-->-->
                <!--{%assign var=status value="`$arrProducts[cnt].status`"%}-->
                <tr style="background:<!--{%$arrPRODUCTSTATUS_COLOR[$status]%}-->;">
                    <td class="id" rowspan="1"><!--{%$arrProducts[cnt].product_id%}--></td>
                    <td class="id" rowspan="1"><!--{%$arrProducts[cnt].org_shop%}--></td>
                    <td class="id" rowspan="1">
                    <!--{%if array_key_exists('view_date', $arrProducts[cnt]) && $arrProducts[cnt].view_date != ''%}--><!--{%$arrProducts[cnt].view_date|date_format:"%Y.%m.%d"|default:""%}-->〜<!--{%/if%}-->
                    <!--{%if array_key_exists('close_date', $arrProducts[cnt]) && $arrProducts[cnt].close_date != ''%}--><!--{%$arrProducts[cnt].close_date|date_format:"%Y.%m.%d"|default:""%}--><!--{%/if%}-->
                    </td>
                    <td class="id" rowspan="1"><!--{%$arrProducts[cnt].category_name%}--></td>
                    <td class="id" rowspan="1"><!--{%if array_key_exists('brand_name', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].brand_name%}--><!--{%/if%}--></td>
                    <td class="thumbnail" rowspan="1">
                    <img src="/upload/images/<!--{%$arrProducts[cnt].org_shop%}-->/<!--{%$arrProducts[cnt].path%}-->" width="65" height="65"></td>
                    <td rowspan="1"><!--{%if array_key_exists('product_code', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].product_code%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('price01', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].price01|number_format%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('name', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].name%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('info', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].info|mb_truncate%}--><!--{%/if%}--></td>
                    <td rowspan="1"><!--{%if array_key_exists('min_stock', $arrProducts[cnt])%}--><!--{%$arrProducts[cnt].min_stock%}--><!--{%if $arrProducts[cnt].min_stock != $arrProducts[cnt].max_stock%}-->〜<!--{%$arrProducts[cnt].max_stock%}--><!--{%/if%}--><!--{%/if%}--></td>
                    <!--{%* 表示 *%}-->
                    <td class="menu" rowspan="1"><span class="icon_confirm"><a href="<!--{%*$smarty.const.HTTP_URL|sfTrimURL*%}-->/mall/<!--{%$smarty.session.shop%}-->/item?detail=<!--{%$arrProducts[cnt].product_id%}-->" target="_blank">確認</a></span></td>
                    <td class="menu" rowspan="1"><span class="icon_delete"><a href="<!--{%*$smarty.const.ROOT_URLPATH*%}-->" onclick="fnChangeAction('/admin/product/copydelete'); fnModeSubmit('delete', 'product_id', <!--{%$arrProducts[cnt].product_id%}-->); return false;">削除</a></span></td>
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

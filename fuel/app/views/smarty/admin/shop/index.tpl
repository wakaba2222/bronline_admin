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

<!--★★検索結果一覧★★-->
<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="search" />
    <input type="hidden" name="product_id" value="" />
    <input type="hidden" name="category_id" value="" />
	<input type="hidden" name="shop_mode" id="shop_mode" value="" />
    <h2>検索結果一覧</h2>
    <!--{%if count($arrShop) > 0%}-->

        <!--検索結果表示テーブル-->
        <table class="list" id="products-search-result">
            <tr>
                <th rowspan="1">ショップID</th>
                <th rowspan="1">POPUPショップ</th>
                <th rowspan="1">ショップ名</th>
                <th nowrap>ログインID/ショップURL</th>
                <th nowrap>在庫管理タイプ</th>
                <th nowrap>稼働状況</th>
                <th nowrap>編集</th>
            </tr>
            <!--{%foreach from=$arrShop item=shop%}-->
            <tr>
            <td><!--{%$shop.id%}--></td>
            <td><!--{%if $shop.popup_flg == '1'%}-->POPUP STORE<!--{%/if%}--></td>
            <td><!--{%$shop.shop_name%}--></td>
            <td><!--{%if $shop.shop_url%}--><!--{%$shop.shop_url%}--><!--{%else%}--><!--{%$shop.login_id%}--><!--{%/if%}--></td>
            <td><!--{%$arrStockTypes[$shop.dtb_stock_type_id]%}--></td>
            <td><!--{%$arrStatus[$shop.shop_status]%}--></td>
            <td><a href="/admin/shop/edit?id=<!--{%$shop.id%}-->">編集</a></td>
            </tr>
            <!--{%/foreach%}-->
        </table>
        <!--検索結果表示テーブル-->
    <!--{%/if%}-->

</form>

<!--★★検索結果一覧★★-->        
</div>

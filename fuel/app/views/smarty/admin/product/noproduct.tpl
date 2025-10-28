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
            <th>ショップ選択</th>
            <td>
                <!--{%assign var=key value="search_shop"%}-->
                <select name="<!--{%$key%}-->">
				<!--{%foreach from=$arrShop key=k item=v%}-->
	            <option value="<!--{%$k%}-->" <!--{%if $arrPost['search_shop']|default:"0" == $k%}-->selected<!--{%/if%}-->><!--{%$v%}--></option>
	            <!--{%/foreach%}-->
                <option value=""></option>
                </select>
            </td>
        </tr>
        <tr>
            <th>最低金額</th>
            <td>
                <!--{%assign var=key value="search_price"%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrPost[$key]%}-->" style="" size="30" class="box30"/>円
            </td>
        </tr>
        <tr>
            <th>商品コード(グループコードの前方一致)</th>
            <td>
            	<!--{%assign var=key value="search_product_code"%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrPost[$key]%}-->" style="" size="30" class="box30"/>
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td>
            <!--{%assign var=key value="search_product_statuses"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <!--{%html_checkboxes name="$key" options=$arrSTATUS selected=$arrPost[$key]|default:""%}-->
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
    <input type="hidden" name="mode" value="download" />
    <input type="hidden" name="search_shop" value="<!--{%$arrPost['search_shop']%}-->" />
    <input type="hidden" name="search_price" value="<!--{%$arrPost['search_price']%}-->" />
    <input type="hidden" name="search_product_code" value="<!--{%$arrPost['search_product_code']%}-->" />
    <input type="hidden" name="search_product_statuses" value="<!--{%implode(',',$arrPost['search_product_statuses'])%}-->" />
    <input type="hidden" name="noproducts" value="<!--{%$noproducts%}-->" />
    <h2>検索結果一覧</h2>
    <div class="btn">
        <span class="attention"><!--検索結果数--><!--{%$arrProducts|@count%}-->件</span>&nbsp;が該当しました。
        <!--検索結果-->
        <a class="btn-tool" href="javascript:;" onclick="fnModeSubmit('download', '', ''); return false;">CSV ダウンロード</a>
    </div>
    <div>
    <textarea rows="20" cols="200"><!--{%$noproducts%}--></textarea>
    </div>

</form>

<!--★★検索結果一覧★★-->
</div>

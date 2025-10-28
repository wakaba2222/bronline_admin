<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="check" />
<input type="hidden" name="extra_class_id" value="<!--{$tpl_extra_class_id|h}-->" />
<div id="products" class="contents-main">

    <table>
        <tr>
            <th>店舗名<span class="attention"> *</span></th>
            <td>
                    <!--{foreach key=cnt item=shop_name from=$arrShop}-->
                    <!--{if $smarty.session.login_id == $cnt}-->
                    <!--{$shop_name}-->
		            <input type="hidden" name="shop_name" value="<!--{$cnt}-->" />
                    <!--{/if}-->
                    <!--{/foreach}-->
<!--{*                    <!--{html_options options=$arrShop selected=$smarty.session.login_id}-->*}-->
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'check', '', ''); return false;"><span class="btn-next">チェック (全件)</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'check2', '', ''); return false;"><span class="btn-next">チェック (差分)</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'sql', '', ''); return false;"><span class="btn-next">SQL (差分)</span></a></li>
        </ul>
    </div>
</div>
</form>
    <!--{if $arrProductList}-->
    <h2>チェック結果</h2>
    <!--{* ▼一覧表示エリアここから *}-->
    <table class="list">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">product_id</th>
            <th rowspan="2">product_code</th>
            <th rowspan="2">group_code</th>
			<th rowspan="2">diff_color</th>
			<th rowspan="2">diff_size</th>
            <th>dtb_products.color_name</th>
            <th>dtb_products.size_name</th>
        </tr>
        <tr>
            <th>dtb_products_extra_class.color</th>
            <th>dtb_products_extra_class.size</th>
        </tr>
        <!--{section name=data loop=$arrProductList}-->
        <tr>
            <td rowspan="2"><!--{$arrProductList[data].cnt|h}--></td>
            <td rowspan="2"><!--{$arrProductList[data].product_id|h}--></td>
            <td rowspan="2"><!--{$arrProductList[data].product_code|h}--></td>
            <td rowspan="2"><!--{$arrProductList[data].group_code|h}--></td>
			<td rowspan="2" class="center"><!--{$arrProductList[data].diff_color|h}--></td>
			<td rowspan="2" class="center"><!--{$arrProductList[data].diff_size|h}--></td>
            <td><!--{$arrProductList[data].color_name|h}--></td>
            <td><!--{$arrProductList[data].size_name|h}--></td>
        </tr>
        <tr>
            <td><!--{$arrProductList[data].color_name2|h}--></td>
            <td><!--{$arrProductList[data].size_name2|h}--></td>
        </tr>
        <!--{sectionelse}-->
        <tr class="center">
            <td colspan="6">該当するデータはありません</td>
        </tr>
        <!--{/section}-->
    </table>
    <!--{/if}-->

    <!--{if $arrSqlList}-->
    <h2>作成結果</h2>
    <!--{* ▼一覧表示エリアここから *}-->
    <table class="list">
        <tr>
            <th>SQL</th>
            <th>更新</th>
        </tr>
        <!--{section name=data loop=$arrSqlList}-->
        <tr>
            <td><!--{$arrSqlList[data].sql|h}--></td>
            <td>
			<form name="form1" id="form1" method="post" action="?">
			<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
			<input type="hidden" name="mode" value="exec" />
			<input type="hidden" name="sql" value="<!--{$arrSqlList[data].sql|h}-->" />
            <input type="submit" value="更新" />
            </form>
            </td>
        </tr>
        <!--{sectionelse}-->
        <tr class="center">
            <td colspan="6">該当するデータはありません</td>
        </tr>
        <!--{/section}-->
    </table>
    <!--{/if}-->
    <!--{* ▲一覧表示エリアここまで *}-->

<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="edit" />
<input type="hidden" name="id" id="id" value="<!--{%$arrForm.id%}-->" />
<div id="products" class="contents-main">

    <table>
        <tr>
            <th>コード<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.p_code}-->
                    <span class="attention"><!--{$arrErr.p_code}--></span>
                <!--{/if}-->
                <input type="text" name="code" value="<!--{%$arrForm.code|h%}-->" maxlength="<!--{%$smarty.const.STEXT_LEN%}-->" style="" size="30" class="box30" />
                <span class="attention"> (上限<!--{%$smarty.const.STEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>ブランド名<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.name}-->
                    <span class="attention"><!--{$arrErr.name}--></span>
                <!--{/if}-->
                <input type="text" name="name" value="<!--{%$arrForm.name|h%}-->" maxlength="<!--{%$smarty.const.STEXT_LEN%}-->" style="" size="30" class="box30" />
                <span class="attention"> (上限<!--{%$smarty.const.STEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>ブランド名（カタカナ）<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.name_kana}-->
                    <span class="attention"><!--{$arrErr.name_kana}--></span>
                <!--{/if}-->
                <input type="text" name="name_kana" value="<!--{%$arrForm.name_kana|h%}-->" maxlength="<!--{%$smarty.const.STEXT_LEN%}-->" style="" size="30" class="box30" />
                <span class="attention"> (上限<!--{%$smarty.const.STEXT_LEN%}-->文字)</span>
            </td>
        </tr>
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'confirm', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

    <table class="list">
        <colgroup width="15%">
        <colgroup width="15%">
        <colgroup width="40%">
        <colgroup width="15%">
        <colgroup width="15%">
        <tr>
            <th>ID</th>
            <th>コード</th>
            <th>ブランド名</th>
            <th>ブランド名(カナ)</th>
            <th class="edit">編集</th>
            <th class="delete">削除</th>
<!--            <th>移動</th> -->
        </tr>
        <!--{%foreach from=$arrBrand item=item%}-->
            <tr>
                <td align="center" >
                <!--{%$item.id%}-->
                </td>
                <td align="center" >
                <!--{%$item.code%}-->
                </td>
                <td align="center" >
                <!--{%$item.name%}-->
                </td>
                <td align="center" >
                <!--{%$item.name_kana%}-->
                </td>
                <td align="center" >
                    <!--{%if $id != $item.id%}-->
                        <a href="?" onclick="fnModeSubmit('pre_edit','id', <!--{%$item.id%}-->); return false;">編集</a>
                    <!--{%else%}-->
                        編集中
                    <!--{%/if%}-->
                </td>
                <td align="center">
                    <a href="?" onclick="fnModeSubmit('delete','id', <!--{%$item.id%}-->); return false;">削除</a>
                </td>
<!--{%*
                <td align="center">
                    <!--{if $smarty.section.cnt.iteration != 1}-->
                        <a href="?" onclick="fnModeSubmit('up','extra_classcategory_id', <!--{$arrExtraClassCat[cnt].extra_classcategory_id}-->); return false;">上へ</a>
                    <!--{/if}-->
                    <!--{if $smarty.section.cnt.iteration != $smarty.section.cnt.last}-->
                        <a href="?" onclick="fnModeSubmit('down','extra_classcategory_id', <!--{$arrExtraClassCat[cnt].extra_classcategory_id}-->); return false;">下へ</a>
                    <!--{/if}-->
                </td>
*%}-->
            </tr>
        <!--{%/foreach%}-->
    </table>
    <div class="btn">
        <a class="btn-action" href="/admin/product/"><span class="btn-prev">商品一覧に戻る</span></a>
    </div>
</div>
</form>    

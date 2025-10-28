
<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit" />
<input type="hidden" name="extra_class_id" value="<!--{$tpl_extra_class_id|h}-->" />
<div id="products" class="contents-main">

<!--{* #CUSTOM# guji ADD BEGIN *}--><!--{if $shop_mode == ''}--><!--{* #CUSTOM# guji ADD END *}-->
<!-- 追加ショップの場合は、追加規格の新規登録　不可 -->
    <table>
        <tr>
            <th>追加規格名<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.name}-->
                    <span class="attention"><!--{$arrErr.name}--></span>
                <!--{/if}-->
                <input type="text" name="name" value="<!--{$arrForm.name|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="" size="30" class="box30" />
            </td>
        </tr>
<!--{*
        <tr>
            <th>追加規格入力タイプフラグ</th>
            <td>
                <label><input type="checkbox" name="url" value="1" <!--{if $arrForm.url}-->checked<!--{/if}--> />追加規格入力タイプフラグ</label>
            </td>
        </tr>
*}-->
<!--{*
        <tr>
            <th>URL</th>
            <td>
                <!--{if $arrErr.url}-->
                    <span class="attention"><!--{$arrErr.url}--></span>
                <!--{/if}-->
                <input type="text" name="url" value="<!--{$arrForm.url|h}-->" maxlength="<!--{$smarty.const.STEXT_LEN}-->" style="" size="30" class="box30" />
                <span class="attention"> (上限<!--{$smarty.const.STEXT_LEN}-->文字)</span>
            </td>
        </tr>
*}-->
    </table>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'edit', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
<!-- #CUSTOM# guji ADD BEGIN --><!--{/if}--><!-- #CUSTOM# guji ADD END -->

    <table class="list">
        <colgroup width="45%">
        <colgroup width="15%">
<!-- #CUSTOM# guji ADD BEGIN --><!--{if $shop_mode == ''}--><!-- #CUSTOM# guji ADD END -->
        <colgroup width="10%">
        <colgroup width="10%">
        <colgroup width="15%">
<!-- #CUSTOM# guji ADD BEGIN --><!--{/if}--><!-- #CUSTOM# guji ADD END -->
<!-- 追加ショップの場合は、編集、削除、移動　不可 -->
        <tr>
            <th>追加規格名 (登録数)</th>
            <th>分類登録</th>
<!-- #CUSTOM# guji ADD BEGIN --><!--{if $shop_mode == ''}--><!-- #CUSTOM# guji ADD END -->
            <th class="edit">編集</th>
            <th class="delete">削除</th>
            <th>移動</th>
<!-- #CUSTOM# guji ADD BEGIN --><!--{/if}--><!-- #CUSTOM# guji ADD END -->
        </tr>
        <!--{section name=cnt loop=$arrExtraClass}-->
<!-- #CUSTOM# guji ADD BEGIN -->
<!--{if $shop_mode == ''}-->
    <!-- 追加ショップではない場合は、全項目を表示 -->
    <!--{assign var=show value=true}-->
<!--{else}-->
    <!-- 追加ショップの場合は、サイズ、カラー、ブランド　のみ表示 -->
    <!--{if $arrExtraClass[cnt].extra_class_id == '1' || $arrExtraClass[cnt].extra_class_id == '5' || $arrExtraClass[cnt].extra_class_id == '6'}-->
        <!--{assign var=show value=true}-->
    <!--{else}-->
        <!--{assign var=show value=false}-->
    <!--{/if}-->
<!--{/if}-->
<!--{if $show}-->
<!-- #CUSTOM# guji ADD END -->
            <tr style="background:<!--{if $tpl_extra_class_id != $arrExtraClass[cnt].extra_class_id}-->#ffffff<!--{else}--><!--{$smarty.const.SELECT_RGB}--><!--{/if}-->;">
                <!--{assign var=extra_class_id value=$arrExtraClass[cnt].extra_class_id}-->
                <td><!--{* 規格名 *}--><!--{$arrExtraClass[cnt].name|h}--> (<!--{$arrExtraClassCatCount[$extra_class_id]|default:0}-->)</td>
                <td align="center">
                <!--{if $arrExtraClass[cnt].url == ''}-->
                <a href="./extra_classcategory.php?extra_class_id=<!--{$arrExtraClass[cnt].extra_class_id}-->" >分類登録</a>
                <!--{/if}-->
                </td>
<!-- #CUSTOM# guji ADD BEGIN --><!--{if $shop_mode == ''}--><!-- #CUSTOM# guji ADD END -->
                <td align="center">
                    <!--{if $tpl_extra_class_id != $arrExtraClass[cnt].extra_class_id}-->
                        <a href="?" onclick="fnModeSubmit('pre_edit', 'extra_class_id', <!--{$arrExtraClass[cnt].extra_class_id}-->); return false;">編集</a>
                    <!--{else}-->
                        編集中
                    <!--{/if}-->
                </td>
                <td align="center">
                    <!--{if $arrExtraClassCatCount[$extra_class_id] > 0}-->
                        -
                    <!--{else}-->
                        <a href="?" onclick="fnModeSubmit('delete', 'extra_class_id', <!--{$arrExtraClass[cnt].extra_class_id}-->); return false;">削除</a>
                    <!--{/if}-->
                </td>
                <td align="center">
                    <!--{if $smarty.section.cnt.iteration != 1}-->
                        <a href="?" onclick="fnModeSubmit('up', 'extra_class_id', <!--{$arrExtraClass[cnt].extra_class_id}-->); return false;">上へ</a>
                    <!--{/if}-->
                    <!--{if $smarty.section.cnt.iteration != $smarty.section.cnt.last}-->
                        <a href="?" onclick="fnModeSubmit('down', 'extra_class_id', <!--{$arrExtraClass[cnt].extra_class_id}-->); return false;">下へ</a>
                    <!--{/if}-->
                </td>
<!-- #CUSTOM# guji ADD BEGIN --><!--{/if}--><!-- #CUSTOM# guji ADD END -->
            </tr>
<!-- #CUSTOM# guji ADD BEGIN --><!--{/if}--><!-- #CUSTOM# guji ADD END -->
        <!--{/section}-->
    </table>

</div>
</form>

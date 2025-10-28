<script>
function set_action()
{
    $('#form1').attr('action', '/admin/productedit');
}
</script>
<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<!--{%*
<!--{%foreach key=key item=item from=$arrHidden%}-->
    <!--{%if is_array($item)%}-->
        <!--{%foreach item=c_item from=$item%}-->
        <input type="hidden" name="<!--{%$key%}-->[]" value="<!--{%$c_item%}-->" />
        <!--{%/foreach%}-->
    <!--{%else%}-->
        <input type="hidden" name="<!--{%$key%}-->" value="<!--{%$item%}-->" />
    <!--{%/if%}-->
<!--{%/foreach%}-->
*%}-->

<input type="hidden" name="mode" id="mode" value="confirm" />
<div id="products" class="contents-main">
    <h2>基本情報</h2>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

    <table class="form">
        <tr>
            <th>商品ID</th>
            <td><!--{%$arrProduct.product_id%}--></td>
        </tr>
        <tr>
            <th>スマレジ商品ID</th>
            <td><!--{%$arrProduct.smaregi_product_id%}--></td>
        </tr>
        <tr>
            <th>セール対象区分</th>
            <td>
            	<!--{%if $arrProduct.sale_status == 0%}-->通常商品
            	<!--{%elseif $arrProduct.sale_status == 1%}-->シークレットセール対象
            	<!--{%elseif $arrProduct.sale_status == 2%}-->VIPシークレットセール対象
            	<!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>お直し商品</th>
            <td><!--{%if $arrProduct.pay_off%}-->お直し商品<!--{%else%}-->通常商品<!--{%/if%}--></td>
        </tr>
        <tr>
            <th>予約商品</th>
            <td><!--{%if $arrProduct.reservation_flg%}-->予約商品<!--{%else%}-->通常商品<!--{%/if%}--></td>
        </tr>
        <tr>
            <th>商品名<span class="attention"> *</span></th>
            <td>
            <!--{%$arrProduct.name%}-->
            </td>
        </tr>
        <tr>
            <th>商品名(英語)</th>
            <td>
            <!--{%$arrProduct.name_en%}-->
            </td>
        </tr>
        <tr>
            <th>商品名(カナ)</th>
            <td>
            <!--{%$arrProduct.name_kana%}-->
            </td>
        </tr>
        <tr>
            <th>ブランド選択<span class="attention"> *</span><br><span class="attention">ブランドはコードマスター管理から予め登録しておく必要があります。</span></th>
            <td>
                <!--{%section name=bc loop=$arrBrand%}-->
                <!--{%if $arrProduct.brand_id == $arrBrand[bc].id%}--><!--{%$arrBrand[bc].name%}--><!--{%/if%}-->
                <!--{%/section%}-->
            </td>
        </tr>
        <tr>
            <th>商品SKU情報</th>
            <td>
                <!--{%foreach from=$arrProductCode.product_code key=key item=val%}-->
                商品コード：<!--{%$val%}--><br>
                カラーコード：<!--{%$arrProductCode.color_code[$key]%}--><br>
                カラー名：<!--{%$arrProductCode.color_name[$key]%}--><br>
                サイズコード：<!--{%$arrProductCode.size_code[$key]%}--><br>
                サイズ名：<!--{%$arrProductCode.size_name[$key]%}--><br>
                在庫：<!--{%$arrProductCode.stock[$key]%}-->
                <!--{%/foreach%}-->
            </td>
        </tr>

        <tr>
            <th>規格（スマレジ項目）</th>
            <td>
            <!--{%$arrProduct.attribute|nl2br%}-->
            </td>
        </tr>
        <tr>
            <th>商品部門<span class="attention"> *</span></th>
            <td>
                <!--{%foreach from=$arrCategory item=category key=key%}-->
                <!--{%if $key == $category_id%}--><!--{%$category%}--><!--{%/if%}-->
                <!--{%/foreach%}-->
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td>
            <!--{%$arrSTATUS[$arrProduct.status]%}-->
            </td>
        </tr>
        <tr>
            <th>NEWステータス</th>
            <td>
                <!--{%if $arrProduct.status_flg|default:"1"%}-->
                NEWフラグあり
                <!--{%else%}-->
                NEWフラグなし
                <!--{%/if%}-->
            </td>
        </tr>
        <tr>
            <th>グループコード</th>
            <td>
            <!--{%$arrProduct.group_code%}-->
            </td>
        </tr>
        <tr>
            <th>商品単価<span class="attention"> *</span></th>
            <td>
            <!--{%$arrProduct.price01%}-->
            </td>
        </tr>
        <tr>
            <th>原価</th>
            <td>
            <!--{%$arrProduct.cost_price%}-->
            </td>
        </tr>
        <tr>
            <th>ポイント付与率<span class="attention"> *</span></th>
            <td>
            <!--{%$arrProduct.point_rate%}-->
            </td>
        </tr>
        <!--{%*
        <tr>
            <th>発送日目安</th>
            <td>
                <span class="attention"><!--{$arrErr.deliv_date_id}--></span>
                <select name="deliv_date_id" style="<!--{$arrErr.deliv_date_id|sfGetErrorColor}-->">
                    <option value="">選択してください</option>
                    <!--{html_options options=$arrDELIVERYDATE selected=$arrForm.deliv_date_id}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>販売制限数</th>
            <td>
                <span class="attention"><!--{$arrErr.sale_limit}--></span>
                <input type="text" name="sale_limit" value="<!--{$arrForm.sale_limit}-->" size="6" class="box6" maxlength="<!--{$smarty.const.AMOUNT_LEN}-->" />
                <span class="attention"> (半角数字で入力)</span>
            </td>
        </tr>
        *%}-->
        <tr>
            <th>タグ</th>
            <td>
            <!--{%foreach from=$arrTag.tag item=tag%}-->
            <!--{%$tag%}-->,
            <!--{%/foreach%}-->
            </td>
        </tr>
        <!--{%*
        <tr>
            <th>備考欄(SHOP専用)</th>
            <td>
                <span class="attention"><!--{$arrErr.note}--></span>
                <textarea name="note" cols="60" rows="8" class="area60" maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" style="<!--{$arrErr.note|sfGetErrorColor}-->"><!--{"\n"}--><!--{$arrForm.note}--></textarea><br />
                <span class="attention"> (上限<!--{$smarty.const.LLTEXT_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>サイズ(スマレジ項目)</th>
            <td>
                <span class="attention"><!--{$arrErr.size}--></span>
                <input type="text" name="size" value="<!--{$arrForm.size}-->" maxlength="85" style="<!--{if $arrErr.size != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" size="60" class="box60" />
                <span class="attention"> (上限85文字)</span>
            </td>
        </tr>
        <tr>
            <th>カラー(スマレジ項目)</th>
            <td>
                <span class="attention"><!--{$arrErr.color}--></span>
                <input type="text" name="color" value="<!--{$arrForm.color}-->" maxlength="85" style="<!--{if $arrErr.color != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" size="60" class="box60" />
                <span class="attention"> (上限85文字)</span>
            </td>
        </tr>
        <tr>
            <th>タグ(スマレジ項目)</th>
            <td>
                <span class="attention"><!--{$arrErr.tag}--></span>
                <input type="text" name="tag" value="<!--{$arrForm.tag}-->" maxlength="85" style="<!--{if $arrErr.tag != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" size="60" class="box60" />
                <span class="attention"> (上限85文字)</span>
            </td>
        </tr>
        *%}-->
        <tr>
            <th style="background-image:none;background-color:#FFAE00;">SEASON</th>
            <td>
            <!--{%$arrProduct.season%}-->
            </td>
        </tr>
        <tr>
            <th style="background-image:none;background-color:#FFAE00;">MATERIAL</th>
            <td>
            <!--{%$arrProduct.material%}-->
            </td>
        </tr>
        <tr>
            <th style="background-image:none;background-color:#FFAE00;">SIZE(CUBE)<span class="attention">(タグ許可)</span></th>
            <td>
            <!--{%$arrProduct.size_text|nl2br%}-->
            </td>
        </tr>
        <tr>
            <th>原産国</th>
            <td>
            <!--{%$arrProduct.country|nl2br%}-->
            </td>
        </tr>
        <tr>
            <th>REMARKS</th>
            <td>
            <!--{%$arrProduct.remarks|nl2br%}-->
            </td>
        </tr>
<!--{%*
        <tr>
            <th>動画URL</th>
            <td>
                <span class="attention"><!--{$arrErr.youtube_tag}--></span>
                <input type="text" name="youtube_tag" value="<!--{$arrForm.youtube_tag}-->" maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" style="<!--{if $arrErr.youtube_tag != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" size="60" class="box60" />
                <span class="attention"> (上限<!--{$smarty.const.LLTEXT_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>一覧-メインコメント(キャッチコピー)</th>
            <td>
                <span class="attention"><!--{$arrErr.main_list_comment}--></span>
                <textarea name="main_list_comment" maxlength="<!--{$smarty.const.MTEXT_LEN}-->" style="<!--{if $arrErr.main_list_comment != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->" cols="60" rows="8" class="area60"><!--{"\n"}--><!--{$arrForm.main_list_comment}--></textarea><br />
                <span class="attention"> (上限<!--{$smarty.const.MTEXT_LEN}-->文字)</span>
            </td>
        </tr>
*%}-->
        <tr>
            <th>詳細(説明)<span class="attention">(タグ許可)</span></th>
            <td>
            <!--{%$arrProduct.info|nl2br%}-->
            </td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
            <div>
            <!--{%if $arrImages|default:""%}-->
            <!--{%if array_key_exists('images', $arrImages)%}-->
            <!--{%foreach from=$arrImages.images key=key item=item%}-->
            <img src="<!--{%$item%}-->" width="200"/>
            <!--{%$arrImages.tags[$key]%}-->
            </div>
            <!--{%/foreach%}-->
            <!--{%/if%}-->
            <!--{%/if%}-->
            </td>
        </tr>
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2013 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
*}-->

<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="complete" />
<!--{foreach key=key item=item from=$arrSearchHidden}-->
    <!--{if is_array($item)}-->
        <!--{foreach item=c_item from=$item}-->
            <input type="hidden" name="<!--{$key|h}-->[]" value="<!--{$c_item|h}-->" />
        <!--{/foreach}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key|h}-->" value="<!--{$item|h}-->" />
    <!--{/if}-->
<!--{/foreach}-->
<!--{foreach key=key item=item from=$arrForm}-->
    <!--{if $key == 'product_status'}-->
        <!--{foreach item=statusVal from=$item}-->
            <input type="hidden" name="<!--{$key}-->[]" value="<!--{$statusVal|h}-->" />
        <!--{/foreach}-->
    <!--{elseif $key == 'arrCategoryId'}-->
        <!--{* nop *}-->
    <!--{elseif $key == 'arrFile'}-->
        <!--{* nop *}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key}-->" value="<!--{$item|h}-->" />
    <!--{/if}-->
<!--{/foreach}-->
<div id="products" class="contents-main">

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

    <table>
        <tr>
            <th>グランドコンテンツに掲載する</th>
            <td>
                <!--{if $arrForm.v_mall}-->掲載する<!--{else}-->掲載しない<!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>商品名</th>
            <td>
                <!--{$arrForm.name|h}--> / <!--{$arrForm.name2|h}-->
            </td>
        </tr>
        <tr>
            <th>商品名(カナ)</th>
            <td>
                <!--{$arrForm.name_kana|h}-->
            </td>
        </tr>
        <tr>
            <th>作成日時</th>
            <td>
                <!--{$arrForm.create_date|date_format:"%Y-%m-%d %H:%M:%S"}-->
            </td>
        </tr>
        <tr>
            <th>更新日時</th>
            <td>
                <!--{$arrForm.update_date|date_format:"%Y-%m-%d %H:%M:%S"}-->
            </td>
        </tr>
        <tr>
            <th>商品部門</th>
            <td>
                <!--{section name=cnt loop=$arrForm.arrCategoryId}-->
                    <!--{assign var=key value=$arrForm.arrCategoryId[cnt]}-->
                    <!--{$arrCatList[$key]|sfTrim}--><br />
                <!--{/section}-->
            </td>
        </tr>
        <tr>
            <th>公開・非公開</th>
            <td>
                <!--{$arrDISP[$arrForm.status]}-->
            </td>
        </tr>
<!--{*
        <tr>
            <th>商品ステータス</th>
            <td>
                <!--{foreach from=$arrForm.product_status item=status}-->
                    <!--{if $status != ""}-->
                        <img src="<!--{$TPL_URLPATH_PC}--><!--{$arrSTATUS_IMAGE[$status]}-->">
                    <!--{/if}-->
                <!--{/foreach}-->
            </td>
        </tr>
*}-->

        <!--{if $arrForm.has_product_class != true}-->
            <tr>
                <th>商品種別</th>
                <td>
                    <!--{$arrProductType[$arrForm.product_type_id]}-->
                </td>
            </tr>
            <tr>
                <th>ダウンロード商品ファイル名</th>
                <td>
                    <!--{$arrForm.down_filename|h}-->
                </td>
            </tr>
            <tr>
                <th>ダウンロード商品用<BR />ファイル</th>
                <td>
                    <!--{if $arrForm.down_realfilename != ""}-->
                        <!--{$arrForm.down_realfilename|h}-->
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>商品コード</th>
                <td>
                    <!--{$arrForm.product_code|h}-->
                </td>
            </tr>
            <tr>
                <th>グループコード</th>
                <td>
                    <!--{$arrForm.group_code|h}-->
                    <!--{if $arrForm.group_view == '1'}-->主商品とする<!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>商品URL</th>
                <td>
                    <!--{$arrForm.product_url|h}-->
                </td>
            </tr>
            <tr>
                <th>商品単価</th>
                <td>
                    <!--{if strlen($arrForm.price01) >= 1}--><!--{$arrForm.price01|h}--> 円<!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>アウトレット価格</th>
                <td>
                    <!--{if strlen($arrForm.price02) >= 1}--><!--{$arrForm.price02|h}--> 円<!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>原価</th>
                <td>
                    <!--{$arrForm.cost_price|h}--> 円
                </td>
            </tr>
            <tr>
                <th>在庫数</th>
                <td>
                    <!--{if $arrForm.stock_unlimited == 1}-->
                        無制限
                    <!--{else}-->
                        <!--{$arrForm.stock|h}-->
                    <!--{/if}-->
                </td>
            </tr>
        <!--{/if}-->

        <tr>
            <th>商品送料</th>
            <td>
                <!--{if strlen($arrForm.deliv_fee) >= 1}--><!--{$arrForm.deliv_fee|h}--> 円<!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>ポイント付与率</th>
            <td>
                <!--{if strlen($arrForm.point_rate) >= 1}--><!--{$arrForm.point_rate|h}--> ％<!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>発送日目安</th>
            <td>
                <!--{$arrDELIVERYDATE[$arrForm.deliv_date_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>販売制限数</th>
            <td>
                <!--{$arrForm.sale_limit|default:'無制限'|h}-->
            </td>
        </tr>
<!--{*
        <tr>
            <th>メーカー</th>
            <td>
                <!--{$arrMaker[$arrForm.maker_id]|h}-->
            </td>
        </tr>
        <tr>
            <th>メーカーURL</th>
            <td style="word-break: break-all;">
                <!--{$arrForm.comment1|h}-->
            </td>
        </tr>
*}-->
        <tr>
            <th>検索ワード</th>
            <td>
                <!--{$arrForm.comment3|h}-->
            </td>
        </tr>
        <tr>
            <th>備考欄(SHOP専用)</th>
            <td>
                <!--{$arrForm.note|h|nl2br}-->
            </td>
        </tr>
        <tr>
            <th>サイズ(スマレジ項目)</th>
            <td>
                <!--{$arrForm.size|h}-->
            </td>
        </tr>
        <tr>
            <th>カラー(スマレジ項目)</th>
            <td>
                <!--{$arrForm.color|h}-->
            </td>
        </tr>
        <tr>
            <th>タグ(スマレジ項目)</th>
            <td>
                <!--{$arrForm.tag|h}-->
            </td>
        </tr>
        <tr>
            <th>SEASON</th>
            <td>
                <!--{$arrForm.season|h}-->
            </td>
        </tr>
        <tr>
            <th>MATERIAL</th>
            <td>
                <!--{$arrForm.material|h}-->
            </td>
        </tr>
        <tr>
            <th>SIZE</th>
            <td>
                <!--{$arrForm.size_text|nl2br_html}-->
            </td>
        </tr>
        <tr>
            <th>REMARKS</th>
            <td>
                <!--{$arrForm.remarks|nl2br_html}-->
            </td>
        </tr>
        <tr>
            <th>原産国</th>
            <td>
                <!--{$arrForm.country|h}-->
            </td>
        </tr>

        <tr>
            <th>一覧-メインコメント</th>
            <td>
                <!--{$arrForm.main_list_comment|h|nl2br}-->
            </td>
        </tr>
        <tr>
            <th>詳細-メインコメント</th>
            <td>
                <!--{$arrForm.main_comment|nl2br_html}-->
            </td>
        </tr>
        <tr>
            <th>一覧-メイン画像</th>
            <td>
                <!--{assign var=key value="main_list_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>一覧-メイン画像(マウスオーバー)</th>
            <td>
                <!--{assign var=key value="main_list_image2"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
<!--{*
        <tr>
            <th>詳細-メイン画像</th>
            <td>
                <!--{assign var=key value="main_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
        <tr>
            <th>詳細-メイン拡大画像</th>
            <td>
                <!--{assign var=key value="main_large_image"}-->
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                    <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                <!--{/if}-->
            </td>
        </tr>
*}-->
        <!--{* オペビルダー用 *}-->
        <!--{if "sfViewAdminOpe"|function_exists === TRUE}-->
            <!--{include file=`$smarty.const.MODULE_REALDIR`mdl_opebuilder/admin_ope_view.tpl}-->
        <!--{/if}-->

        <!--{section name=cnt loop=$smarty.const.PRODUCTSUB_MAX}-->
            <!--▼商品<!--{$smarty.section.cnt.iteration}-->-->
            <tr>
                <th>詳細-サブタイトル（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_title`$smarty.section.cnt.iteration`"}-->
                    <!--{$arrForm[$key]|h}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブコメント（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_comment`$smarty.section.cnt.iteration`"}-->
                    <!--{$arrForm[$key]|nl2br_html}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブ画像（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_image`$smarty.section.cnt.iteration`"}-->
                    <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                        <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                    <!--{/if}-->
                </td>
            </tr>
            <tr>
                <th>詳細-サブ拡大画像（<!--{$smarty.section.cnt.iteration}-->）</th>
                <td>
                    <!--{assign var=key value="sub_large_image`$smarty.section.cnt.iteration`"}-->
                    <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                        <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.name|h}-->" /><br />
                    <!--{/if}-->
                </td>
            </tr>
            <!--▲商品<!--{$smarty.section.cnt.iteration}-->-->
        <!--{/section}-->

        <!--{if $smarty.const.OPTION_RECOMMEND == 1}-->
            <!--▼関連商品-->
            <!--{section name=cnt loop=$smarty.const.WEARIT_PRODUCT_MAX}-->
            <!--{assign var=wearit_no value="`$smarty.section.cnt.iteration`"}-->
                <tr>
                    <th>WEAR WITH IT(<!--{$smarty.section.cnt.iteration}-->)<br />
                        <!--{if $arrWearit[$wearit_no].product_id|strlen >= 1}-->
                            <img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$arrWearit[$wearit_no].main_list_image|sfNoImageMainList|h}-->&amp;width=65&amp;height=65" alt="<!--{$arrWearit[$wearit_no].name|h}-->">
                        <!--{/if}-->
                    </th>
                    <td>
                        <!--{if $arrWearit[$wearit_no].product_id|strlen >= 1}-->
                            商品コード:<!--{$arrWearit[$wearit_no].product_code_min}--><br />
                            商品名:<!--{$arrWearit[$wearit_no].name|h}--><br />
                            コメント:<br />
                            <!--{$arrWearit[$wearit_no].comment|h|nl2br}-->
                        <!--{/if}-->
                    </td>
                </tr>
            <!--{/section}-->
            <!--▲関連商品-->
            <!--{section name=cnt loop=$smarty.const.RECOMMEND_PRODUCT_MAX}-->
            <!--{assign var=recommend_no value="`$smarty.section.cnt.iteration`"}-->
                <tr>
                    <th>RELATED ITEMS(<!--{$smarty.section.cnt.iteration}-->)<br />
                        <!--{if $arrRecommend[$recommend_no].product_id|strlen >= 1}-->
                            <img src="<!--{$smarty.const.ROOT_URLPATH}-->resize_image.php?image=<!--{$arrRecommend[$recommend_no].main_list_image|sfNoImageMainList|h}-->&amp;width=65&amp;height=65" alt="<!--{$arrRecommend[$recommend_no].name|h}-->">
                        <!--{/if}-->
                    </th>
                    <td>
                        <!--{if $arrRecommend[$recommend_no].product_id|strlen >= 1}-->
                            商品コード:<!--{$arrRecommend[$recommend_no].product_code_min}--><br />
                            商品名:<!--{$arrRecommend[$recommend_no].name|h}--><br />
                            コメント:<br />
                            <!--{$arrRecommend[$recommend_no].comment|h|nl2br}-->
                        <!--{/if}-->
                    </td>
                </tr>
            <!--{/section}-->
            <!--▲関連商品-->
        <!--{/if}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

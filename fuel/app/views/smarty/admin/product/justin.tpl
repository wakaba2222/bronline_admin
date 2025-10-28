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

<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="edit" />
    <input type="hidden" name="maker_id" value="<!--{$tpl_maker_id}-->" />
    <div id="products" class="contents-main">
        <p class="attention">1~の数値を表示順番に入れてください。同じ数字を入れた場合には上に表示されている方が優先です。<br>
        100以上を入れるとOTHER対象となります。（100以上はOTHERでの表示順番を制御します。）</p>

        <table class="form">
            <tr>
                <th width="5%">表示番号</th>
                <th width="95%">ショップ名</th>
            </tr>
<!--{section name=cnt loop=$arrJustin}-->
            <tr>
                <td width="5%">
                <input type="hidden" name="member_id[]" value="<!--{$arrJustin[cnt].member_id|h}-->">
                <input type="text" name="no[]" value="<!--{$arrJustin[cnt].no|default:"100"|h}-->">
                </td>
                <td width="95%"><!--{$arrJustin[cnt].name|h}--></td>
            </tr>
<!--{/section}-->
        </table>
        <p class="attention">1~の数値を表示順番に入れてください。同じ数字を入れた場合には上に表示されている方が優先です。<br>
        100以上を入れるとOTHER対象となります。（100以上はOTHERでの表示順番を制御します。）</p>

        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'edit', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
            </ul>
        </div>
    </div>
</form>

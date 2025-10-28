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
<script>
$(document).ready(function(){
<!--{*
	<!--{if $codes}-->
	<!--{section name=cnt loop=$codes}-->
	$('.all_size_check<!--{$codes[cnt]}-->').change(function(){
		if ($(this).attr('checked'))
			$('.p_size_check<!--{$codes[cnt]}-->').attr('checked','checked');
		else
			$('.p_size_check<!--{$codes[cnt]}-->').removeAttr('checked');
		
	});
	<!--{/section}-->
	<!--{else}-->
	<!--{section name=cnt loop=$targets}-->
	$('.all_size_check<!--{$targets[cnt]}-->').change(function(){
		if ($(this).attr('checked'))
			$('.p_size_check<!--{$targets[cnt]}-->').attr('checked','checked');
		else
			$('.p_size_check<!--{$targets[cnt]}-->').removeAttr('checked');
		
	});
	<!--{/section}-->
	<!--{/if}-->
*}-->

<!--{if $arrErr}-->
<!--{foreach key=err item=msg from=$arrErr}-->
$('#<!--{$err}-->').css('color','#FF0000');
$('#<!--{$err}--> input').attr('checked','checked');
<!--{/foreach}-->
<!--{/if}-->
});


</script>

<form name="form1" id="form1" method="POST" action="?" enctype="multipart/form-data">
<input type="hidden" id="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" id="mode" name="mode" value="<!--{$mode}-->" />
<div id="products" class="contents-main">
<!--{if $targets}-->
    <!--▼登録テーブルここから-->
<!--{if $arrErr}-->
<p style="color:#FF0000;">重複した選択肢があります。</p>
<!--{/if}-->


    <table>
		<!--{if $codes}-->
		<!--{section name=cnt loop=$codes}-->
        <tr>
            <th><!--{$targets[cnt]}--><!--{*<br><br><label><input type="checkbox" class="all_size_check<!--{$codes[cnt]}-->">すべてチェックする</label>*}--></th>
            <td>
			<!--{section name=cc loop=$arrProducts}-->
			<!--{if $arrProducts[cc].extra_class_id == $no}-->
				<label id="p_size_<!--{$codes[cnt]}--><!--{$arrProducts[cc].p_code}-->"><input class="p_size_check<!--{$codes[cnt]}-->" type="checkbox" value="<!--{$arrProducts[cc].p_code}-->" name="p_size_<!--{$codes[cnt]}-->[]" <!--{if $arrProducts[cc].name_code == $codes[cnt]}-->checked<!--{/if}--> /><!--{$arrProducts[cc].name}-->(<!--{$arrProducts[cc].p_code}-->)</label>
			<!--{elseif $no == 0}-->
				<label id="p_size_<!--{$codes[cnt]}--><!--{$arrProducts[cc].p_code}-->"><input class="p_size_check<!--{$codes[cnt]}-->" type="checkbox" value="<!--{$arrProducts[cc].p_code}-->" name="p_size_<!--{$codes[cnt]}-->[]" <!--{if $arrProducts[cc].name_code == $codes[cnt]}-->checked<!--{/if}--> /><!--{$arrProducts[cc].name}-->(<!--{$arrProducts[cc].p_code}-->)</label>
			<!--{/if}-->
			<!--{/section}-->
            </td>
        </tr>
        <!--{/section}-->
		<!--{else}-->
		<!--{section name=cnt loop=$targets}-->
        <tr>
            <th><!--{$targets[cnt]}--><!--{*<br><br><label><input type="checkbox" class="all_size_check<!--{$targets[cnt]}-->">すべてチェックする</label>*}--></th>
            <td>
			<!--{section name=cc loop=$arrProducts}-->
			<!--{if $arrProducts[cc].extra_class_id == $no}-->
				<label id="p_size_<!--{$targets[cnt]}--><!--{$arrProducts[cc].p_code}-->"><input class="p_size_check<!--{$targets[cnt]}-->" type="checkbox" value="<!--{$arrProducts[cc].p_code}-->" name="p_size_<!--{$targets[cnt]}-->[]" <!--{if $arrProducts[cc].name_code == $targets[cnt]}-->checked<!--{/if}--> /><!--{$arrProducts[cc].name}-->(<!--{$arrProducts[cc].p_code}-->)</label>
			<!--{elseif $no == 0}-->
				<label id="p_size_<!--{$targets[cnt]}--><!--{$arrProducts[cc].p_code}-->"><input class="p_size_check<!--{$targets[cnt]}-->" type="checkbox" value="<!--{$arrProducts[cc].p_code}-->" name="p_size_<!--{$targets[cnt]}-->[]" <!--{if $arrProducts[cc].name_code == $targets[cnt]}-->checked<!--{/if}--> /><!--{$arrProducts[cc].name}-->(<!--{$arrProducts[cc].p_code}-->)</label>
			<!--{/if}-->
			<!--{/section}-->
            </td>
        </tr>
        <!--{/section}-->
        <!--{/if}-->
    </table>
    <!--▲登録テーブルここまで-->
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', '<!--{$mode}-->', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
<!--{/if}-->
</div>
</form>

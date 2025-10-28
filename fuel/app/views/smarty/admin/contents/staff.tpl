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

<!--{*
/*
 * WYSIWYG Editor Script Start
 */
*}-->
<script type="text/javascript">
$(function(){
  var oFCKeditor = new FCKeditor( 'news_comment' ) ;
  oFCKeditor.Height="800";
  oFCKeditor.ReplaceTextarea() ;
});
</script>
<!--{*
/*
 * WYSIWYG Editor Script End
 */
*}-->

<script type="text/javascript">
<!--

function func_regist(url) {
    res = confirm('この内容で<!--{if $edit_mode eq "on"}-->編集<!--{else}-->登録<!--{/if}-->しても宜しいですか？');
    if(res == true) {
        document.form1.mode.value = 'regist';
        document.form1.submit();
        return false;
    }
    return false;
}

function func_edit(news_id) {
    document.form1.mode.value = "search";
    document.form1.news_id.value = news_id;
    document.form1.submit();
}

function func_del(news_id) {
    res = confirm('このSTAFF RECOMMEND情報を削除しても宜しいですか？');
    if(res == true) {
        document.form1.mode.value = "delete";
        document.form1.news_id.value = news_id;
        document.form1.submit();
    }
    return false;
}

function func_rankMove(term,news_id) {
    document.form1.mode.value = "move";
    document.form1.news_id.value = news_id;
    document.form1.term.value = term;
    document.form1.submit();
}

function moving(news_id,rank, max_rank) {

    var val;
    var ml;
    var len;

    ml = document.move;
    len = document.move.elements.length;
    j = 0;
    for( var i = 0 ; i < len ; i++) {
            if ( ml.elements[i].name == 'position' && ml.elements[i].value != "" ) {
            val = ml.elements[i].value;
            j ++;
            }
    }

    if ( j > 1) {
        alert( '移動順位は１つだけ入力してください。' );
        return false;
    } else if( ! val ) {
        alert( '移動順位を入力してください。' );
        return false;
    } else if( val.length > 4){
        alert( '移動順位は4桁以内で入力してください。' );
        return false;
    } else if( val.match(/[0-9]+/g) != val){
        alert( '移動順位は数字で入力してください。' );
        return false;
    } else if( val == rank ){
        alert( '移動させる番号が重複しています。' );
        return false;
    } else if( val == 0 ){
        alert( '移動順位は0以上で入力してください。' );
        return false;
    } else if( val > max_rank ){
        alert( '入力された順位は、登録数の最大値を超えています。' );
        return false;
    } else {
        ml.moveposition.value = val;
        ml.rank.value = rank;
        ml.news_id.value = news_id;
        ml.submit();
        return false;
    }
}

function selectAll(target) {
    $('#' + target).children().attr({selected: true});
}

//-->
</script>

<div id="admin-contents" class="contents-main">
<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="" />
<input type="hidden" name="news_id" value="<!--{$arrForm.news_id|h}-->" />
<input type="hidden" name="term" value="" />
<input type="hidden" name="image_key" value="" />
<input type="hidden" name="creator_id" value="<!--{$arrForm.creator_id|h}-->" />
<!--{foreach key=key item=item from=$arrForm.arrHidden}-->
<input type="hidden" name="<!--{$key}-->" value="<!--{$item|h}-->" />
<!--{/foreach}-->
    <!--{* ▼登録テーブルここから *}-->
    <table>
        <tr>
            <th>日付<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.year || $arrErr.month || $arrErr.day}--><span class="attention"><!--{$arrErr.year}--><!--{$arrErr.month}--><!--{$arrErr.day}--></span><!--{/if}-->
                <select name="year" <!--{if $arrErr.year || $arrErr.month || $arrErr.day }-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}-->>
                    <option value="" selected="selected">----</option>
                    <!--{html_options options=$arrYear selected=$arrForm.year}-->
                </select>年
                <select name="month" <!--{if $arrErr.year || $arrErr.month || $arrErr.day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}-->>
                    <option value="" selected="selected">--</option>
                    <!--{html_options options=$arrMonth selected=$arrForm.month}-->
                </select>月
                <select name="day" <!--{if $arrErr.year || $arrErr.month || $arrErr.day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}-->>
                    <option value="" selected="selected">--</option>
                    <!--{html_options options=$arrDay selected=$arrForm.day}-->
                </select>日
            </td>
        </tr>
<!--{if $arrLabel}-->
        <tr>
            <th>Label選択</th>
            <td>
                <select name="label_id" <!--{if $arrErr.label_id}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}-->>
                    <option value="" selected="selected">--</option>
                    <!--{html_options options=$arrLabel selected=$arrForm.label_id}-->
                </select>
            </td>
        </tr>
<!--{/if}-->
        <tr>
            <th>ステータス</th>
            <td>
            	<label><input type="checkbox" name="status" value="1" <!--{if $arrForm.status == 1}-->checked<!--{/if}--> />公開する</label>
            </td>
        </tr>
        <tr>
            <th>グランドコンテンツに記載する</th>
            <td>
            	<label><input type="checkbox" name="view_flg" value="1" <!--{if $arrForm.view_flg == 1 || $arrForm.view_flg == ''}-->checked<!--{/if}--> />グランドコンテンツに記載する</label>
            </td>
        </tr>
        <tr>
            <th>カテゴリ<span class="attention"> *</span></th>
            <td>
                <select name="news_category" <!--{if $arrErr.news_category}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}-->>
                    <option value="">--</option>
                    <!--{html_options options=$arrCategory selected=$arrForm.news_category}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>タイトル<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.news_title}--><span class="attention"><!--{$arrErr.news_title}--></span><!--{/if}-->
                <input type="text" name="news_title" size="60" class="box60"    value="<!--{$arrForm.news_title|h}-->" <!--{if $arrErr.news_title}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.URL_LEN}-->" />
                <span class="attention"> (上限<!--{$smarty.const.MTEXT_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>タイトル２（一覧表示用）<span class="attention"> *</span></th>
            <td>
                <!--{if $arrErr.list_title}--><span class="attention"><!--{$arrErr.list_title}--></span><!--{/if}-->
                <input type="text" name="list_title" size="60" class="box60"    value="<!--{$arrForm.list_title|h}-->" <!--{if $arrErr.list_title}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.MTEXT_LEN}-->" />
                <span class="attention"> (上限<!--{$smarty.const.MTEXT_LEN}-->文字)</span>
            </td>
        </tr>
<!--{*
        <tr>
            <th>URL</th>
            <td>
                <span class="attention"><!--{$arrErr.news_url}--></span>
                <input type="text" name="news_url" size="60" class="box60"    value="<!--{$arrForm.news_url|h}-->" <!--{if $arrErr.news_url}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.URL_LEN}-->" />
                <span class="attention"> (上限<!--{$smarty.const.URL_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>リンク</th>
            <td><label><input type="checkbox" name="link_method" value="2" <!--{if $arrForm.link_method eq 2}--> checked <!--{/if}--> /> 別ウィンドウで開く</label></td>
        </tr>
*}-->
        <tr>
            <!--{assign var=key value="news_image2"}-->
            <th>メイン用画像<br />[680×400]</th>
            <td>
                <a name="<!--{$key}-->"></a>
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.news_title|h}-->" />　<a href="" onclick="fnModeSubmit('delete_image', 'image_key', '<!--{$key}-->'); return false;">[画像の取り消し]</a><br />
                <!--{/if}-->
                <input type="file" name="news_image2" size="40" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" />
                <a class="btn-normal" href="javascript:;" name="btn" onclick="fnModeSubmit('upload_image', 'image_key', '<!--{$key}-->'); return false;">アップロード</a>
            </td>
        </tr>
        <tr>
            <!--{assign var=key value="news_image"}-->
<!--{*            <th>リスト用画像<br />[155×205]</th>*}-->
            <th>リスト用画像<br />[372×492]</th>
            <td>
                <a name="<!--{$key}-->"></a>
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <!--{if $arrForm.arrFile[$key].filepath != ""}-->
                <img src="<!--{$arrForm.arrFile[$key].filepath}-->" alt="<!--{$arrForm.news_title|h}-->" />　<a href="" onclick="fnModeSubmit('delete_image', 'image_key', '<!--{$key}-->'); return false;">[画像の取り消し]</a><br />
                <!--{/if}-->
                <input type="file" name="news_image" size="40" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" />
                <a class="btn-normal" href="javascript:;" name="btn" onclick="fnModeSubmit('upload_image', 'image_key', '<!--{$key}-->'); return false;">アップロード</a>
            </td>
        </tr>
<!--{*
        <tr>
            <th>関連記事（記事IDをカンマ区切り）</th>
            <td>
                <!--{if $arrErr.articles}--><span class="attention"><!--{$arrErr.articles}--></span><!--{/if}-->
                <input type="text" name="articles" size="60" class="box60"    value="<!--{$arrForm.articles|h}-->" <!--{if $arrErr.articles}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.URL_LEN}-->" />
            </td>
        </tr>
*}-->
        <tr>
            <th>ITEM（グループコードをカンマ区切り）</th>
            <td>
	            <!--{if $prefixs}-->
	            他ショップのアイテムを指定するにはグループコードの前にプレフィックスを指定してください。<br>
	            <!--{foreach from=$prefixs key=shop item=prefix}-->
	            <p>ショップ名[<!--{$shop}-->]:プレフィックス[<!--{$prefix}-->]</p>
	            <!--{/foreach}-->
	            <!--{/if}-->
                <!--{if $arrErr.item}--><span class="attention"><!--{$arrErr.item}--></span><!--{/if}-->
                <input type="text" name="item" size="60" class="box60"    value="<!--{$arrForm.item|h}-->" <!--{if $arrErr.item}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" />
            </td>
        </tr>
        <tr>
            <th>ANOTHER ITEM（グループコードをカンマ区切り）</th>
            <td>
	            <!--{if $prefixs}-->
	            他ショップのアイテムを指定するにはグループコードの前にプレフィックスを指定してください。<br>
	            <!--{foreach from=$prefixs key=shop item=prefix}-->
	            <p>ショップ名[<!--{$shop}-->]:プレフィックス[<!--{$prefix}-->]</p>
	            <!--{/foreach}-->
	            <!--{/if}-->
                <!--{if $arrErr.another}--><span class="attention"><!--{$arrErr.another}--></span><!--{/if}-->
                <input type="text" name="another" size="60" class="box60"    value="<!--{$arrForm.another|h}-->" <!--{if $arrErr.another}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" />
            </td>
        </tr>
        <tr>
            <th>ARCHIVE（カンマ区切り）</th>
            <td>
                <!--{if $arrErr.archive}--><span class="attention"><!--{$arrErr.archive}--></span><!--{/if}-->
                <input type="text" name="archive" size="60" class="box60"    value="<!--{$arrForm.archive|h}-->" <!--{if $arrErr.archive}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" />
            </td>
        </tr>
<!--{*
        <tr>
            <th>LINKS（カンマ区切り）</th>
            <td>
                <!--{if $arrErr.links}--><span class="attention"><!--{$arrErr.links}--></span><!--{/if}-->
                <input type="text" name="links" size="60" class="box60"    value="<!--{$arrForm.links|h}-->" <!--{if $arrErr.links}-->style="background-color:<!--{$smarty.const.ERR_COLOR|h}-->"<!--{/if}--> maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" />
            </td>
        </tr>
*}-->
        <tr>
            <th>本文作成</th>
            <td>
                <!--{if $arrErr.news_comment}--><span class="attention"><!--{$arrErr.news_comment}--></span><!--{/if}-->
                <textarea name="news_comment" cols="80" rows="20" wrap="soft" class="" maxlength="<!--{$smarty.const.LLTEXT_LEN}-->" style="background-color:<!--{if $arrErr.news_comment}--><!--{$smarty.const.ERR_COLOR|h}--><!--{/if}-->"><!--{"\n"}--><!--{$arrForm.news_comment|smarty:nodefaults}--></textarea><br />
                <span class="attention"> (上限9999文字)</span>
            </td>
        </tr>
    </table>
    <!--{* ▲登録テーブルここまで *}-->

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="return func_regist();"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</form>

    <h2>新着情報一覧</h2>
    <!--{if $arrErr.moveposition}-->
    <p><span class="attention"><!--{$arrErr.moveposition}--></span></p>
    <!--{/if}-->
    <!--{* ▼一覧表示エリアここから *}-->
    <p>タイトルをクリックすることでプレビュー画面が開きます。</p>
    <form name="move" id="move" method="post" action="?">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="moveRankSet" />
    <input type="hidden" name="term" value="setposition" />
    <input type="hidden" name="news_id" value="" />
    <input type="hidden" name="moveposition" value="" />
    <input type="hidden" name="rank" value="" />
    <table class="list">
        <col width="5%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="30%" />
        <col width="5%" />
        <col width="5%" />
        <col width="15%" />
        <tr>
            <th>記事ID</th>
            <th>日付</th>
            <th>ショップ</th>
            <th>ステータス</th>
            <th>カテゴリ</th>
            <th>タイトル</th>
            <th class="edit">編集</th>
            <th class="delete">削除</th>
            <th>移動</th>
        </tr>
        <!--{section name=data loop=$arrNews}-->
        <tr style="background:<!--{if $arrNews[data].news_id != $tpl_news_id}-->#ffffff<!--{else}--><!--{$smarty.const.SELECT_RGB}--><!--{/if}-->;" class="center">
            <!--{assign var=db_rank value="`$arrNews[data].rank`"}-->
            <td><!--{$arrNews[data].news_id}--><!--{* <!--{math equation="$line_max - $db_rank + 1"}--> *}--></td>
            <td><!--{$arrNews[data].cast_news_date|date_format:"%Y/%m/%d"}--></td>
            <td><!--{$arrNews[data].mall|h}--></td>
            <td><!--{if $arrNews[data].status == 1}-->公開<!--{else}-->下書き<!--{/if}--></td>
			<!--{assign var=cid value=`$arrNews[data].news_category`}-->
            <td><!--{$arrCategory[$cid]}--></td>
            <td class="left">
<!--{*
                <!--{if $arrNews[data].link_method eq 1 && $arrNews[data].news_url != ""}--><a href="<!--{$arrNews[data].news_url|h}-->" ><!--{$arrNews[data].news_title|h|nl2br}--></a>
                <!--{elseif $arrNews[data].link_method eq 1 && $arrNews[data].news_url == ""}--><!--{$arrNews[data].news_title|h|nl2br}-->
                <!--{elseif $arrNews[data].link_method eq 2 && $arrNews[data].news_url != ""}--><a href="<!--{$arrNews[data].news_url|h}-->" target="_blank" ><!--{$arrNews[data].news_title|h|nl2br}--></a>
                <!--{else}--><!--{$arrNews[data].news_title|h|nl2br}-->
                <!--{/if}-->
*}-->
				<!--{if $arrNews[data].creator_id != 'administrator'}-->
				<a href="<!--{$smarty.const.HTTP_URL}-->mall/<!--{$arrNews[data].url|h}-->/staff_entry/?entry=<!--{$arrNews[data].news_id}-->&admin=on" target="_blank"><!--{$arrNews[data].news_title|h|nl2br}--></a>
				<!--{else}-->
				<a href="<!--{$smarty.const.HTTP_URL}-->staff_entry/?entry=<!--{$arrNews[data].news_id}-->&admin=on" target="_blank"><!--{$arrNews[data].news_title|h|nl2br}--></a>
				<!--{/if}-->
            </td>
            <td>
                <!--{if $arrNews[data].news_id != $tpl_news_id}-->
                <a href="#" onclick="return func_edit('<!--{$arrNews[data].news_id|h}-->');">編集</a>
                <!--{else}-->
                編集中
                <!--{/if}-->
            </td>
            <td><a href="#" onclick="return func_del('<!--{$arrNews[data].news_id|h}-->');">削除</a></td>
            <td>
            <!--{if count($arrNews) != 1}-->
            <input type="text" name="pos-<!--{$arrNews[data].news_id|h}-->" size="3" class="box3" />番目へ<a href="?" onclick="fnFormModeSubmit('move', 'moveRankSet','news_id', '<!--{$arrNews[data].news_id|h}-->'); return false;">移動</a><br />
            <!--{/if}-->
            <!--{if $arrNews[data].rank ne $max_rank}--><a href="#" onclick="return func_rankMove('up', '<!--{$arrNews[data].news_id|h}-->', '<!--{$max_rank|h}-->');">上へ</a><!--{/if}-->　<!--{if $arrNews[data].rank ne 1}--><a href="#" onclick="return func_rankMove('down', '<!--{$arrNews[data].news_id|h}-->', '<!--{$max_rank|h}-->');">下へ</a><!--{/if}-->
            </td>
        </tr>
        <!--{sectionelse}-->
        <tr class="center">
            <td colspan="6">現在データはありません。</td>
        </tr>
        <!--{/section}-->
    </table>
    </form>
    <!--{* ▲一覧表示エリアここまで *}-->

</div>

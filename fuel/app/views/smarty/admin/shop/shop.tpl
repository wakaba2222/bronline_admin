<script src="/admin_common/js/Sortable.js"></script>
<script type="text/javascript">
// 表示非表示切り替え
function lfDispSwitch(id){
    var obj = document.getElementById(id);
    if (obj.style.display == 'none') {
        obj.style.display = '';
    } else {
        obj.style.display = 'none';
    }
}

// セレクトボックスのリストを移動
// (移動元セレクトボックスID, 移動先セレクトボックスID)
function fnMoveSelect(select, target) {
    $('#' + select).children().each(function() {
        if (this.selected) {
            $('#' + target).append(this);
            $(this).attr({selected: false});
        }
    });
    // IE7再描画不具合対策
    if ($.browser.msie && $.browser.version >= 7) {
        $('#' + select).hide();
        $('#' + select).show();
        $('#' + target).hide();
        $('#' + target).show();
    }
}

// target の子要素を選択状態にする
function selectAll(target) {
    $('#' + target).children().attr({selected: true});
}

// File APIに対応していない場合はエリアを隠す
if (!window.File) {
    document.getElementById('image_upload_section').style.display = "none";
}

// ブラウザ上でファイルを展開する挙動を抑止
function onDragOver(event) {
    event.preventDefault();
}

// Drop領域にドロップした際のファイルのプロパティ情報読み取り処理
function onDrop(event) {
    // ブラウザ上でファイルを展開する挙動を抑止
    event.preventDefault();

    // ドロップされたファイルのfilesプロパティを参照
    var files = event.dataTransfer.files;
    for (var i=0; i<files.length; i++) {
        // 一件ずつアップロード
        imageFileUpload(files[i]);
    }
}

// ファイルアップロード
function imageFileUpload(f) {
    var formData = new FormData();
    formData.append('image', f);
    formData.append('shop', '<!--{%$shop%}-->');
    var url = "/api/addimg";

    // POSTでアップロード
    $.ajax({
        url  : url,
        type : "POST",
        data : formData,
        cache       : false,
        contentType : false,
        processData : false,
        dataType    : "json"
    })
    .done(function(data){
        var img = new Image();
        img.src = data.img;
        img.width = 200;
        img.class = 'img_name';
        var str = '<li class="img_li"><img src="'+ data.img +'" width="200"><input type="hidden" name="arrImages[images][]" value="'+data.img+'" /><br>タグ：<input type="text" name="arrImages[tags][]" /><button class="del">削除</button></li>';
        
        $('#image_area').append(str);
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert("fail");
    });
}
</script>

<style>
ul#image_area
{
    display:flex;
}
ul#image_area li
{
}
</style>
<script>
$(function(){
    $(document).on("click", ".del", function(){
        $(this).parent().empty();
    });

    Sortable.create($('ul#image_area')[0]);
});
</script>

<form name="form1" id="form1" method="post" action="/admin/productedit/confirm?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<!--{%*
<!--{foreach key=key item=item from=$arrSearchHidden}-->
    <!--{if is_array($item)}-->
        <!--{foreach item=c_item from=$item}-->
        <input type="hidden" name="<!--{$key}-->[]" value="<!--{$c_item}-->" />
        <!--{/foreach}-->
    <!--{else}-->
        <input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->" />
    <!--{/if}-->
<!--{/foreach}-->
*%}-->
<input type="hidden" name="mode" value="edit" />
<input type="hidden" name="arrProduct[product_id]" value="<!--{%if array_key_exists('product_id', $arrProduct)%}--><!--{%$arrProduct.product_id%}--><!--{%/if%}-->" />
<input type="hidden" name="arrProduct[smaregi_product_id]" value="<!--{%if array_key_exists('smaregi_product_id', $arrProduct)%}--><!--{%$arrProduct.smaregi_product_id%}--><!--{%/if%}-->" />
<!--{%*
<!--{foreach key=key item=item from=$arrForm.arrHidden}-->
<input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->" />
<!--{/foreach}-->
*%}-->
<div id="products" class="contents-main">
    <h2>基本情報</h2>

    <div class="btn-area">
        <!--{if count($arrSearchHidden) > 0}-->
        <!--▼検索結果へ戻る-->
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="location.href='/admin/product';"><span class="btn-prev">検索画面に戻る</span></a></li>
        <!--▲検索結果へ戻る-->
        <!--{/if}-->
            <li><a class="btn-action" href="javascript:;" onclick="selectAll('category_id'); document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>

    <table class="form">
        <tr>
            <th>商品ID</th>
            <td><!--{%if array_key_exists('product_id', $arrProduct)%}--><!--{%$arrProduct.product_id%}--><!--{%/if%}--></td>
        </tr>
        <tr>
            <th>スマレジ商品ID</th>
            <td><!--{%if array_key_exists('smaregi_product_id', $arrProduct)%}--><!--{%$arrProduct.smaregi_product_id%}--><!--{%/if%}--></td>
        </tr>
        <tr>
            <th>商品名<span class="attention"> *</span></th>
            <td>
                <span class="attention"><!--{$arrErr.name}--></span>
                <input type="text" name="arrProduct[name]" value="<!--{%$arrProduct.name%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention"> (上限85文字)</span>
            </td>
        </tr>
        <tr>
            <th>商品名(英語)</th>
            <td>
                <span class="attention"><!--{$arrErr.name2}--></span>
                <input type="text" name="arrProduct[name_en]" value="<!--{%$arrProduct.name_en%}-->" maxlength="85" size="60" class="box60" />
                <!--<span class="attention"> (上限85文字)</span>-->
            </td>
        </tr>
        <tr>
            <th>商品名(カナ)</th>
            <td>
                <span class="attention"><!--{$arrErr.name_kana}--></span>
                <input type="text" name="arrProduct[name_kana]" value="<!--{%$arrProduct.name_kana%}-->" maxlength="85" size="60" class="box60" />
                <!--<span class="attention"> (上限85文字)</span>-->
            </td>
        </tr>
        <tr>
            <th>ブランド選択<span class="attention"> *</span><br><span class="attention">ブランドはコードマスター管理から予め登録しておく必要があります。</span></th>
            <td>
                <span class="attention"><!--{$arrErr.brand_id}--></span>
                <select name="arrProduct[brand_id]">
                <option value="">選択してください</option>
                <!--{%section name=bc loop=$arrBrand%}-->
                <option value="<!--{%$arrBrand[bc].id%}-->" <!--{%if $arrProduct.brand_id == $arrBrand[bc].id%}-->selected<!--{%/if%}-->><!--{%$arrBrand[bc].name%}--></option>
                <!--{%/section%}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>商品SKU情報</th>
            <td>
                <!--{%foreach from=$arrProductCode key=key item=sku%}-->
                <div  style="border-bottom:1px solid #000;padding:10px 0;">
                商品コード：<input type="text" name="arrProductCode[product_code][]" value="<!--{%$sku.product_code%}-->" maxlength="30" size="30" class="box60" /><br>
                カラーコード：<input type="text" name="arrProductCode[color_code][]" value="<!--{%$sku.color_code%}-->" maxlength="10" size="30" class="box60" />
                カラー名：<input type="text" name="arrProductCode[color_name][]" value="<!--{%$sku.color_name%}-->" maxlength="10" size="30" class="box60" /><br>
                サイズコード：<input type="text" name="arrProductCode[size_code][]" value="<!--{%$sku.size_code%}-->" maxlength="10" size="30" class="box60" />
                サイズ名：<input type="text" name="arrProductCode[size_name][]" value="<!--{%$sku.size_name%}-->" maxlength="10" size="30" class="box60" /><br>
                在庫：<input type="text" name="arrProductCode[stock][]" value="<!--{%$sku.stock%}-->" maxlength="10" size="30" class="box60" /><br>
                </div>
                <!--{%/foreach%}-->
                <p style="padding:10px 0;font-weight:bold;">追加</p>
                商品コード：<input type="text" name="arrProductCode[product_code][]" value="" maxlength="30" size="30" class="box60" /><br>
                カラーコード：<input type="text" name="arrProductCode[color_code][]" value="" maxlength="10" size="30" class="box60" />
                カラー名：<input type="text" name="arrProductCode[color_name][]" value="" maxlength="10" size="30" class="box60" /><br>
                サイズコード：<input type="text" name="arrProductCode[size_code][]" value="" maxlength="10" size="30" class="box60" />
                サイズ名：<input type="text" name="arrProductCode[size_name][]" value="" maxlength="10" size="30" class="box60" /><br>
                在庫：<input type="text" name="arrProductCode[stock][]" value="" maxlength="10" size="30" class="box60" /><br>
            </td>
        </tr>

        <tr>
            <th>商品部門<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <select name="category_id">
                <option value="">選択してください</option>
                <!--{%foreach from=$arrCategory item=category key=key%}-->
                <option value="<!--{%$key%}-->" <!--{%if $key == $category_id%}-->selected<!--{%/if%}-->><!--{%$category%}--></option>
                <!--{%/foreach%}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td>
                <!--{%html_radios name="arrProduct[status]" options=$arrSTATUS selected=$arrProduct.status separator='&nbsp;&nbsp;'%}-->
            </td>
        </tr>
        <tr>
            <th>グループコード</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrProduct[group_code]" value="<!--{%$arrProduct.group_code%}-->" maxlength="<!--{%$smarty.const.STEXT_LEN%}-->" size="60" class="box60" />
                <span class="attention"> (<!--{%$smarty.const.STEXT_LEN%}-->文字)</span><br/>
            </td>
        </tr>
        <tr>
            <th>商品単価<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrProduct[price01]" value="<!--{%$arrProduct.price01%}-->" size="10" class="box6" maxlength="<!--{%$smarty.const.PRICE_LEN%}-->"/>円
                <span class="attention"> (半角数字で入力)</span>
            </td>
        </tr>
        <tr>
            <th>原価</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrProduct[cost_price]" value="<!--{%$arrProduct.cost_price%}-->" maxlength="<!--{%$smarty.const.PRICE_LEN%}-->" size="10" class="box6" />
                <span class="attention"> (半角数字で入力)</span>
            </td>
        </tr>
        <tr>
            <th>ポイント付与率<span class="attention"> *</span></th>
            <td>
                <span class="attention"><!--{$arrErr.point_rate}--></span>
                <input type="text" name="arrProduct[point_rate]" value="<!--{%$arrProduct.point_rate%}-->" size="6" class="box6" maxlength="<!--{%$smarty.const.PERCENTAGE_LEN%}-->" />％
                <span class="attention"> (半角数字で入力)</span>
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
                <span class="attention"><!--{$arrErr.comment3}--></span>
                <div style="border-bottom:1px solid #fff;padding:10px 0;">
                <!--{%foreach from=$arrTag item=tag key=key%}-->
                <input type="text" name="arrTag[tag][<!--{%$key%}-->]" value="<!--{%$tag%}-->" size="20" class="box20" />
                <!--{%/foreach%}-->
                </div>
                <p style="padding:10px 0;font-weight:bold;">追加</p>
                <input type="text" name="arrTag[tag][]" value="" size="20" class="box20" />
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
                <span class="attention"><!--{$arrErr.season}--></span>
                <input type="text" name="arrProduct[season]" value="<!--{%$arrProduct.season%}-->" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" size="60" class="box60" />
                <span class="attention"> (上限<!--{$smarty.const.LLTEXT_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th style="background-image:none;background-color:#FFAE00;">MATERIAL</th>
            <td>
                <span class="attention"><!--{$arrErr.material}--></span>
                <input type="text" name="arrProduct[material]" value="<!--{%$arrProduct.material%}-->" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" size="60" class="box60" />
                <span class="attention"> (上限<!--{$smarty.const.LLTEXT_LEN}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th style="background-image:none;background-color:#FFAE00;">SIZE(CUBE)<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.size_text}--></span>
                <textarea name="arrProduct[size_text]" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.size_text%}--></textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>REMARKS</th>
            <td>
                <span class="attention"><!--{$arrErr.remarks}--></span>
                <textarea name="arrProduct[remarks]" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.remarks%}--></textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
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
                <span class="attention"><!--{$arrErr.main_comment}--></span>
                <textarea name="arrProduct[info]" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.info%}--></textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
            <div id="image_upload_section">
                <div id="drop" style="width:700px; height:150px; padding:10px; border:3px solid" ondragover="onDragOver(event)" ondrop="onDrop(event)">
                    ファイルをドラッグアンドドロップしてください。複数ファイル同時も対応しています。
                </div>
            </div>
            <div id="images_area">
                <ul id="image_area">
                <!--{%foreach from=$arrImages item=image key=key%}-->
                <li class="img_li"><img src="<!--{%$smarty.const.UPLOAD_IMAGE_PATH%}--><!--{%$shop%}-->/<!--{%$image.path%}-->" width="200"><input type="hidden" name="arrImages[images][]" value="<!--{%$smarty.const.UPLOAD_IMAGE_PATH%}--><!--{%$shop%}-->/<!--{%$image.path%}-->" /><br>タグ：<input type="text" name="arrImages[tags][]" value="<!--{%$image.tag%}-->" /><button class="del">削除</button></li>
                <!--{%/foreach%}-->
                 </ul>
            </div>
            </td>
        </tr>
    </table>

    <div class="btn-area">
        <!--{if count($arrSearchHidden) > 0}-->
        <!--▼検索結果へ戻る-->
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="location.href='/admin/product';"><span class="btn-prev">検索画面に戻る</span></a></li>
        <!--▲検索結果へ戻る-->
        <!--{/if}-->
            <li><a class="btn-action" href="javascript:;" onclick="selectAll('category_id'); document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>
</div>
</form>

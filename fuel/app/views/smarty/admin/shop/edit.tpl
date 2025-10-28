<script src="/admin_common/js/Sortable.js"></script>
<link rel="stylesheet" href="/admin_common/css/excolor.css" type="text/css" />
<script src="/admin_common/js/jquery.excolor.js"></script>
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
    for (var i=0; i<1; i++) {
        // 一件ずつアップロード
        imageFileUpload(files[i]);
        check_img();
    }
}

function check_img()
{
    if ($('#image_area').children().length > 0)
        $('.images_area').hide();
    else
        $('.images_area').show();
}

// ファイルアップロード
function imageFileUpload(f) {
    var formData = new FormData();
    formData.append('image', f);
    var url = "https://origin.bronline.jp/api/addimg";

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
        var str = '<li class="img_li"><img src="'+ data.img +'" width="200"><input type="hidden" name="arrShop[logo_img]" value="'+data.img+'" /><br><button class="del">削除</button></li>';
        
        $('#image_area').append(str);
    })
    .fail(function(jqXHR, textStatus, errorThrown){
        alert("fail");
    });
}
$(function(){
	$('#color').excolor({
	});
    $('#stock_type').change(function(){
        var type = $(this).val();
        if (type == 1)
            $('.smaregi').show();
        else
            $('.smaregi').hide();
    });
    $('#stock_type').change();
    check_img();    
});
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

<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit" />
<input type="hidden" name="arrShop[id]" value="<!--{%if array_key_exists('id', $arrShop)%}--><!--{%$arrShop.id%}--><!--{%/if%}-->" />
<div id="products" class="contents-main">
    <h2>基本情報</h2>

    <div class="btn-area">
        <!--{if count($arrSearchHidden) > 0}-->
        <!--▼検索結果へ戻る-->
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="location.href='/admin/shop';"><span class="btn-prev">検索画面に戻る</span></a></li>
        <!--▲検索結果へ戻る-->
        <!--{/if}-->
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>

    <table class="form">
        <tr>
            <th>ショップID</th>
            <td><!--{%if array_key_exists('id', $arrShop)%}--><!--{%$arrShop.id%}--><!--{%/if%}--></td>
        </tr>
        <tr>
            <th>POPUPショップ</th>
            <td><label><input type="checkbox" value="1" name="arrShop[popup_flg]">POPUPショップ</label></td>
        </tr>
        <tr>
            <th>ショップカラー</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[color]" value="<!--{%$arrShop.color%}-->" id="color" maxlength="6" size="60" class="box60" />
            </td>
        </tr>
        <tr>
            <th>ショップ名<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[shop_name]" value="<!--{%$arrShop.shop_name%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention"> (上限85文字)</span>
            </td>
        </tr>
        <tr>
            <th>ショップURL</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[shop_url]" value="<!--{%$arrShop.shop_url%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ（未入力時はログインIDが使用されます）</span>
            </td>
        </tr>
        <tr>
            <th>ログインID<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[login_id]" value="<!--{%$arrShop.login_id%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr>
            <th>パスワード<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="password" name="arrShop[login_pass]" value="<!--{%$arrShop.login_pass%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr>
            <th>在庫管理タイプ<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <select name="arrShop[dtb_stock_type_id]" id="stock_type">
                <!--{%foreach from=$arrStockTypes key=key item=stock_type%}-->
                <option value="<!--{%$key%}-->" <!--{%if $arrShop.dtb_stock_type_id|default:"" == $key%}-->selected<!--{%/if%}-->><!--{%$stock_type%}--></option>
                <!--{%/foreach%}-->
                </select>
            </td>
        </tr>
        <tr class="">
            <th>通知先メールアドレス（「,」区切りで複数可）</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrStockType[email]" value="<!--{%$arrStockType.email%}-->" maxlength="2000" size="60" class="box60" />
                <span class="attention"></span>
            </td>
        </tr>
        <tr class="smaregi">
            <th>スマレジログインID<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrStockType[login_id]" value="<!--{%$arrStockType.login_id%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr class="smaregi">
            <th>パスワード<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrStockType[login_pass]" value="<!--{%$arrStockType.login_pass%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr class="smaregi">
            <th>セキュアコード<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrStockType[secure_code]" value="<!--{%$arrStockType.secure_code%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr class="smaregi">
            <th>API送受信URL<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrStockType[url]" value="<!--{%$arrStockType.url%}-->" maxlength="85" size="60" class="box60" />
                <span class="attention">英数字のみ</span>
            </td>
        </tr>
        <tr>
            <th>稼働状況<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <select name="arrShop[shop_status]">
                <!--{%foreach from=$arrStatus key=key item=shop_status%}-->
                <option value="<!--{%$key%}-->" <!--{%if $arrShop.shop_status|default:"" == $key%}-->selected<!--{%/if%}-->><!--{%$shop_status%}--></option>
                <!--{%/foreach%}-->
                </select>
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
                <!--{%if array_key_exists('logo_img', $arrShop)%}-->
                <!--{%if $arrShop.logo_img != ''%}-->
                <li class="img_li"><img src="<!--{%$smarty.const.UPLOAD_LOGOIMAGE_PATH%}--><!--{%$arrShop.login_id%}-->/<!--{%$arrShop.logo_img%}-->" width="200">
                <input type="hidden" name="arrShop[logo_img]" value="<!--{%$arrShop.logo_img%}-->" /><br>
                <button class="del">削除</button></li>
                <!--{%/if%}-->
                <!--{%/if%}-->
                 </ul>
            </div>
            </td>
        </tr>
    </table>
    <table class="form">
    <caption>【PICKUP用情報】</caption>
        <tr class="">
            <th>サムネイル画像パス</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[thumbnail]" value="<!--{%$arrShop.thumbnail%}-->" maxlength="1000" size="60" class="box60" />
                <span class="attention"></span>
            </td>
        </tr>
        <tr class="">
            <th>ショップ名</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrShop[pickup_name]" value="<!--{%$arrShop.pickup_name%}-->" maxlength="1000" size="60" class="box60" />
                <span class="attention"></span>
            </td>
        </tr>
    </table>

    <div class="btn-area">
        <!--{if count($arrSearchHidden) > 0}-->
        <!--▼検索結果へ戻る-->
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="location.href='/admin/shop';"><span class="btn-prev">検索画面に戻る</span></a></li>
        <!--▲検索結果へ戻る-->
        <!--{/if}-->
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>
</div>
</form>

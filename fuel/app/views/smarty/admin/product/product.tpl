<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-addon.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-ja.js"></script>
<link rel="stylesheet" href="/admin_common/css/jquery-ui-timepicker-addon.css">

<script src="/admin_common/js/datepicker-ja.js"></script>
<script src="/admin_common/js/Sortable.js"></script>

<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">-->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<link href="/admin_common/js/summernote.css" rel="stylesheet" type="text/css">
<script src="/admin_common/js/summernote.min.js"></script>
<script src="/admin_common/js/lang/summernote-ja-JP.js"></script>

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
//    var url = "https://bradmin.bronline.jp/api/addimg";

	var host = '<!--{%$smarty.server.HTTP_HOST%}-->';
    var url = '';
    if (host == 'origin-develop.bronline.jp')
	    url = "https://"+host+"/api/addimg";
	else
		url = "https://"+host+"/api/addimg";

    // POSTでアップロード
    $.ajax({
        url  : url,
//        username:"demo",
//        password:"testtest",
        type : "POST",
        data : formData,
        cache       : false,
        contentType : false,
        processData : false,
	    async: false,
        dataType    : "json"
    })
    .done(function(data){
        var img = new Image();
        img.src = data.img;
        img.width = 200;
        img.class = 'img_name';
        var str = '<li class="img_li"><img src="'+ data.img +'" width="200"><input type="hidden" name="arrImages[images][]" value="'+data.img+'" /><br>タグ：<input type="text" name="arrImages[tags][]" /><button type="button" class="del">削除</button>';
        var str2 = '<br>画像コメント：<input type="text" name="arrImages[comment][]" value="" maxlength="26" /></li>';
        
        $('#image_area').append(str+str2);
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

$('#summernote').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});

$('#summernote2').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});
$('#summernote3').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});
$('#summernote4').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});
$('#summernote5').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});
$('#summernote6').summernote({
　　　　　　　　　　tabsize: 2,
　　　　　　　　　　height: 300,
　　　　　　　　　　fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
　　　　　　　　　　lang: "ja-JP",
				callbacks: {
                        onImageUpload : function(files, editor, welEditable) {
                
                             for(var i = files.length - 1; i >= 0; i--) {
                                     sendFile(files[i], this);
                            }
                        }
                    }
});

$('#brand_select').change(function(){
	$('#brand_id').val($(this).val());
});
$('#brand_id').blur(function(){
	$('#brand_select').val($(this).val());
});

$('input[name="arrProduct[reservation_flg]"]').change(function(){
	$('.reservations2').hide();
	$('.reservations').hide();
	if ($('input[name="arrProduct[reservation_flg]"]:checked').val() == '1')
	{
//		alert($('input[name="arrProduct[reservation_flg]"]:checked').val());
		$('.reservations').show();
	}
	else if ($('input[name="arrProduct[reservation_flg]"]:checked').val() == '2')
	{
//		alert($('input[name="arrProduct[reservation_flg]"]:checked').val());
		$('.reservations2').show();
	}
	else
	{
//		alert($('input[name="arrProduct[reservation_flg]"]:checked').val());
//		$('.reservations').hide();
//		$('.reservations2').hide();
	}
});

function sendFile(file, el) {
//	var url = "https://bradmin.bronline.jp/api/addpimg";
//	var form_data = new FormData();
	var host = '<!--{%$smarty.server.HTTP_HOST%}-->';

    var url = '';
    if (host == 'origin-develop.bronline.jp')
	    url = "https://"+host+"/api/addpimg";
	else
		url = "https://"+host+"/api/addpimg";

	var form_data = new FormData();
	form_data.append('file', file);
	$.ajax({
	    data: form_data,
	    type: "POST",
	    url: url,
//        username:"demo",
//        password:"testtest",
	    cache: false,
	    contentType: false,
	    processData: false,
	    async: false,
        dataType    : "json"
	 })
	 .done(function(data){
	    	console.log(data);
	    	console.log(data.str);
	    	console.log(data.url);
	        $(el).summernote('editor.insertImage', data.url);
	 })
	 .fail(function(jqXHR, textStatus, errorThrown){
	        alert("fail");
	 });
}

    $(document).on("click", ".del", function(){
        $(this).parent().empty();
    });
	$('.datetimepicker').datetimepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:2,
		showOtherMonths: true,
/*		selectOtherMonths: true,*/
/*		minDate: new Date(<!--{%$year%}-->,<!--{%$month-1%}-->,<!--{%$day%}-->),*/
		showOn: "both",
		buttonText: "カレンダーを表示",
		timeFormat: "HH:mm",
		stepMinute: 1,
	});

    Sortable.create($('ul#image_area')[0]);
    
	$('input[name="arrProduct[reservation_flg]"]').change();
//    $('.reservation_check').change();
});
function check()
{
    if ($('#category_id').val() == '')
    {
        alert("部門を選択してください。");
        return false;
    }

    if ($('#brand_id').val() == '')
    {
        alert("ブランドを選択、または入力してください。");
        return false;
    }
    if ($('#brand_select').val() == '' || $('#brand_select').val() == null)
    {
        alert("入力されたIDのブランドがありません。");
        return false;
    }

    ret = checkCharType ($('input[name="arrProductCode[stock][]"]').val(), "numeric");
    if (ret == false)
    {
        alert("在庫は数値（半角）で入力してください。");
        return false;
    }

    ret = checkname('input[name="arrProductCode[size_code][]"]', 'input[name="arrProductCode[size_name][]"]', 'サイズ');
    if (ret == false)
    {
        return false;
    }

    ret = checkname('input[name="arrProductCode[color_code][]"]', 'input[name="arrProductCode[color_name][]"]', 'カラー');

    if (ret == false)
    {
        return false;
    }


    return true;
}
function checkCharType(input, charType) {
    switch (charType) {
        // 全角文字（ひらがな・カタカナ・漢字 etc.）
        case "zenkaku":
            return (input.match(/^[^\x01-\x7E\xA1-\xDF]+$/)) ? true : false;
        // 全角ひらがな
        case "hiragana":
            return (input.match(/^[\u3041-\u3096]+$/)) ? true : false;
        // 全角カタカナ
        case "katakana":
            return (input.match(/^[\u30a1-\u30f6]+$/)) ? true : false;
        // 半角英数字（大文字・小文字）
        case "alphanumeric":
            return (input.match(/^[0-9a-zA-Z]+$/)) ? true : false;
        // 半角数字
        case "numeric":
            return (input.match(/^[0-9]+$/)) ? true : false;
        // 半角英字（大文字・小文字）
        case "alphabetic":
            return (input.match(/^[a-zA-Z]+$/)) ? true : false;
        // 半角英字（大文字のみ）
        case "upper-alphabetic":
            return (input.match(/^[A-Z]+$/)) ? true : false;
        // 半角英字（小文字のみ）
        case "lower-alphabetic":
            return (input.match(/^[a-z]+$/)) ? true : false;
    }
    return false;
}
function checkname(id, id2, msg)
{
    var ret = true;
    var cnt = 0;
    var len = $('input[name="arrProductCode[size_code][]"]').length;
    $(id).each(function(){
        var code = $(this).val();
        console.log(cnt+' code:'+code);
        var target = 0;
        if (code != '')
        {
            $(id2).each(function(){
                if (target == cnt)
                {
                    var name = $(this).val();
                    if (name == '')
                    {
                        alert('['+code+']の'+msg+'名を入れてください。');
                        ret = false;
                    }
                }
                target++;
            });
        }
        cnt++;
    });
    return ret;
}
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
            <li><a class="btn-action" href="javascript:;" onclick="if (check() == false) { return false; };document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>

    <table class="form">
        <tr>
            <th>商品ID</th>
            <td><!--{%if array_key_exists('product_id', $arrProduct)%}--><!--{%$arrProduct.product_id%}--><!--{%/if%}--></td>
        </tr>
        <!--{%if $smarty.session.stock_type == 1%}-->
        <tr>
            <th>在庫対象</th>
            <td>
            <label><input type="radio" value="0" name="arrProduct[stockControlDivision]" <!--{%if $arrProduct.stockControlDivision == 0%}-->checked<!--{%/if%}--> />スマレジ在庫対象</label>
            <label><input type="radio" value="1" name="arrProduct[stockControlDivision]" <!--{%if $arrProduct.stockControlDivision == 1%}-->checked<!--{%/if%}--> />スマレジ在庫対象外</label>
            </td>
        </tr>
        <!--{%/if%}-->
        <tr>
            <th>セール対象区分</th>
            <td>
            <label><input type="radio" value="0" name="arrProduct[sale_status]" <!--{%if $arrProduct.sale_status == 0%}-->checked<!--{%/if%}--> />通常商品</label>
            <label><input type="radio" value="1" name="arrProduct[sale_status]" <!--{%if $arrProduct.sale_status == 1%}-->checked<!--{%/if%}--> />セール商品</label>
<!--
            <label><input type="radio" value="1" name="arrProduct[sale_status]" <!--{%if $arrProduct.sale_status == 1%}-->checked<!--{%/if%}--> />シークレットセール対象</label>
            <label><input type="radio" value="2" name="arrProduct[sale_status]" <!--{%if $arrProduct.sale_status == 2%}-->checked<!--{%/if%}--> />VIPシークレットセール対象</label>
-->
            </td>
        </tr>
<!--
        <tr>
            <th>スマレジ商品ID</th>
            <td><!--{%if array_key_exists('smaregi_product_id', $arrProduct)%}--><!--{%$arrProduct.smaregi_product_id%}--><!--{%/if%}--></td>
        </tr>
-->
<!--{%if $shop == 'brshop'%}-->
        <tr>
            <th>お直し商品フラグ<br>（お直し商品を選択の場合は購入時、代金引換が非表示になります）</th>
            <td>
            <label><input type="radio" value="0" name="arrProduct[pay_off]" <!--{%if $arrProduct.pay_off == 0%}-->checked<!--{%/if%}--> />通常商品</label>
            <label><input type="radio" value="1" name="arrProduct[pay_off]" <!--{%if $arrProduct.pay_off == 1%}-->checked<!--{%/if%}--> />お直し商品</label>
            </td>
        </tr>
<!--{%else%}-->
            <input type="hidden" value="0" name="arrProduct[pay_off]" />
<!--{%/if%}-->
        <tr>
            <th>完全受注生産/予約商品フラグ</th>
            <td>
            <label><input class="reservation_check" type="radio" value="0" name="arrProduct[reservation_flg]" <!--{%if $arrProduct.reservation_flg == 0%}-->checked<!--{%/if%}--> />通常商品</label>
            <label><input class="reservation_check" type="radio" value="1" name="arrProduct[reservation_flg]" <!--{%if $arrProduct.reservation_flg == 1%}-->checked<!--{%/if%}--> />完全受注生産</label>
            <label><input class="reservation_check" type="radio" value="2" name="arrProduct[reservation_flg]" <!--{%if $arrProduct.reservation_flg == 2%}-->checked<!--{%/if%}--> />予約商品</label>
            </td>
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
            <th>公開開始日</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrProduct[view_date]" value="<!--{%$arrProduct.view_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="85" size="60" class="box60 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>公開終了日</th>
            <td>
                <span class="attention"><!--{$arrErr.close_date}--></span>
                <input type="text" name="arrProduct[close_date]" value="<!--{%$arrProduct.close_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="85" size="60" class="box60 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>更新日</th>
            <td>
                <span class="attention"><!--{$arrErr.update_date}--></span>
                <input type="text" name="arrProduct[update_date]" value="<!--{%$arrProduct.update_date|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="85" size="60" class="box60 datetimepicker" />
            </td>
        </tr>
        <tr>
            <th>ブランド選択<span class="attention"> *</span><br><span class="attention">ブランドはコードマスター管理から予め登録しておく必要があります。</span></th>
            <td>
                <span class="attention"><!--{$arrErr.brand_id}--></span>
                <p>ブランドID：<input type="text" name="arrProduct[brand_id]" value="<!--{%$arrProduct.brand_id%}-->" id="brand_id" size="60"/></p>
                <select name="brand_id" id="brand_select">
                <option value="">選択してください</option>
                <!--{%section name=bc loop=$arrBrand%}-->
                <option value="<!--{%$arrBrand[bc].id%}-->" <!--{%if $arrProduct.brand_id == $arrBrand[bc].id%}-->selected<!--{%/if%}-->><!--{%$arrBrand[bc].id%}-->:<!--{%$arrBrand[bc].name%}--></option>
                <!--{%/section%}-->
                </select>
            </td>
        </tr>
        <tr>
            <th>テーマ選択<span class="attention"> *</span><br><span class="attention">テーマはテーマ管理から予め登録しておく必要があります。</span></th>
            <td>
                <span class="attention"><!--{$arrErr.brand_id}--></span>
                <select name="arrProduct[theme_id]" id="theme_id">
                <option value="0">選択してください</option>
                <!--{%section name=bc loop=$arrTheme%}-->
                <option value="<!--{%$arrTheme[bc].id%}-->" <!--{%if $arrProduct.theme_id == $arrTheme[bc].id%}-->selected<!--{%/if%}-->><!--{%$arrTheme[bc].name%}--></option>
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
                カラー名：<input type="text" name="arrProductCode[color_name][]" value="<!--{%$sku.color_name%}-->" maxlength="15" size="30" class="box60" /><br>
                サイズコード：<input type="text" name="arrProductCode[size_code][]" value="<!--{%$sku.size_code%}-->" maxlength="10" size="30" class="box60" />
                サイズ名：<input type="text" name="arrProductCode[size_name][]" value="<!--{%$sku.size_name%}-->" maxlength="15" size="30" class="box60" /><br>
                在庫：<input type="text" name="arrProductCode[stock][]" value="<!--{%$sku.stock%}-->" maxlength="10" size="30" class="box60" /><br>
                </div>
                <!--{%/foreach%}-->
                <p style="padding:10px 0;font-weight:bold;">追加</p>
                商品コード：<input type="text" name="arrProductCode[product_code][]" value="" maxlength="30" size="30" class="box60" /><br>
                カラーコード：<input type="text" name="arrProductCode[color_code][]" value="" maxlength="10" size="30" class="box60" />
                カラー名：<input type="text" name="arrProductCode[color_name][]" value="" maxlength="15" size="30" class="box60" /><br>
                サイズコード：<input type="text" name="arrProductCode[size_code][]" value="" maxlength="10" size="30" class="box60" />
                サイズ名：<input type="text" name="arrProductCode[size_name][]" value="" maxlength="15" size="30" class="box60" /><br>
                在庫：<input type="text" name="arrProductCode[stock][]" value="" maxlength="10" size="30" class="box60" /><br>
            </td>
        </tr>

        <tr>
            <th>規格（スマレジ項目）</th>
            <td>
                <textarea name="arrProduct[attribute]" cols="60" rows="8" class="area60" maxlength="1000"><!--{%"\n"%}--><!--{%$arrProduct.attribute%}--></textarea><br />
                <span class="attention"> (上限1000文字)</span>
            </td>
        </tr>
        <tr>
            <th>商品部門<span class="attention"> *</span></th>
            <td>
                <span class="attention"></span>
                <select name="category_id" id="category_id">
                <!--{%foreach from=$arrParent item=parent%}-->
                <!--{%if $parent.category|@count > 0%}-->
				<optgroup label="<!--{%$parent.name%}-->">
					<!--{%foreach from=$parent.category item=categorys%}-->
					<!--{%foreach from=$categorys key=key item=category%}-->
	                <option value="<!--{%$key%}-->" <!--{%if $key == $category_id%}-->selected<!--{%/if%}-->><!--{%$category%}--></option>
	                <!--{%/foreach%}-->
	                <!--{%/foreach%}-->
				</optgroup>
				<!--{%/if%}-->
                <!--{%/foreach%}-->
                </select>
<!--{%*                
                <select name="category_id" id="category_id">
                <option value="">選択してください</option>
                <!--{%foreach from=$arrCategory item=category key=key%}-->
                <option value="<!--{%$key%}-->" <!--{%if $key == $category_id%}-->selected<!--{%/if%}-->><!--{%$category%}--></option>
                <!--{%/foreach%}-->
                </select>
*%}-->
            </td>
        </tr>
        <tr>
            <th>商品ステータス</th>
            <td>
                <!--{%html_radios name="arrProduct[status]" options=$arrSTATUS selected=$arrProduct.status separator='&nbsp;&nbsp;'%}-->
            </td>
        </tr>
        <tr>
            <th>NEWステータス</th>
            <td>
                <label><input type="radio" name="arrProduct[status_flg]" value="1" <!--{%if $arrProduct.status_flg == 1%}-->checked<!--{%/if%}-->>NEWフラグあり</label>
                <label><input type="radio" name="arrProduct[status_flg]" value="0" <!--{%if $arrProduct.status_flg == 0%}-->checked<!--{%/if%}-->>NEWフラグなし</label>
            </td>
        </tr>
        <tr>
            <th>グループコード</th>
            <td>
                <span class="attention"></span>
                <input type="text" name="arrProduct[group_code]" value="<!--{%$arrProduct.group_code%}-->" maxlength="30" size="60" class="box60" />
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
            <th>原産国</th>
            <td>
                <span class="attention"><!--{$arrErr.country}--></span>
                <textarea name="arrProduct[country]" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.country%}--></textarea><br />
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
        <tr class="reservations">
            <th>完全受注生産テキスト１<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.reservation_text1}--></span>
                <textarea name="arrProduct[reservation_text1]" id="summernote3" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}-->
                <!--{%if $arrProduct.reservation_text1 == ''%}-->
<p style="font-size: 13px;letter-spacing: 0;">
<span style="font-size: 14px;letter-spacing: 0;">こちらは</span><span style="color:#c85267;font-size: 14px;font-weight:bolder;">完全受注生産商品</span><span style="font-size: 14px;letter-spacing: 0;">です</span><br>
・お届け予定：初旬〜中旬<br>
※工場の生産の都合上、納期が変更になる場合がございます。<br>
</p>
                <!--{%else%}-->
                <!--{%$arrProduct.reservation_text1%}-->
                <!--{%/if%}-->
                </textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr class="reservations">
            <th>受注生産テキスト２<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.reservation_text2}--></span>
                <textarea name="arrProduct[reservation_text2]" id="summernote4" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}-->
                <!--{%if $arrProduct.reservation_text2 == ''%}-->
<p style="font-size: 16px;letter-spacing: 0;">
<span style="color:#c85267;">【完全受注生産商品に関する注意事項】</span><br>
・お客さま都合によるキャンセルは承りかねます。<br>
・受付期間　年月日（）23時59分まで<br>
・その他の商品との同時決済はできません。<br>
・メーカー側の都合で生産数量が減産となった場合、予約の受付順に応じて予約受付金をお返しいたします。予めご了承くださいませ。<br>
・今後通常販売を行う可能性もございます。<br>
・銀行振込のお客様は年月日（）12時までのお振込みが確認できた場合、予約完了となります。<br>
・代金引換でのご注文は承っておりません。<br>
・お客様都合による返品、交換は承りかねます。<br>
</p>
                <!--{%else%}-->
                <!--{%$arrProduct.reservation_text2%}-->
                <!--{%/if%}-->
                </textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>

        <tr class="reservations2">
            <th>予約テキスト１<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.production_text1}--></span>
                <textarea name="arrProduct[production_text1]" id="summernote5" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}-->
                <!--{%if $arrProduct.production_text1 == ''%}-->
<p style="font-size: 13px;letter-spacing: 0;">
<span style="font-size: 14px;letter-spacing: 0;">こちらは</span><span style="color:#c85267;font-size: 14px;font-weight:bolder;">予約商品</span><span style="font-size: 14px;letter-spacing: 0;">です</span><br>
・お届け予定：初旬〜中旬<br>
※工場の生産の都合上、納期が変更になる場合がございます。<br>
</p>
                <!--{%else%}-->
                <!--{%$arrProduct.production_text1%}-->
                <!--{%/if%}-->
                </textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr class="reservations2">
            <th>予約テキスト２<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.production_text2}--></span>
                <textarea name="arrProduct[production_text2]" id="summernote6" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}-->
                <!--{%if $arrProduct.production_text2 == ''%}-->
<p style="font-size: 16px;letter-spacing: 0;">
<span style="color:#c85267;">【予約商品に関する注意事項】</span><br>
・その他の商品との同時決済はできません。<br>
・メーカー側の都合で生産数量が減産となった場合、予約の受付順に応じて予約受付金をお返しいたします。予めご了承くださいませ。<br>
・入荷後は通常販売となります。<br>
・代金引換でのご注文は承っておりません。<br>
・返品を承ることが可能です。<br>
</p>
                <!--{%else%}-->
                <!--{%$arrProduct.production_text2%}-->
                <!--{%/if%}-->
                </textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>


        <tr>
            <th>詳細(説明)<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.main_comment}--></span>
                <textarea name="arrProduct[info]" id="summernote" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.info%}--></textarea><br />
                <span class="attention"> (上限<!--{%$smarty.const.LLTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>スタッフコメント<span class="attention">(タグ許可)</span></th>
            <td>
                <span class="attention"><!--{$arrErr.comment2}--></span>
                <textarea name="arrProduct[comment]" id="summernote2" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" cols="60" rows="8" class="area60"><!--{%"\n"%}--><!--{%$arrProduct.comment%}--></textarea><br />
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
                <!--{%if $arrImages|default:""%}-->
                <!--{%foreach from=$arrImages item=image key=key%}-->
                <li class="img_li"><img src="<!--{%$smarty.const.UPLOAD_IMAGE_PATH%}--><!--{%$shop%}-->/<!--{%$image.path%}-->" width="200"><input type="hidden" name="arrImages[images][]" value="<!--{%$smarty.const.UPLOAD_IMAGE_PATH%}--><!--{%$shop%}-->/<!--{%$image.path%}-->" /><br>タグ：<input type="text" name="arrImages[tags][]" value="<!--{%$image.tag%}-->" /><button type="button" class="del">削除</button>
                <br>画像コメント：<input type="text" name="arrImages[comment][]" value="<!--{%$image.comment%}-->" maxlength="26" /></li>
                <!--{%/foreach%}-->
                <!--{%/if%}-->
                 </ul>
            </div>
            </td>
        </tr>
        <tr>
            <th>動画ID</th>
            <td>
                <span class="attention"><!--{$arrErr.movies}--></span>
                <input type="text" name="arrProduct[movies]" value="<!--{%$arrProduct.movies%}-->" maxlength="<!--{%$smarty.const.LLTEXT_LEN%}-->" size="60" class="box60" />
                <span class="attention"> (上限<!--{%$smarty.const.STEXT_LEN%}-->文字)</span>
            </td>
        </tr>
        <tr>
            <th>動画サムネイル</th>
            <td>
                <span class="attention"><!--{$arrErr.movies_img}--></span>
                <!--{%if $arrProduct.movies_img%}-->
                <img width="100" src="<!--{%$smarty.const.UPLOAD_IMAGE_PATH%}--><!--{%$shop%}-->/<!--{%$arrProduct.movies_img%}-->" />
                <input type="hidden" name="arrProduct[movies_img]" value="<!--{%$arrProduct.movies_img%}-->" />
                <!--{%/if%}-->
                <input type="file" name="movies_img_tmp" value="" />
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
            <li><a class="btn-action" href="javascript:;" onclick="if (check() == false) { return false; };document.form1.submit(); return false;"><span class="btn-next">確認ページへ</span></a></li>
        </ul>
    </div>
</div>
</form>

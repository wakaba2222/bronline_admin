<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="confirm" />
<div id="products" class="contents-main">

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnModeSubmit('confirm_return','',''); return false;"><span class="btn-prev">前のページに戻る</span></a></li>
            <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>

    <table class="form">
        <tr>
            <th>ショップID</th>
            <td><!--{%if array_key_exists('id', $arrShop)%}--><!--{%$arrShop.id%}--><!--{%/if%}--></td>
        </tr>
        <tr>
            <th>POPUPショップ</th>
            <td><!--{%if array_key_exists('id', $arrShop)%}-->POPUPショップ<!--{%/if%}--></td>
        </tr>
        <tr>
            <th>ショップ名<span class="attention"> *</span></th>
            <td>
            <!--{%$arrShop.shop_name%}-->
            </td>
        </tr>
        <tr>
            <th>ショップURL</th>
            <td>
            <!--{%$arrShop.shop_url%}-->
            </td>
        </tr>
        <tr>
            <th>ログインID<span class="attention"> *</span></th>
            <td>
            <!--{%$arrShop.login_id%}-->
            </td>
        </tr>
        <tr>
            <th>パスワード<span class="attention"> *</span></th>
            <td>
            <!--{%$arrShop.login_pass%}-->
            </td>
        </tr>
        <tr>
            <th>在庫管理タイプ<span class="attention"> *</span></th>
            <td>
                <!--{%foreach from=$arrStockTypes key=key item=stock_type%}-->
                <!--{%if $arrShop.dtb_stock_type_id == $key%}--><!--{%$stock_type%}--><!--{%/if%}-->
                <!--{%/foreach%}-->
        </td>
        </tr>
        <tr class="">
            <th>通知先メールアドレス（「,」区切りで複数可）</th>
            <td>
            <!--{%$arrStockType.email%}-->
            </td>
        </tr>
        <tr class="smaregi">
            <th>スマレジログインID<span class="attention"> *</span></th>
            <td>
            <!--{%$arrStockType.login_id%}-->
            </td>
        </tr>
        <tr class="smaregi">
            <th>パスワード<span class="attention"> *</span></th>
            <td>
            <!--{%$arrStockType.login_pass%}-->
            </td>
        </tr>
        <tr class="smaregi">
            <th>セキュアコード<span class="attention"> *</span></th>
            <td>
            <!--{%$arrStockType.secure_code%}-->
            </td>
        </tr>
        <tr class="smaregi">
            <th>API送受信URL<span class="attention"> *</span></th>
            <td>
            <!--{%$arrStockType.url%}-->
            </td>
        </tr>
        <tr>
            <th>稼働状況<span class="attention"> *</span></th>
            <td>
                <!--{%foreach from=$arrStatus key=key item=shop_status%}-->
                <!--{%if $arrShop.shop_status == $key%}--><!--{%$shop_status%}--><!--{%/if%}-->
                <!--{%/foreach%}-->
            </td>
        </tr>

        <tr>
            <th>画像</th>
            <td>
                <ul id="image_area">
                <!--{%if array_key_exists('logo_img', $arrShop)%}-->
                <!--{%if $arrShop.logo_img != ''%}-->
                <li class="img_li"><img src="<!--{%$smarty.const.UPLOAD_LOGOIMAGE_PATH%}--><!--{%$arrShop.login_id%}-->/<!--{%$arrShop.logo_img%}-->" width="200"></li>
                <!--{%/if%}-->
                <!--{%/if%}-->
                 </ul>
            </td>
        </tr>
    </table>
    <table class="form">
    	<tr>
            <th>サムネイル画像パス</th>
            <td>
            <!--{%$arrShop.thumbnail%}-->
            </td>
    	</tr>
    	<tr>
            <th>ショップ名</th>
            <td>
            <!--{%$arrShop.pickup_name%}-->
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

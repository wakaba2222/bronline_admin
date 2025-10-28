<form name="point_form" id="point_form" method="post" action="">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="confirm" />
<div id="basis" class="contents-main">
    <table>
        <tr>
            <th>ポイント付与率（初期値）<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="point_rate"%}-->
                    <span class="attention"><!--{%$arrErr.point_rate%}--></span>
                <input type="text" name="arrForm[point_rate]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
                ％　小数点以下切り捨て</td>
        </tr>
        <tr>
            <th>仮ポイント　有効化日数<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="pointtopoint"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[pointtopoint]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
                日後に有効</td>
        </tr>
        <tr>
            <th>第一有効期限お知らせメール<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="send_mail_fast"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                購買後<input type="text" name="arrForm[send_mail_fast]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
                日</td>
        </tr>
        <tr>
            <th>第二有効期限お知らせメール<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="send_mail_last"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                購買後<input type="text" name="arrForm[send_mail_last]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
                日</td>
        </tr>
        <tr>
            <th>ポイント失効日数<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="lost_point"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                購入<input type="text" name="arrForm[lost_point]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
                日後に失効</td>
        </tr>
        <input type="hidden" name="welcome_point" value="0" />
<!--{%*
        <tr>
            <th>会員登録時付与ポイント<span class="attention"> *</span></th>
            <td>
                <!--{%assign var=key value="welcome_point"%}-->
                    <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="arrForm[welcome_point]" value="<!--{%$arrForm[$key]%}-->" maxlength="5" size="6" class="box6" />
            pt</td>
        </tr>
*%}-->
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('point_form', 'confirm', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
</form>

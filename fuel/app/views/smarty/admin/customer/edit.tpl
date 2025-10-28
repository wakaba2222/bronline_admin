<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-addon.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-ja.js"></script>
<link rel="stylesheet" href="/admin_common/css/jquery-ui-timepicker-addon.css">


<script type="text/javascript">
<!--
    function fnReturn() {
		$("#form1").attr("action", "./index.php");
		$("#form1").submit();
        return false;
    }

	function fnConfirm() {
		$("#form1").attr("action", "./confirm.php");
		$("#form1").submit();
	    return false;
	}

    function fnNaviPage(page, mode) {
    	$("#search_page").val(page);
    	$("#mode").val(mode);
    	$("#form1").submit();
        return false;
    }

//-->
</script>

<!--{%*$arrForm|@debug_print_var*%}-->
<!--{%*$arrError|@debug_print_var*%}-->
<form name="form1" id="form1" method="post" action="?" autocomplete="off">
	<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" id="mode" name="mode" value="confirm" />
    <input type="hidden" name="customer_id" value="<!--{%$arrForm['customer_id']%}-->" />

    <!-- 検索条件の保持 -->
    <!--{%foreach $arrSearch as $k => $v%}-->
    	<!--{%if $k|mb_strpos:'search_' === 0%}-->
			<!--{%if is_array($v)%}-->
			    <!--{%foreach $v as $k2 => $v2%}-->
			    <input type="hidden" name="<!--{%$k%}-->[]" value="<!--{%$v2%}-->" />
			    <!--{%/foreach%}-->
			<!--{%else%}-->
			    <input type="hidden" name="<!--{%$k%}-->" value="<!--{%$v%}-->" />
			<!--{%/if%}-->
		<!--{%/if%}-->
	<!--{%/foreach%}-->

    <div id="customer" class="contents-main">
        <table class="form">
            <tr>
                <th>会員ID<span class="attention"> *</span></th>
                <td><!--{%$arrForm['customer_id']%}--></td>
            </tr>
            <tr>
                <th>会員状態<span class="attention"> *</span></th>
                <td>
					<!--{%foreach $arrCustomerStatus as $status %}-->
						<input type="radio"  name="status" value="<!--{%$status['id']%}-->" id="status<!--{%$status['id']%}-->" <!--{%if $status['id'] == $arrForm['status']%}-->checked<!--{%/if%}--> >
						<label for="status<!--{%$status['id']%}-->"><!--{%$status['name']%}--></label>
					<!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>会員ランク</th>
                <td>
                	<select name="rank_name">
                	<!--{%foreach from=$arrCustomerRank key=key item=item%}-->
                	<option value="<!--{%$item.id%}-->" <!--{%if $arrForm['rank_name'] == $item.name%}-->selected<!--{%/if%}-->><!--{%$item.name|upper%}--></option>
                	<!--{%/foreach%}-->
                	</select>
                	<!--{%*
                	<!--{%if array_key_exists('rank_name', $arrForm) %}--><!--{%$arrForm['rank_name']|upper%}--><!--{%/if%}-->
                	<input type="hidden" name="rank_name" value="<!--{%if array_key_exists('rank_name', $arrForm) %}--><!--{%$arrForm['rank_name']%}--><!--{%/if%}-->" />
                	*%}-->
                </td>
            </tr>
            <tr>
                <th>ポイントレート</th>
                <td>
                	<!--{%if array_key_exists('point_rate', $arrForm) %}--><!--{%$arrForm['point_rate']%}--><!--{%/if%}-->%
                	<input type="hidden" name="point_rate" value="<!--{%if array_key_exists('point_rate', $arrForm) %}--><!--{%$arrForm['point_rate']%}--><!--{%/if%}-->" />
                </td>
            </tr>
            <tr>
                <th>セール対象</th>
                <td>
                	<!--{%if array_key_exists('sale_status', $arrForm) %}-->
                	<select name="sale_status">
                		<option value="0" <!--{%if $arrForm.sale_status == 0 %}-->selected<!--{%/if%}-->>通常</option>
                		<option value="1" <!--{%if $arrForm.sale_status == 1 %}-->selected<!--{%/if%}-->>セール</option>
<!--
                		<option value="2" <!--{%if $arrForm.sale_status == 2 %}-->selected<!--{%/if%}-->>VIPシークレットセール対象</option>
-->
                		<option value="-1" <!--{%if $arrForm.sale_status == -1 %}-->selected<!--{%/if%}-->>セール除外</option>
                	</select>
                	<!--{%/if%}-->
                </td>
            </tr>
            <tr>
                <th>お名前<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('name01', $arrError) || array_key_exists('name02', $arrError) %}-->
                    <span class="attention">
					<!--{%if array_key_exists('name01', $arrError) %}--><!--{%$arrError['name01']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('name02', $arrError) %}--><!--{%$arrError['name02']%}--><br><!--{%/if%}-->
					</span>
                    <!--{%/if%}-->
					<input placeholder="姓" type="text" class="col2 ph" name="name01" value="<!--{%if array_key_exists('name01', $arrForm) %}--><!--{%$arrForm['name01']%}--><!--{%/if%}-->" >
					<input placeholder="名" type="text" class="col2 ph" name="name02" value="<!--{%if array_key_exists('name02', $arrForm) %}--><!--{%$arrForm['name02']%}--><!--{%/if%}-->" ></td>
                </td>
            </tr>
            <tr>
                <th>お名前(フリガナ)<span class="attention"> *</span></th>
                <td>
					<!--{%if array_key_exists('kana01', $arrError) || array_key_exists('kana02', $arrError) %}-->
					<span class="attention">
						<!--{%if array_key_exists('kana01', $arrError) %}--><!--{%$arrError['kana01']%}--><br><!--{%/if%}-->
						<!--{%if array_key_exists('kana02', $arrError) %}--><!--{%$arrError['kana02']%}--><br><!--{%/if%}-->
					</span>
					<!--{%/if%}-->
					<input placeholder="セイ" type="text" class="col2 ph" name="kana01" value="<!--{%if array_key_exists('kana01', $arrForm) %}--><!--{%$arrForm['kana01']%}--><!--{%/if%}-->" >
					<input placeholder="メイ" type="text" class="col2 ph" name="kana02" value="<!--{%if array_key_exists('kana02', $arrForm) %}--><!--{%$arrForm['kana02']%}--><!--{%/if%}-->" ></td>
                </td>
            </tr>
            <tr>
                <th>会社名</th>
                <td>
					<!--{%if array_key_exists('company', $arrError) %}-->
					<span class="attention"><!--{%$arrError['company']%}--></span>
					<!--{%/if%}-->
					<input type="text" class="col1 box50" name="company" value="<!--{%if array_key_exists('company', $arrForm) %}--><!--{%$arrForm['company']%}--><!--{%/if%}-->">
                </td>
            </tr>
            <tr>
                <th>部署名</th>
                <td>
					<!--{%if array_key_exists('department', $arrError) %}-->
					<span class="attention"><!--{%$arrError['department']%}--></span>
					<!--{%/if%}-->
					<input type="text" class="col1 box50" name="department" value="<!--{%if array_key_exists('department', $arrForm) %}--><!--{%$arrForm['department']%}--><!--{%/if%}-->">
                </td>
            </tr>
            <tr>
                <th>郵便番号<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('zip01', $arrError) || array_key_exists('zip02', $arrError) %}-->
                    <span class="attention">
					<!--{%if array_key_exists('zip01', $arrError) %}--><!--{%$arrError['zip01']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('zip02', $arrError) %}--><!--{%$arrError['zip02']%}--><br><!--{%/if%}-->
                    </span>
                    <!--{%/if%}-->
                    〒 <input type="text" id="zip1" class="col4 box10" name="zip01" value="<!--{%if array_key_exists('zip01', $arrForm) %}--><!--{%$arrForm['zip01']%}--><!--{%/if%}-->" >
					<input type="text" id="zip2" class="col4 box10" name="zip02" value="<!--{%if array_key_exists('zip02', $arrForm) %}--><!--{%$arrForm['zip02']%}--><!--{%/if%}-->" >
					<input type="button" id="btn" name="btn" value="住所自動入力" class="btn_zip">
					<a href="http://www.post.japanpost.jp/smt-zipcode/" target="_blank" class="search_zip">郵便番号検索</a>
                </td>
            </tr>
            <tr>
                <th>住所<span class="attention"> *</span></th>
                <td>
					<!--{%if array_key_exists('pref', $arrError) || array_key_exists('addr01', $arrError) %}-->
                    <span class="attention">
					<!--{%if array_key_exists('pref', $arrError) %}--><!--{%$arrError['pref']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('addr01', $arrError) %}--><!--{%$arrError['addr01']%}--><br><!--{%/if%}-->
                    </span>
					<!--{%/if%}-->
					<select name="pref" id="address1" class="col1">
						<option disabled selected>都道府県を選択</option>
						<!--{%foreach $arrPref as $pref %}-->
						<option value="<!--{%$pref['id']%}-->" <!--{%if array_key_exists('pref', $arrForm) && $arrForm['pref'] == $pref['id'] %}-->selected<!--{%/if%}-->><!--{%$pref['name']%}--></option>
						<!--{%/foreach%}-->
					</select><br/>
					<input type="text" id="address2" class="col1 mb2 ph box50" name="addr01" placeholder="市区町村・番地" value="<!--{%if array_key_exists('addr01', $arrForm) %}--><!--{%$arrForm['addr01']%}--><!--{%/if%}-->" ><br/>
					<input type="text" class="col1 ph box50" name="addr02" placeholder="ビル/マンション名・部屋番号" value="<!--{%if array_key_exists('addr02', $arrForm) %}--><!--{%$arrForm['addr02']%}--><!--{%/if%}-->" >
                </td>
            </tr>
            <tr>
                <th>電話番号<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('tel01', $arrError) %}-->
                    <span class="attention"><!--{%$arrError['tel01']%}--></span><br>
                    <!--{%/if%}-->
                    <input type="tel" class="col1 ph box30" name="tel01" placeholder="ハイフン無し数字" value="<!--{%if array_key_exists('tel01', $arrForm) %}--><!--{%$arrForm['tel01']%}--><!--{%/if%}-->" >
                </td>
            </tr>
            <tr>
                <th>メールアドレス<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('email', $arrError) %}-->
                    <span class="attention"><!--{%$arrError['email']%}--></span><br>
                    <!--{%/if%}-->
                    <input type="mail" class="col1 mb2 box50" name="email" value="<!--{%if array_key_exists('email', $arrForm) %}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" >
					<input type="hidden" name="email_before" value="<!--{%if array_key_exists('email_before', $arrForm) %}--><!--{%$arrForm['email_before']%}--><!--{%else%}--><!--{%$arrForm['email']%}--><!--{%/if%}-->" ></td>
                </td>
            </tr>
            <tr>
                <th>性別<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('sex', $arrError) %}-->
                    <span class="attention"><!--{%$arrError['sex']%}--></span>
                    <!--{%/if%}-->
                    <!--{%foreach $arrSex as $sex %}-->
						<input type="radio"  name="sex" value="<!--{%$sex['id']%}-->" id="sex<!--{%$sex['id']%}-->" <!--{%if array_key_exists('sex', $arrForm) && $arrForm['sex'] == $sex['id'] %}-->checked<!--{%/if%}--> >
						<label for="sex<!--{%$sex['id']%}-->"><!--{%$sex['name']%}--></label>
                    <!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td>
					<!--{%if array_key_exists('year', $arrError) || array_key_exists('month', $arrError) || array_key_exists('day', $arrError) %}-->
                	<span class="attention">
					<!--{%if array_key_exists('year', $arrError) %}--><!--{%$arrError['year']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('month', $arrError) %}--><!--{%$arrError['month']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('day', $arrError) %}--><!--{%$arrError['day']%}--><!--{%/if%}-->
                    </span>
                    <!--{%/if%}-->
                    <!--{%if !array_key_exists('year', $arrForm) && array_key_exists('birth', $arrForm)%}-->
	                    <!--{%$arrForm['year'] = $arrForm['birth']|date_format:"%Y"%}-->
	                    <!--{%$arrForm['month'] = $arrForm['birth']|date_format:"%m"%}-->
	                    <!--{%$arrForm['day'] = $arrForm['birth']|date_format:"%d"%}-->
                    <!--{%/if%}-->
					<select name="year" class="col1">
						<option disabled selected>----</option>
						<!--{%for $y=1900 to 2030%}-->
						<option value="<!--{%$y%}-->" <!--{%if array_key_exists('year', $arrForm) && $arrForm['year'] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
						<!--{%/for%}-->
					</select>年　
					<select name="month" class="col1">
						<option disabled selected>--</option>
						<!--{%for $m=1 to 12%}-->
						<option value="<!--{%$m%}-->" <!--{%if array_key_exists('month', $arrForm) && $arrForm['month'] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
						<!--{%/for%}-->　
					</select>月　　
					<select name="day" class="col1">
						<option disabled selected>--</option>
						<!--{%for $d=1 to 31%}-->
						<option value="<!--{%$d%}-->" <!--{%if array_key_exists('day', $arrForm) && $arrForm['day'] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
						<!--{%/for%}-->
					</select>日
                </td>
            </tr>
            <tr>
                <th>パスワード<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('password', $arrError) || array_key_exists('password2', $arrError) %}-->
                    <span class="attention">
					<!--{%if array_key_exists('password', $arrError) %}--><!--{%$arrError['password']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('password2', $arrError) %}--><!--{%$arrError['password2']%}--><br><!--{%/if%}-->
					</span>
                    <!--{%/if%}-->
					<input type="password" placeholder="変更希望の場合のみご入力ください（８桁以上の半角英数）"class="col1 mb2 ph box50" name="password" value="<!--{%if array_key_exists('password', $arrForm) %}--><!--{%$arrForm['password']%}--><!--{%/if%}-->" ><br/>
					<input type="password" placeholder="８桁以上の半角英数（再入力）" class="col1 ph box50" name="password2" value="<!--{%if array_key_exists('password2', $arrForm) %}--><!--{%$arrForm['password2']%}--><!--{%/if%}-->" ></td>
                </td>
            </tr>
            <tr>
                <th>パスワードを忘れたときのヒント<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('reminder', $arrError) || array_key_exists('reminder_answer', $arrError) %}-->
                    <span class="attention">
					<!--{%if array_key_exists('reminder', $arrError) %}--><!--{%$arrError['reminder']%}--><br><!--{%/if%}-->
					<!--{%if array_key_exists('reminder_answer', $arrError) %}--><!--{%$arrError['reminder_answer']%}--><br><!--{%/if%}-->
					</span>
					<!--{%/if%}-->
                    質問：
					<select name="reminder" id="reminder" class="col1">
						<option disabled selected>質問を選択</option>
						<!--{%foreach $arrReminder as $reminder %}-->
						<option value="<!--{%$reminder['id']%}-->" <!--{%if array_key_exists('reminder', $arrForm) && $arrForm['reminder'] == $reminder['id'] %}-->selected<!--{%/if%}-->><!--{%$reminder['name']%}--></option>
						<!--{%/foreach%}-->
					</select><br/>
                    答え：
                    <input type="text" id="reminder_answer" class="col1 mb2 ph box50" name="reminder_answer" placeholder="変更希望の場合のみご入力ください" value="<!--{%if array_key_exists('reminder_answer', $arrForm) %}--><!--{%$arrForm['reminder_answer']%}--><!--{%/if%}-->" >
                </td>
            </tr>
            <tr>
                <th>メールマガジン<span class="attention"> *</span></th>
                <td>
                	<!--{%if array_key_exists('mailmaga_flg', $arrError) %}-->
                    <span class="attention"><!--{%$arrError['mailmaga_flg']%}--></span><br>
                    <!--{%/if%}-->
					<!--{%foreach $arrMagazineType as $type %}-->
						<input type="radio" name="mailmaga_flg" value="<!--{%$type['id']%}-->" id="magazinetype<!--{%$type['id']%}-->" <!--{%if array_key_exists('mailmaga_flg', $arrForm) && $arrForm['mailmaga_flg'] == $type['id'] %}-->checked<!--{%/if%}--> >
						<label for="magazinetype<!--{%$type['id']%}-->"><!--{%$type['name']%}--></label>
					<!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>SHOP用メモ</th>
                <td>
                	<!--{%if array_key_exists('note', $arrError) %}-->
                    <span class="attention"><!--{%$arrError['note']%}--></span><br>
                    <!--{%/if%}-->
                    <textarea name="note" cols="60" rows="8" class="area60"><!--{%if array_key_exists('note', $arrForm) %}--><!--{%$arrForm['note']%}--><!--{%/if%}--></textarea>
                </td>
            </tr>
            <tr>
                <th>所持ポイント<span class="attention"> *</span></th>
                <td>
					<!--{%if array_key_exists('point', $arrError) %}-->
					<span class="attention"><!--{%$arrError['point']%}--></span>
					<!--{%/if%}-->
                    <input type="text" name="point" value="<!--{%if array_key_exists('point', $arrForm) %}--><!--{%$arrForm['point']|default:0%}--><!--{%else%}-->0<!--{%/if%}-->" maxlength="" size="6" class="box6" /> pt
                    <input type="hidden" name="oldpoint" value="<!--{%if array_key_exists('oldpoint', $arrForm) %}--><!--{%$arrForm['oldpoint']|default:0%}--><!--{%else%}--><!--{%$arrForm['point']|default:0%}--><!--{%/if%}-->"  />
                </td>
            </tr>
            <tr>
                <th>最終購入日</th>
                <td>
					<!--{%if array_key_exists('last_buy_date', $arrError) %}-->
					<span class="attention"><!--{%$arrError['last_buy_date']%}--></span>
					<!--{%/if%}-->
					<input type="text" class="col1 box50" name="last_buy_date" value="<!--{%if array_key_exists('last_buy_date', $arrForm) %}--><!--{%$arrForm['last_buy_date']%}--><!--{%/if%}-->">
					<br><span class="attention">※所持ポイントを手動で変更する場合に最終購入日から1年以上経過していた場合リセットされるため、一緒に変更してください。</span>
                </td>
            </tr>
        </table>

        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="return fnReturn();"><span class="btn-prev">検索画面に戻る</span></a></li>
                <li><a class="btn-action" href="javascript:;" onclick="fnConfirm(); return false;"><span class="btn-next">確認ページへ</span></a></li>
            </ul>
        </div>


<script>
function point_add()
{
	if ($('.point_mode').prop('checked') == true)
	{
		if ($('#price').val() == '')
		{
			alert('金額を入力してください。');
			return false;
		}
		if ($('#price').val() == '0')
		{
			alert('金額を0以上で入力してください。');
			return false;
		}
	}
	else
	{
		if ($('#add_point').val() == '')
		{
			alert('ポイントを入力してください。');
			return false;
		}
		if ($('#add_point').val() == '0')
		{
			alert('ポイントを0以上で入力してください。');
			return false;
		}
	}
	if ($('#create_date').val() == '')
	{
		alert('購入日を入力してください。');
		return false;
	}
	$('#mode').val('point_add');
	$('#form1').submit();
}

function point_delete(id, point, del_date)
{
	if (confirm('仮ポイントを削除します。よろしいですか？'))
	{
		$('#mode').val('point_delete');
		$('#del_id').val(id);
		$('#del_point').val(point);
		$('#del_date').val(del_date);
		$('#form1').submit();
	}
	else
		return false;
}
function leaveOnlyNumber(e){
  // 数字以外の不要な文字を削除
  var st = String.fromCharCode(e.which);
  if ("0123456789".indexOf(st,0) < 0) { return false; }
  return true;  
}

$(function(){
	$('.datetimepicker').datetimepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:1,
		showOtherMonths: true,
		showOn: "both",
		buttonText: "カレンダーを表示",
		timeFormat: "HH:mm",
		stepMinute: 1,
	});

	$('#price').on("keypress", function(event){return leaveOnlyNumber(event);});
	$('#add_point').on("keypress", function(event){return leaveOnlyNumber(event);});

	$('.point_mode').change(function(){
		console.log($(this).val());
		if ($(this).val() == 1)
		{
			$('#price').attr('readonly', false);
			$('#add_point').val('');
			$('#add_point').attr('readonly', true);
		}
		else
		{
			$('#price').val('');
			$('#price').attr('readonly', true);
			$('#add_point').attr('readonly', false);
		}
	});
	
	$('#price').attr('readonly', false);
	$('#add_point').attr('readonly', true);
});
</script>


        <h2>ポイントログ履歴</h2>
<p style="margin:20px auto;">
	購入日：<input type="text" name="create_date" id="create_date" class="datetimepicker" value="" />
	<input type="radio" class="point_mode" name="point_mode" value="1" checked />購入金額(税込)：<input type="text" name="price" id="price" value="" />
	<input type="radio" class="point_mode" name="point_mode" value="2" />ポイント数：<input type="text" name="add_point" id="add_point" value="" />
	<input type="hidden" name="del_id" id="del_id" value="" />
	<input type="hidden" name="del_point" id="del_point" value="" />
	<input type="hidden" name="del_date" id="del_date" value="" />
    <button type="button" onclick="javascript:point_add();">ポイント追加</button>
</p>
        <p>有効ポイント： <!--{%$arrForm['point']|default:0|number_format%}-->pt　／　仮ポイント： <!--{%$tempPoint|default:0|number_format%}-->pt</p>
		<div style="overflow-y:auto;max-height:300px;">
        <table class="list">
            <tr>
                <th width="30%">日付</th>
                <th width="20%">受注番号</th>
                <th width="30%">ステータス</th>
                <th width="20%">ポイント</th>
            </tr>
            <!--{%foreach $arrPointHistory as $pointHistory%}-->
                <tr>
                    <td><!--{%$pointHistory['create_date']|date_format:'%Y/%m/%d %H:%M:%S'%}--></td>
                    <td style="text-align:center;"><!--{%$pointHistory['order_id']%}--></td>
                    <td class="center"><!--{%$pointHistory['status_name']%}--></td>
                    <td class="center"><!--{%$pointHistory['point']%}-->
                    <!--{%if $pointHistory['order_id'] == 0 && $pointHistory['status'] == '9' && $pointHistory['del_id'] == '0'%}-->
                    <span><button type="button" onclick="javascript:point_delete('<!--{%$pointHistory['id']%}-->', '<!--{%$pointHistory['point']%}-->', '<!--{%$pointHistory['create_date']%}-->');">削除</button></span>
                    <!--{%/if%}-->
                    </td>
                </tr>
            <!--{%/foreach%}-->
        </table>
        </div>



        <input type="hidden" name="order_id" value="" />
        <input type="hidden" id="search_page" name="search_page" value="<!--{%$page|default:1%}-->">
        <input type="hidden" name="edit_customer_id" value="<!--{%$arrForm['customer_id']%}-->" >

        <h2>購入履歴一覧</h2>
        <p style="margin:20px auto;">前回更新時　合計金額（発送済み）<!--{%$payment_total_prev[0].total|default:"0"|number_format%}-->円</p>
        <p style="margin:20px auto;">ランク更新前　合計購入金額（発送済み）<!--{%$payment_total[0].total|default:"0"|number_format%}-->円<br><!--{%$payment_total_update%}--></p>
        <!--{%if 0 < count($arrPurchaseHistory)%}-->
	        <p><span class="attention"><!--購入履歴一覧--><!--{%$maxRecordNum%}-->件</span>&nbsp;が該当しました。</p>

			<!--{%* ★ ページャここから ★ *%}-->
			<div class="pager">
			    <ul>
				<!--{%for $p=1 to $maxPageNum %}-->
					<li<!--{%if $p == $pageNum%}--> class="on"<!--{%/if%}-->><a href="#" onclick="fnNaviPage(<!--{%$p%}-->, 'page'); return false;"><span><!--{%$p%}--></span></a></li>
				<!--{%/for%}-->
			    </ul>
			</div>
			<!--{%* ★ ページャここまで ★ *%}-->

            <!--{* 購入履歴一覧表示テーブル *}-->
            <table class="list">
                <tr>
                    <th>日付</th>
                    <th>注文番号</th>
                    <th>対応状況</th>
                    <th>購入金額</th>
                    <th>発送日</th>
                    <th>支払方法</th>
                </tr>
                <!--{%foreach $arrPurchaseHistory as $purchaseHistory%}-->
                <!--{%assign var=status_id value="`$purchaseHistory['status']`"%}-->
		        <tr style="background:<!--{%$arrORDERSTATUS_COLOR[$status_id]%}-->;">

                        <td><!--{%$purchaseHistory['create_date']|date_format:'%Y/%m/%d %H:%M:%S'%}--></td>
                        <td class="center"><a href="../order/edit.php?order_id=<!--{%$purchaseHistory['order_id']%}-->" ><!--{%$purchaseHistory['order_id']%}--></a></td>
			            <td class="center"><!--{%$arrORDERSTATUS[$status_id]%}--></td>
                        <td class="center"><!--{%$purchaseHistory['payment_total']|number_format%}-->円</td>
                        <td class="center"><!--{%if $purchaseHistory['send_date'] != ""%}--><!--{%$purchaseHistory['send_date']|date_format:'%Y/%m/%d %H:%M:%S'%}--><!--{%else%}-->未発送<!--{%/if%}--></td>
                        <td class="center"><!--{%$purchaseHistory['payment_name']%}--></td>
                    </tr>
                <!--{%/foreach%}-->
            </table>
            <!--{* 購入履歴一覧表示テーブル *}-->
        <!--{%else%}-->
            <div class="message">購入履歴はありません。</div>
        <!--{%/if%}-->

    </div>
</form>

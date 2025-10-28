<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-addon.js"></script>
<script src="/admin_common/js/jquery-ui-timepicker-ja.js"></script>
<link rel="stylesheet" href="/admin_common/css/jquery-ui-timepicker-addon.css">

<script src="/admin_common/js/datepicker-ja.js"></script>
<style>
.pager
{
    margin:10px auto;
}
.pager a
{
   padding:5px;
}
.pager a.active
{
    font-weight:bold;
    background-color:black;
    color:white!important;
    padding:5px;
}
</style>
<script type="text/javascript">
<!--
    function fnSelectCheckSubmit(action){

        var fm = document.form1;

        if (!fm["pdf_order_id[]"]) {
            return false;
        }

        var checkflag = false;
        var max = fm["pdf_order_id[]"].length;

        if (max) {
            for (var i=0; i<max; i++) {
                if(fm["pdf_order_id[]"][i].checked == true){
                    checkflag = true;
                }
            }
        } else {
            if(fm["pdf_order_id[]"].checked == true) {
                checkflag = true;
            }
        }

        if(!checkflag){
            alert('チェックボックスが選択されていません');
            return false;
        }

        fnOpenPdfSettingPage(action);
    }

    function fnOpenPdfSettingPage(action){
        var fm = document.form1;
        win02("about:blank", "pdf_input", "620","650");

        // 退避
        tmpTarget = fm.target;
        tmpMode = fm.mode.value;
        tmpAction = fm.action;

        fm.target = "pdf_input";
        fm.mode.value = 'pdf';
        fm.action = action;
        fm.submit();

        // 復元
        fm.target = tmpTarget;
        fm.mode.value = tmpMode;
        fm.action = tmpAction;
    }


    function fnSelectMailCheckSubmit(action){

        var fm = document.form1;

        if (!fm["mail_order_id[]"]) {
            return false;
        }

        var checkflag = false;
        var max = fm["mail_order_id[]"].length;

        if (max) {
            for (var i=0; i<max; i++) {
                if(fm["mail_order_id[]"][i].checked == true){
                    checkflag = true;
                }
            }
        } else {
            if(fm["mail_order_id[]"].checked == true) {
                checkflag = true;
            }
        }

        if(!checkflag){
            alert('チェックボックスが選択されていません');
            return false;
        }

        fm.mode.value="mail_select";
        fm.action=action;
        fm.submit();
    }


    function fnNumberCsvSubmit(){

/*
    	var flgChk = false;
    	$('.status_order_id').each(function ( index, element ) {
			if( $(element).prop('checked') ) {
    			flgChk = true;
    		}
    	});

    	if( !flgChk ) {
            alert('チェックボックスが選択されていません');
            return false;
    	}
    	if( $('#status_change').val() == "" ) {
            alert('変更するステータスが選択されていません');
            return false;
    	}
		$('#status_change').val('5');
*/

    	if( confirm('伝票番号取込を行って宜しいですか？')) {
    		$('#form1').attr('action', '/admin/order/numbercsv');
    		$("#form1").submit();
    	}

		return false;
    }

    function fnSelectStatusCheckSubmit(){

    	var flgChk = false;
    	$('.status_order_id').each(function ( index, element ) {
			if( $(element).prop('checked') ) {
    			flgChk = true;
    		}
    	});

    	if( !flgChk ) {
            alert('チェックボックスが選択されていません');
            return false;
    	}

    	if( $('#status_change').val() == "" ) {
            alert('変更するステータスが選択されていません');
            return false;
    	}

    	if( confirm('ステータス変更を行って宜しいですか？')) {
    		$('#form1').attr('action', '/admin/order/changestatus');
    		$("#form1").submit();
    	}

		return false;
    }



    function fnAllCheck( chk, target ) {
    	$('.'+target).prop('checked', $('#'+chk.id).prop('checked'));
    }


	function number_check()
	{
		if ($('#number_csv').val() != '')
		{
			$('#number_action').css('display','inline-block');
		}
		else
		{
			$('#number_action').css('display','none');
		}
	}
$(function(){
	$('.datetimepicker').datetimepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
		numberOfMonths:1,
		showOtherMonths: true,
		selectOtherMonths: true,
		showOn: "both",
		buttonText: "カレンダーを表示",
		timeFormat: "HH:mm",
		stepMinute: 1,
		defaultDate: ""
	});
	<!--{%if $arrForm['search_order_date'].value == ''%}-->
	$('.datetimepicker').val('');
	<!--{%/if%}-->
});
//-->
</script>
<div id="order" class="contents-main">
<form name="search_form" id="search_form" method="post" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="search" />
    <h2>検索条件設定</h2>
    <!--{%* 検索条件設定テーブルここから *%}-->
    <table>
        <tr>
            <th>注文番号</th>
            <td>
                <!--{%assign var=key1 value="search_order_id1"%}-->
                <!--{%assign var=key2 value="search_order_id2"%}-->
                <span class="attention"><!--{%$arrErr[$key1]%}--></span>
                <span class="attention"><!--{%$arrErr[$key2]%}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1].value|h%}-->" maxlength="<!--{%$arrForm[$key1].length%}-->" size="6" class="box6" />
                ～
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2].value|h%}-->" maxlength="<!--{%$arrForm[$key2].length%}-->" size="6" class="box6" />
            </td>
            <th>対応状況</th>
            <td>
                <!--{%assign var=key value="search_order_status"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <select name="<!--{%$key%}-->">
                <option value="">選択してください</option>
                <!--{%html_options options=$arrORDERSTATUS selected=$arrForm[$key].value%}-->
                </select><br/>
                <!--{%assign var=key value="search_send_status"%}-->
                <label><input type="radio" name="search_send_status" value="0" <!--{%if $arrForm[$key].value == '0'%}-->checked<!--{%/if%}--> />発送済み表示</label><br/>
                <label><input type="radio" name="search_send_status" value="1" <!--{%if $arrForm[$key].value == '1'%}-->checked<!--{%/if%}--> />発送済み非表示</label><br/>
            </td>
        </tr>
        <tr>
            <th>お名前[注文者名]</th>
            <td>
            <!--{%assign var=key value="search_order_name"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
            <th>お名前(フリガナ)[注文者名]</th>
            <td>
            <!--{%assign var=key value="search_order_kana"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
        </tr>
        <tr>
            <th>お名前[お届け先名]</th>
            <td>
            <!--{%assign var=key value="search_shipping_name"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
            <th>お名前(フリガナ)[お届け先名]</th>
            <td>
            <!--{%assign var=key value="search_shipping_kana"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>
                <!--{%assign var=key value="search_order_email"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
            <th>TEL</th>
            <td>
                <!--{%assign var=key value="search_order_tel"%}-->
                <span class="attention"><!--{%$arrErr[$key]%}--></span>
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="30" class="box30" />
            </td>
        </tr>
<!--{%*
        <tr>
            <th>生年月日</th>
            <td colspan="3">
                <span class="attention"><!--{%$arrErr.search_sbirthyear%}--></span>
                <span class="attention"><!--{%$arrErr.search_ebirthyear%}--></span>
                <select name="search_sbirthyear">
                <option value="">----</option>
                <!--{%html_options options=$arrBirthYear selected=$arrForm.search_sbirthyear.value%}-->
                </select>年
                <select name="search_sbirthmonth" >
                <option value="">--</option>
                <!--{%html_options options=$arrMonth selected=$arrForm.search_sbirthmonth.value%}-->
                </select>月
                <select name="search_sbirthday" >
                <option value="">--</option>
                <!--{%html_options options=$arrDay selected=$arrForm.search_sbirthday.value%}-->
                </select>日～
                <select name="search_ebirthyear">
                <option value="">----</option>
                <!--{%html_options options=$arrBirthYear selected=$arrForm.search_ebirthyear.value%}-->
                </select>年
                <select name="search_ebirthmonth">
                <option value="">--</option>
                <!--{%html_options options=$arrMonth selected=$arrForm.search_ebirthmonth.value%}-->
                </select>月
                <select name="search_ebirthday">
                <option value="">--</option>
                <!--{%html_options options=$arrDay selected=$arrForm.search_ebirthday.value%}-->
                </select>日
            </td>
        </tr>
        <tr>
            <th>性別</th>
            <td colspan="3">
            <!--{%assign var=key value="search_order_sex"%}-->
            <span class="attention"><!--{%$arrErr[$key]%}--></span>
            <!--{%html_checkboxes name="$key" options=$arrSex selected=$arrForm[$key].value%}-->
            </td>
        </tr>
*%}-->
        <tr>
            <th>支払方法</th>
            <td colspan="3">
            <!--{%assign var=key value="search_payment_id"%}-->
            <span class="attention"><!--{%$arrErr[$key]|h%}--></span>
            <!--{%html_checkboxes name="$key" options=$arrPayments selected=$arrForm[$key].value%}-->
            </td>
        </tr>
        <tr>
            <th>受注日</th>
            <td colspan="3">
                <select name="search_sorderyear">
                <option value="">----</option>
                <!--{%html_options options=$arrRegistYear selected=$arrForm.search_sorderyear.value%}-->
                </select>年
                <select name="search_sordermonth">
                <option value="">--</option>
                <!--{%html_options options=$arrMonth selected=$arrForm.search_sordermonth.value%}-->
                </select>月
                <select name="search_sorderday">
                <option value="">--</option>
                <!--{%html_options options=$arrDay selected=$arrForm.search_sorderday.value%}-->
                </select>日～
                <select name="search_eorderyear">
                <option value="">----</option>
                <!--{%html_options options=$arrRegistYear selected=$arrForm.search_eorderyear.value%}-->
                </select>年
                <select name="search_eordermonth">
                <option value="">--</option>
                <!--{%html_options options=$arrMonth selected=$arrForm.search_eordermonth.value%}-->
                </select>月
                <select name="search_eorderday">
                <option value="">--</option>
                <!--{%html_options options=$arrDay selected=$arrForm.search_eorderday.value%}-->
                </select>日
            </td>
        </tr>
        <tr>
            <th>受注日(売上確定用)<br><span class="attention">※受注日より優先されます</span></th>
            <td colspan="3">
                <input type="text" name="search_order_date" value="<!--{%$arrForm.search_order_date.value|default:""|date_format:"%Y-%m-%d %H:%M"%}-->" maxlength="85" size="60" class="box60 datetimepicker" />　以降を検索
            </td>
        </tr>
<!--{%*
        <tr>
            <th>更新日</th>
            <td colspan="3">
                <!--{%if $arrErr.search_supdateyear%}--><span class="attention"><!--{%$arrErr.search_supdateyear%}--></span><!--{%/if%}-->
                <!--{%if $arrErr.search_eupdateyear%}--><span class="attention"><!--{%$arrErr.search_eupdateyear%}--></span><!--{%/if%}-->
                <select name="search_supdateyear">
                    <option value="">----</option>
                    <!--{%html_options options=$arrRegistYear selected=$arrForm.search_supdateyear.value%}-->
                </select>年
                <select name="search_supdatemonth">
                    <option value="">--</option>
                    <!--{%html_options options=$arrMonth selected=$arrForm.search_supdatemonth.value%}-->
                </select>月
                <select name="search_supdateday">
                    <option value="">--</option>
                    <!--{%html_options options=$arrDay selected=$arrForm.search_supdateday.value%}-->
                </select>日～
                <select name="search_eupdateyear">
                    <option value="">----</option>
                    <!--{%html_options options=$arrRegistYear selected=$arrForm.search_eupdateyear.value%}-->
                </select>年
                <select name="search_eupdatemonth">
                    <option value="">--</option>
                    <!--{%html_options options=$arrMonth selected=$arrForm.search_eupdatemonth.value%}-->
                </select>月
                <select name="search_eupdateday">
                    <option value="">--</option>
                    <!--{%html_options options=$arrDay selected=$arrForm.search_eupdateday.value%}-->
                </select>日
            </td>
        </tr>
*%}-->
        <tr>
            <th>購入金額(税込)</th>
            <td>
                <!--{%assign var=key1 value="search_total1"%}-->
                <!--{%assign var=key2 value="search_total2"%}-->
                <span class="attention"><!--{%$arrErr[$key1]%}--></span>
                <span class="attention"><!--{%$arrErr[$key2]%}--></span>
                <input type="text" name="<!--{%$key1%}-->" value="<!--{%$arrForm[$key1].value|h%}-->" maxlength="<!--{%$arrForm[$key1].length%}-->" size="6" class="box6" />
                円 ～
                <input type="text" name="<!--{%$key2%}-->" value="<!--{%$arrForm[$key2].value|h%}-->" maxlength="<!--{%$arrForm[$key2].length%}-->" size="6" class="box6" />
                円
            </td>
            <th>購入商品</th>
            <td>
                <!--{%assign var=key value="search_product_name"%}-->
                <input type="text" name="<!--{%$key%}-->" value="<!--{%$arrForm[$key].value|h%}-->" maxlength="<!--{%$arrForm[$key].length%}-->" size="6" class="box30" />
            </td>
        </tr>
    </table>
    <div class="btn">
<!--%*
        <p class="page_rows">検索結果表示件数
        <!--{%assign var=key value="search_page_max"%}-->
        <span class="attention"><!--{%$arrErr[$key]%}--></span>
        <select name="<!--{%$arrForm[$key].keyname%}-->">
        <!--{%html_options options=$arrPageMax selected=$arrForm[$key].value%}-->
        </select> 件</p>
*%}-->
        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'search', '', ''); return false;"><span class="btn-next">この条件で検索する</span></a></li>
            </ul>
        </div>
    </div>
    <!--検索条件設定テーブルここまで-->
</form>

<!--{%*
<!--{%if count($arrErr) == 0 and ($smarty.post.mode == 'search' or $smarty.post.mode == 'delete')%}-->
<!--{%if count($arrErr) == 0 and ($smarty.post.mode == 'search' or $smarty.post.mode == 'delete' or $modes == 'def')%}-->
*%}-->

<!--%*
<table>
	<tr>
		<!--{%foreach key=key item=item from=$arrORDERSTATUS%}-->
		<th style="font-size:0.6rem;"><!--{%$item%}--></th>
		<td style="background-color:<!--{%$arrORDERSTATUS_COLOR[$key]%}-->;">　</td>
		<!--{%/foreach%}-->
	</tr>
</table>
*%}-->

<!--★★検索結果一覧★★-->
<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" id="mode" name="mode" value="search" />
<input type="hidden" name="order_id" value="" />
<!--{%foreach key=key item=item from=$arrHidden%}-->
    <!--{%if is_array($item)%}-->
        <!--{%foreach item=c_item from=$item%}-->
        <input type="hidden" name="<!--{%$key|h%}-->[]" value="<!--{%$c_item|h%}-->" />
        <!--{%/foreach%}-->
    <!--{%else%}-->
        <input type="hidden" name="<!--{%$key|h%}-->" value="<!--{%$item|h%}-->" />
    <!--{%/if%}-->
<!--{%/foreach%}-->
    <h2>検索結果一覧</h2>
        <div class="btn">
        <span class="attention"><!--検索結果数--><!--{%$count%}-->件</span>&nbsp;が該当しました。
        <!--{%if $smarty.const.ADMIN_MODE == '1'%}-->
        <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('delete_all','',''); return false;"><span>検索結果をすべて削除</span></a>
        <!--{%/if%}-->
<!--{%if $smarty.SESSION.authority == 0%}-->
        <a class="btn-normal" href="javascript:;" onclick="fnSelectCheckSubmit('/admin/pdf.php'); return false;"><span>納品書一括出力</span></a>｜
        <a class="btn-normal" href="javascript:;" onclick="fnSelectCheckSubmit('/admin/pdf.php?type=1'); return false;"><span>注文書一括出力</span></a>｜
        <a class="btn-normal" href="javascript:;" onclick="fnSelectCheckSubmit('/admin/pdf.php?type=2'); return false;"><span>領収書一括出力</span></a>｜
<!--{%/if%}-->
<!--{%if $smarty.SESSION.authority == 0%}-->
        <a class="btn-normal" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'csv4','',''); return false;">売上確定CSV</a>｜
        <a class="btn-normal" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'csv2','',''); return false;">受注毎CSV</a>｜
        <a class="btn-normal" href="javascript:;" onclick="fnFormModeSubmit('search_form', 'csv3','',''); return false;">ヤマト伝票CSV</a>｜
<!--{%/if%}-->
        <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('csv','',''); return false;">受注CSV</a>｜
<!--{%if $smarty.SESSION.authority == 0%}-->
        <a class="btn-normal" href="javascript:;" onclick="copyToClipboard(); return false;">売上受注番号</a>｜
    <script>
        function copyToClipboard() {
            // コピー対象をJavaScript上で変数として定義する
            var copyTarget = document.getElementById("copyTarget");

            // コピー対象のテキストを選択する
            copyTarget.select();

            // 選択しているテキストをクリップボードにコピーする
            document.execCommand("Copy");

            // コピーをお知らせする
            alert("コピーできました！ : \n" + copyTarget.value);
        }
    </script>
<!--{%/if%}-->
<!--{%*

        <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('csv2','',''); return false;">CSV ダウンロード(受注毎)</a>
        <a class="btn-normal" href="javascript:;" onclick="fnSelectCheckSubmit('pdf.php'); return false;"><span>PDF一括出力</span></a>
        <a class="btn-normal" href="javascript:;" onclick="fnSelectMailCheckSubmit('mail.php'); return false;"><span>メール一括通知</span></a>
*%}-->
	<!--{%if $smarty.SESSION.authority == 0%}-->
<br><br>        <select id="status_change" name="status_change">
        <option value="">選択してください</option>
        <!--{%foreach $arrORDERSTATUS as $k => $v%}-->
        <!--{%if $k != 3%}-->
        <option value="<!--{%$k%}-->"><!--{%$v%}--></option>
        <!--{%/if%}-->
        <!--{%/foreach%}-->
        </select>
        <a class="btn-normal" href="javascript:;" onclick="fnSelectStatusCheckSubmit(); return false;"><span>ステータス一括変更</span></a>｜
        
       メール一括送信CSVを選択：<input type="file" name="number_csv" id="number_csv" onchange="number_check()" />
        <a class="btn-normal" href="javascript:;" id="number_action" onclick="fnNumberCsvSubmit(); return false;" style="display:none;"><span>メール一括送信(CSV)</span></a>
        
    </div>
    <!--{%/if%}-->
    <!--{%if count($arrResults) > 0%}-->

<!--{%if $csvx%}-->
<textarea id="copyTarget" readonly style="height:0px;width:0px;padding:0;margin:0;">
<!--{%foreach $ret_csvx as $c%}-->
<!--{%$c%}-->
<!--{%/foreach%}-->
</textarea>
<!--{%/if%}-->

    <!--{%*include file=$tpl_pager*%}-->

    <div class="pager">
        <a href="/admin/order?page=1">先頭</a>
		<!--{%section name=cnt loop=$max%}-->
		<!--{%if $pstart <= $smarty.section.cnt.iteration && $pend >= $smarty.section.cnt.iteration%}-->
		<a <!--{%if $page == $smarty.section.cnt.iteration%}-->class="active"<!--{%/if%}--> href="/admin/order?page=<!--{%$smarty.section.cnt.iteration%}-->"><!--{%$smarty.section.cnt.iteration%}--></a>
		<!--{%/if%}-->
		<!--{%/section%}-->
        <a href="/admin/order?page=<!--{%$max%}-->">最後</a>
    </div>
    <!--{%if count($arrResults) > 0%}-->

    <!--{%* 検索結果表示テーブル *%}-->
        <table class="list">
        <col width="10%" />
        <col width="8%" />
        <col width="15%" />
        <col width="8%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="5%" />
        <col width="9%" />
        <col width="5%" />
        <tr>
            <th>受注日</th>
            <th>注文番号</th>
<!--{%if $smarty.SESSION.authority == 0%}-->
            <th>お名前</th>
            <th>メールアドレス</th>
<!--{%/if%}-->
            <th>支払方法</th>
            <th>購入金額(円)</th>
            <th>支払金額(円)</th>
            <th>全商品発送日</th>
<!--{%if $smarty.SESSION.authority == 0%}-->
            <th>対応状況
			<input type="checkbox" name="status_check" id="status_check" onclick="fnAllCheck(this, 'status_order_id')" />
			</th>

            <th><label for="pdf_check">帳票</label>
<!--			<input type="checkbox" name="pdf_check" id="pdf_check" onclick="fnAllCheck(this, 'input[name=pdf_order_id[]]')" /> -->
			<input type="checkbox" name="pdf_check" id="pdf_check" onclick="fnAllCheck(this, 'pdf_order_id')" />
			</th>
<!--{%/if%}-->
            <th>編集</th>
            <!--{%if $smarty.SESSION.authority == 0%}-->
            <th>個別通知</th>
            <!--{%/if%}-->
<!--{%*
            <th>メール
            <input type="checkbox" name="mail_check" id="mail_check" onclick="fnAllCheck(this, 'input[name=mail_order_id[]]')" />
            </th>
            <th>削除</th>
*%}-->
        </tr>

        <!--{%section name=cnt loop=$arrResults%}-->
        <!--{%assign var=status value="`$arrResults[cnt].status`"%}-->
        <!--{%if $arrResults[cnt].status == 1 && $arrResults[cnt].reservation_flg == 1%}-->
        <tr style="background:#ede3f2;">
        <!--{%elseif $arrResults[cnt].status == 1 && $arrResults[cnt].reservation_flg == 2%}-->
        <tr style="background:#f8e5f1;">
        <!--{%else%}-->
        <tr style="background:<!--{%$arrORDERSTATUS_COLOR[$status]%}-->;">
        <!--{%/if%}-->
            <td class="center"><!--{%$arrResults[cnt].create_date%}--></td>
            <td class="center"><!--{%$arrResults[cnt].order_id%}-->
	        <!--{%if $arrResults[cnt].reservation_flg == 1%}-->
	        <br>受注生産商品
	        <!--{%elseif $arrResults[cnt].reservation_flg == 2%}-->
	        <br>予約商品
	        <!--{%/if%}-->
            </td>
<!--{%if $smarty.SESSION.authority == 0%}-->
            <td>
            <!--{%$arrResults[cnt].name01|h%}--> <!--{%$arrResults[cnt].name02|h%}--><br>
            <!--{%$arrResults[cnt].kana01|h%}--> <!--{%$arrResults[cnt].kana02|h%}-->
            </td>
            <td>
            <!--{%if $arrResults[cnt].email%}-->
            <!--{%$arrResults[cnt].email|h%}-->
            <!--{%else%}-->
            <!--{%$arrResults[cnt].customer_email|h%}-->
            <!--{%/if%}-->
            </td>
<!--{%/if%}-->
            <!--{%assign var=payment_id value="`$arrResults[cnt].payment_id`"%}-->
            <td class="center"><!--{%$arrPayments[$payment_id]%}--></td>
<!--{%if $shop == 'brshop'%}-->
            <td class="right"><!--{%$arrResults[cnt].payment_total+$arrResults[cnt].use_point|number_format%}--></td>
            <td class="right"><!--{%(Tag_Util::taxin_cal($arrResults[cnt].gift_price+$arrResults[cnt].total+$arrResults[cnt].fee+$arrResults[cnt].deliv_fee)-$arrResults[cnt].use_point)-$arrResults[cnt].discount|number_format%}--></td>
<!--{%else%}-->
			<!--{%assign var=oid value="`$arrResults[cnt].order_id`"%}-->
            <td class="right"><!--{%$arrShopResult[$oid]|number_format%}--></td>
            <td class="right"><!--{%$arrShopResult[$oid]|number_format%}--></td>
<!--{%/if%}-->
            <td class="center"><!--{%$arrResults[cnt].send_date|default:"未発送"%}--></td>
<!--{%if $smarty.SESSION.authority == 0%}-->
            <td class="center"><!--{%$arrORDERSTATUS[$status]%}-->
            <!--{%if $status != 3 && $status != 7%}-->
            <br><input type="checkbox" name="status_order_id[]" class="status_order_id" value="<!--{%$arrResults[cnt].order_id%}-->" id="status_order_id_<!--{%$arrResults[cnt].order_id%}-->"/><label for="status_order_id_<!--{%$arrResults[cnt].order_id%}-->">一括変更</label><br>
            <!--{%/if%}-->
			</td>

            <td class="center">
                <input type="checkbox" name="pdf_order_id[]" class="pdf_order_id" value="<!--{%$arrResults[cnt].order_id%}-->" id="pdf_order_id_<!--{%$arrResults[cnt].order_id%}-->"/><label for="pdf_order_id_<!--{%$arrResults[cnt].order_id%}-->">一括出力</label><br>
                <a href="./" onClick="win02('/admin/pdf.php?order_id=<!--{%$arrResults[cnt].order_id%}-->','pdf_input','620','650'); return false;"><span class="icon_class">個別出力</span></a>
            </td>
<!--{%/if%}-->
            <td class="center">

            <!--{%if $status != 3 && $status != 7%}-->
            <a href="?" onclick="fnChangeAction('/admin/order/edit/'); fnModeSubmit('pre_edit', 'order_id', '<!--{%$arrResults[cnt].order_id%}-->'); return false;"><span class="icon_edit">編集</span></a>
            <!--{%/if%}-->
            </td>
<!--%*
            <td class="center">
                <!--{%if $arrResults[cnt].email|strlen >= 1%}-->
                    <input type="checkbox" name="mail_order_id[]" value="<!--{%$arrResults[cnt].order_id%}-->" id="mail_order_id_<!--{%$arrResults[cnt].order_id%}-->"/><label for="mail_order_id_<!--{%$arrResults[cnt].order_id%}-->">一括通知</label><br>
                    <a href="?" onclick="fnChangeAction('<!--{%$smarty.const.ADMIN_ORDER_MAIL_URLPATH%}-->'); fnModeSubmit('pre_edit', 'order_id', '<!--{%$arrResults[cnt].order_id%}-->'); return false;"><span class="icon_mail">個別通知</span></a>
                <!--{%/if%}-->
            </td>
            <td class="center">
            <!--{%if $status == 3%}-->
			<a href="?" onclick="fnModeSubmit('delete_order', 'order_id', <!--{%$arrResults[cnt].order_id%}-->); return false;"><span class="icon_delete">削除</span></a>
			<!--{%/if%}-->
			</td>
*%}-->
			<!--{%if $smarty.SESSION.authority == 0%}-->
            <td class="center">
            <a href="?" onclick="fnChangeAction('/admin/order/mail/'); fnModeSubmit('mail', 'order_id', '<!--{%$arrResults[cnt].order_id%}-->'); return false;"><span class="icon_edit">個別通知</span></a>
            </td>
			<!--{%/if%}-->
        </tr>
        <!--{%/section%}-->
    </table>
    <!--{%* 検索結果表示テーブル *%}-->
    <!--{%/if%}-->

    <!--{%/if%}-->

</form>
</div>

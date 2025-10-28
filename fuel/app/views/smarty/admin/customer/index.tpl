<script type="text/javascript">
<!--

    function fnDelete(customer_id) {
        if (confirm('この会員情報を削除しても宜しいですか？')) {
        	$("#form1").attr("action", "./delete.php");
        	$("#edit_mode").val("delete");
        	$("#edit_customer_id").val(customer_id);
        	$("#form1").submit();
            return false;
        }
    }


    function fnEdit(customer_id) {
    	$("#form1").attr("action", "./edit.php");
    	$("#edit_mode").val("edit");
    	$("#edit_customer_id").val(customer_id);
    	$("#form1").submit();
        return false;
    }


    function fnNaviSearchPage(page, mode) {
    	$("#mode").val(mode);
    	$("#search_page").val(page);
    	$("#search_form").submit();
        return false;
    }


    function fnReSendMail(customer_id) {
        if (confirm('仮登録メールを再送しても宜しいですか？')) {
        	$("#form1").attr("action", "./resendmail.php");
        	$("#edit_mode").val("resendmail");
        	$("#edit_customer_id").val(customer_id);
        	$("#form1").submit();
            return false;
        }
    }


    function fnChangeStatus() {
    	if( $("#status_change").val() == "") {
    		alert('会員状態が選択されていません。');
    		return false;
    	}

    	if( $(".change_customer_id:checked").length == 0) {
    		alert('変更する会員が選択されていません。');
    		return false;
    	}

        if (confirm('会員状態を変更しても宜しいですか？')) {
        	$("#form1").attr("action", "./changestatus.php");
        	$("#edit_mode").val("changestatus");
        	$("#form1").submit();
            return false;
        }
    }

//-->
</script>


<div id="customer" class="contents-main">
<form name="search_form" id="search_form" method="post" action="?">
	<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
	<input type="hidden" id="mode" name="mode" value="search" />
	<input type="hidden" id="search_page" name="search_page" value="1" />

    <h2>検索条件設定</h2>
	<!--{%*$arrForm|@debug_print_var*%}-->

    <!--検索条件設定テーブルここから-->
    <table class="form">
        <!--{%include file="smarty/admin/adminparts/form_customer_search.tpl"%}-->
        <tr>
            <th>会員状態</th>
            <td colspan="3">
		        <!--{%assign var=key value="search_status"%}-->
				<!--{%foreach $arrCustomerStatus as $status %}-->
					<input type="checkbox"  name="<!--{%$key%}-->[]" value="<!--{%$status['id']%}-->" id="status<!--{%$status['id']%}-->" <!--{%if array_key_exists($key, $arrForm) && in_array($status['id'], (array)$arrForm[$key]) %}-->checked<!--{%/if%}--> >
					<label for="status<!--{%$status['id']%}-->"><!--{%$status['name']%}--></label>
				<!--{%/foreach%}-->
            </td>
        </tr>
        <tr>
            <th>会員メルマガ</th>
            <td colspan="3">
		        <!--{%assign var=key value="search_mailmaga"%}-->
				<!--{%foreach $arrMagazineType as $type %}-->
					<input type="checkbox"  name="<!--{%$key%}-->[]" value="<!--{%$type['id']%}-->" id="type<!--{%$type['id']%}-->" <!--{%if array_key_exists($key, $arrForm) && in_array($type['id'], (array)$arrForm[$key]) %}-->checked<!--{%/if%}--> >
					<label for="type<!--{%$type['id']%}-->"><!--{%$type['name']%}--></label>
				<!--{%/foreach%}-->
            </td>
        </tr>
        <tr>
            <th>会員ランク</th>
            <td colspan="3">
	            <select name="search_rank" >
		            <option value="">選択してください</option>
		            <!--{%foreach $arrCustomerRank as $rank%}-->
		            <option value="<!--{%$rank['id']%}-->" <!--{%if isset($arrForm.search_rank) && $arrForm.search_rank == $rank.id%}-->selected<!--{%/if%}-->><!--{%$rank.name%}--></option>
		            <!--{%/foreach%}-->
	            </select>
            </td>
        </tr>
        <tr>
            <th>セール区分</th>
            <td colspan="3">
            <!--{%assign var=key value="search_sale_statuses"%}-->
			<!--{%foreach $arrSALESTATUS as $status %}-->
				<input type="checkbox"  name="<!--{%$key%}-->[]" value="<!--{%$status['id']%}-->" id="sale_status<!--{%$status['id']%}-->" <!--{%if array_key_exists($key, $arrForm) && in_array($status['id'], (array)$arrForm[$key]) %}-->checked<!--{%/if%}--> >
				<label for="sale_status<!--{%$status['id']%}-->"><!--{%$status['name']%}--></label>
			<!--{%/foreach%}-->
            <!--{%*
            <!--{%html_checkboxes name="$key" options=$arrSALESTATUS selected=$search_sale_statuses['id']%}-->
            *%}-->
            </td>
        </tr>
    </table>
    <div class="btn">
        <p class="page_rows">検索結果表示件数
        <select name="search_page_max">
            <!--{%foreach $arrCustomerView as $view%}-->
            <option value="<!--{%$view['name']%}-->" <!--{%if isset($arrForm.search_page_max) && $arrForm.search_page_max == $view.id%}-->selected<!--{%/if%}-->><!--{%$view.name%}--></option>
            <!--{%/foreach%}-->
        </select> 件</p>
        <div class="btn-area">
            <ul>
                <li><button type="submit"><span class="btn-next">この条件で検索する</span></button></li>
            </ul>
        </div>
    </div>
</form>

<!--{%if 0 < count($arrCustomer)%}-->
<!--★★検索結果一覧★★-->
<form name="form1" id="form1" method="post" action="?">
	<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
	<input type="hidden" id="edit_mode" name="mode" value="search" />
	<input type="hidden" id="edit_customer_id" name="customer_id" value="" />

    <!-- 検索条件の保持 -->
    <!--{%foreach $arrForm as $k => $v%}-->
		<!--{%if is_array($v)%}-->
		    <!--{%foreach $v as $k2 => $v2%}-->
		    <input type="hidden" name="<!--{%$k%}-->[]" value="<!--{%$v2%}-->" />
		    <!--{%/foreach%}-->
		<!--{%else%}-->
		    <input type="hidden" name="<!--{%$k%}-->" value="<!--{%$v%}-->" />
		<!--{%/if%}-->
	<!--{%/foreach%}-->

    <h2>検索結果一覧</h2>
    <div class="btn">
        <span class="attention"><!--検索結果数--><!--{%$maxRecordNum%}-->件</span>&nbsp;が該当しました。
        <!--検索結果-->
        <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('csv','',''); return false;">CSV ダウンロード</a>
<!--        <a class="btn-normal" href="javascript:;" onclick="location.href='../contents/csv.php?tpl_subno_csv=customer'">CSV 出力項目設定</a>-->

        <select id="status_change" name="status_change">
        <option value="">選択してください</option>
        <!--{%foreach $arrCustomerStatus as $status %}-->
        <option value="<!--{%$status['id']%}-->"><!--{%$status['name']%}--></option>
        <!--{%/foreach%}-->
        </select>
		<a class="btn-normal" href="javascript:;" onclick="fnChangeStatus(); return false;">会員状態変更</a>
    </div>
    <!--{if count($arrData) > 0}-->

	<!--{%* ★ ページャここから ★ *%}-->
	<div class="pager">
	    <ul>
		<!--{%for $p=1 to $maxPageNum %}-->
			<li<!--{%if $p == $pageNum%}--> class="on"<!--{%/if%}-->><a href="#" onclick="fnNaviSearchPage(<!--{%$p%}-->, 'search'); return false;"><span><!--{%$p%}--></span></a></li>
		<!--{%/for%}-->
	    </ul>
	</div>
	<!--{%* ★ ページャここまで ★ *%}-->

    <!--検索結果表示テーブル-->
    <table class="list" id="customer-search-result">
        <col width="10%" />
        <col width="10%" />
        <col width="10%" />
        <col width="18%" />
        <col width="7%" />
        <col width="22%" />
        <col width="9%" />
        <col width="7%" />
        <col width="7%" />
        <tr>
            <th rowspan="2">種別</th>
            <th>会員ID</th>
            <th>会員ランク</th>
            <th rowspan="2">お名前/(フリガナ)</th>
            <th rowspan="2">性別</th>
            <th>TEL</th>
            <th rowspan="2">状態変更<input type="checkbox" name="status_check" id="status_check" onclick="fnAllCheck(this, 'input[name=change_customer_id[]]')" /></th>
            <th rowspan="2">編集</th>
            <th rowspan="2">削除</th>
        </tr>
        <tr>
            <th>都道府県</th>
            <th>セール区分</th>
            <th>メールアドレス</th>
        </tr>

        <!--{%foreach $arrCustomer as $row%}-->
            <tr>
                <td class="center" rowspan="2"><!--{%$row.status_name%}--></td>
                <td><!--{%$row.customer_id%}--></td>
                <td>
                <!--{%foreach $arrCustomerRank as $st%}-->
                	<!--{%if $st.id == $row.customer_rank%}-->
                		<!--{%$st.name|upper%}-->
                	<!--{%/if%}-->
                <!--{%/foreach%}-->
                </td>
                <td rowspan="2"><!--{%$row.name01%}--> <!--{%$row.name02%}--><br>(<!--{%$row.kana01%}--> <!--{%$row.kana02%}-->)</td>
                <td class="center" rowspan="2"><!--{%$row.sex_name%}--></td>
                <td><!--{%$row.tel01%}--></td>
                <td class="center" rowspan="2"><span class="icon_edit">
                <input type="checkbox" name="change_customer_id[]" value="<!--{%$row.customer_id%}-->" id="customer_id_<!--{%$row.customer_id%}-->" class="change_customer_id" /><label for="customer_id_<!--{%$row.customer_id%}-->">一括変更</label></span>
				</td>
                <td class="center" rowspan="2"><span class="icon_edit"><a href="#" onclick="return fnEdit('<!--{%$row.customer_id%}-->');">編集</a></span></td>
                <td class="center" rowspan="2"><span class="icon_delete"><a href="#" onclick="return fnDelete('<!--{%$row.customer_id%}-->');">削除</a></span></td>
            </tr>
            <tr>
                <td><!--{%$row.pref_name%}--></td>
                <td>
                <!--{%foreach $arrSALESTATUS as $st%}-->
                	<!--{%if $st.id == $row.sale_status%}-->
                		<!--{%$st.name%}-->
                	<!--{%/if%}-->
                <!--{%/foreach%}-->
                </td>
                <td><!--{%mailto address=$row.email encode="javascript"%}--></a><!--{%if $row.status eq 1%}--><br /><a href="#" onclick="return fnReSendMail('<!--{%$row.customer_id%}-->');">仮登録メール再送</a><!--{%/if%}--></td>
            </tr>
        <!--{%/foreach%}-->
    </table>
    <!--検索結果表示テーブル-->

    <!--{/if}-->
</form>
<!--★★検索結果一覧★★-->

<!--{%else%}-->
    <table class="list" id="customer-search-result">
		<tr><td>会員情報が存在しません。</td></tr>
	</table>
<!--{%/if%}-->
</div>

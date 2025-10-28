<script type="text/javascript">
<!--
	function fnReturn() {
		$("#form1").attr("action", "./edit.php");
		$("#form1").submit();
	    return false;
	}

	function fnComplete() {
		$("#form1").attr("action", "./complete.php");
		$("#form1").submit();
	    return false;
	}

//-->
</script>


<form name="form1" id="form1" method="post" action="?">
	<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
    <input type="hidden" name="mode" value="complete" />

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

    <!-- 顧客情報 -->
    <!--{%foreach $arrForm as $k => $v%}-->
    	<!--{%if $k|mb_strpos:'search_' !== 0%}-->
			<input type="hidden" name="<!--{%$k%}-->" value="<!--{%$v%}-->" />
		<!--{%/if%}-->
	<!--{%/foreach%}-->


    <div id="customer" class="contents-main">
        <table class="form">
            <tr>
                <th>会員ID</th>
                <td><!--{%$arrForm['customer_id']%}--></td>
            </tr>
            <tr>
                <th>会員状態</th>
                <td>
			    <!--{%foreach $arrCustomerStatus as $status%}-->
			    	<!--{%if $status['id'] == $arrForm['status']%}-->
						<!--{%$status['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>会員ランク</th>
                <td><!--{%$arrForm['rank_name']|upper%}--></td>
            </tr>
            <tr>
                <th>セール対象</th>
                <td>
                <!--{%if $arrForm['sale_status'] == 0%}-->通常
                <!--{%elseif $arrForm['sale_status'] == 1%}-->シークレットセール対象
                <!--{%elseif $arrForm['sale_status'] == 2%}-->VIPシークレットセール対象
                <!--{%elseif $arrForm['sale_status'] == -1%}-->セール除外
                <!--{%/if%}-->
                </td>
            </tr>
            <tr>
                <th>ポイントレート</th>
                <td><!--{%$arrForm['point_rate']%}-->%</td>
            </tr>
            <tr>
                <th>お名前</th>
                <td><!--{%$arrForm['name01']%}--><!--{%$arrForm['name02']%}-->　様</td>
            </tr>
            <tr>
                <th>お名前(フリガナ)</th>
                <td><!--{%$arrForm['kana01']%}--><!--{%$arrForm['kana02']%}-->　様</td>
            </tr>
            <tr>
                <th>会社名</th>
                <td><!--{%$arrForm['company']%}--></td>
            </tr>
            <tr>
                <th>部署名</th>
                <td><!--{%$arrForm['department']%}--></td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>〒 <!--{%$arrForm['zip01']%}--> - <!--{%$arrForm['zip02']%}--></td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
			    <!--{%foreach $arrPref as $pref%}-->
			    	<!--{%if $pref['id'] == $arrForm['pref']%}-->
						<!--{%$pref['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
                <!--{%$arrForm['addr01']%}--><!--{%$arrForm['addr02']%}-->
				</td>
            </tr>
            <tr>
                <th>お電話番号</th>
                <td><!--{%$arrForm['tel01']%}--></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td><!--{%$arrForm['email']%}--></td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
			    <!--{%foreach $arrSex as $sex%}-->
			    	<!--{%if $sex['id'] == $arrForm['sex']%}-->
						<!--{%$sex['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td><!--{%$arrForm['year']%}-->/<!--{%$arrForm['month']%}-->/<!--{%$arrForm['day']%}--></td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>**********</td>
            </tr>
            <tr>
                <th>パスワードを忘れたときのヒント</th>
                <td>
                    質問：
                    <!--{%foreach $arrReminder as $reminder%}-->
				    	<!--{%if $reminder['id'] == $arrForm['reminder']%}-->
							<!--{%$reminder['name']%}-->
						<!--{%/if%}-->
					<!--{%/foreach%}--><br/>
                    答え： <!--{%$arrForm['reminder_answer']%}-->
                </td>
            </tr>
            <tr>
                <th>メールマガジン</th>
                <td>
			    <!--{%foreach $arrMagazineType as $mtype%}-->
			    	<!--{%if $mtype['id'] == $arrForm['mailmaga_flg']%}-->
						<!--{%$mtype['name']%}-->
					<!--{%/if%}-->
				<!--{%/foreach%}-->
                </td>
            </tr>
            <tr>
                <th>SHOP用メモ</th>
                <td><!--{%$arrForm['note']|nl2br|default:"未登録"%}--></td>
            </tr>
            <tr>
                <th>所持ポイント</th>
                <td><!--{%$arrForm['point']|default:"0"%}--> pt</td>
            </tr>
            <tr>
                <th>最終購入日</th>
                <td><!--{%$arrForm['last_buy_date']%}--></td>
            </tr>
        </table>
        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" onclick="fnReturn(); return false;"><span class="btn-prev">編集画面に戻る</span></a></li>
                <li><a class="btn-action" href="javascript:;" onclick="fnComplete(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
            </ul>
        </div>
    </div>
</form>

<script type="text/javascript">
<!--
var flag = 0;

function setFlag(){
    flag = 1;
}
function checkFlagAndSubmit(){
    if ( flag == 1 ){
        if( confirm("内容が変更されています。続行すれば変更内容は破棄されます。宜しいでしょうか？") ){
            fnSetvalAndSubmit( 'form1', 'mode', 'id_set' );
        } else {
            return false;
        }
    } else {
        fnSetvalAndSubmit( 'form1', 'mode', 'id_set' );
    }
}

//-->
</script>


<form name="form1" id="form1" method="post" action="?">
<input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
<input type="hidden" name="mode" value="regist" />


<div id="basis" class="contents-main">
    <table>
    	<tr>
    		<th>adbnr_big(広告大)</th>
    		<td>
	    		<select name="big_id" id="big_id">
    			<!--{%html_options options=$arrAdImg selected=$arrAdsVal['big']%}-->
    			</select><br><br>
    			<div id="big_area">
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<th>adbnr_middle(広告中)</th>
    		<td>
	    		<select name="middle_id" id="middle_id">
    			<!--{%html_options options=$arrAdImg selected=$arrAdsVal['middle']%}-->
    			</select><br><br>
    			<div id="middle_area">
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<th>adbnr_footer(フッタ)</th>
    		<td>
	    		<select name="footer_id" id="footer_id">
    			<!--{%html_options options=$arrAdImg selected=$arrAdsVal['footer']%}-->
    			</select><br><br>
    			<div id="footer_area">
    			</div>
    		</td>
    	</tr>
    	<tr>
    		<th>adbnr_2col(２カラム)</th>
    		<td>
	    		<select name="2col_id" id="2col_id">
    			<!--{%html_options options=$arrAdImg selected=$arrAdsVal['2col']%}-->
    			</select><br><br>
    			<div id="2col_area">
    			</div>
    		</td>
    	</tr>
	</table>
</div>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'regist', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>


<script>
var ads = <!--{%$jAds|html_entity_decode%}-->;

$(function(){
	$('#big_id').change(function(){
		$('#big_area').empty();
		var val = $(this).val();
		var src = ads[val].image;
		var str = '<img src="'+src+'" width="300">';
		$('#big_area').append(str);
	});
	$('#middle_id').change(function(){
		$('#middle_area').empty();
		var val = $(this).val();
		var src = ads[val].image;
		var str = '<img src="'+src+'" width="300">';
		$('#middle_area').append(str);
	});
	$('#footer_id').change(function(){
		$('#footer_area').empty();
		var val = $(this).val();
		var src = ads[val].image;
		var str = '<img src="'+src+'" width="300">';
		$('#footer_area').append(str);
	});
	$('#2col_id').change(function(){
		$('#2col_area').empty();
		var val = $(this).val();
		var src = ads[val].image;
		var str = '<img src="'+src+'" width="300">';
		$('#2col_area').append(str);
	});
	
	$('#big_id').change();
	$('#middle_id').change();
	$('#footer_id').change();
	$('#2col_id').change();
});
//alert(ads[40].image);
</script>
<!--{%if false%}-->
<div id="basis" class="contents-main">
    <table>
    	<tr>
    		<th>adbnr_big(広告大)</th>
    		<td>
	    		<select name="big_id">
    			<!--{%html_options options=$arrAdImg%}-->
    			</select>
    		</td>
    	</tr>
    
    
    
        <tr>
            <th>テンプレート<span class="attention"> *</span></th>
            <td>
            <!--{%assign var=key value="template_id"%}-->
            <!--{if $arrErr[$key]}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
            <!--{/if}-->
            <select name="template_id" onChange="return checkFlagAndSubmit();">
            <option value="" selected="selected">選択してください</option>
            <!--{%html_options options=$arrMailTEMPLATE selected=$arrForm[$key]%}-->
            </select>
            </td>
        </tr>
        <tr>
            <th>メールタイトル<span class="attention"> *</span></th>
            <td>
            <!--{%assign var=key value="subject"%}-->
            <!--{if $arrErr[$key]}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
            <!--{/if}-->
            <input type="text" name="subject" value="<!--{%$arrForm[$key]%}-->" onChange="setFlag();" size="30" class="box30" " />
            </td>
        </tr>
        <tr>
            <th>ヘッダー</th>
            <td>
            <!--{%assign var=key value="header"%}-->
            <!--{if $arrErr[$key]}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
            <!--{/if}-->
            <textarea name="header" cols="75" rows="12" class="area75" onChange="setFlag();" "><!--{%$arrForm[$key]|h%}--></textarea><br />
            <span class="attention"> (上限<!--{%$smarty.const.LTEXT_LEN%}-->文字)
            </span>
            </td>
        </tr>
        <tr>
            <th colspan="2" align="center">動的データ挿入部分</th>
        </tr>
        <tr>
            <th>フッター</th>
            <td>
            <!--{%assign var=key value="footer"%}-->
            <!--{if $arrErr[$key]}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
            <!--{/if}-->
            <textarea name="footer" cols="75" rows="12" class="area75" onChange="setFlag();" "><!--{%$arrForm[$key]|h%}--></textarea><br />
            <span class="attention"> (上限<!--{%$smarty.const.LTEXT_LEN%}-->文字)</span>
            </td>
        </tr>
    </table>

    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'regist', '', ''); return false;"><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</div>
<!--{%/if%}-->
</form>

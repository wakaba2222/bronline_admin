<tr>
    <th>会員ID</th>
    <td>
	    <!--{%assign var=key value="search_customer_id"%}-->
	    <!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="30" class="box30" />
	</td>
    <th>都道府県</th>
    <td>
		<!--{%assign var=key value="search_pref"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
        <select class="top" name="<!--{%$key%}-->">
            <option value="">都道府県を選択</option>
			<!--{%foreach $arrPref as $pref %}-->
			<option value="<!--{%$pref['id']%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $pref['id'] %}-->selected<!--{%/if%}-->><!--{%$pref['name']%}--></option>
			<!--{%/foreach%}-->
        </select>
    </td>
</tr>
<tr>
    <th>お名前</th>
    <td>
		<!--{%assign var=key value="search_name"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="30" class="box30" />
    </td>
    <th>お名前(フリガナ)</th>
    <td>
        <!--{%assign var=key value="search_kana"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="30" class="box30" />
    </td>
</tr>
<tr>
    <th>性別</th>
    <td>
        <!--{%assign var=key value="search_sex"%}-->
		<!--{%foreach $arrSex as $sex %}-->
			<input type="checkbox"  name="<!--{%$key%}-->[]" value="<!--{%$sex['id']%}-->" id="sex<!--{%$sex['id']%}-->" <!--{%if array_key_exists($key, $arrForm) && in_array($sex['id'], (array)$arrForm[$key]) %}-->checked<!--{%/if%}--> >
			<label for="sex<!--{%$sex['id']%}-->"><!--{%$sex['name']%}--></label>
		<!--{%/foreach%}-->
    </td>
    <th>誕生月</th>
    <td>
        <!--{%assign var=key value="search_birth_month"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月
    </td>
</tr>
<tr>
    <th>誕生日</th>
    <td colspan="3">
		<!--{%assign var=errkey1 value="search_b_start_year"%}-->
		<!--{%assign var=errkey2 value="search_b_start_month"%}-->
		<!--{%assign var=errkey3 value="search_b_start_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
		<!--{%assign var=errkey1 value="search_b_end_year"%}-->
		<!--{%assign var=errkey2 value="search_b_end_month"%}-->
		<!--{%assign var=errkey3 value="search_b_end_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->

        <!--{%assign var=key value="search_b_start_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_b_start_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_b_start_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日～

        <!--{%assign var=key value="search_b_end_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_b_end_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_b_end_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日
    </td>
</tr>
<tr>
    <th>メールアドレス</th>
    <td colspan="3">
    <!--{%assign var=key value="search_email"%}-->
	<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="60" class="box30" />
    </td>
</tr>
<tr>
    <th>電話番号</th>
    <td colspan="3">
        <!--{%assign var=key value="search_tel"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="60" class="box30" />
    </td>
</tr>
<tr>
    <th>購入金額</th>
    <td>
        <!--{%assign var=key1 value="search_buy_total_from"%}-->
        <!--{%assign var=key2 value="search_buy_total_to"%}-->
        <!--{%if array_key_exists($key1, $arrError) || array_key_exists($key2, $arrError) %}-->
        	<span class="attention">
	        	<!--{%if array_key_exists($key1, $arrError) %}--><!--{%$arrError[$key1]%}--><!--{%/if%}-->
	        	<!--{%if array_key_exists($key2, $arrError) %}--><!--{%$arrError[$key2]%}--><!--{%/if%}-->
        	</span><br />
        <!--{%/if%}-->
	    <input type="text" name="<!--{%$key1%}-->" value="<!--{%if array_key_exists($key1, $arrForm)%}--><!--{%$arrForm[$key1]%}--><!--{%/if%}-->" size="6" class="box6" />円～
	    <input type="text" name="<!--{%$key2%}-->" value="<!--{%if array_key_exists($key2, $arrForm)%}--><!--{%$arrForm[$key2]%}--><!--{%/if%}-->" size="6" class="box6" />円
    </td>
    <th>購入回数</th>
    <td>
        <!--{%assign var=key1 value="search_buy_times_from"%}-->
        <!--{%assign var=key2 value="search_buy_times_to"%}-->
        <!--{%if array_key_exists($key1, $arrError) || array_key_exists($key2, $arrError) %}-->
        	<span class="attention">
	        	<!--{%if array_key_exists($key1, $arrError) %}--><!--{%$arrError[$key1]%}--><!--{%/if%}-->
	        	<!--{%if array_key_exists($key2, $arrError) %}--><!--{%$arrError[$key2]%}--><!--{%/if%}-->
        	</span><br />
        <!--{%/if%}-->
	    <input type="text" name="<!--{%$key1%}-->" value="<!--{%if array_key_exists($key1, $arrForm)%}--><!--{%$arrForm[$key1]%}--><!--{%/if%}-->" size="6" class="box6" />回～
	    <input type="text" name="<!--{%$key2%}-->" value="<!--{%if array_key_exists($key2, $arrForm)%}--><!--{%$arrForm[$key2]%}--><!--{%/if%}-->" size="6" class="box6" />回
    </td>
</tr>
<tr>
    <th>登録日</th>
    <td colspan="3">
		<!--{%assign var=errkey1 value="search_start_year"%}-->
		<!--{%assign var=errkey2 value="search_start_month"%}-->
		<!--{%assign var=errkey3 value="search_start_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
		<!--{%assign var=errkey1 value="search_end_year"%}-->
		<!--{%assign var=errkey2 value="search_end_month"%}-->
		<!--{%assign var=errkey3 value="search_end_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
        <!--{%assign var=key value="search_start_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_start_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_start_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日～

        <!--{%assign var=key value="search_end_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_end_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_end_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日
    </td>
</tr>
<tr>
    <th>最終購入日</th>
    <td colspan="3">
		<!--{%assign var=errkey1 value="search_buy_start_year"%}-->
		<!--{%assign var=errkey2 value="search_buy_start_month"%}-->
		<!--{%assign var=errkey3 value="search_buy_start_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
		<!--{%assign var=errkey1 value="search_buy_end_year"%}-->
		<!--{%assign var=errkey2 value="search_buy_end_month"%}-->
		<!--{%assign var=errkey3 value="search_buy_end_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
        <!--{%assign var=key value="search_buy_start_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_buy_start_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_buy_start_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日～

        <!--{%assign var=key value="search_buy_end_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_buy_end_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_buy_end_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日
    </td>
</tr>
<tr>
    <th>購入期間日</th>
    <td colspan="3">
		<!--{%assign var=errkey1 value="search_buys_start_year"%}-->
		<!--{%assign var=errkey2 value="search_buys_start_month"%}-->
		<!--{%assign var=errkey3 value="search_buys_start_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
		<!--{%assign var=errkey1 value="search_buys_end_year"%}-->
		<!--{%assign var=errkey2 value="search_buys_end_month"%}-->
		<!--{%assign var=errkey3 value="search_buys_end_day"%}-->
		<!--{%if array_key_exists($errkey1, $arrError) || array_key_exists($errkey2, $arrError) || array_key_exists($errkey3, $arrError) %}-->
			<span class="attention">
				<!--{%if array_key_exists($errkey1, $arrError) %}--><!--{%$arrError[$errkey1]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey2, $arrError) %}--><!--{%$arrError[$errkey2]%}--><!--{%/if%}-->
				<!--{%if array_key_exists($errkey3, $arrError) %}--><!--{%$arrError[$errkey3]%}--><!--{%/if%}-->
			</span><br />
		<!--{%/if%}-->
        <!--{%assign var=key value="search_buys_start_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_buys_start_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_buys_start_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日～

        <!--{%assign var=key value="search_buys_end_year"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">----</option>
			<!--{%for $y=1900 to 2030%}-->
			<option value="<!--{%$y%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $y %}-->selected<!--{%/if%}-->><!--{%$y%}--></option>
			<!--{%/for%}-->
        </select>年

        <!--{%assign var=key value="search_buys_end_month"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $m=1 to 12%}-->
			<option value="<!--{%$m%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $m %}-->selected<!--{%/if%}-->><!--{%$m%}--></option>
			<!--{%/for%}-->
        </select>月

        <!--{%assign var=key value="search_buys_end_day"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="" selected="selected">--</option>
			<!--{%for $d=1 to 31%}-->
			<option value="<!--{%$d%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $d %}-->selected<!--{%/if%}-->><!--{%$d%}--></option>
			<!--{%/for%}-->
        </select>日
    </td>
</tr>

<tr>
    <th>購入商品名</th>
    <td>
        <!--{%assign var=key value="search_buy_product_name"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="30" class="box30" />
    </td>
    <th>購入商品コード</th>
    <td>
        <!--{%assign var=key value="search_buy_product_code"%}-->
		<!--{%if array_key_exists($key, $arrError) %}--><span class="attention"><!--{%$arrError[$key]%}--></span><br /><!--{%/if%}-->
	    <input type="text" name="<!--{%$key%}-->" value="<!--{%if array_key_exists($key, $arrForm)%}--><!--{%$arrForm[$key]%}--><!--{%/if%}-->" size="30" class="box30" />
    </td>
</tr>
<tr>
    <th>カテゴリ</th>
    <td colspan="3">
        <!--{%assign var=key value="search_category_id"%}-->
        <select name="<!--{%$key%}-->" >
            <option value="">選択してください</option>
            <!--{%foreach $arrCategory as $category%}-->
            <option value="<!--{%$category['category_id']%}-->" <!--{%if array_key_exists($key, $arrForm) && $arrForm[$key] == $category['category_id']%}-->selected<!--{%/if%}-->><!--{%$category['name']%}--></option>
            <!--{%/foreach%}-->
        </select>
    </td>
</tr>

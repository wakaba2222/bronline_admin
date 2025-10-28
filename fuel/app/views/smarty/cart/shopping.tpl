<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">SHIPPING</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>お届け先の指定</h3>
  	<p>下記一覧よりお届け先住所を選択して、「次へ」ボタンをクリックしてください。一覧にご希望の住所が無い場合は、「新しいお届け先を追加」より追加登録ください。※最大20件まで追加できます。</p>
  </div>
	<form method="post" action="/cart/payment/">
		<table class="option delivery">
			<tr>
				<th>選択</th>
				<th>お届け先</th>
				<th>修正</th>
				<th>削除</th>
			</tr>
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="add" value="0" id="add_0" required="" checked>
						<label for="add_0"></label>
  				</div>
				</td>
				<td class="add">
  				<p>〒<!--{%$arrCustomer.zip01%}-->-<!--{%$arrCustomer.zip02%}--><br>
				<!--{%assign var=pref_id value=$arrCustomer.pref%}-->
<!--{%$arrPref[$pref_id]%}--><!--{%$arrCustomer.addr01%}--><!--{%$arrCustomer.addr02%}--><br> 
<!--{%$arrCustomer.name01%}--><!--{%$arrCustomer.name02%}--></p>
				</td>
				<td></td>
        <td></td>
			</tr>
			<tr><td colspan="4" class="border_none"><hr></td></tr>


			<!--{%foreach from=$arrDeliv item=deliv%}-->
			<tr>
				<td>
  				<div class="wrap_radio">
						<input type="radio" name="add" value="<!--{%$deliv.id%}-->" id="addr_<!--{%$deliv.id%}-->" required="">
						<label for="addr_<!--{%$deliv.id%}-->"></label>
  				</div>
				</td>
				<td class="add">
  				<p>〒<!--{%$deliv.zip01%}-->-<!--{%$deliv.zip02%}--><br>
				<!--{%assign var=pref_id value=$deliv.pref%}-->
<!--{%$arrPref[$pref_id]%}--><!--{%$deliv.addr01%}--><!--{%$deliv.addr02%}--><br> 
<!--{%$deliv.name01%}--><!--{%$deliv.name02%}--></p>
				</td>
				<td><a href="/cart/shoppingadd?id=<!--{%$deliv.id%}-->">修正</a></td>
        <td><a onclick="if (confirm('選択したお届け先を削除します。よろしいですか？')) return true; else return false;" href="/cart/shoppingadd?del_id=<!--{%$deliv.id%}-->">削除</a></td>
			</tr>
			<tr><td colspan="4" class="border_none"><hr></td></tr>
			<!--{%/foreach%}-->
		</table>

  <div class="btn_area">
			<a href="/cart/shoppingadd" class="submit_sys block confirm b_purple small">新しいお届け先を追加</a>
			<hr>
			<button class="submit_sys block confirm" href="/cart/payment/" type="submit">次へ</button>
			<a class="back_sys block" href="/cart/">戻る</a>
		</div>


	</form>	
<!--
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
-->
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

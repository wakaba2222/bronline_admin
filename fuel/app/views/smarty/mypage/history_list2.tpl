<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">MY PAGE</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>ご購入履歴</h3>
  </div>
  <table class="option historylist">
			<tr>
				<th>購入日</th>
				<th>注文番号</th>
				<th>ご購入内容</th>
				<th>詳細</th>
			</tr>
			<!--{%foreach from=$arrHistory item=history%}-->
			<tr>
				<td>
                  <p><!--{%$history.create_date|date_format:"Y.m.d"%}--><br><!--{%$history.create_date|date_format:"H:i"%}--></p>
				</td>
				<td>
  				<p><!--{%$history.order_id%}--></p>
				</td>
				<td class="detail">
  				<ul>
    				<li>支払方法：<!--{%$arrPayment[$history.payment_id]%}--></li>
            <li>合計金額：¥<!--{%($history.total+$history.tax)|number_format%}--></li>
            <li>ポイント：<!--{%$history.add_point%}--> point</li>
  				</ul>
          </td>
            <td><a href="/mypage/history2?detail=<!--{%$history.order_id%}-->">詳細</a></td>
			</tr>
			<tr><td colspan="4" class="border_none"><hr></td></tr>
			<!--{%/foreach%}-->
		</table>

	<!--{%if $max > 1%}-->
	<div class="pager">
		<!--{%if $page > 1%}-->
		<a class="prev" href="javascript:search('page', <!--{%$page-1%}-->);"><span></span></a>
		<!--{%/if%}-->
		<!--{%section name=cnt loop=$max%}-->
				<a <!--{%if $page == $smarty.section.cnt.iteration%}-->class="active"<!--{%/if%}--> href="javascript:search('page', <!--{%$smarty.section.cnt.iteration%}-->);"><!--{%$smarty.section.cnt.iteration%}--></a>
		<!--{%/section%}-->
		<!--{%if $max > $page%}-->
		<a class="next" href="javascript:search('page', <!--{%$page+1%}-->);"><span></span></a>
		<!--{%/if%}-->
	</div>
	<!--{%/if%}-->
  
    <a href="/mypage/" class="back_sys block historylist">戻る</a>
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
<script>
function search(page, id)
{
	location.href='/mypage/historylist2?page='+id;
}
</script>


<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

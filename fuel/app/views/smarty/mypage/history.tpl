<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<section class="tit_page">
	<h2 class="times">MY PAGE</h2>
</section>
<div class="wrap_contents sub">
  <div class="intro">
  	<h3>ご購入履歴の詳細</h3>
  </div>

    <table class="form confirm history">
      <tbody>
        <tr>
          <th>購入日時</th>
          <td><!--{%$arrHistory.create_date|date_format:"Y/m/d"%}-->　<!--{%$arrHistory.create_date|date_format:"H:i"%}--></td>
        </tr>
        <tr>
          <th>注文番号</th>
          <td><!--{%$arrHistory.order_id%}--></td>
        </tr>
        <tr>
          <th>ご注文状況</th>
          <td>
          <!--{%if $arrHistory.status == 1%}-->
          準備中
          <!--{%elseif $arrHistory.status == 2%}-->
          お支払い確認中
          <!--{%elseif $arrHistory.status == 6%}-->
          準備中
          <!--{%elseif $arrHistory.status == 4%}-->
          お取り寄せ中
          <!--{%elseif $arrHistory.status == 5%}-->
          発送完了
          <!--{%elseif $arrHistory.status == 8%}-->
          お直し中
          <!--{%elseif $arrHistory.status == 9%}-->
          予約商品入荷待ち
          <!--{%elseif $arrHistory.status == 10%}-->
          店舗受取
          <!--{%elseif $arrHistory.status == 11%}-->
          準備中
          <!--{%elseif $arrHistory.status == 12%}-->
          
          <!--{%elseif $arrHistory.status == 1000%}-->
          準備中
          <!--{%elseif $arrHistory.status == 1001%}-->
          準備中
          <!--{%elseif $arrHistory.status == 1002%}-->
          準備中
          <!--{%elseif $arrHistory.status == 13%}-->
          交換対応中
          <!--{%elseif $arrHistory.status == 14%}-->
          準備中
          <!--{%elseif $arrHistory.status == 15%}-->
          在庫確認中
          <!--{%elseif $arrHistory.status == 16%}-->
          準備中
          <!--{%/if%}-->
          </td>
        </tr>
      </tbody>
    </table>  

		<table class="cart confirm">
			<tr>
				<th>商品</th>
				<th>個数</th>
				<th>小計</th>
			</tr>
			<!--{%foreach from=$arrDetail item=detail%}-->
			<tr>
				<td>
					<div class="box_item">
						<img class="block fl" src="/upload/images/<!--{%$detail.shop_id%}-->/<!--{%$detail.image%}-->">
						<div class="item_detail fr">
							<p class="bold"><!--{%$detail.brand_name%}--> / <!--{%$detail.brand_name_kana%}--></p>
							<p class="bold"><!--{%$detail.product_name%}--></p>
							<p class="bold">¥<!--{%$detail.price|number_format%}--></p>
							<!--{%if $detail.color_name%}-->
							<dl>
								<dt class="bold">カラー：</dt>
								<dd><!--{%$detail.color_name%}--></dd>
							</dl>
							<!--{%/if%}-->
							<!--{%if $detail.size_name%}-->
							<dl>
								<dt class="bold">サイズ：</dt>
								<dd><!--{%$detail.size_name%}--></dd>
							</dl>
							<!--{%/if%}-->
						</div>
					</div>
				</td>
				<td><!--{%$detail.quantity%}--></td>
				<td class="border_none">
					<p class="price bold">¥<!--{%(($detail.price*$tax_rate)*$detail.quantity)|floor|number_format%}--></p>
				</td>
			</tr>
			<tr><td colspan="3" class="border_none"><hr></td></tr>
			<!--{%/foreach%}-->
      <tr>
  		<td colspan="3" class="child_wrapper">
        <table class="cart child" style="border-spacing: 0 15px;">
          <tr>
    				<td class="price_info">
      				<p class="fl">ご使用ポイント（1pt = ¥1）</p>
            </td>
            <td class="price"><span>- ¥<!--{%$arrHistory.use_point|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">クーポン</p>
            </td>
            <td class="price"><span>- ¥<!--{%$arrHistory.discount|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">送料</p>
            </td>
            <td class="price"><span> ¥<!--{%($arrHistory.deliv_fee*$tax_rate)|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">代引手数料</p>
            </td>
            <td class="price"><span> ¥<!--{%($arrHistory.fee*$tax_rate)|number_format%}--></span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">ギフトラッピング</p>
            </td>
            <td class="price"><span> ¥<!--{%$arrHistory.gift_price|number_format%}--></span></td>
          </tr>
          <tr class="total">
    				<td class="price_info">
      				<p class="fl">合計（税込）</p>
            </td>
            <td class="price"><span>¥<!--{%(($arrHistory.total+$arrHistory.deliv_fee+$arrHistory.fee)*$tax_rate)-($arrHistory.discount+$arrHistory.use_point)|number_format%}--></span></td>
          </tr>
          <tr>
    				<td class="price_info">
      				<p class="fl">加算ポイント</p>
            </td>
            <td class="price"><span>+ <!--{%$arrHistory.add_point|number_format%}-->pt</span></td>
          </tr>
          <tr><td colspan="2" class="border_none"><hr></td></tr>
        </table>
  		</td>
		</tr>
		</table>
    <h3 class="single">お届け先</h3>
		<table class="form confirm">
			<tbody><tr>
				<th>お名前</th>
				<td><!--{%$arrOrderDeliv.name01%}--><!--{%$arrOrderDeliv.name02%}--></td>
			</tr>
			<tr>
				<th>フリガナ</th>
				<td><!--{%$arrOrderDeliv.kana01%}--><!--{%$arrOrderDeliv.kana02%}--></td>
			</tr>
			<tr>
				<th>会社名</th>
				<td><!--{%$arrOrderDeliv.company%}--></td>
			</tr>
			<tr>
				<th>部署名</th>
				<td><!--{%$arrOrderDeliv.department%}--></td>
			</tr>
			<tr>
				<th>郵便番号</th>
				<td><!--{%$arrOrderDeliv.zip01%}-->-<!--{%$arrOrderDeliv.zip02%}--></td>
			</tr>
			<tr>
				<th>住所</th>
				<td><!--{%$arrPref[$arrOrderDeliv.pref]%}--><!--{%$arrOrderDeliv.addr01%}--><!--{%$arrOrderDeliv.addr02%}--></td>
			</tr>
			<tr>
				<th>電話番号</th>
				<td><!--{%$arrOrderDeliv.tel01%}--></td>
			</tr>
		</tbody>
		</table>
    <h3 class="single">ご注文詳細</h3>
		<table class="form confirm">
			<tbody>
			<!--{%*
			<tr>
				<th>配送業者</th>
				<td>ヤマト運輸</td>
			</tr>
			*%}-->
			<tr>
				<th>お支払い方法</th>
				<td><!--{%$arrPayment[$arrHistory.payment_id]%}--></td>
			</tr>
<!--
			<tr>
				<th>お届け日時</th>
				<td>2018年1月1日 (月)　18〜20時</td>
			</tr>
-->
			<tr>
				<th>明細書</th>
				<td><!--{%if $arrHistory.detail_statement == 1%}-->同封する<!--{%else%}-->同封しない<!--{%/if%}--></td>
			</tr>
			<tr>
				<th>領収書</th>
				<td>宛名：<!--{%$arrHistory.recepit_atena%}--><br>
  				但し書：<!--{%$arrHistory.receipt_tadashi%}--></td>
			</tr>
			<tr>
				<th>簡易包装</th>
				<td><!--{%if $arrHistory.packing == 0%}-->希望しない<!--{%else%}-->希望する<!--{%/if%}--></td>
			</tr>
			<tr>
				<th>ギフトラッピング</th>
				<td><!--{%if $arrHistory.gift == 0%}-->希望しない<!--{%else%}-->希望する<!--{%/if%}--></td>
			</tr>
			<tr>
				<th>メッセージカード</th>
				<td><!--{%if $arrHistory.card == 0%}-->メッセージカードなし<!--{%else%}-->メッセージカードあり<!--{%/if%}--><br>
  				内容：<!--{%$arrHistory.msg_card%}--></td>
			</tr>
			<tr>
				<th>備考</th>
				<td><!--{%$arrHistory.memo%}--></td>
			</tr>

		</tbody>
		</table>
    <div class="btn_area">
			<a href="/mypage/historylist" class="back_sys block">戻る</a>
		</div>	
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
<!--{%include file='smarty/common/include/viewed.tpl'%}-->
<!--{%include file='smarty/common/include/pickup.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

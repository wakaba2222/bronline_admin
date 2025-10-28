<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<p>受注　ツール</p>

<form action="?" method="post">
<input type="hidden" name="mode" value="order_temp">
<p>受注番号：<input type="text" name="order_id" id="order_id" value="" /><button type="submit" id="search_btn">取得</button></p>
</form>

<div id="order_area">
<!--{%*
<h3>注文情報</h3>
<p>注文番号：<!--{%$cart_data->getOrderId()%}--></p>
<p>会員ID：<!--{%$cart_data->getMemberId()%}--></p>
<p>氏名：<!--{%$cart_data->getCustomerName()%}-->　<!--{%$cart_data->getCustomerName2()%}--></p>
<p>氏名カナ：<!--{%$cart_data->getCustomerKana()%}-->　<!--{%$cart_data->getCustomerKana2()%}--></p>
<p>メールアドレス：<!--{%$cart_data->getCustomerEmail()%}--></p>
<p>都道府県：<!--{%$arrPref[$cart_data->getPref()]%}--></p>
<p>郵便番号：<!--{%$cart_data->getZip()%}-->-<!--{%$cart_data->getZip2()%}--></p>
<p>住所：<!--{%$cart_data->getAddress()%}--><!--{%$cart_data->getAddress2()%}--></p>
<p>電話番号：<!--{%$cart_data->getTelNumber()%}--></p>

<p>支払い方法：<!--{%$arrPayment[$cart_data->getPaymentType()]%}--></p>
*%}-->
<!--{%if $cart_data%}-->
<h3>注文詳細</h3>
<!--{%foreach from=$cart_data->getOrderDetail() item=detail%}-->
-----
<p>SHOP：<!--{%$detail->getShop()%}--></p>
<p>商品コード：<!--{%$detail->getProductCode()%}--></p>
<p>商品名：<!--{%$detail->getName()%}--></p>
<p>商品ID：<!--{%$detail->getProductId()%}--></p>
<p>ブランド名：<!--{%$detail->getBrandName()%}--></p>
<p>単価：<!--{%$detail->getPrice()%}--></p>
<p>サイズ：<!--{%$detail->getSize()%}--></p>
<p>カラー：<!--{%$detail->getColor()%}--></p>
<p>数量：<!--{%$detail->getQuantity()%}--></p>
<br>
<!--{%/foreach%}-->
<!--{%/if%}-->
</div>

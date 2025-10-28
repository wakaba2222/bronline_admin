
[注文番号] <!--{%$registData.order_id%}-->
[注文日時] <!--{%$registData.create_date%}-->
[支払方法] BR支払
[配送方法] BR配送

[備考]

[ご注文者]
BR (BR) 様
〒000-0000
住所
TEL : 000-0000-0000
MAIL : br@com
端末 : PC

[お届け先]
BR (BR) 様
〒000-0000
住所
TEL : 000-0000-0000

[お買い上げ明細]
<!--{%section name=cnt loop=$registData.arrProduct%}-->
[商品]
<!--{%$registData.arrProduct[cnt].product_name%}--> (<!--{%$registData.arrProduct[cnt].product_code%}-->)
サイズ : <!--{%$registData.arrProduct[cnt].size_name%}-->
カラー : <!--{%$registData.arrProduct[cnt].color_name%}-->
価格 <!--{%$registData.arrProduct[cnt].price|number_format|default:0%}-->(円) x <!--{%$registData.arrProduct[cnt].quantity%}-->(個) = <!--{%$registData.arrProduct[cnt].price*$registData.arrProduct[cnt].quantity|number_format|default:0%}-->(円) (税別)

<!--{%/section%}-->

**************************************************
小計 : <!--{%$registData.subtotal|number_format|default:0%}-->(円)
消費税 : <!--{%$registData.tax|number_format|default:0%}-->(円)
送料 : 0(円)
ラッピング料 : 0(円)
ポイント利用 : 0(円)
-------------------------
合計 : <!--{%$registData.total|number_format|default:0%}-->(円)


--------------------------------------------------

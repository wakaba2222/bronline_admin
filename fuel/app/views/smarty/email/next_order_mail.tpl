B.R.ONLINE 様

******************************
　購入者情報とご請求金額
******************************

受注日：<!--{%$arrOrder.create_date%}-->
ご注文番号：<!--{%$arrOrder.order_id%}-->
お支払合計：￥ <!--{%$arrOrder.total|number_format|default:0%}-->
ご決済方法：<!--{%$arrPayment[$arrOrder.payment_id]%}-->
メッセージ：<!--{%$arrOrder.memo%}-->
◎購入者
　お名前　：B.R.ONLINE　様
　オナマエ：ビーアールオンライン
　郵便番号：〒150-0001
　ご住所　：東京都渋谷区神宮前3-35-16 ルナーハウスパート4ビル 4F
　電話番号：03-5775-7827
　メール　：br@com

◎お届け先
　お名前　：B.R.ONLINE　様
　オナマエ：ビーアールオンライン
　郵便番号：〒150-0001
　ご住所　：東京都渋谷区神宮前3-34-10 ヴィラロイヤル神宮前502
　電話番号：03-5775-7827
　配送方法：
　お届け日：指定なし
　お届け時間：指定なし

******************************
　ご注文商品明細
******************************

<!--{%section name=cnt loop=$arrShopData%}-->
商品コード：<!--{%$arrShopData[cnt].product_code%}-->
商品名：<!--{%$arrShopData[cnt].product_name|strip_tags%}--> <!--{%$arrShopData[cnt].color_name%}--> <!--{%$arrShopData[cnt].size_name%}-->
単価：￥ <!--{%Tag_Util::taxin_cal($arrShopData[cnt].price)|number_format%}-->
数量：<!--{%$arrShopData[cnt].quantity%}-->

<!--{%/section%}-->
-------------------------------------------------
小　計 ￥ <!--{%$arrOrder.total|number_format|default:0%}--> (うち消費税 ￥<!--{%$arrOrder.tax|number_format|default:0%}-->）
値引き ￥ 0
送　料 ￥ 0
手数料 ￥ 0
============================================
合　計 ￥ <!--{%$arrOrder.total|number_format|default:0%}-->

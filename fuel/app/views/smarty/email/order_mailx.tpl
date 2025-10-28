
<!--{%$tpl_header%}-->

************************************************
　ご請求金額
************************************************

ご注文番号：<!--{%$arrOrder.order_id%}-->
お支払合計：￥ <!--{%$arrOrder.payment_total|number_format|default:0%}-->
ご決済方法：<!--{%$arrPayment[$arrOrder.payment_id]%}-->
メッセージ：<!--{%$arrOrder.memo%}-->

************************************************
　ご注文商品明細
************************************************

<!--{%section name=cnt loop=$arrOrderDetail%}-->
<!--{%if $arrOrderDetail[cnt].sale_status == 1 && $arrOrder.customer_sale_status == 1%}-->
【シークレットセール対象商品】
<!--{%elseif $arrOrderDetail[cnt].sale_status == 2 && $arrOrder.customer_sale_status == 2%}-->
【VIPシークレットセール対象商品】
<!--{%elseif $arrOrderDetail[cnt].reservation_flg == 1%}-->
【完全受注生産商品】
<!--{%elseif $arrOrderDetail[cnt].reservation_flg == 2%}-->
【予約商品】
<!--{%/if%}-->
商品コード: <!--{%$arrOrderDetail[cnt].product_code%}-->
ショップ名：[<!--{%$arrOrderDetail[cnt].shop_name%}-->]
商品名: [<!--{%$arrOrderDetail[cnt].brand%}-->]<!--{%$arrOrderDetail[cnt].product_name|strip_tags%}-->
<!--{%if $arrOrderDetail[cnt].product_url_id%}-->
商品URL：<!--{%$arrOrderDetail[cnt].product_url_id%}-->
<!--{%/if%}-->

[<!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%*
<!--{%if $arrOrderDetail[cnt].gara%}-->
[<!--{%$arrOrderDetail[cnt].gara%}--> / <!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%else%}-->
[<!--{%$arrOrderDetail[cnt].color_name%}--> / <!--{%$arrOrderDetail[cnt].size_name%}-->]
<!--{%/if%}-->
*%}-->
単価：￥ <!--{%Tag_Util::taxin_cal($arrOrderDetail[cnt].price)|number_format%}-->
数量：<!--{%$arrOrderDetail[cnt].quantity%}-->

<!--{%/section%}-->
-------------------------------------------------
小　計 ￥ <!--{%Tag_Util::taxin_cal($arrOrder.total)|number_format|default:0%}--> (うち消費税 ￥<!--{%Tag_Util::tax_cal($arrOrder.total)|number_format|default:0%}-->）
<!--{%if !$arrFree%}-->
値引き ￥ <!--{%$arrOrder.discount|number_format|default:0%}-->
<!--{%/if%}-->
<!--{%if $arrOrder.use_point%}-->
ポイント使用分 ￥ <!--{%$arrOrder.use_point|default:0|number_format%}-->
<!--{%/if%}-->
送　料 ￥ <!--{%Tag_Util::taxin_cal($arrOrder.deliv_fee)|number_format|default:0%}-->
手数料 ￥ <!--{%Tag_Util::taxin_cal($arrOrder.fee)|number_format|default:0%}-->
<!--{%if $arrOrder.gift_price%}-->
ギフトラッピング　「<!--{%if $arrOrder.gift%}-->あり<!--{%else%}-->なし<!--{%/if%}-->」　￥ <!--{%Tag_Util::taxin_cal($arrOrder.gift_price)|number_format|default:0%}-->
<!--{%/if%}-->
<!--{%if $arrFree%}-->
無料商品　<!--{%$arrFree.name%}-->  ￥ <!--{%Tag_Util::taxin_cal($arrFree.price)|number_format%}-->
<!--{%/if%}-->
============================================
合　計 ￥ <!--{%($arrOrder.payment_total)|number_format|default:0%}-->

************************************************
　配送情報
************************************************

<!--{%foreach item=shipping name=shipping from=$arrDeliv%}-->
◎お届け先<!--{%if count($arrDeliv) > 1%}--><!--{%$smarty.foreach.shipping.iteration%}--><!--{%/if%}-->
<!--{%* 法人名・団体名：<!--{%$shipping.company%}--> *%}-->
　お名前　：<!--{%$shipping.name01%}--> <!--{%$shipping.name02%}-->　様
　郵便番号：〒<!--{%$shipping.zip01%}-->-<!--{%$shipping.zip02%}-->
　住所　　：<!--{%$arrPref[$shipping.pref]%}--><!--{%$shipping.addr01%}-->　<!--{%$shipping.addr02%}-->
　電話番号：<!--{%$shipping.tel01%}-->

<!--{%if $arrOrder.deliv_date%}-->
　お届け日：<!--{%$arrOrder.deliv_date|date_format:"%Y/%m/%d"|default:"指定なし"%}-->
<!--{%else%}-->
　お届け日：指定なし
<!--{%/if%}-->
　お届け時間：<!--{%$arrOrder.deliv_time|default:"指定なし"%}-->

<!--{%/foreach%}-->

============================================
明細書　　　　　　「<!--{%if $arrOrder.detail_statement%}-->あり<!--{%else%}-->なし<!--{%/if%}-->」
領収書宛名　　　　「<!--{%$arrOrder.recepit_atena%}-->」
領収書但し　　　　「<!--{%$arrOrder.receipt_tadashi%}-->」
簡易梱包　　　　　「<!--{%if $arrOrder.packing%}-->ダンボール箱を希望する<!--{%else%}-->紙袋を希望する<!--{%/if%}-->」
メッセージカード　「<!--{%if $arrOrder.card%}-->カードあり<!--{%else%}-->カードなし<!--{%/if%}-->」
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
メッセージ内容
---
<!--{%$arrOrder.msg_card%}-->
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

<!--{%if true%}-->
<!--{%if $arrOrder.customer_id && $smarty.const.USE_POINT !== false%}-->
============================================
<!--{%* ご注文前のポイント {$tpl_user_point} pt *%}-->
お客様のステージは「<!--{%$arrRank[$arrCustomer.customer_rank]|upper%}-->」です。
<!--{%/if%}-->
<!--{%/if%}-->
<!--{%$tpl_footer%}-->

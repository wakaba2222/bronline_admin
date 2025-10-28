<!--{%*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *%}-->


************************************************
　ご注文商品明細
************************************************

注文番号：<!--{%$arrOrder.order_id%}-->
<!--{%if $arrOrder.coupon%}-->
	<!--{%if $arrOrder.coupon != '685848527565' && $arrOrder.coupon != 471649978809%}-->
	<!--{%/if%}-->
<!--{%/if%}-->

<!--{%section name=cnt loop=$arrShopData%}-->
<!--{%if $arrOrderDetail[cnt].sale_status == 1 && $arrOrder.customer_sale_status == 1%}-->
【シークレットセール対象商品】
<!--{%elseif $arrOrderDetail[cnt].sale_status == 2 && $arrOrder.customer_sale_status == 2%}-->
【VIPシークレットセール対象商品】
<!--{%elseif $arrOrderDetail[cnt].reservation_flg == 1%}-->
【完全受注生産商品】
<!--{%elseif $arrOrderDetail[cnt].reservation_flg == 2%}-->
【予約商品】
<!--{%/if%}-->
商品コード: <!--{%$arrShopData[cnt].product_code%}-->
グループコード：<!--{%$arrShopData[cnt].group_code%}-->
ショップ名：[<!--{%$arrOrder.shop_name%}-->]
商品名: [<!--{%$arrShopData[cnt].brand%}-->]<!--{%$arrShopData[cnt].product_name|strip_tags%}-->
商品URL：<!--{%$smarty.const.HTTP_URL%}-->mall/<!--{%$arrOrder.shop_id%}-->/item/?detail=<!--{%$arrShopData[cnt].product_id%}-->

<!--{%*
<!--{%if $arrShopData[cnt].gara%}-->
[<!--{%$arrShopData[cnt].gara%}--> / <!--{%$arrShopData[cnt].color%}--> / <!--{%$arrShopData[cnt].size%}-->]
<!--{%else%}-->
[<!--{%$arrShopData[cnt].color_name%}--> / <!--{%$arrShopData[cnt].size_name%}-->]
<!--{%/if%}-->
*%}-->
[<!--{%$arrShopData[cnt].color_name%}--> / <!--{%$arrShopData[cnt].size_name%}-->]
<!--{%if $arrOrder.tax_in == '0'%}-->
単価：￥ <!--{%if $arrShopData[cnt].price < $arrShopData[cnt].price02 && $arrShopData[cnt].price02 != 0 && $arrShopData[cnt].price02 != ""%}--><!--{%$arrShopData[cnt].price02|number_format%}-->→<!--{%/if%}--><!--{%$arrShopData[cnt].price|number_format%}-->
<!--{%else%}-->
単価：￥ <!--{%$arrShopData[cnt].price|number_format%}-->
<!--{%/if%}-->
数量：<!--{%$arrShopData[cnt].quantity%}-->

<!--{%/section%}-->
-------------------------------------------------
小　計 ￥ <!--{%$arrOrder.subtotal+$arrOrder.tax|number_format|default:0%}--> (うち消費税 ￥<!--{%$arrOrder.tax|number_format|default:0%}-->）
============================================
合　計 ￥ <!--{%$arrOrder.total|number_format|default:0%}-->

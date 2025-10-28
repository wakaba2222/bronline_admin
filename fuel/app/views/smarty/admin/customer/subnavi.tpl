<!--{%*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2013 LOCKON CO.,LTD. All Rights Reserved.
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
 */
*%}-->

<ul class="level1">
<li<!--{%if $tpl_subno == 'index'%}--> class="on"<!--{%/if%}--> id="navi-customer-index"><a href="/admin/customer/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>会員マスター</span></a></li>
<!--{%if $smarty.session.shop_admin == 'on'%}-->
<li<!--{%if $tpl_subno == 'upload_csv'%}--> class="on"<!--{%/if%}--> id="navi-customer-csv"><a href="/admin/customer/upload_csv.php"><span>会員CSV更新（ポイント付与率、ランク）</span></a></li>
<!--{%/if%}-->

<!--{%*
<li<!--{%if $tpl_subno == 'customer'%}--> class="on"<!--{%/if%}--> id="navi-customer-customer"><a href="/admin/customer/edit.php"><span>会員登録</span></a></li>
*%}-->
<li<!--{%if $tpl_subno == 'sale'%}--> class="on"<!--{%/if%}--> id="navi-customer-sale"><a href="/admin/customer/uploadsale"><span>会員セール設定登録</span></a></li>
</ul>

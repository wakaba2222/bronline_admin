<!--{*
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
*}-->

<ul class="level1">
<li<!--{if $tpl_subno == 'index'}--> class="on"<!--{/if}--> id="navi-contents-index"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/<!--{$smarty.const.DIR_INDEX_PATH}-->"><span>新着情報管理</span></a></li>
<li<!--{if $tpl_subno == 'feature'}--> class="on"<!--{/if}--> id="navi-contents-feature"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/feature.php"><span>FEATURE管理</span></a></li>
<li<!--{if $tpl_subno == 'styling'}--> class="on"<!--{/if}--> id="navi-contents-styling"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/styling.php"><span>STYLING管理</span></a></li>
<li<!--{if $tpl_subno == 'staff'}--> class="on"<!--{/if}--> id="navi-contents-staff"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/staff.php"><span>STAFF RECOMMEND管理</span></a></li>
<!--{if $shop_mode == ''}-->
<li<!--{if $tpl_subno == 'theme'}--> class="on"<!--{/if}--> id="navi-contents-theme"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/theme.php"><span>テーマ管理</span></a></li>
<!--{/if}-->
<!--{*
<li<!--{if $tpl_subno == 'recommend'}--> class="on"<!--{/if}--> id="navi-contents-recommend"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/recommend.php"><span>おすすめ商品管理</span></a></li>
<li<!--{if $tpl_subno == 'file'}--> class="on"<!--{/if}--> id="navi-contents-file"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/file_manager.php"><span>ファイル管理</span></a></li>
<li<!--{if $tpl_subno == 'csv'}--> class="on"<!--{/if}--> class="on_level2" id="navi-contents-csv"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php"><span>CSV出力項目設定</span></a>
    <ul id="navi-csv-sub" class="level2">
    <li<!--{if $tpl_subno_csv == 'product'}--> class="on"<!--{/if}--> id="navi-csv-product"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php?tpl_subno_csv=product"><span>商品管理</span></a></li>
    <li<!--{if $tpl_subno_csv == 'customer'}--> class="on"<!--{/if}--> id="navi-csv-customer"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php?tpl_subno_csv=customer"><span>会員管理</span></a></li>
    <li<!--{if $tpl_subno_csv == 'order'}--> class="on"<!--{/if}--> id="navi-csv-order"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php?tpl_subno_csv=order"><span>受注管理</span></a></li>
    <li<!--{if $tpl_subno_csv == 'category'}--> class="on"<!--{/if}--> id="navi-csv-category"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php?tpl_subno_csv=category"><span>カテゴリ</span></a></li>
    <li<!--{if $tpl_subno_csv == 'review'}--> class="on"<!--{/if}--> id="navi-csv-review"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv.php?tpl_subno_csv=review"><span>レビュー</span></a></li>
    <li<!--{if $tpl_subno_csv == 'csv_sql'}--> class="on"<!--{/if}--> id="navi-csv-sql"><a href="<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/csv_sql.php"><span>高度な設定</span></a></li>
    </ul>
</li>
*}-->
</ul>

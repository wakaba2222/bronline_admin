<ul class="level1">
<li<!--{%if $tpl_subno == 'index'%}--> class="on"<!--{%/if%}--> id="navi-product-index"><a href="/admin/product"><span>商品マスター</span></a></li>
<!--{%if $smarty.session.shop == 'forzastyleshop'%}-->
<li<!--{%if $tpl_subno == 'copy'%}--> class="on"<!--{%/if%}--> id="navi-product-index"><a href="/admin/product/copy"><span>商品マスター(COPY)</span></a></li>
<!--{%/if%}-->
<li<!--{%if $tpl_subno == 'product'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/upload"><span>商品登録</span></a></li>
<li<!--{%if $tpl_subno == 'productdel'%}--> class="on"<!--{%/if%}--> id="navi-product-productdel"><a href="/admin/product/uploaddel"><span>商品削除(グループコード)</span></a></li>
<li<!--{%if $tpl_subno == 'productdel2'%}--> class="on"<!--{%/if%}--> id="navi-product-productdel2"><a href="/admin/product/uploaddel2"><span>商品削除(商品ID)</span></a></li>
<!--{%if $smarty.session.shop != 'brshop2' && $smarty.session.shop != 'guji' && $smarty.session.shop != 'ring' && $smarty.session.shop != 'biglietta' && $smarty.session.shop != 'sugawaraltd' && $smarty.session.shop != 'altoediritto'%}-->
<li<!--{%if $tpl_subno == 'productstock'%}--> class="on"<!--{%/if%}--> id="navi-product-productstock"><a href="/admin/product/productstock"><span>在庫一括更新</span></a></li>
<!--{%/if%}-->
<li<!--{%if $tpl_subno == 'brand'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/brand"><span>ブランド登録</span></a></li>
<!--{%if $smarty.session.shop == 'brshop'%}-->
<li<!--{%if $tpl_subno == 'theme'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/theme"><span>テーマ登録</span></a></li>
<li<!--{%if $tpl_subno == 'category'%}--> class="on"<!--{%/if%}--> id="navi-product-product"><a href="/admin/product/category"><span>カテゴリ操作</span></a></li>
<!--{%/if%}-->
<li<!--{%if $tpl_subno == 'sale'%}--> class="on"<!--{%/if%}--> id="navi-product-sale"><a href="/admin/product/uploadsale"><span>セール登録(商品ID)</span></a></li>
<li<!--{%if $tpl_subno == 'sale2'%}--> class="on"<!--{%/if%}--> id="navi-product-sale2"><a href="/admin/product/uploadsale2"><span>セール登録(グループコード)</span></a></li>
<!--{%if $smarty.session.shop == 'brshop'%}-->
<li<!--{%if $tpl_subno == 'theme'%}--> class="on"<!--{%/if%}--> id="navi-product-theme"><a href="/admin/product/uploadtheme"><span>テーマ商品登録(商品ID)</span></a></li>
<li<!--{%if $tpl_subno == 'noproduct'%}--> class="on"<!--{%/if%}--> id="navi-product-noproduct"><a href="/admin/product/noproduct"><span>対象外商品検索</span></a></li>
<!--{%/if%}-->
</ul>

<ul class="level1">
    <li id="navi-order-index" class="<!--{if $tpl_mainno == 'order' && $tpl_subno == 'index'}-->on<!--{/if}-->"><a href="/admin/order/"><span>受注管理</span></a></li>
<!--{%if $smarty.SESSION.authority == 0%}-->
    <li id="navi-order-add" class="<!--{if $tpl_mainno == 'order' && $tpl_subno == 'add'}-->on<!--{/if}-->"><a href="/admin/order/regist"><span>受注登録</span></a></li>
<!--{%/if%}-->
</ul>

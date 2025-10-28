<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{%$smarty.const.CHAR_CODE%}-->" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" href="<!--{%$TPL_URLPATH%}-->css/reset.css" type="text/css" media="all" />
<link rel="stylesheet" href="<!--{%$TPL_URLPATH%}-->css/admin_contents.css" type="text/css" media="all" />
<link rel="stylesheet" href="<!--{%$TPL_URLPATH%}-->css/admin_file_manager.css" type="text/css" media="all" />
<!--{%if $tpl_mainno eq "basis" && $tpl_subno eq "index"%}-->
<!--{%if ($smarty.server.HTTPS != "") && ($smarty.server.HTTPS != "off")%}-->
<script type="text/javascript" src="https://maps-api-ssl.google.com/maps/api/js?sensor=false"></script>
<!--{%else%}-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!--{%/if%}-->
<!--{%/if%}-->
<script type="text/javascript" src="<!--{%$smarty.const.ROOT_URLPATH%}-->js/navi.js"></script>
<script type="text/javascript" src="<!--{%$smarty.const.ROOT_URLPATH%}-->js/win_op.js"></script>
<script type="text/javascript" src="<!--{%$smarty.const.ROOT_URLPATH%}-->js/site.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<!--{%$TPL_URLPATH%}-->js/admin.js"></script>
<script type="text/javascript" src="<!--{%$smarty.const.ROOT_URLPATH%}-->js/css.js"></script>
<script type="text/javascript" src="<!--{%$TPL_URLPATH%}-->js/file_manager.js"></script>
<title><!--{%$smarty.const.ADMIN_TITLE%}--></title>
<link rel="shortcut icon" href="/common/images/ico/favicon.ico" />
<link rel="icon" type="image/vnd.microsoft.icon" href="/common/images/ico/favicon.ico" />
<script type="text/javascript">//<![CDATA[
    <!--{%$tpl_javascript%}-->
    $(function(){
        <!--{%$tpl_onload%}-->
    });
//]]></script>
<script>
$(function(){
	$('input').on('keydown', function(e){
		  if(e.keyCode === 13){
			e.preventDefault();
		  }
	});
});
</script>
</head>

<body class="<!--{%if strlen($tpl_authority) >= 1%}-->authority_<!--{%$tpl_authority%}--><!--{%/if%}-->">
<!--{%$GLOBAL_ERR%}-->
<noscript>
    <p>JavaScript を有効にしてご利用下さい.</p>
</noscript>

<div id="container">
<a name="top"></a>
<!--{%if $smarty.const.ADMIN_MODE == '1'%}-->
<div id="admin-mode-on">ADMIN_MODE ON</div>
<!--{%/if%}-->

<!--{%* ▼HEADER *%}-->
<div id="header">
    <div id="header-contents">
        <div id="logo"><a href="<!--{%$smarty.const.ADMIN_HOME_URLPATH%}-->"><img src="<!--{%$TPL_URLPATH%}-->img/header/bronline_logo.svg" width="172" height="25" alt="EC-CUBE" /></a></div>
        <div id="site-check">
            <p class="info"><span>ログイン&nbsp;:&nbsp;<!--{%* ログイン名 *%}--><!--{%$smarty.SESSION.author%}--></span>&nbsp;様&nbsp;</p>
            <ul>
                <li><a href="/" class="btn-tool-format" target="_blank"><span>SITE CHECK</span></a></li>
                <li><a href="/admin/logout" class="btn-tool-format">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</div>
<!--{%* ▲HEADER *%}-->

<!--{%* ▼NAVI *%}-->
<div id="navi-wrap">
    <ul id="navi" class="clearfix">
<!--{%if $smarty.SESSION.authority == 0%}-->
        <li id="navi-basis" class="<!--{%if $tpl_mainno eq "basis"%}-->on<!--{%/if%}-->">
            <a href="/admin/basis/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span class="level1">基本情報管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`basis/subnavi.tpl"%}-->
        </li>
        <li id="navi-products" class="<!--{%if $tpl_mainno eq "shop"%}-->on<!--{%/if%}-->">
            <a href="/admin/shop/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>ショップ管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`shop/subnavi.tpl"%}-->
        </li>
<!--{%/if%}-->
        <li id="navi-products" class="<!--{%if $tpl_mainno eq "products"%}-->on<!--{%/if%}-->">
            <a href="/admin/product/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>商品管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`product/subnavi.tpl"%}-->
        </li>
<!--{%if $smarty.SESSION.authority == 0%}-->
        <li id="navi-customer" class="<!--{%if $tpl_mainno eq "customer"%}-->on<!--{%/if%}-->">
            <a href="/admin/customer/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>会員管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`customer/subnavi.tpl"%}-->
        </li>
<!--{%/if%}-->
        <li id="navi-order" class="<!--{%if $tpl_mainno eq "order"%}-->on<!--{%/if%}-->">
            <a href="/admin/order/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>受注管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`order/subnavi.tpl"%}-->
        </li>
<!--{%if $smarty.SESSION.authority == 0%}-->
<!--{%*
        <li id="navi-mail" class="<!--{%if $tpl_mainno eq "mail"%}-->on<!--{%/if%}-->">
            <a href="/admin/mail/<!--{%$smarty.const.DIR_INDEX_PATH%}-->"><span>メール管理</span></a>
            <!--{%include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`mail/subnavi.tpl"%}-->
        </li>
*%}-->
<!--{%/if%}-->
    </ul>
</div>
<!--{%* ▲NAVI *%}-->

<!--{%if $tpl_subtitle%}-->
<h1><span class="title"><!--{%$tpl_maintitle%}--><!--{%if strlen($tpl_maintitle) >= 1 && strlen($tpl_subtitle) >= 1%}-->＞<!--{%/if%}--><!--{%$tpl_subtitle%}--></span></h1>
<!--{%/if%}-->

<div id="contents" class="clearfix">
    <!--{%include file=$tpl_mainpage%}-->
</div>

<!--{%* ▼FOOTER *%}-->
<div id="footer">
    <div id="footer-contents">
        <div id="copyright">Copyright &copy; 2000-<!--{%$smarty.now|date_format:"%Y"%}--> © B.R.ONLINE All Rights Reserved.</div>
        <div id="topagetop">
            <ul class="sites">
                <li><a href="#top" class="btn-tool-format">PAGE TOP</a></li>
            </ul>
        </div>
    </div>
</div>
<!--{%* ▲FOOTER *%}-->

</div>
</body>
</html>

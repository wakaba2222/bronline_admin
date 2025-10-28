<style>
h1.title
{
 color: #FEFEFE;
    background:#141215!important;
    text-shadow: 2px 2px 1px #999999;
    /*-webkit-background-clip: text;*/
    /*-webkit-text-fill-color: transparent;*/
/*
  background: -webkit-linear-gradient(-45deg, #FF7C00, #DA8E00, #EDAC06, #F7DE05, #ECB802, #FF7C00, #B67B03, #DA8E00, #EDAC06, #FF7C00, #ECB802, #FF7C00);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
*/
    font-size: 180%;
    font-weight: bold;
    font-family: serif;
    height:110px!important;
    margin:30px 0 30px 30px!important;
    box-shadow:2px 2px 4px #444;
    text-align:center;
    padding:0!important;
    padding:40px 20px 0px 20px!important;
}
</style>
<div id="login-wrap">

    <div id="login-form" class="clearfix">
        <h1 class="title">B.R.ONLINE</h1>
        <div id="input-form">
        <p class="attention"><!--{%$error%}--></p>
            <form name="form1" id="form1" method="post" action="/admin/login">
            <input type="hidden" name="<!--{%$smarty.const.TRANSACTION_ID_NAME%}-->" value="<!--{%$transactionid%}-->" />
            <input type="hidden" name="mode" value="login" />
            <input type="hidden" name="shop_admin" value="<!--{$shop_admin}-->" />
            <p><label for="login_id">ID</label></p>
            <input type="text" name="login_id" size="20" class="box25" />
            <p><label for="password">PASSWORD</label></p>
            <input type="password" name="password" size="20" class="box25" />
            <p><a class="btn-tool-format" href="javascript:;" onclick="document.form1.submit(); return false;"><span>LOGIN</span></a></p>
            </form>
        </div>
    </div>

</div>
<div id="copyright">Copyright &copy; 2018-<!--{%$smarty.now|date_format:"%Y"%}--> All Rights Reserved.</div>

<script type="text/javascript">//<![CDATA[
document.form1.login_id.focus();
$(function() {
    $('<input type="submit" />')
        .css({'position' : 'absolute',
            'top' : '-1000px'})
        .appendTo('form');
});
//]]></script>

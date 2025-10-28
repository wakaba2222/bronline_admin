<!--{%include file='smarty/common/include/head.tpl'%}-->
<!--{%include file='smarty/common/include/header.tpl'%}-->
<style>
.pc
{
	display:inline;
}
.sp
{
	display:none;
}
.rank_name
{
	margin-top:50px;
	float:right;
}
@media screen and (max-width: 450px) {
	.pc
	{
		display:none;
	}
	.sp
	{
		display:block;
	}
    .rank_name {
		margin-top:0px;
    }
}
</style>
<section class="tit_page">
	<h2 class="times">MY PAGE</h2>
</section>
<div class="wrap_contents sub">

  <div class="wrap_customer_info">
    <div class="customer_name clearfix">
      <p class="name"><!--{%$arrCustomer.name01%}--><!--{%$arrCustomer.name02%}--> <span>さま</span></p>
      <p class="limit_point rank_name">ステージ締切日：<!--{%$rank_date|date_format:"%Y年%m月%d日"%}--><span class="pc">（ステージ反映日：<!--{%$update_date|date_format:"%Y年%m月%d日"%}-->）</span><span class="sp">ステージ反映日：<!--{%$update_date|date_format:"%Y年%m月%d日"%}--></span></p>
      <!--{%if $arrCustomer.customer_rank < 4%}-->
      <!--{%if $next_total <= 0%}-->
      <p class="info">来年度より<span><!--{%$next_stage%}--></span>ステージ</p>
      <!--{%else%}-->
      <p class="info"><span><!--{%$next_date%}--></span>までに<span>¥<!--{%$next_total|number_format%}-->円</span>以上のご購入で、来年度より<span><!--{%$next_stage%}--></span>ステージ</p>
      <!--{%/if%}-->
      <!--{%/if%}-->
    </div>

    <div class="customer_stage <!--{%$arrRank.name%}-->">
      <div>
        <p class="status_tit">会員ステージ</p>
        <p class="status mont"><!--{%$arrRank.name%}--></p>
      </div>
      <div>
        <p class="status_tit">ポイント還元率</p>
        <p class="status os"><!--{%$arrRank.point_rate%}--><span>%</span></p>
      </div>
      <div>
        <p class="status_tit">所有ポイント</p>
        <p class="status os"><!--{%$arrCustomer.point%}--><span>point</span></p>
      </div>
      <div>
        <p class="status_tit">本年度購入金額</p>
        <p class="status os">¥<!--{%$total|number_format%}--></p>
      </div>
    </div>

    <div class="customer_data_info clearfix">
      <p class="limit_point">ポイント有効期限： <!--{%$next_date%}--></p>
      <p class="about_point"><a href="https://www.bronline.jp/guide/point.php">ステージ・ポイントについて</a></p>
    </div>

    <div class="intro">
  		<h3>マイページメニュー</h3>
    </div>


  <ul class="mypage_menu">
    <li>
      <a href="/mypage/wishlist">
      <img src="../common/images/system/mypage_icon_01.svg" alt="お気に入りアイテム" class="icon_01">
      <div class="mypage_menu_txt">
        <p class="tit">お気に入りアイテム</p>
        <p>お気に入り登録したアイテムを確認することができます</p>
      </div>
    </a>
    </li>
    <li>
      <a href="/mypage/historylist">
      <img src="../common/images/system/mypage_icon_02.svg" alt="購入履歴" class="icon_02">
      <div class="mypage_menu_txt">
        <p class="tit">購入履歴</p>
        <p>過去のご注文履歴を確認することができます</p>
      </div>
    </a>
    </li>
    <li>
      <a href="/mypage/historylist2">
      <img src="../common/images/system/mypage_icon_02.svg" alt="購入履歴" class="icon_02">
      <div class="mypage_menu_txt">
        <p class="tit">購入履歴(2018/10/7以前)</p>
        <p>2018/10/7より前のご注文履歴を確認することができます</p>
      </div>
    </a>
    </li>
    <li>
      <a href="/mypage/memberedit">
      <img src="../common/images/system/mypage_icon_03.svg" alt="会員情報の変更" class="icon_03">
      <div class="mypage_menu_txt">
        <p class="tit">会員情報の変更</p>
        <p>メールアドレスやパスワードなど、登録情報を変更することができます</p>
      </div>
    </a>
    </li>
    <li>
      <a href="/mypage/deliv">
      <img src="../common/images/system/mypage_icon_04.svg" alt="お届け先の追加・修正" class="icon_04">
      <div class="mypage_menu_txt">
        <p class="tit">お届け先の追加・修正</p>
        <p>お届け先の住所を追加・修正・削除することができます</p>
      </div>
    </a>
    </li>
    <li>
      <a href="/mypage/unsubscribe">
      <img src="../common/images/system/mypage_icon_05.svg" alt="退会" class="icon_05">
      <div class="mypage_menu_txt">
        <p class="tit">退会</p>
        <p>会員情報を削除して退会します</p>
      </div>
    </a>
    </li>

  </ul>




</div>
<!--
	<div id="ssl" class="clearfix">
		<span id="ss_gmo_img_wrapper_115-57_image_ja">
			<a href="https://jp.globalsign.com/" target="_blank" rel="nofollow"><img alt="SSL　GMOグローバルサインのサイトシール" border="0" id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_115-57_ja.gif"></a>
		</span>
		<script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_115-57_ja.js" defer="defer"></script>
		<span class="t-left">当サイトはGMOグローバルサイン社のデジタルIDにより証明されています。<br>SSL暗号通信により通信すべてが暗号化されるので、ご記入された内容は安全に送信されます。</span>
	</div>
-->
</div>
<!--{%include file='smarty/common/include/fbnr.tpl'%}-->
<!--{%include file='smarty/common/include/footer.tpl'%}-->

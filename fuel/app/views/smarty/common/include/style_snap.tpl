<!--{%if ($arrStyleSnap['arrPosts']|count) > 0%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_slide m_grey snap">
	<div class="wrap_contents">
		<div class="head_01 clearfix">
			<h2 class="times">STYLE SNAP</h2>
			<a href="<!--{%$mallurl%}-->/stylesnap/" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
		</div>
		<div class="slide_snap owl-carousel <!--{%if count($arrStyleSnap['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
			<!--{%foreach $arrStyleSnap['arrPosts'] as $post%}-->
				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="/mall/<!--{%$post['shop_url']%}-->/stylesnap/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="/stylesnap/?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img src="<!--{%$post['thumb_url']|replace:'dev':'www'%}-->"/>
					<!--{%if $post['flg_shop']%}-->
					<p class="shop_snap times"><!--{%$post['shop_name']%}--></p>
					<!--{%else%}-->
					<p class="shop_snap times"><!--{%$post['last_name']%}--> <!--{%$post['first_name']%}--></p>
					<!--{%/if%}-->
					<div class="tit_snap"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></div>
				</a>
			<!--{%/foreach%}-->
		</div>
		<a href="<!--{%$mallurl%}-->/stylesnap/" class="times btn_viewmore_sp sp_portrait_only">VIEW MORE </a>
	</div>
</section>
<!--{%/if%}-->

<!--{%if ($attention2['arrPosts']|count) > 0%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_slide m_grey snap blog">
	<div class="wrap_contents">
		<div class="head_01 clearfix">
			<h2 class="times">NEWS</h2>
			<a href="<!--{%$mallurl%}-->/news/" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
		</div>
		<div class="slide_snap owl-carousel <!--{%if count($attention2['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
			<!--{%foreach $attention2['arrPosts'] as $post%}-->
				<a class="block" href="/news/?entry=<!--{%$post['ID']%}-->">
				<!--{%if $post['thumb_url'] != ""%}-->
					<img src="<!--{%$post['thumb_url']%}-->"/>
				<!--{%else%}-->
					<img src="/common/images/news/thum_news_01.jpg">
				<!--{%/if%}-->
					<div class="tit_snap"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></div>
				</a>
			<!--{%/foreach%}-->
		</div>
		<a href="<!--{%$mallurl%}-->/news/" class="times btn_viewmore_sp sp_portrait_only">VIEW MORE </a>
	</div>
</section>
<!--{%/if%}-->

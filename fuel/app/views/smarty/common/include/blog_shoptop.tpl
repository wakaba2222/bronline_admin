<!--{%if ($arrBlog['arrPosts']|count) > 0%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_slide m_grey snap blog">
	<div class="wrap_contents">
		<div class="head_01 clearfix">
			<h2 class="times">BLOG</h2>
			<a href="<!--{%$mallurl%}-->/blog/" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
		</div>
		<div class="slide_snap owl-carousel <!--{%if count($arrBlog['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
			<!--{%foreach $arrBlog['arrPosts'] as $post%}-->
				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="<!--{%$mallurl%}-->/blog/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="/blog/?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img src="<!--{%$post['thumb_url']%}-->"/>
					<div class="tit_snap"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}-->　｜　<!--{%$post['last_name']%}--><!--{%$post['first_name']%}--></span></div>
				</a>
			<!--{%/foreach%}-->
		</div>
		<a href="<!--{%$mallurl%}-->/blog/" class="times btn_viewmore_sp sp_portrait_only">VIEW MORE </a>
	</div>
</section>
<!--{%/if%}-->

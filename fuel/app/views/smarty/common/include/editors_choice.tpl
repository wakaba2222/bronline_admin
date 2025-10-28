<!--{%if ($arrEditorsChoice['arrPosts']|count) > 0%}-->
<!--{%assign var=mallurl value=""%}-->
<!--{%if isset($shop_url) && $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_slide editor">
	<div class="wrap_contents">
		<div class="head_01 clearfix">
			<h2 class="times">EDITORS' CHOICE</h2>
			<a href="<!--{%$mallurl%}-->/editorschoice/" class="times fr btn_viewall"><i class="icon-list"></i> VIEW ALL</a>
		</div>
		<div class="slide_editor owl-carousel <!--{%if count($arrEditorsChoice['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
			<!--{%foreach $arrEditorsChoice['arrPosts'] as $post%}-->
				<!--{%if $post['flg_shop']%}-->
				<a class="block" href="/mall/<!--{%$post['shop_url']%}-->/editorschoice/?entry=<!--{%$post['ID']%}-->">
				<!--{%else%}-->
				<a class="block" href="/editorschoice/?entry=<!--{%$post['ID']%}-->">
				<!--{%/if%}-->
					<img src="<!--{%$post['thumb_url']|replace:'dev':'www'%}-->"/>
					<p class="shop_editor times"><!--{%$post['last_name']%}--> <!--{%$post['first_name']%}--></p>
					<div class="tit_editor"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></div>
				</a>
			<!--{%/foreach%}-->
		</div>
		<a href="<!--{%$mallurl%}-->/editorschoice/" class="times btn_viewmore_sp sp_portrait_only">VIEW MORE </a>
	</div>
</section>
<!--{%/if%}-->

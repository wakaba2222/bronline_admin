<!--{%*$post|@debug_print_var*%}-->
<!--{%*$user|@debug_print_var*%}-->
<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/blog/">BLOG</a></li>
		<li class="arrow">＞</li>
		<li><!--{%*<a href="/blog/?user_id=<!--{%$user['ID']%}-->">*%}--><!--{%$user['name_en']%}--><!--{%*</a>*%}--></li>
		<li class="arrow">＞</li>
		<li><!--{%$post['post_title']%}--></li>
	</ul>
</div>
<section class="tit_page">
	<!--{%if $user['flg_shop'] %}-->
	<h2 class="times">SHOP BLOG</h2>
	<!--{%else%}-->
	<h2 class="times">BLOG <span class="author">/ <!--{%$user['name_en']%}--></span></h2>
	<!--{%/if%}-->
</section>
<section class="sec_2col l_grey under detail">
	<div class="wrap_contents clearfix">
		<div class="col_left blog">
			<div class="tit_blog_detail">
				<p class="times head_blog">TITLE</p>
				<h2><!--{%$post['post_title']%}--></h2>
				<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
				<div class="addthis_inline_share_toolbox_g5mc"></div>
			</div>
			<div class="article_area">
				<div class="wrap_txt">
					<div class="entry_area">
						<!--{%$post['content']%}-->
					</div>
				</div>
			</div>
			<div class="pager article_detail blog">
				<!--{%if $prev_next['prev'] != ""%}-->
				<a class="prev" href="?entry=<!--{%$prev_next['prev']['ID']%}-->">
					<p><span></span></p>
					<p class="tit"><!--{%$prev_next['prev']['post_title']%}--></p>
				</a>
				<!--{%/if%}-->
				<!--{%if $prev_next['next'] != ""%}-->
				<a class="next" href="?entry=<!--{%$prev_next['next']['ID']%}-->">
					<p class="tit"><!--{%$prev_next['next']['post_title']%}--></p>
					<p><span></span></p>
				</a>
				<!--{%/if%}-->
			</div>
		</div>

		<!--{%include file='smarty/common/include/blog_side_detail.tpl'%}-->
	</div>
</section>

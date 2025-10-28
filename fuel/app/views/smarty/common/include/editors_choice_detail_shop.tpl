<section class="sec_2col l_grey under detail">
	<div class="wrap_contents bread feature">
		<ul>
			<li><a href="/">TOP</a></li>
			<li class="arrow">＞</li>
			<li><a href="/mall/">MALL</a></li>
			<li class="arrow">＞</li>
			<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
			<li class="arrow">＞</li>
			<li><a href="/mall/<!--{%$shop_url%}-->/editorschoice/">EDITORS' CHOICE</a></li>
			<li class="arrow">＞</li>
			<li><!--{%$post['post_title']%}--></li>
		</ul>
	</div>
	<div class="wrap_contents clearfix editor">
		<div class="col_left">
			<div class="article_area editor">
				<div class="wrap_txt">
					<div class="tit">
						<h2><span class="times">EDITORS' CHOICE / <!--{%$post['last_name']%}--><!--{%$post['first_name']%}--></span><!--{%$post['post_title']%}--></h2>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
						<div class="addthis_inline_share_toolbox_g5mc"></div>
					</div>
					<div class="entry_area">
						<!--{%$post['content']%}-->
					</div>
					<div class="sub_info">
						<dl>
							<dt class="times">TAGS</dt>
							<dd class="tag">
								<ul>
									<!--{%foreach $arrTags as $tag %}-->
									<li><a href="/search/?article=<!--{%$tag["name"]|escape:"url"%}-->">＃ <!--{%$tag["name"]%}--></a></li>
									<!--{%/foreach%}-->
								</ul>
							</dd>
						</dl>
					</div>
				</div>
			</div>
			<div class="pager article_detail">
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

		<!--{%include file='smarty/common/include/feature_side_detail.tpl'%}-->
	</div>
</section>

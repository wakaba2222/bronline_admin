<!--{%assign var=mallurl value=""%}-->
<!--{%if $shop_url != ""%}-->
	<!--{%assign var=mallurl value="/mall/`$shop_url`"%}-->
<!--{%/if%}-->
<section class="sec_2col l_grey under detail">
	<div class="wrap_contents bread feature">
		<ul>
			<li><a href="/">TOP</a></li>
			<!--{%if isset($shop_url) && $shop_url != ""%}-->
			<li class="arrow">＞</li>
			<li><a href="/mall/">MALL</a></li>
			<li class="arrow">＞</li>
			<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
			<!--{%/if%}-->
			<li class="arrow">＞</li>
			<li><a href="<!--{%$mallurl%}-->/feature/">FEATURE</a></li>
			<li class="arrow">＞</li>
			<li><!--{%$post['title2']|replace:'[BR]':''%}--></li>
		</ul>
	</div>
	<div class="wrap_contents clearfix">
		<div class="col_left">
			<!--{%*$post|@debug_print_var*%}-->
			<!--{%*$arrTags|@debug_print_var*%}-->
			<div class="article_area">
				<div class="mainvisual"><img src="<!--{%$post['main_image_url']%}-->"></div>
				<div class="wrap_txt">
					<div class="tit">
						<h2><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h2>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
						<div class="addthis_inline_share_toolbox_g5mc"></div>
					</div>
					<div class="entry_area">
						<!--{%if 2 <= $p%}-->
						<p class="tonext"><span class="mont_medi">PAGE　<!--{%$p%}--> / <!--{%$post['inner_page']%}--></span><!--{%$post['page_title']|replace:'[BR]':'<br/>'%}--></p>
						<!--{%/if%}-->
						<!--{%$post['content']%}-->
					</div>
					<!-- ページ分けする場合 ここから -->
					<!--{%if 2 <= $post['inner_page']%}-->
						<!--{%if $p < $post['inner_page']%}-->
							<a class="tonext" href="?entry=<!--{%$entry%}-->&p=<!--{%$p+1%}-->"><span class="mont_medi">NEXT</span><!--{%$post['next_title']|replace:'[BR]':'<br/>'%}--></a>
						<!--{%/if%}-->
						<div class="pager">
							<!--{%if 1 < $p%}-->
							<a class="prev" href="?entry=<!--{%$entry%}-->&p=<!--{%$p-1%}-->"><span></span></a>
							<!--{%/if%}-->
							<!--{%for $pn=1 to $post['inner_page']%}-->
							<a class="<!--{%if $pn==$p%}-->active<!--{%/if%}-->" href="?entry=<!--{%$entry%}-->&p=<!--{%$pn%}-->"><!--{%$pn%}--></a>
							<!--{%/for%}-->
							<!--{%if $p < $post['inner_page']%}-->
							<a class="next" href="?entry=<!--{%$entry%}-->&p=<!--{%$p+1%}-->"><span></span></a>
							<!--{%/if%}-->
						</div>
					<!--{%/if%}-->
					<!-- ページ分けする場合 ここまで -->

					<!--{%if $post['notice'] != ""%}-->
					<div class="pr_area">
						<!--{%$post['notice']%}-->
					</div>
					<!--{%/if%}-->
					<div class="sub_info">
						<!--{%if $post['credit'] != ""%}-->
						<dl>
							<dt class="times">CREDIT</dt>
							<dd><!--{%$post['credit']%}--></dd>
						</dl>
						<!--{%/if%}-->
						<!--{%if $arrTags != ""%}-->
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
						<!--{%/if%}-->
					</div>
				</div>
			</div>
			<div class="wrap_related_article">
				<div class="head_01 tit_jp clearfix">
					<h2>関連特集記事</h2>
				</div>
				<div class="load_list">
					<!--{%foreach $arrRelated['arrPosts'] as $post%}-->
						<!--{%if $post['flg_shop']%}-->
						<a class="cel_feature block" href="/mall/<!--{%$post['shop_url']%}-->/feature/?entry=<!--{%$post['ID']%}-->">
						<!--{%else%}-->
						<a class="cel_feature block" href="/feature/?entry=<!--{%$post['ID']%}-->">
						<!--{%/if%}-->
							<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
							<div class="tit_feature">
								<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
								<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
							</div>
						</a>
					<!--{%/foreach%}-->
				</div>
				<!--{%if 1 < $arrRelated['maxPageNum']%}-->
					<!--{%if $arrRelated['pageNum'] == ""%}-->
						<!--{%assign var=next_page value=1%}-->
					<!--{%else%}-->
						<!--{%assign var=next_page value=$arrRelated['pageNum']+1%}-->
					<!--{%/if%}-->
					<a id="btn_more" href="<!--{%$mallurl%}-->/feature/?entry=<!--{%$entry%}-->&page=<!--{%$next_page%}-->" class="btn_more times">LOAD MORE<i class="icon-arrow_down"></i></a>
					<input type="hidden" id="loading_max_page" value="<!--{%$arrRelated['maxPageNum']%}-->" />
				<!--{%/if%}-->
				<p id="loading" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
			</div>
			<div class="wrap_related_article">
				<div class="head_01 tit_jp clearfix">
					<h2>最新記事</h2>
				</div>
				<div class="load_list2">
					<!--{%foreach $arrLatest['arrPosts'] as $post%}-->
						<!--{%if $post['flg_shop']%}-->
						<a class="cel_feature block" href="/mall/<!--{%$post['shop_url']%}-->/feature/?entry=<!--{%$post['ID']%}-->">
						<!--{%else%}-->
						<a class="cel_feature block" href="/feature/?entry=<!--{%$post['ID']%}-->">
						<!--{%/if%}-->
							<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
							<div class="tit_feature">
								<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
								<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
							</div>
						</a>
					<!--{%/foreach%}-->
				</div>
				<!--{%if 1 < $arrLatest['maxPageNum']%}-->
					<!--{%if $arrLatest['pageNum'] == ""%}-->
						<!--{%assign var=next_page2 value=1%}-->
					<!--{%else%}-->
						<!--{%assign var=next_page2 value=$arrLatest['pageNum']+1%}-->
					<!--{%/if%}-->
					<a id="btn_more2" href="<!--{%$mallurl%}-->/feature/?entry=<!--{%$entry%}-->&page2=<!--{%$next_page2%}-->" class="btn_more times">LOAD MORE<i class="icon-arrow_down"></i></a>
					<input type="hidden" id="loading_max_page2" value="<!--{%$arrLatest['maxPageNum']%}-->" />
				<!--{%/if%}-->
				<p id="loading2" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
			</div>
		</div>

		<!--{%include file='smarty/common/include/feature_side_detail.tpl'%}-->
	</div>
</section>

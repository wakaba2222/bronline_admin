<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li>BLOG</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">BLOG</h2>
</section>
<section class="sec_2col l_grey under">
	<div class="wrap_contents clearfix">
		<div class="col_left clearfix">
			<div class="head_01 clearfix">
				<h2 class="times">MEMBER</h2>
				<ul class="times fr block">
					<li><a href="/blog">LATEST</a></li>
					<li><a href="" class="active">MEMBER</a></li>
				</ul>
			</div>
			<div class="">
				<!--{%foreach $arrData['arrUsers'] as $user%}-->
					<!--{%if $user['last_id'] != ""%}-->
						<!--{%if $user['flg_shop']%}-->
						<a class="cel_blog block matchHeight" href="/mall/<!--{%$user['shop_url']%}-->/blog/?entry=<!--{%$user['last_id']%}-->">
						<!--{%else%}-->
						<a class="cel_blog block matchHeight" href="/blog/?entry=<!--{%$user['last_id']%}-->">
						<!--{%/if%}-->
					<!--{%else%}-->
						<div class="cel_blog block matchHeight">
					<!--{%/if%}-->
						<img class="block" src="<!--{%$user['image_url']%}-->" alt="<!--{%$user['last_name']%}--> <!--{%$user['first_name']%}-->">
						<div class="tit_member t-center">
							<h3><!--{%$user['last_name']%}--> <!--{%$user['first_name']%}--><span class="times"><!--{%$user['list_degree']%}--></span></h3>
							<p class="date">
								<!--{%if $user['last_id'] != ""%}-->
									<!--{%$user['last_date']|date_format:"%Y.%m.%d"%}--> UP
								<!--{%else%}-->
									COMMING SOON
								<!--{%/if%}-->
							</p>
						</div>
					<!--{%if $user['last_id'] != ""%}-->
						</a>
					<!--{%else%}-->
						</div>
					<!--{%/if%}-->
				<!--{%/foreach%}-->
			</div>
		</div>

		<!--{%include file='smarty/common/include/feature_side.tpl'%}-->
	</div>
</section>

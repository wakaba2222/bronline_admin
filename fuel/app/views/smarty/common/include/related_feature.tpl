<!--{%if 0 < count($arrRelated2['arrPosts'])%}-->
<section class="sec_slide justin related feature">
	<div class="wrap_contents">
		<div class="head_01 tit_jp clearfix">
			<h2 class="">関連特集記事</h2>
			<a href="/feature/" class="fr btn_jp">FEATURE TOP</a>
		</div>
		<div class="feature_related clearfix">
			<!--{%foreach $arrRelated2['arrPosts'] as $post%}-->
			<div>
				<a class="block" href="/mall/<!--{%$shop_url%}-->/feature?entry=<!--{%$post['ID']%}-->">
					<img src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
					<div class="wrap_tit_pickup">
						<div class="tit_pickup"><span class="min"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></div>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
					</div>
				</a>
			</div>
			<!--{%/foreach%}-->
		</div>
	</div>
</section>
<!--{%/if%}-->
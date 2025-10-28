

<section class="sec_slide m_purple <!--{%if ($smarty.server.REQUEST_URI == '/index.php' || $smarty.server.REQUEST_URI == '/')%}--> pickuptop<!--{%/if%}-->">
	<!--{%*$arrPickup|@debug_print_var*%}-->
	<div class="wrap_contents">
		<div class="head_01 t-center">
			<h2 class="times">PICK UP</h2>
		</div>
		<div class="slide_pickup owl-carousel <!--{%if count($arrPickup['arrPosts']) <= $smarty.const.CAROUSEL_NO_LOOP %}--> noloop <!--{%/if%}-->">
		<!--{%foreach $arrSpecial as $p%}-->
			<a class="block" href="/mall/<!--{%$p.login_id%}-->">
			<!--{%if $p.thumbnail%}-->
				<img loading="lazy" src="<!--{%$p.thumbnail%}-->"/>
			<!--{%else%}-->
				<img loading="lazy" src="<!--{%$p.img%}-->"/>
			<!--{%/if%}-->
			<!--{%if $p.pickup_name%}-->
				<div class="tit_pickup"><span class="min">SPECIAL STORE OPEN！</span><!--{%$p.pickup_name%}--></div>
			<!--{%else%}-->
				<div class="tit_pickup"><span class="min">SPECIAL STORE OPEN！</span><!--{%$p.shop_name%}--></div>
			<!--{%/if%}-->
			</a>
		<!--{%/foreach%}-->
			<!--{%foreach $arrPickup['arrPosts'] as $post%}-->
			<a class="block" href="/feature/?entry=<!--{%$post['ID']%}-->">
				<img loading="lazy" src="<!--{%$post['thumb_url']|replace:'dev':'www'%}-->"/>
				<div class="tit_pickup"><span class="min"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></div>
			</a>
			<!--{%/foreach%}-->
		</div>
	</div>
</section>

<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/stylesnap/">STYLE SNAP</a></li>
		<li class="arrow">＞</li>
		<li><!--{%$post['post_title']%}--></li>
	</ul>
</div>
<div class="wrap_item_detail clearfix">
	<section class="fr name_area">
		<h3 class="snap_tit"><!--{%$post['post_title']%}--></h3>
		<a href="/stylesnap/?user_id=<!--{%$user['ID']%}-->" class="author inline_b"><!--{%$user['shop_name']%}--> / <!--{%$post['last_name']%}--> <!--{%$post['first_name']%}--></a>
		<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></p>
		<div class="addthis_inline_share_toolbox_g5mc"></div>
	</section>
	<section class="fl">
		<div id="slide_item_detail" class="slider-pro snap">
			<!--{%assign var=slide value=$post['slide']%}-->
			<div class="sp-slides">
				<!--{%for $no=1 to 6%}-->
					<!--{%assign var=img value="image`$no`"%}-->
					<!--{%if $slide[$img] != ""%}-->
						<!--{%if $slide['movie_pos'] == $no && $slide['movie_url'] != ""%}-->
						<div class="sp-slide"><div class="movie"><video class="sp-video" muted loop preload="auto" poster="/common/images/item/video_loader.gif"><source src="<!--{%$slide['movie_url']%}-->" type="video/mp4"></video></div></div>
						<!--{%else%}-->
						<div class="sp-slide"><img class="sp-image" src="<!--{%$slide[$img]%}-->" /></div>
						<!--{%/if%}-->
					<!--{%/if%}-->
				<!--{%/for%}-->
			</div>
			<div class="sp-thumbnails">
				<!--{%for $no=1 to 6%}-->
					<!--{%assign var=img value="image`$no`"%}-->
					<!--{%if $slide[$img] != ""%}-->
						<!--{%if $slide['movie_pos'] == $no && $slide['movie_url'] != ""%}-->
						<div class="sp-thumbnail movie"><img src="<!--{%$slide[$img]%}-->"/></div>
						<!--{%else%}-->
						<div class="sp-thumbnail"><img src="<!--{%$slide[$img]%}-->"/></div>
						<!--{%/if%}-->
					<!--{%/if%}-->
				<!--{%/for%}-->
			</div>
		</div>
	</section>
	<section class="fr style_comment">
		<div class="txt_area">
			<!--{%$post['content']%}-->
		</div>
		<dl class="tag_snap">
			<dt class="times">TAGS</dt>
			<dd>
				<ul>
					<!--{%foreach $arrTags as $tag %}-->
					<li><a href="/search/?article=<!--{%$tag["name"]|escape:"url"%}-->">＃ <!--{%$tag["name"]%}--></a></li>
					<!--{%/foreach%}-->
				</ul>
			</dd>
		</dl>
		<!--{%if !($user['shop_name'] == "" || $user['last_name'] == "" || $user['first_name'] == "" || $user['name_en'] == "" || $user['height'] == "" || $user['weight'] == "" || $user['profile'] == "") %}-->
		<dl class="profile_snap">
			<dt class="times">PROFILE</dt>
			<dd>
				<div class="wrap_profile">
					<!--{%if $user['image_url'] != ""%}-->
						<!--{%assign var="image_url" value=$user['image_url']%}-->
					<!--{%else%}-->
						<!--{%assign var="image_url" value='/common/images/profile_default.jpg'%}-->
					<!--{%/if%}-->
					<p class="photo_profile"><img src="<!--{%$image_url%}-->"></p>
					<div class="name_profile">
						<p class="times shopname"><!--{%$user['shop_name']%}--></p>
						<a href="/stylesnap/?user_id=<!--{%$user['ID']%}-->" class="inline_b name"><!--{%$user['last_name']%}--> <!--{%$user['first_name']%}--> / <!--{%$user['name_en']%}--></a>
						<p class="style"><!--{%$user['height']%}-->センチ / <!--{%$user['weight']%}-->キロ</p>
					</div>
				</div>
				<p class="txt_profile"><!--{%$user['profile']%}--></p>
				<p><a href="/stylesnap/?user_id=<!--{%$user['ID']%}-->" class="underline">このスタッフの他のスタイリングを見る</a></p>
			</dd>
		</dl>
		<!--{%/if%}-->
	</section>
</div>
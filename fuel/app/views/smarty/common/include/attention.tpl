<!--{%if 0 < $attention['recordNum']%}-->
	<!--{%assign var=ticker value=""%}-->
	<!--{%if 1 < $attention['recordNum']%}-->
		<!--{%assign var=ticker value="ticker"%}-->
	<!--{%/if%}-->
	<div class="attention_top <!--{%$ticker%}-->" rel="roll">
		<ul>
		<!--{%foreach $attention['arrPosts'] as $post%}-->
			<li><a href="/news/?entry=<!--{%$post['ID']%}-->"><!--{%$post['post_title']%}--></a></li>
		<!--{%/foreach%}-->
		</ul>
	</div>
<!--{%/if%}-->

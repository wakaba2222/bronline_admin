<!--{%include file='smarty/wptest/header.tpl'%}-->

<section class="tit_page">
	<h2 class="times">FEATURE</h2>
</section>
<section class="sec_2col l_grey under">
	<div class="wrap_contents clearfix">
		<div class="col_left">
			<div class="head_01 clearfix">
				<h2 class="times"><!--{%if $order =="rank"%}-->RANKING<!--{%else%}-->LATEST<!--{%/if%}--></h2>
				<ul class="times fr block">
					<li><a href="feature" class="<!--{%if $order ==""%}-->active<!--{%/if%}-->">LATEST</a></li>
					<li><a href="?order=rank" class="<!--{%if $order =="rank"%}-->active<!--{%/if%}-->">RANKING</a></li>
				</ul>
			</div>
			<div class="load_list">
				<!--{%foreach $arrData['arrPosts'] as $post%}-->
				<a class="cel_feature block" href="?entry=<!--{%$post['ID']%}-->">
					<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['title2']|replace:'[BR]':''%}-->">
					<div class="tit_feature">
						<h3><span class="times"><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></span><!--{%$post['title2']|replace:'[BR]':'<br/>'%}--></h3>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--><!--{%if $post['pr']%}--><span>　｜　Promotion</span><!--{%/if%}--></p>
					</div>
				</a>
				<!--{%/foreach%}-->
			</div>
			<!--{%if $arrData['pageNum'] == ""%}-->
				<!--{%assign var=next_page value=1%}-->
			<!--{%else%}-->
				<!--{%assign var=next_page  value=$arrData['pageNum']+1%}-->
			<!--{%/if%}-->
			<a href="?page=<!--{%$next_page%}-->" class="btn_more times" onclick="return false;">LOAD MORE<i class="icon-arrow_down"></i></a>
			<p class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
			<input type="hidden" id="loading_max_page" value="<!--{%$arrData['maxPageNum']%}-->" />

			<p>取得レコード数 / 総レコード数：<!--{%$arrData['recordNum']%}--> / <!--{%$arrData['maxRecordNum']%}--></p>
			<p>ページ数 / 総ページ数：<!--{%$arrData['pageNum']%}--> / <!--{%$arrData['maxPageNum']%}--></p>
		</div>


		<div class="col_right fixedsticky">
			<a href="" target="_blank" class="hovernone adbnr_side"><img src="/common/images/bnr/adbnr_side_federi.jpg" alt="FEDELI"></a>
			<a href="" target="_blank" class="hovernone adbnr_side"><img class="imgChange2" src="/common/images/bnr/adbnr_side_sample.jpg" alt=""></a>
		</div>

	</div>
</section>

<!--{%include file='smarty/wptest/footer.tpl'%}-->

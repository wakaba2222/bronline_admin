<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="/common/js/cart.js"></script>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
jQuery(function($){
	var url = "/api/keyword.json";

	var data = {type : 2};
	var res = sendApi(url, data, item_search);
	var data = {type : 1};
	var res = sendApi(url, data, article_search);

  function item_search(data)
  {
	console.log(JSON.stringify(data));

    $( "#search_item" ).autocomplete({
      source: data.keyword
    });

  }
  function article_search(data)
  {
	console.log(JSON.stringify(data));

    $( "#search_article" ).autocomplete({
      source: data.keyword
    });
  }
  } );
  
  </script>
<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li>SEARCH</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">SEARCH</h2>
</section>
<section class="area_search">
	<div class="wrap_contents search item">
		<h3>フリーワードからアイテムを検索</h3>
		<div class="wrap_form">
			<p class="search_icon"><img src="/common/images/ico/search_input.png"></p>
			<form method="post" action=""><input type="search" id="search_item" class="search-field ui-autocomplete-input" placeholder="Search" value="" name="word_item" autocomplete="off"></form>
		</div>
		<dl>
			<dt>PICK UP TAGS</dt>
			<dd>
				<ul>
				<!--{%section name=cnt loop=$arrItemw max=10%}-->
					<li><a href="?item=<!--{%$arrItemw[cnt].keyword%}-->">＃ <!--{%$arrItemw[cnt].keyword%}--></a></li>
				<!--{%/section%}-->
				<!--{%foreach $arrItemwTag as $tag%}-->
					<li><a href="?item=<!--{%$tag.keyword%}-->">＃ <!--{%$tag.keyword%}--></a></li>
				<!--{%/foreach%}-->
				</ul>
			</dd>
		</dl>
	</div>
</section>
<section class="area_search m_purple">
	<div class="wrap_contents search">
		<h3>フリーワードから記事を検索</h3>
		<div class="wrap_form">
			<p class="search_icon"><img src="/common/images/ico/search_input.png"></p>
			<form method="post" action="" id="form1"><input type="search" id="search_article" class="search-field ui-autocomplete-input" placeholder="Search" value="" name="word_article"></form>
		</div>
		<dl>
			<dt>PICK UP TAGS</dt>
			<dd>
				<ul>
				<!--{%section name=cnt loop=$arrKiji max=10%}-->
					<li><a href="?article=<!--{%$arrKiji[cnt].keyword%}-->">＃ <!--{%$arrKiji[cnt].keyword%}--></a></li>
				<!--{%/section%}-->
				<!--{%foreach $arrKijiTag as $tag%}-->
					<li><a href="?article=<!--{%$tag.keyword%}-->">＃ <!--{%$tag.keyword%}--></a></li>
				<!--{%/foreach%}-->
				</ul>
			</dd>
		</dl>
	</div>
</section>

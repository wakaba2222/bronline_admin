<script src="/common/js/exif.js"></script>
<script>
$(function(){
	$.fileImageViewer = function() {
        function resizeImage(src, size, callback) {
            var img = new Image();
            img.onload = function() {
                EXIF.getData(img, function() {
                    var dst = _resize(img, size)
                    callback(dst);
                    img = null; // for leak
                });
            };
            img.src = src;
            return;
        }

        // imageObjectから圧縮したbase64dataURLを生成
        function _resize(img, compressSize) {
            var exif = img.exifdata.Orientation
            var raw_width = img.width;
            var raw_height = img.height;
            var canvas = document.createElement('canvas');
            canvas.width = compressSize;
            canvas.height = compressSize;
            var ctx = canvas.getContext('2d');
            ctx.translate(canvas.width / 2, canvas.height / 2);
            switch (exif) {
            case 1:
                break;
            case 2: // vertical flip
                ctx.scale(-1, 1);
                break;
            case 3: // 180 rotate left
                ctx.rotate(Math.PI);
                break;
            case 4: // horizontal flip
                ctx.scale(1, -1);
                break;
            case 5: // vertical flip + 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                ctx.scale(1, -1);
                break;
            case 6: // 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                break;
            case 7: // horizontal flip + 90 rotate right
                ctx.rotate(0.5 * Math.PI);
                ctx.scale(-1, 1);
                break;
            case 8: // 90 rotate left
                ctx.rotate(-0.5 * Math.PI);
                break;
            default:
                break;
            }
            var dx = -canvas.width / 2;
            var dy = -canvas.height / 2;
            var dw = canvas.width;
            var dh = canvas.height;
            var sx = Math.max((raw_width - raw_height) / 2, 0);
            var sy = Math.max((raw_height - raw_width) / 2, 0);
            var sw = Math.min(raw_height, raw_width);
            var sh = Math.min(raw_height, raw_width);
            ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh);
            var url = canvas.toDataURL('image/jpeg');
            ctx = null;
            canvas = null;
            return url;
        }
        return {
            resizeImage : resizeImage
        }
    };

$('div.load_list img.block').each(function(){
	var src = $(this).attr('src');
	console.log(src);
	var img = $(this);
	$.fileImageViewer().resizeImage(src, 592, function(dst){
				console.log("image rotate");
                img.attr("src", dst);
            });
});

});
</script>
<div class="wrap_contents bread">
	<ul>
		<li><a href="/">TOP</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/">MALL</a></li>
		<li class="arrow">＞</li>
		<li><a href="/mall/<!--{%$shop_url%}-->/"><!--{%$shop_name%}--></a></li>
		<li class="arrow">＞</li>
		<li>BLOG</li>
	</ul>
</div>
<section class="tit_page">
	<h2 class="times">SHOP BLOG</h2>
</section>
<section class="sec_2col l_grey under">
	<div class="wrap_contents clearfix">
		<div class="col_left clearfix">
			<div class="head_01 blog">
				<p class="times head_blog">BLOG LIST : <!--{%$shop_name%}--></p>
			</div>
			<div class="load_list">
				<!--{%foreach $arrData['arrPosts'] as $post%}-->
				<a class="cel_bloglist block" href="?entry=<!--{%$post['ID']%}-->">
					<img class="block" src="<!--{%$post['thumb_url']%}-->" alt="<!--{%$post['post_title']|replace:'[BR]':''%}-->">
					<div class="tit_bloglist">
						<h3><!--{%$post['post_title']|replace:'[BR]':'<br/>'%}--></h3>
						<p class="date"><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}-->　｜　<!--{%$post['last_name']%}--><!--{%$post['first_name']%}--></p>
					</div>
				</a>
				<!--{%/foreach%}-->
			</div>
			<!--{%if 1 < $arrData['maxPageNum']%}-->
				<!--{%if $arrData['pageNum'] == ""%}-->
					<!--{%assign var=next_page value=1%}-->
				<!--{%else%}-->
					<!--{%assign var=next_page value=$arrData['pageNum']+1%}-->
				<!--{%/if%}-->
				<a id="btn_more" href="?page=<!--{%$next_page%}-->" class="btn_more times">LOAD MORE<i class="icon-arrow_down"></i></a>
				<input type="hidden" id="loading_max_page" value="<!--{%$arrData['maxPageNum']%}-->" />
			<!--{%/if%}-->
			<p id="loading" class="t-center loading"><img src="/common/images/ico/ajax-loader.gif" alt="loading"></p>
		</div>
		<!--{%include file='smarty/common/include/blog_side_shop.tpl'%}-->
	</div>
</section>

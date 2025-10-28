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

$('p.thum img').each(function(){
	var src = $(this).attr('src');
	console.log(src);
	var img = $(this);
	$.fileImageViewer().resizeImage(src, 280, function(dst){
				console.log("image rotate");
                img.attr("src", dst);
            });
});

});
</script>
<div class="col_right blog">
	<p class="times head_blog">PROFILE</p>
	<img class="block" src="<!--{%$user['image_url']%}-->" alt="<!--{%$user['last_name']%}--> <!--{%$user['first_name']%}-->">
	<h3><!--{%$user['last_name']%}--> <!--{%$user['first_name']%}--></h3>
	<p class="position"><!--{%$user['degree']%}--></p>
	<hr>
	<p class="txt"><!--{%$user['profile']%}--></p>
	<div class="calendar">
		<!--{%$calendar%}-->
	</div>
	<div class="archive">
		<!--{%foreach $arrRelated['arrPosts'] as $post%}-->
		<a href="?entry=<!--{%$post['ID']%}-->" class="wrap_archive">
			<p class="thum"><img src="<!--{%$post['thumb_url']%}-->"></p>
			<p class="tit"><!--{%$post['post_title']%}--><span><!--{%$post['post_date']|date_format:"%Y.%m.%d"%}--></span></p>
		</a>
		<!--{%/foreach%}-->
	</div>
	<div class=free_area>
		<!--{%$user['free_area']%}-->
	</div>
</div>
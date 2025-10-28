/* wishlist-cookie */
$(function(){

	/**********************************
	* お気に入り追加／削除
	***********************************/
	$(".like_item, .like_item_detail").on("click", function() {

		// cookie読み込み
		var strPid = $.cookie("pid");
		var arrPid = [];

		// cookieが読み込めた場合は配列にする
		if( strPid != undefined ) {
			arrPid = strPid.split(",");
		}

		var pid = $(this).attr("data-pid");

		var objTarget = $(this);

		if( objTarget.hasClass('active') ) {
			// 削除
			$.each(arrPid, function( index, val) {
				if( val == pid ) {
					arrPid.splice(index,1);
					return false;
				}
			});
			objTarget.removeClass('active');

		} else {
			// 追加
			arrPid.push(pid);
			objTarget.addClass('active');
		}

		// cookie書き込み
		$.cookie("pid", arrPid, { path: "/" } );

	});


	/**********************************
	* お気に入り削除（mypage用）
	***********************************/
	$(".wish_delete").on("click", function() {

		// cookie読み込み
		var strPid = $.cookie("pid");
		var arrPid = [];

		// cookieが読み込めた場合は配列にする
		if( strPid != undefined ) {
			arrPid = strPid.split(",");
		}

		var pid = $(this).attr("data-pid");

		var objTarget = $(this);

		// 削除
		$.each(arrPid, function( index, val) {
			if( val == pid ) {
				arrPid.splice(index,1);
				return false;
			}
		});
		objTarget.parent().remove();

		if( $(".wishlist .matchHeight").length == 0 ) {
			$html  = '<p class="none_wishlist">現在お気に入りの商品はございません。</p>';
			$html += '<div class="btn_area">';
			$html += '	<a href="#" onclick="history.back(); return false;" class="back_sys block">戻る</a>';
			$html += '</div>';
			$(".wishlist").html($html);
		}

		// cookie書き込み
		$.cookie("pid", arrPid, { path: "/" } );
	});

});


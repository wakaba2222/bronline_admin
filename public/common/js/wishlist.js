/* wishlist */
$(function(){

	/**********************************
	* お気に入り追加／削除
	***********************************/
	$(".like_item, .like_item_detail").on("click", function() {

		var json_data = {
				customer_id: $("#sidemenu_customer_id").attr("data-cid"),
				product_id: $(this).attr("data-pid")
		}

		var objTarget = $(this);

		var url = "addwish";
		if( objTarget.hasClass('active') ) {
			url = "delwish";
		}

		// ajaxによりサーバ処理を呼び出す
		$.ajax({
			type: "post",
			url: "/ajax/"+url,
			cache: false,
			data: JSON.stringify(json_data),
			contentType: 'application/json',
			dataType: "json",

			// 通信成功
			success: function(data) {
				//alert(JSON.stringify(data));
				if( objTarget.hasClass('active') ) {
					objTarget.removeClass('active');
				} else {
					objTarget.addClass('active');
				}
			},

			// 通信エラー
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				if( objTarget.hasClass('active') ) {
					alert("お気に入りの削除に失敗しました。");
				} else {
					alert("お気に入りの追加に失敗しました。");
				}
			}
		});
	});


	/**********************************
	* お気に入り削除（mypage用）
	***********************************/
	$(".wish_delete").on("click", function() {

		var json_data = {
				customer_id: $("#sidemenu_customer_id").attr("data-cid"),
				product_id: $(this).attr("data-pid")
		}

		var objTarget = $(this);

		// ajaxによりサーバ処理を呼び出す
		$.ajax({
			type: "post",
			url: "/ajax/delwish",
			cache: false,
			data: JSON.stringify(json_data),
			contentType: 'application/json',
			dataType: "json",

			// 通信成功
			success: function(data) {
				//alert(JSON.stringify(data));
				objTarget.parent().remove();

				if( $(".wishlist .matchHeight").length == 0 ) {
					$html  = '<p class="none_wishlist">現在お気に入りの商品はございません。</p>';
					$html += '<div class="btn_area">';
					$html += '	<a href="#" onclick="history.back(); return false;" class="back_sys block">戻る</a>';
					$html += '</div>';
					$(".wishlist").html($html);
				}
			},

			// 通信エラー
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("お気に入りの削除に失敗しました。");
			}
		});
	});

});


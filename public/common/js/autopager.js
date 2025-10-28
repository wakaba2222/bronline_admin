/* autopager */
$(function(){

	/********************************************
	 * LOAD MORE クリック
	 ********************************************/
	$('#loading').css('display', 'none');
	$('#btn_more').on('click', function(e){
		var maxpage = $("#loading_max_page").val();

		$.autopager({
			content: '.load_list',// 読み込むコンテンツ
			link: '#btn_more', // 次ページへのリンク
			autoLoad: false,// スクロールの自動読込み解除

			// 読み込み開始イベント
			start: function(current, next){
		    	//alert("start\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next));

		    	$('#loading').css('display', 'block');
		    	$('#btn_more').css('display', 'none');
			},

			// 読み込み完了イベント
			load: function(current, next){
				//alert("load\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next) + "\n maxpage : " + maxpage);

				$('#loading').css('display', 'none');
				$('#btn_more').css('display', 'block');
				$('#btn_more').attr('href', next.url);
				$(this).css('display', 'none').fadeIn("slow");

				var curpage = current.page;
				if( isNaN(curpage)) {
					// mall以下の場合、.pageで取得できないのでurlから取得
					var url = next.url.split('?');
					url = url[1].split('&');
					$.each( url, function( index, val ) {
						param = val.split('=');
						if( param[0] == 'page' ) {
							curpage = param[1];
							return false;
						}
					});
				}

				if( parseInt(curpage) > parseInt(maxpage) ){ //最後のページ
		    		$('#btn_more').hide(); //次ページのリンクを隠す
				}
			}
		});

		$.autopager('load');
	    return false;
	});


	/********************************************
	 * LOAD MORE クリック
	 * ２画面に２つある場合、２つめは以下を使用
	 ********************************************/
	$('#loading2').css('display', 'none');
	$('#btn_more2').on('click', function(e){
		var maxpage2 = $("#loading_max_page2").val();

		$.autopager({
			content: '.load_list2',	// 読み込むコンテンツ
			link: '#btn_more2',		// 次ページへのリンク
			autoLoad: false,		// スクロールの自動読込み解除
			page_arg: 'page2',		// ページ変数名

			// 読み込み開始イベント
			start: function(current, next){
		    	//alert("start\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next));

		    	$('#loading2').css('display', 'block');
		    	$('#btn_more2').css('display', 'none');
			},

			// 読み込み完了イベント
			load: function(current, next){
				//alert("load\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next) + "\n maxpage : " + maxpage2);

				$('#loading2').css('display', 'none');
				$('#btn_more2').css('display', 'block');
				$('#btn_more2').attr('href', next.url);
				$(this).css('display', 'none').fadeIn("slow");

				var curpage = current.page;
				if( isNaN(curpage)) {
					// mall以下の場合、.pageで取得できないのでurlから取得
					var url = next.url.split('?');
					url = url[1].split('&');
					$.each( url, function( index, val ) {
						param = val.split('=');
						if( param[0] == 'page2' ) {
							curpage = param[1];
							return false;
						}
					});
				}

				if( curpage > maxpage2 ){		 //最後のページ
					$('#btn_more2').hide(); //次ページのリンクを隠す
				}
			}
		});

		$.autopager('load');
	    return false;
	});


	/********************************************
	 * LATEST / RANKING クリック
	 ********************************************/
	$('.btn_order').on('click', function(e){
		// ソート名の active 切替
		$(".btn_order").each(function( index, ele) {
			$(ele).removeClass("active");
		});
		$(this).addClass("active");

		var order = $(this).attr("data-order");
		$('.btn_order').attr('href', "?page=1&order="+order);

		$.autopager({
			content: '.load_list',	// 読み込むコンテンツ
			link: '.btn_order', 	// 並び替えのリンク
			autoLoad: false,		// スクロールの自動読込み解除

			// 読み込み開始イベント
			start: function(current, next){
		    	//alert("start\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next));

				$('#loading').css('display', 'block');
		    	$('#btn_more').css('display', 'none');
			},

			// 読み込み完了イベント
			load: function(current, next){
				//alert("load\n current :" + JSON.stringify(current) + "\n next  : " + JSON.stringify(next));

				$('#loading').css('display', 'none');
				$('#btn_more').css('display', 'block');
				$(this).css('display', 'none').fadeIn(600);
				$("#btn_more").attr("href", "?page=2&order="+order);
			}
		});


		$('.load_list').fadeOut(600);
		setTimeout(function(){
			$(".load_list").remove();		// 一覧エリアを削除
			$.autopager('load');
		}, 600);

	    return false;
	});



});


$(window).on('resize load', function(){
    imgChange();
    imgChange2();
});
function imgChange(){
	if($(window).width() < 450) {
        $('.imgChange').each( function(){
            fileName = $(this).attr('src').slice(0,-4);
            fileExtension = $(this).attr('src').substr(-3);
            src = $(this).attr('src');
            $(this).attr('src', (fileName + '_sp' + '.' + fileExtension).replace(/_sp_sp/g,'_sp'))
        });
	}else{
        $('.imgChange').each( function(){
            fileName = $(this).attr('src').slice(0,-4);
            fileExtension = $(this).attr('src').substr(-3);
            src = $(this).attr('src');
            src = (fileName + '_sp' + '.' + fileExtension).replace(/_sp/g,'');
            $(this).attr('src', src);
        });
	}
}
function imgChange2(){
	if($(window).width() < 768) {
        $('.imgChange2').each( function(){
            fileName = $(this).attr('src').slice(0,-4);
            fileExtension = $(this).attr('src').substr(-3);
            src = $(this).attr('src');
            $(this).attr('src', (fileName + '_sp' + '.' + fileExtension).replace(/_sp_sp/g,'_sp'))
        });
	}else{
        $('.imgChange2').each( function(){
            fileName = $(this).attr('src').slice(0,-4);
            fileExtension = $(this).attr('src').substr(-3);
            src = $(this).attr('src');
            src = (fileName + '_sp' + '.' + fileExtension).replace(/_sp/g,'');
            $(this).attr('src', src);
        });
	}
}

/* BODYに、下層ディレクトリ名をIDとして付与 */
$(function(){
	var $dir = location.pathname.split("/")[1];
	$('body').attr('id', $dir);
});

/* SHOP名を、下層ディレクトリ名をclassとして付与 */
$(window).bind("load", function(){
	if(document.URL.match("/mall/")) {
		var $dir = location.pathname.split("/")[2];
		$('body').addClass($dir);
	}

});

/* url判定 navにactiveを付与" */
$(document).ready(function() {
    var activeUrl = location.pathname.split("/")[1];
    navList = $(".gnav").find("a");
    navList.each(function(){
        if( $(this).attr("href").split("/")[1] == activeUrl ) {
        	$(this).addClass("active");
    	};
	});
});

/* filter & sort */
$(function(){
	$('.filter h3').on('click', function() {
		$(this).next().slideToggle();
		$('.sort h3').next().css({"display":"none"});
		$('.sort h3').removeClass('open');
		$(this).toggleClass('open');
		return false;
	});
});
$(function(){
	$('.sort h3').on('click', function() {
		$(this).next().slideToggle();
		$('.filter h3').next().css({"display":"none"});
		$('.filter h3').removeClass('open');
		$(this).toggleClass('open');
		return false;
	});
});
$(window).on('resize', function() {
	if( 'none' == $('.sort h3').css('pointer-events') ){
		$('.sort h3').next().attr('style','');
		$('.sort h3').removeClass('open');
	};
});
$(window).on('resize', function() {
	if( 'none' == $('.filter h3').css('pointer-events') ){
		$('.filter h3').next().attr('style','');
		$('.filter h3').removeClass('open');
	};
});

/* accordion - footer */
$(function(){
	$('.col_fmenu h3').on('click', function() {
		$(this).next().slideToggle();
		$(this).children('.plus').toggleClass('open');
		return false;
	});
});
$(window).on('resize', function() {
	if( 'none' == $('.col_fmenu h3').css('pointer-events') ){
		$('.col_fmenu h3').next().attr('style','');
		$('.col_fmenu h3').children('.plus').removeClass('open');
	};
});

/* accordion - justin */
$(function(){
	$('.item_menu .tit_item_menu').on('click', function() {
		$(this).next().slideToggle();
		$(this).children('.plus').toggleClass('open');
		return false;
	});
});

/* accordion - justin */
$(function(){
	$('.toggle').on('click', function() {
		$(this).next().slideToggle();
		$(this).children('.plus').toggleClass('open');
		return false;
	});
});

/* accordion - item detail */
$(function(){
	$('.accordion dt').on('click', function() {
		$(this).next().slideToggle();
		$(this).children('.plus').toggleClass('open');
		return false;
	});
});

/* accordion - shop header */
$(function(){
	$('.toggle_shopmenu').on('click', function() {
		$(this).next().slideToggle();
		$(this).toggleClass('open');
		return false;
	});
});


/* scroll */
$(function(){
   $('a[href^=#]').click(function() {
      var speed = 1000; // ミリ秒
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});

/* matchHeight */
$(window).on('load resize', function(){
	$('.matchHeight').matchHeight();
});

/* fixedsticky */
$('header, .shadow, .col_right, #header_shop').fixedsticky();


/* page fadein */
$(window).on('pageshow load', function(){
	$('body').removeClass('fadeout');
});
$(function() {
  // ハッシュリンク(#)と別ウィンドウでページを開く場合はスルー
  $('a:not([href^="#"]):not([target]):not(.btn_more):not(.btn_more2):not(.btn_order)').on('click', function(e){
    e.preventDefault(); // ナビゲートをキャンセル
    url = $(this).attr('href'); // 遷移先のURLを取得
    if (url !== '') {
      $('body').addClass('fadeout');  // bodyに class="fadeout"を挿入
      setTimeout(function(){
        window.location = url;  // 0.8秒後に取得したURLに遷移
      }, 600);
    }
    return false;
  });
});

/* showcase */
$(window).on('resize load', function(){
	$("#showcase.owl-carousel").owlCarousel({
		items: 1,
		loop: true,
		autoplay:true,
		autoplayTimeout:5000,
		animateOut: 'fadeOut',
		dots: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				nav: false
			},
			768: {
				nav: true
			}
		}
	});
});

/* showcase mall */
$(window).on('resize load', function(){
	$("#showcase_mall.owl-carousel").owlCarousel({
		items: 1,
		loop: true,
		autoplay:true,
		autoplaySpeed: 500,
		navSpeed: 500,
		autoplayTimeout: 4000,
		dots: true,
		center: true,
		mouseDrag: true,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				margin: 0,
				nav: false,
				autoWidth:false
			},
			768: {
				margin: 0,
				nav: true,
				autoWidth:false
			},
			813: {
				margin: 10,
				nav: true,
				autoWidth:true
			}
		}
	});
});

/* pickup slide */
$(window).on('resize load', function(){
	$(".slide_pickup.owl-carousel").owlCarousel({
		loop: true,
		autoplay: false,
		dots: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				items: 1,
				slideBy: 1,
				margin: 20,
				nav: false,
				center: true,
				stagePadding: 30
			},
			450: {
				items: 2,
				slideBy: 2,
				margin: 20
			},
			768: {
				items: 2,
				slideBy: 2,
				margin: 20,
				nav: true
			},
			813: {
				items: 3,
				slideBy: 3,
				margin: 35,
				nav: true
			}
		}
	});
});

/* justin slide */
$(window).on('resize load', function(){
    justinSlide();
});
function justinSlide(){
	if($(window).width() < 450) {
		$(".slide_justin.owl-carousel").owlCarousel('destroy');
	}else{
		$(".slide_justin.owl-carousel").owlCarousel({
			navSpeed: 150,
			loop: true,
			autoplay: false,
			dots: true,
			nav: true,
			mouseDrag: false,
			navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
			responsive: {
				0: {
					items: 4,
					slideBy: 4,
					margin: 20,
					nav: false
				},
				768: {
					items: 4,
					slideBy: 4,
					margin: 20,
					nav: true
				},
				813: {
					items: 5,
					slideBy: 5,
					margin: 35
				}
			}
		});
	}
}

/* editor&snap slide */
$(window).on('resize load', function(){
	$(".slide_editor.owl-carousel,.slide_snap.owl-carousel").owlCarousel({
		navSpeed: 150,
		loop: true,
		autoplay: false,
		dots: true,
		nav: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy: 2,
				margin: 15,
				nav: false
			},
			450: {
				items: 4,
				slideBy: 4,
				margin: 20,
				nav: false
			},
			768: {
				items: 4,
				slideBy: 4,
				margin: 20,
				nav: true
			},
			813: {
				items: 4,
				slideBy: 4,
				margin: 35,
				nav: true
			}
		}
	});
});

/* スライドアイテムが４つ以下の場合　ここから*/
/* pickup slide */
$(window).on('resize load', function(){
	$(".slide_pickup.owl-carousel.noloop").owlCarousel({
		loop: false,
		autoplay: false,
		dots: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				items: 1,
				slideBy: 1,
				margin: 20,
				nav: false,
				center: true,
				stagePadding: 30
			},
			450: {
				items: 2,
				slideBy: 2,
				margin: 20
			},
			768: {
				items: 2,
				slideBy: 2,
				margin: 20,
				nav: true
			},
			813: {
				items: 3,
				slideBy: 3,
				margin: 35,
				nav: true
			}
		}
	});
});

/* justin slide */
$(window).on('resize load', function(){
    justinSlideNoLoop();
});
function justinSlideNoLoop(){
	if($(window).width() < 450) {
		$(".slide_justin.owl-carousel.noloop").owlCarousel('destroy');
	}else{
		$(".slide_justin.owl-carousel.noloop").owlCarousel({
			navSpeed: 150,
			loop: false,
			autoplay: false,
			dots: true,
			nav: true,
			mouseDrag: false,
			navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
			responsive: {
				0: {
					items: 4,
					slideBy: 4,
					margin: 20,
					nav: false
				},
				768: {
					items: 4,
					slideBy: 4,
					margin: 20,
					nav: true
				},
				813: {
					items: 5,
					slideBy: 5,
					margin: 35
				}
			}
		});
	}
}

/* editor&snap&blog slide */
$(window).on('resize load', function(){
	$(".slide_editor.owl-carousel.noloop, .slide_snap.owl-carousel.noloop").owlCarousel({
		navSpeed: 150,
		loop: false,
		autoplay: false,
		dots: true,
		nav: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				items: 2,
				slideBy: 2,
				margin: 15,
				loop: false,
				nav: false
			},
			450: {
				items: 4,
				slideBy: 4,
				margin: 20,
				loop: false,
				nav: false
			},
			768: {
				items: 4,
				slideBy: 4,
				margin: 20,
				loop: false,
				nav: true
			},
			813: {
				items: 4,
				slideBy: 4,
				margin: 35,
				loop: false,
				nav: true
			}
		}
	});
});
/* スライドアイテムが４つ以下の場合　ここまで*/

/* mall list slide */
$(window).on('resize load', function(){
	$(".slide_mall.owl-carousel").owlCarousel({
		items: 1,
		slideBy: 1,
		navSpeed: 400,
		loop: true,
		autoplay: false,
		dots: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				nav: false,
				margin: 15
			},
			768: {
				nav: true,
				margin: 25
			}
		}
	});
});

/* popup slide */
$(window).on('resize load', function(){
	$(".slide_popup.owl-carousel").owlCarousel({
		items: 1,
		slideBy: 1,
		navSpeed: 400,
		loop: true,
		autoplay: false,
		dots: true,
		mouseDrag: false,
		navText: ['<i class="icon-arrow_prev"></i>','<i class="icon-arrow_next"></i>'],
		responsive: {
			0: {
				nav: false
			},
			768: {
				nav: true
			}
		}
	});
});

/* itemdetail slide */
$(function(){
	$('.item_slide').photoSwipe();
});
$(document).ready(function() {
	$('#slide_item_detail').sliderPro({
		responsive: true,
		width: '560',
		autoHeight: true,
		arrows: true,
		fadeArrows: false,
		buttons: true,
		slideDistance:0,
		autoplay: false,
		heightAnimationDuration: 0,
		reachVideoAction: 'playVideo',
		thumbnailWidth: '85', //サムネイルの幅の設定 初期:100
		thumbnailHeight: '113',
		thumbnailPointer: true
	});
});
 
/* drawer-menu */
$(function(){
    var touch = false;
    $('.drawer-toggle').on('click touchstart',function(e){
        switch (e.type) {
            case 'touchstart':
                drawerToggle();
                touch = true;
                return false;
            break;
            case 'click':
                if(!touch)
                     drawerToggle();
                return false;
            break;
         }
        function drawerToggle(){
            $('body').toggleClass('drawer-opened');
            scroll = $(window).scrollTop();
			$('body').css({"overflow":"hidden","height":"100%",'top': -scroll});
            touch = false;
        }
    })
    $('#overlay, .drawer-menu li.logo .close').on('click touchstart',function(){
        $('body').removeClass('drawer-opened');
        $('body').css({"overflow":"visible","height":"auto"});
		$(window).scrollTop(scroll);
    })
});

/* news ticker */
$(function(){
	$(window).load(function(){
		var $setElm = $('.ticker');
		var effectSpeed = 1000;
		var switchDelay = 3000;
		var easing = 'swing';

		$setElm.each(function(){
			var effectFilter = $(this).attr('rel');

			var $targetObj = $(this);
			var $targetUl = $targetObj.children('ul');
			var $targetLi = $targetObj.find('li');
			var $setList = $targetObj.find('li:first');

			var ulWidth = $targetUl.width();
			var listHeight = $targetLi.height();
			$targetObj.css({height:(listHeight)});
			$targetLi.css({top:'0',left:'0',position:'absolute'});

			if(effectFilter == 'fade') {
				$setList.css({display:'block',opacity:'0',zIndex:'98'}).stop().animate({opacity:'1'},effectSpeed,easing).addClass('showlist');
				setInterval(function(){
					var $activeShow = $targetObj.find('.showlist');
					$activeShow.animate({opacity:'0'},effectSpeed,easing,function(){
						$(this).next().css({display:'block',opacity:'0',zIndex:'99'}).animate({opacity:'1'},effectSpeed,easing).addClass('showlist').end().appendTo($targetUl).css({display:'none',zIndex:'98'}).removeClass('showlist');
					});
				},switchDelay);
			} else if(effectFilter == 'roll') {
				$setList.css({top:'3em',display:'block',opacity:'0',zIndex:'98'}).stop().animate({top:'0',opacity:'1'},effectSpeed,easing).addClass('showlist');
				setInterval(function(){
					var $activeShow = $targetObj.find('.showlist');
					$activeShow.animate({top:'-3em',opacity:'0'},effectSpeed,easing).next().css({top:'3em',display:'block',opacity:'0',zIndex:'99'}).animate({top:'0',opacity:'1'},effectSpeed,easing).addClass('showlist').end().appendTo($targetUl).css({zIndex:'98'}).removeClass('showlist');
				},switchDelay);
			} else if(effectFilter == 'slide') {
				$setList.css({left:(ulWidth),display:'block',opacity:'0',zIndex:'98'}).stop().animate({left:'0',opacity:'1'},effectSpeed,easing).addClass('showlist');
				setInterval(function(){
					var $activeShow = $targetObj.find('.showlist');
					$activeShow.animate({left:(-(ulWidth)),opacity:'0'},effectSpeed,easing).next().css({left:(ulWidth),display:'block',opacity:'0',zIndex:'99'}).animate({left:'0',opacity:'1'},effectSpeed,easing).addClass('showlist').end().appendTo($targetUl).css({zIndex:'98'}).removeClass('showlist');
				},switchDelay);
			}
		});
	});
});

/* send-option */
$(function(){
  $('#login_memory').change(function(){
    $('.send-option').slideToggle(500);
  })
})

/* added cart */
$(function(){
	/*
	$('.btn_addcart').on('click', function() {
		$('.added_cart').fadeIn();
		return false;
	});
	*/
	$('.close.added,.btn_added.close').on('click', function() {
		$('.added_cart').fadeOut();
		return false;
	});
});

/* 文字数制限 */
$(function(){
    var $setElm = $('.attention_top ul li a');
    var cutFigure = '30'; // カットする文字数
    var afterTxt = '…'; // 文字カット後に表示するテキスト
 
    $setElm.each(function(){
        var textLength = $(this).text().length;
        var textTrim = $(this).text().substr(0,(cutFigure))
 
        if(cutFigure < textLength) {
            $(this).html(textTrim + afterTxt).css({visibility:'visible'});
        } else if(cutFigure >= textLength) {
            $(this).css({visibility:'visible'});
        }
    });
});
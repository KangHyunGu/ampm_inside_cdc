//올림피아
$(window).scroll(function () {
	if ($(this).scrollTop() > 300) {
		$('.text').fadeIn();
	} else {
		$('.text').fadeOut();
	}
});


$(document).ready(function() {
	$('.monts_fontB').click(function(){			
		//animate()메서드를 이용해서 선택한 태그의 스크롤 위치를 지정해서 0.4초 동안 부드럽게 해당 위치로 이동함 	        
		$('html, body').animate({
			scrollTop : $('#lastod_cate').offset().top}, 2000);		//상품위치까지 스크롤처리
	});	
});

$(window).scroll(function() {
	var now_scroll = $(this).scrollTop();
	var target_banner = Math.ceil($('.banner').offset().top)-$('.banner').height();
console.log(now_scroll);
console.log(target_banner);
	if (now_scroll > target_banner) {
		$('.wrap1').fadeOut("slow");
	}else{
		$('.wrap1').fadeIn("slow");
	}
});

/* use map */
jQuery(document).ready(function(e) {
	jQuery('img[usemap]').rwdImageMaps();
});

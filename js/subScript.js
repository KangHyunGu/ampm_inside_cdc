/* sub 인기글 슬라이드 */
$(document).ready(function(){
   $('.lank_slider').slick({
      dots: false,
      prevArrow: $('.lank_slider_btn .prev'),
      nextArrow: $('.lank_slider_btn .next'),
      infinite: true,
      autoplay: true,
      autoplaySpeed : 3000,
      speed: 800,
      slidesToShow: 3,
      slidesToScroll: 3
   });
});


/* 로그인 탭메뉴 */
$(document).ready(function(){
	$('ul.login_tab li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.login_tab li').removeClass('on');
		$('.con_box').removeClass('on');

		$(this).addClass('on');
		$("#"+tab_id).addClass('on');
	});
});


/* 게시판 list 최신순/인기순 */
$(document).ready(function ($) {
   var url = window.location.href;
   var activePage = url;
   $('.bo_cate_top .bo_sort a').each(function () {
       var linkPage = this.href;

       if (activePage == linkPage) {
         $(this).closest("li").addClass("on");
       }
   });
});

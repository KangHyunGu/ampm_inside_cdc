$(document).ready(function(){

    /* 메인 탭메뉴 스크립트 */
   $('.main_insight .tab_link').click(function(e){
       var tabID = $(this).attr('data-tab');

       $('.main_insight .tab_link').removeClass('active');
       $('.main_insight .con_box').removeClass('active');

       $(this).addClass('active');
       $("#"+tabID).addClass('active');

       e.preventDefault();
       return false;
    });

   $('.main_video .tab_link').click(function(e){
      var tabID = $(this).attr('data-tab');

      $('.main_video .tab_link').removeClass('active');
      $('.main_video .con_box').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');

      e.preventDefault();
      return false;

   });

   $('.main_qna .tab_link').click(function(e){
      var tabID = $(this).attr('data-tab');

      $('.main_qna .tab_link').removeClass('active');
      $('.main_qna .con_box').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');

      e.preventDefault();
      return false;

   });

   $('.main_refer .tab_link').click(function(e){
      var tabID = $(this).attr('data-tab');

      $('.main_refer .tab_link').removeClass('active');
      $('.main_refer .con_box').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');
      e.preventDefault();
      return false;
   });


    /* 메인 금주의마케터 슬라이드 */
   $('.slide_wrapper').slick({
        dots: false,
        prevArrow: $('.prev'),
        nextArrow: $('.next'),
        infinite: true,
        autoplay: true,
        autoplaySpeed : 3000,
        speed: 800,
        slidesToShow: 2,
        slidesToScroll: 2
    });

   $('ul.login_tab li').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('ul.login_tab li').removeClass('on');
        $('.con_box').removeClass('on');

        $(this).addClass('on');
        $("#"+tab_id).addClass('on');
    });

    // 카테고리고정
    $(window).scroll(function(){
        var sticky = $('.ca_sticky'),
            scroll = $(window).scrollTop();

        if (scroll >= 60) sticky.addClass('ca_fixed');
        else sticky.removeClass('ca_fixed');
    });

    $(window).scroll(function(){
        var sticky = $('.mp_ca_sticky'),
            bottom = $('.b_mp_ca'),
            scroll = $(window).scrollTop();

        if (scroll >= 100){ sticky.show(),
                           bottom.hide();
        }else{sticky.hide(),
              bottom.show();
        } 
    });

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
        slidesToShow: 2,
        slidesToScroll: 2
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
});


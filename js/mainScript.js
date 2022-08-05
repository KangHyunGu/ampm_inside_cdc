/* 메인 탭메뉴 스크립트 */
$(document).ready(function(){
   $('.main_insight .tab_link').click(function(){
       var tabID = $(this).attr('data-tab');

       $('.main_insight .tab_link').removeClass('active');
       $('.main_insight .tab_content').removeClass('active');

       $(this).addClass('active');
       $("#"+tabID).addClass('active');
   });

   $('.main_video .tab_link').click(function(){
      var tabID = $(this).attr('data-tab');

      $('.main_video .tab_link').removeClass('active');
      $('.main_video .tab_content').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');
   });

   $('.main_qna .tab_link').click(function(){
      var tabID = $(this).attr('data-tab');

      $('.main_qna .tab_link').removeClass('active');
      $('.main_qna .tab_content').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');
   });

   $('.main_reference .tab_link').click(function(){
      var tabID = $(this).attr('data-tab');

      $('.main_reference .tab_link').removeClass('active');
      $('.main_reference .tab_content').removeClass('active');

      $(this).addClass('active');
      $("#"+tabID).addClass('active');
   });
});


/* 메인 금주의마케터 슬라이드 */
$(document).ready(function(){
   $('.slide_wrapper').slick({
      dots: false,
      prevArrow: $('.prev'),
      nextArrow: $('.next'),
      infinite: true,
      autoplay: true,
      autoplaySpeed : 3000,
      speed: 800,
      slidesToShow: 5,
      slidesToScroll: 5
   });
});
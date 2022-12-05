// header addclass
$(window).scroll(function(){
    var topPos=$(document).scrollTop();
    
    $('#scroll').text(topPos);
    if(topPos>50) {
        $('#header').addClass('on');
        $('#ft-btn').addClass('on');
    } else {
        $('#header').removeClass('on');
        $('#ft-btn').removeClass('on');
    }
});

// 상단으로
$(function() {
    $(".top-btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});


// all menu icon
$(document).ready(function(){
    $('.all-menu-icon').click(function(){
        $(this).toggleClass('open');
        $('#all_menu').toggleClass('open');
    });
});


/* a태그 부드럽게 이동 */
$(document).ready(function(){
    $('.quick-nav a').click(function(e){
        e.preventDefault(); // 버벅거림 빼기
        $('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);
    });
})


/* family site */
$(document).ready(function() {
    $('.family-tab').click(function(){
        $(this).parent().toggleClass("open");
        $('.icoArrow img').toggleClass("open");
    });
});


/* 상담문의 */
$(document).ready(function() {
    $('.popup-btn').click(function(){
        $('#modal-inquiry').toggleClass("open");
    });
});


$(function() {
	//미사용인거 같아서 주석처리 -- feeris
	//AOS.init();
});
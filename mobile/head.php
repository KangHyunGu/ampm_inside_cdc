<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

///////////////////////////////////////////////////////////////////
//인기글가져오기  - feeris
///////////////////////////////////////////////////////////////////
include_once(G5_LIB_PATH.'/latest_popular.lib.php');
?>

<header id="hd" class="sticky">
    <!-- <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div class="to_content"><a href="#container">본문 바로가기</a></div>-->

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        // include G5_MOBILE_PATH.'/newwin.inc.php';
        // 팝업레이어
    } ?>
 
    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>">
                <img src="<? G5_URL?>/images/logo.png" alt="<?php echo $config['cf_title']; ?>">
            </a>
        </div>

        <button type="button" id="menu_open" class="hd_opener">
            <span class="sound_only"> 메뉴열기</span>
            <div class="open_icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>

    <div id="menu" class="hd_div">
        <div class="top">
                <button type="button" id="menu_close" class="hd_closer">
                    <span class="sound_only">메뉴 닫기</span>
                    <div class="close_icon">
                        <span></span>
                        <span></span>
                    </div>
                </button>
        </div>
        <div class="bottom">
            <?php include(G5_PATH.'/inc/_inc_login.php'); ?>

            <div class="menu_gnb">
                <ul>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=insight">마케터 인사이트</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=video">영상 교육</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=reference">마케팅 레퍼런스</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=qna">질문답변</a>
                    </li>
                    <li>
                        <a href="<?=G5_URL?>/marketer/#section4">마케터 소개</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <script>
        $(function () {
            //폰트 크기 조정 위치 지정
            var font_resize_class = get_cookie("ck_font_resize_add_class");
            if( font_resize_class == 'ts_up' ){
                $("#text_size button").removeClass("select");
                $("#size_def").addClass("select");
            } else if (font_resize_class == 'ts_up2') {
                $("#text_size button").removeClass("select");
                $("#size_up").addClass("select");
            }

            $(window).scroll(function(){
                var sticky = $('.sticky'),
                    scroll = $(window).scrollTop();

                if (scroll >= 60) sticky.addClass('fixed');
                else sticky.removeClass('fixed');
                });

            $(".hd_closer").on("click", function() {
                var idx = $(".hd_closer").index($(this));
                $(".hd_div").animate({left: '150vw'});
            });

            $(".hd_opener").on("click", function() {
                var idx = $(".hd_opener").index($(this));
                $(".hd_div").animate({left: '0'});
            });


            $(".btn_gnb_op").click(function(){
                $(this).toggleClass("btn_gnb_cl").next(".gnb_2dul").slideToggle(300);
                
            });

        });
    </script>

</header>
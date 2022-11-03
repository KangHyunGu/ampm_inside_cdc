<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php
if (G5_IS_MOBILE) { 
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}
?>

<?php
include_once('./_head.php');
?>

<?php
include(G5_PATH.'/inc/top.php');
?>


<div id="container">
    <!-- 좌측 컨텐츠 영역 -->
    <section class="section_left">
        <!-- 비주얼 배너 -->
        <div class="visual_banner">
            <a href="https://www.youtube.com/c/%EB%A7%88%EC%BC%80%ED%8C%85%ED%95%99%EA%B5%90AMPM" target="_blank">
               <!--<img src="<? G5_URL ?>/images/main_banner.jpg" alt="마케팅학교 유튜브 바로가기">-->
               <img src="<? G5_URL ?>/images/main_banner.gif" alt="마케팅학교 유튜브 바로가기">
            </a>
        </div>


        <!-- 마케터 인사이트 인기순/최신순 -->
        <div class="main_insight">
            <div class="main_tab_con">
                <div class="type_popular con_box">
                    <!-- 인기순 -->
					<?php echo latest_popular("popular", 'insight', 8, 25, 1, 'wr_hit desc', 'Y');?>
                </div>
                <div class="type_new con_box">
                    <!-- 최신순 -->
                    <?php echo latest('list', 'insight', 8, 25);?>
                </div>
            </div>
        </div>

        <!-- 영상교육 인기순/최신순 -->
        <div class="main_video">
            <div class="title_box">
                <h3>영상교육</h3>
                <a href="<? G5_URL ?>/bbs/board.php?bo_table=video" class="video_more">더보기 <span>></span></a>
                <div class="main_tab">
                    <ul class="main_tab_nav">
                        <li class="tab_link active" data-tab="tab-3">인기순</li>
                        <li class="tab_link" data-tab="tab-4">최신순</li>
                    </ul>
                </div>
            </div>
            <div class="main_tab_con">
                <!-- 인기순 -->
                <div id="tab-3" class="tab_content active">
                    <?php echo latest_popular("pop_video", 'video', 8, 46, 1, 'wr_hit desc', 'Y');?>
                </div>
                <!-- 최신순-->
                <div id="tab-4" class="tab_content">
                    <?php echo latest('pic_video', 'video', 8, 46);?>
                </div>
            </div>
         </div>


         <!-- 금주의 추천 마케터 10명 -->
         <div class="main_marketer">
            <div class="title_box">
                <h3>금주의 추천 마케터</h3>
                <a href="<? G5_URL ?>/marketer/#section4" class="mkt_more">더보기 <span>></span></a>
            </div>
            <div class="mkt_slider">
                <div class="slide_wrapper">
					<?php include_once(G5_PATH.'/inc/_marketerInfo.php'); ?>
					<?php echo latest_maketer(8); ?>

                 </div>
                <div class="pager">
                    <div class="prev pager_btn">
                        <i class="fa-solid fa-angle-left"></i>
                    </div>
                    <div class="next pager_btn">
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                </div>
            </div>
         </div>
   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>


<?php
//풋터
include_once('./_tail.php');
?>
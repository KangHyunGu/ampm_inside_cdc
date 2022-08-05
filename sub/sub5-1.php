<?php
include_once('./_common.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MOBILE_PATH.'/sub/sub1-1.php');
    return;
}

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
            <img src="<? G5_URL ?>/images/sub_banner5.jpg" alt="마케터소개 배너">
        </div>


        <!-- 레퍼런스 게시판 -->
        <div class="sub5">
            <!-- 게시판 스킨 불러오는 곳 -->
        </div>
   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>

<?php
//풋터
include_once('./_tail.php');
?>
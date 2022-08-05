<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

$g5['title'] = "상담문의";
?>
<?php
//마케터 고유코드 없는 경우 마케터 리스트로 리다이렉트
include(G5_MARKETER_PATH.'/inc/_utm_member.php');
?>

<?php
////////////////////////////////////////////////////////////////////
//마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
include(G5_MARKETER_PATH.'/inc/_marketer_info.php');
?>

<?php
include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_header.php');
?>

<!-- S: 컨텐츠 -->
<section id="sub-common">
    <div class="wrap">  
        <div class="common-info">
            <div class="member-title">
                <h3 class="main-color">Customer Service</h3>
                <h2>상담문의</h2>
            </div>
            <div class="member-info">
                <!-- 마케터 이미지 -->
                <div class="mkt-img">
                    <?=$mb_images?>
                </div>
                <ul>
                    <li>
                        <span><i class="fas fa-mobile-alt"></i></span>
                        <p><?=$mb['mb_tel'] ?></p>
                    </li>

                    <?php if($mb['mb_kakao']){ ?>
                    <li>
                        <span><i class="fab fa-kaggle"></i></span>
                        <p><?=$mb['mb_kakao'] ?></p>
                    </li>
                    <?php } ?>

                    <li>
                        <span><i class="fas fa-envelope"></i></span>
                        <p><?=$mb['mb_email'] ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- S: 컨텐츠 -->
<section id="sub-layout">
    <div class="wrap customer">
        <div class="layout">
            <?php
               //상담신청하기 include
               include(G5_MARKETER_PATH.'/inc/m_quick_estimate.php');
            ?>
         </div>
    </div>
</section>
<!-- E: 컨텐츠 -->


<!-- footer -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
<?php
//풋터
include_once('./_tail.php');
?>
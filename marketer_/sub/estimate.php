<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/estimate.php');
    return;
}

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
                <h3 class="main-color">Marketer Profile</h3>
                <h2><?php echo ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO"; ?></h2>
            </div>
            <div class="member-info">
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

<section id="sub-layout">
    <div class="wrap">
        <div class="layout">

            <?php
            //상담신청하기 include
            include(G5_MAERKETER_PATH.'/inc/m_quick_estimate.php');
            ?>

        </div>
    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
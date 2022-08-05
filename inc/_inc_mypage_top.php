<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

///////////////////////////////////////////////////////////////////////
// 로그인 후 정보 처리
///////////////////////////////////////////////////////////////////////
include(G5_PATH.'/inc/_inc_loginMeberInfo.php'); 

?>
<!-- 마이페이지 네임카드 -->
<div class="mp_top">
    <h3>마이페이지</h3>
    <ul>
        <li>
            <div class="nc_img">
                <?php echo $mb_images; ?>
            </div>
            <div class="title">
                <h2><?php echo $mb_slogan ?></h2>
                <h1><?php echo $nick ?></h1>
            </div>
        </li>
        <li class="button">
            <div><a href="<?php echo G5_BBS_URL ?>/logout.php" class="logout_bt">로그아웃</a></div>
            <div><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="main_color ed_profile_bt"><?=($member['ampmkey'] == 'Y')?'프로필수정':'내 정보 수정'?></a></div>
        </li>
    </ul>
</div>


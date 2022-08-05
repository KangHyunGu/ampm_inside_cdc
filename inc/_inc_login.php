<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>
    <? if (!$member['mb_id']) { ?>

<!-- 로그인 전 -->
<div class="login_box">
    <h2>로그인 후 이용하세요.</h2>
    <a class="login_btn" href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>

    <div class="login_bt_btn">
        <a class="register_btn" href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a>
        <a class="lost" href="<?php echo G5_BBS_URL ?>/password_lost.php">패스워드 찾기</a>
    </div>

</div>

<? } else { ?>  

<!-- 로그인 후 -->
<?php echo outlogin("basic"); // 외부 로그인  ?>
<!-- 마케터, 사용자 각각 다른 스킨필요 -->

<? } ?>

<?php
}else{	//PC인 경우
?>

    <? if (!$member['mb_id']) { ?>

    <!-- 로그인 전 -->
    <div class="login">
    <h2>로그인 후 이용하세요.</h2>
    <a class="login_btn" href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>

    <div class="login_bt_btn">
        <a class="register_btn" href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a>
        <a class="lost" href="<?php echo G5_BBS_URL ?>/password_lost.php">패스워드 찾기</a>
    </div>
    </div>

    <? } else { ?>  

    <!-- 로그인 후 -->
    <?php echo outlogin("basic"); // 외부 로그인  ?>
    <!-- 마케터, 사용자 각각 다른 스킨필요 -->

    <? } ?>

<?php
}
?>


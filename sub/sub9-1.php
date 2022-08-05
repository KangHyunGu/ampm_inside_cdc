<!-- 일반사용자 마이페이지 네임카드 -->
<div class="mp_top">
    <h3>마이페이지</h3>
    <ul>
        <li>
            <div class="nc_img">
                <?php echo $mb_images; ?>
            </div>
            <div class="title">
                <h2><?php echo $mb_slogan ?></h2>
                <h3><?php echo $nick ?></h3>
                <div class="count">
                    <p>
                        내가 쓴 글 <span class="main_color">00</span>개
                    </p>
                    <p>
                        내가 쓴 댓글 <span class="main_color">00</span>개
                    </p>
                </div>
            </div>
        </li>
        <li class="button">
            <div><a href="<?php echo G5_BBS_URL ?>/logout.php" class="logout_bt">로그아웃</a></div>
            <div><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="main_color ed_profile_bt"><?=($member['ampmkey'] == 'Y')?'프로필수정':'내 정보 수정'?></a></div>
        </li>
    </ul>
</div>


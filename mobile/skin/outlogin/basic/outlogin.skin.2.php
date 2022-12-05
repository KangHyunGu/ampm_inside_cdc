<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);

///////////////////////////////////////////////////////////////////////
// 로그인 후 정보 처리
///////////////////////////////////////////////////////////////////////
include(G5_PATH.'/inc/_inc_loginMeberInfo.php'); 
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<section id="ol_after" class="ol">

    <div class="profile_box">
        <div class="info">
            <div class="p_info">
                <div class="p_img">
                    <?php echo $mb_images; ?>
                </div>
                <div class="p_name">
                    <!-- 이름 -->
                    <h3><?php echo $nick ?></h3>
                    <!-- 소속 팀 -->
                    <p><?php echo $team ?></p>
                    <!-- PR 문구 -->
                    <p class="pr"><?php echo cut_str(get_text($mb_slogan), 14) ?></p>
                </div>
            </div>
			<?php  if($is_admin=='super' || $is_admin=='manager' || $member['ampmkey'] == 'Y'){   //마케터 ?>
			<div class="button ch_info">
				<a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="ol_after_info">프로필수정</a>
			</div>
			<?php } ?>
        </div>

        <?php if($is_admin=='super' || $is_admin=='manager' || $member['ampmkey'] == 'Y'){   //마케터 ?>
            
            <div class="p_m_menu">
                <ul id="ol_after_private" class="w-box">
                    <li>
                        <span class="pop">
                            <?=get_record_alarm('insight', $member['mb_id'])?>
                        </span><!-- 업로드등록 알람 -->
                       <a href="<?=$go_amypage?>">
                            <i class="fas fa-house-user"></i>
                            <span>마이페이지</span>
                        </a>
                    </li>
                    <li>
                        <span class="pop">
                            <?=get_record_alarm('qna', $member['mb_id'])?>
                        </span><!-- 답변대기 알람 -->
                        <a href="<?=$go_qna?>">
                            <i class="fas fa-question-circle"></i>
                            <span>답변대기</span>
                        </a>
                    </li>
                    <li>
                        <span class="pop">
                            <?=get_record_alarm('request', $member['mb_id'])?>
                        </span> <!-- 대행의뢰 알람 -->
                        <a href="<?=$go_reqeust?>">
                            <i class="fas fa-edit"></i>
                            <span>대행의뢰</span>
                        </a>
                    </li>
                    <li>
                        <span class="pop">
                            <?=get_record_alarm('mkestimate', $member['mb_id'])?>
                        </span> <!-- 상담현황 알람 -->
                        <a href="<?=$go_estimate?>">
                            <i class="fa-solid fa-headset"></i>
                            <span>상담현황</span>
                        </a>
                    </li>
                </ul>
            </div>

        <?php } else {    //광고주 ?>

            <div class="p_menu">
                <ul id="ol_after_private" class="w-box">
                    <li>
                        <a href="<?=$go_umypage?>">
                            <i class="fas fa-house-user"></i>
                            <span>마이페이지</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php">
                            <i class="fa-solid fa-address-card"></i>
                            <span>내 정보 수정</span>
                        </a>
                    </li>
                </ul>
            </div>

        <?php } ?>
    </div>
    
    <div class="logout">
       <a class="logout_btn" href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout">로그아웃</a>
    </div>

</section>

<script>
    // 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
    function member_leave()
    {
        if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
            location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
    }
</script>
<!-- } 로그인 후 아웃로그인 끝 -->

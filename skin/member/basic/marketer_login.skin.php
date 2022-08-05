<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!--<link rel="stylesheet" href="<?=$member_skin_url?>/style.css">-->
<section id="section1">

	<!-- 로그인 시작 { -->
	<div id="mb_login" class="mbskin">
		<h1><?php echo $g5['title'] ?></h1>

		<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
		<input type="hidden" name="url" value="<?php echo $login_url ?>">

		<fieldset id="login_fs">
			<legend>사원로그인</legend>
            <div class="login_custom">
                <div class="logbox id">
                    <label for="login_id">사원아이디<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="mb_id" id="login_id" required class="frm_input required" value="<?=($utm_member)?$utm_member:''?>" size="20" maxLength="20" placeholder="아이디">
                </div>
            <div class="logbox pw">
                <label for="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
                <input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호">
			</div>
            <div class="login_btn">
                <input type="submit" value="로그인" class="btn_submit">
            </div>
		</fieldset>
		</form>


	</div>

</section>
<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->

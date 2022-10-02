<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->
<div class="register">
   <div class="wrap">

      <h1 class="register_title">회원정보수정</h1>

   <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
   <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
   <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
   <?php } ?>

	<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">
	<input type="hidden" name="agree" value="<?php echo $agree ?>">
	<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
	<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
	<input type="hidden" name="cert_no" value="">
	<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
	<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
	<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
	<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
	<?php }  ?>
	
	<div id="register_form" class="form_01">   
	    <div class="register_form_inner">
	        <ul>
  	            <li>
					<label for="reg_mb_id">아이디<strong class="sound_only">필수</strong></label>
					<div class="s_input">
						<div class="box">
							<input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" size="70" maxlength="100" placeholder="이메일 형태로 작성하세요.">
							<span id="msg_mb_id"></span>
						</div>
					</div>
	            </li>
				<li class="half_input left_input margin_input">
					<label for="reg_mb_password">비밀번호<strong class="sound_only">필수</strong></label>
					<input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="5" maxlength="20" placeholder="비밀번호를 입력하세요.">
					<div class="s_notice">
						<span class="tooltips">
							*영문/숫자/특수 문자 등을 혼합하여 5자 이상으로 작성하세요.(권장)
						</span>
					</div>
				</li>
	            <li class="half_input left_input">
	                <label for="reg_mb_password_re">비밀번호 확인<strong class="sound_only">필수</strong></label>
	                <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input full_input <?php echo $required ?>" minlength="5" maxlength="20" placeholder="비밀번호를 한번 더 입력하세요.">
	            </li>
				<li>
	                <label for="reg_mb_name">이름<strong class="sound_only">필수</strong></label>
	                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" size="10" placeholder="이름을 입력하세요.">
	            </li>

	            <?php if ($req_nick) {  ?>
	            <li>
                  <label for="reg_mb_nick">닉네임<strong class="sound_only">필수</strong></label>

	                
                  <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                  <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace full_input" size="10" maxlength="30" placeholder="닉네임을 입력하세요.">
                  <span id="msg_mb_nick"></span>	 

                  <div class="s_notice">
                     <span class="tooltips">
                        *공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
                        *닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
                     </span>
                  </div>                  
	            </li>
				<?php }  ?>

				<li>
                  <label for="reg_mb_profile">소개글<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_profile" value="<?php echo get_text($member['mb_profile']) ?>" id="reg_mb_profile" class="frm_input full_input" size="10" maxlength="30" placeholder="소개글을 입력하세요.">                
	            </li>

				<?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
                <li class="reg_mb_img_file">

                     <label for="reg_mb_img" class="frm_label">회원이미지</label>
                     <input type="file" name="mb_img" id="reg_mb_img">
      
                     <div>
                        <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
                        <img src="<?php echo $mb_img_url ?>" alt="회원이미지">
                        <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">
                        <label for="del_mb_img" class="inline">삭제</label>
                        <?php }  ?>
                     </div>

                  </li>
               <?php }  ?>
				<!--
					<li class="is_captcha_use">
	                <label>자동등록방지</label>
	                <?php echo captcha_html(); ?>
	            </li>
				-->
	        </ul>
	    </div>

	</div>
	<div class="btn_confirm">
		<a href="<?php echo G5_URL ?>/bbs/register.php" class="btn_close">이전단계</a>
	    <button type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?:'정보수정'; ?></button>
	</div>
	</form>
   </div>
</div>
<script>

// submit 최종 폼체크
function fregisterform_submit(f)
{
    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }else{
			if ( isValid_Email($("#reg_mb_id").val()) == false ) { 
				alert("이메일 형식이 유효하지 않습니다.\r\n다시 확인해 주세요!");	$("#reg_mb_id").focus(); 	return false; 
			}
		}
    }

    if (f.w.value == "") {
        if (f.mb_password.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }

    // 이름 검사
    if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
            alert("이름을 입력하십시오.");
            f.mb_name.focus();
            return false;
        }

        /*
        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert("이름은 한글로 입력하십시오.");
            f.mb_name.select();
            return false;
        }
        */
    }

    <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
    // 본인확인 체크
    if(f.cert_no.value=="") {
        alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
        return false;
    }
    <?php } ?>

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }

/*
    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        var msg = reg_mb_email_check();
        if (msg) {
            alert(msg);
            f.reg_mb_email.select();
            return false;
        }
    }

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
    // 휴대폰번호 체크
    var msg = reg_mb_hp_check();
    if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
    }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
            if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원이미지가 이미지 파일이 아닙니다.");
                f.mb_img.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert("본인을 추천할 수 없습니다.");
            f.mb_recommend.focus();
            return false;
        }

        var msg = reg_mb_recommend_check();
        if (msg) {
            alert(msg);
            f.mb_recommend.select();
            return false;
        }
    }

    <?php //echo chk_captcha_js();  ?>
*/
    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>

<!-- } 회원정보 입력/수정 끝 -->
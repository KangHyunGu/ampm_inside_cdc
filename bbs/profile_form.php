<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');

run_event('register_form_before');

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);
set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");

$is_social_login_modify = false;

/////////////////////////////////////////////////////////////////////////////////////
//AMPM 사원(팀장포함) 수정을 위해서 수정 - feeris
/////////////////////////////////////////////////////////////////////////////////////
//if ($is_admin){
if ($is_admin == 'super' || $is_admin == 'manager'){
	alert('관리자의 회원정보는 관리자 화면에서 수정해 주십시오.', G5_URL);
}

if (!$is_member)
	alert('로그인 후 이용하여 주십시오.', G5_URL);

if ($member['mb_id'] != $_POST['mb_id'])
	alert('로그인된 회원과 넘어온 정보가 서로 다릅니다.');



if($_POST['mb_id'] && ! (isset($_POST['mb_password']) && $_POST['mb_password'])){
	if( ! $is_social_login_modify ){
		alert('비밀번호를 입력해 주세요.');
	}
}
/*
if (isset($_POST['mb_password'])) {
	// 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
	if (isset($_POST['is_update']) && $_POST['is_update']) {
		$tmp_password = $_POST['mb_password'];
		$pass_check = ($member['mb_password'] === $tmp_password);
	} else {
		$pass_check = check_password($_POST['mb_password'], $member['mb_password']);
	}

	if (!$pass_check)
		alert('비밀번호가 틀립니다.');
}
*/
if ($_POST['mb_password']) {
	// 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
	if ($_POST['is_update'])
		$tmp_password = $_POST['mb_password'];
	else
		$tmp_password = sql_password($_POST['mb_password']);

	if ($member['mb_password'] != $tmp_password)
		alert('비밀번호가 틀립니다.');
}

if ($w == "") {
    $g5['title'] = '프로필 정보 등록';

} else if ($w == 'u') {

    $g5['title'] = '프로필 정보 수정';

    set_session("ss_reg_mb_name", $member['mb_name']);
    set_session("ss_reg_mb_hp", $member['mb_hp']);

    $member['mb_email']       = get_text($member['mb_email']);
    $member['mb_homepage']    = get_text($member['mb_homepage']);
    $member['mb_birth']       = get_text($member['mb_birth']);
    $member['mb_tel']         = get_text($member['mb_tel']);
    $member['mb_hp']          = get_text($member['mb_hp']);
    $member['mb_addr1']       = get_text($member['mb_addr1']);
    $member['mb_addr2']       = get_text($member['mb_addr2']);
    $member['mb_signature']   = get_text($member['mb_signature']);
    $member['mb_recommend']   = get_text($member['mb_recommend']);
    $member['mb_profile']     = get_text($member['mb_profile']);
    $member['mb_1']           = get_text($member['mb_1']);
    $member['mb_2']           = get_text($member['mb_2']);
    $member['mb_3']           = get_text($member['mb_3']);
    $member['mb_4']           = get_text($member['mb_4']);
    $member['mb_5']           = get_text($member['mb_5']);
    $member['mb_6']           = get_text($member['mb_6']);
    $member['mb_7']           = get_text($member['mb_7']);
    $member['mb_8']           = get_text($member['mb_8']);
    $member['mb_9']           = get_text($member['mb_9']);
    $member['mb_10']          = get_text($member['mb_10']);

	$mb_part = ($member['mb_part'])?codeToName($code_part3, get_text($member['mb_part'])):"";
	$mb_team = ($member['mb_team'])?codeToName($code_team, get_text($member['mb_team'])):"";
	$mb_post = ($member['mb_post'])?codeToName($code_post, get_text($member['mb_post'])):"";

	$photo_url = G5_INTRANET_URL.'/data/member_image/'.$member['mb_id'];
	$mb_images = '<img src="'.$photo_url.'" width="50" height="70" alt=""> ';


	$mb_dir = substr($member['mb_id'],0,2);
	$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$member['mb_id'].'.jpg';
	if (file_exists($mk_file)) {
		$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$member['mb_id'].'.jpg';

		$mb_images = '<img src="'.$mk_url.'" width="50" height="70" alt=""> ';
	}

	
	/////////////////////////////////////////////////////////////////////////
	//마케터소개 테이블 정보 추출
	/////////////////////////////////////////////////////////////////////////
	$mkt = get_marketer_detail($member['mb_id']);
    $mkt['mb_id'] 				= get_text($member['mb_id']);
    $mkt['mb_name'] 			= get_text($member['mb_name']);
    $mkt['mb_license'] 			= get_text($mkt['mb_license']);
    $mkt['mb_media'] 			= get_text($mkt['mb_media']);
    $mkt['mb_sectors'] 			= get_text($mkt['mb_sectors']);
    $mkt['mb_slogan'] 			= get_text($mkt['mb_slogan']);
    $mkt['mb_profile'] 			= get_text($mkt['mb_profile'], 0);
    $mkt['mb_message'] 			= get_text($mkt['mb_message'], 0);
    
	$mkt['mb_kakaochat'] 		= get_text($mkt['mb_kakaochat']);

    $mkt['mb_bloglink'] 			= get_text($mkt['mb_bloglink']);
    $mkt['mb_facebooklink'] 		= get_text($mkt['mb_facebooklink']);
    $mkt['mb_instagramlink'] 	= get_text($mkt['mb_instagramlink']);
    $mkt['mb_youtubelink'] 		= get_text($mkt['mb_youtubelink']);

    $mkt['mb_kakaoid'] 			= ($member['mb_5'])?$member['mb_5']:get_text($mkt['mb_kakaoid']);

	if (!$mkt['mb_id']) {
		$mk = '';
	}else{
		$mk = 'u';
	}
} else {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

include_once('./_head.php');


$register_action_url = G5_HTTPS_BBS_URL.'/profile_form_update.php';
$req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)));
$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
if ($config['cf_use_addr'])
    add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

if($w == ""){ // 신규가입이라면...
	include_once($member_skin_path.'/profile_form.skin.php');
}else{ // 회원이 정보수정을 하는 상태라면
	include_once($member_skin_path.'/profile_form.skin.php');
}

run_event('register_form_after', $w, $agree, $agree2);

include_once('./_tail.php');
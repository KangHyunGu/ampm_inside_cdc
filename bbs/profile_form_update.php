<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 리퍼러 체크
referer_check();

if (!($w == '' || $w == 'u')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

if ($w == 'u' && $is_admin == 'super') {
    if (file_exists(G5_PATH.'/DEMO'))
        alert('데모 화면에서는 하실(보실) 수 없는 작업입니다.');
}

/* - 자동방지 사용안함 - feeris
if (!chk_captcha()) {
    alert('자동등록방지 숫자가 틀렸습니다.');
}
*/

/*
print_r2($_REQUEST);
exit;
*/

if($w == 'u'){
    $mb_id = isset($_SESSION['ss_mb_id']) ? trim($_SESSION['ss_mb_id']) : '';
	
	/////////////////////////////////////////////////////////////////////////////////////
	//AMPM 사원(팀장포함) 프로필 테이블 - feeris
	/////////////////////////////////////////////////////////////////////////////////////
	$bo_table = 'g5_marketer_detail';

}else if($w == ''){
    $mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';
}else{
    alert('잘못된 접근입니다', G5_URL);
}

if(!$mb_id)
    alert('사원정보가 올바르지 않습니다. 올바른 방법으로 이용해 주십시오.');

if (isset($_POST['mb_profile'])) {
    //$mb_profile = substr(trim($_POST['mb_profile']),0,65536);
    $mb_profile = preg_replace("#[\\\]+$#", "", $mb_profile);
}

if (isset($_POST['mb_message'])) {
    //$mb_message = substr(trim($_POST['mb_message']),0,65536);
    $mb_message = preg_replace("#[\\\]+$#", "", $mb_message);
}

//취득 자격증
$arrLicense = '';
for($i=0;$i<count($_POST['mb_license']);$i++){ 
	$arrLicense = $arrLicense.$_POST['mb_license'][$i]."|";
}
$arrLicense = substr($arrLicense, 0, -1);

//전문 매체
$arrMedia = '';
for($i=0;$i<count($_POST['mb_media']);$i++){ 
	$arrMedia = $arrMedia.$_POST['mb_media'][$i]."|";
}
$arrMedia = substr($arrMedia, 0, -1);

//전문 직종
$arrSectors = '';
for($i=0;$i<count($_POST['mb_sectors']);$i++){ 
	$arrSectors = $arrSectors.$_POST['mb_sectors'][$i]."|";
}
$arrSectors = substr($arrSectors, 0, -1);

$sql_common = "  mb_license 		= '{$arrLicense}',
                 mb_media 			= '{$arrMedia}',
                 mb_sectors 		= '{$arrSectors}',
                 mb_slogan 			= '{$_POST['mb_slogan']}',
                 mb_profile 		= '{$mb_profile}',
                 mb_message 		= '{$mb_message}',
                 mb_kakaoid 		= '{$_POST['mb_kakaoid']}',
                 mb_kakaochat 		= '{$_POST['mb_kakaochat']}',
                 mb_bloglink 		= '{$_POST['mb_bloglink']}',
                 mb_facebooklink 	= '{$_POST['mb_facebooklink']}',
                 mb_instagramlink 	= '{$_POST['mb_instagramlink']}',
                 mb_youtubelink 	= '{$_POST['mb_youtubelink']}',
                 mb_common_data_yn 	= '{$_POST['mb_common_data_yn']}',

				 mb_part 	= '{$_POST['mb_part']}',
                 mb_team 	= '{$_POST['mb_team']}',
                 mb_post 	= '{$_POST['mb_post']}'

			  ";

//인트라넷 업데이트 용
$sql_common1 = " mb_13 	= '{$arrSectors}',
				 mb_14 	= '{$arrMedia}',
				 mb_16 	= '{$arrLicense}',
				 mb_15 	= '{$mb_profile}',
				 mb_12 	= '{$_POST['mb_slogan']}',
				 mb_5 	= '{$_POST['mb_kakaoid']}'
			  ";


//마케터소개 LOG 용
$sql_common2 = " mb_license 		= '{$arrLicense}',
                 mb_media 			= '{$arrMedia}',
                 mb_sectors 		= '{$arrSectors}',
                 mb_slogan 			= '{$_POST['mb_slogan']}',
                 mb_profile 		= '{$mb_profile}',
                 mb_message 		= '{$mb_message}',
                 mb_kakaoid 		= '{$_POST['mb_kakaoid']}',
                 mb_kakaochat 		= '{$_POST['mb_kakaochat']}',
                 mb_bloglink 		= '{$_POST['mb_bloglink']}',
                 mb_facebooklink 	= '{$_POST['mb_facebooklink']}',
                 mb_instagramlink 	= '{$_POST['mb_instagramlink']}',
                 mb_youtubelink 	= '{$_POST['mb_youtubelink']}',

				 mb_part 	= '{$_POST['mb_part']}',
                 mb_team 	= '{$_POST['mb_team']}',
                 mb_post 	= '{$_POST['mb_post']}'
			  ";

//echo($sql_common);exit;

run_event('register_form_update_before', $mb_id, $w);

if ($w == '') {
    $mb = get_marketer_detail($mb_id);
    if ($mb['mb_id'])
        alert('이미 존재하는 사원 입니다.\\nＩＤ : '.$mb['mb_id'].'\\n이름 : '.$mb['mb_name']);

    sql_query(" insert into {$bo_table} set mb_id = '{$mb_id}', {$sql_common} ");


	//인트라넷업데이트용
    $sql = " update g5_member
                set {$sql_common1}
                where mb_id = '{$mb_id}' ";
	//echo $sql;exit;
	sql_query_intra($sql);


	//마케터소개 LOG 용
    sql_query(" insert into g5_marketer_permute_log set mb_id = '{$mb_id}', per_type = '최초등록', per_ip = '{$_SERVER['REMOTE_ADDR']}' ,per_date = '".G5_TIME_YMDHIS."', {$sql_common2} ");

} else if ($w == 'u') {
    if (!trim(get_session('ss_mb_id')))
        alert('로그인 되어 있지 않습니다.');

    if (trim($_POST['mb_id']) != $mb_id)
        alert("로그인된 정보와 수정하려는 정보가 틀리므로 수정할 수 없습니다.\\n만약 올바르지 않은 방법을 사용하신다면 바로 중지하여 주십시오.");

    $mb = get_marketer_detail($mb_id);
    if (!$mb['mb_id']){
		sql_query(" insert into {$bo_table} set mb_id = '{$mb_id}', {$sql_common} ");
	}else{

		$sql = " update {$bo_table}
					set {$sql_common}
					where mb_id = '{$mb_id}' ";
		//echo $sql;exit;
		sql_query($sql);


		//인트라넷업데이트용
		$sql = " update g5_member
					set {$sql_common1}
					where mb_id = '{$mb_id}' ";
		
		//echo $sql;exit;
		sql_query_intra($sql);


		//마케터소개 LOG 용
		sql_query(" insert into g5_marketer_permute_log set mb_id = '{$mb_id}', per_type = '정보수정', per_ip = '{$_SERVER['REMOTE_ADDR']}' ,per_date = '".G5_TIME_YMDHIS."', {$sql_common2} ");
	}
}

$mb_dir = substr($mb_id,0,2);

// 마케터 사진 삭제
if ($del_mb_img)
	@unlink(G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mb_id.'.jpg');

// 마케터 사진 업로드
if (is_uploaded_file($_FILES['mb_img']['tmp_name'])) {
	if (!preg_match("/(\.jpg)$/i", $_FILES['mb_img']['name'])) {
		alert($_FILES['mb_img']['name'] . '은(는) jpg 파일이 아닙니다.');
	}

	if (preg_match("/(\.jpg)$/i", $_FILES['mb_img']['name'])) {
		@mkdir(G5_DATA_PATH.'/marketer_image/'.$mb_dir, G5_DIR_PERMISSION);
		@chmod(G5_DATA_PATH.'/marketer_image/'.$mb_dir, G5_DIR_PERMISSION);

		$dest_path = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mb_id.'.jpg';

		move_uploaded_file($_FILES['mb_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}


// 사용자 코드 실행
@include_once ($member_skin_path.'/profile_form_update.tail.skin.php');


if ($msg)
    echo '<script>alert(\''.$msg.'\');</script>';

run_event('register_form_update_after', $mb_id, $w);

$row  = sql_fetch_intra(" select mb_password from {$g5['member_table']} where mb_id = '{$member['mb_id']}' ");
$tmp_password = $row['mb_password'];

if ($w == '') {
        echo '
        <!doctype html>
        <html lang="ko">
        <head>
        <meta charset="utf-8">
        <title>프로필 정보 등록</title>
        <body>
        <form name="fregisterupdate" method="post" action="'.G5_HTTP_BBS_URL.'/profile_form.php">
        <input type="hidden" name="w" value="u">
        <input type="hidden" name="mb_id" value="'.$mb_id.'">
        <input type="hidden" name="mb_password" value="'.$tmp_password.'">
        <input type="hidden" name="is_update" value="1">
        </form>
        <script>
        alert("프로필 정보가 등록 되었습니다.");
        document.fregisterupdate.submit();
        </script>
        </body>
        </html>';
} else if ($w == 'u') {
        echo '
        <!doctype html>
        <html lang="ko">
        <head>
        <meta charset="utf-8">
        <title>프로필 정보 수정</title>
        <body>
        <form name="fregisterupdate" method="post" action="'.G5_HTTP_BBS_URL.'/profile_form.php">
        <input type="hidden" name="w" value="u">
        <input type="hidden" name="mb_id" value="'.$mb_id.'">
        <input type="hidden" name="mb_password" value="'.$tmp_password.'">
        <input type="hidden" name="is_update" value="1">
        </form>
        <script>
        alert("프로필 정보가 수정 되었습니다.");
        document.fregisterupdate.submit();
        </script>
        </body>
        </html>';
}
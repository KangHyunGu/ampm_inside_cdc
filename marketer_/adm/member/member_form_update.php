<?php
$sub_menu = "300400";
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");

if ($w == 'u')
    check_demo();

auth_check($auth[$sub_menu], 'w');

check_token();

$mb_id = trim($_POST['mb_id']);
$bo_table = 'g5_marketer_detail';

if (!$mb_id) {
   alert('사원정보가 올바르지 않습니다.', G5_MARKETER_ADMIN_URL);
}

//print_r2($_POST);exit;


if (isset($_POST['mb_profile'])) {
    $mb_profile = substr(trim($_POST['mb_profile']),0,65536);
    $mb_profile = preg_replace("#[\\\]+$#", "", $mb_profile);
}

if (isset($_POST['mb_message'])) {
    $mb_message = substr(trim($_POST['mb_message']),0,65536);
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
                 mb_youtubelink 	= '{$_POST['mb_youtubelink']}'
			  ";

//인트라넷 업데이트 용
$sql_common1 = " mb_13 	= '{$arrSectors}',
				 mb_14 	= '{$arrMedia}',
				 mb_16 	= '{$arrLicense}',
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
                 mb_youtubelink 	= '{$_POST['mb_youtubelink']}'
			  ";

//echo($sql_common);exit;

if ($mk == '')
{
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

}
else if ($mk == 'u')
{
    $mb = get_marketer_detail($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 사원자료입니다.');


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
else{
    alert('제대로 된 값이 넘어오지 않았습니다.');
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
/*
		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			// 마케터 사진의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 마케터 사진 삭제
			if ($size[0] > 350 || $size[1] > 350) {
				@unlink($dest_path);
			}
		}
*/
	}
}

goto_url('./member_form.php?'.$qstr.'&amp;w=u&amp;mk=u&amp;mb_id='.$mb_id, false);
?>

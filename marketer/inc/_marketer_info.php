<?php
////////////////////////////////////////////////////////////////////
//utm_member 마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
$mb = get_marketer($utm_member);
if (!$mb['mb_id'])
	//alert('존재하지 않는 마케터 자료입니다.');
	move_page("/sub/sub1-2.php");

    $mb['mb_name'] 			= get_text($mb['mb_name']);
    $mb['mb_ename'] 		= get_text($mb['mb_2']);

    $mb['mb_email'] 		= get_text($mb['mb_email']);

    $mb['mb_email1'] 		= strstr($mb['mb_email'], '@');
    $mb['mb_email2'] 		= mb_substr(strstr($mb['mb_email'], '@'),1);
	//echo $mb['mb_email']." | ".$mb['mb_email1']." | " .$mb['mb_email2'];

    $mb['mb_tel'] 			= get_text($mb['mb_tel']);
    $mb['mb_tel'] 			= '02-6049-'.$mb['mb_tel'];
    $mb['mb_hp'] 			= get_text($mb['mb_hp']);
    $mb['mb_1'] 			= get_text($mb['mb_1']);
    $mb['mb_2'] 			= get_text($mb['mb_2']);
    $mb['mb_3'] 			= get_text($mb['mb_3']);
    $mb['mb_4'] 			= get_text($mb['mb_4']);
    $mb['mb_5'] 			= get_text($mb['mb_5']);	//카카오아이디
    $mb['mb_kakao'] 		= get_text($mb['mb_5']);	//카카오아이디
    $mb['mb_6'] 			= get_text($mb['mb_6']);
    $mb['mb_7'] 			= get_text($mb['mb_7']);
    $mb['mb_8'] 			= get_text($mb['mb_8']);
    $mb['mb_9'] 			= get_text($mb['mb_9']);
    $mb['mb_10'] 			= get_text($mb['mb_10']);

	$mb_part = ($mb['mb_part'])?codeToName($code_part3, get_text($mb['mb_part'])):"";
	$mb_team = ($mb['mb_team'])?codeToName($code_team, get_text($mb['mb_team'])):"";
	$mb_post = ($mb['mb_post'])?codeToName($code_post, get_text($mb['mb_post'])):"";

	$photo_file = G5_DATA_PATH.'/member_image/'.$mb['mb_id'];


	///////////////////////////////////////////////////////////////////////////////////////
	//사원 등록 사진 있으면 그걸 적용
	///////////////////////////////////////////////////////////////////////////////////////
	$mb_dir = substr($mb['mb_id'],0,2);
	$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
	if (file_exists($mk_file)) {
		$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
		$mb_images = '<img src="'.$mk_url.'" alt="'.$mb['mb_name'].' AE" width="280" height="280">';
	}else{
		//없으면 인트라넷 사진
		$photo_url = G5_INTRANET_URL.'/data/member_image/'.$mb['mb_id'];
		
		$mb_images = '<img src="'.$photo_url.'" alt="'.$mb['mb_name'].' AE" width="280" height="280">';
	}


	/////////////////////////////////////////////////////////////////////////
	//마케터소개 테이블 정보 추출
	/////////////////////////////////////////////////////////////////////////
	$mkt = get_marketer_detail($mb['mb_id']);
    $mb['mb_license'] 			= get_text($mkt['mb_license']);
    $mb['mb_media'] 			= get_text($mkt['mb_media']);
    $mb['mb_sectors'] 			= get_text($mkt['mb_sectors']);
    $mb['mb_slogan'] 			= get_text($mkt['mb_slogan']);
    $mb['mb_profile'] 			= $mkt['mb_profile'];
    $mb['mb_message'] 			= $mkt['mb_message'];

    $mb['mb_kakaochat'] 		= $mkt['mb_kakaochat'];

    $mb['mb_bloglink'] 			= get_text($mkt['mb_bloglink']);
    $mb['mb_facebooklink'] 		= get_text($mkt['mb_facebooklink']);
    $mb['mb_instagramlink'] 	= get_text($mkt['mb_instagramlink']);
    $mb['mb_youtubelink'] 		= get_text($mkt['mb_youtubelink']);

	//에디터사용
	$html = 1;

	//저에 대해 더 알고 싶으시다면?
	$sns_link = false;
	if($mb['mb_bloglink'] || $mb['mb_facebooklink'] || $mb['mb_instagramlink'] || $mb['mb_youtubelink']){
		$sns_link = true;
	}
?>

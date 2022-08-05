<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//이름 & 소속 & PR문구
if($is_admin != 'super'){
	$mk = get_memberLoginInfo($member['mb_id']); 
	if($mk){
		$mb_images	= $mk['mb_images'];
		$nick		= $mk['nick'];
		$team		= $mk['mb_team_text'];
		$mb_slogan  = $mk['mb_slogan'];
	}
}else{
	$mb_images	= get_member_profile_img($member['mb_id']);
	$nick		= $member['mb_nick'];
	$team		= '';
	$mb_slogan  = '';
}

/////////////////////////////////////////////////////////////////////////
//경로 설정 비로그인의 경우 로그인 창으로 연결
/////////////////////////////////////////////////////////////////////////
//로그인 박스 
//마케터
//마이페이지	$go_mypage
//답변대기	$go_qna
//대행의뢰	$go_reqeust
//상담현황	$go_estimate

//일반회원
//마이페이지	$go_mypage
//내 정보 수정
//로그아웃

//마이페이지
//마케터
//내가 쓴 글		$go_mypage
//내가 쓴 댓글	$go_comment
//답변대기		$go_qna
//대행의뢰		$go_reqeust
//상담현황		$go_estimate

//일반회원
//내가 쓴 글		$go_mypage
//내가 쓴 댓글	$go_comment
//즐겨찾기		$go_favorites
/////////////////////////////////////////////////////////////////////////

$go_amypage	= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=amypage&view=w':G5_BBS_URL.'/login.php?url='.$uri;
$go_acomment= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=acomment&view=c':G5_BBS_URL.'/login.php?url='.$uri;
$go_qna		= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=qna&view=w':G5_BBS_URL.'/login.php?url='.$uri;
$go_reqeust = ($is_member)?G5_BBS_URL.'/mypage.php?go_table=request&view=w':G5_BBS_URL.'/login.php?url='.$uri;
$go_estimate= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=mkestimate&view=w':G5_BBS_URL.'/login.php?url='.$uri;
$go_favorites= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=favorites&view=w':G5_BBS_URL.'/login.php?url='.$uri;

$go_umypage	= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=umypage&view=w':G5_BBS_URL.'/login.php?url='.$uri;
$go_ucomment= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=ucomment&view=c':G5_BBS_URL.'/login.php?url='.$uri;
?>
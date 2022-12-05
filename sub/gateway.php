<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MOBILE_PATH.'/sub/gateway.php');
    return;
}
?>

<?php
////////////////////////////////////////////////////////////////////////
//유투브 - 에피글에서 마케터 소개 링크를 타고 오는 경우
//키 값이 없는 경우 - 마케터소개 sub1-2.php 로 이동 처리
//utm_member
////////////////////////////////////////////////////////////////////////
//echo $utm_member;exit;
if(!$utm_member){
	move_page("/marketer/");
}

/*
$bo_table = "marketer";
$write_table = $g5['write_prefix'] . $bo_table;

//$view = get_bbs_view($bo_table, $wr_id);
$view = get_bbs_maketer($bo_table, $utm_member);

////////////////////////////////////////////////////////////////////////
//$wr_id 값에 해당하는 마케터가 퇴사한 경우 - 마케터소개 sub1-2.php 로 이동 처리
////////////////////////////////////////////////////////////////////////
if(!$view){
	move_page("/sub/sub1-2.php");
}
//print_r2($view);exit;
*/
//move_page("/sub/sub1-2-view.php?utm_member=".$view['wr_1']."#empty");

//echo "/ae-".$utm_member."&team_code=".$team_code;exit;
//echo "/ae-".$utm_member."/member".$utm_member."&team_code=".$team_code;exit;
if($team_code){
	move_page("/ae-".$utm_member."/?team_code=".$team_code);
}else{
	move_page("/ae-".$utm_member."/");
}
?>
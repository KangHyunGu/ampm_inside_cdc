<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

include_once('./_common.php');

/**************************************************************************************
	너나우리 LMS 셋팅 연결
    LMS 객체 생성
**************************************************************************************/
#include_once(G5_MMS_PATH."/lms_set.lib.php");
include_once(G5_MMS_PATH.'/send_lms_youiwe.lib.php');

$admin_callNumber = "0260494239";

///////////////////////////////////////////////////////////////////////////////////////
// 신청자 글이 등록됨을 관리자 에게 문자로 전달하는 부분
///////////////////////////////////////////////////////////////////////////////////////
$wr_reply = str_replace('-', '', trim($admin_callNumber));		// 회신(발신)번호 "-" 없이 적어 주십시오 슈어엠 발신인증번호 
//$list[]	  = str_replace('-', '', trim('010-2655-5440')); 		// 수신번호  - 대표번호

//마케터정보
if($team_code == 'mk'){	//팀정보가 mk 로 전체 마케터 번호 랜덤 적용인 경우
	$list[]	  = str_replace('-', '', trim($wr_7)); 		// 수신번호  - 마케터
}else{
	//일반회원 이면서 탈퇴 회원이 아닌 경우, 상담수신으로 선택된 인원 
	$sql = " select mb_name, mb_hp from {$g5['member_table']} where mb_level = '2' and mb_leave_date = '' and mb_intercept_date = '' and mb_1 = '1' ";
	$result = sql_query($sql);

	for ($i=0; $row=sql_fetch_array($result); $i++){
		$smsGroupList[$i] = $row;
	}

	if(count($smsGroupList) < 1){
		//alert_close('문자발송 대상 리스트가 없습니다.');
		$list[]	  = str_replace('-', '', trim('010-9182-4024')); 		// 수신번호  - 김윤중
	}else{
		for ($i=0; $i<count($smsGroupList); $i++) {
			$list[$i] = str_replace('-', '', trim($smsGroupList[$i]['mb_hp']));
		}
	}
}

$memoyn = (strlen($wr_content)> 1)?'유':'무';

$subject    = "[상담신청]";
$wr_message	= "
업체명:{$wr_1} 
연락처:{$wr_5} 
광고예산:{$wr_2} 
관심매체:{$wr_3}
배당팀:{$wr_8}
희망마케터:{$wr_11}
문의내용유무:{$memoyn}
";

//print_r2($list);
//신청자가 관리자에게 접수 문자 발송
$res = sendmms($list, $wr_reply, $subject, $wr_message,$filepath1='');

//echo "<h1>$res</h1>";
//exit;

///////////////////////////////////////////////////////////////////////////////////////
// 신청자에게 문자가 발송되었음을 알리는 문자 발송 부분
///////////////////////////////////////////////////////////////////////////////////////
// 확인 메세지를 고객에게도 보내도록 start {
$subject    = "빠른상담요청이 접수되었습니다. ";

if (G5_TIME_HIS>="20:00:00") {	// 밤 8시 이후에는 익일 오전에 연락함
	//SMS 문자제한으로..
	$wr_message	= "[에이엠피엠] 상담요청이 접수되었습니다. 상담원이 익일 오전에 연락드리겠습니다.";
}else {
	//SMS 문자제한으로..
	$wr_message	= "[에이엠피엠] 상담요청이 접수되었습니다. 상담원이 1분안에 연락드리겠습니다.";
}

$reply_phoneNumber 	= str_replace('-', '', trim($admin_callNumber)); 	// 회신(발신)번호 "-" 없이 적어 주십시오 슈어엠 발신인증번호
$clist[]  			= $wr_5;											// 수신번호 - 고객 번호

//관리자가 신청자에게 접수확인 문자 발송
//$res = sendmms($clist, $reply_phoneNumber, $subject, $wr_message,$filepath1='');
// 확인 메세지를 고객에게도 보내도록 } end

//echo($res);
?>
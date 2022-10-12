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
$mm = get_marketer($utm_member);

$_MARKETER_NAME  = $mm['mb_name'];
$_MARKETER_TEL   = '02.6049-'.$mm['mb_tel'];
$_MARKETER_HP    = $mm['mb_hp'];
$_MARKETER_EMAIL = $mm['mb_email'];

$list[]	  = str_replace('-', '', trim($_MARKETER_HP)); 		// 수신번호  - 마케터

$subject    = "[상담신청]";
$wr_message	= "
업체명:{$wr_1} 
관심매체:{$wr_3}
연락처:{$wr_5} 
월예산광고비:{$wr_2} 
";


//신청자가 관리자에게 접수 문자 발송
$res = sendmms($list, $wr_reply, $subject, $wr_message,$filepath1='');

//echo "<h1>$res</h1>";


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
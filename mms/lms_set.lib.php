<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

include_once('./_common.php');

/**************************************************************************************
	너나우리 SMS
**************************************************************************************/
include_once(G5_MMS_PATH."/mms/lms_nusoap_youiwe.php");

/******LMS 접속계정정보************/
include_once(G5_MMS_PATH."/mms/lms_id_youiwe.php");
/**********************************/

//바로 전 URL 접속 정보
$StringRefer	= $_SERVER["HTTP_REFERER"];

//현재 처리되는 페이지 URL 정보를 알수 있다.
$StringHOST = Trim($_SERVER["HTTP_HOST"]);

//REMOTE_ADDR 현재 호출한 Client의 IP Address
$StringAddr = Trim($_SERVER["REMOTE_ADDR"]);


//발신자번호
$admin_callNumber = "0260494239";

//발신자이름
$wr_name ="운영자";

$snd_number = str_replace('-', '', trim($admin_callNumber));	//발신인증번호(보내는 사람 번호를 받음)

$callbackURL = "www.youiwe.co.kr";
$userdefine = $sms_id;							//예약취소를 위해 넣어주는 구분자 정의값, 사용자 임의로 지정해주시면 됩니다. 영문으로 넣어주셔야 합니다. 사용자가 구분할 수 있는 값을 넣어주세요.
$canclemode = "1";								//예약 취소 모드 1: 사용자정의값에 의한 삭제.  현제는 무조건 1을 넣어주시면 됩니다.


$seqno    = 1;
$booking  = 1;
$wr_total = 1;
$hs_flag  = 1;

$wr_booking = 1;
$wr_total = 1;
$n_success = 0;

//구축 테스트 주소와 일반 웹서비스 선택
if (substr($lms_id,0,3) == "bt_"){
	$webService = "http://lmsservice.youiwe.co.kr/lms.1/ServiceLMS_bt.asmx?WSDL";
}else{
	$webService = "http://lmsservice.youiwe.co.kr/lms.1/ServiceLMS.asmx?WSDL";
}
//+) funcMode는 메소드실행 후 반환값에 따라 다른 메시지를 띄우기 위해서 쓰입니다.

//LMS 객체 생성
$lms = new LMS($webService); 
?>
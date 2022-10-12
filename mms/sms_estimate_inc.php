<?
include_once('./_common.php');

/**************************************************************************************
	너나우리 SMS
**************************************************************************************/
#include_once "./sendmms.lib.php";
include_once(G5_MMS_PATH.'/sendyouiwe.lib.php');


///////////////////////////////////////////////////////////////////////////////////////
// 회신(발신)번호 부분
///////////////////////////////////////////////////////////////////////////////////////
//관리자번호
//$admin_callNumber = $sms5['cf_phone'];
$admin_callNumber = "0260494239";
//$wr_name ="홍길동";

$wr_reply = str_replace('-', '', trim($admin_callNumber));		// 회신(발신)번호 "-" 없이 적어 주십시오 슈어엠 발신인증번호 

///////////////////////////////////////////////////////////////////////////////////////
// 수신번호
///////////////////////////////////////////////////////////////////////////////////////
//$list[]	  = str_replace('-', '', trim('010-2655-5440')); 		// 수신번호  - 테스트

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

//$subject    = "[".$config['cf_title']."]";
$subject    = "[상담신청]";
$wr_message	= "
업체명:{$wr_1} 
담당자명:{$wr_name}
연락처:{$wr_5} 
광고예산:{$wr_2} 
관심매체:{$wr_3}
배당팀:{$wr_8}
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
	$wr_message	= "[".$config['cf_title']."] 상담요청이 접수되었습니다. 상담원이 익일 오전에 연락드리겠습니다.";
}else {
	//SMS 문자제한으로..
	$wr_message	= "[".$config['cf_title']."] 상담요청이 접수되었습니다. 상담원이 1분안에 연락드리겠습니다.";
}

$reply_phoneNumber 	= str_replace('-', '', trim($admin_callNumber)); 	// 회신(발신)번호 "-" 없이 적어 주십시오 슈어엠 발신인증번호
$clist[]  			= $wr_5;											// 수신번호 - 고객 번호

//관리자가 신청자에게 접수확인 문자 발송
//$res = sendmms($clist, $reply_phoneNumber, $subject, $wr_message,$filepath1='');
// 확인 메세지를 고객에게도 보내도록 } end

//echo($res);

?>
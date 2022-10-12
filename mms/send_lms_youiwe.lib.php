<?php
include_once('./_common.php');

include_once(G5_MMS_PATH."/mms/lms_nusoap_youiwe.php");
?>
<?php
function sendmms($list, $reply, $subj, $msg, $filePath) {
	global $g5;

	/******SMS 접속계정정보************/
	include_once(G5_MMS_PATH."/mms/lms_id_youiwe.php");
	/**********************************/

	//바로 전 URL 접속 정보
	$StringRefer	= $_SERVER["HTTP_REFERER"];

	//현재 처리되는 페이지 URL 정보를 알수 있다.
	$StringHOST = Trim($_SERVER["HTTP_HOST"]);

	//REMOTE_ADDR 현재 호출한 Client의 IP Address
	$StringAddr = Trim($_SERVER["REMOTE_ADDR"]);

	$snd_number = str_replace('-', '', trim($reply));	//발신인증번호(보내는 사람 번호를 받음)

	$lms_title  = $subj;
	$lms_content= $subj.$msg;							//전송 내용

	$rcv_number	= $stran_callback;						//수신번호(받는 사람 번호를 받음)

//print_r2($list);
//echo "<br>";

	$callbackURL = "www.youiwe.co.kr";
	$userdefine = $sms_id;							//예약취소를 위해 넣어주는 구분자 정의값, 사용자 임의로 지정해주시면 됩니다. 영문으로 넣어주셔야 합니다. 사용자가 구분할 수 있는 값을 넣어주세요.
	$canclemode = "1";								//예약 취소 모드 1: 사용자정의값에 의한 삭제.  현제는 무조건 1을 넣어주시면 됩니다.

	$seqno    = '1';
	$booking  = '';
	$wr_total = '1';
	$hs_flag  = '1';

	$n_try = count($list);

	$wr_booking = $n_try;
	$wr_total = $n_try;
	$n_success = 0;


	//구축 테스트 주소와 일반 웹서비스 선택
	if (substr($lms_id,0,3) == "bt_"){
		$webService = "http://lmsservice.youiwe.co.kr/lms.1/ServiceLMS_bt.asmx?WSDL";
	}
	else{
		$webService = "http://lmsservice.youiwe.co.kr/lms.1/ServiceLMS.asmx?WSDL";
	}
		
	//+) funcMode는 메소드실행 후 반환값에 따라 다른 메시지를 띄우기 위해서 쓰입니다.

	$lms = new LMS($webService); //SMS 객체 생성

	foreach ($list as $call) {
		$call = str_replace('-', '', trim($call));
		/*즉시 전송으로 구성하실경우*/
		$result=$lms->SendLMS($lms_id,$lms_pwd,$snd_number,$call,$lms_title,$lms_content);// 5개의 인자로 함수를 호출합니다.
		//echo $lms_id. " | ".$lms_pwd. " | ".$snd_number. " | ".$call. " | ".$lms_title. " | ".$lms_content. "<br>";
		//echo $snd_number. " | ".$call. " | ".$lms_title. " | result = ".$result."<br>";
		//echo "ddd=  ".$result."<br>";
		
		if (!$result){
			$n_success ++;
			$hs_flag = '0';
		}
	}

	// log
	$row = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']} ");
	if ($row){
		$wr_no = $row['wr_no'] + 1;
	}else{
		$wr_no = 1;
	}

	$wr_failure = $n_success;			//실패
	$wr_success = $n_try - $n_success;	//성공 : 시도횟수 - 실패횟수

	sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$reply', wr_message='$msg', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='".G5_TIME_YMDHIS."', wr_success='$wr_success', wr_failure='$wr_failure' ");
	foreach ($list as $p) {
		$hs_memo = $p.'로 전송했습니다.';
		sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='{$row['bg_no']}', mb_id='{$member['mb_id']}', bk_no='{$row['bk_no']}', hs_name='".addslashes($row['bk_name'])."', hs_hp='{$row['bk_hp']}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
	}
	
	return $n_success;
}

	/*결과는 알맞게 처리합니다.*/
	/*
	전송결과 처리
	1 	: 발송성공
	1~N 	: 콤마로 연결하여 다중 발송을 하였을 경우에는 성공한 정수 숫자로 리턴 됩니다.
	0 	: 발송 가능량 부족 
	-1 	: ID /비밀번호 이상
	-2 	: ID 공백
	-3 	: 다중 전송시 모두 실패(수신번호이상)
	-4 	: 해쉬공백
	-5 	: 해쉬이상
	-6 	: 수신자 전화번호 공백
	-8	: 발신자 전화번호 공백
	-9	: 전송내용 공백
	-10	: 예약 날짜 이상
	-11	: 예약 시간 이상
	-12	: 예약 가능시간 지남
	-13	: 동의서가 접수되지 않음
	-14 	: LMS / MMS 사용신청이 되지 않음
	-15	: 서버에 이미지 파일 업로드 실패 
	-16	: 지원하지 않는 파일 확장자(MMS인 경우)
	-21	: 데이터베이스 연결실패(DB Connection Fail)
	-23	: 허용하지 않는 IP인 경우 (IP허용 제한설정 확인)
	-30	: 등록되지 않은 발신번호
	-31	: 잘못된 발신번호 
	-40	: 스팸 발송 차단 
	-50	: 잘못된 전화번호	
	*/
?>
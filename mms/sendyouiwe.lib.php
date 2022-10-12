<?php
include_once('./_common.php');

include_once(G5_MMS_PATH."/mms/sms_nusoap_youiwe.php");
?>
<?php
function sendmms($list, $reply, $subj, $msg, $filePath) {
	global $g5;

	/******SMS 접속계정정보************/
	include_once(G5_MMS_PATH."/mms/sms_id_youiwe.php");
	/**********************************/

	//바로 전 URL 접속 정보
	$StringRefer	= $_SERVER["HTTP_REFERER"];

	//현재 처리되는 페이지 URL 정보를 알수 있다.
	$StringHOST = Trim($_SERVER["HTTP_HOST"]);

	//REMOTE_ADDR 현재 호출한 Client의 IP Address
	$StringAddr = Trim($_SERVER["REMOTE_ADDR"]);

	$snd_number 	= str_replace('-', '', trim($reply));	//발신인증번호

	//$stran_msg		= iconv('utf8', 'euckr', $subj);		//제목
	$sms_content        = $subj.$msg;

	//$sms_content	= iconv('utf8', 'euckr', $sms_content);			//전송 내용을 받음
	//$sms_content	= conv_unescape_nl($sms_content);			//전송 내용을 받음

	//$rcv_number		= $stran_callback;			//수신번호


	$callbackURL = "www.youiwe.co.kr";
	$userdefine = $sms_id;							//예약취소를 위해 넣어주는 구분자 정의값, 사용자 임의로 지정해주시면 됩니다. 영문으로 넣어주셔야 합니다. 사용자가 구분할 수 있는 값을 넣어주세요.
	$canclemode = "1";								//예약 취소 모드 1: 사용자정의값에 의한 삭제.  현제는 무조건 1을 넣어주시면 됩니다.

	$seqno    = '1';
	$booking  = '';
	$wr_total = '1';
	$hs_flag  = '1';


	//구축 테스트 주소와 일반 웹서비스 선택
	if (substr($sms_id,0,3) == "bt_"){
		$webService = "http://webservice.youiwe.co.kr/SMS.v.6.bt/ServiceSMS_bt.asmx?WSDL";
	}
	else{
		$webService = "http://webservice.youiwe.co.kr/SMS.v.6/ServiceSMS.asmx?WSDL";
	}
		
	//+) funcMode는 메소드실행 후 반환값에 따라 다른 메시지를 띄우기 위해서 쓰입니다.

	$n_try = count($list);

	$wr_booking = $n_try;
	$wr_total = $n_try;
	$n_success = 0;

	$sms = new SMSPacket($webService); //SMS 객체 생성

	foreach ($list as $call) {
		$call = str_replace('-', '', trim($call));
		/*즉시 전송으로 구성하실경우*/
		$result=$sms->SendSMS($sms_id,$sms_pwd,$snd_number,$call,$sms_content);// 5개의 인자로 함수를 호출합니다.
		//echo $sms_id. " | ".$sms_pwd. " | ".$snd_number. " | ".$call. " | ".$sms_content. "<br>";
		//echo "ddd".$result."<br>";
		
		if (!$result){
			$n_success ++;
			$hs_flag = '0';
		}
	}

	// log
	$row = sql_fetch("select max(wr_no) as wr_no from {$g5['sms5_write_table']} ");
	if ($row)
		$wr_no = $row['wr_no'] + 1;
	else
		$wr_no = 1;
	
	$wr_failure = $n_success;			//실패
	$wr_success = $n_try - $n_success;	//성공 : 시도횟수 - 실패횟수

	sql_query("insert into {$g5['sms5_write_table']} set wr_no='$wr_no', wr_renum=0, wr_reply='$reply', wr_message='$msg', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='".G5_TIME_YMDHIS."', wr_success='$wr_success', wr_failure='$wr_failure' ");
	foreach ($list as $p) {
		$hs_memo = $p.'로 전송했습니다.';
		sql_query("insert into {$g5['sms5_history_table']} set wr_no='$wr_no', wr_renum=0, bg_no='{$row['bg_no']}', mb_id='{$row['mb_id']}', bk_no='{$row['bk_no']}', hs_name='".addslashes($row['bk_name'])."', hs_hp='{$row['bk_hp']}', hs_datetime='".G5_TIME_YMDHIS."', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='".addslashes($hs_memo)."', hs_log='".addslashes($log)."'", false);
	}
	
	return $n_success;
}
?>
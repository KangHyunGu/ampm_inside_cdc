<?php
include_once('./_common.php');

include_once(G5_MMS_PATH."/mms/common_mms.php");
include_once(G5_MMS_PATH."/mms/suremcfg_mms.php");

function sendmms($list, $reply, $subj, $msg, $filePath) {
	
	global $g5;
	
	$packettest = new MmsPacket;
	
	$seqno    = '1';
	$booking  = '';
	$wr_total = '1';
	$hs_flag  = '1';

	$reply 	= str_replace('-', '', trim($reply));

	$subject = iconv('utf8', 'euckr', $subj);

	$message = iconv('utf8', 'euckr', $msg);
	$message = conv_unescape_nl($message);

	$filepath1=$filePath;	//파일경로1
	$filepath2="";			//파일경로2
	$filepath3="";			//파일경로3

	$n_try = count($list);

	$wr_booking = $n_try;
	$wr_total = $n_try;
	$n_success = 0;

	foreach ($list as $call) {
		$call = str_replace('-', '', trim($call));
		$result=$packettest->SendMms($seqno, $call, $reply, $time, $subject, $message, $filepath1, $filepath2, $filepath3);
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



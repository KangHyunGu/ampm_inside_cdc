<?php
include_once('./_common.php');

$mb_id = trim($_POST['reg_mb_id']);
$sql = "SELECT mb_id FROM {$g5['member_table']} WHERE mb_id = '{$mb_id}'";
$row = sql_fetch($sql);
if ($row['mb_id']) {
    echo $reg_data = 'Y'. '/' .$row['mb_id'];    
} else {
	//인트라넷에서도 체크
	$sql = "SELECT mb_id FROM {$g5['member_table']} WHERE mb_id = '{$mb_id}'";
	$row = sql_fetch_intra($sql);
	if ($row['mb_id']) {
		echo $reg_data = 'Y'. '/' .$row['mb_id'];  
	}else {
	    echo $reg_data = 'N'. '/' .$mb_id;    
	}
}


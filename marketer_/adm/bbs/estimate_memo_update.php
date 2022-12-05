<?php
include_once('./_common.php');

if ($sw != 'memo')
    alert('sw 값이 제대로 넘어오지 않았습니다.');

if (substr_count($comments, "&#") > 50) {
    alert("내용에 올바르지 않은 코드가 다수 포함되어 있습니다.");
    exit;
}


$memo_table = $g5['write_prefix'] . "memo";

$deal_wr_id 	= trim($_POST['deal_wr_id']);
$re_wr_id 		= trim($_POST['re_wr_id']);

$wr_content		= trim($_POST['comments']);

if($_POST['title'] == ""){
	$wr_subject = "상담 메모".G5_TIME_YMDHIS;
}


// 등록
if ($proc_mode == 'w')
{
	$wr_num = get_next_num($memo_table);
	$wr_password = sql_password($wr_password);

	$sql = " insert into {$memo_table}
				set wr_num = '$wr_num',
					 wr_reply = '$wr_reply',
					 wr_comment = 0,
					 ca_name = '$ca_name',
					 wr_option = '$html,$secret,$mail',
					 wr_subject = '$wr_subject',
					 wr_content = '$wr_content',
					 wr_link1 = '$wr_link1',
					 wr_link2 = '$wr_link2',
					 wr_link1_hit = 0,
					 wr_link2_hit = 0,
					 wr_hit = 0,
					 wr_good = 0,
					 wr_nogood = 0,
					 mb_id = '{$member[mb_id]}',
					 wr_password = '$wr_password',
					 wr_name = '$member[mb_name]',
					 wr_email = '$wr_email',
					 wr_homepage = '$wr_homepage',
					 wr_datetime = '".G5_TIME_YMDHIS."',
					 wr_last = '".G5_TIME_YMDHIS."',
					 wr_ip = '$wr_ip',
					 wr_1 = '$deal_wr_id',
					 wr_2 = '$wr_2',
					 wr_3 = '$wr_3',
					 wr_4 = '$wr_4',
					 wr_5 = '$wr_5',
					 wr_6 = '$wr_6',
					 wr_7 = '$wr_7',
					 wr_8 = '$wr_8',
					 wr_9 = '$wr_9',
					 wr_10 = '$wr_10'
	";
	sql_query($sql);

	$wr_id = mysql_insert_id();

	// 부모 아이디에 UPDATE
	sql_query(" update {$memo_table} set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

	// 게시글 1 증가
	sql_query("update g5_board set bo_count_write = bo_count_write + 1 where bo_table = 'dealer'");
}
else if ($proc_mode == 'd')	// 삭제
{
	# 코멘트 삭제
	sql_query(" delete from {$memo_table} where wr_id ='$re_wr_id' ");

}else{
    alert('제대로 된 값이 넘어오지 않았습니다.');
}

goto_url('./estimate_memo.php?'.$qstr.'&amp;sw='.$sw.'&amp;bo_table='.$bo_table.'&amp;deal_wr_id='.$deal_wr_id, false);
?>

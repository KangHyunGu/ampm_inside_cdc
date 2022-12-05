<?php
include_once('./_common.php');
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
//exit;
*/

$searchStr = '&bo_table='.$bo_table.'&wr_id='.$wr_id;		//쿼리스트링

//==============================================================================================================================
// ▒▒ 파라미터 및 권한 체크
//==============================================================================================================================
if ($bo_table && $wr_id && $mb_id){		
	$ap = get_bbs_view($bo_table, $wr_id);
	if (!$ap['wr_id']) {
		$msg = $ap['wr_id'].' : 자료가 존재하지 않습니다.\\n';
	} else {
		$visible_val = $mb_id.'|'.$wr_id;
		
		//echo $visible_val."<br>";
		//echo $ap['wr_20']."<br>";

		$wr_20 = board_visible($ap['wr_20'], $visible_val, $visible_checked);
		//echo " update g5_write_".$bo_table." set wr_20 = '".$wr_20."' WHERE wr_id = '{$ap['wr_id']}' ";exit;
		
		sql_query(" update g5_write_".$bo_table." set wr_20 = '".$wr_20."' WHERE wr_id = '{$ap['wr_id']}' ");
	}	
	$msg = "처리 되었습니다.";
	$url = "board.php?bo_table=".$bo_table;
	//alert_close_reload($msg);
	goto_url('board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;'.$qstr);
}else{
	alert('제대로 된 값이 넘어오지 않았습니다.');
}
?>
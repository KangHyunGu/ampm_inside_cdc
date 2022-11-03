<?php
/* write_update.skin.php */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if(!$wr_comment) {  // 코멘일때는 저장하면 안됨
	
	$hs_type = ($w='u')?'정보수정':'최초등록';

	$sql = " insert into g5_marketer_bbs_history 
				set mb_id = '{$member['mb_id']}',
				 bo_table = '$bo_table',
				 hs_type = '$hs_type',
				 hs_ip = '{$_SERVER['REMOTE_ADDR']}',
				 hs_date = '".G5_TIME_YMDHIS."',
				 wr_id = '{$wr_id}',
				 ca_name = '{$ca_name}',
				 wr_subject = '{$wr_subject}',
				 wr_content = '{$wr_content}',
				 wr_link1 = '$wr_link1',
				 wr_link2 = '$wr_link2',

				 wr_ampm_user = '$wr_ampm_user',

				 wr_1 = '{$wr_1}',
				 wr_2 = '{$wr_2}',
				 wr_3 = '{$wr_3}',
				 wr_4 = '{$wr_4}',
				 wr_5 = '{$wr_5}',
				 wr_6 = '{$wr_6}',
				 wr_7 = '{$wr_7}',
				 wr_8 = '{$wr_8}',
				 wr_9 = '{$wr_9}',
				 wr_10 = '{$wr_10}', 
				 wr_11 = '{$wr_11}', 
				 wr_12 = '{$wr_12}', 
				 wr_13 = '{$wr_13}', 
				 wr_14 = '{$wr_14}', 
				 wr_15 = '{$wr_15}', 
				 wr_16 = '{$wr_16}', 
				 wr_17 = '{$wr_17}', 
				 wr_18 = '{$wr_18}', 
				 wr_19 = '{$wr_19}', 
				 wr_20 = '{$wr_20}'
	" ; 
	sql_query($sql); 
}
// CDC 적용
include_once(CDC_PATH.'/write_update.skin.php');
?>
<?php
include_once('./_common.php');

$sql = " select * from g5_marketer_detail ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result))
{
	$mb = get_marketer($row['mb_id']);

	if($mb['mb_id']){
		$sql= " update g5_marketer_detail set mb_part = '{$mb['mb_part']}', mb_team = '{$mb['mb_team']}', mb_post = '{$mb['mb_post']}' where mb_id = '{$mb['mb_id']}' ";
		sql_query($sql);
	}else{
		$sql= " insert into g5_marketer_detail  set mb_id = '{$mb['mb_id']}', mb_part = '{$mb['mb_part']}', mb_team = '{$mb['mb_team']}', mb_post = '{$mb['mb_post']}' ";
		sql_query($sql);
	}
	echo $sql."<br>";
}

?>
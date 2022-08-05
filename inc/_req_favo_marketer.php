<?php
include_once('./_common.php');
include_once(G5_INCLUDE_PATH."/JSON.php");
?>
<?php
$marketer_id= $_POST['marketer_id'];
$mb_id		= $_POST['mb_id'];
$mode		= $_POST['mode'];

$fv = sql_fetch(" select * from g5_favo_info where mb_id = TRIM('$mb_id') ");

if($fv['mb_id']){
	$fa_marketer = go_processFavo($fv['fa_marketer'], $marketer_id, $mode);

	$row = sql_query(" update g5_favo_info set fa_marketer = '{$fa_marketer}' where mb_id = '{$fv['mb_id']}' ");
	if($row){
		if($mode == 'sub'){
			echo "sub";
		}else{
			echo "add";
		}
	}
}else{
	$fa_marketer = go_processFavo('', $marketer_id, $mode);

	$row = sql_query(" insert into g5_favo_info set mb_id = '{$mb_id}', fa_marketer = '{$fa_marketer}' ");
	if($row){
		if($mode == 'sub'){
			echo "sub";
		}else{
			echo "add";
		}
	}
}

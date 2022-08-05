<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
/*
$mk = get_marketer($wr_1);

$mb_id = $mk['mb_id'];
$wr_name = addslashes(clean_xss_tags($mk['mb_name']));
*/
$wr_4 = ($memberEmail)?$memberEmail:$memberEmail1."@".$memberEmail2;
$wr_5 = ($memberHp)?$memberHp:$memberHp1."-".$memberHp2."-".$memberHp3;
?>
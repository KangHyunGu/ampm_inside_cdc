<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

//$redirect_url = run_replace('write_update_move_url', short_url_clean(G5_HTTP_BBS_URL.'/write.php?bo_table='.$bo_table.$qstr), $board, $wr_id, $w, $qstr, $file_upload_msg);
$redirect_url = run_replace('write_update_move_url', '/', $board, $wr_id, $w, $qstr, $file_upload_msg);
//echo $redirect_url; exit;
$msg = "대행의뢰가 접수되었습니다.";
alert_move($msg, $redirect_url);
?>
<?php
/**************************
@Filename: login_log.php
@Version : 0.1
@Author  : Freemaster(http://freemaster.kr)
@Date  : 2016/04/01 Fri Am 10:03:24
@Content : PHP by Editplus
**************************/
include_once('./_common.php');

$g5['title'] = '로그인 기록';
include_once('./_head.php');

if(!$is_member)
    alert("회원만 접근가능합니다");

$sql_from = " FROM ".$g5['mklogin_log_table'];
$sql_common = " WHERE (1) ";
if($is_admin)
{
    $sfl = $sfl?$sfl:"mb_id";
    if($stx)
        $sql_common .= " AND ".$sfl." LIKE '%".$stx."%' ";
    else
        $sql_common .= "";
}
else
    $sql_common .= " AND mb_id = '".$member['mb_id']."' ";

$sql = " SELECT COUNT(*) AS cnt ".$sql_from." ".$sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql_order = " ORDER BY loc_datetime DESC";
$sql_limit = " LIMIT ".$from_record.", ".$rows;

$sql = "SELECT * ".$sql_from." ".$sql_common." ".$sql_order." ".$sql_limit;
$result = sql_query($sql);

// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체
$login_file = $member_skin_path.'/login.skin.php';
if (!file_exists($login_file))
    $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/login_log.skin.php');

include_once('./_tail.php');
?>
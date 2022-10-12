<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH . '/captcha.lib.php');

$g5['title'] = 'CDC 완료링크 저장';


$msg = array();

$is_blog = $_POST['is_blog'];
$is_insta = $_POST['is_insta'];
$is_youtube = $_POST['is_youtube'];
$wr_comp_blog_link = isset($_POST['wr_comp_blog_link']) ? $_POST['wr_comp_blog_link'] : '';
$wr_comp_insta_link = isset($_POST['wr_comp_insta_link']) ? $_POST['wr_comp_insta_link'] : '';
$wr_comp_youtube_link = isset($_POST['wr_comp_youtube_link']) ? $_POST['wr_comp_youtube_link'] : '';


if ($is_blog && $wr_comp_blog_link == '') {
    $msg[] = '<strong>블로그 완료</strong>링크를 입력하세요';
}

if ($is_insta && $wr_comp_insta_link == '') {
    $msg[] = '<strong>인스타 완료</strong>링크를 입력하세요';
}

if ($is_youtube && $wr_comp_youtube_link == '') {
    $msg[] = '<strong>유튜브 완료</strong>링크를 입력하세요';
}

$update_sql = "update {$g5['cdc_table']} 
set wr_comp_blog_link = '$wr_comp_blog_link',
    wr_comp_insta_link = '$wr_comp_insta_link',
    wr_comp_youtube_link = '$wr_comp_youtube_link',
    wr_is_comp = 'Y' 
    where bo_table = '{$_POST['bo_table']}'
    and wr_id    = '{$_POST['wr_id']}'";

sql_query($update_sql);

goto_url('./index.php');

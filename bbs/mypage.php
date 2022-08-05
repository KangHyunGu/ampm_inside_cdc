<?php
include_once('./_common.php');

$g5['title'] = '마이페이지';
include_once('./_head.php');

// 게시물 아이디가 있다면 게시물 보기를 INCLUDE
if (isset($wr_id) && $wr_id) {
    include_once(G5_BBS_PATH.'/mypage_view.php');
}else{
    include_once(G5_BBS_PATH.'/mypage_list.php');
}

include_once('./_tail.php');
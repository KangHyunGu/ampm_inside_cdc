<?php
include_once('./_common.php');

$count = (isset($_POST['chk_bn_id']) && is_array($_POST['chk_bn_id'])) ? count($_POST['chk_bn_id']) : 0;
$post_btn_submit = isset($_POST['btn_submit']) ? clean_xss_tags($_POST['btn_submit'], 1, 1) : '';

if(!$count) {
    alert(addcslashes($post_btn_submit, '"\\/').' 하실 항목을 하나 이상 선택하세요.');
}

$write_table = $g5['write_prefix'].$bo_table;


if($post_btn_submit === '선택삭제') {
    include './delete_all.php';

} else if($post_btn_submit === '선택노출') {
    $sw = 'show';
	// 게시글 노출 처리
    include './delete_all.php';

} else if($post_btn_submit === '선택숨김') {
    $sw = 'hide';
	// 게시글 숨김 처리
    include './delete_all.php';

} else if($post_btn_submit === '선택처리') {
    $sw = 'process';
	// 게시글 처리 처리, 선택처리가 들어가면 확인 된거로 인지
    include './delete_all.php';

} else if($post_btn_submit === '선택담당자') {
    $sw = 'marketer';
	// 게시글 처리 처리, 선택처리가 들어가면 확인 된거로 인지
    include './delete_all.php';

} else if($post_btn_submit === '일괄처리') {
    $sw = 'proc';
	// 게시글 처리 처리, 선택처리가 들어가면 확인 된거로 인지
    include './proc_all.php';

} else if($post_btn_submit === '선택복사') {
    $sw = 'copy';
    include './move.php';

} else if($post_btn_submit === '선택이동') {
    $sw = 'move';
    include './move.php';


} else {
    alert('올바른 방법으로 이용해 주세요.');
}
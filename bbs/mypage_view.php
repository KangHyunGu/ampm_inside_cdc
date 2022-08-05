<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
$ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name))
{
	sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

	// 자신의 글이면 통과
	if ($write['mb_id'] && $write['mb_id'] === $member['mb_id']) {
		;
	} else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
		// 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
		;
	} else {
		// 글읽기 포인트가 설정되어 있다면
		if ($config['cf_use_point'] && $board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
			alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글읽기('.number_format($board['bo_read_point']).')가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.');

		insert_point($member['mb_id'], $board['bo_read_point'], ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$wr_id.' 글읽기', $bo_table, $wr_id, '읽기');
	}

	set_session($ss_name, TRUE);
}



// 게시판에서 두단어 이상 검색 후 검색된 게시물에 코멘트를 남기면 나오던 오류 수정
$sop = strtolower($sop);
if ($sop != 'and' && $sop != 'or')
    $sop = 'and';

@include_once($mypage_skin_path.'/view.head.skin.php');

$sql_search = "";
// 검색이면
if ($sca || $stx || $stx === '0') {
    // where 문을 얻음
    $sql_search = get_sql_search($sca, $sfl, $stx, $sop);
    $search_href = get_pretty_mypage_url($bo_table,'','&amp;page='.$page.$qstr, '', $go_table);
    $list_href = get_pretty_mypage_url($bo_table,'','', '', '', $go_table);
} else {
    $search_href = '';
    $list_href = get_pretty_mypage_url($bo_table,'',$qstr, '', $go_table);
}

if (!$board['bo_use_list_view']) {
    if ($sql_search)
        $sql_search = " and " . $sql_search;

    // 윗글을 얻음
    $sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply < '{$write['wr_reply']}' {$sql_search} order by wr_num desc, wr_reply desc limit 1 ";
    $prev = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (! (isset($prev['wr_id']) && $prev['wr_id'])) {
        $sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num < '{$write['wr_num']}' {$sql_search} order by wr_num desc, wr_reply desc limit 1 ";
        $prev = sql_fetch($sql);
    }

    // 아래글을 얻음
    $sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply > '{$write['wr_reply']}' {$sql_search} order by wr_num, wr_reply limit 1 ";
    $next = sql_fetch($sql);
    // 위의 쿼리문으로 값을 얻지 못했다면
    if (! (isset($next['wr_id']) && $next['wr_id'])) {
        $sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num > '{$write['wr_num']}' {$sql_search} order by wr_num, wr_reply limit 1 ";
        $next = sql_fetch($sql);
    }
}

// 이전글 링크
$prev_href = '';
if (isset($prev['wr_id']) && $prev['wr_id']) {
    $prev_wr_subject = get_text(cut_str($prev['wr_subject'], 255));
    $prev_href = get_pretty_mypage_url($bo_table, $prev['wr_id'], $qstr, '', $go_table);
    $prev_wr_date = $prev['wr_datetime'];
}

// 다음글 링크
$next_href = '';
if (isset($next['wr_id']) && $next['wr_id']) {
    $next_wr_subject = get_text(cut_str($next['wr_subject'], 255));
    $next_href = get_pretty_mypage_url($bo_table, $next['wr_id'], $qstr, '', $go_table);
    $next_wr_date = $next['wr_datetime'];
}

// 쓰기 링크
$write_href = '';
if ($member['mb_level'] >= $board['bo_write_level']) {
    $write_href = short_url_clean(G5_BBS_URL.'/write.php?bo_table='.$bo_table);

	///////////////////////////////////////////////////////////////////
	//인사이트 영상교육 레퍼런스 AMPM 사원만 등록  - feeris
	///////////////////////////////////////////////////////////////////
	if($is_admin !='super' && $member['ampmkey'] != 'Y' && ($bo_table == 'insight' || $bo_table == 'video' || $bo_table == 'reference')){ // 일반회원
		$write_href = '';
	}
}

// 답변 링크
$reply_href = '';
if ($member['mb_level'] >= $board['bo_reply_level']) {
    $reply_href = short_url_clean(G5_BBS_URL.'/write.php?w=r&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);

	///////////////////////////////////////////////////////////////////
	//인사이트 영상교육 레퍼런스 AMPM 사원만 등록  - feeris
	///////////////////////////////////////////////////////////////////
	if($is_admin !='super' && $member['ampmkey'] != 'Y' && ($bo_table == 'insight' || $bo_table == 'video' || $bo_table == 'reference')){ // 일반회원
		$reply_href = '';
	}
}

// 수정, 삭제 링크
$update_href = $delete_href = '';
// 로그인중이고 자신의 글이라면 또는 관리자라면 비밀번호를 묻지 않고 바로 수정, 삭제 가능

///////////////////////////////////////////////////////////////////
//AMPM 사원도 관리권한이 있어 is_admin 구체적 명시 - feeris
///////////////////////////////////////////////////////////////////
if (($member['mb_id'] && ($member['mb_id'] === $write['mb_id'])) || ($is_admin && $is_admin != 'mk_admin')) {
    $update_href = short_url_clean(G5_BBS_URL.'/write.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;page='.$page.$qstr);
    set_session('ss_delete_token', $token = uniqid(time()));
    $delete_href = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
}
else if (!$write['mb_id']) { // 회원이 쓴 글이 아니라면
    $update_href = G5_BBS_URL.'/password.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;page='.$page.$qstr;
    $delete_href = G5_BBS_URL.'/password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;page='.$page.$qstr;
}

// 최고, 그룹관리자라면 글 복사, 이동 가능
$copy_href = $move_href = '';
if ($write['wr_reply'] == '' && ($is_admin == 'super' || $is_admin == 'group')) {
    $copy_href = G5_BBS_URL.'/move.php?sw=copy&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;page='.$page.$qstr;
    $move_href = G5_BBS_URL.'/move.php?sw=move&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;page='.$page.$qstr;
}

$scrap_href = '';
$good_href = '';
$nogood_href = '';
if ($is_member) {
    // 스크랩 링크
    $scrap_href = G5_BBS_URL.'/scrap_popin.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table;

    // 추천 링크
    if ($board['bo_use_good'])
        $good_href = G5_BBS_URL.'/good.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;good=good';

    // 비추천 링크
    if ($board['bo_use_nogood'])
        $nogood_href = G5_BBS_URL.'/good.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;good=nogood';
}

$view = get_view($write, $board, $board_skin_path);

if (strstr($sfl, 'subject'))
    $view['subject'] = search_font($stx, $view['subject']);

$html = 0;
if (strstr($view['wr_option'], 'html1'))
    $html = 1;
else if (strstr($view['wr_option'], 'html2'))
    $html = 2;

$view['content'] = conv_content($view['wr_content'], $html);
if (strstr($sfl, 'content'))
    $view['content'] = search_font($stx, $view['content']);

//$view['rich_content'] = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view['content']);
function conv_rich_content($matches)
{
    global $view;
    return view_image($view, $matches[1], $matches[2]);
}
$view['rich_content'] = preg_replace_callback("/{이미지\:([0-9]+)[:]?([^}]*)}/i", "conv_rich_content", $view['content']);

$is_signature = false;
$signature = '';
if ($board['bo_use_signature'] && $view['mb_id']) {
    $is_signature = true;
    $mb = get_member($view['mb_id']);
    $signature = $mb['mb_signature'];

    $signature = conv_content($signature, 1);
}

///////////////////////////////////////////////////////////////////////
// AMPM 최초 글 등록 시에 노출 ID,이름도 같이 저장한다.
// 담당자 변경 시에 노출 ID,이름을 변경하여 적용한다.
///////////////////////////////////////////////////////////////////////
if($view['wr_17']){
	$view['mb_id'] = $view['wr_17'];
	$view['wr_name'] = $view['wr_18'];
	$view['name'] = $view['wr_18'];
}

///////////////////////////////////////////////////////////////////////
//대행의뢰, 상담신청의 경우 수정권한은 없고 
//담당마케터의 경우 삭제 권한은 부여
///////////////////////////////////////////////////////////////////////
if($go_table == 'request' || $go_table == 'mkestimate'){
	$update_href = false;
	set_session('ss_delete_token', $token = uniqid(time()));
    $delete_href = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;go_table='.$go_table.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
	$delete_href = false;
}

if($go_table == 'mkestimate'){
	include_once($mypage_skin_path.'/view_mkestimate.skin.php');

}else if($go_table == 'request'){
	include_once($mypage_skin_path.'/view_request.skin.php');

}else{
	include_once($mypage_skin_path.'/view.skin.php');
}


@include_once($mypage_skin_path.'/view.tail.skin.php');
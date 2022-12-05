<?php
include_once('./_common.php');

$g5['title'] = '마이페이지';
include_once('./_head.php');

if($go_table == 'qna'){
	$sql_common = " 
					FROM (
						SELECT *, 'qna' as bo_table
						FROM g5_write_qna
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='client'
	";
}else if($go_table == 'mkestimate'){
	$sql_common = " 
					FROM (
						SELECT *, 'mkestimate' as bo_table
						FROM g5_write_mkestimate
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='marketer'
	";
}else if($go_table == 'request'){
	$sql_common = " 
					FROM (
						SELECT *, 'request' as bo_table
						FROM g5_write_request
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='client'
	";
}else if($go_table == 'amypage'){	//마케터 내가쓴글
	$sql_common = " 
					FROM (
						SELECT *, 'insight' as bo_table
						FROM g5_write_insight 
						union
						SELECT *, 'reference' as bo_table
						FROM g5_write_reference 
						union
						SELECT *, 'video' as bo_table
						FROM g5_write_video 
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='inside'
	";
}else if($go_table == 'acomment'){	//내가쓴댓글
	$sql_common = " 
					FROM (
						SELECT *, 'insight' as bo_table, wr_17 as wr_writer
						FROM g5_write_insight 
						union
						SELECT *, 'reference' as bo_table, wr_17 as wr_writer
						FROM g5_write_reference 
						union
						SELECT *, 'video' as bo_table, wr_17 as wr_writer
						FROM g5_write_video 
						union
						SELECT *, 'qna' as bo_table, if(wr_11 != '', wr_11, wr_17) as wr_writer
						FROM g5_write_qna 
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE 1
	";
}else if($go_table == 'favorites'){		//일반회원 즐겨찾기
	$fb = get_favoMarketer_info($member['mb_id']);
	if($fb['fa_marketer']){
		$marketer_array = explode(",", trim($fb['fa_marketer']));
		for($i=0;$i<count($marketer_array);$i++){ 
			$marketer = $marketer."'".$marketer_array[$i]."',";
		}
		$marketer = substr($marketer, 0, -1);
	}
	
	if($fb['fa_marketer']){
		$sql_common = " 
						FROM (
							SELECT *, 'insight' as bo_table
							FROM g5_write_insight 
							union
							SELECT *, 'reference' as bo_table
							FROM g5_write_reference 
							union
							SELECT *, 'video' as bo_table
							FROM g5_write_video 
						) a
						INNER JOIN g5_board b ON a.bo_table = b.bo_table
						WHERE b.gr_id='inside'
		";

		$sql_common.= " 
						AND a.wr_17 IN({$marketer}) 
		";
	}
}else if($go_table == 'more'){		//일반회원 컨텐츠 더보기
	$sql_common = " 
					FROM (
						SELECT *, 'insight' as bo_table
						FROM g5_write_insight 
						union
						SELECT *, 'reference' as bo_table
						FROM g5_write_reference 
						union
						SELECT *, 'video' as bo_table
						FROM g5_write_video 
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='inside'
	";
}else if($go_table == 'umypage'){	//일반회원 내가쓴글
	$sql_common = " 
					FROM (
						SELECT *, 'request' as bo_table
						FROM g5_write_request 
						union
						SELECT *, 'qna' as bo_table
						FROM g5_write_qna 
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE b.gr_id='client'
	";
}else if($go_table == 'ucomment'){						//일반회원 내가쓴댓글
	$sql_common = " 
					FROM (
						SELECT *, 'insight' as bo_table
						FROM g5_write_insight 
						union
						SELECT *, 'reference' as bo_table
						FROM g5_write_reference 
						union
						SELECT *, 'video' as bo_table
						FROM g5_write_video 
						union
						SELECT *, 'request' as bo_table
						FROM g5_write_request 
						union
						SELECT *, 'qna' as bo_table
						FROM g5_write_qna 
					) a
					INNER JOIN g5_board b ON a.bo_table = b.bo_table
					WHERE 1
	";
}

$view = isset($_GET['view']) ? $_GET['view'] : "";
$is_checkbox = false;
if ($view == "w"){
	$is_checkbox = true;
	$sql_common .= " and a.wr_id = a.wr_parent ";
}else if ($view == "c"){
    $sql_common .= " and a.wr_id <> a.wr_parent ";
}else{
    $view = '';
}

if($go_table == 'more'){				//컨텐츠 더보기의 경우 선택된 마케터의 자료를 보여준다.
	$mb_id = $_GET['mk_id'];
}else if($go_table == 'favorites'){		//일반회원 즐겨찾기
	$mb_id = '';
}else{
	$mb_id = isset($member['mb_id']) ? ($member['mb_id']) : $_GET['mk_id'];
}


if ($mb_id) {
	$is_checkbox = true;

	if($go_table == 'qna'){
		$sql_common .= " and (a.wr_11 = '{$mb_id}' OR a.wr_11 = '') ";
	
	}else if($go_table == 'mkestimate'){
		$sql_common .= " and a.mb_id = '{$mb_id}' ";
	
	}else if($go_table == 'request'){
		$sql_common .= " and (a.wr_11 = '{$mb_id}'  OR a.wr_11 = '') ";
	
	}else if($go_table == 'acomment'){
		$sql_common .= " and a.wr_writer = '{$mb_id}' ";
	
	}else{
		$sql_common .= " and a.wr_17 = '{$mb_id}' ";
	}
}

//검색추가
if ($sear_bo_table) {
	$is_checkbox = true;
	$sql_common .= " and a.bo_table = '{$sear_bo_table}' ";
}
if ($stx && $sfl) {
	$is_checkbox = true;
    $sql_common .= " and ({$sfl} like '%{$stx}%') ";
}


// 정렬에 사용하는 QUERY_STRING
$qstr2 = 'bo_table='.$bo_table.'&amp;go_table='.$go_table.'&amp;sop='.$sop.'&amp;view='.$view;

if(!$sst){
    //$sst  = "wr_num, wr_reply";
    $sst  = "wr_datetime desc, wr_num, wr_reply";
}
if ($sst) {
    $sql_order = " order by {$sst} {$sod} ";
}

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$list = array();
$sql = " select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
//echo $sql; 
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'].$row['bo_table'];

    if ($row['wr_id'] == $row['wr_parent']) {

        // 원글
        $comment = "";
        $comment_link = "";
        $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
        $list[$i] = $row2;

        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
		// 당일인 경우 시간으로 표시함
        $datetime = substr($row2['wr_datetime'],0,10);
        $datetime2 = $row2['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2,11,5);
        } else {
            $datetime2 = substr($datetime2,5,5);
        }

        $mk_id = $row2['wr_17'];
        $mk_name = $row2['wr_18'];

    } else {

        // 코멘트
        $comment = '[코] ';
        $comment_link = '#c_'.$row['wr_id'];
        $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");//원글
        $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime,wr_content, wr_17, wr_18 from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
        $list[$i] = $row2;
        $list[$i]['wr_id'] = $row['wr_id'];
        $list[$i]['mb_id'] = $row3['mb_id'];
        $list[$i]['wr_name'] = $row3['wr_name'];
        $list[$i]['wr_email'] = $row3['wr_email'];
        $list[$i]['wr_homepage'] = $row3['wr_homepage'];

        $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);

        // 당일인 경우 시간으로 표시함
        $datetime = substr($row3['wr_datetime'],0,10);
        $datetime2 = $row3['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2,11,5);
        } else {
            $datetime2 = substr($datetime2,5,5);
        }

        $cm_content = $row3['wr_content'];
		//원글작성자정보
		$mk_id = $row2['wr_17'];
        $mk_name = $row2['wr_18'];
    }

    $list[$i]['gr_id'] = $row['gr_id'];
    $list[$i]['bo_table'] = $row['bo_table'];
    //$list[$i]['name'] = $name;
    $list[$i]['name'] = $row['wr_name'];
    $list[$i]['mk_id'] = $mk_id;
    $list[$i]['mk_name'] = $mk_name;
    $list[$i]['comment'] = $comment;

    $list[$i]['bo_new'] = $row['bo_new'];
    $list[$i]['bo_hot'] = $row['bo_hot'];
	
	if($list[$i]['gr_id'] == 'client' && $list[$i]['bo_table'] == 'request'){
		if($member['ampmkey'] == 'Y'){
		    $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
		}else{
		    $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
		}

	}else if($list[$i]['gr_id'] == 'marketer' && $list[$i]['bo_table'] == 'mkestimate'){
	    $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
	
	}else{
	    $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
	}
    $list[$i]['datetime'] = $datetime;
    $list[$i]['datetime2'] = $datetime2;

	$list[$i]['icon_new'] = '';
	//if ($board['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
	if ($list[$i]['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($list[$i]['bo_new'] * 3600)))
		$list[$i]['icon_new'] = '<img src="'.$skin_url.'/img/icon_new.gif" alt="새글">';

    $list[$i]['comment_cnt'] = '';
    if ($list[$i]['wr_comment'])
       $list[$i]['comment_cnt'] = "<span class=\"cnt_cmt\">".$list[$i]['wr_comment']."</span>";

    $list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
    $list[$i]['wr_subject'] = $row2['wr_subject'];
    $list[$i]['cm_content'] = $cm_content;

	$list[$i]['wr_ip']  = $row2['wr_ip'];
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;go_table=$go_table&amp;mk_id=$mb_id&amp;page=");


if($go_table == 'qna'){
	include_once($mypage_skin_path.'/list_qna.skin.php');

}else if($go_table == 'mkestimate'){
	include_once($mypage_skin_path.'/list_mkestimate.skin.php');

}else if($go_table == 'request'){
	include_once($mypage_skin_path.'/list_request.skin.php');

}else if($go_table == 'acomment' || $go_table == 'ucomment'){
	include_once($mypage_skin_path.'/list_comment.skin.php');

}else if($go_table == 'umypage'){
	include_once($mypage_skin_path.'/list_umypage.skin.php');

}else if($go_table == 'more'){
	include_once($mypage_skin_path.'/list_more.skin.php');

}else if($go_table == 'favorites'){		//일반회원 즐겨찾기
	include_once($mypage_skin_path.'/list_favorites.skin.php');
}else{
	include_once($mypage_skin_path.'/list.skin.php');

}
include_once('./_tail.php');
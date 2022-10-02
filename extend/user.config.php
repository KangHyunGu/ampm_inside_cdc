<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가;
?>
<?php
// 회원 팀장 정보를 얻는다.
function get_member_teamowner($mb_id, $mb_part, $mb_team, $fields='*')
{
    global $g5;

    return sql_fetch(" select $fields from {$g5['member_table']} where 1 and mb_level >='2' and mb_part = TRIM('$mb_part') and mb_team = TRIM('$mb_team') and mb_post = 'P2' ");
}


// 회원 팀장 정보를 얻는다.
function get_teamowner($mb_id, $mb_part, $mb_team, $fields='*')
{
    global $g5;

	
	if($mb_team == 'S2'){	//경영지원팀
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P5' ";
	}else if($mb_team == 'T1'){	//대외협력실
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P4' ";
	}else if($mb_team == 'T2'){	//TFT
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P3' ";
	}else if($mb_team == 'A0'){	//본부장이상은 대표님 표기
		$search_text = " and mb_post = 'P6' ";
	}else{
		$search_text = " and mb_part = TRIM('$mb_part') and mb_team = TRIM('$mb_team') and mb_post = 'P2' ";
	}

    return sql_fetch(" select $fields from {$g5['member_table']} where 1 and mb_level >='2' $search_text ");
}

// 회원 본부장 정보를 얻는다.
function get_partowner($mb_id, $mb_part, $mb_team, $fields='*')
{
    global $g5;

	if($mb_team == 'S1'){	//개발지원팀
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P5' ";
	}else if($mb_team == 'S2'){	//경영지원팀
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P5' ";
	}else if($mb_team == 'Q1'){	//퍼포먼스팀 - 본부 정보 배제
		$search_text = " and mb_team = TRIM('$mb_team') and mb_post = 'P2' ";
	}else if($mb_team == 'T1'){	//대외협력실
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P4' ";
	}else if($mb_team == 'A0'){	//본부장이상은 대표님 표기
		//$search_text = " and mb_post = 'P6' ";
		$search_text = " and mb_post = '' ";
	}else if($mb_part == 'AD2'){	//광고기획2본부 
		$search_text = " and mb_post = 'P4' ";
	}else{
		$search_text = " and mb_part = TRIM('$mb_part') and mb_post = 'P3' ";
	}
	//echo "select $fields from {$g5['member_table']} where 1 and mb_level >='2' $search_text ";
    return sql_fetch(" select $fields from {$g5['member_table']} where 1 and mb_level >='2' $search_text ");
}

//사원 팀별 홈페이지 정보
function myHomepageInfo($part, $team){
    global $g5;

	switch ($part) {
	    case 'AD3':	//광고컨설팅본부
		switch ($team) {
			case 'M1':	//광고건설팅1팀
				$homepageInfo = "www.am-pm.co.kr";
			break;
			case 'M2':	//광고건설팅2팀
				$homepageInfo = "www.ampmglobal.co.kr";
			break;
			case 'M3':	//광고건설팅3팀
				$homepageInfo = "www.ampm-mk.com";
			break;
			case 'K1':	//영상사업1팀
				$homepageInfo = "www.zzzstudio.co.kr";
			break;
			default:
				$homepageInfo = "www.ampm.co.kr";
		}
		break;
	    default:
		$homepageInfo = "www.ampm.co.kr";
	}

	return $homepageInfo;
}

//사원 팀별 대표번호 정보
function myTeamPhoneInfo($part, $team,$fields='*'){
    global $g5;

	$telNo = sql_fetch(" select $fields from {$g5['member_table']} where 1 and mb_level >='2' and mb_part = TRIM('$part') and mb_team = TRIM('$team') and mb_post = 'P2' ");


	switch ($part) {
	    case 'AD3':	//광고컨설팅본부
		switch ($team) {
			case 'M1':	//광고건설팅1팀
				$teamPhoneInfo = "4424";
			break;
			case 'M2':	//광고건설팅2팀
				$teamPhoneInfo = "4242";
			break;
			case 'M3':	//광고건설팅3팀
				$teamPhoneInfo = "4033";
			break;
			case 'K1':	//영상사업1팀
				$teamPhoneInfo = "4228";
			break;
		}
		break;
	    case 'ASU':	//경영지원본부
			switch ($team) {
				case 'S2':	//경영관리팀
					$teamPhoneInfo = "4260";
				break;
				case 'T1':	//대외협력실
					$teamPhoneInfo = "4220";
				break;
				default:
					$teamPhoneInfo = $telNo['mb_tel'];
			}
		break;
	    case 'AT1':	//대외협력본부
			switch ($team) {
				case 'T1':	//대외협력실
					$teamPhoneInfo = "4220";
				break;
				default:
					$teamPhoneInfo = $telNo['mb_tel'];
			}
		break;
	    case 'AQ1':	//퍼포먼스마케팅본부
			switch ($team) {
				case 'Q1':	//퍼포먼스마케팅1팀
					$teamPhoneInfo = "4642";
				break;
				default:
					$teamPhoneInfo = $telNo['mb_tel'];
			}
		break;
	    default:
			$teamPhoneInfo = $telNo['mb_tel'];
	}

	return $teamPhoneInfo;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//마케터소개
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
function get_marketer_file($bo_table, $wr_id)
{
    global $g5, $qstr;

	$g5['file_table'] = G5_TABLE_PREFIX.$bo_table.'_file'; // 게시판 첨부파일 테이블

    $file['count'] = 0;
    $sql = " select * from {$g5['file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $no = $row['bf_no'];
        $bf_content = $row['bf_content'] ? html_purifier($row['bf_content']) : '';
        $file[$no]['href'] = G5_URL."/inc/file_download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
        $file[$no]['download'] = $row['bf_download'];
        // 4.00.11 - 파일 path 추가
        $file[$no]['path'] = G5_DATA_URL.'/file/'.$bo_table.'_youtube';
        $file[$no]['size'] = get_filesize($row['bf_filesize']);
        $file[$no]['datetime'] = $row['bf_datetime'];
        $file[$no]['source'] = addslashes($row['bf_source']);
        $file[$no]['bf_content'] = $bf_content;
        $file[$no]['content'] = get_text($bf_content);
        //$file[$no]['view'] = view_file_link($row['bf_file'], $file[$no]['content']);
        $file[$no]['view'] = view_marketer_file_link($row['bf_file'], $row['bf_width'], $row['bf_height'], $file[$no]['content']);
        $file[$no]['file'] = $row['bf_file'];
        $file[$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
        $file[$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
        $file[$no]['image_type'] = $row['bf_type'];
		$file[$no]['bf_link'] = $row['bf_link'];
        $file['count']++;
    }

    return $file;
}

//  게시글에 첨부된 파일 모두 삭제
function get_marketer_file_delete($bo_table, $wr_id)
{
    global $config;
    global $g5;

	$g5['file_table'] = G5_TABLE_PREFIX.$bo_table.'_file'; // 게시판 첨부파일 테이블

	$row = sql_fetch(" select bf_file from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	@unlink(G5_DATA_PATH.'/file/'.$bo_table.'_youtube'.'/'.$row['bf_file']);
	
	// 썸네일삭제
	if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
		delete_board_thumbnail($bo_table.'_youtube', $row['bf_file']);
	}

	sql_query(" delete from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
}

// 파일을 보이게 하는 링크 (이미지, 플래쉬, 동영상)
function view_marketer_file_link($file, $width, $height, $content='')
{
    global $config, $board;
    global $g5;
    static $ids;

    if (!$file) return;

    $ids++;

    // 파일의 폭이 게시판설정의 이미지폭 보다 크다면 게시판설정 폭으로 맞추고 비율에 따라 높이를 계산
    if ($width > $board['bo_image_width'] && $board['bo_image_width'])
    {
        $rate = $board['bo_image_width'] / $width;
        $width = $board['bo_image_width'];
        $height = (int)($height * $rate);
    }

    // 폭이 있는 경우 폭과 높이의 속성을 주고, 없으면 자동 계산되도록 코드를 만들지 않는다.
    if ($width)
        $attr = ' width="'.$width.'" height="'.$height.'" ';
    else
        $attr = '';

    if (preg_match("/\.({$config['cf_image_extension']})$/i", $file)) {
        $img = '<a href="'.G5_BBS_URL.'/view_image.php?bo_table='.$board['bo_table'].'&amp;fn='.urlencode($file).'" target="_blank" class="view_image">';
        $img .= '<img src="'.G5_DATA_URL.'/file/'.$board['bo_table'].'_youtube'.'/'.urlencode($file).'" alt="'.$content.'">';
        $img .= '</a>';

        return $img;
    }
}

// 게시글리스트 썸네일 생성
function get_list_thumbnail2($bo_table, $wr_id, $thumb_width, $thumb_height, $is_create=false, $is_crop=true, $crop_mode='center', $is_sharpen=false, $um_value='80/0.5/3')
{
    global $g5, $config;
    $filename = $alt = "";
    $edt = false;

	$write_table = $g5['write_prefix'].$bo_table;
	$sql = " select wr_content from $write_table where wr_id = '$wr_id' ";
	$write = sql_fetch($sql);
	$matches = get_editor_image($write['wr_content'], false);
	$edt = true;

	if($matches){
		for($i=0; $i<count($matches[1]); $i++)
		{
			// 이미지 path 구함
			$p = parse_url($matches[1][$i]);
			if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
				$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
			else
				$data_path = $p['path'];

			$srcfile = G5_PATH.$data_path;

			if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
				$size = @getimagesize($srcfile);
				if(empty($size))
					continue;

				$filename = basename($srcfile);
				$filepath = dirname($srcfile);

				preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
				$alt = get_text($malt[1]);

				break;
			}
		}
	}else{
		$sql = " select bf_file, bf_content from {$g5['board_file_table']}
					where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_type between '1' and '3' order by bf_no limit 0, 1 ";
		$row = sql_fetch($sql);

		if($row['bf_file']) {
			$filename = $row['bf_file'];
			$filepath = G5_DATA_PATH.'/file/'.$bo_table;
			$alt = get_text($row['bf_content']);
		}
	}

    if(!$filename)
        return false;

    $tname = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);

    if($tname) {
        if($edt) {
            $src = G5_URL.str_replace($filename, $tname, $data_path);
        } else {
            $src = G5_DATA_URL.'/file/'.$bo_table.'/'.$tname;
        }
    } else {
        return false;
    }

    $thumb = array("src"=>$src, "alt"=>$alt);

    return $thumb;
}

function get_view_thumbnail2($contents, $thumb_width=0)
{
    global $board, $config;

    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];

    // $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

    for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = $m[1];
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = $m[1];
        preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = $m[1];
        preg_match("/height:\s*(\d+)px/", $style, $m);
        $height = $m[1];
        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = get_text($m[1]);

        // 이미지 path 구함
        $p = parse_url($src);
        if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
            $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
        else
            $data_path = $p['path'];

        $srcfile = G5_PATH.$data_path;

        if(is_file($srcfile)) {
            $size = @getimagesize($srcfile);
            if(empty($size))
                continue;

            // jpg 이면 exif 체크
            if($size[2] == 2 && function_exists('exif_read_data')) {
                $degree = 0;
                $exif = @exif_read_data($srcfile);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }
            }

            // 원본 width가 thumb_width보다 작다면
            if($size[0] <= $thumb_width)
                continue;

            // Animated GIF 체크
            $is_animated = false;
            if($size[2] == 1) {
                $is_animated = is_animated_gif($srcfile);
            }

            // 썸네일 높이
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            $filename = basename($srcfile);
            $filepath = dirname($srcfile);

            // 썸네일 생성
            if(!$is_animated)
                $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
            else
                $thumb_file = $filename;

            if(!$thumb_file)
                continue;

            if ($width) {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'"/>';
            } else {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'"/>';
            }
/*
            // $img_tag에 editor 경로가 있으면 원본보기 링크 추가
            $img_tag = $matches[0][$i];
            if(strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                $imgurl = str_replace(G5_URL, "", $src);
                $thumb_tag = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode($imgurl).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
            }
*/
            $contents = str_replace($img_tag, $thumb_tag, $contents);
        }
    }

    return $contents;
}


//사원비중 정보를 얻는다.
function get_member_ratio($mk_id, $fields='*')
{
    global $g5;

    return sql_fetch(" select $fields from g5_member_ratio where mk_id = TRIM('$mk_id') ");
}

// 사원비중 삭제
function member_ratio_delete($mk_id)
{
    global $config;
    global $g5;

    $sql = " select * from g5_member_ratio where mk_id = '".$mk_id."' ";
    $mb = sql_fetch($sql);

    // 이미 삭제된 장비 제외
    if($mb['md_delyn'] == 'Y'){
        return;
	}

    // 소프트웨어 자료는 상태값을 삭제로 전환 후 이력 보관 
    $sql = " update g5_member_ratio set md_delyn = 'Y', md_expirday = '".date('Y-m-d', G5_SERVER_TIME)."', md_content = '".date('Y-m-d', G5_SERVER_TIME)." 삭제함\n{$mb['md_content']}' where mk_id = '{$mk_id}' ";
    sql_query($sql);

}

//사원비중 랜덤 추출
function get_member_rand($fields='*')
{
    global $g5;
    return sql_fetch(" select $fields from g5_member_ratio where md_delyn = 'N' AND md_ratio != '' AND date_format(md_s_ratioday, '%Y-%m-%d') <= '".G5_TIME_YMD."' AND date_format(md_e_ratioday, '%Y-%m-%d') >= '".G5_TIME_YMD."' order by rand() limit 1 ");
}


// 게시판 정보를 얻는다.
function get_bbs_maketer($bo_table,$utm_member, $fields='*')
{
    global $g5;
	$write_table = 'g5_write_'.$bo_table;

    return sql_fetch(" select $fields from {$write_table} where wr_1 = TRIM('$utm_member') ");//정상사원만
}

// 게시판 정보를 얻는다.
function get_bbs_view($bo_table,$wr_id, $fields='*')
{
    global $g5;
	$write_table = 'g5_write_'.$bo_table;

    return sql_fetch(" select $fields from {$write_table} where wr_id = TRIM('$wr_id') ");//정상사원만
}

// 게시판 정보를 얻는다.
function get_youtube_view($bo_table,$wr_id, $fields='*')
{
    global $g5;
	$write_table = 'g5_write_'.$bo_table;

    return sql_fetch(" select $fields from {$write_table} where wr_id = TRIM('$wr_id') ");
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//마케터 개인화
///////////////////////////////////////////////////////////////////////////////////////////////////
// 게시판의 노출비노출을 , 로 구분하여 업데이트 한다.
function board_visible($visibleData, $visible_val, $visible_checked)
{
    $notice_array = explode(",", trim($visibleData));

    if($visible_checked == 'N' && in_array($visible_val, $notice_array))
        return $visibleData;

    $notice_array = array_merge(array($visible_val), $notice_array);
    $notice_array = array_unique($notice_array);
    foreach ($notice_array as $key=>$value) {
        if (!trim($value))
            unset($notice_array[$key]);
    }
    if ($visible_checked == 'Y') {
        foreach ($notice_array as $key=>$value) {
            if ($value == $visible_val)
                unset($notice_array[$key]);
        }
    }
    return implode(",", $notice_array);
}

// 공통자료 비노출 찾아서 제외하기 위한 함수
function get_not_wrid($bo_table, $utm_member)
{
    global $g5;
	$write_table = 'g5_write_'.$bo_table;

	//마케터가 비노출 처리한 정보 가져오기
	$sql = " SELECT wr_20 FROM {$write_table} where wr_20 like '%{$utm_member}%' ";
	//echo $sql;
	$result = sql_query($sql);

	$arr_visible = array();
	while ($row = sql_fetch_array($result)) {
		$visible_array = explode(",", trim($row['wr_20']));
		$arr_visible = array_merge($arr_visible, $visible_array);
	}
	$arr_visible = array_unique($arr_visible);


	//마케터가 비노출 처리한 정보 중에서 해당 마케터가 비노출한 정보 가져오기
	$visible_count = count($arr_visible);
	$arr_wr_id = array();
	for ($k=0; $k<$visible_count; $k++) {
		// $arr_visible 에 utm_member(해당 마케터)가 포함되어 있지 않은 경우
		if (strpos(trim($arr_visible[$k]),$utm_member) === false){	
			continue;
		}

		$wr_array = explode('|', $arr_visible[$k]);
		$arr_wr_id[] = $wr_array[1];				//게시판 wr_id 만 배열로 묶는다.
	}
	$arr_wr_id = array_unique($arr_wr_id);


	// DB의 Not IN 안에 넣을 수 있게 wr_id를 문자열 처리
	$grp_wr_id = "";
	for($i=0;$i<count($arr_wr_id);$i++){ 
		if($arr_wr_id[$i]){
			$grp_wr_id = $grp_wr_id.$arr_wr_id[$i].",";
		}
	}
	$grp_wr_id = substr($grp_wr_id, 0, -1);

	return $grp_wr_id;
}

// 게시판 정보를 얻는다.
function get_video_info($bo_table, $utm_member, $option="", $fields='*')
{
    global $g5;
	
	$write_table = 'g5_write_'.$bo_table;
	$mk_sql_search = " ( mb_id = '{$utm_member}' OR mb_id = 'ampm' )";
	$mk_where = '';
	$mk_where = " and ".$mk_sql_search;
	if($option) {
		$mk_where.= " and ca_name = '{$option}' ";
	}
	
    return sql_fetch(" select $fields from {$write_table} where 1 {$mk_where} ");
}


//사원 디테일 정보를 얻는다.
function get_marketer_detail($mb_id, $fields='*')
{
    global $g5;

    return sql_fetch(" select $fields from g5_marketer_detail where mb_id = TRIM('$mb_id') ");
}


// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging_marketer($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    //$url = preg_replace('#/page=[0-9]*#', '', $url) . '/page=';

	$str = '';
    if ($cur_page > 1) {
		$url = preg_replace('#/page=[0-9]*#', '/page=1', $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_start">처음</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) {
		$url = preg_replace('#/page=[0-9]*#', '/page='.($start_page-1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_prev">이전</a>'.PHP_EOL;
	}
    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k){
				$url = preg_replace('#/page=[0-9]*#', '/page='.$k, $url);

                $str .= '<a href="'.$url.$add.'" class="pg_page">'.$k.'</a>'.PHP_EOL;
            }else
                $str .= '<strong class="pg_current">'.$k.'</strong>'.PHP_EOL;
        }

	}

    if ($total_page > $end_page) {
		$url = preg_replace('#/page=[0-9]*#', '/page='.($end_page+1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_next">다음</a>'.PHP_EOL;
	}
    if ($cur_page < $total_page) {
		$url = preg_replace('#/page=[0-9]*#', '/page='.$total_page, $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
    else
        return "";
}

function get_paging1($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    //$url = preg_replace('#/mypage=[0-9]*#', '', $url) . '/mypage=';

	$str = '';
    if ($cur_page > 1) {
		$url = preg_replace('#/mypage=[0-9]*#', '/mypage=1', $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_start">처음</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) {
		$url = preg_replace('#/mypage=[0-9]*#', '/mypage='.($start_page-1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_prev">이전</a>'.PHP_EOL;
	}
    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k){
				$url = preg_replace('#/mypage=[0-9]*#', '/mypage='.$k, $url);

                $str .= '<a href="'.$url.$add.'" class="pg_page">'.$k.'</a>'.PHP_EOL;
            }else
                $str .= '<strong class="pg_current">'.$k.'</strong>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) {
		$url = preg_replace('#/mypage=[0-9]*#', '/mypage='.($end_page+1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_next">다음</a>'.PHP_EOL;
	}
    if ($cur_page < $total_page) {
		$url = preg_replace('#/mypage=[0-9]*#', '/mypage='.$total_page, $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
    else
        return "";
}
// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging2($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    //$url = preg_replace('#/yopage=[0-9]*#', '', $url) . '/yopage=';

	$str = '';
    if ($cur_page > 1) {
		$url = preg_replace('#/yopage=[0-9]*#', '/yopage=1', $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_start">처음</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) {
		$url = preg_replace('#/yopage=[0-9]*#', '/yopage='.($start_page-1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_prev">이전</a>'.PHP_EOL;
	}
    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k){
				$url = preg_replace('#/yopage=[0-9]*#', '/yopage='.$k, $url);

                $str .= '<a href="'.$url.$add.'" class="pg_page">'.$k.'</a>'.PHP_EOL;
            }else
                $str .= '<strong class="pg_current">'.$k.'</strong>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) {
		$url = preg_replace('#/yopage=[0-9]*#', '/yopage='.($end_page+1), $url);
		$str .= '<a href="'.$url.$add.'" class="pg_page pg_next">다음</a>'.PHP_EOL;
	}
    if ($cur_page < $total_page) {
		$url = preg_replace('#/yopage=[0-9]*#', '/yopage='.$total_page, $url);
        $str .= '<a href="'.$url.$add.'" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
    else
        return "";
}


//마케터이력 토탈 수
function get_record_counter($mb_id, $tablename, $bo_table='', $fd='', $td='')
{
    global $g5;

	$sql = " select IFNULL(count(*), 0) as cnt from {$tablename} ";
	$sql.= " where mb_id = TRIM('$mb_id') ";

	if($tablename == 'g5_mklogin_log'){
		$field = 'loc_datetime';
	}else if($tablename == 'g5_marketer_permute_log'){
		$field = 'per_date';
	}else if($tablename == 'g5_marketer_bbs_history'){
		$field = 'hs_date';
		$sql.= " and bo_table = '{$bo_table}' ";
	}
	
	if($fd && $td){
		$between = " and {$field} between '".$fd." 00:00:00' and '".$td." 23:59:59'  ";
	}
	$sql = $sql.$between;

	$row = sql_fetch($sql);

	return $row['cnt'];
}



// 메세지 출력후 부모페이지 이동
function page_reload($msg, $url='', $error=true)
{
    global $g5;
	echo "<script type='text/javascript'>";
	echo "window.alert('" . $msg . "');";
	echo "window.opener.document.location.replace('".$url."');";
	echo "window.close();";
	echo "</script>";
    exit;
}

// 경고메세지 출력후 페이지 이동
function move_page($url, $error=true)
{
    global $g5;

    $header = '';
    if (isset($g5['title'])) {
        $header = $g5['title'];
    }

	echo "<script type='text/javascript'>";
	echo "location.href='".G5_URL.$url."'";
	echo "</script>";
    exit;
}

function codeToName2($const_codeName, $matching_codeValue){
	if(empty($const_codeName)) 			exit;
	if(empty($matching_codeValue)) 		exit;

	$str = "";
	
	if(!empty($const_codeName)){
		foreach($const_codeName as $key=>$value){
			if(trim($key) == trim($matching_codeValue)){
				$str = trim($value);
			}
		}
	}
	
	return $str;
}

/////////////////////////////////////////////////////////////////////////////////
// 관리자 수정
/////////////////////////////////////////////////////////////////////////////////
//메뉴권한 - 메뉴에 구성된 ID 정보 추출
function get_menu_auth($au_menu, $fields='*'){
    global $g5;

	$sql = " select $fields from {$g5['auth_table']} where au_menu = '{$au_menu}' ";
	//echo $sql; exit;
	return sql_fetch($sql);

}


// 로그인 후 로그인 박스 정보 추출
function get_memberLoginInfo($mb_id){
	global $g5, $member, $code_team;
	
	$mbInfo = array();
	$mbInfo['mb_id'] = $mb_id;

	//마케터여부 
	$mk = get_marketer($mb_id);

	if($mk['mb_id']){	//인트라넷 사원정보 
		$mbInfo['ampmkey'] = 'Y';
		$mbInfo['mb_id'] = $mk['mb_id'];
		$mbInfo['name'] = $mk['mb_name'];
		$mbInfo['nick'] = $mk['mb_name']." AE";
		$mbInfo['mb_team_text'] = ($mk)?codeToName($code_team, get_text($mk['mb_team']))." 팀":"";

		$mb_dir = substr($mk['mb_id'],0,2);
		$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';
		if (file_exists($mk_file)) {
			$mbInfo['mk_url'] = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';
			$mbInfo['mb_images'] = '<img src="'.$mbInfo['mk_url'].'" alt="'.$mk['mb_name'].' AE" width="170">';
		}else{
			//없으면 인트라넷 사진
			$mbInfo['mk_url'] = G5_INTRANET_URL.'/data/member_image/'.$mk['mb_id'];
			
			if($mk['mb_id'] == 'manager' || $mk['mb_id'] == 'cdc'){
				$mbInfo['mk_url'] = G5_INTRANET_URL.'/img/no_profile.gif';
			}
			$mbInfo['mb_images'] = '<img src="'.$mbInfo['mk_url'].'" alt="'.$mk['mb_name'].' AE" width="170">';
		}

		/////////////////////////////////////////////////////////////////////////
		//마케터소개 테이블 정보 추출
		/////////////////////////////////////////////////////////////////////////
		$mkt = get_marketer_detail($mb_id);
		$mbInfo['mb_slogan'] = get_text($mkt['mb_slogan']);
	
	}else{
		$mk = get_member($mb_id);

		$mbInfo['ampmkey'] = '';
		$mbInfo['mb_id'] = $mk['mb_id'];
		$mbInfo['nick'] = $mk['mb_nick'];
		$mbInfo['mb_team_text'] = '';
		$mbInfo['mb_images'] = get_member_profile_img($mk['mb_id']);
		$mbInfo['mk_url'] = '';
		$mbInfo['mb_slogan'] = cut_str(strip_tags($mk['mb_profile']),30);
	}

	return $mbInfo;
}


// 로그인 후 게시판 조회 화면 네임카드 정보 추출
function get_viewNamecardInfo($bo_table, $wr_id){
	global $g5, $code_team;
	
	$mbInfo = array();

	$write_table = 'g5_write_'.$bo_table;
	$mb_team_text = '';

    $sql = " select * from {$write_table} where wr_id = '".$wr_id."' ";
    $bbs = sql_fetch($sql);

	if($bbs['wr_ampm_user'] == 'Y'){	//인트라넷 사원정보 
		//게시물 담당자 정보 추출
		$mk = get_marketer($bbs['wr_17']);

		$mbInfo['mb_id'] = $mk['mb_id'];
		$mbInfo['name'] = $mk['mb_name'];
		$mbInfo['nick'] = $mk['mb_name']." AE";
		$mbInfo['mb_team_text'] = ($mk)?codeToName($code_team, get_text($mk['mb_team']))." 팀":"";

		$mbInfo['mb_tel'] = '02-6049-'.$mk['mb_tel'];
		$mbInfo['mb_email'] = $mk['mb_email'];

		$mb_dir = substr($mk['mb_id'],0,2);
		$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';
		if (file_exists($mk_file)) {
			$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';
			$mbInfo['mb_images'] = '<img src="'.$mk_url.'" alt="'.$mk['mb_name'].' AE" width="170">';
		}else{
			//없으면 인트라넷 사진
			$mk_url = G5_INTRANET_URL.'/data/member_image/'.$mk['mb_id'];
			
			if($mk['mb_id'] == 'manager' || $mk['mb_id'] == 'cdc'){
				$mk_url = G5_INTRANET_URL.'/img/no_profile.gif';
			}
			$mbInfo['mb_images'] = '<img src="'.$mk_url.'" alt="'.$mk['mb_name'].' AE" width="170">';
		}

		/////////////////////////////////////////////////////////////////////////
		//마케터소개 테이블 정보 추출
		/////////////////////////////////////////////////////////////////////////
		$mkt = get_marketer_detail($mk['mb_id']);
		$mbInfo['mb_slogan'] = get_text($mkt['mb_slogan']);
	
	}else{
		$mk = get_member($bbs['wr_17']);

		$mbInfo['mb_id'] = $mk['mb_id'];
		$mbInfo['nick'] = $mk['mb_nick'];
		$mbInfo['mb_team_text'] = '';
		$mbInfo['mb_images'] = get_member_profile_img($mk['mb_id']);
		$mbInfo['mb_slogan'] = cut_str(strip_tags($mk['mb_profile']),30);

		$mbInfo['mb_tel'] = '02-6049-'.$mk['mb_tel'];
		$mbInfo['mb_email'] = $mk['mb_email'];

	}

    return $mbInfo;
}

function get_record_alarm($bo_table, $mb_id){
	global $g5;

	$write_table = $g5['write_prefix'].$bo_table;

	$sql = " select IFNULL(count(*), 0) as cnt from $write_table where wr_is_comment = 0 and wr_11 = '{$mb_id}' and wr_16 = 'N' ";
	
	$row = sql_fetch($sql);

	return $row['cnt'];
}

// 즐겨찾기 추가삭제를 , 로 구분하여 업데이트 한다.
function go_processFavo($orgData, $marketer, $mode)
{
    $marketer_array = explode(",", trim($orgData));

    if($mode == 'sub' && in_array($marketer, $marketer_array))
        return $orgData;

    $marketer_array = array_merge(array($marketer), $marketer_array);
    $marketer_array = array_unique($marketer_array);
    foreach ($marketer_array as $key=>$value) {
        if (!trim($value))
            unset($marketer_array[$key]);
    }
    if ($mode == 'add') {
        foreach ($marketer_array as $key=>$value) {
            if ($value == $marketer)
                unset($marketer_array[$key]);
        }
    }
    return implode(",", $marketer_array);
}

function get_favoMarketer_info($mb_id){
	global $g5;

	$sql = " select * from g5_favo_info where mb_id = TRIM('$mb_id') ";
	
	return sql_fetch($sql);

}

function get_favoMarketer($mb_id, $marketer){
	global $g5;

	$sql = " select IFNULL(count(*), 0) as cnt from g5_favo_info where mb_id = TRIM('$mb_id') and fa_marketer like '%{$marketer}%' ";
	
	$row = sql_fetch($sql);

	return $row['cnt'];
}
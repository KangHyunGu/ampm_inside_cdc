<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$g5['title'] = "질문답변 상세보기";
?>
<?php
//마케터 고유코드 없는 경우 마케터 리스트로 리다이렉트
include(G5_MARKETER_PATH.'/inc/_utm_member.php');
?>

<?php
////////////////////////////////////////////////////////////////////
//마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
include(G5_MARKETER_PATH.'/inc/_marketer_info.php');
?>

<?php
$bo_table = 'qna';
$write_table = 'g5_write_'.$bo_table;
$list_link = "/ae-".$utm_member."/qna/";
$mk_sql_search = " (wr_11 = '{$utm_member}' OR wr_11 = '') ";
$mk_where = " and ".$mk_sql_search;

// 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
$ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name))
{
	sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

	// 자신의 글이면 통과
	if ($write['mb_id'] && $write['mb_id'] == $member['mb_id']) {
		;
	} else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
		// 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
		;
	} else {
		// 글읽기 포인트가 설정되어 있다면
		if ($config['cf_use_point'] && $board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
			alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글읽기('.number_format($board['bo_read_point']).')가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.');

		insert_point($member['mb_id'], $board['bo_read_point'], "{$board['bo_subject']} {$wr_id} 글읽기", $bo_table, $wr_id, '읽기');
	}

	set_session($ss_name, TRUE);
}

$write = sql_fetch(" select * from $write_table where wr_id = '$wr_id' ");


$subject_len=40;

$view = get_bbs_view($bo_table, $wr_id);

if ($subject_len)
	$view['subject'] = conv_subject($view['wr_subject'], $subject_len, '…');
else
	$view['subject'] = conv_subject($view['wr_subject'], $board['bo_subject_len'], '…');

$html = 0;
if (strstr($view['wr_option'], 'html1'))
	$html = 1;
else if (strstr($view['wr_option'], 'html2'))
	$html = 2;

$view['content'] = conv_content($view['wr_content'], $html);


// 링크
for ($i=1; $i<=G5_LINK_COUNT; $i++) {
	$view['link'][$i] = set_http(get_text($view["wr_link{$i}"]));
	$view['link_href'][$i] = G5_BBS_URL.'/link.php?bo_table='.$bo_table.'&amp;wr_id='.$view['wr_id'].'&amp;wr_1='.$view['wr_1'].'&amp;no='.$i.$qstr;
	$view['link_hit'][$i] = (int)$view["wr_link{$i}_hit"];
}

// 가변 파일
if (($view['wr_file']) /* view 인 경우 */) {
	$view['file'] = get_file($bo_table, $view['wr_id']);
} else {
	$view['file']['count'] = $view['wr_file'];
}

if ($view['file']['count'])
	$view['icon_file'] = '<img src="'.G5_MARKETER_URL.'/inc/img/icon_file.gif" alt="첨부파일">';


$sql_search = "";
if ($sql_search)
	$sql_search = " and " . $sql_search;

// 윗글을 얻음
$sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply < '{$write['wr_reply']}' {$sql_search} {$mk_where} order by wr_num desc, wr_reply desc limit 1 ";
$prev = sql_fetch($sql);
// 위의 쿼리문으로 값을 얻지 못했다면
if (!$prev['wr_id'])     {
	$sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num < '{$write['wr_num']}' {$sql_search} {$mk_where} order by wr_num desc, wr_reply desc limit 1 ";
	$prev = sql_fetch($sql);
}

// 아래글을 얻음
$sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num = '{$write['wr_num']}' and wr_reply > '{$write['wr_reply']}' {$sql_search} {$mk_where} order by wr_num, wr_reply limit 1 ";
$next = sql_fetch($sql);
// 위의 쿼리문으로 값을 얻지 못했다면
if (!$next['wr_id']) {
	$sql = " select wr_id, wr_subject, wr_datetime from {$write_table} where wr_is_comment = 0 and wr_num > '{$write['wr_num']}' {$sql_search} {$mk_where} order by wr_num, wr_reply limit 1 ";
	$next = sql_fetch($sql);
}

// 이전글 링크
$prev_href = '';
if (isset($prev['wr_id']) && $prev['wr_id']) {
    $prev_wr_subject = get_text(cut_str($prev['wr_subject'], 255));
    $prev_wr_datetime = date("Y.m.d", strtotime($prev['wr_datetime']));
	
	if($team_code){
		$prev_href = "/ae-".$utm_member."/qna/".$prev['wr_id']."&team_code=".$team_code;
	}else{
		$prev_href = "/ae-".$utm_member."/qna/".$prev['wr_id'];
	}
}

// 다음글 링크
$next_href = '';
if (isset($next['wr_id']) && $next['wr_id']) {
    $next_wr_subject = get_text(cut_str($next['wr_subject'], 255));
    $next_wr_datetime = date("Y.m.d", strtotime($next['wr_datetime']));
	
	if($team_code){
		$next_href = "/ae-".$utm_member."/qna/".$next['wr_id']."&team_code=".$team_code;
	}else{
		$next_href = "/ae-".$utm_member."/qna/".$next['wr_id'];
	}
}


// 수정, 삭제 링크
$update_href = $delete_href = '';
// 로그인중이고 자신의 글이라면 또는 관리자라면 비밀번호를 묻지 않고 바로 수정, 삭제 가능

///////////////////////////////////////////////////////////////////
//AMPM 사원도 관리권한이 있어 is_admin 구체적 명시 - feeris
//담당자변경으로 지정된 경우도 수정권한 부여
///////////////////////////////////////////////////////////////////
if (($member['mb_id'] && ($member['mb_id'] === $write['mb_id'] || $member['mb_id'] === $write['wr_17'])) || ($is_admin =='super' || $is_admin =='manager')) {
    $update_href = short_url_clean(G5_MARKETER_BBS_URL.'/write.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr);
    set_session('ss_delete_token', $token = uniqid(time()));
    $delete_href = G5_MARKETER_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
}
else if (!$write['mb_id']) { // 회원이 쓴 글이 아니라면
    $update_href = G5_MARKETER_BBS_URL.'/password.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;utm_member='.$utm_member.'&amp;page='.$page.$qstr;
    $delete_href = G5_MARKETER_BBS_URL.'/password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;utm_member='.$utm_member.'&amp;page='.$page.$qstr;
}


//print_r2($view);

//$wr_id 값 없는 경우
if(!$view){
	move_page($list_link);
}
?>

<?php
$g5['board_title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']);

$g5['title'] = $mb['mb_name']."AE - ";
$g5['title'].= strip_tags(conv_subject($view['wr_subject'], 255))." > ".$g5['board_title'];


include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_header.php');
?>


<!-- S: 컨텐츠 -->

<section id="content" class="sub5">
    <div class="wrap">
        <div class="qna-wrap">
            <div class="view-title">
                <div class="view-info">
                    <!-- 카테고리 -->
                    <span class="vw_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span>
                    <span class="seleted"><?=($view['wr_11'])?'지정':'전체'?></span>
                    <div class="inner">
                        <p><?php echo date("Y.m.d", strtotime($view['wr_datetime'])) ?> <!--게시글 작성 날짜 --></p>
                        <p>
                            <i class="fa-solid fa-eye"></i>
                            <?php echo number_format($view['wr_hit']) ?> <!--조회수 -->
                        </p>
                    </div>
                </div>
                <!-- 게시글 제목 -->
                <h2><?=$view['subject']?></h2>
                <p class="sv_use"><?=$view['wr_name']?> <!--작성자 --></p>

            </div>

            <div class="view-text-area">
                <?php
                    if ($view['file']['count']) {
                        $cnt = 0;
                        for ($i=0; $i<count($view['file']); $i++) {
                            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                                $cnt++;
                        }
                    }
                    
                    if($cnt) { 
                        // 가변 파일
                        for ($i=0; $i<count($view['file']); $i++) {
                            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                                $view['file'][$i]['href'] = G5_MARKETER_URL."/inc/file_download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$i";
                ?>
                    <div class="download">
                        <div class="file-tit">첨부파일</div>
                        <div class="file">
                            <a href="<?php echo $view['file'][$i]['href'];  ?>">
                                <div class="file-text">
                                    <!--<span>첨부파일</span>-->
                                    <p class="view_file_download">
                                    <!--
                                        <img src="<?php echo G5_MARKETER_URL?>/inc/img/icon_file.gif" alt="첨부">
                                        -->
                                        <?php echo $view['file'][$i]['source'] ?>
                                        <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                                    </p>
                                </div>
                                <div class="file-img">
                                    <i class="fas fa-file-download"></i>
                                </div>
                            </a>
                            <!--
                            <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                            <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                            -->
                        </div>
                    </div>
                <?php 
                            }
                        }
                    } 
                ?>
                <div class="view-text">
                    <!--게시글 본문 -->
                    <?php echo get_view_thumbnail($view['content']); ?>
                </div>

                <div id="commentWrap">
                <?php
                // 코멘트 입출력
                include_once('./qna_view_comment.php');
                ?>
                </div>
            
            </div>

            <!-- 이전글, 다음글 -->
            <div class="view-nav">
                <ul class="bo_v_nb">
                    <li class="btn">
                        <?php
                            if($prev_href){
                        ?>

                        <a class="btn_prv" href="<?php echo $prev_href ?>">
                            <i class="fa-solid fa-caret-left"></i>
                            이전글
                        </a>
                        <?php
                        }

                            if($next_href){
                        ?>
                        <a class="btn_next" href="<?php echo $next_href ?>">
                            다음글
                            <i class="fa-solid fa-caret-right"></i>
                        </a>
                        <?php
                            }
                        ?>
                    </li>
                    <li class="view-list">
                        <a href="/ae-<?=$utm_member?>/qna/<?php if($team_code){ echo "&team_code=".$team_code; }?>">목록</a>
                    </li>
                </ul>
            </div>
                
        </div>
    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
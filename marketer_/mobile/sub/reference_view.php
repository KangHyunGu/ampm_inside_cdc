<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

$g5['title'] = "REFERENCE 상세보기";
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
$bo_table = 'reference';
$write_table = 'g5_write_'.$bo_table;
$list_link = "/ae-".$utm_member."/reference/";
$mk_sql_search = " ( mb_id = '{$utm_member}' OR mb_id = 'ampm' )";
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

$file = get_file($bo_table, $view['wr_id']);

$img_link = $file[0]['path'].'/'.$file[0]['file'];
if($file[0]['file']){
    $img_content = '<img src="'.$img_link.'" alt="'.$list[$i]['wr_subject'].'" title="'.$list[$i]['wr_subject'].'" style="border:1px solid #8aff00">';
}else{
    $img_content = '<img src="'.G5_MARKETER_URL.'/images/no_images.jpg" alt="'.$list[$i]['wr_subject'].'" title="'.$list[$i]['wr_subject'].'" style="border:1px solid #8aff00">';
}

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
		$prev_href = "/ae-".$utm_member."/reference/".$prev['wr_id']."&team_code=".$team_code;
	}else{
		$prev_href = "/ae-".$utm_member."/reference/".$prev['wr_id'];
	}
}

// 다음글 링크
$next_href = '';
if (isset($next['wr_id']) && $next['wr_id']) {
    $next_wr_subject = get_text(cut_str($next['wr_subject'], 255));
    $next_wr_datetime = date("Y.m.d", strtotime($next['wr_datetime']));
	if($team_code){
		$next_href = "/ae-".$utm_member."/reference/".$next['wr_id']."&team_code=".$team_code;
	}else{
		$next_href = "/ae-".$utm_member."/reference/".$next['wr_id'];
	}
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
<section id="sub-common">
    <div class="wrap">  
        <div class="common-info">
            <div class="member-title">
                <h3 class="main-color">Reference</h3>
                <h2><?php echo ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO"; ?></h2>
            </div>
            <div class="member-info">
                <!-- 마케터 이미지 -->
                <div class="mkt-img">
                    <?=$mb_images?>
                </div>

                <ul>
                    <li>
                        <span><i class="fas fa-mobile-alt"></i></span>
                        <p><?=$mb['mb_tel'] ?></p>
                    </li>

                    <?php if($mb['mb_kakao']){ ?>
                    <li>
                        <span><i class="fab fa-kaggle"></i></span>
                        <p><?=$mb['mb_kakao'] ?></p>
                    </li>
                    <?php } ?>

                    <li>
                        <span><i class="fas fa-envelope"></i></span>
                        <p><?=$mb['mb_email'] ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="reference-view">
    <!-- 타이틀 영역 -->
    <!-- background=첨부이미지 -->
    <div class="title-box" style="background:url(<?=$img_link?>) center center no-repeat; background-size:cover;">
        <div class="title-bg"></div>
    </div>
    
    <div class="content wrap">
        <!-- 래퍼런스 view -->
        <div class="rf-view">
            <div class="rf-box">
                <div class="rf-title">
                    <h1><?=$view['subject']?><span>마케팅 사례</span></h1>
                </div>

                <?php if($view['wr_4']){ ?>
                    <div class="rf-view-title">
                        <div class="view-title">
                            <!-- 홈페이지 URL -->
                            <p>Homepage URL</p>
                            <a href="<?=$view['wr_4']?>" target="_blank">
                                <?=$view['wr_4']?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            
            <div class="rf-con">
                <table>
                    <!-- 마케팅 KPI -->
                    <?php if($view['wr_1']){ ?>
                    <tr>
                        <th>마케팅 KPI</th>
                        <td><?=$view['wr_1']?></td>
                    </tr>
                    <?php } ?>
                    <!-- 집행매체 -->
                    <?php if($view['wr_2']){ ?>
                    <tr>
                        <th>집행매체</th>
                        <td><?=$view['wr_2']?></td>
                    </tr>
                    <?php } ?>
                    <!-- 집행성과 -->
                    <?php if($view['wr_3']){ ?>
                    <tr>
                        <th>집행성과</th>
                        <td><?=$view['wr_3']?></td>
                    </tr>
                    <?php } ?>
                    <!-- 집행내용 -->
                    <?php if($view['content']){ ?>
                    <tr>
                        <th>집행내용</th>
                        <td class="view-text"><?php echo get_view_thumbnail($view['content']); ?></td>
                    </tr>
                    <?php } ?>
                </table>

                <div class="board">
                    <!-- 이전글, 다음글 -->
                    <div class="view-nav">
                        <ul class="bo_v_nb">
                            <?php
                                if($prev_href){
                            ?>
                            <li class="btn_prv">
                                <span class="nb_tit">이전글 <img src="<?=G5_MARKETER_URL ?>/images/arrowup.png"></span>
                                <a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject ?></a>
                            </li>
                            <?php
                                }

                                if($next_href){
                            ?>
                            <li class="btn_next">
                                <span class="nb_tit">다음글 <img src="<?=G5_MARKETER_URL ?>/images/arrowdown.png"></span>
                                <a href="<?php echo $next_href ?>"><?php echo $next_wr_subject ?></a>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                    
                    <div class="view-list">
                        <a href="/ae-<?=$utm_member?>/reference/<?php if($team_code){ echo "&team_code=".$team_code; }?>">목록 더보기</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
            
</section>
<!-- E: 컨텐츠 -->

<!-- footer -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
<?php
//풋터
include_once('./_tail.php');
?>
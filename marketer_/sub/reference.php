<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/reference.php');
    return;
}

$g5['title'] = "REFERENCE 리스트";
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
////////////////////////////////////////////////////////////////////
//Insight 정보 가져오기
////////////////////////////////////////////////////////////////////
$bo_table = 'reference';
$write_table = 'g5_write_'.$bo_table;
$list_link = "/ae-".$utm_member."/reference/";

//$mk_sql_search = " ( mb_id = '{$utm_member}' OR mb_id = 'ampm' )";
$mk_sql_search = " ( wr_17 = '{$utm_member}' OR mb_id = 'ampm' )";

//////////////////////////////////////////////
//공통자료 비노출 찾아서 제외하기
//////////////////////////////////////////////
$not_wr_id = get_not_wrid($bo_table, $utm_member);
if($not_wr_id){
	$mk_sql_search.= " AND wr_id NOT IN( {$not_wr_id} )";
}
//////////////////////////////////////////////

$board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '$bo_table' ");

$sql_search = "";

// 분류 선택 또는 검색어가 있다면
$stx = trim($stx);

//검색인지 아닌지 구분하는 변수 초기화
$is_search_bbs = false;
if ($stx || $stx === '0') {     //검색이면
    $is_search_bbs = true;      //검색구분변수 true 지정

	$sql_search .= " and ";
	$sql_search .= " $sfl like '%$stx%' ";		
}

/////////////////////////////////////////////////////////////////////////
//마케터 개인화 용
/////////////////////////////////////////////////////////////////////////
$mk_where = " and ".$mk_sql_search;
/////////////////////////////////////////////////////////////////////////
$sql = " select count(*) as cnt from {$write_table} WHERE 1 $sql_search {$mk_where} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];


if(G5_IS_MOBILE) {
	$page_rows = $board['bo_mobile_page_rows'];
	$list_page_rows = $board['bo_mobile_page_rows'];
} else {
    $page_rows = $board['bo_page_rows'];
    $list_page_rows = $board['bo_page_rows'];
}

if (!$page) $page = 1;						// 페이지가 없으면 첫 페이지 (1 페이지)

$list = array();
$i = 0;
$notice_count = 0;
$notice_array = array();

// 공지 처리
if (!$is_search_bbs) {
    $arr_notice = explode(',', trim($board['bo_notice']));
    $from_notice_idx = ($page - 1) * $page_rows;
    if($from_notice_idx < 0)
        $from_notice_idx = 0;
    $board_notice_count = count($arr_notice);

    for ($k=0; $k<$board_notice_count; $k++) {
        if (trim($arr_notice[$k]) == '') continue;

		/////////////////////////////////////////////////////////////////////////
		//마케터 개인화 용
		/////////////////////////////////////////////////////////////////////////
		$mk_where = " and ".$mk_sql_search;
		/////////////////////////////////////////////////////////////////////////

        $row = sql_fetch(" select * from {$write_table} where wr_id = '{$arr_notice[$k]}' {$mk_where} ");

        if (!$row['wr_id']) continue;

        $notice_array[] = $row['wr_id'];

        if($k < $from_notice_idx) continue;

        $list[$i] = get_list($row, $board, $board_skin_url, G5_IS_MOBILE ? $board['bo_mobile_subject_len'] : $board['bo_subject_len']);
        
		if($team_code){
			$list[$i]['href'] = "/ae-".$utm_member."/reference/".$row['wr_id']."&team_code=".$team_code;
		}else{
			$list[$i]['href'] = "/ae-".$utm_member."/reference/".$row['wr_id'];
		}

		$list[$i]['icon_new'] = '';
		if ($board['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
			$list[$i]['icon_new'] = '<img src="'.G5_MARKETER_URL.'/inc/img/icon_new.gif" alt="새글">';


		$reply = $list[$i]['wr_reply'];
		$list[$i]['reply'] = strlen($reply)*10;

		$list[$i]['icon_reply'] = '';
		if ($list[$i]['reply'])
			$list[$i]['icon_reply'] = '<img src="'.G5_MARKETER_URL.'/inc/img/icon_reply.gif" style="margin-left:'.$list['reply'].'px;" alt="답변글">';


		$list[$i]['is_notice'] = true;

        $i++;
        $notice_count++;

        if($notice_count >= $list_page_rows)
            break;
    }
}

$total_page  = ceil($total_count / $page_rows);  	// 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; 			// 시작 열을 구함

// 공지글이 있으면 변수에 반영
if(!empty($notice_array)) {
    $from_record -= count($notice_array);

    if($from_record < 0)
        $from_record = 0;

    if($notice_count > 0)
        $page_rows -= $notice_count;

    if($page_rows < 0)
        $page_rows = $list_page_rows;
}


if(!$sst)
    $sst  = "wr_num, wr_reply";

if ($sst) {
    $sql_order = " order by {$sst} {$sod} ";
}

if ($is_search_bbs) {
	/////////////////////////////////////////////////////////////////////////
	//마케터 개인화 용
	/////////////////////////////////////////////////////////////////////////
	$mk_where = " and ".$mk_sql_search;
	/////////////////////////////////////////////////////////////////////////

	$sql = " select distinct wr_parent from {$write_table} where 1 {$sql_search} {$mk_where} {$sql_order} limit {$from_record}, $page_rows ";
} else {
	/////////////////////////////////////////////////////////////////////////
	//마케터 개인화 용
	/////////////////////////////////////////////////////////////////////////
	$mk_where = " and ".$mk_sql_search;
	/////////////////////////////////////////////////////////////////////////

	$sql = " select * from {$write_table} where wr_is_comment = 0 {$mk_where} ";
    if(!empty($notice_array))
        $sql .= " and wr_id not in (".implode(', ', $notice_array).") ";
    $sql .= " {$sql_order} limit {$from_record}, $page_rows ";
}
//echo $sql;

// 페이지의 공지개수가 목록수 보다 작을 때만 실행
if($page_rows > 0) {
    $result = sql_query($sql);

    $k = 0;

    while ($row = sql_fetch_array($result))
    {
        // 검색일 경우 wr_id만 얻었으므로 다시 한행을 얻는다
        if ($is_search_bbs)
            $row = sql_fetch(" select * from {$write_table} where wr_id = '{$row['wr_parent']}' ");

        $list[$i] = get_list($row, $board, $board_skin_url, G5_IS_MOBILE ? $board['bo_mobile_subject_len'] : $board['bo_subject_len']);

		if($team_code){
	        $list[$i]['href'] = "/ae-".$utm_member."/reference/".$row['wr_id']."&team_code=".$team_code;
		}else{
	        $list[$i]['href'] = "/ae-".$utm_member."/reference/".$row['wr_id'];
		}

		$list[$i]['icon_new'] = '';
		if ($board['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
			$list[$i]['icon_new'] = '<img src="'.G5_MARKETER_URL.'/inc/img/icon_new.gif" alt="새글">';


		$reply = $list[$i]['wr_reply'];
		$list[$i]['reply'] = strlen($reply)*10;

		$list[$i]['icon_reply'] = '';
		if ($list[$i]['reply'])
			$list[$i]['icon_reply'] = '<img src="'.G5_MARKETER_URL.'/inc/img/icon_reply.gif" style="margin-left:'.$list['reply'].'px;" alt="답변글">';

		if (strstr($sfl, 'subject')) {
            $list[$i]['subject'] = search_font($stx, $list[$i]['subject']);
        }
        $list[$i]['is_notice'] = false;
        $list_num = $total_count - ($page - 1) * $list_page_rows - $notice_count;
        $list[$i]['num'] = $list_num - $k;

        $i++;
        $k++;
    }
}

if($team_code){
	$list_link = $list_link."page=".$page."&team_code=".$team_code;
}else{
	$list_link = $list_link."page=".$page;
}

$write_pages = get_paging_marketer(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $list_link);
?>

<?php
$g5['board_title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']);

$g5['title'] = $mb['mb_name']."AE - ";
$g5['title'].= strip_tags(conv_subject($row['wr_subject'], 255))." > ".$g5['board_title'];


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


<section id="sub-layout" class="rf-layout">
    <div class="wrap">
        <div class="layout">

            <div class="content2" data-aos="fade-up" data-aos-offset="300" data-aos-easing="ease-in-cubic">
                
                <div class="reference">
                    <div class="table-tit">Reference</div>
                    <div class="table-top">
                        <div class="list-count">
                            총 <span><?php echo number_format($total_count) ?></span>건 / <?php echo $page ?>Page
                        </div>
                        
                        <div class="search">
                            <!-- 게시판 검색 시작 { -->
                            <fieldset id="bo_sch">
                                <legend>게시물 검색</legend>

                                <form name="fsearch" method="post">
                                <label for="sfl" class="sound_only">검색대상</label>
                                <select name="sfl" id="sfl">
                                    <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>업체명</option>
                                    <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                                </select>
                                <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                                <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력하세요">
                                <button type="submit" value="검색" class="sch_btn"><span class="sound_only">검색</span></button>
                                </form>
                            </fieldset>
                            <!-- } 게시판 검색 끝 -->   
                        </div>   
                    </div>
                </div>
                <div class="table-list">
                    <!-- 래퍼런스 목록 -->
                    <ul class="grid">
                        <?php
                        for ($i=0; $i<count($list); $i++) {
                            /*
                            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

                            if($thumb['src']) {
                                $img_content = '<img src="'.$thumb['src'].'"
                                alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'">';
                            } else {
                                $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                            }
                            */
                            $file = get_file($bo_table, $list[$i]['wr_id']);

                            $img_link = $file[0]['path'].'/'.$file[0]['file'];
                            if($file[0]['file']){
                                $img_content = '<img src="'.$img_link.'" alt="'.$list[$i]['wr_subject'].'" title="'.$list[$i]['wr_subject'].'" ';
                            }else{
                                $img_content = '<img src="'.G5_MARKETER_URL.'/images/no_images.jpg" alt="'.$list[$i]['wr_subject'].'" title="'.$list[$i]['wr_subject'].'" ';
                            }
                        ?>
                    
                        <li class="item">
                            <a href="<?php echo $list[$i]['href'] ?>">
                                <div class="rf-img">
                                    <!-- 이미지 -->
                                    <?echo $img_content ?>
                                </div>
                                </div>
                                <div class="rf-title">
                                    <!-- 업체(광고주명) -->
                                    <p><?echo $list[$i]['subject'];?></p>
                                </div>
                            </a>
                        </li>

                        <?php
                            }
                        ?>
                        
                        <?php if (count($list) == 0) { echo '<div class="empty">게시물이 없습니다.</div>'; } ?>
                    </ul>
                    
                    <!-- 페이징 -->
                    <?php echo $write_pages;  ?>
                </div>

            </div>

            <?php
                //마케터 프로필
                include(G5_MARKETER_PATH.'/inc/mkt_profile.php');
            ?>  

        </div>
    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
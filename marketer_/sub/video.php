<?php
include_once('./_common.php');
// 필요한 LIB 불러오기
include_once(G5_MARKETER_PATH.'/inc/gaburi.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/video.php');
    return;
}

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
//영상 정보 가져오기
////////////////////////////////////////////////////////////////////

////////////////////
//상단 노출 영상
////////////////////
$bo_table = 'video';
$write_table = 'g5_write_'.$bo_table;

//$mk_sql_search = " ( mb_id = '{$utm_member}' OR mb_id = 'ampm' )";
$mk_sql_search = " ( wr_17 = '{$utm_member}' )";

//////////////////////////////////////////////
//공통자료 비노출 찾아서 제외하기
//////////////////////////////////////////////
$not_wr_id = get_not_wrid($bo_table, $utm_member);
if($not_wr_id){
	$mk_sql_search.= " AND wr_id NOT IN( {$not_wr_id} )";
}
//////////////////////////////////////////////


//video 게시판에 대표영상 설정 정보 가져오기
$sql = " SELECT bo_notice FROM g5_board WHERE bo_table = '{$bo_table}' ";
$row = sql_fetch($sql);
$arr_notice = explode(',', $row['bo_notice']);
$board_notice_count = count($arr_notice);

$notice_array = array();
for ($k=0; $k<$board_notice_count; $k++) {
	if (trim($arr_notice[$k]) == '') continue;

	$row = sql_fetch(" select * from {$write_table} where wr_id = '{$arr_notice[$k]}' AND {$mk_sql_search} ");
	if (!$row['wr_id']) continue;
	$notice_array[] = $row['wr_id'];
}

///////////////////////////////////////////////////////////////
//$wr_id 없으면 대표영상, 대표영상 설정도 없으면 최근 등록 1개 호출
///////////////////////////////////////////////////////////////
if($wr_id){	//선택한 영상이 있다?
	$sql = " SELECT * FROM {$write_table} WHERE wr_id = TRIM('$wr_id') ";
}else{				//초기 값
	if(count($notice_array) > 0){	// 대표영상(공지글)이 있으면 
		$sql = " SELECT * FROM {$write_table} WHERE wr_id = '{$notice_array[0]}' ";
	}else{
		$sql = " SELECT * FROM {$write_table} WHERE {$mk_sql_search} order by wr_num, wr_reply limit 1 ";
	}
}
//echo $sql;
$result = sql_query($sql);
$row=sql_fetch_array($result);
$youtube_link = $row['wr_5'];

if(preg_match("/youtu/", $youtube_link)) {
	$videoId = get_youtubeid($youtube_link);
	$co_media = "<iframe width='100%' height='400' src='//www.youtube.com/embed/$videoId' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'></iframe>";
	$thumbImg = "<img src='http://img.youtube.com/vi/$videoId/maxresdefault.jpg' />";
} else if(preg_match("/vimeo/", $youtube_link)) {
	$videoId = get_vimeoid($youtube_link);
	$co_media = "<iframe width='100%' height='400' src='//player.vimeo.com/video/$videoId' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
	$thumbImg = "<img src='$thumb_Url'/>";
}


$g5['board_title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']);

$g5['title'] = $mb['mb_name']."AE - ";
$g5['title'].= strip_tags(conv_subject($row['wr_subject'], 255))." > ".$g5['board_title'];



//영상첨부파일
$g5['file_table'] = G5_TABLE_PREFIX.'board_file'; // 게시판 첨부파일 테이블
$sql = " select * from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$row['wr_id']}' order by bf_no desc ";
//echo $sql;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$no = $row['bf_no'];
$file_href = G5_MARKETER_URL."/inc/file_download.php?bo_table=$bo_table&amp;wr_id={$row['wr_id']}&amp;no=$no" . $qstr;
$file_link = $row['bf_link'];
$file_source = addslashes($row['bf_source']);
?>

<?php
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
                <h3 class="main-color">Marketer Video</h3>
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

<section id="sub-layout">
    <div class="wrap">
        <div class="layout">

            <div class="content" data-aos="fade-up" data-aos-offset="300" data-aos-easing="ease-in-cubic">
                <!-- 나의 영상 -->
                <div class="sub-my-video">
                    <!--영상 출력 -->
                    <div class="mv-video">
                        <?=$co_media?>
                    </div>
                    <!--
                    <?php // if($file_source){ ?>
                        <div class="mv-video-list">
                            <div class="mv-boxleft">
                                <div class="mv-title">첨부자료</div>
                            </div>

                            <div class="mv-boxright">
                                <div class="mv-text">
                                    <a href="<?=$file_href?>">
                                        <span><?=$file_source?></span>
                                        <img src="<?=G5_URL?>/images/icon_download.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php // } ?>
                    -->
                </div>

                <div class="sub-video-list">
                    <?php
                        $rows = '2';									// 페이지 내에 노출 수
                        if (!$mypage) $mypage = 1;						// 페이지가 없으면 첫 페이지 (1 페이지)
                        if (!$yopage) $yopage = 1;						// 페이지가 없으면 첫 페이지 (1 페이지)

                        $mk_sql_search = " AND ".$mk_sql_search;
                    ?>

                    <!-- 나의 영상 -->
                    <?php
                        //////////////////////////////////////////////////////////////////////////
                        //나의영상 리스트
                        //////////////////////////////////////////////////////////////////////////
                        
                        $sql_search = "";
                        //$sql_search.= "  AND wr_1 = '나의영상' ";	//나의영상만
                        $sql_search.= "  AND wr_20 = '' ";	//나의영상만

                        if($stx) {
                            $sql_search .= " and ";
                            $sql_search .= " $sfl like '%$stx%' ";		
                        }
                        $sql = " select count(*) as cnt from {$write_table} WHERE 1 $sql_search {$mk_sql_search} ";
                        $row = sql_fetch($sql);
                        $total_my_count = $row['cnt'];

                        $total_my_page  = ceil($total_my_count / $rows);  // 전체 페이지 계산
                        $from_my_record = ($mypage - 1) * $rows;			// 시작 열을 구함

                        $sql = " select * from {$write_table} WHERE 1 {$sql_search} {$mk_sql_search} order by wr_num, wr_reply limit $from_my_record, $rows ";
                        //echo "<br> sql: ".$sql;
                        $result = sql_query($sql);
                        
                        if ($total_my_count > 0) {
                    ?>

                    <div class="list-myvideo video-box">
                        <div class="video-title">마케터 영상</div>
                        <ul>
                            <!--비디오 목록-->
                            <?php
                            $iList = 0;
                            while ($row = sql_fetch_array($result)) {
                                $iNum = $total_my_count - (( $mypage - 1 ) * $rows + $iList );
                                $list = $iList%2;

                                if(preg_match("/youtu/", $row['wr_5'])) {
                                    $videoId = get_youtubeid($row['wr_5']);
                                    $thumbImg = "<img src='http://img.youtube.com/vi/$videoId/0.jpg' />";
                                } else if(preg_match("/vimeo/", $row['wr_5'])) {
                                    $videoId = get_vimeoid($row['wr_5']);
                                    $thumbImg = "<img src='$thumb_Url'/>";
                                }

                                if($team_code){
                                    $youtube_link = "/ae-".$utm_member."/video/".$row['wr_id']."/mypage=".$mypage."/yopage=".$yopage."&team_code=".$team_code;
                                }else{
                                    $youtube_link = "/ae-".$utm_member."/video/".$row['wr_id']."/mypage=".$mypage."/yopage=".$yopage;
                                }
                            ?>
                            <li><a href="<?=G5_MARKETER_URL?><?=$youtube_link?>"><?=$thumbImg?></a></li>
                            <?php
                            }
                            ?>
                            <!--
                            <li><a href="#"><img src="https://img.youtube.com/vi/HeZWMipKNzM/hqdefault.jpg"></a></li>
                            <li><a href="#"><img src="https://img.youtube.com/vi/VkVka0H0eAA/hqdefault.jpg"></a></li>
                            -->
                        </ul>
                        <?php
                            $pagelist = get_paging1($config['cf_write_pages'], $mypage, $total_my_page, $youtube_link,"#sub-video-list");
                            echo $pagelist;
                        ?>
                    </div>
                    <?php } ?>
                    
                    <!-- 추천 영상 -->
                    <?php
                        //////////////////////////////////////////////////////////////////////////
                        //추천영상 리스트
                        //////////////////////////////////////////////////////////////////////////
                        
                        $sql_search = "";
                        //$sql_search.= "  AND wr_1 = '추천영상' ";	//추천영상만
                        $sql_search.= "  AND wr_20 != '' ";	//추천영상만

                        if($stx) {
                            $sql_search .= " and ";
                            $sql_search .= " $sfl like '%$stx%' ";		
                        }
                        $sql = " select count(*) as cnt from {$write_table} WHERE 1 $sql_search {$mk_sql_search} ";
                        $row = sql_fetch($sql);
                        $total_yo_count = $row['cnt'];

                        $total_yo_page  = ceil($total_yo_count / $rows);  // 전체 페이지 계산
                        $from_yo_record = ($yopage - 1) * $rows;			// 시작 열을 구함

                        $sql = " select * from {$write_table} WHERE 1 {$sql_search} {$mk_sql_search} order by wr_num, wr_reply limit $from_yo_record, $rows ";
                        //echo "<br> sql: ".$sql;
                        $result = sql_query($sql);
                        
                        if ($total_yo_count > 0) {
                    ?>

                    <div class="list-revideo video-box">
                        <div class="video-title">추천 영상</div>
                        <ul>
                            <!--비디오 목록-->
                            <?php
                            $iList = 0;
                            while ($row = sql_fetch_array($result)) {
                                $iNum = $total_yo_count - (( $yopage - 1 ) * $rows + $iList );
                                $list = $iList%2;

                                if(preg_match("/youtu/", $row['wr_5'])) {
                                    $videoId = get_youtubeid($row['wr_5']);
                                    $thumbImg = "<img src='http://img.youtube.com/vi/$videoId/0.jpg' />";
                                } else if(preg_match("/vimeo/", $row['wr_5'])) {
                                    $videoId = get_vimeoid($row['wr_5']);
                                    $thumbImg = "<img src='$thumb_Url'/>";
                                }

                                if($team_code){
                                    $youtube_link = "/ae-".$utm_member."/video/".$row['wr_id']."/mypage=".$mypage."/yopage=".$yopage."&team_code=".$team_code;
                                }else{
                                    $youtube_link = "/ae-".$utm_member."/video/".$row['wr_id']."/mypage=".$mypage."/yopage=".$yopage;
                                }
                            ?>
                            <li><a href="<?=G5_MARKETER_URL?><?=$youtube_link?>"><?=$thumbImg?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                            $pagelist = get_paging2($config['cf_write_pages'], $yopage, $total_yo_page, $youtube_link,"#sub-video-list");
                            echo $pagelist;
                        ?>
                    </div>
                    <?php } ?>
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
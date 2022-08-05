
<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
?>

<?php
include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_header.php');
?>

<?php
$bo_table = 'member';
$sql_common = " from {$g5['member_table']} b ";

$sql_search = "";
$sql_pro_search = "";

$sql_search.= " where (1) ";
$sql_search.= "and (b.mb_leave_date = '' or b.mb_level > 1) ";
$sql_search.= "and b.mb_level < 5 ";
$sql_search.= "and b.mb_post in('P1','P2') ";
$sql_search.= "and b.mb_part NOT IN('ACE','ASU','AT1') ";

//프로마케터 추출용
$sql_pro_search.= $sql_search;
$sql_pro_search.= " and mb_8 = '비전구간' ";

//업종선택
$sear_mkcheck = ($mkcheck == 'all')?'':$mkcheck;
if($sear_mkcheck) {
	$sql_search .= " and ";
	$sql_search .= " mb_13 like '%{$sear_mkcheck}%' ";		
}


if($stx) {
	$sql_search .= " and ";
	$sql_search .= " $sfl like '%$stx%' ";		
}


if ($sst) {
    //$sst = "mb_datetime";
    //$sod = "desc";

	$sql_order = " order by {$sst} {$sod} ";
}else{
	//$sql_order = " order by {$sst} {$sod} ";
	$sql_order = " order by rand() ";
}

//한페이지 최대 노출 수
$rows = "15";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch_intra($sql);
$total_count = $row['cnt'];

/*
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} $sql_search order by rand() limit $from_record, $rows ";
//echo "sql: ".$sql;
$result = sql_query_intra($sql);
*/

///////////////////////////////////////////////////////////////////////
// 업종선택 했는데 대상자가 없다.
// 업종선택 전체가 아니다.
// 마케터 직접 검색이 아니다.
// 프로마케터로 지정된 사원이 노출되도록 구성한다.
///////////////////////////////////////////////////////////////////////
if(($total_count < 1) && ($sear_mkcheck != '') && ($stx == '')){
	$sql = " select count(*) as cnt {$sql_common} {$sql_pro_search} {$sql_order} ";
	$row = sql_fetch_intra($sql);
	$total_count = $row['cnt'];

	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함

	//$sql = " select * {$sql_common} {$sql_pro_search} order by rand() limit $from_record, $rows ";
	$sql = " select * {$sql_common} {$sql_pro_search} order by rand() ";
	//echo "sql: ".$sql;
	$result = sql_query_intra($sql);
}else{
	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함

	//$sql = " select * {$sql_common} {$sql_search} order by rand() limit $from_record, $rows ";
	$sql = " select * {$sql_common} {$sql_search} order by rand() ";
	//echo "sql: ".$sql;
	$result = sql_query_intra($sql);
}

 // echo "sql: ".$sql;
?>

<?php
//마케터 고유코드 없는 경우 마케터 리스트로 리다이렉트
//include(G5_MARKETER_PATH.'/inc/_utm_member.php');
?>
<?php
////////////////////////////////////////////////////////////////////
//마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
//include(G5_MARKETER_PATH.'/inc/_marketer_info.php');
?>


<!-- index -->
<section id="section1">
    <div id="mk-main-visual">
        <div class="wrap">
           
            <div class="main-txt">
                <h5 data-aos="fade-up" data-aos-easing="ease-in-cubic">최상의 성과를 만들기 위한 <b>최고의 디지털마케팅 사업</b></h5>
                <h2 data-aos="fade-up" data-aos-easing="ease-in-cubic" data-aos-delay="200">
                    AMPM GLOBAL에서 광고주와의<br>동반성장을 이루어낼
                    검증된 전담 마케터를 추천드립니다.
                </h2>
            </div>

            <div class="main-img">
                <!-- <img class="main-img" src="<?=G5_MARKETER_URL ?>/images/main-img.png" alt="에이엠피엠글로벌 화면"> -->
                <img class="effect img1" src="<?=G5_MARKETER_URL ?>/images/main-effect-img1.png" alt="현직 마케터가 알려주는 효율적 광고 세팅법!">
                <img class="effect img2" src="<?=G5_MARKETER_URL ?>/images/main-effect-img2.png" alt="아직도 타겟팅없이 진행하세요?">
                <img class="effect img3" src="<?=G5_MARKETER_URL ?>/images/main-effect-img3.png" alt="알짜배기만 모아 놓은 10분 마케팅 뉴스!">

                <img class="icon1" src="<?=G5_MARKETER_URL ?>/images/main-icon1.png" alt="네이버쇼핑">
                <img class="icon2" src="<?=G5_MARKETER_URL ?>/images/main-icon2.png" alt="카카오광고">
                <img class="icon3" src="<?=G5_MARKETER_URL ?>/images/main-icon3.png" alt="구글광고">
                <img class="icon4" src="<?=G5_MARKETER_URL ?>/images/main-icon4.png" alt="페이스북">
                <img class="icon5" src="<?=G5_MARKETER_URL ?>/images/main-icon5.png" alt="인스타그램">
            </div>

            <div class="main-link">
                <a href="#section3" class="move">전담마케터 찾기</a>
                <a href="<?=G5_URL?>/sub/sub5-1.php<?=$teamLinkPara?>" target="_blank">마케터가 되고 싶다면?</a>
            </div>

        </div>
    </div>
</section>

<section id="section2">
    <div class="wrap">
            
        <div class="con-title">
            <h2><b>'우리'업종의 최적화 된 마케터, <br></b> 이렇게 선택하세요!</h2>
            <p>광고주의 모든 Needs를 빨아들여 <span class="sub-color">한방에 뇌리를 때리는 광고</span>를 기획합니다.<br>
            핵심을 뚫는 광고를 실현하여, 목표를 달성할 수 있는 최적의 마케터와 함께 하세요.</p>
        </div>
        
        <div class="con-box">
            <ul>
                <li data-aos="fade-up" data-aos-offset="150" data-aos-easing="ease-in-cubic">
                    <div class="box-img">
                        <img src="<?=G5_MARKETER_URL ?>/images/con2-img1.jpg" alt="업종별 최고의 마케터 선택">
                    </div>
                    <div class="box-title">
                        <span>STEP 1</span>
                        <h2>업종별 최고의<br>마케터 선택</h2>
                        <p>
                            에이엠피엠글로벌에는<br>
                            클라이언트의 성공을 함께할<br>
                            다양한 ‘업종 전문가’들이 모였습니다.
                        </p>
                    </div>
                </li>
                <li data-aos="fade-up" data-aos-offset="150" data-aos-easing="ease-in-cubic">
                    <div class="box-img">
                        <img src="<?=G5_MARKETER_URL ?>/images/con2-img2.jpg" alt="자사분석 및 디지털마케팅 컨설팅">
                    </div>
                    <div class="box-title">
                        <span>STEP 2</span>
                        <h2>자사분석 및<br>디지털마케팅 컨설팅</h2>
                        <p>
                            선택하신 전담 마케터가<br>
                            자사 분석을 통한 광고진단 및<br>
                            목표에 따른 광고운영계획을 수립합니다.
                        </p>
                    </div>
                </li>
                <li data-aos="fade-up" data-aos-offset="150" data-aos-easing="ease-in-cubic">
                    <div class="box-img">
                        <img src="<?=G5_MARKETER_URL ?>/images/con2-img3.jpg" alt="체계적인 관리를 통한 광고목표 달성">
                    </div>
                    <div class="box-title">
                        <span>STEP 3</span>
                        <h2>체계적인 관리를<br>통한 광고목표 달성</h2>
                        <p>
                            목표달성을 위해 실시간 모니터링을 하며<br>
                            데이터 분석을 통한 문제점 및 개선점을 도출하여<br>
                            성공적인 마케팅을 실현합니다.
                        </p>
                    </div>
                </li>
            </ul>
        </div> 
    </div>
</section>

<section id="section3">
    <div class="wrap">
        <div class="sch-box">
            <div class="sch-title">
                <h2>최적의 마케팅을 통해 <br>
                 <span class="main-color">최고의 성과를 이뤄 낼 수 있는</span><br>마케터를 찾으시나요?</h2>
            </div>
            <div class="search" data-aos="fade-up" data-aos-easing="ease-in-cubic" data-aos-delay="300">
                <fieldset id="bo_sch">
                    <legend>게시물 검색</legend>

                    <form name="fsearch" method="post">
                    <input type="hidden" name="page" value="1">
                    <input type="hidden" name="mkcheck" value="<?php echo ($mkcheck)?$mkcheck:'all' ?>">
                    <label for="sfl" class="sound_only">검색대상</label>
                    <select name="sfl" id="sfl">
                        <option value="mb_name"<?php echo get_selected($sfl, 'mb_name', true); ?>>마케터명</option>
                        <option value="mb_email"<?php echo get_selected($sfl, 'mb_email', true); ?>>이메일</option>
                        <option value="mb_tel"<?php echo get_selected($sfl, 'mb_tel', true); ?>>전화번호뒤4자리</option>
                    </select>
                    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="sch_input" size="25" maxlength="20" placeholder="찾으시는 마케터를 입력하세요">
                    <button type="submit" value="검색" class="sch_btn"><span class="sound_only">검색</span></button>
                    </form>
                </fieldset>
            </div>   
        </div>
    </div>
</section>

<section id="section4">
    <div class="wrap" id="SectorsList">

        <div class="marketer-check">
            <div class="mk-list-tit">
                <b>다양한 분야</b>의 마케터들이 <br> 인사이트를 운영하고 있습니다.
            </div>
            <div class="mk-list-option" data-aos="fade-up" data-aos-easing="ease-in-cubic" data-aos-delay="300">
                <div class="option-box">
                    <form name="fsectorsSearch" id="fsectorsSearch" method="post">
                        <label class="marketer_option">
                            <input type="radio" name="mkcheck" id="mkcheck" class="hidden" value="all" checked />
                            <div class="op-name">
                                <p>전체</p>
                            </div>
                        </label>
                        <?=codeToHtml($code_sectors, $mkcheck, "rdo7", "mkcheck")?>
                    </form>
                    </div>
                </div>


                <div class="checked-marketer">
                    <?php
                    if($total_count > 0 && $sear_mkcheck){
                    ?>
                        지금 보시는 마케터는 <span><span id="Sectors"><?=($mkcheck)?$mkcheck:'ㅇㅇㅇ'?></span> 업종의 성공경험을 가진</span> 전문 마케터입니다!
                    <?php
                    }
                    ?>
                </div>
            </div>

            <ul class="marketer_list" data-aos="fade-up" data-aos-offset="150" data-aos-easing="ease-in-cubic">
                <?php
                $moreClass = '';
                $rCnt = 1;
                $iList = 0;
                while ($row = sql_fetch_array($result)) {
                    $iNum = $total_count - (( $page - 1 ) * $rows + $iList );
                    $list = $iList%2;

                    $mb_part = ($row['mb_part'])?codeToName($code_part3, get_text($row['mb_part'])):"";
                    $mb_team = ($row['mb_team'])?codeToName($code_team, get_text($row['mb_team'])):"";
                    $mb_post = ($row['mb_post'])?codeToName($code_post, get_text($row['mb_post'])):"";

                    ///////////////////////////////////////////////////////////////////////////////////////
                    //사원 등록 사진 있으면 그걸 적용
                    ///////////////////////////////////////////////////////////////////////////////////////
                    $mb_dir = substr($row['mb_id'],0,2);
                    $mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';
                    if (file_exists($mk_file)) {
                        $mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';
                        $mb_images = '<img src="'.$mk_url.'" alt="'.$row['mb_name'].' AE" width="220" height="220">';
                    }else{
                        //없으면 인트라넷 사진
                        $photo_url = G5_INTRANET_URL.'/data/member_image/'.$row['mb_id'];
                        
                        $mb_images = '<img src="'.$photo_url.'" alt="'.$row['mb_name'].' AE" width="220" height="220">';
                    }

                    $view_link = "sub/gateway.php?utm_member=".$row['mb_id']."&team_code=".$team_code;
                    
                    //더보기 처리 위한것
                    if($rCnt > $rows){ $moreClass = 'more'; }
                ?>
                    <li class="<?=$moreClass?>"><a href="<?=G5_URL?>/<?=$view_link?>"><?=$mb_images?></a>
                        <div class="marketer-name"><?php echo $row['mb_name'] ?> <span class="main-color">AE</span></div>
                    </li>
                <?php
                    $mb_images="";

                    $rCnt++;
                    $iList++;
                }
                ?>
                <?php
                    //더보기 처리 위한것
                    // if(($rCnt > $rows) || ($rCnt < $total_count)){ echo '<div id="moreAll" style="cursor:pointer">마케터 더보기</div>'; }
                ?>
                <?php
                if ($iList == 0)
                    echo "<div>검색된 마케터가 없습니다.</div>";
                ?>
            </ul>

            <?php
                $pagelist = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $teamLinkPara."&amp;bo_table=".$bo_table."&amp;pck=ok&amp;mkcheck=".$mkcheck."&amp;".$qstr."&amp;page=","#SectorsList");
                //echo $pagelist;
            ?>
        </div>

    </div>
</section>

<section id="section5" data-aos="fade-up" data-aos-offset="150" data-aos-easing="ease-in-cubic">
    <div class="wrap">
        <div class="recruit">
            <div class="con-title">
                <h2>클라이언트와 함께 성공을 이루는 마케터가 되어보세요.</h2>
                <p>에이엠피엠글로벌에서는 마케터를 상시 모집하고 있습니다.</p>
            </div>
            <div class="con-link">
                <a href="<?=G5_URL?>/sub/sub5-1.php<?=$teamLinkPara?>#tab-3" target="_blank">마케터 지원하기</a>
            </div>
        </div>
    </div>
</section>
<!-- index 끝-->

<script type="text/javascript">
$(document).ready(function () {
<?php
if($mkcheck || $pck == 'ok'){	//업종선택이 있는 경우, 페이징 인경우
?>
	//console.log('<?=$mkcheck?>');
	$('html, body').animate({ scrollTop: $('#SectorsList').offset().top}, 'fast'); //slow
<?php
}else{	//업종선택이 아닌 경우
?>
	$('html, body').animate({ scrollTop: $('#empty').offset().top}, 'fast'); //slow
<?php
}
?>

	//////////////////////////////////////////////////////////////////////////
	// 사원리스트 일부만 보이도록 처리 후 더보기로 전체 보기
	//////////////////////////////////////////////////////////////////////////
	$('.more').hide();

	$('#moreAll').click(function(){ 
		$('.more').fadeIn(1000);
		$('.more').show();
		$('#moreAll').hide();
	});
});

//radio 버튼 클릭 이벤트 
$("input:radio[name=mkcheck]").click(function(){
	var radioVal = $('input[name="mkcheck"]:checked').val();
	//$('#Sectors').val(radioVal); 
	//$('#Sectors').html(radioVal); 

	//$("#fsectorsSearch").attr("target", "ifrBlank");
	$("#fsectorsSearch").attr("enctype", "multipart/form-data");
	$("#fsectorsSearch").attr("method", "post");
	$("#fsectorsSearch").submit();
});
</script>



<!-- footer -->
<?php
include(G5_MARKETER_PATH.'/inc/_footer.php');
?>

<?php
include_once('./_tail.php');
?>
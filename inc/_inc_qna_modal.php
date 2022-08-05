<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once('./_common.php');
// 필요한 LIB 불러오기
include_once('./gaburi.lib.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
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
?>

<div id="mkt-modal">
   <div class="content">
      <h1>마케터 선택<span>/</span>조회</h1>

      <div class="top-bar">
         <div class="sch-bar">
            <fieldset id="bo_sch">
               <legend>게시물 검색</legend>

               
               <input type="hidden" name="page" id="page" value="1">
               <input type="hidden" name="mkcheck" id="mkcheck" value="<?php echo ($mkcheck)?$mkcheck:'all' ?>">
               <label for="sfl" class="sound_only">검색대상</label>
               <select name="sfl" id="sfl">
                  <option value="mb_name"<?php echo get_selected($sfl, 'mb_name', true); ?>>마케터명</option>
                  <option value="mb_email"<?php echo get_selected($sfl, 'mb_email', true); ?>>이메일</option>
                  <option value="mb_tel"<?php echo get_selected($sfl, 'mb_tel', true); ?>>전화번호뒤4자리</option>
               </select>
               <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
               <input type="text" name="stx" id="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="sch_input" size="25" maxlength="20" placeholder="찾으시는 마케터를 입력하세요.">
               <button type="submit" value="검색" class="sch_btn"><span class="sound_only">검색</span></button>
              
            </fieldset>
         </div>

         <div class="cate-btn">
            <div class="mkt-toggle">카테고리 <span>열기</span></div>
            <form name="fsectorsSearch" id="fsectorsSearch" method="post" class="mkt-category">
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

      <ul class="marketer_list">
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
				   $mb_images = '<img src="'.$mk_url.'" alt="'.$row['mb_name'].' AE" width="220" height="145">';
				}else{
				   //없으면 인트라넷 사진
				   $mk_url = G5_INTRANET_URL.'/data/member_image/'.$row['mb_id'];
				   
				   $mb_images = '<img src="'.$mk_url.'" alt="'.$row['mb_name'].' AE" width="145" height="145">';
				}

				$view_cho = $row['mb_id']."|".$row['mb_name']."|".$mk_url;
				
				//더보기 처리 위한것
				if($rCnt > $rows){ $moreClass = 'more'; }
				echo "
				<label class='mkt-choice'>
				   <input type='radio' name='mk-cho' id='mk-cho' class='hidden' value='".$view_cho."'>
					  <li class='".$moreClass."'>".$mb_images."<div class='marketer-name'>".$row['mb_name']."<span class='main-color'>AE</span></div></li>
				</label>
				";
				
				 $mb_images="";

				 $rCnt++;
				 $iList++;
            }
			//더보기 처리 위한것
			// if(($rCnt > $rows) || ($rCnt < $total_count)){ echo '<div id="moreAll" style="cursor:pointer">마케터 더보기</div>'; }

            if ($iList == 0)
               echo "<div class=".'none'.">검색된 마케터가 없습니다.</div>";
            ?>
      </ul>

      <div class="close-btn">
         CLOSE <img src="<?php echo G5_URL ?>/images/close-btn.png" alt="닫기">
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
	/* 조회 버튼 클릭시 모달 open */
	$("#mkt_sch").click( function(){
		$("#mkt-modal").fadeIn('slow/400/fast', function() {
			$("#mkt-modal").css("visibility", "visible");
		});
	});

    /* 닫기 버튼 클릭시 모달 close */
    $(".close-btn").click( function(){
		$("#mkt-modal").fadeOut('slow/400/fast', function() {
			$("#mkt-modal").css("visibility", "hidden");
        });

	});

	/* 마케터 조회 */
    $(document).on("click",".mkt-toggle",function(){
		if($(this).next().css("display")=="none"){
			$(this).next().show();
            $(this).children("span").text("닫기");
        }else{
            $(this).next().hide();
            $(this).children("span").text("열기");
        }
	});

    /* 외부영역 클릭시 팝업 닫기 */
    $(document).mouseup(function (e){
         if($("#mkt-modal").has(e.target).length === 0){
            $("#mkt-modal").css("display", "none");
         }
    });


	/* 마케터 선택하면 모달 닫힘 */
	$(document).on('click', '.mkt-choice input:radio[name=mk-cho]', function(){
		var str = $('input[name=mk-cho]:checked').val();
		console.log(str);
		var arr_str = str.split('|');
		console.log(arr_str);

		var wr_11 = arr_str[0];
		var name  = arr_str[1];
		var img   = arr_str[2];

		$("#mk_appoint").show();

		$("#cho-img").attr("src", img);
		$("#cho-name").html(name);

		$("#wr_11").val(wr_11);
		$("#wr_12").val(name);
		$("#wr_13").val(img);
         
        $("#mkt-modal").css("display","none"); 
	});
});

$(document).on('click', '.sch_btn', function(){
	var page = ($("#page").val())?$("#page").val():1;
	var mkcheck = ($("input[name=mkcheck]:checked").val())?$("input[name=mkcheck]:checked").val():'all';
	var sfl = ($("#sfl option:selected").val())?$("#sfl option:selected").val():$("#mk-cho option:selected").val();
	var stx = $("#stx").val();

	$.ajax({
		url: '/inc/_req_marketerInfo.php',
		type: 'post',
		data:{page:page, mkcheck:mkcheck, sfl:sfl, stx:stx},
		success: function(data){
			$(".marketer_list").html(data);
		}
	});
});
$(document).on('click', '.cate-btn input:radio[name=mkcheck]', function(){
	var page = ($("#page").val())?$("#page").val():1;
	var mkcheck = ($("input[name=mkcheck]:checked").val())?$("input[name=mkcheck]:checked").val():'all';
	var sfl = ($("#sfl option:selected").val())?$("#sfl option:selected").val():$("#mk-cho option:selected").val();
	var stx = $("#stx").val();

	$.ajax({
		url: '/inc/_req_marketerInfo.php',
		type: 'post',
		data:{page:page, mkcheck:mkcheck, sfl:sfl, stx:stx},
		success: function(data){
			$(".marketer_list").html(data);
		}
	});
});

</script>
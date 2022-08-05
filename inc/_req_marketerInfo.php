<?php
include_once('./_common.php');
include_once(G5_INCLUDE_PATH."/JSON.php");
?>

<?php
$page = $_POST['page'];
$sfl = $_POST['sfl'];
$mkcheck = $_POST['mkcheck'];
$stx = $_POST['stx'];

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


$sql_order = " order by rand() ";

//한페이지 최대 노출 수
$rows = "15";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch_intra($sql);
$total_count = $row['cnt'];


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
//echo "sql: ".$sql;
/*
$moreClass = '';
$rCnt = 1;
$iList = 0;
while ($row = sql_fetch_array($result)) {
	$iNum = $total_count - (( $page - 1 ) * $rows + $iList );
	$list = $iList%2;

	$mb_part_text = ($row['mb_part'])?codeToName($code_part3, get_text($row['mb_part'])):"";
	$mb_team_text = ($row['mb_team'])?codeToName($code_team, get_text($row['mb_team'])):"";
	$mb_post_text = ($row['mb_post'])?codeToName($code_post, get_text($row['mb_post'])):"";

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
	   $photo_url = G5_INTRANET_URL.'/data/member_image/'.$row['mb_id'];
	   
	   $mb_images = '<img src="'.$photo_url.'" alt="'.$row['mb_name'].' AE" width="145" height="145">';
	}

	$view_link = "sub/gateway.php?utm_member=".$row['mb_id']."&team_code=".$team_code;


	$rows[] = array( "mb_id" => urlencode($row['mb_id'])
				, "mb_name" => urlencode($row['mb_name'])
				, "mb_nick" => urlencode($row['mb_nick'])
				, "mb_part" => urlencode($row['mb_part'])
				, "mb_team" => urlencode($row['mb_team'])
				, "mb_post" => urlencode($row['mb_post'])
				, "mb_part_text" => urlencode($mb_part_text)
				, "mb_team_text" => urlencode($mb_team_text)
				, "mb_post_text" => urlencode($mb_post_text)
				, "mb_images" => urlencode($mb_images)
				, "view_link" => urlencode($view_link)
		);
}
*/
?>
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
				   
				   $mb_images = "<img src='".$mk_url."' alt='".$row['mb_name']." AE' width='220' height='145'>";
				}

				$view_cho = $row['mb_id']."|".$row['mb_name']."|".$mk_url;

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
            if ($iList == 0)
               echo "<div class=".'none'.">검색된 마케터가 없습니다.</div>";
            ?>

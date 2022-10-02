<?php
include_once('./_common.php');
include_once(G5_INCLUDE_PATH."/JSON.php");

$searchword = $_REQUEST['searchword'];    
?>

<?php 
//-----------------------------------------------------------------------------------------
// 프로그램 데이터
//-----------------------------------------------------------------------------------------
$sql_select = " * ";
$sql_common = " from g5_member a  ";

$sql_search = " where (1) ";
$sql_search.= " AND mb_level > 1 ";

if ($searchword) {	
    $sql_search .= " and  ";
	$sql_search .= " a.mb_name like '{$searchword}%' ";
}

// 쿼리 정렬값이 없다면
if (!$sst) {
    $sst = "a.mb_name";
    $sod = "";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select {$sql_select} {$sql_common} {$sql_search} {$sql_order} ";
//echo $sql;exit;
$result = sql_query_intra($sql);

// JSON 객체 생성
$json = new Services_JSON();    
$rows = array();

while($row=sql_fetch_array($result)) {
	$mb_part_name = codeToName($code_part, $row['mb_part']);
	$mb_team_name = codeToName($code_team, $row['mb_team']);

	$lavel_name = $row['mb_name']."(".$mb_part_name.">".$mb_team_name.")";

	$rows[] = array( "mb_id" => urlencode($row['mb_id']), "mb_name" => urlencode($row['mb_name']),"lavel_name" => urlencode($lavel_name)
		, "mb_part_code" => urlencode($mb_part_code), "mb_part_name" => urlencode($mb_part_name)
		, "mb_team_code" => urlencode($mb_team_code), "mb_team_name" => urlencode($mb_team_name)
	);
		              
	//$rows[] = $row;
}

$output = $json->encode($rows);	
echo urldecode($output); 
?>		             	

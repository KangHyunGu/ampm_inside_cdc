<?php
$sub_menu = "400200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$mb_id = ($mb_id)?$mb_id:$member['mb_id'];
$sql_common = " from {$g5['mklogin_log_table']} a ";

$sql_search = " where (1) ";

if($mb_id && $mb_id != 'ampm'){
	$sql_search .= " AND a.mb_id = '{$mb_id}' ";
}

if($fd && $td){
	$sql_search.= " and loc_datetime between '".$fd." 00:00:00' and '".$td." 23:59:59'  ";
}


if (!$sst) {
    $sst  = "loc_uid";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
//echo $sql;
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_marketer($stx);

$g5['title'] = '로그인 기록';
include_once(G5_MARKETER_ADMIN_PATH.'/admin.head.php');

$colspan = 16;

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>

<script type="text/javascript">
function goList(sst) {
	$("#fsearch #sst").val(sst);
	$("#fsearch").attr("action", "member_loginLog.php");
	$("#fsearch").attr("method", "post");
	$("#fsearch").submit();
}

function doAction(rowcount) {
	$("#fsearch #rowcount").val(rowcount);
	$("#fsearch").attr("action", "member_loginLog.php");
	$("#fsearch").attr("method", "post");
	$("#fsearch").submit();
}

function goExcel(){
	$("#fsearch").attr("action", "member_loginLog_exceldown.php");
	$("#fsearch").attr("method", "post");
	$("#fsearch").submit();
}
</script>

<?php if($is_admin == 'super' || $member['mb_id'] == 'ampm'){ echo help('부서별, 마케터 개인별 정보 조회가 필요한 경우에는 좌측 [개인화 종합 이력] 메뉴를 이용바랍니다.'); } ?>

<div class="local_ov01 local_ov">
    전체 <?php echo number_format($total_count) ?> 건
</div>

<form name="formLoginLogList" id="formLoginLogList" action="./member_loginLog_update.php" onsubmit="return formLoginLogList_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="rowcount" id="rowcount"  value='<?=$rowcount?>'>		<!-- 줄수 -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">본부</th>
        <th scope="col">팀</th>
        <th scope="col">사원명</th>
		<th scope="col">아이디</th>
        <th scope="col">사진</th>
        <th scope="col">접속경로</th>
        <th scope="col">접속IP</th>
        <th scope="col">접속시간</th>
        <th scope="col">상태</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$mk = get_marketer($row['mb_id']);

		$mb_part = ($mk['mb_part'])?codeToName($code_part3, get_text($mk['mb_part'])):"";
		$mb_team = ($mk['mb_team'])?codeToName($code_team, get_text($mk['mb_team'])):"";
		$mb_post = ($mk['mb_post'])?codeToName($code_post, get_text($mk['mb_post'])):"";

		//$photo_file = G5_DATA_PATH.'/member_image/'.$row['mb_id'];

		$photo_url = G5_INTRANET_URL.'/data/member_image/'.$mk['mb_id'];
		$mb_images = '<img src="'.$photo_url.'" width="50" height="70" alt=""> ';


		$mb_dir = substr($mk['mb_id'],0,2);
		$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';
		if (file_exists($mk_file)) {
			$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mk['mb_id'].'.jpg';

			$mb_images = '<img src="'.$mk_url.'" width="50" height="70" alt=""> ';
		}
    ?>

    <tr class="<?php echo $bg; ?>">
        <td><?php echo $mb_part ?></td>
        <td><?php echo $mb_team ?></td>
        <td><?php echo $mk['mb_name'] ?></td>
        <td><?php echo $row['mb_id'] ?></td>
        <td><?php echo $mb_images ?></td>
        <td><?php echo $row['loc_referer'];?></td>
        <td><?php echo $row['loc_ip'];?></td>
        <td><?php echo date("Y-m-d H:i:s", strtotime($row['loc_datetime'])) ?></td>
        <td><?php echo $login_log_array[$row['loc_success']];?></td>
    </tr>

    <?php
    }
    if ($i == 0)
        echo "<tr><td colspan=\"".$colspan."\" class=\"empty_table\">자료가 없습니다.</td></tr>";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
<?php 
	if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
?>
    <!--input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02"-->
<?php 
} 
?>
</div>

</form>

<?php 
	$queryString	= "&sear_teacher={$sear_teacher}&sear_part={$sear_part}&sear_team={$sear_team}&sear_post={$sear_post}&sear_duty={$sear_duty}&sear_sex={$sear_sex}&sear_level={$sear_level}&rowcount={$rowcount}";		//쿼리스트링
	$qstr = $qstr.$queryString;
	echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); 
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
/* 달력 시작 */
$(function() {
	$("#fd, #td").datepicker({
		monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd",
		showButtonPanel: true,
		yearRange: "c-10:c+10",
		minDate: "",
		maxDate: ""
	});
});
/* 달력 끝 */

function formLoginLogList_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}


function excelform(url)
{
    var opt = "width=600,height=450,left=10,top=10";
    window.open(url, "win_excel", opt);
    return false;
} 

</script>

<?php
include_once(G5_MARKETER_ADMIN_PATH.'/admin.tail.php');
?>

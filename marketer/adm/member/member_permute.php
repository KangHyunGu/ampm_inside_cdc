<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['member_table']} b ";

$sql_search = " where (1) ";

$sql_search.= "and (b.mb_leave_date = '' or b.mb_level > 1) ";
$sql_search.= "and b.mb_level < 5 ";
$sql_search.= "and b.mb_post = 'P1' ";
$sql_search.= "and b.mb_part NOT IN('ACE','ASU','AT1') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point' :
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel' :
        case 'mb_hp' :
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

// 본부구분
if($sear_part){
	if($sql_search == "") $sql_search .= " where ";
	else $sql_search .= " and ";
	
	$sql_search .= " b.mb_part = '{$sear_part}' ";
}

// 부서구분
if($sear_team){
	if($sql_search == "") $sql_search .= " where ";
	else $sql_search .= " and ";
	
	$sql_search .= " b.mb_team = '{$sear_team}' ";
}

// 직책구분
if($sear_post){
	if($sql_search == "") $sql_search .= " where ";
	else $sql_search .= " and ";
	
	$sql_search .= " b.mb_post = '{$sear_post}' ";
}

// 직위구분
if($sear_duty){
	if($sql_search == "") $sql_search .= " where ";
	else $sql_search .= " and ";
	
	$sql_search .= " b.mb_duty = '{$sear_duty}' ";
}

// 성별구분
if($sear_sex){
	if($sql_search == "") $sql_search .= " where ";
	else $sql_search .= " and ";
	
	$sql_search .= " b.mb_sex = '{$sear_sex}' ";
}

// 접속 기간 검색
if($fd && $td) {
	$sql_search .= " and a.md_createday between '".$fd." 00:00:00' and '".$td." 23:59:59' ";
}

if ($sst) {
    //$sst = "mb_datetime";
    //$sod = "desc";

	$sql_order = " order by {$sst} {$sod} ";
}else{
	//$sql_order = " order by {$sst} {$sod} ";
	$sql_order = " order by mb_part, mb_team, mb_post desc, mb_datetime ";
}

$sql_search.= "and (b.mb_leave_date = '' or b.mb_level > 1) ";

if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
}else{
	/*
	if($member['mb_post'] == 'P3' || $member['mb_post'] == 'P4'){ //본부장은 해당 본부 본인 포함 모두 
		if($sql_search == "") $sql_search .= " where ";
		else $sql_search .= " and ";
		if($member['mb_post'] == 'P4'){	// 영업총괄 - 대외협력실, 2본부
			//$sql_search .= " b.mb_team = 'T1' ";
			$sql_search .= " (b.mb_team = 'T1' OR b.mb_part = 'AD2' OR b.mb_id = '{$member['mb_id']}') ";
		}else{
			$sql_search .= " b.mb_part = '{$member['mb_part']}' ";
		}
	}else if($member['mb_post'] == 'P2'){ //팀장 권한은 본인포함, 팀원모두
		if($sql_search == "") $sql_search .= " where ";
		else $sql_search .= " and ";
		
		$sql_search .= " b.mb_part = '{$member['mb_part']}' ";
		$sql_search .= " and ";
		$sql_search .= " b.mb_team = '{$member['mb_team']}' ";
	}else{
		if($sql_search == "") $sql_search .= " where ";
		else $sql_search .= " and ";
		
		$sql_search .= " b.mb_part = '{$member['mb_part']}' ";
		$sql_search .= " and ";
		$sql_search .= " b.mb_team = '{$member['mb_team']}' ";
		$sql_search .= " and ";
		$sql_search .= " b.mb_id = '{$member['mb_id']}' ";
	}
	*/
		if($sql_search == "") $sql_search .= " where ";
		else $sql_search .= " and ";
		
		$sql_search .= " b.mb_part = '{$member['mb_part']}' ";
		$sql_search .= " and ";
		$sql_search .= " b.mb_team = '{$member['mb_team']}' ";
		$sql_search .= " and ";
		$sql_search .= " b.mb_id = '{$member['mb_id']}' ";
}

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch_intra($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] = "내 정보 수정 이력";
include_once(G5_MARKETER_ADMIN_PATH.'/admin.head.php');


$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query_intra($sql);

$colspan = 16;
?>
<?php
if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
?>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sear_part" id="sear_part">
	<option value=''>::: 본부 :::</option>
	<?=codeToHtml($code_part3, $sear_part, "cbo", "")?>
</select>
<select name="sear_team" id="sear_team">
	<option value=''>::: 부서 :::</option>
	<?=codeToHtml($code_team, $sear_team, "cbo", "")?>
</select>
<select name="sear_post" id="sear_post">
	<option value=''>::: 직책 :::</option>
	<?=codeToHtml($code_post, $sear_post, "cbo", "")?>
</select>
<select name="sear_duty" id="sear_duty">
	<option value=''>::: 직위 :::</option>
	<?=codeToHtml($code_duty, $sear_duty, "cbo", "")?>
</select>
<select name="sear_sex" id="sear_sex">
	<option value=''>::: 성별 :::</option>
	<?=codeToHtml($code_sex, $sear_sex, "cbo", "")?>
</select>
<input type="text" name="fd" id="fd" class="frm_input" size="10" value="<?php echo $fd; ?>" placeholder="접속일시 시작" /> ~
<input type="text" name="td" id="td" class="frm_input" size="10" value="<?php echo $td; ?>" placeholder="접속일시 종료" />
<select name="sfl" id="sfl">
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>사원아이디</option>
    <option value="mb_name"<?php echo get_selected($_GET['sfl'], "mb_name"); ?>>이름</option>
    <option value="mb_email"<?php echo get_selected($_GET['sfl'], "mb_email"); ?>>E-MAIL</option>
    <option value="mb_tel"<?php echo get_selected($_GET['sfl'], "mb_tel"); ?>>전화번호</option>
    <option value="mb_hp"<?php echo get_selected($_GET['sfl'], "mb_hp"); ?>>휴대폰번호</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
<input type="submit" class="btn_submit" value="검색">

</form>
<?php
}
?>

<div class="local_desc01 local_desc">
    <p>
        내 정보 수정 이력을 조회 할 수 있습니다.
    </p>
</div>

<form name="permuteLog" id="permuteLog" action="./member_list_update.php" onsubmit="return permuteLog_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
<?php
if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
?>
        <th scope="col" id="mb_list_chk" rowspan="2" >
            <label for="chkall" class="sound_only">사원 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
<?php
}
?>
        <th scope="col">본부</th>
        <th scope="col">팀</th>
        <th scope="col">사원명</th>
        <th scope="col">영문이름</th>
        <th scope="col">아이디</th>
        <th scope="col">사진</th>
        <th scope="col">변경건수</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$s_mod = '<a href="./member_permute_log.php?'.$qstr.'&amp;w=u&amp;mb_id='.$row['mb_id'].'" class="btn btn_03">히스토리</a>';

		$mb_part = ($row['mb_part'])?codeToName($code_part3, get_text($row['mb_part'])):"";
		$mb_team = ($row['mb_team'])?codeToName($code_team, get_text($row['mb_team'])):"";
		$mb_post = ($row['mb_post'])?codeToName($code_post, get_text($row['mb_post'])):"";

		//$photo_file = G5_DATA_PATH.'/member_image/'.$row['mb_id'];

		$photo_url = G5_INTRANET_URL.'/data/member_image/'.$row['mb_id'];
		$mb_images = '<img src="'.$photo_url.'" width="50" height="70" alt=""> ';


		$mb_dir = substr($row['mb_id'],0,2);
		$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';
		if (file_exists($mk_file)) {
			$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';

			$mb_images = '<img src="'.$mk_url.'" width="50" height="70" alt=""> ';
		}

		$sql = " select count(*) as cnt from g5_marketer_permute_log where mb_id = '{$row['mb_id']}' GROUP BY mb_id ";
		$row1 = sql_fetch($sql);
		$log_count = $row1['cnt'];
	
	?>

    <tr class="<?php echo $bg; ?>">
<?php
if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
?>
        <td>
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['mb_name']); ?> <?php echo get_text($row['mb_nick']); ?>님</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
<?php
}
?>
        <td><?php echo $mb_part ?></td>
        <td><?php echo $mb_team ?></td>
        <td><?php echo $row['mb_name'] ?></td>
        <td><?php echo $row['mb_2'] ?></td>
        <td><?php echo $row['mb_id'] ?></td>
        <td><?php echo $mb_images ?></td>
        <td><?php echo $log_count ?></td>
        <td><?php echo $s_mod ?></td>
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
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
<?php 
} 
?>

</div>


</form>

<?php 
$queryString	= "&sear_part={$sear_part}&sear_team={$sear_team}&sear_post={$sear_post}&sear_duty={$sear_duty}&sear_sex={$sear_sex}&fd={$fd}&td={$td}&sfl={$sfl}&stx={$stx}";		//쿼리스트링
$qstr = $qstr.$queryString;

echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?bo_table='.$qstr.'&amp;page='); 
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
function permuteLog_submit(f)
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
</script>

<?php
include_once(G5_MARKETER_ADMIN_PATH.'/admin.tail.php');
?>
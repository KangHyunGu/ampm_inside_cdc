<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

//mb_id 정보가 없으면 안됨
$mb_id = ($mb_id)?$mb_id:$member['mb_id'];

$sql_common = " from g5_marketer_permute_log a ";

$sql_search = " where (1) ";

if($mb_id && $mb_id != 'ampm'){
	$sql_search .= " AND a.mb_id = '{$mb_id}' ";
}


if($fd && $td){
	$sql_search.= " and per_date between '".$fd." 00:00:00' and '".$td." 23:59:59'  ";
}


if ($sst) {
    //$sst = "mb_datetime";
    //$sod = "desc";

	$sql_order = " order by {$sst} {$sod} ";
}else{
	//$sql_order = " order by {$sst} {$sod} ";
	$sql_order = " order by per_date desc ";
}


$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] = "내 정보 수정 히스토리";
include_once(G5_MARKETER_ADMIN_PATH.'/admin.head.php');


$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 16;
?>

<?php if($is_admin == 'super' || $member['mb_id'] == 'ampm'){ echo help('부서별, 마케터 개인별 정보 조회가 필요한 경우에는 좌측 [개인화 종합 이력] 메뉴를 이용바랍니다.'); } ?>

<div class="local_ov01 local_ov">
    전체 <?php echo number_format($total_count) ?> 건
</div>


<form name="permuteHistoey" id="permuteHistoey" action="./permuteHistoey_update.php" onsubmit="return permuteHistoey_submit(this);" method="post">
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
        <th scope="col">본부</th>
        <th scope="col">팀</th>
        <th scope="col">사원명</th>
        <th scope="col">영문이름</th>
        <th scope="col">아이디</th>
        <th scope="col">사진</th>
        <th scope="col">변경유형</th>
        <th scope="col">변경시간</th>
        <th scope="col">변경IP</th>
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
        <td><?php echo $mk['mb_2'] ?></td>
        <td><?php echo $mk['mb_id'] ?></td>
        <td><?php echo $mb_images ?></td>
        <td><?php echo $row['per_type'] ?></td>
        <td><?php echo $row['per_date'] ?></td>
        <td><?php echo $row['per_ip'] ?></td>
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

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?'.$qstr.'&amp;page='); ?>

<script>
function permuteHistoey_submit(f)
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
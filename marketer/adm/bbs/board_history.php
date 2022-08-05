<?php
include_once('./_common.php');
include_once('./board_submenu.php');

auth_check($auth[$sub_menu], 'r');

if (!$bo_table) {
   alert('정보가 올바르지 않습니다.', G5_MARKETER_ADMIN_URL);
}

// history 테이블이 없을 경우 생성
if(!sql_query(" DESC g5_marketer_bbs_history ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS g5_marketer_bbs_history (
		hs_id INT(11) NOT NULL AUTO_INCREMENT,
		bo_table VARCHAR(20) NOT NULL DEFAULT '',
		hs_type varchar(255) NOT NULL,                                         
		hs_ip varchar(255) NOT NULL,                                         
		hs_date varchar(255) NOT NULL,
		mb_id VARCHAR(20) NOT NULL DEFAULT '',
		wr_id VARCHAR(15) NOT NULL DEFAULT '',
		ca_name varchar(255) NOT NULL,                                
		wr_subject varchar(255) NOT NULL,                             
		wr_content longtext NOT NULL,                                 
		wr_link1 text NOT NULL,                                       
		wr_link2 text NOT NULL,                                       
		wr_1 varchar(255) NOT NULL,                                   
		wr_2 varchar(255) NOT NULL,                                   
		wr_3 varchar(255) NOT NULL,                                   
		wr_4 varchar(255) NOT NULL,                                   
		wr_5 varchar(255) NOT NULL,                                   
		wr_6 varchar(255) NOT NULL,                                   
		wr_7 varchar(255) NOT NULL,                                   
		wr_8 varchar(255) NOT NULL,                                   
		wr_9 varchar(255) NOT NULL,                                   
		wr_10 varchar(255) NOT NULL,                                  
		wr_11 varchar(255) DEFAULT NULL,                              
		wr_12 varchar(255) DEFAULT NULL,                              
		wr_13 varchar(255) DEFAULT NULL,                              
		wr_14 varchar(255) DEFAULT NULL,                              
		wr_15 varchar(255) DEFAULT NULL,                              
		wr_16 varchar(255) DEFAULT NULL,                              
		wr_17 varchar(255) DEFAULT NULL,                              
		wr_18 varchar(255) DEFAULT NULL,                              
		wr_19 varchar(255) DEFAULT NULL,                              
		wr_20 varchar(255) DEFAULT NULL,     
		PRIMARY KEY (hs_id),
		INDEX hs_bo_table (bo_table),
		INDEX hs_wr_id (wr_id),
		INDEX hs_mb_id (mb_id)
	) ", false);
}
$bo_table = substr($bo_table, 3); 

$mb_id = ($mb_id)?$mb_id:$member['mb_id'];

$sql_common = " from g5_marketer_bbs_history a ";

$sql_search = " where (1) ";
$sql_search.= " and a.bo_table = '{$bo_table}' ";

if($mb_id && $mb_id != 'ampm'){
	$sql_search .= " AND a.mb_id = '{$mb_id}' ";
}

if($fd && $td){
	$sql_search.= " and hs_date between '".$fd." 00:00:00' and '".$td." 23:59:59'  ";
}


if (!$sst) {
    $sst  = "hs_id";
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
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_marketer($stx);


$sql2 = " select bo_subject from g5_board where bo_table = '{$bo_table}' ";
$row2 = sql_fetch($sql2);

$g5['title'] = $row2['bo_subject'].' 게시글 이력';
include_once(G5_MARKETER_ADMIN_PATH.'/admin.head.php');

$colspan = 16;

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>

<?php if($is_admin == 'super' || $member['mb_id'] == 'ampm'){ echo help('부서별, 마케터 개인별 정보 조회가 필요한 경우에는 좌측 [개인화 종합 이력] 메뉴를 이용바랍니다.'); } ?>

<div class="local_ov01 local_ov">
    전체 <?php echo number_format($total_count) ?> 건
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 수정 내역 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">본부</th>
        <th scope="col">팀</th>
        <th scope="col">사원명</th>
        <th scope="col">영문이름</th>
        <th scope="col">아이디</th>
        <th scope="col">사진</th>
		<th scope="col">게시판</th>
        <th scope="col">글분류</th>
        <th scope="col">글제목</th>
        <th scope="col">글번호</th>
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

		// 게시글 제목을 가져옴
        $row3 = get_write($g5['write_prefix'].$row['bo_table'], $row['wr_id']);

		$link1 = $link2 = '';
        $link1 = '<a href="'.G5_MARKETER_ADMBBS_URL.'/board.php?bo_table='.$row['bo_table'].'&amp;wr_id='.$row['wr_id'].'" target="_blank">';
        $link2 = '</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <input type="hidden" name="hs_id[<?php echo $i ?>]" value="<?php echo $row['hs_id'] ?>" id="po_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['po_content'] ?> 내역</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td><?php echo $mb_part ?></td>
        <td><?php echo $mb_team ?></td>
        <td><?php echo $mk['mb_name'] ?></td>
        <td><?php echo $mk['mb_2'] ?></td>
        <td><?php echo $mk['mb_id'] ?></td>
        <td><?php echo $mb_images ?></td>

		<td><?php echo $row['bo_table'] ?></td>
		<td><?php echo $row3['ca_name'] ?></td>
        <td><?php echo $link1 ?><?php echo $row3['wr_subject'] ?><?php echo $link2 ?></td>
        
        <td><?php echo $row['wr_id'] ?></td>
        <td><?php echo $row['hs_type'] ?></td>
        <td><?php echo $row['hs_date'] ?></td>
        <td><?php echo $row['hs_ip'] ?></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
<?php 
	if($is_admin == 'super' || $member['mb_id'] == 'ampm'){		//관리자는 다본다.
?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
<?php 
} 
?>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fpointlist_submit(f)
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

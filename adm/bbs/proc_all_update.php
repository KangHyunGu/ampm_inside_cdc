<?php
include_once('./_common.php');

if(!$is_admin)
    alert('접근 권한이 없습니다.', G5_URL);


$act = isset($act) ? strip_tags($act) : '';
$post_btn_submit = isset($_POST['btn_submit']) ? clean_xss_tags($_POST['btn_submit'], 1, 1) : '';

$wr_10    = $_POST['wr_10'];
$wr_17    = $_POST['wr_17'];
$wr_18    = $_POST['wr_18'];


/*
print_r2($_POST);
echo $post_btn_submit;

exit;
*/


$wr_id_list = isset($_POST['wr_id_list']) ? preg_replace('/[^0-9\,]/', '', $_POST['wr_id_list']) : '';

$sql = " select * from $write_table where wr_id in ({$wr_id_list}) order by wr_id ";
//echo $sql;
$result = sql_query($sql);
while ($row = sql_fetch_array($result))
{
	if ($is_admin == 'manager' || $is_admin == 'super') // 최고관리자 통과
        ;
    else if ($is_admin == 'group') // 그룹관리자
    {
        $mb = get_member($row['mb_id']);
        if ($member['mb_id'] == $group['gr_admin']) // 자신이 관리하는 그룹인가?
        {
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                continue;
        }
        else
            continue;
    }
    else if ($is_admin == 'board') // 게시판관리자이면
    {
        $mb = get_member($row['mb_id']);
        if ($member['mb_id'] == $board['bo_admin']) // 자신이 관리하는 게시판인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                continue;
        else
            continue;
    }
    else if ($is_admin == 'ma_admin') // AMPM 운영관리자 OR AMPM 팀장 이상인 경우
    {
        $mb = get_marketer($row['mb_id']);
		if($mb['mb_id']){
			//작성자의 소속정보에 따른 권한 확인
			if($member['mb_post'] == 'P6'){ //대표이사
				;
			}else if($member['mb_post'] == 'P4' || $member['mb_post'] == 'P5'){ //이사
				;
			}else if($member['mb_post'] == 'P3'){ //이사

				if ($member['mb_part'] == $mb['mb_part']) // 자신이 관리하는 소속인가?
					;
				else
					continue;
			}else{	//팀장
				if ($member['mb_part'] == $mb['mb_part'] && $member['mb_team'] == $mb['mb_team']) // 자신이 관리하는 소속인가?
					;
				else
					continue;
			}
		}else{
			continue;
		}
	}
    else if ($member['mb_id'] && $member['mb_id'] == $row['mb_id']) // 자신의 글이라면
    {
        ;
    }
    else if ($wr_password && !$row['mb_id'] && check_password($wr_password, $row['wr_password'])) // 비밀번호가 같다면
    {
        ;
    }
    else
        continue;   // 나머지는 삭제 불가

	
	if($post_btn_submit == '담당자일괄변경') {
		// 게시글 담당자 변경
		//echo " update $write_table set wr_17 = '{$wr_17}', wr_18 = '{$wr_18}'  where wr_id = '{$row['wr_id']}' ";
		sql_query(" update $write_table set wr_17 = '{$wr_17}', wr_18 = '{$wr_18}'  where wr_id = '{$row['wr_id']}' ");
	
	} else if($post_btn_submit == '처리일괄변경') {
		// 게시글 처리 처리, 선택처리가 들어가면 확인 된거로 인지
		//echo " update $write_table set wr_10 =  '{$wr_10}' where wr_id = '{$row['wr_id']}' ";
		sql_query(" update $write_table set wr_10 = '{$wr_10}', wr_16 =  'Y' where wr_id = '{$row['wr_id']}' ");
	
	} else {
		alert('올바른 방법으로 이용해 주세요.');
	}
}

//exit;
$msg = '해당 게시물을 수정하였습니다.';
$opener_href  = get_pretty_adm_url($bo_table,'','&amp;page='.$page.'&amp;'.$qstr);
$opener_href1 = str_replace('&amp;', '&', $opener_href);
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<script>
alert("<?php echo $msg; ?>");
opener.document.location.href = "<?php echo $opener_href1; ?>";
window.close();
</script>
<noscript>
<p>
    <?php echo $msg; ?>
</p>
<a href="<?php echo $opener_href; ?>">돌아가기</a>
</noscript>
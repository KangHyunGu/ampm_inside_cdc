<?php
include_once('./_common.php');

if (!count($_POST['chk_wr_id'])) {
    alert("항목을 하나 이상 체크하세요.");
}

$writeTable = 'g5_write_'.$bo_table;

//print_r($_POST['chk_wr_id']);exit;

for ($i=0; $i<count($_POST['chk_wr_id']); $i++)
{
	// 실제 번호를 넘김
	$real_wr_id = $_POST['chk_wr_id'][$i];

	$write = sql_fetch(" select * from $write_table where wr_id = '$real_wr_id' ");


	if ($is_admin == 'super') // 최고관리자 통과
        ;
    else if ($is_admin == 'group') // 그룹관리자
    {
        $mb = get_member($write['mb_id']);

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
        $mb = get_member($write['mb_id']);
        if ($member['mb_id'] == $board['bo_admin']) // 자신이 관리하는 게시판인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                continue;
        else
            continue;
    }
    else if ($member['mb_id'] && $member['mb_id'] == $write['mb_id']) // 자신의 글이라면
    {
        ;
    }
    else if ($wr_password && !$write['mb_id'] && sql_password($wr_password) == $write['wr_password']) // 비밀번호가 같다면
    {
        ;
    }
    else
        continue;   // 나머지는 수정 불가


	$sql_common = 	"	wr_9	= '{$_POST['wr_9'][$real_wr_id]}',		
						wr_10	= '{$_POST['wr_10'][$real_wr_id]}'
					";

	// 업데이트
	$sql = " update {$writeTable}
				set {$sql_common}
			 where wr_id = '{$real_wr_id}' ";
	//echo $sql;
	sql_query($sql);
}
//exit; 

goto_url('./board.php?bo_table='.$bo_table.'&amp;page='.$page.$qstr);
?>

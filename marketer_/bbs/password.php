<?php
include_once('./_common.php');

$g5['title'] = '비밀번호 입력';

$sublink = '&amp;path_dep1='.$_REQUEST['path_dep1'].'&amp;path_dep2='.$_REQUEST['path_dep2'].'&amp;path_dep3='.$_REQUEST['path_dep3'].'&amp;path_dep4='.$_REQUEST['path_dep4'];


switch ($w) {
    case 'u' :
        $action = './write.php?bo_table='.$bo_table.$sublink;
        $return_url = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$sublink;
        break;
    case 'd' :
        $action = './delete.php?bo_table='.$bo_table.$sublink;
        $return_url = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$sublink;
        break;
    case 'x' :
        $action = './delete_comment.php?bo_table='.$bo_table.$sublink;
        $row = sql_fetch(" select wr_parent from $write_table where wr_id = '$comment_id' ");
        $return_url = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$row['wr_parent'].$sublink;
        break;
    case 's' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$sublink);
        else {
            $action = './password_check.php?bo_table='.$bo_table.$sublink;
            $return_url = './board.php?bo_table='.$bo_table.$sublink;
        }
        break;
    case 'sc' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$sublink);
        else {
            $action = './password_check.php?bo_table='.$bo_table.$sublink;
            $return_url = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$sublink;
        }
        break;
    default :
        alert('w 값이 제대로 넘어오지 않았습니다.');
}

include_once(G5_PATH.'/head.sub.php');

//if ($board['bo_include_head']) { @include ($board['bo_include_head']); }
//if ($board['bo_content_head']) { echo stripslashes($board['bo_content_head']); }

/* 비밀글의 제목을 가져옴 지운아빠 2013-01-29 */
$sql = " select wr_subject from {$write_table}
                      where wr_num = '{$write['wr_num']}'
                      and wr_reply = ''
                      and wr_is_comment = 0 ";
$row = sql_fetch($sql);

$g5['title'] = $row['wr_subject'];

include_once($member_skin_path.'/password.skin.php');

//if ($board['bo_content_tail']) { echo stripslashes($board['bo_content_tail']); }
//if ($board['bo_include_tail']) { @include ($board['bo_include_tail']); }

include_once(G5_PATH.'/tail.sub.php');
?>

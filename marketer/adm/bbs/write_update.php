<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/naver_syndi.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$g5['title'] = '게시글 저장';

$msg = array();
/*
print_r2($_POST);
exit;
*/
$wr_subject = '';
if (isset($_POST['wr_subject'])) {
    $wr_subject = substr(trim($_POST['wr_subject']),0,255);
    $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
}
if ($wr_subject == '') {
    $msg[] = '<strong>제목</strong>을 입력하세요.';
}

$wr_content = '';
if (isset($_POST['wr_content'])) {
    //$wr_content = substr(trim($_POST['wr_content']),0,65536);
	$wr_content = trim($_POST['wr_content']);
	$wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}
//echo $wr_content;
//exit;

if ($wr_content == '') {
    //$msg[] = '<strong>내용</strong>을 입력하세요.';
}

/*
$wr_link1 = '';
if (isset($_POST['wr_link1'])) {
    $wr_link1 = substr($_POST['wr_link1'],0,1000);
    $wr_link1 = trim(strip_tags($wr_link1));
    $wr_link1 = preg_replace("#[\\\]+$#", "", $wr_link1);
}

$wr_link2 = '';
if (isset($_POST['wr_link2'])) {
    $wr_link2 = substr($_POST['wr_link2'],0,1000);
    $wr_link2 = trim(strip_tags($wr_link2));
    $wr_link2 = preg_replace("#[\\\]+$#", "", $wr_link2);
}
*/
for ($i=1; $i<=G5_LINK_COUNT; $i++) {
    $var = "wr_link$i";
    $$var = "";
	if (isset($_POST['wr_link'.$i])) {
		$$var = substr($_POST['wr_link'.$i],0,1000);
		$$var = trim(strip_tags($$var));
		$$var = preg_replace("#[\\\]+$#", "", $$var);
	}
}

$msg = implode('<br>', $msg);
if ($msg) {
    alert($msg);
}

// 090710
if (substr_count($wr_content, '&#') > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}

$upload_max_filesize = ini_get('upload_max_filesize');

if (empty($_POST)) {
    alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=".$upload_max_filesize."\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");
}

$notice_array = explode(",", $board['bo_notice']);

if ($w == 'u' || $w == 'r') {
    $wr = get_write($write_table, $wr_id);
    if (!$wr['wr_id']) {
        alert("글이 존재하지 않습니다.\\n글이 삭제되었거나 이동하였을 수 있습니다.");
    }
}

// 외부에서 글을 등록할 수 있는 버그가 존재하므로 비밀글은 사용일 경우에만 가능해야 함
if (!$is_admin && !$board['bo_use_secret'] && $secret) {
	alert('비밀글 미사용 게시판 이므로 비밀글로 등록할 수 없습니다.');
}

// 외부에서 글을 등록할 수 있는 버그가 존재하므로 비밀글 무조건 사용일때는 관리자를 제외(공지)하고 무조건 비밀글로 등록
if (!$is_admin && $board['bo_use_secret'] == 2) {
    $secret = 'secret';
}

$html = '';
if (isset($_POST['html']) && $_POST['html']) {
    $html = $_POST['html'];
}

$mail = '';
if (isset($_POST['mail']) && $_POST['mail']) {
    $mail = $_POST['mail'];
}

$notice = '';
if (isset($_POST['notice']) && $_POST['notice']) {
    $notice = $_POST['notice'];
}

for ($i=1; $i<=20; $i++) {
    $var = "wr_$i";
    $$var = "";
    if (isset($_POST['wr_'.$i]) && settype($_POST['wr_'.$i], 'string')) {
        $$var = trim($_POST['wr_'.$i]);
    }
}

@include_once($board_skin_path.'/write_update.head.skin.php');

$db_datetime = ($_POST['writeday'])?$_POST['writeday']:G5_TIME_YMDHIS;
$wr_hit = 0;


//상담신청인경우
if($bo_table=="mkestimate"){
    $secret = 'secret';

	$wr_5 = ($memberHp)?$memberHp:$memberHp1."-".$memberHp2."-".$memberHp3;
	$wr_8 = $memberEmail1."@".$memberEmail2;
}


if ($w == '' || $w == 'r') {

    if ($member['mb_id']) {
        $mb_id = $member['mb_id'];
        $wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_name']));
        $wr_password = $member['mb_password'];
        $wr_email = addslashes($member['mb_email']);
        $wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
    } else {
        $mb_id = '';
        // 비회원의 경우 이름이 누락되는 경우가 있음
        $wr_name = clean_xss_tags(trim($_POST['wr_name']));
        if (!$wr_name)
            alert('이름은 필히 입력하셔야 합니다.');
        $wr_password = sql_password($wr_password);
        $wr_email = get_email_address(trim($_POST['wr_email']));
        $wr_homepage = clean_xss_tags($wr_homepage);
    }

    if ($w == 'r') {
        // 답변의 원글이 비밀글이라면 비밀번호는 원글과 동일하게 넣는다.
        if ($secret)
            $wr_password = $wr['wr_password'];

        $wr_id = $wr_id . $reply;
        $wr_num = $write['wr_num'];
        $wr_reply = $reply;
    } else {
        $wr_num = get_next_num($write_table);
        $wr_reply = '';
    }

	$wr_name = ($_POST['writename'])? clean_xss_tags(trim($_POST['writename'])) : $wr_name;

    $sql = " insert into $write_table
                set wr_num = '$wr_num',
                     wr_reply = '$wr_reply',
                     wr_comment = 0,
                     ca_name = '$ca_name',
                     wr_option = '$html,$secret,$mail',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_seo_title = '$wr_seo_title',
                     wr_link1 = '$wr_link1',
                     wr_link2 = '$wr_link2',
                     wr_link1_hit = 0,
                     wr_link2_hit = 0,
                     wr_hit = 0,
                     wr_good = 0,
                     wr_nogood = 0,
                     mb_id = '{$member['mb_id']}',
                     wr_password = '$wr_password',
                     wr_name = '$wr_name',
                     wr_email = '$wr_email',
                     wr_homepage = '$wr_homepage',
                     wr_datetime = '$db_datetime',
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2',
                     wr_3 = '$wr_3',
                     wr_4 = '$wr_4',
                     wr_5 = '$wr_5',
                     wr_6 = '$wr_6',
                     wr_7 = '$wr_7',
                     wr_8 = '$wr_8',
                     wr_9 = '$wr_9',
                     wr_10 = '$wr_10', 
                     wr_11 = '$wr_11', 
                     wr_12 = '$wr_12', 
                     wr_13 = '$wr_13', 
                     wr_14 = '$wr_14', 
                     wr_15 = '$wr_15', 
                     wr_16 = '$wr_16', 
                     wr_17 = '$wr_17', 
                     wr_18 = '$wr_18', 
                     wr_19 = '$wr_19', 
                     wr_20 = '$wr_20' 
				";

	sql_query($sql);

    $wr_id = mysql_insert_id();


    // 부모 아이디에 UPDATE
    sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

    // 새글 INSERT
    sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

    // 게시글 1 증가
    sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");

    // 쓰기 포인트 부여
    if ($w == '') {
        if ($notice) {
            $bo_notice = $wr_id.($board['bo_notice'] ? ",".$board['bo_notice'] : '');
            sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");
        }

        insert_point($member['mb_id'], $board['bo_write_point'], "{$board['bo_subject']} {$wr_id} 글쓰기", $bo_table, $wr_id, '쓰기');
    } else {
        // 답변은 코멘트 포인트를 부여함
        // 답변 포인트가 많은 경우 코멘트 대신 답변을 하는 경우가 많음
        insert_point($member['mb_id'], $board['bo_comment_point'], "{$board['bo_subject']} {$wr_id} 글답변", $bo_table, $wr_id, '쓰기');
    }
}  else if ($w == 'u') {
    if (get_session('ss_bo_table') != $_POST['bo_table'] || get_session('ss_wr_id') != $_POST['wr_id']) {
        alert('올바른 방법으로 수정하여 주십시오.', 'board.php?bo_table='.$bo_table);
    }

    $return_url = 'board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;

    if ($is_admin == 'super') // 최고관리자 통과
        ;
    else if ($is_admin == 'group') { // 그룹관리자
        $mb = get_member($write['mb_id']);
        if ($member['mb_id'] != $group['gr_admin']) // 자신이 관리하는 그룹인가?
            alert('자신이 관리하는 그룹의 게시판이 아니므로 수정할 수 없습니다.', $return_url);
        else if ($member['mb_level'] < $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
            alert('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.', $return_url);
    } else if ($is_admin == 'board') { // 게시판관리자이면
        $mb = get_member($write['mb_id']);
        if ($member['mb_id'] != $board['bo_admin']) // 자신이 관리하는 게시판인가?
            alert('자신이 관리하는 게시판이 아니므로 수정할 수 없습니다.', $return_url);
        else if ($member['mb_level'] < $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
            alert('자신의 권한보다 높은 권한의 회원이 작성한 글은 수정할 수 없습니다.', $return_url);
    } else if ($member['mb_id']) {
        if ($member['mb_id'] != $write['mb_id'])
            alert('자신의 글이 아니므로 수정할 수 없습니다.', $return_url);
    } else {
        if ($write['mb_id'])
            alert('로그인 후 수정하세요.', './login.php?url='.urlencode($return_url));
    }

    if ($member['mb_id']) {
        // 자신의 글이라면
        if ($member['mb_id'] == $wr['mb_id']) {
            $mb_id = $member['mb_id'];
            $wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_name']));
            $wr_email = addslashes($member['mb_email']);
            $wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
        } else {
            $mb_id = $wr['mb_id'];
            if(isset($_POST['wr_name']) && $_POST['wr_name'])
                $wr_name = clean_xss_tags(trim($_POST['wr_name']));
            else
                $wr_name = addslashes(clean_xss_tags($wr['wr_name']));
            if(isset($_POST['wr_email']) && $_POST['wr_email'])
                $wr_email = get_email_address(trim($_POST['wr_email']));
            else
                $wr_email = addslashes($wr['wr_email']);
            if(isset($_POST['wr_homepage']) && $_POST['wr_homepage'])
                $wr_homepage = addslashes(clean_xss_tags($_POST['wr_homepage']));
            else
                $wr_homepage = addslashes(clean_xss_tags($wr['wr_homepage']));
        }
    } else {
        $mb_id = "";
        // 비회원의 경우 이름이 누락되는 경우가 있음
        if (!trim($wr_name)) alert("이름은 필히 입력하셔야 합니다.");
        $wr_name = clean_xss_tags(trim($_POST['wr_name']));
        $wr_email = get_email_address(trim($_POST['wr_email']));
    }

    $sql_password = $wr_password ? " , wr_password = '".sql_password($wr_password)."' " : "";

    $sql_ip = '';
    if (!$is_admin)
        $sql_ip = " , wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";


	$wr_name = ($_POST['writename'])? clean_xss_tags(trim($_POST['writename'])) : $wr_name;

    $sql = " update {$write_table}
                set ca_name = '{$ca_name}',
                     wr_option = '{$html},{$secret},{$mail}',
                     wr_subject = '{$wr_subject}',
                     wr_content = '{$wr_content}',
                     wr_seo_title = '$wr_seo_title',
                     wr_link1 = '$wr_link1',
                     wr_link2 = '$wr_link2',
                     mb_id = '{$mb_id}',
                     wr_name = '{$wr_name}',
                     wr_email = '{$wr_email}',
                     wr_homepage = '{$wr_homepage}',
	";

	$sql.= "		wr_datetime = '$db_datetime', ";
	
	$sql.= "
                     wr_1 = '{$wr_1}',
                     wr_2 = '{$wr_2}',
                     wr_3 = '{$wr_3}',
                     wr_4 = '{$wr_4}',
                     wr_5 = '{$wr_5}',
                     wr_6 = '{$wr_6}',
                     wr_7 = '{$wr_7}',
                     wr_8 = '{$wr_8}',
                     wr_9 = '{$wr_9}',
                     wr_10 = '{$wr_10}', 
                     wr_11 = '{$wr_11}', 
                     wr_12 = '{$wr_12}', 
                     wr_13 = '{$wr_13}', 
                     wr_14 = '{$wr_14}', 
                     wr_15 = '{$wr_15}', 
                     wr_16 = '{$wr_16}', 
                     wr_17 = '{$wr_17}', 
                     wr_18 = '{$wr_18}', 
                     wr_19 = '{$wr_19}', 
                     wr_20 = '{$wr_20}' 
                     {$sql_ip}
                     {$sql_password}
              where wr_id = '{$wr['wr_id']}' 
	";
	//echo $sql; exit;
	sql_query($sql);

    // 분류가 수정되는 경우 해당되는 코멘트의 분류명도 모두 수정함
    // 코멘트의 분류를 수정하지 않으면 검색이 제대로 되지 않음
    $sql = " update {$write_table} set ca_name = '{$ca_name}' where wr_parent = '{$wr['wr_id']}' ";
    sql_query($sql);

    /*
    if ($notice) {
        //if (!preg_match("/[^0-9]{0,1}{$wr_id}[\r]{0,1}/",$board['bo_notice']))
        if (!in_array((int)$wr_id, $notice_array)) {
            $bo_notice = $wr_id . ',' . $board['bo_notice'];
            sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");
        }
    } else {
        $bo_notice = '';
        for ($i=0; $i<count($notice_array); $i++)
            if ((int)$wr_id != (int)$notice_array[$i])
                $bo_notice .= $notice_array[$i] . ',';
        $bo_notice = trim($bo_notice);
        //$bo_notice = preg_replace("/^".$wr_id."[\n]?$/m", "", $board['bo_notice']);
        sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");
    }
    */

    $bo_notice = board_notice($board['bo_notice'], $wr_id, $notice);
    sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");
}

// 게시판그룹접근사용을 하지 않아야 하고 비회원 글읽기가 가능해야 하며 비밀글이 아니어야 합니다.
if (!$group['gr_use_access'] && $board['bo_read_level'] < 2 && !$secret) {
    naver_syndi_ping($bo_table, $wr_id);
}

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
    $upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';

    // 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
        $upload[$i]['del_check'] = true;

        $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
        @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
        // 썸네일삭제
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
            delete_board_thumbnail($bo_table, $row['bf_file']);
        }
    }
    else
        $upload[$i]['del_check'] = false;

    $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
    $filesize  = $_FILES['bf_file']['size'][$i];
    $filename  = $_FILES['bf_file']['name'][$i];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'][$i] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
            continue;
        }
        else if ($_FILES['bf_file']['error'][$i] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
            continue;
        }
    }

    if (is_uploaded_file($tmp_file)) {
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
            continue;
        }

        //=================================================================\
        // 090714
        // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
        // 에러메세지는 출력하지 않는다.
        //-----------------------------------------------------------------
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        //=================================================================

        $upload[$i]['image'] = $timg;

        // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
        if ($w == 'u') {
            // 존재하는 파일이 있다면 삭제합니다.
            $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
            @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
            // 이미지파일이면 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }
        }

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

        $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);
    }
}

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    if (!get_magic_quotes_gpc()) {
        $upload[$i]['source'] = addslashes($upload[$i]['source']);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = '{$bo_table}'
                                and wr_id = '{$wr_id}'
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = '{$bo_table}'
                                  and wr_id = '{$wr_id}'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$wr_id}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);
    }
}

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
}

// 파일의 개수를 게시물에 업데이트 한다.
$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");

// 자동저장된 레코드를 삭제한다.
sql_query(" delete from {$g5['autosave_table']} where as_uid = '{$uid}' ");
//------------------------------------------------------------------------------


//////////////////////////////////////////////////////////////////////////////////////
//마케터강의영상 강의자료 처리
//////////////////////////////////////////////////////////////////////////////////////
if($bo_table == 'marketer'){

	$g5['file_table'] = G5_TABLE_PREFIX.$bo_table.'_file'; // 게시판 첨부파일 테이블

	//등록된 파일을 제거 그후에 등록
	//get_marketer_file_delete($bo_table, $wr_id);

	// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
	@mkdir(G5_DATA_PATH.'/file/'.$bo_table.'_youtube', G5_DIR_PERMISSION);
	@chmod(G5_DATA_PATH.'/file/'.$bo_table.'_youtube', G5_DIR_PERMISSION);
	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

	// 가변 파일 업로드
	$file_upload_msg = '';
	$upload = array();
	$tmp_youtubelink ='';

	//강의영상 링크 정보 유무 파악용
	for ($i=0; $i<count($youtubelink); $i++) {
		$tmp_youtubelink .= $youtubelink[$i];
	}

	if((count($youtubelink) < 1) || (strlen($tmp_youtubelink) < 1)){
		//강의영상 링크 정보가 없는 경우에는 작동 금지
	}else{

		//for ($i=0; $i<count($_FILES['edu_file']['name']); $i++) {
		for ($i=0; $i<count($youtubelink); $i++) {//강의영상을 중심으로 변경
			$upload[$i]['file']     = '';
			$upload[$i]['source']   = '';
			$upload[$i]['filesize'] = 0;
			$upload[$i]['image']    = array();
			$upload[$i]['image'][0] = '';
			$upload[$i]['image'][1] = '';
			$upload[$i]['image'][2] = '';

			// 삭제에 체크가 되어있다면 파일을 삭제합니다.
			if (isset($_POST['edu_file_del'][$i]) && $_POST['edu_file_del'][$i]) {
				$upload[$i]['del_check'] = true;

				$row = sql_fetch(" select bf_file from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
				@unlink(G5_DATA_PATH.'/file/'.$bo_table.'_youtube'.'/'.$row['bf_file']);
				// 썸네일삭제
				if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
					delete_board_thumbnail($bo_table.'_youtube', $row['bf_file']);
				}
			}
			else
				$upload[$i]['del_check'] = false;


			if($_FILES['edu_file']['name'][$i]){ //첨부파일이 있다면

				$tmp_file  = $_FILES['edu_file']['tmp_name'][$i];
				$filesize  = $_FILES['edu_file']['size'][$i];
				$filename  = $_FILES['edu_file']['name'][$i];
				$filename  = get_safe_filename($filename);

				// 서버에 설정된 값보다 큰파일을 업로드 한다면
				if ($filename) {
					if ($_FILES['edu_file']['error'][$i] == 1) {
						$file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
						continue;
					}
					else if ($_FILES['edu_file']['error'][$i] != 0) {
						$file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
						continue;
					}
				}

				if (is_uploaded_file($tmp_file)) {
					// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
					if (!$is_admin && $filesize > $board['bo_upload_size']) {
						$file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
						continue;
					}

					//=================================================================\
					// 090714
					// 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
					// 에러메세지는 출력하지 않는다.
					//-----------------------------------------------------------------
					$timg = @getimagesize($tmp_file);
					// image type
					if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
						 preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
						if ($timg['2'] < 1 || $timg['2'] > 16)
							continue;
					}
					//=================================================================


					$upload[$i]['image'] = $timg;

					// 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
					if ($w == 'u') {
						// 존재하는 파일이 있다면 삭제합니다.
						$row = sql_fetch(" select bf_file from {$g5['file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
						@unlink(G5_DATA_PATH.'/file/'.$bo_table.'_youtube'.'/'.$row['bf_file']);
						// 이미지파일이면 썸네일삭제
						if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
							delete_board_thumbnail($bo_table.'_youtube', $row['bf_file']);
						}
					}

					// 프로그램 원래 파일명
					$upload[$i]['source'] = $filename;
					$upload[$i]['filesize'] = $filesize;

					// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
					$filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
					
					shuffle($chars_array);
					$shuffle = implode('', $chars_array);

					// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
					$upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));



					$dest_file = G5_DATA_PATH.'/file/'.$bo_table.'_youtube'.'/'.$upload[$i]['file'];
					

					// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
					$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['edu_file']['error'][$i]);

					// 올라간 파일의 퍼미션을 변경합니다.
					chmod($dest_file, G5_FILE_PERMISSION);
				}
			}
		}

		// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
		for ($i=0; $i<count($upload); $i++)
		{
			if (!get_magic_quotes_gpc()) {
				$upload[$i]['source'] = addslashes($upload[$i]['source']);
			}
			
			$row = sql_fetch(" select count(*) as cnt from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
			//echo $row['cnt']."<br>"; 
			if ($row['cnt'])
			{
				// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
				// 그렇지 않다면 내용만 업데이트 합니다.
				if ($upload[$i]['del_check'] || $upload[$i]['file'])
				{
					$sql = " update {$g5['file_table']}
								set bf_source = '{$upload[$i]['source']}',
									 bf_file = '{$upload[$i]['file']}',
									 bf_content = '{$bf_content[$i]}',
									 bf_filesize = '{$upload[$i]['filesize']}',
									 bf_width = '{$upload[$i]['image']['0']}',
									 bf_height = '{$upload[$i]['image']['1']}',
									 bf_type = '{$upload[$i]['image']['2']}',
									 bf_link = '{$youtubelink[$i]}',
									 bf_datetime = '".G5_TIME_YMDHIS."'
							  where bo_table = '{$bo_table}'
										and wr_id = '{$wr_id}'
										and bf_no = '{$i}' ";
					//echo $sql."<br>";
					sql_query($sql);
				}
				else
				{
					$sql = " update {$g5['file_table']}
								set bf_content = '{$bf_content[$i]}', bf_link = '{$youtubelink[$i]}'
								where bo_table = '{$bo_table}'
										  and wr_id = '{$wr_id}'
										  and bf_no = '{$i}' ";
					//echo $sql."<br>";
					sql_query($sql);
				}
			}
			else
			{
				$sql = " insert into {$g5['file_table']}
							set bo_table = '{$bo_table}',
								 wr_id = '{$wr_id}',
								 bf_no = '{$i}',
								 bf_source = '{$upload[$i]['source']}',
								 bf_file = '{$upload[$i]['file']}',
								 bf_content = '{$bf_content[$i]}',
								 bf_download = 0,
								 bf_filesize = '{$upload[$i]['filesize']}',
								 bf_width = '{$upload[$i]['image']['0']}',
								 bf_height = '{$upload[$i]['image']['1']}',
								 bf_type = '{$upload[$i]['image']['2']}',
								 bf_link = '{$youtubelink[$i]}',
								 bf_datetime = '".G5_TIME_YMDHIS."' ";
				
				//echo $sql."<br>";
				sql_query($sql);
			}
		}
	}
	
	// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
	// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
	$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
	{
		$row2 = sql_fetch(" select bf_file, bf_link from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

		// 정보가 있다면 빠집니다.
		if ($row2['bf_file']) break;
		if ($row2['bf_link']) break;

		// 그렇지 않다면 정보를 삭제합니다.
		echo " delete from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ";
		sql_query(" delete from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
	}

	
	// 파일의 개수를 게시물에 업데이트 한다.
	//$row = sql_fetch(" select count(*) as cnt from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
	//테이블명 변경
	//sql_query(" update g5_aw_data set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");

}
//////////////////////////////////////////////////////////////////////////////////////


// 비밀글이라면 세션에 비밀글의 아이디를 저장한다. 자신의 글은 다시 비밀번호를 묻지 않기 위함
if ($secret)
    set_session("ss_secret_{$bo_table}_{$wr_num}", TRUE);

// 메일발송 사용 (수정글은 발송하지 않음)
if (!($w == 'u' || $w == 'cu') && $config['cf_email_use'] && $board['bo_use_email']) {

    // 관리자의 정보를 얻고
    $super_admin = get_admin('super');
    $group_admin = get_admin('group');
    $board_admin = get_admin('board');

    $wr_subject = get_text(stripslashes($wr_subject));

    $tmp_html = 0;
    if (strstr($html, 'html1'))
        $tmp_html = 1;
    else if (strstr($html, 'html2'))
        $tmp_html = 2;

    $wr_content = conv_content(conv_unescape_nl($wr_content), $tmp_html);

    $warr = array( ''=>'입력', 'u'=>'수정', 'r'=>'답변', 'c'=>'코멘트', 'cu'=>'코멘트 수정' );
    $str = $warr[$w];

    $subject = '['.$config['cf_title'].'] '.$board['bo_subject'].' 게시판에 '.$str.'글이 올라왔습니다.';

    $link_url = 'board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;'.$qstr;

    include_once(G5_LIB_PATH.'/mailer.lib.php');

    ob_start();
    include_once ('./write_update_mail.php');
    $content = ob_get_contents();
    ob_end_clean();

    $array_email = array();
    // 게시판관리자에게 보내는 메일
    if ($config['cf_email_wr_board_admin']) $array_email[] = $board_admin['mb_email'];
    // 게시판그룹관리자에게 보내는 메일
    if ($config['cf_email_wr_group_admin']) $array_email[] = $group_admin['mb_email'];
    // 최고관리자에게 보내는 메일
    if ($config['cf_email_wr_super_admin']) $array_email[] = $super_admin['mb_email'];

    // 원글게시자에게 보내는 메일
    if ($config['cf_email_wr_write']) {
        if($w == '')
            $wr['wr_email'] = $wr_email;

        $array_email[] = $wr['wr_email'];
    }

    // 옵션에 메일받기가 체크되어 있고, 게시자의 메일이 있다면
    if (strstr($wr['wr_option'], 'mail') && $wr['wr_email'])
        $array_email[] = $wr['wr_email'];

    // 중복된 메일 주소는 제거
    $unique_email = array_unique($array_email);
    $unique_email = array_values($unique_email);
    for ($i=0; $i<count($unique_email); $i++) {
        mailer($wr_name, $wr_email, $unique_email[$i], $subject, $content, 1);
    }
}

// 사용자 코드 실행
$board_skin_url  = G5_MARKETER_ADMBBS_URL.'/bbs_form/'.$board['bo_skin'];
$board_skin_path = G5_MARKETER_ADMBBS_PATH.'/bbs_form/'.$board['bo_skin'];

@include_once($board_skin_path.'/write_update.skin.php');
@include_once($board_skin_path.'/write_update.tail.skin.php');

delete_cache_latest($bo_table);

if ($file_upload_msg)
    alert($file_upload_msg, 'board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr);
else
    goto_url('board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;'.$qstr);
?>

<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/qna_write.php');
    return;
}


//마케터는 질문하기를 할 수 없다.
if($member['ampmkey'] == 'Y'){
	alert('마케터는 질문을 할 수 없습니다.');
}
?>

<?php
////////////////////////////////////////////////////////////////////
//마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
include(G5_MARKETER_PATH.'/inc/_marketer_info.php');
?>

<?php
include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_header.php');
?>

<?php
$bo_table = 'qna';
if ($bo_table) {
    $board = get_board_db($bo_table, true);
    if (isset($board['bo_table']) && $board['bo_table']) {
        set_cookie("ck_bo_table", $board['bo_table'], 86400 * 1);
        $gr_id = $board['gr_id'];
        $write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

        if (isset($wr_id) && $wr_id) {
            $write = get_write($write_table, $wr_id);
        } else if (isset($wr_seo_title) && $wr_seo_title) {
            $write = get_content_by_field($write_table, 'bbs', 'wr_seo_title', generate_seo_title($wr_seo_title));
            if( isset($write['wr_id']) ){
                $wr_id = $write['wr_id'];
            }
        }
    }
    
    // 게시판에서 
    if (isset($board['bo_select_editor']) && $board['bo_select_editor']){
        $config['cf_editor'] = $board['bo_select_editor'];
    }
}


if (!$board['bo_table']) {
    alert('존재하지 않는 게시판입니다.', G5_URL);
}

if (!$bo_table) {
    alert("bo_table 값이 넘어오지 않았습니다.\\nwrite.php?bo_table=code 와 같은 방식으로 넘겨 주세요.", G5_URL);
}

check_device($board['bo_device']);

$notice_array = explode(',', trim($board['bo_notice']));

if (!($w == '' || $w == 'u' || $w == 'r')) {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

if ($w == 'u' || $w == 'r') {
    if ($write['wr_id']) {
        // 가변 변수로 $wr_1 .. $wr_10 까지 만든다.
        for ($i=1; $i<=10; $i++) {
            $vvar = "wr_".$i;
            $$vvar = $write['wr_'.$i];
        }
    } else {
        alert("글이 존재하지 않습니다.\\n삭제되었거나 이동된 경우입니다.", G5_URL);
    }
}

run_event('bbs_write', $board, $wr_id, $w);

if ($w == '') {
    if ($wr_id) {
        alert('글쓰기에는 \$wr_id 값을 사용하지 않습니다.', G5_BBS_URL.'/board.php?bo_table='.$bo_table);
    }

    if ($member['mb_level'] < $board['bo_write_level']) {
        if ($member['mb_id']) {
            alert('글을 쓸 권한이 없습니다.');
        } else {
            alert("글을 쓸 권한이 없습니다.\\n회원이시라면 로그인 후 이용해 보십시오.", G5_BBS_URL.'/login.php?'.$qstr.'&amp;url='.urlencode($_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table));
        }
    }

    // 음수도 true 인것을 왜 이제야 알았을까?
    if ($is_member) {
        $tmp_point = ($member['mb_point'] > 0) ? $member['mb_point'] : 0;
        if ($tmp_point + $board['bo_write_point'] < 0 && !$is_admin) {
            alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글쓰기('.number_format($board['bo_write_point']).')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글쓰기 해 주십시오.');
        }
    }

    $title_msg = '글쓰기';
} else if ($w == 'u') {
    // 김선용 1.00 : 글쓰기 권한과 수정은 별도로 처리되어야 함
    //if ($member['mb_level'] < $board['bo_write_level']) {
    if($member['mb_id'] && $write['mb_id'] === $member['mb_id']) {
        ;
    } else if ($member['mb_level'] < $board['bo_write_level']) {
        if ($member['mb_id']) {
            alert('글을 수정할 권한이 없습니다.');
        } else {
            alert('글을 수정할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL.'/login.php?'.$qstr.'&amp;url='.urlencode($_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table));
        }
    }

    $len = strlen($write['wr_reply']);
    if ($len < 0) $len = 0;
    $reply = substr($write['wr_reply'], 0, $len);

    // 원글만 구한다.
    $sql = " select count(*) as cnt from {$write_table}
                where wr_reply like '{$reply}%'
                and wr_id <> '{$write['wr_id']}'
                and wr_num = '{$write['wr_num']}'
                and wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    if ($row['cnt'] && !$is_admin)
        alert('이 글과 관련된 답변글이 존재하므로 수정 할 수 없습니다.\\n\\n답변글이 있는 원글은 수정할 수 없습니다.');

    // 코멘트 달린 원글의 수정 여부
    $sql = " select count(*) as cnt from {$write_table}
                where wr_parent = '{$wr_id}'
                and mb_id <> '{$member['mb_id']}'
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($board['bo_count_modify'] && $row['cnt'] >= $board['bo_count_modify'] && !$is_admin)
        alert('이 글과 관련된 댓글이 존재하므로 수정 할 수 없습니다.\\n\\n댓글이 '.$board['bo_count_modify'].'건 이상 달린 원글은 수정할 수 없습니다.');

    $title_msg = '글수정';
} else if ($w == 'r') {
    if ($member['mb_level'] < $board['bo_reply_level']) {
        if ($member['mb_id'])
            alert('글을 답변할 권한이 없습니다.');
        else
            alert('답변글을 작성할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL.'/login.php?'.$qstr.'&amp;url='.urlencode($_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table));
    }

    $tmp_point = isset($member['mb_point']) ? $member['mb_point'] : 0;
    if ($tmp_point + $board['bo_write_point'] < 0 && !$is_admin)
        alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글답변('.number_format($board['bo_comment_point']).')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글답변 해 주십시오.');

    //if (preg_match("/[^0-9]{0,1}{$wr_id}[\r]{0,1}/",$board['bo_notice']))
    if (in_array((int)$wr_id, $notice_array))
        alert('공지에는 답변 할 수 없습니다.');

    //----------
    // 4.06.13 : 비밀글을 타인이 열람할 수 있는 오류 수정 (헐랭이, 플록님께서 알려주셨습니다.)
    // 코멘트에는 원글의 답변이 불가하므로
    if ($write['wr_is_comment'])
        alert('정상적인 접근이 아닙니다.');

    // 비밀글인지를 검사
    if (strstr($write['wr_option'], 'secret')) {
        if ($write['mb_id']) {
            // 회원의 경우는 해당 글쓴 회원 및 관리자
            if (!($write['mb_id'] === $member['mb_id'] || $is_admin))
                alert('비밀글에는 자신 또는 관리자만 답변이 가능합니다.');
        } else {
            // 비회원의 경우는 비밀글에 답변이 불가함
            if (!$is_admin)
                alert('비회원의 비밀글에는 답변이 불가합니다.');
        }
    }
    //----------

    // 게시글 배열 참조
    $reply_array = &$write;

    // 최대 답변은 테이블에 잡아놓은 wr_reply 사이즈만큼만 가능합니다.
    if (strlen($reply_array['wr_reply']) == 10)
        alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 10단계 까지만 가능합니다.');

    $reply_len = strlen($reply_array['wr_reply']) + 1;
    if ($board['bo_reply_order']) {
        $begin_reply_char = 'A';
        $end_reply_char = 'Z';
        $reply_number = +1;
        $sql = " select MAX(SUBSTRING(wr_reply, {$reply_len}, 1)) as reply from {$write_table} where wr_num = '{$reply_array['wr_num']}' and SUBSTRING(wr_reply, {$reply_len}, 1) <> '' ";
    } else {
        $begin_reply_char = 'Z';
        $end_reply_char = 'A';
        $reply_number = -1;
        $sql = " select MIN(SUBSTRING(wr_reply, {$reply_len}, 1)) as reply from {$write_table} where wr_num = '{$reply_array['wr_num']}' and SUBSTRING(wr_reply, {$reply_len}, 1) <> '' ";
    }
    if ($reply_array['wr_reply']) $sql .= " and wr_reply like '{$reply_array['wr_reply']}%' ";
    $row = sql_fetch($sql);

    if (!$row['reply'])
        $reply_char = $begin_reply_char;
    else if ($row['reply'] == $end_reply_char) // A~Z은 26 입니다.
        alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.');
    else
        $reply_char = chr(ord($row['reply']) + $reply_number);

    $reply = $reply_array['wr_reply'] . $reply_char;

    $title_msg = '글답변';

    $write['wr_subject'] = 'Re: '.$write['wr_subject'];

	///////////////////////////////////////////////////////////////////////
	// AMPM 최초 글 등록 시에 노출 ID,이름도 같이 저장한다.
	// 담당자 변경 시에 노출 ID,이름을 변경하여 적용한다.
	///////////////////////////////////////////////////////////////////////
	if($write['wr_17']){
		$write['mb_id'] = $write['wr_17'];
		$write['wr_name'] = $write['wr_18'];
		$write['name'] = $write['wr_18'];
	}

}

// 그룹접근 가능
if (!empty($group['gr_use_access'])) {
    if ($is_guest) {
        alert("접근 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.", 'login.php?'.$qstr.'&amp;url='.urlencode($_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table));
    }

    if ($is_admin == 'super' || $group['gr_admin'] === $member['mb_id'] || $board['bo_admin'] === $member['mb_id']) {
        ; // 통과
    } else {
        // 그룹접근
        $sql = " select gr_id from {$g5['group_member_table']} where gr_id = '{$board['gr_id']}' and mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if (!$row['gr_id'])
            alert('접근 권한이 없으므로 글쓰기가 불가합니다.\\n\\n궁금하신 사항은 관리자에게 문의 바랍니다.');
    }
}

// 본인확인을 사용한다면
if ($config['cf_cert_use'] && !$is_admin) {
    // 인증된 회원만 가능
    if ($board['bo_use_cert'] != '' && $is_guest) {
        alert('이 게시판은 본인확인 하신 회원님만 글쓰기가 가능합니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', 'login.php?'.$qstr.'&amp;url='.urlencode($_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table));
    }

    if ($board['bo_use_cert'] == 'cert' && !$member['mb_certify']) {
        alert('이 게시판은 본인확인 하신 회원님만 글쓰기가 가능합니다.\\n\\n회원정보 수정에서 본인확인을 해주시기 바랍니다.', G5_URL);
    }

    if ($board['bo_use_cert'] == 'adult' && !$member['mb_adult']) {
        alert('이 게시판은 본인확인으로 성인인증 된 회원님만 글쓰기가 가능합니다.\\n\\n성인인데 글쓰기가 안된다면 회원정보 수정에서 본인확인을 다시 해주시기 바랍니다.', G5_URL);
    }

    if ($board['bo_use_cert'] == 'hp-cert' && $member['mb_certify'] != 'hp') {
        alert('이 게시판은 휴대폰 본인확인 하신 회원님만 글읽기가 가능합니다.\\n\\n회원정보 수정에서 휴대폰 본인확인을 해주시기 바랍니다.', G5_URL);
    }

    if ($board['bo_use_cert'] == 'hp-adult' && (!$member['mb_adult'] || $member['mb_certify'] != 'hp')) {
        alert('이 게시판은 휴대폰 본인확인으로 성인인증 된 회원님만 글읽기가 가능합니다.\\n\\n현재 성인인데 글읽기가 안된다면 회원정보 수정에서 휴대폰 본인확인을 다시 해주시기 바랍니다.', G5_URL);
    }
}

// 글자수 제한 설정값
if ($is_admin || $board['bo_use_dhtml_editor'])
{
    $write_min = $write_max = 0;
}
else
{
    $write_min = (int)$board['bo_write_min'];
    $write_max = (int)$board['bo_write_max'];
}

$g5['title'] = ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$title_msg;

$is_notice = false;
$notice_checked = '';
if ($is_admin && $w != 'r') {
    $is_notice = true;

    if ($w == 'u') {
        // 답변 수정시 공지 체크 없음
        if ($write['wr_reply']) {
            $is_notice = false;
        } else {
            if (in_array((int)$wr_id, $notice_array)) {
                $notice_checked = 'checked';
            }
        }
    }
}

$is_html = false;
if ($member['mb_level'] >= $board['bo_html_level'])
    $is_html = true;

$is_secret = $board['bo_use_secret'];

$is_mail = false;
if ($config['cf_email_use'] && $board['bo_use_email'])
    $is_mail = true;

$recv_email_checked = '';
if ($w == '' || strstr($write['wr_option'], 'mail'))
    $recv_email_checked = 'checked';

$is_name     = false;
$is_password = false;
$is_email    = false;
$is_homepage = false;
if ($is_guest || ($is_admin && $w == 'u' && $member['mb_id'] !== $write['mb_id'])) {
    $is_name = true;
    $is_password = true;
    $is_email = true;
    $is_homepage = true;
}

$is_category = false;
$category_option = '';
if ($board['bo_use_category']) {
    $ca_name = "";
    if (isset($write['ca_name']))
        $ca_name = $write['ca_name'];
    $category_option = get_category_option($bo_table, $ca_name);
    $is_category = true;
}

$is_link = false;
if ($member['mb_level'] >= $board['bo_link_level']) {
    $is_link = true;
}

$is_file = false;
if ($member['mb_level'] >= $board['bo_upload_level']) {
    $is_file = true;
}

$is_file_content = false;
if ($board['bo_use_file_content']) {
    $is_file_content = true;
}

$file_count = (int)$board['bo_upload_count'];

$name     = "";
$email    = "";
$homepage = "";
if ($w == "" || $w == "r") {
    if ($is_member) {
        if (isset($write['wr_name'])) {
            $name = get_text(cut_str(stripslashes($write['wr_name']),20));
        }
        $email = get_email_address($member['mb_email']);
        $homepage = get_text(stripslashes($member['mb_homepage']));
    }
}

$html_checked   = "";
$html_value     = "";
$secret_checked = "";

if ($w == '') {
    $password_required = 'required';
} else if ($w == 'u') {
    $password_required = '';

    if (!$is_admin) {
        if (!($is_member && $member['mb_id'] === $write['mb_id'])) {
            if (!check_password($wr_password, $write['wr_password'])) {
                $is_wrong = run_replace('invalid_password', false, 'write', $write);
                if(!$is_wrong) alert('비밀번호가 틀립니다.');
            }
        }
    }

    $name = get_text(cut_str(stripslashes($write['wr_name']),20));
    $email = get_email_address($write['wr_email']);
    $homepage = get_text(stripslashes($write['wr_homepage']));

    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
        $write['wr_link'.$i] = get_text($write['wr_link'.$i]);
        $link[$i] = $write['wr_link'.$i];
    }

    if (strstr($write['wr_option'], 'html1')) {
        $html_checked = 'checked';
        $html_value = 'html1';
    } else if (strstr($write['wr_option'], 'html2')) {
        $html_checked = 'checked';
        $html_value = 'html2';
    }

    if (strstr($write['wr_option'], 'secret')) {
        $secret_checked = 'checked';
    }

    $file = get_file($bo_table, $wr_id);
    if($file_count < $file['count']) {
        $file_count = $file['count'];
    }

    for($i=0;$i<$file_count;$i++){
        if(! isset($file[$i])) {
            $file[$i] = array('file'=>null, 'source'=>null, 'size'=>null);
        }
    }

} else if ($w == 'r') {
    if (strstr($write['wr_option'], 'secret')) {
        $is_secret = true;
        $secret_checked = 'checked';
    }

    $password_required = "required";

    for ($i=1; $i<=G5_LINK_COUNT; $i++) {
        $write['wr_link'.$i] = get_text($write['wr_link'.$i]);
    }
}

set_session('ss_bo_table', $bo_table);
set_session('ss_wr_id', $wr_id);

$subject = "";
if (isset($write['wr_subject'])) {
    $subject = str_replace("\"", "&#034;", get_text(cut_str($write['wr_subject'], 255), 0));
}

$content = '';
if ($w == '') {
    $content = html_purifier($board['bo_insert_content']);
} else if ($w == 'r') {
    if (!strstr($write['wr_option'], 'html')) {
        $content = "\n\n\n &gt; "
                 ."\n &gt; "
                 ."\n &gt; ".str_replace("\n", "\n> ", get_text($write['wr_content'], 0))
                 ."\n &gt; "
                 ."\n &gt; ";

    }
} else {
    $content = get_text($write['wr_content'], 0);
}

$upload_max_filesize = number_format($board['bo_upload_size']) . ' 바이트';

$width = $board['bo_table_width'];
if ($width <= 100)
    $width .= '%';
else
    $width .= 'px';

$captcha_html = '';
$captcha_js   = '';
$is_use_captcha = ((($board['bo_use_captcha'] && $w !== 'u') || $is_guest) && !$is_admin) ? 1 : 0;

if ($is_use_captcha) {
    $captcha_html = captcha_html();
    $captcha_js   = chk_captcha_js();
}

$is_dhtml_editor = false;
$is_dhtml_editor_use = false;
$editor_content_js = '';
if(!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)
    $is_dhtml_editor_use = true;

// 모바일에서는 G5_IS_MOBILE_DHTML_USE 설정에 따라 DHTML 에디터 적용
if ($config['cf_editor'] && $is_dhtml_editor_use && $board['bo_use_dhtml_editor'] && $member['mb_level'] >= $board['bo_html_level']) {
    $is_dhtml_editor = true;

    if ( $w == 'u' && (! $is_member || ! $is_admin || $write['mb_id'] !== $member['mb_id']) ){
        // kisa 취약점 제보 xss 필터 적용
        $content = get_text(html_purifier($write['wr_content']), 0);
    }

    if(is_file(G5_EDITOR_PATH.'/'.$config['cf_editor'].'/autosave.editor.js'))
        $editor_content_js = '<script src="'.G5_EDITOR_URL.'/'.$config['cf_editor'].'/autosave.editor.js"></script>'.PHP_EOL;
}
$editor_html = editor_html('wr_content', $content, $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js('wr_content', $is_dhtml_editor);
$editor_js .= chk_editor_js('wr_content', $is_dhtml_editor);

// 임시 저장된 글 수
$autosave_count = autosave_count($member['mb_id']);

$action_url = https_url(G5_MARKETER_BBS_DIR)."/write_update.php";

//카테고리 라디오 형태 변형을 위한 처리
if ($board['bo_use_category']) {
	$code_category = array();
	$arr_categories = explode("|", $board['bo_category_list']);
	for ($k=0; $k<count($arr_categories); $k++) {
		$code_category[$arr_categories[$k]] = $arr_categories[$k];
	}
}
?>

<!-- S: 컨텐츠 -->
<section id="content" class="sub5">
    <div class="wrap">
        <div class="title-tab">
            <div class="title-area">
				<h2>질문답변 글쓰기</h2>
            </div>
        </div>
        <div class="qna-write">
			<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
				<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
				<input type="hidden" name="w" value="<?php echo $w ?>">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
				<input type="hidden" name="sca" value="<?php echo $sca ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="spt" value="<?php echo $spt ?>">
				<input type="hidden" name="sst" value="<?php echo $sst ?>">
				<input type="hidden" name="sod" value="<?php echo $sod ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<input type="hidden" name="utm_member" value="<?php echo $utm_member ?>">


				<?php
				$option = '';
				$option_hidden = '';
				if ($is_notice || $is_html || $is_secret || $is_mail) {
					$option = '';
					if ($is_notice) {
						  $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
					}

					if ($is_html) {
						  if ($is_dhtml_editor) {
							 $option_hidden .= '<input type="hidden" value="html1" name="html">';
						  } else {
							 $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
						  }
					}

					if ($is_secret) {
						  if ($is_admin || $is_secret==1) {
							 $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
						  } else {
							 $option_hidden .= '<input type="hidden" name="secret" value="secret">';
						  }
					}

					if ($is_mail) {
						  $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
					}
				}

				echo $option_hidden;
				?>
      
				<div class="tbl_frm01 tbl_wrap">
					<table>
						<tbody>
							<!-- 카테고리 선택 -->
							<?php if ($is_category) { ?>
							<tr>
								<th scope="row"><label for="ca_name">카테고리 선택<strong class="sound_only">필수</strong></label></th>
								<td class="chk_category">
									<?=codeToHtml($code_category, $write['ca_name'], "rdo8", "ca_name")?>
									<!--
									<select name="ca_name" id="ca_name" required class="required" >
										<option value="">선택하세요</option>
										<?php echo $category_option ?>
									</select>
									-->
								</td>
							</tr>
							<?php } ?>

							<!-- 마케터 지정질문 -->
							<!-- 마케터 선택 -->
							<?php 
								//지정마케터 정보 여부 판단
								$mk = get_memberLoginInfo($utm_member); 
								
								if($mk['mb_id']){
									$mk_id    = $mk['mb_id'];
									$mk_url   = $mk['mk_url'];
									$mk_name  = $mk['name'];
									$mk_nick  = $mk['nick'];
								}
							?>
							<script>
								$(document).ready(function(){
							<?php
								if((isset($utm_member) && $utm_member != '')){
							?>
								$("#mk_appoint").css('visibility','visible');
								$("#cho-img").attr("src", "<?=$mk_url?>");
								$("#cho-name").html("<?=$mk_nick?>");
							<?php
								}else{
							?>
								$("#mk_appoint").css('display','none');
								$("#cho-img").attr("src", "<?=$write['wr_13']?>");
								$("#cho-name").html("<?=$write['wr_12']?>");
								
							<?php
								}
							?>
								});
							</script>

							<tr id="mk_appoint">
								<th>지정 마케터</th>
								<td>
									<div class="cho-mkt">
										<!-- 마케터 프로필 사진 -->
										<div class="cho-img"><img src="<?=G5_URL ?>/images/profile_ex.jpg" id="cho-img"></div>
										<!-- 이름 -->                           
										<div class="cho-info"><span id="cho-name">OOO</span>를 선택하셨습니다. 해당 마케터에게 답변을 받아보실 수 있습니다.</div>
									</div>
								</td>
							</tr>

							<tr>
								<th scope="row"><label for="wr_subject">제목<strong class="sound_only">필수</strong></label></th>
								<td>
									<div id="autosave_wrapper">
										<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255">
										<?php if ($is_member) { // 임시 저장된 글 기능 ?>
										<script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
										<button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
										<div id="autosave_pop">
											  <strong>임시 저장된 글 목록</strong>
											  <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
											  <ul></ul>
											  <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
										</div>
										<?php } ?>
									</div>
								</td>
							</tr>
					 
							<tr>
								<th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
								<td class="wr_content">

                                    <div></div>


									<?php if($write_min || $write_max) { ?>
									<!-- 최소/최대 글자 수 사용 시 -->
									<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
									<?php } ?>
									<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
									<?php if($write_min || $write_max) { ?>
									<!-- 최소/최대 글자 수 사용 시 -->
									<div id="char_count_wrap"><span id="char_count"></span>글자</div>
									<?php } ?>
								</td>
							</tr>
					 

							<!-- 첨부파일 -->
							<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
							<tr>
								<th scope="row">첨부파일<?// php echo $i+1 ?></th>
								<td>
									<input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
									<?php if ($is_file_content) { ?>
									<input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
									<?php } ?>
									<?php if($w == 'u' && $file[$i]['file']) { ?>
									<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>

							
							<input type="hidden" name="wr_1" id="wr_1" value="<?php echo $write['wr_1']; ?>">
							<input type="hidden" name="wr_2" id="wr_2" value="<?php echo $write['wr_2']; ?>">
							<input type="hidden" name="wr_3" id="wr_3" value="<?php echo $write['wr_3']; ?>">
							<input type="hidden" name="wr_4" id="wr_4" value="<?php echo $write['wr_4']; ?>">
							<input type="hidden" name="wr_5" id="wr_5" value="<?php echo $write['wr_5']; ?>">
							<input type="hidden" name="wr_6" id="wr_6" value="<?php echo $write['wr_6']; ?>">
							<input type="hidden" name="wr_7" id="wr_7" value="<?php echo $write['wr_7']; ?>">
							<input type="hidden" name="wr_8" id="wr_8" value="<?php echo $write['wr_8']; ?>">
							<input type="hidden" name="wr_9" id="wr_9" value="<?php echo $write['wr_9']; ?>">
							<input type="hidden" name="wr_10" id="wr_10" value="<?php echo $write['wr_10']; ?>">
							<input type="hidden" name="wr_11" id="wr_11" value="<?php echo ($write['wr_11'])?$write['wr_11']:$mk_id; ?>"><!-- 지정마케터ID -->
							<input type="hidden" name="wr_12" id="wr_12" value="<?php echo ($write['wr_12'])?$write['wr_12']:$mk_name; ?>"><!-- 지정마케터이름 -->
							<input type="hidden" name="wr_13" id="wr_13" value="<?php echo ($write['wr_13'])?$write['wr_13']:$mk_url; ?>"><!-- 지정마케터사진 -->
							<input type="hidden" name="wr_14" id="wr_14" value="<?php echo $write['wr_14']; ?>">
							<input type="hidden" name="wr_15" id="wr_15" value="<?php echo $write['wr_15']; ?>">
							<input type="hidden" name="wr_16" id="wr_16" value="<?php echo ($write['wr_16'])?$write['wr_16']:'N' ?>"><!-- 확인여부 -->
							<input type="hidden" name="wr_17" id="wr_17" value="<?php echo $write['wr_17']; ?>"><!-- 담당아이디(노출) -->
							<input type="hidden" name="wr_18" id="wr_18" value="<?php echo $write['wr_18']; ?>"><!-- 담당이름(노출) -->
							<input type="hidden" name="wr_19" id="wr_19" value="<?php echo ($write['wr_19'])?$write['wr_19']:'Y'; ?>"><!-- 개인게시물 노출여부 -->
							<input type="hidden" name="wr_20" id="wr_20" value="<?php echo $write['wr_20']; ?>">
					 
						   <?php if ($is_guest) { //자동등록방지  ?>
								<?php if ($is_name) { ?>
							<tr>
								<th scope="row">이름</th>
								<td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input half_input required" placeholder="이름"></td>
							</tr>
							<?php } ?>
						
								<?php if ($is_password) { ?>
							<tr>
								<th scope="row">비밀번호</th>
								<td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호"></td>
							</tr>
							<?php } ?>
							<tr>
							  <th scope="row">자동등록방지</th>
							  <td>
								 <?php echo $captcha_html ?>
							  </td>
						   </tr>
						   <?php } ?>
         
						</tbody>
					</table>
				</div>
      
				<div class="btn_confirm">
					<a href="/ae-<?=$utm_member?>/qna/" class="btn_cancel">취소</a>
					<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
				</div>
			</form>
        </div>
    </div>

	<script>
	<?php if($write_min || $write_max) { ?>
	// 글자수 제한
	var char_min = parseInt(<?php echo $write_min; ?>); // 최소
	var char_max = parseInt(<?php echo $write_max; ?>); // 최대
	check_byte("wr_content", "char_count");

	$(function() {
	$("#wr_content").on("keyup", function() {
		  check_byte("wr_content", "char_count");
	});
	});

	<?php } ?>
	function html_auto_br(obj)
	{
	if (obj.checked) {
		  result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		  if (result)
			 obj.value = "html2";
		  else
			 obj.value = "html1";
	}
	else
		  obj.value = "";
	}

	function fwrite_submit(f)
	{
	<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		  url: g5_bbs_url+"/ajax.filter.php",
		  type: "POST",
		  data: {
			 "subject": f.wr_subject.value,
			 "content": f.wr_content.value
		  },
		  dataType: "json",
		  async: false,
		  cache: false,
		  success: function(data, textStatus) {
			 subject = data.subject;
			 content = data.content;
		  }
	});

	if (subject) {
		  alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		  f.wr_subject.focus();
		  return false;
	}

	if (content) {
		  alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		  if (typeof(ed_wr_content) != "undefined")
			 ed_wr_content.returnFalse();
		  else
			 f.wr_content.focus();
		  return false;
	}

	if (document.getElementById("char_count")) {
		  if (char_min > 0 || char_max > 0) {
			 var cnt = parseInt(check_byte("wr_content", "char_count"));
			 if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			 }
			 else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			 }
		  }
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
	}
	</script>
	</section>

</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
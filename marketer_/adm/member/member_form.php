<?php
$sub_menu = "300400";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

auth_check($auth[$sub_menu], 'w');

$token = get_token();

if ($w == '')
{
    $required_mb_id = 'required';
    $required_mb_id_class = 'required alnum_';
    $required_mb_password = 'required';
    $sound_only = '<strong class="sound_only">필수</strong>';

    $mb['mb_mailling'] = 1;
    $mb['mb_open'] = 1;
    $mb['mb_level'] = $config['cf_register_level'];
    $html_title = '추가';
}
else if ($w == 'u')
{
    $mb = get_marketer($mb_id);
    if (!$mb['mb_id'])
        alert('존재하지 않는 사원 자료입니다.');

    $required_mb_id = 'readonly';
    $required_mb_password = '';
    $html_title = '소개';

    $mb['mb_email'] 		= get_text($mb['mb_email']);

    $mb['mb_email1'] 		= strstr($mb['mb_email'], '@', true);
    $mb['mb_email2'] 		= mb_substr(strstr($mb['mb_email'], '@'),1);
	//echo $mb['mb_email']." | ".$mb['mb_email1']." | " .$mb['mb_email2'];

    $mb['mb_tel'] 			= get_text($mb['mb_tel']);
    $mb['mb_hp'] 			= get_text($mb['mb_hp']);
    $mb['mb_1'] 			= get_text($mb['mb_1']);
    $mb['mb_2'] 			= get_text($mb['mb_2']);
    $mb['mb_3'] 			= get_text($mb['mb_3']);
    $mb['mb_4'] 			= get_text($mb['mb_4']);
    $mb['mb_5'] 			= get_text($mb['mb_5']);
    $mb['mb_6'] 			= get_text($mb['mb_6']);
    $mb['mb_7'] 			= get_text($mb['mb_7']);
    $mb['mb_8'] 			= get_text($mb['mb_8']);
    $mb['mb_9'] 			= get_text($mb['mb_9']);
    $mb['mb_10'] 			= get_text($mb['mb_10']);

	$mb_part = ($mb['mb_part'])?codeToName($code_part3, get_text($mb['mb_part'])):"";
	$mb_team = ($mb['mb_team'])?codeToName($code_team, get_text($mb['mb_team'])):"";
	$mb_post = ($mb['mb_post'])?codeToName($code_post, get_text($mb['mb_post'])):"";

	$photo_url = G5_INTRANET_URL.'/data/member_image/'.$mb['mb_id'];
	$mb_images = '<img src="'.$photo_url.'" width="50" height="70" alt=""> ';


	$mb_dir = substr($mb['mb_id'],0,2);
	$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
	if (file_exists($mk_file)) {
		$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';

		$mb_images = '<img src="'.$mk_url.'" width="50" height="70" alt=""> ';
	}

	/////////////////////////////////////////////////////////////////////////
	//마케터소개 테이블 정보 추출
	/////////////////////////////////////////////////////////////////////////
	$mkt = get_marketer_detail($mb_id);
    $mb['mb_license'] 			= get_text($mkt['mb_license']);
    $mb['mb_media'] 			= get_text($mkt['mb_media']);
    $mb['mb_sectors'] 			= get_text($mkt['mb_sectors']);
    $mb['mb_slogan'] 			= get_text($mkt['mb_slogan']);
    $mb['mb_profile'] 			= get_text($mkt['mb_profile']);
    $mb['mb_message'] 			= get_text($mkt['mb_message']);
    
	$mb['mb_kakaochat'] 		= get_text($mkt['mb_kakaochat']);

    $mb['mb_bloglink'] 			= get_text($mkt['mb_bloglink']);
    $mb['mb_facebooklink'] 		= get_text($mkt['mb_facebooklink']);
    $mb['mb_instagramlink'] 	= get_text($mkt['mb_instagramlink']);
    $mb['mb_youtubelink'] 		= get_text($mkt['mb_youtubelink']);

    $mb['mb_kakaoid'] 			= ($mb['mb_5'])?$mb['mb_5']:get_text($mkt['mb_kakaoid']);

	if (!$mkt['mb_id']) {
		$mk = '';
	}else{
		$mk = 'u';
	}

	$is_dhtml_editor = false;
	$is_dhtml_editor_use = false;
	$editor_content_js = '';
	if(!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)
		$is_dhtml_editor_use = true;

	// 모바일에서는 G5_IS_MOBILE_DHTML_USE 설정에 따라 DHTML 에디터 적용
	if ($config['cf_editor'] && $is_dhtml_editor_use && $board['bo_use_dhtml_editor'] && $member['mb_level'] >= $board['bo_html_level']) {
		$is_dhtml_editor = true;

		if(is_file(G5_EDITOR_PATH.'/'.$config['cf_editor'].'/autosave.editor.js'))
			$editor_content_js = '<script src="'.G5_EDITOR_URL.'/'.$config['cf_editor'].'/autosave.editor.js"></script>'.PHP_EOL;
	}

	$editor_mb_profile_html = editor_html('mb_profile', $mb['mb_profile']);
	$editor_mb_profile_js = '';
	$editor_mb_profile_js .= get_editor_js('mb_profile');
	//$editor_mb_profile_js .= chk_editor_js('mb_profile');

	$editor_mb_message_html = editor_html('mb_message', $mb['mb_message']);
	$editor_mb_message_js = '';
	$editor_mb_message_js .= get_editor_js('mb_message');
	//$editor_mb_message_js .= chk_editor_js('mb_message');
}
else
    alert('제대로 된 값이 넘어오지 않았습니다.');


if ($mb['mb_intercept_date']) $g5['title'] = "차단된 ";
else $g5['title'] .= "";
$g5['title'] .= '마케터 '.$html_title;

include_once(G5_MARKETER_ADMIN_PATH.'/admin.head.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>

<form name="fmember" id="fmember" action="./member_form_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="mk" value="<?php echo $mk ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<input type="hidden" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="mb_part">본부<?php echo $sound_only ?></label></th>
        <td><?php echo $mb_part ?></td>
        <th scope="row"><label for="mb_team">팀<?php echo $sound_only ?></label></th>
        <td><?php echo $mb_team ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_name">이름<?php echo $sound_only ?></label></th>
        <td><?php echo $mb['mb_name'] ?></td>
        <th scope="row"><label for="mb_2">영문이름<strong class="sound_only">필수</strong></label></th>
        <td><?php echo $mb['mb_2'] ?></td>
   </tr>
    <tr>
        <th scope="row"><label for="mb_level">사진</label></th>
        <td><?php echo $mb_images ?></td>
        <th scope="row"><label for="mb_email">E-mail<strong class="sound_only">필수</strong></label></th>
        <td><?php echo $mb['mb_email1'] ?>@<?php echo $mb['mb_email2'] ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_hp">휴대폰번호</label></th>
        <td><?php echo $mb['mb_hp'] ?></td>
        <th scope="row"><label for="mb_tel">전화번호</label></th>
        <td>02-6049-<?php echo $mb['mb_tel'] ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_kakaoid">카카오아이디</label></th>
        <td colspan="3"><input type="text" name="mb_kakaoid" value="<?php echo $mb['mb_kakaoid'] ?>" id="mb_kakaoid" class="frm_input" size="150"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_kakaochat">카카오 1:1 오픈채팅</label></th>
        <td colspan="3">https://open.kakao.com/o/<input type="text" name="mb_kakaochat" value="<?php echo $mb['mb_kakaochat'] ?>" id="mb_kakaochat" class="frm_input" size="50"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_img">마케터 이미지</label></th>
        <td colspan="3" class="pop">
            <?php echo help('마케터 소개에 사용될 이미지를 올려 주세요. 가로 X 세로 길이는 350 X 350 이 넘지 않는 사진을 사용하기 바랍니다.') ?>
            <button class="open-pop" onclick="popTemplate()">※제작가이드 확인</button>
            <input type="file" name="mb_img" id="mb_img">
            <?php
            $mb_dir = substr($mb['mb_id'],0,2);
            $mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
            if (file_exists($mk_file)) {
                $mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mb['mb_id'].'.jpg';
                echo '<img src="'.$mk_url.'" alt="" width="350">';
                echo '<input type="checkbox" id="del_mb_img" name="del_mb_img" value="1">삭제';
            }
            ?>
        </td>
    </tr>
    <?php
		if($mb['mb_license']){
			$arrLicense = explode('|',$mb['mb_license']);

			foreach($arrLicense as $key=>$val)  
			{
				unset($arrLicense[$key]);  

				$License_newKey = $val;  
				$arrLicense[$License_newKey] = $val;  
			  
				$i++;  
			}
		}
	?>
	<tr>
        <th scope="row"><label for="mb_license">취득 자격증</label></th>
        <td colspan="3"><?=codeToHtml($code_license2, $arrLicense, "chk2", "mb_license")?>
						<br><?php echo help("광고대행에 관련한 취득 자격증을 선택해주세요.") ?></td>
    </tr>
    <?php
		if($mb['mb_media']){
			$arrMedia = explode('|',$mb['mb_media']);

			foreach($arrMedia as $key=>$val)  
			{
				unset($arrMedia[$key]);  

				$Media_newKey = $val;  
				$arrMedia[$Media_newKey] = $val;  
			  
				$i++;  
			}
		}
	?>
    <tr>
        <th scope="row"><label for="mb_media">전문 매체</label></th>
        <td colspan="3"><?php echo help("본인의 전문적인 광고 마케팅을 선택해주세요.") ?><br><?=codeToHtml($code_media2, $arrMedia, "chk2", "mb_media")?></td>
    </tr>
    <?php
		if($mb['mb_sectors']){
			$arrSectors = explode('|',$mb['mb_sectors']);

			foreach($arrSectors as $key=>$val)  
			{
				unset($arrSectors[$key]);  

				$Sectors_newKey = $val;  
				$arrSectors[$Sectors_newKey] = $val;  
			  
				$i++;  
			}
		}
	?>
    <tr>
        <th scope="row"><label for="mb_sectors">전문 직종</label></th>
        <td colspan="3"><?php echo help("본인의 전문 직종을 꼭 3개만 선택해주세요.") ?><br><?=codeToHtml($code_sectors, $arrSectors, "chk2", "mb_sectors")?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_slogan">대표타이틀</label></th>
        <td colspan="3"><input type="text" name="mb_slogan" value="<?php echo $mb['mb_slogan'] ?>" id="mb_slogan" class="frm_input" maxlength="20" size="150">
						<br><?php echo help("예) 자신을 나타낼 수 있는 한마디를 띄어쓰기 포함 20자 이내로 기술해 주세요.") ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_profile">마케터 이력</label></th>
        <td colspan="3">
			<?php echo help("예) [업체명]네이버광고 및 캠페인 운영 19.05.20~진행중") ?>
			<?php echo $editor_mb_profile_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
		</td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_message">클라이언트에게 던지는 메시지</label></th>
        <td colspan="3">
			<?php echo help("예) 광고주에게 어필할 수 있는 자신의 장점 및 광고 운영 포부를 적어주세요.") ?>
			<?php echo $editor_mb_message_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
		</td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_bloglink">운영 블로그 주소</label></th>
        <td colspan="3"><input type="text" name="mb_bloglink" value="<?php echo $mb['mb_bloglink'] ?>" id="mb_bloglink" class="frm_input" size="150">
						<br><?php echo help("예) http:// 포함해서 운영 블로그 주소를 입력하세요.") ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_facebooklink">운영 페이스북 주소</label></th>
        <td colspan="3"><input type="text" name="mb_facebooklink" value="<?php echo $mb['mb_facebooklink'] ?>" id="mb_facebooklink" class="frm_input" size="150">
						<br><?php echo help("예) http:// 포함해서 운영 페이스북 주소를 입력하세요.") ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_instagramlink">운영 인스타그램 주소</label></th>
        <td colspan="3"><input type="text" name="mb_instagramlink" value="<?php echo $mb['mb_instagramlink'] ?>" id="mb_instagramlink" class="frm_input" size="150">
						<br><?php echo help("예) http:// 포함해서 운영 인스타그램 주소를 입력하세요.") ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_youtubelink">운영 유투브채널 주소</label></th>
        <td colspan="3"><input type="text" name="mb_youtubelink" value="<?php echo $mb['mb_youtubelink'] ?>" id="mb_youtubelink" class="frm_input" size="150">
						<br><?php echo help("예) http:// 포함해서 운영 유투브채널 주소를 입력하세요.") ?></td>
    </tr>

	</tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey='s'>
    <a href="./member_list.php?<?php echo $qstr ?>">목록</a>
</div>
</form>

<script>
//템플릿 팝업
function popTemplate()
{
	var w = 900;
	var h = 800;
	var url = "/marketer/inc/pop_template.php";
    var opt = 'width='+ w +', height='+ h +', resizable=yes, scrollbars=yes';

    window.open(url, "popTemplate", opt);
    return false;
}

//전문직종 체크 수 제한
function count_ck(obj){
	var chkbox = document.getElementsById("mb_sectors");
	var chkCnt = 0;

	for(var i=0;i<chkbox.length; i++){
		if(chkbox[i].checked){
			chkCnt++;
		}
	}

	if(chkCnt > 3){
		alert("check NO");
		obj.checked = false;
		return false;
	}
}
	
function fmember_submit(f)
{
	if (!f.mb_img.value.match(/\.jpg$/i) && f.mb_img.value) {
        alert('아이콘은 jpg 파일만 가능합니다.');
        return false;
    }
	
	var mb_sectors_chk=$("#mb_sectors:checked").length;
	if(mb_sectors_chk > 3){
        alert('전문직종 선택은 3개 까지만 가능합니다.');
        return false;
	}

	<?php echo $editor_mb_profile_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
	<?php echo $editor_mb_message_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    return true;
}
</script>

<?php
include_once(G5_MARKETER_ADMIN_PATH.'/admin.tail.php');
?>

<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_ADMBBS_URL.'/bbs_form/'.$board['bo_skin'].'/style.css">', 0);
?>

<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
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
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';

		$is_notice = false;
		if ($is_notice) {
            $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
        }

        $is_html = false;
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

        $is_mail = false;
		if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        
         
        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td colspan="5">
                <select name="ca_name" id="ca_name" required class="required" >
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>
    	
        <tr><th colspan="6" style="background:#ffffff; border:0px;"></th></tr>


        <?php $option = false; if ($option) { ?>
        <tr style="border-top:2px solid #fb501c;">
            <th scope="row">옵션</th>
            <td colspan="5"><?php echo $option ?></td>
        </tr>
        <?php } ?>
		
		<!--
        <tr>
            <th scope="row"><label for="wr_subject">제목<strong class="sound_only">필수</strong></label></th>
            <td colspan="5">
                <div id="autosave_wrapper">
                    <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255">
                </div>
            </td>
        </tr>
		-->
		<tr>
        	<?php $is_name=false;if ($is_name) { ?>
        	<th scope="row"><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
            <td colspan="2"><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
            <?php } ?>
            <?php $is_password=false;if ($is_password) { ?>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
            <td colspan="2"><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
            <?php } ?>
        </tr>
		<input type="hidden" name="wr_subject" id="wr_subject" class="frm_input" value="<?=$write['wr_subject']?>">
        <tr>
        	<th>업체명</th>
            <td colspan="5">
				<input type="text" name="wr_1" id="wr_1" class="frm_input" value="<?=$write['wr_1']?>">
			</td>
		</tr>
        <?php 
			if($write['wr_5']){

				$memberHp = explode('-',$write['wr_5']);

				$memberHp1 = $memberHp[0];
				$memberHp2 = $memberHp[1];
				$memberHp3 = $memberHp[2];
			}
		?>
        <tr>
        	<th>연락처</th>
            <td colspan="5">
				<select name="memberHp1" id="memberHp1"  required class="frm_input2 required">
					<?=codeToHtml($code_hp, $memberHp1, "cbo", "")?>
				</select> - 
				<input name="memberHp2" id="memberHp2" itemname="휴대전화2" required class="frm_input required" value="<?=$memberHp2?>" size="6" maxlength="4"> -
				<input name="memberHp3" id="memberHp3" itemname="휴대전화3" required class="frm_input required" value="<?=$memberHp3?>" size="6" maxlength="4">
			</td>
        </tr>
        <tr>
        	<th>월 예상 광고비</th>
            <td colspan="5">
				<select name="wr_2" id="wr_2" class="frm_input2">
				<?=codeToHtml($code_monthPrice, $write['wr_2'], "cbo", "")?>
				</select>
			</td>
		</tr>
        <tr>
        	<th>관심매체</th>
            <td colspan="5">
				<select name="wr_3" id="wr_3" class="frm_input2">
				<?=codeToHtml($code_selltype, $write['wr_3'], "cbo", "")?>
				</select>
			</td>
		</tr>

		<input type="hidden" name="wr_content" id="wr_content" class="frm_input" value="<?=($write['wr_content'])?$write['wr_content']:"-"?>">
        <tr>
        	<th>상담상태</th>
            <td colspan="5">
				<select name="wr_10" id="wr_10"  required class="frm_input2 required">
					<?=codeToHtml($state_code, $write['wr_10'], "cbo", "")?>
				</select>
			</td>
		</tr>
		<!--
        <tr>
        	<th>홈페이지</th>
            <td colspan="3"><input type="text" name=wr_7 id="wr_7" itemname="홈페이지" class="frm_input" value="<?=$write[wr_7]?>"></td>
		</tr>
        <tr>
            <th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
            <td colspan="3" class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>
		-->
		<!--
        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">링크 #<?php echo $i ?></label></th>
            <td colspan="3"><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input" size="50"></td>
        </tr>
        <?php } ?>
        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row">파일 #<?php echo $i+1 ?></th>
            <td colspan="3">
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
		-->

        <?php $is_guest=false;if ($is_guest) { //자동등록방지  ?>
        <tr>
            <th scope="row">자동등록방지</th>
            <td colspan="3">
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>

        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="./board.php?bo_table=<?php echo $bo_table ?><?=$sublink?>" class="btn_b02">목록</a>
    </div>
    </form>


<link type="text/css" href="<?php echo G5_JS_URL ?>/datepicker/jquery-ui.css" rel="stylesheet" />
<style type="text/css">
<!--
.ui-datepicker { font:12px dotum; }
.ui-datepicker select.ui-datepicker-month,
.ui-datepicker select.ui-datepicker-year { width: 70px;}
.ui-datepicker-trigger { margin:0 0 -5px 2px; }
-->
</style>
<script src="<?php echo G5_JS_URL ?>/datepicker/jquery.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/datepicker/jquery-ui.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/datepicker/jquery.dynDateTime.js"></script>
<script src="<?php echo G5_JS_URL ?>/datepicker/calendar-en.js"></script>
<script>
//-------------------------------------------------------------------------------------------------------------------------------
//	datepicker
//-------------------------------------------------------------------------------------------------------------------------------
$(function() {
	//$("#wr_1").datepicker({dateFormat: 'yy-mm-dd'});
})
</script>

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

	function doSearch(value) {
		location.href="<?=G5_BBS_URL?>/write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&w=<?=$w?>&course=" + value + "&sub_path1=" + value;
	}
	

	function doChange(){
		var course   = $("select[name='wr_6'] option:selected").val();

		$.ajax({
			type : "POST",
			url  : "coursechange.php",
			data : "course="+course,
			success : function(html){
				$("#courseval").html(html);
			}
		});

	}


	function comChange(val){
		var companyName   = $("select[name='companyName'] option:selected").val();

		$.ajax({
			type : "POST",
			url  : "<?=G5_URL?>/inc/req_model.php",
			data : "companyName="+companyName,
			success : function(html){
				$("#search_model").html(html);
			}
		});
	}
	
	</script>

</section>
<!-- } 게시물 작성/수정 끝 -->
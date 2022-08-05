<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<section id="bo_w">
    <h2 id="wrapper_title"><?php echo $g5['title'] ?></h2>

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
        <?php if ($is_name) { ?>
        <tr>
            <th scope="row"><label for="wr_name">이름<strong class="sound_only"> 필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_password) { ?>
        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only"> 필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" size="50" maxlength="100"></td>
        </tr>
        <?php } ?>

        <?php if ($is_homepage) { ?>
        <tr>
            <th scope="row"><label for="wr_homepage">홈페이지</label></th>
            <td><input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input" size="50"></td>
        </tr>
        <?php } ?>

        <?php if ($option) { ?>
        <tr>
            <th scope="row">옵션</th>
            <td><?php echo $option ?></td>
        </tr>
        <?php } ?>

        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td>
                <select name="ca_name" id="ca_name" required class="required" >
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <th scope="row"><label for="wr_subject">사원명<strong class="sound_only">필수</strong></label></th>
            <td>
                <div id="autosave_wrapper">
                    <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255">
                </div>
            </td>
        </tr>
<input type="hidden" name="wr_1" id="wr_1" value="<?php echo $write['wr_1'] ?>"><!--사원아이디-->
<input type="hidden" name="wr_8" id="wr_8" value="<?php echo $write['wr_8'] ?>"><!--본부정보-->
<input type="hidden" name="wr_9" id="wr_9" value="<?php echo $write['wr_9'] ?>"><!--팀정보-->

		<tr>
			<th scope="row"><label for="wr_2">퇴사여부</label></th>
			<td>
				<select name="wr_2" id="wr_2">
					<option value=""> :: 선택 :: </option>
					<?=codeToHtml($code_leaveYn, ($write['wr_2'])?$write['wr_2']:'N', "cbo", "")?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_3">취득자격증</label></th>
			<td><input type="text" name="wr_3" value="<?php echo $write['wr_3'] ?>" id="wr_3" class="frm_input" size="100">예) 여러 개인 경우 구분자 '/' 로 구분 검색광고마케터 1급,구글 애널틱리스,페이스북 FCBP</td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_5">연락처</label></th>
			<td><input type="text" name="wr_5" value="<?php echo $write['wr_5'] ?>" id="wr_5" class="frm_input" size="100"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_6">이메일</label></th>
			<td><input type="text" name="wr_6" value="<?php echo $write['wr_6'] ?>" id="wr_6" class="frm_input" size="100"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_7">카톡아이디</label></th>
			<td><input type="text" name="wr_7" value="<?php echo $write['wr_7'] ?>" id="wr_7" class="frm_input" size="100"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_11">광고주에게 한마디</label></th>
			<td><input type="text" name="wr_11" value="<?php echo $write['wr_11'] ?>" id="wr_11" class="frm_input" size="255"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_12">자신의 대표 타이틀</label></th>
			<td><input type="text" name="wr_12" value="<?php echo $write['wr_12'] ?>" id="wr_12" class="frm_input" size="255"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_13">자신있는, 하고싶은 광고 직종</label></th>
			<td><input type="text" name="wr_13" value="<?php echo $write['wr_13'] ?>" id="wr_13" class="frm_input" size="255"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_14">할 수 있는 광고 종류</label></th>
			<td><input type="text" name="wr_14" value="<?php echo $write['wr_14'] ?>" id="wr_14" class="frm_input" size="255"></td>
		</tr>
		<tr>
			<th scope="row"><label for="wr_15">집행해본 업체 3곳</label></th>
			<td><input type="text" name="wr_15" value="<?php echo $write['wr_15'] ?>" id="wr_15" class="frm_input" size="255"></td>
		</tr>

        <tr>
            <th scope="row"><label for="wr_content">마케터소개<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php $write['content'] = ($write['content'])?$write['content']:'-'; echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>

        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row"><label for="wr_link<?php echo $i ?>">마케터소개영상 #<?php echo $i ?></label></th>
            <td><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input" size="50"></td>
        </tr>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <tr>
            <th scope="row">썸네일 #<?php echo $i+1 ?></th>
            <td>
                <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

        <?php if ($is_guest) { //자동등록방지  ?>
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


  			<section>
                <div class="form-group row">
                    <label for="inputEmail3MD" class="col-sm-12 col-form-label">
                        <h3>강의자료</h3>
                    </label>
                </div>
				<div class="adlist">
 				<button class="fwzadd btn btn-dark" value="youtubeTable">+</button> <button class="fwzdel btn btn-dark" value="youtubeTable">-</button>
				<table id="youtubeTable">
                    <thead>
                        <tr>
                            <th>유튜브주소</th>
                            <th>강의자료</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
						$sql = " SELECT *
								 FROM g5_marketer_file c
								 WHERE 1
								 AND bo_table = '$bo_table' 
								 AND wr_id = '$wr_id'
								 ORDER BY bf_no
						";
						$result = sql_query($sql);
						$icnt = 0;
						for ($k=0; $row=sql_fetch_array($result); $k++) {
							$no = $row['bf_no'];
							$bf_content = $row['bf_content'] ? html_purifier($row['bf_content']) : '';
							$yfile[$no]['href'] = G5_URL."/inc/file_download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
							$yfile[$no]['download'] = $row['bf_download'];
							// 4.00.11 - 파일 path 추가
							$yfile[$no]['path'] = G5_DATA_URL.'/file/'.$bo_table.'_youtube';
							$yfile[$no]['size'] = get_filesize($row['bf_filesize']);
							$yfile[$no]['datetime'] = $row['bf_datetime'];
							$yfile[$no]['source'] = addslashes($row['bf_source']);
							$yfile[$no]['bf_content'] = $bf_content;
							$yfile[$no]['content'] = get_text($bf_content);
							//$yfile[$no]['view'] = view_file_link($row['bf_file'], $yfile[$no]['content']);
							$yfile[$no]['view'] = view_marketer_file_link($row['bf_file'], $row['bf_width'], $row['bf_height'], $yfile[$no]['content']);
							$yfile[$no]['file'] = $row['bf_file'];
							$yfile[$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
							$yfile[$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
							$yfile[$no]['image_type'] = $row['bf_type'];
							$yfile[$no]['bf_link'] = $row['bf_link'];
							$yfile['count']++;
					?>
						<tr>
                            <td><input type="text" name="youtubelink[]" value="<?php echo $yfile[$k]['bf_link'] ?>" id="youtubelink<?=$k?>" class="frm_input" size="100" placeholder="유튜브주소"></td>
                            <td><input type="file" name="edu_file[]" value="" class="frm_file frm_input" placeholder="강의자료">
								<?php if($w == 'u' && $yfile[$k]['file']) { ?>
								<input type="checkbox" id="edu_file_del<?php echo $k ?>" name="edu_file_del[<?php echo $k;  ?>]" value="1"> <label for="edu_file_del<?php echo $k ?>"><?php echo $yfile[$k]['source'].'('.$yfile[$k]['size'].')';  ?> 파일 삭제</label>
								<?php } ?>
							</td>
                        </tr>
					<?php
							$icnt++;
						}

						if ($icnt == 0){
							$k = 0;
					?>
						<tr>
                            <td><input type="text" name="youtubelink[]" value="<?php echo $youtube ?>" id="youtubelink<?=$k?>" class="frm_input" size="100" placeholder="유튜브주소"></td>
                            <td><input type="file" name="edu_file[]" value=""  class="frm_file frm_input" placeholder="강의자료"></td>
                        </tr>
					<?php
					}
					?>
					</tbody>
                </table>
                </div>
           </section>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">목록</a>
    </div>
    </form>

	<script>
	$(document).ready(function(){
		function successCall(){
			alert("전송성공");
		}

		function errorCall(){
			alert("전송실패");
		}

		$("#wr_subject").autocomplete({
			source:function(request, response) {
				$.ajax({
					url: "/inc/_ajax_intranet_memberList.php",
					type: 'post',
					dataType: "json",
					//data:dataString,
					data: 'searchword='+request.term,
					success: function( data ) {
						//alert(request.term);
						
						response(
							$.map(data, function(item) {
								return { 
									label: item.lavel_name,
									value: item.mb_name,

									mb_id: item.mb_id,
									mb_name: item.mb_name,
									mb_part_code: item.mb_part_code,
									mb_part_name: item.mb_part_name,
									mb_team_code: item.mb_team_code,
									mb_team_name: item.mb_team_name,

									mb_post_code: item.mb_post_code,
									mb_post_name: item.mb_post_name,

									mb_partownner_id: item.mb_partownner_id,
									mb_partownner_name: item.mb_partownner_name,
									mb_teamownner_id: item.mb_teamownner_id,
									mb_teamownner_name: item.mb_teamownner_name,
									
									mb_images: item.mb_images,
									mb_datetime: item.mb_datetime,
									
									mb_tel: item.mb_tel,
									mb_hp: item.mb_hp,
									mb_email: item.mb_email,
									mb_5: item.mb_5,
									mb_profile: item.mb_profile,

									mb_11: item.mb_11,
									mb_12: item.mb_12,
									mb_13: item.mb_13,
									mb_14: item.mb_14,
									mb_15: item.mb_15,

									license_name: item.license_name
								}
							})//map
						)//response
					},
					error   : errorCall
				});
			},
			minLength:1, /*최소 검색 글자수*/
			select: function( event, ui ) {
				// 만약 검색리스트에서 선택하였을때 선택한 데이터에 의한 이벤트발생
				
				//console.log(ui.item);
				dataList(ui.item);
				return false;
				//event.preventDefault();
			}
		});

		function dataList( item ) {
			m_id        = item.mb_id;
			m_name      = item.mb_name;
			m_part_code = item.mb_part_code;
			m_part_name = item.mb_part_name;
			m_team_code = item.mb_team_code;
			m_team_name = item.mb_team_name;

			m_post_code = item.mb_post_code;
			m_post_name = item.mb_post_name;

			m_partownner_id   = item.mb_partownner_id;
			m_partownner_name = item.mb_partownner_name;
			m_teamownner_id   = item.mb_teamownner_id;
			m_teamownner_name = item.mb_teamownner_name;

			m_images = item.mb_images;
			m_datetime = item.mb_datetime;

			m_tel = item.mb_tel;
			m_hp = item.mb_hp;
			m_email = item.mb_email;

			m_kakao = item.mb_5;
			m_profile = item.mb_profile;

			m_11 = item.mb_11;
			m_12 = item.mb_12;
			m_13 = item.mb_13;
			m_14 = item.mb_14;
			m_15 = item.mb_15;

			license_name = item.license_name;

			console.log(m_kakao); 
			console.log(license_name); 

			$("#wr_subject").val(m_name);
			$("#wr_1").val(m_id);
			$("#wr_8").val(m_part_name);
			$("#wr_9").val(m_team_name);
			$("#wr_3").val(license_name);
			$("#wr_5").val(m_tel);
			$("#wr_6").val(m_email);
			$("#wr_7").val(m_kakao);

			$("#wr_11").val(m_11);
			$("#wr_12").val(m_12);
			$("#wr_13").val(m_13);
			$("#wr_14").val(m_14);
			$("#wr_15").val(m_15);

			
			$("#wr_content").val(m_profile);

		}
	
		$(document).on("click",'.fwzadd', function(e) {
			var id = $(e.target).attr('id');
			var value = $(e.target).attr('value');
			e.preventDefault();
			rowAdd(value);
		});

		$(document).on("click",'.fwzdel', function(e) {
			var id = $(e.target).attr('id');
			var value = $(e.target).attr('value');
			e.preventDefault();
			rowDel(value);
		});
	

		function rowAdd(){
			var flen = $("#youtubeTable tr").length;
			var appendHtml  = "";

			if (flen < 16){
				//searhTable
				var appendHtml  = "";

					appendHtml	+= "		<tr> ";
					appendHtml	+= "	        <td><input type='text' name='youtubelink[]' value='' id='youtubelink"+flen+"' class='frm_input' size='100' placeholder='유튜브주소'></td> ";
					appendHtml	+= "	        <td><input type='file' name='edu_file[]' value='' id='edu_file"+flen+"' class='frm_file frm_input' placeholder='강의자료'></td> ";
					appendHtml	+= "	    </tr> ";

				$("#youtubeTable > tbody:last").append(appendHtml);
			}
		}

		function rowDel(){
			var flen = $("#youtubeTable tbody>tr").length;

			if (flen > 1){
				$("#youtubeTable > tbody > tr:last").remove();
			}else{
				alert("1개는 남겨 놓자");
				//return false;
			}
		}
	
	});
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
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->
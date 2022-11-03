<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include(CDC_PATH . '/cdc_cdn_include.php');
?>

<?php
//카테고리 라디오 형태 변형을 위한 처리
if ($board['bo_use_category']) {
	$code_category = array();
	$arr_categories = explode("|", $board['bo_category_list']);
	for ($k=0; $k<count($arr_categories); $k++) {
		$code_category[$arr_categories[$k]] = $arr_categories[$k];
	}
}
?>

<h2 id="container_title"><?php echo $board['bo_subject'] ?> 글쓰기</h2>

<div id="q-app">
	<section id="bo_w" v-if="form">
		<!-- 게시물 작성/수정 시작 { -->
		<q-form name="fwrite" 
				ref="form" id="fwrite" action="<?php echo $action_url ?>" 
				@submit.prevent="formSave"
				@validation-error="validationError"
				method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
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
					<!-- 노출매체(추가매체) -->
					<tr>
						<th><label for="">추가배포매체</label></th>
						<td class="row">
							<div class="q-gutter-sm justify-start col-4">
								<q-checkbox size="xs" v-model="form.cdc.is_blog" name="is_blog" true-value="Y" false-value="N" label="블로그" />
								<q-checkbox size="xs" v-model="form.cdc.is_insta" name="is_insta" true-value="Y" false-value="N" label="인스타" />
								<q-checkbox size="xs" v-model="form.cdc.is_youtube" name="is_youtube" true-value="Y" false-value="N" label="유튜브" />
							</div>
						</td>
					</tr>
					<!-- 카테고리 선택 -->
					<tr v-if="is_category">
						<th scope="row"><label for="ca_name">카테고리 선택<strong class="sound_only">필수</strong></label></th>
						<td class="chk_category">
							<!-- 카테고리 : CDC_JS_URL/categoryComponents.js -->

							<category v-model="form.ca_name" :opts="code_category" required></category>
						</td>
					</tr>

					<!-- 제목 및 임시 저장된 글 -->
					<tr>
						<!-- 제목 -->
						<th scope="row">
							<span style="color: red;" v-if="required.indexOf('wr_subject') != -1"> * </span>
							<label for="wr_subject">제목<strong class="sound_only">필수</strong></label>
						</th>
						<td>
							<div id="autosave_wrapper">
								<!-- <input type="text" name="wr_subject" v-model="form.wr_subject" id="wr_subject" required class="frm_input required" size="50" maxlength="255"> -->
								<div class="row items-start">
								<div>
									<q-input outlined class="q-input" type="text" name="wr_subject" v-model="form.wr_subject" id="wr_subject" :lazy-rules="true" :rules="mandatory('wr_subject', '제목')" size="50" maxlength="255" :dense="true">
								</div>

								<!-- 임시 저장된 글  -->
								<div style="display: inline;" v-if="<?php $is_member ?>">
									<!--  -->
									<q-btn class="q-ml-sm" size="md" color="black" id="btn_autosave" @click="isAutoSaveOpen = true" :label="`임시 저장된 글(${skinSaveList.length})`"></q-btn>
									<div id="autosave_pop" v-if="isAutoSaveOpen" style="display: block;">
										<!-- 임시 저장된 글 기능  -->
										<strong>임시 저장된 글 목록</strong>
										<div><button type="button" class="autosave_close" @click="isAutoSaveOpen = false"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
										<ul v-for="index in skinSaveList.length" :key="index">
											<li>
											<a href="#none" class="autosave_load" @click="autosave_load(skinSaveList[index - 1])">
												{{skinSaveList[index - 1].wr_subject}}
											</a>
											<span>
												{{skinSaveList[index - 1].date}}
												<button type="button" class="autosave_del" @click="autosave_remove(index - 1)">삭제</button>
											</span>
											</li>
										</ul>
										<div><button type="button" class="autosave_close" @click="isAutoSaveOpen = false"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
									</div>
								</div>

								</div>
							</div>
						</td>
					</tr>
                    <!-- // 제목 및 임시 저장된 글 -->
				
					<!-- 유튜브 동영상 링크주소 -->
					<tr>
						<th scope="row">
							<span style="color: red;" v-if="required.indexOf('wr_5') != -1"> * </span>
							<label for="wr_5">영상주소</label>
						</th>
						<td>
							<div class="row items-start">
								<q-input outlined class="q-input" type="text" name="wr_5" v-model="form.wr_5" id="wr_5" class="frm_input" size="50" :dense="true" :rules="mandatory('wr_5', '영상링크')" :lazy-rules="true" placeholder="내용에 출력되는 영상 링크입니다." />
							</div>
							<br />
							Youtube, Vimeo 동영상 공유 링크를 입력하세요. (썸네일은 자동생성 됩니다.)
						</td>
					</tr>

					<tr>
						<th scope="row">
							<span style="color: red;" v-if="required.indexOf('wr_content') != -1"> * </span>
							<label for="wr_content">영상설명
								<strong class="sound_only">필수</strong>
							</label>
                        </th>
						<td class="wr_content">
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

					<!-- 링크 -->
					<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
					<tr>
						<th scope="row"><label for="wr_link<?php echo $i ?>">출처링크<?// php echo $i ?></label></th>
						<td><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input" size="50"></td>
					</tr>
					<?php } ?>

					<!-- 첨부파일 -->
					<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
					<tr>
						<th scope="row">관련자료 <?// php echo $i+1 ?></th>
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

					<input type="hidden" name="wr_6" id="wr_6" value="<?php echo $write['wr_6']; ?>">
					<input type="hidden" name="wr_7" id="wr_7" value="<?php echo $write['wr_7']; ?>">
					<input type="hidden" name="wr_8" id="wr_8" value="<?php echo $write['wr_8']; ?>">
					<input type="hidden" name="wr_9" id="wr_9" value="<?php echo $write['wr_9']; ?>"><!-- 업체구분 -->
					<input type="hidden" name="wr_10" id="wr_10" value="<?php echo $write['wr_10']; ?>">
					<input type="hidden" name="wr_11" id="wr_11" value="<?php echo $write['wr_11']; ?>">
					<input type="hidden" name="wr_12" id="wr_12" value="<?php echo $write['wr_12']; ?>">
					<input type="hidden" name="wr_13" id="wr_13" value="<?php echo $write['wr_13']; ?>">
					<input type="hidden" name="wr_14" id="wr_14" value="<?php echo $write['wr_14']; ?>">
					<input type="hidden" name="wr_15" id="wr_15" value="<?php echo $write['wr_15']; ?>">
					<input type="hidden" name="wr_16" id="wr_16" value="<?php echo ($write['wr_16'])?$write['wr_16']:'N' ?>"><!-- 확인여부 -->
					<input type="hidden" name="wr_17" id="wr_17" value="<?php echo $write['wr_17']; ?>"><!-- 담당아이디(노출) -->
					<input type="hidden" name="wr_18" id="wr_18" value="<?php echo $write['wr_18']; ?>"><!-- 담당이름(노출) -->

					<input type="hidden" name="wr_20" id="wr_20" value="<?php echo $write['wr_20']; ?>">

					<tr>
						<th scope="row"><label for="wr_19">게시물 숨김 여부<strong class="sound_only">필수</strong></label></th>
						<td>
							<select name="wr_19" id="wr_19" required class="required" >
								<?=codeToHtml($code_hide, $write['wr_19'], "cbo", "")?>
							</select>
						</td>
					</tr>

					<?php include_once(CDC_PATH . '/cdcWriteForm.php'); ?>

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

			<div class="btn_confirm">
				<a href="./board.php?bo_table=<?php echo $bo_table ?><?=$sublink?>" class="btn btn_cancel">취소</a>
				<a href="#" @click="autoSave" class="btn btn_b02">임시등록</a>
				<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn btn_submit">
			</div>
		</q-form>

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
		<!-- CDC Write 폼 Control include -->
		<?php include(CDC_PATH . "/cdcWriteFormSetting.php"); ?>
        <!-- } 게시물 작성/수정 끝 -->
	</section>
	<!-- // q-app -->
</div>
<!-- CDC Write Config include -->
<?php include_once(CDC_PATH . "/setConfig.php"); ?>

<!-- 우측 side 영역 -->
<?php include(G5_PATH . '/inc/aside.php'); ?>

<!-- } 게시물 작성/수정 끝 -->
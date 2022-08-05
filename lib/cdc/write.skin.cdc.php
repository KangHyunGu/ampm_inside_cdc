<?php

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// quasar Css
add_stylesheet('<link href="https://cdn.jsdelivr.net/npm/quasar@2.7.5/dist/quasar.prod.css" rel="stylesheet" type="text/css">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">', 0);


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="' . CDC_CSS_URL . '/cdc-style.css">', 0);


?>

<?php
include(G5_PATH.'/inc/top.php');
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

<!-- Add the following at the end of your body tag vue3(Vue3 사용)-->
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@2.7.5/dist/quasar.umd.prod.js"></script>

<div id="container" class="sub">
	<!-- 좌측 컨텐츠 영역 -->
	<section class="section_left">
		<!-- 비주얼 배너 -->
		<div class="visual_banner">
			<img src="<?=G5_URL?>/images/sub_banner1.jpg" alt="마케터 인사이트 배너">
		</div>

		<!-- 게시물 작성/수정 시작 { -->
		<div id="q-app">
			<section id="bo_w">
				<h2>마케팅 인사이트 글쓰기</h2>
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
								<!-- 카테고리 선택 -->
								<?php if ($is_category) { ?>
								<tr>
									<th scope="row"><label for="ca_name">카테고리 선택<strong class="sound_only">필수</strong></label></th>
									<td class="chk_category">
									<!-- Array
										(
											[네이버] => 네이버
											[카카오] => 카카오
											[구글[유튜브]] => 구글[유튜브]
											[META] => META
											[바이럴] => 바이럴
											[APP] => APP
											[기타 매체] => 기타 매체
											[매체 통합] => 매체 통합
											[트렌드] => 트렌드
											[솔루션] => 솔루션
										) -->
									<div class="q-pa-md">
										<div class="q-gutter-xm">
												<q-radio v-for="cat in code_category" 
													:checked="true"
													size="xs" 
													v-model="form.ca_name" 
													:val="cat" 
													:label="cat" 
													class="sel-cate"
													/>
										</div>
										<!-- <button @click="valueCheck">값 확인</button> -->
									</div>	
										<!--
										<select name="ca_name" id="ca_name" required class="required" >
											<option value="">선택하세요</option>
											<?php echo $category_option ?>
										</select>
										-->
									</td>
								</tr>
								<?php } ?>
								
								<!-- 노출매체 -->
								<tr>
									<th scope="row"><label for="">노출매체</label></th>
									<td>
										<div class="q-pa-md">
											<div class="q-gutter-sm">
												<q-checkbox size="xs"  
													v-model="is_blog" 
													true-value="Y"
													false-value="N"
													label="블로그" />

													<q-checkbox size="xs"  
													v-model="is_insta" 
													true-value="Y"
													false-value="N"
													label="인스타" />

													<q-checkbox size="xs"  
													v-model="is_youtube" 
													true-value="Y"
													false-value="N"
													label="유튜브" />
											</div>
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
									<th scope="row">이미지 첨부파일<?// php echo $i+1 ?></th>
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

							
								<input type="hidden" name="wr_1" id="wr_1" v-model="form.wr_1" />
								<input type="hidden" name="wr_2" id="wr_2" value="<?php echo $write['wr_2']; ?>">
								<input type="hidden" name="wr_3" id="wr_3" value="<?php echo $write['wr_3']; ?>">
								<input type="hidden" name="wr_4" id="wr_4" value="<?php echo $write['wr_4']; ?>">
								<input type="hidden" name="wr_5" id="wr_5" value="<?php echo $write['wr_5']; ?>">
								<input type="hidden" name="wr_6" id="wr_6" value="<?php echo $write['wr_6']; ?>">
								<input type="hidden" name="wr_7" id="wr_7" value="<?php echo $write['wr_7']; ?>">
								<input type="hidden" name="wr_8" id="wr_8" value="<?php echo $write['wr_8']; ?>">
								<input type="hidden" name="wr_9" id="wr_9" value="<?php echo $write['wr_9']; ?>">
								<input type="hidden" name="wr_10" id="wr_10" value="<?php echo $write['wr_10']; ?>">
								<input type="hidden" name="wr_11" id="wr_11" value="<?php echo $write['wr_11']; ?>">
								<input type="hidden" name="wr_12" id="wr_12" value="<?php echo $write['wr_12']; ?>">
								<input type="hidden" name="wr_13" id="wr_13" value="<?php echo $write['wr_13']; ?>">
								<input type="hidden" name="wr_14" id="wr_14" value="<?php echo $write['wr_14']; ?>">
								<input type="hidden" name="wr_15" id="wr_15" value="<?php echo $write['wr_15']; ?>">
								<input type="hidden" name="wr_16" id="wr_16" value="<?php echo $write['wr_16']; ?>">
								<input type="hidden" name="wr_17" id="wr_17" value="<?php echo $write['wr_17']; ?>">
								<input type="hidden" name="wr_18" id="wr_18" value="<?php echo $write['wr_18']; ?>">
								<input type="hidden" name="wr_20" id="wr_20" value="<?php echo $write['wr_20']; ?>">

								<tr>
									<th scope="row"><label for="wr_19">게시물 숨김 여부<strong class="sound_only">필수</strong></label></th>
									<td>
										<select name="wr_19" id="wr_19" required class="required" >
											<?=codeToHtml($code_hide, $write['wr_19'], "cbo", "")?>
										</select>
									</td>
								</tr>
								
								<!-- CDC-메인해쉬태그 -->
								 <tr v-if="form.cdc.is_blog || form.cdc_is_insta || form.cdc.is_youtube">
									<th scope="row"><label for="wr_19">메인해쉬태그<strong class="sound_only">필수</strong></label></th>
									<td>
									</td>
								</tr> 
						
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
						<a href="./board.php?bo_table=<?php echo $bo_table ?><?=$sublink?>" class="btn_cancel">취소</a>
						<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
					</div>
				</form>
		
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

				<!-- php 환경 -->
				<?php include_once(CDC_PATH."/setConfig.php"); ?>

				<!-- JavaScript Method(Vue.js 3) -->
				<script src="<?= CDC_JS_URL ?>/cdcVue.js?v=<?= CDC_VER ?>"></script>
			</section>
		</div>
		<!-- } 게시물 작성/수정 끝 -->
	</section>
	<script>
		const board_data= <?php echo json_encode($board); ?>;
		const write_fields = <?php echo json_encode($write); ?>;
		vm.$data.code_category = board_data.bo_category_list.split("|");
		vm.fetchData(write_fields);
		console.log(vm.$data.form);
		vm.setBoardData(board_data);
		console.log('write_fields : ', write_fields);
		console.log('board_data : ', board_data);
	</script>
	<!-- 우측 side 영역 -->
	<?php include(G5_PATH.'/inc/aside.php'); ?>

</div>

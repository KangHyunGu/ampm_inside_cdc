<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<?php
include(G5_PATH.'/inc/quick.php');
?>
<?php
include(G5_PATH.'/inc/top.php');
?>
<?php
include(G5_PATH.'/inc/leftMenu.php');
?>
<?
$sublink = '&amp;path_dep1='.$_REQUEST['path_dep1'].'&amp;path_dep2='.$_REQUEST['path_dep2'].'&amp;path_dep3='.$_REQUEST['path_dep3'].'&amp;path_dep4='.$_REQUEST['path_dep4'];
$sublink_list = '&amp;path_dep1='.$_REQUEST['path_dep1'].'&amp;path_dep2='.$_REQUEST['path_dep2'].'&amp;path_dep3=01&amp;path_dep4='.$_REQUEST['path_dep4'];
?>
		<div class="sub_wrap">
			<div class="sub_contents">

			
			<h1>빠른 상담 신청 작성하기</h1>
			<p style="padding-bottom: 20px;">궁금하신 점이 있으신가요? 상담 신청 게시판에 문의를 남겨주세요. 빠르고 친절하게 안내해드리겠습니다.<br>
			에이엠피엠글로벌은 속도전에서 강한 기업, 확실한 통찰력을 가진 e비즈니스 강자가 되겠습니다.</p>

			<section id="bo_w">
				<!--h2 id="container_title"><?php echo $g5['title'] ?></h2-->

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

				<input type="hidden" name="path_dep1"		id="path_dep1" 		value="<?=$path_dep1?>" />
				<input type="hidden" name="path_dep2"		id="path_dep2" 		value="<?=$path_dep2?>" />
				<input type="hidden" name="path_dep3"		id="path_dep3" 		value="<?=$path_dep3?>" />
				<input type="hidden" name="path_dep4"		id="path_dep4" 		value="<?=$path_dep4?>" />

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
					<input type="hidden" name="wr_subject" value="<?php echo ($subject)?$subject:"빠른상담이 접수되었습니다." ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255">
					<tr>
						<?php if ($is_name) { ?>
						<th scope="row"><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
						<td colspan="2"><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
						<?php } ?>
						<?php if ($is_password) { ?>
						<th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
						<td colspan="2"><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
						<?php } ?>
					</tr>
					<input type="hidden" name="wr_10"		value="<?=($write['wr_10'])?$write['wr_10']:"접수"?>">
					<tr>
						<th>관심상품</th>
						<td colspan="5">
							<?=codeToHtml($code_selltype, $write['wr_1'], "rdo5", "selltype")?>
						</td>
					</tr>
					
					<? 
						if($write['wr_5']){

							$memberHp = explode('-',$write['wr_5']);

							$memberHp1 = $memberHp[0];
							$memberHp2 = $memberHp[1];
							$memberHp3 = $memberHp[2];
						}
					?>
					<tr>
						<th>전화번호</th>
						<td colspan="5">
							<select name="memberHp1" id="memberHp1" required class="frm_input1 required">
								<?=codeToHtml($code_hp, $memberHp1, "cbo", "")?>
							</select>
							<input name=memberHp2 id="memberHp2" itemname="휴대전화2" required class="frm_input2 required" value="<?=$memberHp2?>" size="6" maxlength="4"> -
							<input name=memberHp3 id="memberHp3" itemname="휴대전화3" required class="frm_input2 required" value="<?=$memberHp3?>" size="6" maxlength="4">
						</td>
					</tr>
					<!--
					<tr>
						<th>홈페이지</th>
						<td colspan="3"><input type="text" name=wr_7 id="wr_7" itemname="홈페이지" class="frm_input" value="<?=$write[wr_7]?>"></td>
					</tr>
					-->
					<tr>
						<th scope="row"><label for="wr_content">상담내용<strong class="sound_only">필수</strong></label></th>
						<td colspan="5" class="wr_content">
							<?php if($write_min || $write_max) { ?>
							<p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
							<?php } ?>
							<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
							<?php if($write_min || $write_max) { ?>
							<div id="char_count_wrap"><span id="char_count"></span>글자</div>
							<?php } ?>
						</td>
					</tr>
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

					<?php if ($is_guest) { //자동등록방지  ?>
					<tr>
						<th scope="row">자동등록방지</th>
						<td colspan="5">
							<?php echo $captcha_html ?>
						</td>
					</tr>
					<tr>
						<td colspan="6">
							<input type="checkbox" name="agreeSelect" id="agreeSelect1" value="Y" required>
							개인정보취급방침에 동의합니다.&nbsp;&nbsp;<a href="#" target="_blank" style="color:#fff;">&lt;자세히보기&gt;</a>
						</td>
					</tr>
					<?php } ?>
					</tbody>
					</table>
				</div>

				<div class="btn_confirm">
					<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_design1">
					<input type="button" value="목록" onclick="window.location='./board.php?bo_table=<?php echo $bo_table ?><?=$sublink_list?>'" id="btn_submit" accesskey="s" class="btn_design2">
				</div>
				</form>
			</section>
	<!-- } 게시물 작성/수정 끝 -->

		</div>
	</div>

<?php
include(G5_PATH.'/inc/brand_slide.php');
?>
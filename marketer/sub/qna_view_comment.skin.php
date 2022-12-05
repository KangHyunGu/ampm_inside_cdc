<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);
include_once($board_skin_path.'/view_comment.php'); //코멘트 파일을 재정의
?>

<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>
<button type="button" class="cmt_btn"><span class="total"><b>답변</b> <?php echo $view['wr_comment']; ?></span><span class="cmt_more"></span></button>
<!-- 댓글 시작 { -->
<section id="bo_vc">
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 50;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
		$c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c&amp;ch=s#bo_vc_w';
		$c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu&amp;ch=#bo_vc_w';
        $is_comment_reply_edit = ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) ? 1 : 0;
		
		///////////////////////////////////////////////////////////////////////
		// AMPM 사원인 경우 팀 정보 노출
		///////////////////////////////////////////////////////////////////////
		$mk = get_viewNamecardInfo($bo_table, $comment_id);
		$nick = $mk['nick'];
		$mb_images = $mk['mb_images'];
		$mb_team_text = $mk['mb_team_text'];
	?>


	<article id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?>style="margin-left:<?php echo $cmt_depth ?>px;"<?php } ?>>
        
        <div class="cm_wrap">

            <header style="z-index:<?php echo $cmt_sv; ?>">
                <!-- 답변자 정보 -->
                <div class="pf_img">
                    <?php echo $mb_images; ?>
                </div>

                <div class="pf_info">
                    <h2><?php echo get_text($nick); ?>님의 <?php if ($cmt_depth) { ?><span class="sound_only">답변의</span><?php } ?> 답변</h2>

                    <!-- 마케터라면 소속 팀 노출되고, 일반사용자는 미노출 -->
                    <h6><?php echo $mb_team_text; ?></h6>
                    <!-- 답변자 이름 -->
                    <h5><b><?php echo $nick ?></b> 님의 답변입니다.</h5>
                    <?php if ($is_ip_view) { ?>
                    <span class="sound_only">아이피</span>
                    <span>(<?php echo $list[$i]['ip']; ?>)</span>
                    <?php } ?>
                    
                    <!-- 답변 작성 날짜 -->
                    <p class="bo_vc_hdinfo">
                        <time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])) ?>"><?php echo $list[$i]['datetime'] ?></time>
                    </p>
                    <?php
                    include(G5_SNS_PATH.'/view_comment_list.sns.skin.php');
                    ?>
                </div>

				<?php
				//대대글이 아니고(답변글) 마케터인 경우만
				if($list[$i]['wr_comment_reply'] == '' && $list[$i]['wr_ampm_user'] == 'Y'){
				?>
                <!-- 마케터 지정 질문시 나타나는 표시, 미지정시 미노출 -->
                <div class="cmt_select">
                    <?php echo $mb_images; ?>
                    <b><?php echo $nick; ?></b>
                    <p><?=($view['wr_1'] && $view['wr_1'] == $list[$i]['wr_17'])?'지정':''?>마케터<br>답변입니다.</p>
                </div>
                <!-- 마케터 지정 질문시 나타나는 표시 끝 -->
				<?php
				}
				?>
	        </header>
	
	        <!-- 답변 출력 -->
	        <div class="cmt_contents">
                <p>
                    <?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
                    <?php echo $comment ?>
					<?php
						//첨부파일
						if($list[$i]['file']['count'] > 0) {
							echo '<ul class="co_file">';
							for($f=0;$f<$list[$i]['file']['count'];$f++) {
								if (isset($list[$i]['file'][$f]['source']) && $list[$i]['file'][$f]['source']) { //이미지도 별도 출력하지 않고 다운로드 처리
									echo '<li class="file_list">';
									echo '<i class="fa fa-folder-open" aria-hidden="true"></i>';
									echo '<a href="'.$list[$i]['file'][$f]['href'].'" class="view_file_download">'.$list[$i]['file'][$f]['source'].$list[$i]['file'][$f]['content'].'('.$list[$i]['file'][$f]['size'].')</a>';
									//echo '<span class="co_file_cnt">'.$list[$i]['file'][$f]['download'].'회 다운로드 <span class="mobile-none">| DATE : '.$list[$i]['file'][$f]['datetime'].'</span></span>';
									//echo '<input type="hidden" name="co_file_name[]" value="'.$list[$i]['file'][$f]['source'].'" class="co_file_name">';
									//echo '<input type="hidden" name="co_file_no[]" value="'.$f.'" class="co_file_no">';
									echo '</li>';
								}
							}
							echo '</ul>';
						}
					?>
               </p>
	            <?php if($is_comment_reply_edit) {
                  if($w == 'cu') {
                        $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                        $cmt = sql_fetch($sql);
                        if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
                           $cmt['wr_content'] = '';
                        $c_wr_content = $cmt['wr_content'];
                     }
                  ?>
                <?php } ?>
	        </div>

			<?php
				//대대글이 아니고(답변글) 마케터인 경우만
				if($list[$i]['wr_comment_reply'] == '' && $list[$i]['wr_ampm_user'] == 'Y'){

					//마케터 답변시 해당 마케터 네임카드 출력
					include(G5_PATH.'/inc/_inc_namecard_ma.php'); 
				}
			?>

            <div class="name_bt">
                <div class="etc">
                    <span><?php if($list[$i]['wr_comment_reply'] == '' && $list[$i]['wr_ampm_user'] == 'Y'){ ?>※ 위 답변은 마케터의 경험과 지식을 바탕으로 작성되었습니다.<?php } ?></span>
                </div>

				<?php if($is_comment_reply_edit) { ?>
                <div class="bo_vl_opt">
					<!-- <button type="button" class="btn_cm_opt btn_b01 btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">댓글 옵션</span></button> -->
					<ul class="bo_vc_act">
						<?php if ($list[$i]['is_reply'] && $member['mb_id'] != '') { ?><li><a href="<?php echo $c_reply_href; ?>" class="comment_box_btn" onclick="comment_box('<?php echo $comment_id ?>', 'c', 's'); return false;">댓글</a></li><?php } ?>
                        <?php if ($list[$i]['is_edit']) { ?><li><a href="<?php echo $c_edit_href; ?>" onclick="comment_box('<?php echo $comment_id ?>', 'cu', ''); return false;">수정</a></li><?php } ?>
                        <?php if ($list[$i]['is_del']) { ?><li><a href="<?php echo $list[$i]['del_link']; ?>" onclick="return comment_delete();">삭제</a></li><?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div> 
			<!-- 대댓글 작성 영역 -->
			<div class="re_comm_wr">
				<span id="edit_<?php echo $comment_id ?>" class="bo_vc_w "></span><!-- 수정 -->
				<span id="reply_<?php echo $comment_id ?>" class="bo_vc_w reply"></span><!-- 답변 -->
		
				<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
				<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
			</div>


            <!-- 답변 출력 끝 -->

			<?php
				/////////////////////////////////////////////////////////////////
				//대대글리스트
				/////////////////////////////////////////////////////////////////
				$re_cmt_amt = count($cmlist[$i]);
				for ($j=0; $j<$re_cmt_amt; $j++) {
					$re_comment_id = $cmlist[$i][$j]['wr_id'];
					$re_cmt_depth = strlen($cmlist[$i][$j]['wr_comment_reply']) * 20;
					$re_comment = $cmlist[$i][$j]['content'];
					$re_comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $re_comment);
					$re_cmt_sv = $re_cmt_amt - $j + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
					$re_c_reply_href = $comment_common_url.'&amp;c_id='.$re_comment_id.'&amp;w=c&amp;ch=s#bo_vc_w';
					$re_c_edit_href = $comment_common_url.'&amp;c_id='.$re_comment_id.'&amp;w=cu&amp;ch=s#bo_vc_w';
					$re_is_comment_reply_edit = ($cmlist[$i][$j]['is_reply'] || $cmlist[$i][$j]['is_edit'] || $cmlist[$i][$j]['is_del']) ? 1 : 0;

					///////////////////////////////////////////////////////////////////////
					// AMPM 사원인 경우 팀 정보 노출
					///////////////////////////////////////////////////////////////////////
					$re = get_viewNamecardInfo($bo_table, $re_comment_id);
					$re_nick = $re['nick'];
					$re_images = $re['mb_images'];
			?>
			<!-- 대댓글 영역 -->
            <div id="c_<?php echo $re_comment_id ?>" class="re_comm" <?php if ($re_cmt_depth) { ?>style="padding-left:<?php echo $re_cmt_depth ?>px;"<?php } ?>>
				
				<!-- 실제 1개 댓글 영역 -->
				<div class="re_comm_area">
					<div class="re_comm_vw">
						<div class="comm_vw_info">
							<img src="<?php echo G5_URL?>/images/re_icon.png" alt="대댓글" />
							<p>
								<span class="name"><?php echo $re_nick ?></span> <!-- 대댓글 작성자 -->

								<?php if ($is_ip_view) { ?>
								<span>(<?php echo $cmlist[$i][$j]['ip']; ?>)</span>
								<?php } ?>
							</p>

							<span class="re_date"> <!-- 댓글 작성일 -->
								<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($cmlist[$i][$j]['datetime'])) ?>"><?php echo $cmlist[$i][$j]['datetime'] ?></time>
							</span> 

							<?php if($re_is_comment_reply_edit) { ?>
							<!-- 대댓글 수정/삭제 -->
							<div class="re_comm_btn"> 
								<?php if ($cmlist[$i][$j]['is_reply'] && $member['mb_id'] != '') { ?><a href="<?php echo $re_c_reply_href; ?>" onclick="comment_box('<?php echo $re_comment_id ?>', 'c', 's'); return false;">댓글</a></li><?php } ?>
								<?php if ($cmlist[$i][$j]['is_edit']) { ?><a href="<?php echo $re_c_edit_href; ?>" onclick="comment_box('<?php echo $re_comment_id ?>', 'cu', 's'); return false;">수정</a><?php } ?>
								<?php if ($cmlist[$i][$j]['is_del']) { ?><a href="<?php echo $cmlist[$i][$j]['del_link']; ?>" onclick="return comment_delete();">삭제</a><?php } ?>
							</div>
							<?php } ?>
						</div>
						<div class="comm_vw_box">
							<?php echo $re_comment ?>
							<?php
								//첨부파일
								if($cmlist[$i][$j]['file']['count'] > 0) {
									echo '<ul class="co_file">';
									for($f=0;$f<$cmlist[$i][$j]['file']['count'];$f++) {
										if (isset($cmlist[$i][$j]['file'][$f]['source']) && $cmlist[$i][$j]['file'][$f]['source']) { //이미지도 별도 출력하지 않고 다운로드 처리
											echo '<li class="file_list">';
											echo '<i class="fa fa-folder-open" aria-hidden="true"></i>';
											echo '<a href="'.$cmlist[$i][$j]['file'][$f]['href'].'" class="view_file_download">'.$cmlist[$i][$j]['file'][$f]['source'].$cmlist[$i][$j]['file'][$f]['content'].'('.$cmlist[$i][$j]['file'][$f]['size'].')</a>';
											echo '<span class="co_file_cnt">'.$cmlist[$i][$j]['file'][$f]['download'].'회 다운로드 <span class="mobile-none">| DATE : '.$cmlist[$i][$j]['file'][$f]['datetime'].'</span></span>';
											echo '<input type="hidden" name="co_file_name[]" value="'.$cmlist[$i][$j]['file'][$f]['source'].'" class="co_file_name">';
											echo '<input type="hidden" name="co_file_no[]" value="'.$f.'" class="co_file_no">';
											echo '</li>';
										}
									}
									echo '</ul>';
								}
							?>
							<?php if($re_is_comment_reply_edit) {
								if($w == 'cu') {
									$sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' and wr_comment = '{$cmlist[$i][$j]['wr_comment']}' and wr_comment_reply != '' ";
									$cmt = sql_fetch($sql);
									if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
										$cmt['wr_content'] = '';
									
									$c_wr_content = $cmt['wr_content'];
								}
							?>
							<?php } ?>
						</div>
					</div>
				</div>
				<!-- 실제 1개 댓글 영역 끝 -->
				
				<!-- 대댓글 작성 영역 -->
				<div class="re_comm_wr">
					<span id="edit_<?php echo $re_comment_id ?>" class="bo_vc_w reply"></span><!-- 수정 -->
					<span id="reply_<?php echo $re_comment_id ?>" class="bo_vc_w reply"></span><!-- 답변 -->
         
					<input type="hidden" value="<?php echo strstr($cmlist[$i][$j]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $re_comment_id ?>">
					<textarea id="save_comment_<?php echo $re_comment_id ?>" style="display:none"><?php echo get_text($cmlist[$i][$j]['content1'], 0) ?></textarea>
				</div>
            </div>
			<?php } ?>

 		</div>
    </article>
<?php } ?>

<?php if ($i == 0) { //답변이 없다면 ?><p id="bo_vc_empty">등록된 답변이 없습니다.</p><?php } ?>

</section>
<!-- } 답변 끝 -->

<?php 
if ($is_comment_write) {
    if($w == ''){
        $w = 'c';
	}

	//마케터인경우 혹은 지정마케터와 같거나 지정이 아닌 경우
	$memberLoginInfo = get_memberLoginInfo($member['mb_id']);


	//////////////////////////////////////////////////////////
	// 마케터만 답글을 단다. 회원은 대댓글만
	// 마케터 답글도 전체이거나 지정마케터와 같은 경우만 답글을 단다.
	//////////////////////////////////////////////////////////
?>
<?php
//마케터이고 마케터가 지정마케터이거나 전체인 경우
if( ($member['ampmkey'] == 'Y' && ($view['wr_11'] == $member['mb_id'] || ! $view['wr_11'])) || $ch == 's' ){
?>

<!-- 댓글 쓰기 시작 { -->
<aside id="bo_vc_w" class="bo_vc_w ans">
    <form name="fviewcomment" id="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
		<input type="hidden" name="ch" value="<?php echo $ch ?>" id="ch">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
		<input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="is_good" value="">
		<input type="hidden" name="utm_member" value="<?php echo $utm_member ?>">

    <div class="cnt_write">
		<span class="sound_only">내용</span>
		<?php //echo $memberLoginInfo['nick']; ?>
		<?php echo $memberLoginInfo['mb_images']; ?>

		<?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
		<textarea id="wr_content" name="wr_content" maxlength="10000" required title="내용" placeholder="답변내용을 입력해주세요" 
		<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content; ?></textarea>
		<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
		<script>
		$(document).on("keyup change", "textarea#wr_content[maxlength]", function() {
			var str = $(this).val()
			var mx = parseInt($(this).attr("maxlength"))
			if (str.length > mx) {
				$(this).val(str.substr(0, mx));
				return false;
			}
		});
		</script>
        <div class="btn_confirm">
        	<!--
			<span class="secret_cm chk_box">
	            <input type="checkbox" name="wr_secret" value="secret" id="wr_secret" class="selec_chk">
	            <label for="wr_secret"><span></span>비밀글</label>
            </span>
			-->
            <button type="submit" id="btn_submit" class="btn_submit">등록</button>
        </div>
    </div>
    <div class="bo_vc_w_wr">
        <div class="bo_vc_w_info">
            <?php if ($is_guest) { ?>
            <label for="wr_name" class="sound_only">이름<strong> 필수</strong></label>
            <input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" required class="frm_input required" size="25" placeholder="이름">
            <label for="wr_password" class="sound_only">비밀번호<strong> 필수</strong></label>
            <input type="password" name="wr_password" id="wr_password" required class="frm_input required" size="25" placeholder="비밀번호">
            <?php
            }
            ?>
            <?php
            if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {
            ?>
            <span class="sound_only">SNS 동시등록</span>
            <span id="bo_vc_send_sns"></span>
            <?php } ?>
            <?php if ($is_guest) { ?>
                <?php echo $captcha_html; ?>
            <?php } ?>
        </div>
		<?php 
			if($board['bo_upload_count'] > 0) { 
				$file = get_file($bo_table, $c_id);
				if($file_count < $file['count']) {
					$file_count = $file['count'];
				}

		?>
        <div class="btn_file">
            <input type="file" name="bf_file[]" title="파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
            <?php if ($is_file_content) { ?>
            <input type="text" name="bf_content[]" value="<?php echo ($w == 'cu') ? $file[0]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
            <?php } ?>
            <?php if($w == 'cu' && $file[0]['file']) { ?>
            <input type="checkbox" id="bf_file_del" name="bf_file_del[]" value="1"> <label for="bf_file_del"><?php echo $file[0]['source'].'('.$file[0]['size'].')';  ?> 파일 삭제</label>
            <?php } ?>
        </div>
		<?php } ?>
    </div>
	
	</form>
</aside>

<?php
}
?>


<script>
var save_before = '';

<?php
//마케터이고 마케터가 지정마케터이거나 전체인 경우
if( ($member['ampmkey'] == 'Y' && ($view['wr_11'] == $member['mb_id'] || ! $view['wr_11'])) || $ch == 's' ){
?>
var save_html = document.getElementById('bo_vc_w').innerHTML;
<?php
}
?>

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
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

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("답변은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("답변은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("답변을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work, ch)
{
    var el_id,
        form_el = 'fviewcomment',
        respond = document.getElementById(form_el);

    // 답변 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

console.log('comment_id=> '+comment_id);
console.log('work=>'+work);
console.log('ch=>'+ch);
console.log('el_id=>'+el_id);
console.log('save_before=>'+save_before);


    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
        //입력값 초기화
        document.getElementById('wr_content').value = '';
        
        // 답변 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            /*
			if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
			*/
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;
        document.getElementById('ch').value = ch;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete()
{
    return confirm("이 글을 삭제하시겠습니까?");
}

<?php
//마케터이고 마케터가 지정마케터이거나 전체인 경우
if( ($member['ampmkey'] == 'Y' && ($view['wr_11'] == $member['mb_id'] || ! $view['wr_11'])) || $ch == 's' ){
?>
comment_box('<?=$c_id?>', 'c', 's'); // 답변 입력폼이 보이도록 처리하기위해서 추가 (root님)
<?php
}
?>



<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>

$(function() {
    // sns 등록
    $("#bo_vc_send_sns").load(
        "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
$(function() {            
    //답변열기
    $(".cmt_btn").click(function(){
        $(this).toggleClass("cmt_btn_op");
        $("#bo_vc").toggle();
    });
});
</script>
<?php 
}
?>
<!-- } 답변 쓰기 끝 -->

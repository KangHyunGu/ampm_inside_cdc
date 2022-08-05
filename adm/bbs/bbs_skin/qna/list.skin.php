<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 10;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

    <!-- 검색 -->
<div class="top_sch">
   <select name="sear_part" id="sear_part" class="form-control">
      <option value=''> 본부 </option>
      <?=codeToHtml($code_part4, $sear_part, "cbo", "")?>
   </select>
   <select name="sear_team" id="sear_team" class="form-control">
      <option value=''> 팀 </option>
      <?=codeToHtml($code_team, $sear_team, "cbo", "")?>
   </select>
   <select name="sfl" id="sfl" class="form-control">
      <option value=''>검색항목</option>
      <?=codeToHtml($member_search, $sfl, "cbo", "")?>
   </select>
   <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="form-control" placeholder="검색어를 입력하세요.">
   <button type="button" id="btn_submit" class="btn btn-primary">검색</button>
   <button type="button" id="reset" class="btn btn-secondary">초기화</button>
   <a href="<? G5_URL ?>/bbs/board.php?bo_table=qna" class="btn btn-link" target="_blank">질문답변 바로가기</a>
</div>

 <!-- 게시판 카테고리 시작 { -->
 <?php if ($is_category) { ?>
 <nav id="bo_cate">
     <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
     <ul id="bo_cate_ul">
         <?php echo $category_option ?>
     </ul>
 </nav>
 <?php } ?>
 <!-- } 게시판 카테고리 끝 -->

 <!-- 게시판 페이지 정보 및 버튼 시작 { -->
 <div class="bo_fx">
     <div id="bo_list_total">
         <span>Total <?php echo number_format($total_count) ?>건</span>
         <?php echo $page ?> 페이지
     </div>

     <?php if ($rss_href || $write_href) { ?>
     <ul class="btn_bo_user">
         <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
         <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
         <!--
         <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
     -->
     </ul>
     <?php } ?>
 </div>
 <!-- } 게시판 페이지 정보 및 버튼 끝 -->
        	
 <div class="tbl_head01 tbl_wrap bo_table">
				<table>
				<thead>
					<tr>
						<?php if ($is_checkbox) { ?>
						<th scope="col">
							<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
							<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
						</th>
						<?php } ?>
                  <th scope="col">번호</th>
                  <?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
                  <th scope="col">노출여부</th>
                  <?php } ?>
                  <th scope="col">카테고리</th>
                  <th scope="col">답변여부</th>
                  <th scope="col">제목</th>
                  <th scope="col">작성자</th>
                  <th scope="col">지정여부</th>
                  <?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<th scope="col">지정마케터</th>
						<?php } ?>
                  <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일</a></th>
                  <th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회수</a></th>
					</tr>
				</thead>
				<tbody>
				<?php
				for ($i=0; $i<count($list); $i++) {
					if ($i%2==0) $lt_class = "even";
					else $lt_class = "";
				?>
					<tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?> <?php echo $lt_class ?>">
						<?php if ($is_checkbox) { ?>
						<td class="td_chk chk_box">
							<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
							<label for="chk_wr_id_<?php echo $i ?>">
								<span></span>
								<b class="sound_only"><?php echo $list[$i]['subject'] ?></b>
							</label>
						</td>
						<?php } ?>

                  <td class="td_num"><?php echo $list[$i]['num']; ?></td>

						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
                  <td class="td_hide"><?=codeToName($code_hide, $list[$i]['wr_19'])?></td>
                  <?php } ?>

						<td class="td_category">
							<?php echo $list[$i]['ca_name'] ?>
						</td>

                  <td class="td_cate">
						<?php  if ($list[$i]['is_notice']) { ?> 
							<span class="qnaIco qnaIco1">공지사항</span>
						<?php } else {?>
							<?php if ($list[$i]['comment_cnt']) { ?>
							<span class="qnaIco qnaIco2">답변완료</span>
							<?php } else {?>
							<span class="qnaIco qnaIco3">답변대기</span>
							<?php } ?>
						<?php } ?>
						</td>

						<td class="td_subject">
							<div class="bo_tit">
								<a href="<?php echo $list[$i]['href'] ?>">
									<?php echo $list[$i]['icon_reply'] ?>
									<?php
										if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
									?>
									<?php echo $list[$i]['subject'] ?>
								</a>
							<?php
							//if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
                     if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
							// if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
							//if (isset($list[$i]['icon_file'])) echo '<i class="fas fa-file-image"></i>';
							//if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
							//if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
							?>
                           
							<?php if ($list[$i]['comment_cnt']) { ?>
								<span class="cnt_cmt"><?php echo $list[$i]['wr_comment']; ?></span>
							<?php } ?>
							</div>
						</td>
						<td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td>
						
						<!-- 지정마케터 정보가 있는 경우 지정여부 지정으로 출력 -->
						<td class="td_name2"><?=($list[$i]['wr_1'])?'지정':'전체'?></td>

                  <?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<td class="td_hide"><?php echo ($list[$i]['wr_12'])?$list[$i]['wr_12']:'전체' ?></td>
						<?php } ?>

						<td class="td_datetime"><?php echo $list[$i]['datetime'] ?></td>
						<td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
					</tr>
				<?php } ?>
				<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
				</tbody>
				</table>
			</div>
	
	
   
   <?php if ($list_href || $is_checkbox || $write_href) { ?>
   <div class="bo_fx">
      <?php if ($is_checkbox) { ?>
      <ul class="btn_bo_adm">
            <li><input type="submit" name="btn btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn btn_submit2" value="담당자변경"></li>
            <li><input type="submit" name="btn btn_submit3" value="게시물숨김"></li>
      </ul>
      <?php } ?>

      <!--
      <?php if ($list_href || $write_href) { ?>
      <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn btn_b01">목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn_b02">글쓰기</a></li><?php } ?>
      </ul>
      <?php } ?>
      -->
   </div>
   <?php } ?>
        
    </form>

</div>
<!-- 페이지 -->
<?php echo $write_pages; ?>
	<!-- 페이지 -->
<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<?php if ($is_checkbox) { ?>
		<script>
		function all_checked(sw) {
			var f = document.fboardlist;
		
			for (var i=0; i<f.length; i++) {
				if (f.elements[i].name == "chk_wr_id[]")
					f.elements[i].checked = sw;
			}
		}
		
		function fboardlist_submit(f) {
			var chk_count = 0;
		
			for (var i=0; i<f.length; i++) {
				if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
					chk_count++;
			}
		
			if (!chk_count) {
				alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
				return false;
			}
		
			if(document.pressed == "선택복사") {
				select_copy("copy");
				return;
			}
		
			if(document.pressed == "선택이동") {
				select_copy("move");
				return;
			}
		
			if(document.pressed == "선택삭제") {
				if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
					return false;
		
				f.removeAttribute("target");
				f.action = "./board_list_update.php";
			}
		
			return true;
		}
		
		// 선택한 게시물 복사 및 이동
		function select_copy(sw) {
			var f = document.fboardlist;
		
			if (sw == "copy")
				str = "복사";
			else
				str = "이동";
		
			var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");
		
			f.sw.value = sw;
			f.target = "move";
			f.action = "./move.php";
			f.submit();
		}
		</script>
		<?php } ?>
<!-- } 게시판 목록 끝 -->

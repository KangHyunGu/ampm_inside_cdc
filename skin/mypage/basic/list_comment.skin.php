<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 10;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$mypage_skin_url.'/style.css">', 0);

?>
<?php
include(G5_PATH.'/inc/top.php');
?>
<div id="container " class="sub">
	<!-- 좌측 컨텐츠 영역 -->
	<section id="mypage" class="section_middle">

        <?php
            //마이페이지 네임카드
            include_once(G5_PATH.'/inc/_inc_mypage_top.php');
        ?>
        <!-- 게시판영역 시작 -->
        <div class="bo_list mp_board">

			<?php
				//마이페이지 메뉴
				include_once(G5_PATH.'/inc/_inc_mypage_menu.php');
			?>

			<!-- 전체게시물 목록 시작 { -->
			<form name="fnewlist" id="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
			<input type="hidden" name="sw"       value="move">
			<input type="hidden" name="view"     value="<?php echo $view; ?>">
			<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
			<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="go_table" value="<?php echo $go_table ?>">
			<input type="hidden" name="page"     value="<?php echo $page; ?>">
			<input type="hidden" name="pressed"  value="">

			<!-- 게시판 list -->
			<div class="bo_fx bo_cate_top">
				<div class="bo_count">
					총 <?php echo number_format($total_count) ?>개 게시물
				</div>
				<!-- <div class="bo_sort">
					<ul>
						<li class="on">
						<a href="#">최신순</a>
						</li>
						<li>
						<a href="#">인기순</a>
						</li>
					</ul>
				</div> -->
			</div>

			<div class="bo_table mp-1">

				<table>
				<thead>
					<tr>
						<th scope="col">No.</th>
						<?php if ($is_checkbox) { ?>
						<th scope="col">
							<label for="all_chk" class="sound_only">현재 페이지 게시물 전체</label>
							<input type="checkbox" id="all_chk">
						</th>
						<?php } ?>
						<th scope="col">게시판</th>
						<th scope="col">구분</th>
						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<th scope="col">노출여부</th>
						<?php } ?>
						<th scope="col">원글제목</th>
						<th scope="col">내가쓴댓글</th>
						<th scope="col">원글작성자</th>
						<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일 <i class="fas fa-sort style"></i></a></th>
						<th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회수 <i class="fas fa-sort style"></i></a></th>
					</tr>
				</thead>
				<tbody>
			<?php
			for ($i=0; $i<count($list); $i++)
			{
				$list[$i]['num'] = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
				$bo_subject = cut_str($list[$i]['bo_subject'], 20);
				$wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
			?>
					<tr>
						<td class="td_num2">
						<?php
						if ($list[$i]['is_notice']) // 공지사항
						   echo '<strong>공지</strong>';
						else if ($wr_id == $list[$i]['wr_id'])
						   echo "<span class=\"bo_current\">열람중</span>";
						else
						   echo $list[$i]['num'];
						?>
						</td>

						<?php if ($is_checkbox) { ?>
 						<td class="td_chk">
							<label for="chk_bn_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
							<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i ?>">
							<input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
							<input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
						</td>
						<?php } ?>
						<td class="td_board"><a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>"><?php echo $bo_subject ?></a></td>
						<td class="td_category">
                            <?php if ($list[$i]['ca_name']) { ?>
							<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link">
								<?php echo $list[$i]['ca_name'] ?>
							</a>
							<?php } ?>
						</td>
						
						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<td class="td_hide"><?=codeToName($code_hide, ($list[$i]['wr_19'])?$list[$i]['wr_19']:'Y')?></td>
						<?php } ?>
						
						<td class="td_subject_2">
                            <a href="<?php echo $list[$i]['href'] ?>" class="new_tit">
                                <?php echo cut_str(get_text($wr_subject),13) ?>
                            </a>
                            <?php if ($list[$i]['icon_new']){ ?>
                                <span class="new_icon">N<span class="sound_only">새글</span></span>
                            <?php } ?>
							<?php if ($list[$i]['comment_cnt']) { ?>
								<span><?=$list[$i]['comment_cnt']?></span>
							<?php } ?>
                        </td>
						<td class="td_comment">
                     <a href="<?php echo $list[$i]['href'] ?>" class="new_tit">
                        <?php echo $list[$i]['comment'] ?>
                        <?php echo cut_str(get_text($list[$i]['cm_content']),16) ?>
                     </a>
						</td>
						
						<td class="td_name"><?php echo $list[$i]['mk_name'] ?></td>
						<td class="td_date"><?php echo $list[$i]['datetime'] ?></td>
						<td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
					</tr>
					<?php }  ?>

					<?php if ($i == 0)
						echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>';
					?>
				</tbody>
				</table>
			</div>

			<!-- 검색, 글쓰기 버튼 -->
			<div class="bt_wrap">

				<div class="bo_fx">

					<ul class="btn_bo_user">
						<?php if ($is_checkbox) {  ?>
							<?php if ($member['ampmkey'] == 'Y') {  ?>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택숨김" onclick="document.pressed=this.value">선택숨김</button></li>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택노출" onclick="document.pressed=this.value">선택노출</button></li>
							<?php }  ?>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value">선택삭제</button></li>
						<?php }  ?>
					</ul>

               <ul class="btn_bo_adm">
                  <?php if ($member['ampmkey'] == 'Y') {  ?>
						<li><a href="<?=G5_BBS_URL?>/write.php?bo_table=insight" class="btn_b04">인사이트 글쓰기</a></li>
                        <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=video" class="btn_b04">영상교육 글쓰기</a></li>
                        <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=reference" class="btn_b04">레퍼런스 글쓰기</a></li>
						<?php }else{  ?>
						<li><a href="<?=G5_BBS_URL?>/write.php?bo_table=qna" class="btn_b04">질문답변 글쓰기</a></li>
						<?php }  ?>
               </ul>

				</div>

			</div> 
			<!-- } 검색, 글쓰기 버튼 -->

			<!-- 페이지 -->
			<?php echo $write_pages;  ?>
		</form>  
		</div>


		<!-- 게시판 검색 시작 { -->
		<div class="bo_search">
			<fieldset id="bo_sch">
            <legend>게시물 검색</legend>
         
            <form name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="go_table" value="<?php echo $go_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">

 			<label for="sear_bo_table" class="sound_only">게시판</label>
			<select name="sear_bo_table" id="sear_bo_table">
				<option value=""> 전체 </option>
				<?=codeToHtml($code_botable, $sear_bo_table, "cbo", "")?>
            </select>

			<label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
				<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
				<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
				<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
				<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>작성자</option>
				<option value="wr_18,1"<?php echo get_selected($sfl, 'wr_18,1'); ?>>담당자</option>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>"  id="stx" class="sch_input frm_input " size="15" maxlength="20">
            <input type="submit" value="검색" class="sch_btn">
            </form>
			</fieldset>   
		</div>
		
		<?php if($is_checkbox) { ?>
		<noscript>
		<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
		</noscript>
		<?php } ?>


	<?php if ($is_checkbox) { ?>
	<script>
	$(function(){
		$('#all_chk').click(function(){
			$('[name="chk_bn_id[]"]').attr('checked', this.checked);
		});
	});

	function fnew_submit(f)
	{
		f.pressed.value = document.pressed;

		var cnt = 0;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
				cnt++;
		}

		if (!cnt) {
			alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
			return false;
		}

		if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n삭제의 경우 한번 삭제한 자료는 복구할 수 없습니다")) {
			return false;
		}

		f.action = "./mypage_delete.php";

		return true;
	}
	</script>
	<?php } ?>
	<!-- } 전체게시물 목록 끝 -->

   </section>

</div>
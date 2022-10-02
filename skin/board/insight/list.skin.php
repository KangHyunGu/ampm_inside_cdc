<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 8;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 2);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<div id="container" class="sub">
	<!-- 좌측 컨텐츠 영역 -->
	<section class="section_left">
		<!-- 비주얼 배너 -->
		<div class="visual_banner">
			<img src="<?=G5_URL?>/images/sub_banner1.jpg" alt="마케터 인사이트 배너">
		</div>

		<!-- 금주의 인기글 슬라이드 -->
		<?php echo latest_popular("insight_slider", 'insight', 10, 30, 1, 'wr_hit desc', 'Y');?>
 

		<!-- 게시판 목록 시작 { -->
		<div id="bo_list" class="bo_list insight_board" style="width:<?php echo $width; ?>">
		
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
			<div class="bo_fx bo_cate_top">
				<div id="bo_list_total" class="bo_count">
					<span>총 <?php echo number_format($total_count) ?>개 게시물</span>
					<!-- <?php echo $page ?> 페이지 -->
				</div>
				
				<!-- 최신순, 인기순 정렬 -->
				<div class="bo_sort">
					<ul>
						<li class="<?=($sst=='wr_num, wr_reply' || $sst=='wr_datetime')?'on':''?>">
							<?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>최신순</a>
						</li>
						<li class="<?=($sst=='wr_hit')?'on':''?>">
							<?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>인기순</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- } 게시판 페이지 정보 및 버튼 끝 -->
		 
			<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="spt" value="<?php echo $spt ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">
			<input type="hidden" name="sw" value="">

			<div class="tbl_head01 tbl_wrap bo_table">
				<table>
				<!--<caption><?php echo $board['bo_subject'] ?> 목록</caption>-->
				<thead>
					<tr>
						<th scope="col">No.</th>
						<?php if ($is_checkbox) { ?>
						<th scope="col">
							<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
							<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
						</th>
						<?php } ?>
						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<th scope="col">노출여부</th>
						<?php } ?>
						<th scope="col">구분</th>
						<th scope="col">제목</th>
						<th scope="col">작성자</th>
						<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일 <i class="fas fa-sort style"></i></a></th>
						<th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회수 <i class="fas fa-sort style"></i></a></th>
					</tr>
				</thead>

				<tbody>
					<?php for ($i=0; $i<count($list); $i++) { ?>
					<tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?> even">
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
							<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
							<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
						</td>
						<?php } ?>

						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<td class="td_hide"><?=codeToName($code_hide, $list[$i]['wr_19'])?></td>
						<?php } ?>

						<td class="td_category">
							<?php if ($is_category && $list[$i]['ca_name']) { ?>
							<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link">
								<?php echo $list[$i]['ca_name'] ?>
							</a>
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
							if ($list[$i]['icon_new']) echo '<span class="new_icon">N<span class="sound_only">새글</span></span>';
							// if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
							if (isset($list[$i]['icon_file'])) echo '<i class="fas fa-file-image"></i>';
							//if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
							//if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
							?>
                           
							<?php if ($list[$i]['comment_cnt']) { ?>
								<span class="cnt_cmt"><?php echo $list[$i]['wr_comment']; ?></span>
							<?php } ?>
							</div>
						</td>
						<td class="td_name"><?php echo $list[$i]['name'] ?></td>
						<td class="td_date"><?php echo $list[$i]['datetime'] ?></td>
						<td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
					</tr>
					<?php } ?>
					<?php if (count($list) == 0) { echo '<tr class="even"><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
				</tbody>
				</table>
			</div>

			<!-- 검색, 글쓰기 버튼 -->
			<div class="bt_wrap">
            <?php if ($list_href || $is_checkbox || $write_href) { ?>
				<div class="bo_fx">
					<?php if ($rss_href || $write_href) { ?>
					<ul class="btn_bo_user">
						<?php if ($is_admin == 'super' || $is_auth) {  ?>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value">선택삭제</button></li>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value">선택복사</button></li>
						<li><button class="btn_b02" type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value">선택이동</button></li>
						<?php }  ?>
						<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?><?=$sublink?>" class="btn_b02 btn">RSS</a></li><?php } ?>
						<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?><?=$sublink?>" class="btn_b02 btn">관리자</a></li><?php } ?>
						<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?><?=$sublink?>" class="btn_b01 btn">글쓰기</a></li><?php } ?>
					</ul>
					<?php } ?>
				</div>
			<?php } ?>
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
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sop" value="and">

            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
				<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
				<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
				<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
				<option value="wr_18,1"<?php echo get_selected($sfl, 'wr_18,1'); ?>>작성자</option>
            </select>
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input frm_input required" size="15" maxlength="20">
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
   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>
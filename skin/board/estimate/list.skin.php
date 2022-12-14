<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//비밀글 처리 땜에
//include_once($board_skin_path."/list.php");

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

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
$sublink_write = '&amp;path_dep1='.$_REQUEST['path_dep1'].'&amp;path_dep2='.$_REQUEST['path_dep2'].'&amp;path_dep3=03&amp;path_dep4='.$_REQUEST['path_dep4'];
?>

<div class="sub_wrap">
	<div class="sub_contents">


	<!--h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2-->

	<!-- 게시판 목록 시작 { -->
	<div id="bo_list" style="width:<?php echo $width; ?>">

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
			</ul>
			<?php } ?>
		</div>
		<!-- } 게시판 페이지 정보 및 버튼 끝 -->

		<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="sw" value="">

		<input type="hidden" name="path_dep1"		id="path_dep1" 		value="<?=$path_dep1?>" />
		<input type="hidden" name="path_dep2"		id="path_dep2" 		value="<?=$path_dep2?>" />
		<input type="hidden" name="path_dep3"		id="path_dep3" 		value="<?=$path_dep3?>" />
		<input type="hidden" name="path_dep4"		id="path_dep4" 		value="<?=$path_dep4?>" />


		<div class="tbl_head01 tbl_wrap">
			<table>
			<caption><?php echo $board['bo_subject'] ?> 목록</caption>
			<thead>
			<tr>
				<th scope="col">번호</th>
				<?php $is_checkbox=false;if ($is_checkbox) { ?>
				<th scope="col">
					<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
					<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
				</th>
				<?php } ?>
				<th scope="col" align="center">제목</th>
				<th scope="col" align="center">신청자</th>
				<!--
				<th scope="col" align="center">회사명</th>
				<th scope="col" align="center">부서명</th>
				<th scope="col" align="center">E-mail</th>
				<th scope="col" align="center">전화번호</th>
				<th scope="col" align="center">휴대전화</th>
				-->
				<th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일</a></th>
				<th scope="col" align="center">처리현황</th>
			   <?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
				<?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $i<count($list); $i++) {
			 ?>
			<tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
				<td class="td_num">
				<?php
				if ($list[$i]['is_notice']) // 공지사항
					echo '<strong>공지</strong>';
				else if ($wr_id == $list[$i]['wr_id'])
					echo "<span class=\"bo_current\">열람중</span>";
				else
					echo $list[$i]['num'];
				 ?>
				</td>
				<?php $is_checkbox=false;if ($is_checkbox) { ?>
				<td class="td_chk">
					<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
					<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
				</td>
				<?php } ?>
				<td class="td_subject">
					<?php
					echo $list[$i]['icon_reply'];
					if ($is_category && $list[$i]['ca_name']) {
					 ?>
					<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
					<?php } ?>

					<!--a href="<?php echo $list[$i]['href'] ?>"-->
						[<?=$list[$i]['wr_1']?>]<?=$list[$i]['wr_subject']?>
						<?php //echo $list[$i]['subject'] ?>
						<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
					<!--/a-->

					<?php
					// if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
					// if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

					if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
					if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
					if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
					if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
					//if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
					echo '<img src="'.$board_skin_url.'/img/icon_secret.gif" alt="비밀글">';

					 ?>
				</td>
				<td class="td_datetime"><?=substr($list[$i][wr_name], 0, -6).'**'?> </td>
				<!--
				<td class="td_datetime"><?php echo $list[$i]['wr_1'] ?></td>
				<td class="td_datetime"><?php echo $list[$i]['wr_2'] ?></td>
				<td class="td_datetime"><?php echo $list[$i]['wr_3'] ?></td>
				<td class="td_datetime"><?php echo $list[$i]['wr_4'] ?></td>
				<td class="td_datetime"><?php echo $list[$i]['wr_5'] ?></td>
				-->
			   <td class="td_datetime"><?php echo date("Y-m-d", strtotime($list[$i]['wr_datetime'])) ?></td>
			   <td class="td_datetime"><?php echo $list[$i]['wr_10'] ?></td>
				<?php if ($is_good) { ?><td class="td_num"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
				<?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
			</tr>
			<?php } ?>
			<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
			</tbody>
			</table>
		</div>

		<?php if ($list_href || $is_checkbox || $write_href) { ?>
		<div class="bo_fx">
			<?php $is_checkbox=false;if ($is_checkbox) { ?>
			<ul class="btn_bo_adm">
				<li><input type="submit" name="btn_submit" class="btn_design2" value="선택삭제" onclick="document.pressed=this.value"></li>
			</ul>
			<?php } ?>

			<?php if ($list_href || $write_href) { ?>
			<ul class="btn_bo_user">
				<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?><?=$sublink?>" class="btn_design2">목록</a></li><?php } ?>
				<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?><?=$sublink_write?>" class="btn_design1">상담신청</a></li><?php } ?>
			</ul>
			<?php } ?>
		</div>
		<?php } ?>
		</form>
	</div>

	<?php if($is_checkbox) { ?>
	<noscript>
	<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
	</noscript>
	<?php } ?>

	<!-- 페이지 -->
	<?php echo $write_pages;  ?>

	<!-- 게시판 검색 시작 { -->
	<fieldset id="bo_sch">
		<legend>게시물 검색</legend>

		<form name="fsearch" method="get">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sop" value="and">

		<input type="hidden" name="path_dep1"		id="path_dep1" 		value="<?=$path_dep1?>" />
		<input type="hidden" name="path_dep2"		id="path_dep2" 		value="<?=$path_dep2?>" />
		<input type="hidden" name="path_dep3"		id="path_dep3" 		value="<?=$path_dep3?>" />
		<input type="hidden" name="path_dep4"		id="path_dep4" 		value="<?=$path_dep4?>" />

		<label for="sfl" class="sound_only">검색대상</label>
		<select name="sfl" id="sfl" style="padding:15px;height:28px; border:1px solid #cccccc;">
			<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
			<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
			<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
		</select>
		<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
		<input type="text" style="padding:15px;width:300px; height:28px; border:1px solid #cccccc;" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="15">
		<input type="submit" value="검색" class="btn_design2">
		</form>
	</fieldset>
	<!-- } 게시판 검색 끝 -->

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

	</div>
</div>

<?php
include(G5_PATH.'/inc/brand_slide.php');
?>


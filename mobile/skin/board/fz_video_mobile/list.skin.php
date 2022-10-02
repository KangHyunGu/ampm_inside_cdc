<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 2);

// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');
?>

<?php
include(G5_PATH.'/inc/m_menu.php');
?>

	<section id="m_sub1">
        <!-- 게시판 카테고리 시작 { -->
            <?php if ($is_category) { ?>
            <nav id="bo_cate" class="ca_sticky">
				<h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
				<ul id="bo_cate_ul">
					<?php echo $category_option ?>
				</ul>
			</nav>
			<?php } ?>
			<!-- } 게시판 카테고리 끝 -->
		

		<!-- 비주얼 배너 -->
		<div class="visual_banner">
			<img src="<?=G5_URL?>/images/sub_banner2.jpg" alt="영상교육 배너">
		</div>

		<!-- 금주의 인기글 슬라이드 -->
		<?php echo latest_popular("m_video_slider", 'video', 10, 20, 1, 'wr_hit desc', 'Y');?>

		<!-- 게시판 목록 시작 { -->
		<div id="bo_gall" class="bo_list" style="width:<?php echo $width; ?>">

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

			 <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
				<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
				<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
				<input type="hidden" name="stx" value="<?php echo $stx ?>">
				<input type="hidden" name="spt" value="<?php echo $spt ?>">
				<input type="hidden" name="sst" value="<?php echo $sst ?>">
				<input type="hidden" name="sod" value="<?php echo $sod ?>">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<input type="hidden" name="sw" value="">

				<?php if ($is_checkbox) { ?>
				<div id="gall_allchk">
					<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					<label for="chkall">전체선택</label>
				</div>
				<?php } ?>

				<ul id="gall_ul" class="gall_row">
				   <?php for ($i=0; $i<count($list); $i++) {
					  if(preg_match("/youtu/", $list[$i]['wr_5'])) {
						 $videoId = get_youtubeid($list[$i]['wr_5']);
						 //$thumb = "<img src='http://img.youtube.com/vi/$videoId/maxresdefault.jpg'/>";
						 $thumb = "<img src='http://img.youtube.com/vi/$videoId/maxresdefault.jpg'/>";
					  }
					  else if(preg_match("/vimeo/", $list[$i]['wr_5'])) {
						 $videoId = get_vimeoid($list[$i]['wr_5']);
						 $thumb_Url = get_vimeoThumb($videoId);
						 $thumb = "<img src='$thumb_Url'/>";
					  }

					  if($i>0 && ($i % $bo_gallery_cols == 0))
						 $style = 'clear:both;';
					  else
						 $style = '';
					  if ($i == 0) $k = 0;
					  $k += 1;
					  if ($k % $bo_gallery_cols == 0) $style .= "margin:0 !important;";
				   ?>
				   <li class="gall_li col-gn-4 <?php if ($wr_id == $list[$i]['wr_id']) { ?>gall_now<?php } ?>">
						<ul class="gall_con">
							<li class="gall_href">
								<?php if ($is_admin) { ?>
									<?php if ($is_checkbox) { ?>
								<div class="td_chk">
									<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
									<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
								</div>
									<?php } ?>
								<?php } ?>
								<a href="<?php echo $list[$i]['href'] ?>">
									<div class="gall_img"><?php echo $thumb; ?></div>

									<div class="gall_text_href">
										<span><?php echo $list[$i]['ca_name'] ?></span>
										<p><?php echo cut_str(get_text( $list[$i]['subject']),20);?></p>
									</div>
									
									<div class="gall_info1">
                                        <span class="gall_name"><?php echo $list[$i]['name'] ?></span>
                                        <span class="view">
                                            <?php if($member['ampmkey'] == 'Y'){	//마케터 ?><?=codeToName($code_hide, $list[$i]['wr_19'])?><?php } ?>
                                        </span>
                                    </div>

                                    <div class="gall_info2">
										<span class="gall_date"><?php echo $list[$i]['datetime'] ?></span>
										<span class="gall_view">
                                            <i class="fa-solid fa-eye"></i>
                                             <?php echo $list[$i]['wr_hit'] ?>
                                        </span>
                                        <?php if ($list[$i]['comment_cnt']) { ?>
                                            <span class="cnt_cmt">
                                                <i class="fa-solid fa-comment-dots"></i>
                                                <?php echo $list[$i]['wr_comment']; ?>
                                            </span>
                                        <?php } ?>

									</div>

								</a>
							</li>
					  </ul>
				   </li>
				   <?php } ?>
				   <?php if (count($list) == 0) { echo "<li class=\"empty_list\">게시물이 없습니다.</li>"; } ?>
				</ul>


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

		<?php if($is_checkbox) { ?>
		<noscript>
			<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
		</noscript>
		<?php } ?>

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
						<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
					</select>
					<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
					<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input frm_input required" size="15" maxlength="20">
					<input type="submit" value="검색" class="sch_btn">
				</form>
			</fieldset>   
		</div>
	</section>



<?php if ($is_checkbox) { ?>
<script>
    function all_checked(sw) {
        var f = document.fboardlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]")
                f.elements[i].checked = sw;
        }
    }

    function fboardlist_submit(f) {
        var chk_count = 0;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택복사") {
            select_copy("copy");
            return;
        }

        if (document.pressed == "선택이동") {
            select_copy("move");
            return;
        }

        if (document.pressed == "선택삭제") {
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

        if (sw == 'copy')
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

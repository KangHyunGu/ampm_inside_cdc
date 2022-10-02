<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 10;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$mypage_skin_url.'/style.css">', 0);

?>
	<!-- 좌측 컨텐츠 영역 -->
	<section id="m_mypage">
        <nav id="bo_cate" class="mp_ca_sticky">
            <?php
                //마이페이지 메뉴
                include(G5_PATH.'/inc/_inc_mypage_menu.php');
            ?>
        </nav>

        <?php
            //마이페이지 네임카드
            include_once(G5_PATH.'/inc/_inc_mypage_top.php');
        ?>

        <nav id="bo_cate2" class="b_mp_ca">
            <?php
                //마이페이지 메뉴
                include(G5_PATH.'/inc/_inc_mypage_menu.php');
            ?>
        </nav>


        <!-- 게시판영역 시작 -->
        <div class="bo_list mp_board">

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
						<?php if ($is_checkbox) { ?>
						<th scope="col">
							<label for="all_chk" class="sound_only">현재 페이지 게시물 전체</label>
							<input type="checkbox" id="all_chk">
						</th>
						<?php } ?>
						<th scope="col">상태</th>
						<th scope="col">구분</th>
						<?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
						<th scope="col">노출</th>
						<?php } ?>
						<th scope="col">제목</th>
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
						<?php if ($is_checkbox) { ?>
 						<td class="td_chk">
							<label for="chk_bn_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
							<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i ?>">
							<input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
							<input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
						</td>
						<?php } ?>
						<td class="td_2">
                            <div>
                                <?php if ($list[$i]['comment_cnt']) { ?>
                                <span class="qnaIco qnaIco2">답변완료</span>
                                <?php } else {?>
                                <span class="qnaIco qnaIco3">답변대기</span>
                                <?php } ?>
                            </div>
						</td>
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
                        <td class="td_subject">
                            <div class="bo_tit">
                                <a href="<?php echo $list[$i]['href'] ?>">						<!-- 지정마케터 정보가 있는 경우 지정여부 지정으로 출력 -->
                                    <!-- 지정마케터 정보가 있는 경우 지정여부 지정으로 출력 -->
                                    <span class="td_name2"><?=($list[$i]['wr_11'])?'지정':'전체'?></span>

                                    <?php echo $list[$i]['comment'] ?>
                                    <?php echo cut_str(get_text($wr_subject),10) ?>
                                    <?php
                                        if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
                                    ?>
                                    <?php echo cut_str(get_text( $list[$i]['subject']),15);?>
                                    <?php
                                        if ($list[$i]['icon_new']) echo '<span class="new_icon">N<span class="sound_only">새글</span></span>';
                                        // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                                        //if (isset($list[$i]['icon_file'])) echo '<i class="fas fa-file-image"></i>';
                                        //if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
                                        //if (isset($list[$i]['icon_hot'])) echo rtrim($list[$i]['icon_hot']);
                                    ?>
                                </a>
                            </div>

                            <div class="bo_tit_sub_1">
                                <span class="td_name"><?php echo $list[$i]['name'] ?></span>
                            </div>

                            <div class="bo_tit_sub_2">
                                <span class="td_date"><?php echo $list[$i]['datetime'] ?></span>
                                <div class="box">
                                    <span class="td_num">
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
                            </div>

                        </td>

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
                        <li>
                            <ul class="btn_user_1">
                                <?php if ($is_checkbox) {  ?>
                                <?php if ($member['ampmkey'] == 'Y') {  ?>
                                <li><button class="btn_b02" type="submit" name="btn_submit" value="선택숨김" onclick="document.pressed=this.value">선택숨김</button></li>
                                <li><button class="btn_b02" type="submit" name="btn_submit" value="선택노출" onclick="document.pressed=this.value">선택노출</button></li>
                                    <?php }  ?>
                                <li><button class="btn_b02" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value">선택삭제</button></li>
                                <?php }  ?>
                            </ul>
                        </li>
                            
                        <li>
                            <P class="btn_write">글쓰기</P>
                            <ul class="btn_user_2">
                                <?php if ($member['ampmkey'] == 'Y') {  ?>
                                <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=insight" class="btn_b04">인사이트</a></li>
                                <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=video" class="btn_b04">영상교육</a></li>
                                <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=reference" class="btn_b04">레퍼런스</a></li>
                                <?php }else{  ?>
                                <li><a href="<?=G5_BBS_URL?>/write.php?bo_table=qna" class="btn_b04">질문답변</a></li>
                                <?php }  ?>
                            </ul>
                        </li>
                    </ul>
                    <script>
                        $(".btn_write").click(function(){
                            $(".btn_user_2").toggle()
                        });
                    </script>
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

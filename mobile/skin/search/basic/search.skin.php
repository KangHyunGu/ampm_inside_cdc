<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
?>

<div id="sch-page">
   <div class="sub-title">
      <strong class="main_color">'<?php echo $stx ?>'</strong> 에 대한 검색결과는 총 <?php echo number_format($total_count) ?>건 입니다.
   </div>

   <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
   <input type="hidden" name="srows" value="<?php echo $srows ?>">
   <fieldset id="sch_res_detail">
      <legend>상세검색</legend>
      <div class="sch_wr">
         <?php //echo $group_select ?>
         <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>

		 <!--
         <label for="sfl" class="sound_only">검색조건</label>
         <select name="sfl" id="sfl">
            <option value="wr_subject||wr_content||wr_18"<?php echo get_selected($sfl, "wr_subject||wr_content||wr_18") ?>>제목+내용+담당자</option>
            <option value="wr_subject"<?php echo get_selected($sfl, "wr_subject") ?>>제목</option>
            <option value="wr_content"<?php echo get_selected($sfl, "wr_content") ?>>내용</option>
            <option value="wr_18"<?php echo get_selected($sfl, "wr_18") ?>>담당자</option>
         </select>
		 -->
		 <input type="hidden" name="sfl" value="wr_subject||wr_content||wr_18||wr_12">

         <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
         <input type="text" name="stx" id="stx" value="<?php echo $text_stx ?>" class="frm_input" required  maxlength="20">
         <button type="submit" class="btn_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i></button>

         <script>
         function fsearch_submit(f)
         {
               if (f.stx.value.length < 2) {
                  alert("검색어는 두글자 이상 입력하십시오.");
                  f.stx.select();
                  f.stx.focus();
                  return false;
               }

               // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
               var cnt = 0;
               for (var i=0; i<f.stx.value.length; i++) {
                  if (f.stx.value.charAt(i) == ' ')
                     cnt++;
               }

               if (cnt > 1) {
                  alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                  f.stx.select();
                  f.stx.focus();
                  return false;
               }

               f.action = "";
               return true;
         }
         </script>
      </div>
	  <!--
      <div class="switch_field chk_box">
         <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop">
         <label for="sop_or"><span></span>OR</label>
         <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
         <label for="sop_and"><span></span>AND</label>
      </div>
	  -->
   </fieldset>
   </form>


   <?php
   if ($stx) {
      if ($board_count) {
   ?>
   <section id="sch_res_ov">
      <h2>전체검색 결과</h2>
      <ul>
         <li>게시판<strong><?php echo $board_count ?>개</strong></li>
         <li>게시물<strong><?php echo number_format($total_count) ?>개</strong></li>
         <li><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중</li>
      </ul>
   </section>
   <?php
      }
   }
   ?>
   
   <div id="sch_result">

         <?php
         if ($stx) {
            if ($board_count) {
         ?>
         <ul id="sch_res_board">
            <li><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>>전체게시판</a></li>
            <?php echo $str_board_list; ?>
         </ul>
         <?php
            } else {
         ?>
         <div class="empty_list">검색된 자료가 하나도 없습니다.</div>
         <?php } }  ?>

         <hr>

         <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
         <?php
         $k=0;
         for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
         ?>
            <div class="search_board_result">
            <h2><a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>"><?php echo $bo_subject[$idx] ?> 게시판 내 결과</a></h2>
            <a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="sch_more">더보기</a>
            <ul>
            <?php
            for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
                  if ($list[$idx][$i]['wr_is_comment'])
                  {
                     $comment_def = '<span class="cmt_def"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">댓글</span></span> ';
                     $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
                  }
                  else
                  {
                     $comment_def = '';
                     $comment_href = '';
                  }
               ?>

                  <li>
                     <div class="sch_tit">
                        <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                     </div>
                     <p><?php echo $list[$idx][$i]['content'] ?></p>
                     <div class="sch_info">
						<?php if($search_table[$idx] == 'qna'){ ?>
							작성자 : <?php echo $list[$idx][$i]['wr_18'] ?>
 						<?php }  ?>
                       <span class="sch_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> 등록일 : <?php echo $list[$idx][$i]['datetime'] ?></span>
                     </div>
					<?php 
						if($search_table[$idx] !== 'qna'){
					?>
					<!-- 본문 밑 마케터 네임카드 출력 -->
					<?php include(G5_PATH . '/inc/_inc_namecard_search.php'); ?>

		            <?php }  ?>

                  </li>
            <?php }  ?>
            </ul>
            </div>
         <?php }		//end for?>
         <?php if ($stx && $board_count) {  ?></section><?php }  ?>

         <?php echo $write_pages ?>
   </div>
</div>
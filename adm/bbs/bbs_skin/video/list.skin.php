<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$colspan = 10;

// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');

// 썸네일 크기 설정
$thumb_width = '110';    //썸네일 넓이
$thumb_height = '80';    //썸네일 높이

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<link rel="stylesheet" href="<?=$board_skin_url?>/style.css">
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
   <a href="<? G5_URL ?>/bbs/board.php?bo_table=video" class="btn btn-link" target="_blank">영상교육 바로가기</a>
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

 <div class="tbl_head01 tbl_wrap">
     <table>
     <caption><?php echo $board['bo_subject'] ?> 목록</caption>
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
         <th scope="col">제목</th>
         <th scope="col">썸네일</th>
         <th scope="col">작성자</th>
         <th seope="col">담당자</th>
         <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일</a></th>
      <th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회수</a></th>
         <?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
         <?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
     </tr>
     </thead>
     <tbody class="bo_tr">
     <?php
     for ($i=0; $i<count($list); $i++) {
      ?>
     <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
         <?php if ($is_checkbox) { ?>
         <td class="td_chk">
             <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
             <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
         </td>
         <?php } ?>
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
         <?php if($member['ampmkey'] == 'Y'){	//마케터 ?>
            <td class="td_hide"><?=codeToName($code_hide, $list[$i]['wr_19'])?></td>
         <?php } ?>
         <td class="td_cate">
             <?php echo $list[$i]['ca_name'] ?>
         </td>
         <td class="td_subject">
             <?php
             echo $list[$i]['icon_reply'];
             if ($is_category && $list[$i]['ca_name']) {
             ?>
             <?php } ?>

             <a href="<?php echo $list[$i]['href'] ?>">
                 <?php echo $list[$i]['subject'] ?>
                 <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
             </a>

             <?php
             // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
             // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

             if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
             //if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
             if ($list[$i]['icon_file']) echo '<i class="fas fa-file-image"></i>';
             if ($list[$i]['icon_link']) echo '<i class="fa fa-link"></i>';
             //if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

              ?>
         </td>
         <td class="td_img">
            <a href="<?php echo $list[$i]['wr_5'] ?>">
            <?php 
               if(preg_match("/youtu/", $list[$i]['wr_5'])) {
                  $videoId = get_youtubeid($list[$i]['wr_5']);
                  $thumb = "<img src='http://img.youtube.com/vi/$videoId/mqdefault.jpg' width='$thumb_width' height='$thumb_height' />";
               }
               else if(preg_match("/vimeo/", $list[$i]['wr_5'])) {
                  $videoId = get_vimeoid($list[$i]['wr_5']);
                  $thumb_Url = get_vimeoThumb($videoId);
                  $thumb = "<img src='$thumb_Url' width='$thumb_width' height='$thumb_height' />";
               }

               echo $thumb;
            ?>
            </a>
         </td>
         <td class="td_name sv_use"><?php echo $list[$i]['wr_name'] ?></td>
         <td class="td_manager"><?php echo $list[$i]['name'] ?></td> <!--담당자 -->
         <td class="td_datetime"><?php echo date("Y-m-d H:i", strtotime($list[$i]['wr_datetime'])) ?></td>
         <td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
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
     <?php if ($is_checkbox) { ?>
     <ul class="btn_bo_adm">
         <li><input type="submit" name="btn btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
         <li><input type="submit" name="btn btn_submit2" value="담당자변경"></li>
         <li><input type="submit" name="btn btn_submit3" value="게시물숨김"></li>
     </ul>
     <?php } ?>

     <?php if ($list_href || $write_href) { ?>
     <ul class="btn_bo_user">
         <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn btn_b01">목록</a></li><?php } ?>
         <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn_b02">글쓰기</a></li><?php } ?>
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
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');

$colspan = 10;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<?php
//소속처리
include(G5_PATH.'/inc/_inc_adm_belong.php');
?>
<h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2>

<div id="view_notice">
	<ul>
		<li>
        ※ 담당자 변경방법<br>
         <p>
         방법. 1<br>
         ① 사원명을 입력 후 해당 담당자를 선택하세요.<br>
         ② 체크박스 선택 후 '선택담당자' 버튼을 클릭하세요.<br>
         
		 방법. 2<br>
         ① 체크박스 선택 후 '담당자일괄변경' 버튼을 클릭하세요.<br>
         ② 오픈된 팝업창에서 변경할 사원명을 입력 후 담당자를 선택하세요.<br>
		 ③ '담당자일괄변경' 버튼을 클릭하세요.<br>
         </p>
		</li>
	</ul>
</div>


<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

	<!-- 검색 -->
	<?php
	//검색폼
	include(G5_PATH.'/inc/_inc_adm_belong_search.php');
	?>

	<!-- 게시판 업종 시작 { -->
	<form name="fsectors" id="fsectors">
		<select name="sear_wr_8" id="sear_wr_8" onchange="doAction(this.value)">
			<option value="">업종 선택 </option>
            <?=codeToHtml($code_sectors, $sear_wr_8, "cbo", "")?>
        </select>
	</form>
    <script>   
    function doAction(a){
		$("#fsearch #wr_8").val(a);
		$("#fsectors").attr("method", "post");
		$("#fsectors").submit();
    }
    </script>
	<!-- } 게시판 업종 끝 -->

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
            <th scope="col"><?php echo subject_sort_link('wr_19', $qstr2, 1) ?>노출여부</a></th>
            <th scope="co;">업종</th>
            <th scope="col">제목</th>
			<th scope="col">원글작성자</th>
            <th scope="col">담당자</th>
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
                <label for="chk_bn_id<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
				<input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i ?>">
				<input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
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
            <td class="td_hide"><?=codeToName($code_hide, $list[$i]['wr_19'])?></td>
            <td class="td_cate"><?php echo $list[$i]['wr_8'] ?></td>
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
                //if ($list[$i]['icon_file']) echo '<i class="fas fa-file-image"></i>';
                if ($list[$i]['icon_link']) echo '<i class="fa fa-link"></i>';
                //if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                ?>
            </td>
            <td class="td_name sv_use"><?php echo $list[$i]['wr_name'] ?></td>
            <td class="td_manager">
				<input type="text" name="wr_18[]" value="<?php echo $list[$i]['name'] ?>" id="wr_18_<?php echo $i ?>" class="frm_input chk_wr_18 ui-autocomplete-input" placeholder="담당자">
				<input type="hidden" name="wr_17[]" value="<?php echo $list[$i]['wr_17'] ?>" id="wr_17_<?php echo $i ?>">
			</td> <!--담당자 -->
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
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택노출" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택숨김" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택담당자" onclick="document.pressed=this.value"></li>
            <li><input type="submit" class="btn_bg" name="btn_submit" value="담당자일괄변경" onclick="document.pressed=this.value"></li>
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
        if (f.elements[i].name == "chk_bn_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "담당자일괄변경") {
        select_copy("proc_marketer");
        return;
    }

    if(document.pressed == "처리일괄변경") {
        select_copy("proc_state");
        return;
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

	url = './move.php';

    if (sw == "proc_marketer"){
        str = "담당자일괄변경";
		url = './proc_all.php';
    }else if (sw == "proc_state"){
        str = "처리일괄변경";
		url = './proc_all.php';
     }else if (sw == "copy"){
        str = "복사";
    }else{
        str = "이동";
	}

   var sub_win = window.open("", sw, "left=50, top=50, width=450, height=300, scrollbars=1");

    f.sw.value = sw;
    f.target = sw;
    f.action = url;
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->

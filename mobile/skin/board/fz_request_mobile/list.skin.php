<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">', 0);
add_javascript('<script type="text/javascript" src="'.$board_skin_url.'/js/default.js"></script>', 100);
?>
<?php
include(G5_PATH.'/inc/m_menu.php');
?>
<!-- 시작 -->
<div class="m_contents clearfix" style="padding-bottom:8%;">

<div class="img100 clearfix">
		<img src="<?=G5_MOBILE_URL?>/images/sub_visual06.jpg" alt="">
</div>

<!-- <h2 id="container_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2> -->
<!-- 게시판 목록 시작 -->
<div id="bo_list" class="fz_wrap" style="margin-top:4%">
    <?php if ($is_category) { ?>
    <div id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </div>
    <?php } ?>

	<div class="fz_header">
		<div class="fl fz_total_count"><span class="total_count"> Total <strong><?php echo number_format($total_count) ?></strong>건</span></div>
		<? if ($rss_href) { ?><div class="fz_rss fr"><a class="list_btn btn_rss" href="<?=$rss_href?>" title="RSS">RSS</a></div><?php }?>
	</div>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

	<table class='fz_board'>
		<thead>
		<tr>
		<?php if ($is_checkbox) { ?>
			<th scope="col" width="30px">
				<input type="checkbox" id="chkall" />
			</th>
			<?php } ?>
			<th scope="col">제목</th>
			<th scope="col" width="70px"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</a></th>
		</tr>
		</thead>
		<tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
			if($list[$i]['wr_10'] == "신규"){
				$img_num = "ing";
			}else if($list[$i]['wr_10'] == "접수"){
				$img_num = "ing";
			}else if($list[$i]['wr_10'] == "진행"){
				$img_num = "sell";
			}else if($list[$i]['wr_10'] == "완료"){
				$img_num = "end";
			}

			if($list[$i]['is_notice']) $list[$i]['article_type']="<strong class='icon_notice'>공지</strong>";
			else if($list[$i]['icon_secret']) $list[$i]['article_type'] = "<span class='icon_pack2 icon_secret2'>비밀글</span>";
			else if($list[$i]['icon_file']) $list[$i]['article_type'] = "<span class='icon_pack2 icon_file2'>파일첨부</span>";
			else $list[$i]['article_type'] = "<span class='icon_pack2 icon_txt2'>텍스트</span>";

			if($list[$i]['icon_link']) $list[$i]['icon_pack'] .= "<span class='icon_pack icon_link'>링크</span>";
			if($list[$i]['icon_new']) $list[$i]['icon_pack'] .= "<span class='icon_pack icon_new'>새글</span>";
			if($list[$i]['wr_reply']) $list[$i]['icon_reply'] = "<span class='icon_pack2 icon_reply re".strlen($list[$i][wr_reply])."'>답변</span>";
        ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
				<label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
				<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
			</td><?php } ?>
			<td class="al td_subject">
                <a href="<?php echo $list[$i]['href'] ?>">

				<?php
				echo $list[$i]['icon_reply'];
				echo $list[$i]['article_type'];
				if ($is_category && $list[$i]['ca_name']) {
				 ?>
				<span class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></span>
				<?php } ?>

				<?=substr($list[$i]['wr_name'], 0, -6).'**'?> <?php echo $list[$i]['subject'] ?>
				<?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
				<?=$list[$i][icon_pack]?>
                </a>

            </td>
            <td class="td_datetime"><?php echo date("Y-m-d", strtotime($list[$i]['wr_datetime'])) ?></td>
        </tr>
		<?php } ?>
		<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="fz_empty_list">게시물이 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>

	<div class="fz_footer">
        <?php $is_checkbox = false;if ($is_checkbox) { ?>
		<div id="fz_admin_select">
			<select name="btn_submit" id="">
				<option value="">선택명령</option>
				<option value="선택삭제">선택삭제</option>
				<option value="선택복사">선택복사</option>
				<option value="선택이동">선택이동</option>
			</select>
		</div>
        <?php } ?>
		<div class="fr">
            <?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="list_btn btn_list">목록</a><?php } ?>
            <?php if ($write_href) { ?><a class="list_btn btn_write" href="<?=$write_href?>" title="견적문의">견적문의</a><?php } ?>
		</div>
	</div>
    </form>


	<?php if($is_checkbox) { ?>
	<noscript>
	<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
	</noscript>
	<?php } ?>

	<!-- 페이지 -->
<?php 
	$write_pages=str_replace("처음", "<i class='fa fa-angle-left'></i><i class='fa fa-angle-left'></i>", $write_pages);
	$write_pages=str_replace("이전", "<i class='fa fa-angle-left'></i>", $write_pages);
	$write_pages=str_replace("다음", "<i class='fa fa-angle-right'></i>", $write_pages);
	$write_pages=str_replace("맨끝", "<i class='fa fa-angle-right'></i><i class='fa fa-angle-right'></i>", $write_pages);
	echo $write_pages; 
?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>
    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
	<span class="select_box">
    <select name="sfl" id="sfl" style="width:80px;height:27px">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
    </select>
	</span>
	<span class="placeholder">
		<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="i_text w_sbox required" size="15" maxlength="20" placeholder="검색어 필수">
	</span>
	<input type="image" src="<?=G5_MOBILE_URL?>/images/remove.png" class="btn_search_submit" alt="검색"/>

    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

</div>

<?php if ($is_checkbox) { ?>
<script type="text/javascript">
$(function(){
	$("#chkall").click(function(){
		$(".fz_board tbody input[type='checkbox']").prop("checked", $(this).prop("checked"));
	});
	$("#fz_admin_select").select_box({
		height:24,
		onchange:function(p, $select, ul){
			if(!$select.val()) return false;

			if(!$(".fz_board tbody input[type='checkbox']:checked").length)
			{
				alert($select.val()+" 할 게시물을 하나 이상 선택하세요.");
				$select.find("option").eq(0).prop("selected", true).change();
				return false;
			}

			if($select.val()=="선택복사" || $select.val()=="선택이동")
			{
				var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

				$("#fboardlist input[name='sw']").val($select.val()=="선택복사" ? "copy" : "move");
				$("#fboardlist").attr("target", "move");
				$("#fboardlist").attr("action", "./move.php");
				$("#fboardlist").submit();
			}
			else if($select.val()=="선택삭제")
			{
				if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
					return false;

				$("#fboardlist").attr("target", "");
				$("#fboardlist").attr("action", "./board_list_update.php");
				$("#fboardlist").submit();
			}
		}
	});
});
</script>
<?php } ?>

<!-- 게시판 목록 끝 -->

<script type="text/javascript">
$(function(){
	$(".select_box").select_box();
});
</script>

</div>
<!-- 끝 -->

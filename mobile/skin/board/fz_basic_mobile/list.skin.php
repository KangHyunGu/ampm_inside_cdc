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

<section class="m_sub_visual">
    <img src="<?=G5_URL?>/images/m_img_sub1.jpg" />
    <div class="text_wrap">
        <ul class="text">
            <li>
                <h1>인사말</h1>
            </li>
            <li>
                <p>진진수라를 방문해주신 고객 여러분을 진심으로 환영합니다.</p>
            </li>
        </ul>
    </div>
</section>



<section id="m_sub1">
    <article id="brand" class="brand">
            <img class="logo" src="<?=G5_URL?>/images/logo_black.png">
            <h2>안녕하세요. <b>진진수라 광화문점</b>을 방문해주신 고객 여러분을 진심으로 환영합니다.</h2>
            <div class="img1">
                <img src="<?=G5_URL?>/images/img_sub1-1.jpg">
            </div>
            <div class="part1">
                <b>“진진하다”</b>는 입에 착착 달라붙을 정도로 맛이 좋다. 물건 따위가 풍성하게 많다 라는 뜻이며
                <b>“수라상”</b>은 고려 말과 조선시대에 “왕에게 올리던 밥상”을 높여 부르는 말입니다.<br>
                <div class="part1-2">
                    <b>“진진수라”</b>는 정갈하고 맛있는 요리, 기품있고 세심한 서비스를 통해                    <b>왕에게 올리는 밥상</b>처럼 고객님들께
                    최상의 경험을 제공하는 것을 목표로 합니다.
                </div>
            </div>

            <img class="img2" src="<?=G5_URL?>/images/img_sub1-2.jpg">
            <div class="part2">
                멋스럽고 기품있는 인테리어와 특급호텔보다 수준높은 서비스로 외국인 손님이나 
                VIP 접대에도 부족함이 없으며 한정식 전문가들이 모여 탄생시킨
                음식의 구성 및 퀄리티는 어떠한 만찬자리에도 잘 어울릴 것이라 믿어 의심치 않습니다.<br><br>

                진진수라에서는 실속있는 가격의 식사메뉴부터 접대를 위한 코스요리까지 최고로 준비되어 있습니다.<br>
                크고 작은 각종 모임과 돌잔치 및 회갑잔치, 스몰웨딩, 상견례 등 가족 연회장소로 최적화되어
                있으며 세미나, 기자간담회 및 회식장소로 독립적인 공간에서 편안한 외식을 즐길 수 있도록
                다양한 크기의 룸을 완비하였습니다.<br>
                진진수라에서 즐겁고 뜻깊은 자리가 되시길 바랍니다.<br><br>

                <b>진진수라 대표이사 외 직원 일동</b>
            </div>
    </article>



    <article id="notice" class="notice">

        <!-- 게시판 목록 시작 { -->
        <section class="wrap">
            <div class="subtitle">
                <h1>공지사항</h1>
                <div class="line"></div>
            </div>

            <div id="bo_list" class="fz_wrap">
                <?php if ($is_category) { ?>
                <div id="bo_cate">
                    <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
                    <ul id="bo_cate_ul">
                        <?php echo $category_option ?>
                    </ul>
                </div>
                <?php } ?>

<!--
                <div class="fz_header">
                    <div class="fl fz_total_count"><span class="total_count"> Total <strong><?php echo number_format($total_count) ?></strong>건</span></div>
                    <? if ($rss_href) { ?>
                    <div class="fz_rss fr"><a class="list_btn btn_rss" href="<?=$rss_href?>" title="RSS">RSS</a></div><?php }?>
                </div>
-->

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

                                        <?php echo $list[$i]['subject'] ?>
                                        <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                                        <?=$list[$i][icon_pack]?>
                                    </a>

                                </td>
                                <td class="td_date"><?php echo $list[$i]['datetime2'] ?></td>
                            </tr>
                            <?php } ?>
                            <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="fz_empty_list">게시물이 없습니다.</td></tr>'; } ?>
                        </tbody>
                    </table>

                    <div class="fz_footer">
                        <?php if ($is_checkbox) { ?>
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
                            <?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>" class="list_btn btn_adm">관리자</a><?php } ?>
                            <?php if ($write_href) { ?><a class="list_btn btn_write" href="<?=$write_href?>" title="글쓰기">글쓰기</a><?php } ?>
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
<!--                        <label for="sfl" class="sound_only">검색대상</label>-->
                        <span class="select_box">
                            <select name="sfl" id="sfl">
                                <option value="wr_subject" <?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                                <option value="wr_content" <?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                                <option value="wr_subject||wr_content" <?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                            </select>
                        </span>
                        <span class="placeholder">
                            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="i_text w_sbox required" size="10" maxlength="10" placeholder="검색어 필수">
                        </span>
                        <input type="submit" class="btn_search_submit" value="검색" />

                    </form>
                </fieldset>
                <!-- } 게시판 검색 끝 -->

            </div>

            <?php if ($is_checkbox) { ?>
            <script type="text/javascript">
                $(function() {
                    $("#chkall").click(function() {
                        $(".fz_board tbody input[type='checkbox']").prop("checked", $(this).prop("checked"));
                    });
                    $("#fz_admin_select").select_box({
                        height: 24,
                        onchange: function(p, $select, ul) {
                            if (!$select.val()) return false;

                            if (!$(".fz_board tbody input[type='checkbox']:checked").length) {
                                alert($select.val() + " 할 게시물을 하나 이상 선택하세요.");
                                $select.find("option").eq(0).prop("selected", true).change();
                                return false;
                            }

                            if ($select.val() == "선택복사" || $select.val() == "선택이동") {
                                var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

                                $("#fboardlist input[name='sw']").val($select.val() == "선택복사" ? "copy" : "move");
                                $("#fboardlist").attr("target", "move");
                                $("#fboardlist").attr("action", "./move.php");
                                $("#fboardlist").submit();
                            } else if ($select.val() == "선택삭제") {
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
                $(function() {
                    $(".select_box").select_box();
                });

            </script>

            </article>
</section>
            <!-- 끝 -->

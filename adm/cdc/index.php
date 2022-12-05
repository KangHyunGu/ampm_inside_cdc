<?php
$sub_menu = '700000';
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.sub.head.php');

echo '<link rel="stylesheet" href="' . G5_ADMIN_URL . '/css/admin.css">' . PHP_EOL;
include(CDC_PATH . '/cdc_cdn_include.php');
echo '<link rel="stylesheet" href="' . CDC_CSS_URL . '/quasar.css">' . PHP_EOL;
echo '<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">' . PHP_EOL;
echo '<link rel="stylesheet" href="' . CDC_CSS_URL . '/cdc-style.css">' . PHP_EOL;
echo '<link rel="stylesheet" href="../css/custom.css">' . PHP_EOL;


$colspan = 12;
?>
<?php
$is_checkbox = false;

$sql_common = " 
                FROM (
                    SELECT *, 'insight' as bo_table
                    FROM g5_write_insight 
                    union
                    SELECT *, 'reference' as bo_table
                    FROM g5_write_reference 
                    union
                    SELECT *, 'video' as bo_table
                    FROM g5_write_video
                ) a
                INNER JOIN g5_board b ON a.bo_table = b.bo_table
                WHERE b.gr_id='inside'
";

$sql_common .= " and a.wr_id = a.wr_parent ";

//검색추가
if ($sear_bo_table) {
    //$is_checkbox = true;
    $sql_common .= " and a.bo_table = '{$sear_bo_table}' ";
}
if ($stx && $sfl) {
    //$is_checkbox = true;
    $sql_common .= " and ({$sfl} like '%{$stx}%') ";
}

//$sql_order = " order by a.wr_datetime desc ";
$sql_order = " 
order by (SELECT IFNULL(is_blog, '') FROM g5_wr_cdc WHERE bo_table=a.bo_table AND wr_id=a.wr_id ) desc 
, (SELECT IFNULL(is_youtube, '') FROM g5_wr_cdc WHERE bo_table=a.bo_table AND wr_id=a.wr_id ) desc 
, (SELECT IFNULL(is_insta, '') FROM g5_wr_cdc WHERE bo_table=a.bo_table AND wr_id=a.wr_id ) desc 
, a.wr_datetime desc
";

$sql = " select count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$list = array();
$sql = " select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
//echo $sql; 
$result = sql_query($sql);

for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];
    if ($row['wr_id'] == $row['wr_parent']) {
        // 원글
        $comment = "";
        $comment_link = "";

        //CDC 항목 추가(OUTER JOIN으로 데이터를 가져와야 하는데 
        //CDC의 정보가 없을때 wr_id가 null값 나오는 경우가 있어 select 문 skin.wr_id 추가)
        $skin_sql = " select *, skin.wr_id from {$tmp_write_table} skin";
        $outer_join_str = "LEFT OUTER JOIN g5_wr_cdc cdc";
        $on_str = " ON cdc.bo_table = '{$row['bo_table']}' AND cdc.wr_id = '{$row['wr_id']}'";
        $sel_sql = "{$skin_sql} {$outer_join_str} 
        {$on_str} 
        where skin.wr_id = '{$row['wr_id']}'";

        $row2 = sql_fetch($sel_sql);
        $list[$i] = $row2;

        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row2['wr_datetime'], 0, 10);
        $datetime2 = $row2['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2, 11, 5);
        } else {
            $datetime2 = substr($datetime2, 5, 5);
        }

        $mk_id = $row2['wr_17'];
        $mk_name = $row2['wr_18'];
    }

    $list[$i]['gr_id'] = $row['gr_id'];
    $list[$i]['bo_table'] = $row['bo_table'];
    //$list[$i]['name'] = $name;
    $list[$i]['name'] = $row['wr_name'];
    $list[$i]['mk_id'] = $mk_id;
    $list[$i]['mk_name'] = $mk_name;
    $list[$i]['comment'] = $comment;

    if ($list[$i]['gr_id'] == 'client' && $list[$i]['bo_table'] == 'request') {
        if ($member['ampmkey'] == 'Y') {
            $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
        } else {
            $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
        }
    } else if ($list[$i]['gr_id'] == 'marketer' && $list[$i]['bo_table'] == 'mkestimate') {
        $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
    } else {
        $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
    }
    $list[$i]['href'] = '';

    $list[$i]['datetime'] = $datetime;
    $list[$i]['datetime2'] = $datetime2;

    $list[$i]['icon_new'] = '';
    if ($board['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
        $list[$i]['icon_new'] = '<img src="' . $skin_url . '/img/icon_new.gif" alt="새글">';

    $list[$i]['comment_cnt'] = '';
    if ($list[$i]['wr_comment'])
        $list[$i]['comment_cnt'] = "<span class=\"cnt_cmt\">" . $list[$i]['wr_comment'] . "</span>";

    $list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
    $list[$i]['wr_subject'] = $row2['wr_subject'];
    $list[$i]['cm_content'] = $cm_content;

    $list[$i]['wr_ip']  = $row2['wr_ip'];
    $list[$i]['cdc_files'] = get_file_cdc($row['bo_table'], $row['wr_id']);
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;go_table=$go_table&amp;mk_id=$mb_id&amp;page=");
?>
<!-- admin_cdc_app -->
<div id="admin_cdc_app">

    <!-- cdc_list -->
    <div id="cdc_list">
        <div class="cdc_title">CDC 컨텐츠</div>
			<!-- 검색, 글쓰기 버튼 -->
			<div class="bt_wrap">

				<div class="bo_fx">
					<!-- CDC 용 스킨페이지 구성 필요 -->
					<ul class="btn_bo_adm">
                  		<li><a href="<?=G5_ADMBBS_URL?>/board.php?bo_table=insight" class="btn_b04">인사이트</a></li>
					</ul>
				</div>

			</div> 
			<!-- } 검색, 글쓰기 버튼 -->

        <!-- 전체게시물 목록 시작 { -->
        <form name="fnewlist" id="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
            <input type="hidden" name="sw" value="move">
            <input type="hidden" name="view" value="<?php echo $view; ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
            <input type="hidden" name="stx" value="<?php echo $stx; ?>">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
            <input type="hidden" name="go_table" value="<?php echo $go_table ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <input type="hidden" name="pressed" value="">

            <div class="tbl_head01 tbl_wrap cdc_table">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <?php if ($is_checkbox) { ?>
                                <th scope="col">
                                    <label for="all_chk" class="sound_only">현재 페이지 게시물 전체</label>
                                    <input type="checkbox" id="all_chk">
                                </th>
                            <?php } ?>
                            <th scope="co;">게시판</th>
                            <th scope="co;">노출여부</th>
                            <th scope="col">매체</th>
                            <th scope="col">제목</th>
                            <th scope="col">내용확인</th>
                            <th scope="col">매체등록</th>
                            <th scope="col">작성자</th>
                            <th seope="col">담당자</th>
                            <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일</a></th>
                        </tr>
                    </thead>

                    <tbody class="bo_tr">
                        <?php
                        for ($i = 0; $i < count($list); $i++) {
                            $list[$i]['num'] = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
                            $bo_subject = cut_str($list[$i]['bo_subject'], 20);
                            $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
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
                                <?php if ($is_checkbox) { ?>
                                    <td class="td_chk">
                                        <label for="chk_bn_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                                        <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i ?>">
                                        <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
                                        <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
                                    </td>
                                <?php } ?>
                                <td class="td_board">
                                    <!-- 인사이트 / 교육영상 / 레퍼런스 -->
                                    <?php echo $bo_subject ?>
                                </td>
                                <td class="td_board">
                                    <!-- 노출여부 -->
                                    <?=codeToName($code_hide, $list[$i]['wr_19'])?>
                                </td>
                                <td class="td_media">
                                    <!-- 업로드 된 매체 아이콘만 보이기 -->
                                    <ul>
                                        <!-- blog -->
                                        <?php
                                        $blog_class = $list[$i]['wr_comp_blog_link'] != '' ? 'blog on' : 'blog';
                                        $insta_class = $list[$i]['wr_comp_insta_link'] != '' ? 'instagram on' : 'instagram';
                                        $youtube_class = $list[$i]['wr_comp_youtube_link'] != '' ? 'youtube on' : 'youtube';
                                        $is_blog = $list[$i]['is_blog'];
                                        $is_insta = $list[$i]['is_insta'];
                                        $is_youtube = $list[$i]['is_youtube'];
                                        $is_cdc_view = $is_blog == 'Y' || $is_insta == 'Y' || $is_youtube == 'Y';
                                        ?>
                                        <!-- blog -->
                                        <li v-if="'<?php echo $is_blog == 'Y'; ?>'" class="<?php echo $blog_class ?>">
                                            <!-- 업로드 된 매체는 'on' class추가 -->
                                            <a :href="'<?php echo $blog_class == 'blog on'; ?>'
                                            ? '<?php echo $list[$i]['wr_comp_blog_link'] ?>'
                                            : '#'" target="blank">
                                            </a>
                                        </li>
                                        <!-- instagram -->
                                        <li v-if="'<?php echo $is_insta == 'Y'; ?>'" class="<?php echo $insta_class ?>">
                                            <a :href="'<?php echo $insta_class == 'instagram on'; ?>'
                                            ? '<?php echo $list[$i]['wr_comp_insta_link'] ?>'
                                            : '#'" target="blank">
                                            </a>
                                        </li>
                                        <!-- youtube -->
                                        <li v-if="'<?php echo $is_youtube == 'Y'; ?>'" class="<?php echo $youtube_class ?>">
                                            <a :href="'<?php echo $youtube_class == 'youtube on'; ?>' 
                                            ? '<?php echo $list[$i]['wr_comp_youtube_link'] ?>'
                                            : '#'" target="blank">
                                            </a>

                                        </li>
                                    </ul>
                                </td>
                                <td class="td_subject">
                                    <a class="upload">
                                        <!-- href="<?php echo $list[$i]['href'] ?>" javascript:" onclick="alert('미리보기'); -->
                                        <?php echo cut_str(get_text($wr_subject), 30) ?>
                                    </a>
                                </td>
                                <td class="td_view">
                                    <q-btn class="cdc-modal-btn" v-if="'<?php echo $is_cdc_view; ?>'" @click="cdcModalOn(<?php echo $i ?>)" size="sm" icon="description" />
                                </td>
                                <td class="td_upload">
                                    <!-- 미완료 / 완료 -->
                                    <div>
                                        <q-btn v-if="phpCompControl(<?php echo $i; ?>)" @click="cdcModalCompOn(<?php echo $i ?>)" class="cdc-modal-btn" :style="phpIsCdcComp(<?php echo $i; ?>) ? '' : 'color: red'">
                                            {{phpIsCdcComp(<?php echo $i; ?>) ? '완료' : '미완료'}}
                                        </q-btn>
                                    </div>
                                </td>
                                <td class="td_name">
                                    <?php echo $list[$i]['name'] ?>
                                </td>
                                <td class="td_manager">
                                    <?php echo $list[$i]['mk_name'] ?>
                                </td>
                                <td class="td_datetime"><?php echo date("Y-m-d H:i", strtotime($list[$i]['wr_datetime'])) ?></td>
                            </tr>
                        <?php }  ?>
                        <?php if (count($list) == 0) {
                            echo '<tr><td colspan="' . $colspan . '" class="empty_table">게시물이 없습니다.</td></tr>';
                        } ?>
                    </tbody>
                </table>

            </div>

            <!-- 페이지 -->
            <?php echo $write_pages;  ?>
        </form>

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
                        <?= codeToHtml($code_botable, $sear_bo_table, "cbo", "") ?>
                    </select>

                    <label for="sfl" class="sound_only">검색대상</label>
                    <select name="sfl" id="sfl">
                        <option value="wr_subject" <?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                        <option value="wr_content" <?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                        <option value="wr_subject||wr_content" <?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                        <option value="wr_name" <?php echo get_selected($sfl, 'wr_name'); ?>>작성자</option>
                        <option value="wr_18" <?php echo get_selected($sfl, 'wr_18'); ?>>담당자</option>
                    </select>
                    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="sch_input frm_input " size="15" maxlength="20">
                    <input type="submit" value="검색" class="sch_btn">
                </form>
            </fieldset>
        </div>

        <?php if ($is_checkbox) { ?>
            <noscript>
                <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
            </noscript>
        <?php } ?>

    </div>
    <!-- //cdc_list -->



    <!-- CDC 업로드 모달 -->
    <div id="cdcUpload" class="cdc-upload-modal">
        <div class="cdc-modal-con">
            <?php include("./cdcAdmView.php"); ?>
        </div>
    </div>
    <!-- //CDC 업로드 모달 -->


    <!-- CDC 매체등록 모달 -->
    <div v-if="isCompDialogOpen && curList && curList.wr_id" id="cdcModal" class="cdc-modal">
        <div class="cdc-modal-con">
            <?php include("./cdcCompForm.php"); ?>
        </div>
    </div>
    <!-- //CDC 매체등록 모달 -->
</div>
<!-- //admin_cdc_app -->

<!-- CDC 모듈 src include -->
<?php include("./cdcAdmFormSetting.php"); ?>

<script>
    jQuery(document).ready(function($) {

        //open popup
        // $('.cdc-modal-btn').on('click', function(event){
        //     event.preventDefault();
        //     $('.cdc-modal').addClass('on');
        // });

        //close popup
        // $('.cdc-modal').on('click', function(event){
        //     if( $(event.target).is('.close') || $(event.target).is('.cdc-modal') ) {
        //         event.preventDefault();
        //         $(this).removeClass('on');
        //     }
        // });
    });

    jQuery(document).ready(function($) {
        //open popup
        // $('.upload').on('click', function(event){
        //  event.preventDefault();
        //  $('.cdc-upload-modal').addClass('on');
        // });

        //close popup
        // $('.cdc-upload-modal').on('click', function(event){
        //  if( $(event.target).is('.close-cdc') || $(event.target).is('.cdc-upload-modal') ) {
        //      event.preventDefault();
        //      $(this).removeClass('on');
        //  }
        // });
    });
</script>



<?php if ($is_checkbox) { ?>
    <script>
        $(function() {
            $('#all_chk').click(function() {
                $('[name="chk_bn_id[]"]').attr('checked', this.checked);
            });
        });

        function fnew_submit(f) {
            f.pressed.value = document.pressed;

            var cnt = 0;
            for (var i = 0; i < f.length; i++) {
                if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
                    cnt++;
            }

            if (!cnt) {
                alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                return false;
            }

            if (!confirm("선택한 게시물을 정말 " + document.pressed + " 하시겠습니까?\n\n삭제의 경우 한번 삭제한 자료는 복구할 수 없습니다")) {
                return false;
            }

            f.action = "./mypage_delete.php";

            return true;
        }
    </script>
<?php } ?>
<!-- } 전체게시물 목록 끝 -->

<?php
include_once(G5_ADMIN_PATH . '/admin.sub.tail.php');
?>
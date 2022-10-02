<?php
$sub_menu = '700000';
include_once('./_common.php');
include_once(G5_ADMIN_PATH.'/admin.sub.head.php');

echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
include(CDC_PATH.'/cdc_cdn_include.php');
echo '<link rel="stylesheet" href="' . CDC_CSS_URL . '/quasar.css">'.PHP_EOL;
echo '<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">'.PHP_EOL;
echo '<link rel="stylesheet" href="' . CDC_CSS_URL . '/cdc-style.css">'.PHP_EOL;

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
                    union
                    SELECT *, 'insight_cdc' as bo_table
                    FROM g5_write_insight_cdc 
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

$sql_order = " order by a.wr_datetime desc ";

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

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'].$row['bo_table'];
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
        $datetime = substr($row2['wr_datetime'],0,10);
        $datetime2 = $row2['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2,11,5);
        } else {
            $datetime2 = substr($datetime2,5,5);
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
    
    if($list[$i]['gr_id'] == 'client' && $list[$i]['bo_table'] == 'request'){
        if($member['ampmkey'] == 'Y'){
            $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
        }else{
            $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
        }

    }else if($list[$i]['gr_id'] == 'marketer' && $list[$i]['bo_table'] == 'mkestimate'){
        $list[$i]['href'] = get_pretty_mypage_url($row['bo_table'], $row2['wr_id'], $comment_link, '', $go_table);
    
    }else{
        $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
    }
    $list[$i]['href'] = '';

    $list[$i]['datetime'] = $datetime;
    $list[$i]['datetime2'] = $datetime2;

    $list[$i]['icon_new'] = '';
    if ($board['bo_new'] && $list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
        $list[$i]['icon_new'] = '<img src="'.$skin_url.'/img/icon_new.gif" alt="새글">';

    $list[$i]['comment_cnt'] = '';
    if ($list[$i]['wr_comment'])
       $list[$i]['comment_cnt'] = "<span class=\"cnt_cmt\">".$list[$i]['wr_comment']."</span>";

    $list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
    $list[$i]['wr_subject'] = $row2['wr_subject'];
    $list[$i]['cm_content'] = $cm_content;

    $list[$i]['wr_ip']  = $row2['wr_ip'];
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id=$gr_id&amp;view=$view&amp;go_table=$go_table&amp;mk_id=$mb_id&amp;page=");
?>
<!-- admin_cdc_app -->
 <div id="admin_cdc_app">

    <!-- cdc_list -->
    <div id="cdc_list">
    <div class="cdc_title">CDC 컨텐츠</div>

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
                <th scope="col">매체</th>
                <th scope="col">제목</th>
                <th scope="col">매체등록</th>
                <th scope="col">작성자</th>
                <th seope="col">담당자</th>
                <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>등록일</a></th>
                </tr>
            </thead>

            <tbody class="bo_tr">
                <?php
                for ($i=0; $i<count($list); $i++){
                    $list[$i]['num'] = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
                    $bo_subject = cut_str($list[$i]['bo_subject'], 20);
                    $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
                ?>
                <?php echo $i; ?>
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
                <td class="td_media">
                        <!-- 업로드 된 매체 아이콘만 보이기 -->
                        <ul>
                    <!-- blog -->
                    <?php 
                        $blog_class=$list[$i]['is_blog'] == 'Y' ? 'blog on' : 'blog';
                        $insta_class=$list[$i]['is_insta'] == 'Y' ? 'instagram on' : 'instagram';
                        $youtube_class=$list[$i]['is_youtube'] == 'Y' ? 'youtube on' : 'youtube'; 
                    ?>
                            <li class="<?php echo $blog_class ?>"> <!-- 업로드 된 매체는 'on' class추가 -->
                                <a href="#" target="blank">
                                </a>
                            </li>
                            <!-- instagram -->
                            <li class="<?php echo $insta_class ?>">
                                <a href="#" target="blank">
                                </a>
                            </li>
                            <!-- youtube -->
                            <li class="<?php echo $youtube_class ?>">
                                <a href="#" target="blank">
                                </a>
                            </li>
                        </ul>
                    </td>
                    <td class="td_subject">
                        <a class="upload" @click="cdcModalOn(<?php echo $i ?>)"> <!-- href="<?php echo $list[$i]['href'] ?>" javascript:" onclick="alert('미리보기'); -->
                            <?php echo cut_str(get_text($wr_subject),30) ?>
                        </a>
                    </td>
                    <td class="td_upload">
                        <!-- 미완료 / 완료 -->
                        <button class="cdc-modal-btn">미완료</button>
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
                <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
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
                <?=codeToHtml($code_botable, $sear_bo_table, "cbo", "")?>
            </select>

            <label for="sfl" class="sound_only">검색대상</label>
            <select name="sfl" id="sfl">
                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                <option value="wr_name"<?php echo get_selected($sfl, 'wr_name'); ?>>작성자</option>
                <option value="wr_18"<?php echo get_selected($sfl, 'wr_18'); ?>>담당자</option>
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

    </div>
    <!-- //cdc_list -->

            

    <!-- CDC 업로드 모달 -->
    <div id="cdcUpload" class="cdc-upload-modal">
    <div class="cdc-modal-con">
        <button @click="cdcModalClose" class="close-cdc">&times;</button>
        <div class="cdc-title">CDC 업로드</div>
        <div class="q-pa-md">
            <div class="q-gutter-y-md">
            <q-btn-toggle
                v-model="toggleVal"
                spread
                no-caps
                toggle-color="purple"
                color="white"
                @click="toggleBtn"
                text-color="black"
                :options="curOptions"
            /> 
            </div>
        </div>



      

            <!-- <div class="topform">
                <label for="">노출매체</label></th>
                <div class="q-gutter-sm justify-start col-4">
                <q-checkbox size="xs" v-model="form.cdc.is_blog" name="is_blog" true-value="Y" false-value="N" label="블로그" />
                <q-checkbox size="xs" v-model="form.cdc.is_insta" name="is_insta" true-value="Y" false-value="N" label="인스타" />
                <q-checkbox size="xs" v-model="form.cdc.is_youtube" name="is_youtube" true-value="Y" false-value="N" label="유튜브" />
                </div>
            </div> -->

            <!-- 이미지 -->
            <!-- <div v-if="isImageForm" class="cdc-box">
                <label for="">이미지</label>
                <div class="q-gutter-md row items-start">
                    <imageform
                        v-for="i in 10"
                        :key="i"
                        v-show="ShowControl(i)"
                        v-model="bf_file[i - 1]"
                        :bf_file="bf_file[i - 1]"
                        @remove="removeImage"
                        style="width:140px; height:100px;"
                    >
                    </imageform>
                </div>
            </div>  -->


            <!-- 썸네일 -->
            <!-- <div v-if="isThumNail" class="cdc-box">
                <label for="">썸네일</label>
                <imageform
                v-model="bf_file[10]"
                :bf_file="bf_file[10]"
                @remove="removeImage"
                />
            </div> -->

            <!-- CTA 배너 -->
            <!-- <div v-if="isCtaVanner" class="cdc-box">
                <label for="">CTA배너</label>
                <imageform
                v-model="bf_file[11]"
                :bf_file="bf_file[11]"
                @remove="removeImage"
                >
                </imageform>
                <div v-if="bf_file[11]" class="q-gutter-md row items-start">
                <q-input 
                    name="wr_cat_link"
                    class="q-input"
                    style="margin-top:20px;"
                    outlined
                    v-model="form.cdc.wr_cat_link" 
                    label="클릭 링크를 입력해주세요" 
                    dense size="100">
                </q-input>
                </div>
            </div> -->

            <!-- 동영상 15 ~ 60 -->
            <!-- <div v-if="isShortVideo" class="cdc-box">
                <label for="">동영상(15~60초)</label>
                <inputvideo  
                v-model="form.cdc.wr_video_link"
                ref="inputvideo"
                :bf_file="bf_file[12]"
                @uploader-video="uploaderVideo($event, 'bf_file', 12)"
                /> 
            </div> -->

            <!-- 유튜브 동영상 -->
            <!-- <div v-if="isYoutubeVideo" class="cdc-box">
                <label for="">유튜브 동영상</label>
                <inputvideo  
                :clcd="'youtube'"
                ref="inputvideoYoutube"
                v-model="form.cdc.wr_youtube_link"
                :bf_file="bf_file[13]"
                @uploader-video="uploaderVideo($event, 'bf_file', 13)"
                /> 
            </div> -->

            <!-- 메인 해시태그(3개) -->
            <!-- <div v-if="isMainHashTag" class="cdc-box">
                <label for="">메인 해시태그</label>
                <div class="q-gutter-md row items-start">
                <q-input v-for="i in 3"
                        class="q-input"
                        :name="`wr_mhash_${i}`"
                        :key="i" 
                        :rules="[Rules.require({label:`메인해시태크${i}`})]" 
                        outlined
                        v-model="form.cdc[`wr_mhash_${i}`]" 
                        :label="`#${i}`" 
                        style="max-width:100%;"
                        dense size="25">
                </q-input>
                </div>
            </div> -->

            <!-- 서브 해시태그(7개) -->
            <!-- <div v-if="isSubHashTag" class="cdc-box">
                <label for="">서브 해시태그</label>
                <div class="q-gutter-md row items-start">
                <q-input v-for="i in 7" 
                        :key="i" 
                        :name="`wr_shash_${i}`"
                        :rules="[Rules.require({label:`서브해시태크${i + 3}`})]" 
                        outlined
                        v-model="form.cdc[`wr_shash_${i}`]" 
                        :label="`#${i + 3}`" 
                        dense size="25">
                </q-input>
                </div>
            </div> -->

            <!-- 유튜브 태그 -->
            <!-- <div v-if="isYtag" class="cdc-box">
                <label for="">유튜브 태그</label>
                <div class="q-gutter-md row items-start"
                style="width:100%;"
                >
                <q-input 
                        name="wr_ytag"
                        :rules="[Rules.require({label:`유튜브 태그`})]"
                        outlined
                        v-model="form.cdc.wr_ytag" 
                        label="유튜브 태그를 입력하세요" 
                        dense size="50">
                </q-input>
                </div>
            </div> -->

            <!-- 재생목록 -->
            <!-- <div v-if="isVideoList" class="cdc-box">
                <label for="">재생목록</th>
                <td>
                <div class="q-gutter-md row items-start"
                    style="width:100%;"
                >
                    <q-input 
                            name="wr_playlist_link"
                            :rules="[Rules.require({label:`재생목록`})]"
                            outlined
                            v-model="form.cdc.wr_playlist_link" 
                            label="영상재생목록 URL링크 입력하세요" 
                            dense size="100">
                    </q-input>
                </div>
                </td>
            </div> -->

            <!-- <div v-if="isCdcMode" class="q-gutter-sm col-6 q-sb">
                <q-button-group>
                <q-btn class="btn">미리보기</q-btn>
                <q-btn @click="autoSave" class="btn">임시등록</q-btn>
                <q-btn class="btn submit">등록</q-btn>
                </q-button-group>
            </div> -->
     
    </div>
    </div>
    <!-- //CDC 업로드 모달 -->


    <!-- CDC 매체등록 모달 -->
    <div id="cdcModal" class="cdc-modal">
    <div class="cdc-modal-con">
        <button class="close">&times;</button>
        
        <div class="cdc-title">링크</div>
        <form>
            <div class="cdc-con-box">
                <div class="write-area blog">
                <img src="<? G5_URL ?>/images/cdc-blog.png">
                <input type="text" name="cdc-blog" id="cdc-blog" placeholder="URL을 입력하세요.">
                </div>
                <div class="write-area instagram">
                <img src="<? G5_URL ?>/images/cdc-instagram.png">
                <input type="text" name="cdc-insta" id="cdc-insta" placeholder="URL을 입력하세요.">
                </div>
                <div class="write-area youtube">
                <img src="<? G5_URL ?>/images/cdc-youtube.png">
                <input type="text" name="cdc-youtube" id="cdc-youtube" placeholder="URL을 입력하세요.">
                </div>
                <button class="write-btn">확인</button>
            </div>
        </form>
    </div>
    </div>

    <script src="<?= CDC_JS_URL ?>/cdcCommon.js?v=<?= CDC_VER ?>"></script>
    <script>
        // vue setting
        // Vue 생성 전 setting 처리
        const list = <?php echo json_encode($list) ?>;
        const phpConfig = <?php echo json_encode($config) ?>;
    </script>
    <!-- CDC 모듈 Admin-->
    <script src="<?= CDC_JS_URL ?>/adm/admVue.js?v=<?= CDC_VER ?>"></script>
    
    <!-- //CDC 매체등록 모달 -->
 
</div>
<!-- //admin_cdc_app -->

<script>
jQuery(document).ready(function($){
    //open popup
    $('.cdc-modal-btn').on('click', function(event){
        event.preventDefault();
        $('.cdc-modal').addClass('on');
    });
    
    //close popup
    $('.cdc-modal').on('click', function(event){
        if( $(event.target).is('.close') || $(event.target).is('.cdc-modal') ) {
            event.preventDefault();
            $(this).removeClass('on');
        }
    });
});

jQuery(document).ready(function($){
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

<?php
include_once(G5_ADMIN_PATH.'/admin.sub.tail.php');
?>

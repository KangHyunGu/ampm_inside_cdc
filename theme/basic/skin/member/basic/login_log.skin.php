<?php
/**************************
@Filename: login_log.skin.php
@Version : 0.1
@Author  : Freemaster(http://freemaster.kr)
@Date  : 2016/04/01 Fri Am 10:03:24
@Content : PHP by Editplus
**************************/
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
if($is_admin)
{
?>
<!-- 전체검색 시작 { -->
<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
<input type="hidden" name="srows" value="<?php echo $srows ?>">
<fieldset id="sch_res_detail">
    <legend>상세검색</legend>
    <?php echo $group_select ?>
    <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>

    <label for="sfl" class="sound_only">검색조건</label>
    <select name="sfl" id="sfl">
        <option value="mb_id" <?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
    </select>

    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="frm_input required" maxlength="20">
    <input type="submit" class="btn_submit" value="검색">
    <a href="<?=$_SERVER['PHP_SELF']?>" class="btn_b02" >해제</a>
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
    <!-- <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop">
    <label for="sop_or">OR</label>
    <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
    <label for="sop_and">AND</label> -->
</fieldset>
</form>
<?php
}
?>
<!-- 로그인 기록 목록 시작 { -->
<div id="sch_result">
    <?php
    if ($stx) {
    ?>
    <section id="sch_res_ov">
        <h2><?php echo $stx ?>님의 전체 로그인 결과</h2>
        <dl>
            <dt>로그인 내역</dt>
            <dd><strong class="sch_word"><?php echo number_format($total_count) ?>개</strong></dd>
        </dl>
        <p><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중</p>
    </section>
    <?php
    }
    ?>

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption>
            전체  <?php echo $total_count ?><br>
        </caption>
        <thead>
        <tr>
            <th scope="col">접속IP</th>
            <th scope="col">접속시간</th>
            <th scope="col">상태</th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $row=sql_fetch_array($result); $i++) {
        ?>
        <tr>
            <td><?php echo $is_admin?"[ ".$row['mb_id']." ]":"";?><?php echo $row['loc_ip'];?> ( <?php echo $row['loc_referer'];?> ) </td>
            <td class="td_datetime"><?php echo $row['loc_datetime'];?></td>
            <td class="td_datetime"><?php echo $login_log_array[$row['loc_success']];?></a></td>
        </tr>
        <?php }  ?>
        <?php if ($i==0) { echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>'; }  ?>
        </tbody>
        </table>
    </div>

    <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
</div>
<!-- } 로그인 기록 목록 끝 -->
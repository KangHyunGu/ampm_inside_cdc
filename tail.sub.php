<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 사용자가 지정한 tail.sub.php 파일이 있다면 include
if(defined('G5_TAIL_SUB_FILE') && is_file(G5_PATH.'/'.G5_TAIL_SUB_FILE)) {
    include_once(G5_PATH.'/'.G5_TAIL_SUB_FILE);
    return;
}
?>


<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>


<?php
}else {	//PC인 경우
	if($bodyok){
?>

<footer id="footer">
   <div class="wrapper">
      <div class="ft_link">
         <a href="<? G5_URL ?>/sub/personal.php">개인정보처리방침</a>
         <a href="<? G5_URL ?>/sub/clause.php">사용자이용약관</a>
         <a href="<? G5_URL ?>/sub/email.php">이메일무단수집거부</a>
         <?php if ($is_admin == 'super' || $is_admin == 'manager' || $is_admin == 'uploader' || $is_admin == 'ma_admin' || $is_auth) {  ?>
            <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">
               관리자페이지
            </a>
         <?php }  ?>
         <a href="<? G5_URL ?>/?device=mobile">모바일버전</a>
      </div>
      <div class="ft_copy">
         <p>Copyright © 2022 AMPM Global. All rights reserved.</p>
      </div>
   </div>
</footer>


<?php
	}
}
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->

<?php run_event('tail_sub'); ?>

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.
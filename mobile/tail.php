<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}
?>
    </div>
</div>


<!-- <?php echo poll('basic'); // 설문조사 ?>
<?php echo visit('basic'); // 방문자수 ?> -->


<div id="ft">
    <div id="ft_copy">
        <div id="ft_company">
            <a href="<? G5_URL ?>/mobile/sub/personal.php">개인정보처리방침</a>
            <a href="<? G5_URL ?>/mobile/sub/clause.php">이용약관</a>
            <a href="<? G5_URL ?>/mobile/sub/email.php">이메일무단수집거부</a>
        </div>
        Copyright © 2022 AMPM Global. All rights reserved.
        <div class="pc_btn">
            <a href="<? G5_URL ?>/?device=pc">PC버전 확인하기</a>
        </div>
    </div>

    <button type="button" id="top_btn">
        <i class="fa-solid fa-angle-up"></i>
        <span class="sound_only">상단으로</span>
    </button>
   
   <!-- <?php
    if(G5_DEVICE_BUTTON_DISPLAY && G5_IS_MOBILE) { ?>
    <a href="<?php echo get_device_change_url(); ?>" id="device_change">PC 버전으로 보기</a>
    <?php
    }

    if ($config['cf_analytics']) {
        echo $config['cf_analytics'];
    }
    ?> -->
</div>
<script>
jQuery(function($) {

    $( document ).ready( function() {

        // 폰트 리사이즈 쿠키있으면 실행
        font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
        
        //상단으로
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '300');
            return false;
        });

    });
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
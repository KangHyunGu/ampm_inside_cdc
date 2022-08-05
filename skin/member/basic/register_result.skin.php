<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>


<!-- 회원가입결과 시작 { -->
<div id="sub_layout" class="register">
   <div class="wrap">

      <div class="register_result">
         <h1 class="reg_result_p">
            <i class="fas fa-check"></i><br>
            인증메일이 발송되었습니다.
         </h1>

         <!--
         <?php if (is_use_email_certify()) {  ?>
         <p class="result_txt">
            회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
            발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
         </p>
         <div id="result_email">
            <span>아이디</span>
            <strong><?php echo $mb['mb_id'] ?></strong><br>
            <span>이메일 주소</span>
            <strong><?php echo $mb['mb_email'] ?></strong>
         </div>
         <?php }  ?>
         -->

         <p class="result_txt">
            <strong><?php echo get_text($mb['mb_name']); ?></strong>님의 회원가입을 진심으로 환영합니다.<br>
            가입하신 메일로 인증 메일이 발송되며,<br>
            이메일 인증 후 마케팅 인사이드 서비스 이용이 가능합니다.<br>
         </p>
      </div>

      <!-- } 회원가입결과 끝 -->
      <div class="btn_confirm">
         <a href="<?php echo G5_URL ?>/" class="btn_close">홈으로</a>
         <a href="<?php echo G5_URL ?>/bbs/login.php" class="btn_submit">로그인</a>
      </div>

   </div>
</div>
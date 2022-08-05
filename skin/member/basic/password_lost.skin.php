<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<!-- 회원가입약관 동의 시작 { -->
<div id="sub_layout" class="register lost_pw">
   <div class="wrap">

      <!-- 회원정보 찾기 시작 { -->
      <h1 class="register_title">패스워드 찾기</h1>
      <p>
         회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>
         해당 이메일로 비밀번호 정보를 보내드립니다.
      </p>

      <div class="new_win_con">
         <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
         <fieldset id="info_fs">
               <label for="mb_email" class="sound_only">E-mail 주소<strong class="sound_only">필수</strong></label>
               <input type="text" name="mb_email" id="mb_email" required class="required frm_input full_input email" size="30" placeholder="E-mail 주소">
         </fieldset>

        
         <div id="register_form">
            <?php echo captcha_html();  ?>
         </div>


         <div class="btn_confirm">
            <a href="javascript:history.back()">이전으로​</a>
            <button type="submit" class="btn_submit">메일 요청</button>
         </div>
         </form>
      </div>

   </div>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->
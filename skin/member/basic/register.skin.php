<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<!-- 회원가입약관 동의 시작 { -->
<div id="sub_layout" class="register">
   <div class="wrap">
      <h1 class="register_title">회원가입</h1>

      <div class="register_step">
         <div class="step_box active">약관동의</div>
         <div class="step_box">정보입력</div>
         <div class="step_box">가입완료</div>
      </div>

      <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
      
      <section id="fregister_term">
         <fieldset class="fregister_agree">
            <input type="checkbox" name="agree" value="1" id="agree11" class="selec_chk">
            <label for="agree11"><b>(필수) 이용약관</b></label>
         </fieldset>
         <div class="fregister_box"><?php include_once(G5_PATH.'/inc/clause_con.php');?></div>
      </section>

      <section id="fregister_private">
         <fieldset class="fregister_agree">
            <input type="checkbox" name="agree2" value="1" id="agree21" class="selec_chk">
            <label for="agree21"><b>(필수) 개인정보 수집 및 이용</b></label>
         </fieldset>
         <div class="fregister_box"><?php include_once(G5_PATH.'/inc/personal_con.php');?></div>
      </section>

      <div id="fregister_chkall" class="chk_all fregister_agree">
         <input type="checkbox" name="chk_all" id="chk_all" class="selec_chk">
         <label for="chk_all"><b>회원가입 약관에 모두 동의합니다.</b></label>
      </div>
         
      <div class="btn_confirm">
         <a href="javascript:history.back()" class="btn_close">취소</a>
         <button type="submit" class="btn_submit">다음단계</button>
      </div>

      <?php
      // 소셜로그인 사용시 소셜로그인 버튼
      @include_once(get_social_skin_path().'/social_register.skin.php');
      ?>

      </form>

      <script>
      function fregister_submit(f)
      {
         if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
         }

         if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
         }

         return true;
      }
      
      jQuery(function($){
         // 모두선택
         $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                  $("input[name^=agree]").prop('checked', true);
            } else {
                  $("input[name^=agree]").prop("checked", false);
            }
         });
      });

      </script>
   </div>
</div>
<!-- } 회원가입 약관 동의 끝 -->

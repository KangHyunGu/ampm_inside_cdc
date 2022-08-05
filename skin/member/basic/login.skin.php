<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<div id="sub_layout" class="wrap">
   <!-- 로그인 시작 { -->
   <div id="mb_login" class="mbskin">
      <div class="mbskin_box">
         <h1>로그인</h1>
         <p class="notice">로그인하시면 마케팅 커뮤니티의 모든 서비스 이용이 가능합니다.</p>


         <div class="tab_wrapper">
            <ul class="login_tab">
               <li class="tab_box on" data-tab="tab-1">로그인</li>
               <li class="tab_box" data-tab="tab-2">AMPM</li>
            </ul>

            <!-- 일반사용자 로그인 -->
            <div id="tab-1" class="con_box on">
               <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
                  <input type="hidden" name="url" value="<?php echo $login_url ?>">
                  <input type="hidden" name="mb_ampmkey" value="">
                  
                  <fieldset id="login_fs">
                     <legend>회원로그인</legend>
                     <label for="login_id" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
                     <input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20" placeholder="아이디">
                     <label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
                     <input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호">
                     <button type="submit" class="btn_submit">로그인</button>
                     
                     <div id="login_info">
                        <!--
                        <div class="login_if_auto chk_box">
                           <input type="checkbox" name="auto_login" id="login_auto_login" class="selec_chk">
                           <label for="login_auto_login">자동로그인</label>  
                        </div>
                        -->
                        <div class="login_if_lpl">
                           <a href="<?php echo G5_BBS_URL ?>/password_lost.php">패스워드 찾기</a>
                           <a href="<?php echo G5_BBS_URL ?>/register.php" class="join">회원가입</a> 
                        </div>
                     </div>
                  </fieldset> 
               </form>
               <?php @include_once(get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>
            </div>

            <!-- AMPM 로그인 -->
            <div id="tab-2" class="con_box">
               <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
                  <input type="hidden" name="url" value="<?php echo $login_url ?>">
                  <input type="hidden" name="mb_ampmkey" value="G">
                  
                  <fieldset id="login_fs">
                     <legend>AMPM로그인</legend>
                     <label for="login_id" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
                     <input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20" placeholder="아이디">
                     <label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
                     <input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호">
                     <button type="submit" class="btn_submit">로그인</button>
                  </fieldset> 
               </form>
            </div>
         </div>

      </div>
   </div>

</div>

<script>
jQuery(function($){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->

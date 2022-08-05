<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal.css">', 11);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal-default-theme.css">', 12);
add_stylesheet('<link rel="stylesheet" href="'.get_social_skin_url().'/style.css?ver='.G5_CSS_VER.'">', 0);
add_javascript('<script src="'.G5_JS_URL.'/remodal/remodal.js"></script>', 10);

$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';
?>


<!-- 회원정보 입력/수정 시작 { -->
<div class="register sns">
   <div class="wrap">

      <h1 class="register_title">SNS 회원가입</h1>

      <div class="mbskin" id="register_member">

         <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
         
         <!-- 새로가입 시작 -->
         <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
         <input type="hidden" name="w" value="<?php echo $w; ?>">
         <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
         <input type="hidden" name="mb_name" value="<?php echo $user_name ? $user_name : $user_nick ?>" >
         <input type="hidden" name="provider" value="<?php echo $provider_name;?>" >
         <input type="hidden" name="action" value="register">

         <input type="hidden" name="mb_id" value="<?php echo $user_id; ?>" id="reg_mb_id">
         <input type="hidden" name="mb_nick_default" value="<?php echo isset($user_nick)?get_text($user_nick):''; ?>">
         <input type="hidden" name="mb_nick" value="<?php echo isset($user_nick)?get_text($user_nick):''; ?>" id="reg_mb_nick">


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

         <div class="sns_tbl">
            <h3>개인정보 입력</h3>
            <ul>
               <li>
               <label for="reg_mb_email">아이디<strong class="sound_only">필수</strong></label>
                  <div class="s_input">
                     <div class="box">
						  <input type="text" name="mb_email" value="<?php echo isset($user_email)?$user_email:''; ?>" id="reg_mb_email" required class="frm_input email required" size="70" maxlength="100" placeholder="이메일 형태로 작성하세요." >
						  <p class="email_msg"><?php echo $email_msg; ?></p>
                     </div>
                     <div class="ctf_btn">
                        <button class="email_certify" id="id_check">중복확인</button>
                     </div>
                  </div>
                  <div class="s_notice">
                     <span class="tooltips">
                        *이메일 주소를 입력하세요. 아이디는 이메일 주소로 사용됩니다.
                     </span>
                  </div>
               </li>
            </ul>
         </div>

         <div class="btn_confirm">
            <a href="<?php echo G5_URL ?>" class="btn_close">취소</a>
            <input type="submit" value="회원가입" id="btn_submit" class="btn_submit" accesskey="s">
         </div>
         </form>
         <!-- 새로가입 끝 -->

         <!-- 기존 계정 연결 -->

         <div class="member_connect">
            <p class="strong">혹시 기존 회원이신가요?</p>
            <button type="button" class="connect-opener btn-txt" data-remodal-target="modal">
                  기존 계정에 연결하기
                  <i class="fa-solid fa-angle-right"></i>
            </button>
         </div>

         <div id="sns-link-pnl" class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
            <button type="button" class="connect-close" data-remodal-action="close">
                  <i class="fa fa-close"></i>
                  <span class="txt">닫기</span>
            </button>
            <div class="connect-fg">
                  <form method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
                  <input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
                  <input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
                  <input type="hidden" id="action" name="action" value="social_account_linking">

                  <div class="connect-title">기존 계정에 연결하기</div>

                  <div class="connect-desc">
                     기존 아이디에 SNS 아이디를 연결합니다.<br>
                     이 후 SNS 아이디로 로그인 하시면 기존 아이디로 로그인 할 수 있습니다.
                  </div>

                  <div id="login_fs">
                     <label for="login_id" class="login_id">아이디<strong class="sound_only"> 필수</strong></label>
                     <span class="lg_id"><input type="text" name="mb_id" id="login_id" class="frm_input required" size="20" maxLength="20" ></span>
                     <label for="login_pw" class="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
                     <span class="lg_pw"><input type="password" name="mb_password" id="login_pw" class="frm_input required" size="20" maxLength="20"></span>
                     <br>
                     <input type="submit" value="연결하기" class="login_submit btn_submit">
                  </div>

                  </form>
            </div>
         </div>

    <script>
	$('#id_check').click(function() {
		var reg_mb_id = $('#reg_mb_email').val();
		
		$.ajax({
			type: 'post',
			url: g5_bbs_url+"/ajax.mb_id.php",
			data: { reg_mb_id: reg_mb_id},
			cache: false,
			async: false,
			success: function(data) {
				result = data;
			
				if(result){
					alert(result);
					$("#reg_mb_email").focus();
					return false;
				}
			}
		});
	});

    // submit 최종 폼체크
    function fregisterform_submit(f)
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

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                jQuery(".email_msg").html(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function flogin_submit(f)
    {
        var mb_id = $.trim($(f).find("input[name=mb_id]").val()),
            mb_password = $.trim($(f).find("input[name=mb_password]").val());

        if(!mb_id || !mb_password){
            return false;
        }

        return true;
    }

    jQuery(function($){
        if( jQuery(".toggle .toggle-title").hasClass('active') ){
            jQuery(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
        }
        jQuery(".toggle .toggle-title .right_i").click(function(){

            var $parent = $(this).parent();
            
            if( $parent.hasClass('active') ){
                $parent.removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
            } else {
                $parent.addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
            }
        });
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
</div>
<!-- } 회원정보 입력/수정 끝 -->
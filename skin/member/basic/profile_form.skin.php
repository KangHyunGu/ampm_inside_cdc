<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>
<?php
	$is_dhtml_editor = true;
	$is_dhtml_editor_use = true;
?>
<!-- 회원정보 입력/수정 시작 { -->
<div class="register">
   <div class="wrap">

      <h1 class="register_title"><?=$g5['title']?></h1>

	<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="url" value="<?php echo $urlencode ?>">

	<input type="hidden" name="mk" value="<?php echo $mk ?>">
	<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="mb_id">
	
	<input type="hidden" name="mb_part" value="<?php echo $member['mb_part'] ?>" id="mb_part">
	<input type="hidden" name="mb_team" value="<?php echo $member['mb_team'] ?>" id="mb_team">
	<input type="hidden" name="mb_post" value="<?php echo $member['mb_post'] ?>" id="mb_post">

	<div id="register_form" class="form_01 marketer">   
	    <div class="register_form_inner">
	        <ul>
  	            <li class="marketer_img">
					<label for="mb_img">마케터 이미지<strong class="sound_only">필수</strong></label>
					<div class="img">
                  <!--
                  <button class="open-pop" onclick="popTemplate()">※ 제작가이드 확인</button>
-->
                  <input type="file" name="mb_img" id="mb_img">
                  <div class="box">
                     <?php
                     $mb_dir = substr($mkt['mb_id'],0,2);
                     $mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$mkt['mb_id'].'.jpg';
                     if (file_exists($mk_file)) {
                        $mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$mkt['mb_id'].'.jpg';
                        echo '<img src="'.$mk_url.'" alt="" width="200">';
                        echo '<div class="del"><input type="checkbox" id="del_mb_img" name="del_mb_img" value="1">삭제</div>';
                     }
                     ?>
                     <div class="s_notice">
                        <span class="tooltips">
                           *마케터 소개에 사용될 이미지를 올려 주세요.<br>
                           *가로x세로 길이는 350x350(권장)이 넘지 않는 사진을 사용하기 바랍니다.
                        </span>
                     </div>
						</div>
					</div>
	            </li>
				<?php
					if($mkt['mb_license']){
						$arrLicense = explode('|',$mkt['mb_license']);

						foreach($arrLicense as $key=>$val)  
						{
							unset($arrLicense[$key]);  

							$License_newKey = $val;  
							$arrLicense[$License_newKey] = $val;  
						  
							$i++;  
						}
					}
				?>
				<li class="marketer_lisence">
                  <label for="mb_license">취득 자격증<strong class="sound_only">필수</strong></label>
                  <div class="align">
                  <?=codeToHtml($code_license2, $arrLicense, "chk4", "mb_license")?>
                  </div>
                  <div class="s_notice2">
                     <span class="tooltips">
                        *광고대행에 관련한 취득 자격증을 선택해주세요.
                     </span>
                  </div>
	            </li>
				<?php
					if($mkt['mb_media']){
						$arrMedia = explode('|',$mkt['mb_media']);

						foreach($arrMedia as $key=>$val)  
						{
							unset($arrMedia[$key]);  

							$Media_newKey = $val;  
							$arrMedia[$Media_newKey] = $val;  
						  
							$i++;  
						}
					}
				?>
				<li class="marketer_media">
                  <label for="mb_media">전문 매체<strong class="sound_only">필수</strong></label>
                  <div class="align">
                  <?=codeToHtml($code_media2, $arrMedia, "chk4", "mb_media")?>
                  </div>
                  <div class="s_notice2">
                     <span class="tooltips">
                        *본인의 전문적인 광고 마케팅을 선택해주세요.
                     </span>
                  </div>
	            </li>
				<?php
					if($mkt['mb_sectors']){
						$arrSectors = explode('|',$mkt['mb_sectors']);

						foreach($arrSectors as $key=>$val)  
						{
							unset($arrSectors[$key]);  

							$Sectors_newKey = $val;  
							$arrSectors[$Sectors_newKey] = $val;  
						  
							$i++;  
						}
					}
				?>
				<li class="marketer_job">
                  <label for="mb_sectors">전문 직종<strong class="sound_only">필수</strong></label>
                  <div class="align">
                  <?=codeToHtml($code_sectors, $arrSectors, "chk4", "mb_sectors")?>
                  </div>
                  <div class="s_notice2">
                     <span class="tooltips">
                        *본인의 전문 직종을 꼭 3개만 선택해주세요.
                     </span>
                  </div>
	            </li>
				<li class="marketer_title">
                  <label for="mb_media">타이틀문구<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_slogan" value="<?php echo $mkt['mb_slogan'] ?>" id="mb_slogan" class="frm_input" maxlength="20" size="150">
                  <div class="s_notice2">
                     <span class="tooltips">
                        *자신을 나타낼 수 있는 한마디를 띄어쓰기 포함 20자 이내로 기술해 주세요.
                     </span>
                  </div>
	            </li>
				<li class="marketer_history">
                  <label for="mb_profile">마케터 이력<strong class="sound_only">필수</strong></label>
                  <?php echo editor_html("mb_profile", $mkt['mb_profile'], $is_dhtml_editor); ?>
                  <div class="s_notice2">
                     <span class="tooltips">
                        *ex) [업체명]네이버광고 및 캠페인 운영 19.05.20~진행중
                     </span>
                  </div>
	            </li>
				<li class="marketer_msg">
                  <label for="mb_message">클라이언트에게 던지는 메시지<strong class="sound_only">필수</strong></label>
                  <?php echo editor_html("mb_message", $mkt['mb_message'], $is_dhtml_editor); ?>
                  <div class="s_notice2">
                     <span class="tooltips">
                        *광고주에게 어필할 수 있는 자신의 장점 및 광고 운영 포부를 적어주세요.
                     </span>
                  </div>
	            </li>

				<li>
                  <label for="mb_bloglink">운영 블로그 주소<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_bloglink" value="<?php echo $mkt['mb_bloglink'] ?>" id="mb_bloglink" class="frm_input" size="150">
                  <div class="s_notice2">
                     <span class="tooltips">
                        *http:// 포함해서 운영 블로그 주소를 입력하세요.
                     </span>
                  </div>
	            </li>
				<li>
                  <label for="mb_facebooklink">운영 페이스북 주소<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_facebooklink" value="<?php echo $mkt['mb_facebooklink'] ?>" id="mb_facebooklink" class="frm_input" size="150">
                  <div class="s_notice2">
                     <span class="tooltips">
                        *http:// 포함해서 운영 페이스북 주소를 입력하세요.
                     </span>
                  </div>
	            </li>
				<li>
                  <label for="mb_instagramlink">운영 인스타그램 주소<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_instagramlink" value="<?php echo $mkt['mb_instagramlink'] ?>" id="mb_instagramlink" class="frm_input" size="150">
                  <div class="s_notice2">
                     <span class="tooltips">
                        *http:// 포함해서 운영 인스타그램 주소를 입력하세요.
                     </span>
                  </div>
	            </li>
				<li>
                  <label for="mb_youtubelink">운영 유튜브채널 주소<strong class="sound_only">필수</strong></label>
                  <input type="text" name="mb_youtubelink" value="<?php echo $mkt['mb_youtubelink'] ?>" id="mb_youtubelink" class="frm_input" size="150">
                  <div class="s_notice2">
                     <span class="tooltips">
                        *http:// 포함해서 운영 유튜브 주소를 입력하세요.
                     </span>
                  </div>
	            </li>
	        </ul>
	    </div>

	</div>
	<div class="btn_confirm">
		<a href="<?php echo G5_URL ?>/bbs/register.php" class="btn_close">이전단계</a>
	    <button type="submit" id="btn_submit" class="btn_submit" accesskey="s"><?php echo $w==''?:'프로필수정'; ?></button>
	</div>
	</form>
   </div>
</div>
<script>
//템플릿 팝업
function popTemplate()
{
	var w = 900;
	var h = 800;
	var url = "/marketer/inc/pop_template.php";
    var opt = 'width='+ w +', height='+ h +', resizable=yes, scrollbars=yes';

    window.open(url, "popTemplate", opt);
    return false;
}

//전문직종 체크 수 제한
function count_ck(obj){
	var chkbox = document.getElementsById("mb_sectors");
	var chkCnt = 0;

	for(var i=0;i<chkbox.length; i++){
		if(chkbox[i].checked){
			chkCnt++;
		}
	}

	if(chkCnt > 3){
		alert("check NO");
		obj.checked = false;
		return false;
	}
}

// submit 최종 폼체크
function fregisterform_submit(f)
{

    <?php //echo chk_captcha_js();  ?>

	<?php echo get_editor_js("mb_profile"); ?> // 반드시 추가해야합니다.
	<?php //echo chk_editor_js("mb_profile"); ?> // 추가하면 필수 입력 상태로 됩니다. 선택 입력으로 하고 싶으면 삭제
	<?php echo get_editor_js("mb_message"); ?> // 반드시 추가해야합니다.
	<?php //echo chk_editor_js("mb_message"); ?> // 추가하면 필수 입력 상태로 됩니다. 선택 입력으로 하고 싶으면 삭제

	document.getElementById("btn_submit").disabled = "disabled";


    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>

<!-- } 회원정보 입력/수정 끝 -->
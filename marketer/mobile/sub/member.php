<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

?>
<?php
//마케터 고유코드 없는 경우 마케터 리스트로 리다이렉트
include(G5_MARKETER_PATH.'/inc/_utm_member.php');

?>

<?php
////////////////////////////////////////////////////////////////////
//마케터 정보 가져오기
////////////////////////////////////////////////////////////////////
include(G5_MARKETER_PATH.'/inc/_marketer_info.php');
?>

<?php
$g5['title'] = $mb['mb_name']."AE - ";
$g5['title'].= ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO";
include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_header.php');
?>

<!-- S: 컨텐츠 -->
<section id="content" class="sub1">
   <div class="wrap">

      <h2 class="sub-title"><?=$mb['mb_name'] ?>AE 소개</h2>

      <!-- 프로필 -->
      <div class="member_pf">
         <div class="info">

            <div class="info_box">
               <h3 class="main-color team"><?=$mb_team?>팀</h3>
               <p class="ae"><?=$mb['mb_name'] ?></p>
               <span class="eng"><?=$mb['mb_ename'] ?></span>
            </div>

            <div class="mkt-img">
               <?=$mb_images?>
            </div>

         </div>

         <div class="slogan">
            <?php echo ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO"; ?>
         </div>

         <div class="button_wrap">
            <table class="top">
               <tr>
                  <td>
                     <a href="mailto:<?=$_MARKETER_MAIL ?>" alt="메일">
                        <i class="fa-solid fa-envelope"></i>
                        <p><?=$mb['mb_email']?></p>       
                     </a>
                  </td>
                  <?php if($mb['mb_kakao']){ ?>
                  <td>
                     <a href="#" class="kakao_id">
                        <svg id="a" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 59.35 54.81"><defs><style>.b{fill:#3556ff;}</style></defs><path class="b" d="M29.67,0C13.29,0,0,10.49,0,23.44c0,8.33,5.51,15.62,13.77,19.79l-2.8,10.44c-.11,.32-.02,.66,.21,.89,.16,.16,.37,.25,.61,.25,.18,0,.36-.08,.52-.2l12.03-8.12c1.74,.25,3.53,.39,5.34,.39,16.39,0,29.68-10.49,29.68-23.44S46.06,0,29.67,0ZM13.82,30.85c0,.53-.16,.97-.47,1.29-.3,.33-.73,.49-1.25,.49-.43,0-.79-.12-1.09-.35-.3-.24-.49-.56-.58-.97-.03-.15-.04-.3-.03-.45v-11.13h-3.22c-.44,0-.83-.11-1.15-.31-.32-.2-.52-.49-.59-.87-.02-.1-.04-.21-.05-.33,0-.47,.17-.84,.51-1.1,.33-.26,.76-.4,1.27-.4h9.88c.45,0,.83,.1,1.14,.31,.32,.2,.52,.49,.6,.87,.01,.1,.03,.21,.02,.32,0,.49-.17,.85-.49,1.12-.33,.26-.75,.39-1.26,.39h-3.23v11.13Zm14.11,1.32c-.31,.31-.69,.45-1.14,.45-.79,0-1.3-.33-1.53-.97l-.88-2.6h-5.5l-.89,2.6c-.21,.65-.72,.97-1.53,.97-.4,0-.74-.1-1.01-.31-.27-.21-.45-.51-.52-.88-.02-.11-.03-.23-.03-.36,0-.17,.02-.38,.09-.63,.06-.24,.14-.49,.23-.73l4.42-12.17c.14-.39,.35-.67,.62-.83,.27-.17,.62-.25,1.05-.25h.82c.44,0,.82,.09,1.12,.27,.3,.18,.54,.52,.71,1.03l4.12,11.96c.13,.37,.22,.69,.28,.95,.03,.18,.05,.31,.06,.41,0,.44-.17,.8-.48,1.1Zm11.41-.22c-.33,.26-.76,.39-1.27,.39h-7.13c-.53,0-.96-.1-1.29-.33-.33-.21-.54-.56-.65-1.05-.04-.21-.06-.44-.07-.7v-12.05c0-.53,.16-.96,.47-1.29,.31-.32,.73-.49,1.25-.49,.43,0,.8,.12,1.09,.36,.29,.24,.49,.56,.57,.97,.03,.15,.04,.3,.03,.45v11.13h5.71c.46,0,.84,.1,1.15,.3,.31,.21,.51,.5,.58,.87,.02,.1,.04,.21,.05,.33,0,.47-.17,.84-.5,1.1Zm12.84,.27c-.34,.26-.76,.4-1.24,.4-.35,0-.63-.06-.85-.18-.22-.14-.45-.38-.67-.74l-3.94-6.34-1.88,1.96,.02,3.54c0,.53-.16,.97-.47,1.29-.31,.33-.73,.49-1.25,.49-.43,0-.8-.12-1.1-.35-.3-.24-.49-.56-.57-.97-.03-.15-.03-.3-.03-.45v-12.63c0-.53,.15-.96,.46-1.29,.31-.32,.73-.49,1.25-.49,.43,0,.8,.12,1.09,.36,.3,.24,.49,.56,.57,.97,.03,.15,.04,.3,.03,.45v5.18l5.38-6.17c.24-.26,.45-.46,.65-.59,.2-.13,.43-.19,.71-.19,.38,0,.72,.11,1.02,.32,.31,.2,.49,.48,.57,.83,0,.01,.01,.06,.02,.13,0,.05,0,.1,0,.14,0,.25-.05,.46-.16,.65-.11,.19-.24,.38-.41,.57l-3.51,3.83,4.15,6.58,.13,.2c.28,.45,.45,.77,.49,.99,0,.01,.01,.05,.03,.11,0,.06,0,.09,0,.11,0,.61-.17,1.05-.51,1.31Z"/><polygon class="b" points="21.67 20.31 19.65 26.58 23.65 26.58 21.71 20.31 21.67 20.31"/></svg>
                        <p><?=$mb['mb_kakao'] ?></p>
                     </a>
                  </td>
                  <?php } ?>
               </tr>
            </table>

            <a href="tel:<?=$_MARKETER_TEL ?>"  class="call" alt="전화">
               <i class="fa-solid fa-phone"></i>   
               <?=$mb['mb_tel'] ?>
            </a>
         </div>
      </div>

      <!-- 매체,직종 -->
      <div class="mb_content1">

         <!-- 전문 매체 -->
         <?php if($mb['mb_media']){ ?>
            <div class="mb-box media">
               <div class="mb-title">전문<br>매체</div>
               <!-- 내용 출력-->
               <div class="mb-con">
                  <?php
                     $arrMedia = explode('|',$mb['mb_media']);

                     foreach($arrMedia as $key=>$val)  
                     {
                        unset($arrMedia[$key]);  

                        $Media_newKey = $val;  
                        $arrMedia[$Media_newKey] = $val;  
                        echo '<span>#'.$arrMedia[$Media_newKey].'</span>';
                     
                        $i++;  
                     }
                  ?>
               </div>
            </div>
         <?php } ?>
               

         <!-- 전문 직종 -->
         <?php if($mb['mb_sectors']){ ?>
            <div class="mb-box job">
               <div class="mb-title">전문<br>직종</div>
               <!-- 내용 출력-->
               <div class="mb-con">
                     <?php
                        $arrSectors = explode('|',$mb['mb_sectors']);

                        foreach($arrSectors as $key=>$val)  
                        {
                           unset($arrSectors[$key]);  

                           $Sectors_newKey = $val;  
                           $arrSectors[$Sectors_newKey] = $val;  
                           echo '<span>#'.$arrSectors[$Sectors_newKey].'</span>';
                        
                           $i++;  
                        }
                     ?>
               </div>
            </div>
         <?php } ?>

      </div>
         

      <!-- 마케터 이력 -->
      <?php if($mb['mb_profile']) { ?>
         <div class="history">
            <div class="mb-title">마케터 이력</div>
            <!-- 내용 출력-->
            <div class="mb-con">
                  <?=conv_content($mb['mb_profile'], $html);?>
            </div>
         </div>
      <?php } ?>
            

      <!-- 클라이언트에게 던지는 메세지 -->
      <?php if($mb['mb_message']) { ?>
         <div class="msg">
            <div class="mb-title">클라이언트에게 던지는 메세지</div>
            <!-- 내용 출력-->
            <div class="mb-con">
                  <?=conv_content($mb['mb_message'], $html);?>
            </div>
         </div>
      <?php } ?>


      <!-- 하단 배너 영역 -->
      <div class="sub-banner">
         <a href="/ae-<?=$utm_member?>/video/<?php if($team_code){ echo "&team_code=".$team_code; }?>">
            <img src="<?=G5_MARKETER_URL ?>/images/m_sub-video-banner.png" alt="영상교육 바로가기">
         </a>
      </div>

      <div class="sub-banner">
         <a href="<?=G5_URL ?>" class="inside">
            <img src="<?=G5_MARKETER_URL ?>/images/sub-inside-banner.png" alt="마케팅인사이드 바로가기">
         </a>
      </div>

   </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
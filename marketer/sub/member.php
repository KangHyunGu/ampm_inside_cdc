<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/member.php');
    return;
}

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

      <!-- 전문 매체 -->
      <?php if($mb['mb_media']){ ?>
         <div class="mb-box media">
            <div class="mb-title">전문 매체</div>
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
            <div class="mb-title">전문 직종</div>
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
            <img src="<?=G5_MARKETER_URL ?>/images/sub-video-banner.png" alt="영상교육 바로가기">
         </a>
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
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
<section id="content">
    <div class="wrap">
        
         <div id="content1">
               <div class="main_insight">
                  <?php echo latestMarketer('ma_insight', 'insight', 5, 25, $cache_time=1, $options='', $utm_member, $team_code);?>

                  <div class="inside_banner">
                     <a href="<?=G5_URL ?>">
                        <img src="<?=G5_MARKETER_URL?>/images/inside_banner.jpg" alt="마케팅 인사이드 바로가기">
                     </a>
                  </div>
               </div>
               <div class="main_reference">
                  <?php echo latestMarketer('ma_reference', 'reference', 4, 25, $cache_time=1, $options='', $utm_member, $team_code);?>
               </div>
         </div>


         <div id="content2">
               <?php echo latestMarketer('ma_video', 'video', 5, 35, $cache_time=1, $options='', $utm_member, $team_code);?>
         </div>
        
         <div id="content3">
            <div class="member_banner">
               <a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>">
                  <img src="<?=G5_MARKETER_URL?>/images/member_banner.png" alt="마케팅 소개 바로가기">
               </a>
            </div>
            <div class="main_qna">
               <?php echo latestMarketer('ma_qna', 'qna', 4, 50, $cache_time=1, $options='', $utm_member, $team_code);?>
            </div>
         </div>
    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
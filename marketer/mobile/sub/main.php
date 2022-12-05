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
<section id="content">
    <div class="wrap">
        <div class="main_insight">
            <?php echo latestMarketer('m_ma_insight', 'insight', 5, 32, $cache_time=1, $options='', $utm_member, $team_code);?>
        </div>

        <div class="main_video">
            <?php echo latestMarketer('m_ma_video', 'video', 5, 35, $cache_time=1, $options='', $utm_member, $team_code);?>
        </div>

        <div class="main_banner">
            <a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>">
                <img src="<?=G5_MARKETER_URL?>/images/m_member_banner.png" alt="마케팅 소개 바로가기">
            </a>
        </div>

        <div class="main_qna">
            <?php echo latestMarketer('m_ma_qna', 'qna', 4, 20, $cache_time=1, $options='', $utm_member, $team_code);?>
        </div>

        <div class="main_reference">
            <?php echo latestMarketer('m_ma_reference', 'reference', 5, 25, $cache_time=1, $options='', $utm_member, $team_code);?>
        </div>

         <div class="inside_banner">
         </div>

         <div class="main_banner">
            <a href="<?=G5_URL ?>">
               <img src="<?=G5_MARKETER_URL?>/images/m_inside_banner.jpg" alt="마케팅 인사이드 바로가기">
            </a>
        </div>

        <div class="main_banner">
            <a href="<?=G5_URL?>/marketer/#section4">
                <img src="<?=G5_MARKETER_URL?>/images/m_q_list_banner.png" alt="마케터목록보기">
            </a>
        </div>


    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
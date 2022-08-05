<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MARKETER_MOBILE_PATH.'/sub/member.php');
    return;
}

$g5['title'] = "마케터소개";
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
include_once('./_head.php');
?>

<!-- header -->
<?php
include(G5_MARKETER_PATH.'/inc/_sub_header.php');
?>

<!-- S: 컨텐츠 -->
<section id="sub-common">
    <div class="wrap">  
        <div class="common-info">
            <div class="member-title">
                <h3 class="main-color">Marketer Profile</h3>
                <h2><?php echo ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO"; ?></h2>
            </div>
            <div class="member-info">
                <ul>
                    <li>
                        <span><i class="fas fa-mobile-alt"></i></span>
                        <p><?=$mb['mb_tel'] ?></p>
                    </li>

                    <?php if($mb['mb_kakao']){ ?>
                    <li>
                        <span><i class="fab fa-kaggle"></i></span>
                        <p><?=$mb['mb_kakao'] ?></p>
                    </li>
                    <?php } ?>

                    <li>
                        <span><i class="fas fa-envelope"></i></span>
                        <p><?=$mb['mb_email'] ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="sub-layout">
    <div class="wrap">
        <div class="layout">

            <div class="content" data-aos="fade-up" data-aos-offset="300" data-aos-easing="ease-in-cubic">
                <!-- 전문 매체 -->
 				<?php if($mb['mb_media']){ ?>
                    <div class="mb-box">
                        <div class="mb-title">
                            <span></span> 전문 매체
                        </div>
                        <!-- 내용 출력-->
                        <div class="mb-con media">
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
                    <div class="mb-box">
                        <div class="mb-title">
                            <span></span> 전문 직종
                        </div>
                        <!-- 내용 출력-->
                        <div class="mb-con job">
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
                    <div class="mb-box">
                        <div class="mb-title">
                            <span></span> 마케터 이력
                        </div>
                        <!-- 내용 출력-->
                        <div class="mb-con history">
                            <?=conv_content($mb['mb_profile'], $html);?>
                        </div>
                    </div>
 				<?php } ?>
                
                <!-- 클라이언트에게 던지는 메세지 -->
				<?php if($mb['mb_message']) { ?>
                    <div class="mb-box">
                        <div class="mb-title">
                            <span></span> 클라이언트에게 던지는 메세지
                        </div>
                        <!-- 내용 출력-->
                        <div class="mb-con msg">
                            <?=conv_content($mb['mb_message'], $html);?>
                        </div>
                    </div>
 				<?php } ?>
            </div>

            <?php
                //마케터 프로필
                include(G5_MARKETER_PATH.'/inc/mkt_profile.php');
            ?>  

        </div>
    </div>
</section>
<!-- E: 컨텐츠 -->

<?php
//풋터
include(G5_MARKETER_PATH.'/inc/_sub_footer.php');
?>
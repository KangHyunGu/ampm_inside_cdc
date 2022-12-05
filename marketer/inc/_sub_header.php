<?php
//마케터정보
$mm = get_marketer($utm_member);

$_MARKETER_NAME  = $mm['mb_name'];
$_MARKETER_TEL   = '02-6049-'.$mm['mb_tel'];
$_MARKETER_EMAIL = $mm['mb_email'];
?>

<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>
<header id="m-sub-header">

    <div class="head-nav">

         <div class="logo">
            <a href="<?=G5_URL ?>"><img src="<?=G5_MARKETER_URL ?>/images/marketer_logo.png"></a>
            <a href="/ae-<?=$utm_member?>/<?php if($team_code){ echo "&team_code=".$team_code; }?>"><p><?=$mb['mb_name'] ?> AE</p></a>
         </div>
         
         <div class="menu_icon">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
         </div>
        
    </div>

    <aside id="m_menu">

        <ul class="gnb">
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>">
                <?=$mb['mb_name'] ?>AE소개</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/insight/<?php if($team_code){ echo "&team_code=".$team_code; }?>">인사이트</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/video/<?php if($team_code){ echo "&team_code=".$team_code; }?>">영상교육</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/reference/<?php if($team_code){ echo "&team_code=".$team_code; }?>">레퍼런스</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/qna/<?php if($team_code){ echo "&team_code=".$team_code; }?>">질문답변</a></li>
        </ul>

        <a class="m_menu_banner" href="/ae-<?=$utm_member?>/estimate/<?php if($team_code){ echo "&team_code=".$team_code; }?>">
            <img src="<?=G5_MARKETER_URL?>/images/m_menubanner.png" alt="메뉴배너_상담문의">
        </a>
        <script>
        // menu
        $(function() {
            $('#m-sub-header .menu_icon').click(function () {
                $(this).toggleClass('open');
                $('#m_menu').toggleClass('on');
            });
        });

        </script>

    </aside>


</header>

<!-- 상단 프로필 영역 -->
<section id="head_profile">
   <article class="wrap">
      <div class="main_profile">
         <!-- 마케터 이미지 -->
         <div class="mkt-img">
            <?=$mb_images?>
         </div>

         <!-- 마케터 팀, 이름 -->
         <div class="mkt-name">
            <h3 class="main-color"><?=$mb_team?>팀</h3>
            <p class="ae"><?=$mb['mb_name'] ?></p>
         </div>
      </div>

      <div class="main_link">
         
         <ul class="link_group1">
            
            <!-- 오픈카카오 -->
            <?php if($mb['mb_kakaochat']){ ?>
               <li class="kakao">
                  <a href="https://open.kakao.com/o/<?php echo $mb['mb_kakaochat'] ?>" target="_blank">
                     <img src="<?=G5_MARKETER_URL ?>/images/m_kakaochat.png" alt="카카오 오픈채팅">
                  </a>
               </li>
            <?php } ?>

            <!-- 이메일 -->
            <li class="mail">
               <a href="mailto:<?=$_MARKETER_EMAIL ?>" alt="메일">
                  <i class="fa-solid fa-envelope"></i>
               </a>
            </li>

            <!-- 전화 -->
            <li class="call">
               <a href="tel:<?=$_MARKETER_TEL ?>" alt="전화">
                  <i class="fa-solid fa-phone"></i>   
               </a>
            </li>

         </ul>

         <ul class="link_group2">

            <?php if($sns_link){ ?>
               <!-- 블로그 -->
               <?php if($mb['mb_bloglink']){ ?>
                  <li class="blog">
                     <a href="<?=$mb['mb_bloglink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/blog.png" alt="블로그">
                     </a>
                  </li>
               <?php } ?>
               <!-- 페이스북 -->
               <?php if($mb['mb_facebooklink']){ ?>
                  <li class="facebook">
                     <a href="<?=$mb['mb_facebooklink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/facebook.png" alt="페이스북">
                     </a>
                  </li>
               <?php } ?>
               <!-- 인스타그램 -->
               <?php if($mb['mb_instagramlink']){ ?>
                  <li class="instagram">
                     <a href="<?=$mb['mb_instagramlink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/instagram.png" alt="인스타그램">
                     </a>
                  </li>
               <?php } ?>
               <!-- 유튜브 -->
               <?php if($mb['mb_youtubelink']){ ?>
                  <li class="youtube">
                     <a href="<?=$mb['mb_youtubelink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/youtube.png" alt="유튜브">
                     </a>
                  </li>
               <?php } ?>
            <?php } ?>

         </ul>
      </div>
      
   </article>
</section>

    
<?php
}else{	//PC인 경우
?>

<header id="sub-header">
   <div class="head-nav">
      <div class="wrap">
         <div class="logo">
            <a href="<?=G5_URL ?>"><img src="<?=G5_MARKETER_URL ?>/images/marketer_logo.png"></a>
            <a href="/ae-<?=$utm_member?>/<?php if($team_code){ echo "&team_code=".$team_code; }?>"><p><?=$mb['mb_name'] ?> AE</p></a>
         </div>
         <ul class="gnb">
               <li><a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>"><?=$mb['mb_name'] ?>AE 소개</a></li>
               <li><a href="/ae-<?=$utm_member?>/insight/<?php if($team_code){ echo "&team_code=".$team_code; }?>">인사이트</a></li>
               <li><a href="/ae-<?=$utm_member?>/video/<?php if($team_code){ echo "&team_code=".$team_code; }?>">영상교육</a></li>
               <li><a href="/ae-<?=$utm_member?>/reference/<?php if($team_code){ echo "&team_code=".$team_code; }?>">레퍼런스</a></li>
               <li><a href="/ae-<?=$utm_member?>/qna/<?php if($team_code){ echo "&team_code=".$team_code; }?>">질문답변</a></li>
         </ul>
      </div>
   </div>
</header>

<!-- 상단 프로필 영역 -->
<section id="head_profile">
   <article class="wrap">
      <div class="main_profile">
         <!-- 마케터 이미지 -->
         <div class="mkt-img">
            <?=$mb_images?>
         </div>

         <!-- 마케터 팀, 이름 -->
         <div class="mkt-name">
            <h3 class="main-color"><?=$mb_team?>팀</h3>
            <div class="name">
               <p class="ae"><?=$mb['mb_name'] ?></p>
               <p class="eng"><?=$mb['mb_ename'] ?></p>
            </div>
            <div class="slogan">
               <?php echo ($mb['mb_slogan'])?$mb['mb_slogan']:"퍼포먼스 마케팅 PRO"; ?>
            </div>
            <div class="job">
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
      </div>

      <div class="main_info">
         <ul>
            <li>
               <span class="main-color">Contact</span>
               <p><?=$mb['mb_tel'] ?></p>
            </li>

            <li>
               <span class="main-color">E-mail</span>
               <p><?=$mb['mb_email'] ?></p>
            </li>

            <?php if($mb['mb_kakao']){ ?>
            <li>
               <span class="main-color">Kakao ID</span>
               <p><?=$mb['mb_kakao'] ?></p>
            </li>
            <?php } ?>
         </ul>
      </div>

      <div class="main_link">
         <ul>
            <?php if($sns_link){ ?>
               <!-- 블로그 -->
               <?php if($mb['mb_bloglink']){ ?>
                  <li class="blog">
                     <a href="<?=$mb['mb_bloglink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/blog.png" alt="블로그">
                     </a>
                  </li>
               <?php } ?>
               <!-- 페이스북 -->
               <?php if($mb['mb_facebooklink']){ ?>
                  <li class="facebook">
                     <a href="<?=$mb['mb_facebooklink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/facebook.png" alt="페이스북">
                     </a>
                  </li>
               <?php } ?>
               <!-- 인스타그램 -->
               <?php if($mb['mb_instagramlink']){ ?>
                  <li class="instagram">
                     <a href="<?=$mb['mb_instagramlink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/instagram.png" alt="인스타그램">
                     </a>
                  </li>
               <?php } ?>
               <!-- 유튜브 -->
               <?php if($mb['mb_youtubelink']){ ?>
                  <li class="youtube">
                     <a href="<?=$mb['mb_youtubelink']?>" target="_blank">
                        <img src="<?=G5_MARKETER_URL ?>/images/youtube.png" alt="유튜브">
                     </a>
                  </li>
               <?php } ?>
            <?php } ?>
            <?php if($mb['mb_kakaochat']){ ?>
               <li class="kakao">
                  <a href="https://open.kakao.com/o/<?php echo $mb['mb_kakaochat'] ?>" target="_blank">
                     <img src="<?=G5_MARKETER_URL ?>/images/kakaochat.png" alt="카카오 오픈채팅">
                  </a>
               </li>
            <?php } ?>
         </ul>
      </div>
      
   </article>
</section>
<script>

</script>

<?php
}
?>
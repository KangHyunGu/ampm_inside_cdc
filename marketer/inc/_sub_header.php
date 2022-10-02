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

    <div class="head-top">
        <div class="wrap">
            <p>전문 마케터들이 준비되어 있습니다! →</p>
            <a href="<?=G5_MARKETER_URL?>/#section4">마케터 목록보기</a>
        </div>
    </div>

    <div class="head-nav">
      <!--
         <a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>" class="logo">
-->
         <a href="<?=G5_URL?>" class="logo">
            <img src="<?=G5_URL?>/images/logo.png" title="로고">
        </a>
        <div class="menu_icon">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <aside id="m_menu">
        <h2 class="inner_logo">
        <a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>"></a>
        </h2>

        <ul class="gnb">
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>">마케터 소개</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/video/<?php if($team_code){ echo "&team_code=".$team_code; }?>">MY VIDEO</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/reference/<?php if($team_code){ echo "&team_code=".$team_code; }?>">REFERENCE</a></li>
            <li class="dropdown"><a href="/ae-<?=$utm_member?>/insight/<?php if($team_code){ echo "&team_code=".$team_code; }?>">INSIGHT</a></li>
        </ul>

        <script>
        // menu
        $(function() {
            $('#m-sub-header .menu_icon').click(function () {
                $(this).toggleClass('open');
                $('#m_menu').toggleClass('on');
            });
        });

        </script>

        <div class="sns-link">
            <a href="tel:02.6049-1158" alt="전화">
                <img class="blog" src="<? G5_URL ?>/images/memu_call.png" alt="전화">
            </a>

            <a href="https://blog.naver.com/ampmglobal" target="_blank">
                <img class="blog" src="<? G5_URL ?>/images/memu_sns1.png" alt="블로그">
            </a>

            <a href="https://www.youtube.com/channel/UCCZEqe3-h1IKKsMLNIZmJ1A" target="_blank">
                <img class="youtube" src="<? G5_URL ?>/images/memu_sns2.png" alt="유튜브">
            </a>
        </div>
    </aside>


</header>
    
<?php
}else{	//PC인 경우
?>

<header id="sub-header">
    <div class="head-top">
        <div class="wrap">
            <p>다양한 분야의 전문 마케터들이 준비되어 있습니다! →</p>
            <a href="<?=G5_MARKETER_URL?>/#section4">마케터 목록보기</a>
        </div>
    </div>
    <div class="head-nav">
        <div class="wrap">
            <div class="logo">
               <!--
                <a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>"><img src="<?=G5_URL ?>/images/logo.png"></a>
                  -->
                  <a href="<?=G5_URL?>"><img src="<?=G5_URL ?>/images/logo.png"></a>
            </div>
            <ul class="gnb">
                <li><a href="/ae-<?=$utm_member?>/member/<?php if($team_code){ echo "&team_code=".$team_code; }?>">마케터 소개</a></li>
                <li><a href="/ae-<?=$utm_member?>/video/<?php if($team_code){ echo "&team_code=".$team_code; }?>">MY VIDEO</a></li>
                <li><a href="/ae-<?=$utm_member?>/reference/<?php if($team_code){ echo "&team_code=".$team_code; }?>">REFERENCE</a></li>
                <li><a href="/ae-<?=$utm_member?>/insight/<?php if($team_code){ echo "&team_code=".$team_code; }?>">INSIGHT</a></li>
            </ul>
            <div class="link">
                <ul>
                    <?php if($sns_link){ ?>
                        <!-- 블로그 -->
                        <?php if($mb['mb_bloglink']){ ?>
                            <li>
                                <a href="<?=$mb['mb_bloglink']?>" target="_blank">
                                    <img src="<?=G5_MARKETER_URL ?>/images/blog.png">
                                </a>
                            </li>
                        <?php } ?>
                        <!-- 페이스북 -->
                        <?php if($mb['mb_facebooklink']){ ?>
                            <li>
                                <a href="<?=$mb['mb_facebooklink']?>" target="_blank">
                                    <img src="<?=G5_MARKETER_URL ?>/images/facebook.png">
                                </a>
                            </li>
                        <?php } ?>
                        <!-- 인스타그램 -->
                        <?php if($mb['mb_instagramlink']){ ?>
                            <li>
                                <a href="<?=$mb['mb_instagramlink']?>" target="_blank">
                                    <img src="<?=G5_MARKETER_URL ?>/images/instagram.png">
                                </a>
                            </li>
                        <?php } ?>
                        <!-- 유튜브 -->
                        <?php if($mb['mb_youtubelink']){ ?>
                            <li>
                                <a href="<?=$mb['mb_youtubelink']?>" target="_blank">
                                    <img src="<?=G5_MARKETER_URL ?>/images/youtube.png">
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if($mb['mb_kakaochat']){ ?>
                        <li class="inquiry">
                            <a href="https://open.kakao.com/o/<?php echo $mb['mb_kakaochat'] ?>" target="_blank"><span>카카오</span> 오픈채팅</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>

<?php
}
?>
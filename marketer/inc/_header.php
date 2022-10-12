<?php
//마케터정보
$mm = get_marketer($utm_member);

$_MARKETER_NAME  = $mm['mb_name'];
$_MARKETER_TEL   = '02.6049-'.$mm['mb_tel'];
$_MARKETER_EMAIL = $mm['mb_email'];
?>

<?php
if (G5_IS_MOBILE) {	//모바일인 경우
?>

<header id="m_header">
    <div class="logo">
        <a href="<?=G5_URL?>"></a>
    </div>
</header>

<?php
}else{	//PC인 경우
?>

<header id="mk-header">
    <div id="mk-gnb">
        <div class="wrap">
            <div class="logo">
                <a href="<?=G5_URL?>"><img src="<?=G5_URL ?>/images/logo.png" alt="마케팅 인사이드 로고"></a>
            </div>
            <nav>
                <ul class="gnb">
                    <li><a href="#section2" class="move">이렇게 선택하세요!</a></li>
                    <li><a href="#section3" class="move">전문마케터 찾기 <span class="icon">↗</span></a></li>
                </ul>
            </nav>
            <div class="other-link">
                <a href="http://ampm.co.kr/sub/sub2-2-1.php<?=$teamLinkPara?>" target="_blank">‘우리’에게 맞는 광고 매체는?</a>
            </div>
        </div>
    </div>
</header>

<?php
}
?>
<?php
include_once('./_common.php');

$g5['title'] = '로그인';


//마케터 관리자 ==> 이동
include_once(G5_MARKETER_PATH.'/head.sub.php');

include(G5_MARKETER_PATH.'/inc/_sub_header.php');


$url = $_GET['url'];

$p = parse_url($url);
if ((isset($p['scheme']) && $p['scheme']) || (isset($p['host']) && $p['host'])) {
    //print_r2($p);
    if ($p['host'].(isset($p['port']) ? ':'.$p['port'] : '') != $_SERVER['HTTP_HOST'])
        alert('url에 타 도메인을 지정할 수 없습니다.');
}

// 이미 로그인 중이라면
if ($is_member) {
    if ($url)
        goto_url($url);
    else
        goto_url(G5_URL);
}

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_MARKETER_BBS_URL."/login_check.php";

//echo $url;
// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체
$login_file = $member_skin_path.'/login.skin.php';
if (!file_exists($login_file))
    $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/marketer_login.skin.php');

include(G5_MARKETER_PATH.'/inc/_sub_footer.php');

//마케터 관리자 ==> 이동
include_once(G5_MARKETER_PATH.'/tail.sub.php');

?>

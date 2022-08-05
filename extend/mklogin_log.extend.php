<?php
/**************************
@Filename: login_log.extend.php
@Version : 0.1
@Author  : Freemaster(http://freemaster.kr)
@Date  : 2016/04/01 Fri Am 10:03:24
@Content : PHP by Editplus
**************************/
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
define('_LOGIN_LOG_',true); //로그인로그 접근

define('G5_INC_DIR','inc'); //로그인 로그 파일 폴더
define('G5_MKLD_PATH',G5_MARKETER_PATH.'/'.G5_INC_DIR);
define('G5_MKLD_URL',G5_MARKETER_URL.'/'.G5_INC_DIR);

$g5['mklogin_log_table'] = G5_TABLE_PREFIX."mklogin_log";

$mklogin_log_array = array(
	1=>"정상로그인",
	2=>"로그인",
	3=>"아이디 미입력",
	4=>"비회원 아이디",
	5=>"패스워드 미입력",
	6=>"패스워드 틀림",
	7=>"차단된 아이디 로그인 시도",
	8=>"탈퇴한 아이디 로그인 시도",
	9=>"이메일 미인증 회원 로그인 시도",
	10=>"관리자 미승인 회원 로그인 시도",
	11=>"중복로그인 시도",
);

include_once(G5_MKLD_PATH."/mklogin_log.lib.php");
?>
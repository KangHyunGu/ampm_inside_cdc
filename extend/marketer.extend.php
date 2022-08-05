<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// 마케터 상수 모음 시작
//------------------------------------------------------------------------------

define('G5_MARKETER_DIR',			'marketer');
define('G5_MARKETER_BBS_DIR',		G5_MARKETER_DIR.'/'.G5_BBS_DIR);

define('G5_MARKETER_URL',			G5_URL.'/'.G5_MARKETER_DIR);
define('G5_MARKETER_BBS_URL',		G5_MARKETER_URL.'/'.G5_BBS_DIR);
define('G5_MARKETER_CSS_URL',       G5_MARKETER_URL.'/'.G5_CSS_DIR);
define('G5_MARKETER_JS_URL',		G5_MARKETER_URL.'/'.G5_JS_DIR);
define('G5_MARKETER_MOBILE_URL',	G5_MARKETER_URL.'/'.G5_MOBILE_DIR);

define('G5_MARKETER_ADMIN_URL',		G5_MARKETER_URL.'/'.G5_ADMIN_DIR);
define('G5_MARKETER_ADMBBS_URL',	G5_MARKETER_URL.'/'.G5_ADMIN_DIR.'/'.G5_BBS_DIR);


define('G5_MARKETER_PATH',			G5_PATH.'/'.G5_MARKETER_DIR);
define('G5_MARKETER_BBS_PATH',		G5_MARKETER_PATH.'/'.G5_BBS_DIR);
define('G5_MARKETER_MOBILE_PATH',	G5_MARKETER_PATH.'/'.G5_MOBILE_DIR);

define('G5_MARKETER_ADMIN_PATH',	G5_MARKETER_PATH.'/'.G5_ADMIN_DIR);
define('G5_MARKETER_ADMBBS_PATH',	G5_MARKETER_PATH.'/'.G5_ADMIN_DIR.'/'.G5_BBS_DIR);

define('G5_HTTP_MARKETER_BBS_URL',  https_url(G5_MARKETER_BBS_DIR, false));
define('G5_HTTPS_MARKETER_BBS_URL', https_url(G5_MARKETER_BBS_DIR, true));
?>
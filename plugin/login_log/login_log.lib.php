<?php
/**************************
@Filename: login_log.lib.php
@Version : 0.1
@Author  : Freemaster(http://freemaster.kr)
@Date  : 2016/04/01 Fri Am 10:03:24
@Content : PHP by Editplus
**************************/
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if(!defined('_LOGIN_LOG_')) exit; //로그인로그 접근

//테이블 추가
$log_sql = "SHOW TABLES LIKE '".$g5['login_log_table']."' ";
$log_row = sql_fetch($log_sql);
if(empty($log_row))
{
    $logSql = " CREATE TABLE IF NOT EXISTS `".$g5['login_log_table']."` (
                  `loc_uid` int(10) unsigned NOT NULL auto_increment,
                  `loc_ip` varchar(50) NOT NULL default '',
                  `mb_id` varchar(100) NOT NULL default '',
                  `loc_success` tinyint(4) NOT NULL,
                  `loc_referer` text NOT NULL,
                  `loc_agent` text NOT NULL,
                  `loc_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
                  PRIMARY KEY  (`loc_uid`),
                  KEY `loc_index` (`mb_id`,`loc_success`,`loc_datetime`)
                ); ";
    sql_query($logSql);
}

function login_log($mb_id,$num)
{	//로그인 이력 저장
	global $g5;

	$remote_addr = escape_trim($_SERVER['REMOTE_ADDR']);
    $referer = escape_trim(clean_xss_tags($_SERVER['HTTP_REFERER']));
    $agent  = escape_trim(clean_xss_tags($_SERVER['HTTP_USER_AGENT']));

	$sql = "INSERT INTO ".$g5['login_log_table']." SET loc_ip='".$remote_addr."', mb_id='".$mb_id."', loc_datetime = '".G5_TIME_YMDHIS."', loc_success = '".$num."', loc_referer='".$referer."' , loc_agent = '".$agent."' ";
	sql_query($sql,FALSE);
}
?>
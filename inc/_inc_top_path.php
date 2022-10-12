<?php
$pageName = basename($_SERVER['PHP_SELF']);

$para1 = $_REQUEST['path_dep1'];
$para2 = $_REQUEST['path_dep2'];
$para3 = $_REQUEST['path_dep3'];

$subok = false;
//sub 폴더 여부
if(strpos($_SERVER['SCRIPT_NAME'], '/sub/') !== false) {  
	$subok = true;	//sub폴더
}

$bbsok = false;
//bbs 폴더 여부
if(strpos($_SERVER['SCRIPT_NAME'], '/bbs/') !== false) {  
	$bbsok = true;	//bbs폴더
}

if($_SERVER['SCRIPT_NAME'] == '/index.php') {
	$path_dep1 = "0";
	$path_dep2 = "0";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/clause.php') {
	$path_dep1 = "10";
	$path_dep2 = "1";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/personal.php') {
	$path_dep1 = "10";
	$path_dep2 = "2";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/email.php') {
	$path_dep1 = "10";
	$path_dep2 = "3";
}else if($_SERVER['SCRIPT_NAME'] == '/bbs/login.php') {
	$path_dep1 = "8";
	$path_dep2 = "1";
}else if($subok) {
	$path_dep1 = substr($pageName, 3, 1);
	$path_dep2 = substr($pageName, 5, 1);
	$path_dep3 = ($path_dep1 == '2' && $path_dep2 == '2')?substr($pageName, 7, 1):'0';
}else if($bbsok) {
	switch ($go_table) {

		case 'insight': 
			$path_dep1 = "1";
			$path_dep2 = "1";
		break;

		case 'video': 
			$path_dep1 = "2";
			$path_dep2 = "1";
		break;
		case 'reference': 
			$path_dep1 = "3";
			$path_dep2 = "1";
		break;
		case 'qna': 
			$path_dep1 = "4";
			$path_dep2 = "1";

			$path_dep0 = "3";
		break;
		case 'mkestimate': 
			$path_dep1 = "5";
			$path_dep2 = "1";
			
			$path_dep0 = "5";
		break;
		case 'request': 
			$path_dep1 = "6";
			$path_dep2 = "1";
			
			$path_dep0 = "4";
		break;

		case 'content': 
			$path_dep1 = "7";
			$path_dep2 = "1";
		break;

		case 'amypage': 
			$path_dep1 = "8";
			$path_dep2 = "1";
			
			$path_dep0 = "1";
		break;
		case 'umypage': 
			$path_dep1 = "8";
			$path_dep2 = "1";
			
			$path_dep0 = "1";
		break;

		case 'acomment': 
			$path_dep1 = "8";
			$path_dep2 = "2";
			
			$path_dep0 = "2";
		break;
		case 'ucomment': 
			$path_dep1 = "8";
			$path_dep2 = "2";
			
			$path_dep0 = "2";
		break;

		case 'favorites': 
			$path_dep1 = "8";
			$path_dep2 = "3";

			$path_dep0 = "6";
		break;


		case 'memberlogin': 
			$path_dep1 = "10";
			$path_dep2 = "1";
		break;
		case 'memberjoin': 
			$path_dep1 = "10";
			$path_dep2 = "2";
		break;
		case 'membermodify': 
			$path_dep1 = "10";
			$path_dep2 = "3";
		break;
	}
}else{
	$path_dep1 = $_REQUEST['path_dep1'];
	$path_dep2 = $_REQUEST['path_dep2'];
	$path_dep3 = ($path_dep1 == '2')?$_REQUEST['path_dep3']:'0';
}

$para1 = $path_dep1;
$para2 = $path_dep2;
$para3 = ($path_dep1 == '2')?$path_dep3:'0';

//$chkPath = $path_dep0."-".$path_dep1."-".$path_dep2."-".$path_dep3;
//echo "chkPath=> ".$chkPath;

////////////////////////////////////////
//path_dep0 = 마이페이지 탭메뉴 코드
////////////////////////////////////////

?>
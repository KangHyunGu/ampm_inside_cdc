<?php
include_once('./_common.php');
//error_reporting(E_ALL);
//ini_set("display_errors", 1);


// clean the output buffer
ob_end_clean();


// 쿠키에 저장된 ID값과 넘어온 ID값을 비교하여 같지 않을 경우 오류 발생
// 다른곳에서 링크 거는것을 방지하기 위한 코드

//if (!get_session('ss_view_'.$bo_table.'_'.$wr_id))
//    alert('잘못된 접근입니다.');

$g5['file_table'] = 'g5_board_file'; // 게시판 첨부파일 테이블
$bo_table = $_GET['bo_table'];
$wr_id = $_GET['wr_id'];
$no = $_GET['no'];
$no = (int)$no;

$sql = " select bf_source, bf_file from {$g5['file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$no}' ";
$file = sql_fetch($sql);
if (!$file['bf_file'])
    alert_close('파일 정보가 존재하지 않습니다(0).');

$filepath = G5_DATA_PATH.'/file/'.$bo_table.'/'.$file['bf_file'];
$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath))
    alert('파일이 존재하지 않습니다(1).');


// 이미 다운로드 받은 파일인지를 검사한 후 게시물당 한번만 포인트를 차감하도록 수정
$ss_name = 'ss_down_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name))
{
    // 다운로드 카운트 증가
    $sql = " update {$g5['file_table']} set bf_download = bf_download + 1 where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
    sql_query($sql);

    set_session($ss_name, TRUE);

}

$g5['title'] = '다운로드 &gt; ';

$original = urlencode($file['bf_source']);

/*
if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])){
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"".basename($file['bf_source'])."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();
*/

// Must be fresh start 
if( headers_sent() ) 
	die('Headers Already Sent'); 

// Required for some browsers 
if(ini_get('zlib.output_compression')) 
	ini_set('zlib.output_compression', 'Off'); 

// Parse Info / Get Extension 
$fsize = filesize($filepath); 
$path_parts = pathinfo($filepath); 
$ext = strtolower($path_parts["extension"]); 

// Determine Content Type 
switch ($ext) 
{ 
	case "pdf": $ctype="application/pdf"; break; 
	case "exe": $ctype="application/octet-stream"; break; 
	case "zip": $ctype="application/zip"; break; 
	case "doc": $ctype="application/msword"; break; 
	case "xls": $ctype="application/vnd.ms-excel"; break; 
	case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
	case "gif": $ctype="image/gif"; break; 
	case "png": $ctype="image/png"; break; 
	case "jpeg": 
	case "jpg": $ctype="image/jpg"; break; 
	default: $ctype="application/force-download"; 
} 

    header("Pragma: public"); // required 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-Type: $ctype"); 
    header("Content-Disposition: attachment; filename=\"".$original."\";" ); 
    header("Content-Transfer-Encoding: binary"); 
    header("Content-Length: ".$fsize); 
    ob_clean(); 
    flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();
?>

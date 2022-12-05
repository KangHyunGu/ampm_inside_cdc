<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  까불이 스페셜 함수 모음
**
**  Code by Gaburi
**  cwh727@gmail.com
**  Last updated 2015.08.20
**
**  다음 코드는 개인 목적에 맞게 수정하셔도 됩니다.
**  다만, 고생한 원저작자에 대한 예의로 출처는 계속 표기하여 주시면 감사하겠습니다.
**
*************************************************************************/


/////////////////////////////////////////////////////////////////////
// 게시판 사이즈에 맞추어서 설정하세요

// 동영상 재생 사이즈 설정
$movie_width = "728";
$movie_height = "413";

if (G5_IS_MOBILE) {
	$movie_width = "393";
	$movie_height = "251";
}

// 섬네일 사이즈 설정
$thumb_width = "280";
$thumb_height = "158";
/////////////////////////////////////////////////////////////////////

// 유튜브 동영상 주소에서 동영상 ID만 추출하는 함수
function get_youtubeid($url) {
    $id = str_replace("https://youtu.be/", "", $url);
    $id = str_replace("http://youtu.be/", "", $id);
    $id = str_replace("https://www.youtube.com/watch?v=", "", $id);
    $id = str_replace("http://www.youtube.com/watch?v=", "", $id);
	$id = mb_substr($id,0,11,'utf-8');
    
    return $id;
}

function get_vimeoid($url) {
    $id = str_replace("https://vimeo.com/channels/staffpicks/", "", $url);
    $id = str_replace("https://vimeo.com/channels/staffpicks/", "", $id);
    $id = str_replace("https://vimeo.com/", "", $id);
    $id = str_replace("http://vimeo.com/", "", $id);

    return $id;
}

function get_vimeoThumb($id) {
    $apiurl = "http://vimeo.com/api/v2/video/".$id.".xml";
    $response = file_get_contents($apiurl);
    $xml = simplexml_load_string($response);

    $thumbUrl = $xml->video->thumbnail_medium;

    return $thumbUrl;
}

?>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/gaburi.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 210;
$thumb_height = 118;
$list_count = (is_array($list) && $list) ? count($list) : 0;

if($team_code){
	$list_more = "/ae-".$utm_member."/video/?team_code=".$team_code;
}else{
	$list_more = "/ae-".$utm_member."/video/";
}
?>

<div class="la_video">
	<h2 class="lat_title">
		<a href="<?php echo $list_more; ?>"><?php echo $bo_subject ?></a>
        <a href="<?php echo $list_more; ?>" class="lt_more">더보기</a>
	</h2>

    <div class="lt_video">
            <?php
            for ($i=0; $i<$list_count; $i++) {
                if(preg_match("/youtu/", $list[$i]['wr_5'])) {
                    $videoId = get_youtubeid($list[$i]['wr_5']);
                    $thumb = "<img src='http://img.youtube.com/vi/$videoId/mqdefault.jpg' alt='".$list[$i]['subject']."' />";
                }else if(preg_match("/vimeo/", $list[$i]['wr_5'])) {
                    $videoId = get_vimeoid($list[$i]['wr_5']);
                    $thumb_Url = get_vimeoThumb($videoId);
                    $thumb = "<img src='$thumb_Url'  alt='".$list[$i]['subject']."' />";
                }

                $string = $list[$i]['wr_5']; 
                $pattern = '/([0-9]+)-([0-9]+)-([0-9]{4})/'; 
                $replacement = '${1}-****-$3'; 
                $real_hp = preg_replace($pattern, $replacement, $string);

                if($team_code){
                    $list_more = "/ae-".$utm_member."/video/?team_code=".$team_code;
                    $list[$i]['href'] = "/ae-".$utm_member."/video/".$list[$i]['wr_id']."&team_code=".$team_code;
                }else{
                    $list_more = "/ae-".$utm_member."/video/";
                    $list[$i]['href'] = "/ae-".$utm_member."/video/".$list[$i]['wr_id'];
                }
            ?>
                <a href="<?php echo $list[$i]['href']; ?>" class="lt_img"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?>
                    <div class="video_thumbnail">
                        <?=$thumb?>
                    </div>
                </a>
            <?php }  ?>
            <?php if ($list_count == 0) { //게시물이 없을 때  ?>
            <li class="empty_li">게시물이 없습니다.</li>
            <?php }  ?>
    </div>

   <!--<a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more">더보기</a>-->
</div>
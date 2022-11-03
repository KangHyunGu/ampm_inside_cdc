<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/gaburi.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 210;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<ul class="type_video">
   <?php
   for ($i=0; $i<$list_count; $i++) {
      if(preg_match("/youtu/", $list[$i]['wr_5'])) {
         $videoId = get_youtubeid($list[$i]['wr_5']);
         $thumb = "<img src='http://img.youtube.com/vi/$videoId/hqdefault.jpg' alt='".$list[$i]['subject']."' />";
      }else if(preg_match("/vimeo/", $list[$i]['wr_5'])) {
         $videoId = get_vimeoid($list[$i]['wr_5']);
         $thumb_Url = get_vimeoThumb($videoId);
         $thumb = "<img src='$thumb_Url'  alt='".$list[$i]['subject']."' />";
      }

   $wr_href = $list[$i]['href'];
   ?>
      <li class="video_box">
         
         <a href="<?php echo $wr_href; ?>" class="lt_img"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?>
            <div class="video_thumbnail">
               <?=$thumb?>
            </div>
         </a>
         <?php
         if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

         echo "<a class=\"con_title\" href=\"".$wr_href."\"> ";
         if ($list[$i]['is_notice'])
               echo "<strong>".$list[$i]['subject']."</strong>";
         else
               echo $list[$i]['subject'];
         echo "</a>";
         ?>
      </li>
   <?php }  ?>
   <?php if ($list_count == 0) { //게시물이 없을 때  ?>
   <li class="empty_li">게시물이 없습니다.</li>
   <?php }  ?>
</ul>
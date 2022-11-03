<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 294;
$thumb_height = 165;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="week_lank">
   <h3>금주의 영상교육 BEST <span>🏆</span></h3>
   <div class="lank_slider">
         <?php
         for ($i=0; $i<$list_count; $i++) {
            if(preg_match("/youtu/", $list[$i]['wr_5'])) {
               $videoId = get_youtubeid($list[$i]['wr_5']);
               $thumb = "<img src='http://img.youtube.com/vi/$videoId/maxresdefault.jpg'  alt='".$list[$i]['subject']."' />";
            }else if(preg_match("/vimeo/", $list[$i]['wr_5'])) {
               $videoId = get_vimeoid($list[$i]['wr_5']);
               $thumb_Url = get_vimeoThumb($videoId);
               $thumb = "<img src='$thumb_Url'  alt='".$list[$i]['subject']."' />";
            }

         $wr_href = $list[$i]['href'];
         ?>
            <div class="lank">
                <a href="<?php echo $list[$i]['href'] ?>">

                     <div class="lank_img">
                        <?=$thumb?>
                     </div>

                    <div class="lank_subject">
                        <div class="ca"><?php echo "{$list[$i]['ca_name']}"; ?></div>
                        <?php echo $list[$i]['subject']; ?>
                    </div>

                    <div class="lank_bottom">
                        <span><?php echo $list[$i]['name'] ?></span>
                        <span class="lt_date"><?php echo $list[$i]['datetime'] ?></span>
                    </div>

                </a>
            </div>
        <?php }  ?>

        <?php if ($list_count == 0) { //게시물이 없을 때  ?>
            <div class="empty_li">게시물이 없습니다.</div>
        <?php }  ?>
    </div>

    <div class="lank_slider_btn">
      <div class="prev">
         <i class="fa-solid fa-angle-left"></i>
      </div>
      <div class="next">
         <i class="fa-solid fa-angle-right"></i>
      </div>
   </div>

</div> 
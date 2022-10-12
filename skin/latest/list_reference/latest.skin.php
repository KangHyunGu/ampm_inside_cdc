<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 60;
$thumb_height = 60;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<ul class="type_ref">
   <?php
   for ($i=0; $i<$list_count; $i++) {
   $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

   if($thumb['src']) {
      $img = $thumb['src'];
 	  $thumb['alt'] = $list[$i]['subject'];
  } else {
      $img = G5_IMG_URL.'/no_img.png';
      $thumb['alt'] = '이미지가 없습니다.';
   }
   $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
   $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
   ?>

      <li>
         <div class="ref">
            <div class="ref_img_box">
               <span class="new"><?=$i+1?></span>
               <div class="ref_img">
                  <a href="<?php echo $wr_href; ?>" class="lt_img"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
               </div>
            </div>
            <div class="ref_img_tit">
               <?php
               if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

               echo "<a href=\"".$wr_href."\"> ";
               echo "<h5>";
               if ($list[$i]['is_notice'])
                     echo "<strong>".$list[$i]['subject']."</strong>";
               else
                     echo $list[$i]['subject'];
                     echo "</h5>";
                     echo "</a>";
               ?>
               <p>By. <span><?php echo $list[$i]['name'] ?></span></p>    
            </div>
         </div>
      </li>
   <?php }  ?>
   <?php if ($list_count == 0) { //게시물이 없을 때  ?>
      <li class="empty_li">게시물이 없습니다.</li>
   <?php }  ?>
</ul>
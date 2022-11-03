<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 218;
$thumb_height = 218;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="week_lank">
   <h3>금주의 레퍼런스 BEST <span>🏆</span></h3>
   <div class="lank_slider">
         <?php
         for ($i=0; $i<$list_count; $i++) {
			$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

			if($thumb['src']) {
				$img = $thumb['src'];
 				$thumb['alt'] = $list[$i]['subject'];
			} else {
				$img = '../skin/board/reference/img/no-img.jpg';
				$thumb['alt'] = '이미지가 없습니다.';
			}
			$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';

			$wr_href = $list[$i]['href'];
         ?>
            <div class="lank">
                <a href="<?php echo $list[$i]['href'] ?>">

                     <div class="lank_img">
                        <div class="ca"><?php echo "{$list[$i]['ca_name']}"; ?></div>
                        <?=$img_content?>
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
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 294;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="week_lank">
   <h3>금주의 질문답변 BEST <span>🏆</span></h3>
   <div class="lank_slider">
        <?php
            for ($i=0; $i<count($list); $i++) {
            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

            if($thumb['src']) {
            $img = $thumb['src'];
            } else {
            $img = G5_IMAGES_URL.'/sub1_defualt.jpg';
            }
            $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
            ?>
            <div class="lank">
                <a href="<?php echo $list[$i]['href'] ?>">

                <!--
                    <div class="lank_top">
                        <div class="lank_num"><?=$i+1?></div>
                    </div>
               -->

                    <div class="lank_subject">
                        <div class="ca"><?php echo "{$list[$i]['ca_name']}"; ?></div>
                        <?php echo $list[$i]['subject']; ?>
                    </div>

                    <div class="lank_con">
                        <?php echo cut_str(strip_tags($list[$i]['wr_content']), 50)?>
                    </div>

                    <div class="lank_bottom">
                        <span class="lt_date"><?php echo $list[$i]['datetime'] ?></span>
                        <span class="cnt">답변 <?php echo $list[$i]['wr_comment']; ?></span>
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
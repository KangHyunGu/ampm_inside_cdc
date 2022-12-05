<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 210;
$thumb_height = 210;
$list_count = (is_array($list) && $list) ? count($list) : 0;

if($team_code){
	$list_more = "/ae-".$utm_member."/reference/?team_code=".$team_code;
}else{
	$list_more = "/ae-".$utm_member."/reference/";
}
?>

<div class="lt_ref">
   <h2 class="lat_title">
    <a href="<?php echo $list_more; ?>"><?php echo $bo_subject ?>
        <img src="<?=G5_MARKETER_URL?>/images/main_ref.png" alt="다양한 업체 성공사례">
    </a>
   </h2>

   <ul class="type_ref">
      <?php
      for ($i=0; $i<$list_count; $i++) {
	    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

		if($thumb['src']) {
			$img = $thumb['src'];
			$thumb['alt'] = $list[$i]['subject'];
		} else {
			$img = G5_MARKETER_URL.'/images/no-img.jpg';
			$thumb['alt'] = '이미지가 없습니다.';
		}
		$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';

		$string = $list[$i]['wr_5']; 
		$pattern = '/([0-9]+)-([0-9]+)-([0-9]{4})/'; 
		$replacement = '${1}-****-$3'; 
		$real_hp = preg_replace($pattern, $replacement, $string);

		if($team_code){
			$list_more = "/ae-".$utm_member."/reference/?team_code=".$team_code;
			$list[$i]['href'] = "/ae-".$utm_member."/reference/".$list[$i]['wr_id']."&team_code=".$team_code;
		}else{
			$list_more = "/ae-".$utm_member."/reference/";
			$list[$i]['href'] = "/ae-".$utm_member."/reference/".$list[$i]['wr_id'];
		}
	?>

         <li>
            <div class="ref_img">
               <a href="<?php echo $list[$i]['href']; ?>" class="lt_img"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
            </div>
            <div class="ref_img_tit">
               <?php
               echo "<a href=\"".$list[$i]['href']."\"> ";
               if ($list[$i]['is_notice'])
                     echo "<strong>".$list[$i]['subject']."</strong>";
               else
                     echo $list[$i]['subject'];
                     echo "</a>";
               ?> 
            </div>
         </li>
      <?php }  ?>
      <?php if ($list_count == 0) { //게시물이 없을 때  ?>
         <li class="empty_li">게시물이 없습니다.</li>
      <?php }  ?>
	</ul>

	<a href="<?php echo $list_more; ?>" class="lt_more">더보기</a>    
</div>
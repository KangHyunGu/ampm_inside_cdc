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
      <a href="<?php echo $list_more; ?>"><?php echo $bo_subject ?></a>
      <a href="<?php echo $list_more; ?>" class="lt_more">더보기</a>    
   </h2>

   <div class="type_ref">
      <?php
      for ($i=0; $i<$list_count; $i++) {
	    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

		if($thumb['src']) {
			$img = $thumb['src'];
			$thumb['alt'] = $list[$i]['subject'];
		} else {
			$img = G5_MARKETER_URL.'/images/no_images.jpg';
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

        <a href="<?php echo $list[$i]['href']; ?>" class="lt_img"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
      <?php }  ?>
      <?php if ($list_count == 0) { //게시물이 없을 때  ?>
         <p class="empty_li">게시물이 없습니다.</p>
      <?php }  ?>
      </div>

</div>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;

if($team_code){
	$list_more = "/ae-".$utm_member."/insight/?team_code=".$team_code;
}else{
	$list_more = "/ae-".$utm_member."/insight/";
}
?>


<div class="la_insight">
    <h2 class="lat_title">
      <a href="<?php echo $list_more; ?>"><?php echo $bo_subject ?>
        <img src="<?=G5_MARKETER_URL?>/images/main_insight.png" alt="마케팅 아이디어를 공유해요">
      </a>
   </h2>

    <ul>
    <?php 
	for ($i=0; $i<$list_count; $i++) {  

		$string = $list[$i]['wr_5']; 
		$pattern = '/([0-9]+)-([0-9]+)-([0-9]{4})/'; 
		$replacement = '${1}-****-$3'; 
		$real_hp = preg_replace($pattern, $replacement, $string);

		if($team_code){
			$list_more = "/ae-".$utm_member."/insight/?team_code=".$team_code;
			$list[$i]['href'] = "/ae-".$utm_member."/insight/".$list[$i]['wr_id']."&team_code=".$team_code;
		}else{
			$list_more = "/ae-".$utm_member."/insight/";
			$list[$i]['href'] = "/ae-".$utm_member."/insight/".$list[$i]['wr_id'];
		}
	?>
        <li class="basic_li">
            <div class="lt_cate">
               <span class="cate"><?php echo $list[$i]['ca_name'] ?></span>
            </div>

            <div class="lt_subject">
               <?php
               if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

               echo "<a href=\"".$list[$i]['href']."\"> ";
               if ($list[$i]['is_notice'])
                  echo "<strong>".$list[$i]['subject']."</strong>";
               else
                  echo $list[$i]['subject'];

               echo "</a>";
            
               if ($list[$i]['icon_new']) echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
               ?>
            </div>

            <div class="lt_info">
            	<span class="lt_date"><?php echo $list[$i]['datetime'] ?></span>              
            </div>
        </li>
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <!--<a href="<?php echo get_pretty_url($bo_table); ?>" class="lt_more">더보기</a>-->
    <a href="<?php echo $list_more; ?>" class="lt_more">더보기</a>
</div>

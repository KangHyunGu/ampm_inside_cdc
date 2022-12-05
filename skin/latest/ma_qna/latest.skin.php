<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;

if($team_code){
	$list_more = "/ae-".$utm_member."/qna/?team_code=".$team_code;
}else{
	$list_more = "/ae-".$utm_member."/qna/";
}
?>

<div class="la_qna">
	<h2 class="lat_title">
		<a href="<?php echo $list_more; ?>"><?php echo $bo_subject ?></a>
	</h2>

	<ul>
    <?php 
	for ($i=0; $i<$list_count; $i++) {  

		$string = $list[$i]['wr_5']; 
		$pattern = '/([0-9]+)-([0-9]+)-([0-9]{4})/'; 
		$replacement = '${1}-****-$3'; 
		$real_hp = preg_replace($pattern, $replacement, $string);

		if($team_code){
			$list_more = "/ae-".$utm_member."/qna/?team_code=".$team_code;
			$list[$i]['href'] = "/ae-".$utm_member."/qna/".$list[$i]['wr_id']."&team_code=".$team_code;
		}else{
			$list_more = "/ae-".$utm_member."/qna/";
			$list[$i]['href'] = "/ae-".$utm_member."/qna/".$list[$i]['wr_id'];
		}
	?>
      <!-- 1~3번째 게시물 번호 main_color 클래스 추가 -->
      <li class="line_box">
         <div class="lt_cate">
            <span class="cate"><?php echo $list[$i]['ca_name'] ?></span>
            <span class="check"><?=($list[$i]['wr_11'])?'지정':'전체'?></span>
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
            ?>
         </div>
         <div class="lt_con">
            <?php echo cut_str(preg_replace("@<.*?>@","", $list[$i]['wr_content']),85); ?>
         </div>
         <div class="lt_info">
            <div class="reply">
               <?php if ($list[$i]['comment_cnt']) { ?>
                  <span class="qnaIco qnaIco2">답변완료</span>
               <?php } else {?>
                  <span class="qnaIco qnaIco3">답변대기</span>
               <?php } ?>
            </div>
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

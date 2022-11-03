<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="lat">
    <!-- <h2 class="lat_title"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h2> -->
            <ul class="type_line">
                <?php for ($i=0; $i<$list_count; $i++) {  ?>
                  <!-- 1~3번째 게시물 번호 main_color 클래스 추가 -->
                  <li class="line_box">
                        <span><?=$i+1?></span>
                        <?php
                            if ($list[$i]['icon_secret']) echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

                            echo "<a href=\"".$list[$i]['href']."\"> ";
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

</div>

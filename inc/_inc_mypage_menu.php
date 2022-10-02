<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
///////////////////////////////////////////////////////////////////////
// 로그인 후 정보 처리
///////////////////////////////////////////////////////////////////////
include(G5_PATH.'/inc/_inc_loginMeberInfo.php'); 

?>       
<!-- 마이페이지 메뉴 -->
<ul class="mp_menu">
    <?php if($is_admin=='super' || $is_admin=='manager' || $member['ampmkey'] == 'Y'){   //마케터 ?>
    <li><a class="<?=($path_dep0==1)?'menu_on':''?>" href="<?=$go_amypage?>">내가 쓴 글</a></li>
    <li><a class="<?=($path_dep0==2)?'menu_on':''?>" href="<?=$go_acomment?>">내가 쓴 댓글</a></li>
    <li><a class="<?=($path_dep0==3)?'menu_on':''?>" href="<?=$go_qna?>">답변대기</a></li>
    <li><a class="<?=($path_dep0==4)?'menu_on':''?>" href="<?=$go_reqeust?>">대행의뢰</a></li>
    <li><a class="<?=($path_dep0==5)?'menu_on':''?>" href="<?=$go_estimate?>">상담현황</a></li>
    <?php }else if($is_admin=='super' || $member['ampmkey'] == ''){   //사용자 ?>
    <li><a class="<?=($path_dep0==1)?'menu_on':''?>" href="<?=$go_umypage?>">내가 쓴 글</a></li>
    <li><a class="<?=($path_dep0==2)?'menu_on':''?>" href="<?=$go_ucomment?>">내가 쓴 댓글</a></li>
    <li><a class="<?=($path_dep0==6)?'menu_on':''?>" href="<?=$go_favorites?>">즐겨찾기</a></li>
    <?php } ?>
</ul>


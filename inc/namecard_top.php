<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

///////////////////////////////////////////////////////////////////////
// 로그인 후 정보 처리
///////////////////////////////////////////////////////////////////////
include(G5_PATH.'/inc/_inc_loginMeberInfo.php'); 

?>
		<!-- 상단네임카드 -->
        <div class="content_nc">
            <!-- <h3><?php echo $view['name'] ?>마케터님의 컨텐츠 목록입니다.</h3> -->
            <ul>
                <li>
                    <div class="nc_img">
						<!-- 프로필 이미지 -->
						<?php echo $mb_images; ?>
                    </div>
                    <div class="title">
						<!-- PR 문구 -->
                        <h2><?php echo $mb_slogan ?></h2>
						<!-- 이름 -->
                        <h3><?php echo $nick ?></h3>
                    </div>
                </li>
                <li class="button">
                    <div><a href="<?=$go_reqeust?>"><i class="fas fa-edit"></i> 대행의뢰</a></div>
                    <div><a href="<?=$go_qna_edit?>"><i class="fas fa-question-circle"></i> 질문하기</a></div>
                    <div><a href="<?=$go_marketer?>"><i class="fas fa-house-user"></i> 마케터 페이지</a></div>
                </li>
            </ul>
        </div>

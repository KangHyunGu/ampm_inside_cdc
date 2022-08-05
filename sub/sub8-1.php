<!-- 마이페이지 -->

<?php
include_once('./_common.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MOBILE_PATH.'/sub/sub1-1.php');
    return;
}

include_once('./_head.php');

///////////////////////////////////////////////////////////////////////
// 로그인 후 정보 처리
///////////////////////////////////////////////////////////////////////
include(G5_PATH.'/inc/_inc_loginMeberInfo.php'); 
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<div id="container">
    <!-- 컨텐츠 영역 -->
    <section id="mypage">

        <!-- 상단네임카드 -->
        <div class="mp_top">
            <h3>마이페이지</h3>
            <ul>
                <li>
                    <div class="nc_img">
                        <?php echo $mb_images; ?>
                    </div>
                    <div class="title">
                        <h2><?php echo $mb_slogan ?></h2>
                        <h3><?php echo $nick ?></h3>
                        <div class="count">
                            <p>
                                내가 쓴 글 <span class="main_color">00</span>개
                            </p>
                            <p>
                                내가 쓴 댓글 <span class="main_color">00</span>개
                            </p>
                        </div>
                    </div>
                </li>
                <li class="button">
                    <div><a href="<?php echo G5_BBS_URL ?>/logout.php" class="logout_bt">로그아웃</a></div>
					<div><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="main_color ed_profile_bt"><?=($member['ampmkey'] == 'Y')?'프로필수정':'내 정보 수정'?></a></div>
                </li>
            </ul>
        </div>

        <!-- 게시판영역 시작 -->
        <div class="bo_list mp_board">

            <!-- 마이페이지 메뉴 -->
            <ul class="mp_menu">
                <li data-tab="tab-1"  class="menu_on">내가 쓴 글</li>
                <li data-tab="tab-2" >내가 쓴 댓글</li>
				<?php if($is_admin=='super' || $member['ampmkey'] == 'Y'){   //마케터 ?>
                <li data-tab="tab-3" >답변대기</li>
                <li data-tab="tab-4" >대행의뢰</li>
                <li data-tab="tab-5" >상담현황</li>
				<?php } ?>
            </ul>

            <!-- 게시판 스킨 불러오는 곳 -->
            <div id="tab-1" class="innerboard active">
                <?php
                    //내가쓴글
                    include_once(G5_PATH.'/sub/sub8-1-1.php');
                ?>
            </div>
            <div id="tab-2" class="innerboard">
                <?php
                    // 내가쓴댓글
                    include_once(G5_PATH.'/sub/sub8-1-2.php');
                ?>
            </div>
            <div id="tab-3" class="innerboard"> 
                <?php
                    // 답변대기
                    include_once(G5_PATH.'/sub/sub8-1-3.php');
                ?>
            </div>
            <div id="tab-4" class="innerboard"> 
                <?php
                    // 대행의뢰
                    include_once(G5_PATH.'/sub/sub8-1-4.php');
                ?>
            </div>
            <div id="tab-5" class="innerboard"> 
                <?php
                    // 상담현황
                    include_once(G5_PATH.'/sub/sub8-1-5.php');
                ?>
            </div>

            <script>
                $('.mp_menu li').click(function(){
                    var tabID = $(this).attr('data-tab');

                    $(this).addClass('menu_on');
                    $(this).siblings().removeClass('menu_on');

                    $("#"+tabID).addClass('active');
                    $("#"+tabID).siblings().removeClass('active');
                });

            </script>

        </div>
        <!-- 게시판영역 끝 -->

    </section>
</div>

<?php
//풋터
include_once('./_tail.php');
?>
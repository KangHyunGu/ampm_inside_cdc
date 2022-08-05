<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

include_once(G5_MOBILE_PATH.'/head.php');
?>

<!-- 메인화면 시작 -->
<section id="main">
    
    <!-- 비주얼 배너 -->
    <div class="visual_banner">
        <img src="<? G5_URL ?>/images/banner1.jpg" alt="비주얼배너1">
    </div>

    <!-- 마케터 인사이트 인기순/최신순 -->
    <div class="main_insight">
        <div class="head">
            <h2>마케터 인사이트</h2>
            <ul class="sort">
                <li class="tab_link active" data-tab="tab-1"><a href="#">인기순</a></li>
                <li class="tab_link"  data-tab="tab-2"><a href="#">최신순</a></li>
            </ul>
        </div>

        <div class="main_tab_con">
            <div  id="tab-1" class="type_popular con_box active">
                <!-- 인기순 -->
                <?php echo latest_popular("m_pop_insight", 'insight', 8, 18, 1, 'wr_hit desc', 'Y');?>
            </div>

            <div  id="tab-2" class="type_new con_box">
                <!-- 최신순 -->
                <?php echo latest('m_new_insight', 'insight', 8, 18);?>
            </div>
        </div>

        <div class="to_board">
            <a href="<?=G5_BBS_URL?>/board.php?bo_table=insight">인사이트 더보기 ></a>
        </div>

    </div>

    <!-- 영상교육 인기순/최신순 -->
    <div class="main_video">
        <div class="head">
            <h2>영상교육</h2>
            <ul class="sort">
                <li class="tab_link active" data-tab="tab-3"><a href="#">인기순</a></li>
                <li class="tab_link" data-tab="tab-4"><a href="#">최신순</a></li>
            </ul>
        </div>

        <div class="main_tab_con">

            <div id="tab-3" class="type_popular con_box active">
                <!-- 인기순 -->
                <?php echo latest_popular("m_pop_video", 'video', 6, 20, 1, 'wr_hit desc', 'Y');?>
            </div>

            <div id="tab-4" class="type_new con_box">
                <!-- 최신순 -->
                <?php echo latest('m_new_video', 'video', 6, 20);?>
            </div>
            
        </div>

        <div class="to_board">
            <a href="<?=G5_BBS_URL?>/board.php?bo_table=video">영상교육 더보기 ></a>
        </div>
    </div>

    <!-- 레퍼런스 인기순/최신순 -->
    <div class="main_refer">
        <div class="head">
            <h2>마케팅 레퍼런스</h2>
            <ul class="sort">
                <li class="tab_link active" data-tab="tab-5"><a href="#">인기순</a></li>
                <li class="tab_link" data-tab="tab-6"><a href="#">최신순</a></li>
            </ul>
        </div>

        <div class="main_tab_con">

            <div id="tab-5" class="type_popular con_box active">
                <!-- 인기순 -->
                <?php echo latest_popular("m_pop_reference", 'reference', 6, 20, 1, 'wr_hit desc', 'Y');?>
            </div>

            <div id="tab-6" class="type_new con_box">
                <!-- 최신순 -->
                <?php echo latest('m_new_reference', 'reference', 6, 20);?>
            </div>
            
        </div>

        <div class="to_board">
            <a href="<?=G5_BBS_URL?>/board.php?bo_table=video">마케팅 레퍼런스 더보기 ></a>
        </div>
    </div>


    <!-- 질문답변 인기순/최신순 -->
    <div class="main_qna">
        <div class="head">
            <h2>질문답변</h2>
            <ul class="sort">
                <li class="tab_link active" data-tab="tab-7"><a href="#">인기순</a></li>
                <li class="tab_link" data-tab="tab-8"><a href="#">최신순</a></li>
            </ul>
        </div>

        <div class="main_tab_con">
            
            <div id="tab-7" class="type_popular con_box active">
                <!-- 인기순 -->
                <?php echo latest_popular("m_pop_qa", 'qa', 8, 18, 1, 'wr_hit desc', 'Y');?>
            </div>

            <div id="tab-8" class="type_new con_box">
                <!-- 최신순 -->
                <?php echo latest('m_new_qa', 'qa', 8, 18);?>
            </div>

        </div>

        <div class="to_board">
            <a href="<?=G5_BBS_URL?>/board.php?bo_table=qna">질문답변 더보기 ></a>
        </div>
    </div>

    <!-- 금주의 추천 마케터 10명 -->
    <div class="main_marketer">
        <div class="title_box">
            <h2>금주의 추천 마케터</h2>
        </div>
        <div class="mkt_slider">
            <div class="slide_wrapper">
                <?php include_once(G5_PATH.'/inc/_marketerInfo.php'); ?>
                <?php echo latest_maketer(8); ?>

                <!-- 클릭시 해당 마케터 페이지로 이동 -->
                <!-- <a href="#">
                    <div class="mkt">
                        마케터 이미지
                        <div class="mkt_img">
                            <img src="<? G5_URL ?>/images/profile_ex.jpg" alt="마케터 프로필 예시">
                        </div>
                        마케터 이름
                        <div class="mkt_name">
                            김가영
                        </div>
                    </div>
                </a> -->
            </div>
            <div class="pager">
                <div class="prev pager_btn">
                    <i class="fa-solid fa-angle-left"></i>
                </div>
                <div class="next pager_btn">
                    <i class="fa-solid fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>




</section>

<!-- 메인화면 끝 -->

<?php
include_once(G5_MOBILE_PATH.'/tail.php');
?>
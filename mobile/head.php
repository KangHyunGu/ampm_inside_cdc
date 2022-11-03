<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

///////////////////////////////////////////////////////////////////
//인기글가져오기  - feeris
///////////////////////////////////////////////////////////////////
include_once(G5_LIB_PATH.'/latest_popular.lib.php');
?>
<?php
////////////////////////////////////////
//path_dep0 = 마이페이지 탭메뉴 코드
////////////////////////////////////////
include(G5_PATH.'/inc/_inc_top_path.php');
?>
<header id="hd" class="sticky">
    <!-- <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div class="to_content"><a href="#container">본문 바로가기</a></div>-->

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        // include G5_MOBILE_PATH.'/newwin.inc.php';
        // 팝업레이어
    } ?>
 
    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>">
                <img src="<? G5_URL?>/images/logo.png" alt="<?php echo $config['cf_title']; ?>">
            </a>
        </div>

        <div id="sch_btn">
            <img src="<? G5_URL ?>/images/sch_icon.png">
        </div>

        <button type="button" id="menu_open" class="hd_opener">
            <span class="sound_only"> 메뉴열기</span>
            <div class="open_icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>

    <div id="hd_open_sch">
      <div class="close_icon">
         <span></span>
         <span></span>
      </div>

      <form name="fsearchbox" method="get" action="<?=G5_BBS_URL?>/search.php" onsubmit="return fsearchbox_submit(this);" class="sidebar-form">
         <input type="hidden" name="sfl" value="wr_subject||wr_content||wr_18||wr_12">
         <input type="hidden" name="sop" value="and">
         
         <div class="input-group input-group-sm">
         <label for="sch_stx" class="sound_only">검색어 필수</label>
         <input type="text" name="stx" id="sch_stx" maxlength="20" class="form-control" placeholder="검색어를 입력하세요.">
         <span class="input-group-btn">
            <button type="submit" id="sch_submit" value="검색" class="btn btn-flat">검색</button>
         </span>	
         </div>
      </form>

    </div>

    <div id="menu" class="hd_div">
        <div class="top">
                <button type="button" id="menu_close" class="hd_closer">
                    <span class="sound_only">메뉴 닫기</span>
                    <div class="close_icon">
                        <span></span>
                        <span></span>
                    </div>
                </button>
        </div>
        <div class="bottom">
            <?php include(G5_PATH.'/inc/_inc_login.php'); ?>

            <div class="menu_gnb">
                <ul>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=insight">마케팅 인사이트</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=video">영상 교육</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=reference">마케팅 레퍼런스</a>
                    </li>
                    <li>
                        <a href="<?=G5_BBS_URL?>/board.php?bo_table=qna">질문답변</a>
                    </li>
                    <li>
                        <a href="<?=G5_URL?>/marketer/#section4">마케터 소개</a>
                    </li>
                </ul>
            </div>

            
            <div id="hd_sch">
               <form name="fsearchbox" method="get" action="<?=G5_BBS_URL?>/search.php" onsubmit="return fsearchbox_submit(this);" class="sidebar-form">
				  <input type="hidden" name="sfl" value="wr_subject||wr_content||wr_18||wr_12">
                  <input type="hidden" name="sop" value="and">
                  
                  <div class="input-group input-group-sm">
                  <label for="sch_stx" class="sound_only">검색어 필수</label>
                  <input type="text" name="stx" id="sch_stx" maxlength="20" class="form-control" placeholder="검색어를 입력하세요.">
                  <span class="input-group-btn">
                     <button type="submit" id="sch_submit" value="검색" class="btn btn-flat"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
                  </span>	
                  </div>
               </form>

                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>
            </div>
               
        </div>
    </div>

    <script>
        $(function () {
            //폰트 크기 조정 위치 지정
            var font_resize_class = get_cookie("ck_font_resize_add_class");
            if( font_resize_class == 'ts_up' ){
                $("#text_size button").removeClass("select");
                $("#size_def").addClass("select");
            } else if (font_resize_class == 'ts_up2') {
                $("#text_size button").removeClass("select");
                $("#size_up").addClass("select");
            }

            $(window).scroll(function(){
                var sticky = $('.sticky'),
                    scroll = $(window).scrollTop();

                if (scroll >= 60) sticky.addClass('fixed');
                else sticky.removeClass('fixed');
                });

            $(".hd_closer").on("click", function() {
                var idx = $(".hd_closer").index($(this));
                $(".hd_div").animate({left: '150vw'});
            });

            $(".hd_opener").on("click", function() {
                var idx = $(".hd_opener").index($(this));
                $(".hd_div").animate({left: '0'});
            });


            $(".btn_gnb_op").click(function(){
                $(this).toggleClass("btn_gnb_cl").next(".gnb_2dul").slideToggle(300);
                
            });

            $("#sch_btn").on("click", function() {
               $("#hd_open_sch").addClass("open");
            });

            $("#hd_open_sch .close_icon").on("click", function() {
               $("#hd_open_sch").removeClass("open");
            });

        });
    </script>

</header>
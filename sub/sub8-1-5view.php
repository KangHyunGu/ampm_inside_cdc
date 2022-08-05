<!-- 마이페이지 상담현황 뷰-->

<?php
include_once('./_common.php');

if (G5_IS_MOBILE) { 
    include_once(G5_MOBILE_PATH.'/sub/sub1-1.php');
    return;
}

include_once('./_head.php');
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
                        <?php echo get_member_profile_img($view['mb_id']); ?>
                    </div>
                    <div class="title">
                        <h2>당신의 매출 성장을 견인하겠습니다!</h2>
                        <h3>이름<?php echo $view['name'] ?> AE</h3>
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
                    <div><a href="#" class="logout_bt">로그아웃</a></div>
                    <div><a href="#" class="main_color ed_profile_bt">내 정보 수정</a></div>
                </li>
            </ul>
        </div>

        <!-- 게시판영역 시작 -->
        <div class="bo_list mp_board">
            <!-- 게시물 읽기 시작 { -->
            <article id="mp5_v" style="width:<?php echo $width; ?>">

                <!-- 본문 내용 시작 { -->
                <table id="mp5_v_table">
                    <tbody>
                        <tr>
                            <th>업체명</th>
                            <td>영프라이스개발</td>
                        </tr>
                        <tr>
                            <th>연락처</th>
                            <td>010-3931-6193</td>
                        </tr>
                        <tr>
                            <th>월 예상 광고비</th>
                            <td>100만원 - 500만원</td>
                        </tr>
                        <tr>
                            <th>관심매체</th>
                            <td>DA광고(구글/GFA/카카오 등)</td>
                        </tr>
                        <tr>
                            <th>IP</th>
                            <td>112.144.14.180</td>
                        </tr>
                        <tr>
                            <th>상담상태</th>
                            <td>접수</td>
                        </tr>
                        <tr>
                            <th>등록일</th>
                            <td>2022-07-02 11:12</td>
                        </tr>

                    </tbody>
                </table>
                <!-- } 본문 내용 끝 -->



                <!-- 게시물 상단 버튼 시작 { -->
                <div id="mp5_v_bot">
                    <?php ob_start(); ?>

                    <?php if ($prev_href || $next_href) { ?>
                        <ul class="mp5_v_nb">
                            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?><?=$sublink?>" class="btn_b03 btn">이전글</a></li><?php } ?>
                            <li><a href="<?php echo $list_href ?><?=$sublink?>" class="btn_b03 btn">목록</a></li>
                            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?><?=$sublink?>" class="btn_b03 btn">다음글</a></li><?php } ?>
                        </ul>
                    <?php } ?>

                        <ul class="mp5_v_com">
                            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?><?=$sublink?>" class="btn_b02 btn">수정</a></li><?php } ?>
                            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?><?=$sublink?>" class="btn_b02 btn" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
                            <li><a href="#" class="btn_b02 btn">숨김</a></li>
                            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?><?=$sublink?>" class="btn_b01 btn">글쓰기</a></li><?php } ?>
                        </ul>
                    <?php
                        $link_buttons = ob_get_contents();
                        ob_end_flush();
                    ?>
                </div>
                <!-- } 게시물 상단 버튼 끝 -->

            </article>
            <!-- } 게시판 읽기 끝 -->
        </div>
    </section>
</div>

<?php
//풋터
include_once('./_tail.php');
?>
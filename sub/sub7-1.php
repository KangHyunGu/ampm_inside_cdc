<!-- 컨텐츠더보기 -->

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
   <!-- 좌측 컨텐츠 영역 -->
   <section class="section_left">

        <!-- 상단네임카드 -->
        <div class="content_nc">
            <h3><?php echo $view['name'] ?>마케터님의 컨텐츠 목록입니다.</h3>
            <ul>
                <li>
                    <div class="nc_img">
                        <?php echo get_member_profile_img($view['mb_id']); ?>
                    </div>
                    <div class="title">
                        <h2>당신의 매출 성장을 견인하겠습니다!</h2>
                        <h3><?php echo $view['name'] ?> AE</h3>
                    </div>
                </li>
                <li class="button">
                    <div><a href="../sub/sub8-1-4write.php"><i class="fas fa-edit"></i> 대행의뢰</a></div>
                    <div><a href="#"><i class="fas fa-question-circle"></i> 질문하기</a></div>
                    <div><a href="#"><i class="fas fa-house-user"></i> 마케터 페이지</a></div>
                    <div class="bookmark"><a href="#"><i class="fas fa-star"></i> 즐겨찾기</a></div>
                    <div class="bookmark"><a href="#" class="add"><i class="fas fa-star"></i> 즐겨찾기</a></div>
                </li>
            </ul>
        </div>

        <!-- 컨텐츠더보기 게시판 -->
        <div class="bo_list mkp_board">
            <!-- 게시판 스킨 불러오는 곳 -->

            <!-- 게시판영역 시작 -->
            <!-- 게시판 list -->
            <div class="bo_fx bo_cate_top">
                <div class="bo_count">
                    총 OO개 게시물
                </div>
                <!-- <div class="bo_sort">
                    <ul>
                        <li class="on">
                        <a href="#">최신순</a>
                        </li>
                        <li>
                        <a href="#">인기순</a>
                        </li>
                    </ul>
                </div> -->
            </div>

            <div class="bo_table">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <!-- <th scope="col">
                                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                            </th> -->
                            <th scope="col">카테고리</th>
                            <th scope="col">구분</th>
                            <th scope="col">제목</th>
                            <th scope="col">작성자</th>
                            <th scope="col">등록일</th>
                            <th scope="col">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 리스트에 게시글 15개 노출-->
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <!-- <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td> -->
                            <td class="td_board_category">인사이트</td>
                            <td class="td_category">매체</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- 페이지 -->
            <div class="pg_wrap">
                <a href="#" class="pg_page pg_current">1</a>
                <a href="#" class="pg_page">2</a>
                <a href="#" class="pg_page">3</a>
                <a href="#" class="pg_page">4</a>
                <a href="#" class="pg_page">5</a>
                <a href="#" class="pg_page pg_next"><i class="fa-solid fa-angle-right"></i></a>
                <a href="#" class="pg_page pg_end"><i class="fa-solid fa-angles-right"></i></a>
            </div>


            <!-- 검색 -->
            <div class="bo_search">
                <fieldset id="bo_sch">
                    <legend>게시물 검색</legend>

                    <form name="fsearch" method="post">
                    <input type="hidden" name="page" value="1">
                    <input type="hidden" name="mkcheck" value="<?php echo ($mkcheck)?$mkcheck:'all' ?>">
                    <label for="sfl" class="sound_only">검색대상</label>
                    <select name="sfl" id="sfl">
                        <option value="전체">전체</option>
                        <option value="제목">제목</option>
                        <option value="게시글+댓글">게시글+댓글</option>
                        <option value="작성자">작성자</option>
                    </select>
                    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="sch_input" size="25" maxlength="20">
                    <button type="submit" value="검색" class="sch_btn">검색</button>
                    </form>
                </fieldset>
            </div>

            <!-- 게시판영역 끝 -->
        </div>

   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>
<script>
    
    $('.bookmark a').click(function(){
        $(this).toggleClass("add")
	});

</script>
<?php
//풋터
include_once('./_tail.php');
?>
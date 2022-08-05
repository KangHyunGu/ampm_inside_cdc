<!-- 마이페이지 답변대기 -->
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

        <?php
            //마이페이지 네임카드
            include_once(G5_PATH.'/sub/sub9-1.php');
        ?>

        <!-- 게시판영역 시작 -->
        <div class="bo_list mp_board">

            <!-- 마이페이지 메뉴 -->
            <ul class="mp_menu">
                <li><a href="/sub/sub9-1-1.php">내가 쓴 글</a></li>
                <li><a href="/sub/sub9-1-2.php">내가 쓴 댓글</a></li>
				<?php if($is_admin=='super' || $member['ampmkey'] == 'Y'){   //마케터 ?>
                <li><a  class="menu_on" href="/sub/sub9-1-3.php">답변대기</a></li>
                <li><a href="/sub/sub9-1-4.php">대행의뢰</a></li>
                <li><a href="/sub/sub9-1-5.php">상담현황</a></li>
				<?php } ?>
                <?php if($is_admin=='super' || $member['ampmkey'] == 'N'){   //사용자 ?>
                <li><a href="/sub/sub9-1-6.php">즐겨찾기</a></li>
				<?php } ?>
            </ul>


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

            <div class="bo_table mp-1">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">
                                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                            </th>
                            <th scope="col">구분</th>
                            <th scope="col">주제</th>
                            <th scope="col">노출상태</th>
                            <th scope="col">제목</th>
                            <th scope="col">작성자</th>
                            <th scope="col">지정여부</th>
                            <th scope="col">등록일</th>
                            <th scope="col">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 리스트에 게시글 15개 노출-->
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco3">답변대기</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject">
                                <a href="#">게시글 제목입니다.</a>
                                <span class="new_icon">N<span class="sound_only">새글</span></span>
                            </td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco3">답변대기</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject">
                                <a href="#">게시글 제목입니다.</a>
                                <span class="new_icon">N<span class="sound_only">새글</span></span>
                            </td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject">
                                <a href="#">게시글 제목입니다.</a>
                                <span class="cnt_cmt">1</span>
                            </td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>
                        <tr class="even">
                            <td class="td_num2">15</td>
                            <td class="td_chk">
                                <label for="chk_wr_id_0" class="sound_only"></label>
                                <input type="checkbox" name="chk_wr_id[]" value="25" id="chk_wr_id_0">
                            </td>
                            <td class="td_board_category">
                                <span class="qnaIco qnaIco2">답변완료</span>
                            </td>
                            <td class="td_category">매체</td>
                            <td class="td_s_h">노출</td>
                            <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                            <td class="td_w_name">홍길동</td>
                            <td class="td_designate">지정</td>
                            <td class="td_date">2022-06-29</td>
                            <td class="td_num">0</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- 글쓰기 버튼 -->
            <div class="mp_bt_wrap">
                <div class="bo_fx">
                    <ul class="btn_bo_user">
                        <li><button class="btn_b02">선택삭제</button></li>
                        <li><button class="btn_b02">선택숨김</button></li>
                        <li><a href="#" class="btn_b04">인사이트 글쓰기</a></li>
                        <li><a href="#" class="btn_b04">영상교육 글쓰기</a></li>
                        <li><a href="#" class="btn_b04">레퍼런스 글쓰기</a></li>
                    </ul>
                </div>
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

        </div>
        <!-- 게시판영역 끝 -->

    </section>
</div>

<?php
//풋터
include_once('./_tail.php');
?>

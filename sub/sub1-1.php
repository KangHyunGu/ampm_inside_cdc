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

<div id="container" class="sub">
    <!-- 좌측 컨텐츠 영역 -->
    <section class="section_left">
        <!-- 비주얼 배너 -->
        <div class="visual_banner">
            <img src="<? G5_URL ?>/images/sub_banner1.jpg" alt="마케터 인사이트 배너">
        </div>

        <!-- 금주의 인기글 슬라이드 -->
        <div class="week_lank">
            <h3>금주의 인사이트 BEST 10 <span>🏆</span></h3>
            <div class="lank_slider">
               <div class="lank">
                  <a href="#">
                     <!-- 게시판 이미지 -->
                     <div class="lank_img">
                        <img src="<? G5_URL ?>/images/img_box_ex.jpg">
                     </div>
                     <!-- 게시판 제목 -->
                     <div class="lank_subject">
                        게시판 제목입니다. 글자수는 20까지 출력됩니다.
                     </div>
                  </a>
               </div>
               <div class="lank">
                  <a href="#">
                     <!-- 게시판 이미지 -->
                     <div class="lank_img">
                        <img src="<? G5_URL ?>/images/img_box_ex.jpg">
                     </div>
                     <!-- 게시판 제목 -->
                     <div class="lank_subject">
                        게시판 제목
                     </div>
                  </a>
               </div>
               <div class="lank">
                  <a href="#">
                     <!-- 게시판 이미지 없는경우 -->
                     <div class="lank_img">
                        <img src="<? G5_URL ?>/images/sub1_defualt.jpg">
                     </div>
                     <!-- 게시판 제목 -->
                     <div class="lank_subject">
                        게시판 제목
                     </div>
                  </a>
               </div>
               <div class="lank">
                  <a href="#">
                     <!-- 게시판 이미지 -->
                     <div class="lank_img">
                        <img src="<? G5_URL ?>/images/img_box_ex.jpg">
                     </div>
                     <!-- 게시판 제목 -->
                     <div class="lank_subject">
                        게시판 제목
                     </div>
                  </a>
               </div>
            </div>
            <div class="lank_slider_btn">
               <div class="prev">
                  <i class="fa-solid fa-angle-left"></i>
               </div>
               <div class="next">
                  <i class="fa-solid fa-angle-right"></i>
               </div>
            </div>
        </div>

         <!-- 인사이트 게시판 -->
         <div class="bo_list insight_board">
            <!-- 게시판 스킨 불러오는 곳 -->

            <!-- 게시판 분류 -->
            <div class="bo_cate">
               <ul id="bo_cate_ul">
                  <li>
                     <a href="#" id="bo_cate_on">전체</a>
                  </li>
                  <li>
                     <a href="#">제안서</a>
                  </li>
                  <li>
                     <a href="#">성과보고서</a>
                  </li>
                  <li>
                     <a href="#">네이버</a>
                  </li>
                  <li>
                     <a href="#">카카오</a>
                  </li>
                  <li>
                     <a href="#">구글</a>
                  </li>
                  <li>
                     <a href="#">SNS</a>
                  </li>
                  <li>
                     <a href="#">배너</a>
                  </li>
                  <li>
                     <a href="#">기타</a>
                  </li>
               </ul>
            </div>


            <!-- 게시판 list -->
            <div class="bo_cate_top">
               <div class="bo_count">
                  총 OO개 게시물
               </div>
               <div class="bo_sort">
                  <ul>
                     <li class="on">
                        <a href="#">최신순</a>
                     </li>
                     <li>
                        <a href="#">인기순</a>
                     </li>
                  </ul>
               </div>
            </div>

            <div class="bo_table">
               <table>
                  <thead>
                     <tr>
                        <th scope="col">번호</th>
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
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">14</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">13</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">12</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">11</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">10</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">9</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">8</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">7</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">6</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">5</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">4</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">3</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">2</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
                        <td class="td_date">2022-06-29</td>
                        <td class="td_num">0</td>
                     </tr>
                     <tr class="even">
                        <td class="td_num2">1</td>
                        <td class="td_category">게시판분류</td>
                        <td class="td_subject"><a href="#">게시글 제목입니다.</a></td>
                        <td class="td_name">홍길동</td>
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


            <!-- 검색, 글쓰기 버튼 -->
            <div class="bt_wrap">
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

               <!-- 글쓰기 버튼 -->
               <div class="bo_fx">
                  <ul class="btn_bo_user">
                     <li>
                        <a href="#" class="btn_b01 btn">글쓰기</a>
                     </li>
                  </ul>
               </div>
            </div>
        </div>
   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>

<?php
//풋터
include_once('./_tail.php');
?>
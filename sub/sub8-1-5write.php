<!-- 마이페이지 상담현황 글쓰기-->
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


        <div class="container_wr">
            <section id="mp5_w">
                <h2 id="container_title">상담현황 글수정</h2>

                <!-- 게시물 작성/수정 시작 { -->
                <form name="fwrite" id="fwrite" action="write_update.php" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:100%">
                    <input type="hidden" name="uid" value="22071813131600">
                    <input type="hidden" name="w" value="u">
                    <input type="hidden" name="bo_table" value="mkestimate">
                    <input type="hidden" name="wr_id" value="188">
                    <input type="hidden" name="sca" value="">
                    <input type="hidden" name="sfl" value="">
                    <input type="hidden" name="stx" value="">
                    <input type="hidden" name="spt" value="">
                    <input type="hidden" name="sst" value="">
                    <input type="hidden" name="sod" value="">
                    <input type="hidden" name="page" value="0">
                
                    <div class="tbl_frm01 tbl_wrap">
                        <table>
                            <tbody>
                                <input type="hidden" name="wr_subject" id="wr_subject" class="frm_input" value="상담신청이 접수되었습니다.">
                            
                                <tr>
                                    <th>업체명</th>
                                    <td colspan="5">
                                        <input type="text" name="wr_1" id="wr_1" class="frm_input" value="영프라이스개발">
                                    </td>
                                </tr>

                                <tr>
                                    <th>연락처</th>
                                    <td colspan="5">
                                        <select name="memberHp1" id="memberHp1" required="" class="frm_input2 required">
                                            <option value="010" selected="">010</option><option value="011">011</option><option value="060">060</option><option value="070">070</option>
                                        </select> - 
                                        <input name="memberHp2" id="memberHp2" itemname="휴대전화2" required="" class="frm_input required" value="3931" size="6" maxlength="4"> -
                                        <input name="memberHp3" id="memberHp3" itemname="휴대전화3" required="" class="frm_input required" value="6193" size="6" maxlength="4">
                                    </td>
                                </tr>

                                <tr>
                                    <th>월 예상 광고비</th>
                                    <td colspan="5">
                                        <select name="wr_2" id="wr_2" class="frm_input2">
                                        <option value="50만원 - 100만원">50만원 - 100만원</option><option value="100만원 - 500만원" selected="">100만원 - 500만원</option><option value="500만원 - 1,000만원">500만원 - 1,000만원</option><option value="1,000만원 - 5,000만원">1,000만원 - 5,000만원</option><option value="5,000만원 이상">5,000만원 이상</option>				</select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>관심매체</th>
                                    <td colspan="5">
                                        <select name="wr_3" id="wr_3" class="frm_input2">
                                        <option value="검색광고">검색광고</option><option value="바이럴광고">바이럴광고</option><option value="DA광고(구글/GFA/카카오 등)" selected="">DA광고(구글/GFA/카카오 등)</option><option value="앱광고">앱광고</option><option value="제휴광고">제휴광고</option><option value="기타광고">기타광고</option><option value="SNS광고">SNS광고</option><option value="언론홍보">언론홍보</option>				</select>
                                    </td>
                                </tr>

                                <input type="hidden" name="wr_content" id="wr_content" class="frm_input" value="-">
                                
                                <tr>
                                    <th>상담상태</th>
                                    <td colspan="5">
                                        <select name="wr_10" id="wr_10" required="" class="frm_input2 required">
                                            <option value="접수" selected="">접수</option>
                                            <option value="상담중">상담중</option>
                                            <option value="상담완료">상담완료</option>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="btn_confirm">
                        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
                        <a href="./board.php?bo_table=mkestimate" class="btn_b02">목록</a>
                    </div>
                </form>
            </section>
            <!-- } 게시물 작성/수정 끝 -->
            <noscript>
                <p>
                    귀하께서 사용하시는 브라우저는 현재 <strong>자바스크립트를 사용하지 않음</strong>으로 설정되어 있습니다.<br>
                    <strong>자바스크립트를 사용하지 않음</strong>으로 설정하신 경우는 수정이나 삭제시 별도의 경고창이 나오지 않으므로 이점 주의하시기 바랍니다.
                </p>
            </noscript>
        </div>
    </section>
</div>

<?php
//풋터
include_once('./_tail.php');
?>
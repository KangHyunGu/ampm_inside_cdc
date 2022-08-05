<!-- 마이페이지 대행의뢰 글쓰기-->
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
            <!-- <h3><?php echo $view['name'] ?>마케터님의 컨텐츠 목록입니다.</h3> -->
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
                </li>
            </ul>
        </div>

        <div class="container_wr">
            <section id="mp4_w">
                <h2 id="container_title">대행의뢰 작성 화면입니다.</h2>

                <!-- 게시물 작성/수정 시작 { -->
                <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
                    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
                    <input type="hidden" name="w" value="<?php echo $w ?>">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
                    <input type="hidden" name="sca" value="<?php echo $sca ?>">
                    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                    <input type="hidden" name="stx" value="<?php echo $stx ?>">
                    <input type="hidden" name="spt" value="<?php echo $spt ?>">
                    <input type="hidden" name="sst" value="<?php echo $sst ?>">
                    <input type="hidden" name="sod" value="<?php echo $sod ?>">
                    <input type="hidden" name="page" value="<?php echo $page ?>">

                    <input type="hidden" name="path_dep1"		id="path_dep1" 		value="<?=$path_dep1?>" />
                    <input type="hidden" name="path_dep2"		id="path_dep2" 		value="<?=$path_dep2?>" />
                    <input type="hidden" name="path_dep3"		id="path_dep3" 		value="<?=$path_dep3?>" />
                    <input type="hidden" name="path_dep4"		id="path_dep4" 		value="<?=$path_dep4?>" />

                    <?php
                    $option = '';
                    $option_hidden = '';
                    if ($is_notice || $is_html || $is_secret || $is_mail) {
                        $option = '';
                        if ($is_notice) {
                            $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
                        }

                        if ($is_html) {
                            if ($is_dhtml_editor) {
                                $option_hidden .= '<input type="hidden" value="html1" name="html">';
                            } else {
                                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
                            }
                        }

                        if ($is_secret) {
                            if ($is_admin || $is_secret==1) {
                                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
                            } else {
                                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                            }
                        }

                        if ($is_mail) {
                            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
                        }
                    }

                    echo $option_hidden;
                    ?>

                    <div class="tbl_frm01 tbl_wrap">
                        <table>
                            <tbody>
                                <?php if ($is_name) { ?>
                                <tr>
                                    <th scope="row"><label for="wr_name">작성자<strong class="sound_only"> 필수</strong></label></th>
                                    <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
                                </tr>
                                <?php } ?>

                                <!-- 입력란추가 -->

                                <!-- 업체명 -->
                                <tr>
                                    <th scope="row"><label for="wr_brand">업체명<strong class="sound_only">필수</strong></label></th>
                                    <td><input type="text" name="wr_name" value="" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
                                </tr>

                                <!-- 관심매체 -->
                                <tr>
                                    <th>관심매체</th>
                                    <td colspan="5">
                                        <select name="wr_3" id="wr_3" class="frm_input2">
                                        <option value="검색광고">검색광고</option><option value="바이럴광고">바이럴광고</option><option value="DA광고(구글/GFA/카카오 등)" selected="">DA광고(구글/GFA/카카오 등)</option><option value="앱광고">앱광고</option><option value="제휴광고">제휴광고</option><option value="기타광고">기타광고</option><option value="SNS광고">SNS광고</option><option value="언론홍보">언론홍보</option>				</select>
                                    </td>
                                </tr>


                                <!-- 예상광고비 -->
                                <tr>
                                    <th>월 예상 광고비</th>
                                    <td colspan="5">
                                        <select name="wr_2" id="wr_2" class="frm_input2">
                                            <option value="50만원 - 100만원" selected="">50만원 - 100만원</option>
                                            <option value="100만원 - 500만원">100만원 - 500만원</option>
                                            <option value="500만원 - 1,000만원">500만원 - 1,000만원</option>
                                            <option value="1,000만원 - 5,000만원">1,000만원 - 5,000만원</option>
                                            <option value="5,000만원 이상">5,000만원 이상</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- 연락처 -->
                                <tr>
                                    <th>연락처</th>
                                    <td colspan="5">
                                        <select name="memberHp1" id="memberHp1" required="" class="frm_input2 required">
                                            <option value="010" selected="">010</option>
                                            <option value="011">011</option>
                                            <option value="060">060</option>
                                            <option value="070">070</option>
                                        </select> - 
                                        <input name="memberHp2" id="memberHp2" itemname="휴대전화2" required="" class="frm_input required" value="" size="6" maxlength="4"> -
                                        <input name="memberHp3" id="memberHp3" itemname="휴대전화3" required="" class="frm_input required" value="" size="6" maxlength="4">
                                    </td>
                                </tr>

                                <?php if ($is_password) { ?>
                                <tr>
                                    <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only"> 필수</strong></label></th>
                                    <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
                                </tr>
                                <?php } ?>

                                <?php if ($is_email) { ?>
                                <tr>
                                    <th scope="row"><label for="wr_email">이메일</label></th>
                                    <td><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" size="50" maxlength="100"></td>
                                </tr>
                                <?php } ?>

                                <?php if ($is_homepage) { ?>
                                <tr>
                                    <th scope="row"><label for="wr_homepage">홈페이지</label></th>
                                    <td><input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input" size="50"></td>
                                </tr>
                                <?php } ?>

                                <!-- 내용 -->
                                <tr>
                                    <th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
                                    <td class="wr_content">
                                        <input type="texteara">
                                        <!-- <?php if($write_min || $write_max) { ?>
                                        최소/최대 글자 수 사용 시
                                        <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                                        <?php } ?>
                                        <?php echo $editor_html; 
                                        // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                                        <?php if($write_min || $write_max) { ?>
                                        최소/최대 글자 수 사용 시
                                        <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                                        <?php } ?> -->
                                    </td>
                                </tr>

                                <?php if ($is_guest) { //자동등록방지  ?>
                                <tr>
                                    <th scope="row">자동등록방지</th>
                                    <td>
                                        <?php echo $captcha_html ?>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>

                        <!-- 개인정보처리방침 -->
                        <div class="agreement">
                            <input type="checkbox" id="personal" name="personal" value="personal">
                            <label for="personal">
                                <span>
                                    개인정보처리방침 동의 <a href="#">[보기]</a>
                                </span>    
                            </label>
                        </div>
                    </div>
                    
                    <div class="btn_confirm">
                        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
                        <a href="./board.php?bo_table=<?php echo $bo_table ?><?=$sublink?>" class="btn_cancel">취소</a>
                    </div>
                </form>
            </section>
            <!-- } 게시물 작성/수정 끝 -->
        </div>

   </section>

   <!-- 우측 side 영역 -->
   <?php include(G5_PATH.'/inc/aside.php'); ?>
</div>
<?php
//풋터
include_once('./_tail.php');
?>


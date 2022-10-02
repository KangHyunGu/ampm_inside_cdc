<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$mypage_skin_url.'/style.css">', 1);

/////////////////////////////////////////////////////////////
//AMPM 사원이면 확인여부 확인처리
// $is_checkbox = true;
/////////////////////////////////////////////////////////////
if($member['ampmkey'] == 'Y'){
	$write_table = $g5['write_prefix'].$bo_table;
	sql_query(" UPDATE $write_table SET wr_16 = 'Y' WHERE wr_id = '{$wr_id}' AND wr_11 = '{$member['mb_id']}' ", false);
}
?>

<section id="m_mypage">

    <nav id="bo_cate" class="mp_ca_sticky">
        <?php
            //마이페이지 메뉴
            include(G5_PATH.'/inc/_inc_mypage_menu.php');
        ?>
    </nav>

    <?php
        //마이페이지 네임카드
        include_once(G5_PATH.'/inc/_inc_mypage_top.php');
    ?>

    <nav id="bo_cate2" class="b_mp_ca">
        <?php
            //마이페이지 메뉴
            include(G5_PATH.'/inc/_inc_mypage_menu.php');
        ?>
    </nav>

    <!-- 게시물 읽기 시작 { -->
    <article id="bo_v" style="width:<?php echo $width; ?>">

        <!-- 본문 내용 시작 { -->
        <table id="mp5_v_table">
            <tbody>
                <tr>
                    <th>업체명</th>
                    <td class="brand_name">
                        <?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?>
                    </td>
                </tr>
                <tr>
                    <th>관심매체</th>
                    <td><?=codeToName($code_selltype, $view['wr_3'])?></td>
                </tr>
                <tr>
                    <th>월 예상 광고비</th>
                    <td><?=codeToName($code_monthPrice, $view['wr_2'])?></td>
                </tr>
                <tr>
                    <th>연락처</th>
                    <td><?=$view['wr_5']?></td>
                </tr>

                <tr>
                    <th>의뢰내용</th>
                    <td><div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div></td>
                </tr>
                <tr>
                    <th>관련링크</th>
                    <td>
                        <?php
                        if (implode('', $view['link'])) {
                        ?>
                        <!-- 관련링크 시작 { -->
                        <section id="bo_v_link">
                        <?php
                            // 링크
                            $cnt = 0;
                            for ($i=1; $i<=count($view['link']); $i++) {
                                if ($view['link'][$i]) {
                                    $cnt++;
                                    $link = cut_str($view['link'][$i], 70);
                        ?>
                            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                                <?php echo $link ?>
                            </a>
                            <!--<span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>-->
                        <?php
                                }
                            }
                        ?>
                        </section>
                        <!-- } 관련링크 끝 -->
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th>첨부파일</th>
                    <td>
                        <?php
                            if ($view['file']['count']) {
                                $cnt = 0;
                                for ($i=0; $i<count($view['file']); $i++) {
                                    if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'])
                                        $cnt++;
                                }
                            }
                        ?>

                        <?php
                            // 가변 파일
                            for ($i=0; $i<count($view['file']); $i++) {
                                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source']) {
                        ?>
                        <!-- 첨부파일 시작 { -->
                        <section id="bo_v_file">
                            <ul>
                                <li>
                                    <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                                        <?php echo $view['file'][$i]['source'] ?>
                                        <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                                    </a>
                                    <!--
                                    <span class="bo_v_file_cnt ">다운로드 : <?php echo $view['file'][$i]['download'] ?>회 &nbsp;&nbsp;</span>
                                    <span class="">DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                                    -->				
                                </li>
                            </ul>
                        </section>
                        <!-- } 첨부파일 끝 -->
                        <?php
                                }
                            }
                        ?>
                        
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- } 본문 내용 끝 -->
    
    
        <section id="bo_v_atc">
   
            <!-- 게시물 상단 버튼 시작 { -->
            <div id="bo_v_top">
                <?php ob_start(); ?>

                <?php if ($prev_href || $next_href) { ?>
                <ul class="bo_v_nb">
                    <?php if ($prev_href) { ?>
                        <li>
                            <p><i class="fa-solid fa-caret-up"></i>이전글</p>
                            <a href="<?php echo $prev_href ?>">
                                <?php echo cut_str(get_text($prev_wr_subject),15) ?>
                                <span>
                                    <?php if ($prev_href) echo date("y-m-d", strtotime($prev['wr_datetime'])) ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($next_href) { ?>
                        <li>
                            <p><i class="fa-solid fa-sort-down"></i>다음글</p>
                            <a href="<?php echo $next_href ?>">
                                <?php echo cut_str(get_text($next_wr_subject),15) ?>
                                <span>
                                    <?php if ($next_href) echo date("y-m-d", strtotime($next['wr_datetime'])) ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
                <?php } ?>

                <ul class="bo_v_com_left">
                    <li><a href="<?php echo $list_href ?>" class="btn_b03 btn">목록</a></li>
                </ul>

                <ul class="bo_v_com_right">
                    <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b02 btn">수정</a></li><?php } ?>
                    <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b02 btn" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
                    <?php $write_href=false;if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn">글쓰기</a></li><?php } ?>
                    <?php if ($member['ampmkey'] == 'Y') { ?><li><a href="#" class="btn_view btn"><?=codeToName($code_hide, $view['wr_19'])?></a><?php } ?>
                </ul>
                <?php
                    $link_buttons = ob_get_contents();
                    ob_end_flush();
                ?>
            </div>
            <!-- } 게시물 상단 버튼 끝 -->
        </section>
    
    
    </article>
    <!-- } 게시판 읽기 끝 -->
</section>

<script>
    <?php if ($board['bo_download_point'] < 0) { ?>
    $(function() {
        $("a.view_file_download").click(function() {
            if(!g5_is_member) {
                alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
                return false;
            }

            var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

            if(confirm(msg)) {
                var href = $(this).attr("href")+"&js=on";
                $(this).attr("href", href);

                return true;
            } else {
                return false;
            }
        });
    });
    <?php } ?>

    function board_move(href)
    {
        window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
    }
    </script>

    <script>
    $(function() {
        $("a.view_image").click(function() {
            window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
            return false;
        });

        // 추천, 비추천
        $("#good_button, #nogood_button").click(function() {
            var $tx;
            if(this.id == "good_button")
                $tx = $("#bo_v_act_good");
            else
                $tx = $("#bo_v_act_nogood");

            excute_good(this.href, $(this), $tx);
            return false;
        });

        // 이미지 리사이즈
        //$("#bo_v_atc").viewimageresize();
    });

    function excute_good(href, $el, $tx)
    {
        $.post(
            href,
            { js: "on" },
            function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                if(data.count) {
                    $el.find("strong").text(number_format(String(data.count)));
                    if($tx.attr("id").search("nogood") > -1) {
                        $tx.text("이 글을 비추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    } else {
                        $tx.text("이 글을 추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    }
                }
            }, "json"
        );
    }
</script>
<!-- } 게시글 읽기 끝 -->

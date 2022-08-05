<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->


<article id="bo_v">
    <header>
        <h1 id="bo_v_title"><p align="center"><font color="#0b009d">[
            <?php

            echo cut_str(get_text($view['wr_subject']), 170); // 글제목 출력
            ?>
        ]</font></p></h1>
    </header>



    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if ($view['link']) {
    ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($yfile[$k]['bf_link']) {
                $cnt++;
                $link = cut_str($yfile[$k]['bf_link'], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>


        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

		<div class="tbl_frm01 tbl_wrap">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>마테터썸네일</th>
					<td colspan="3">
					<?php
						if ($view['link'][1]) {
							if(preg_match("/youtu/", $view['link'][1])) {
								$videoId = get_youtubeid($view['link'][1]);
								$co_media = "<iframe width='$movie_width' height='$movie_height' src='//www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>";
							}
							else if(preg_match("/vimeo/", $view['link'][1])) {
								$videoId = get_vimeoid($view['link'][1]);
								$co_media = "<iframe src='//player.vimeo.com/video/$videoId' width='$movie_width' height='$movie_height' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
							}

							//echo $co_media;
						}
					?>
					<?php
					// 파일 출력
					$v_img_count = count($view['file']);
					if($v_img_count) {
						echo "<div id=\"bo_v_img\">\n";
						
						if ($view['file'][1]['view']) {
							//echo $view['file'][$i]['view'];
							echo get_view_thumbnail($view['file'][1]['view'],350);
						}

						echo "</div>\n";
					}
					?>
					</td>
				</tr>
				<!--
				<tr>
					<th>QR 링크</th>
					<td colspan="3"><?=$link_url?>/sub/sub3-1-view.php?wr_id=<?=$view['wr_id']?>#mav</td>
				</tr>
				-->
				<tr>
					<th class="t_tit1">부서명</th>
					<td><?=$view['wr_8']?> > <?=$view['wr_9']?></td>
				</tr>
				<tr>
					<th>사원명</th>
					<td><?=$view['wr_subject']?>(<?=$view['wr_1']?>)</td>
				</tr>
				<tr>
					<th>퇴사여부</th>
					<td><?=codeToName($code_leaveYn,$view['wr_2'])?></td>
				</tr>
				<tr>
					<th>취득자격증</th>
					<td><?=$view['wr_3'] ?></td>
				</tr>
				<tr>
					<th>연락처</th>
					<td><?=$view['wr_5']?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td><?=$view['wr_6']?></td>
				</tr>
				<tr>
					<th>카카오아이디</th>
					<td><?=$view['wr_7']?></td>
				</tr>
				<tr>
					<th>광고주에게 한마디</th>
					<td><?=$view['wr_11']?></td>
				</tr>
				<tr>
					<th>자신의 대표 타이틀</th>
					<td><?=$view['wr_12']?></td>
				</tr>
				<tr>
					<th>자신있는, 하고싶은 광고 직종</th>
					<td><?=$view['wr_13']?></td>
				</tr>
				<tr>
					<th>할 수 있는 광고 종류</th>
					<td><?=$view['wr_14']?></td>
				</tr>
				<tr>
					<th>집행해본 업체 3곳</th>
					<td><?=$view['wr_15']?></td>
				</tr>
				<tr>
					<th>마케터소개</th>
					<td><?=conv_content($view['wr_content'], 2); ?></td>
				</tr>
				<?php
					$g5['file_table'] = G5_TABLE_PREFIX.$bo_table.'_file'; // 게시판 첨부파일 테이블
					$sql = " select count(*) as cnt from {$g5['file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
					$row = sql_fetch($sql);
					$total_count = $row['cnt'];

					if ($total_count > 0) {
				?>
				<tr>
					<th>강의영상</th>
					<td colspan="3">
						<!-- 동영상이 있다면 동영상 추출하여 화면 띄우기 -->
					<?php
						$sql = " SELECT *
								 FROM g5_marketer_file c
								 WHERE 1
								 AND bo_table = '$bo_table' 
								 AND wr_id = '$wr_id'
								 ORDER BY bf_no
						";
						$result = sql_query($sql);
						for ($k=0; $row=sql_fetch_array($result); $k++) {
							$no = $row['bf_no'];
							$file_href = G5_URL."/inc/file_download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
							$file_link = $row['bf_link'];
							$file_source = addslashes($row['bf_source']);

							if(preg_match("/youtu/", $file_link)) {
								$videoId = get_youtubeid($file_link);
								$co_media = "<iframe width='$thumb_width' height='$thumb_height' src='//www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>";
							} else if(preg_match("/vimeo/", $file_link)) {
								$videoId = get_vimeoid($file_link);
								$co_media = "<iframe src='//player.vimeo.com/video/$videoId' width='$thumb_width' height='$thumb_height' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
							}

							echo $co_media."<a href='".$file_href."'>".$file_source."</a> ";
						}
					?>
					</td>
				</tr>
				<?php 
					} 
				?>
			</table>
		</div>


        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php //echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <!-- 스크랩 추천 비추천 시작 { -->
        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn_b01" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act">
            <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- } 스크랩 추천 비추천 끝 -->
    </section>

    <?php
    include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?>



    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

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
    $("#bo_v_atc").viewimageresize();
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
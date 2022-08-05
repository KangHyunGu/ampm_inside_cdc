<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');

$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$link_url = 'http://' . $http_host;
?>

<link rel="stylesheet" href="<?=$board_skin_url?>/style.css">


<div id="bo_v_table"><?php echo $board['bo_subject']; ?></div>

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title">
            <?php
            if ($category_name) echo ($category_name ? $view['ca_name'].' | ' : ''); // 분류 출력 끝
            //echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        작성자 <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="sound_only">작성일</span><strong><?php echo date("Y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
        조회<strong><?php echo number_format($view['wr_hit']) ?>회</strong>
        <!--댓글<strong><?php echo number_format($view['wr_comment']) ?>건</strong-->
    </section>

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
                    <?php echo $view['file'][$i]['bf_content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
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
    <?php } ?>

    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php $copy_href=false;if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
            <?php $move_href=false;if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
            <?php $reply_href=false;if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
        ?>

		<div class="tbl_frm01 tbl_wrap">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th>마테터소개 영상</th>
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

							echo $co_media;
						}
					?>
					</td>
				</tr>
				<tr>
					<th>QR 링크</th>
					<td colspan="3"><?=$link_url?>/sub/sub3-1-view.php?wr_id=<?=$view['wr_id']?>#mav</td>
				</tr>
				<tr>
					<th class="t_tit1">부서명</th>
					<td><?=$view['wr_8']?> > <?=$view['wr_9']?></td>
					<th>사원명</th>
					<td><?=$view['wr_subject']?>(사원ID : <?=$view['wr_1']?>)</td>
				</tr>
				<tr>
					<th>자격증</th>
					<td colspan="3"><?=$view['wr_3'] ?></td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$view['wr_5']?></td>
					<th>이메일</th>
					<td><?=$view['wr_6']?></td>
				</tr>
				<tr>
					<th>카카오아이디</th>
					<td><?=$view['wr_7']?></td>
					<th>퇴사여부</th>
					<td><?=codeToName($code_leaveYn,$view['wr_2'])?></td>
				</tr>
				<tr>
					<th>마케터소개</th>
					<td colspan="3"><?=conv_content($view['wr_content'], 2); ?></td>
				</tr>
				<?php
				if (implode('', $view['link'])) {
				?>
				<tr>
					<th>강의링크</th>
					<td colspan="3">
						<!-- 동영상이 있다면 동영상 추출하여 화면 띄우기 -->
						<?php
						// 링크
						$cnt = 0;
						$videoId = "";
						$co_media = "";
						for ($i=2; $i<=count($view['link']); $i++) {
							if ($view['link'][$i]) {
								$cnt++;
								$link = cut_str($view['link'][$i], 70);
   
								if(preg_match("/youtu/", $view['link'][$i])) {
									$videoId = get_youtubeid($view['link'][$i]);
									$co_media = "<iframe width='$thumb_width' height='$thumb_height' src='//www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>";
								}
								else if(preg_match("/vimeo/", $view['link'][$i])) {
									$videoId = get_vimeoid($view['link'][$i]);
									$co_media = "<iframe src='//player.vimeo.com/video/$videoId' width='$thumb_width' height='$thumb_height' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
								}

								echo $co_media;
								echo "  ";
								//echo "<br />";
							}

							$videoId = "";
						}
						?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>


        <div id="bo_v_con"><?php //echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ($scrap_href || $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn_b01" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn_b01">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
            <b id="bo_v_act_good"></b>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn_b01">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
            <b id="bo_v_act_nogood"></b>
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
    </section>

    <?php 
    include(G5_SNS_PATH."/view.sns.skin.php"); 
    ?>

    <?php
    // 코멘트 입출력
    //include_once('./view_comment.php');
    ?>

    <div id="bo_v_bot">
        <!-- 링크 버튼 -->
        <?php echo $link_buttons ?>
    </div>

</article>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
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

<!-- 게시글 보기 끝 -->

<script>
// 이미지 등비율 리사이징
$(window).load(function() {
    view_image_resize();
});

var now = new Date();
var timeout = false;
var millisec = 200;
var tid;

$(window).resize(function() {
    now = new Date();
    if (timeout === false) {
        timeout = true;

        if(tid != null)
            clearTimeout(tid);

        tid = setTimeout(resize_check, millisec);
    }
});

function resize_check() {
    if (new Date() - now < millisec) {
        if(tid != null)
            clearTimeout(tid);

        tid = setTimeout(resize_check, millisec);
    } else {
        timeout = false;
        view_image_resize();
    }
}

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
});

function view_image_resize()
{
    var $img = $("#bo_v_atc img");
    var img_wrap = $("#bo_v_atc").width();
    var win_width = $(window).width() - 35;
    var res_width = 0;

    if(img_wrap < win_width)
        res_width = img_wrap;
    else
        res_width = win_width;

    $img.each(function() {
        var img_width = $(this).width();
        var img_height = $(this).height();
        var this_width = $(this).data("width");
        var this_height = $(this).data("height");

        if(this_width == undefined) {
            $(this).data("width", img_width); // 원래 이미지 사이즈
            $(this).data("height", img_height);
            this_width = img_width;
            this_height = img_height;
        }

        if(this_width > res_width) {
            $(this).width(res_width);
            var res_height = Math.round(res_width * $(this).data("height") / $(this).data("width"));
            $(this).height(res_height);
        } else {
            $(this).width(this_width);
            $(this).height(this_height);
        }
    });
}

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
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                }
            }
        }, "json"
    );
}
</script>
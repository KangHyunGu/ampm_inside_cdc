<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

// 필요한 LIB 불러오기
include_once($board_skin_path.'/gaburi.lib.php');
?>
<link rel="stylesheet" href="<?=$board_skin_url?>/style.css">

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<h2 id="container_title"><?php echo $board['bo_subject'] ?></h2>

<div id="view_notice">
   <ul>
      <li>
         ※ 인사이트에 작성된 게시글입니다. 실제 내용은 사용자 화면을 통해 확인하세요.
      </li>
   </ul>
</div>
<!-- 게시물 읽기 시작 { -->
   <article id="bo_v" style="width:<?php echo $width; ?>">
			<div class="bo_title_wrap">
				<div class="bo_v_title">
					<h1>
						<?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?>
					</h1>
				</div>
				<h3>
					<?php if ($category_name) echo $view['ca_name']; // 분류 출력 끝 ?>
				</h3>

				<section id="bo_v_info">
					<strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
					<strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
					<strong>조회수 <?php echo number_format($view['wr_hit']) ?></strong>
					<strong>댓글 <?php echo number_format($view['wr_comment']) ?>건</strong>
				</section>

				<div class="inner">
					<!-- media아이콘 -->
					<div class="media">
						<ul>
							<!-- instagram -->
							<li>
								<a href="#" target="blank">
									<img src="<?=G5_URL ?>/images/instagram_on.png" alt="">
								</a>
							</li>
							<!-- naver -->
							<li>
								<a href="#" target="blank">
									<img src="<?=G5_URL ?>/images/blog_on.png" alt="">
								</a>
							</li>
							<!-- youtube -->
							<li>
								<a href="#" target="blank">
									<img src="<?=G5_URL ?>/images/youtube_on.png" alt="">
								</a>
							</li>
						</ul>
					</div>
					<!-- 공유하기 -->
					<div class="share">
						<span class="link_copy">
							<a href="#" onclick="clip(); return false;">
								<i class="fas fa-external-link-alt"></i> 공유하기
							</a>
						</span>
					</div>
				</div>
			</div>
			<script type="text/javascript">
            function clip(){
               var url = '';
               var textarea = document.createElement("textarea");
               document.body.appendChild(textarea);
               url = window.document.location.href;
               textarea.value = url;
               textarea.select();
               document.execCommand("copy");
               document.body.removeChild(textarea);
               alert("http://<?php echo $_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];?> \n주소가 복사되었습니다.")
            }
			</script>

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
                  <i class="fas fa-link"></i> 관련 링크 : <?php echo $view['wr_5'] ?>
               </a>
               <!--<span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>-->
            <?php
				}
            }
            ?>
         </section>
         <!-- } 관련링크 끝 -->
         <?php } ?>


         <section id="bo_v_atc">
            <h2 id="bo_v_atc_title">본문</h2>
               
            <div id="bo_v_video">
               <!-- 동영상이 있다면 동영상 추출하여 화면 띄우기 -->
               <?
                  if($view[wr_5]) {
                     if(preg_match("/youtu/", $view[wr_5])) {
                        $videoId = get_youtubeid($view[wr_5]);
                        $co_media = "<iframe width='$movie_width' height='$movie_height' src='//www.youtube.com/embed/$videoId' frameborder='0' allowfullscreen></iframe>";
                     }
                     else if(preg_match("/vimeo/", $view[wr_5])) {
                        $videoId = get_vimeoid($view[wr_5]);
                        $co_media = "<iframe src='//player.vimeo.com/video/$videoId' width='$movie_width' height='$movie_height' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
                     }

                     echo $co_media;
                     echo "<br />";
                  }
               ?>
            </div>

            <!-- 본문 내용 시작 { -->
            <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>

            
            <!-- 본문 밑 마케터 네임카드 출력 -->
			<?php include(G5_PATH.'/inc/_inc_namecard.php'); ?>       


            <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
            <!-- } 본문 내용 끝 -->

            <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>
               
            <?php
				   if ($view['file']['count']) {
					  $cnt = 0;
					  for ($i=0; $i<count($view['file']); $i++) {
							if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'])
							   $cnt++;
					  }
				   }
				?>

	
            <?php if ($view['file']['count']) { ?>
				<!-- 첨부파일 시작 { -->
				<section id="bo_v_file">
               <h3>첨부파일</h3>
					<ul>
                  <?php
                     // 가변 파일
                     for ($i=0; $i<count($view['file']); $i++) {
                     if (isset($view['file'][$i]['source']) && $view['file'][$i]['source']) {
                  ?>
						<li>
							<a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                        ·		<?php echo $view['file'][$i]['source'] ?>
								<?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
							</a>
							<!--
							<span class="bo_v_file_cnt ">다운로드 : <?php echo $view['file'][$i]['download'] ?>회 &nbsp;&nbsp;</span>
							<span class="">DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
							-->				
						</li>
                  <?php
                     }
                     }
                  ?>
					</ul>
				</section>
				<!-- } 첨부파일 끝 -->
            <?php
               }
            ?>


            <!-- 게시물 상단 버튼 시작 { -->
            <div id="bo_v_top">
               <?php ob_start(); ?>

               <?php if ($prev_href || $next_href) { ?>
               <ul class="bo_v_nb">
					<?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b03 btn">이전글</a></li><?php } ?>
					<?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b03 btn">다음글</a></li><?php } ?>
               </ul>
               <?php } ?>
         
				<ul class="bo_v_com">
					<?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b02 btn">수정</a></li><?php } ?>
					<?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b02 btn" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
					<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01 btn">글쓰기</a></li><?php } ?>
					<li><a href="<?php echo $list_href ?>" class="btn_b03 btn">목록</a></li>
					<?php if ($member['ampmkey'] == 'Y') { ?><li class="btn_view btn"><?=codeToName($code_hide, $view['wr_19'])?><?php } ?>
				</ul>
               <?php
                  $link_buttons = ob_get_contents();
                  ob_end_flush();
               ?>
            </div>
            <!-- } 게시물 상단 버튼 끝 -->
         </section>

         <?php
         //include_once(G5_SNS_PATH."/view.sns.skin.php");
         ?>

         <?php
         // 코멘트 입출력
         include_once(G5_BBS_PATH.'/view_comment.php');
         ?>
     
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
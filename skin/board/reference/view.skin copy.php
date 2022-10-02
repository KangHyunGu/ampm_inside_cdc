<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 2);
?>

<?php
include(G5_PATH.'/inc/top.php');
?>

<div id="container" class="sub">
	<!-- 좌측 컨텐츠 영역 -->
	<section class="section_left">
		<!-- 비주얼 배너 -->
		<div class="visual_banner">
			<img src="<?=G5_URL ?>/images/sub_banner3.jpg" alt="마케터 레퍼런스 배너">
		</div>

		<!-- 게시물 읽기 시작 { -->
		<article id="bo_v" style="width:<?php echo $width; ?>">

			<!-- 본문 내용 시작 { -->
			<table id="bo_v_table">
				<tbody>
					<tr>
						<th>카테고리</th>
						<td class="brand_name">
							<?php if ($category_name) echo $view['ca_name']; // 분류 출력 끝 ?>     
							<div class="inner">
								<!-- media아이콘 -->
                        <div class="media">
                           <ul>
                              <!-- blog -->
                              <li class="blog on"> <!-- 업로드 된 매체는 'on' class추가 -->
                                 <a href="#" target="blank">
                                 </a>
                              </li>
                              <!-- instagram -->
                              <li class="instagram">
                                 <a href="#" target="blank">
                                 </a>
                              </li>
                              <!-- youtube -->
                              <li class="youtube">
                                 <a href="#" target="blank">
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
							</div>
						</td>
					</tr>
					<tr>
						<th>브랜드명</th>
						<td>
							<?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?>
						</td>
					</tr>
					<tr>
						<th>업종</th>
						<td>
							<?php echo $view['wr_8']; ?>
						</td>
					</tr>
					<!--
					<tr>
						<th>업체이미지</th>
						<td>
							<?php
							// 파일 출력
							$v_img_count = count($view['file']);
							if($v_img_count) {
								echo "<div id=\"bo_v_img\">\n";

								for ($i=0; $i<=count($view['file']); $i++) {
									if ($view['file'][$i]['view']) {
										//echo $view['file'][$i]['view'];
										echo get_view_thumbnail($view['file'][$i]['view'], 300);
									}
								}

								echo "</div>\n";
							}
							?>
						
						</td>
					</tr>
					-->
					<tr>
						<th>마케팅KPI</th>
						<td><?=$view['wr_1']?></td>
					</tr>
					<tr>
						<th>집행매체</th>
						<td><?=$view['wr_2']?></td>
					</tr>
					<tr>
						<th>집행성과</th>
						<td><?=$view['wr_3']?></td>
					</tr>
					<tr>
						<th>홈페이지</th>
						<td><?=$view['wr_4']?></td>
					</tr>

					<tr>
						<th>집행내용</th>
						<td><div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div></td>
					</tr>
				</tbody>
			</table>
			<!-- } 본문 내용 끝 -->

			<!-- 본문 밑 마케터 네임카드 출력 -->
			<?php include(G5_PATH.'/inc/_inc_namecard.php'); ?>       


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


         <?php
         //include_once(G5_SNS_PATH."/view.sns.skin.php");
         ?>

         <?php
         // 코멘트 입출력
         include_once('./view_comment.php');
         ?>

      </article>
      <!-- } 게시판 읽기 끝 -->


   </section>

	<!-- 우측 side 영역 -->
	<?php include(G5_PATH.'/inc/aside.php'); ?>
</div>

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

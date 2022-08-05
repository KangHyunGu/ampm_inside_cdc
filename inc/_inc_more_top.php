<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

///////////////////////////////////////////////////////////////////////
// 마케터정보 가져오기
///////////////////////////////////////////////////////////////////////
$mk = get_memberLoginInfo($mk_id); 
if($mk['mb_id']){
	$mb_images	= $mk['mb_images'];
	$nick		= $mk['nick'];
	$team		= $mk['mb_team_text'];
	$mb_slogan  = $mk['mb_slogan'];
}

//마케터가 즐겨찾기에 포함되었는가?
$cn_favo = get_favoMarketer($member['mb_id'], $mk_id);

/////////////////////////////////////////////////////////////////////////
//경로 설정 비로그인의 경우 로그인창으로 연결
/////////////////////////////////////////////////////////////////////////
$go_reqeust_edit = ($is_member)?G5_BBS_URL.'/write.php?bo_table=request&mk_id='.$mk_id:G5_BBS_URL.'/login.php?url='.$uri;
$go_content		 = ($is_member)?G5_BBS_URL.'/mypage.php?go_table=more&view=w&mk_id='.$mk_id:G5_BBS_URL.'/login.php?url='.$uri;
$go_qna_edit	 = ($is_member)?G5_BBS_URL.'/write.php?bo_table=qna&mk_id='.$mk_id:G5_BBS_URL.'/login.php?url='.$uri;
$go_marketer	 = G5_URL.'/ae-'.$mk_id.'/member/';
?>
		<!-- 컨텐츠더보기 네임카드 -->
        <div class="content_nc">
            <h3><?php echo $nick ?> 님의 컨텐츠 목록입니다.</h3>
            <ul>
                <li>
                    <div class="nc_img">
                        <?php echo $mb_images; ?>
                    </div>
                    <div class="title">
                        <h2><?php echo $mb_slogan ?></h2>
                        <h3><?php echo $nick ?></h3>
                    </div>
                </li>
                <li class="button">
                    <div><a href="<?=$go_reqeust_edit?>"><i class="fas fa-edit"></i> 대행의뢰</a></div>
                    <div><a href="<?=$go_qna_edit?>"><i class="fas fa-question-circle"></i> 질문하기</a></div>
                    <div><a href="<?=$go_marketer?>" target="_blank"><i class="fas fa-house-user"></i> 마케터 페이지</a></div>
					<!-- 일반회원만 즐겨찾기 기능 사용 -->
					<?php if($member['ampmkey'] != 'Y'){	?>
						<!-- 즐겨찾기 전 -->
                    <div><a href="#" class="bookmark"><i class="fas fa-star <?=($cn_favo['cnt'])?'bookmark_af':''?>"></i> 즐겨찾기</a></div>
                    <!-- 즐겨찾기 후 boookmark_af 클래스 추가 -->
 					<?php } ?>
               </li>
            </ul>
        </div>

		<script>
		//네임카드 즐겨찾기 선태 여부 처리
		$(document).ready(function(){
			$(document).on("click",".fa-star",function(){
				var marketer_id = "<?=$mk_id?>";
				var mb_id = "<?=$member['mb_id']?>";
				var mode = "";

				$(this).toggleClass('bookmark_af');
				
				if ($(this).hasClass("bookmark_af")) {	//즐겨찾기제거
					mode = 'sub';

					$.ajax({
						url: '/inc/_req_favo_marketer.php',
						type: 'post',
						data:{marketer_id:marketer_id, mb_id:mb_id, mode:mode},
						success: function(data){
							console.log(data);
							$(this).parent().removeClass('bookmark_af');
						}, 
						error: function(e) { 
							alert("값을 가져오지 못했습니다."); 
						} 
					});
				}else{									//즐겨찾기추가
					mode = 'add';

					$.ajax({
						url: '/inc/_req_favo_marketer.php',
						type: 'post',
						data:{marketer_id:marketer_id, mb_id:mb_id, mode:mode},
						success: function(data){
							console.log(data);
							$(this).parent().addClass('bookmark_af');
						}, 
						error: function(e) { 
							alert("값을 가져오지 못했습니다."); 
						} 
					});
				}

			});
		});
		</script>

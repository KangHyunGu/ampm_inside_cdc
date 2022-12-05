<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
@include_once(G5_LIB_PATH.'/thumbnail.lib.php');
///////////////////////////////////////////////////////////////////////
// AMPM 사원인 경우 팀 정보 노출
// view 스킨용
///////////////////////////////////////////////////////////////////////
$mk = get_viewNamecardInfo($bo_table, $comment_id);
$mk_id = $mk['mb_id'];
$nick = $mk['nick'];
$mb_images = $mk['mb_images'];
$mb_team_text = $mk['mb_team_text'];
$mb_slogan = $mk['mb_slogan'];

$mb_tel = $mk['mb_tel'];
$mb_email = $mk['mb_email'];

//마케터가 즐겨찾기에 포함되었는가?
$cm_favo = get_favoMarketer($member['mb_id'], $mk_id);


/////////////////////////////////////////////////////////////////////////
//경로 설정 비로그인의 경우 로그인창으로 연결
/////////////////////////////////////////////////////////////////////////
$go_reqeust_edit = ($is_member)?G5_BBS_URL.'/write.php?bo_table=request&mk_id='.$mk_id:G5_BBS_URL.'/login.php?url='.$uri;
//$go_content			= ($is_member)?G5_BBS_URL.'/mypage.php?go_table=more&view=w&mk_id='.$mk_id:G5_BBS_URL.'/login.php?url='.$uri;
$go_content			= G5_BBS_URL.'/mypage.php?go_table=more&view=w&mk_id='.$mk_id;
$go_qna_edit	 = G5_BBS_URL.'/write.php?bo_table=qna&mk_id='.$mk_id;
$go_marketer	 = ($is_member)?G5_URL.'/ae-'.$mk_id.'/member/':G5_BBS_URL.'/login.php?url='.$uri;
$go_marketer	 = G5_URL.'/ae-'.$mk_id.'/';
?>
<?php
	//공통게시물에는 네임카드 노출하지 않는다.
	if($mk_id != 'ampm'){
?>

    <?php
    if (G5_IS_MOBILE) {	//모바일인 경우
    ?>

    <!-- 마케터 프로필 네임카드 -->
    <div id="namecard" class="card">
        <div class="nc_box">
            <div class="nc_inner">
                <div class="nc_img">
                    <?php echo $mb_images; ?>
                </div>
                <div class="nc_info">
                    <!-- 마케터 문구 -->
                    <div class="nc_comm"><?php echo get_text($mb_slogan); ?></div>
                    <!-- 마케터 이름 -->
                    <h3><?php echo get_text($nick); ?></h3>
                    <!-- 마케터 전화번호 / 이메일 -->
                    <h6><b>Contact.</b> <span><!--전화번호--><?=$mb_tel?></span> <span class="mail"><!--이메일--><?=$mb_email?></span></h6>
                </div>

            </div>
            <div class="nc_btn">
                    <ul>
                        <a href="<?=$go_reqeust_edit?>"><li><i class="fas fa-edit"></i> 대행의뢰</li></a>
                        <a href="<?=$go_content?>"><li><i class="fas fa-ad"></i> 컨텐츠 더보기</li></a>
                        <a href="<?=$go_qna_edit?>"><li><i class="fas fa-question-circle"></i> 질문하기</li></a>
                        <a href="<?=$go_marketer?>" target="_blank"><li><i class="fas fa-house-user"></i> 마케터 페이지</li></a>
                    </ul>
                </div>

                <p>Written By. <?php echo get_text($nick); ?></p>

        </div>
        <!-- 일반회원만 즐겨찾기 기능 사용 -->
        <?php if($member['ampmkey'] != 'Y'){	?>
        <div class="bookmark">
            <!-- 즐겨찾기 전 -->
            <button class="bm-btn"><i class="fas fa-star <?=($favo['cnt'])?'bookmark_af':''?>"></i></button>
            <!-- 즐겨찾기 후 boookmark_af 클래스 추가 -->
        </div>
        <?php } ?>
    </div>


    <?php
    }else{	//PC인 경우
    ?>


    <!-- 마케터 프로필 네임카드 -->
    <div id="namecard" class="card">
        <div class="nc_box">
            <div class="nc_img">
                <?php echo $mb_images; ?>
            </div>
            <div class="nc_info">
                <!-- 마케터 문구 -->
                <div class="nc_comm"><?php echo get_text($mb_slogan); ?></div>
                <!-- 마케터 이름 -->
                <h3><?php echo get_text($nick); ?></h3>
                <!-- 마케터 전화번호 / 이메일 -->
                <h5><b>Contact.</b> <span><!--전화번호--><?=$mb_tel?></span> <span class="mail"><!--이메일--><?=$mb_email?></span></h5>


                <div class="nc_btn">
                    <ul>
                        <a href="<?=$go_reqeust_edit?>"><li><i class="fas fa-edit"></i> 대행의뢰</li></a>
                        <a href="<?=$go_content?>"><li><i class="fas fa-ad"></i> 컨텐츠 더보기</li></a>
                        <a href="<?=$go_qna_edit?>"><li><i class="fas fa-question-circle"></i> 질문하기</li></a>
                        <a href="<?=$go_marketer?>" target="_blank"><li><i class="fas fa-house-user"></i> 마케터 페이지</li></a>
                    </ul>
                </div>

                <p>Written By. <?php echo get_text($nick); ?></p>
            </div>
        </div>
        <!-- 일반회원만 즐겨찾기 기능 사용 -->
        <?php if($member['ampmkey'] != 'Y'){	?>
        <div class="bookmark">
            <!-- 즐겨찾기 전 -->
            <button class="bm-btn"><i class="fas fa-star <?=($favo['cnt'])?'bookmark_af':''?>"></i></button>
            <!-- 즐겨찾기 후 boookmark_af 클래스 추가 -->
        </div>
        <?php } ?>
    </div>

    <?php
    }
    ?>


<?php
	}
?>

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
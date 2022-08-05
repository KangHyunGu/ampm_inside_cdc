<?php
include_once('./_common.php');

$g5['title'] = '로그인 인증';
include_once(G5_PATH.'/head.sub.php');

print_r($_POST);
exit;
?>

<div id="copymove" class="new_win">

    <form name="fboardmoveall" method="post" action="./sms_estimate_update.php" onsubmit="return fboardmoveall_submit(this);">
    <input type="hidden" name="sw" value="<?php echo $sw ?>">
    <input type="hidden" name="smsGroupList" value="<?php echo $smsGroupList ?>">

	<div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <th scope="col">
                <label for="chkall" class="sound_only">현재 페이지 게시판 전체</label>
				딜러그룹
                <!--input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"-->
            </th>
            <th scope="col">내용</th>
        </tr>
        </thead>
        <tbody>
        <?php 
			for ($i=0; $i<count($smsGroupList); $i++) {

		?>
        <tr class="<?php echo $atc_bg; ?>">
            <td class="td_chk">
                <label for="chk<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['bo_table'] ?></label>
                <!--input type="checkbox" value="<?php echo $list[$i]['bo_table'] ?>" id="chk<?php echo $i ?>" name="chk_bo_table[]"-->
				<?php echo $smsGroupList[$i]['groupname']; ?> 
            </td>
            <td>
                <label for="chk<?php echo $i ?>">
                    <?php
                    echo "상담구분 - {$smsGroupList[$i][wr_1]}, 제조사 - {$smsGroupList[$i][wr_2]}, 모델 - {$smsGroupList[$i][wr_3]}, 변속기 - {$smsGroupList[$i][wr_4]}, 
		                  연식 - {$smsGroupList[$i][wr_6]}, 연료 - {$smsGroupList[$i][wr_7]},  지역 - {$smsGroupList[$i][wr_8]}, 전화번호 - {$smsGroupList[$i][wr_5]}, 차량번호 - {$smsGroupList[$i][wr_carnumber]}<br>";
                    ?>
                    딜러명 : <?php echo $smsGroupList[$i]['dealername'] ?> (<?php echo $smsGroupList[$i]['dealerphone'] ?>)
                </label>
            </td>
        </tr>
        <?php 
				$list[$i] = str_replace('-', '', trim($smsGroupList[$i]['dealerphone']));

				//$message = "상담요청이 그룹 {$smsGroupList[$i]['groupname']} - {$smsGroupList[$i]['groupname']}에 배당 되었습니다.  상담구분 - {$smsGroupList[$i][wr_1]}, 제조사 - {$smsGroupList[$i][wr_2]}, 모델 - {$smsGroupList[$i][wr_3]}, 변속기 - {$smsGroupList[$i][wr_4]}, 연식 - {$smsGroupList[$i][wr_6]}, 연료 - {$smsGroupList[$i][wr_7]},  지역 - {$smsGroupList[$i][wr_8]}, 전화번호 - {$smsGroupList[$i][wr_5]}";
				$message = "상담요청이 배당 되었습니다.  상담구분 - {$smsGroupList[$i][wr_1]}, 제조사 - {$smsGroupList[$i][wr_2]}, 모델 - {$smsGroupList[$i][wr_3]}, 변속기 - {$smsGroupList[$i][wr_4]}, 연식 - {$smsGroupList[$i][wr_6]}, 연료 - {$smsGroupList[$i][wr_7]},  지역 - {$smsGroupList[$i][wr_8]}, 전화번호 - {$smsGroupList[$i][wr_5]}, 차량번호 - {$smsGroupList[$i][wr_carnumber]}";
			} 
		?>
        </tbody>
        </table>
    </div>
	
    <div class="win_btn">
        <!--input type="submit" value="<?php echo $act ?>" id="btn_submit" class="btn_submit"-->
    </div>
    </form>

</div>

<script>
$(function() {
    $(".win_btn").append("<button type=\"button\" class=\"btn_cancel\">창닫기</button>");

    $(".win_btn button").click(function() {
        window.close();
    });
});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>

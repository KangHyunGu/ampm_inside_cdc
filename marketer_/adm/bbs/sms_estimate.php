<?php
include_once('./_common.php');

if ($sw == 'sms')
    $act = '문자발송';
else
    alert('sw 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = '게시물 ' . $act;
include_once(G5_PATH.'/head.sub.php');

//echo $wr_id;
if(!$bo_table) $bo_table = "estimate";
$write_table  = $g5['write_prefix'] . $bo_table;
$dealer_table = $g5['write_prefix'] . "dealer";

// 해당게시물의 지정 그굽에 해당하는 딜러 정보 추출.
$sql = " select a.*, b.mb_1 as groupname, b.mb_id as dealerid, b.mb_name as dealername, b.mb_hp as dealerphone from {$write_table} a inner join {$g5['member_table']} b ON a.wr_9 = b.mb_1 ";
$sql.= " where 1 and b.mb_level = '8' and a.wr_id = '{$wr_id}' ";
$sql.= " order by a.wr_id, b.mb_id ";
//echo $sql; exit;
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $smsGroupList[$i] = $row;
}

if(count($smsGroupList) < 1)
    alert_close('문자발송 대상 리스트가 없습니다.');


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
	
<?
/////////////////////////////////////////////////////////////////////////
//해당 문자를 받은 인원에게
//해당 게시물 정보를 리스트 한다. 
/////////////////////////////////////////////////////////////////////////
//게시물정보
$sms_write = get_write($write_table, $wr_id);
$sms_wr_subject		= $sms_write['wr_subject'];
$sms_wr_content		= $sms_write['wr_content'];
$sms_mb_id			= $sms_write['mb_id'];
$sms_wr_password	= $sms_write['wr_password'];
$sms_wr_name		= $sms_write['wr_name'];
$sms_wr_datetime	= $sms_write['wr_datetime'];
$sms_wr_ip			= $sms_write['wr_ip'];

$sms_wr_carnumber	= $sms_write['wr_carnumber'];

$sms_wr_1			= $sms_write['wr_1'];
$sms_wr_2			= $sms_write['wr_2'];
$sms_wr_3			= $sms_write['wr_3'];
$sms_wr_4			= $sms_write['wr_4'];
$sms_wr_5			= $sms_write['wr_5'];
$sms_wr_6			= $sms_write['wr_6'];
$sms_wr_7			= $sms_write['wr_7'];
$sms_wr_8			= $sms_write['wr_8'];
$sms_wr_9			= $sms_write['wr_9'];
$sms_wr_10			= $sms_write['wr_10'];

for ($i=0; $i<count($smsGroupList); $i++) {
	$sms_wr_num = get_next_num($dealer_table);
	$dealerid = $smsGroupList[$i]['dealerid'];
	//딜러테이들 등록

	$dealer_exists = get_write_dealer($dealer_table, $wr_id, $bo_table, $dealerid);
	
	if($dealer_exists){
		continue;
	}else{

		$sql = " insert into {$dealer_table}
					set wr_num = '$sms_wr_num',
						 wr_reply = '$sms_wr_reply',
						 wr_comment = 0,
						 ca_name = '$sms_ca_name',
						 wr_option = '$sms_html,$sms_secret,$sms_mail',
						 wr_subject = '$sms_wr_subject',
						 wr_content = '$sms_wr_content',
						 wr_link1 = '$sms_wr_link1',
						 wr_link2 = '$sms_wr_link2',
						 wr_link1_hit = 0,
						 wr_link2_hit = 0,
						 wr_hit = 0,
						 wr_good = 0,
						 wr_nogood = 0,
						 mb_id = '{$sms_mb_id}',
						 wr_password = '$sms_wr_password',
						 wr_name = '$sms_wr_name',
						 wr_email = '$sms_wr_email',
						 wr_homepage = '$sms_wr_homepage',
						 wr_datetime = '$sms_wr_datetime',
						 wr_last = '".G5_TIME_YMDHIS."',
						 wr_ip = '$sms_wr_ip',
						 wr_carnumber = '$sms_wr_carnumber',
						 wr_1 = '$sms_wr_1',
						 wr_2 = '$sms_wr_2',
						 wr_3 = '$sms_wr_3',
						 wr_4 = '$sms_wr_4',
						 wr_5 = '$sms_wr_5',
						 wr_6 = '$sms_wr_6',
						 wr_7 = '$sms_wr_7',
						 wr_8 = '$sms_wr_8',
						 wr_9 = '$sms_wr_9',
						 wr_10 = '$sms_wr_10',
						 wr_11 = '$wr_id',
						 wr_12 = '$bo_table', 
						 wr_13 = '$dealerid' 
		";
		sql_query($sql);

		$sms_wr_id = mysql_insert_id();

		// 부모 아이디에 UPDATE
		sql_query(" update {$dealer_table} set wr_parent = '$sms_wr_id' where wr_id = '$sms_wr_id' ");

		// 게시글 1 증가
		sql_query("update g5_board set bo_count_write = bo_count_write + 1 where bo_table = 'dealer'");
	}
}
?>
<?
	//해당그룹 딜러에게 문자 발송
	include_once(G5_MMS_PATH.'/mms_admin_inc.php');
?>
    <div class="win_btn">
        <!--input type="submit" value="<?php echo $act ?>" id="btn_submit" class="btn_submit"-->
    </div>
    </form>

</div>

<script>
function fboardmoveall_submit(f)
{

    f.action = './sms_estimate_update.php';
    return true;
}

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

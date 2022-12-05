<?php
include_once('./_common.php');

if ($sw == 'memo')
    $act = '메모관리';
else
    alert('sw 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = '게시물 ' . $act;
include_once(G5_PATH.'/head.sub.php');

$host_name = (($host_key == 'car')?"카스토어":"셀카스토어");

$write_table = $g5['write_prefix'] . $bo_table;
$memo_table  = $g5['write_prefix'] . "memo";

//게시물정보
$sms_write = get_write($write_table, $deal_wr_id);
?>
<div id="copymove" class="new_win">

	<form name="frmOMemo" id="frmOMemo">
		<input type="hidden" name="sw"			value="<?php echo $sw ?>">
		<input type="hidden" name="proc_mode" 	id="proc_mode">
		<input type="hidden" name="re_wr_id" 	id="re_wr_id">
		<input type="hidden" name="deal_wr_id" 	value="<?=$deal_wr_id?>">
		<input type="hidden" name="bo_table" 	value="<?=$bo_table?>">
		<input type="hidden" name="page" 		value="<?php echo $page ?>">
		<input type="hidden" name="token" 		value="<?php echo $token ?>">
		<input type="hidden" name="url"			value="<?php echo $_SERVER['HTTP_REFERER'] ?>">

	<div class="tbl_head02 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_4">
		</colgroup>
        <thead>
		<tr>
			<th scope="col">게시물 내용</th>
		</tr>
        <tr>
            <td scope="col">
				<?php
				echo "[{$host_name}]<br> 
					  상담구분 - {$sms_write[wr_1]}<br> 
				      제조사 - {$sms_write[wr_2]}<br> 
					  모델 - {$sms_write[wr_3]}<br> 
					  변속기 - {$sms_write[wr_4]}<br> 
					  연식 - {$sms_write[wr_6]}<br> 
					  연료 - {$sms_write[wr_7]}<br>  
					  지역 - {$sms_write[wr_8]}<br> 
					  전화번호 - {$sms_write[wr_5]}<br>";
				?>
			</th>
        </tr>
        <tr>
            <th scope="col"><strong>메모 등록</strong></th>
        </tr>
       </thead>
		<tbody>
			<tr>
				<td><textarea name="comments" id="comments" cols="100" rows="6" placeholder="내용" style="ime-mode:auto;width:98%"></textarea></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div class="btn_confirm01 btn_confirm">
		<input type="button" value="메모등록" class="btn_submit" onclick="execMemo()">
	</div>
	
	</form>

	<div class="tbl_head02 tbl_wrap">
		<table>
		<colgroup>
			<col class="grid_4">
		</colgroup>
		<tbody>
			<tr>
				<th scope="col"><strong><?=$html_title?> 리스트</strong></th>
			</tr>
			<tr>
				<td>
					<?
						$sql = "SELECT a.* FROM {$memo_table} a  WHERE a.wr_1='{$deal_wr_id}' order by a.wr_num, a.wr_reply ";
						//echo $sql;
						$or_com = sql_query($sql);
					?>
					<table>
					<colgroup>
						<col>
						<col>
						<col>
					</colgroup>
					<thead>
						<tr>
							<th scope="col"><strong>작성일시</strong></th>
							<th scope="col"><strong>메세지 내용</strong></th>
							<th scope="col"><strong>관리</strong></th>
						</tr>
					</thead>
					<tbody>
					<?	$k=0;
						while($row=sql_fetch_array($or_com)) {				  
							
							$re_wr_id	= $row['wr_id'];
							$mess_id 	= get_text($row['mb_id']);
							$mess_name 	= get_text($row['wr_name']);
							$title 		= get_text($row['wr_subject']);
							$comments 	= get_text($row['wr_content']);
							$regdate 	= date("Y-m-d  H:i", strtotime($row['wr_datetime']));
							
							$font_color = "blue";
							$bg = 'bg0';
					?>
						<tr class="<?php echo $bg; ?>">
							<td><div style="color:<?=$font_color?>;"><?=$regdate?></div></td>
							<td><div style="width:250px;overflow:auto;"><?=str_replace("\r\n","<br>",$comments)?></div></td>
							<td><a href="javascript:goMemoDel('<?=$re_wr_id?>');"><img src="/dealer/adm/img/icon_delete.gif" border="0"></a></td>
						</tr>
						<tr><td class="td_mbcert" colspan="3"></td></tr>
					<? 		$k++;
						} 
						
						if ($k == 0)
							echo "<tr><td colspan='3' class='empty_table'>자료가 없습니다.</td></tr>";

					?>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		</table>
	</div>

	<div class="win_btn">
		<!--input type="submit" value="<?php echo $act ?>" id="btn_submit" class="btn_submit"-->
	</div>
</div>


<script>
//-------------------------------------------------------------------------------------------------------------------------------
//	memo_validate_Form()
//-------------------------------------------------------------------------------------------------------------------------------
function mess_validate_Form()
{
	var pattern_num		= /[0-9]/;

	if ( isValid_Empty($("#comments").val()) )	{
		alert("메세지 내용을 입력해 주십시오.");	$("#comments").focus();	return false;
	}

	return true;
}

//-------------------------------------------------------------------------------------------------------------------------------
//	memo 저장
//-------------------------------------------------------------------------------------------------------------------------------
function execMemo()
{

	if ( mess_validate_Form() )
	{
		$("#proc_mode").val("w");
		//$("#frmOMemo").attr("enctype", "multipart/form-data");
		$("#frmOMemo").attr("action", "estimate_memo_update.php");
		$("#frmOMemo").attr("method", "post");
		$("#frmOMemo").submit();
	}
}
//-------------------------------------------------------------------------------------------------------------------------------
//	memo 삭제
//-------------------------------------------------------------------------------------------------------------------------------
function goMemoDel(idx){
	if( confirm("삭제하시겠습니까?") )
	{
		$("#proc_mode").val("d");
		$("#re_wr_id").val(idx);

		$("#frmOMemo").attr("encoding", "multipart/form-data");
		$("#frmOMemo").attr("action", "estimate_memo_update.php");
		$("#frmOMemo").attr("method", "post");
		$("#frmOMemo").submit();
	}
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

<?php
include_once('./_common.php');

$sw = isset($_REQUEST['sw']) ? clean_xss_tags($_REQUEST['sw'], 1, 1) : '';

if ($sw === 'proc_marketer')
    $act = '담당자일괄변경';
else if ($sw === 'proc_state')
    $act = '처리일괄변경';
else
    alert('sw 값이 제대로 넘어오지 않았습니다.');

$g5['title'] = '게시물 ' . $act;
include_once(G5_PATH.'/head.sub.php');

$wr_id_list = '';
$comma = '';


$count_chk_bn_id = (isset($_POST['chk_bn_id']) && is_array($_POST['chk_bn_id'])) ? count($_POST['chk_bn_id']) : 0;

for($i=0;$i<$count_chk_bn_id;$i++)
{
    // 실제 번호를 넘김
    $k = isset($_POST['chk_bn_id'][$i]) ? (int) $_POST['chk_bn_id'][$i] : 0;
	//echo $_POST['wr_id'][$k]."<br>";
	$wr_id_val   = isset($_POST['wr_id'][$k]) ? preg_replace('/[^0-9]/i', '', $_POST['wr_id'][$k]) : 0;
	$wr_id_list .= $comma . $wr_id_val;
	$comma = ',';
}

/*
echo $count_chk_bn_id."<br>";
echo $wr_id_list;

exit;
*/
?>
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/jquery-ui-1.11.4/jquery-ui.css"></link>
<script src="<?php echo G5_JS_URL ?>/jquery-ui-1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	function successCall(){
		alert("전송성공");
	}

	function errorCall(){
		alert("전송실패");
	}

	//console.log(index);
	$("#wr_18").autocomplete({
		source:function(request, response) {
			$.ajax({
				url: "/inc/_ajax_intranet_memberList.php",
				type: 'post',
				dataType: "json",
				//data:dataString,
				data: 'searchword='+request.term,
				success: function( data ) {
					//alert(request.term);
					
					response(
						$.map(data, function(item) {
							return { 
								label: item.lavel_name,
								value: item.mb_name,

								mb_id: item.mb_id,
								mb_name: item.mb_name
							}
						})//map
					)//response
				},
				error   : errorCall
			});
		},
		minLength:1, /*최소 검색 글자수*/
		select: function( event, ui ) {
			// 만약 검색리스트에서 선택하였을때 선택한 데이터에 의한 이벤트발생
			
			//console.log(ui.item);
			dataList(ui.item);
			return false;
			//event.preventDefault();
		}
	});

	function dataList( item ) {
		m_id        = item.mb_id;
		m_name      = item.mb_name;

		//console.log(m_id); 
		//console.log(m_name); 

		$("#wr_18").val(m_name);
		$("#wr_17").val(m_id);
	}

});
</script>
<div id="copymove" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>
    <form name="fboardlist" id="fboardlist" action="./proc_all_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="sw" value="<?php echo $sw ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id_list" value="<?php echo $wr_id_list ?>">
    <input type="hidden" name="count_chk_bn_id" value="<?php echo $count_chk_bn_id ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="act" value="<?php echo $act ?>">
    <input type="hidden" name="url" value="<?php echo get_text(clean_xss_tags($_SERVER['HTTP_REFERER'])); ?>">

<?php
//담당자일괄변경
if ($sw === 'proc_marketer'){
?>

	<input type="text" name="wr_18" value="" id="wr_18" class="frm_input ui-autocomplete-input" placeholder="변경 담당자">
	<input type="hidden" name="wr_17" value="" id="wr_17">
	<input type="submit" class="btn_submit" name="btn_submit" value="담당자일괄변경" onclick="document.pressed=this.value">
<?php
//처리일괄변경
}else{
?>
	<select name="wr_10" id="wr_10" required>
		<?=codeToHtml($state_code, $wr_10, "cbo", "")?>
	</select>
	<input type="submit" class="btn_submit" name="btn_submit" value="처리일괄변경" onclick="document.pressed=this.value">
<?php
}
?>
    </form>

</div>

<script>
$(function() {
    $(".win_btn").append("<button type=\"button\" class=\"btn_cancel btn_close\">창닫기</button>");

    $(".win_btn button").click(function() {
        window.close();
    });
});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
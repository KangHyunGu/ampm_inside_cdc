<?
include_once('./_common.php');
?>
		
<html>
<head>
<script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
});



function brandChange(){
	var wr_1 = $("select[name='wr_1'] option:selected").val();

	$.ajax({
		type : "POST",
		url  : "categorychange.php",
		data : "wr_1="+wr_1,
		success : function(html){
			$("#change_category1").html(html);
		}
	});

}
function cateChange1(){
	var wr_1 = $("select[name='wr_1'] option:selected").val();
	var wr_2 = $("select[name='wr_2'] option:selected").val();
	$.ajax({
		type : "POST",
		url  : "categorychange.php",
		data : "wr_1="+wr_1+"&wr_2="+wr_2,
		success : function(html){
			$("#change_category2").html(html);
		}
	});

}
function cateChange2(){
	var wr_1 = $("select[name='wr_1'] option:selected").val();
	var wr_2 = $("select[name='wr_2'] option:selected").val();
	var wr_3 = $("select[name='wr_3'] option:selected").val();
	$.ajax({
		type : "POST",
		url  : "categorychange.php",
		data : "wr_1="+wr_1+"&wr_2="+wr_2+"&wr_3="+wr_3,
		success : function(html){
			$("#change_category3").html(html);
		}
	});

}

function categoryChange(){
	var wr_1 = $("select[name='wr_1'] option:selected").val();
	var wr_2 = $("select[name='wr_2'] option:selected").val();
	var wr_3 = $("select[name='wr_3'] option:selected").val();
	$.ajax({
		type : "POST",
		url  : "categorychange.php",
		data : "wr_1="+wr_1+"&wr_2="+wr_2+"&wr_3="+wr_3,
		success : function(html){
			$("#change_category3").html(html);
		}
	});
}
</script>
</head>
<BODY>
<div id="change_brand">
	<select name="wr_1" id="wr_1" onchange="brandChange();">
		<option value="">브랜드 선택</option>
		<?php 
			$Big_Sql = " select * from g5s_BigDiv  order by BigDivOrder asc ";
			$Big_Result = sql_query($Big_Sql);
			for ($i=0; $Big_Row=sql_fetch_array($Big_Result); $i++){
				
				if($write['wr_1'] == $Big_Row['BigDivNo']){
					$BigSelected = 'selected';
				}else{
					$BigSelected = '';
				}

				echo("
					<option value='".$Big_Row['BigDivNo']."' ".$BigSelected.">".$Big_Row['BigDivName']."</option>
				");
			}
		?>								
	</select>
</div>
<div id="change_category1">
	<select name="wr_2" id="wr_2" onchange="cateChange1();">
		<option value="">카테고리1 선택</option>
	</select>
</div>
<div id="change_category2">
	<select name="wr_3" id="wr_3" onchange="cateChange2();">
		<option value="">카테고리2 선택</option>
	</select>
</div>
<a href="javascript:" onClick="categoryChange();"><img src="http://cheongsol.ampm.kr/skin/board/product/img/search_btn.gif" alt="검색"></a>

<div id="search-list-div">
</div>
</body>
</html>

<?php
if(!$sear_part){
	if($is_admin=='super' || $member['mb_post'] == 'P6'){ //대표이사
		$sear_part = 'ACE';
	}else if($member['mb_post'] == 'P4' || $member['mb_post'] == 'P5'){ //이사
		$sear_part = 'ACE';
	}else if($member['mb_post'] == 'P3'){ //이사
		$sear_part = $member['mb_part'];

	}else{	//팀장
		$sear_part = $member['mb_part'];
	}
}

if(!$sear_team){
	if($is_admin=='super' || $member['mb_post'] == 'P6'){ //대표이사
		;
	}else if($member['mb_post'] == 'P4' || $member['mb_post'] == 'P5'){ //이사
		;
	}else if($member['mb_post'] == 'P3'){ //이사
		;
	}else{	//팀장
		$sear_team = $member['mb_team'];
	}
}

//본부정보로 팀 정보 가져오기
if ($sear_part) {
	switch ($sear_part) {
		case 'AD1':
			$code_new_team = array();
			$code_new_team["A1"]	= "광고전략제안1";
			$code_new_team["A2"]	= "광고전략제안2";
			$code_new_team["A3"]	= "광고전략제안3";
			$code_new_team["A4"]	= "광고전략제안4";
			$code_new_team["AA5"]	= "광고전략제안5";
			$code_new_team["A6"]	= "광고전략제안6";
		break;
		case 'AD3':
			$code_new_team = array();
			$code_new_team["M1"]	= "광고컨설팅1";
			$code_new_team["M2"]	= "광고컨설팅2";
			$code_new_team["M3"]	= "광고컨설팅3";
			$code_new_team["M4"]	= "광고컨설팅4";
			$code_new_team["M5"]	= "광고컨설팅5";
			$code_new_team["M6"]	= "광고컨설팅6";
			$code_new_team["K1"]	= "영상마케팅";
		break;
		case 'AQ1':
			$code_new_team = array();
			$code_new_team["Q1"]	= "광고퍼포먼스1";
			$code_new_team["Q2"]	= "광고퍼포먼스2";
			$code_new_team["Q3"]	= "광고퍼포먼스3";
			$code_new_team["Q4"]	= "광고퍼포먼스4";
			$code_new_team["Q5"]	= "광고퍼포먼스5";
			$code_new_team["Q6"]	= "광고퍼포먼스6";
		break;
		case 'ACE':
			$code_new_team = array();
			$code_new_team["A1"]	= "광고전략제안1";
			$code_new_team["A2"]	= "광고전략제안2";
			$code_new_team["A3"]	= "광고전략제안3";
			$code_new_team["A4"]	= "광고전략제안4";
			$code_new_team["AA5"]	= "광고전략제안5";
			$code_new_team["A6"]	= "광고전략제안6";

			$code_new_team["M1"]	= "광고컨설팅1";
			$code_new_team["M2"]	= "광고컨설팅2";
			$code_new_team["M3"]	= "광고컨설팅3";
			$code_new_team["M4"]	= "광고컨설팅4";
			$code_new_team["M5"]	= "광고컨설팅5";
			$code_new_team["M6"]	= "광고컨설팅6";
			$code_new_team["K1"]	= "영상마케팅";

			$code_new_team["Q1"]	= "광고퍼포먼스1";
			$code_new_team["Q2"]	= "광고퍼포먼스2";
			$code_new_team["Q3"]	= "광고퍼포먼스3";
			$code_new_team["Q4"]	= "광고퍼포먼스4";
			$code_new_team["Q5"]	= "광고퍼포먼스5";
			$code_new_team["Q6"]	= "광고퍼포먼스6";
		break;
		default:
			$code_new_team = array();
			$code_new_team["A1"]	= "광고전략제안1";
			$code_new_team["A2"]	= "광고전략제안2";
			$code_new_team["A3"]	= "광고전략제안3";
			$code_new_team["A4"]	= "광고전략제안4";
			$code_new_team["AA5"]	= "광고전략제안5";
			$code_new_team["A6"]	= "광고전략제안6";

			$code_new_team["M1"]	= "광고컨설팅1";
			$code_new_team["M2"]	= "광고컨설팅2";
			$code_new_team["M3"]	= "광고컨설팅3";
			$code_new_team["M4"]	= "광고컨설팅4";
			$code_new_team["M5"]	= "광고컨설팅5";
			$code_new_team["M6"]	= "광고컨설팅6";
			$code_new_team["K1"]	= "영상마케팅";

			$code_new_team["Q1"]	= "광고퍼포먼스1";
			$code_new_team["Q2"]	= "광고퍼포먼스2";
			$code_new_team["Q3"]	= "광고퍼포먼스3";
			$code_new_team["Q4"]	= "광고퍼포먼스4";
			$code_new_team["Q5"]	= "광고퍼포먼스5";
			$code_new_team["Q6"]	= "광고퍼포먼스6";
	}	
}
?>
<script>
$(document).ready(function(){
<?php
	if($is_admin != 'super' && $member['mb_post'] <= 'P3'){
?>
	$("select[name=sear_part]").attr("disabled", true);
<?php
	}
?>
<?php
	if($is_admin != 'super' && $member['mb_post'] < 'P3'){
?>
	$("select[name=sear_team]").attr("disabled", true);
<?php
	}
?>

	$("select[name^='sear_part']").change(function(){
    	findId = $(this).attr('id');
		selectVal = this.value;

		$("#fsearch").attr("method", "post");
		$("#fsearch").submit();
	});

});
</script>

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

	$('.chk_wr_18').each(function (index, item) {
		//console.log(index);
		$("#wr_18_"+index).autocomplete({
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
									mb_name: item.mb_name,
									mb_part_code: item.mb_part_code,
									mb_part_name: item.mb_part_name,
									mb_team_code: item.mb_team_code,
									mb_team_name: item.mb_team_name
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
				dataList(ui.item, index);
				return false;
				//event.preventDefault();
			}
		});
	});

	function dataList( item, index ) {
		m_id        = item.mb_id;
		m_name      = item.mb_name;

		//console.log(m_id); 
		//console.log(m_name); 

		$("#wr_18_"+index).val(m_name);
		$("#wr_17_"+index).val(m_id);
	}


	// 검색 - 초기화버튼 클릭시
	$("#reset").click(function() {
		$("#fsearch input, #sfl")
			.not(':button, :submit, :reset, :hidden, :checkbox')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected')
		;
		$("#fsearch input[type='checkbox']").removeAttr('checked'); // 체크박스 체크해제
	});
	
	// 검색버튼 클릭시
	$('#btn_submit').click(function() {
		$("#fsearch").attr("method", "post");
		$("#fsearch").submit();
	});

});
</script>

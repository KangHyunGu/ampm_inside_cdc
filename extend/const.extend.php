<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 설정정보
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 회원 권한등급
$member_level 		= array();			
$member_level["1"] = "비회원";
$member_level["2"] = "일반회원";
$member_level["9"] = "운영자";
if($is_admin == 'super'){
	$member_level["10"] = "총관리자";
}

// 회원관리 검색항목
$member_search		= array();		
$member_search["mb_id"]			=	"회원아이디";
$member_search["mb_name"]		=	"이름";
$member_search["mb_email"]		=	"E-MAIL";
$member_search["mb_hp"]			=	"휴대폰번호";

// 리스트 줄수
$list_rowCount	= array();
$list_rowCount["10"]	=	"10";
$list_rowCount["15"]	=	"15";
$list_rowCount["20"]	=	"20";
$list_rowCount["30"]	=	"30";
$list_rowCount["50"]	=	"50";
$list_rowCount["100"]	=	"100";
$list_rowCount["300"]	=	"300";


// 성별 
$code_sex 		= array();			
$code_sex["남성"] 	= "남성"; 
$code_sex["여성"] 	= "여성"; 

// 이메일
$code_email = array();
$code_email["gmail.com"] = "gmail.com";
$code_email["naver.com"] = "naver.com";
$code_email["nate.com"]  = "nate.com";
$code_email["hanmail.net"] = "hanmail.net";


// 핸드폰번호
$code_hp	= array();			
$code_hp["010"]	= "010";	
$code_hp["011"] = "011";		
//$code_hp["016"] = "016";		
//$code_hp["017"] = "017";		
//$code_hp["018"] = "018";		
//$code_hp["019"] = "019";		
$code_hp["060"] = "060";		
$code_hp["070"] = "070";		

// 전화번호
$code_tel	= array();			
$code_tel["02"]	= "02";	
$code_tel["031"] = "031";		
$code_tel["032"] = "032";		
$code_tel["033"] = "033";		
$code_tel["041"] = "041";		
$code_tel["042"] = "042";		
$code_tel["043"] = "043";		
$code_tel["044"] = "044";		
$code_tel["051"] = "051";		
$code_tel["052"] = "052";		
$code_tel["053"] = "053";		
$code_tel["054"] = "054";		
$code_tel["055"] = "055";		
$code_tel["061"] = "061";		
$code_tel["062"] = "062";		
$code_tel["063"] = "063";		
$code_tel["064"] = "064";		

// 핸드폰 + 전화번호
$code_phone	= array();			
$code_phone["010"] = "010";		
$code_phone["011"] = "011";		
//$code_phone["016"] = "016";		
//$code_phone["017"] = "017";		
//$code_phone["018"] = "018";		
//$code_phone["019"] = "019";		
$code_phone["060"] = "060";		
$code_phone["070"] = "070";		
$code_phone["02"]	= "02";	
$code_phone["031"] = "031";		
$code_phone["032"] = "032";		
$code_phone["033"] = "033";		
$code_phone["041"] = "041";		
$code_phone["042"] = "042";		
$code_phone["043"] = "043";		
$code_phone["044"] = "044";		
$code_phone["051"] = "051";		
$code_phone["052"] = "052";		
$code_phone["053"] = "053";		
$code_phone["054"] = "054";		
$code_phone["055"] = "055";		
$code_phone["061"] = "061";		
$code_phone["062"] = "062";		
$code_phone["063"] = "063";		
$code_phone["064"] = "064";		


//지역
$space_code = array();
$space_code["서울"] = "서울";
$space_code["경기"] = "경기";
$space_code["인천"] = "인천";
$space_code["부산"] = "부산";
$space_code["대구"] = "대구";
$space_code["대전"] = "대전";
$space_code["광주"] = "광주";
$space_code["울산"] = "울산";
$space_code["세종"] = "세종";
$space_code["충북"] = "충북";
$space_code["충남"] = "충남";
$space_code["전북"] = "전북";
$space_code["전남"] = "전남";
$space_code["경북"] = "경북";
$space_code["경남"] = "경남";
$space_code["강원"] = "강원";
$space_code["제주"] = "제주";



//상담진행상태
$state_code 		= array();			
$state_code["접수"] = "접수"; 
$state_code["진행"] = "진행"; 
$state_code["완료"] = "완료"; 


//상담구분
$code_selltype = array();
$code_selltype["검색광고"]					= "검색광고";
$code_selltype["바이럴광고"]					= "바이럴광고";
$code_selltype["DA광고(구글/GFA/카카오 등)"]	= "DA광고(구글/GFA/카카오 등)";
$code_selltype["앱광고"]						= "앱광고";
$code_selltype["제휴광고"]					= "제휴광고";
$code_selltype["기타광고"]					= "기타광고";
$code_selltype["SNS광고"]					= "SNS광고";
$code_selltype["언론홍보"]					= "언론홍보";


//월 예상 광고비
$code_monthPrice = array();
$code_monthPrice["50만원 - 100만원"]		= "50만원 - 100만원";
$code_monthPrice["100만원 - 500만원"]		= "100만원 - 500만원";
$code_monthPrice["500만원 - 1,000만원"]	= "500만원 - 1,000만원";
$code_monthPrice["1,000만원 - 5,000만원"]	= "1,000만원 - 5,000만원";
$code_monthPrice["5,000만원 이상"]		= "5,000만원 이상";


//결재수단
$code_paymethod = array();
$code_paymethod["100000000000"]	= "신용카드";
$code_paymethod["010000000000"]	= "계좌이체";
$code_paymethod["001000000000"]	= "가상계좌";
$code_paymethod["000100000000"]	= "포인트";
$code_paymethod["000010000000"]	= "휴대폰";


//영상구분
$code_video = array();
$code_video["나의영상"]	= "나의영상";
$code_video["추천영상"]	= "추천영상";

//업체구분
$code_com = array();
$code_com["업체"]	= "업체";
$code_com["자사"]	= "자사";

//영상종류
$code_moviekind = array();
$code_moviekind["브랜드필름"]		= "브랜드필름";
$code_moviekind["바이럴영상"]		= "바이럴영상";
$code_moviekind["인터뷰"]		= "인터뷰";
$code_moviekind["비디오커머스"]	= "비디오커머스";


//회원구분
$code_authck = array();
$code_authck["M"]	= "인사이드";
$code_authck["I"]	= "인트라넷";


//시간
$ad_time_clock	=	array();

for($k=1; $k<=24; $k++){
	$ad_time_clock["{$k}"] = "{$k}";
}

//년도
$code_year	=	array();

for($k=date("Y"); $k>=1960; $k--){
	$code_year["{$k}"] = "{$k}";
}

//월
$code_month	=	array();

for($k=1; $k<=12; $k++){
	$k = sprintf("%02d",$k); 
	$code_month["{$k}"] = "{$k}";
}

//일
$code_day	=	array();

for($k=1; $k<=31; $k++){
	$k = sprintf("%02d",$k); 
	$code_day["{$k}"] = "{$k}";
}


////////////////////////////////////////////////////////////////////////////
//부문, 본부 팀 직위 정보
////////////////////////////////////////////////////////////////////////////
//부문
$code_sector = array();
$code_sector["SE1"]	= "AMPM";

// 본부
$code_part = array();
$code_part["ACE"]	= "CEO";
$code_part["AD1"]	= "광고전략제안1본부";
$code_part["AD2"]	= "광고전략제안2본부";
$code_part["AD3"]	= "광고컨설팅본부";
$code_part["AQ1"]	= "광고퍼포먼스본부";
$code_part["ASU"]	= "경영지원본부";
$code_part["AT1"]	= "대외협력본부";
$code_part["AD4"]	= "(구)전략기획본부";

$code_part2 = array();
$code_part2["AD1"]	= "광고전략제안1";
$code_part2["AD2"]	= "광고전략제안2";
$code_part2["AD3"]	= "광고컨설팅";
$code_part2["AQ1"]	= "광고퍼포먼스";
$code_part2["AT1"]	= "대외협력";
$code_part2["AD4"]	= "(구)전략기획";

$code_part3 = array();
$code_part3["ACE"]	= "CEO";
$code_part3["AD1"]	= "광고전략제안1";
$code_part3["AD2"]	= "광고전략제안2";
$code_part3["AD3"]	= "광고컨설팅";
$code_part3["AQ1"]	= "광고퍼포먼스";
$code_part3["ASU"]	= "경영지원";
$code_part3["AT1"]	= "대외협력";
$code_part3["AD4"]	= "(구)전략기획";

$code_part4 = array();
$code_part4["ACE"]	= "CEO";
$code_part4["AD1"]	= "광고전략제안1";
$code_part4["AD2"]	= "광고전략제안2";
$code_part4["AD3"]	= "광고컨설팅";
$code_part4["AQ1"]	= "광고퍼포먼스";
$code_part4["ASU"]	= "경영지원";
$code_part4["AT1"]	= "대외협력";
$code_part4["AD4"]	= "(구)전략기획";

$code_part5 = array();
$code_part5["AD1"]	= "광고전략제안1";
$code_part5["AD3"]	= "광고컨설팅";
$code_part5["AQ1"]	= "광고퍼포먼스";


// 팀
$code_team = array();
$code_team["A1"]	= "광고전략제안1";
$code_team["A2"]	= "광고전략제안2";
$code_team["A3"]	= "광고전략제안3";
$code_team["A4"]	= "광고전략제안4";
$code_team["AA5"]	= "광고전략제안5";
$code_team["A6"]	= "광고전략제안6";

$code_team["AA4"]	= "(구)광고전략제안4";
$code_team["A5"]	= "(구)광고전략제안5";

$code_team["M1"]	= "광고컨설팅1";
$code_team["M2"]	= "광고컨설팅2";
$code_team["M3"]	= "광고컨설팅3";
$code_team["M4"]	= "광고컨설팅4";
$code_team["M5"]	= "광고컨설팅5";
$code_team["M6"]	= "광고컨설팅6";

$code_team["P1"]	= "(구)전략기획1";
$code_team["P2"]	= "(구)전략기획2";
$code_team["P3"]	= "(구)전략기획3";
//$code_team["P4"]	= "(구)전략기획4";
//$code_team["P5"]	= "브랜드기획1";

$code_team["K1"]	= "영상마케팅";
$code_team["Q1"]	= "광고퍼포먼스1";
$code_team["Q2"]	= "광고퍼포먼스2";
$code_team["Q3"]	= "광고퍼포먼스3";
$code_team["Q4"]	= "광고퍼포먼스4";
$code_team["Q5"]	= "광고퍼포먼스5";
$code_team["Q6"]	= "광고퍼포먼스6";
$code_team["T1"]	= "대외협력실";
$code_team["T2"]	= "TFT";
$code_team["S1"]	= "개발지원";
$code_team["S2"]	= "경영관리";
$code_team["A0"]	= "임원";


$code_team2 = array();
$code_team2["A1"]	= "광고전략제안1";
$code_team2["A2"]	= "광고전략제안2";
$code_team2["A3"]	= "광고전략제안3";
$code_team2["A4"]	= "광고전략제안4";
$code_team2["AA5"]	= "광고전략제안5";
$code_team2["A6"]	= "광고전략제안6";

$code_team2["AA4"]	= "(구)광고전략제안4";
$code_team2["A5"]	= "(구)광고전략제안5";

$code_team2["M1"]	= "광고컨설팅1";
$code_team2["M2"]	= "광고컨설팅2";
$code_team2["M3"]	= "광고컨설팅3";
$code_team2["M4"]	= "광고컨설팅4";
$code_team2["M5"]	= "광고컨설팅5";
$code_team2["M6"]	= "광고컨설팅6";

$code_team2["P1"]	= "(구)전략기획1";
$code_team2["P2"]	= "(구)전략기획2";
$code_team2["P3"]	= "(구)전략기획3";
//$code_team2["P4"]	= "(구)전략기획4";
//$code_team2["P5"]	= "브랜드기획1";

$code_team2["K1"]	= "영상마케팅";
$code_team2["Q1"]	= "광고퍼포먼스1";
$code_team2["Q2"]	= "광고퍼포먼스2";
$code_team2["Q3"]	= "광고퍼포먼스3";
$code_team2["Q4"]	= "광고퍼포먼스4";
$code_team2["Q5"]	= "광고퍼포먼스5";
$code_team2["Q6"]	= "광고퍼포먼스6";
$code_team2["T2"]	= "TFT";

$code_team3 = array();
$code_team3["A1"]	= "광고전략제안1";
$code_team3["A2"]	= "광고전략제안2";
$code_team3["A3"]	= "광고전략제안3";
$code_team3["A4"]	= "광고전략제안4";
$code_team3["AA5"]	= "광고전략제안5";
$code_team3["A6"]	= "광고전략제안6";

$code_team3["AA4"]	= "(구)광고전략제안4";
$code_team3["A5"]	= "(구)광고전략제안5";

$code_team3["M1"]	= "광고컨설팅1";
$code_team3["M2"]	= "광고컨설팅2";
$code_team3["M3"]	= "광고컨설팅3";
$code_team3["M4"]	= "광고컨설팅4";
$code_team3["M5"]	= "광고컨설팅5";
$code_team3["M6"]	= "광고컨설팅6";

$code_team3["P1"]	= "(구)전략기획1";
$code_team3["P2"]	= "(구)전략기획2";
$code_team3["P3"]	= "(구)전략기획3";
//$code_team3["P4"]	= "(구)전략기획4";

//$code_team3["P5"]	= "브랜드기획1";

$code_team3["K1"]	= "영상마케팅";

$code_team3["Q1"]	= "광고퍼포먼스1";
$code_team3["Q2"]	= "광고퍼포먼스2";
$code_team3["Q3"]	= "광고퍼포먼스3";
$code_team3["Q4"]	= "광고퍼포먼스4";
$code_team3["Q5"]	= "광고퍼포먼스5";
$code_team3["Q6"]	= "광고퍼포먼스6";

$code_team3["U1"]	= "신생팀1";
$code_team3["U2"]	= "신생팀2";


//관리자평가용
$code_part6 = array();
$code_part6["AD1"]	= "광고전략제안1";
$code_part6["AD3"]	= "광고컨설팅";
$code_part6["AQ1"]	= "광고퍼포먼스";


$code_team6 = array();
$code_team6["A1"]	= "광고전략제안1";
$code_team6["A2"]	= "광고전략제안2";
$code_team6["A3"]	= "광고전략제안3";
$code_team6["A4"]	= "광고전략제안4";
$code_team6["AA5"]	= "광고전략제안5";
$code_team6["A6"]	= "광고전략제안6";

$code_team6["AA4"]	= "(구)광고전략제안4";
$code_team6["A5"]	= "(구)광고전략제안5";

$code_team6["M1"]	= "광고컨설팅1";
$code_team6["M2"]	= "광고컨설팅2";
$code_team6["M3"]	= "광고컨설팅3";
$code_team6["M4"]	= "광고컨설팅4";
$code_team6["M5"]	= "광고컨설팅5";
$code_team6["M6"]	= "광고컨설팅6";

$code_team6["P1"]	= "(구)전략기획1";
$code_team6["P2"]	= "(구)전략기획2";
$code_team6["P3"]	= "(구)전략기획3";

$code_team6["K1"]	= "영상마케팅";
$code_team6["Q1"]	= "광고퍼포먼스1";
$code_team6["Q2"]	= "광고퍼포먼스2";
$code_team6["Q3"]	= "광고퍼포먼스3";
$code_team6["Q4"]	= "광고퍼포먼스4";
$code_team6["Q5"]	= "광고퍼포먼스5";
$code_team6["Q6"]	= "광고퍼포먼스6";

//전보용
$code_part9 = array();
$code_part9["AD1"]	= "광고전략제안1";
$code_part9["AD3"]	= "광고컨설팅";
$code_part9["AQ1"]	= "광고퍼포먼스";
$code_part9["AD4"]	= "(구)전략기획";

$code_team9 = array();	
$code_team9["A1"]	= "광고전략제안1";
$code_team9["A2"]	= "광고전략제안2";
$code_team9["A3"]	= "광고전략제안3";
$code_team9["A4"]	= "광고전략제안4";
$code_team9["AA5"]	= "광고전략제안5";
$code_team9["A6"]	= "광고전략제안6";

$code_team9["AA4"]	= "(구)광고전략제안4";
$code_team9["A5"]	= "(구)광고전략제안5";

$code_team9["M1"]	= "광고컨설팅1";
$code_team9["M2"]	= "광고컨설팅2";
$code_team9["M3"]	= "광고컨설팅3";
$code_team9["M4"]	= "광고컨설팅4";
$code_team9["M5"]	= "광고컨설팅5";
$code_team9["M6"]	= "광고컨설팅6";


$code_team9["K1"]	= "영상마케팅";

$code_team9["Q1"]	= "광고퍼포먼스1";
$code_team9["Q2"]	= "광고퍼포먼스2";
$code_team9["Q3"]	= "광고퍼포먼스3";
$code_team9["Q4"]	= "광고퍼포먼스4";
$code_team9["Q5"]	= "광고퍼포먼스5";
$code_team9["Q6"]	= "광고퍼포먼스6";

$code_team9["P1"]	= "(구)전략기획1";


//직위
$code_duty = array();
$code_duty["D1"]	= "사원";
$code_duty["D2"]	= "주임";
$code_duty["D3"]	= "대리";
$code_duty["D4"]	= "과장";
$code_duty["D5"]	= "차장";
$code_duty["D6"]	= "부장";
$code_duty["D7"]	= "이사";

//직책
$code_post = array();
$code_post["P1"]	= "팀원";
$code_post["P2"]	= "팀장";
$code_post["P3"]	= "본부장";
$code_post["P4"]	= "영업총괄";
$code_post["P5"]	= "관리총괄";
$code_post["P6"]	= "대표";

//직책2
$code_post2 = array();
$code_post2["P1"]	= "팀원";
$code_post2["P2"]	= "팀장";
$code_post2["P3"]	= "본부장";
$code_post2["P4"]	= "이사";
$code_post2["P6"]	= "대표";

//직책3
$code_post3 = array();
$code_post3["P1"]	= "팀원";
$code_post3["P2"]	= "팀장";
$code_post3["P3"]	= "임원";
$code_post3["P6"]	= "대표";

//직책4
$code_post4 = array();
$code_post4["P1"]	= "팀원";
$code_post4["P2"]	= "팀장";
$code_post4["P3"]	= "본부장";

//직책5
$code_post5 = array();
$code_post5["P1"]	= "사원";
$code_post5["P2"]	= "팀장";
$code_post5["P3"]	= "본부장";
$code_post5["P4"]	= "임원";
$code_post5["P5"]	= "임원";

//직책6
$code_post6 = array();
$code_post6["AA"]	= "소속";
$code_post6["P1"]	= "사원";
$code_post6["P2"]	= "팀장";
$code_post6["P3"]	= "임원";



// 사원명 검색항목
$mnid_search		= array();
$mnid_search["mb_name"] = "사원명";
$mnid_search["mb_id"]	= "아이디";


////////////////////////////////////////////////////////////////////////////
//자격증
////////////////////////////////////////////////////////////////////////////
//자격증 종류
$code_li_type =  array();
$code_li_type["A"]	= "검색광고마케터 1급";
#$code_li_type["B"]	= "검색광고마케터 2급";
#$code_li_type["C"]	= "구글 애드워즈 인증시험";
$code_li_type["D"]	= "구글 애널틱리스";
$code_li_type["E"]	= "페이스북 FCBP(BLUEPRINT)";
#$code_li_type["F"]	= "페이스북 FCPP";

//자격증 태스트 형태
$code_li_gubun =  array();
$code_li_gubun["A"]	= "실제응시";
$code_li_gubun["B"]	= "쪽지시험";
$code_li_gubun["C"]	= "모의테스트";


//자격증 합격여부
$code_li_passyn =  array();
$code_li_passyn["Y"]	= "합격";
$code_li_passyn["N"]	= "불합격";

//퇴사여부
$code_leaveYn =  array();
$code_leaveYn["N"]	= "사원";
$code_leaveYn["Y"]	= "퇴사";



////////////////////////////////////////////////////////////////////////////
//마케터 개인화 용
////////////////////////////////////////////////////////////////////////////
//자격증 종류2
$code_license2 =  array();
$code_license2["검색광고마케터1급"]			= "검색광고마케터1급";
$code_license2["GAIQ구글애널리틱스"]			= "GAIQ구글애널리틱스";
$code_license2["페이스북 블루프린트(FCBP)"]	= "페이스북 블루프린트(FCBP)";
$code_license2["마케터자격이수"]				= "마케터자격이수";

//전문 매체2
$code_media2 =  array();
$code_media2["검색 마케팅"]	= "검색 마케팅";
$code_media2["영상 마케팅"]	= "영상 마케팅";
$code_media2["앱 마케팅"]		= "앱 마케팅";
$code_media2["DA 마케팅"]	= "DA 마케팅";
$code_media2["SNS 마케팅"]	= "SNS 마케팅";
$code_media2["바이럴 마케팅"]	= "바이럴 마케팅";
$code_media2["제휴 마케팅"]	= "제휴 마케팅";

//전문 업종
$code_sectors =  array();
$code_sectors["가구/인테리어"]	= "가구/인테리어";
$code_sectors["건축/건설"]		= "건축/건설";
$code_sectors["게임"]			= "게임";
$code_sectors["결혼/출산/육아"]	= "결혼/출산/육아";
$code_sectors["관공서/단체"]		= "관공서/단체";
$code_sectors["교육/학원/취업"]	= "교육/학원/취업";
$code_sectors["금융/대출/보험"]	= "금융/대출/보험";
$code_sectors["꽃/이벤트"]		= "꽃/이벤트";
$code_sectors["다이어트/건강"]	= "다이어트/건강";
$code_sectors["디지털/가전"]		= "디지털/가전";
$code_sectors["반려동물"]			= "반려동물";
$code_sectors["병원/의료"]		= "병원/의료";
$code_sectors["분양/부동산"]		= "분양/부동산";
$code_sectors["뷰티/미용"]		= "뷰티/미용";
$code_sectors["비즈니스/전문서비스"]	= "비즈니스/전문서비스";
$code_sectors["산업기기"]			= "산업기기";
$code_sectors["생활/잡화"]		= "생활/잡화";
$code_sectors["스타트업"]			= "스타트업";
$code_sectors["스포츠/레져"]		= "스포츠/레져";
$code_sectors["식품/음료"]		= "식품/음료";
$code_sectors["어플리케이션"]		= "어플리케이션";
$code_sectors["엔터테인먼트"]		= "엔터테인먼트";
$code_sectors["여행/숙박"]		= "여행/숙박";
$code_sectors["유통/수송"]		= "유통/수송";
$code_sectors["의류/패션잡화"]	= "의류/패션잡화";
$code_sectors["인쇄/문구/사무기기"]	= "인쇄/문구/사무기기";
$code_sectors["인터넷/통신"]		= "인터넷/통신";
$code_sectors["자동차"]			= "자동차";
$code_sectors["프랜차이즈"]		= "프랜차이즈";
$code_sectors["공기업"]		= "공기업";
$code_sectors["호텔"]		= "호텔";
$code_sectors["기타"]			= "기타";

// 숨김여부 
$code_hide 		= array();			
$code_hide["Y"] 	= "<span class='style1 viewbox'>노출</span>"; 
$code_hide["N"] 	= "<span class='style2 viewbox'>숨김</span>"; 


// 노출여부 
$code_visible 		= array();			
$code_visible["Y"] 	= "노출"; 
$code_visible["N"] 	= "비노출"; 

// 확인여부 
$code_check 		= array();			
$code_check["Y"] 	= "<span class='qnaIco qnaIco2'>확인</span>"; 
$code_check["N"] 	= "<span class='qnaIco qnaIco3'>미확인</span>"; 


// 게시판종류
$code_botable	=	array();

if($go_table=='acomment'){
	$query = "SELECT * FROM g5_board WHERE gr_id='inside' OR (gr_id='client' and bo_table='qna')  order by bo_table ";
}else{
	$query = "SELECT * FROM g5_board WHERE gr_id='inside' order by bo_table ";
}
$_obj = sql_query($query);
while($_row=sql_fetch_array($_obj)) {
	$code_botable["{$_row['bo_table']}"] = "{$_row['bo_subject']}";
}
$code_botable_client	=	array();
$query = "SELECT * FROM g5_board WHERE gr_id='client' and bo_table != 'mkestimate' order by bo_table ";
$_obj = sql_query($query);
while($_row=sql_fetch_array($_obj)) {
	$code_botable_client["{$_row['bo_table']}"] = "{$_row['bo_subject']}";
}
?>
<?php
//------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	codeToHtml()
// 기  능 :	상수를 기본으로 코드형태의 HTML INPUT 요소의 생성
// Params :	const_codeName		: 상수
// Params :	selected_codeValue	: DB저장 코드값 또는 default 셋팅 코드값
// Params :	generateType		: 생성형태 (chk:체크박스, rdo:라디오박스, cbo:셀렉트박스)
// Params :	generateFieldName	: 체크박스, 라디오박스 형태로 생성할때의 INPUT name, id
//------------------------------------------------------------------------------------------------------------------------------
Function codeToHtml($const_codeName, $selected_codeValue, $generateType, $generateFieldName){
	if(empty($const_codeName)) 		exit;
	if($selected_codeValue == "") 	$selected_codeValue = "";
	if($generateType == "") 		$generateType 		= "cbo";
	if($generateFieldName == "") 	$generateFieldName 	= "";

	$str = "";
	
	if(!empty($const_codeName)){
		foreach($const_codeName as $key=>$value){

			if(strtolower($generateType) == "chk" || strtolower($generateType) == "chk1" || strtolower($generateType) == "chk2" || strtolower($generateType) == "chk3" || strtolower($generateType) == "chk4"){
				$selected_codeValues = $selected_codeValue[$key];
			}

			// 체크박스, 라이오버튼, 셀렉트박스의 옵션부분을 생성
			switch (strtolower($generateType)) {
				case "chk"  : //	checkbox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='checkbox' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value ."&nbsp;";
              	 	break;
				case "chk1"  : //	checkbox
					$mark =  ($key == $selected_codeValues)?"checked":"";
					$str .= "<input type='checkbox' name='". $generateFieldName ."[]' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value . "&nbsp;";
              	 	break;
				case "chk2"  : //	checkbox
					$mark =  ($key == $selected_codeValues)?"checked":"";
					$str .= "<li><input type='checkbox' name='". $generateFieldName ."[]' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value . "</li>";
              	 	break;
				case "chk3"  : //	checkbox - 마케터인사이드
					$mark =  ($key == $selected_codeValues)?"checked":"";
					$str .= "<input type='checkbox' name='". $generateFieldName ."[]' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value . "&nbsp;";
              	 	break;
				case "chk4"  : //	checkbox - 마케터인사이드 - 프로필수정
					$mark =  ($key == $selected_codeValues)?"checked":"";
               $str .= "<div class='chk_option'>";
					$str .= "<input type='checkbox' name='". $generateFieldName ."[]' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value . "&nbsp;";
               $str .= "</div>";
              	 	break;
				case "rdo"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark ." style='margin-right:5px; margin-left:10px;'>&nbsp;". $value;
              	 	break;
				case "rdo1"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."_".$key."' value='". $key ."'". $mark .">&nbsp;". $value ."&nbsp;<br>";
              	 	break;
				case "rdo2"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<li><input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."_".$key."' value='". $key ."'". $mark .">&nbsp;". $value . "</li>";
              	 	break;
				case "rdo3"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value ."&nbsp;";
              	 	break;
				case "rdo4"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark .">&nbsp;". $value ."&nbsp;<br>";
              	 	break;
				case "rdo5"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark ." required>&nbsp;<label>". $value ."&nbsp;</label>";
              	 	break;
				case "rdo6"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<label class='marketer_option'>";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark ." class='hidden' required>";
					$str .= "<div class='op-name'>". $key ."</div>";
					$str .= "</label>";
              	 	break;
				case "rdo7"  : //	radiobox
					$mark =  ($key == $selected_codeValue)?"checked":"";
					$str .= "<label class='marketer_option'>";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark ." class='hidden' required>";
					$str .= "<div class='op-name'>"."<p>". $key ."</p>"."</div>";
					$str .= "</label>";
              	 	break;
				case "rdo8"  : //	radiobox 마케터인사이드 - 카테고리
					$mark =  ($key == $selected_codeValue)?"checked":"";
               $str .= "<div class='sel-cate'>";
					$str .= "<input type='radio' name='". $generateFieldName ."' id='". $generateFieldName ."' value='". $key ."'". $mark ." required>&nbsp;<label>". $value ."&nbsp;</label>";
               $str .= "</div>";
              	 	break;
				case "cbo"  : //	selectbox
					$mark =  ($key == $selected_codeValue)?"selected":"";
					$str .= "<option value='". $key ."'". $mark .">". $value ."</option>";
              	 	break;
			}

		}
	
	}else{
		exit;
	}

	return $str;
}


//------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	codeToName()
// 기  능 :	코드값을 코드명으로 변환
// Params :	const_codeName		: 상수
// Params :	matching_codeValue	: DB저장 코드값 또는 default 셋팅 코드값
//
// Return :	코드명
//
// 사용법 :	echo codeToName($gc_code_yesno, "N")
//------------------------------------------------------------------------------------------------------------------------------
Function codeToName($const_codeName, $matching_codeValue){
	if(empty($const_codeName)) 			exit;
	if(empty($matching_codeValue)) 		exit;

	$str = "";
	
	if(!empty($const_codeName)){
		foreach($const_codeName as $key=>$value){
			if(trim($key) == trim($matching_codeValue)){
				$str = trim($value);
			}
		}
	}
	
	return $str;
}
?>
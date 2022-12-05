/*▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒
//	자바스크립트 공통 함수
//▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒
//	■ 페이징처리 함수									getPagingList()
//	■ 페이징처리 함수 (모든 버튼 항상 활성화 상태)		getPagingList_TypeB()
//-------------------------------------------------------------------------------------------------------------------------------
//	■ 특정 자바스크립트 함수 호출						jsFunc_Call()
//	■ 태그삭제											strip_tags()
//	■ 문자열의 Byte 계산된 길이						jsLenBytes()
//	■ 3자리마다 콤마를 찍어줌							jsFormat_Comma()
//	■ 모바일기기여부 체크 (데스크탑인지를 판단)		chk_isMobile()
//	■ 모바일기기여부 체크 (모바일인지를 판단)			isMobile()
//-------------------------------------------------------------------------------------------------------------------------------
//	■ 빈값여부체크										isValid_Empty()
//	■ 입력길이 최소/최대 범위 여부 체크				isValid_Length()
//	■ 입력길이 최소/최대 범위 여부 체크 (바이트체크)	isValid_ByteLength()
//	■ 숫자인지를 체크 (정수,음의정수,실수)				isValid_Numeric()
//-------------------------------------------------------------------------------------------------------------------------------
//	■ 0~9 까지의 숫자만 허용							isValid_Number()
//	■ 영문 대/소문자와 0~9 까지의 숫자만 허용			isValid_AlpaNumber()
//	■ 영문 대/소문자만 허용							isValid_Alpa()
//	■ 영문 대문자만 허용								isValid_AlpaL()
//	■ 영문 소문자만 허용								isValid_AlpaS()
//	■ 한글만 허용										isValid_Kor()
//	■ 한글과 영문만 허용								isValid_KorEng()
//	■ 영문명중 이름부분에 허용할 문자들				isValid_Eng_FirstName()
//-------------------------------------------------------------------------------------------------------------------------------
//	■ 이메일주소의 유효성 체크							isValid_Email()
//	■ 아이디 및 비밀번호의 입력문자 체크				isValid_ID_PWD()
//	■ 전화번호 유효성 체크								isValid_Phone()
//	■ 핸드폰 번호 유효성 체크							isValid_HP()
//	■ 주민등록번호의 유효성 체크						isValid_PersonalNumber()
//	■ 사업자번호의 유효성 체크							isValid_BusinessNumber()
//▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒*/
/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	getPagingList()
// 기  능 :	특정 자바스크립트 함수 호출
// Params :	total   : 총레코드수
// Params :	pgNo    : 현재페이지
// Params :	pgSize  : 페이지당목록수
// Params :	pgBlock : 페이지블럭수
// Params :	fnName	: 페이징이동 함수명(문자열)
//
// Return :	페이징
//
// 사용법 :	var strPaging = getPagingList( listTotal, pgNo, pgSize, 5 );
//			$(".paging01").html( strPaging );
//			<div class="paging01"></div>
-------------------------------------------------------------------------------------------------------------------------------*/
function getPagingList(total, pgNo, pgSize, pgBlock, fnName)
{
	// check params
	total	= ($.isNumeric(total)) ? parseInt(total) : 0;
	pgNo	= ($.isNumeric(pgNo)) ? parseInt(pgNo) : 1;
	pgSize	= ($.isNumeric(pgSize)) ? parseInt(pgSize) : 5;
	pgBlock	= ($.isNumeric(pgBlock)) ? parseInt(pgBlock) : 5;

	var fnName = (fnName != null) ? fnName : "movePage";

	// default value
	if (total <= 0)	return "";
	if (pgNo < 1)		pgNo	= 1;
	if (pgSize <= 1)	pgSize	= 1;
	if (pgBlock <= 1)	pgBlock = 1;

	//
	var pgTotal = parseInt((total-1)/pgSize)+1;				// 총페이지수
    var pgPrev  = parseInt(pgNo-1);							// 이전페이지
    var pgNext  = parseInt(pgNo+1);							// 다음페이지
    var cBlock  = parseInt((pgNo-1)/pgBlock)*pgBlock+1;		// 현재 페이지 블럭
	if (pgPrev < 1)			pgPrev = 1;
	if (pgNext > pgTotal)	pgNext = pgTotal;

	// 버튼셋팅
	var imgFirst    = "<img src='/web/images/board/btn_paging_home.gif' alt='처음' title='처음'>";
    var imgLast     = "<img src='/web/images/board/btn_paging_end.gif' alt='마지막' title='마지막'>";
    //var imgPrev     = "<img src='' alt='' title=''>";
    //var imgNext     = "<img src='' alt='' title=''>";
    var imgPrevN    = "<img src='/web/images/board/btn_paging_prev.gif' alt='이전"+ pgBlock +" 페이지' title='이전"+ pgBlock +" 페이지'>";
    var imgNextN    = "<img src='/web/images/board/btn_paging_next.gif' alt='다음"+ pgBlock +" 페이지' title='다음"+ pgBlock +" 페이지'>";

	//-----------------------------------------------------------------------------------------------------------------
	// 페이지 디자인
	//-----------------------------------------------------------------------------------------------------------------
	var sbPaging = new StringBuffer();

	if (cBlock == 1) {
		sbPaging.append("<a>"+ imgFirst +"</a>");
		sbPaging.append("<a>"+ imgPrevN +"</a>");
	} else {
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"(1)'>"+ imgFirst +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ (cBlock - pgBlock) +")'>"+ imgPrevN +"</a>");
	}

	for (var i=1; (i <= pgBlock && cBlock  <= pgTotal); i++) {

		if (cBlock == pgNo) {
			sbPaging.append("<a class='pg_On'><strong>"+ cBlock +"</strong></a>");
		} else {
			sbPaging.append("<a class='pg_Off' href='javascript:' onclick='"+fnName+"("+ cBlock +");'>"+ cBlock +"</a>")
		}
		cBlock += 1;
	}

	if (cBlock > pgTotal) {
		sbPaging.append("<a>"+ imgNextN +"</a>");
		sbPaging.append("<a>"+ imgLast +"</a>");
	} else {
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ cBlock +")'>"+ imgNextN +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgTotal +")'>"+ imgLast +"</a>");
	}

	// 페이징 결과 문자열
	return sbPaging.toString();
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	getPagingList_TypeB()
// 기  능 :	특정 자바스크립트 함수 호출
// Params :	total   : 총레코드수
// Params :	pgNo    : 현재페이지
// Params :	pgSize  : 페이지당목록수
// Params :	pgBlock : 페이지블럭수
// Params :	fnName	: 페이징이동 함수명(문자열)
//
// Return :	페이징
//
// 사용법 :	var strPaging = getPagingList_TypeB( listTotal, pgNo, pgSize, 5 );
//			$(".paging01").html( strPaging );
//			<div class="paging01"></div>
-------------------------------------------------------------------------------------------------------------------------------*/
function getPagingList_TypeB(total, pgNo, pgSize, pgBlock, fnName)
{
	// check params
	total	= ($.isNumeric(total)) ? parseInt(total) : 0;
	pgNo	= ($.isNumeric(pgNo)) ? parseInt(pgNo) : 1;
	pgSize	= ($.isNumeric(pgSize)) ? parseInt(pgSize) : 5;
	pgBlock	= ($.isNumeric(pgBlock)) ? parseInt(pgBlock) : 5;

	var fnName = (fnName != null) ? fnName : "movePage";

	// default value
	if (total <= 0)	return "";
	if (pgNo < 1)		pgNo	= 1;
	if (pgSize <= 1)	pgSize	= 1;
	if (pgBlock <= 1)	pgBlock = 1;

	//
	var pgTotal = parseInt((total-1)/pgSize)+1;				// 총페이지수
    var pgPrev  = parseInt(pgNo-1);							// 이전페이지
    var pgNext  = parseInt(pgNo+1);							// 다음페이지
    var cBlock  = parseInt((pgNo-1)/pgBlock)*pgBlock+1;		// 현재 페이지 블럭
	if (pgPrev < 1)			pgPrev = 1;
	if (pgNext > pgTotal)	pgNext = pgTotal;

	// 버튼셋팅
	var imgFirst    = "<img src='/web/images/board/btn_paging_home.gif' alt='처음' title='처음'>";
    var imgLast     = "<img src='/web/images/board/btn_paging_end.gif' alt='마지막' title='마지막'>";
    var imgPrev     = "<img src='/web/images/board/btn_paging_prev.gif' alt='이전' title='이전'>";
    var imgNext     = "<img src='/web/images/board/btn_paging_next.gif' alt='다음' title='다음'>";
    var imgPrevN    = "<img src='/web/images/board/btn_paging_prev.gif' alt='이전"+ pgBlock +" 페이지' title='이전"+ pgBlock +" 페이지'>";
    var imgNextN    = "<img src='/web/images/board/btn_paging_next.gif' alt='다음"+ pgBlock +" 페이지' title='다음"+ pgBlock +" 페이지'>";

	//-----------------------------------------------------------------------------------------------------------------
	// 페이지 디자인
	//-----------------------------------------------------------------------------------------------------------------
	var sbPaging = new StringBuffer();

	if (cBlock == 1) {
		//sbPaging.append("<a>"+ imgFirst +"</a>");
		//sbPaging.append("<a>"+ imgPrevN +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"(1)'>"+ imgFirst +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgPrev +")'>"+ imgPrev +"</a>");
	} else {
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"(1)'>"+ imgFirst +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgPrev +")'>"+ imgPrev +"</a>");
		//sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ (cBlock - pgBlock) +")'>"+ imgPrevN +"</a>");
	}

	for (var i=1; (i <= pgBlock && cBlock  <= pgTotal); i++) {

		if (cBlock == pgNo) {
			//sbPaging.append("<a class='pg_On'><strong>"+ cBlock +"</strong></a>");
			sbPaging.append("<a class='pg_On' href='javascript:' onclick='"+fnName+"("+ cBlock +");'>"+ cBlock +"</a>")
		} else {
			sbPaging.append("<a class='pg_Off' href='javascript:' onclick='"+fnName+"("+ cBlock +");'>"+ cBlock +"</a>")
		}
		cBlock += 1;
	}

	if (cBlock > pgTotal) {
		//sbPaging.append("<a>"+ imgNextN +"</a>");
		//sbPaging.append("<a>"+ imgLast +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgNext +")'>"+ imgNext +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgTotal +")'>"+ imgLast +"</a>");
	} else {
		//sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ cBlock +")'>"+ imgNextN +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgNext +")'>"+ imgNext +"</a>");
		sbPaging.append("<a href='javascript:' onclick='"+fnName+"("+ pgTotal +")'>"+ imgLast +"</a>");
	}

	// 페이징 결과 문자열
	return sbPaging.toString();
}

/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	jsFunc_Call()
// 기  능 :	특정 자바스크립트 함수 호출
// Params :	call_jsFuncName	: 호출할 자바스크립트 함수명
//
// Return :	없음
//
// 사용법 :	<input type="text" name="searchField" id="searchField" onKeyDown="return jsFunc_Call( 'execPageSearch()' );">
-------------------------------------------------------------------------------------------------------------------------------*/
function jsFunc_Call( call_jsFuncName )
{
    if ( event.keyCode == 13 )
	{
		eval(call_jsFuncName +";");		// 지정함수 호출
        return false;
    }
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	strip_tags()
// 기  능 :	태그삭제
// Params :	chk_val	: 문자열
//
// Return :	태그가 삭제된 문자열
//
// 사용법 :	alert( strip_tags(chk_val) );
-------------------------------------------------------------------------------------------------------------------------------*/
function strip_tags( chk_val )
{
	if ( $.trim(chk_val) != "" )
	{
		//chk_val = chk_val.replace(/<\/?[^>]+>/gi, '');
		chk_val = chk_val.replace(/<\/?(?!\!)[^>]*>/gi, '');
	}
	
	return chk_val;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	jsLenBytes()
// 기  능 :	문자열의 Byte 계산된 길이
// Params :	chk_val	: 문자열
//
// Return :	바이트길이
//
// 사용법 :	alert( jsLenBytes(chk_val) );
-------------------------------------------------------------------------------------------------------------------------------*/
function jsLenBytes(chk_val)
{
	var txtLen = chk_val.length;
	var totLen = 0;

	for (var i=0; i < txtLen; i++)
	{
		var tmpChar = chk_val.charAt(i);
		totLen = (escape(tmpChar).length >= 4) ? (totLen+2) : (totLen+1);
	}

    return totLen;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	jsFormat_Comma()
// 기  능 :	3자리마다 콤마를 찍어줌
// Params :	num	: 숫자값
//
// Return :	없음
//
// 사용법 :	<td><script>jsFormat_Comma(1000);</script></td>
-------------------------------------------------------------------------------------------------------------------------------*/
function jsFormat_Comma( num )
{
	num = num.toString();
	return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	chk_isMobile()
// 기  능 :	모바일기기여부 체크 (데스크탑이 아닌경우 모바일로 간주)
// Params :	없음
//
// Return :	true /false
//
// 사용법 :	if (chk_isMobile()) alert("모바일접속")
-------------------------------------------------------------------------------------------------------------------------------*/
function chk_isMobile()
{
	var filter = "win16|win32|win64|mac|macintel";

	if( navigator.platform  ) {
		if( filter.indexOf(navigator.platform.toLowerCase()) < 0 )	return true;
	}
	return false;
}

/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isMobile()
// 기  능 :	모바일기기여부 체크
// Params :	없음
//
// Return :	true /false
//
// 사용법 :	if (isMobile()) alert("모바일접속")
-------------------------------------------------------------------------------------------------------------------------------*/
function isMobile()
{
	var ua = window.navigator.userAgent.toLowerCase(); 

	if ( /iphone/.test(ua) || /android/.test(ua) || /opera/.test(ua) || /bada/.test(ua) ) { 
		return true;
	}
	return false;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Empty()
// 기  능 :	빈값여부체크
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Empty($("#title").val()) == false ) { alert("빈값아님"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Empty( chk_val )
{
	return ( $.trim(chk_val) != "" ) ? false : true;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Length()
// 기  능 :	입력길이 최소/최대 범위 여부 체크
// Params :	chk_val	: 체크할 문자열
// Params :	minLen	: 입력허용 최소길이
// Params :	maxLen	: 입력허용 최대길이
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Length($("#title").val(), null, null) != true ) { alert("제목은 2글자~4글자 이내로 입력!!");}
//			if ( isValid_Length($("#title").val(), 4, null) != true ) { alert("제목은 2글자 이상으로 입력!!");}
//			if ( isValid_Length($("#title").val(), null, 4) != true ) { alert("제목은 4글자 이내로 입력!!");}
//			if ( isValid_Length($("#title").val(), 2, 4) != true ) { alert("제목은 2글자~4글자 이내로 입력!!");}
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Length( chk_val, minLen, maxLen )
{
	var inputLen = $.trim(chk_val).length;
	if (inputLen <= 0)	return false;
    if ( !(isValid_Numeric(minLen)) && !(isValid_Numeric(maxLen)) ) return false;
    if ( minLen != null && inputLen < minLen )    return false;
    if ( maxLen != null && inputLen > maxLen )    return false;

    return true;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_ByteLength()
// 기  능 :	입력길이 최소/최대 범위 여부 체크 (★바이트단위의 길이: 한글 2Byte, 영문/숫자 1Byte)
// Params :	chk_val	: 체크할 문자열
// Params :	minLen	: 입력허용 최소길이
// Params :	maxLen	: 입력허용 최대길이
//
// Return :	true / false
//
// 사용법 :	if ( isValid_ByteLength($("#title").val(), null, null) != true ) { alert("제목은 2글자~4글자 이내로 입력!!");}
//			if ( isValid_ByteLength($("#title").val(), 4, null) != true ) { alert("제목은 2글자 이상으로 입력!!");}
//			if ( isValid_ByteLength($("#title").val(), null, 4) != true ) { alert("제목은 4글자 이내로 입력!!");}
//			if ( isValid_ByteLength($("#title").val(), 2, 4) != true ) { alert("제목은 2글자~4글자 이내로 입력!!");}
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_ByteLength( chk_val, minLen, maxLen )
{
	var inputLen = jsLenBytes( $.trim(chk_val) );
	if (inputLen <= 0)	return false;
    if ( !(isValid_Numeric(minLen)) && !(isValid_Numeric(maxLen)) ) return false;
    if ( minLen != null && inputLen < minLen )    return false;
    if ( maxLen != null && inputLen > maxLen )    return false;

    return true;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Numeric()
// 기  능 :	숫자인지를 체크 (정수,음의정수,실수)
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Empty($("#title").val()) == false ) { alert("빈값아님"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Numeric( chk_val )
{
	return $.isNumeric(chk_val);
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Number()
// 기  능 :	0~9 까지의 숫자만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Number("-100") == false ) { alert("실패"); }
// 조  건 :	오직 0~9 까지만 허용
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Number( chk_val )
{
	var pattern = /^[0-9]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_AlpaNumber()
// 기  능 :	영문 대/소문자와 0~9 까지의 숫자만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_AlpaNumber("AbcD123") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_AlpaNumber( chk_val )
{
	var pattern = /^[A-Za-z0-9]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Alpa()
// 기  능 :	영문 대/소문자만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Alpa("AbcD") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Alpa( chk_val )
{
	var pattern = /^[A-Za-z]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_AlpaL()
// 기  능 :	영문 대문자만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_AlpaL("AbcD") == false ) { alert("실패"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_AlpaL( chk_val )
{
	var pattern = /^[A-Z]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_AlpaS()
// 기  능 :	영문 소문자만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_AlpaS("AbcD") == false ) { alert("실패"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_AlpaS( chk_val )
{
	var pattern = /^[a-z]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Kor()
// 기  능 :	한글만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Kor("한gul") == false ) { alert("실패"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Kor( chk_val )
{
	var pattern = /^[가-힣]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_KorEng()
// 기  능 :	한글과 영문만 허용
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_KorEng("한gul") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_KorEng( chk_val )
{
	var pattern = /^[가-힣a-zA-Z]+$/;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Eng_FirstName()
// 기  능 :	영문명중 이름부분에 허용할 문자들
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Eng_FirstName("abc-g .k") == false ) { alert("성공"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Eng_FirstName( chk_val )
{
	var pattern = /^[a-zA-Z][a-zA-Z-.\s]*$/;	// 영문으로시작하고, 영문대소문자,하이픈,도트,스페이스만 허용!!
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Email()
// 기  능 :	이메일주소의 유효성 체크
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Email("test@test.co.kr") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Email( chk_val )
{
	//var pattern = /^([A-Za-z0-9_-]{1,30})(@{1})([A-Za-z0-9_-]{1,50})(.{1})([A-Za-z0-9]{2,4})(.{1}[A-Za-z]{2,4})?(.{1}[A-Za-z]{2,4})?$/;
	//var pattern = /^([/\w/g\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/							// chk_val.toLowerCase() 적용시 통과!!
	var pattern = /^[0-9a-zA-Z-_\.]*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_ID_PWD()
// 기  능 :	아이디 유효성 체크
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_ID_PWD("tesT_id") == false ) { alert("실패"); }
// 조  건 :	영문소문자와 숫자만허용하고, 4~15글자만 허용
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_ID_PWD( chk_val )
{
	//var pattern = /^[a-z]+[a-z0-9_]{3,14}$/	// 영문소문자로 시작하고 + 영문/숫자/하이픈만 사용할 수 있으며 최소 4~15글자만 허용
	var pattern = /^[a-z0-9]{4,15}$/
	return pattern.test( chk_val );
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_Phone()
// 기  능 :	전화번호 / 핸드폰 번호 유효성 체크
// Params :	chk_type	: H(핸드폰 전용), 그외:전화번호,핸드폰 공통
// Params :	chk_val		: 체크할 문자열 (★ 010-1234-1234 와 같이 하이픈이 포함된 형태로 전달)
//
// Return :	true / false
//
// 사용법 :	if ( isValid_Phone("", "02-123-4567") == true ) { alert("성공"); }
//			if ( isValid_Phone("HP", "02-123-4567") == false ) { alert("실패"); }
//			if ( isValid_Phone("TEL", "02-123-4567") == true ) { alert("성공"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_Phone( chk_type, chk_val )
{
	if (chk_type.toUpperCase() == "TEL")
	{
		var arrCode	= ["02","031","032","033","041","042","043","044","051","052","053","054","055","061","062","063","064","070"];
		var pattern = /^[0]+\d{1,2}-\d{3,4}-\d{4}$/;
	}
	else if (chk_type.toUpperCase() == "HP")
	{
		var arrCode	= ["010","011","012","016","017","018","019"];
		var pattern = /^[0]+\d{2}-\d{3,4}-\d{4}$/;
	}
	else
	{
		var arrCode	= ["02","031","032","033","041","042","043","044","051","052","053","054","055","061","062","063","064","070","080","010","011","012","016","017","018","019"];
		var pattern = /^[0]+\d{1,2}-\d{3,4}-\d{4}$/;
	}

	var chk_result = pattern.test( chk_val );		// 패턴체크

	if (chk_result)
	{
		var arrPhoneNumber = chk_val.split("-");
		var find_index = $.inArray(arrPhoneNumber[0], arrCode);		// 지역번호 배열과의 매칭 체크
		return (find_index >= 0) ? true : false;
	}
	else
	{
		return false;
	}
}



/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_HP()
// 기  능 :	핸드폰 번호 유효성 체크 (★ 010의 경우 11자리일때만 통과!!)
// Params :	chk_val		: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_HP("011-123-4567") == true ) { alert("성공"); }
//			if ( isValid_HP("010-123-4567") == false ) { alert("실패"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_HP( chk_val )
{
	chk_val = chk_val.replace(/-/gi, "");

	var pattern =  /^((01[1|6|7|8|9])[1-9]+[0-9]{6,7})|(010[1-9][0-9]{7})$/;
	var is_ok = pattern.test( chk_val );
	if ( !is_ok )	return false;

    return true;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_PersonalNumber()
// 기  능 :	주민등록번호의 유효성 체크
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_PersonalNumber("900101-1111115") == true ) { alert("통과"); }
//			if ( isValid_PersonalNumber("9001011111115") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_PersonalNumber( chk_val )
{
	// 패턴체크
	var pattern = /^([0-9]{6})(?:[\-]+)?([1-4]{1}[0-9]{6})$/;	//6자리+(하이픈가능)[1~4까지의 1자리]+6자리
	var is_ok = pattern.test( chk_val );
	if ( !is_ok )	return false;

	// 하이픈제거
	chk_val = chk_val.replace(/-/gi, "");    

	// 
	var yy = (chk_val.charAt(6) <= "2") ? "19" : "20";
	yy += chk_val.substr(0,2);
	var mm = chk_val.substr(2,2)-1;
	var dd = chk_val.substr(4,2);

	//
	var birthday = new Date(yy, mm, dd);
	if ( birthday.getYear() % 100 != chk_val.substr(0,2) || birthday.getMonth() != mm || birthday.getDate() != dd)	return false;
	
	// 체크섬
	var chk_rules = [2,3,4,5,6,7,8,9,2,3,4,5];
	var arr_chr = new Array(13);
	for (var i=0; i<13; i++)	arr_chr[i] = parseInt(chk_val.charAt(i));
	for (var chk_sum=0, i=0; i<12; i++) chk_sum += (arr_chr[i] *= chk_rules[i]);
	if ((11 - (chk_sum % 11)) % 10 != arr_chr[12])	return false;

	return true;
}


/*-------------------------------------------------------------------------------------------------------------------------------
// 함수명 :	isValid_BusinessNumber()
// 기  능 :	사업자번호 유효성 체크
// Params :	chk_val	: 체크할 문자열
//
// Return :	true / false
//
// 사용법 :	if ( isValid_BusinessNumber("123-45-12345") == true ) { alert("통과"); }
//			if ( isValid_BusinessNumber("1234512345") == true ) { alert("통과"); }
-------------------------------------------------------------------------------------------------------------------------------*/
function isValid_BusinessNumber( chk_val )
{
	// 패턴체크
	var pattern = /^([0-9]{3})(?:[\-]+)?([0-9]{2})(?:[\-]+)?([0-9]{5})$/;
	var is_ok = pattern.test( chk_val );
	if ( !is_ok )	return false;

	// 하이픈제거
	chk_val = chk_val.replace(/-/gi, "");    

	// 체크섬
	var chk_rules = new Array(1,3,7,1,3,7,1,3,5);
	var chk_sum = 0;
	var chk_end = 0;

	for(var i=0; i<9; i++)  chk_sum += parseInt(chk_val.substring(i,i+1)) * chk_rules[i];
	chk_sum += parseInt(parseInt(chk_val.substring(8,9))/2);
	chk_end = (10-chk_sum % 10) % 10;

	return (parseInt(chk_val.substring(9,10)) == chk_end) ? true : false;
}




 /*--------------------------------------------------------------------------*
  * call Plalyer popup 
  *--------------------------------------------------------------------------*/
  // 핵심리플레이용 (오픈시 파라미터 replay 추가함)
  function studyReplayPlayer (width, height, ViewSample, lecture_id, course_id, chapter_id) {

     var screenWidth  = window.screen.availWidth;
     var screenHeight = window.screen.availHeight;

     var intLeft = (screenWidth - width) / 2;
     var intTop  = (screenHeight - height) / 2

     var swin = window.open('/web/course/myPlayer.asp?replay=Y&ViewSample='+ViewSample+'&lecture_id='+lecture_id+'&course_id='+course_id+'&chapter_id='+chapter_id, 'myPlayer', 'scrollbars=no,resizable=no,top='+intTop+',left='+intLeft+',width='+width+',height='+height);

	 return;
  
  }


	
  function studyPlayer (width, height, ViewSample, lecture_id, course_id, chapter_id) {

     var screenWidth  = window.screen.availWidth;
     var screenHeight = window.screen.availHeight;

     var intLeft = (screenWidth - width) / 2;
     var intTop  = (screenHeight - height) / 2

     var swin = window.open('/web/course/myPlayer.asp?ViewSample='+ViewSample+'&lecture_id='+lecture_id+'&course_id='+course_id+'&chapter_id='+chapter_id, 'myPlayer', 'scrollbars=no,resizable=no,top='+intTop+',left='+intLeft+',width='+width+',height='+height);

	 return;
  
  }

  function studyPlayer_test (width, height, ViewSample, lecture_id, course_id, chapter_id) {

     var screenWidth  = window.screen.availWidth;
     var screenHeight = window.screen.availHeight;

     var intLeft = (screenWidth - width) / 2;
     var intTop  = (screenHeight - height) / 2

     var swin = window.open('/web/course/myPlayerx.asp?ViewSample='+ViewSample+'&lecture_id='+lecture_id+'&course_id='+course_id+'&chapter_id='+chapter_id, 'myPlayer', 'scrollbars=no,resizable=no,top='+intTop+',left='+intLeft+',width='+width+',height='+height);

	 return;
  
  }




 /*--------------------------------------------------------------------------*
  * call Plalyer popup 
  *--------------------------------------------------------------------------*/
  function moviePlayer (width, height, url) {

     var screenWidth  = window.screen.availWidth;
     var screenHeight = window.screen.availHeight;

     var intLeft = (screenWidth - width) / 2;
     var intTop  = (screenHeight - height) / 2

     var swin = window.open('/web/course/mvPlayer.asp?url='+url, 'mvPlayer', 'scrollbars=no,resizable=no,top='+intTop+',left='+intLeft+',width='+width+',height='+height);

	 return;
  
  }


 /*--------------------------------------------------------------------------*
  * boolean IsEmpty(str)
  * 문자열이 공백을 포함하여 빈문자열이면 True, 아니면 False
  *--------------------------------------------------------------------------*/
  function IsEmpty(str) {
	for (var i=0; i < str.length; i++) {
		if (str.substring(i,i+1) != " ") return false;  
	}   
	return true; 
  }


// 자료가 숫자인지 체크

function checkDigit(tocheck) {
  var isnum = true;
  if ((tocheck ==null) || (tocheck == "")) {
       isnum = false;
       return isnum; 
  }

  for (var j= 0 ; j< tocheck.length; j++ ) {
       if ( ( tocheck.substring(j,j+1) != "0" ) &&
            ( tocheck.substring(j,j+1) != "1" ) &&
            ( tocheck.substring(j,j+1) != "2" ) &&
            ( tocheck.substring(j,j+1) != "3" ) &&
            ( tocheck.substring(j,j+1) != "4" ) &&
            ( tocheck.substring(j,j+1) != "5" ) &&
            ( tocheck.substring(j,j+1) != "6" ) &&
            ( tocheck.substring(j,j+1) != "7" ) &&
            ( tocheck.substring(j,j+1) != "8" ) &&
            ( tocheck.substring(j,j+1) != "9" ) ) {
            isnum = false; }  
   }
   return isnum; 
}



function checkDigitDish(tocheck) {
  var isnum = true;
  if ((tocheck ==null) || (tocheck == "")) {
       isnum = false;
       return isnum; 
  }

  for (var j= 0 ; j< tocheck.length; j++ ) {
       if ( ( tocheck.substring(j,j+1) != "0" ) &&
            ( tocheck.substring(j,j+1) != "1" ) &&
            ( tocheck.substring(j,j+1) != "2" ) &&
            ( tocheck.substring(j,j+1) != "3" ) &&
            ( tocheck.substring(j,j+1) != "4" ) &&
            ( tocheck.substring(j,j+1) != "5" ) &&
            ( tocheck.substring(j,j+1) != "6" ) &&
            ( tocheck.substring(j,j+1) != "7" ) &&
            ( tocheck.substring(j,j+1) != "8" ) &&
            ( tocheck.substring(j,j+1) != "9" ) &&
            ( tocheck.substring(j,j+1) != "-" ) ) {
            isnum = false; }  
   }
   return isnum; 
}


// 자료가 숫자, 콤마 인지 체크

function checkDigit_comma(tocheck) {
  var isnum = true;
  if ((tocheck ==null) || (tocheck == "")) {
       isnum = false;
       return isnum; 
  }

  for (var j= 0 ; j< tocheck.length; j++ ) {
       if ( ( tocheck.substring(j,j+1) != "0" ) &&
            ( tocheck.substring(j,j+1) != "1" ) &&
            ( tocheck.substring(j,j+1) != "2" ) &&
            ( tocheck.substring(j,j+1) != "3" ) &&
            ( tocheck.substring(j,j+1) != "4" ) &&
            ( tocheck.substring(j,j+1) != "5" ) &&
            ( tocheck.substring(j,j+1) != "6" ) &&
            ( tocheck.substring(j,j+1) != "7" ) &&
            ( tocheck.substring(j,j+1) != "8" ) &&
            ( tocheck.substring(j,j+1) != "9" ) &&
            ( tocheck.substring(j,j+1) != "," ) ) {
            isnum = false; }  
   }
   return isnum; 
}


// 자료가 영문,숫자로만 이루어 졌는지 체크

function IsAlphaNumeric(checkStr) {
  var checkOK = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_0123456789";
  for (i = 0; i < checkStr.length; i++ ) {
	ch = checkStr.charAt(i);
	for (j = 0; j < checkOK.length; j++)  if (ch == checkOK.charAt(j)) break;
 	if (j == checkOK.length) { 
	    return false;
		break;
	}
  }
  return true; 
}



// 자료가 영문 로만 이루어 졌는지 체크

function IsAlpha(checkStr) {
  var checkOK = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  for (i = 0; i < checkStr.length; i++ ) {
	ch = checkStr.charAt(i);
	for (j = 0; j < checkOK.length; j++)  if (ch == checkOK.charAt(j)) break;
 	if (j == checkOK.length) { 
	    return false;
		break;
	}
  }
  return true; 
}



// 자료가 영문,한글 로만 이루어 졌는지 체크

function IsAlphaHangul(checkStr) {
  
  for (i=0; i < checkStr.length; i++) {
	
	ch = checkStr.charAt(i);    
	if ( (ch >= '0' && ch <= '9') || !((ch >= 'a' && ch <='z') || (ch == '_') || (ch < 255) || (ch > 0) || (ch >= '가' && ch <= '힣')) ) {
	    return false;
		break;     
    }
  }
  
  return true;
}


// trim 함수 

function trim(str){
  
  // 정규 표현식을 사용하여 화이트스페이스를 빈문자로 전환
  str = str.replace(/^\s*/,'').replace(/\s*$/, ''); 
  return str;

} 


// 3자리 단위로 콤마 삽입하기전 폼값 체크
// onblur="comma(폼이름.폼필드)" 식으로 input 형식에 삽입

function comma(f) {
 
  if (IsEmpty(f.value) == true)  return  false;
	 
  if (!checkDigit_comma(f.value) == true) { 
      window.alert("숫자만 입력해 주세요.");
	  f.value = '';
      f.focus();
      return false; 
  }

  var price, tmp;
  price = f.value;
  tmp = price.replace(/,/g, "");
	
  f.value = commaNum(tmp);  

}


//3자리 단위로 콤마 삽입하기

function commaNum(num) {  
  if (num < 0) { num *= -1; var minus = true} 
  else var minus = false 
         
  var dotPos = (num+"").split(".") 
  var dotU = dotPos[0] 
  var dotD = dotPos[1] 
  var commaFlag = dotU.length%3 

  if (commaFlag) { 
      var out = dotU.substring(0, commaFlag)  
      if (dotU.length > 3) out += "," 
  } 
  else var out = "" 

  for (var i=commaFlag; i < dotU.length; i+=3) { 
       out += dotU.substring(i, i+3)  
       if( i < dotU.length-3) out += "," 
  } 

  if (minus) out = "-" + out 
  if (dotD) return out + "." + dotD 
  else return out  
} 


function sendMe2Day(title,url,tag) {
	title = "\""+title+"\":"+url;
	var wp = window.open("http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(title) + "&new_post[tags]=" + encodeURIComponent(tag), 'me2Day', '');
	if ( wp ) {
		wp.focus();
	}
}

function sendFaceBook(title,url) {
	var wp = window.open("http://www.facebook.com/sharer.php?u=" + url + "&t=" + encodeURIComponent(title), 'facebook', 'width=600px,height=420px');
	if ( wp ) {
		wp.focus();
	}
}

function sendTwitter(title,url) {
	var wp = window.open("http://twitter.com/home?status=" + encodeURIComponent(title) + " " + encodeURIComponent(url), 'twitter', '');
	if ( wp ) {
		wp.focus();
	}
}


function loadJPlayer(chapter_id, url) {

  if (chapter_id != '') {
  
	  $.ajax({
		 url:"/web/course/chapter_readnum_up.asp",
		 type: "post",
		 data:{
		   chapter_id : chapter_id
		 },
		 success:function(data) {
		 }
	  });    
  }


   $("#mvPop").bPopup({
     modalClose :false, 
	 speed:0, 
	 positionStyle: 'fixed',
	 loadUrl : "/web/course/jPlayer_1.asp?url="+url
   });

}

function loadJPlayer2(chapter_id, url) {

  if (chapter_id != '') {
  
	  $.ajax({
		 url:"/web/course/chapter_readnum_up.asp",
		 type: "post",
		 data:{
		   chapter_id : chapter_id
		 },
		 success:function(data) {
		 }
	  });    
  }


   $("#mvPop").bPopup({
     modalClose :false, 
	 speed:0, 
	 positionStyle: 'fixed',
	 loadUrl : "/mvPlayer/jPlayer_1.asp?url="+url
   });

}


function loadJPlayerX(chapter_id, url) {

  if (chapter_id != '') {
  
	  $.ajax({
		 url:"/web/course/chapter_readnum_up.asp",
		 type: "post",
		 data:{
		   chapter_id : chapter_id
		 },
		 success:function(data) {
		 }
	  });    
  }

  $("#mvPop").load("/mvPlayer/jwPlayer.asp?url="+url); 
  $("#mvPop").center();
  $("#mvPop").show();

}

function closejwPlayer() {
  jwplayer("jw_cont").stop();
  $("#mvPop").hide();
}


function closeJPlayer() {
  $("#mvPop").bPopup().close();
}


jQuery.fn.center = function () {
  this.css("position","absolute");
  this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
  this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2)  + $(window).scrollLeft()) + "px");
  return this;
}



function openPop(width, height, url, name) {

 var screenWidth  = window.screen.availWidth;
 var screenHeight = window.screen.availHeight;

 var intLeft = (screenWidth - width) / 2;
 var intTop  = (screenHeight - height) / 2

 var swin = window.open(url, name, 'scrollbars=no,resizable=no,top='+intTop+',left='+intLeft+',width='+width+',height='+height);

 return;

}


//전화번호 하이픈 넣기
function setHyphen(string){
	var str;
	str = checkDigit(string);
	var retValue = "";
	var len = str.length;

	if (len == 9 || len == 10 || len == 11){
		if (len == 9){
			if(str.substring(0, 2) == '02'){
				retValue = retValue + str.substring(0, 2) + "-" + str.substring(2, 5) + "-" + str.substring(5, 9);
			}else{
				retValue = retValue + str.substring(0, 3) + "-" + str.substring(3, 6) + "-" + str.substring(6, 10);
			}
		}else if (len == 10){
			if(str.substring(0, 2) == '02'){
				retValue = retValue + str.substring(0, 2) + "-" + str.substring(2, 6) + "-" + str.substring(6, 10);
			}else{
				retValue = retValue + str.substring(0, 3) + "-" + str.substring(3, 6) + "-" + str.substring(6, 10);
			}
		} else{
			retValue = retValue + str.substring(0, 3) + "-" + str.substring(3, 7) + "-" + str.substring(7, 11);
		}
	}else{
		//alert("번호가 유효하지 않습니다.");
		//document.write('Wrong Number');
		return false;
	}

	//document.write(retValue);
	return retValue;
}

// 입력값중에 공백 및 기타 문자를 날려버리는 함수요.
function checkDigit(num){
	var Digit = "1234567890";
	var string = num;
	var len = string.length
	var retVal = "";

	for (i = 0; i < len; i++){
		if (Digit.indexOf(string.substring(i, i+1)) >= 0){
			retVal = retVal + string.substring(i, i+1);
		}
	}
	return retVal;
}


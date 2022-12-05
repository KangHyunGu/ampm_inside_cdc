도메인 별 홈페이지 분기
http://sellcarstore.co.kr
- 기존 디렉토리 경로 사용

http://car-store.co.kr
- PC root 경로: www/car-store
- 모바일 root 경로: www/mobile/car-store

- css, images, img, js, inc, sub 분리
  : 모바일 에서 사용되는 파일도 www/car-store 아래의 해당 경로에서 가져옴

- skin 은 /www/skin/board, /www/mobile/skin/board 시영

관리자 두 도메인 연동
/config.php		car-store.co.kr 사용경로 정의
/index.php		상단에 도메인별 분기 처리
/landing_ok.php
/biging_ok.php
/buying_ok.php
/mms			문자 연동 시 메세지에 홈페이지명 처리
/bbs/route.php		관리자모드에서 도메인 변경 시 세션 연동
/adm/admin.head.php	셀카스토어, 카스토어 메뉴구성
/adm/admin.menu500.php
/adm/admin.menu600.php
/adm/bbs/sms_estimate.php	딜러 배당 메시지 홈페이지명 처리

/adm/index.php		딜러로그인 시 리다이렉트

skin
car-store.co.kr 용 스킨 추가
/adm/bbs/bbs_form
/dealer/adm/bbs/bbs_form
/skin/board
/mobile/skin/board

DB
car-store.co.kr 용 게시판 추가

/////////////////////////////////////////////////////////////////////////////////
//마케터 개인화 페이지 구성 진행사항 
/////////////////////////////////////////////////////////////////////////////////
* 개발일정
- 완료, 진행, 미진행의 기준은 4/16일 현 시점 기준

백앤드 구성
- DB 설계 => 완료

- 사원 관리자 로그인 구성 작업 => 완료
  : 인트라넷 등록 사원 기준 로그인 처리
  : 인트라넷에 등록 되지 않은 경우 로그인 할 수 없음
  : 퇴사 시에 로그인 안됨

- 관리자 구성 작업 => 진행중(80%) 완료예정(4/20)
  : 마케터소개
  : My video
  : Reference
  : Insight
  : 상담문의

마케터 개인화 프론트앤드 구성 => 진행중 완료예정(4/23)
- 디자인 레이아웃 구성
  : 메인 => 완료
  : 마케터소개 => 완료
  : My video => 진행중
  : Reference => 미진행
  : Insight => 미진행
  : 상담문의 => 미진행

- 프로그램 연동 작업(4/23)
  : 메인 => 진행중
  : 마케터소개 => 미진행
  : My video => 미진행
  : Reference => 미진행
  : Insight => 미진행
  : 상담문의 => 미진행
  : 마케터 상담문자 연동 => 미진행


대표페이지 마케터 리스트 구성 작업 미진행 완료예정(4/23)
- 마케터소개 리스트 인트라넷 사원 기준으로 변경 구성 => 미진행
- 마케터 관리자 로그인 구성 작업 => 미진행

검수 및 기능테스트(4/27 ~ 4/28 15시 까지)
- 기능 검수 
* 개발사이트에서 등록한 자료는 본사이트 오픈시 반영되지 않습니다.(테스트 임)
* 본사이트 오픈 4/28 19시

본사이트 적용 작업(4/28)

마케터 데이터 등록 작업(4/29~4/30)

그랜드오픈(5/3)

*****************************************************
** 개발서버 정보
*****************************************************
관리자모드 로그인
http://ampm121.ampm.kr/marketer/adm/
ID : 인트라넷아이디
PW : q1111

마케터개인화 페이지 접근(개발서버 기준)
- http://ampm121.ampm.kr/ae-인트라넷아이디
- 대표페이지 > About Us > 마케터소개
  : 사원 사진 클릭





1. 마케터 소개 페이지 구성 및 링크 연결
 - 대표페이지 마케터 소개 리스트에서 연결 처리 (sub1-2.php)	=> 미작업
 - 외부에서 마케터 코드 포함 링크로 연결 시 (gateway.php)	=> 미작업

2. .htaccess RewriteRule 처리				=> 미작업
 - 마케터 소개
 - 마케터 영상
 - 마케터 레퍼런스
 - 마케터 인사이트

3. dbconfig.php
 - 인트라넷 DB 연동 구성					=> 작업

4. common.php
 - 마케터 개인화 페이지 로그인 요청 인 경우 접속자 세션 정보를
   인트라넷 DB에 유효한 사원정보를 가져와 처리
    if($_SESSION['ss_mb_marketer'] == 'Y'){
	$member = get_marketer($_SESSION['ss_mb_id']);	=> 작업

5. common.lib.php
 - 마케터 개인화 용 함수 구성
   get_marketeradmlist() // 마케터 개인화 관리자 게시판리스트
   get_marketer()	 // 인트라넷 DB 연동 사원정보
   is_admin()		 // 관리자 권한 추가

6. /extend 폴더 구성
 - const.php		 // 구성값 상수 설정
 - marketer.extend.php	 // URL, PATH 상수 설정
 - user.config.php	 // 전용 함수 설정

7. 마케터 개인화 폴더 구성
 - /marketer/ 폴더 구성
   /adm
   /bbs
   /inc
   /mobile
   /sub

   head.sub.php
   index.php
   tail.sub.php

8. 마케터 관리자모드 접근 구성
 - /skin/member/basic/marketer.login.skin.php 별도 구성
 - /marketer/bbs/login.php 연결 URL, PATH 수정(G5_MARKETER_PATH)
 - /marketer/bbs/login_check.php
   인트라넷 사원정보 get_marketer() 함수를 통해 로그인 체크
   
   유효한 접근의 경우 
   마케터 사원 로그인 여부 확인 세션 추가
   set_session('ss_mb_marketer', 'Y');

 - /marketer/bbs/logout.php 시도 시 연결 링크 수정

9. 관리자 화면 구성
CREATE TABLE `g5_marketer_detail` (                                       
`mb_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',                   
`mb_id` varchar(20) NOT NULL COMMENT '사원아이디',                      
`mb_license` varchar(255) NOT NULL COMMENT '자격증',                    
`mb_media` varchar(255) NOT NULL COMMENT '매체',                        
`mb_sectors` varchar(255) NOT NULL COMMENT '전문직종',                  
`mb_slogan` varchar(255) DEFAULT NULL COMMENT '대표타이틀',             
`mb_profile` text COMMENT '마케터이력',                                 
`mb_message` text COMMENT '한마디',                                     
`mb_kakaoid` varchar(255) DEFAULT NULL COMMENT '카카오아이디',          
`mb_bloglink` varchar(255) DEFAULT NULL COMMENT '운영블로그',           
`mb_facebooklink` varchar(255) DEFAULT NULL COMMENT '운영페이스북',     
`mb_instagramlink` varchar(255) DEFAULT NULL COMMENT '운영인스타그램',  
`mb_youtubelink` varchar(255) DEFAULT NULL COMMENT '운영유투브',        
PRIMARY KEY (`mb_no`),                                                  
UNIQUE KEY `mb_id` (`mb_id`)                                            
);


레퍼런스 샘플

업종 : 운전학원
캠페인기간 : 2020년 이후 ~ 현재
업체분석 : 
 - 위치 서울 인접 경기도 소재
 - 서울 소재 학원에 비하여 수강료 및 서비스 경쟁력 있음
KPI : 유입당 단가 1,800원 수준, DB 당 단가 3만원
집행전략 : 실 결재 고객 수 증대를 위한 타케팅 최적화 및 타켓 유입 서비스
집행매체 : 네이버 광고
집행성과 : 4월 현재 DB 당 2.75만원, 유입 당 단가 1.75만원
인사이트 : 



가구/인테리어
건축/건설
게임
결혼/출산/육아
관공서/단체
교육/학원/취업
금융/대출/보험
꽃/이벤트
다이어트/건강
디지털/가전
반려동물
병원/의료
분양/부동산
뷰티/미용
비즈니스/전문서비스
산업기기
생활/잡화
스타트업
스포츠/레져
식품/음료
어플리케이션
엔터테인먼트
여행/숙박
유통/수송
의류/패션잡화
인쇄/문구/사무기기
인터넷/통신
자동차
프랜차이즈
기타

[마케터 개인화 페이지]

마케터 개인화 페이지 접근 정보
http://ampm121.ampm.kr/
About Us > 마케터소개


마케터 개인화 페이지 관리화면 접근 정보
http://ampm121.ampm.kr/ae-마케터사원아이디
하단의 [마케터로그인]
접속정보 
ID : 마케터아이디
PW : 인트라넷 접속 비밀번호

기능 오류나 개선 디자인 등 
개발지원팀에 요청 사항은 본부별로 취합하여
주시면 확인후 반영하도록 하겠습니다.
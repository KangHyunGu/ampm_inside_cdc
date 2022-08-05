<?php
$pageName = basename($_SERVER['PHP_SELF']);

$para1 = $_REQUEST['path_dep1'];
$para2 = $_REQUEST['path_dep2'];
$para3 = $_REQUEST['path_dep3'];

$subok = false;
//sub 폴더 여부
if(strpos($_SERVER['SCRIPT_NAME'], '/sub/') !== false) {  
	$subok = true;	//sub폴더
}

$bbsok = false;
//bbs 폴더 여부
if(strpos($_SERVER['SCRIPT_NAME'], '/bbs/') !== false) {  
	$bbsok = true;	//bbs폴더
}

if($_SERVER['SCRIPT_NAME'] == '/index.php') {
	$path_dep1 = "0";
	$path_dep2 = "0";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/clause.php') {
	$path_dep1 = "10";
	$path_dep2 = "1";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/personal.php') {
	$path_dep1 = "10";
	$path_dep2 = "2";
}else if($_SERVER['SCRIPT_NAME'] == '/sub/email.php') {
	$path_dep1 = "10";
	$path_dep2 = "3";
}else if($_SERVER['SCRIPT_NAME'] == '/bbs/login.php') {
	$path_dep1 = "8";
	$path_dep2 = "1";
}else if($subok) {
	$path_dep1 = substr($pageName, 3, 1);
	$path_dep2 = substr($pageName, 5, 1);
	$path_dep3 = ($path_dep1 == '2' && $path_dep2 == '2')?substr($pageName, 7, 1):'0';
}else if($bbsok) {
	switch ($go_table) {

		case 'insight': 
			$path_dep1 = "1";
			$path_dep2 = "1";
		break;

		case 'video': 
			$path_dep1 = "2";
			$path_dep2 = "1";
		break;
		case 'reference': 
			$path_dep1 = "3";
			$path_dep2 = "1";
		break;
		case 'qna': 
			$path_dep1 = "4";
			$path_dep2 = "1";

			$path_dep0 = "3";
		break;
		case 'mkestimate': 
			$path_dep1 = "5";
			$path_dep2 = "1";
			
			$path_dep0 = "5";
		break;
		case 'request': 
			$path_dep1 = "6";
			$path_dep2 = "1";
			
			$path_dep0 = "4";
		break;

		case 'content': 
			$path_dep1 = "7";
			$path_dep2 = "1";
		break;

		case 'amypage': 
			$path_dep1 = "8";
			$path_dep2 = "1";
			
			$path_dep0 = "1";
		break;
		case 'umypage': 
			$path_dep1 = "8";
			$path_dep2 = "1";
			
			$path_dep0 = "1";
		break;

		case 'acomment': 
			$path_dep1 = "8";
			$path_dep2 = "2";
			
			$path_dep0 = "2";
		break;
		case 'ucomment': 
			$path_dep1 = "8";
			$path_dep2 = "2";
			
			$path_dep0 = "2";
		break;

		case 'favorites': 
			$path_dep1 = "8";
			$path_dep2 = "3";

			$path_dep0 = "6";
		break;


		case 'memberlogin': 
			$path_dep1 = "10";
			$path_dep2 = "1";
		break;
		case 'memberjoin': 
			$path_dep1 = "10";
			$path_dep2 = "2";
		break;
		case 'membermodify': 
			$path_dep1 = "10";
			$path_dep2 = "3";
		break;
	}
}else{
	$path_dep1 = $_REQUEST['path_dep1'];
	$path_dep2 = $_REQUEST['path_dep2'];
	$path_dep3 = ($path_dep1 == '2')?$_REQUEST['path_dep3']:'0';
}

$para1 = $path_dep1;
$para2 = $path_dep2;
$para3 = ($path_dep1 == '2')?$path_dep3:'0';

$chkPath = $path_dep1."-".$path_dep2."-".$path_dep3;
//echo "chkPath=> ".$chkPath;

////////////////////////////////////////
//path_dep0 = 마이페이지 탭메뉴 코드
////////////////////////////////////////

?>
<?php
if($bodyok){ // adm 폴더도 아니고 로그인 페이지도 아니다.
?>

    <!-- header -->
	<header id="header">
		<div class="header_wrap">
			<a class="logo" href="<?=G5_URL?>/index.php">
            <img src="<?=G5_URL?>/images/logo.png" alt="마케팅 인사이드 로고">
         </a>
			<nav>
				<!--gnb-->
				<ul class="gnb clear">
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=insight_cdc">마케터 인사이트 CDC</a>
					</li>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=insight">마케터 인사이트</a>
					</li>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=video">영상 교육</a>
					</li>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=reference">마케팅 레퍼런스</a>
					</li>
					<li>
						<a href="<?=G5_BBS_URL?>/board.php?bo_table=qna">질문답변</a>
					</li>
               <li>
						<a href="<?=G5_URL?>/marketer/#section4" target="_blank">마케터 소개</a>
					</li>
				</ul>
			</nav>
         <!--
         <div class="top_sch">
            <fieldset id="hd_sch">
                <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="검색어를 입력하세요">
                <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search"></i></button>
                </form>

                <script>
                function fsearchbox_submit(f)
                {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i=0; i<f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
                </script>

            </fieldset>
         </div>
         -->
		</div>
	</header>

<?php
}
?>
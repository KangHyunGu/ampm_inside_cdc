<?php
include_once('./_common.php');

$g5['title'] = '사원이미지 템플릿';
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"><title><?=$g5['title']?></title>
<!--[if lte IE 8]>
<script src="<?=G5_JS_URL?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_path      = "<?php echo G5_PATH ?>";
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/js.common.js"></script>
<script>
    $(function(){
        $(".tab ul li").click(function(){ 
            $(".tab ul li").removeClass('on');
            $(".tab .conBox").removeClass('on');
            $(this).addClass('on');
            $("#"+$(this).data('id')).addClass('on');
        });
    });
</script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
<style>
html {
    margin:0;
    padding:0;
    border:0;
}
    
body {
    height:100%;
    background: #fff;
    min-width: 800px;
    margin:0;
    padding:0;
    font-family: 'Pretendard', 'Noto Sans KR', sans-serif;
    letter-spacing: -0.025em;
}
    
.tab{
    display:block;
    width:100%;
    height:auto;
    overflow:hidden;
}
 
.tab ul{
    padding:0;
    margin:0;
    list-style:none;
    width:100%;
    height:auto;
    overflow:hidden;
}
 
.tab ul li{
    display:inline-block;
    width:50%;
    float:left;
    line-height:50px;
    text-align:center;
    cursor:pointer;
    color:#000;
    border: 1px solid #eee;
    box-sizing: border-box;
}
 
.tab ul li.on{
    background: #1acb86;
    color:#fff;
}

.tab ul li:hover {
   background: #f0f0f0;
   color: #000;
}
 
.tab .conBox{
    padding: 20px 0;
    width:100%;
    height:auto;
    overflow:hidden;
    min-height:200px;
    display:none;
    text-align:center;
    background: #fff;
}
 
.tab .conBox.on{
    display:block;
}

.warning { 
   margin: 20px 0;
   color: #333;
}
    
.conBox a {
    text-align: center;
    display: inline-block;
    margin:0 auto;
    color:#ff4172;
    padding: 10px 30px;
    border: 1px solid #ff4172;
    text-decoration: none;
    transition: all 0.3s ease-in-out;
    font-weight: 700;
}

.conBox a:hover {
    background: #ff4172;
    color:#fff;
}
</style>
</head>

<body>

<div class="tab">
    <ul>
        <li data-id="con1" class="on">템플릿이미지</li>
        <li data-id="con2">제작가이드</li>
    </ul>
    <div id="con1" class="conBox on">
        <img src="<?=G5_MARKETER_URL?>/inc/template/template.jpg" alt="">
        <div class="warning">
            ※ PSD 파일 다운로드 후, 가이드에 준수하여 이미지를 제작합니다.<br>
            ※ 타입 별 상세 가이드는 PSD 파일에서 확인 가능합니다.
        </div>
        <a href="<?=G5_MARKETER_URL?>/inc/template/template.zip" target="_blank">
			PSD 다운로드
	    </a>
    </div>
    <div id="con2" class="conBox">
        <img src="<?=G5_MARKETER_URL?>/inc/template/guide.jpg" alt="">
        <div class="warning">
            ※ PSD 파일 다운로드 후, 가이드에 준수하여 이미지를 제작합니다.<br>
            ※ 타입 별 상세 가이드는 PSD 파일에서 확인 가능합니다.
        </div>
        <a href="<?=G5_MARKETER_URL?>/inc/template/template.zip" target="_blank">
			PSD 다운로드
	    </a>
    </div>
</div>

</body>
</html>
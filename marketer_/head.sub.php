<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 기준시작시간
$begin_time = get_microtime();

// 사이트 타이틀 명
if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = $_SERVER['REQUEST_URI'];
$g5['lo_url'] = $_SERVER['REQUEST_URI'];
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/

?>
<?php
$bodyok = true;
//adm 폴더 여부
if(strpos($_SERVER['SCRIPT_NAME'], '/adm/') !== false) {  
	$bodyok = false;
}

//로그인페이지
$loginok = false;
if($_SERVER['SCRIPT_NAME'] == '/bbs/login.php') { 
	$bodyok = false;
	$loginok = true;
}
?>
<!doctype html>
<html lang="ko">
<head>
<title><?php echo $g5_head_title; ?></title>
<meta charset="utf-8">
<META HTTP-EQUIV="Page-Enter" content="BlendTrans(Duration=0.3)"> 
<META HTTP-EQUIV="Page-exit" content="BlendTrans(Duration=0.3)">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<?php
if (defined('G5_IS_ADMIN')) {
    echo '<link rel="stylesheet" href="'.G5_MARKETER_ADMIN_URL.'/css/admin.css">'.PHP_EOL;
} else {
    
	if($bodyok){ 
		if (G5_IS_MOBILE) {
			echo '<link rel="stylesheet" href="'.G5_MARKETER_CSS_URL.'/m_marketer.css">'.PHP_EOL;
		}else{
			echo '<link rel="stylesheet" href="'.G5_MARKETER_CSS_URL.'/marketer.css">'.PHP_EOL;
		}
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">'.PHP_EOL;
        echo '<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">'.PHP_EOL;
   }
}
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_CAR_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php
if ($is_admin) {
    echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
}
?>
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<script src="<?php echo G5_JS_URL ?>/js.common.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.cookie.js"></script>

<?php
if($bodyok){ 
?>

	<?php
	if(G5_IS_MOBILE) {
	?>
        <?php
			//메인페이지 만
			if($_SERVER['SCRIPT_NAME'] == '/marketer/index.php') { 
		?>

            <script>
                // index 스크립트
			</script>

		<?php
		}
		?>
        
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="<?php echo G5_MARKETER_JS_URL ?>/m_quick2.js"></script>
        <script src="<?php echo G5_MARKETER_JS_URL ?>/jquery.easing.js"></script>
		<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	    <script>
		// header, #top_btn addclass
		jQuery(document).ready(function() {
			var bodyOffset = jQuery('body').offset();
			jQuery(window).scroll(function() {
				if (jQuery(document).scrollTop() > bodyOffset.top) {
					jQuery('header').addClass('on');
					jQuery('#top_btn').addClass('on');
				} else {
					jQuery('header').removeClass('on');
					jQuery('#top_btn').removeClass('on');
				}
			});
		});

        /* a태그 부드럽게 이동 */
        $(document).ready(function(){
            $('a.move').click(function(e){
                e.preventDefault(); // 버벅거림 빼기
                $('html,body').animate({scrollTop:$(this.hash).offset().top - 200}, 800);
            });
        })

		</script>
        <script>
            $(function() {
                AOS.init();
            });
        </script>
	
	<?php
	}else{
	?>
		
		<?php
			//메인페이지 만
			if($_SERVER['SCRIPT_NAME'] == '/marketer/index.php') { 
		?>

			<script>
                // index 스크립트
			</script>
		
		<?php
		}
		?>
        
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="<?php echo G5_JS_URL ?>/commonScript.js"></script>
		<script>
		// header, #top_btn addclass
		jQuery(document).ready(function() {
			var bodyOffset = jQuery('body').offset();
			jQuery(window).scroll(function() {
				if (jQuery(document).scrollTop() > bodyOffset.top) {
					jQuery('#mk-header, #sub-header').addClass('on');
				} else {
					jQuery('#mk-header, #sub-header').removeClass('on');
				}
			});
		});

		/* a태그 부드럽게 이동 */
        $(document).ready(function(){
            $('a.move').click(function(e){
                e.preventDefault(); // 버벅거림 빼기
                $('html,body').animate({scrollTop:$(this.hash).offset().top - 120}, 800);
            });
        })
        
		</script>
        <script>
            $(function() {
                AOS.init();
            });
        </script>

	<?php
	}
	?>

<?php
}
?>


<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}

if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>

<?php
if($bodyok){ // adm 폴더도 아니고 로그인 페이지도 아니다.
	/////////////////////////////////////////////////////////////////////////////////
	//매체 스크립트
	/////////////////////////////////////////////////////////////////////////////////
?>

    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-87097306-2', 'auto');
		ga('require', 'displayfeatures');
        ga('send', 'pageview');

    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5QHLLVP');

    </script>
    <!-- End Google Tag Manager -->

    <script type="text/javascript" charset="UTF-8" src="//t1.daumcdn.net/adfit/static/kp.js"></script>
    <script type="text/javascript">
        kakaoPixel('6435093421289813510').pageView();
        kakaoPixel('6435093421289813510').viewContent();

    </script>

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '574218739912962');
        fbq('track', 'PageView');

    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=574218739912962&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->



    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QHLLVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
<?php
}
?>
</head>
<body>
    <?php
if($bodyok){ // adm 폴더도 아니고 로그인 페이지도 아니다.
?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QHLLVP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
?>

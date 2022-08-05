<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_PATH.'/head.php');
?>


<!-- 시안 1 / 시안 2 -->
<div class="design">
   <div class="wrap">

      <h1>마케팅 커뮤니티 시안</h1>
      <p>마케팅 커뮤니티 1안/2안 입니다. 클릭하면 해당 시안 목록으로 이동합니다.</p>

      <div class="design-wrap">
         <div class="design-box">
            <a href="<? echo G5_URL ?>/design/design1/list.html">
               <p>시안 1안</p>
            </a>
         </div>
         <div class="design-box">
            <a href="<? echo G5_URL ?>/design/design2/list.html">
               <p>시안 2안</p>
            </a>
         </div>
      </div>

   </div>
</div>


<?php
include_once(G5_PATH.'/tail.php');
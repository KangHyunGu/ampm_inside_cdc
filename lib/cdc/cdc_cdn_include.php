<?php
    // quasar Css
    add_stylesheet('<link rel="stylesheet" href="' . CDC_CSS_URL . '/quasar.css">', 0);
    add_stylesheet('<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">', 0);

    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
    add_stylesheet('<link rel="stylesheet" href="' . CDC_CSS_URL . '/cdc-style.css">', 0);
?>

<!-- Add the following at the end of your body tag vue3(Vue3 사용)-->
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@2.7.5/dist/quasar.umd.prod.js"></script>
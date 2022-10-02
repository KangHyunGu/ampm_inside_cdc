<?php
    // CDC 게시글 삭제
    sql_query("delete from g5_wr_cdc where bo_table = '$bo_table' and wr_id = '{$write['wr_id']}' ");
?>
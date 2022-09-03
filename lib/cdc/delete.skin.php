<?php
    // CDC- 업로드된 파일(이미지) 삭제
    $sql2 = " select * from {$g5['cdc_file']} where bo_table = '$bo_table' and wr_id = '{$write['wr_id']}' ";
    $result2 = sql_query($sql2);
     while ($row2 = sql_fetch_array($result2)) {
         $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row2['bf_file']), $row2);
         if( file_exists($delete_file) ){
             @unlink($delete_file);
         }
    }
    // 파일테이블 행 삭제
    sql_query(" delete from {$g5['cdc_file']} where bo_table = '$bo_table' and wr_id = '{$write['wr_id']}' ");
    
    // CDC 게시글 삭제
    sql_query("delete from {$g5['cdc_table']} where bo_table = '$bo_table' and wr_id = '{$write['wr_id']}' ");
?>
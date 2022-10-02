<?php
// 신규 입력 아이디
//echo $wr_id;
//echo json_encode($_POST);
//print_r2($_POST);
// DB 처리 default INSERT 처리(해당 게시글을 수정하지만 CDC 관련 정보가 없는경우가 존재)

//2022.09.29 파일 처리 개선 필요(처리시간 지연 문제 발생)
// 임시 bf_source 개선 완료 후 bf_file로 변경 예정
$cdc_sql = "insert into {$g5['cdc_table']} set bo_table = '${bo_table}', wr_id = '$wr_id', {fieldSet}";
if($w == 'u'){
    // 해당 게시글에 CDC 관련 정보 존재유무 확인 후 update 처리(error 확인 필요)
     $sel_sql = "select count(*) as cnt from {$g5['cdc_table']} where bo_table = '$bo_table' and wr_id='$wr_id'";
     $row = sql_fetch($sel_sql);
     if($row['cnt'] != 0){
        $cdc_sql = "update {$g5['cdc_table']} set {fieldSet} where bo_table = '$bo_table' and wr_id = '$wr_id'";
    }
}

$file_size = count($_FILES);
$is_insta = $_POST['is_insta'];

$commonSql = "is_youtube = '{$_POST['is_youtube']}',
                    is_blog = '{$_POST['is_blog']}',
                    is_insta = '$is_insta',
                    wr_cat_link = '{$_POST['wr_cat_link']}',
                    wr_mhash_1 = '{$_POST['wr_mhash_1']}',
                    wr_mhash_2 = '{$_POST['wr_mhash_2']}',
                    wr_mhash_3 = '{$_POST['wr_mhash_3']}',
                    wr_shash_1 = '{$_POST['wr_shash_1']}',
                    wr_shash_2 = '{$_POST['wr_shash_2']}',
                    wr_shash_3 = '{$_POST['wr_shash_3']}',
                    wr_shash_4 = '{$_POST['wr_shash_4']}',
                    wr_shash_5 = '{$_POST['wr_shash_5']}',
                    wr_shash_6 = '{$_POST['wr_shash_6']}',
                    wr_shash_7 = '{$_POST['wr_shash_7']}',
                    wr_ytag = '{$_POST['wr_ytag']}',
                    wr_video_link = '{$_POST['wr_video_link']}',
                    wr_youtube_link = '{$_POST['wr_youtube_link']}',
                    wr_playlist_link = '{$_POST['wr_playlist_link']}',
                    wr_cdc_content = '$wr_content',
                    wr_cdc_title = '$wr_subject',
                    wr_cdc_file = '$file_size',
                    wr_mhash = '{$_POST['wr_mhash']}',
                    wr_shash = '{$_POST['wr_shash']}'";
                    
    $cdc_sql = str_replace("{fieldSet}", $commonSql, $cdc_sql);
    sql_query($cdc_sql);

// 파일개수 체크
 $file_count   = 0;
 $upload_count = (isset($_FILES['cdc_file']['name']) && is_array($_FILES['cdc_file']['name'])) ? count($_FILES['cdc_file']['name']) : 0;

 for ($i=0; $i<$upload_count; $i++) {
     if($_FILES['cdc_file']['name'][$i] && is_uploaded_file($_FILES['cdc_file']['tmp_name'][$i]))
         $file_count++;
 }

// if($w == 'u') {
//     $file = get_file($bo_table, $wr_id);
//     if($file_count && (int)$file['count'] > $board['bo_upload_count'])
//         alert('기존 파일을 삭제하신 후 첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
// } else {
//     if($file_count > $board['bo_upload_count'])
//         alert('첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
// }

// // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
// @mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
// @chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

 $chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

 // 가변 파일 업로드

 // 파일 DB default 값 
 $file_upload_msg = '';

 $upload = array();

 $upload_file    = '';
 $upload_source   = '';
 $upload_filesize = 0;
 $upload_image    = array();
 $upload_image[0] = 0;
 $upload_image[1] = 0;
 $upload_image[2] = 0;
 $upload_fileurl = '';
 $upload_thumburl= '';
 $upload_storage = '';

 // 수정전 이미지/썸네일/CAT배너 삭제 파일이 존재 할 경우 처리  
 if($w == 'u' && isset($_FILES['cdc_remove_files']['name'])){
    for ($i=0; $i<count($_FILES['cdc_remove_files']['name']); $i++){
        $bf_file = $_FILES['cdc_remove_files']['name'][$i];

        $row = sql_fetch(" select * from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_source = '{$bf_file}' ");

        $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);

        if( file_exists($delete_file) ){
            //CDC 파일 삭제
            @unlink($delete_file);
        }
       
        // 썸네일삭제
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
            delete_board_thumbnail($bo_table, $row['bf_file']);
        }

        // CDC 파일 DB 처리
        $sql = " update {$g5['cdc_file']}
         set bf_source = '$upload_source',
             bf_file = '{$upload_file}',
             bf_content = '',
             bf_fileurl = '$upload_fileurl',
             bf_thumburl = '$upload_thumburl',
             bf_storage = '$upload_storage',
             bf_filesize = '$upload_filesize',
             bf_width = '0',
             bf_height = '0',
             bf_type = '',
             bf_datetime = '".G5_TIME_YMDHIS."'
        where bo_table = '{$bo_table}'
                and wr_id = '{$wr_id}'
                and bf_source = '{$bf_file}' ";
        sql_query($sql);
    }
 }

 if(isset($_FILES['cdc_file']['name']) && is_array($_FILES['cdc_file']['name'])) {
     for ($i=0; $i<count($_FILES['cdc_file']['name']); $i++) {
         $upload[$i]['file']     = $upload_file;
         $upload[$i]['source']   = $upload_source;
         $upload[$i]['filesize'] = $upload_filesize;
         $upload[$i]['image']    = $upload_image;
         $upload[$i]['image'][0] = $upload_image[0];
         $upload[$i]['image'][1] = $upload_image[1];
         $upload[$i]['image'][2] = $upload_image[2];
         $upload[$i]['fileurl'] = $upload_fileurl;
         $upload[$i]['thumburl'] = $upload_thumburl;
         $upload[$i]['storage'] = $upload_storage;

         // 삭제에 체크가 되어있다면 파일을 삭제합니다.
         if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
             $upload[$i]['del_check'] = true;

             $row = sql_fetch(" select * from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

             $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
             if( file_exists($delete_file) ){
                 @unlink($delete_file);
             }
             // 썸네일삭제
             if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                 delete_board_thumbnail($bo_table, $row['bf_file']);
             }
         }
         else
             $upload[$i]['del_check'] = false;

         $tmp_file  = $_FILES['cdc_file']['tmp_name'][$i];
         $filesize  = $_FILES['cdc_file']['size'][$i];
         $filename  = $_FILES['cdc_file']['name'][$i];
         $filename  = get_safe_filename($filename);

         // 서버에 설정된 값보다 큰파일을 업로드 한다면
         if ($filename) {
             if ($_FILES['cdc_file']['error'][$i] == 1) {
                 $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
                 continue;
             }
             else if ($_FILES['cdc_file']['error'][$i] != 0) {
                 $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
                 continue;
             }
         }

         if (is_uploaded_file($tmp_file)) {
             // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
             if (!$is_admin && $filesize > $board['bo_upload_size']) {
                 $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
                 continue;
             }

             //=================================================================\
             // 090714
             // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
             // 에러메세지는 출력하지 않는다.
             //-----------------------------------------------------------------
             $timg = @getimagesize($tmp_file);
             // image type
             if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
                  preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
                 if ($timg['2'] < 1 || $timg['2'] > 16)
                     continue;
             }
             //=================================================================

             $upload[$i]['image'] = $timg;

             // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
             if ($w == 'u') {
                 // 존재하는 파일이 있다면 삭제합니다.
                 $row = sql_fetch(" select * from {$g5['cdc_file']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
                 if(isset($row['bf_file']) && $row['bf_file']){
                     $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
                     if( file_exists($delete_file) ){
                         @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
                     }
                     // 이미지파일이면 썸네일삭제
                     if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                         delete_board_thumbnail($bo_table, $row['bf_file']);
                     }
                 }
             }

             // 프로그램 원래 파일명
             $upload[$i]['source'] = $filename;
             $upload[$i]['filesize'] = $filesize;

             // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
             $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

             shuffle($chars_array);
             $shuffle = implode('', $chars_array);

             // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
             $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

             $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];

             // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
             $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['cdc_file']['error'][$i]);

             // 올라간 파일의 퍼미션을 변경합니다.
             chmod($dest_file, G5_FILE_PERMISSION);

             $dest_file = run_replace('write_update_upload_file', $dest_file, $board, $wr_id, $w);
             $upload[$i] = run_replace('write_update_upload_array', $upload[$i], $dest_file, $board, $wr_id, $w);
         }
     }   // end for
 }   // end if

 // 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
 for ($i=0; $i<count($upload); $i++)
 {
     $upload[$i]['source'] = sql_real_escape_string($upload[$i]['source']);
     $bf_content[$i] = isset($bf_content[$i]) ? sql_real_escape_string($bf_content[$i]) : '';
     $bf_width = isset($upload[$i]['image'][0]) ? (int) $upload[$i]['image'][0] : 0;
     $bf_height = isset($upload[$i]['image'][1]) ? (int) $upload[$i]['image'][1] : 0;
     $bf_type = isset($upload[$i]['image'][2]) ? (int) $upload[$i]['image'][2] : 0;

     $row = sql_fetch(" select count(*) as cnt from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
     if ($row['cnt'])
     {
         // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
         // 그렇지 않다면 내용만 업데이트 합니다.
         if ($upload[$i]['file'])
         {
             $sql = " update {$g5['cdc_file']}
                         set bf_source = '{$upload[$i]['source']}',
                              bf_file = '{$upload[$i]['file']}',
                              bf_content = '{$bf_content[$i]}',
                              bf_fileurl = '{$upload[$i]['fileurl']}',
                              bf_thumburl = '{$upload[$i]['thumburl']}',
                              bf_storage = '{$upload[$i]['storage']}',
                              bf_filesize = '".(int)$upload[$i]['filesize']."',
                              bf_width = '".$bf_width."',
                              bf_height = '".$bf_height."',
                              bf_type = '".$bf_type."',
                              bf_datetime = '".G5_TIME_YMDHIS."'
                       where bo_table = '{$bo_table}'
                                 and wr_id = '{$wr_id}'
                                 and bf_no = '{$i}' ";
             sql_query($sql);
         }
         else
         {
              $sql = " update {$g5['cdc_file']}
                         set bf_content = '{$bf_content[$i]}'
                         where bo_table = '{$bo_table}'
                                   and wr_id = '{$wr_id}'
                                   and bf_no = '{$i}' ";
             sql_query($sql);
         }
     }
     else
     {
         $sql = " insert into {$g5['cdc_file']}
                     set bo_table = '{$bo_table}',
                          wr_id = '{$wr_id}',
                          bf_no = '{$i}',
                          bf_source = '{$upload[$i]['source']}',
                          bf_file = '{$upload[$i]['file']}',
                          bf_content = '{$bf_content[$i]}',
                          bf_fileurl = '{$upload[$i]['fileurl']}',
                          bf_thumburl = '{$upload[$i]['thumburl']}',
                          bf_storage = '{$upload[$i]['storage']}',
                          bf_download = 0,
                          bf_filesize = '".(int)$upload[$i]['filesize']."',
                          bf_width = '".$bf_width."',
                          bf_height = '".$bf_height."',
                          bf_type = '".$bf_type."',
                          bf_datetime = '".G5_TIME_YMDHIS."' ";
        

 		sql_query($sql);
        run_event('write_update_file_insert', $bo_table, $wr_id, $upload[$i], $w);
     }
 }

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
 $row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
 for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
 {
     $row2 = sql_fetch(" select bf_file from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

     // 정보가 있다면 빠집니다.
     if ($row2['bf_file']) break;

     // 그렇지 않다면 정보를 삭제합니다.
     sql_query(" delete from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
 }

 // 파일의 개수 CDC 관련 정보 테이블에 업데이트 한다
 $row = sql_fetch(" select count(*) as cnt from {$g5['cdc_file']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
 sql_query(" update {$g5['cdc_file']} set wr_cdc_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");
?>
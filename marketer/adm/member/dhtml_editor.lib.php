<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  스킨 함수 모음
**
*************************************************************************/

// 날짜, 조회수의 경우 높은 순서대로 보여져야 하므로 $flag 를 추가
// $flag : asc 낮은 순서 , desc 높은 순서
// 제목별로 컬럼 정렬하는 QUERY STRING
function subject_sort_link_overriding($col, $query_string='', $flag='asc')
{
    global $sst, $sod, $sfl, $stx, $page;

    $q1 = "sst=$col";
    if ($flag == 'asc')
    {
        $q2 = 'sod=asc';
        if ($sst == $col)
        {
            if ($sod == 'asc')
            {
                $q2 = 'sod=desc';
            }
        }
    }
    else
    {
        $q2 = 'sod=desc';
        if ($sst == $col)
        {
            if ($sod == 'desc')
            {
                $q2 = 'sod=asc';
            }
        }
    }

    $arr_query = array();
    $arr_query[] = $query_string;
    $arr_query[] = $q1;
    $arr_query[] = $q2;
    $arr_query[] = 'sfl='.$sfl;
    $arr_query[] = 'stx='.$stx;
    $arr_query[] = 'page='.$page;
    $qstr = implode("&amp;", $arr_query);

    return "<a href=\"{$_SERVER['SCRIPT_NAME']}?{$qstr}\" class=\"link-inverse\">";
}

// 회원 레이어
function get_sideview_overriding($mb_id, $name='', $email='', $homepage='')
{
    global $config;
    global $g5;
    global $bo_table, $sca, $is_admin, $member;

    $email_enc = new str_encrypt();
    $email = $email_enc->encrypt($email);
    $homepage = set_http(clean_xss_tags($homepage));

    $name     = get_text($name, 0, true);
    $email    = get_text($email);
    $homepage = get_text($homepage);

    $tmp_name = "";
    if ($mb_id) {
        //$tmp_name = "<a href=\"".G5_BBS_URL."/profile.php?mb_id=".$mb_id."\" class=\"sv_member\" title=\"$name 자기소개\" target=\"_blank\" onclick=\"return false;\">$name</a>";
        $tmp_name = '<a href="'.G5_BBS_URL.'/profile.php?mb_id='.$mb_id.'" class="sv_member" title="'.$name.' 자기소개" target="_blank" onclick="return false;" data-toggle="dropdown">';

        if ($config['cf_use_member_icon']) {
            $mb_dir = substr($mb_id,0,2);
            $icon_file = G5_DATA_PATH.'/member/'.$mb_dir.'/'.$mb_id.'.gif';

            if (file_exists($icon_file)) {
                $width = $config['cf_member_icon_width'];
                $height = $config['cf_member_icon_height'];
                $icon_file_url = G5_DATA_URL.'/member/'.$mb_dir.'/'.$mb_id.'.gif';
                $tmp_name .= '<img src="'.$icon_file_url.'" width="'.$width.'" height="'.$height.'" alt="">';

                if ($config['cf_use_member_icon'] == 2) // 회원아이콘+이름
                    $tmp_name = $tmp_name.' '.$name;
            } else {
                  $tmp_name = $tmp_name." ".$name;
            }
        } else {
            $tmp_name = $tmp_name.' '.$name;
        }
        $tmp_name .= ' <span class="fa fa-caret-down"></span></a>';

        $title_mb_id = '['.$mb_id.']';
    } else {
        if(!$bo_table)
            return $name;

        $tmp_name = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;sca='.$sca.'&amp;sfl=wr_name,1&amp;stx='.$name.'" title="'.$name.' 이름으로 검색" class="sv_guest" onclick="return false;" data-toggle="dropdown">'.$name.' <span class="fa fa-caret-down"></span></a>';
        $title_mb_id = '[비회원]';
    }

    $str = "<span class=\"dropdown\">\n";
    $str .= $tmp_name."\n";

    $str2 = "<ul class=\"dropdown-menu\" role=\"menu\">\n";
    if($mb_id)
        $str2 .= "<li><a href=\"".G5_BBS_URL."/memo_form.php?me_recv_mb_id=".$mb_id."\" onclick=\"win_memo(this.href); return false;\">쪽지보내기</a></li>\n";
    if($email)
        $str2 .= "<li><a href=\"".G5_BBS_URL."/formmail.php?mb_id=".$mb_id."&amp;name=".urlencode($name)."&amp;email=".$email."\" onclick=\"win_email(this.href); return false;\">메일보내기</a></li>\n";
    if($homepage)
        $str2 .= "<li><a href=\"".$homepage."\" target=\"_blank\">홈페이지</a></li>\n";
    if($mb_id)
        $str2 .= "<li><a href=\"".G5_BBS_URL."/profile.php?mb_id=".$mb_id."\" onclick=\"win_profile(this.href); return false;\">자기소개</a></li>\n";
    if($bo_table) {
        if($mb_id)
            $str2 .= "<li><a href=\"".G5_BBS_URL."/board.php?bo_table=".$bo_table."&amp;sca=".$sca."&amp;sfl=mb_id,1&amp;stx=".$mb_id."\">아이디로 검색</a></li>\n";
        else
            $str2 .= "<li><a href=\"".G5_BBS_URL."/board.php?bo_table=".$bo_table."&amp;sca=".$sca."&amp;sfl=wr_name,1&amp;stx=".$name."\">이름으로 검색</a></li>\n";
    }
    if($mb_id)
        $str2 .= "<li><a href=\"".G5_BBS_URL."/new.php?mb_id=".$mb_id."\">전체게시물</a></li>\n";
    if($is_admin == "super" && $mb_id) {
        $str2 .= "<li><a href=\"".G5_ADMIN_URL."/member_form.php?w=u&amp;mb_id=".$mb_id."\" target=\"_blank\">회원정보변경</a></li>\n";
        $str2 .= "<li><a href=\"".G5_ADMIN_URL."/point_list.php?sfl=mb_id&amp;stx=".$mb_id."\" target=\"_blank\">포인트내역</a></li>\n";
    }
    $str2 .= "</ul>\n";
    $str .= $str2;
    $str .= "\n<noscript class=\"sv_nojs\">".$str2."</noscript>";

    $str .= "</span>";

    return $str;
}

// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging_overriding($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<li class="hidden-xs"><a href="'.$url.'1'.$add.'">처음</a></li><li class="hidden visible-xs"><a href="'.$url.'1'.$add.'">S</a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li class="hidden-xs"><a href="'.$url.($start_page-1).$add.'">이전</a></li><li class="hidden visible-xs"><a href="'.$url.($start_page-1).$add.'">◀</a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<li><a href="'.$url.$k.$add.'">'.$k.'<span class="sr-only sound_only">페이지</span></a></li>'.PHP_EOL;
            else
                $str .= '<li class="active"><a href="#" onclick="return false;"><span class="sr-only sound_only">열린</span><b>'.$k.'</b><span class="sr-only sound_only">페이지</span></a></li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li class="hidden-xs"><a href="'.$url.($end_page+1).$add.'">다음</a></li><li class="hidden visible-xs"><a href="'.$url.($end_page+1).$add.'">▶</a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<li class="hidden-xs"><a href="'.$url.$total_page.$add.'">맨끝</a></li><li class="hidden visible-xs"><a href="'.$url.$total_page.$add.'">E</a></li>'.PHP_EOL;
    }

    if ($str)
        return "<div class=\"col-xs-12 text-center zero-padding\"><ul class=\"pagination\">{$str}</ul></div>";
    else
        return "";
}

// 게시글보기 썸네일 생성
function get_view_thumbnail_overriding($contents, $thumb_width=0)
{
    global $board, $config;

    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];

    // $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

    for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = $m[1];
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = $m[1];
        preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = $m[1];
        preg_match("/height:\s*(\d+)px/", $style, $m);
        $height = $m[1];
        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = get_text($m[1]);

        // 이미지 path 구함
        $p = parse_url($src);
        if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
            $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
        else
            $data_path = $p['path'];

        $srcfile = G5_PATH.$data_path;

        if(is_file($srcfile)) {
            $size = @getimagesize($srcfile);
            if(empty($size))
                continue;

            // jpg 이면 exif 체크
            if($size[2] == 2 && function_exists('exif_read_data')) {
                $degree = 0;
                $exif = @exif_read_data($srcfile);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }
            }

            // 원본 width가 thumb_width보다 작다면
            if($size[0] <= $thumb_width)
                continue;

            // Animated GIF 체크
            $is_animated = false;
            if($size[2] == 1) {
                $is_animated = is_animated_gif($srcfile);
            }

            // 썸네일 높이
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            $filename = basename($srcfile);
            $filepath = dirname($srcfile);

            // 썸네일 생성
            if(!$is_animated)
                $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
            else
                $thumb_file = $filename;

            if(!$thumb_file)
                continue;

            if ($width) {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'" class="img-responsive"/>';
            } else {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" class="img-responsive"/>';
            }

            // $img_tag에 editor 경로가 있으면 원본보기 링크 추가
            $img_tag = $matches[0][$i];
            if(strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                $imgurl = str_replace(G5_URL, "", $src);
                $thumb_tag = '<a href="'.G5_BBS_URL.'/view_image.php?fn='.urlencode($imgurl).'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
            }

            $contents = str_replace($img_tag, $thumb_tag, $contents);
        }
    }

    return $contents;
}

// 캡챠 HTML 코드 출력
function captcha_html_overriding($class="captcha")
{
    if(is_mobile())
        $class .= ' m_captcha';

    $html .= "\n".'<script>var g5_captcha_url  = "'.G5_CAPTCHA_URL.'";</script>';
    //$html .= "\n".'<script>var g5_captcha_path = "'.G5_CAPTCHA_PATH.'";</script>';
    $html .= "\n".'<script src="'.G5_CAPTCHA_URL.'/kcaptcha.js"></script>';
    //$html .= "\n".'<fieldset id="captcha" class="'.$class.'">';
    $html .= "\n".'<legend class="sr-only"><label for="captcha_key">자동등록방지</label></legend>';
    if (is_mobile()) $html .= '<audio src="#" id="captcha_audio" controls style="width:50px;"></audio>';

    //$html .= "\n".'<img src="#" alt="" id="captcha_img">';
    $html .= "\n".'<p><img src="javascript:void(0);" alt="" id="captcha_img"></p>';

    //if (!is_mobile()) $html .= "\n".'<button type="button" id="captcha_mp3"><span></span>숫자음성듣기</button>';
    //$html .= "\n".'<button type="button" id="captcha_reload"><span></span>새로고침</button>';
	
    $html .= '<div class="col-sm-7 col-lg-5 zero-padding">';
	$html .= '<div class="input-group">';
	$html .= '<input type="text" name="captcha_key" id="captcha_key" required class="captcha_box required form-control" size="6" maxlength="6">';
	$html .= '<div class="input-group-btn">';
	if (!is_mobile()) $html .= "\n".'<button type="button" id="captcha_mp3" class="btn btn-default"><span></span><i class="fa fa-fw fa-volume-up"></i><span class="sr-only">숫자음성듣기</span></button>';
    $html .= "\n".'<button type="button" id="captcha_reload" class="btn btn-default"><span></span><i class="fa fa-fw fa-refresh"></i><span class="sr-only">새로고침</span></button>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="clearfix"></div>';

	$html .= '<div class="col-sm-12 zero-padding">';
    $html .= "\n".'<p id="captcha_info" class="helper-block">자동등록방지 숫자를 순서대로 입력하세요.</p>';
	$html .= '</div>';
    //$html .= "\n".'</fieldset>';
    return $html;
}

function editor_html_overriding($id, $content, $is_dhtml_editor=true)
{
    global $g5, $config;
    static $js = true;

    $editor_url = G5_EDITOR_URL.'/'.$config['cf_editor'];

    $html = "";
    $html .= "<span class=\"sr-only sound_only\">Summernote 시작</span>";

	if ($is_dhtml_editor && $js) {

        ob_start();
?>

<link rel="stylesheet" href="<?php echo $editor_url ?>/summernote/summernote.css">
<script src="<?php echo $editor_url ?>/summernote/summernote.min.js"></script>
<script src="<?php echo $editor_url ?>/summernote/lang/summernote-ko-KR.js"></script>
<script type="text/javascript">

function sendFile(file, editor) {

    data = new FormData();
    data.append("SummernoteFile", file);
    $.ajax({
       data: data,
       type: "POST",
       url: "<?php echo $editor_url ?>/upload.php",
       cache: false,
       contentType: false,
       processData: false,
       success: function(data) {
         var obj =  JSON.parse(data);
         if (obj.success) {
             $(editor).summernote("insertImage", obj.save_url);
         } else {
            switch(parseInt(obj.error)) {
                case 1: alert('업로드 용량 제한에 걸렸습니다.'); break; 
				case 2: alert('MAX_FILE_SIZE 보다 큰 파일은 업로드할 수 없습니다.'); break;
				case 3: alert('파일이 일부분만 전송되었습니다.'); break;
				case 4: alert('파일이 전송되지 않았습니다.'); break;
				case 6: alert('임시 폴더가 없습니다.'); break;
				case 7: alert('파일 쓰기 실패'); break;
				case 8: alert('알수 없는 오류입니다.'); break;
                case 100: alert('이미지 파일이 아닙니다.(jpeg, jpg, gif, bmp, png 만 올리실 수 있습니다.)'); break; 
                case 101: alert('이미지 파일이 아닙니다.(jpeg, jpg, gif, bmp, png 만 올리실 수 있습니다.)'); break; 
                case 102: alert('0 byte 파일은 업로드 할 수 없습니다.'); break; 
            }// end switch
         }//end if
       }//end success
   });
}

</script>
<script src="<?php echo $editor_url ?>/config.js"></script>

<?php       
        $html .= ob_get_contents();
        ob_end_clean();

        $js = false;
    }

    $summernote_class = $is_dhtml_editor ? "summernote" : "";
    $html .= "\n<textarea id=\"$id\" name=\"$id\" class=\"$summernote_class form-control\" >$content</textarea>";
    $html .= "\n<span class=\"sr-only sound_only\">Summernote 끝</span>";
    return $html;
}// end function editor_html_overriding

// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js_overriding($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "var {$id}_editor_data = $('#{$id}').summernote('code');";
    } else {
        return "var {$id}_editor = document.getElementById('{$id}');\n";
    }
}

//  textarea 의 값이 비어 있는지 검사
function chk_editor_js_overriding($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "if (!{$id}_editor_data) { alert(\"내용을 입력해 주십시오.\"); $('#{$id}').summernote('focus'); return false; }\n";
    } else {
        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
    }
}

?>
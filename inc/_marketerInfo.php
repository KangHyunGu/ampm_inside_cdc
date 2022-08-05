<?php
if (!defined('_GNUBOARD_')) exit;
@include_once(G5_LIB_PATH.'/thumbnail.lib.php');

function latest_maketer($rows=10, $subject_len=40, $options='rand()', $pro='')
{
    global $g5;

	$sql_common = " from {$g5['member_table']} b ";

	$sql_search = "";
	$sql_pro_search = "";

	$sql_search.= " where (1) ";
	$sql_search.= "and (b.mb_leave_date = '' or b.mb_level > 1) ";
	$sql_search.= "and b.mb_level < 5 ";
	$sql_search.= "and b.mb_post in('P1','P2') ";
	$sql_search.= "and b.mb_part NOT IN('ACE','ASU','AT1') ";

	//프로마케터 추출용
	if($pro){
		$sql_search .= " and ";
		$sql_search.= " and mb_8 = '비전구간' ";
	}

	$list = array();
	
	$sql = " select * {$sql_common} {$sql_search}  order by {$options} limit 0, {$rows} ";
	//echo "sql: ".$sql;exit;
	$result = sql_query_intra($sql);

	for ($i=0; $row = sql_fetch_array($result); $i++) {
		///////////////////////////////////////////////////////////////////////////////////////
		//사원 등록 사진 있으면 그걸 적용
		///////////////////////////////////////////////////////////////////////////////////////
		$mb_dir = substr($row['mb_id'],0,2);
		$mk_file = G5_DATA_PATH.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';
		if (file_exists($mk_file)) {
			$mk_url = G5_DATA_URL.'/marketer_image/'.$mb_dir.'/'.$row['mb_id'].'.jpg';
			$mb_images = '<img src="'.$mk_url.'" alt="'.$row['mb_name'].' AE" width="170">';
		}else{
			//없으면 인트라넷 사진
			$photo_url = G5_INTRANET_URL.'/data/member_image/'.$row['mb_id'];
			
			$mb_images = '<img src="'.$photo_url.'" alt="'.$row['mb_name'].' AE" width="170">';
		}
        $view_link = "sub/gateway.php?utm_member=".$row['mb_id'];
?>

                    <a href="<?=$view_link?>">
                        <div class="mkt">
                            <div class="mkt_img">
                                <?=$mb_images?>
                            </div>
                            <div class="mkt_name">
                                <?=$row['mb_name']?> AE
                            </div>
                        </div>
                    </a>
<?php
						
	}
}
?>
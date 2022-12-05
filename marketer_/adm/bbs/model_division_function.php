<?php
####################################################################################################
# 그누보드 5s용 3단 카테고리 디비저장 부분
# 제작 정권짱
# 메일주소 kiypocom@nate.com
####################################################################################################

include_once('./_common.php');
//check_demo();


if ($_POST['actype'] == "bigdiv_insert") {	
	$DivTable		= $_POST['DivTable'];
	$OrderCount		= $_POST['TotCount']+1;
	$DivName		= $_POST['DivName'];
	$IsNew			= $_POST['IsNew'];
	$IsShow			= $_POST['IsShow'];
	$BigDivNo		= $_POST['DivNo'];
	$BigDivOrder	= $_POST['OrderCount'];

//print_r($_POST);

	if($IsNew=="Y"){
		//해당 분류가 등록 되어있는지 확인  
		$sql = " select count(*) as cnt from {$DivTable} where BigDivName= '{$DivName}'";
		//echo $sql;

		$row = sql_fetch($sql);
		$bo_count_write = $row['cnt']; 
	 
		if($bo_count_write)
	 		alert('이미 등록되어 있는 분류명입니다.');
	 	
	 	$sql_common = " BigDivName	= '{$DivName}',
	 	 				BigDivOrder	= '{$OrderCount}',
						IsShow		= 'Y'";

		$sql = " insert into {$DivTable}
	             set $sql_common ";
		
		//echo $sql;
		sql_query($sql);
	  
		goto_url('/adm/category_bigdiv.php');
		exit;
	}else{
		if($BigDivNo){			
			$sql = " select count(*) as cnt from {$DivTable} where BigDivNo <> '{$BigDivNo}' and BigDivName = '{$DivName}'";
			$row = sql_fetch($sql);
			$bo_count_write = $row['cnt'];
			 
			if(!$bo_count_write){
				$WhereQuery = " where BigDivNo='".$BigDivNo."'";
				$As			= "BigDivName='".$DivName."' , IsShow = '".$IsShow."', BigDivOrder='".$BigDivOrder."'";
				$sql = "update {$DivTable} set {$As} {$WhereQuery}";								
				sql_query($sql);								
			}else{
				alert('중복된 대분류 입니다.');
				exit;
			}			
			
			goto_url('/adm/category_bigdiv.php');
	  	
			exit;
		}
	}
}

if ($_POST['actype'] == "bigdiv_delete") {	
	$DivTable = $_POST['DivTable'];
	$BigDivNo = $_POST['DivNo'];
	
	$WhereQuery = " where BigDivNo='".$BigDivNo."'";	
	$sql = "delete from {$DivTable} {$WhereQuery}";								
	sql_query($sql);							
				
	goto_url('/adm/category_bigdiv.php');
	exit;
}

if($_POST['actype'] == "mediumdiv_insert"){		
	$DivTable		= $_POST['DivTable'];
	$BigDivNo		= $_POST['SelBigDiv'];
	$OrderCount		= $_POST['TotCount']+1;
	$MediumDivName	= $_POST['DivName'];
	$IsNew			= $_POST['IsNew'];
	$IsShow			= $_POST['IsShow'];
	$MediumDivNo	= $_POST['DivNo'];
	$BigDivOrder	= $_POST['OrderCount'];	
	
	if(!$IsShow)
		$IsShow = 'Y';

	if($IsNew == "Y"){
		$sql = " select max(MediumDivOrder) as Count from ".$DivTable;		
		$Row = sql_fetch($sql);
		$MaxOrder = $Row[Count]+1;
		
		$m_sql = " select count(*) as cnt from {$DivTable} where BigDivNo = '{$BigDivNo}' and MediumDivName = '{$MediumDivName}'";
		$m_row = sql_fetch($m_sql);
		$bo_count_write = $m_row['cnt'];
		
		if(!$bo_count_write){
			$sql_common = " BigDivNo             = '{$BigDivNo}',
	 	 					MediumDivName        = '{$MediumDivName}',
							MediumDivOrder       = '{$MaxOrder}',
							IsShow               = '{$IsShow}'";
			$sql = " insert into {$DivTable}
		             set $sql_common ";
			
			sql_query($sql);
		  
			goto_url('/adm/category_medium.php?&SelBigDiv='.$BigDivNo);
			exit;			
		}else{
			alert("중복된 중분류 입니다.");
			exit;
		}
	}else{
		if($MediumDivNo){
			$m_sql = " select count(*) as cnt from {$DivTable} where BigDivNo = '{$BigDivNo}' and MediumDivNo<>'".$MediumDivNo."' and MediumDivName = '{$MediumDivName}'";
			$m_row = sql_fetch($m_sql);
			$bo_count_write = $m_row['cnt'];
			if(!$bo_count_write){
				$WhereQuery = " where MediumDivNo='".$MediumDivNo."'";				
				$As			= "MediumDivName='".$MediumDivName."' , IsShow = '".$IsShow."', MediumDivOrder='".$BigDivOrder."'";
				$sql = "update {$DivTable} set {$As} {$WhereQuery}";								
				sql_query($sql);				
			}else{
				alert("중복된 중분류 입니다.");
				exit;
			}
		}
	}	
	
	goto_url('/adm/category_medium.php?&SelBigDiv='.$BigDivNo);
	exit;			
}

if($_POST['actype'] == "div_insert"){		
	$DivTable		= $_POST['DivTable'];
	$BigDivNo		= $_POST['SelBigDiv'];
	$SetMediumDivNo	= $_POST['SelMediumDiv'];	
	$OrderCount		= $_POST['TotCount']+1;
	$DivName		= $_POST['DivName'];
	$IsNew			= $_POST['IsNew'];
	$IsShow			= $_POST['IsShow'];
	$MediumDivNo	= $_POST['DivNo'];
	$DivOrder		= $_POST['OrderCount'];
		
	if(!$IsShow)
		$IsShow = 'Y';

	if($IsNew == "Y"){
		$sql = " select max(DivOrder) as Count from ".$DivTable." where BigDivNo = '$BigDivNo' and MediumDivNo = '$SetMediumDivNo'";		
		$Row = sql_fetch($sql);
		$MaxOrder = $Row[Count]+1;
		
		$m_sql = " select count(*) as cnt from {$DivTable} where BigDivNo = '{$BigDivNo}' and MediumDivNo = '{$SetMediumDivNo}' and DivName = '{$DivName}'";		 
		$m_row = sql_fetch($m_sql);
		$bo_count_write = $m_row['cnt'];
		
		if(!$bo_count_write){
			$sql_common = " BigDivNo      = '{$BigDivNo}',
							MediumDivNo   = '{$SetMediumDivNo}',									
	 	 					DivName       = '{$DivName}',
							DivOrder      = '{$MaxOrder}',
							IsShow        = '{$IsShow}'";
			$sql = " insert into {$DivTable}
		             set $sql_common ";
			sql_query($sql);
		  
			goto_url('/adm/category_div.php?&SelBigDiv='.$BigDivNo.'&SelMediumDiv='.$SetMediumDivNo);
			exit;			
		}else{
			alert("중복된 중분류 입니다.");
			exit;
		}
	}else{
		if($MediumDivNo){
			$m_sql = " select count(*) as cnt from {$DivTable} where BigDivNo = '{$BigDivNo}' and MediumDivNo='".$SetMediumDivNo."' and DivNo<>'".$DivNo."' and DivName = '{$DivName}'";					
			$m_row = sql_fetch($m_sql);
			$bo_count_write = $m_row['cnt'];
			if(!$bo_count_write)
			{
				$WhereQuery = " where BigDivNo = '".$BigDivNo."' and MediumDivNo='".$SetMediumDivNo."' and DivNo='".$DivNo."'";
				$As	= "DivName = '".$DivName."' , IsShow = '".$IsShow."', DivOrder='".$DivOrder."'";
				$sql = "update {$DivTable} set {$As} {$WhereQuery}";								
				sql_query($sql);				
			}
			else
			{
				alert("중복된 중분류 입니다.");
				exit;
			}
		}
	}	
	
	goto_url('/adm/category_div.php?&SelBigDiv='.$BigDivNo.'&SelMediumDiv='.$SetMediumDivNo);
}

if ($_POST['actype'] == "mediumdiv_delete") {	
	$DivTable		= $_POST['DivTable'];
	$BigDivNo		= $_POST['SelBigDiv'];
	$MediumDivNo	= $_POST['DivNo'];	
	
	$WhereQuery = " where BigDivNo='".$BigDivNo."' and MediumDivNo='$MediumDivNo'";	
	$sql = "delete from {$DivTable} {$WhereQuery}";								
	sql_query($sql);							
				
	goto_url('/adm/category_medium.php?&SelBigDiv='.$BigDivNo);
	exit;
}

if ($_POST['actype'] == "div_delete") {		
	$DivTable		= $_POST['DivTable'];
	$BigDivNo		= $_POST['SelBigDiv'];
	$MediumDivNo	= $_POST['SetMediumDivNo'];	
	$DivNo = $_POST['DivNo'];	
	
	$WhereQuery = " where BigDivNo='".$BigDivNo."' and MediumDivNo='$MediumDivNo' and DivNo='$DivNo'";	
	$sql = "delete from {$DivTable} {$WhereQuery}";								
		
	sql_query($sql);							
				
	goto_url('/adm/category_div.php?&SelBigDiv='.$BigDivNo.'&SelMediumDiv='.$MediumDivNo);
	exit;
}

if($actype == 'big_div_change'){	
	$where = " where BigDivNo='$source_value' and IsShow='Y'";
	echo "<script language='javascript'>";
	echo " var arr_text = new Array();";
	echo " var arr_value = new Array();";
	echo " var arr_style = new Array();";
	
	$i=0;
	$Change_sql = "select MediumDivName,MediumDivNo from g5s_MediumDiv  ".$where." order by MediumDivOrder";
	$Change_Result = sql_query($Change_sql);
	for ($i=0; $Change_Row=sql_fetch_array($Change_Result); $i++){			
		echo "arr_text.push('$Change_Row[MediumDivName]');";
		echo "arr_value.push('$Change_Row[MediumDivNo]');";
		echo "arr_style.push('#000000');";
	}	
	
	if($is_default)
		echo "parent.div_change('$form_name','$destination_name',arr_text,arr_value,arr_style,true);";
	else
		echo "parent.div_change('$form_name','$destination_name',arr_text,arr_value,arr_style,false);";
	
	echo "</script>";
}

if($actype == 'medium_div_change'){	
	$where = " where MediumDivNo='$source_value' and IsShow='Y'";		
	echo "<script language='javascript'>";
	echo " var arr_text = new Array();";
	echo " var arr_value = new Array();";
	echo " var arr_style = new Array();";
	
	$i=0;
	$Change_sql = "select DivNo,DivName from g5s_Div  ".$where." order by DivOrder";
	$Change_Result = sql_query($Change_sql);
	for ($i=0; $Change_Row=sql_fetch_array($Change_Result); $i++)
	{	
		echo "arr_text.push('$Change_Row[DivName]');";
		echo "arr_value.push('$Change_Row[DivNo]');";
		echo "arr_style.push('#000000');";
	}	
	
	if($is_default)
		echo "parent.div_change('$form_name','$destination_name',arr_text,arr_value,arr_style,true);";
	else
		echo "parent.div_change('$form_name','$destination_name',arr_text,arr_value,arr_style,false);";
	
	echo "</script>";
}
?>
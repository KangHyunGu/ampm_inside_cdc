<?
include_once('./_common.php');

$wr_1 = $_REQUEST['wr_1'];
$wr_2 = $_REQUEST['wr_2'];

?>

<?
if(!isset($wr_2)){
?>
<select name="wr_2" id="wr_2" onChange="cateChange1()">
	<option value=''>카테고리1 선택</option>
	<?php 
		$Where_Med_Query = " where BigDivNo='$wr_1'"; 
		$MediumDiv_Sql = " select * from g5s_MediumDiv ".$Where_Med_Query." order by MediumDivOrder asc ";
		$MediumDiv_Result = sql_query($MediumDiv_Sql);
		for ($i=0; $MediumDiv_Row=sql_fetch_array($MediumDiv_Result); $i++)
		{
			if($write['wr_2'] == $MediumDiv_Row['MediumDivNo'])
				$MedSelected = 'selected';
			else
				$MedSelected = '';
			
			echo("
					<option value='".$MediumDiv_Row['MediumDivNo']."' ".$MedSelected.">[".$MediumDiv_Row['MediumDivNo']."]".stripslashes($MediumDiv_Row['MediumDivName'])."</option>
			");
		}
	?>		             	
</select>
<?
}else{
?>
<select name="wr_3" id="wr_3" onChange="cateChange2()">
	<option value=''>카테고리2 선택</option>
	<?php 
		$Where_Med_Query = " where MediumDivNo='$wr_2'";
		$MediumDiv_Sql = " select * from g5s_Div ".$Where_Med_Query." order by DivOrder asc ";
		$MediumDiv_Result = sql_query($MediumDiv_Sql);
		for ($i=0; $MediumDiv_Row=sql_fetch_array($MediumDiv_Result); $i++)
		{
			if($write['wr_3'] == $MediumDiv_Row['DivNo'])
				$MedSelected = 'selected';
			else
				$MedSelected = '';
			
			echo("
					<option value='".$MediumDiv_Row['DivNo']."' ".$MedSelected.">[".$MediumDiv_Row['DivNo']."]".stripslashes($MediumDiv_Row['DivName'])."</option>
			");
		}
	?>		             	
</select>			
<?
}
?>
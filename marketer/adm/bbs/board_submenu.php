<?php
$bo_table = ($_GET['bo_table'])?$_GET['bo_table']:$bo_table;
switch($bo_table){
	case "introduce"	: $sub_menu = "300400";break;
	case "video"		: $sub_menu = "300500";break;
	case "reference"	: $sub_menu = "300600";break;
	case "insight"		: $sub_menu = "300700";break;
	case "mkestimate"	: $sub_menu = "300800";break;
	
	case "hs_video"			: $sub_menu = "400400";break;
	case "hs_reference"		: $sub_menu = "400500";break;
	case "hs_insight"		: $sub_menu = "400600";break;
	case "hs_mkestimate"	: $sub_menu = "400700";break;
}
?>
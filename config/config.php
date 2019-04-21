<?php

// TODO: remove this once move to production.
// header("Access-Control-Allow-Origin: http://localhost:4200");
// header("Access-Control-Allow-Origin: http://localhost:4200/asquare/user");
// header("Access-Control-Allow-Origin: *");


 date_default_timezone_set("Asia/Calcutta");
/****************************************************
			Database configuration						
****************************************************/
global $host;
$host = "localhost"; 
$user = "ACUBE"; 
$pass = "GENACUBE"; 
$database = "asquare";

// $host = "localhost"; 
// $user = "ASQUARE2018"; 
// $pass = "GENACUBE2018123$"; 
// $database = "asquareapp";
global $con;
$con = mysqli_connect($host,$user,$pass);
 
if (!$con) {
die('Sorry not able to connect, please contact DB administrator for more details ' . mysql_error());
}
 
mysqli_select_db($con,$database);

function idCREATOR($prefix, $count) {
	if($count > 0){
		$idCount = $count + 1;
	} else {
		$idCount = 1;
	}
	return   $prefix . $idCount;
}
function valFORMAT($value){
	return str_replace("'","''",$value);
}
?>
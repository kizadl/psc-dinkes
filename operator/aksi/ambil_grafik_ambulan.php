<?php
//error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$data = array();
$sqlcount = ("SELECT COUNT(IF(kepemilikan='rsud',id_unit,NULL)) AS jumRSUD,
		COUNT(IF(kepemilikan='puskesmas',id_unit,NULL)) AS jumPuskesmas,
		COUNT(IF(kepemilikan='klinik',id_unit,NULL)) AS jumKlinik FROM m_unit");
		$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['jumtotal']= $s['jumRSUD'] + $s['jumPuskesmas']- $s['jumKlinik'];
	$row_array['jumRSUD']= $s['jumRSUD'];
	$row_array['jumPuskesmas']= $s['jumPuskesmas'];
	$row_array['jumKlinik']= $s['jumKlinik'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  

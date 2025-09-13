<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$data = array();
$sqlcount = ("SELECT COUNT(IF(stts_ugd='rsud',id_ugd,NULL)) AS jumRSUD,
		COUNT(IF(stts_ugd='puskesmas',id_ugd,NULL)) AS jumPuskesmas,
		COUNT(IF(stts_ugd='klinik',id_ugd,NULL)) AS jumKlinik FROM m_ugd");
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

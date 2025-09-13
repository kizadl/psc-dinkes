<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$tglawal =trim($_POST['tglawal']);$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date('Y-m-d', strtotime($tglakhir));

$data = array();
$sqlcount = ("SELECT COUNT(IF(jk='L',id_layanan,NULL)) AS jumLaki,
		COUNT(IF(jk='P',id_layanan,NULL)) AS jumPerempuan 
		FROM trans_layanan WHERE tgl_layanan >= '".$tglawal."' AND tgl_layanan <= '".$tglakhir."'");
		$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['jumLaki']= $s['jumLaki'];
	$row_array['jumPerempuan']= $s['jumPerempuan'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  

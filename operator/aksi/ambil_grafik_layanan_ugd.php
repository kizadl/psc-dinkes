<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$tglawal =trim($_POST['tglawal']);$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date('Y-m-d', strtotime($tglakhir));

$data = array();
$sqlcount = ("SELECT COUNT(IF(q.stts_ugd='rsud',p.id_layanan,NULL)) AS jumRS,
		COUNT(IF(q.stts_ugd='puskesmas',p.id_layanan,NULL)) AS jumPus,
		COUNT(IF(q.stts_ugd='klinik',p.id_layanan,NULL)) AS jumKlin 
		FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
		 WHERE tgl_layanan >= '".$tglawal."' AND tgl_layanan <= '".$tglakhir."'");
		$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['jumRS']= $s['jumRS'];
	$row_array['jumPus']= $s['jumPus'];$row_array['jumKlin']= $s['jumKlin'];
	array_push($data,$row_array);

echo json_encode($data);
$resultcount->close();
$dbconn->close();
?>  

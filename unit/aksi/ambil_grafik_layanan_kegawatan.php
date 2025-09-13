<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

function anti_injection($data){
	global $dbconn;
	$filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
}

$idugd =anti_injection(trim($_POST['idugd']));
$tglawal =anti_injection(trim($_POST['tglawal']));$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =anti_injection(trim($_POST['tglakhir']));$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sqlx = ("SELECT DISTINCT (ket_gawat) AS sttsumur FROM trans_layanan");
 $result = mysqli_query($dbconn,$sqlx);
 $data = array();
 $totaldetail =0;
 while($t=mysqli_fetch_array($result)){
	
	$sqlcount = ("SELECT COUNT(id_layanan) as jumDetSekolah FROM trans_layanan
			 WHERE md5(id_ugd) = '".$idugd."' AND ket_gawat = '".$t['sttsumur']."' AND tgl_layanan >= '".$tglawal."' AND tgl_layanan <= '".$tglakhir."'");

	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);
	$totaldetail = $totaldetail + $s['jumDetSekolah'];

	$row_array = array();
	$row_array['nmbentuksekolah']=ucwords(strtolower($t['sttsumur']));
	$row_array['jumDetSekolah']=$s['jumDetSekolah'];	
	$row_array['totaldetail']=$totaldetail;
	array_push($data,$row_array);
}

echo json_encode($data);

$result->close();
$resultcount->close();
$dbconn->close();
 ?>
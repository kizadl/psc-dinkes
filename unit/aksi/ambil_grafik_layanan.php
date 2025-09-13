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

$sqlx = ("SELECT DISTINCT (ket_gawat) AS sttsgawat FROM trans_layanan");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
 while($t=mysqli_fetch_array($result)){

	$sqlcount = ("SELECT COUNT(IF(stts_rujuk='Y',id_layanan,NULL)) as jumRujuk,COUNT(IF(stts_rujuk='N',id_layanan,NULL)) as jumDilayani,
				COUNT(id_layanan) as jumLayanan FROM trans_layanan
				WHERE id_ugd = '".$idugd."' AND ket_gawat = '".$t['sttsgawat']."' AND tgl_layanan >= '".$tglawal."' AND tgl_layanan <= '".$tglakhir."'");
	$resultcount = mysqli_query($dbconn,$sqlcount);$s= mysqli_fetch_assoc($resultcount);

	$row_array = array();
	$row_array['sttsgawat']=ucwords(strtolower($t['sttsgawat']));
	$row_array['jumRujuk']=$s['jumRujuk'];
	$row_array['jumDilayani']=$s['jumDilayani'];
	$row_array['jumLayanan']=$s['jumLayanan'];	
	array_push($data,$row_array);
}

echo json_encode($data);

$result->close();
$resultcount->close();
$dbconn->close();
 ?>
<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idugd =trim($_POST['idugd']);

$sqljum = ("SELECT COUNT(IF(stts_rujuk='Y' AND id_ugd_rujuk='".$idugd."',id_layanan,null)) AS jumrujuk,
			COUNT(IF(stts_rujuk='N' AND id_ugd='".$idugd."',id_layanan,null)) AS jumdilayani
			FROM trans_layanan WHERE timeline <> 'selesai'");

$restjum = mysqli_query($dbconn,$sqljum);$sm= mysqli_fetch_assoc($restjum);

$data = array();
$row_array['jumrujuk']=number_format($sm['jumrujuk'],0,',','.');
$row_array['jumdilayani']=number_format($sm['jumdilayani'],0,',','.');
array_push($data,$row_array);

echo json_encode($data);
$restjum->close();
$dbconn->close();
?>  

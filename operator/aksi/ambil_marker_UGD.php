<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT * FROM m_ugd");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	
	//if ($t['stts_ugd'] == "puskesmas"){
	//	$nmugd = substr($t['nm_ugd'],10);
	//} else if ($t['stts_ugd'] == "rsud"){
		$nmugd = $t['nm_ugd'];
	//}else if ($t['stts_ugd'] == "klinik"){
	//	$nmugd = substr($t['nm_ugd'],7);
	//}

	$row_array = array();
	$row_array['idtempat']=$t['id_ugd'];
	$row_array['nmtempat']=ucwords(strtolower($nmugd));
	$row_array['alamat']=$t['alamat'];
	$row_array['notelepon']=$t['telepon'];
	$row_array['sttsugd']=$t['stts_ugd'];
	$row_array['koordinat']=$t['koordinat'];

	$row_array['idkecamatan']=$t['id_kecamatan'];
	$row_array['iddesa']=$t['id_desa'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>
<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$sqlx = ("SELECT p.id_unit,p.nm_unit,p.stts_layanan,p.id_ugd,p.id_sdk,q.nm_ugd,
		r.id_layanan,r.ket_gawat
		FROM m_unit p 
		LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
		LEFT JOIN trans_layanan r ON p.id_sdk=r.id_sdk AND r.stts_layanan='Y'
		GROUP BY p.id_unit ORDER BY p.stts_layanan='Y' DESC");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['idunit']=$t['id_unit'];
	$row_array['nmunit']=ucwords(strtolower($t['nm_unit']));
	$row_array['nmugd']=ucwords(strtolower($t['nm_ugd']));
	$row_array['sttslayanan']=$t['stts_layanan'];
	$row_array['idugd']=$t['id_ugd'];
	$row_array['idsdk']=$t['id_sdk'];

	$row_array['idlayanan']=$t['id_layanan'];$row_array['ketgawat']=ucwords(strtolower($t['ket_gawat']));
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>
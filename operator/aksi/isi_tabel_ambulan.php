<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$sqlx = ("SELECT p.id_unit,p.nm_unit,p.nm_sdk,p.imei_gps,p.merk,p.type_unit,p.no_plat,p.jenis_bbm,p.harga_bbm,p.avg_bbm,p.id_sdk,q.nm_ugd 
		FROM m_unit p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd WHERE p.aktif='Y' ORDER BY p.id_unit ASC");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idunit']=$t['id_unit'];$row_array['idsdk']=$t['id_sdk'];
	$row_array['nmunit']=$t['nm_unit'];$row_array['nmsdk']=strtoupper($t['nm_sdk']);
	$row_array['imei']=$t['imei_gps'];
	$row_array['merk']=ucwords(strtolower($t['merk']));
	$row_array['type']=ucwords(strtolower($t['type_unit']));
	$row_array['noplat']=$t['no_plat'];
	$row_array['jenisbbm']=ucwords(strtolower($t['jenis_bbm']));
	$row_array['hargabbm']=$t['harga_bbm'];
	$row_array['nmugd']=$t['nm_ugd'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  

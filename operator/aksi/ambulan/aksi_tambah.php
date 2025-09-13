<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}
date_default_timezone_set('Asia/Jakarta');	

$nmunit = strtoupper(anti_injection(trim($_POST['nmunit'])));
$idsdk = anti_injection(trim($_POST['idsdk']));$nmsdk = anti_injection(trim($_POST['nmsdk']));
$idugd = anti_injection(trim($_POST['idugd']));$sttsugd = anti_injection(trim($_POST['sttsugd']));
$noplat = strtoupper(anti_injection(trim($_POST['noplat'])));
$merk = strtoupper(anti_injection(trim($_POST['merk'])));
$type = strtoupper(anti_injection(trim($_POST['type'])));
$imei = strtoupper(anti_injection(trim($_POST['imei'])));

$jnsbbm = strtolower(anti_injection(trim($_POST['jnsbbm'])));
$harga = trim($_POST['harga']);
$konsumsi = trim($_POST['konsumsi']);

$sqlX = ("SELECT nm_unit FROM m_unit WHERE nm_unit='".$nmunit."'");			
$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);

$pesanError = array();
if (strtolower($r['nm_unit'])==strtolower($nmunit)) {
	$pesanError[] = ucwords(strtolower($nmunit))." terdeteksi sudah ada\nInput data unit ambulan tidak boleh sama";	
}	
if (trim($nmunit)=="") {
	$pesanError[] = "Data Unit Ambulan Tidak Terdeteksi";		
}
if (trim($idsdk)=="") {
	$pesanError[] = "Data Unit Ambulan GIS Tidak Terdeteksi";		
}
if (trim($idugd)=="") {
	$pesanError[] = "Data UGD Tidak Terdeteksi";		
}
if (trim($sttsugd)=="") {
	$pesanError[] = "Status Kepemilikan UGD Tidak Terdeteksi";		
}
if (trim($noplat)=="") {
	$pesanError[] = "Data Plat Nomor Tidak Terdeteksi";		
}
if (trim($merk)=="") {
	$pesanError[] = "Data Merk Ambulan Tidak Terdeteksi";		
}
if (trim($type)=="") {
	$pesanError[] = "Data Type Ambulan Tidak Terdeteksi";		
}
if (trim($imei)=="") {
	$pesanError[] = "Data IMEI GPS Tidak Terdeteksi";		
}
if (trim($jnsbbm)=="") {
	$pesanError[] = "Data BBM Tidak Terdeteksi";		
}
if (trim($harga)=="") {
	$pesanError[] = "Data Harga BBM Tidak Terdeteksi";		
}
if (trim($konsumsi)=="") {
	$pesanError[] = "Data Konsumsi BBM Tidak Terdeteksi";		
}

if (count($pesanError)>=1 ){
		foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$errMsg .="$pesan_tampil\n";	
			$status = 'err_val';
		} 
}else{	

		$sql2  = "INSERT INTO m_unit (nm_unit,nm_sdk,imei_gps,merk,type_unit,no_plat,jenis_bbm,harga_bbm,avg_bbm,kepemilikan,id_ugd,id_sdk,aktif) 
				VALUES ('$nmunit','$nmsdk','$imei','$merk','$type','$noplat','$jnsbbm','$harga','$konsumsi','$sttsugd','$idugd','$idsdk','Y')";
		$res=mysqli_query($dbconn,$sql2);
		
		if($res){
			$errMsg = "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg = "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>

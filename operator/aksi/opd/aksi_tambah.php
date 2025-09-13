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

	$nmopd = anti_injection(trim($_POST['nmopd']));	
	$alamat = anti_injection(trim($_POST['alamat']));
	$telepon = anti_injection(trim($_POST['telepon']));
	$kategori = anti_injection(trim($_POST['kategori']));
	$koordinat = trim($_POST['koordinat']);

	$sqlX = ("SELECT nm_ugd FROM m_ugd WHERE nm_ugd='".$nmopd."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_opd'])==strtolower($nmopd)) {
		$pesanError[] = ucwords(strtolower($nmopd))." terdeteksi sudah ada\nInput data UGD tidak boleh sama";	
	}		
	if (trim($nmopd)=="") {
		$pesanError[] = "Nama UGD Tidak Terdeteksi";		
	}
	if (trim($alamat)=="") {
		$pesanError[] = "Alamat Tidak Terdeteksi";		
	}
	if (trim($telepon)=="") {
		$pesanError[] = "Nomor telepon Tidak Terdeteksi";		
	}
	if (trim($kategori)=="") {
		$pesanError[] = "Kategori UGD Tidak Terdeteksi";		
	}
	if (trim($koordinat)=="") {
		$pesanError[] = "Koordinat UGD Tidak Terdeteksi";		
	}

	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sql2  = "INSERT INTO m_ugd (nm_ugd,alamat,telepon,stts_ugd,koordinat) VALUES ('$nmopd','$alamat','$telepon','$kategori','$koordinat')";
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

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
	
	$idgejala = anti_injection(trim($_POST['idgejala']));
	$nmgejala = anti_injection(trim($_POST['nmgejala']));

	$sqlX = ("SELECT nm_gejala FROM m_gejala WHERE nm_gejala='".$nmgejala."' AND id_gejala <> '".$idgejala."'");			
	$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
	
	$pesanError = array();
	if (strtolower($r['nm_opd'])==strtolower($nmgejala)) {
		$pesanError[] = ucwords(strtolower($nmgejala))." terdeteksi sudah ada\nEdit data gejala symptom tidak boleh sama";	
	}	
	if (trim($idgejala)=="") {
		$pesanError[] = "Data Identitas gejala Tidak Terdeteksi !";		
	}	
	if (trim($nmgejala)=="") {
		$pesanError[] = "Data gejala Tidak Terdeteksi";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	
	
		$sql2  = "UPDATE m_gejala set nm_gejala='$nmgejala' WHERE id_gejala='".$idgejala."'";
		$res=mysqli_query($dbconn,$sql2);			

		if($res){
			$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
			$status = 'ok';
		}else{
			$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
			$status = 'err';
		}
	}			
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);
	
	mysqli_free_result($res);
	mysqli_free_result($resultx);
	mysqli_close($dbconn);
?>

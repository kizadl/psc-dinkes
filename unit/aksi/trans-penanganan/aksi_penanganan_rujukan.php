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

	$idoperator =anti_injection(trim($_POST['idoperator']));
	$idlayanan =anti_injection(trim($_POST['idlayanan']));$idunit =anti_injection(trim($_POST['idunit']));

	$penanganan = anti_injection(trim($_POST['penanganan']));
	$kondisi =anti_injection(trim($_POST['kondisi']));

	$pesanError = array();
	if (trim($idlayanan)=="") {
		$pesanError[] = "Layanan tidak terdeteksi";		
	}
	if (trim($penanganan)=="" && trim($statuslayanan)=="selesai") {
		$pesanError[] = "Penanganan tidak terdeteksi";		
	}
	if (trim($kondisi)=="" && trim($statuslayanan)=="selesai") {
		$pesanError[] = "Kondisi pasien tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

			$sql3  = "UPDATE trans_layanan SET penanganan='$penanganan',stts_pasien='$kondisi',stts_layanan='N',id_operator_ugd_rujuk='$idoperator',id_operator_selesai='$idoperator',ket_selesai='ugd'
					,tgl_penanganan=CURDATE(),jam_penanganan=CURTIME(),tgl_selesai=CURDATE(),jam_selesai=CURTIME(),timeline='selesai' WHERE id_layanan='".$idlayanan."'";
			$res=mysqli_query($dbconn,$sql3);	

			$sql2  = "UPDATE m_unit SET stts_layanan='N' WHERE id_unit='".$idunit."'";
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
	mysqli_close($dbconn);
?>

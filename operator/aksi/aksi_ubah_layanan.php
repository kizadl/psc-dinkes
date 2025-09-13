<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	
	$idoperator = anti_injection(trim($_POST['idoperator']));
	$idlayanan = anti_injection(trim($_POST['idlayanan']));
	$idunit = anti_injection(trim($_POST['idunit']));
	
	$sql  = "UPDATE trans_layanan SET stts_layanan='N',tgl_selesai=CURDATE(),jam_selesai=CURTIME(),id_operator_selesai='$idoperator',ket_selesai='operator' WHERE id_layanan='".$idlayanan."'";
	$res=mysqli_query($dbconn,$sql);
	
	$sql2  = "UPDATE m_unit SET stts_layanan='N' WHERE id_unit='".$idunit."'";
	$res=mysqli_query($dbconn,$sql2);

	if($res){
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
	}else{
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
	}	
	echo json_encode($errMsg);	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>

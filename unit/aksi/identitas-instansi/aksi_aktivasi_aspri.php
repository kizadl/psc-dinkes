<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	

	$statusx = anti_injection(trim($_POST['statusx']));
	
	if ($statusx == "TIDAK AKTIF"){
		$sql  = "UPDATE m_aspri SET dvs_model=null,dvs_uuid=null,dvs_seri=null,status='$statusx'";
		$res=mysqli_query($dbconn,$sql);
	}else{
		$sql2  = "UPDATE m_aspri SET status='$statusx'";
		$res=mysqli_query($dbconn,$sql2);
	}
			
	if($res){
		$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
		$status = 'ok';
	}else{
		$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
		$status = 'err';
	}	
	$data = array('msg1'=>$errMsg,'msg2'=>$status);
	echo json_encode($data);	
	mysqli_free_result($res);
	mysqli_close($dbconn);
?>

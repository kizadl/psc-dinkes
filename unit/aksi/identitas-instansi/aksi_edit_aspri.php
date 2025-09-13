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

	$idinstansi =trim($_POST['idinstansi']);
	$nmbupati = anti_injection(trim($_POST['nmbupati']));
	$jabatan = anti_injection(trim($_POST['jabatan']));
	$username = "aspri";
	$password = md5("aspri");

	$lokasi_akta    = $_FILES['upAspri']['tmp_name'];

	$pesanError = array();
	if (trim($idinstansi)=="") {
		$pesanError[] = "Data instansi tidak terdeteksi";		
	}
	if (trim($nmbupati)=="") {
		$pesanError[] = "Nama asisten tidak boleh kosong";		
	}
	if (trim($jabatan)=="") {
		$pesanError[] = "Jabatan tidak boleh kosong";		
	}
	if (trim($username)=="") {
		$pesanError[] = "Username tidak boleh kosong";		
	}
	if (trim($password)=="") {
		$pesanError[] = "Password tidak boleh kosong";		
	}
	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sqlins = ("SELECT COUNT(id_aspri) AS jmlrecord FROM m_aspri");
		$restps = mysqli_query($dbconn,$sqlins);$sm= mysqli_fetch_assoc($restps);
		$jumrecord = $sm['jmlrecord'];
		if ($jumrecord >= 1){
			$sql2  = "UPDATE m_aspri SET nm_aspri='$nmbupati',jabatan='$jabatan',username='$username',password='$password' WHERE id_aspri='1'";
					$res=mysqli_query($dbconn,$sql2);	
		} else if ($jumrecord <= 0){
			$sql2  = "INSERT INTO m_aspri (id_aspri,nm_aspri,jabatan,username,password) VALUES ('1','$nmbupati','$jabatan','$username','$password')";
			$res=mysqli_query($dbconn,$sql2);
		}

		if(!is_dir("../../data-ttd"))
		mkdir("../../data-ttd",0777,true); 
		$path1 = "../../data-ttd/aspri.png";	
		
		if (!($lokasi_akta)==''){
			move_uploaded_file($lokasi_akta, $path1);
		}

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

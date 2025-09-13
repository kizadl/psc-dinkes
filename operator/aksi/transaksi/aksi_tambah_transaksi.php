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

	$idoperator = anti_injection(trim($_POST['idoperator']));
	$pelapor = strtoupper(anti_injection(trim($_POST['pelapor'])));	
	$telepon = anti_injection(trim($_POST['telepon']));
	$pasien = strtoupper(anti_injection(trim($_POST['pasien'])));
	$jk = strtoupper(anti_injection(trim($_POST['jk'])));$umur = anti_injection(trim($_POST['umur']));
	$ketgawat = anti_injection(trim($_POST['ketgawat']));

	$idugd = anti_injection(trim($_POST['idugd']));
	$koordinat = anti_injection(trim($_POST['koordinatpasien']));
	$idunit = anti_injection(trim($_POST['idunit']));

	$pesanError = array();	
	if (trim($idoperator)=="") {
		$pesanError[] = "Data operator tidak terdeteksi";		
	}
	if (trim($pelapor)=="") {
		$pesanError[] = "Data pelapor tidak terdeteksi";		
	}
	if (trim($telepon)=="") {
		$pesanError[] = "Telepon tidak boleh kosong";		
	}	
	if (trim($pasien)=="") {
		$pesanError[] = "Pasien tidak boleh kosong";		
	}	
	if (trim($jk)=="") {
		$pesanError[] = "Jenis Kelamin tidak boleh kosong";		
	}
	if (trim($umur)=="") {
		$pesanError[] = "Umur pasien tidak boleh kosong";		
	}
	if (trim($ketgawat)=="") {
		$pesanError[] = "Keterangan kegawatdaruratan tidak boleh kosong";		
	}

	if (trim($idugd)=="") {
		$pesanError[] = "Rekomendasi tidak boleh kosong";		
	}
	if (trim($koordinat)=="") {
		$pesanError[] = "Koordinat pelapor tidak boleh kosong";		
	}
	if (trim($idunit)=="") {
		$pesanError[] = "Unit ambulance tidak boleh kosong";		
	}	

	if (count($pesanError)>=1 ){
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$errMsg .="$pesan_tampil\n";	
				$status = 'err_val';
			} 
	}else{	

		$sqlX = ("SELECT id_unit FROM m_unit WHERE id_sdk='".$idunit."'");			
		$resultx = mysqli_query($dbconn,$sqlX);$r= mysqli_fetch_assoc($resultx);
		$idunitX = $r['id_unit'];

		$sqlX2 = ("SELECT koordinat FROM m_ugd WHERE id_ugd='".$idugd."'");			
		$resultx2 = mysqli_query($dbconn,$sqlX2);$s= mysqli_fetch_assoc($resultx2);
		$XYugd = $s['koordinat'];

		$sql2  = "INSERT INTO trans_layanan (nm_pelapor,telp_pelapor,nm_pasien,jk,umur,ket_gawat,koordinat_awal,koordinat_pasien,koordinat_ugd,
				stts_layanan,tgl_layanan,jam_layanan,id_ugd,id_sdk,id_unit,id_operator) 
				VALUES ('$pelapor','$telepon','$pasien','$jk','$umur','$ketgawat','$koordinat','$koordinat','$XYugd','Y',CURDATE(),CURTIME(),'$idugd','$idunit','$idunitX','$idoperator')";
		$res=mysqli_query($dbconn,$sql2);

		$sqlX3 = ("SELECT max(id_layanan) AS idne FROM trans_layanan ORDER BY id_layanan DESC");			
		$resultx3 = mysqli_query($dbconn,$sqlX3);$t= mysqli_fetch_assoc($resultx3);
		$idlayanan = $t['idne'];

		$n=count($_POST['idSymptom']);
		for($i=0;$i<$n;$i++){
			$sqlDP  = "INSERT INTO detail_layanan (id_gejala,id_layanan) VALUES ('".$_POST['idSymptom'][$i]."','$idlayanan')";
			$res=mysqli_query($dbconn,$sqlDP);	
		} 

		$sql3  = "UPDATE m_unit set stts_layanan='Y' WHERE id_sdk='".$idunit."'";
		$res=mysqli_query($dbconn,$sql3);			

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
	
	mysqli_free_result($res);mysqli_free_result($resultx);mysqli_free_result($resultx2);mysqli_free_result($resultx3);
	mysqli_close($dbconn);

?>

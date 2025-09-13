<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,2,2);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Jan";
			break;
		case 2:
			return "Feb";
			break;
		case 3:
			return "Mar";
			break;
		case 4:
			return "Apr";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Agu";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Okt";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Des";
			break;
	}
} 

$tglawal =trim($_POST['tglawal']);$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date('Y-m-d', strtotime($tglakhir));

$jk =trim($_POST['jk']);
$umur =trim($_POST['umur']);
$gawat =trim($_POST['gawat']);
$symptom =trim($_POST['symptom']);
$ugd =trim($_POST['ugd']);

/// 1. satu !
if ($jk == "" AND $umur == "" AND $gawat == "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk != "" AND $umur == "" AND $gawat == "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur != "" AND $gawat == "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.umur = '".$umur."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur == "" AND $gawat != "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.ket_gawat = '".$gawat."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur == "" AND $gawat == "" AND 
	$symptom != "" AND $ugd != ""){
		$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
		p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
		q.nm_ugd
		FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
		LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
		WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
		ORDER BY p.id_layanan ASC");
} 

/// s. dua !
if ($jk != "" AND $umur != "" AND $gawat == "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.umur = '".$umur."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk != "" AND $umur == "" AND $gawat != "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.ket_gawat = '".$gawat."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk != "" AND $umur == "" AND $gawat == "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 
 
if ($jk == "" AND $umur != "" AND $gawat != "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.umur = '".$umur."' AND p.ket_gawat = '".$gawat."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur != "" AND $gawat == "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.umur = '".$umur."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur == "" AND $gawat != "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.ket_gawat = '".$gawat."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

// 3. tiga
if ($jk != "" AND $umur != "" AND $gawat != "" AND 
	$symptom != "" AND $ugd == ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.umur = '".$umur."' AND p.ket_gawat = '".$gawat."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk != "" AND $umur != "" AND $gawat == "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.umur = '".$umur."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk != "" AND $umur == "" AND $gawat != "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.ket_gawat = '".$gawat."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

if ($jk == "" AND $umur != "" AND $gawat != "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.ket_gawat = '".$gawat."' AND p.umur = '".$umur."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

// 4. empat
if ($jk != "" AND $umur != "" AND $gawat != "" AND 
	$symptom != "" AND $ugd != ""){
	$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,
			p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.tgl_selesai,p.jam_selesai,p.id_ugd,p.id_unit,p.id_sdk,p.penanganan,p.stts_pasien,
			q.nm_ugd
			FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
			LEFT JOIN detail_layanan r ON p.id_layanan=r.id_layanan
			WHERE p.stts_layanan='Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' AND p.jk = '".$jk."' AND p.ket_gawat = '".$gawat."' AND p.umur = '".$umur."' AND p.id_ugd = '".$ugd."' AND r.id_gejala='".$symptom."'
			ORDER BY p.id_layanan ASC");
} 

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	
	$idlayanan=$t['id_layanan'];

	$qricbg = ("SELECT q.nm_gejala FROM detail_layanan p LEFT JOIN m_gejala q ON p.id_gejala=q.id_gejala WHERE p.id_layanan='".$idlayanan."'");
	$dbcabang = mysqli_query($dbconn,$qricbg);
	$nmdiagnosa = "";
	while($c=mysqli_fetch_array($dbcabang)){
		$nmdiagnosa.=$c['nm_gejala'].", ";
	}

	if ($t['jk']=="L"){$kelamin = "Laki-laki";} else {$kelamin = "Perempuan";}

	if ($t['penanganan']==NULL){$penanganan = "";} else {$penanganan = $t['penanganan'];}
	if ($t['stts_pasien']==NULL){$sttspasien = "";} else {$sttspasien = ucwords(strtolower($t['stts_pasien']));}
	$row_array = array();
	$row_array['idlayanan']=$idlayanan;
	$row_array['no']=$no;

	$row_array['nmpasien']=ucwords(strtolower($t['nm_pasien']));
	$row_array['kelamin']=$kelamin;
	$row_array['umur']=ucwords(strtolower($t['umur']));
	$row_array['ketgawat']=ucwords(strtolower($t['ket_gawat']));

	$row_array['nmpelapor']=ucwords(strtolower($t['nm_pelapor']));$row_array['telppelapor']=$t['telp_pelapor'];

	$row_array['sttslayanan']=$t['stts_layanan'];

	$row_array['tgllayanan']=tgl_indo($t['tgl_layanan']);
	$row_array['jamlayanan']=date("H:i",strtotime($t['jam_layanan']));
	$row_array['tglselesai']=tgl_indo($t['tgl_selesai']);
	$row_array['jamselesai']=date("H:i",strtotime($t['jam_selesai']));

	$row_array['idugd']=$t['id_ugd'];
	$row_array['idunit']=$t['id_unit'];
	$row_array['idsdk']=$t['id_sdk'];
	$row_array['nmugd']=ucwords(strtolower($t['nm_ugd']));
	$row_array['nmdiagnosa']=$nmdiagnosa;

	$row_array['penanganan']=$penanganan;$row_array['sttspasien']=$sttspasien;
	
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  

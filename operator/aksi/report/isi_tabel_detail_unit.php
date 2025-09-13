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

$idsdk =trim($_POST['idsdk']);
$tglawal =trim($_POST['tglawal']);$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sqlx = ("SELECT p.id,p.time_start,p.lokasi_start,p.koordinat_start,p.time_end,p.koordinat_end,p.lokasi_end,p.durasi,p.jt,p.use_bbm,p.harga_bbm,p.id_unit,p.id_sdk,
		q.nm_unit,q.no_plat,r.nm_ugd
		FROM log_trip_unit p LEFT JOIN m_unit q ON p.id_unit=q.id_unit
		LEFT JOIN m_ugd r ON q.id_ugd=r.id_ugd
		WHERE p.time_start >= '".$tglawal."' AND p.time_start <= '".$tglakhir."' AND p.id_sdk='".$idsdk."'");

$resultx = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($resultx)){
	$no++;	
	$idtrip=$t['id'];$idunit=$t['id_unit'];$idsdk=$t['id_sdk'];
	$nmunit=ucwords(strtolower($t['nm_unit']));
	$nmugd=ucwords(strtolower($t['nm_ugd']));
	$noplat=$t['no_plat'];

	$tglstart = date("Y-m-d",strtotime($t['time_start']));$tglstart = tgl_indo($tglstart);
	$jamstart = date("H:m:s",strtotime($t['time_start']));

	$tglend = date("Y-m-d",strtotime($t['time_end']));$tglend = tgl_indo($tglend);
	$jamend = date("H:m:s",strtotime($t['time_end']));

	$lokasistart=$t['lokasi_start'];$lokasiend=$t['lokasi_end'];
	$koordinatstart=$t['koordinat_start'];$koordinatend=$t['koordinat_end'];

	$durasi=$t['durasi'];$jt=$t['jt'];
	$konsbbm=$t['use_bbm'];

	//$konsumsibbm = (int) filter_var($konsbbm, FILTER_SANITIZE_NUMBER_INT);  

	//$konsbbm=substr($t['use_bbm'],0,strlen($t['use_bbm'])-1);
	$konsbbm = floatval(str_replace(',', '.', str_replace('.', ',', $konsbbm)));
	$rpbbm = number_format($t['harga_bbm'] * $konsbbm);
	
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idtrip']=$idtrip;$row_array['idunit']=$idunit;$row_array['idsdk']=$idsdk;
	$row_array['nmunit']=$nmunit;$row_array['nmugd']=$nmugd;
	$row_array['noplat']=$noplat;
	$row_array['tglstart']=$tglstart;
	$row_array['jamstart']=$jamstart;
	$row_array['tglend']=$tglend;
	$row_array['jamend']=$jamend;
	$row_array['lokasistart']=$lokasistart;$row_array['lokasiend']=$lokasiend;
	$row_array['durasi']=$durasi;$row_array['jt']=$jt;
	$row_array['konsbbm']=$konsbbm;$row_array['rpbbm']=$rpbbm;

	array_push($data,$row_array);
}
echo json_encode($data);
$resultx->close();
$dbconn->close();
?>  

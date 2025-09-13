<?php
error_reporting(0);
include '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');

$tglawal =trim($_POST['tglawal']);$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir =trim($_POST['tglakhir']);$tglakhir = date('Y-m-d', strtotime($tglakhir));

$sql = ("SELECT q.id_unit,q.nm_unit,q.no_plat,r.nm_ugd
		FROM m_unit q LEFT JOIN m_ugd r ON q.id_ugd=r.id_ugd");

$result = mysqli_query($dbconn,$sql);
$data = array();
$no=0;
while($c=mysqli_fetch_array($result)){
	$no++;	

	$sqlx = ("SELECT DISTINCT p.harga_bbm,p.id_unit,p.id_sdk,COUNT(p.id) AS jumtrip,SEC_TO_TIME( SUM( TIME_TO_SEC(p.durasi))) AS jmldurasi,SUM(p.jt) AS jumjarak,SUM(p.use_bbm) AS jumbbm		
			FROM log_trip_unit p WHERE p.time_start >= '".$tglawal."' AND p.time_start <= '".$tglakhir."' AND p.id_unit='".$c['id_unit']."'");
	$resultx = mysqli_query($dbconn,$sqlx);$t= mysqli_fetch_assoc($resultx);

	$idunit=$c['id_unit'];$idsdk=$t['id_sdk'];
	$jumtrip=$t['jumtrip'];

	if ($t['jmldurasi'] == NULL){$durasi="00:00:00";} else {$durasi=substr($t['jmldurasi'],0,8);}

	$jt=number_format($t['jumjarak'],2,',','.');
	$konsbbm=number_format($t['jumbbm'],2,',','.');

	$konsbbm = floatval(str_replace(',', '.', str_replace('.', ',', $konsbbm)));
	$rpbbm = number_format($t['harga_bbm'] * $konsbbm,0,',','.');

	$nmunit=ucwords(strtolower($c['nm_unit']));
	$nmugd=ucwords(strtolower($c['nm_ugd']));
	$noplat=$c['no_plat'];

	$row_array = array();
	$row_array['no']=$no;
	$row_array['jumtrip']=$jumtrip;
	$row_array['idunit']=$idunit;$row_array['idsdk']=$idsdk;
	
	$row_array['nmunit']=$nmunit;$row_array['nmugd']=$nmugd;
	$row_array['noplat']=$noplat;

	$row_array['durasi']=$durasi;
	$row_array['jt']=$jt;
	$row_array['konsbbm']=$konsbbm;$row_array['rpbbm']=$rpbbm;

	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$resultx->close();
$dbconn->close();
?>  

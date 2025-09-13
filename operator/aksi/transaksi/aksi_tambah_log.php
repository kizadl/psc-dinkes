<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$idsdk = trim($_POST['idsdk']);
$sqlX = ("SELECT jenis_bbm,harga_bbm,id_unit FROM m_unit WHERE id_sdk='".$idsdk."'");			
		$resultx = mysqli_query($dbconn,$sqlX);$q= mysqli_fetch_assoc($resultx);
		$jenisbbm = $q['jenis_bbm'];$hargabbm = $q['harga_bbm'];$idunit = $q['id_unit'];

	$sqlX2 = ("SELECT time_start FROM log_trip_unit WHERE id_sdk='".$idsdk."' AND time_start = '".$_POST['sa0']."'");			
	$resultx2 = mysqli_query($dbconn,$sqlX2);$s= mysqli_fetch_assoc($resultx2);
	$timestart = $s['time_start'];

	if ($timestart != $_POST['sa0']){

		$jt=substr($_POST['sa9'],0,strlen($_POST['sa9'])-2);
		$jt = floatval(str_replace(',', '.', str_replace('.', ',', $jt)));

		$finaljt=substr($_POST['sa10'],0,strlen($_POST['sa10'])-2);
		$finaljt = floatval(str_replace(',', '.', str_replace('.', ',', $finaljt)));

		$avgspd=substr($_POST['sa11'],0,strlen($_POST['sa11'])-4);
		$avgspd = floatval(str_replace(',', '.', str_replace('.', ',', $avgspd)));

		$maxspd=substr($_POST['sa12'],0,strlen($_POST['sa12'])-4);
		$maxspd = floatval(str_replace(',', '.', str_replace('.', ',', $maxspd)));

		$bbm=substr($_POST['sa14'],0,strlen($_POST['sa14'])-1);
		$bbm = floatval(str_replace(',', '.', str_replace('.', ',', $bbm)));

		$sqlDP  = "INSERT INTO log_trip_unit (time_start,lokasi_start,koordinat_start,time_end,lokasi_end,koordinat_end,
				durasi,total_time,mesin_on,jt,final_jt,avg_speed,max_speed,msg_count,use_bbm,jenis_bbm,harga_bbm,id_sdk,id_unit) 
				VALUES ('".$_POST['sa0']."','".$_POST['sa1']."','".$_POST['sa2']."','".$_POST['sa3']."','".$_POST['sa4']."','".$_POST['sa5']."',
				'".$_POST['sa6']."','".$_POST['sa7']."','".$_POST['sa8']."','".$jt."','".$finaljt."','".$avgspd."','".$maxspd."',
				'".$_POST['sa13']."','".$bbm."','$jenisbbm','$hargabbm','$idsdk','$idunit')";

		$res=mysqli_query($dbconn,$sqlDP);	
	}
/*			
$n=count($_POST['sa0']);
for($i=0;$i<$n;$i++){

	$sqlX2 = ("SELECT time_start FROM log_trip_unit WHERE id_sdk='".$idsdk."' AND time_start = '".$_POST['sa0'][$i]."'");			
	$resultx2 = mysqli_query($dbconn,$sqlX2);$s= mysqli_fetch_assoc($resultx2);
	$timestart = $s['time_start'];

	if ($timestart != $_POST['sa0'][$i]){

		$jt=substr($_POST['sa9'][$i],0,strlen($_POST['sa9'][$i])-2);
		$jt = floatval(str_replace(',', '.', str_replace('.', ',', $jt)));

		$finaljt=substr($_POST['sa10'][$i],0,strlen($_POST['sa10'][$i])-2);
		$finaljt = floatval(str_replace(',', '.', str_replace('.', ',', $finaljt)));

		$avgspd=substr($_POST['sa11'][$i],0,strlen($_POST['sa11'][$i])-4);
		$avgspd = floatval(str_replace(',', '.', str_replace('.', ',', $avgspd)));

		$maxspd=substr($_POST['sa12'][$i],0,strlen($_POST['sa12'][$i])-4);
		$maxspd = floatval(str_replace(',', '.', str_replace('.', ',', $maxspd)));

		$bbm=substr($_POST['sa14'][$i],0,strlen($_POST['sa14'][$i])-1);
		$bbm = floatval(str_replace(',', '.', str_replace('.', ',', $bbm)));

		$sqlDP  = "INSERT INTO log_trip_unit (time_start,lokasi_start,koordinat_start,time_end,lokasi_end,koordinat_end,
				durasi,total_time,mesin_on,jt,final_jt,avg_speed,max_speed,msg_count,use_bbm,jenis_bbm,harga_bbm,id_sdk,id_unit) 
				VALUES ('".$_POST['sa0'][$i]."','".$_POST['sa1'][$i]."','".$_POST['sa2'][$i]."','".$_POST['sa3'][$i]."','".$_POST['sa4'][$i]."','".$_POST['sa5'][$i]."',
				'".$_POST['sa6'][$i]."','".$_POST['sa7'][$i]."','".$_POST['sa8'][$i]."','".$jt."','".$finaljt."','".$avgspd."','".$maxspd."',
				'".$_POST['sa13'][$i]."','".$bbm."','$jenisbbm','$hargabbm','$idsdk','$idunit')";

		$res=mysqli_query($dbconn,$sqlDP);	
	}
} 
*/

//mysqli_free_result($res);mysqli_free_result($resultx);mysqli_free_result($resultx2);
mysqli_close($dbconn);
?>
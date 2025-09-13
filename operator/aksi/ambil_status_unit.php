<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
$idunitx= trim($_POST['idunitx']);

$sqlx = ("SELECT p.stts_layanan FROM m_unit p WHERE id_sdk='".$idunitx."'");
$result = mysqli_query($dbconn,$sqlx);
$data = array();
while($t=mysqli_fetch_array($result)){
	$row_array = array();
	$row_array['sttslayanan']=$t['stts_layanan'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
 ?>
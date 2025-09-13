<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idinstansi= trim($_POST['idinstansi']);

$sqlx = ("SELECT p.id_operator,p.nm_operator,p.username,p.akses,p.blokir,p.id_ugd,q.nm_ugd 
		FROM m_operator p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd WHERE p.aktif='Y'");			
$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;	 	
	if ($t['blokir']=='Y'){$warna='danger';$nmblokir="Blocked";} else if ($t['blokir']=='N'){$warna='success';$nmblokir="Unbloked";}
	
	$row_array = array();
	$row_array['no']=$no;$row_array['warna']=$warna;$row_array['nmblokir']=$nmblokir;
	$row_array['idoperator']=$t['id_operator'];$row_array['nmoperator']=ucwords(strtolower($t['nm_operator']));
	$row_array['nmugd']=ucwords(strtolower($t['nm_ugd']));
	$row_array['username']=$t['username'];
	$row_array['akses']=$t['akses'];
	$row_array['blokir']=$t['blokir'];	
	$row_array['idugd']=$t['id_ugd'];
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();
$dbconn->close();
?>  

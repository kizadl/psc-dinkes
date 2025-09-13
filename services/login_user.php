<?php
error_reporting(0);
include 'config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

function anti_injection($data){
  global $dbconn;
  $filter = mysqli_real_escape_string($dbconn,stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}	

if(isset($_POST['checkUser']))
{	
	$userName = anti_injection(trim($_POST['uid']));
	$pwd=anti_injection(trim($_POST['pwrd']));
	$pwd2 = md5($pwd);
		$stmt = $mysqli->prepare("SELECT p.id_operator,p.username,p.password,p.nm_operator,p.akses,p.blokir,p.login_time,p.id_instansi,p.id_ugd
								FROM m_operator p WHERE p.username=?");								
		$stmt->bind_param('s',$userName);
		$stmt->execute();
		$stmt->store_result();
		$row = $stmt->num_rows;
		
		if($row<1)
		{
			echo "<script>alert('Login gagal !');</script>";
		}
		else
		{
			$stmt->bind_result($idoperator,$username,$pw,$nmoperator,$akses,$blokir,$logintime,$idinstansi,$idugd);
			$rek = $stmt->fetch();

			if($pw!==$pwd2){
				
				if($logintime >= 3){
					
					echo "<script>alert('Status akun Anda terblokir, hubungi administrator untuk aktivasi kembali !');</script>";
					
					$sql4  = "UPDATE m_operator SET blokir='Y',login_time='0' WHERE username='".$userName."'";
					$res=mysqli_query($dbconn,$sql4);

				} else {
					$logintime2 = $logintime + 1;
					$sql2  = "UPDATE m_operator set login_time='$logintime2' WHERE username='".$userName."'";
					$res=mysqli_query($dbconn,$sql2);
					echo "<script>alert('Login gagal !');</script>";
				}
			} else if($blokir=="Y"){
				echo "<script>alert('Status akun Anda terblokir, hubungi administrator untuk aktivasi kembali !');</script>";
			}else{	

				$sql3  = "UPDATE m_operator SET login_time='0' WHERE username='".$userName."'";
				$res=mysqli_query($dbconn,$sql3);

				if ($akses == "administrator"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']); 
					unset($_SESSION['IDUGD']); 
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					$_SESSION['IDUGD'] = $idugd;
					
					echo "	<script>
							document.location.href='operator/monitoring.html';
							</script>";
				}
				if ($akses == "operator"){
					session_start();
					unset($_SESSION['IDOPERATOR']); 
					unset($_SESSION['USERNAME']); 
					unset($_SESSION['NMOPERATOR']);
					unset($_SESSION['AKSES']);
					unset($_SESSION['IDINSTANSI']);
					unset($_SESSION['IDUGD']); 
					
					$_SESSION['IDOPERATOR'] = $idoperator;
					$_SESSION['USERNAME'] = $username;
					$_SESSION['NMOPERATOR'] = $nmoperator;
					$_SESSION['AKSES'] = $akses;
					$_SESSION['IDINSTANSI'] = $idinstansi;
					$_SESSION['IDUGD'] = $idugd;
					
					echo "	<script>
							document.location.href='unit/home.html';
							</script>";
				}				
			}
		}	
	
}else{
	echo "<script>document.location.href='login.html'</script>";
}	
	
?>
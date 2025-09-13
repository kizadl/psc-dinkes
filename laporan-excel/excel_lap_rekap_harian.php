<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap-pelayanan.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Bimatech"); 

error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}
function getBulan($bln){
	switch ($bln){
		case 1: 
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
} 
$tglsekarang = tgl_indo(date("Y-m-d"));

$idugd =trim($_GET['idugd']);$tglawal =trim($_GET['tglawal']);$tglakhir =trim($_GET['tglakhir']);
$tglawal = date('Y-m-d', strtotime($tglawal));
$tglakhir = date('Y-m-d', strtotime($tglakhir));

$tanggalawal = tgl_indo($tglawal);
$tanggalakhir = tgl_indo($tglakhir);

$qriserver = ("SELECT nm_ugd FROM m_ugd WHERE id_ugd='".$idugd."'");
$dbserver = mysqli_query($dbconn,$qriserver);$s= mysqli_fetch_assoc($dbserver);
$nmugd = strtoupper($s['nm_ugd']);
mysqli_free_result($dbserver);
?>
<center><?php echo $nmugd;?></center>
<center>LAPORAN PELAYANAN UGD</center>
<center><?php echo $tanggalawal;?> s/d <?php echo $tanggalakhir;?></center>

                 <table>
				  <thead>
                    <tr>
					  <th rowspan=2 style="background:#000;color:#fff;height:25px;width:50px"><center>&nbsp;&nbsp;No&nbsp;&nbsp;</center></th>
					  <th rowspan=2 style="background:#222;color:#fff;height:25px;width:180px"><center>Tanggal</center></th>
					  <th colspan=3 style="background:#000;color:#fff;height:25px;width:430px"><center>Identitas Pasien</center></th>	
					  <th colspan=2 style="background:#000;color:#fff;height:25px;"><center>Rujukan / Gejala Symptom</center></th>
					  <th rowspan=2 style="background:#000;color:#fff;height:25px;width:400px"><center>Penanganan Medis</center></th>
					  <th rowspan=2 style="background:#444;color:#fff;height:25px;width:150px"><center>Keterangan</center></th>
                    </tr>				  
                    <tr>
					  <th style="background:#222;color:#fff;height:20px;width:150px"><center>Nama</center></th>
                      <th style="background:#222;color:#fff;height:20px;width:140px"><center>Umur</center></th>		
					  <th style="background:#222;color:#fff;height:20px;width:140px"><center>Kegawatan</center></th>		
					  <th style="background:#444;color:#fff;height:20px;width:150px"><center>Rujukan</center></th>
                      <th style="background:#444;color:#fff;height:20px;width:600px"><center>Gejala Symptom</center></th>		
                    </tr>
				  </thead>
				  <tbody>
<?php
$sqlx = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.jk,p.umur,p.ket_gawat,p.stts_layanan,p.tgl_layanan,p.jam_layanan,
	p.tgl_penanganan_awal,p.jam_penanganan_awal,p.tgl_penanganan,p.jam_penanganan,
	p.id_ugd,p.id_ugd_rujuk,p.id_unit,p.penanganan_awal,p.penanganan,p.timeline,p.stts_rujuk,p.stts_pasien,
	q.nm_ugd AS nmugdrujukan,r.nm_ugd AS nmugddirujuk
	FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd_rujuk=q.id_ugd
	LEFT JOIN m_ugd r ON p.id_ugd=r.id_ugd
	WHERE p.id_ugd='".$idugd."' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."'
	OR p.id_ugd_rujuk='".$idugd."' AND p.stts_rujuk = 'Y' AND p.tgl_layanan >= '".$tglawal."' AND p.tgl_layanan <= '".$tglakhir."' ORDER BY p.id_layanan ASC");

$result = mysqli_query($dbconn,$sqlx);
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;
	$idlayanan=$t['id_layanan'];
	$nmpasien = ucwords(strtolower($t['nm_pasien']));
	$umur=$t['umur'];$ketgawat=ucwords(strtolower($t['ket_gawat']));

	$qricbg = ("SELECT q.nm_gejala FROM detail_layanan p LEFT JOIN m_gejala q ON p.id_gejala=q.id_gejala WHERE p.id_layanan='".$idlayanan."'");
	$dbcabang = mysqli_query($dbconn,$qricbg);
	$nmdiagnosa = "";
	while($c=mysqli_fetch_array($dbcabang)){
		$nmdiagnosa.=$c['nm_gejala'].", ";
	}

	$waktupenangananawal = tgl_indo($t['tgl_penanganan_awal'])." - ".date('H:m',strtotime($t['jam_penanganan_awal']));
	$waktupenanganan = tgl_indo($t['tgl_penanganan'])." - ".date('H:i',strtotime($t['jam_penanganan']));

	if ($t['jk']=="L"){$kelamin = "Laki-laki";} else {$kelamin = "Perempuan";}

	if ($t['penanganan_awal']==NULL){$penangananawal = "";} else {$penangananawal = $waktupenangananawal ."<br>".$t['penanganan_awal'];}
	if ($t['penanganan']==NULL){$penanganan = "";} else {$penanganan = $waktupenanganan."<br>".$t['penanganan'];}

	if ($t['stts_pasien']==NULL){$sttspasien = "";} else {$sttspasien = ucwords(strtolower($t['stts_pasien']));}

	if ($t['stts_rujuk']=="Y" AND $t['id_ugd_rujuk']!=$idugd){
		$nmugdrujukan = $t['nmugdrujukan'];
	} else if ($t['stts_rujuk']=="Y" AND $t['id_ugd_rujuk']==$idugd){
		$nmugdrujukan = $t['nmugddirujuk'];	
	} else {
		$nmugdrujukan = "";
	}
		
	mysqli_free_result($dbcabang);
echo "	
	<tr style='height:25px;'>
       <td align='center' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$no
		</td>	
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$waktupenanganan
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmpasien
		</td>
		<td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$kelamin / $umur
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$ketgawat
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmugdrujukan
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$nmdiagnosa
		</td>
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;'>
			$penanganan
		</td>		
        <td align='left' style='vertical-align:middle;border: 1px dotted #999;padding: 3px 5px;background:#FFFAF0;'>
			$sttspasien
		</td>
	</tr>";
} 
	
mysqli_free_result($result);mysqli_close($dbconn); 
?>  
				  </tbody>
                  </table><br>
Cetak Tanggal <?php echo $tglsekarang;?>

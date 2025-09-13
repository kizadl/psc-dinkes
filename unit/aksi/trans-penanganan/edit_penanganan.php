<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');	

$idlayanan = trim($_POST['idlayanan']);

$sqltps = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.umur,p.jk,p.stts_layanan,p.tgl_layanan,p.jam_layanan,p.id_ugd,p.id_unit,p.penanganan,p.stts_pasien,q.nm_ugd 
    FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
    WHERE p.id_layanan='".$idlayanan."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$idlayanan = $sm['id_layanan'];
$idunit = $sm['id_unit'];
$idugd = $sm['id_ugd'];

if ($sm['jk']=="L"){$kelamin = "Laki-laki";} else {$kelamin = "Perempuan";}
$umur = $sm['umur'];

$tgllayanan = $sm['tgl_layanan'];$tgllayanan = date('d-m-Y', strtotime($tgllayanan));
$jamlayanan = $sm['jam_layanan'];$jamlayanan = date('H:i', strtotime($jamlayanan));

$sttslayanan = $sm['stts_layanan'];

$nmpelapor = strtoupper($sm['nm_pelapor']);$telppelapor = $sm['telp_pelapor'];
$nmpasien = strtoupper($sm['nm_pasien']);//$penyakit = strtoupper($sm['penyakit']);

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Penanganan Pasien</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input isian data penanganan pasien dibawah ini</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <input type="text" class="form-control form-control-sm" id="txtidlayananE" value="<?php echo $idlayanan?>" disabled
        style="display:none">

    <input type="text" class="form-control form-control-sm" id="txtidlunitE" value="<?php echo $idunit?>" disabled
        style="display:none">

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-3 mb-0">
            <p class="fs--1 mb-0 text-600"><b><?php echo $nmpasien?></b><br><?php echo $kelamin?> / <?php echo $umur?> 
            <br>CP : <?php echo $nmpelapor?> (<?php echo $telppelapor?>)
            <br>IN : <?php echo $tgllayanan?>  <?php echo $jamlayanan?>
            </p>
        </div>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" id="cbostatuspelayananE" onchange="tampilkanLayanan()">
            <option value="" selected>Pilih Status Penanganan</option>
            <option value="awal">Penanganan Medis Awal</option>
            <option value="rujukan">Dirujuk</option>
            <option value="selesai">Layanan Selesai</option>
        </select>
        <label for="cbostatuspelayananE">Pilih Status Penanganan</label>
    </div>

    <div id="area-penanganan-awal" style="display:none">
        <div class="form-floating mb-3">
            <input type="text" class="form-control form-control-sm" id="txtpenangananAwalE" value=""
                placeholder="Penanganan medis awal" autocomplete="off">
            <label for="txtpenangananAwalE">Penanganan Medis Awal</label>
        </div>
    </div>

    <div id="area-penanganan" style="display:none">
        <div class="form-floating mb-3">
            <input type="text" class="form-control form-control-sm" id="txtpenangananE" value=""
                placeholder="Penanganan medis" autocomplete="off">
            <label for="txtpenangananE">Penanganan Medis</label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select form-select-sm js-choice px-3" id="cbokondisipasienE">
                <option value="" selected>Pilih Kondisi Pasien</option>
                <option value="rawat jalan">Rawat Jalan</option>
                <option value="rawat inap">Rawat Inap</option>
                <option value="pulang">Pulang</option>
                <option value="meninggal">Meninggal Dunia</option>
            </select>
            <label for="cbokondisipasienE">Kondisi Pasien</label>
        </div>
    </div>

    <div id="area-rujukan" style="display:none">
        <div class="form-floating mb-3">
            <input type="text" class="form-control form-control-sm" id="txtpenangananrujukE" value=""
                placeholder="Penanganan medis" autocomplete="off">
            <label for="txtpenangananrujukE">Penanganan Medis</label>
        </div>

        <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" id="cboUGDrujukE" size="1" required="required"
			data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih UGD</option>
            <?php
							$qrikec = ("SELECT id_ugd,nm_ugd FROM m_ugd WHERE id_ugd <> '".$idugd."' AND stts_ugd='rsud'");								
							$liskec = mysqli_query($dbconn,$qrikec);									
							while($j=mysqli_fetch_array($liskec)){
								echo "<option value=\"".$j['id_ugd']."\">".$j['nm_ugd']."</option>";
							}mysqli_free_result($liskec);mysqli_close($dbconn);
						?>
        </select>
        <label for="cboUGDrujukE">UGD Rujukan</label>
    </div>

    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" id="cmdbatalSuratE" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanSuratE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#area-penanganan-awal").css("display","none");
    $("#area-penanganan").css("display","none");
    $("#area-rujukan").css("display","none");
});

function bersihkanLayanan(){
    $("#txtpenangananAwalE").val("");$("#txtpenangananE").val("");$("#txtpenangananrujukE").val("");
    $("#cboUGDrujukE").val("").trigger("change");
}

function tampilkanLayanan(){
    bersihkanLayanan();
    var statuslayanan = $("#cbostatuspelayananE").val();
    if (statuslayanan == "awal"){  
        $("#area-penanganan").css("display","none");
        $("#area-rujukan").css("display","none");
        $("#area-penanganan-awal").fadeIn();
    } else if (statuslayanan == "selesai"){
        $("#area-penanganan-awal").css("display","none");
        $("#area-rujukan").css("display","none");
        $("#area-penanganan").fadeIn();
    } else if (statuslayanan == "rujukan"){
        $("#area-penanganan-awal").css("display","none");
        $("#area-penanganan").css("display","none");
        $("#area-rujukan").fadeIn();
    } else if (statuslayanan == ""){ 
        $("#area-penanganan-awal").css("display","none");
        $("#area-penanganan").css("display","none");
        $("#area-rujukan").css("display","none");
    }
}

$("#cmdsimpanSuratE").click(function() {
    var idoperator = $("#lbleditor").val();
    var idlayanan = $('#txtidlayananE').val();var idunit = $('#txtidlunitE').val();

    var statuslayanan = $("#cbostatuspelayananE").val();
    //// penanganan awal ////
    var penangananawal = $('#txtpenangananAwalE').val();
    //// penanganan rujukan ////
    var penangananrujukan = $('#txtpenangananrujukE').val();
    var idugdrujukan = $('#cboUGDrujukE').val();
    //// penanganan selesai ////
    var penanganan = $('#txtpenangananE').val();
    var kondisi = $('#cbokondisipasienE').val();

    var data = new FormData();
    data.append('idlayanan', idlayanan);data.append('idoperator', idoperator);
    data.append('idunit', idunit);

    data.append('statuslayanan', statuslayanan);
    data.append('penangananawal', penangananawal);
    data.append('penangananrujukan', penangananrujukan); data.append('idugdrujukan', idugdrujukan);
    data.append('penanganan', penanganan);data.append('kondisi', kondisi);

    if (statuslayanan.length <= 0) {
        $('#cbostatuspelayananE').focus();
        alert('Status penanganan pasien masih kosong')
    } else if (penangananawal.length <= 0 && statuslayanan == "awal") {
        $('#txtpenangananAwalE').focus();
        alert('Penanganan medis awal pasien masih kosong')
    } else if (penangananrujukan.length <= 0 && statuslayanan == "rujukan") {
        $('#txtpenangananrujukE').focus();
        alert('Penanganan medis masih kosong') 
    } else if (idugdrujukan.length <= 0 && statuslayanan == "rujukan") {
        $('#cboUGDrujukE').focus();
        alert('UGD rujukan masih kosong') 
    } else if (penanganan.length <= 0 && statuslayanan == "selesai") {
        $('#txtpenangananE').focus();
        alert('Penanganan medis masih kosong')
    } else if (kondisi.length <= 0 && statuslayanan == "selesai") {
        $('#cbokondisipasienE').focus();
        alert('Kondisi pasien masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/trans-penanganan/aksi_penanganan.php',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#cmdsimpanSuratE").attr("disabled", "disabled");
                $("#cmdbatalSuratE").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modEditDataLarge').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiInputPenanganan();
                    isiJumlahPelayanan();
                    //socket.emit('kirim surat', idinstansi);
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdsimpanSuratE").removeAttr("disabled");
                    $("#cmdbatalSuratE").removeAttr("disabled");
                } else {
                    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdsimpanSuratE").removeAttr("disabled");
                    $("#cmdbatalSuratE").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdsimpanSuratE").removeAttr("disabled");
                $("#cmdbatalSuratE").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
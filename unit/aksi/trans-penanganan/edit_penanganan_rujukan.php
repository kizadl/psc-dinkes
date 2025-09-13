<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
date_default_timezone_set('Asia/Jakarta');	

$idlayanan = trim($_POST['idlayanan']);

$sqltps = ("SELECT p.id_layanan,p.nm_pelapor,p.telp_pelapor,p.nm_pasien,p.umur,p.jk,p.stts_layanan,p.tgl_penanganan_rujuk,p.jam_penanganan_rujuk,p.id_ugd,p.id_unit,p.penanganan,p.stts_pasien,q.nm_ugd 
    FROM trans_layanan p LEFT JOIN m_ugd q ON p.id_ugd=q.id_ugd
    WHERE p.id_layanan='".$idlayanan."'");
$restps = mysqli_query($dbconn,$sqltps);$sm= mysqli_fetch_assoc($restps);
$idlayanan = $sm['id_layanan'];
$idunit = $sm['id_unit'];
$idugd = $sm['id_ugd'];

if ($sm['jk']=="L"){$kelamin = "Laki-laki";} else {$kelamin = "Perempuan";}
$umur = $sm['umur'];

$tgllayanan = $sm['tgl_penanganan_rujuk'];$tgllayanan = date('d-m-Y', strtotime($tgllayanan));
$jamlayanan = $sm['jam_penanganan_rujuk'];$jamlayanan = date('H:i', strtotime($jamlayanan));

$sttslayanan = $sm['stts_layanan'];

$nmugd = strtoupper($sm['nm_ugd']);
$nmpasien = strtoupper($sm['nm_pasien']);//$penyakit = strtoupper($sm['penyakit']);

mysqli_free_result($restps);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Input Penanganan Pasien Rujukan</h5>
        <p class="fs--1 mb-0 text-white">Silahkan input isian data penanganan pasien rujukan dibawah ini</p>
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
                <br><?php echo $nmugd?>
                <br><?php echo $tgllayanan?> <?php echo $jamlayanan?>
            </p>
        </div>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtpenangananERJ" value=""
            placeholder="Penanganan medis" autocomplete="off">
        <label for="txtpenangananERJ">Penanganan Medis</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select form-select-sm js-choice px-3" id="cbokondisipasienERJ">
            <option value="" selected>Pilih Kondisi Pasien</option>
            <option value="rawat jalan">Rawat Jalan</option>
            <option value="rawat inap">Rawat Inap</option>
            <option value="pulang">Pulang</option>
            <option value="meninggal">Meninggal Dunia</option>
        </select>
        <label for="cbokondisipasienERJ">Kondisi Pasien</label>
    </div>

</div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" id="cmdbatalSuratERJ" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdsimpanSuratERJ">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">

$("#cmdsimpanSuratERJ").click(function() {
    var idoperator = $("#lbleditor").val();
    var idlayanan = $('#txtidlayananE').val();
    var idunit = $('#txtidlunitE').val();

    var penanganan = $('#txtpenangananERJ').val();
    var kondisi = $('#cbokondisipasienERJ').val();

    var data = new FormData();
    data.append('idlayanan', idlayanan);
    data.append('idoperator', idoperator);
    data.append('idunit', idunit);

    data.append('penanganan', penanganan);
    data.append('kondisi', kondisi);

    if (penanganan.length <= 0) {
        $('#txtpenangananERJ').focus();
        alert('Penanganan medis masih kosong')
    } else if (kondisi.length <= 0) {
        $('#cbokondisipasienERJ').focus();
        alert('Kondisi pasien masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/trans-penanganan/aksi_penanganan_rujukan.php',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#cmdsimpanSuratERJ").attr("disabled", "disabled");
                $("#cmdbatalSuratERJ").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modEditDataLarge').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiInputRujukan();
                    isiJumlahPelayanan();
                    //socket.emit('kirim surat', idinstansi);
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdsimpanSuratERJ").removeAttr("disabled");
                    $("#cmdbatalSuratERJ").removeAttr("disabled");
                } else {
                    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdsimpanSuratERJ").removeAttr("disabled");
                    $("#cmdbatalSuratERJ").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdsimpanSuratERJ").removeAttr("disabled");
                $("#cmdbatalSuratERJ").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
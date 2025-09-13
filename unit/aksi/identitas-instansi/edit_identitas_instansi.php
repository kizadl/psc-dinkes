<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idinstansi = trim($_POST['idinstansi']);
$sqlins = ("SELECT nm_instansi,alamat,kota,email FROM m_instansi WHERE id_instansi='".$idinstansi."'");
$restps = mysqli_query($dbconn,$sqlins);$sm= mysqli_fetch_assoc($restps);
$nminstansi = $sm['nm_instansi'];
$alamat = $sm['alamat'];$kota = $sm['kota'];$email = $sm['email'];
mysqli_free_result($restps);mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Identitas Instansi</h5>
        <p class="fs--1 mb-0 text-white">Silahkan mengubah data identitas instansi</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmskpd" value="<?php echo $nminstansi?>"
            placeholder="Nama instansi" maxlength="100" autocomplete="off">
        <label for="txtnmskpd">Nama Instansi</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtalamatskpd" value="<?php echo $alamat?>"
            placeholder="Alamat Lengkap" maxlength="150" autocomplete="off">
        <label for="txtalamatskpd">Alamat Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtkotaskpd" value="<?php echo $kota?>"
            placeholder="Kota" maxlength="50" autocomplete="off">
        <label for="txtkotaskpd">Kota</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtemailskpd" value="<?php echo $email?>"
            placeholder="Kota" maxlength="100" autocomplete="off">
        <label for="txtemailskpd">Email</label>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanIdentitasSKPD">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#txtnmskpd").focus();
});

$("#cmdSimpanIdentitasSKPD").click(function() {
    var idinstansi = $('#lblidinstansi').val();
    var nmskpd = $('#txtnmskpd').val();
    var alamat = $('#txtalamatskpd').val();
    var kota = $('#txtkotaskpd').val();
    var email = $('#txtemailskpd').val();

    var data = new FormData();
    data.append('idinstansi', idinstansi);
    data.append('nmskpd', nmskpd);
    data.append('alamat', alamat);
    data.append('kota', kota);
    data.append('email', email);

    if (nmskpd.length <= 0) {
        $('#txtnmskpd').focus();
        alert('Nama instansi SKPD masih kosong')
    } else if (alamat.length <= 0) {
        $('#txtalamatskpd').focus();
        alert('Alamat masih kosong')
    } else if (kota.length <= 0) {
        $('#txtkotaskpd').focus();
        alert('Kota masih kosong')
    } else if (email.length <= 0) {
        $('#txtemailskpd').focus();
        alert('Email masih kosong')
    } else {
        if (confirm("Setelah proses perubahan data, otomatis akan keluar aplikasi.\nLanjutkan proses ?") == true) {
            $.ajax({
                type: "POST",
                url: 'aksi/identitas-instansi/aksi_edit_instansi.php',
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(e) {
                    $("#loading").fadeIn();
                    document.body.style.cursor = "wait";
                    $("#cmdSimpanIdentitasSKPD").attr("disabled", "disabled");
                },
                success: function(resp) {
                    document.body.style.cursor = "default";
                    if (resp.msg2 == 'ok') {
                        $("#loading").fadeOut("slow");
                        $("#cmdSimpanIdentitasSKPD").removeAttr("disabled");
                        $("#ToastSukses").toast("show");
                        setTimeout(function() {
                            $('#modEditData').modal('hide');
                            window.open("logout.html", "_self");
                        }, 1000);
                    } else if (resp.msg2 == 'err_val') {
                        $("#loading").fadeOut("slow");
                        $("#ToastGagal").toast("show");
                        $("#cmdSimpanIdentitasSKPD").removeAttr("disabled");
                    } else {
                        $("#loading").fadeOut("slow");
                        $("#ToastGagal").toast("show");
                        $("#cmdSimpanIdentitasSKPD").removeAttr("disabled");
                    }
                },
                error: function() {
                    document.body.style.cursor = "default";
                    $("#loading").fadeOut("slow");
                    alert('Koneksi bermasalah periksa internet');
                    $("#cmdSimpanIdentitasSKPD").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
            });
        };
    };
});
</script>
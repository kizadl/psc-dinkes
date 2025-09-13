<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Tambah Operator</h5>
        <p class="fs--1 mb-0 text-white">Silahkan menambahkan data operator</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">

    <div class="mb-3">
        <label for="txtnmoperator">Nama Operator</label>
        <input class="form-control" type="text" id="txtnmoperator" maxlength="50" autocomplete="off"
            style="font-size:13px;" />
    </div>

    <div class="mb-3">
        <label for="cboakses">Hak Akses</label>
        <select class="form-select js-choice" size="1" name="cboakses" id="cboakses"
            data-options='{"removeItemButton":true,"placeholder":true}' style="font-size:14px;">
            <option value=""></option>
            <option value="administrator">Administrator</option>
            <option value="operator">Operator</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">RSD / Puskesmas / Klinik</label>
        <div id="selectParentRekom" class="fs--1">
            <select class="form-select" id="cborekom" data-placeholder="Pilih UGD" required="required"
                data-options='{"removeItemButton":true,"placeholder":true}' style="width:68vh;overflow:hidden;">
                <option value="" selected>Pilih UGD</option>
                <?php
                    $qrikec = ("SELECT id_ugd,nm_ugd FROM m_ugd WHERE aktif='Y'");								
                    $liskec = mysqli_query($dbconn,$qrikec);									
                    while($j=mysqli_fetch_array($liskec)){
                        echo "<option value=\"".$j['id_ugd']."\">".$j['nm_ugd']."</option>";
                    }mysqli_free_result($liskec);mysqli_close($dbconn);
				?>
            </select>
        </div>
    </div>

</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanOperator">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#txtnmoperator").val("");
    $("#cboakses").val("");

    $('#cborekom').select2({
        dropdownParent: $('#selectParentRekom'),
        width: 'resolve',
        theme: 'bootstrap4'
    });
});

$("#cmdSimpanOperator").click(function() {
    var idinstansi = $('#lblidinstansi').val();
    var akses = $('#cboakses').val();
    var idugd = $('#cborekom').val();
    var nmuser = $('#txtnmoperator').val();

    if (nmuser.length <= 0) {
        $('#txtnmoperator').focus();
        alert('Nama operator masih kosong')
    } else if (akses.length <= 0) {
        $('#cboakses').focus();
        alert('Akses masih kosong')
    } else if (idugd.length <= 0) {
        $('#cborekom').focus();
        alert('UGD masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/operator/aksi_tambah.php',
            data: {nmuser: nmuser,akses: akses,idugd: idugd,idinstansi: idinstansi},
            dataType: "json",
            beforeSend: function(e) {
                $("#cmdSimpanOperator").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modTambahData').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiMasterOperator();
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdSimpanOperator").removeAttr("disabled");
                } else {
                    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdSimpanOperator").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanOperator").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
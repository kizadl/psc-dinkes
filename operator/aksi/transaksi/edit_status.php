<?php
$idunit= trim($_POST['idunit']);$idsdk= trim($_POST['idsdk']);
$sttslayanan= trim($_POST['sttslayanan']);
$nmunit= trim($_POST['nmunit']);$nmugd= trim($_POST['nmugd']);
if ($sttslayanan == "Y"){$nmlayanan = "ON PROSES";$nmubah = "FINISH";} else {$nmlayanan = "FINISH";$nmubah = "ON PROSES";}
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Ubah Status Unit</h5>
        <p class="fs--1 mb-0 text-white">Silahkan mengubah status unit</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <input class="form-control" type="text" id="txtidunitUbah" value="<?php echo $idunit;?>" style="display:none;" />
 
            <p class="fs--1">Yakin, Anda merubah status unit<br><b><?php echo $nmunit;?></b><br><?php echo $nmugd;?><br>
    Status awal <b><?php echo $nmlayanan;?></b> menjadi status <b><?php echo $nmubah;?></b></p>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanUbahStatus">Ubah status</button>
</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanUbahStatus").click(function() {
    var idunit = $('#txtidunitUbah').val();
  
    if (idunit.length <= 0) {
        alert('Data unit ambulance tidak terdeteksi')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/transaksi/aksi_edit_status.php',
            data: {
                idunit: idunit
            },
            dataType: "json",
            beforeSend: function(e) {
                $("#cmdSimpanUbahStatus").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modEditStatus').modal('hide');
                    }, 1000);
                    ambilSemuaUnit();
                    isiTabelLayanan();
                    refreshGis();
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdSimpanUbahStatus").removeAttr("disabled");
                } else {
                    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdSimpanUbahStatus").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanUbahStatus").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
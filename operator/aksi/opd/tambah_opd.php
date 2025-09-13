<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Tambah RSUD, Puskesmas, Klinik</h5>
        <p class="fs--1 mb-0 text-white">Silahkan tambah data RSUD, Puskesmas, Klinik</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="mb-3">
        <label class="form-label" for="txtnmopd">Nama RSUD, Puskesmas, Klinik</label>
        <input class="form-control" type="text" placeholder="Instansi" id="txtnmopd" value="" maxlength="100"
			autocomplete="off" style="font-size:13px;" />
    </div>

    <div class="mb-3">
        <label class="form-label" for="txtalamatopd">Alamat</label>
        <input class="form-control" type="text" placeholder="Alamat lengkap" id="txtalamatopd" value="" autocomplete="off"
            style="font-size:13px;" />
    </div>

    <div class="mb-3">
        <label for="txttelpopd">Nomor Telepon</label>
        <input class="form-control" type="text" placeholder="Telepon" id="txttelpopd" value="" maxlength="20"
            autocomplete="off" style="font-size:13px;" />
    </div>

    <div class="mb-3">
        <label for="cboKategoriOPD">Kategori</label>
        <select class="form-select form-select-sm js-choice px-3" id="cboKategoriOPD" placeholder="Pilih Kategori"
            size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
            <option value="">Pilih kategori</option>
            <option value='rsud'>RSUD</option>
            <option value='puskesmas'>PUSKESMAS</option>
            <option value='klinik'>KLINIK</option>
        </select>
    </div>

    <div class="mb-0">
        <label for="txtkoordinattopd">Koordinat Lokasi</label>
        <input class="form-control" type="text" placeholder="Koordinat lokasi" id="txtkoordinattopd" value=""
            autocomplete="off" style="font-size:13px;" />
    </div>

</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanOPD">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanOPD").click(function() {
    var nmopd = $('#txtnmopd').val();
    var alamat = $('#txtalamatopd').val();
    var telepon = $('#txttelpopd').val();
    var koordinat = $('#txtkoordinattopd').val();
    var kategori = $('#cboKategoriOPD').val();

    if (nmopd.length <= 0) {
        $('#txtnmopd').focus();
        alert('Nama UGD masih kosong')
    } else if (alamat.length <= 0) {
        $('#txtalamatopd').focus();
        alert('Alamat UGD masih kosong')
    } else if (telepon.length <= 0) {
        $('#txttelpopd').focus();
        alert('Telepon UGD masih kosong')
    } else if (kategori.length <= 0) {
        $('#cboKategoriOPD').focus();
        alert('Kategori UGD masih kosong')
    } else if (koordinat.length <= 0) {
        $('#txtkoordinattopd').focus();
        alert('Koordinat UGD masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/opd/aksi_tambah.php',
            data: {nmopd: nmopd,alamat: alamat,telepon: telepon,koordinat: koordinat,kategori: kategori},
            dataType: "json",
            beforeSend: function(e) {
                $("#cmdSimpanOPD").attr("disabled", "disabled");
            },
            success: function(resp) {
                if (resp.msg2 == 'ok') {
                    setTimeout(function() {
                        $('#modTambahData').modal('hide');
                    }, 1000);
                    $("#ToastSukses").toast("show");
                    isiMasterOPD();
                } else if (resp.msg2 == 'err_val') {
                    alert(resp.msg1);
                    $("#cmdSimpanOPD").removeAttr("disabled");
                } else {
                    alert('Ada sedikit masalah, silakan coba lagi.');
                    $("#cmdSimpanOPD").removeAttr("disabled");
                }
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanOPD").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
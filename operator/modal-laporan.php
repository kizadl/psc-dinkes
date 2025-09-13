<!------------------MODAL EDIT LARGE ------------------>
<div class="modal fade" id="modLaporan" data-bs-keyboard="false" data-bs-backdrop="static" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog mt-6" role="document">
        <div class="modal-content border-0" id="isianmodLaporan">

            <div class="modal-header px-3 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-index-1 light">
                    <h5 class="mb-0 text-white">Filter Laporan</h5>
                    <p class="fs--1 mb-0 text-white">Silahkan tentukan filter kriteria pelaporan</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="mb-1">
                    <tr>
                        <td>
                            <input class="form-check-input me-1" id="chkMelayani" type="checkbox" value="Y" checked
                                style="transform: scale(1);" />
                            <label class="text-800 fs--1" for="chkMelayani">Status Melayani</label>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <input class="form-check-input me-1" id="chkSelesai" type="checkbox" value="N" checked
                                style="transform: scale(1);" />
                            <label class="text-800 fs--1" for="chkSelesai">Status Selesai</label>
                        </td>
                    </tr>
                </table>

                <div class="mb-3">
                    <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokelamin" size="1"
                        placeholder="Jenis kelamin" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="" selected>Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Wanita</option>
                    </select>

                </div>

                <div class="mb-3">
                    <select class="form-select form-select-sm js-choice fs--1 px-3" id="cboumur" size="1"
                        placeholder="Umur" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="" selected>Umur</option>
                        <option value="balita">Balita</option>
                        <option value="remaja">Remaja</option>
                        <option value="dewasa">Dewasa</option>
                        <option value="lansia">Lansia</option>
                    </select>
                </div>

                <div class="mb-3">
                    <select class="form-select form-select-sm js-choice fs--1 px-3" id="cbokategorigawat" size="1"
                        placeholder="Umur" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="" selected>Kegawatdaruratan</option>
                        <option value="meninggal">Meninggal</option>
                        <option value="gawat darurat">Gawat Darurat</option>
                        <option value="gawat tidak darurat">Gawat Tidak Darurat</option>
                        <option value="tidak gawat darurat">Tidak Gawat Darurat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <div id="selectParentLapDiagnosa" class="fs--1">
                        <select class="form-select form-select-sm fs--1 px-3" id="cbolapdiagnosa"
                            data-placeholder="Pilih Gejala Symptom"
                            data-options='{"removeItemButton":true,"placeholder":false}'>

                            <option value="" selected>Pilih Gejala Symptom</option>
                            <?php
                                        $qrikec = ("SELECT id_gejala,nm_gejala FROM m_gejala");								
                                        $liskec = mysqli_query($dbconn,$qrikec);									
                                        while($j=mysqli_fetch_array($liskec)){
                                        	echo "<option value=\"".$j['id_gejala']."\">".$j['nm_gejala']."</option>";
                                        }
                                        mysqli_free_result($liskec);
                                    ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <div id="selectParentLapUGD" class="fs--1">
                        <select class="form-select form-select-sm fs--1 px-3" id="cbolapUGD"
                            data-placeholder="Pilih UGD" data-options='{"removeItemButton":true,"placeholder":false}'>

                            <option value="" selected>Pilih UGD</option>
                            <?php
                                        $qrikec2 = ("SELECT id_ugd,nm_ugd FROM m_ugd");								
                                        $liskec2 = mysqli_query($dbconn,$qrikec2);									
                                        while($k=mysqli_fetch_array($liskec2)){
                                        	echo "<option value=\"".$k['id_ugd']."\">".$k['nm_ugd']."</option>";
                                        }
                                        mysqli_free_result($liskec2);
                                        mysqli_close($dbconn);
                                    ?>
                        </select>
                    </div>
                </div>

                <div class="mb-0 mt-4">
                    <button class="btn btn-primary d-block w-100 mt-3 fs--1" type="button" id="cmdKriteriaLaporan">Terapkan
                        Kriteria Laporan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $('#cbolapUGD').select2({
        dropdownParent: $('#selectParentLapUGD'),
        width: 'resolve',
        theme: 'bootstrap4'
    });

    $('#cbolapdiagnosa').select2({
        dropdownParent: $('#selectParentLapDiagnosa'),
        width: 'resolve',
        theme: 'bootstrap4'
    });
});
</script>
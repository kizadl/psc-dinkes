		<!------------------MODAL EDIT STATUS  ------------------>
		<div class="modal fade" id="modEditStatus" data-bs-keyboard="false" data-bs-backdrop="static" role="dialog"
		    aria-hidden="true">
		    <div class="modal-dialog mt-6" role="document">
		        <div class="modal-content border-0" id="isianmodEditStatus">

		        </div>
		    </div>
		</div>


		<!------------------MODAL EDIT LARGE ------------------>
		<div class="modal fade" id="modPencarian" data-bs-keyboard="false" data-bs-backdrop="static" role="dialog"
		    aria-hidden="true">
		    <div class="modal-dialog modal-lg mt-6" role="document">
		        <div class="modal-content border-0" id="isianModPencarian">

		            <div class="modal-header px-4 position-relative modal-shape-header bg-shape">
		                <div class="position-relative z-index-1 light">
		                    <h5 class="mb-0 text-white">Pencarian Lokasi Terdekat</h5>
		                    <p class="fs--1 mb-0 text-white">Silahkan tentukan ambulance lokasi terdekat untuk menangani
		                        panggilan darurat</p>
		                </div>
		                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2"
		                    data-bs-dismiss="modal" aria-label="Close"></button>
		            </div>
		            <div class="modal-body">

		                <div class="row light mb-3">
		                    <div class="col-sm-12">
		                        <div class="card bg-light">
		                            <div class="card-body px-3 py-2 mb-0">

		                                <label class="form-label">Identitas Pelapor</label>
		                                <div class="input-group mb-3"><span class="input-group-text fs--1">Nama</span>
		                                    <input class="form-control form-control-sm" type="text" placeholder="Nama pelapor"
		                                        autocomplete="off" id="txtpelapor" />
		                                    <span class="input-group-text fs--1">Telepon</span>
		                                    <input class="form-control form-control-sm" type="text" placeholder="No. Telepon"
		                                        autocomplete="off" id="txttelepon" style="width:12vh;overflow:hidden;" />
		                                </div>

		                            </div>
		                        </div>
		                    </div>
		                </div>

		                <div class="row light mb-3">
		                    <div class="col-sm-12">
		                        <div class="card bg-light">
		                            <div class="card-body px-3 py-2 mb-0">

		                                <label class="form-label">Identitas Pasien</label>
		                                <div class="input-group mb-3"><span class="input-group-text fs--1">Nama</span>
		                                    <input class="form-control form-control-sm" type="text" placeholder="Nama pasien"
		                                        autocomplete="off" id="txtpasien" style="width:34vh;overflow:hidden;" />
		                                    <span class="input-group-text fs--1">Gender</span>
		                                    <select class="form-select form-select-sm js-choice px-3" id="cbokelamin" size="1"
		                                        placeholder="Jenis kelamin"
		                                        data-options='{"removeItemButton":true,"placeholder":true}'
		                                        style="width:15vh;overflow:hidden;">
		                                        <option value="" selected></option>
		                                        <option value="L">Laki-laki</option>
		                                        <option value="P">Wanita</option>
		                                    </select>
		                                    <span class="input-group-text fs--1">Umur</span>
		                                    <select class="form-select form-select-sm js-choice px-3" id="cboumur" size="1"
		                                        placeholder="Umur" data-options='{"removeItemButton":true,"placeholder":true}'
		                                        style="width:13vh;overflow:hidden;">
		                                        <option value="" selected></option>
		                                        <option value="balita">Balita</option>
		                                        <option value="remaja">Remaja</option>
		                                        <option value="dewasa">Dewasa</option>
		                                        <option value="lansia">Lansia</option>
		                                    </select>
		                                </div>

		                                <label class="form-label">Diagnosa Symptom</label>
		                                <div class="input-group mb-3">
		                                    <span class="input-group-text fs--1">Gejala Symptom</span>
		                                    <div id="selectParentDiagnosa" class="fs--1">
		                                        <select class="form-select form-select-sm fs--1" id="cbodiagnosa"
		                                            name="cbodiagnosa[]" multiple data-placeholder="" data-allow-clear="1"
		                                            style="width:91vh;overflow:hidden;">
		                                            <?php
																	$qrikec = ("SELECT id_gejala,nm_gejala FROM m_gejala");								
																	$liskec = mysqli_query($dbconn,$qrikec);									
																	while($j=mysqli_fetch_array($liskec)){
																		echo "<option value=\"".$j['id_gejala']."\">".$j['nm_gejala']."</option>";
																	}mysqli_free_result($liskec);
																?>
		                                        </select>
		                                    </div>
		                                </div>

		                                <label class="form-label">Kategori Kegawatdaruratan</label>
		                                <div class="input-group mb-3">
		                                    <span class="input-group-text fs--1">Kegawatdaruratan</span>
		                                    <select class="form-select form-select-sm js-choice px-3" id="cbokategorigawat"
		                                        size="1" placeholder="Umur"
		                                        data-options='{"removeItemButton":true,"placeholder":true}'>
		                                        <option value="" selected></option>
												<option value="meninggal">Meninggal</option>
		                                        <option value="gawat darurat">Gawat Darurat</option>
												<option value="gawat tidak darurat">Gawat Tidak Darurat</option>
		                                        <option value="tidak gawat darurat">Tidak Gawat Darurat</option>
		                                    </select>
		                                </div>

		                                <label class="form-label">Rekom UGD RSD / Puskesmas / Klinik</label>
		                                <div class="input-group mb-3">
		                                    <span class="input-group-text fs--1">UGD</span>
		                                    <div id="selectParentRekom" class="fs--1">
		                                        <select class="form-select" id="cborekom"
		                                            data-placeholder="Pilih rekomendasi UGD" required="required"
		                                            data-options='{"removeItemButton":true,"placeholder":true}'
		                                            style="width:45vh;overflow:hidden;" onchange="pilihanUGD()">
		                                            <option value="" selected>Pilih UGD</option>
		                                            <?php
																	$qrikec = ("SELECT id_ugd,nm_ugd,alamat,koordinat FROM m_ugd");								
																	$liskec = mysqli_query($dbconn,$qrikec);									
																	while($j=mysqli_fetch_array($liskec)){
																		echo "<option value=\"".$j['id_ugd']."@".$j['koordinat']."\">".$j['nm_ugd']."</option>";
																	}mysqli_free_result($liskec);mysqli_close($dbconn);
																?>
		                                        </select>
		                                    </div>
		                                    <span class="input-group-text fs--1">Jarak</span>
		                                    <input class="form-control form-control-sm" type="text" placeholder=""
		                                        autocomplete="off" id="txtjarakrekom" disabled />
		                                </div>

		                            </div>
		                        </div>
		                    </div>
		                </div>

		                <div class="row light mb-3">
		                    <div class="col-sm-12">
		                        <div class="card text-white bg-secondary">
		                            <div class="card-body">
		                                <label class="form-label">Cari Unit Terdekat Dengan Posisi Pasien</label>
		                                <div class="input-group mb-3">
		                                    <input class="form-control me-2" type="text" id="latlng"
		                                        placeholder="Posisi pelapor" autocomplete="off"
		                                        style="font-size:13px;width:100px;" />
		                                    <button class="btn btn-info btn-sm" type="button"
		                                        id="find-by-location-button"></span>Cari Unit
		                                        Terdekat</button>
		                                </div>

		                                <div class="mb-3">
		                                    <label class="form-label" for="max-units">Maximum Jumlah Unit</label>
		                                    <select class="form-select js-choice" size="1" name="cboakses" id="max-units"
		                                        style="font-size:14px;">
		                                        <option>5</option>
		                                        <option>10</option>
		                                        <option>20</option>
		                                    </select>
		                                </div>

		                                <div class="mb-0">
		                                    <label class="form-label" for="last-message-time-filter">Filter Berdasarkan Waktu
		                                        Aktif</label>
		                                    <select class="form-select js-choice" size="1" id="last-message-time-filter"
		                                        style="font-size:14px;">
		                                        <option value='5'>Pesan diterima dalam 5 menit</option>
		                                        <option value='30'>Pesan diterima dalam 30 menit</option>
		                                        <option value='60'>Pesan diterima dalam 1 jam</option>
		                                        <option value='360'>Pesan diterima dalam 6 jam</option>
		                                        <option value='720'>Pesan diterima dalam 12 jam</option>
		                                        <option value='1440' selected>Pesan diterima dalam 24 jam</option>
		                                        <option value='0'>Tampilkan Semua</option>
		                                    </select>
		                                </div>

		                            </div>
		                        </div>
		                    </div>
		                </div>

		                <p style="display:none">Units: <select id='units' style="display:none">
		                        <option value='0'>—</option>
		                    </select>
		                    <button id='find-by-unit-button'>Find nearest to the unit</button>
		                </p>

		                <p style="display:none">Unit select: <input id='txttransidunit' type='text'></p>

		                <p style="display:none">Use routing: <input id='use-routing' type='checkbox'></p>
		                <div id="log" style="display:none"></div>

		                <div class="row light">
		                    <div class="col-sm-12">
		                        <div class="card bg-light">
		                            <div class="card-body">
		                                <label class="form-label" for="results-table">Unit Terdekat Dengan Posisi
		                                    Pasien</label>
		                                <div class="table-responsive scrollbar">
		                                    <table id="results-table" class="table table-sm table-striped mb-0 fs--1 w-100">
		                                        <thead class="bg-200">
		                                            <tr>
		                                                <th class="sort">Identitas Unit</th>
		                                                <th class="sort">Jarak</th>
		                                                <th class="sort text-center">Akhir</th>
		                                                <th class="sort">Status</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody class="bg-white" id="results-table-body"></tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>

		<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#cborekom').select2({
				dropdownParent: $('#selectParentRekom'),
				width: 'resolve',
				theme: 'bootstrap4'
			});

			$('#cbodiagnosa').select2({
				dropdownParent: $('#selectParentDiagnosa'),
				width: 'resolve',
				theme: 'bootstrap4'
			});
		});

		function pilihanUGD() {
			$("#txtjarakrekom").val("");
			var cariugd = $("#cborekom").val();
			var poss = cariugd.indexOf("@");

			var idugd = cariugd.substr(0, poss);
			var koordinat2 = cariugd.substr(poss + 1, cariugd.length);

			var latlngStr2 = koordinat2.split(",", 2);
			var lat2 = parseFloat(latlngStr2[0]);
			var lng2 = parseFloat(latlngStr2[1]);
			var posisi_2 = new google.maps.LatLng(lat2, lng2);

			var koordinat1 = $("#latlng").val();
			var latlngStr1 = koordinat1.split(",", 2);
			var lat1 = parseFloat(latlngStr1[0]);
			var lng1 = parseFloat(latlngStr1[1]);
			var posisi_1 = new google.maps.LatLng(lat1, lng1);

			if (koordinat2 != "") {
				var jarak = hitungJarak(posisi_1, posisi_2);
				$("#txtjarakrekom").val(jarak + " Km");
			} else {
				$("#txtjarakrekom").val("");
			}
		}

		function hitungJarak(posisi_1, posisi_2) {
			return (google.maps.geometry.spherical.computeDistanceBetween(posisi_1, posisi_2) / 1000).toFixed(2);
		}
		</script>
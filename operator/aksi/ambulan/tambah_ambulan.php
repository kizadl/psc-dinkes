<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');
?>
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h6 class="mb-0 text-white">Tambah Data Unit Ambulan</h6>
		<p class="fs--1 mb-0 text-white">Silahkan menambahkan data unit ambulan</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">

	<div class="mb-3">
		<label for="txtnmunit">Nama Unit Ambulan</label>
		<input class="form-control" type="text" id="txtnmunit" value="" maxlength="50" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="cbounit">Cari Unit Ambulan GIS</label>
		<div id="selectParentcbounit" class="fs--1">
		<select class="form-select" id="cbounit" data-placeholder="Cari unit ambulan GIS" required="required" data-options='{"removeItemButton":true,"placeholder":true}' style="width:68vh;overflow:hidden;">
			<option value="">Cari unit ambulan</option>
		</select>
		</div>	
		<input class="form-control" type="text" id="txtidunitgis" value="" style="font-size:13px;" hidden />
		<input class="form-control" type="text" id="txtnmunitgis" value="" style="font-size:13px;" hidden />
	</div>

	<div class="mb-3 mt-3">
		<label for="cbokepemilikanunit">Cari Kepemilikan Unit Ambulan</label>
		<div id="selectParentcbokepemilikan" class="fs--1">
		<select class="form-select" id="cbokepemilikanunit" data-placeholder="Cari kepemilikan unit" required="required" data-options='{"removeItemButton":true,"placeholder":true}' style="width:68vh;overflow:hidden;">
			<option value="">Cari kepemilikan unit</option>
			<?php
				$qrikec = ("SELECT id_ugd,nm_ugd,stts_ugd FROM m_ugd");
				$liskec = mysqli_query($dbconn, $qrikec);
				while ($j = mysqli_fetch_array($liskec)) {
					echo "<option value=\"" . $j['id_ugd'] . "@" . $j['stts_ugd'] . "\">" . $j['nm_ugd'] . "</option>";
				}
				mysqli_free_result($liskec);
				mysqli_close($dbconn);
				?>
		</select>	
		</div>
		<input class="form-control" type="text" id="txtidugd" value="" style="font-size:13px;" hidden />
		<input class="form-control" type="text" id="txtsttsugd" value="" style="font-size:13px;" hidden />
	</div>

	<div class="mb-3 mt-3">
		<label for="txtnoplatunit">Nomor Kendaraan Bermotor (TNKB)</label>
		<input class="form-control" type="text" id="txtnoplatunit" value="" maxlength="15" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtmerkunit">Merk Kendaraan</label>
		<input class="form-control" type="text" id="txtmerkunit" value="" maxlength="25" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txttypeunit">Type Kendaraan</label>
		<input class="form-control" type="text" id="txttypeunit" value="" maxlength="25" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtimeiunit">NO. IMEI GPS</label>
		<input class="form-control" type="text" id="txtimeiunit" value="" maxlength="50" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="cbobbmunit">Jenis BBM</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbobbmunit" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>
			<option value="">Pilih BBM</option>
			<option value='pertalite'>Pertalite</option>
			<option value='pertamax'>Pertamax</option>
			<option value='bio solar'>Bio Solar</option>
			<option value='dexlite'>Dexlite</option>
		</select>
	</div>

	<div class="mb-3">
		<label for="txthargabbmunit">Harga BBM</label>
		<input class="form-control" type="number" id="txthargabbmunit" value="" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtkonsbbmunit">Pemakaian Perliter BBM (KM)</label>
		<input class="form-control" type="number" id="txtkonsbbmunit" value="" autocomplete="off" style="font-size:13px;" />	
	</div>

</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanUnit">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#cbounit').select2({
			dropdownParent: $('#selectParentcbounit'),
			width: 'resolve',
			theme: 'bootstrap4'
		});

		$('#cbokepemilikanunit').select2({
			dropdownParent: $('#selectParentcbokepemilikan'),
			width: 'resolve',
			theme: 'bootstrap4'
		});

		init()
	});

	function init() { 
		var sess = wialon.core.Session.getInstance(); 
		var flags = wialon.item.Item.dataFlag.base | wialon.item.Unit.dataFlag.lastMessage;

		sess.loadLibrary("itemIcon"); 
		sess.updateDataFlags( 
			[{
				type: "type",
				data: "avl_unit",
				flags: flags,
				mode: 0
			}], 
			function(code) { 
				if (code) {
					console.log(wialon.core.Errors.getErrorText(code));
					return;
				} 
				var units = sess.getItems("avl_unit"); 
				if (!units || !units.length) {
					console.log("No units found");
					return;
				} 
				for (var i = 0; i < units.length; i++) 
					$("#cbounit").append("<option value='" + units[i].getId() + "'>" + units[i].getName() + "</option>");
			});
	}

	$("#cmdSimpanUnit").click(function() {
		
		var nmunit = $('#txtnmunit').val();
		var idsdk = $('#txtidunitgis').val();
		var nmsdk = $('#txtnmunitgis').val();

		var idugd = $('#txtidugd').val();
		var sttsugd = $('#txtsttsugd').val();

		var noplat = $('#txtnoplatunit').val();
		var merk = $('#txtmerkunit').val();
		var type = $('#txttypeunit').val();
		var imei = $('#txtimeiunit').val();
		var jnsbbm = $('#cbobbmunit').val();
		var harga = $('#txthargabbmunit').val();
		var konsumsi = $('#txtkonsbbmunit').val();

		if (nmunit.length <= 0) {$('#txtnmunit').focus();alert('Unit ambulan masih kosong')
		} else if (idsdk.length <= 0 || nmsdk.length <= 0) {$('#cbounit').focus();alert('Unit ambulan GIS masih kosong')
		} else if (idugd.length <= 0 || sttsugd.length <= 0) {$('#cbokepemilikanunit').focus();alert('Kepemilikan ambulan masih kosong')
		} else if (noplat.length <= 0) {$('#txtnoplatunit').focus();alert('Plat nomor kendaraan masih kosong')
		} else if (merk.length <= 0) {$('#txtmerkunit').focus();alert('Merk kendaraan masih kosong')
		} else if (type.length <= 0) {$('#txttypeunit').focus();alert('Type kendaraan masih kosong')
		} else if (imei.length <= 0) {$('#txtimeiunit').focus();alert('IMEI GPS masih kosong')
		} else if (jnsbbm.length <= 0) {$('#cbobbmunit').focus();alert('Jenis BBM masih kosong')
		} else if (harga.length <= 0) {$('#txthargabbmunit').focus();alert('Harga BBM masih kosong')
		} else if (konsumsi.length <= 0) {$('#txtkonsbbmunit').focus();alert('Konsumsi perliter BBM masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/ambulan/aksi_tambah.php',
				data: {nmunit: nmunit,idsdk: idsdk,nmsdk: nmsdk,idugd: idugd,sttsugd: sttsugd,noplat: noplat,merk: merk,type: type,imei: imei,jnsbbm: jnsbbm,harga: harga,konsumsi: konsumsi},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanUnit").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modTambahData').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterAmbulan();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanUnit").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanUnit").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanUnit").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});

	$('#cbounit').on('change',function(){
		var idunitgis = $('#cbounit').val()
		var nmunitgis = $('#cbounit :selected').text()
		$("#txtidunitgis").val(idunitgis);$("#txtnmunitgis").val(nmunitgis);
	});

	$('#cbokepemilikanunit').on('change',function(){
		var kepemilikan = $('#cbokepemilikanunit').val()
		var idxke = kepemilikan.indexOf("@");
		var idugd = kepemilikan.slice(0, idxke);
		var statusx = kepemilikan.slice(idxke + 1, kepemilikan.length);
		$("#txtidugd").val(idugd);
		$("#txtsttsugd").val(statusx);
	});

</script>
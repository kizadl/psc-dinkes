<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idunit= trim($_POST['idunit']);

$qri = ("SELECT p.nm_unit,p.nm_sdk,p.imei_gps,p.merk,p.type_unit,p.no_plat,p.jenis_bbm,p.harga_bbm,p.avg_bbm,p.kepemilikan,p.id_sdk,p.id_ugd
		FROM m_unit p WHERE p.id_unit='".$idunit."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$nmunit = $c['nm_unit'];
$idsdk = $c['id_sdk'];$nmsdk = $c['nm_sdk'];
$idugd = $c['id_ugd'];
$imei = $c['imei_gps'];
$merk = $c['merk'];$type = $c['type_unit'];$noplat = $c['no_plat'];
$jenisbbm = $c['jenis_bbm'];$hargabbm = $c['harga_bbm'];$avgbbm = $c['avg_bbm'];
$kepemilikan = $c['kepemilikan'];
mysqli_free_result($dbquery);
?>    				
<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
	<div class="position-relative z-index-1 light">
		<h6 class="mb-0 text-white">Edit Data Unit Ambulan</h6>
		<p class="fs--1 mb-0 text-white">Silahkan edit data unit ambulan</p>
	</div>
	<button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4 bg-light">
	
	<input class="form-control" type="text" id="txtidunitE" value="<?php echo $idunit ?>" style="font-size:13px;" hidden />

	<div class="mb-3">
		<label for="txtnmunitE">Nama Unit Ambulan</label>
		<input class="form-control" type="text" id="txtnmunitE" value="<?php echo $nmunit ?>" maxlength="50" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="cbounitE">Cari Unit Ambulan GIS</label>
		<div id="selectParentcbounitE" class="fs--1">
		<select class="form-select" id="cbounitE" data-placeholder="Cari unit ambulan GIS" required="required" data-options='{"removeItemButton":true,"placeholder":true}' style="width:68vh;overflow:hidden;">
			<option value="">Cari unit ambulan</option>
		</select>
		</div>	
		<input class="form-control" type="text" id="txtidunitgisE" value="<?php echo $idsdk ?>" style="font-size:13px;" hidden />
		<input class="form-control" type="text" id="txtnmunitgisE" value="<?php echo $nmsdk ?>" style="font-size:13px;" hidden />
	</div>

	<div class="mb-3 mt-3">
		<label for="cbokepemilikanunitE">Cari Kepemilikan Unit Ambulan</label>
		<div id="selectParentcbokepemilikanE" class="fs--1">
		<select class="form-select" id="cbokepemilikanunitE" data-placeholder="Cari kepemilikan unit" required="required" data-options='{"removeItemButton":true,"placeholder":true}' style="width:68vh;overflow:hidden;">
			<option value="">Cari kepemilikan unit</option>
			<?php
				$qrikec = ("SELECT id_ugd,nm_ugd,stts_ugd FROM m_ugd");
				$liskec = mysqli_query($dbconn, $qrikec);
				while ($j = mysqli_fetch_array($liskec)) {
					if ($idugd == $j['id_ugd']){$plhugd = "selected";} else {$plhugd = "";}
					echo "<option value=".$j['id_ugd']."@".$j['stts_ugd']."  $plhugd >".$j['nm_ugd']."</option>";
				}
				mysqli_free_result($liskec);
				mysqli_close($dbconn);
				?>
		</select>	
		</div>
		<input class="form-control" type="text" id="txtidugdE" value="<?php echo $idugd ?>" style="font-size:13px;" hidden />
		<input class="form-control" type="text" id="txtsttsugdE" value="<?php echo $kepemilikan ?>" style="font-size:13px;" hidden />
	</div>

	<div class="mb-3 mt-3">
		<label for="txtnoplatunitE">Nomor Kendaraan Bermotor (TNKB)</label>
		<input class="form-control" type="text" id="txtnoplatunitE" value="<?php echo $noplat ?>" maxlength="15" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtmerkunitE">Merk Kendaraan</label>
		<input class="form-control" type="text" id="txtmerkunitE" value="<?php echo $merk ?>" maxlength="25" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txttypeunitE">Type Kendaraan</label>
		<input class="form-control" type="text" id="txttypeunitE" value="<?php echo $type ?>" maxlength="25" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtimeiunitE">NO. IMEI GPS</label>
		<input class="form-control" type="text" id="txtimeiunitE" value="<?php echo $imei ?>" maxlength="50" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="cbobbmunitE">Jenis BBM</label>
		<select class="form-select form-select-sm js-choice px-3" id="cbobbmunitE" size="1" required="required" data-options='{"removeItemButton":true,"placeholder":true}'>		
			<?php
				if ($jenisbbm == "pertalite"){$plhbbm1 = "selected";
				} else if ($jenisbbm == "pertamax"){$plhbbm2 = "selected";
				} else if ($jenisbbm == "bio solar"){$plhbbm3 = "selected";
				} else if ($jenisbbm == "dexlite"){$plhbbm4 = "selected";}
			echo "
			<option value=''>Pilih BBM</option>
			<option value='pertalite' $plhbbm1 >Pertalite</option>
			<option value='pertamax' $plhbbm2 >Pertamax</option>
			<option value='bio solar' $plhbbm3 >Bio Solar</option>
			<option value='dexlite' $plhbbm4 >Dexlite</option>";
			?>
		</select>
	</div>

	<div class="mb-3">
		<label for="txthargabbmunitE">Harga BBM</label>
		<input class="form-control" type="number" id="txthargabbmunitE" value="<?php echo $hargabbm ?>" autocomplete="off" style="font-size:13px;" />	
	</div>

	<div class="mb-3">
		<label for="txtkonsbbmunitE">Pemakaian Perliter BBM (KM)</label>
		<input class="form-control" type="number" id="txtkonsbbmunitE" value="<?php echo $avgbbm ?>" autocomplete="off" style="font-size:13px;" />	
	</div>

</div>
<div class="modal-footer bg-primary justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-info" type="button" id="cmdSimpanUnitE">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#cbounitE').select2({
			dropdownParent: $('#selectParentcbounitE'),
			width: 'resolve',
			theme: 'bootstrap4'
		});

		$('#cbokepemilikanunitE').select2({
			dropdownParent: $('#selectParentcbokepemilikanE'),
			width: 'resolve',
			theme: 'bootstrap4'
		});

		initE()
	});

	function initE() { 
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
				var idsdk = $("#txtidunitgisE").val();
				for (var i = 0; i < units.length; i++) {
					if (idsdk == units[i].getId()){var pilihsdk = "selected";} else {var pilihsdk = "";}
					$("#cbounitE").append("<option value=" + units[i].getId() + " "+pilihsdk+">" + units[i].getName() + "</option>");
				}
			});
	}

	$("#cmdSimpanUnitE").click(function() {

		var idunit = $('#txtidunitE').val();
		var nmunit = $('#txtnmunitE').val();
		var idsdk = $('#txtidunitgisE').val();
		var nmsdk = $('#txtnmunitgisE').val();

		var idugd = $('#txtidugdE').val();
		var sttsugd = $('#txtsttsugdE').val();

		var noplat = $('#txtnoplatunitE').val();
		var merk = $('#txtmerkunitE').val();
		var type = $('#txttypeunitE').val();
		var imei = $('#txtimeiunitE').val();
		var jnsbbm = $('#cbobbmunitE').val();
		var harga = $('#txthargabbmunitE').val();
		var konsumsi = $('#txtkonsbbmunitE').val();

		if (idunit.length <= 0) {alert('Unit ambulan tidak terdeteksi')
		} else if (nmunit.length <= 0) {$('#txtnmunitE').focus();alert('Unit ambulan masih kosong')
		} else if (idsdk.length <= 0 || nmsdk.length <= 0) {$('#cbounitE').focus();alert('Unit ambulan masih kosong')
		} else if (idugd.length <= 0 || sttsugd.length <= 0) {$('#cbokepemilikanunitE').focus();alert('Kepemilikan ambulan masih kosong')
		} else if (noplat.length <= 0) {$('#txtnoplatunitE').focus();alert('Plat nomor kendaraan masih kosong')
		} else if (merk.length <= 0) {$('#txtmerkunitE').focus();alert('Merk kendaraan masih kosong')
		} else if (type.length <= 0) {$('#txttypeunitE').focus();alert('Type kendaraan masih kosong')
		} else if (imei.length <= 0) {$('#txtimeiunitE').focus();alert('IMEI GPS masih kosong')
		} else if (jnsbbm.length <= 0) {$('#cbobbmunitE').focus();alert('Jenis BBM masih kosong')
		} else if (harga.length <= 0) {$('#txthargabbmunitE').focus();alert('Harga BBM masih kosong')
		} else if (konsumsi.length <= 0) {$('#txtkonsbbmunitE').focus();alert('Konsumsi perliter BBM masih kosong')
		} else {
			$.ajax({
				type: "POST",
				url: 'aksi/ambulan/aksi_edit.php',
				data: {idunit: idunit,nmunit: nmunit,idsdk: idsdk,nmsdk: nmsdk,idugd: idugd,sttsugd: sttsugd,noplat: noplat,merk: merk,type: type,imei: imei,jnsbbm: jnsbbm,harga: harga,konsumsi: konsumsi},
				dataType: "json",
				beforeSend: function(e) {
					$("#cmdSimpanUnitE").attr("disabled", "disabled");
				},
				success: function(resp) {
					if (resp.msg2 == 'ok') {
						setTimeout(function() {
							$('#modEditData').modal('hide');
						}, 1000);
						$("#ToastSukses").toast("show");
						isiMasterAmbulan();
					} else if (resp.msg2 == 'err_val') {
						alert(resp.msg1);
						$("#cmdSimpanUnitE").removeAttr("disabled");
					} else {
						alert('Ada sedikit masalah, silakan coba lagi.');
						$("#cmdSimpanUnitE").removeAttr("disabled");
					}
				},
				error: function() {
					alert('Koneksi bermasalah periksa internet');
					$("#cmdSimpanUnitE").removeAttr("disabled");
					$(".modal-body").css("opacity", "");
				},
			});
		};
	});

	$('#cbounitE').on('change',function(){
		var idunitgis = $('#cbounitE').val()
		var nmunitgis = $('#cbounitE :selected').text()
		$("#txtidunitgisE").val(idunitgis);$("#txtnmunitgisE").val(nmunitgis);
	});

	$('#cbokepemilikanunitE').on('change',function(){
		var kepemilikan = $('#cbokepemilikanunitE').val()
		var idxke = kepemilikan.indexOf("@");
		var idugd = kepemilikan.slice(0, idxke);
		var statusx = kepemilikan.slice(idxke + 1, kepemilikan.length);
		$("#txtidugdE").val(idugd);
		$("#txtsttsugdE").val(statusx);
	});

</script>
<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idopd= trim($_POST['idopd']);

$qri = ("SELECT nm_ugd,alamat,telepon,koordinat,stts_ugd FROM m_ugd WHERE id_ugd='".$idopd."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$nmopd = $c['nm_ugd'];$alamat = $c['alamat'];$telepon = $c['telepon'];$koordinat = $c['koordinat'];$kategori = $c['stts_ugd'];
mysqli_free_result($dbquery);mysqli_close($dbconn);
?>    				
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
			<div class="position-relative z-index-1 light">
                  <h5 class="mb-0 text-white">Edit RSUD, Puskesmas, Klinik</h5>
                  <p class="fs--1 mb-0 text-white">Silahkan edit data RSUD, Puskesmas, Klinik</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				
				<input class="form-control" type="text" id="txtidopdE" value="<?php echo $idopd;?>" style="display:none;"/>

				<div class="mb-3">
					<label class="form-label" for="txtnmopdE">Nama RSUD, Puskesmas, Klinik</label>
                    <input class="form-control" type="text" id="txtnmopdE" value="<?php echo $nmopd;?>" maxlength="100" autocomplete="off" style="font-size:13px;"/>
				</div>

				<div class="mb-3">
					<label class="form-label" for="txtalamatopdE">Alamat</label>
                    <input class="form-control" type="text" id="txtalamatopdE" value="<?php echo $alamat;?>" autocomplete="off" style="font-size:13px;"/>
				</div>

				<div class="mb-3">
					<label class="form-label" for="txttelpopdE">Nomor Telepon</label>
                    <input class="form-control" type="text" id="txttelpopdE" value="<?php echo $telepon;?>" maxlength="20" autocomplete="off" style="font-size:13px;"/>
				</div>

				<div class="mb-3">
					<label for="cboKategoriOPDE">Kategori</label>
					<select class="form-select form-select-sm js-choice px-3" id="cboKategoriOPDE" size="1" required="required"
						data-options='{"removeItemButton":true,"placeholder":true}'>
						<option value="">Pilih kategori</option>
						<?php
						if ($kategori == "rsud"){$plhas1 = "selected";}
						if ($kategori == "puskesmas"){$plhas2 = "selected";}
						if ($kategori == "klinik"){$plhas3 = "selected";}
							echo "<option value='rsud' $plhas1 >RSUD</option>";
							echo "<option value='puskesmas' $plhas2 >PUSKESMAS</option>";
							echo "<option value='klinik' $plhas3 >KLINIK</option>";
						?>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-label" for="txtkoordinattopdE">Koordinat Lokasi</label>
                    <input class="form-control" type="text" id="txtkoordinattopdE" value="<?php echo $koordinat;?>" autocomplete="off" style="font-size:13px;"/>
				</div>

            </div>
			<div class="modal-footer bg-primary justify-content-between">
				<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-info" type="button" id="cmdSimpanOPDE">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanOPDE").click(function(){
	var idugd = $('#txtidopdE').val();
	var nmugd = $('#txtnmopdE').val();
	var alamat = $('#txtalamatopdE').val();
	var telepon = $('#txttelpopdE').val();
	var kategori = $('#cboKategoriOPDE').val();
	var koordinat = $('#txtkoordinattopdE').val();

	if(idugd.length<=0){alert('Data UGD tidak terdeteksi')}
	else if(nmugd.length<=0){$('#txtnmopdE').focus();alert('Nama UGD masih kosong')}
	else if(alamat.length<=0){$('#txtalamatopdE').focus();alert('Alamat UGD masih kosong')}
	else if(telepon.length<=0){$('#txttelpopdE').focus();alert('Telepon UGD masih kosong')}
	else if(kategori.length<=0){$('#cboKategoriOPDE').focus();alert('Kategori UGD masih kosong')}
	else if(koordinat.length<=0){$('#txtkoordinattopdE').focus();alert('Koordinat lokasi UGD masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/opd/aksi_edit.php',
		data: {idugd: idugd,nmugd: nmugd,alamat: alamat,telepon: telepon,koordinat: koordinat,kategori: kategori},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanOPDE").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);
				$("#ToastSukses").toast("show");
				isiMasterOPD();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdSimpanOPDE").removeAttr("disabled");							
			} else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSimpanOPDE").removeAttr("disabled");
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanOPDE").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	
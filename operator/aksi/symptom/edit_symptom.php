<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
$idgejala= trim($_POST['idgejala']);

$qri = ("SELECT nm_gejala FROM m_gejala WHERE id_gejala='".$idgejala."'");
$dbquery = mysqli_query($dbconn,$qri);$c= mysqli_fetch_assoc($dbquery);
$nmgejala = $c['nm_gejala'];
mysqli_free_result($dbquery);mysqli_close($dbconn);
?>    				
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
			<div class="position-relative z-index-1 light">
                  <h6 class="mb-0 text-white">Edit Data Symptom</h6>
                  <p class="fs--1 mb-0 text-white">Silahkan edit data symptom</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">
				
				<input class="form-control" type="text" id="txtidgejalaE" value="<?php echo $idgejala;?>" style="display:none;"/>

				<div class="form-floating mb-3">
                    <input class="form-control" type="text" id="txtnmgejalaE" value="<?php echo $nmgejala;?>" maxlength="100" autocomplete="off" style="font-size:13px;"/>
					<label class="form-label" for="txtnmgejalaE">Gejala Symptom</label>
				</div>

            </div>
			<div class="modal-footer justify-content-between">
				<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-primary" type="button" id="cmdSimpanEditGejala">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanEditGejala").click(function(){
	var idgejala = $('#txtidgejalaE').val();
	var nmgejala = $('#txtnmgejalaE').val();

	if(idgejala.length<=0){alert('Data symptom tidak terdeteksi')}
	else if(nmgejala.length<=0){$('#txtnmgejalaE').focus();alert('Nama gejala symptom masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/symptom/aksi_edit.php',
		data:{idgejala:idgejala,nmgejala:nmgejala},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanEditGejala").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);
				$("#ToastSukses").toast("show");
				isiMasterGejala();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdSimpanEditGejala").removeAttr("disabled");							
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSimpanEditGejala").removeAttr("disabled");
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanEditGejala").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	
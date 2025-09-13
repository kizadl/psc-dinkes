
			<div class="modal-header px-4 position-relative modal-shape-header bg-shape">			  
			<div class="position-relative z-index-1 light">
                  <h6 class="mb-0 text-white">Tambah Data Symptom</h6>
                  <p class="fs--1 mb-0 text-white">Silahkan edit data symptom</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3 px-4">

				<div class="form-floating mb-3">
                    <input class="form-control" type="text" id="txtsymptom" value="" maxlength="100" autocomplete="off" style="font-size:13px;"/>
					<label class="form-label" for="txtsymptom">Gejala Symptom</label>
				</div>

            </div>
			<div class="modal-footer justify-content-between">
				<button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
				<button class="btn btn-sm btn-primary" type="button" id="cmdSimpanSymptom">Simpan data</button>
			</div>

<script type="text/javascript" charset="utf-8">
$("#cmdSimpanSymptom").click(function(){
	var nmgejala = $('#txtsymptom').val();

	if(nmgejala.length<=0){$('#txtsymptom').focus();alert('Gejala symptom masih kosong')}
	else{
	$.ajax({
		type:"POST",
		url:'aksi/symptom/aksi_tambah.php',
		data:{nmgejala:nmgejala},
		dataType: "json",
		beforeSend: function(e) {
			$("#cmdSimpanSymptom").attr("disabled","disabled");
		},		
		success:function(resp){
			if(resp.msg2 == 'ok'){
				setTimeout(function(){ $('#modTambahData').modal('hide');},1000);
				$("#ToastSukses").toast("show");
				isiMasterGejala();
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdSimpanSymptom").removeAttr("disabled");							
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdSimpanSymptom").removeAttr("disabled");
			}
		},
		error: function() {
			alert('Koneksi bermasalah periksa internet');
			$("#cmdSimpanSymptom").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	
</script>	
<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idinstansi = trim($_POST['idinstansi']);
$sqlins = ("SELECT nm_bupati,jabatan,username,status FROM m_kepala_daerah");
$restps = mysqli_query($dbconn,$sqlins);$sm= mysqli_fetch_assoc($restps);
$nmbupati = $sm['nm_bupati'];
$jabatan = $sm['jabatan'];$username = $sm['username'];

$status = $sm['status'];
if($status=="TIDAK AKTIF"){
    $disaktifkan="display:none";$disnonaktifkan="display:none";
} else if($status=="MENUNGGU AKTIVASI"){
    $disaktifkan="";$disnonaktifkan="display:none";
} else if($status=="AKTIF"){
    $disaktifkan="display:none";$disnonaktifkan="";
}
mysqli_free_result($restps);mysqli_close($dbconn);
?>

<div class="modal-header px-4 position-relative modal-shape-header bg-shape">
    <div class="position-relative z-index-1 light">
        <h5 class="mb-0 text-white">Identitas Bupati</h5>
        <p class="fs--1 mb-0 text-white">Silahkan mengubah data identitas bupati kepala daerah</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmbupati" value="<?php echo $nmbupati?>"
            placeholder="Nama instansi" maxlength="100" autocomplete="off">
        <label for="txtnmbupati">Nama Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatan" value="<?php echo $jabatan?>"
            placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatan">Jabatan</label>
    </div>

    <div class="form-floating mb-3" style="display:none">
        <input type="text" class="form-control form-control-sm" id="txtusername" value="<?php echo $username?>"
            placeholder="Kota" maxlength="100" autocomplete="off" disabled style="background:white;">
        <label for="txtusername">Username</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600">Jika status HP terdeteksi <b>Tidak Aktif</b>, silahkan
                untuk aktivasi HP terlebih
                dahulu. Tekan tombol <b>Aktifkan</b> jika status <b>Sedang Menunggu Aktivasi</b></p>

            <div class="d-flex mb-1 flex-row">
                <select class="form-select form-select-sm me-2" id="cboStatusBupati" style="width:200px;" disabled>
                    <?php
									if($status=="TIDAK AKTIF"){
										$plhtdk='selected';
									} else if($status=="MENUNGGU AKTIVASI"){
										$plhtunggu='selected';
									} else if($status=="AKTIF"){
										$plhaktif='selected';
									}
									echo "<option value='TIDAK AKTIF' $plhtdk>Tidak Aktif</option>";
									echo "<option value='MENUNGGU AKTIVASI' $plhtunggu>Menunggu Aktivasi</option>";
									echo "<option value='AKTIF' $plhaktif>Aktif</option>";
								?>
                </select>
                <button class="btn btn-falcon-primary btn-sm" type="button" id="cmdAktifkanBupati"
                    style="<?php echo $disaktifkan?>">Aktifkan</button>
                <button class="btn btn-falcon-danger btn-sm" type="button" id="cmdNonAktifBupati"
                    style="<?php echo $disnonaktifkan?>">Non Aktifkan</button>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Tandatangan</b><br>File tandatangan harus file
                gambar (tandatangan) berextensi .png</p>
            <input class="form-control form-control-sm" id="btnUploadTTDBup" type="file" accept=".png" />
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanBupati">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#txtnmbupati").focus();
});

function gantiFile() {
    $("#btnUploadTTDBup").val('');
}

$('#btnUploadTTDBup').bind('change', function() {
    var extensinya = $('#btnUploadTTDBup').val().toLowerCase();
    var regex = new RegExp("(.*?)\.(png)$");
    if (!(regex.test(extensinya))) {
        alert("File upload harus file berextensi .png");
        $('#btnUploadTTDBup').val(null);
    }
});

$("#cmdAktifkanBupati").click(function(){
	var statusx = "AKTIF";
	
	var data = new FormData();
	data.append('statusx', statusx);
	
	if (statusx.length<=0){alert('Status aktivasi masih kosong')}	
	else{
	$.ajax({
		type:"POST",
		url:'aksi/identitas-instansi/aksi_aktivasi_bupati.php',
        data: data,
        dataType: "json",
        processData: false,
        contentType: false,			
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
			$("#cmdAktifkanBupati").attr("disabled","disabled");
		},			
		success:function(resp){
			document.body.style.cursor = "default";$("#loading").fadeOut("slow");
			if(resp.msg2 == 'ok'){
				//toast.success('Proses aktivasi handphone sukses');
				$("#cmdAktifkanBupati").removeAttr("disabled","disabled");
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);
				//socket.emit('pesan aktivasi', idinstansi);				
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdAktifkanBupati").removeAttr("disabled");
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdAktifkanBupati").removeAttr("disabled");
			}
		},
		error: function() {
			document.body.style.cursor = "default";$("#loading").fadeOut("slow");
			alert('Koneksi bermasalah periksa internet');
			$("#cmdAktifkanBupati").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	

$("#cmdNonAktifBupati").click(function(){
	var statusx = "TIDAK AKTIF";
	
	var data = new FormData();
	data.append('statusx', statusx);
	
	if(statusx.length<=0){alert('Status aktivasi masih kosong')}	
	else{
	$.ajax({
		type:"POST",
		url:'aksi/identitas-instansi/aksi_nonaktivasi_bupati.php',
		data: data,
        dataType: "json",
        processData: false,
        contentType: false,			
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
			$("#cmdNonAktifBupati").attr("disabled","disabled");
		},			
		success:function(resp){
			document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
			if(resp.msg2 == 'ok'){
				//toast.warning('Proses non aktivasi handphone sukses');
				$("#cmdNonAktifBupati").removeAttr("disabled","disabled");
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);	
				//socket.emit('pesan aktivasi', idinstansi);
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdNonAktifBupati").removeAttr("disabled");						
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdNonAktifBupati").removeAttr("disabled");
			}
		},
		error: function() {
			document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
			alert('Koneksi bermasalah periksa internet');
			$("#cmdNonAktifBupati").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	

$("#cmdSimpanBupati").click(function() {
    var idinstansi = $('#lblidinstansi').val();
    var nmbupati = $('#txtnmbupati').val();
    var jabatan = $('#txtjabatan').val();

    var data = new FormData();
    data.append('upBupati', $("#btnUploadTTDBup")[0].files[0]);
    data.append('idinstansi', idinstansi);
    data.append('nmbupati', nmbupati);
    data.append('jabatan', jabatan);

    if (nmbupati.length <= 0) {
        $('#txtnmbupati').focus();
        alert('Nama bupati masih kosong')
    } else if (jabatan.length <= 0) {
        $('#txtjabatan').focus();
        alert('Jabatan masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/identitas-instansi/aksi_edit_bupati.php',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
                $("#cmdSimpanBupati").attr("disabled", "disabled");
            },
            success: function(resp) {
                document.body.style.cursor = "default";
                if (resp.msg2 == 'ok') {
                    $("#loading").fadeOut("slow");
                    $("#cmdSimpanBupati").removeAttr("disabled");
                    $("#ToastSukses").toast("show");
                    setTimeout(function() {
                        $('#modEditData').modal('hide');
                    }, 1000);
                } else if (resp.msg2 == 'err_val') {
                    $("#loading").fadeOut("slow");
                    $("#ToastGagal").toast("show");
                    $("#cmdSimpanBupati").removeAttr("disabled");
                } else {
                    $("#loading").fadeOut("slow");
                    $("#ToastGagal").toast("show");
                    $("#cmdSimpanBupati").removeAttr("disabled");
                }
            },
            error: function() {
                document.body.style.cursor = "default";
                $("#loading").fadeOut("slow");
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanBupati").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
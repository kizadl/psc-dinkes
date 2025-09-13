<?php
error_reporting(0);
require_once '../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

$idinstansi = trim($_POST['idinstansi']);
$sqlins = ("SELECT nm_aspri,jabatan,username,status FROM m_aspri");
$restps = mysqli_query($dbconn,$sqlins);$sm= mysqli_fetch_assoc($restps);
$nmaspri = $sm['nm_aspri'];
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
        <h5 class="mb-0 text-white">Identitas Asisten Pribadi</h5>
        <p class="fs--1 mb-0 text-white">Silahkan mengubah data identitas asisten pribadi bupati</p>
    </div>
    <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal"
        aria-label="Close"></button>
</div>
<div class="modal-body py-3 px-4">

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtnmaspri" value="<?php echo $nmaspri?>"
            placeholder="Nama instansi" maxlength="100" autocomplete="off">
        <label for="txtnmaspri">Nama Lengkap</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" class="form-control form-control-sm" id="txtjabatanaspri" value="<?php echo $jabatan?>"
            placeholder="Jabatan" maxlength="100" autocomplete="off">
        <label for="txtjabatanaspri">Jabatan</label>
    </div>

    <div class="form-floating mb-3" style="display:none">
        <input type="text" class="form-control form-control-sm" id="txtusernameaspri" value="<?php echo $username?>"
            placeholder="Kota" maxlength="100" autocomplete="off" disabled style="background:white;">
        <label for="txtusernameaspri">Username</label>
    </div>

    <div class="card bg-light mb-3">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600">Jika status HP terdeteksi <b>Tidak Aktif</b>, silahkan
                untuk aktivasi HP terlebih
                dahulu. Tekan tombol <b>Aktifkan</b> jika status <b>Sedang Menunggu Aktivasi</b></p>

            <div class="d-flex mb-1 flex-row">
                <select class="form-select form-select-sm me-2" id="cboStatusAspri" style="width:200px;" disabled>
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
                <button class="btn btn-falcon-primary btn-sm" type="button" id="cmdAktifkanAspri"
                    style="<?php echo $disaktifkan?>">Aktifkan</button>
                <button class="btn btn-falcon-danger btn-sm" type="button" id="cmdNonAktifAspri"
                    style="<?php echo $disnonaktifkan?>">Non Aktifkan</button>
            </div>
        </div>
    </div>

    <div class="card bg-light">
        <div class="card-body px-3 py-2 mb-0">
            <p class="fs--1 mb-2 text-600"><b>Upload Tandatangan</b><br>File tandatangan harus file
                gambar (tandatangan) berextensi .png</p>
            <input class="form-control form-control-sm" id="btnUploadTTDaspri" type="file" accept=".png" />
        </div>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">Batalkan</button>
    <button class="btn btn-sm btn-primary" type="button" id="cmdSimpanAspri">Simpan data</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    $("#txtnmaspri").focus();
});

function gantiFile() {
    $("#btnUploadTTDaspri").val('');
}

$('#btnUploadTTDaspri').bind('change', function() {
    var extensinya = $('#btnUploadTTDaspri').val().toLowerCase();
    var regex = new RegExp("(.*?)\.(png)$");
    if (!(regex.test(extensinya))) {
        alert("File upload harus file berextensi .png");
        $('#btnUploadTTDaspri').val(null);
    }
});

$("#cmdAktifkanAspri").click(function(){
	var statusx = "AKTIF";
	
	var data = new FormData();
	data.append('statusx', statusx);
	
	if (statusx.length<=0){alert('Status aktivasi masih kosong')}	
	else{
	$.ajax({
		type:"POST",
		url:'aksi/identitas-instansi/aksi_aktivasi_aspri.php',
        data: data,
        dataType: "json",
        processData: false,
        contentType: false,			
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
			$("#cmdAktifkanAspri").attr("disabled","disabled");
		},			
		success:function(resp){
			document.body.style.cursor = "default";$("#loading").fadeOut("slow");
			if(resp.msg2 == 'ok'){
				//toast.success('Proses aktivasi handphone sukses');
				$("#cmdAktifkanAspri").removeAttr("disabled","disabled");
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);
				//socket.emit('pesan aktivasi', idinstansi);				
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdAktifkanAspri").removeAttr("disabled");
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdAktifkanAspri").removeAttr("disabled");
			}
		},
		error: function() {
			document.body.style.cursor = "default";$("#loading").fadeOut("slow");
			alert('Koneksi bermasalah periksa internet');
			$("#cmdAktifkanAspri").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	

$("#cmdNonAktifAspri").click(function(){
	var statusx = "TIDAK AKTIF";
	
	var data = new FormData();
	data.append('statusx', statusx);
	
	if(statusx.length<=0){alert('Status aktivasi masih kosong')}	
	else{
	$.ajax({
		type:"POST",
		url:'aksi/identitas-instansi/aksi_nonaktivasi_aspri.php',
		data: data,
        dataType: "json",
        processData: false,
        contentType: false,			
		beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
			$("#cmdNonAktifAspri").attr("disabled","disabled");
		},			
		success:function(resp){
			document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
			if(resp.msg2 == 'ok'){
				//toast.warning('Proses non aktivasi handphone sukses');
				$("#cmdNonAktifAspri").removeAttr("disabled","disabled");
				setTimeout(function(){ $('#modEditData').modal('hide');},1000);	
				//socket.emit('pesan aktivasi', idinstansi);
			}else if(resp.msg2 == 'err_val'){
				alert(resp.msg1);
				$("#cmdNonAktifAspri").removeAttr("disabled");						
			}else {
				alert('Ada sedikit masalah, silakan coba lagi.');
				$("#cmdNonAktifAspri").removeAttr("disabled");
			}
		},
		error: function() {
			document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
			alert('Koneksi bermasalah periksa internet');
			$("#cmdNonAktifAspri").removeAttr("disabled");
			$(".modal-body").css("opacity", "");},
	});	
	}; 	
});	

$("#cmdSimpanAspri").click(function() {
    var idinstansi = $('#lblidinstansi').val();
    var nmbupati = $('#txtnmaspri').val();
    var jabatan = $('#txtjabatanaspri').val();

    var data = new FormData();
	data.append('upAspri', $("#btnUploadTTDaspri")[0].files[0]);
    data.append('idinstansi', idinstansi);
    data.append('nmbupati', nmbupati);
    data.append('jabatan', jabatan);

    if (nmbupati.length <= 0) {
        $('#txtnmaspri').focus();
        alert('Nama asisten pribadi masih kosong')
    } else if (jabatan.length <= 0) {
        $('#txtjabatanaspri').focus();
        alert('Jabatan masih kosong')
    } else {
        $.ajax({
            type: "POST",
            url: 'aksi/identitas-instansi/aksi_edit_aspri.php',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
                $("#cmdSimpanAspri").attr("disabled", "disabled");
            },
            success: function(resp) {
                document.body.style.cursor = "default";
                if (resp.msg2 == 'ok') {
                    $("#loading").fadeOut("slow");
                    $("#cmdSimpanAspri").removeAttr("disabled");
                    $("#ToastSukses").toast("show");
                    setTimeout(function() {
                        $('#modEditData').modal('hide');
                    }, 1000);
                } else if (resp.msg2 == 'err_val') {
                    $("#loading").fadeOut("slow");
                    $("#ToastGagal").toast("show");
                    $("#cmdSimpanAspri").removeAttr("disabled");
                } else {
                    $("#loading").fadeOut("slow");
                    $("#ToastGagal").toast("show");
                    $("#cmdSimpanAspri").removeAttr("disabled");
                }
            },
            error: function() {
                document.body.style.cursor = "default";
                $("#loading").fadeOut("slow");
                alert('Koneksi bermasalah periksa internet');
                $("#cmdSimpanAspri").removeAttr("disabled");
                $(".modal-body").css("opacity", "");
            },
        });
    };
});
</script>
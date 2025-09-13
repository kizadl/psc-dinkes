function bersihkan(){
	$("#lblhalaman").val("");
	$("#area-halaman").css("display","none");

	$("#area-dashboard").css("display","none");	
	$("#area-kop-dashboard").css("display","none");	
	
	$("#area-input-disposisi-lengkap").css("display","none");
	$("#area-input-disposisi").css("display","none");	
	$("#area-arsip-disposisi").css("display","none");
	$("#area-jadwal").css("display","none");	

	$("#area-master-operator").css("display","none");
	$("#area-master-opd").css("display","none");
	$("#area-master-instansi").css("display","none");
  }

  $("#cmdClearInputDispoL").click(function(){
	bersihkanInputLengkap();
  });

  $('#chkJadwalL').click(function(){
	$("#txttgljadwalL").val("");$("#txtjamjadwalL").val("");
    if($(this).is(':checked')){
        $("#txttgljadwalL").css("display","block");
		$("#txtjamjadwalL").css("display","block");
    } else {
		$("#txttgljadwalL").css("display","none");
        $("#txtjamjadwalL").css("display","none");
    }
  });

  function bersihkanInputLengkap(){
	tanggalHariIni();
	document.getElementById("chkUrgentL").checked = false;

	document.getElementById("chkJadwalL").checked = false;
	$("#txttgljadwalL").val("");$("#txtjamjadwalL").val("");
	$("#txttgljadwalL").css("display","none");
    $("#txtjamjadwalL").css("display","none");

	$("#txtnosuratL").val("");
	$("#txtperihalL").val("");
	$("#cboinstansiSuratL").val("");
	$("#cbosifatL").val("");
	$("#cbodistribusiL").val("");
	
	document.getElementById("chkDiketahuiL").checked = false;
	document.getElementById("chkDiperhatikanL").checked = false;
	document.getElementById("chkTidakLanjutL").checked = false;
	document.getElementById("chkDipelajariL").checked = false;
	document.getElementById("chkDicukupiL").checked = false;
	document.getElementById("chkDiwakiliL").checked = false;

	$("#txtIsiDisposisiL").val("");
	$("#btnUploadSuratL").val("");

	$("#cbosifatL").val(null).trigger('change');
	$("#cboinstansiSuratL").val(null).trigger('change');
	$("#cbodistribusiL").val(null).trigger('change');
  }

  ///////////////////////////////////////////////
  //////// pencarian tanggal DASHBOARD //////////
  ///////////////////////////////////////////////
  var setTanggal = $("#txtTransDashboardJadwal").val();
  xarrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
  xarrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
	  "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
	  "31"
  ];
  function CariTglDashboard(){
	var x = new Date(setTanggal);
	//x.setDate(0); // 0 will result in the last day of the previous month
	x.setDate(1); // 1 will result in the first day of the month
	xTanggal = x.getDate();
    xBulan = x.getMonth();
    xTahun = x.getFullYear();

	var kriteria = $("#dashboard-select-jadwal").val();
	if (kriteria == "bulan"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrbulan[xBulan] + '-' + xTahun);
	} else if (kriteria == "minggu"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	} else if (kriteria == "hari"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	}
  }

  $("#cmdprev").click(function(){
	var kriteria = $("#dashboard-select-jadwal").val();
	if (kriteria == "bulan"){
		var x = new Date($("#txtTransDashboardJadwal").val());
		xTanggal = 1;//x.getDate();
		xBulan = x.getMonth()-1;
		xTahun = x.getFullYear();
		if (xBulan < 0){
			xBulan = xBulan+12;
			xTahun = xTahun-1
		} else {
			xBulan = xBulan;
			xTahun = xTahun;
		}
		$("#dashboard-lbltanggal-jadwal").text(xarrbulan[xBulan] + '-' + xTahun);
		$("#txtTransDashboardJadwal").val(xTahun + '-' + arrbulan[xBulan] + '-' + xarrtanggal[xTanggal]);
	} else if (kriteria == "minggu"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	} else if (kriteria == "hari"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	}
  });

  $("#cmdnext").click(function(){
	var kriteria = $("#dashboard-select-jadwal").val();
	if (kriteria == "bulan"){
		var x = new Date($("#txtTransDashboardJadwal").val());
		xTanggal = 1;//x.getDate();
		xBulan = x.getMonth()+1;
		xTahun = x.getFullYear();
		if (xBulan >= 12){
			xBulan = x.getMonth()-11;
			xTahun = xTahun+1
		} else {
			xBulan = xBulan;
			xTahun = xTahun;
		}
		$("#dashboard-lbltanggal-jadwal").text(xarrbulan[xBulan] + '-' + xTahun);
		$("#txtTransDashboardJadwal").val(xTahun + '-' + arrbulan[xBulan] + '-' + xarrtanggal[xTanggal]);
	} else if (kriteria == "minggu"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	} else if (kriteria == "hari"){
    	$("#dashboard-lbltanggal-jadwal").text(xarrtanggal[xTanggal] + '-' + xarrbulan[xBulan] + '-' + xTahun);
	}
  });

  function tanggalHariIni(){
    var tglserver = $("#lbltglserver").val();
    arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
        "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
        "31"
    ];
    mydate = new Date(tglserver);

    tanggal = mydate.getDate();
    bulan = mydate.getMonth();
    tahun = mydate.getFullYear();

    $("#txttglterimaL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
    $("#txttglsuratL").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun);
  }

  function awalTglJadwal(){
    var tglserver = $("#lbltglserver").val();
    arrbulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    arrtanggal = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14",
        "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
        "31"
    ];
    mydate = new Date(tglserver);

	tanggal = mydate.getDate();
    bulan = mydate.getMonth();
    tahun = mydate.getFullYear();

	var newdate = new Date(mydate);
	newdate.setDate(newdate.getDate() + 1); 
	var nd = new Date(newdate);
	
    tanggal2 = nd.getDate();
    bulan2 = nd.getMonth();
    tahun2 = nd.getFullYear();

	$("#txttanggaljadwal").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
  }

  $("#cmdDashboard").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	//isiMasterPengunjung();
	$("#area-dashboard").fadeIn();
	$("#area-kop-dashboard").fadeIn();
	$("#lblhalaman").val("dashboard");
  });

  $("#cmdInputDisposisi").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiInputDisposisi();
	$("#area-input-disposisi").fadeIn();
	$("#lblhalaman").val("inputdisposisi");
  });

  $("#cmdTambahDispoLengkap").click(function(){
	$.ajax({
		type:"POST",
		url :"aksi/trans-surat/tambah_surat_lengkap.php",		
		success:function(resp){
		  $("#isianModTambahDataLarge").html(resp);
		  $("#isianModTambahDataLarge").fadeIn(1000);
		  $("#modTambahDataLarge").modal({backdrop: 'static', keyboard: false}) 
		  $("#modTambahDataLarge").modal('show');
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
  });

  $("#cmdArsipDisposisi").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiArsipDisposisi();
	$("#area-arsip-disposisi").fadeIn();
	$("#lblhalaman").val("arsipdisposisi");
  });

  $("#cmdJadwal").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiJadwal();
	$("#area-jadwal").fadeIn();
	$("#lblhalaman").val("jadwal");
  });

  $("#cmdInstansiPengguna").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiMasterInstansi();
	$("#area-master-instansi").fadeIn();
	$("#lblhalaman").val("masterinstansi");
  });

  $("#cmdMasterOPD").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiMasterOPD();
	$("#area-master-opd").fadeIn();
	$("#lblhalaman").val("masteropd");
  });

  $("#cmdMasterOperator").click(function(){
	bersihkan();           
	$("#area-halaman").fadeIn();
	isiMasterOperator();
	$("#area-master-operator").fadeIn();
	$("#lblhalaman").val("masteroperator");
  });

  /*================ JUMLAH SURAT =================*/
	function isiJumlahSurat(){
		var idugd=$('#lblidugd').val();
		$.ajax({
			type:"POST",
			url : "aksi/isi_jumlah_aktif.php",
			data:{idugd:idugd},
			dataType : 'json',			
			success:function(data){
				$("#lbljumdisposisi").text("0");	
				var i;
				for(i=0; i<data.length; i++){
					$("#lbljumdisposisi").text(data[i].jummasuk);
				}									
			},
		});	
	}

	  /*================ JUMLAH TERJADWAL =================*/
	  function isiJumlahTerjadwal(){
		var idinstansi=$('#lblidinstansi').val();
		$.ajax({
			type:"POST",
			url : "aksi/isi_jumlah_terjadwal.php",
			data:{idinstansi:idinstansi},
			dataType : 'json',			
			success:function(data){
				$("#lbljumjadwal").text("0");	
				var i;
				for(i=0; i<data.length; i++){
					$("#lbljumjadwal").text(data[i].jumjadwal);
				}									
			},
		});	
	}

   /*================ INPUT DISPOSISI =================*/
   function isiInputDisposisi(){
	$('#tabelinputdisposisi').dataTable().fnDestroy();
	var idugd=$('#lblidugd').val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_layanan.php",
	  data:{idugd:idugd},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
			  var html = '';
			  var i;
			  for(i=0; i<data.length; i++){

				if (data[i].ketgawat == 'Meninggal') {
					var warna = "secondary";
				} else if (data[i].ketgawat == 'Gawat Darurat') {
					var warna = "danger";
				}else if (data[i].ketgawat == 'Gawat Tidak Darurat') {
					var warna = "warning";
				}else if (data[i].ketgawat == 'Tidak Gawat Darurat') {
					var warna = "info";
				}

				html += 
				'<tr class="btn-reveal-trigger">'+
				  '<td class="align-middle text-center" width="5%">'+data[i].no+'</td>'+
				  '<td class="align-middle text-center" width="10%">'+data[i].tgllayanan+'<br>'+
				  	'<span class="badge rounded-pill badge-soft-success">'+data[i].jamlayanan+'</span>'+
				  '</td>'+
				  '<td class="align-middle" width="25%">'+data[i].nmpasien+'<span><br>'+data[i].umur+' / '+data[i].kelamin+'</span>'+
				  	'<br><span class="badge badge-soft-' + warna +
                        '">' + data[i].ketgawat + '</span></td>'+
				  '<td class="align-middle" width="25%">'+data[i].nmdiagnosa+'</td>'+
				  '<td class="align-middle" width="30%">'+data[i].penanganan+'<br>'+
				  '<span class="badge rounded-pill badge-soft-warning">'+data[i].sttspasien+'</span>'+
				  '</td>'+			 
				  '<td class="align-middle" width="5%">'+
				  	'<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnEditDisposisi" data-bs-toggle="tooltip" title="Penanganan" data-idlayanan="'+data[i].idlayanan+'"><span class="fas fa-edit"></span></button> '+
				  '</td>'+
				'</tr>';
				}			
				$('#isitabelinputdisposisi').html(html);
				$("#tabelinputdisposisi").dataTable({"paging": false, "lengthChange": false,"ordering": false,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
					  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
					  $("#loading").fadeOut("slow");						
	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $('#isitabelinputdisposisi').on('click','.btnKirimDispo',function(){
	var nminstansi =$("#lblnminstansi").val()
	var idsurat = $(this).data('id');
	var nosurat = $(this).data('nosurat');
	var perihal = $(this).data('perihal'); var ketkirim = $(this).data('ketkirim');
	if(ketkirim == "belum"){
		let text = "Mengirim data surat untuk disposisi\nNo Surat : "+nosurat+"\nPerihal\n"+perihal+"\n";
		if (confirm(text) == true) {
			$.ajax({
				type:"POST",		
				url :"aksi/trans-surat/aksi_kirim.php",	
				data:{idsurat:idsurat},
				success:function(resp){
					$("#ToastSukses").toast("show");
					isiInputDisposisi();
					socket.emit('kirim surat keluar', 'bupati');
					socket.emit('kirim surat keluar', 'aspri');

					var key = "AAAAJvfx7aE:APA91bGlTnQoj5fn3YCI0jsnjI7sJN83Nt3kSj0rNQrm8kkUWliYkIly6TiATzcsRpFR-Juz23e0QxleB2rvHlvA1YliygK1mSpCjvO32HAsUdQN5KIihdBDtbV8Qjb-b3nTMtYe7PJj";
					var to = "/topics/dispobupati";
					var notification = {
						'title': nminstansi,
						'body': perihal,
						'sound': 'default'
					};
					fetch('https://fcm.googleapis.com/fcm/send', {
						'method': 'POST',
						'headers': {
						'Authorization': 'key=' + key,
						'Content-Type': 'application/json',
						'Content-Length': 0
						},
						'priority' : 'high',//normal
						'body': JSON.stringify({
						'notification': notification,
						'to': to
						})
					}).then(function(response) {
						console.log(response);
					}).catch(function(error) {
						console.error(error);
					})

				},
				error: function() {alert('Koneksi bermasalah periksa internet');},
			});
		}
	} else if(ketkirim == "terkirim"){
		$.ajax({
			type:"POST",
			url :"aksi/trans-surat/timeline-disposisi.php",		
			data:{idsurat:idsurat},
			success:function(resp){
			  $("#isianModTambahDataLarge").html(resp);
			  $("#isianModTambahDataLarge").fadeIn(1000);
			  $("#modTambahDataLarge").modal({backdrop: 'static', keyboard: false}) 
			  $("#modTambahDataLarge").modal('show');
			},
			error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	}
  });

  $("#cmdRefreshInputDisposisi").click(function(){
	isiInputDisposisi();
  });

  $("#cmdTambahInputDisposisi").click(function(){
	$.ajax({
	  type:"POST",
	  url :"aksi/trans-surat/tambah_surat.php",		
	  success:function(resp){
		$("#isianModTambahDataLarge").html(resp);
		$("#isianModTambahDataLarge").fadeIn(1000);
		$("#modTambahDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelinputdisposisi').on('click','.btnEditDisposisi',function(){
	var idlayanan = $(this).data('idlayanan');
	var idoperator = $("#lbleditor").val();
	$.ajax({
	  type:"POST",		
	  url :"aksi/trans-surat/edit_penanganan.php",	
	  data:{idlayanan:idlayanan,idoperator:idoperator},
	  success:function(resp){
		$("#isianModEditDataLarge").html(resp);
		$("#isianModEditDataLarge").fadeIn(1000);
		$("#modEditDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });
  
  $('#isitabelinputdisposisi').on('click','.btnEditTerDisposisi',function(){
	var idsurat = $(this).data('id'); 
	var sttsinput = $(this).data('sttsinput');
	if (sttsinput == "baru"){ var urlnya ="aksi/trans-surat/edit_disposisi.php";}
	else if (sttsinput == "lengkap"){ var urlnya ="aksi/trans-surat/edit_surat_lengkap.php";}
	$.ajax({
	  type:"POST",		
	  url : urlnya,	
	  data: {idsurat:idsurat},
	  success:function(resp){
		$("#isianModEditDataLarge").html(resp);
		$("#isianModEditDataLarge").fadeIn(1000);
		$("#modEditDataLarge").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditDataLarge").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#isitabelinputdisposisi').on('click','.btnHapusDisposisi',function(){
	var idinstansi = $('#lblidinstansi').val();
	var idsurat = $(this).data('id');var idopd = $(this).data('idopd');
	var nosurat = $(this).data('nosurat');
	var perihal = $(this).data('perihal'); var nmopd = $(this).data('opd');
	let text = "Yakin menghapus data disposisi\nNo Surat : "+nosurat+"\nPerihal\n"+perihal+"\nAsal Surat\n"+nmopd+"\n";
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/trans-surat/aksi_hapus.php",	
		data:{idinstansi:idinstansi,idsurat:idsurat,idopd:idopd},
		success:function(resp){
		  alert(resp);
		  isiInputDisposisi();isiJumlahSurat();isiJumlahTerjadwal();
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });

  $('#isitabelinputdisposisi').on('click','.btnArsipDisposisi',function(){
	var idinstansi = $('#lblidinstansi').val();
	var idsurat = $(this).data('id');
	var nosurat = $(this).data('nosurat');
	var perihal = $(this).data('perihal'); var nmopd = $(this).data('opd');
	let text = "Mengarsipkan data disposisi\nNo Surat : "+nosurat+"\nPerihal\n"+perihal+"\nAsal Surat\n"+nmopd+"\n";
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/trans-surat/aksi_arsip.php",	
		data:{idsurat:idsurat},
		success:function(resp){
		  alert(resp);
		  isiInputDisposisi();isiJumlahSurat();isiJumlahTerjadwal();
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });


     /*================ ARSIP DISPOSISI =================*/
	 function isiArsipDisposisi(){
		$('#tabelarsipdisposisi').dataTable().fnDestroy();
		var idinstansi=$('#lblidinstansi').val();
		var rangetanggal = $("#txttanggallaporan").val();
		var tglawal = left(rangetanggal,10);
		var tglakhir = right(rangetanggal,10);
		$.ajax({
		  type:"POST",
		  url : "aksi/isi_tabel_arsip_disposisi.php",
		  data:{idinstansi:idinstansi,tglawal:tglawal,tglakhir:tglakhir},
		  dataType : 'json',
		  beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		  },
		  success:function(data){
			document.body.style.cursor = "default";
				  var html = '';
				  var i;
				  for(i=0; i<data.length; i++){
	
					if (data[i].sifat == "Sangat Segera"){var warnasifat = "badge-soft-warning";}
					else if (data[i].sifat == "Segera"){var warnasifat = "badge-soft-success";}
					else if (data[i].sifat == "Rahasia"){var warnasifat = "badge-soft-danger";}
					else if (data[i].sifat == "Biasa"){var warnasifat = "badge-soft-secondary";}
	
					html += 
					'<tr class="btn-reveal-trigger">'+
					  '<td class="align-middle text-center" width="5%">'+data[i].no+'</td>'+
					  '<td class="align-middle text-center" width="10%">'+data[i].tglterima+'<br>'+
						  '<span class="badge rounded-pill '+warnasifat+'">'+data[i].sifat+'</span>'+
					  '</td>'+
					  '<td class="align-middle" width="20%">'+data[i].tglsurat+'<br>'+data[i].nosurat+'<br>Agenda : '+data[i].noagenda+'</td>'+
					  '<td class="align-middle" width="30%">'+data[i].perihal+'</td>'+
					  '<td class="align-middle" width="20%">'+data[i].nmopd+'</td>'+
					  '<td class="align-middle" width="5%">'+
					  	'<a href="print-disposisi-'+data[i].mdcetak+'.html" target="_blank" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm mb-1"><span class="fas fa-pen-nib"></span></a>'+
						'<a href="tampilkan-'+data[i].mdcetak+'.html" target="_blank" class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm"><span class="fas fa-envelope"></span></a>'+
					  '</td>'+
					'</tr>';
					}			
					$('#isitabelarsipdisposisi').html(html);
					$("#tabelarsipdisposisi").dataTable({"paging": true, "lengthChange": false,"ordering": true,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
						  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						  $("#loading").fadeOut("slow");						
		  },
		  error: function() {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";					
		  },
		});	
	  }
	
	  $("#cmdRefreshArsip").click(function(){
		isiArsipDisposisi();
	  });

	  function right(str, chr) {
		return str.slice(str.length-chr,str.length);
	  }
	   
	  function left(str, chr) {
		return str.slice(0, chr - str.length);
	  }


	/*================ ISI JADWAL =================*/
	 function isiJadwal(){
		$('#tabeljadwal').dataTable().fnDestroy();
		var idinstansi=$('#lblidinstansi').val();
		var rangetanggal = $("#txttanggaljadwal").val();
		var tglawal = left(rangetanggal,10);
		var tglakhir = right(rangetanggal,10);
		$.ajax({
		  type:"POST",
		  url : "aksi/isi_tabel_jadwal.php",
		  data:{idinstansi:idinstansi,tglawal:tglawal,tglakhir:tglakhir},
		  dataType : 'json',
		  beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		  },
		  success:function(data){
			document.body.style.cursor = "default";
				  var html = '';
				  var i;
				  for(i=0; i<data.length; i++){

					if (data[i].ketstatus == "Belum"){var warnastatus = "badge-soft-secondary";}
					else if (data[i].ketstatus == "Terima"){var warnastatus = "badge-soft-primary";}

					if (data[i].sttssurat == "Y"){var dissurat = "";}
					else if (data[i].sttssurat == "N"){var dissurat = "display:none !important;";}

					if (data[i].jadwalkosong == "N"){var diskosong = data[i].harijadwal+'<br>'+data[i].tgljadwal+'<br>'+data[i].jamjadwal;}
					else if (data[i].jadwalkosong == "Y"){var diskosong = '<span class="badge rounded-pill badge-soft-danger">KOSONG</span>';}

					html += 
					'<tr class="btn-reveal-trigger">'+
					  '<td class="align-middle text-center" width="5%"><span class="badge rounded-pill badge-soft-primary" style="'+dissurat+'">'+data[i].noagenda+'</span>'+
					  //'<div class="calendar"><span class="calendar-month">Feb 2022</span><span class="calendar-day">21</span></div>'+
					  	//'<br><span class="badge rounded-pill '+warnastatus+'">'+data[i].ketstatus+'</span>'+
					  '</td>'+
					  '<td class="align-middle" width="10%">'+diskosong+'</td>'+
					  '<td class="align-middle" width="20%">'+data[i].nmopd+
						'<br><a class="d-inline-flex align-items-center me-3 py-1 mt-2 inbox-link" href="print-disposisi-'+data[i].mdcetak+'.html" target="_blank" style="'+data[i].disarsip+'"><span class="fas fa-file-alt text-primary" data-fa-transform="grow-4"></span></a>'+
						'<a class="d-inline-flex align-items-center py-1 mt-2 inbox-link" href="tampilkan-'+data[i].mdcetak+'.html" target="_blank" style="'+dissurat+'"><span class="fas fa-file-pdf text-danger" data-fa-transform="grow-4"></span></a>'+
					  '</td>'+
					  '<td class="align-middle" width="30%">'+data[i].perihal+'</td>'+
					  '<td class="align-middle hover-actions-trigger" width="25%">'+
					  	'<div class="btn-group btn-group-sm z-index-2 hover-actions end-0 me-3" style="width: 7rem;">'+
							'<button class="btn btn-light btnTambahJadwal" type="button" data-bs-toggle="tooltip" title="Input Jadwal" data-idsurat="'+data[i].idsurat+'" data-nmopd="'+data[i].nmopd+'" data-perihal="'+data[i].perihal+'" data-sttssurat="'+data[i].sttssurat+'"><span class="fas fa-plus"></span></button>'+
							'<button class="btn btn-light btnEditJadwal" type="button" data-bs-toggle="tooltip" title="Edit Jadwal" data-idjadwal="'+data[i].idjadwal+'" data-nmopd="'+data[i].nmopd+'" data-perihal="'+data[i].perihal+'" data-sttssurat="'+data[i].sttssurat+'"><span class="fas fa-edit"></span></button>'+
							'<button class="btn btn-light btnHapusJadwal" type="button" data-bs-toggle="tooltip" title="Hapus Jadwal" data-idjadwal="'+data[i].idjadwal+'" data-nmopd="'+data[i].nmopd+'" data-perihal="'+data[i].perihal+'" data-sttssurat="'+data[i].sttssurat+'"><span class="fas fa-trash-alt"></span></button>'+
						'</div>'+	  
					  	data[i].tempat+'<br><span class="text-primary">'+data[i].keterangan+'</span><br><span class="text-secondary">'+data[i].jumlah+'</span>'+'<br><span class="text-primary">'+data[i].sambutan+'</span>'+
					  '</td>'+
					'</tr>';
					}			
					$('#isitabeljadwal').html(html);
					$("#tabeljadwal").dataTable({"paging": false, "lengthChange": false,"ordering": false,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
						  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						  $("#loading").fadeOut("slow");						
		  },
		  error: function() {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";					
		  },
		});	
	  }
	
	  $("#cmdRefreshJadwal").click(function(){
		isiJadwal();
	  });

	  $("#cmdTambahJadwalBaru").click(function(){
		$.ajax({
			type:"POST",		
			url :"aksi/trans-jadwal/tambah_jadwal_baru.php",
			success:function(resp){
			  $("#isianModEditData").html(resp);
			  $("#isianModEditData").fadeIn(1000);
			  $("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			  $("#modEditData").modal('show');
			},
			error: function() {alert('Koneksi bermasalah periksa internet');},
		  });
	  });

	  $('#isitabeljadwal').on('click','.btnTambahJadwal',function(){
		var idsurat = $(this).data('idsurat');
		var nmopd = $(this).data('nmopd');var perihal = $(this).data('perihal');var sttssurat = $(this).data('sttssurat');
		$.ajax({
		  type:"POST",		
		  url :"aksi/trans-jadwal/tambah_jadwal.php",	
		  data:{idsurat:idsurat,nmopd:nmopd,perihal:perihal,sttssurat:sttssurat},
		  success:function(resp){
			$("#isianModEditData").html(resp);
			$("#isianModEditData").fadeIn(1000);
			$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			$("#modEditData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });

	  $('#isitabeljadwal').on('click','.btnEditJadwal',function(){
		var idjadwal = $(this).data('idjadwal');
		var nmopd = $(this).data('nmopd');var perihal = $(this).data('perihal');var sttssurat = $(this).data('sttssurat');
		$.ajax({
		  type:"POST",		
		  url :"aksi/trans-jadwal/edit_jadwal.php",	
		  data:{idjadwal:idjadwal,nmopd:nmopd,perihal:perihal,sttssurat:sttssurat},
		  success:function(resp){
			$("#isianModEditData").html(resp);
			$("#isianModEditData").fadeIn(1000);
			$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			$("#modEditData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });

	  $('#isitabeljadwal').on('click','.btnHapusJadwal',function(){
		var idjadwal = $(this).data('idjadwal');
		var nmopd = $(this).data('nmopd');var perihal = $(this).data('perihal');//var sttssurat = $(this).data('sttssurat');
		$.ajax({
		  type:"POST",		
		  url :"aksi/trans-jadwal/hapus_jadwal.php",	
		  data:{idjadwal:idjadwal,nmopd:nmopd,perihal:perihal},
		  success:function(resp){
			$("#isianModEditData").html(resp);
			$("#isianModEditData").fadeIn(1000);
			$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			$("#modEditData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });


  /*================ OPERATOR =================*/
  function isiMasterOperator(){
	$('#tableOperator').dataTable().fnDestroy();
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url : "aksi/isi_tabel_operator.php",
	  data:{idinstansi:idinstansi},
	  dataType : 'json',
	  beforeSend: function(e) {
		$("#loading").fadeIn();
		document.body.style.cursor = "wait";
	  },
	  success:function(data){
		document.body.style.cursor = "default";
			  var html = '';
			  var i;
				  for(i=0; i<data.length; i++){
					if (data[i].blokir=="Y"){var nmblokir ="Blokir";var warnablok = "badge-soft-danger";} else if (data[i].blokir=="N"){var nmblokir ="Tidak";var warnablok = "badge-soft-primary";}
					html += 
					'<tr class="btn-reveal-trigger">'+
					  '<td class="align-middle" width="5%">'+data[i].no+'</td>'+
					  '<td class="align-middle" width="20%">'+data[i].nmuser+'</td>'+
					  '<td class="align-middle" width="25%">'+data[i].nminstansi+'</td>'+
					  '<td class="align-middle" width="20%">'+data[i].username+'</td>'+
					  '<td class="align-middle" width="10%">'+data[i].akses+'</td>'+
					  '<td class="align-middle text-center" width="6%">'+
					  	'<span class="badge rounded-pill '+warnablok+'">'+nmblokir+'</span>'+	
					  '</td>'+
					  '<td class="d-flex align-middle" width="14%">'+
					  	'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnBlokirOperator" data-id="'+data[i].iduser+'" data-nmoperator="'+data[i].nmuser+'" data-blokir="'+data[i].blokir+'"><span class="fas fa-ban"></span></button> '+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditOperator" data-id="'+data[i].iduser+'"><span class="fas fa-edit"></span></button> '+
						'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusOperator" data-id="'+data[i].iduser+'" data-nmuser="'+data[i].nmuser+'"><span class="fas fa-trash"></span></button>'+
					  '</td>'+
					'</tr>';
					}			
					$('#list-operator').html(html);
					$("#tableOperator").dataTable({"paging": true, "lengthChange": false,"ordering": true,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
						  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
						  $("#loading").fadeOut("slow");						
	  },
	  error: function() {
		$("#loading").fadeOut("slow");
		alert("Koneksi bermasalah periksa internet");
		document.body.style.cursor = "default";					
	  },
	});	
  }

  $("#cmdRefreshOperator").click(function(){
	isiMasterOperator();
  });

  $("#cmdTambahOperator").click(function(){
	$.ajax({
	  type:"POST",
	  url :"aksi/operator/tambah_operator.php",			
	  success:function(resp){
		$("#isianModTambahData").html(resp);
		$("#isianModTambahData").fadeIn(1000);
		$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
		$("#modTambahData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#list-operator').on('click','.btnEditOperator',function(){
	var idoperator = $(this).data('id');
	$.ajax({
	  type:"POST",		
	  url :"aksi/operator/edit_operator.php",	
	  data:{idoperator:idoperator},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  $('#list-operator').on('click','.btnHapusOperator',function(){
	var idoperator = $(this).data('id');var nmoperator = $(this).data('nmuser');
	let text = "Yakin menghapus data operator\n"+nmoperator;
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/operator/aksi_hapus.php",	
		data:{idoperator:idoperator},
		success:function(resp){
		  $("#ToastHapus").toast("show");
		  isiMasterOperator();	
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });

  $('#list-operator').on('click','.btnBlokirOperator',function(){
	var idoperator = $(this).data('id');var nmoperator = $(this).data('nmoperator');var blokir = $(this).data('blokir');
	if (blokir=="Y"){var ubahstatus ="Membuka Blokir";var status ="N";} else {var ubahstatus ="Memblokir";var status ="Y";}
	let text = "Yakin Anda "+ubahstatus+" data operator\n"+nmoperator;
	if (confirm(text) == true) {
	  $.ajax({
		type:"POST",		
		url :"aksi/operator/aksi_blokir.php",	
		data:{idoperator:idoperator,status:status},
		success:function(resp){
			$("#ToastSukses").toast("show");
		  	isiMasterOperator();	
		},
		error: function() {alert('Koneksi bermasalah periksa internet');},
	  });
	}  
  });


    /*================ OPD =================*/
	function isiMasterOPD(){
		$('#tableOPD').dataTable().fnDestroy();
		var idinstansi=$('#lblidinstansi').val();
		$.ajax({
		  type:"POST",
		  url : "aksi/isi_tabel_opd.php",
		  data:{idinstansi:idinstansi},
		  dataType : 'json',
		  beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		  },
		  success:function(data){
			document.body.style.cursor = "default";
				  var html = '';
				  var i;
					  for(i=0; i<data.length; i++){
						html += 
						'<tr class="btn-reveal-trigger">'+
						  '<td class="align-middle" width="5%">'+data[i].no+'</td>'+
						  '<td class="align-middle" width="75%">'+data[i].nmopd+'</td>'+
						  '<td class="align-middle" width="15%">'+data[i].kategori+'</td>'+
						  '<td class="d-flex-inline align-middle text-center" width="5%">'+
							'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditOPD" data-id="'+data[i].idopd+'"><span class="fas fa-edit"></span></button> '+
							//'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusOPD" data-id="'+data[i].idopd+'" data-nmopd="'+data[i].nmopd+'"><span class="fas fa-trash"></span></button>'+
						  '</td>'+
						'</tr>';
						}			
						$('#isitableOPD').html(html);
						$("#tableOPD").dataTable({"paging": false, "lengthChange": false,"ordering": true,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
							  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
							  $("#loading").fadeOut("slow");						
		  },
		  error: function() {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";					
		  },
		});	
	  }
	
	  $("#cmdRefreshOPD").click(function(){
		isiMasterOPD();
	  });
	
	  $("#cmdTambahOPD").click(function(){
		$.ajax({
		  type:"POST",
		  url :"aksi/opd/tambah_opd.php",			
		  success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });
	
	  $('#isitableOPD').on('click','.btnEditOPD',function(){
		var idopd = $(this).data('id');
		$.ajax({
		  type:"POST",		
		  url :"aksi/opd/edit_opd.php",	
		  data:{idopd:idopd},
		  success:function(resp){
			$("#isianModEditData").html(resp);
			$("#isianModEditData").fadeIn(1000);
			$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			$("#modEditData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });
	
	  $('#isitableOPD').on('click','.btnHapusOPD',function(){
		var idopd = $(this).data('id');var nmopd = $(this).data('nmopd');
		let text = "Yakin menghapus data OPD\n"+nmopd;
		if (confirm(text) == true) {
		  $.ajax({
			type:"POST",		
			url :"aksi/opd/aksi_hapus.php",	
			data:{idopd:idopd},
			success:function(resp){
			  $("#ToastHapus").toast("show");
			  isiMasterOPD();	
			},
			error: function() {alert('Koneksi bermasalah periksa internet');},
		  });
		}  
	  });


	/*================ INSTANSI =================*/
	function isiMasterInstansi(){
		$('#tableInstansi').dataTable().fnDestroy();
		var idinstansi=$('#lblidinstansi').val();
		$.ajax({
		  type:"POST",
		  url : "aksi/isi_tabel_instansi.php",
		  data:{idinstansi:idinstansi},
		  dataType : 'json',
		  beforeSend: function(e) {
			$("#loading").fadeIn();
			document.body.style.cursor = "wait";
		  },
		  success:function(data){
			document.body.style.cursor = "default";
				  var html = '';
				  var i;
					  for(i=0; i<data.length; i++){
						html += 
						'<tr class="btn-reveal-trigger">'+
						  '<td class="align-middle" width="5%">'+data[i].no+'</td>'+
						  '<td class="align-middle" width="20%">'+data[i].nminstansi+'</td>'+
						  '<td class="align-middle" width="45%">'+data[i].alamat+' - '+data[i].kota+'</td>'+
						  '<td class="align-middle" width="20%">'+data[i].email+'</td>'+
						  '<td class="d-flex align-middle" width="10%">'+
							'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm me-2 btnEditInstansi" data-id="'+data[i].idinstansi+'"><span class="fas fa-edit"></span></button> '+
							'<button class="btn btn-light icon-item rounded-3 fs--2 icon-item-sm btnHapusInstansi" data-id="'+data[i].idinstansi+'" data-nminstansi="'+data[i].nminstansi+'"><span class="fas fa-trash"></span></button>'+
						  '</td>'+
						'</tr>';
						}			
						$('#isitableInstansi').html(html);
						$("#tableInstansi").dataTable({"paging": true, "lengthChange": false,"ordering": true,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
							  initComplete: function() {$(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');},"searching": true,});
							  $("#loading").fadeOut("slow");						
		  },
		  error: function() {
			$("#loading").fadeOut("slow");
			alert("Koneksi bermasalah periksa internet");
			document.body.style.cursor = "default";					
		  },
		});	
	  }
	
	  $("#cmdRefreshInstansi").click(function(){
		isiMasterInstansi();
	  });
	
	  $("#cmdTambahInstansi").click(function(){
		$.ajax({
		  type:"POST",
		  url :"aksi/instansi/tambah_instansi.php",			
		  success:function(resp){
			$("#isianModTambahData").html(resp);
			$("#isianModTambahData").fadeIn(1000);
			$("#modTambahData").modal({backdrop: 'static', keyboard: false}) 
			$("#modTambahData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });
	
	  $('#isitableInstansi').on('click','.btnEditInstansi',function(){
		var idinstansi = $(this).data('id');
		$.ajax({
		  type:"POST",		
		  url :"aksi/instansi/edit_instansi.php",	
		  data:{idinstansi:idinstansi},
		  success:function(resp){
			$("#isianModEditData").html(resp);
			$("#isianModEditData").fadeIn(1000);
			$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
			$("#modEditData").modal('show');
		  },
		  error: function() {alert('Koneksi bermasalah periksa internet');},
		});
	  });
	
	  $('#isitableInstansi').on('click','.btnHapusInstansi',function(){
		var idinstansi = $(this).data('id');var nminstansi = $(this).data('nminstansi');
		let text = "Yakin menghapus data instansi\n"+nminstansi;
		if (confirm(text) == true) {
		  $.ajax({
			type:"POST",		
			url :"aksi/instansi/aksi_hapus.php",	
			data:{idinstansi:idinstansi},
			success:function(resp){
				$("#ToastHapus").toast("show");
			  isiMasterInstansi();	
			},
			error: function() {alert('Koneksi bermasalah periksa internet');},
		  });
		}  
	  });

/* ============== IDENTITAS BUPATI =============== */
  $("#cmdIdentitasBupati").click(function(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url :"aksi/identitas-instansi/edit_identitas_bupati.php",			
	  data:{idinstansi:idinstansi},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  /* ============== IDENTITAS ASPRI =============== */
  $("#cmdIdentitasAspri").click(function(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url :"aksi/identitas-instansi/edit_identitas_aspri.php",			
	  data:{idinstansi:idinstansi},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });
	  
  /* ============== IDENTITAS SKPD =============== */
  $("#cmdIdentitasSKPD").click(function(){
	var idinstansi=$('#lblidinstansi').val();
	$.ajax({
	  type:"POST",
	  url :"aksi/identitas-instansi/edit_identitas_instansi.php",			
	  data:{idinstansi:idinstansi},
	  success:function(resp){
		$("#isianModEditData").html(resp);
		$("#isianModEditData").fadeIn(1000);
		$("#modEditData").modal({backdrop: 'static', keyboard: false}) 
		$("#modEditData").modal('show');
	  },
	  error: function() {alert('Koneksi bermasalah periksa internet');},
	});
  });

  var urlserver = "https://disposisi.jemberkab.go.id:4000";
  var socket_connect = function (room) {
	  return io(urlserver, {
		  query: 'r_var='+room
	  });
  }

  var idinstansi=$('#lblidinstansi').val();
  var socket = socket_connect(idinstansi);

  $(function(){		
	 socket.on('validasi terima', function(msg){
		 var halaman = $('#lblhalaman').val();
		 if (halaman == "inputdisposisi"){
			isiInputDisposisi();
		 }
	  });

  });
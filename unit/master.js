function bersihkan(){
	$("#lblhalaman").val("");
	$("#area-halaman").css("display","none");

	$("#area-dashboard").css("display","none");	
	$("#area-kop-dashboard").css("display","none");	

	$("#area-input-penanganan").css("display","none");
  $("#area-input-rujukan").css("display","none");	
  $("#area-laporan").css("display","none");
  }


function right(str, chr) {
    return str.slice(str.length-chr,str.length);
}
   
function left(str, chr) {
    return str.slice(0, chr - str.length);
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
  
  function awalTglLaporan(){
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
    newdate.setDate(newdate.getDate()+1); 
    var nd = new Date(newdate);
	
    tanggal2 = nd.getDate();
    bulan2 = nd.getMonth();
    tahun2 = nd.getFullYear();

    $("#txttanggalDashboard").val('01-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
    $("#txttanggalLaporan").val('01-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
  }

  $("#lv_dashboard").click(function(){
      bersihkan();           
      $("#area-halaman").fadeIn();
      //isiMasterPengunjung();
      $("#area-dashboard").fadeIn();
      $("#area-kop-dashboard").fadeIn();
      $("#lblhalaman").val("dashboard");
  });

  $("#lv_ditangani").click(function(){
      bersihkan();           
      $("#area-halaman").fadeIn();
      isiInputPenanganan();
      $("#area-input-penanganan").fadeIn();
      $("#lblhalaman").val("inputpelayanan");
  });

  $("#lv_dirujuk").click(function(){
    bersihkan();           
    $("#area-halaman").fadeIn();
    isiInputRujukan();
    $("#area-input-rujukan").fadeIn();
    $("#lblhalaman").val("inputrujukan");
  });

  $("#lv_laporan").click(function(){
    bersihkan();           
    $("#area-halaman").fadeIn();
    isiLaporan();
    $("#area-laporan").fadeIn();
    $("#lblhalaman").val("laporan");
  });

  /*================ JUMLAH SURAT =================*/
	function isiJumlahPelayanan(){
		var idugd=$('#lblidugd').val();
		$.ajax({
			type:"POST",
			url : "aksi/isi_jumlah.php",
			data:{idugd:idugd},
			dataType : 'json',			
			success:function(data){
				$("#lbljumbelum").text("0");$("#lbljumrujuk").text("0");	
				var i;
				for(i=0; i<data.length; i++){
					$("#lbljumbelum").text(data[i].jumdilayani);
          $("#lbljumrujuk").text(data[i].jumrujuk);
				}									
			},
		});	
	}

   /*================ INPUT PENANGANAN =================*/
   function isiInputPenanganan(){
    $('#tabelinputpenanganan').dataTable().fnDestroy();
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
            '<td class="align-middle text-center" width="10%">'+data[i].tgllayanan+'<br>'+
              '<span class="badge rounded-pill badge-soft-success">'+data[i].jamlayanan+'</span>'+
            '</td>'+
            '<td class="align-middle" width="20%">'+data[i].nmpasien+'<span><br>'+data[i].umur+' / '+data[i].kelamin+'</span>'+
              '<br><span class="badge badge-soft-' + warna +
                          '">' + data[i].ketgawat + '</span></td>'+
            '<td class="align-middle" width="25%">'+data[i].nmdiagnosa+'</td>'+
            '<td class="align-middle" width="40%">'+data[i].penangananawal+'<br>'+data[i].penanganan +'</td>'+		 
            '<td class="align-middle" width="5%">'+
              '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnEditPenanganan" data-bs-toggle="tooltip" title="Penanganan" data-idlayanan="'+data[i].idlayanan+'"><span class="fas fa-edit"></span></button> '+
            '</td>'+
          '</tr>';
          }			
          $('#isitabelinputpenanganan').html(html);
          $("#tabelinputpenanganan").dataTable({"paging": false, "lengthChange": false,"ordering": false,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
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

  $("#cmdRefreshPenanganan").click(function(){
	  isiInputPenanganan();
  });

  $('#isitabelinputpenanganan').on('click','.btnEditPenanganan',function(){
	var idlayanan = $(this).data('idlayanan');
	var idoperator = $("#lbleditor").val();
	$.ajax({
	  type:"POST",		
	  url :"aksi/trans-penanganan/edit_penanganan.php",	
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
  
   /*================ INPUT RUJUKAN =================*/
   function isiInputRujukan(){
    $('#tabelinputrujukan').dataTable().fnDestroy();
    var idugd=$('#lblidugd').val();
    $.ajax({
      type:"POST",
      url : "aksi/isi_tabel_rujukan.php",
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
            '<td class="align-middle text-center" width="10%">'+data[i].tgllayanan+'<br>'+
              '<span class="badge rounded-pill badge-soft-success">'+data[i].jamlayanan+'</span>'+
            '</td>'+
            '<td class="align-middle" width="20%">'+data[i].nmpasien+'<span><br>'+data[i].umur+' / '+data[i].kelamin+'</span>'+
              '<br><span class="badge badge-soft-' + warna +
                          '">' + data[i].ketgawat + '</span></td>'+
            '<td class="align-middle" width="27%">'+data[i].nmdiagnosa+'<br><span class="badge bg-primary">'+data[i].nmugd+'</span></td>'+
            '<td class="align-middle fs--2" width="38%">'+data[i].penangananawal+'<br><br>'+data[i].penanganan +'</td>'+		 
            '<td class="align-middle" width="5%">'+
              '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnEditRujukan" data-bs-toggle="tooltip" title="Penanganan" data-idlayanan="'+data[i].idlayanan+'"><span class="fas fa-edit"></span></button> '+
            '</td>'+
          '</tr>';
          }			
          $('#isitabelinputrujukan').html(html);
          $("#tabelinputrujukan").dataTable({"paging": false, "lengthChange": false,"ordering": false,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
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

  $("#cmdRefreshRujukan").click(function(){
	  isiInputRujukan();
  });

  $('#isitabelinputrujukan').on('click','.btnEditRujukan',function(){
    var idlayanan = $(this).data('idlayanan');
    var idoperator = $("#lbleditor").val();
    $.ajax({
      type:"POST",		
      url :"aksi/trans-penanganan/edit_penanganan_rujukan.php",	
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

     /*================ LAPORAN =================*/
     function isiLaporan(){
      $('#tabellaporan').dataTable().fnDestroy();
      var idugd=$('#lblidugd').val();
      var rangetanggal = $("#txttanggalLaporan").val();
      var tglawal = left(rangetanggal,10);
      var tglakhir = right(rangetanggal,10);
      if (tglawal.length <= 9 || tglawal.length <= 9){alert("Maaf, range tanggal pelaporan tidak valid");}
      else {
        $.ajax({
          type:"POST",
          url : "aksi/isi_tabel_laporan.php",
          data: {idugd: idugd,tglawal: tglawal,tglakhir: tglakhir},
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
              '<td class="align-middle text-center" width="10%">'+data[i].tgllayanan+'<br>'+
                '<span class="badge rounded-pill badge-soft-success">'+data[i].jamlayanan+'</span>'+
              '</td>'+
              '<td class="align-middle" width="20%">'+data[i].nmpasien+'<span><br>'+data[i].umur+' / '+data[i].kelamin+'</span>'+
                '<br><span class="badge badge-soft-' + warna +
                            '">' + data[i].ketgawat + '</span></td>'+
              '<td class="align-middle" width="27%">'+data[i].nmdiagnosa+'<br><span class="badge bg-primary">'+data[i].nmugd+'</span></td>'+
              '<td class="align-middle fs--2" width="38%">'+data[i].penangananawal+'<br><br>'+data[i].penanganan +'</td>'+
              '<td class="align-middle" width="10%">'+
                  '<span class="badge rounded-pill badge-soft-warning">'+data[i].sttspasien+'</span>'+
              '</td>'+	
            '</tr>';

              }			
              $('#isitabellaporan').html(html);
              $("#tabellaporan").dataTable({"paging": true, "lengthChange": false,"ordering": false,"info": false,"autoWidth": false,"responsive": true,"select": false,"scrollX": false,
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
    }
  
    $("#cmdRefreshLaporan").click(function(){
      isiLaporan();
    });

    $("#cmdExportLaporan").click(function(){
      var idugd=$('#lblidugd').val();
      var rangetanggal = $("#txttanggalLaporan").val();
      var tglawal = left(rangetanggal,10);
      var tglakhir = right(rangetanggal,10);

      var urlx = "../laporan-excel/excel_lap_rekap_harian.php?idugd="+idugd+"&tglawal="+tglawal+"&tglakhir="+tglakhir;
      window.open(urlx,'_blank');
    });

  Chart.defaults.global.defaultFontColor = "#fff";

  var ctx = document.getElementById('gawatChart').getContext("2d")
  var gradient = ctx.createLinearGradient(0, 0, 0, 200)
  gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
  gradient.addColorStop(0, '#b2d1f0')

  function grafikLayanan(){
      var idugd = $("#lblidugd").val();
      var rangetanggal = $("#txttanggalDashboard").val();
      var tglawal = left(rangetanggal,10);
      var tglakhir = right(rangetanggal,10);
  
      $.ajax({
        type:"POST",
        url : "aksi/ambil_grafik_layanan.php",
        data: {idugd: idugd,tglawal: tglawal,tglakhir: tglakhir},
        async : false,
        dataType : 'json',				
        beforeSend: function(e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success:function(data){			
            var labels = [];
            var valrujuk = [];var vallayan = [];
            myArray = data;
            $.each(myArray, function(index, jum) {
                labels.push(jum.sttsgawat);
                valrujuk.push(jum.jumRujuk);
                vallayan.push(jum.jumDilayani);
            });				
                    
                var hitChartContent = document.getElementById('hitungpelayananChart');
                hitChartContent.innerHTML = '';
                $('#hitungpelayananChart').append('<canvas id="pelayananChart" style="height:300px"><canvas>');
              
                var salesChartCanvas = $('#pelayananChart').get(0).getContext('2d')
                var salesChartData = {
                  labels  : labels,
                  datasets: [
                    {
                      label               : 'Dilayani',
                      backgroundColor		  : '#2ECC40',
                      borderColor         : '#2ECC40',
                      data                : vallayan,
                    },
                    {
                      label               : 'Dirujuk',
                      backgroundColor		  : '#FF4136',
                      borderColor         : '#FF4136',
                      data                : valrujuk,
                    },
                  ]
                }

                var salesChartOptions = {
                  maintainAspectRatio : false,
                  responsive : true,
                  legend: {
                    display: true,
                    labels: {
                      fontColor: 'rgb(255, 255, 255,0.9)'
                    }
                  },
                  animation: {
                    animateScale: true,
                    animateRotate: true
                  },
                  tooltips: {
                    mode: 'index',
                    intersect: false,
                    enabled: true,
                    callbacks: {
                      label: function (tooltipItems, data) {
                          return data.datasets[tooltipItems.datasetIndex].label + ' : ' + tooltipItems.yLabel.toLocaleString();
                      }
                  },	
                  },
                  hover: {
                    mode: 'nearest',
                    intersect: true
                  },	
                  scales: {
                    xAxes: [{
                      ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)'},
                      gridLines : {display : false,},
                      barPercentage: 0.6
                    }],
                    yAxes: [{
                      ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)',beginAtZero: true},
                      gridLines : {display : true,color:"#0d6ecf"}
                    }]
                  }
                }
                var salesChart = new Chart(salesChartCanvas, { 
                    type: 'bar', 
                    data: salesChartData, 
                    options: salesChartOptions
                  }
                )

                $("#loading").fadeOut("slow");	
                document.body.style.cursor = "default";

        },
        error: function() {
            $("#loading").fadeOut("slow");	
            document.body.style.cursor = "default";					
        },
    });		
}

  function grafikLayananKegawatan(){
    var idugd = $("#lblidugd").val();
    var rangetanggal = $("#txttanggalDashboard").val();
    var tglawal = left(rangetanggal,10);
    var tglakhir = right(rangetanggal,10);

      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_kegawatan.php",
          data: {idugd: idugd,tglawal: tglawal,tglakhir: tglakhir},
          async : false,
          dataType : 'json',			
          success:function(data){	
              var labels = [];
              var values = [];
              myArray = data;
              $.each(myArray, function(index, jum) {
                  document.body.style.cursor = "default";	
                  $("#loading").fadeOut("slow");
  
                  labels.push(jum.nmbentuksekolah);
                  values.push(jum.jumDetSekolah);
  
                  var hitChartContent = document.getElementById('hitunggawatChart');
                  hitChartContent.innerHTML = '';
                  $('#hitunggawatChart').append('<canvas id="gawatChart" style="height:300px"><canvas>');
    
                  var salesChartCanvas = $('#gawatChart').get(0).getContext('2d')
                  var salesChartData = {
                      labels: labels,
                          datasets: [
                              {
                              label                   : 'Jumlah',
                              borderColor             : ["#FF4136", "#FF851B", "#2ECC40", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                              backgroundColor         : ["#FF4136", "#FF851B", "#2ECC40", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                              data                    : values,
                              },
                          ]
                  }
                  
                  var salesChartOptions = {
                    maintainAspectRatio : false,
                    responsive : true,
                    legend: {
                      display: true,
                      labels: {
                        fontColor: 'rgb(255, 255, 255,0.9)'
                      }
                    },
                    
                    animation: {
                      animateScale: true,
                      animateRotate: true
                    },
                    hover: {
                      mode: 'nearest',
                      intersect: true
                    },	
                  }
                  var salesChart = new Chart(salesChartCanvas, { 
                      type: 'pie', 
                      data: salesChartData, 
                      options: salesChartOptions,
                  })
              }); 
          },
          error: function() {
              $("#loading").fadeOut("slow");
              document.body.style.cursor = "default";				
          },				
      });		
  }	

  $("#cmdGrafikRefresh").click(function(){
    grafikLayanan();
	  grafikLayananKegawatan();
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
			isiInputPenanganan();
		 }
	  });

  });
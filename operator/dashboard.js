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

	$("#txttanggalLapLayanan").val('01-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
   // $("#txttanggalLapUnit").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
  }

/////////////////////////////////////
///////// GRAFIK + TABEL ////////////
/////////////////////////////////////
$("#cmdGrafikRefresh").on('click',function(){
    grafikLayananUmur();
    grafikLayananKegawatan(); 
    grafikLayananJK();
    grafikLayananSymptom();
    grafikLayananFaskes();
});

Chart.defaults.global.defaultFontColor = "#fff";

var ctx = document.getElementById('umurChart').getContext("2d")
var gradient = ctx.createLinearGradient(0, 0, 0, 200)
gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)')
gradient.addColorStop(0, '#b2d1f0')

function grafikTotalBencana(){
  //var keterangan =  $("#txttransketerangan").val();
  //var idarea = $("#txttransid").val();
  //if (keterangan == "kota"){var Urlnya = "aksi/ambil_grafik_bencana.php";}
  //else  if (keterangan == "kecamatan"){var Urlnya = "aksi/ambil_grafik_bencana_kecamatan.php";}
  //else  if (keterangan == "desa"){var Urlnya = "aksi/ambil_grafik_bencana_desa.php";}
    $.ajax({
        type:"POST",
        url : "aksi/ambil_grafik_bencana.php",
        //data: {idarea: idarea},
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

                const allData = [];
                for (let i = 0; i < labels.length; ++i) {
                    allData.push({
                        label: labels[i],
                        data: values[i]
                    });
                }

                allData.sort((b, a) => a.data - b.data);

                const sortedLabels = allData.map(e => e.label);
                const sortedData = allData.map(e => e.data);

                var hitChartContent = document.getElementById('hitungUmurChart');
                hitChartContent.innerHTML = '';
                $('#hitungUmurChart').append('<canvas id="umurChart"><canvas>');
  
                var salesChartCanvas = $('#umurChart').get(0).getContext('2d')
                var salesChartData = {
                    labels: sortedLabels,
                        datasets: [
                            {
                            label                   : 'Jumlah',
                            borderColor             : 'rgb(255, 255, 255,0.6)',
                            //backgroundColor         : gradient,
                            backgroundColor         : ["#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                            fill                    : true,
                            pointBorderColor        : 'rgba(0, 0, 0, 0)',
                            pointBackgroundColor    : 'rgba(0, 0, 0, 0)',
                            pointHoverBackgroundColor: 'rgb(54, 162, 235)',                                   
                            pointHoverBorderColor   : 'rgb(54, 162, 235)',
                            data                    : sortedData,
                            },
                        ]
                }
                
                var salesChartOptions = {
                    maintainAspectRatio : true,
                    responsive : true,
                    elements: {
                        point: {
                            radius: 0,
                            hitRadius: 10,
                            hoverRadius: 8
                        },
                    },
                    legend: {
                        display: false
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: false
                    },	
                    scales: {
                        xAxes: [{
                            ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)'},
                            gridLines : {display : false,color:"#0d6ecf"},
                            barPercentage: 0.4
                        }],
                        yAxes: [{
                            ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)',beginAtZero: true},
                            gridLines : {display : true,color:"#0d6ecf"},
                            barPercentage: 0.4
                        }]
                    }
                    
                }
                var salesChart = new Chart(salesChartCanvas, { 
                    type: 'bar', 
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


function grafikGender(){
    $.ajax({
        type:"POST",
        url : "aksi/ambil_grafik_gender.php",
        //data: {idarea: idarea},
        async : false,
        dataType : 'json',
        beforeSend: function(e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success:function(data){	 
            //var labels = [];

            var valrs = [];var valpus = [];var valklin = [];
            myArray = data;
            $.each(myArray, function(index, jum) {                  
                valrs.push(jum.jumRSUD);
                valpus.push(jum.jumPuskesmas);valklin.push(jum.jumKlinik);
            });				

            datax=[valrs,valpus,valklin];
            legend=['RSUD','Puskesmas','Klinik'];
            total = datax.reduce((accumulator, currentValue) => parseInt(accumulator) + parseInt(currentValue));
            labelsvalues = datax.map(function(value,i){
            let p= Math.round((value / total) * 100) + '%';
            return legend[i]+' '+p;
            });

  var hitChartContent = document.getElementById('hitungChartContentADMIN');
  hitChartContent.innerHTML = '';
  $('#hitungChartContentADMIN').append('<canvas id="hitungChartADMIN"><canvas>');
  
  var salesChartCanvas = $('#hitungChartADMIN').get(0).getContext('2d')
  var salesChartData = {
    labels  : labelsvalues,
    datasets: [
      {
        label               : 'Jumlah',
        data                : datax,
        backgroundColor		  : ["#FF4136", "#2ECC40", "#FF851B"],
        borderColor         : ["#FF4136", "#2ECC40", "#FF851B"]          
      }
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
      type: 'doughnut', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )

//////////////////////////////////////////////////////////////////// 				
                $("#loading").fadeOut("slow");	
                document.body.style.cursor = "default";

        },
        error: function() {
            $("#loading").fadeOut("slow");	
            //toastr.error('Koneksi bermasalah periksa internet');
            document.body.style.cursor = "default";					
        },
    });		
}

function grafikLayananUmur(){
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_umur.php",
          data: {tglawal: tglawal,tglakhir: tglakhir},
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
  
                  const allData = [];
                  for (let i = 0; i < labels.length; ++i) {
                      allData.push({
                          label: labels[i],
                          data: values[i]
                      });
                  }
  
                  allData.sort((b, a) => a.data - b.data);
  
                  const sortedLabels = allData.map(e => e.label);
                  const sortedData = allData.map(e => e.data);
  
                  var hitChartContent = document.getElementById('hitungLayanUmurChart');
                  hitChartContent.innerHTML = '';
                  $('#hitungLayanUmurChart').append('<canvas id="LayanUmurChart"><canvas>');
    
                  var salesChartCanvas = $('#LayanUmurChart').get(0).getContext('2d')
                  var salesChartData = {
                      labels: sortedLabels,
                          datasets: [
                              {
                              label                   : 'Jumlah',
                              borderColor             : 'rgb(255, 255, 255,0.6)',
                              //backgroundColor         : gradient,
                              backgroundColor         : ["#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                              fill                    : true,
                              pointBorderColor        : 'rgba(0, 0, 0, 0)',
                              pointBackgroundColor    : 'rgba(0, 0, 0, 0)',
                              pointHoverBackgroundColor: 'rgb(54, 162, 235)',                                   
                              pointHoverBorderColor   : 'rgb(54, 162, 235)',
                              data                    : sortedData,
                              },
                          ]
                  }
                  
                  var salesChartOptions = {
                      maintainAspectRatio : true,
                      responsive : true,
                      elements: {
                          point: {
                              radius: 0,
                              hitRadius: 10,
                              hoverRadius: 8
                          },
                      },
                      legend: {
                          display: false
                      },
                      animation: {
                          animateScale: true,
                          animateRotate: true,
                      },
                      tooltips: {
                          mode: 'index',
                          intersect: false,
                      },
                      hover: {
                          mode: 'nearest',
                          intersect: false
                      },	
                      scales: {
                          xAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)'},
                              gridLines : {display : false,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }],
                          yAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)',beginAtZero: true},
                              gridLines : {display : true,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }]
                      }
                      
                  }
                  var salesChart = new Chart(salesChartCanvas, { 
                      type: 'bar', 
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
  
  function grafikLayananKegawatan(){
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_kegawatan.php",
          data: {tglawal: tglawal,tglakhir: tglakhir},
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
  
                  const allData = [];
                  for (let i = 0; i < labels.length; ++i) {
                      allData.push({
                          label: labels[i],
                          data: values[i]
                      });
                  }
  
                  allData.sort((b, a) => a.data - b.data);
  
                  const sortedLabels = allData.map(e => e.label);
                  const sortedData = allData.map(e => e.data);
  
                  var hitChartContent = document.getElementById('hitunggawatChart');
                  hitChartContent.innerHTML = '';
                  $('#hitunggawatChart').append('<canvas id="gawatChart"><canvas>');
    
                  var salesChartCanvas = $('#gawatChart').get(0).getContext('2d')
                  var salesChartData = {
                      labels: sortedLabels,
                          datasets: [
                              {
                              label                   : 'Jumlah',
                              borderColor             : 'rgb(255, 255, 255,0.6)',
                              backgroundColor         : gradient,
                              //backgroundColor         : ["#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                              fill                    : true,
                              pointBorderColor        : 'rgba(0, 0, 0, 0)',
                              pointBackgroundColor    : 'rgba(0, 0, 0, 0)',
                              pointHoverBackgroundColor: 'rgb(54, 162, 235)',                                   
                              pointHoverBorderColor   : 'rgb(54, 162, 235)',
                              data                    : sortedData,
                              },
                          ]
                  }
                  
                  var salesChartOptions = {
                      maintainAspectRatio : true,
                      responsive : true,
                      elements: {
                          point: {
                              radius: 0,
                              hitRadius: 10,
                              hoverRadius: 8
                          },
                      },
                      legend: {
                          display: false
                      },
                      animation: {
                          animateScale: true,
                          animateRotate: true,
                      },
                      tooltips: {
                          mode: 'index',
                          intersect: false,
                      },
                      hover: {
                          mode: 'nearest',
                          intersect: false
                      },	
                      scales: {
                          xAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)'},
                              gridLines : {display : false,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }],
                          yAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)',beginAtZero: true},
                              gridLines : {display : true,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }]
                      }
                      
                  }
                  var salesChart = new Chart(salesChartCanvas, { 
                      type: 'line', 
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
  
  function grafikLayananJK(){
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);
      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_jk.php",
          data: {tglawal: tglawal,tglakhir: tglakhir},
          async : false,
          dataType : 'json',
          beforeSend: function(e) {
              $("#loading").fadeIn();
              document.body.style.cursor = "wait";
          },
          success:function(data){	 

              var valLaki = [];var valWan = [];
              myArray = data;
              $.each(myArray, function(index, jum) {                  
                valLaki.push(jum.jumLaki);
                valWan.push(jum.jumPerempuan);
              });				
  
              datax=[valLaki,valWan];
              legend=['Laki-laki','Perempuan'];
              total = datax.reduce((accumulator, currentValue) => parseInt(accumulator) + parseInt(currentValue));
              labelsvalues = datax.map(function(value,i){
              let p= Math.round((value / total) * 100) + '%';
              return legend[i]+' '+p;
              });
  
    var hitChartContent = document.getElementById('hitungJKChart');
    hitChartContent.innerHTML = '';
    $('#hitungJKChart').append('<canvas id="JKChart"><canvas>');
    
    var salesChartCanvas = $('#JKChart').get(0).getContext('2d')
    var salesChartData = {
      labels  : labelsvalues,
      datasets: [
        {
          label               : 'Jumlah',
          data                : datax,
          backgroundColor		  : ["#FF4136", "#2ECC40", "#FF851B"],
          borderColor         : ["#FF4136", "#2ECC40", "#FF851B"]          
        }
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
        type: 'polarArea', 
        data: salesChartData, 
        options: salesChartOptions
      }
    )
  
  //////////////////////////////////////////////////////////////////// 				
                  $("#loading").fadeOut("slow");	
                  document.body.style.cursor = "default";
  
          },
          error: function() {
              $("#loading").fadeOut("slow");	
              //toastr.error('Koneksi bermasalah periksa internet');
              document.body.style.cursor = "default";					
          },
      });		
  }

  function grafikLayananSymptom(){
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_symptom.php",
          data: {tglawal: tglawal,tglakhir: tglakhir},
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
  
                  const allData = [];
                  for (let i = 0; i < labels.length; ++i) {
                      allData.push({
                          label: labels[i],
                          data: values[i]
                      });
                  }
  
                  allData.sort((b, a) => a.data - b.data);
  
                  const sortedLabels = allData.map(e => e.label);
                  const sortedData = allData.map(e => e.data);
  
                  var hitChartContent = document.getElementById('hitunggejalaChart');
                  hitChartContent.innerHTML = '';
                  $('#hitunggejalaChart').append('<canvas id="gejalaChart" style="height:250px !important"><canvas>');
    
                  var salesChartCanvas = $('#gejalaChart').get(0).getContext('2d')
                  var salesChartData = {
                      labels: sortedLabels,
                          datasets: [
                              {
                              label                   : 'Jumlah',
                              borderColor             : 'rgb(255, 255, 255,0.6)',
                              backgroundColor         : gradient,
                              //backgroundColor         : ["#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE","#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00"],
                              fill                    : true,
                              pointBorderColor        : 'rgba(0, 0, 0, 0)',
                              pointBackgroundColor    : 'rgba(0, 0, 0, 0)',
                              pointHoverBackgroundColor: 'rgb(54, 162, 235)',                                   
                              pointHoverBorderColor   : 'rgb(54, 162, 235)',
                              data                    : sortedData,
                              },
                          ]
                  }
                  
                  var salesChartOptions = {
                      maintainAspectRatio : false,
                      responsive : true,
                      elements: {
                          point: {
                              radius: 0,
                              hitRadius: 10,
                              hoverRadius: 8
                          },
                      },
                      legend: {
                          display: false
                      },
                      animation: {
                          animateScale: true,
                          animateRotate: true,
                      },
                      tooltips: {
                          mode: 'index',
                          intersect: false,
                      },
                      hover: {
                          mode: 'nearest',
                          intersect: false
                      },	
                      scales: {
                          xAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)'},
                              gridLines : {display : false,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }],
                          yAxes: [{
                              ticks: {display: true,fontColor: 'rgb(255, 255, 255,0.6)',beginAtZero: true},
                              gridLines : {display : true,color:"#0d6ecf"},
                              barPercentage: 0.4
                          }]
                      }
                      
                  }
                  var salesChart = new Chart(salesChartCanvas, { 
                      type: 'line', 
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
  
  function grafikLayananFaskes(){
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);
      $.ajax({
          type:"POST",
          url : "aksi/ambil_grafik_layanan_ugd.php",
          data: {tglawal: tglawal,tglakhir: tglakhir},
          async : false,
          dataType : 'json',
          beforeSend: function(e) {
              $("#loading").fadeIn();
              document.body.style.cursor = "wait";
          },
          success:function(data){	 

              var valrs = [];var valpus = [];var valklin = [];
              myArray = data;
              $.each(myArray, function(index, jum) {                  
                valrs.push(jum.jumRS);
                valpus.push(jum.jumPus);valklin.push(jum.jumKlin);
              });				
  
              datax=[valrs,valpus,valklin];
              legend=['RSUD','Puskesmas','Klinik'];
              total = datax.reduce((accumulator, currentValue) => parseInt(accumulator) + parseInt(currentValue));
              labelsvalues = datax.map(function(value,i){
              let p= Math.round((value / total) * 100) + '%';
              return legend[i]+' '+p;
              });
  
    var hitChartContent = document.getElementById('hitungfaskesChart');
    hitChartContent.innerHTML = '';
    $('#hitungfaskesChart').append('<canvas id="faskesChart"><canvas>');
    
    var salesChartCanvas = $('#faskesChart').get(0).getContext('2d')
    var salesChartData = {
      labels  : labelsvalues,
      datasets: [
        {
          label               : 'Jumlah',
          data                : datax,
          backgroundColor	: ["#FF4136", "#2ECC40", "#FF851B"],
          borderColor         : ["#FF4136", "#2ECC40", "#FF851B"]          
        }
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
        options: salesChartOptions
      }
    )
  
  //////////////////////////////////////////////////////////////////// 				
                  $("#loading").fadeOut("slow");	
                  document.body.style.cursor = "default";
  
          },
          error: function() {
              $("#loading").fadeOut("slow");	
              //toastr.error('Koneksi bermasalah periksa internet');
              document.body.style.cursor = "default";					
          },
      });		
  }

  

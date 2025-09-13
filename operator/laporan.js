function refreshGis() {
        map.off();
        map.remove();
        initMap();
        init(); 
}

function ambilSemuaUnit() {
    $.ajax({
        type: "POST",
        url: 'aksi/ambil_semua_unit.php',
        dataType: "json",
        beforeSend: function(e) {
            document.body.style.cursor = "wait";
        },
        success: function(data) {
            document.body.style.cursor = "default";

            var globalidsdkON = [];var globalidsdk = [];  
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {

                globalidsdk.push(data[i].idsdk);
                if (data[i].sttslayanan == "N") {
                    var disproses = "display:none";
                } else {
                    var disproses = "";
                    globalidsdkON.push(data[i].idsdk);
                }

                if (data[i].ketgawat == 'Meninggal') {
                    var warna = "secondary";
                } else if (data[i].ketgawat == 'Gawat Darurat') {
                    var warna = "danger";
                }else if (data[i].ketgawat == 'Gawat Tidak Darurat') {
                    var warna = "warning";
                }else if (data[i].ketgawat == 'Tidak Gawat Darurat') {
                    var warna = "info";
                }

                html += (
                    '<li class="nav-item">'+
                                '<a class="nav-link lv_unit" data-idunit="' + data[i].idunit + '"'+
                                'data-nmunit="' + data[i].nmunit + '" data-nmugd="' + data[i].nmugd + '"'+
                                ' data-idsdk="' + data[i].idsdk + '" data-idugd="' + data[i].idugd + '"'+
                                ' data-sttslayanan="' + data[i].sttslayanan +  '"'+
                                '    href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">'+
                                '    <div class="d-flex align-items-center">'+
                                '        <span class="nav-link-icon"><span class="fas fa-ambulance"></span></span>'+
                                '       <span class="nav-link-text ps-1">' + data[i].nmunit + '</span>'+
                                '       <span class="badge rounded-pill ms-2 bg-'+ warna +'" style="' + disproses + '">ON</span>'+
                                '  </div>'+
                                '</a>'+
                            '</li>');
            }
            $("#lblGlobalUnitMelayani").val(globalidsdkON);
            $("#lblGlobalUnit").val(globalidsdk);
            $('#menu-unit-ambulan').html(html);
            $("#loading").fadeOut("slow");
        },
        error: function() {
            document.body.style.cursor = "default";
            $("#loading").fadeOut("slow");
            alert('Koneksi bermasalah periksa internet');
        }
    });
}

$("#lv_tampilmap").on('click',function(){
    var tampilan = $("#lblkettampilmap").text();
    if (tampilan == "Sembunyikan Map"){
        $("#area-map").fadeOut("slow");   
        $("#lblkettampilmap").text("Tampilkan Map");
    } else if (tampilan == "Tampilkan Map"){
        $("#area-map").fadeIn();
        $("#lblkettampilmap").text("Sembunyikan Map");
    }
});

$("#lv_sinkron").on('click',function(){
    initReport(); 
   // executeReportArrUnit(); 
    test()   
});

$("#lv_pelayanan").on('click',function(){
    bersihkanHalaman();
    isiTabelLayanan();
    $("#area-tabel-layanan").fadeIn();
});

$("#lv_lap_unit").on('click',function(){
    $("#txttransid").val("");
    bersihkanHalaman(); 
    isiTabelLapUnit();
    $("#txttransmenu").val("lapunit");
    $("#area-tabel-ambulan").fadeIn();
    $("#divtabellapambulan").fadeIn();
});
/*
$(".lv_desa").on('click',function(){
    const coordinates = $(this).data('koordinat');
    var coords = coordinates.split(',');
    var latitude = coords[0];
    var longitude = coords[1];

    map.setView({
        lat: latitude,
        lng: longitude
    },18);  
});
*/
$('#menu-unit-ambulan').on('click', '.lv_unit', function() {
    var idsdk = $(this).data('idsdk');

    var val = idsdk; 
    if (!val) return;
    var unit = wialon.core.Session.getInstance().getItem(val); 
    if (!unit) return; 
    var pos = unit.getPosition(); 
    if (!pos) return; 
    map.setView({
        lat: pos.y,
        lng: pos.x
    },20);     
    
    bersihkanHalaman();

    $("#txttransid").val("");
    var idunit = $(this).data('idunit');
    $("#txttransid").val(idsdk);

    isiTabelLapDetailUnit();
    //show_track ();

    $("#txttransmenu").val("lapdetailunit");
    $("#area-tabel-ambulan").fadeIn();
    $("#divtabeldetaillapambulan").fadeIn();

});

function right(str, chr) {
    return str.slice(str.length-chr,str.length);
}
   
function left(str, chr) {
    return str.slice(0, chr - str.length);
}

////////////////////////////////////
////////// TABEL LAYANAN ///////////
////////////////////////////////////
function isiTabelLayanan() {   
    var rangetanggal = $("#txttanggalLapLayanan").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

    if($("#chkMelayani").is(':checked')){var sttsmelayani = "Y";} else {var sttsmelayani = "N";}
    if($("#chkSelesai").is(':checked')){var sttsselesai = "Y";} else {var sttsselesai = "N";}

    var jk = $("#cbokelamin").val();
    var umur = $("#cboumur").val();
    var gawat = $("#cbokategorigawat").val();
    var symptom = $("#cbolapdiagnosa").val();
    var ugd = $("#cbolapUGD").val();

    if (sttsmelayani == "Y" && sttsselesai == "Y" && symptom == ""){var URLnya = "aksi/report/isi_tabel_layanan.php";}
    else if (sttsmelayani == "N" && sttsselesai == "Y" && symptom == ""){var URLnya = "aksi/report/isi_tabel_layanan_selesai.php";}
    else if (sttsmelayani == "Y" && sttsselesai == "N" && symptom == ""){var URLnya = "aksi/report/isi_tabel_layanan_melayani.php";}
    
    else if (sttsmelayani == "Y" && sttsselesai == "Y" && symptom != ""){var URLnya = "aksi/report/isi_tabel_layanan_symptom.php";}
    else if (sttsmelayani == "N" && sttsselesai == "Y" && symptom != ""){var URLnya = "aksi/report/isi_tabel_layanan_symptom_selesai.php";}
    else if (sttsmelayani == "Y" && sttsselesai == "N" && symptom != ""){var URLnya = "aksi/report/isi_tabel_layanan_symptom_melayani.php";}

    if (sttsmelayani == "N" && sttsselesai == "N"){alert("Anda tidak memilih salah satu atau keduanya\nStatus melayani / Status selesai\nCentang salah satu atau keduanya");}
    else {
        $('#tabellayanan').dataTable().fnDestroy(); 
        $.ajax({
            type: "POST",
            url: URLnya,
            data:{tglawal:tglawal,tglakhir:tglakhir,jk:jk,umur:umur,gawat:gawat,symptom:symptom,ugd:ugd},
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    if (data[i].ketgawat == 'Meninggal') {
                        var warna = "secondary";
                    } else if (data[i].ketgawat == 'Gawat Darurat') {
                        var warna = "danger";
                    }else if (data[i].ketgawat == 'Gawat Tidak Darurat') {
                        var warna = "warning";
                    }else if (data[i].ketgawat == 'Tidak Gawat Darurat') {
                        var warna = "info";
                    }

                    if (data[i].sttslayanan == 'Y') {
                        var wrnstatus = "success";var statusx = "Melayani";var timestatus = data[i].tgllayanan + "&nbsp;&nbsp;" + data[i].jamlayanan;
                    } else if (data[i].sttslayanan == 'N') {
                        var wrnstatus = "secondary";var statusx = "Selesai";var timestatus = data[i].tglselesai + "&nbsp;&nbsp;" + data[i].jamselesai;
                    }

                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle" width="10%">' + data[i].tgllayanan + '<br>' + data[i]
                        .jamlayanan + '</td>' +
                        '<td class="align-middle" width="17%">' + data[i].nmpasien + '<br>' + data[i].umur +
                        ' / ' + data[i].kelamin + '</td>' +
                        '<td class="align-middle" width="10%"><span class="badge badge-soft-' + warna +
                        '">' + data[i].ketgawat + '</span></td>' +
                        '<td class="align-middle" width="33%">' + data[i].nmdiagnosa + '</td>' +
                        '<td class="align-middle" width="17%">' + data[i].nmugd + '</td>' +
                        '<td class="align-middle text-center" width="8%"><span class="badge badge-soft-' + wrnstatus +
                        '">' + statusx + '<br>'+ timestatus +'</span></td>' +
                        '<td class="d-flex align-middle" width="5%">'+
                        '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnTimeline" data-id="'+data[i].idlayanan+'" data-idunit="'+data[i].idunit+'" data-nmpasien="'+data[i].nmpasien+'"><span class="fas fa-clock"></span></button>'+
                        '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnLokasiUnit" data-idsdk="'+data[i].idsdk+'"><span class="fas fa-map-marker-alt"></span></button>'+
                        '</td>'+
                        '</tr>';
                }
                $('#isitabellayanan').html(html);
                $("#tabellayanan").dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": true,
                    "select": false,
                    "scrollX": false,
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>')
                            .parent().attr('autocomplete', 'off');
                    },
                    "searching": true,
                });
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

$("#cmdLapFilterLayanan").on('click',function(){
    $("#chkMelayani").prop("checked", true); 
    $("#chkSelesai").prop("checked", true);

    $("#cbokelamin").val('').trigger('change');
	$("#cboumur").val('').trigger('change');

	$("#cbolapdiagnosa").val('').trigger('change');
	$("#cbokategorigawat").val('').trigger('change');

	$("#cbolapUGD").val('').trigger('change');
    
    $("#isianmodLaporan").fadeIn(1000);
    $("#modLaporan").modal('show');
});

$("#cmdKriteriaLaporan").on('click',function(){
    terapkanHtmlFilter();
    isiTabelLayanan();
    ambilSemuaUnit();
});

$("#cmdLapRefreshLayanan").on('click',function(){
    terapkanHtmlFilter();
    isiTabelLayanan();
    ambilSemuaUnit();
});

$('#isitabellayanan').on('click','.btnTimeline',function(){
    var idlayanan = $(this).data('id');var nmpasien = $(this).data('nmpasien');
    var idunit = $(this).data('idunit');
    let text = "Yakin Anda merubah status layanan\nPasien "+nmpasien;
    if (confirm(text) == true) {
 /*       
        $.ajax({
            type:"POST",		
            url :"aksi/aksi_ubah_layanan.php",	
            data:{idlayanan:idlayanan,idunit:idunit},
            dataType: "json",
            success:function(resp){
                alert(resp);
                ambilSemuaUnit();
                isiTabelLayanan();
                refreshGis();
            },
            error: function() {alert('Koneksi bermasalah periksa internet');},
        });
        */
    }  
});

$('#isitabellayanan').on('click','.btnLokasiUnit',function(){
    var idsdk = $(this).data('idsdk');
    var val = idsdk; 
    if (!val) return; 
    var unit = wialon.core.Session.getInstance().getItem(val);
    if (!unit) return;
    var pos = unit.getPosition(); 
    if (!pos) return; 

    map.setView({
        lat: pos.y,
        lng: pos.x
    },20);      
});

////////////////////////////////////
////////// TABEL AMBULAN ///////////
////////////////////////////////////
function isiTabelLapUnit() {   
    var rangetanggal = $("#txttanggalLapUnit").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

        $('#tabellapambulan').dataTable().fnDestroy(); 
        $.ajax({
            type: "POST",
            url: "aksi/report/isi_tabel_unit.php",
            data:{tglawal:tglawal,tglakhir:tglakhir},
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle" width="15%">' + data[i].nmunit + '</td>' +
                        '<td class="align-middle" width="10%">' + data[i].noplat + '</td>' +
                        '<td class="align-middle" width="20%">' + data[i].nmugd + '</td>' +
                        '<td class="align-middle text-center" width="10%">' + data[i].jumtrip + '</td>' +
                        '<td class="align-middle text-center" width="10%">' + data[i].durasi + '</td>' +
                        '<td class="align-middle text-center" width="10%">' + data[i].jt + ' Km</td>' +                         
                        '<td class="align-middle text-center" width="10%">' + data[i].konsbbm + ' Ltr</td>' +
                        '<td class="align-middle text-center" width="10%">' + data[i].rpbbm + '</td>' +
                        '<td class="d-flex align-middle text-center" width="5%">'+
                        '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnDetTrip" data-idunit="'+data[i].idunit+'" data-idsdk="'+data[i].idsdk+'"><span class="fas fa-clock"></span></button>'+
                        '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnTrackTrip" data-idsdk="'+data[i].idsdk+'"><span class="fas fa-map-marker-alt"></span></button>'+
                        '</td>'+
                        '</tr>';
                }
                $('#isitabellapambulan').html(html);
                $("#tabellapambulan").dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": true,
                    "select": false,
                    "scrollX": false,
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>')
                            .parent().attr('autocomplete', 'off');
                    },
                    "searching": true,
                });
                $("#loading").fadeOut("slow");
            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
}

$('#isitabellapambulan').on('click','.btnDetTrip',function(){
    var idsdk = $(this).data('idsdk');
 
    var val = idsdk; 
    if (!val) return;
    var unit = wialon.core.Session.getInstance().getItem(val); 
    if (!unit) return; 
    var pos = unit.getPosition(); 
    if (!pos) return; 
    map.setView({
        lat: pos.y,
        lng: pos.x
    },20);     
    
    bersihkanHalaman();

    $("#txttransid").val("");
    var idunit = $(this).data('idunit');
    $("#txttransid").val(idsdk);

    isiTabelLapDetailUnit();
    $("#txttransmenu").val("lapdetailunit");
    $("#area-tabel-ambulan").fadeIn();
    $("#divtabeldetaillapambulan").fadeIn();
});

$('#isitabellapambulan').on('click','.btnTrackTrip',function(){
    var idsdk = $(this).data('idsdk');

    var val = idsdk; 
    if (!val) return;
    var unit = wialon.core.Session.getInstance().getItem(val); 
    if (!unit) return; 
    var pos = unit.getPosition(); 
    if (!pos) return; 
    map.setView({
        lat: pos.y,
        lng: pos.x
    },20);     

    $("#txttransid").val("");
    var idunit = $(this).data('idunit');
    $("#txttransid").val(idsdk);

    show_track ();

});

function isiTabelLapDetailUnit() {   
    var idsdk = $("#txttransid").val();
    var rangetanggal = $("#txttanggalLapUnit").val();
	var tglawal = left(rangetanggal,10);
	var tglakhir = right(rangetanggal,10);

        $('#tabeldetaillapambulan').dataTable().fnDestroy(); 
        $.ajax({
            type: "POST",
            url: "aksi/report/isi_tabel_detail_unit.php",
            data:{idsdk:idsdk,tglawal:tglawal,tglakhir:tglakhir},
            dataType: 'json',
            beforeSend: function(e) {
                $("#loading").fadeIn();
                document.body.style.cursor = "wait";
            },
            success: function(data) {
                document.body.style.cursor = "default";

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {

                    html +=
                        '<tr class="btn-reveal-trigger">' +
                        '<td class="align-middle" width="15%">' + data[i].nmunit + '<br>' + data[i].noplat + '</td>' +
                        '<td class="align-middle" width="30%">' + data[i].tglstart + ' - ' + data[i]
                        .jamstart + '<br>' + data[i].lokasistart + '</td>' +
                        '<td class="align-middle" width="30%">' + data[i].tglend + ' - ' + data[i]
                        .jamend + '<br>' + data[i].lokasiend + '</td>' +
                        '<td class="align-middle" width="10%">' + data[i].durasi + '<br>' + data[i].jt + ' Km</td>' +                       
                        '<td class="align-middle text-center" width="10%">' + data[i].konsbbm + ' Ltr<br>Rp. ' + data[i].rpbbm + '</td>' +
                        '<td class="align-middle text-center" width="5%">'+
                        //'<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnDetTrip" data-idunit="'+data[i].idunit+'" data-idsdk="'+data[i].idsdk+'"><span class="fas fa-clock"></span></button>'+
                        '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnTrackTrip" data-koordinatstart="'+data[i].koordinatstart+'" data-koordinatend="'+data[i].koordinatend+'"><span class="fas fa-map-marker-alt"></span></button>'+
                        '</td>'+
                        '</tr>';
                }
                $('#isitabeldetaillapambulan').html(html);
                $("#tabeldetaillapambulan").dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": true,
                    "select": false,
                    "scrollX": false,
                    initComplete: function() {
                        $(this.api().table().container()).find('input').parent().wrap('<form>')
                            .parent().attr('autocomplete', 'off');
                    },
                    "searching": true,
                });
                $("#loading").fadeOut("slow");
            },
            error: function() {
                $("#loading").fadeOut("slow");
                alert("Koneksi bermasalah periksa internet");
                document.body.style.cursor = "default";
            },
        });
}

$("#cmdRefreshLapUnit").on('click',function(){
    var ketlap = $("#txttransmenu").val();
    if (ketlap == "lapdetailunit"){
        isiTabelLapDetailUnit();
    } 
    if (ketlap == "lapunit"){
        isiTabelLapUnit();
    }
});

// Token that will be used for auth
// For more info about how to generate token check
// http://sdk.wialon.com/playground/demo/app_auth_token
var TOKEN = 'c6d211d32b6f36b2bc390774c6fc2e02BAB7BFC712FE07A027CEECE7DA6D340EF0E2EF59';

// global variables
var map, marker, unitMarkers = [],
    markerByUnit = {};
var areUnitsLoaded = false;

// for refreshing
var currentPos = null,
    currentUnit = null;

var isUIActive = true;

// Unit markers constructor
function getUnitMarker(unit) {
    // check for already created marker
    var marker = markerByUnit[unit.getId()];
    if (marker) return marker;

    var unitPos = unit.getPosition();

    if (!unitPos) return null;

    //////////////////////////////////////////////
    //// cari idunit == array unit yg sedang aktif
    //////////////////////////////////////////////
    const arridunit = $("#lblGlobalUnitMelayani").val();
    if(arridunit.includes(unit.getId())){
        marker = L.marker([unitPos.y, unitPos.x], {
            clickable: false,
            draggable: false,
            icon: L.icon({
                iconUrl: unit.getIconUrl(32),
                iconAnchor: [16, 16], // set icon center    
                //className: 'berkedip'    
            })
        }).bindTooltip(unit.getName(), {
            permanent: true,
            direction: 'bottom',
            sticky: false,
            interactive: true,
            className: 'my-div-icon'
        })
        .addTo(map).bindPopup('Menuju pelapor', {
                                closeButton: false,
                                autoClose: false,
                                closeOnClick: false,
                                'className': 'berkedip'
                            }).openPopup();
    } else {
        marker = L.marker([unitPos.y, unitPos.x], {
            clickable: false,
            draggable: false,
            icon: L.icon({
                iconUrl: unit.getIconUrl(32),
                iconAnchor: [16, 16], // set icon center    
                //className: 'berkedip'    
            })
        }).bindTooltip(unit.getName(), {
            permanent: true,
            direction: 'bottom',
            sticky: false,
            interactive: true,
            className: 'my-div-icon'
        });
    }

    unitMarkers.push(marker);
    markerByUnit[unit.getId()] = marker;

    return marker;
}

// Print message to log
function msg(text) {
    $('#log').prepend(text + '<br/>');
}

function init() { // Execute after login succeed
    // get instance of current Session
    var session = wialon.core.Session.getInstance();
    // specify what kind of data should be returned
    var flags = wialon.item.Item.dataFlag.base | wialon.item.Unit.dataFlag.lastPosition;

    // load Icon Library
    session.loadLibrary('itemIcon');

    // load items to the current session
    session.updateDataFlags(
        [{
            type: 'type',
            data: 'avl_unit',
            flags: flags,
            mode: 0
        }], // Items specification
        function(error) { // updateDataFlags callback
            if (error) {
                // show error, if update data flags was failed
                msg(wialon.core.Errors.getErrorText(error));
            } else {
                areUnitsLoaded = true;
                msg('Units are loaded');

                // add received data to the UI, setup UI events
                initUIData();
            }
        }
    );
}

// will be called after updateDataFlags success
function initUIData() {
    var session = wialon.core.Session.getInstance();
    var units = session.getItems('avl_unit');
    html = '';
    units.forEach(function(unit) {
        var unitMarker = getUnitMarker(unit);
        if (unitMarker) unitMarker.addTo(map);

        var icon = unit.getIconUrl(32); // get unit Icon url

        // listen for new messages
        unit.addListener('changePosition', function(event) {
            // event is qx.event.type.Data
            // extract message data
            var pos = event.getData();

            // move or create marker, if not exists
            if (pos) {
                if (unitMarker) {
                    unitMarker.setLatLng([pos.y, pos.x]);
                } else {
                    // create new marker
                    unitMarker = getUnitMarker(unit);

                    // add marker to the map
                    if (unitMarker) unitMarker.addTo(map);
                    else msg('Got message with pos, but unit don\'t have a position');
                }
            }
        });
    });
}

function initMap() {
    map = L.map('map', {
        doubleClickZoom: false
    }).setView([-8.16884, 113.70224], 14);

    googleTraffic = L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 22,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    const searchControl = L.esri.Geocoding.geosearch({
        position: "topright",
        placeholder: "Cari lokasi",
        useMapBounds: false,
        providers: [
            L.esri.Geocoding.arcgisOnlineProvider({
                apikey: apiKey,
                nearby: {
                    lat: -8.16884,
                    lng: 113.70224
                }
            })
        ]
    }).addTo(map);

    const results = L.layerGroup().addTo(map);

    searchControl.on("results", function(data) {
        results.clearLayers();

        var icoPelapor = L.icon({
            iconUrl: 'assets/img/pelapor.png',
            iconSize: [10, 10],
        });

        for (let i = data.results.length - 1; i >= 0; i--) {
            if (!marker) { 
                marker = L.marker(data.results[i].latlng, {
                        icon: icoPelapor,
                        clickable: false,
                        draggable: false,
                        zIndexOffset: 1000 
                    })
                    .bindTooltip("Lokasi", {
                        permanent: true,
                        direction: 'center',
                        sticky: false,
                        interactive: true,
                        className: 'my-div-icon-pelapor'
                    });
                marker.addTo(map);

            } else { 
                marker.setLatLng(data.results[i].latlng, {
                        icon: icoPelapor,
                        clickable: false,
                        draggable: false,
                        zIndexOffset: 1000 
                    })
                    .bindTooltip("Lokasi", {
                        permanent: true,
                        direction: 'center',
                        sticky: false,
                        interactive: true,
                        className: 'my-div-icon-pelapor'
                    });
            }

        }
    });

    ////////////////////////////////
    var icoPuskesmas = L.icon({
        iconUrl: 'https://api.geoapify.com/v1/icon?type=awesome&color=red&size=small&icon=stethoscope&strokeColor=%23512424&apiKey=bba6ae273e4e475c912d5392d064391b',
    });

    var icoKlinik = L.icon({
        iconUrl: 'https://api.geoapify.com/v1/icon?type=awesome&color=green&size=small&icon=syringe&strokeColor=%23512424&apiKey=bba6ae273e4e475c912d5392d064391b',
    });

    var icoRSU = L.icon({
        iconUrl: 'https://api.geoapify.com/v1/icon?type=awesome&color=red&icon=hospital&strokeColor=%23512424&apiKey=bba6ae273e4e475c912d5392d064391b',
    });

    ambilmarkerUGD();

    function ambilmarkerUGD() {
        $.ajax({
            url: "../operator/aksi/ambil_marker_UGD.php",
            dataType: "json",
            method: "POST",
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    const str2 = data[i].koordinat;
                    const words2 = str2.split(',');

                    if (data[i].sttsugd == "rsud") {
                        var marker = L.marker([words2[0], words2[1]], {
                            icon: icoRSU
                        }).bindTooltip(data[i].nmtempat, {
                            permanent: true,
                            direction: 'center',
                            sticky: false,
                            interactive: true,
                            className: 'my-div-icon-rsud'
                        }).addTo(map)
                    } else if (data[i].sttsugd == "puskesmas") {
                        var marker = L.marker([words2[0], words2[1]], {
                            icon: icoPuskesmas
                        }).bindTooltip(data[i].nmtempat, {
                            permanent: true,
                            direction: 'center',
                            sticky: false,
                            interactive: true,
                            className: 'my-div-icon-puskesmas'
                        }).addTo(map)

                    } else if (data[i].sttsugd == "klinik") {
                        var marker = L.marker([words2[0], words2[1]], {
                            icon: icoKlinik
                        }).bindTooltip(data[i].nmtempat, {
                            permanent: true,
                            direction: 'center',
                            sticky: false,
                            interactive: true,
                            className: 'my-div-icon-klinik'
                        }).addTo(map)
                    }
                }
            },
        });
    }

    // handle mouse double-click event
    map.on('dblclick', function(e) {
  
    });

    //map.on("mouseover", alert("oke"));

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

	$("#txttanggalLapLayanan").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
    $("#txttanggalLapUnit").val(arrtanggal[tanggal] + '-' + arrbulan[bulan] + '-' + tahun + ' to ' + arrtanggal[tanggal2] + '-' + arrbulan[bulan2] + '-' + tahun2);
  }

 // function msg(text) {
//	$("#log").prepend(text + "<br/>");
 // }

function initReport() { // Execute after login succeed
	// specify what kind of data should be returned
	var res_flags = wialon.item.Item.dataFlag.base | wialon.item.Resource.dataFlag.reports;
	var unit_flags = wialon.item.Item.dataFlag.base;

	var sess = wialon.core.Session.getInstance(); // get instance of current Session
	sess.loadLibrary("resourceReports"); // load Reports Library
	sess.updateDataFlags( // load items to current session
		[
			{ // 'avl_resource's specification
				type: "type",
				data: "avl_resource",
				flags: res_flags,
				mode: 0
			},
			{ // 'avl_unit's specification
				type: "type",
				data: "avl_unit",
				flags: unit_flags,
				mode: 0
			}
		],

		function(code) { // updateDataFlags callback
			if (code) {// exit if error code
				msg(wialon.core.Errors.getErrorText(code));
				return;
			}

			var res = sess.getItems("avl_resource"); // get loaded 'avl_resource's items
			if (!res || !res.length) { // check if resources found
				msg("Resources not found");
				return;
			}
			for (var i = 0; i < res.length; i++) // construct Select object using found resources
				$("#res").append("<option value='" + res[i].getId() + "'>" + res[i].getName() + "</option>");

			var units = sess.getItems("avl_unit"); // get loaded 'avl_units's items
			// check if units found
			if (!units || !units.length) {
				msg("Units not found");
				return;
			}

			for (var i = 0; i < units.length; i++) // construct Select object using found units
				$("#units").append("<option value='" + units[i].getId() + "'>" + units[i].getName() + "</option>");
		}
	);
	drawCheckboxes();
	$('#templ').change(drawCheckboxes);
}

function drawCheckboxes () {
	// get available reports table
	wialon.core.Session.getInstance().getReportTables(function (code,data){
		var selectedTmpl = $("#templ").val();
		var col = [];
		var html = '';
		for (var i = 0; i < data.length; i++) {
			if (data[i].n == selectedTmpl) {//draw only selected report table
				col = data[i].col;
				for (var j = 0; j < col.length; j++){ // construct Select object using found report columns                   
                    if( col[j].l != '' && col[j].n != '' && j != 6 && j != 7 && j != 8 && j != 11 && j != 12 && j != 15 && j != 16 && j != 17 && j != 18 && j != 20 && j != 21 
                    && j != 24 && j != 25 && j != 26 && j != 27 && j != 28 && j != 29 && j != 30 && j != 31 && j != 32 && j != 33 && j != 34 && j != 35 && j != 36 && j != 38
                    && j != 39 && j != 40 && j != 41 && j != 42 && j != 43 && j != 44 && j != 45 && j != 46 && j <= 47 ){
                            html += '<li><input class="rep_col" type="checkbox" id="' + col[j].n + '" checked /><label for="' + col[j].n + '">' + col[j].l + '</label></li>';
                    }
				}
			}
		};
		$('#columns').html(html);
	});
}
/*
function executeReportArrUnit() { // execute selected report
 	// get data from corresponding fields
     var id_res = $("#res").val(),
     templ = $("#templ").val(),
     //id_unit = $("#units").val(),
     time = $("#interval").val();
    if (!id_res) {
        msg("Select resource");
        return;
    } // exit if no resource selected
    //if (!id_unit) {
    //    msg("Select unit");
    //    return;
    //} // exit if no unit selected

    //$("#txttransid").val(id_unit)

    var sess = wialon.core.Session.getInstance(); // get instance of current Session
    var res = sess.getItem(id_res); // get resource by id
    var to = sess.getServerTime(); // get current server time (end time of report time interval)
    var from = to - parseInt($("#interval").val(), 10); // calculate start time of report
    var columns = $("ul li .rep_col:checked"); // get columns, that need to be in a report
    // specify time interval object
    var interval = {
        "from": from,
        "to": to,
        "flags": wialon.item.MReport.intervalFlag.absolute
    };

    var c="", cl=""; // columns and columnsLabels variables
    for(var i=0; i< columns.length; i++){ // cycle to generate columns and columnsLabels
        c += (c==""?"":",") + columns[i].id;
        cl += (cl==""?"":",") + $(columns[i].nextSibling).text();//.innerText;
    }
    //$("#exec_btn").prop("disabled", true); // disable button (to prevent multiclick while execute)
    var template = {// fill template object
        "id": 0,
        "n": templ,
        "ct": "avl_unit",
        "p": "",
        "tbl": [{
                "n": templ,
                "l": $("#templ option[value='" + templ + "']").text(),
                "c": c,
                "cl": cl,
                "s": "",
                "sl": "",
                "p": "",
                "sch": {
                    "f1": 0,
                    "f2": 0,
                    "t1": 0,
                    "t2": 0,
                    "m": 0,
                    "y": 0,
                    "w": 0
                },
                "f": 0
            }]
    };


   // $("#txttransid").val("");
    var units = sess.getItems('avl_unit');

    var idunits = [];
    units.forEach(function(unit) {
        var id_unit = unit.getId();
        if (!id_unit) {
            msg("Select unit");
            return;
        } 

        idunits.push(id_unit)
        //$("#txttransid").val(id_unit);
        //$("#txttransid").val(id_unit)
    });


    ////promise
    Promise.all(idunits) // provide array of promises to Promise.all
    .then(function(residunit) { // receive resolved results, they should be even numbers from 0*2 to 99*2
  
   

        //Promise.all(idunits)
        //.then(function(residunit) {
            for (let c = 0; c < idunits.length; c++) {
//               ^^^−−−−−−−−−−−−−−−− added missing declaration
                //doSomeStuffOnlyWhenTheAsyncStuffIsFinish();    
           // }
        //})
        //.catch((e) => {
            // handle errors here
        //});




        //for (let c = 0; c < idunits.length; c++) {
        //    msg(idunits[c])
        //    var idunitnya = idunits[c];
        //}
        //var idsdk = residunit[c];
        $("#txttransid").val("");
        $("#txttransid").val(idunits[c]);

        res.execReport(template, idunits[c], 0, interval, // execute selected report

        function(code, data) { // execReport template
            //$("#exec_btn").prop("disabled", false); // enable button
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code
            if (!data.getTables().length) { // exit if no tables obtained
                msg("<b>There is no data generated</b>");
                return;
            } else showReportResult(data); // show report result
        });
    }

    });/// promise all

/*


            var tables = data.getTables(); // get report tables
            if (!tables) return; // exit if no tables

            //$("#txttransid").val(id_unit)
            var idsdk = residunit[c];
            for (var i = 0; i < tables.length; i++) { // cycle on tables
                data.getTableRows(i, 0, tables[i].rows, // get Table rows
                    function(code, rows) { // getTableRows callback
                        if (code) {
                            msg(wialon.core.Errors.getErrorText(code));
                            return;
                        } // exit if error code

                        //var idsdk = residunit[c];
                        for (var j in rows) { // cycle on table rows
                            if (typeof rows[j].c == "undefined") continue; // skip empty rows
                            //html += "<tr" + (j % 2 == 1 ? " class='odd' " : "") + ">"; // open table row
                            //var idsdk = id_unit;
                            for (var k = 0; k < rows[j].c.length; k++) // add ceils to table
                            
                            var sa0 = getTableValue(rows[j].c[0]);var sa1 = getTableValue(rows[j].c[1]);var sa2 = getTableValue(rows[j].c[2]);var sa3 = getTableValue(rows[j].c[3]);var sa4 = getTableValue(rows[j].c[4]);
                            var sa5 = getTableValue(rows[j].c[5]);var sa6 = getTableValue(rows[j].c[6]);var sa7 = getTableValue(rows[j].c[7]);
                            var sa8 = getTableValue(rows[j].c[8]);var sa9 = getTableValue(rows[j].c[9]);var sa10 = getTableValue(rows[j].c[10]);
                            var sa11 = getTableValue(rows[j].c[11]);var sa12 = getTableValue(rows[j].c[12]);var sa13 = getTableValue(rows[j].c[13]);var sa14 = getTableValue(rows[j].c[14]);
                        
                            //var idsdk = residunit[c];
                            $.ajax({
                                type:"POST",
                                url : "aksi/transaksi/aksi_tambah_log.php",
                                data:{idsdk:idsdk,sa0:sa0,sa1:sa1,sa2:sa2,sa3:sa3,sa4:sa4,sa5:sa5,sa6:sa6,sa7:sa7,sa8:sa8,sa9:sa9,sa10:sa10,sa11:sa11,sa12:sa12,sa13:sa13,sa14:sa14},
                                success:function(resp){
                                    msg("sukses " +idsdk)
                                    return;
                                    //id_unit ="";
                                    //$("#txttransid").val("")
                                },
                                error: function() {
                                    msg("error " +idsdk)
                                    return;
                                }
                            });	//return                 
                        }
                    },
                );
                //this,null);
               
            }
        });
    //});

        } /// promises result loop
    });/// promises
    
}
*/


function doSomethingAsync(value) {
    return new Promise((resolve) => {
        setTimeout(() => {
            console.log("Resolving " + value);
            //resolve(value);
            //resolve 
        
           // var idunitnya = $("#txttransid").val(value);
        
        
    	// get data from corresponding fields
        var id_res = $("#res").val(),
		templ = $("#templ").val(),
		time = $("#interval").val();

	if (!id_res) {
		msg("Select resource");
		return;
	} // exit if no resource selected

	var sess = wialon.core.Session.getInstance(); // get instance of current Session
	var res = sess.getItem(id_res); // get resource by id
	var to = sess.getServerTime(); // get current server time (end time of report time interval)
	//var from = to - parseInt($("#interval").val(), 10); // calculate start time of report
    var from = to - parseInt(time, 10); // calculate start time of report
	var columns = $("ul li .rep_col:checked"); // get columns, that need to be in a report
	// specify time interval object
	var interval = {
		"from": from,
		"to": to,
		"flags": wialon.item.MReport.intervalFlag.absolute
	};

	var c="", cl=""; // columns and columnsLabels variables
	for(var i=0; i< columns.length; i++){ // cycle to generate columns and columnsLabels
		c += (c==""?"":",") + columns[i].id;
		cl += (cl==""?"":",") + $(columns[i].nextSibling).text();//.innerText;
	}
	$("#exec_btn").prop("disabled", true); // disable button (to prevent multiclick while execute)
	var template = {// fill template object
		"id": 0,
		"n": templ,
		"ct": "avl_unit",
		"p": "",
		"tbl": [{
				"n": templ,
				"l": $("#templ option[value='" + templ + "']").text(),
				"c": c,
				"cl": cl,
				"s": "",
				"sl": "",
				"p": "",
				"sch": {
					"f1": 0,
					"f2": 0,
					"t1": 0,
					"t2": 0,
					"m": 0,
					"y": 0,
					"w": 0
				},
				"f": 0
			}]
	};

    resolve ()
        
            //var idunitnya = $("#txttransid").val(value);

        res.execReport(template, value, 0, interval, // execute selected report
        function(code, data) { // execReport template
            $("#exec_btn").prop("disabled", false); // enable button
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code
            if (!data.getTables().length) { // exit if no tables obtained
                msg("<b>There is no data generated</b>");
                return;
            } else showReportResult(data); // show report result
        });    
   
            
        
        
        
            
        
        
        
        
        
        }, Math.floor(Math.random() * 1000));
    });
  }
  
  function test() {
    var sess = wialon.core.Session.getInstance(); // get instance of current Session
    var units = sess.getItems('avl_unit');

    const promises = [];
    units.forEach(function(unit) {
        var id_unit = unit.getId();
        if (!id_unit) {
            msg("Select unit");
            return;
        } 
        promises.push(doSomethingAsync(unit.getId()));
    });

      Promise.all(promises)
          .then((results) => {
              console.log("All done", results);
          })
          .catch((e) => {
              // Handle errors here
          });
  }
  
 

function showReportResult(result) { // show result after report execute
    var idsdk = $("#txttransid").val();
    console.log(idsdk)
    
	var tables = result.getTables(); // get report tables
	if (!tables) return; // exit if no tables
	for (var i = 0; i < tables.length; i++) { // cycle on tables
		result.getTableRows(i, 0, tables[i].rows, // get Table rows
			function(code, rows) { // getTableRows callback
				if (code) {
					msg(wialon.core.Errors.getErrorText(code));
					return;
				} // exit if error code
				for (var j in rows) { // cycle on table rows
					if (typeof rows[j].c == "undefined") continue; // skip empty rows
					//html += "<tr" + (j % 2 == 1 ? " class='odd' " : "") + ">"; // open table row
					for (var k = 0; k < rows[j].c.length; k++) // add ceils to table
                    
                    var sa0 = getTableValue(rows[j].c[0]);var sa1 = getTableValue(rows[j].c[1]);var sa2 = getTableValue(rows[j].c[2]);var sa3 = getTableValue(rows[j].c[3]);var sa4 = getTableValue(rows[j].c[4]);
                    var sa5 = getTableValue(rows[j].c[5]);var sa6 = getTableValue(rows[j].c[6]);var sa7 = getTableValue(rows[j].c[7]);
                    var sa8 = getTableValue(rows[j].c[8]);var sa9 = getTableValue(rows[j].c[9]);var sa10 = getTableValue(rows[j].c[10]);
                    var sa11 = getTableValue(rows[j].c[11]);var sa12 = getTableValue(rows[j].c[12]);var sa13 = getTableValue(rows[j].c[13]);var sa14 = getTableValue(rows[j].c[14]);
                    
                    //var idsdk = result;
                    $.ajax({
                        type:"POST",
                        url : "aksi/transaksi/aksi_tambah_log.php",
                        data:{idsdk:idsdk,sa0:sa0,sa1:sa1,sa2:sa2,sa3:sa3,sa4:sa4,sa5:sa5,sa6:sa6,sa7:sa7,sa8:sa8,sa9:sa9,sa10:sa10,sa11:sa11,sa12:sa12,sa13:sa13,sa14:sa14},
                        //dataType: "json",
                        success:function(resp){
                            console.log("sukses")
                            $("#txttransid").val("")
                            //return
                        },
                        error: function() {
                            console.log("error")
                            $("#txttransid").val("")
                           // return
                        },
                    });	//return                 
				}
			},
		//this,html);
        );
	}
}

function executeReport() { // execute selected report
	// get data from corresponding fields
    var id_res = $("#res").val(),
		templ = $("#templ").val(),
		time = $("#interval").val();

	if (!id_res) {
		msg("Select resource");
		return;
	} // exit if no resource selected

	var sess = wialon.core.Session.getInstance(); // get instance of current Session
	var res = sess.getItem(id_res); // get resource by id
	var to = sess.getServerTime(); // get current server time (end time of report time interval)
	//var from = to - parseInt($("#interval").val(), 10); // calculate start time of report
    var from = to - parseInt(time, 10); // calculate start time of report
	var columns = $("ul li .rep_col:checked"); // get columns, that need to be in a report
	// specify time interval object
	var interval = {
		"from": from,
		"to": to,
		"flags": wialon.item.MReport.intervalFlag.absolute
	};

	var c="", cl=""; // columns and columnsLabels variables
	for(var i=0; i< columns.length; i++){ // cycle to generate columns and columnsLabels
		c += (c==""?"":",") + columns[i].id;
		cl += (cl==""?"":",") + $(columns[i].nextSibling).text();//.innerText;
	}
	$("#exec_btn").prop("disabled", true); // disable button (to prevent multiclick while execute)
	var template = {// fill template object
		"id": 0,
		"n": templ,
		"ct": "avl_unit",
		"p": "",
		"tbl": [{
				"n": templ,
				"l": $("#templ option[value='" + templ + "']").text(),
				"c": c,
				"cl": cl,
				"s": "",
				"sl": "",
				"p": "",
				"sch": {
					"f1": 0,
					"f2": 0,
					"t1": 0,
					"t2": 0,
					"m": 0,
					"y": 0,
					"w": 0
				},
				"f": 0
			}]
	};

    $("#txttransid").val("");
    var units = sess.getItems('avl_unit');

    var idunits = [];
    units.forEach(function(unit) {
        var id_unit = unit.getId();
        if (!id_unit) {
            msg("Select unit");
            return;
        } 

        idunits.push(id_unit)
        //$("#txttransid").val(id_unit);
    });

        //alert(idunits)
        
        //const promises = idunits.map((num) => function2(num));
        //await Promise.all(promises);
       // showReportResult();
  
        //res.execReport(template, id_unit, 0, interval, // execute selected report
        res.execReport(template, idunits, 0, interval, // execute selected report
        function(code, data) { // execReport template
            $("#exec_btn").prop("disabled", false); // enable button
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code
            if (!data.getTables().length) { // exit if no tables obtained
                msg("<b>There is no data generated</b>");
                return;
            } else showReportResult(data); // show report result
        });

       // $("#txttransid").val(idunits)
        //await Promise.all(promises);
    //});
}

function getTableValue(data) { // calculate ceil value
	if (typeof data == "object")
		if (typeof data.t == "string") return data.t;
		else return "";
		else return data;
}


/////////////////////////////////
////// TRACK LAYER //////////////
/////////////////////////////////
var map, markers = {}, tile_layer, layers = {}; // global variables

// Print message to log
function msg(text) { $("#log").prepend(text + "<br/>"); }

function initTrack() { // Execute after login succeed
	var sess = wialon.core.Session.getInstance(), // get instance of current Session
		flags = wialon.item.Item.dataFlag.base | wialon.item.Unit.dataFlag.lastMessage, // specify what kind of data should be returned
		renderer = wialon.core.Session.getInstance().getRenderer();
	
	renderer.addListener("changeVersion", update_renderer);
	sess.loadLibrary("itemIcon"); // load Icon Library 
	
	sess.updateDataFlags( // load items to current session
	    [{type: "type", data: "avl_unit", flags: flags, mode: 0}], // Items specification
	    function (code) { // updateDataFlags callback
		    if (code) { msg(wialon.core.Errors.getErrorText(code)); return; } // exit if error code
			
		    //var units = sess.getItems("avl_unit"); // get loaded 'avl_resource's items
		    //if (!units || !units.length){ msg("No units found"); return; } // check if units found
		    //for (var i = 0; i< units.length; i++) // construct Select list using found resources
			    //$("#units").append("<option value='"+ units[i].getId() +"'>"+ units[i].getName()+ "</option>");
		    $("#build").click( show_track );  // bind action to select change event
			$("#tracks").on("click", ".close_btn", delete_track); //click, when need delete current track
			$("#tracks").on("click", ".unit", focus_track); //click, when need to see any track
	});
}

function show_track () {

    var rangetanggal = $("#txttanggalLapUnit").val();
    var tglawal = left(rangetanggal,10);
    //var from = new Date(tglawal).getTime() / 1000;
 
    var tglakhir = right(rangetanggal,10);
    //var to = new Date(tglakhir).getTime() / 1000;
   
    //$("#txttransid").val("");$("#units").val()
	var unit_id =  $("#txttransid").val(),
		sess = wialon.core.Session.getInstance(), // get instance of current Session	
		renderer = sess.getRenderer(),


		//cur_day = new Date(),
		//from = Math.round(new Date(cur_day.getFullYear(), cur_day.getMonth(), cur_day.getDate()) / 1000), // get begin time - beginning of day
		//to = from + 3600 * 24 - 1, // end of day in seconds


        //akhir_day = new Date(tglawal),
		to = sess.getServerTime(); // get current server time (end time of report time interval)
		
        //awal_day = new Date(tglakhir),
        from = to - parseInt(2592000, 10); // calculate start time of report

		unit = sess.getItem(unit_id), // get unit by id 
		color = "ff0000" || "ffffff"; // track color
        //color = $("#color").val() || "ffffff"; // track color

		if (!unit) return; // exit if no unit

		// check the existence info in table of such track 
		if (document.getElementById(unit_id))
		{
			msg("You already have this track.");
			return;
		}
      
		var pos = unit.getPosition(); // get unit position
		if(!pos) return; // exit if no position

		// callback is performed, when messages are ready and layer is formed
		callback =  qx.lang.Function.bind(function(code, layer) {
			if (code) { msg(wialon.core.Errors.getErrorText(code)); return; } // exit if error code
			
			if (layer) { 
				var layer_bounds = layer.getBounds(); // fetch layer bounds
				if (!layer_bounds || layer_bounds.length != 4 || (!layer_bounds[0] && !layer_bounds[1] && !layer_bounds[2] && !layer_bounds[3])) // check all bounds terms
				    return;
				
				// if map existence, then add tile-layer and marker on it
				if (map) {
				   //prepare bounds object for map
				    var bounds = new L.LatLngBounds(
					L.latLng(layer_bounds[0],layer_bounds[1]),
					L.latLng(layer_bounds[2],layer_bounds[3])
				    );
				    map.fitBounds(bounds); // get center and zoom
				    // create tile-layer and specify the tile template
					if (!tile_layer)
						tile_layer = L.tileLayer(sess.getBaseUrl() + "/adfurl" + renderer.getVersion() + "/avl_render/{x}_{y}_{z}/"+ sess.getId() +".png", {zoomReverse: true, zoomOffset: -1}).addTo(map);
					else 
						tile_layer.setUrl(sess.getBaseUrl() + "/adfurl" + renderer.getVersion() + "/avl_render/{x}_{y}_{z}/"+ sess.getId() +".png");
				    // push this layer in global container
				    layers[unit_id] = layer;
				    // get icon
				    var icon = L.icon({ iconUrl: unit.getIconUrl(24) });
				    //create or get marker object and add icon in it
				    var marker = L.marker({lat: pos.y, lng: pos.x}, {icon: icon}).addTo(map);
				    
					marker.setLatLng({lat: pos.y, lng: pos.x}); // icon position on map
					marker.setIcon(icon); // set icon object in marker
					markers[unit_id] = marker;	    
				}
				// create row-string with data
				var row = "<tr id='" + unit_id + "'>";  
				// print message with information about selected unit and its position
				row += "<td class='unit'><img src='" + unit.getIconUrl(16) + "'/> " + unit.getName() + "</td>"; 
				row += "<td>Position " + pos.x + ", " + pos.y + "<br> Mileage " + layer.getMileage() + "</td>";
				row += "<td style='border: 1px solid #" + color + "'>     </td>";
				row += "<td class='close_btn'>x</td></tr>";
				//add info in table
				$("#tracks").append(row);
			}
	});
	// query params
	params = {
		"layerName": "route_unit_" + unit_id, // layer name
		"itemId": unit_id, // ID of unit which messages will be requested
		"timeFrom": from, //interval beginning
		"timeTo": to, // interval end
		"tripDetector": 1, //use trip detector: 0 - no, 1 - yes
		"trackColor": color, //track color in ARGB format (A - alpha channel or transparency level)
		"trackWidth": 2, // track line width in pixels
		"arrows": 1, //show course of movement arrows: 0 - no, 1 - yes
		"points": 0, // show points at places where messages were received: 0 - no, 1 - yes
		"pointColor": "ffffff", // points color
		"annotations": 1 //show annotations for points: 0 - no, 1 - yes
	};
	renderer.createMessagesLayer(params, callback);
}

function update_renderer () {
	var sess = wialon.core.Session.getInstance(),
		renderer = sess.getRenderer();
	if (tile_layer && tile_layer.setUrl)
		tile_layer.setUrl(sess.getBaseUrl() + "/adfurl" + renderer.getVersion() + "/avl_render/{x}_{y}_{z}/" + sess.getId() + ".png"); // update url-mask in tile-layer
}

function focus_track (evt) {
	var row = evt.target.parentNode, // get row with data by target parentNode
		unit_id = row.id; // get unit id from current row
	// get bounds for map
	if (layers && layers[unit_id])
		var bounds =  layers[unit_id].getBounds();
	if (bounds && map)
	{
		// create object with need params
		var map_bounds = new L.LatLngBounds(
			L.latLng(bounds[0],bounds[1]),
			L.latLng(bounds[2],bounds[3])
		);
		// set view in geting bounds
		map.fitBounds(map_bounds); // get center and zoom
	}
}

function delete_track (evt) {
	var row = evt.target.parentNode, // get row with data by target parentNode
		unit_id = row.id, // get unit id from current row
		sess = wialon.core.Session.getInstance(),
		renderer = sess.getRenderer();
	if (layers && layers[unit_id])
	{
		// delete layer from renderer
		renderer.removeLayer(layers[unit_id], function(code) { 
			if (code) 
				msg(wialon.core.Errors.getErrorText(code)); // exit if error code
			else 
				msg("Track removed."); // else send message, then ok
		});
		delete layers[unit_id]; // delete layer from container
	}
	// move marker behind bounds
	if (map)
		map.removeLayer(markers[unit_id]);
	delete markers[unit_id];
	// remove row from info table
	$(row).remove();
}

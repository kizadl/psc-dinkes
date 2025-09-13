
/*	var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFoZW5kcmF5dWRoYSIsImEiOiJja29pNnAzajcwcmV3MndsbHlzNWMxM2RmIn0.Q53cv5O2-ozIAIZLhgcKcQ', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		accessToken: 'pk.eyJ1IjoibWFoZW5kcmF5dWRoYSIsImEiOiJja29pNnAzajcwcmV3MndsbHlzNWMxM2RmIn0.Q53cv5O2-ozIAIZLhgcKcQ'
	});

    var wisatalayer = L.layerGroup();
    var travellayer = L.layerGroup();
    var hotellayer = L.layerGroup();
    var restolayer = L.layerGroup();

    var map = L.map("map", {
        center: [-8.264371593833262, 113.6321026467762],
        zoom: 10,
        layers: [peta1, wisatalayer, hotellayer, restolayer],
    });

    var marker = L.circleMarker([-8.264371593833262, 113.6321026467762], {
        color: '#3388ff', weight: 2, fillOpacity: 0.4
    }).addTo(map).bindPopup("Pusat Kota");
    marker.setRadius(20);
   

    var iconApiKey = "a6bdace0ef044b63b68223c23362f463";
 
    var userIconSM = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=lightgreen&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var travelIconSM = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=green&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var blueIconSM = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=blue&icon=house-damage&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [10,10],
        iconAnchor: [22, 94],
        popupAnchor: [-3, -76],
        shadowSize: [68, 95],
    });
    var redIconSM = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=building&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
       
    });
    var goldIconSM = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=gold&icon=house-user&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });

    var userIcon = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon?size=xx-large&type=awesome&color=lightgreen&icon=user&apiKey=${iconApiKey}`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var travelIcon = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=green&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var blueIcon = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=blue&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var redIcon = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=red&icon=house-building&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });
    var goldIcon = new L.Icon({
        iconUrl: `https://api.geoapify.com/v1/icon/?type=material&color=gold&icon=map-marker-alt&iconType=awesome&strokeColor=%23514424&apiKey=a6bdace0ef044b63b68223c23362f463`,
        iconSize: [4, 6],
        iconAnchor: [8,10],
        popupAnchor: [1, -18],
        shadowSize: [10,14]
    });

    ambilmarkerwisata();
 
    function ambilmarkerwisata() {
        $.ajax({
            url: "../operator/aksi/ambil_marker_pendidikan.php",
            dataType: "json",
            method: "POST",
            success: function(data) {
                const pusatXY = "-8.264371593833262, 113.6321026467762";
                const pusat = pusatXY.split(',');
                var pusatX = pusat[0];
                var pusatY = pusat[1];

                var posisiX = $("#lbllatitude").val();
                var posisiY = $("#lbllongitude").val();

                for (var i = 0; i < data.length; i++) {
                    const str2 = data[i].koordinat;
                    const words2 = str2.split(',');
                    
                    var markerFrom = L.circleMarker([posisiX, posisiY]);
                    var markerTo =  L.circleMarker([words2[0], words2[1]]);
                    var from = markerFrom.getLatLng();
                    var to = markerTo.getLatLng();
                    var jarakuser = from.distanceTo(to).toFixed(0)/1000;

                    //// menghitung jarak kota
                    var markerFromKota = L.circleMarker([pusatX, pusatY]);
                    var markerTo2 =  L.circleMarker([words2[0], words2[1]]);
                    var fromkota = markerFromKota.getLatLng();
                    var to2 = markerTo2.getLatLng();
                    var jarakkota = fromkota.distanceTo(to2).toFixed(0)/1000;

                    if (data[i].bentuk == "TK"){
                        var marker = L.circleMarker([words2[0], words2[1]], {
                          color: '#3388ff', weight: 2, fillOpacity: 0.1
                        }).bindPopup(
                            '<b class="text-sm">' + data[i].nmtempat +'</b><br>'+
                            '<span class="btext-xs">' + data[i].alamat + '</span><br><br>' +
                            '<span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                            '</span>' +
                            '<br><br><a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="user" data-koordinat="' + data[i].koordinat +
                            '" style="color:green;cursor: pointer;"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;' + jarakuser + ' Km dengan posisi Anda</a><br>' +
                            '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                            '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'
                            
                            //'<br/><button type="button" class="btn btn-primary sidebar-open-button" data = "' + data[i].pemilik + '" ' + '>Click for more</button>'
                        ).addTo(wisatalayer)
                        marker.setRadius(8);

                    } else if (data[i].bentuk == "SD" || data[i].bentuk == "SPK SD" || data[i].bentuk == "TK" || data[i].bentuk == "KB"){
                        var marker = L.circleMarker([words2[0], words2[1]], {
                          color: '#FF0000', weight: 2, fillOpacity: 0.1
                        }).bindPopup(
                            '<b class="text-sm">' + data[i].nmtempat +'</b><br>'+
                            '<span class="btext-xs">' + data[i].alamat + '</span><br><br>' +
                            '<span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                            '</span>' +
                            '<br><br><a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="user" data-koordinat="' + data[i].koordinat +
                            '" style="color:green;cursor: pointer;"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;' + jarakuser + ' Km dengan posisi Anda</a><br>' +
                            '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                            '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                        ).addTo(hotellayer)
                        marker.setRadius(8);

                    } else if (data[i].bentuk == "SMP" || data[i].bentuk == "SMPLB"){
                        var marker = L.circleMarker([words2[0], words2[1]], {
                          color: '#DAA520', weight: 2, fillOpacity: 0.1
                        }).bindPopup(
                            '<b class="text-sm">' + data[i].nmtempat +'</b><br>'+
                            '<span class="btext-xs">' + data[i].alamat + '</span><br><br>' +
                            '<span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                            '</span>' +
                            '<br><br><a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="user" data-koordinat="' + data[i].koordinat +
                            '" style="color:green;cursor: pointer;"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;' + jarakuser + ' Km dengan posisi Anda</a><br>' +
                            '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                            '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                        ).addTo(restolayer)
                        marker.setRadius(8);

                    } else if (data[i].bentuk == "SMA" || data[i].bentuk == "SMK"){
                        var marker = L.circleMarker([words2[0], words2[1]], {
                          color: '#663399', weight: 2, fillOpacity: 0.1
                        }).bindPopup(
                            '<b class="text-sm">' + data[i].nmtempat +'</b><br>'+
                            '<span class="btext-xs">' + data[i].alamat + '</span><br><br>' +
                            '<span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                            '</span>' +
                            '<br><br><a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="user" data-koordinat="' + data[i].koordinat +
                            '" style="color:green;cursor: pointer;"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;' + jarakuser + ' Km dengan posisi Anda</a><br>' +
                            '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                            '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                        ).addTo(travellayer)
                        marker.setRadius(8);

                    } else if (data[i].bentuk == "SPS" || data[i].bentuk == "Kursus" || data[i].bentuk == "TPA" || data[i].bentuk == "PKBM" || data[i].bentuk == "SLB" || data[i].bentuk == "SDLB" || data[i].bentuk == "SMLB" || data[i].bentuk == "SMPLB") {
                        var marker = L.circleMarker([words2[0], words2[1]], {
                          color: '#90EE90', weight: 2, fillOpacity: 0.1
                        }).bindPopup(
                            '<b class="text-sm">' + data[i].nmtempat +'</b><br>'+
                            '<span class="btext-xs">' + data[i].alamat + '</span><br><br>' +
                            '<span class="btext-xs" style="color:gray"><b>Keterangan</b><br>' + data[i].diskripsi +
                            '</span>' +
                            '<br><br><a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="user" data-koordinat="' + data[i].koordinat +
                            '" style="color:green;cursor: pointer;"><span class="fas fa-user"></span>&nbsp;&nbsp;&nbsp;' + jarakuser + ' Km dengan posisi Anda</a><br>' +
                            '<a role="row" class="text-xs even" data-keterangan="wisata" data-ketjarak="kota" data-koordinat="' + data[i].koordinat +
                            '" style="color:blue;cursor: pointer;"><span class="fas fa-map-marker"></span>&nbsp;&nbsp;&nbsp;' + jarakkota + ' Km dengan pusat kota</a>'

                        ).addTo(travellayer)
                        marker.setRadius(8);

                    }
                }
            },
        });
    }

    $('#map').on('click', 'a', function() {

        const pusatXY = "-8.264371593833262, 113.6321026467762";
        const pusat = pusatXY.split(',');
        var pusatX = pusat[0];
        var pusatY = pusat[1];

        var posisiX = $("#lbllatitude").val();
        var posisiY = $("#lbllongitude").val();

        const koordinat = $(this).data("koordinat");
        const poss = koordinat.split(',');
        var koordinatX = poss[0];var koordinatY = poss[1];

        var keterangan = $(this).data("keterangan");
        var ketjarak = $(this).data("ketjarak");
        
        map.closePopup();
       
        if (ketjarak == "user"){
            var control = L.Routing.control({
                createMarker: function() { return null; },// menghilangkan marker tambahan						
                waypoints: [
                    L.latLng(koordinatX, koordinatY),
                    L.latLng(posisiX, posisiY)
                ],
                routeWhileDragging: false,
                reverseWaypoints: false,
                fitSelectedRoutes: true,
            }).addTo(map)
            //map.closePopup();
            control.hide();
            //control.spliceWaypoints(0, 1); // <-- removes your route
        } else if (ketjarak == "kota"){
            var control = L.Routing.control({
                createMarker: function() { return null; },	// menghilangkan marker tambahan					
                waypoints: [
                    L.latLng(koordinatX, koordinatY),
                    L.latLng(pusatX, pusatY)
                ],
                routeWhileDragging: false,
                reverseWaypoints: false,
                fitSelectedRoutes: true,
            }).addTo(map)
            control.hide();
        }
    });

    $('#txtcarilokasi').keydown(function(e) {
        if (e.keyCode == 13) {
            var kata = $("#txtcarilokasi").val();
            if (kata.length >= 2) {
                $.ajax({
                    type: 'POST',
                    url: 'aksi/cari_lokasi.php',
                    data: {
                        kata: kata
                    },
                    dataType: 'json',
                    beforeSend: function(e) {
                        $("#loading").fadeIn();
                        document.body.style.cursor = "wait";
                    },
                    success: function(resp) {
                        $("#loading").fadeOut("slow");
                        document.body.style.cursor = "default";
                        if (resp.length >= 1) {
                            pencarianLokasi();
                        } else if (resp.length <= 0) {
                            alert("Data tidak diketemukan");
                            $("#txtcarilokasi").val("");
                            $("#txtcarilokasi").focus();
                        } else {
                            alert("Data tidak diketemukan");
                            $("#txtcarilokasi").val("");
                            $("#txtcarilokasi").focus();
                        }
                    },
                    error: function() {
                        $("#loading").fadeOut("slow");
                        document.body.style.cursor = "default";
                        alert("Koneksi ke server terputus");
                    },
                });

            } else {
                alert("Kata kunci pencarian kosong")
            }
        }
    });

    function pencarianLokasi() {
        var kata = $("#txtcarilokasi").val();
        $.ajax({
            type: 'POST',
            url: "aksi/isi_pencarian.php",
            data: {
                kata: kata
            },
            success: function(resp) {
                $("#loading").fadeOut("slow");
                $("#isianModTambahDataLarge").html(resp);
                $("#isianModTambahDataLarge").fadeIn(1000);
                $("#modTambahDataLarge").modal('show');
                $("#txtcarilokasi").val("");
            },
        });
    }

    function formatRibuan(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
     
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
     
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }
    
    $("#lv_kota").click(function(){
        $("#txttransid").val(""); $("#txttransketerangan").val("");
        map.closePopup();
        var nmwilayah = $(this).data('nama');
        $("#lblkoppeta").text(nmwilayah);
        $("#lblkopgrafik1").text(nmwilayah);$("#lblkopgrafik2").text(nmwilayah);
        $("#lblkopgrafik3").text(nmwilayah);$("#lblkopgrafik4").text(nmwilayah);
        var keterangan = $(this).data('keterangan');
        $("#txttransketerangan").val(keterangan);
        var koordinat = $(this).data('koordinat');
        const words1 = koordinat.split(',');
        map.setView([words1[0], words1[1]],10);
        hitungGrafikTotalSekolah();isiGrafikStatus();isiGrafikAkreditasi();isiGrafikBandingGuruSiswa();
        isiDataSarana();
    });

    $(".lv_kecamatan").click(function(){
        $("#txttransid").val(""); $("#txttransketerangan").val("");
        map.closePopup();    
        var koordinat = $(this).data('koordinat');
        const words1 = koordinat.split(',');
        map.setView([words1[0], words1[1]],16);   
        //map.openPopup();
        //hitungkecamatan();
        var idkecamatan = $(this).data('id'); var keterangan = $(this).data('keterangan');
        var nmwilayah = $(this).data('nama');
        $("#lblkoppeta").text(nmwilayah);
        $("#lblkopgrafik1").text(nmwilayah);$("#lblkopgrafik2").text(nmwilayah);
        $("#lblkopgrafik3").text(nmwilayah);$("#lblkopgrafik4").text(nmwilayah);
        $("#txttransid").val(idkecamatan); $("#txttransketerangan").val(keterangan);
        hitungGrafikTotalSekolahKec();isiGrafikStatusKec(); isiGrafikAkreditasiKec();isiGrafikBandingGuruSiswaKec();
        isiDataSarana();
    });
    
    $(".lv_desa").click(function(){
        $("#txttransid").val(""); $("#txttransketerangan").val("");
        map.closePopup();
        var koordinat = $(this).data('koordinat');
        const words1 = koordinat.split(',');
        map.setView([words1[0], words1[1]],18);
        //hitungdesa();	
        var iddesa = $(this).data('id'); var keterangan = $(this).data('keterangan');
        var nmwilayah = $(this).data('nama');
        $("#lblkoppeta").text(nmwilayah);
        $("#lblkopgrafik1").text(nmwilayah);$("#lblkopgrafik2").text(nmwilayah);
        $("#lblkopgrafik3").text(nmwilayah);$("#lblkopgrafik4").text(nmwilayah);
        $("#txttransid").val(iddesa); $("#txttransketerangan").val(keterangan);
        hitungGrafikTotalSekolahDesa();isiGrafikStatusDesa(); isiGrafikAkreditasiDesa();isiGrafikBandingGuruSiswaDesa();
        isiDataSarana();
    });
    */

        /*
     * Showing nearby units
     *
     * Usage:
     *   set position in format "latitude, longitude" and press `Find nearest to the position` button
     *   doubleclick on the map to set position of click
     *   choose unit from the list to set position of selected unit
     *   (click `Find nearest to the unit` button to update matching position by current unit position)
     *
     *   You can setup maximum results count/filter by time of last message
     *
     *   If you have checked `Use routing`, then it will calculate distance not geometrically,
     *   but by actual routes via roads, if possible.
     *
     * Implementation:
     *
     *   1. Request data and subscribe for new unit positions:
     *
     *        var flags = wialon.item.Item.dataFlag.base | wialon.item.Unit.dataFlag.lastPosition;
     *
     *        session.updateDataFlags([
     *          {type: 'type', data: 'avl_unit', flags: flags, mode: 0}
     *        ], callback);
     *
     *   2. To find geometrical distance, use wialon.util.Geometry.getDistance:
     *
     *        https://sdk.wialon.com/api/index.html#wialon.util.Geometry~getDistance
     *
     *      This method will always return value in meters.
     *
     *   3. To get distance of routes, use wialon.util.Gis.getOneToManyRoute:
     *
     *        https://sdk.wialon.com/api/index.html#wialon.util.Gis~getOneToManyRoute
     *
     *        wialon.util.Gis.getOneToManyRoute(lat, lon, [{lat: lat1, lon: lon1}, ...], callback);
     *
     *      In callback you will receive error code in first argument and array of results in the second.
     *
     *      For each point successful result will be in the next format:
     *
     *        {
     *         status: 'OK',
     *         distance: {
     *           value: 1492519.84,
     *           text: '1492.52 km'
     *         },
     *         duration: {
     *           value: 61062,
     *           text: '16 h 57 min'
     *         }
     *        }
     *
     *      Results from GIS will always be in meters.
     */

    // Token that will be used for auth
    // For more info about how to generate token check
    // http://sdk.wialon.com/playground/demo/app_auth_token
    var TOKEN = 'c6d211d32b6f36b2bc390774c6fc2e028B255F9C5040B21CD29F13F77DC2003895FCF0F2';

    // global variables
    var map, marker, unitMarkers = [],
        markerByUnit = {};
    var areUnitsLoaded = false;

    // for refreshing
    var currentPos = null,
        currentUnit = null;

    var isUIActive = true;

    function onlyTwoSignsAfterComma(n) {
        return Math.round(n * 100) / 100;
    }

    // show distance in meters or kilometers with only 2 signs after comma
    function prettyPrintDistance(distance) {
        if (distance < 1000) return Math.ceil(distance) + ' m';
        else return onlyTwoSignsAfterComma(distance / 1000) + ' km';
    }

    // Unit markers constructor
    function getUnitMarker(unit) {
        // check for already created marker
        var marker = markerByUnit[unit.getId()];
        if (marker) return marker;

        var unitPos = unit.getPosition();

        if (!unitPos) return null;

        marker = L.marker([unitPos.y, unitPos.x], {
            clickable: true,
            draggable: false,
            icon: L.icon({
                iconUrl: unit.getIconUrl(32),
                iconAnchor: [16, 16] // set icon center
            })
        });
        marker.on('click', function(e) {
            // select unit in UI
            $('#units').val(unit.getId());

            findAndShowNearestUnitsByUnit(unit, getFilterOptions());
        });

        // save marker for access from filtering by distance
        unitMarkers.push(marker);
        markerByUnit[unit.getId()] = marker;

        return marker;
    }

    function displayPosition(lat, lon) {
        // five signs is precise enough
        var displayLat = Math.round(lat * 100000) / 100000,
            displayLon = Math.round(lon * 100000) / 100000;

        // show position
        $('#latlng').val(displayLat + ', ' + displayLon);
        // we have got valid position
        $('#latlng').removeClass('invalid');
    }

    // Print message to log
    function msg(text) {
        $('#log').prepend(text + '<br/>');
    }

    // gets options from DOM controls
    function getFilterOptions() {
        return {
            lastMessageSeconds: parseInt($('#last-message-time-filter').val()) * 60, // in DOM we have minutes
            maxUnits: parseInt($('#max-units').val()),
            useRouting: $('#use-routing').prop('checked')
        };
    }
    // disable/enable buttons
    function toggleActiveUI(toggle) {
        isUIActive = toggle;

        $('#find-by-location-button').prop('disabled', !toggle);
        $('#find-by-unit-button').prop('disabled', !toggle);
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
        units.forEach(function(unit) {
            var unitMarker = getUnitMarker(unit);
            if (unitMarker) unitMarker.addTo(map);

            // Add option
            $('#units').append($('<option>').text(unit.getName()).val(unit.getId()));

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

        // find nearest to the unit choosed from <select>
        function onUnitSelected() {
            var unitId = parseInt($('#units').val());

            if (unitId === 0) return;

            var unit = session.getItem(unitId);

            if (!unit) {
                msg('No such unit');
                return;
            }

            var unitPos = unit.getPosition();

            if (!unitPos) {
                msg('Unit haven\'t a position');
                return;
            }

            findAndShowNearestUnitsByUnit(unit, getFilterOptions());
        }

        // find near unit
        $('#find-by-unit-button').click(onUnitSelected); // by button
        $('#units').change(onUnitSelected); // by unit selection

        // find near specified location
        $('#find-by-location-button').click(function() {
            // extracts two numbers divided by non-digits
            var latlngRegex = /^[^\d]*?(-?\d+(?:\.\d+)?)[^\.\d]+?(-?\d+(?:\.\d+)?)[^\d]*$/;

            var positionEl = $('#latlng');

            var groups = latlngRegex.exec(positionEl.val());
            if (!groups) { // invalid string
                positionEl.addClass('invalid');
                return;
            }

            var lat = parseFloat(groups[1]),
                lon = parseFloat(groups[2]);

            if (isFinite(lat) && isFinite(lon) && (-90 <= lat && lat <= 90) && (-180 <= lon && lon <= 180)) {
                positionEl.removeClass('invalid');

                findAndShowNearestUnitsByPos({
                    lat: lat,
                    lon: lon
                }, getFilterOptions());
            } else {
                positionEl.addClass('invalid');
            }
        });

        // refresh on settings change:
        function doRefresh() {
            if (isUIActive && currentPos) {
                if (currentUnit) findAndShowNearestUnitsByUnit(currentUnit, getFilterOptions());
                else findAndShowNearestUnitsByPos(currentPos, getFilterOptions());
            } // else TODO: cancel current operation & make new request
        }

        $('#max-units').change(doRefresh);
        $('#last-message-time-filter').change(doRefresh);
        $('#use-routing').change(doRefresh);
    }

    function findAndShowNearestUnitsByPos(pos, options) {
        currentUnit = null;
        $('#units').val('0'); // deselect unit

        _findAndShowNearestUnits(pos, options);
    }

    function findAndShowNearestUnitsByUnit(unit, options) {
        currentUnit = unit;

        var unitPos = unit.getPosition();

        _findAndShowNearestUnits({
            lat: unitPos.y,
            lon: unitPos.x
        }, options, {
            excludeUnitById: unit.getId()
        });
    }

    function _findAndShowNearestUnits(pos, options, _options) {
        // save pos for refreshing
        currentPos = pos;
        // disable UI to prevent second request
        toggleActiveUI(false);

        // center map at selected position
        map.setView([pos.lat, pos.lon]);

        // check for units
        if (!areUnitsLoaded) {
            msg('Units are not loaded yet, please, wait.');
            return;
        }

        // show coordinates
        displayPosition(pos.lat, pos.lon);

        // default filter values, 0 means "no filter, show all"
        var maximumUnits = 0,
            lastMessageTimeFilter = 0,
            useRouting = false,
            excludeUnitById = null;

        // get options, if any
        if (options) {
            if (options.lastMessageSeconds) lastMessageTimeFilter = options.lastMessageSeconds;
            if (options.maxUnits) maximumUnits = options.maxUnits;
            if (options.useRouting) useRouting = options.useRouting;
        }
        // extended options
        if (_options) {
            if (typeof _options.excludeUnitById === 'number') excludeUnitById = _options.excludeUnitById;
        }

        if (!marker) { // create and show default pointer marker, if not exists
            marker = L.marker(pos, {
                clickable: false,
                draggable: false,
                zIndexOffset: 1000 // show topmost
            });
            marker.addTo(map);
        } else { // set marker position
            marker.setLatLng(pos);
        }

        // get authorized session
        var session = wialon.core.Session.getInstance(),
            // get currenlty loaded items
            units = session.getItems('avl_unit');

        units = units.filter(function(unit) {
            // exclude units without position and excluded via options
            return Boolean(unit.getPosition()) && (unit.getId() !== excludeUnitById);
        });

        // filter by last position time
        if (lastMessageTimeFilter > 0) {
            units = units.filter(function(unit) {
                // compare server time with last position time
                return (session.getServerTime() - unit.getPosition().t) < lastMessageTimeFilter;
            });
        }

        // we use this function if not using routing, or if route is not exists
        function calcGeometryDistanceToUnit(pos, unit) {
            var unitPos = unit.getPosition();

            return {
                distance: wialon.util.Geometry.getDistance(pos.lat, pos.lon, unitPos.y, unitPos.x),
                unit: unit
            };
        }

        if (useRouting) {
            // extract points, since getOneToManyRoute receives points, not units
            var points = units.map(function(unit) {
                var unitPos = unit.getPosition();
                return {
                    lon: unitPos.x,
                    lat: unitPos.y
                };
            });

            msg('Loading route');

            // do a request
            wialon.util.Gis.getOneToManyRoute(pos.lat, pos.lon, points, function(error, data) {
                if (error) { // error was happened
                    msg(wialon.core.Errors.getErrorText(error));
                    return;
                }

                var resultUnits = [];

                // extract distances
                data.forEach(function(x, i) {
                    if (x.distance) { // get distance from response, if exists
                        resultUnits.push({
                            distance: x.distance.value,
                            unit: units[i]
                        });
                    } else { // else fallback to Geometry.getDistance
                        resultUnits.push(calcGeometryDistanceToUnit(pos, units[i]));
                    }
                });

                msg('Loaded');

                processResults(resultUnits);
            });
        } else {
            // calculate distance from marker for each unit
            units = units.map(function(unit) {
                return calcGeometryDistanceToUnit(pos, unit);
            });

            processResults(units);
        }

        // sorts, limits, adds results to the table
        function processResults(unitsWithDistance) {
            // sort by distance
            unitsWithDistance.sort(function(a, b) {
                return a.distance - b.distance;
            });

            // apply maximum units filter
            var showUnitsCount = maximumUnits === 0 ? units.length : Math.min(units.length, maximumUnits);

            // remove all rows from result table
            $('#results-table-body').empty();
            
            // add results to the table
            var i;
            for (i = 0; i < showUnitsCount; i++) {
                var unitWithDistance = unitsWithDistance[i];

                addResult(unitWithDistance.unit, unitWithDistance.distance);
            }

            if (i > 0) {
                $('#results-table').show();
                //$('#no-results').hide();
            } else { // if no results
                $('#results-table').hide();
                //$('#no-results').show();
            }

            // activate UI
            toggleActiveUI(true);

            function addResult(unit, distance) {
                var unitPos = unit.getPosition();
                var distanceText = prettyPrintDistance(distance);
                var lastMessageTime = wialon.util.DateTime.formatTime(unit.getPosition().t,
                1); // 1 - print date, if not current day

                // add result to the table
                var tr = $('<tr>');

                tr.append('<td>' + distanceText + '</td>');
                var unitNameTd = $('<td class="unit-name">').append($('<span>').text(unit.getName()));
                tr.append(unitNameTd);
                tr.append('<td>' + lastMessageTime + '</td>');

                // open map at unit position
                unitNameTd.click(function() {
                    var unitPos = unit.getPosition();
                    map.setView([unitPos.y, unitPos.x]);
                });

                $('#results-table-body').append(tr);

            }
        }
    }

    function initMap() {
        // create a map in the "map" div, set the view to a given place and zoom
        map = L.map('map', {
            // disable zooming, because we will use double-click to set up marker
            doubleClickZoom: false
        }).setView([-8.16884, 113.70224], 12);

        // add an OpenStreetMap tile layer
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            // copyrights
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | &copy; <a href="http://gurtam.com">Gurtam</a>'
        }).addTo(map);

        // handle mouse double-click event
        map.on('dblclick', function(e) {
            if (!isUIActive) return;

            // hide hint
            //$('#usage-hint').hide();

            findAndShowNearestUnitsByPos({
                lat: e.latlng.lat,
                lon: e.latlng.lng
            }, getFilterOptions());
        });
    }

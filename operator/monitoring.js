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
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {

                if (data[i].sttslayanan == "N") {
                    var disproses = "display:none";
                } else {
                    var disproses = "";
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

$("#lv_kota").on('click',function(){
    map.setView([-8.16884, 113.70224], 14);  
});

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

$('#menu-unit-ambulan').on('click', '.lv_unit', function() {
    var idunit = $(this).data('idunit');
    var nmunit = $(this).data('nmunit');
    var nmugd = $(this).data('nmugd');
    var idsdk = $(this).data('idsdk');
    var idugd = $(this).data('idugd');
    var sttslayanan = $(this).data('sttslayanan');
    if (sttslayanan == "Y") {
        $.ajax({
            type: "POST",
            url: "aksi/transaksi/edit_status.php",
            data: {
                idunit: idunit,
                idsdk: idsdk,
                idugd: idugd,
                sttslayanan: sttslayanan,
                nmunit: nmunit,
                nmugd: nmugd
            },
            success: function(resp) {
                $("#isianmodEditStatus").html(resp);
                $("#isianmodEditStatus").fadeIn(1000);
                $("#modEditStatus").modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $("#modEditStatus").modal('show');
            },
            error: function() {
                alert('Koneksi bermasalah periksa internet');
            },
        });
    } else {

        var val = idsdk; // get selected unit id
        if (!val) return; // exit if no unit selected
        var unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
        if (!unit) return; // exit if no unit
        var pos = unit.getPosition(); // get unit position
        if (!pos) return; // exit if no position
 
        map.setView({
            lat: pos.y,
            lng: pos.x
        },20);      

    }
});


function isiTabelLayanan() {
    $('#tabellayanan').dataTable().fnDestroy();       
    $.ajax({
        type: "POST",
        url: "aksi/isi_tabel_layanan.php",
        dataType: 'json',
        beforeSend: function(e) {
            $("#loading").fadeIn();
            document.body.style.cursor = "wait";
        },
        success: function(data) {
            document.body.style.cursor = "default";

            var globalidsdk = [];
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {

                globalidsdk.push(data[i].idsdk);

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
                    '<tr class="btn-reveal-trigger">' +
                    '<td class="align-middle" width="10%">' + data[i].tgllayanan + '<br>' + data[i]
                    .jamlayanan + '</td>' +
                    '<td class="align-middle" width="16%">' + data[i].nmpelapor + '<br>' + data[i]
                    .telppelapor + '</td>' +
                    '<td class="align-middle" width="16%">' + data[i].nmpasien + '<br>' + data[i].umur +
                    ' / ' + data[i].kelamin + '</td>' +
                    '<td class="align-middle" width="10%"><span class="badge badge-soft-' + warna +
                    '">' + data[i].ketgawat + '</span></td>' +
                    '<td class="align-middle" width="26%">' + data[i].nmdiagnosa + '</td>' +
                    '<td class="align-middle" width="17%">' + data[i].nmugd + '</td>' +
                    '<td class="d-flex align-middle" width="5%">'+
                      '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnNonAktif" data-id="'+data[i].idlayanan+'" data-idunit="'+data[i].idunit+'" data-nmpasien="'+data[i].nmpasien+'"><span class="fas fa-power-off"></span></button>'+
                      '<button class="btn btn-light icon-item rounded-3 me-2 fs--2 icon-item-sm btnLokasiUnit" data-idsdk="'+data[i].idsdk+'"><span class="fas fa-map-marker-alt"></span></button>'+
                    '</td>'+
                    '</tr>';
            }
            $("#lblGlobalUnit").val(globalidsdk);
            $('#isitabellayanan').html(html);
            $("#tabellayanan").dataTable({
                "paging": false,
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

$("#cmdRefreshLayanan").on('click',function(){
    ambilSemuaUnit();
    isiTabelLayanan();
});

$('#isitabellayanan').on('click','.btnNonAktif',function(){
    var idoperator = $('#lbleditor').val();
    var idlayanan = $(this).data('id');var nmpasien = $(this).data('nmpasien');
    var idunit = $(this).data('idunit');
    let text = "Yakin Anda merubah status layanan\nPasien "+nmpasien;
    if (confirm(text) == true) {
        ///// TRANSAKSI ///////
        $.ajax({
            type:"POST",		
            url :"aksi/aksi_ubah_layanan.php",	
            data:{idlayanan:idlayanan,idunit:idunit,idoperator:idoperator},
            dataType: "json",
            success:function(resp){
                alert(resp);
                ambilSemuaUnit();
                isiTabelLayanan();
                refreshGis();
            },
            error: function() {alert('Koneksi bermasalah periksa internet');},
        });
    }  
});

$('#isitabellayanan').on('click','.btnLokasiUnit',function(){
    var idsdk = $(this).data('idsdk');
    var val = idsdk; // get selected unit id
    if (!val) return; // exit if no unit selected
    var unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
    if (!unit) return; // exit if no unit
    var pos = unit.getPosition(); // get unit position
    if (!pos) return; // exit if no position

    map.setView({
        lat: pos.y,
        lng: pos.x
    },20);      
});


var TOKEN = 'c6d211d32b6f36b2bc390774c6fc2e02BAB7BFC712FE07A027CEECE7DA6D340EF0E2EF59';

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

    //////////////////////////////////////////////
    //// cari idunit == array unit yg sedang aktif
    //////////////////////////////////////////////
    const arridunit = $("#lblGlobalUnit").val();
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

    // marker.bindPopup('<a href="#" data-bind="popover"></a>');
    /*        marker.on('mouseover', function(e) {
                this.openPopup();
            });
            marker.on('mouseout', function(e) {
                this.closePopup();
            });
    */
    /*
    marker.on('click', function(e) {
        // select unit in UI
        $('#txttransidunit').val(unit.getId());

        findAndShowNearestUnitsByUnit(unit, getFilterOptions());
    });
*/
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


    //////////// ANYAR /////////// INIT TRACE //////////
    //////////////////////////////////////////////////////
    sess.loadLibrary("itemIcon"); // load Icon Library 
    sess.updateDataFlags( // load items to current session
        [{
            type: "type",
            data: "avl_unit",
            flags: flags,
            mode: 0
        }], // items specification

        function(code) { // updateDataFlags callback
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code

            var units = sess.getItems("avl_unit"); // get loaded 'avl_resource's items
            if (!units || !units.length) {
                msg("No units found");
                return;
            } // check if units found
            //for (var i = 0; i < units.length; i++) // construct Select list using found resources
            /*
                                $("#list-menu-unit").append(
                                    '<li class="treeview-list-item">' +
                                    '<div class="treeview-item">' +
                                    '<a class="flex-1 lv_unit" href="#!" data-idunit=' + unit.getId() + '>' +
                                    '<p class="treeview-text">' +
                                    '<span class="me-2 fas fa-ambulance text-danger"></span>' +unit.getName() +
                                    '</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '</li>');
                                    */
        });

    ///////////////// AKHIR INIT TRACE ///////////////
}

/*

*/

// will be called after updateDataFlags success
function initUIData() {
    var session = wialon.core.Session.getInstance();
    var units = session.getItems('avl_unit');
    html = '';
    units.forEach(function(unit) {
        var unitMarker = getUnitMarker(unit);
        if (unitMarker) unitMarker.addTo(map);
        
        console.log(unit.getId() + " - " +unit.getName())

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

    // find nearest to the unit choosed from <select>
    function onUnitSelected() {
        var unitId = parseInt($('#txttransidunit').val());

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
    //$('#units').change(onUnitSelected); // by unit selection

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

        if (isFinite(lat) && isFinite(lon) && (-90 <= lat && lat <= 90) && (-180 <= lon && lon <=
                180)) {
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
    //$('#units').val('0'); // deselect unit
    $('#txttransidunit').val('0'); // deselect unit
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
            })
            .bindTooltip("Pelapor", {
                permanent: true,
                direction: 'center',
                sticky: false,
                interactive: true,
                className: 'my-div-icon-pelapor'
            });
        marker.addTo(map);
    } else { // set marker position
        marker.setLatLng(pos)
            .bindTooltip("Pelapor", {
                permanent: true,
                direction: 'center',
                sticky: false,
                interactive: true,
                className: 'my-div-icon-pelapor'
            });
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

            //tr.append('<td class="text-center">' + unit.getId() + '</td>');
            var unitNameTd = $(
                '<td class="unit-name" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'
            ).append($('<span style="color:blue">').text(unit.getName()));
            tr.append(unitNameTd);
            tr.append('<td>' + distanceText + '</td>');
            tr.append('<td class="text-center">' + lastMessageTime + '</td>');

            var idunitx = unit.getId();
            $.ajax({
                type: "POST",
                url: 'aksi/ambil_status_unit.php',
                data: {
                    idunitx: idunitx
                },
                dataType: "json",
                success: function(data) {
                    document.body.style.cursor = "default";
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        if (data[i].sttslayanan == "N") {
                            var disproses = "display:none";
                        } else {
                            var disproses = "";
                        }

                        tr.append(
                            '<td style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap; ' +
                            disproses + '">' +
                            '<span class="badge badge-soft-primary rounded-pill ms-2" style="' +
                            disproses + '">On Proses</span>' +
                            '</td>');

                        tr.append(
                            '<td style="display:none">' + data[i].sttslayanan + '</td>');
                    }
                },
                error: function() {
                    document.body.style.cursor = "default";
                }
            });

            // open map at unit position
            unitNameTd.click(function() {

                var sttsproses = $('#results-table td:last').html();
                if (sttsproses == 'Y') {
                    alert("Maaf, status unit sedang on proses\nCari unit yang lainnya")
                    return
                }

                var unitPos = unit.getPosition();
                map.setView([unitPos.y, unitPos.x]);
                //////////////////////////
                //// ANYAR UNIT TRACE ////
                //////////////////////////
                $('#txttransidunit').val('0');
                $('#txttransidunit').val(unit.getId());
                //$("#txttransidunit").change(showUnit);
                //init_trace()
                var idoperator = $('#lbleditor').val();
                var pelapor = $('#txtpelapor').val();
                var telepon = $('#txttelepon').val();
                var pasien = $('#txtpasien').val();
                var jk = $('#cbokelamin').val();
                var umur = $('#cboumur').val();

                var ketgawat = $('#cbokategorigawat').val();

                var cariugd = $("#cborekom").val();
                var poss = cariugd.indexOf("@");
                var idugd = cariugd.substr(0, poss);

                var idunit = $('#txttransidunit').val();
                var koordinatpasien = $('#latlng').val();

                var idSymptom = $("select[name='cbodiagnosa[]']").map(function() {
                    return $(this).val();
                }).get();

                var data = new FormData();
                data.append('idoperator', idoperator);
                data.append('pelapor', pelapor);
                data.append('telepon', telepon);
                data.append('pasien', pasien);
                data.append('jk', jk);
                data.append('umur', umur);

                for (var a = 0; a < idSymptom.length; a++) {
                    data.append('idSymptom[]', idSymptom[a]);
                }

                data.append('ketgawat', ketgawat);
                data.append('idugd', idugd);

                data.append('idunit', idunit);
                data.append('koordinatpasien', koordinatpasien);

                if (pelapor.length <= 0) {
                    alert("Nama pelapor masih kosong")
                    $('#txtpelapor').focus()
                    return
                } else if (telepon.length <= 0) {
                    alert("Telepon pelapor masih kosong")
                    $('#txttelepon').focus()
                    return
                } else if (pasien.length <= 0) {
                    alert("Nama pasien masih kosong")
                    $('#txtpasien').focus()
                    return
                } else if (jk.length <= 0) {
                    alert("Jenis kelamin pasien masih kosong")
                    $('#cbokelamin').focus()
                    return
                } else if (umur.length <= 0) {
                    alert("Umur pasien masih kosong")
                    $('#cboumur').focus()
                    return

                } else if (idSymptom.length <= 0) {
                    alert("Diagnosa symptom masih kosong")
                    $('#cbodiagnosa').focus()
                    return
                } else if (ketgawat.length <= 2) {
                    alert("Kategori kegawatdaruratan masih kosong")
                    $('#cbokategorigawat').focus()
                    return

                } else if (idugd.length <= 0) {
                    alert("Rekomendasi RSUD / puskesmas masih kosong")
                    $('#cborekom').focus()
                    return
                }
                ///// TRANSAKSI ///////
                $.ajax({
                    type: "POST",
                    url: 'aksi/transaksi/aksi_tambah_transaksi.php',
                    data: data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function(e) {
                        $("#loading").fadeIn();
                        document.body.style.cursor = "wait";
                    },
                    success: function(resp) {
                        document.body.style.cursor = "default";
                        $("#loading").fadeOut("slow");
                        if (resp.msg2 == 'ok') {
                            showUnit()                         
                            ambilSemuaUnit()
                            isiTabelLayanan()
                            //refreshGis()
                            $('#results-table-body').empty();
                            $("#modPencarian").modal('hide');
                        } else if (resp.msg2 == 'err_val') {
                            alert(resp.msg1);
                        } else {
                            alert('Ada sedikit masalah, silakan coba lagi.');
                        }
                    },
                    error: function() {
                        alert('Koneksi bermasalah periksa internet');
                    }
                });

                // showUnit()
                //$('#results-table-body').empty();
                // $("#modPencarian").modal('hide');


            });

            $('#results-table-body').append(tr); // ISI TABEL KENDARAAN
        }
    }
}


function initMap() {

    // create a map in the "map" div, set the view to a given place and zoom
    // 52.33745, 9.81056 ==> -8.16884, 113.70224
    map = L.map('map', {
        // disable zooming, because we will use double-click to set up marker
        doubleClickZoom: false
    }).setView([-8.16884, 113.70224], 14);

    //googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    //googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
    //googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
    googleTraffic = L.tileLayer('https://{s}.google.com/vt/lyrs=m@221097413,traffic&x={x}&y={y}&z={z}', {
    //googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    //L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 22,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // 52.33745, 9.81056 ==> -8.16884, 113.70224
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
            if (!marker) { // create and show default pointer marker, if not exists
                marker = L.marker(data.results[i].latlng, {
                        icon: icoPelapor,
                        clickable: false,
                        draggable: false,
                        zIndexOffset: 1000 // show topmost
                    })
                    .bindTooltip("Pelapor", {
                        permanent: true,
                        direction: 'center',
                        sticky: false,
                        interactive: true,
                        className: 'my-div-icon-pelapor'
                    });
                marker.addTo(map);

            } else { // set marker position
                marker.setLatLng(data.results[i].latlng, {
                        icon: icoPelapor,
                        clickable: false,
                        draggable: false,
                        zIndexOffset: 1000 // show topmost
                    })
                    .bindTooltip("Pelapor", {
                        permanent: true,
                        direction: 'center',
                        sticky: false,
                        interactive: true,
                        className: 'my-div-icon-pelapor'
                    });
            }

            $("#latlng").val(data.results[i].latlng); /// isi text
        }

        bersihkan();
    });

 
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
        if (!isUIActive) return;

        // hide hint
        //$('#usage-hint').hide();
        $("#latlng").val(e.latlng.lat + ',' + e.latlng.lng);
        /*
                    findAndShowNearestUnitsByPos({
                        lat: e.latlng.lat,
                        lon: e.latlng.lng
                    }, getFilterOptions());
        */
        $('#results-table-body').empty();
        bersihkan()

        $("#isianModPencarian").fadeIn(1000);
        $("#modPencarian").modal('show');
    });

    //map.on("mouseover", alert("oke"));

}

/////////////////////////
///// tracking //////////
/////////////////////////

var map, marker, unitID, unitEventID, polyline, mapWaypts = []; // global variables

function init_trace() { // Execute after login succeed
    var sess = wialon.core.Session.getInstance(); // get instance of current Session
    // specify what kind of data should be returned
    var flags = wialon.item.Item.dataFlag.base;

    sess.loadLibrary("itemIcon"); // load Icon Library 
    sess.updateDataFlags( // load items to current session
        [{
            type: "type",
            data: "avl_unit",
            flags: flags,
            mode: 0
        }], // items specification
        function(code) { // updateDataFlags callback
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code

            var units = sess.getItems("avl_unit"); // get loaded 'avl_resource's items
            if (!units || !units.length) {
                msg("No units found");
                return;
            } // check if units found
            for (var i = 0; i < units.length; i++) // construct Select list using found resources
                //$("#units").append("<option value='" + units[i].getId() + "'>" + units[i].getName() +
                //   "</option>");
                // bind action to select change event
                //$("#units").change(showUnit);
                $("#txttransidunit").change(showUnit);
        });
}


function showUnit() { // show selected unit on map
    //var val = $("#units").val(); // get selected unit id
    $('#results-table-body').empty(); // kosongkan dulu tabel unit
    var val = $('#txttransidunit').val(); // get selected unit id

    if (!val) return; // exit if no unit selected
    var sess = wialon.core.Session.getInstance(); // get instance of current Session
    // specify what kind of data should be returned
    var flags = wialon.item.Unit.dataFlag.lastMessage;
    var unit = null;
    if (unitID) { // check if we already have previous unit
        unit = sess.getItem(unitID);
        sess.updateDataFlags( // remove previous item from current session
            [{
                type: "id",
                data: unitID,
                flags: flags,
                mode: 2
            }], // item specification
            function(code) {
                if (code) {
                    msg(wialon.core.Errors.getErrorText(code));
                    return;
                }

                if (unitEventID) unit.removeListenerById(unitEventID); // unbinding event from this unit
            });
    }

    unitID = val;
    unitEventID = null; // empty event ID
    mapWaypts = []; // remove all old checkpoints if they were here

    sess.updateDataFlags( // load item with necessary flags to current session
        [{
            type: "id",
            data: unitID,
            flags: flags,
            mode: 1
        }], // item specification
        function(code) {
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            }

            unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
            if (!unit) return; // exit if no unit
            var position = unit.getPosition(); // get unit position
            if (!position) return; // exit if no position 
            if (map) { // check if map created and we can detect position of unit

                var icon = L.icon({
                    iconUrl: unit.getIconUrl(32),
                    iconAnchor: [16, 16],
                    className: 'berkedip'
                });

                if (!marker) {
                    marker = L.marker({
                            lat: position.y,
                            lng: position.x
                        }, {
                            icon: icon
                        })
                        .addTo(map).bindPopup('Menuju pelapor', {
                            closeButton: false,
                            autoClose: false,
                            closeOnClick: false,
                            'className': 'berkedip'
                        }).openPopup()
                } else {
                    marker = L.marker({
                            lat: position.y,
                            lng: position.x
                        }, {
                            icon: icon
                        })
                        .addTo(map).bindPopup('Menuju pelapor', {
                            closeButton: false,
                            autoClose: false,
                            closeOnClick: false,
                            'className': 'berkedip'
                        }).openPopup()

                    // marker.on('click', function (e) {
                    //  /    alert("hallow")
                    // });
                    //marker.on('mouseout', function (e) {
                    //    this.closePopup();
                    //});

                }

                map.setView({
                    lat: position.y,
                    lng: position.x
                }, 18);

                if (!polyline) {

                    var pos = unit.getPosition(); // get unit position
                    wialon.util.Gis.getLocations([{
                        lon: pos.x,
                        lat: pos.y
                    }], function(code, address) {

                        polyline = L.polyline([{
                            lat: position.y,
                            lng: position.x
                        }], {
                            color: 'blue',
                            speed: pos.s,
                            keterangan: 'menuju lokasi',
                            alamat: address
                        })
                        //polyline.on('click', function() { 
                        //    alert(this.options.speed) 
                        //});
                        polyline.addTo(map)

                        //.bindTooltip(unit.getName(), {permanent: true, direction : 'bottom',sticky: true,className: 'my-div-icon-blink' })
                    });

                    //.bindPopup('Menuju lokasi').openPopup();

                }

                //if (polyline) polyline.setMap(null); // if there is alreday path of map - remove it
                //mapWaypts.push(latlon); // adding point to path array

            }

            msg("You chose unit: " + unit.getName());

            unitEventID = unit.addListener("messageRegistered",
                showData); // register event when we will receive message
        });
}

function showData(event) {
    var data = event.getData(); // get data from event

    if (!data.pos) return; // exit if no position 

    var appended = ''; // here we will put all required information
    var position = { // get unit position 
        x: data.pos.x,
        y: data.pos.y
    };
    appended += "Position (x: " + data.pos.x + "; y: " + data.pos.y + ")"; // printing position
    if (data.t) appended += ", time " + wialon.util.DateTime.formatTime(data.t,
        1); // printing event time (return user time)
    msg(appended); // writing to log message about this event

    if (map) { // check if map created

        marker.setLatLng({
            lat: position.y,
            lng: position.x
        });

        if (polyline) {
            polyline.addLatLng({
                lat: position.y,
                lng: position.x
            });
        }
        map.setView({
            lat: position.y,
            lng: position.x
        });
    }
}

///////////////////////////////////////
//////// INFORMASI UNIT ///////////////
///////////////////////////////////////
function getSelectedUnitInfo() { // print information about selected Unit
    var val = $("#txttransidunit").val(); // get selected unit id
    if (!val) return; // exit if no unit selected

    var unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
    if (!unit) {
        msg("Unit not found");
        return;
    } // exit if unit not found

    // construct message with unit information
    var text = "<div>'" + unit.getName() + "' selected. "; // get unit name
    var icon = unit.getIconUrl(32); // get unit Icon url
    if (icon) text = "<img class='icon' src='" + icon + "' alt='icon'/>" + text; // add icon to message
    var pos = unit.getPosition(); // get unit position
    if (pos) { // check if position data exists
        var time = wialon.util.DateTime.formatTime(pos.t);
        text += "<b>Last message</b> " + time + "<br/>" + // add last message time
            "<b>Position</b> " + pos.x + ", " + pos.y + "<br/>" + // add info about unit position
            "<b>Speed</b> " + pos.s; // add info about unit speed
        // try to find unit location using coordinates 
        wialon.util.Gis.getLocations([{
            lon: pos.x,
            lat: pos.y
        }], function(code, address) {
            if (code) {
                msg(wialon.core.Errors.getErrorText(code));
                return;
            } // exit if error code
            msg(text + "<br/><b>Location of unit</b>: " + address + "</div>"); // print message to log
            alert(text + "<br/><b>Location of unit</b>: " + address + "</div>")
        });
    } else // position data not exists, print message
        msg(text + "<br/><b>Location of unit</b>: Unknown</div>");
}
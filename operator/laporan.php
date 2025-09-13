<?php
error_reporting(0);
session_start();

if(isset($_SESSION['IDOPERATOR'])){
	$iduser=$_SESSION['IDOPERATOR'];
	$username=$_SESSION['USERNAME'];
  $nmoperator=$_SESSION['NMOPERATOR'];
	$akses=$_SESSION['AKSES'];
  $idinstansi=$_SESSION['IDINSTANSI'];
}else{
	header('location:../home.html');
}

require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

$editor=$iduser; 

$qricbg = ("SELECT nm_instansi,kota FROM m_instansi WHERE id_instansi='".$idinstansi."'");
$dbcabang = mysqli_query($dbconn,$qricbg);$c= mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));$nmkotains = ucwords(strtolower($c['kota']));
mysqli_free_result($dbcabang);

$qritoken = ("SELECT gps_token FROM set_server WHERE id_server='1'");
$dbToken = mysqli_query($dbconn,$qritoken);$d= mysqli_fetch_assoc($dbToken);
$gpstoken = $d['gps_token'];
mysqli_free_result($dbToken);
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="google" content="notranslate" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">

    <title>Dinas Kesehatan Kabupaten Jember</title>

    <link href="favicon.png" rel="icon" />
    <link href="favicon.png" rel="apple-touch-icon" />
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="assets/js/config.js"></script>
    <script src="vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link href="assets/lib/select2/select2.min.css" rel="stylesheet">
    <link href="assets/lib/select2-theme/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="vendors/select2-bootstrap4-theme/select2-bootstrap4.min.css" rel="stylesheet">

    <link href="vendors/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">
    <link href="assets/css/style_layanan.css" rel="stylesheet" id="style-default">

    <link href="assets/css/theme.min.css" rel="stylesheet" id="style-default">

    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="https://hst-api.wialon.com/wsdk/script/wialon.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    <script src="https://unpkg.com/esri-leaflet@^3.0.8/dist/esri-leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.css"
        crossorigin="" />
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.js" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"
        crossorigin="anonymous"></script>

    <style>
    .leaflet-control-container .leaflet-routing-container-hide {
        display: none;
    }
    </style>

    <style type="text/css">
    #loading {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(../assets/css/loading.gif) 50% 50% no-repeat #ede9df;
        background-color: #252525;
        opacity: 0.7;
        filter: alpha(opacity=70);
    }

    .pagination {
        padding-right: 10px;
    }

    .page-link {
        border: none;
        margin-top: 5px;
        padding-top: 5px;
        height: 32px;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
    }

    .paginate_button.active .page-link {
        background-color: black !important;
    }


    #map {
        width: 100%;
        height: 100vh;
    }

    @keyframes fade {
        from {
            opacity: 0;
        }
    }

    .berkedip {
        animation: fade 1s infinite alternate;
    }

    .custom-popup .leaflet-popup-content-wrapper {
        background: #2c3e50;
        color: #fff;
        font-size: 12px;
        line-height: 12px;
        border-radius: 5px;
    }

    .custom-popup .leaflet-popup-content-wrapper a {
        color: rgba(255, 255, 255, 0.1);
    }

    .custom-popup .leaflet-popup-tip-container {
        width: 10px;
        height: 12px;
    }

    .custom-popup .leaflet-popup-tip {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .leaflet-popup-content {
        max-width: 100px;
        max-height: 40px;
        height: 14px;
        /*overflow-y: scroll;*/
    }

    @keyframes blink {
        100% {
            height: 30px;
            opacity: 0;
            width: 30px;
        }
    }

    .my-div-icon {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 11pt;
        font-variant: inherit;
        font-weight: bold;
        text-align: center;
        color: cyan;
        text-shadow: 2px 3px 3px #000000;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-blink {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 10pt;
        font-variant: inherit;
        font-weight: bold;
        text-align: center;
        color: greenyellow;
        text-shadow: 2px 3px 3px #000000;
        background-color: transparent;
        animation: blink 1s infinite alternate;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-pelapor {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 13pt;
        font-variant: inherit;
        font-weight: bold;
        text-align: center;
        color: orangered;
        text-shadow: 2px 2px 2px #000000;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-rsud {
        font-family: sans-serif, Verdana, Tahoma;
        font-size: 10.5pt;
        font-weight: bold;
        text-align: center;
        color: red;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-puskesmas {
        font-family: sans-serif, Verdana, Tahoma;
        font-size: 10pt;
        font-weight: normal;
        text-align: center;
        color: maroon;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-klinik {
        font-family: sans-serif, Verdana, Tahoma;
        font-size: 10pt;
        font-weight: normal;
        text-align: center;
        color: black;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    #log {
        border: 1px solid #c6c6c6;
    }

    #usage-hint {
        color: gray;
    }

    #latlng.invalid {
        border-color: red;
    }

    table .unit-name span {
        border-bottom: 1px dashed;
    }

    table .unit-name:hover {
        cursor: pointer;
        background: #eee;
    }

    #results-table {
        display: none;
    }

    #no-results {
        display: none;
    }
    </style>

</head>


<body style="-webkit-user-select:none;-moz-user-select:none;">

    <div id="loading"></div>

    <div style="display:none">
        <input type="text" id="lblgpstoken" value="<?php echo $gpstoken;?>" readonly="readonly" />
        <input type="text" id="lbltglserver" value="<?php echo $tglserver;?>" readonly="readonly" />
        <input type="text" id="lblhalaman" value="" readonly="readonly" />
        <input type="text" id="lblnminstansi" value="<?php echo $nmcabang;?>" readonly="readonly" />

        <input type="text" id="lbleditor" value="<?php echo $editor;?>" readonly="readonly" />
        <input type="text" id="lblakses" value="<?php echo $akses;?>" readonly="readonly" />
        <input type="text" id="lblidinstansi" value="<?php echo $idinstansi;?>" readonly="readonly" />

        <input type="text" id="lbllatitude" value="" readonly="readonly" />
        <input type="text" id="lbllongitude" value="" readonly="readonly" />

        <input type="text" id="txttransid" value="" readonly="readonly" />
        <input type="text" id="txttransketerangan" value="" readonly="readonly" />

        <input type="text" id="txttransmenu" value="" readonly="readonly" />

        <input type="text" id="txtTransDashboardJadwal" value="<?php echo $tglserver;?>" readonly="readonly" />
    </div>

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container" id="like_button_container">

            <nav class="navbar navbar-vertical navbar-expand-xl navbar-vibrant">

                <script>
                var navbarStyle = localStorage.getItem("navbarStyle");
                if (navbarStyle && navbarStyle !== 'transparent') {
                    document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div>
                    <a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Laporan
                            </span></div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <a class="nav-link active" id="lv_tampilmap" data-keterangan="kota"
                                    data-koordinat="-8.264371593833262, 113.6321026467762" href="#!" role="button"
                                    data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-map-marked-alt"></span></span>
                                        <span class="nav-link-text ps-1" id="lblkettampilmap"></span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Sinkronisasi Data</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <a class="nav-link" href="#!" id="lv_sinkron">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-clock"></span></span>
                                        <span class="nav-link-text">Sinkron Laporan </span>
                                    </div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Menu Laporan</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <a class="nav-link" href="#!" id="lv_pelayanan">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span
                                                class="fas fa-chalkboard-teacher"></span></span>
                                        <span class="nav-link-text">Pelayanan </span>
                                    </div>
                                </a>

                                <a class="nav-link" href="#!" id="lv_lap_unit">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-tachometer-alt"></span></span>
                                        <span class="nav-link-text">Unit Ambulan </span>
                                    </div>
                                </a>

                            </li>

                            <li class="nav-item">
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Unit Ambulan</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                            </li>

                            <div id="menu-unit-ambulan"></div>

                        </ul>
                    </div>
                </div>
            </nav>



            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand mb-0">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="monitoring.html">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Laporan
                            </span>
                        </div>
                    </a>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">

                        <li class="nav-item"><a class="nav-link" aria-current="page" href="dashboard.html">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="master.html">Master Data</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page"
                                href="monitoring.html">Monitoring</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Laporan</a></li>

                        <!--li class="nav-item"><a class="nav-link" href="#">Track</a></!--li-->
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link" href="logout.html"><span class="fas fa-power-off"
                                    data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
                        </li>
                    </ul>
                </nav>


                <div id="area-halaman">

                    <div class="row g-0" id="area-map" style="display:none">

                        <div class="col-xxl-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h6 class="mb-0">Gis Sebaran Unit Ambulan <span id="lblkoppeta"></span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="tab-content">
                                        <div class="tab-pane preview-tab-pane active">
                                            <div class='custom-popup' id="map"
                                                style="height:100vh;width:100%;overflow:hidden !important;"></div>
                                        </div>

                                        <input class="form-control form-control-sm" type="text" id="lblGlobalUnit"
                                            style="display:none" />
                                        <input class="form-control form-control-sm" type="text"
                                            id="lblGlobalUnitMelayani" style="display:none" />

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!---------------- tabel PELAYANAN ------------------>
                    <div class="row g-0" id="area-tabel-layanan" style="display:none">
                        <div class="col-xxl-12">

                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap py-2 py-xl-0">Tabel Laporan Pelayanan</h5>
                                        </div>
                                        <div class="col-auto">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <button class="btn btn-falcon-default btn-sm" type="button"
                                                            id="cmdLapFilterLayanan">
                                                            <span class="fas fa-filter"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Filter</span></button>

                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td width="220px">
                                                        <div class="input-group input-group-sm" id="areaTanggalJadwal">
                                                            <input
                                                                class="form-control form-control-sm datetimepicker fs--1 ps-4"
                                                                id="txttanggalLapLayanan" type="text"
                                                                data-options='{"mode":"range","dateFormat":"d-m-Y","disableMobile":true}' />
                                                            <span
                                                                class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-1">
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <button class="btn btn-falcon-default btn-sm" type="button"
                                                            id="cmdLapRefreshLayanan">
                                                            <span class="fas fa-sync-alt"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <button class="btn btn-falcon-default btn-sm" type="button"
                                                            id="cmdLapExportLayanan">
                                                            <span class="fas fa-external-link-alt"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Export</span></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div id="area-filter"></div>

                                    <div class="table-responsive scrollbar">
                                        <table id="tabellayanan" class="table table-striped table-sm mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center">Waktu</th>
                                                    <th class="sort text-center">Pasien</th>
                                                    <th class="sort text-center">Kegawatan</th>
                                                    <th class="sort text-center">Diagnosa Symptom</th>
                                                    <th class="sort text-center">UGD</th>
                                                    <th class="sort text-center">Status</th>
                                                    <th class="sort text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white" id="isitabellayanan"></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!---------------- akhir PELAYANAN ------------------>

                    <!---------------- tabel AMBULAN ------------------>
                    <div class="row g-0" id="area-tabel-ambulan" style="display:none">
                        <div class="col-xxl-12">

                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap py-2 py-xl-0">Tabel Laporan Unit Ambulan
                                            </h5>
                                        </div>
                                        <div class="col-auto">
                                            <table>
                                                <tr>
                                                    <td width="220px">
                                                        <div class="input-group input-group-sm">
                                                            <input
                                                                class="form-control form-control-sm datetimepicker fs--1 ps-4"
                                                                id="txttanggalLapUnit" type="text"
                                                                data-options='{"mode":"range","dateFormat":"d-m-Y","disableMobile":true}' />
                                                            <span
                                                                class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-1">
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <button class="btn btn-falcon-default btn-sm" type="button"
                                                            value="Execute report" id="cmdRefreshLapUnit">

                                                            <span class="fas fa-sync-alt"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                        <button class="btn btn-falcon-default btn-sm" type="button"
                                                            id="cmdLapExportAmbulan">
                                                            <span class="fas fa-external-link-alt"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Export</span></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div id="area-filter-ambulan"></div>


                                    <div id="divtabellapambulan" style="display:none">
                                        <div class="table-responsive scrollbar">
                                            <table id="tabellapambulan"
                                                class="table table-striped table-sm mb-0 fs--1 w-100">
                                                <thead class="bg-200">
                                                    <tr>
                                                        <th class="sort text-center">Unit Ambulan</th>
                                                        <th class="sort text-center">No. PLat</th>
                                                        <th class="sort text-center">Kepemilikan</th>
                                                        <th class="sort text-center">Trip</th>
                                                        <th class="sort text-center">Durasi</th>
                                                        <th class="sort text-center">Jarak</th>
                                                        <th class="sort text-center">BBM</th>
                                                        <th class="sort text-center">BBM (Rp)</th>
                                                        <th class="sort text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white" id="isitabellapambulan"></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="divtabeldetaillapambulan" style="display:block">
                                        <div class="table-responsive scrollbar">
                                            <table id="tabeldetaillapambulan"
                                                class="table table-striped table-sm mb-0 fs--1 w-100">
                                                <thead class="bg-200">
                                                    <tr>
                                                        <th class="sort text-center">Unit Ambulan</th>
                                                        <th class="sort text-center">Lokasi Awal</th>
                                                        <th class="sort text-center">Lokasi Akhir</th>
                                                        <th class="sort text-center">Tempuh</th>
                                                        <th class="sort text-center">BBM</th>
                                                        <th class="sort text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white" id="isitabeldetaillapambulan"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <!---------------- akhir AMBULAN ------------------>

                    <div style="display:none">
                        <table>
                            <tr>
                                <td>
                                    <select id="res"></select>
                                    <select id="templ">
                                        <option value="unit_trips">Trips</option>
                                        <option value="unit_stays">Stays</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select id="units"></select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select id="interval">
                                        <option value="86400"
                                            title="60 sec * 60 minutes * 24 hours = 86400 sec = 1 day" selected >Last day</option>
                                        <option value="604800" title="86400 sec * 7 days = 604800 sec = 1 week">Last
                                            week</option>
                                        <option value="2592000" title="86400 sec * 30 days = 2592000 sec = 1 month"
                                            >Last
                                            month</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <ul id="columns"></ul>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="button" value="Execute report" id="exec_btn" /></td>
                            </tr>
                        </table>
                    </div>
                    <div id="log" style="display:none"></div>


                </div><!-- div halaman -->
            </div>

        </div>
        <!--area halaman-->

        </div>
        <!--content-->

        <?php
          include "modal-laporan.php";
        ?>

        </div>
    </main>
 
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>

    <script src="vendors/echarts/echarts.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>

    <script src="vendors/jquery/jquery.min.js"></script>
    <script src="vendors/jquery/socket.io-1.2.0.js"></script>

    <script src="assets/lib/select2/select2.min.js"></script>

    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="vendors/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>

    <script src="assets/js/flatpickr.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="master.js"></script>
    <script src="laporan.js"></script>

    <script type="text/javascript" charset="utf-8">
    /////////////////////////////////////////
    ////////// ESRI GEOSEARCH ///////////////
    ////////////////////////////////////////
    const apiKey =
        "AAPK1bfb3d228f564df9b4de063bc3b9f9b6BIgZuDPcOc6AMbPanwRt0H1MBp4WFKCz5So0Rf6vMw-_OioeU5aDZYV4Po94AoPm";
    var gpstoken = $("#lblgpstoken").val();
 
    $(document).ready(function() {
        $("#exec_btn").click(executeReport); 
        wialon.core.Session.getInstance().initSession("https://maxxfleetpro.com"); 
        wialon.core.Session.getInstance().loginToken(gpstoken,"",
            function(code) { 
                if (code) {
                    msg(wialon.core.Errors.getErrorText(code));
                    return;
                }
                msg("Logged successfully");
                initMap();
                init(); 
            });
        document.body.style.cursor = "default";
        bersihkan();
        bersihkanHalaman();

        $("#lblkettampilmap").text("Sembunyikan Map");
        $("#area-map").fadeIn();

        $("#chkMelayani").prop("checked", true);
        $("#chkSelesai").prop("checked", true);
       
        awalTglLaporan();
        $("#area-halaman").fadeIn();
        $("#area-tabel-layanan").fadeIn();
        ambilSemuaUnit();
        terapkanHtmlFilter();
        isiTabelLayanan();

        $("#loading").fadeOut("slow");
    });

    function terapkanHtmlFilter() {
        var rangetgllayanan = $("#txttanggalLapLayanan").val();
        if ($("#chkMelayani").is(':checked')) {
            var wrnmelayani = "bg-primary";
        } else {
            var wrnmelayani = "bg-soft-primary";
        }
        if ($("#chkSelesai").is(':checked')) {
            var wrnselesai = "bg-primary";
        } else {
            var wrnselesai = "bg-soft-primary";
        }

        var jk = $("#cbokelamin").val();
        if (jk == "") {
            var kelamin = "Jenis Kelamin";
            wrnkelamin = "bg-soft-primary";
        } else if (jk == "L") {
            var kelamin = "Laki-laki";
            wrnkelamin = "bg-primary";
        } else if (jk == "P") {
            var kelamin = "Perempuan";
            wrnkelamin = "bg-primary";
        }

        var umur = $("#cboumur").val();
        if (umur == "") {
            var lblumur = "Umur";
            wrnumur = "bg-soft-primary";
        } else {
            var lblumur = umur;
            wrnumur = "bg-primary";
        }

        var gawat = $("#cbokategorigawat").val();
        if (gawat == "") {
            var lblgawat = "Kegawatdaruratan";
            wrngawat = "bg-soft-primary";
        } else {
            var lblgawat = gawat;
            wrngawat = "bg-primary";
        }

        var symptom = $("#cbolapdiagnosa").val();
        if (symptom == "") {
            var lblsymptom = "Symptom";
            wrnsymptom = "bg-soft-primary";
        } else {
            var lblsymptom = $("#cbolapdiagnosa :selected").text();
            wrnsymptom = "bg-primary";
        }

        var ugd = $("#cbolapUGD").val();
        if (ugd == "") {
            var lblugd = "UGD";
            wrnugd = "bg-soft-primary";
        } else {
            var lblugd = $("#cbolapUGD :selected").text();
            wrnugd = "bg-primary";
        }

        $("#area-filter").html(
            '<div class="row fs--2 fw-normal text-900 mb-1 g-0">' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot bg-primary"></span><span>' +
            rangetgllayanan + '</span></div>' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot ' + wrnmelayani +
            '"></span><span>Status Melayani</span></div>' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot ' + wrnselesai +
            '"></span><span>Status Selesai</span></div>' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot ' + wrnkelamin +
            '"></span><span>' + kelamin + '</span></div>' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot ' + wrnumur + '"></span><span>' +
            lblumur + '</span></div>' +
            '<div class="col-auto d-flex align-items-center"><span class="dot ' + wrngawat + '"></span><span>' +
            lblgawat + '</span></div>' +
            '</div>' +

            '<div class="row fs--2 fw-normal text-900 mb-0 g-0">' +
            '<div class="col-auto d-flex align-items-center pe-3"><span class="dot ' + wrnsymptom +
            '"></span><span> ' + lblsymptom + '</span></div>' +
            '<div class="col-auto d-flex align-items-center"><span class="dot ' + wrnugd + '"></span><span> ' +
            lblugd + '</span></div>' +
            '</div>');
    }
    </script>


</body>

</html>
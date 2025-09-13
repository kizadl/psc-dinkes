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

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
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


    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@^3.0.8/dist/esri-leaflet.js"></script>
    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.css"
        crossorigin="" />
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.3/dist/esri-leaflet-geocoder.js" crossorigin=""></script>


    <!--
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
-->

    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"
        crossorigin="anonymous"></script>

    <!--link href="vendors/leaflet/leaflet.css" rel="stylesheet" />
    <link href="vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet" />
    <link href="vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet" /-->


    <!-- STYLING UNTUK LEAFLET -->
    <style>
    .leaflet-control-container .leaflet-routing-container-hide {
        display: none;
    }
    </style>
    <!-- STYLING UNTUK LEAFLET -->

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

    /*=====================
    ====== berkedip =======
    =======================*/
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

    /*=====================
    ======blink========
    =======================*/
    @keyframes blink {
        100% {
            height: 30px;
            opacity: 0;
            width: 30px;
        }
    }

    .my-div-icon {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 10pt;
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
        font-size: 10pt;
        font-weight: normal;
        text-align: center;
        color: white;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-puskesmas {
        font-family: sans-serif, Verdana, Tahoma;
        font-size: 9pt;
        font-weight: normal;
        text-align: center;
        color: greenyellow;
        background-color: transparent;
        border-style: none;
        box-shadow: none !important;
    }

    .my-div-icon-klinik {
        font-family: sans-serif, Verdana, Tahoma;
        font-size: 9pt;
        font-weight: normal;
        text-align: center;
        color: cyan;
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

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid" data-layout="container" id="like_button_container">

            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand mb-0">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="monitoring.html">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Dashboard
                            </span>
                        </div>
                    </a>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="https://sisrute.kemkes.go.id" target ="_blank">Sisrute Nas</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="master.html">Master Data</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" aria-current="page"
                                href="monitoring.html">Monitoring</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="laporan.html">Laporan</a>
                        </li>

                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link" href="logout.html"><span class="fas fa-power-off"
                                    data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
                        </li>
                    </ul>
                </nav>


                <div id="area-halaman">

                    <!---------------- GRAFIK JUMLAH ------------------>
                    <!------------------------------------------------->
                    <div class="row mb-3 g-3">
                        <div class="col-lg-6 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Jumlah Ambulan</p>
                                    </div>
                                    <div class="chart h-100" id="hitungUmurChart" data-echart-responsive="true">
                                        <canvas id="umurChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="col light">
                                        <p class="fs--1 fw-semi-bold">Grafik Jumlah RSUD, Puskesmas, Klinik</p>
                                    </div>
                                    <div class="chart h-100" id="hitungChartContentADMIN" data-echart-responsive="true">
                                        <canvas id="hitungChartADMIN"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3 g-3">
                        <div class="col-lg-12 ps-lg-2">
                            <div class="card">
                                <div class="bg-holder bg-card"
                                    style="background-image:url(../assets/img/icons/spot-illustrations/corner-5.png);">
                                </div>
                                <!--/.bg-holder-->

                                <div class="card-body position-relative">
                                    <div class="row g-2 align-items-sm-center">
                                        <div class="col-auto"><img src="../assets/img/icons/connect-circle.png" alt=""
                                                height="55" /></div>
                                        <div class="col">
                                            <div class="row align-items-center">
                                                <div class="col col-lg-8">
                                                    <h5 class="fs-0 mb-3 mb-sm-0 text-primary">Statistik Pelayanan Public Safety Centre</h5>
                                                    <p class="fs--1 mb-0">Detail statistik pelayanan dan detail pemakaian ambulan.</p>
                                                </div>
                                                <div class="col-12 col-sm-auto ms-auto">
                                            <table>
                                                <tr>
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
                                                            id="cmdGrafikRefresh">
                                                            <span class="fas fa-sync-alt"
                                                                data-fa-transform="shrink-3 down-2"></span>
                                                            <span
                                                                class="fs--1 d-none d-sm-inline-block ms-1">Refresh</span></button>
                                                    </td>
                                                </tr>
                                            </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---------------- GRAFIK PELAYANAN ------------------>
                    <!------------------------------------------------->
                    <div class="row mb-3 g-3">
                        <div class="col-lg-4 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">

                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan Kategori Kegawatdaruratan</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="chart h-100" id="hitunggawatChart" data-echart-responsive="true">
                                        <canvas id="gawatChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">

                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan Kategori Kelompok Umur</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="chart h-100" id="hitungLayanUmurChart" data-echart-responsive="true">
                                        <canvas id="LayanUmurChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">

                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan Kategori Jenis Kelamin</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="chart h-100" id="hitungJKChart" data-echart-responsive="true">
                                        <canvas id="JKChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 g-3">
                        <div class="col-lg-8 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">

                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan Kategori Gejala Symptom</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="chart h-100" id="hitunggejalaChart" data-echart-responsive="true">
                                        <canvas id="gejalaChart" style="height:250px !important"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 ps-lg-2">
                            <div class="card bg-line-chart-gradient h-lg-100">

                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan Kategori Faskes</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                                    <div class="chart h-100" id="hitungfaskesChart" data-echart-responsive="true">
                                        <canvas id="faskesChart" style="height:250px !important"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- div halaman -->



                <!---------------- tabel FADWAL ------------------>
                <div class="row mb-3 mt-3 g-3" id="area-jadwal" style="display:none">
                    <div class="col-xxl-12">

                        <div class="card z-index-1 mb-3">
                            <div class="card-header">
                                <div class="row flex-between-center">
                                    <div class="col-sm-auto d-flex align-items-center pe-0">
                                        <h6 class="mb-0 text-nowrap py-2 py-xl-0">Tabel Data Pelayanan Berbanding Dengan
                                            Perjalanan Ambulan <span class="lblkoppeta"></span></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body bg-light px-3 py-3">
                                <div class="table-responsive scrollbar">
                                    <table id="tabeljadwal" class="table table-striped table-sm mb-0 fs--1 w-100">
                                        <thead class="bg-200">
                                            <tr>
                                                <th class="sort text-center">Nama Area</th>
                                                <th class="sort text-center">Laki-Laki</th>
                                                <th class="sort text-center">Perempuan</th>
                                                <th class="sort text-center">Penduduk</th>
                                                <th class="sort text-center">Rawan</th>
                                                <th class="sort text-center">Penerima</th>
                                                <th class="sort text-center">Ancaman</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white" id="isitabeljadwal"></tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!---------------- akhir jadwal ------------------>








            </div>

        </div>
        <!--area halaman-->

        </div>
        <!--content-->

        <?php
          //include "modal-laporan.php";
        ?>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>

    <!--script src="vendors/echarts/echarts.min.js"></!--script-->
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script src="master.js"></script>
    <script src="dashboard.js"></script>

    <script type="text/javascript" charset="utf-8">
 
    // execute when DOM ready
    $(document).ready(function() {
        document.body.style.cursor = "default";
        bersihkan();
        bersihkanHalaman();

        $("#lblkettampilmap").text("Sembunyikan Map");
        $("#area-map").fadeIn();

        //CariTglDashboard();
        awalTglLaporan();
        $("#area-halaman").fadeIn();
        $("#area-tabel-layanan").fadeIn();
     
        grafikGender();
        grafikTotalBencana();

        grafikLayananUmur();
        grafikLayananKegawatan();
        grafikLayananJK();
        grafikLayananSymptom();
        grafikLayananFaskes();

        $("#loading").fadeOut("slow");
    });
    </script>


</body>

</html>
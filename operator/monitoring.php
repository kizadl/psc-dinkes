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

    .page-link {
        padding-top: 5px;
        height: 32px;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
    }

    .paginate_button.active .page-link {
        background-color: gray !important;
        box-shadow: none !important;
    }

    .page-item .page-link {
        box-shadow: none !important;
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
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Dinkes
                                PSC</span></div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <a class="nav-link active" id="lv_kota" data-nama="Kabupaten Jember"
                                    data-keterangan="kota" data-koordinat="-8.264371593833262, 113.6321026467762"
                                    href="#" role="button" data-bs-toggle="collapse" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fas fa-map-marked-alt"></span></span>
                                        <span class="nav-link-text ps-1">Sebaran Unit Ambulan</span>
                                    </div>
                                </a>
                            </li>


                            <li class="nav-item">

                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">RSUD, Puskesmas, Klinik</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <?php
$menuutama = mysqli_query($dbconn, "SELECT id_ugd,nm_ugd,alamat,telepon,stts_ugd,koordinat,id_kecamatan,id_desa FROM m_ugd GROUP BY stts_ugd ASC");
while($dm = mysqli_fetch_array($menuutama)){
    
$idkec = $dm['stts_ugd'];$idkec2="ID". str_replace(".", "", $idkec);
$nmkecamatan = ucwords(strtolower($dm['nm_ugd']));$koordinatkec = $dm['koordinat'];    

if ($dm['stts_ugd'] == "rsud"){$nmsttsugd = "RSUD";}
else if ($dm['stts_ugd'] == "puskesmas"){$nmsttsugd = "Puskesmas";}
else if ($dm['stts_ugd'] == "klinik"){$nmsttsugd = "Klinik";}
else if ($dm['stts_ugd'] == "desa"){$nmsttsugd = "Desa";}

$submenu = mysqli_query($dbconn, "SELECT * FROM m_ugd WHERE stts_ugd = '".$idkec."' ORDER BY stts_ugd,nm_ugd ASC");

echo "<a class='nav-link dropdown-indicator lv_kecamatan' href='#$idkec2' data-id='$idkec' data-keterangan='kecamatan' data-nama='$nmsttsugd' data-koordinat='$koordinatkec' role='button' data-bs-toggle='collapse' aria-expanded='false' aria-controls='$idkec2'>
<div class='d-flex align-items-center'><span class='nav-link-icon'>
<span class='fas fa-home'></span>
</span><span class='nav-link-text ps-1'>$nmsttsugd</span>
</div>
</a>";

      echo "<ul class='nav collapse' id='$idkec2' data-parent='#navbarVerticalCollapse'>";

      while($sub = mysqli_fetch_array($submenu)){
            $idsub = $sub['id_ugd'];$idsub2="ID". str_replace(".", "", $idsub);
            $nmdesa = ucwords(strtolower($sub['nm_ugd'])); $koordinatdesa = $sub['koordinat'];     

            echo " <li class='nav-item'>
                        <a class='nav-link lv_desa' href='#$idsub2' id='$idsub' data-idkec='$idkec' data-id='$idsub' data-keterangan='desa' data-nama='$nmdesa' data-koordinat='$koordinatdesa' data-bs-toggle='collapse' aria-expanded='false' aria-controls='$idsub2'>
                            <div class='d-flex align-items-center'>
                            <!--<span-- class='fas fa-map-marker-alt'></span-->
                            <span class='nav-link-text ps-1'>$nmdesa</span>
                            </div>
                        </a></li>";

  } 
  echo"</ul>";
}
mysqli_free_result($menuutama);mysqli_free_result($submenu);
//mysqli_close($dbconn);
?>

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
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Dinkes
                                PSC</span>
                        </div>
                    </a>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="https://sisrute.kemkes.go.id" target ="_blank">Sisrute Nas</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="dashboard.html">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="master.html">Master Data</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Monitoring</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="laporan.html">Laporan</a></li>
                        
                        <!--li class="nav-item"><a class="nav-link" href="#">Track</a></!--li-->
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link" href="logout.html"><span class="fas fa-power-off"
                                    data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
                        </li>
                    </ul>
                </nav>


                <div id="area-halaman">

                    <div class="row g-0">

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

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!---------------- tabel PELAYANAN ------------------>
                    <div class="row g-0" id="area-tabel-layanan">
                        <div class="col-xxl-12">

                            <div class="card z-index-1 mb-3">
                                <div class="card-header">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h6 class="fs--1 mb-0 text-nowrap py-2 py-xl-0">Tabel Data Status Pelayanan
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <div id="table-purchases-replace-element">
                                                <button class="btn btn-falcon-default btn-sm" type="button"
                                                    id="cmdRefreshLayanan"><span
                                                        class="d-none d-sm-inline-block ms-1">Refresh</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body bg-light px-3 py-3">
                                    <div class="table-responsive scrollbar">
                                        <table id="tabellayanan" class="table table-striped table-sm mb-0 fs--1 w-100">
                                            <thead class="bg-200">
                                                <tr>
                                                    <th class="sort text-center">Waktu</th>
                                                    <th class="sort text-center">Pelapor</th>
                                                    <th class="sort text-center">Pasien</th>
                                                    <th class="sort text-center">Status</th>
                                                    <th class="sort text-center">Diagnosa Symptom</th>
                                                    <th class="sort text-center">UGD</th>
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

                </div><!-- div halaman -->

            </div>


        </div>
        <!--area halaman-->

        </div>
        <!--content-->

        <?php
          include "modal.php";
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
    <script src="monitoring.js"></script>

    <script type="text/javascript" charset="utf-8">
    /////////////////////////////////////////
    ////////// ESRI GEOSEARCH ///////////////
    ////////////////////////////////////////
    const apiKey =
        "AAPK1bfb3d228f564df9b4de063bc3b9f9b6BIgZuDPcOc6AMbPanwRt0H1MBp4WFKCz5So0Rf6vMw-_OioeU5aDZYV4Po94AoPm";
    var gpstoken = $("#lblgpstoken").val();
    $(document).ready(function() {
        wialon.core.Session.getInstance().initSession("https://maxxfleetpro.id"); 
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
        $("#area-halaman").fadeIn();
        ambilSemuaUnit();
        isiTabelLayanan();
        $("#loading").fadeOut("slow");
    });
    </script>


</body>

</html>
<?php
error_reporting(0);
session_start();

if (isset($_SESSION['IDOPERATOR'])) {
    $iduser = $_SESSION['IDOPERATOR'];
    $username = $_SESSION['USERNAME'];
    $nmoperator = $_SESSION['NMOPERATOR'];
    $akses = $_SESSION['AKSES'];
    $idinstansi = $_SESSION['IDINSTANSI'];
} else {
    header('location:../home.html');
}

require_once 'services/config.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

include "services/tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$tglserver = date('Y-m-d');

$editor = $iduser;

$qricbg = ("SELECT nm_instansi,kota FROM m_instansi WHERE id_instansi='" . $idinstansi . "'");
$dbcabang = mysqli_query($dbconn, $qricbg);
$c = mysqli_fetch_assoc($dbcabang);
$nmcabang = ucwords(strtolower($c['nm_instansi']));
$nmkotains = ucwords(strtolower($c['kota']));
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
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

        <input type="text" id="lbltglserver" value="<?php echo $tglserver; ?>" readonly="readonly" />
        <input type="text" id="lblhalaman" value="" readonly="readonly" />
        <input type="text" id="lblnminstansi" value="<?php echo $nmcabang; ?>" readonly="readonly" />

        <input type="text" id="lbleditor" value="<?php echo $editor; ?>" readonly="readonly" />
        <input type="text" id="lblakses" value="<?php echo $akses; ?>" readonly="readonly" />
        <input type="text" id="lblidinstansi" value="<?php echo $idinstansi; ?>" readonly="readonly" />

        <input type="text" id="lbllatitude" value="" readonly="readonly" />
        <input type="text" id="lbllongitude" value="" readonly="readonly" />

        <input type="text" id="txttransid" value="" readonly="readonly" />
        <input type="text" id="txttransketerangan" value="" readonly="readonly" />

        <input type="text" id="txttransmenu" value="" readonly="readonly" />

        <input type="text" id="txtTransDashboardJadwal" value="<?php echo $tglserver; ?>" readonly="readonly" />
    </div>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
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

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div>
                    <a class="navbar-brand" href="#">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Master
                            </span></div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                            <li class="nav-item">

                                <a class="nav-link" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false" id="cmdInstansi">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-home"></span></span><span class="nav-link-text ps-1">Identitas Instansi</span>
                                    </div>
                                </a>

                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Master Data</div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <a class="nav-link" href="#" role="button" data-bs-toggle="" aria-expanded="false" id="cmdMasterOPD">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-briefcase-medical"></span></span><span class="nav-link-text ps-1">RSUD, Puskesmas, Klinik</span>
                                    </div>
                                </a>

                                <a class="nav-link" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false" id="cmdSymptom">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-diagnoses"></span></span><span class="nav-link-text ps-1">Gejala Symptom</span>
                                    </div>
                                </a>

                                <a class="nav-link" href="#" role="button" data-bs-toggle="collapse" aria-expanded="false" id="cmdMasterAmbulan">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-ambulance"></span></span><span class="nav-link-text ps-1">Unit Ambulan</span>
                                    </div>
                                </a>

                                <a class="nav-link" href="#" role="button" data-bs-toggle="" aria-expanded="false" id="cmdMasterOperator">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-friends"></span></span><span class="nav-link-text ps-1">Operator</span>
                                    </div>
                                </a>

                            </li>

                        </ul>
                    </div>
                </div>
            </nav>



            <div class="content">

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand mb-0">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="monitoring.html">
                        <div class="d-flex align-items-center py-3"><span class="text-primary fw-bold mb-0">Master
                            </span>
                        </div>
                    </a>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="https://sisrute.kemkes.go.id" target ="_blank">Sisrute Nas</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="dashboard.html">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Master Data</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="monitoring.html">Monitoring</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="laporan.html">Laporan</a></li>

                        <!--li class="nav-item"><a class="nav-link" href="#">Track</a></!--li-->
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link" href="logout.html"><span class="fas fa-power-off" data-fa-transform="shrink-7" style="font-size: 33px;"></span></a>
                        </li>
                    </ul>
                </nav>


                <div id="area-halaman">
                    <?php
                    include "tabel-master.php";
                    ?>
                </div>


            </div>

        </div>
        <!--area halaman-->

        </div>
        <!--content-->

        <?php
        include "modal-master.php";
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

    <script src="master-data.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            setTimeout(function() {
                document.body.style.cursor = "default";
                bersihkan();
                $("#area-halaman").fadeIn();
                //isiMasterPengunjung();
                //$("#area-dashboard").fadeIn();
                $("#area-master-opd").fadeIn();
                isiMasterOPD();
                $("#lblhalaman").val("ugd");
                $("#loading").fadeOut("slow");

                wialon.core.Session.getInstance().initSession("https://maxxfleetpro.com"); // init session
                wialon.core.Session.getInstance().loginToken(
                    "c6d211d32b6f36b2bc390774c6fc2e02A8902042B5C0EA7983FAA419AFEA12745350B3D4", "", // try to login
                    function(code) { 
                        if (code) {
                            console.log(wialon.core.Errors.getErrorText(code));
                            return;
                        }
                        console.log("Logged successfully");
                       // init(); // when login suceed then run init() function
                    });
            }, 1000);
        });
/*
        var map, marker; // global variables

        // Print message to log
        function msg(text) {
            $("#log").prepend(text + "<br/>");
        }

        function init() { // Execute after login succeed
            var sess = wialon.core.Session.getInstance(); // get instance of current Session
            // specify what kind of data should be returned
            var flags = wialon.item.Item.dataFlag.base | wialon.item.Unit.dataFlag.lastMessage;

            sess.loadLibrary("itemIcon"); // load Icon Library 
            sess.updateDataFlags( // load items to current session
                [{
                    type: "type",
                    data: "avl_unit",
                    flags: flags,
                    mode: 0
                }], // Items specification
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
                        $("#units").append("<option value='" + units[i].getId() + "'>"  + units[i].getId() + " - " + units[i].getName() + "</option>");
                    // bind action to select change event
                    //$("#units").change(showUnit);
                });
        }

        function showUnit() { // show selected unit on map
            var val = $("#units").val(); // get selected unit id
            if (!val) return; // exit if no unit selected
            var unit = wialon.core.Session.getInstance().getItem(val); // get unit by id
            if (!unit) return; // exit if no unit
            var pos = unit.getPosition(); // get unit position
            if (!pos) return; // exit if no position
            // print message with information about selected unit and its position
            msg("<img src='" + unit.getIconUrl(32) + "'/> " + unit.getName() + " selected. Position " + pos.x + ", " + pos.y);

            if (map) { // check if map created
                var icon = L.icon({
                    iconUrl: unit.getIconUrl(32)
                });
                if (!marker) {
                    marker = L.marker({
                        lat: pos.y,
                        lng: pos.x
                    }, {
                        icon: icon
                    }).addTo(map);
                } else {
                    marker.setLatLng({
                        lat: pos.y,
                        lng: pos.x
                    });
                    marker.setIcon(icon);
                }
                map.setView({
                    lat: pos.y,
                    lng: pos.x
                });
            }
        }
*/
    </script>


</body>

</html>
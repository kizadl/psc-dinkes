<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="google" content="notranslate" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>PSC</title>

    <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicons/logo_jember.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicons/logo_jember.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicons/logo_jember.png" />
    <meta name="msapplication-TileImage" content="./assets/img/favicons/logo_jember.png" />
    <meta name="theme-color" content="#ffffff" />
    <script src="./assets/js/config.js"></script>
    <script src="./vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>

    <link href="./vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet" />
    <link href="./vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet" />
    <link href="./assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl" />
    <link href="./assets/css/theme.min.css" rel="stylesheet" id="style-default" />
    <link href="./assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl" />
    <link href="./assets/css/user.min.css" rel="stylesheet" id="user-style-default" />
    <script>
        var isRTL = JSON.parse(localStorage.getItem("isRTL"));
        if (isRTL) {
            var linkDefault = document.getElementById("style-default");
            var userLinkDefault = document.getElementById("user-style-default");
            linkDefault.setAttribute("disabled", true);
            userLinkDefault.setAttribute("disabled", true);
            document.querySelector("html").setAttribute("dir", "rtl");
        } else {
            var linkRTL = document.getElementById("style-rtl");
            var userLinkRTL = document.getElementById("user-style-rtl");
            linkRTL.setAttribute("disabled", true);
            userLinkRTL.setAttribute("disabled", true);
        }
    </script>
</head>

<body style="-webkit-user-select:none;-moz-user-select:none;">

    <main class="main" id="top">
        <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark" data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
            <div class="container">
                <a class="navbar-brand" href="./home.html">
                    <div class="d-flex align-items-center py-2">
                        <img class="me-2" src="./assets/img/logos/logo_psc.png" alt="Logo Jember Satu Data" width="200" />
                    </div>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary px-4" href="#!" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header px-4 position-relative modal-shape-header bg-shape">
                        <div class="position-relative z-index-1 light">
                            <h5 class="mb-0 text-white">Login Jember Safety Center</h5>
                            <p class="fs--1 mb-0 text-white">Silahkan masukkan username dan password Anda</p>
                        </div>
                        <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div id="loginMsg" style="display:none"></div>
                        <form id="loginFrm">
                            <div class="mb-3">
                                <input class="form-control" type="text" id="txtusername" autocomplete="off" placeholder="Username" />
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="password" id="txtpassword" autocomplete="off" placeholder="Password" />
                            </div>
                            <div class="mb-1">
                                <button class="btn btn-primary d-block w-100 mt-4" id="cmdLogin" type="button">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-0 overflow-hidden light" id="banner">
            <div class="bg-holder overlay" style="background-color:#180d5b"></div>
            <div class="container">
                <div class="row flex-center pt-4 pt-lg-8 pb-6" style="height:100vh">
                    <div class="d-none d-sm-block col-xl-4 align-self-center">
                        <img class="img-fluid" src="./assets/img/logos/ambulance.png" width="300" alt="Illustration" /><br><br><br><br><br>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-5 pb-6 text-start">
                        <h3 class="text-white fw-light" align="center">
                            Public Safety Center<br>
                            <span class="typed-text fw-bold" data-typed-text='["Dinas Kesehatan Kabupaten Jember"]'></span>
                        </h3>
                        <p class="lead text-white opacity-100" align="center">
                            PSC (Public Safety Center) merupakan system pelayanan public yang
                            berfungsi sebagai sarana untuk merespon kebutuhan kegawatan masyarakat dan manajemen sistem rujukan terintegrasi.
                        </p>

                    </div>
                    <div class="d-none d-sm-block col-xl-3 offset align-self-center">
                        <img class="img-fluid" src="./assets/img/illustrations/psc.png" alt="Illustration" /><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="./vendors/popper/popper.min.js"></script>
    <script src="./vendors/bootstrap/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="./vendors/anchorjs/anchor.min.js"></script>
    <script src="./vendors/is/is.min.js"></script>
    <script src="./vendors/swiper/swiper-bundle.min.js"></script>
    <script src="./vendors/typed.js/typed.js"></script>
    <script src="./vendors/fontawesome/all.min.js"></script>
    <script src="./vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="./vendors/list.js/list.min.js"></script>
    <script src="./assets/js/theme.js"></script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            document.body.style.cursor = "default";

            $("#cmdLogin").removeAttr("disabled");
            $("#txtusername").val("");
            $("#txtpassword").val("");
        });

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        $("#btn-pelayanan").click(function() {
            $("html, body").animate({
                    scrollTop: $("#data-informasi").offset().top,
                },
                1000
            );
        });

        $("#cmdLogin").click(function() {
            $("#loginFrm").submit(function(e) {
                return false;
            });
            var name = $("#txtusername").val();
            var nameLength = name.length;
            var pw = $("#txtpassword").val();
            var pwLength = pw.length;
            if (nameLength == 0) {
                $("#txtusername").focus();
                alert("Maaf, username masih kosong");
            } else if (pwLength == 0) {
                $("#txtpassword").focus();
                alert("Maaf, password masih kosong");
            } else if (nameLength && pwLength >= 1) {
                $.ajax({
                    type: "POST",
                    url: "services/login_user.php",
                    data: {
                        checkUser: '',
                        uid: name,
                        pwrd: pw
                    },
                    beforeSend: function(e) {
                        $("#cmdLogin").attr("disabled", "disabled");
                        document.body.style.cursor = "wait";
                    },
                    success: function(resp) {
                        document.body.style.cursor = "default";
                        $("#cmdLogin").removeAttr("disabled");
                        $("#loginMsg").html(resp);
                    },
                    error: function() {
                        alert('Koneksi bermasalah periksa internet');
                        document.body.style.cursor = "default";
                        $("#cmdLogin").removeAttr("disabled");
                    },
                });
            }
        });
    </script>
</body>

</html>
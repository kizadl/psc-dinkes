<div class="row mb-3 g-3" id="area-kop-dashboard" style="display:none">
    <div class="col-lg-12 ps-lg-2">
        <div class="card">
            <div class="bg-holder bg-card"
                style="background-image:url(../assets/img/icons/spot-illustrations/corner-5.png);">
            </div>

            <div class="card-body position-relative">
                <div class="row g-2 align-items-sm-center">
                    <div class="col-auto"><img src="../assets/img/icons/connect-circle.png" alt="" height="55" /></div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col col-lg-6">
                                <h5 class="mb-3 mb-sm-0 text-primary"><?php echo $nmcabang;?></h5>
                                <p class="fs--1 mb-0">Dashboard Pelayanan <?php echo $nmcabang;?></p>
                            </div>
                            <div class="col col-lg-6">
                                <div class="float-end">
                                    <table>
                                        <tr>
                                            <td width="220px">
                                                <div class="input-group input-group-sm" id="areaTanggalJadwal">
                                                    <input
                                                        class="form-control form-control-sm datetimepicker fs--1 ps-4"
                                                        id="txttanggalDashboard" type="text"
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
</div>

<!---------------- GRAFIK PELAYANAN ------------------>
<!------------------------------------------------->
<div class="row mb-3 g-3" id="area-dashboard" style="display:none">
    <div class="col-lg-6 ps-lg-2">
        <div class="card bg-line-chart-gradient h-lg-100">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-auto">
                        <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Grafik Pelayanan</h5>
                    </div>
                </div>
            </div>
            <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                <div class="chart h-100" id="hitungpelayananChart" data-echart-responsive="true">
                    <canvas id="pelayananChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 ps-lg-2">
        <div class="card bg-line-chart-gradient h-lg-100">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-auto">
                        <h5 class="fs--1 mb-0 text-nowrap text-white py-2 py-xl-0">Pelayanan Kategori Kegawatdaruratan
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body text-white d-flex flex-column justify-content-between h-100 pe-3">
                <div class="chart h-100" id="hitunggawatChart" data-echart-responsive="true">
                    <canvas id="gawatChart" style="height:300px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!---------------- INPUT PENANGANAN ------------------>
<div class="row mb-3 g-3" id="area-input-penanganan" style="display:none">
    <div class="col-xxl-12">

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pasien Masih Ditangani </h6>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshPenanganan"><span
                                    class="d-none d-sm-inline-block">Refresh</span></button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelinputpenanganan" class="table table-sm mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">Waktu</th>
                                <th class="sort text-center">Identitas Pasien</th>
                                <th class="sort text-center">Identifikasi Symptom</th>
                                <th class="sort text-center">Penanganan Medis</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelinputpenanganan"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!---------------- akhir input penanganan ------------------>

<!---------------- INPUT RUJUKAN ------------------>
<div class="row mb-3 g-3" id="area-input-rujukan" style="display:none">
    <div class="col-xxl-12">

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Data Pasien Rujukan </h6>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <div id="table-purchases-replace-element">
                            <button class="btn btn-falcon-default btn-sm" type="button" id="cmdRefreshRujukan"><span
                                    class="d-none d-sm-inline-block">Refresh</span></button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light px-3 py-3">
                <div class="table-responsive scrollbar">
                    <table id="tabelinputrujukan" class="table table-sm mb-0 fs--1 w-100">
                        <thead class="bg-200">
                            <tr>
                                <th class="sort text-center">Waktu</th>
                                <th class="sort text-center">Identitas Pasien</th>
                                <th class="sort text-center">Asal Rujukan - Symptom</th>
                                <th class="sort text-center">Penanganan Medis</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="isitabelinputrujukan"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<!---------------- akhir input rujukan ------------------>

<!---------------- LAPORAN ------------------>
<div class="row mb-3 g-3" id="area-laporan" style="display:none">
    <div class="col-xxl-12">

        <div class="card z-index-1 mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h6 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Laporan Pelayanan</h6>
                    </div>
                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <table>
                            <tr>
                                <td>
                                    <div id="table-purchases-replace-element">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-sm datetimepicker fs--1 ps-4"
                                                id="txttanggalLaporan" type="text"
                                                data-options='{"mode":"range","dateFormat":"d-m-Y","disableMobile":true}' />
                                            <span
                                                class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-1">
                                            </span>
                                        </div>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <button class="btn btn-falcon-default btn-sm" type="button"
                                        id="cmdRefreshLaporan"><span
                                            class="d-none d-sm-inline-block">Refresh</span></button>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <button class="btn btn-falcon-default btn-sm" type="button"
                                        id="cmdExportLaporan"><span
                                            class="d-none d-sm-inline-block">Export</span></button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body bg-light px-3 py-3">
            <div class="table-responsive scrollbar">
                <table id="tabellaporan" class="table table-sm mb-0 fs--1 w-100">
                    <thead class="bg-200">
                        <tr>
                            <th class="sort text-center">Waktu</th>
                            <th class="sort text-center">Identitas Pasien</th>
                            <th class="sort text-center">Rujukan / Symptom</th>
                            <th class="sort text-center">Penanganan Medis</th>
                            <th class="text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white" id="isitabellaporan"></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>
<!---------------- akhir laporan ------------------>
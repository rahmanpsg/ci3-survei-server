<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survei Kepuasan Masyarakat</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- <link rel="shortcut icon" href="../assets/images/favicon.png" /> -->
</head>

<body>
    <?php $this->load->view('admin/header') ?>
    <!-- partial -->
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--success">
                            <div class="card-inner">
                                <h5 class="card-title">Responden</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= $totalResponden ?></h5>
                                <p class="tx-12 text-muted">Total responden keseluruhan</p>
                                <div class="card-icon-wrapper">
                                    <i class="material-icons">people</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--danger">
                            <div class="card-inner">
                                <h5 class="card-title">Unsur</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= $totalUnsur ?></h5>
                                <p class="tx-12 text-muted">Total unsur</p>
                                <div class="card-icon-wrapper">
                                    <i class="material-icons">assessment</i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php for ($i = 1; $i < 5; $i++) : ?>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--<?= $warna[$i - 1] ?>">
                                <div class="card-inner">
                                    <h5 class="card-title">Responden Triwulan <?= $this->Model->getRomawi($i); ?></h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= !$totalRespondenTriwulan ? '0' : $totalRespondenTriwulan[$i - 1]['total'] ?></h5>
                                    <p class="tx-12 text-muted">Total Responden Triwulan <?= $this->Model->getRomawi($i); ?> Tahun 2020</p>
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-2 mb-sm-0">Data SKM</h4>
                                <div class="d-flex justtify-content-between align-items-center">
                                    <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">Tahun 2020</p>
                                    <!-- <i class="material-icons options-icon">more_vert</i> -->
                                </div>
                            </div>
                            <div class="d-block d-sm-flex justify-content-between align-items-center">
                                <h6 class="card-sub-title mb-0">Hasil survei kepuasan masyarakat berdasarkan triwulan</h6>
                            </div>
                            <div class="chart-container mt-4">
                                <canvas id="skm-chart" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 mdc-layout-grid__cell--span-8-tablet">
                        <div class="mdc-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-2 mb-sm-0">Karakteristik Responden</h4>
                                <div class="d-flex justtify-content-between align-items-center">
                                    <div class="menu-button-container">
                                        <button class="mdc-button mdc-menu-button">
                                            <i class="material-icons options-icon">more_vert</i>
                                        </button>
                                        <div class="mdc-menu mdc-menu-surface" tabindex="-1" id="menu-karakteristik">
                                            <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                                                <?php foreach ($karakteristik as $key => $value) : ?>
                                                    <li class="mdc-list-item" data-jenis="<?= $key ?>" role="menuitem">
                                                        <h6 class="item-subject font-weight-normal" data-jenis="<?= $key ?>"><?= $key ?></h6>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container mt-4">
                                <canvas id="chart-karakteristik" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- partial:partials/_footer.html -->
        <footer>
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                        <span class="tx-14">Copyright © 2020 <a href="#">Survei Kepuasan Masyarakat</a>.</span>
                    </div>
                </div>
            </div>
        </footer>
        <!-- partial -->
    </div>
    </div>
    </div>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/chartjs/Chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') ?>"></script>
    <script src="<?= base_url('assets/js/material.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>

    <script>
        function getDataSKM(tahun = new Date().getFullYear()) {
            const data = {
                tahun
            }

            return $.ajax('<?= base_url('api/getDataSKM') ?>', {
                async: false,
                data
            }).responseJSON
        }

        function loadData() {
            const {
                dataSurvei,
                dataUnsur
            } = getDataSKM()

            let dataSets = []
            const bgColor = ['rgba(0, 187, 221, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(0, 182, 122, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ]

            $.each(dataSurvei, (i, v) => {
                dataSets.push({
                    label: `Triwulan ${i}`,
                    data: $.map(v, val => {
                        return (val.reduce((a, b) => {
                            return a + b
                        }) / val.length).toFixed(2)
                    }),
                    borderColor: bgColor[i - 1],
                    borderWidth: 5
                })
            })

            console.log(dataSurvei);
            return {
                labels: dataUnsur.map(v => {
                    return v.unsur
                }),
                datasets: dataSets
            }
        }

        //Skm Chart
        if ($("#skm-chart").length) {
            let skmChartCanvas = $("#skm-chart").get(0).getContext("2d");

            let skmChart = new Chart(skmChartCanvas, {
                type: 'bar',
                data: loadData(),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                zeroLineColor: "rgba(0, 0, 0, 0.09)",
                                color: "rgba(0, 0, 0, 0.09)"
                            },
                            ticks: {
                                fontColor: '#bababa',
                                min: 0,
                                max: 4,
                                stepSize: 0.5,
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            barPercentage: 0.4
                        }]
                    }
                }
            });
        }

        // ===========================================================================================

        var dataKarakteristik = <?= json_encode($karakteristik); ?>;

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [],
                    backgroundColor: [],
                    label: 'Dataset 1'
                }],
                labels: []
            },
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('chart-karakteristik').getContext('2d');
            window.myDoughnut = new Chart(ctx, config);

            $('#menu-karakteristik').attr('data-jenis', 'Desa').click()
        }

        $('#menu-karakteristik').on('click', function(e) {
            const {
                jenis
            } = e.target.dataset

            config.data.labels = dataKarakteristik[jenis]
            config.options.title.text = `Karakteristik Responden Berdasarkan ${jenis}`

            const bgColor = dataKarakteristik[jenis].map((v, i) => {
                return getRandomColor()
            })

            $.ajax('<?= base_url('api/getDataKarakteristik') ?>', {
                data: {
                    jenis
                }
            }).then(res => {
                config.data.datasets.forEach(function(dataset) {
                    const newData = [];
                    $.each(dataKarakteristik[jenis], (i, v) => {
                        res.find((val) => {
                            if (val.jenis == v) {
                                newData[i] = val.total
                                return true
                            }
                        })
                    });

                    dataset.data = newData
                    dataset.backgroundColor = bgColor;
                });

                window.myDoughnut.update();
            })

        })

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>

</html>
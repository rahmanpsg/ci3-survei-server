<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survei Kepuasan Masyarakat</title>
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/jvectormap/jquery-jvectormap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/@fortawesome/fontawesome-free/css/all.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/select2/select2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
</head>

<body>
    <?php $this->load->view('admin/header') ?>
    <!-- partial -->
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                <h1 class="mdc-typography--headline2">Data Responden</h1>
                            </div>
                            <div class="toolbar">
                                <select id="selectFilter" onchange="setFilter(this.value)">
                                    <option value="">Semua Data</option>
                                    <?php for ($i = 1; $i < 5; $i++) : ?>
                                        <option value="<?= $i ?>">Triwulan <?= $this->Model->getRomawi($i); ?></option>
                                    <?php endfor ?>
                                </select>
                                <select id="selectFilterTahun" onchange="setFilter(this.value, true)">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                </select>
                                <button class="mdc-button mdc-button--raised" onclick="cetakData()">
                                    <i class="material-icons mdc-button__icon">print</i>
                                    Cetak Data
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hoverable" id="table" data-toolbar='.toolbar' data-url='<?= $TBL_URL ?>' data-toggle="table" data-pagination="true" data-search="true" data-detail-view="true" data-detail-formatter="detailFormatter" data-filter-control="true" data-unique-id="id">
                                    <thead>
                                        <tr>
                                            <th data-field="no" data-formatter="indexFormatter" class="text-center">#</th>
                                            <th data-field="nama" data-visible="false">Tanggal</th>
                                            <th data-field="tanggal" data-formatter="tanggalFormatter" data-sortable="true">Tanggal</th>
                                            <th data-field="umur" class="text-center" data-sortable="true" data-filter-control="select_range">Umur</th>
                                            <th data-field="jenis_kelamin" data-filter-control="select" data-sortable="true">Jenis Kelamin</th>
                                            <th data-field="pendidikan_terakhir" data-filter-control="select" data-sortable="true">Pendidikan Terakhir</th>
                                            <th data-field="pekerjaan" data-filter-control="select" data-sortable="true">Pekerjaan</th>
                                            <th data-field="desa" data-filter-control="select" data-sortable="true">Desa</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="modal fade" id="myCetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Form Cetak</h4>
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="isi-laporan"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="mdc-button mdc-button--raised filled-button--primary" data-dismiss="modal">
                                                <i class="material-icons mdc-button__icon">close</i>
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
    <script src="<?= base_url('/assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('/assets/js/material.js') ?>"></script>
    <script src="<?= base_url('/assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table-filter-control.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table-id-ID.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/select2/select2.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/moment/moment-with-locales.min.js') ?>"></script>

    <script>
        $table = $('#table');
        let dataPertanyaan = [];

        (function() {
            $('#selectFilter').select2()
            $('#selectFilterTahun').select2()

            $.ajax(`<?= base_url('api/getData') ?>`, {
                data: {
                    tabel: 'pertanyaan'
                },
                dataType: 'json'
            }).then(res => {
                $.each(res, (i, v) => {
                    dataPertanyaan[v.no] = JSON.parse(v.jawaban)
                })
            })
        })()

        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function tanggalFormatter(val, row) {
            moment.locale('id')
            return moment(row.tanggal).format('DD MMMM YYYY')
        }

        function detailFormatter(val, row) {
            const jawaban = JSON.parse(row.jawaban)

            let res = [`<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                                    <span class="mdc-typography--overline">
                                                        Nama : ${row.nama}
                                                    </span>
                                                </div>`, `<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                                    <span class="mdc-typography--overline">
                                                        Saran : ${row.saran ? row.saran : '-'}
                                                    </span>
                                                </div>`]

            let totalNilai = 0;
            for (let item in jawaban) {
                const nilai = jawaban[item]
                totalNilai += nilai
                res.push(`<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                                    <span class="mdc-typography--overline">
                                                        Pertanyaan ${item} : ${dataPertanyaan[item][nilai-1]} (<b>${nilai}</b>)
                                                    </span>
                                                </div>`)
            }

            res.push(`<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                                    <span class="mdc-typography--overline">
                                                        Total : <b>${totalNilai}</b>
                                                    </span>
                                                </div>`)

            return res.join(' ')
        }

        //Moment.JS Return Date Ranges
        function getDates(startDate, stopDate) {
            var dateArray = [];
            var currentDate = moment(startDate);
            var stopDate = moment(stopDate);
            while (currentDate <= stopDate) {
                dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
                currentDate = moment(currentDate).add(1, 'days');
            }
            return dateArray;
        }

        function getQuarterFirstDay(d) {
            var m = d.getMonth() - d.getMonth() % 3;
            return moment(new Date(d.getFullYear(), m, 1)).format('MM-DD-YYYY');
        }

        function setFilter(val, isTahun = false) {
            let dataFilter = {};
            let tanggal;

            if (val) {
                if (isTahun) {
                    const triwulan = $('#selectFilter').val()
                    tanggal = moment(new Date(`${val}`)).quarter(triwulan);
                } else {
                    const tahun = $('#selectFilterTahun').val()
                    tanggal = moment(new Date(`${tahun}`)).quarter(val);
                }

                dataFilter = {
                    tanggal: getDates(tanggal.startOf('month').format('MM-DD-YYYY'), tanggal.add(2, 'M').endOf('month').format('MM-DD-YYYY'))
                }
            }

            $table.bootstrapTable('filterBy', dataFilter);
        }

        function cetakData() {
            const triwulan = $('#selectFilter').val();
            const tahun = $('#selectFilterTahun').val();

            if (!triwulan) {
                $('#selectFilter').select2('open')
                return;
            }

            const URL = '<?= base_url('cetak?') ?>' + `triwulan=${triwulan}&tahun=${tahun}`
            const laporan = "<embed src='" + URL + "' frameborder='1' width='100%'' height='400px'>";

            $('#myCetak').modal();
            $('.isi-laporan').empty();
            $('.isi-laporan').append(laporan);
        }
    </script>
</body>

</html>
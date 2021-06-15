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
    <link rel="stylesheet" href="<?= base_url('/assets/vendors/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
</head>

<body>
    <?php $this->load->view('admin/header') ?>
    <!-- partial -->
    <div class="page-wrapper mdc-toolbar-fixed-adjust" id="app">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                                <h1 class="mdc-typography--headline2">Data Pertanyaan</h1>
                            </div>
                            <div class="toolbar">
                                <button class="mdc-button mdc-button--raised" onclick="tambahPertanyaan()">
                                    <i class="material-icons mdc-button__icon">add</i>
                                    Tambah Pertanyaan
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="table" data-toolbar=".toolbar" data-url='<?= $TBL_URL ?>' data-toggle="table" data-pagination="true" data-search="true" data-detail-view="true" data-detail-formatter="detailFormatter" data-unique-id="no">
                                    <thead>
                                        <tr>
                                            <th data-field="no" class="text-center">No</th>
                                            <th data-field="pertanyaan">Pertanyaan</th>
                                            <th data-field="aksi" data-formatter="aksiFormatter" data-events="window.aksiEvents">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formPertanyaan">
                                                <input type="hidden" id="defaultNo">
                                                <div class="template-demo">
                                                    <div class="mdc-layout-grid__inner">
                                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                                                            <select name="id_unsur" id="selectUnsur" style="width: 100%;" oninvalid="this.setCustomValidity('Unsur belum dipilih')" oninput="setCustomValidity('')" required>
                                                                <!-- <option value="" selected disable>- Pilih Unsur -</option> -->
                                                                <?php foreach ($dataUnsur as $value) : ?>
                                                                    <option value="<?= $value['id'] ?>"> <?= $value['unsur'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2-desktop">
                                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                                <input type="number" class="mdc-text-field__input" name="no" oninvalid="this.setCustomValidity('Nomor harus diisi')" oninput="setCustomValidity('')" autocomplete="off" required>
                                                                <div class="mdc-notched-outline">
                                                                    <div class="mdc-notched-outline__leading"></div>
                                                                    <div class="mdc-notched-outline__notch">
                                                                        <label class="mdc-floating-label">Nomor</label>
                                                                    </div>
                                                                    <div class="mdc-notched-outline__trailing"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10-desktop" style="margin-bottom: 20px;">
                                                            <div class="mdc-text-field mdc-text-field--outlined">
                                                                <input class="mdc-text-field__input" name="pertanyaan" oninvalid="this.setCustomValidity('Pertanyaan harus diisi')" oninput="setCustomValidity('')" autocomplete="off" required>
                                                                <div class="mdc-notched-outline">
                                                                    <div class="mdc-notched-outline__leading"></div>
                                                                    <div class="mdc-notched-outline__notch">
                                                                        <label class="mdc-floating-label">Pertanyaan</label>
                                                                    </div>
                                                                    <div class="mdc-notched-outline__trailing"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mdc-layout-grid__inner">
                                                        <?php
                                                        for ($i = 1; $i < 5; $i++) :
                                                        ?>
                                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                                <div class="mdc-text-field mdc-text-field--outlined">
                                                                    <input class="mdc-text-field__input" name="jawaban[]" oninvalid="this.setCustomValidity('Jawaban harus diisi')" oninput="setCustomValidity('')" autocomplete="off" required>
                                                                    <div class="mdc-notched-outline">
                                                                        <div class="mdc-notched-outline__leading"></div>
                                                                        <div class="mdc-notched-outline__notch">
                                                                            <label class="mdc-floating-label">Jawaban <?= $i ?></label>
                                                                        </div>
                                                                        <div class="mdc-notched-outline__trailing"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        endfor;
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col text-right" style="margin-top:20px">
                                                    <button class="mdc-button mdc-button--raised">
                                                        <i class="material-icons mdc-button__icon">save</i>
                                                        Simpan
                                                    </button>
                                                    <button class="mdc-button mdc-button--raised filled-button--warning" data-dismiss="modal">
                                                        <i class="material-icons mdc-button__icon">close</i>
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- partial:../../partials/_footer.html -->
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
    <script src="<?= base_url('/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/assets/js/material.js') ?>"></script>
    <script src="<?= base_url('/assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/bootstrap-table/bootstrap-table-id-ID.js') ?>"></script>
    <script src="<?= base_url('/assets/vendors/select2/js/select2.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/sweetalert/sweetalert.min.js') ?>"></script>

    <script>
        $table = $('#table');
        $form = $('#formPertanyaan');
        $modal = $('#myModal');
        $modalLabel = $('#myModalLabel');

        $(document).ready(() => {
            $('#selectUnsur').select2({
                placeholder: '- Pilih Unsur -'
            })
        })

        function tambahPertanyaan() {
            $form.trigger('reset');
            $modal.modal('toggle')
            $modalLabel.text('Form Tambah Pertanyaan')

            $('#selectUnsur').val('').trigger('change')

            $('.mdc-notched-outline').removeClass('mdc-notched-outline--notched')
            $('.mdc-floating-label').removeClass('mdc-floating-label--float-above')
            $('.mdc-notched-outline__notch').css({
                width: 'auto'
            })
        }

        $form.on('submit', (e) => {
            e.preventDefault();
            const aksi = $modalLabel.text().split(' ')[1]

            let data = $form.serializeArray();

            data.push({
                name: 'aksi',
                value: aksi
            })

            if (aksi == 'Tambah') {

                formProses('simpan', data);
            } else {
                data.push({
                    name: 'where',
                    value: $('#defaultNo').val()
                })
                formProses('ubah', data);
            }
        })

        function formProses(aksi, data) {
            const URL = '<?= base_url('api/manajemenPertanyaan') ?>';

            $.ajax(URL, {
                type: 'post',
                dataType: 'json',
                data
            }).then(res => {
                if (res[0]) {
                    swal('Berhasil', `Data berhasil di${aksi}`, 'success', {
                        button: false,
                        timer: 1500
                    })

                    if (aksi == 'simpan') {
                        $table.bootstrapTable('append', res[1])
                    } else {
                        const dataUnsur = <?= json_encode($dataUnsur) ?>

                        dataUnsur.find((v, i) => {
                            if (v.id == res[1].id_unsur) {
                                res[1]['unsur'] = v.unsur;
                                return true;
                            }
                        })

                        $table.bootstrapTable('updateByUniqueId', {
                            id: res[2],
                            row: res[1]
                        });
                    }
                    $modal.modal('toggle')
                    return
                }

                swal('Gagal', `Data gagal di${aksi}`, 'error', {
                    button: false,
                    timer: 1500
                })
            }).catch(err => {
                swal('Error', err.statusText, 'error')
            })
        }

        function detailFormatter(index, row) {
            const jawaban = JSON.parse(row.jawaban)
            let res = `<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                        <span class="mdc-typography--overline">
                        Unsur : ${row.unsur}
                        </span>                          
                    </div>`;

            let i = 1
            for (let item of jawaban) {
                res += `<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10">
                        <span class="mdc-typography--overline">
                        Jawaban ${i++} : ${item}
                        </span>                          
                    </div>`
            }

            return res
        }

        function aksiFormatter(val) {
            return [`<button class="ubah mdc-button mdc-button--raised icon-button filled-button--success" style="width:30px;">
                        <i class="material-icons mdc-button__icon">edit</i>
                    </button>`,
                `<button class="hapus mdc-button mdc-button--raised icon-button filled-button--secondary" style="width:30px;">
                        <i class="material-icons mdc-button__icon">delete</i>
                    </button>`
            ].join(' ');
        }

        window.aksiEvents = {
            'click .ubah': function(e, value, row, index) {
                $form.trigger('reset')
                $modalLabel.text('Form Ubah Pertanyaan')
                $modal.modal('toggle')

                $('#defaultNo').val(row.no)
                $('input[name=no]').val(row.no)
                $('input[name=pertanyaan]').val(row.pertanyaan)
                $('#selectUnsur').val(row.id_unsur).trigger('change')

                const jawaban = JSON.parse(row.jawaban)

                $.each($('input[name="jawaban[]"'), function(i, v) {
                    $(this).val(jawaban[i])
                })

                $.each($form[0], (i, v) => {
                    if (v.tagName == 'INPUT') {
                        $(v).get(0).setCustomValidity('')
                        $(v).parent().removeClass('mdc-text-field--invalid')
                    }
                })
                $('.mdc-notched-outline').addClass('mdc-notched-outline--notched')
                $('.mdc-floating-label').addClass('mdc-floating-label--float-above')
            },
            'click .hapus': function(e, value, row, index) {
                swal({
                        text: `Data akan dihapus?`,
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "Batal",
                                value: null,
                                visible: true
                            },
                            confirm: {
                                text: "OK",
                                closeModal: false
                            }
                        }
                    })
                    .then(hapus => {
                        const data = {
                            tabel: 'pertanyaan',
                            where: {
                                no: row.no
                            }
                        }
                        $.ajax(`<?= base_url('api/hapusData') ?>`, {
                            type: 'post',
                            dataType: 'json',
                            data
                        }).then(res => {
                            if (res) {
                                swal(`Data berhasil dihapus`, {
                                    icon: "success",
                                    buttons: false,
                                    timer: 1000,
                                });

                                $table.bootstrapTable('remove', {
                                    field: 'no',
                                    values: row.no
                                });
                            }
                        }).catch(err => {
                            console.log(err);
                            swal('Error', err.statusText, 'error')
                        })
                    })
            }
        }
    </script>
</body>

</html>
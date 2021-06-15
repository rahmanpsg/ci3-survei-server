<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survei Kepuasan Masyarakat</title>
    <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- <link rel="shortcut icon" href="./assets/images/favicon.png" /> -->
</head>

<body>
    <script src="./assets/js/preloader.js"></script>
    <div class="body-wrapper">
        <div class="main-wrapper">
            <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
                <main class="auth-page">
                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">
                            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                                <div class="mdc-card">
                                    <h2 class="text-center">Login Admin</h2>
                                    <form id="formLogin">
                                        <div class="mdc-layout-grid">
                                            <div class="mdc-layout-grid__inner">
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <div class="mdc-text-field w-100">
                                                        <input class="mdc-text-field__input" id="username" name="username" required>
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="username" class="mdc-floating-label">Username</label>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <div class="mdc-text-field w-100">
                                                        <input class="mdc-text-field__input" type="password" id="password" name="password" required>
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="password" class="mdc-floating-label">Password</label>
                                                    </div>
                                                </div>
                                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <button class="mdc-button mdc-button--raised w-100">
                                                        Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="./assets/js/material.js"></script>
    <script src="./assets/js/misc.js"></script>
    <script src="./assets/vendors/sweetalert/sweetalert.min.js"></script>

    <script>
        const $form = $('#formLogin');

        $form.on('submit', (e) => {
            e.preventDefault();

            const data = $form.serializeArray()

            $.ajax('<?= base_url('login/cekLogin') ?>', {
                type: 'post',
                dataType: 'json',
                data
            }).then(res => {
                if (res) {
                    swal('Berhasil!', 'Anda berhasil login', {
                        buttons: false,
                        timer: 1500
                    }).then(() => window.location = "admin/")

                    return;
                }

                swal('Gagal!', 'Username atau Password salah', {
                    buttons: false,
                    timer: 1500
                })
            }).catch(() => {
                swal('Gagal!', 'Terjadi masalah diserver', 'error')
            })

        })
    </script>
</body>

</html>
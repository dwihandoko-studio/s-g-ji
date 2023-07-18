<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : "Administrator" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Portal Layanan Resmi Dinas Sosial Kab. Lampung Tengah" name="description" />
    <meta content="handokowae.my.id" name="author" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords" content="portal, layanan, portal layanan, portal layanan dinsos, dinsos, disdik, lampung, lampung tengah lampung tengah, dinas sosial, dinas Sosial lampung tengah, kabupaten lampung tengah">

    <meta property="og:title" content="Portal Layanan Resmi Dinas Sosial Kab. Lampung Tengah" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:image" content="<?= base_url('favicon/android-icon-192x192.png'); ?>" />
    <meta property="og:description" content="Portal Layanan Resmi Dinas Sosial Kab. Lampung Tengah" />

    <meta itemprop="name" content="Portal Layanan Resmi Dinas Sosial Kab. Lampung Tengah" />
    <meta itemprop="description" content="Portal Layanan Resmi Dinas Sosial Kab. Lampung Tengah" />
    <meta itemprop="image" content="<?= base_url('favicon/android-icon-192x192.png'); ?>" />

    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('favicon/apple-icon-57x57.png'); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('favicon/apple-icon-60x60.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('favicon/apple-icon-72x72.png'); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('favicon/apple-icon-76x76.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('favicon/apple-icon-114x114.png'); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('favicon/apple-icon-120x120.png'); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('favicon/apple-icon-144x144.png'); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('favicon/apple-icon-152x152.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon/apple-icon-180x180.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('favicon/android-icon-192x192.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('favicon/favicon-96x96.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= base_url('favicon/manifest.json'); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url('favicon/ms-icon-144x144.png'); ?>">
    <meta name="theme-color" content="#ffffff">

    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <link href="<?= base_url() ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="auth-body-bg">

    <div>
        <div class="container-fluid p-0 content-loading">
            <div class="row g-0">

                <div class="col-xl-9">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">

                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                                <!-- <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">Dinas Sosial </span>Kabupaten Lampung Tengah</h4> -->

                                                <div dir="ltr">
                                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" <b>Sinergitas melayani</b>, memberikan yang tebaik untuk masyarakat menuju <b>Lampung Tengah Berjaya.</b> "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">Dinas Sosial</h4>
                                                                    <p class="font-size-14 mb-0">Kabupaten Lampung Tengah</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" If Every Vendor on Envato are as supportive as Themesbrand, Development with be a nice experience. You guys are Wonderful. Keep us the good work. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">nezerious</h4>
                                                                    <p class="font-size-14 mb-0">- Skote User</p>
                                                                </div>
                                                            </div>

                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <!-- <div class="mb-4 mb-md-5">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="assets/images/logo-dark.png" alt="" height="18" class="auth-logo-dark">
                                        <img src="assets/images/logo-light.png" alt="" height="18" class="auth-logo-light">
                                    </a>
                                </div> -->
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary">Selamat Datang Kembali !</h5>
                                        <p class="text-muted">Silahkan Login Dulu Untuk Menggunakan Layanan.</p>
                                    </div>

                                    <div class="mt-4">
                                        <form action="/auth/login" method="post">

                                            <div class="mb-3">
                                                <label for="username" class="form-label">Email/NIK/No HP</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Email / NIK / No HP">
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="<?= base_url('auth/lupapassword') ?>" class="text-muted">Lupa password?</a>
                                                </div>
                                                <label class="form-label">Password</label>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    Ingat Saya
                                                </label>
                                            </div>

                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">MASUK</button>
                                            </div>


                                            <div class="mt-4 text-center">
                                                <h5 class="font-size-14 mb-3">Masuk Dengan</h5>

                                                <ul class="list-inline">
                                                    <!-- <li class="list-inline-item">
                                                        <a href="javascript::void()" class="social-list-item bg-primary text-white border-primary">
                                                            <i class="mdi mdi-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="javascript::void()" class="social-list-item bg-info text-white border-info">
                                                            <i class="mdi mdi-twitter"></i>
                                                        </a>
                                                    </li> -->
                                                    <li class="list-inline-item">
                                                        <a href="javascript::void()" class="social-list-item bg-danger text-white border-danger">
                                                            <i class="mdi mdi-google"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Belum punya akun ? <a href="./auth/register" class="fw-medium text-primary"> Daftar Sekarang </a> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> Dinsos Kab. Lampung Tengah. Supported <i class="mdi mdi-heart text-danger"></i> by <a href="https://kntechline.id">KNTechline</a></p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/blockUI.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/pages/auth-2-carousel.init.js"></script>

    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        <?php if (isset($error)) { ?>
            Swal.fire(
                "Peringatan!",
                '<?= $error ?>',
                "warning"
            );
        <?php } ?>
        $("form").on("submit", function(e) {

            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: "POST",
                url: '/auth/login',
                data: dataString,
                dataType: 'JSON',
                beforeSend: function() {
                    loading = true;
                    $('div.content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(msg) {
                    console.log(msg);
                    if (msg.status != 200) {
                        if (msg.status !== 201) {
                            if (msg.status !== 202) {
                                $('div.content-loading').unblock();
                                loading = false;
                                Swal.fire(
                                    "Gagal!",
                                    msg.message,
                                    "warning"
                                );
                            } else {
                                Swal.fire(
                                    "Warning!",
                                    msg.message,
                                    "warning"
                                ).then((valRes) => {
                                    // setTimeout(function() {
                                    document.location.href = msg.url;
                                    // }, 2000);

                                })
                            }
                        } else {
                            Swal.fire(
                                'Berhasil!',
                                msg.message,
                                'success'
                            ).then((valRes) => {
                                // setTimeout(function() {
                                document.location.href = msg.url;
                                // }, 2000);
                            })
                        }
                    } else {
                        Swal.fire(
                            'Berhasil!',
                            msg.message,
                            'success'
                        ).then((valRes) => {
                            // setTimeout(function() {
                            document.location.href = msg.url;
                            // }, 2000);
                            // document.location.href = window.location.href + "dashboard";
                        })
                    }
                },
                error: function(data) {
                    console.log(data);
                    loading = false;
                    $('div.content-loading').unblock();
                    Swal.fire(
                        'Gagal!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });

        });
    </script>
</body>

</html>
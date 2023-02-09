<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="handokowae.my.id">
    <title><?= isset($title) ? $title : "Dashboard" ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets') ?>/images/logo.svg">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/pages/dashboard-analytics.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/app-assets/css/pages/card-analytics.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/css/style.css">
    <script>
        const BASE_URL = '<?= base_url() ?>';
    </script>
    <?= $this->renderSection('scriptTop'); ?>
</head>

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static loading-logout  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <?= $this->include('template/top_bar'); ?>

    <?= $this->include('template/left_menu'); ?>

    <?= $this->renderSection('content'); ?>

    <?= $this->include('template/footer'); ?>

    <script src="<?= base_url('assets') ?>/app-assets/vendors/js/vendors.min.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/js/core/app-menu.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/js/core/app.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/js/scripts/components.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/vendors/js/extensions/shepherd.min.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/vendors/js/ui/blockUI.min.js"></script>
    <script src="<?= base_url('assets') ?>/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <?= $this->renderSection('scriptBottom'); ?>
    <script>
        function reloadPage(action = "") {
            if (action === "") {
                document.location.href = "<?= current_url(true); ?>";
            } else {
                document.location.href = action;
            }
        }

        function aksiLogout(e) {
            // e.preventDefault();
            const href = BASE_URL + "/auth/logout";
            Swal.fire({
                title: 'Apakah anda yakin ingin keluar?',
                text: "Dari Aplikasi ini",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Sign Out!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: href,
                        type: 'GET',
                        contentType: false,
                        cache: false,
                        beforeSend: function() {
                            $('body.loading-logout').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resMsg) {
                            Swal.fire(
                                'Berhasil!',
                                "Anda berhasil logout.",
                                'success'
                            ).then((valRes) => {
                                document.location.href = BASE_URL + "/web/home";
                            })
                        },
                        error: function() {
                            $('body.loading-logout').unblock();
                            Swal.fire(
                                'Gagal!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    })
                }
            })
        };
    </script>

</body>

</html>
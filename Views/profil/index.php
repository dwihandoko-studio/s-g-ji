<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= isset($title) ? $title : "Portal Layanan" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        .active-menu-href {
            color: #556ee6 !important;
        }
    </style>

    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>/assets/libs/ckeditor5-custom/build/ckeditor.js"></script>
    <link href="<?= base_url() ?>/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <script>
        // if (sessionStorage.getItem("is_visited") === null) {
        //     sessionStorage.setItem("is_visited", "dark-mode-switch");
        // }

        // sessionStorage.setItem("is_visited", "dark-mode-switch");
        const BASE_URL = '<?= base_url() ?>';
    </script>
    <style>
        ._sorot-mouse:hover {
            background-color: #c3cbe4;
        }

        ._sorot-mouse:hover ._color-h-hover {
            color: #000 !important;
        }

        ._sorot-mouse:hover ._color-p-hover {
            color: #202022 !important;
        }
    </style>

    <style>
        .preview-image-upload {
            position: relative;
        }

        .preview-image-upload .imagePreviewUpload {
            max-width: 200px;
            max-height: 200px;
            cursor: pointer;
        }

        .preview-image-upload .btn-remove-preview-image {
            display: none;
            position: absolute;
            top: 5px;
            left: 5px;
            background-color: #555;
            color: white;
            font-size: 16px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
        }

        .imagePreviewUpload:hover+.btn-remove-preview-image,
        .btn-remove-preview-image:hover {
            display: block;
        }

        .ul-custom-style-sub-menu-action {
            list-style: none;
            padding-left: 0.5rem;
            border: 1px solid #ffffff2e;
            padding-top: 0.5rem;
            padding-right: 0.5rem;
            border-radius: 1.5rem;
        }

        .li-custom-style-sub-menu-action {
            border: 1px solid white;
            display: inline-block !important;
            padding: 0.3rem 0.5rem 0rem 0.3rem;
            margin-right: 0.3rem;
            margin-bottom: 0.5rem;
            border-radius: 2rem;
        }

        .custom-style-sub-menu-action {
            font-size: 1em;
            line-height: 1;
            height: 24px;
            color: #f6f6f6;
            display: inline-block;
            position: relative;
            text-align: center;
            font-weight: 500;
            box-sizing: border-box;
            margin-top: -15px;
            vertical-align: -webkit-baseline-middle;
        }
    </style>
    <link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="light" data-layout="horizontal" data-layout-size="boxed" data-layout-mode="light" class="loading-logout">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php $uri = current_url(true); ?>
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= base_url('portal') ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>/assets/images/logo.svg" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>/assets/images/logo-dark.png" alt="" height="17">
                            </span>
                        </a>

                        <a href="<?= base_url('portal') ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>/assets/images/logo-light.svg" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>/assets/images/logo-light-old.png" alt="" height="19">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search..." style="background-color: #ffffff1a;">
                            <span class="bx bx-search-alt"></span>
                        </div>
                    </form>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Search input">

                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>s
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small" key="t-view-all"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="javascript: void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-cart"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript: void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>/assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">James Lemire</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript: void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="bx bx-badge-check"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="javascript: void(0);" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="<?= base_url() ?>/assets/images/users/avatar-4.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Salena Layfield</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= isset($user) ? ($user->image !== null ? base_url() . '/upload/user/' . $user->image : base_url() . '/assets/images/users/avatar-1.jpg') : base_url() . '/assets/images/users/avatar-1.jpg' ?>" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= isset($user) ? $user->fullname : '-' ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="<?= base_url('profil') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="javascript:aksiLogout(this);"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">PENGGUNA</h4>

                                <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:actionEdit('<?= $data->fullname ?>');" class="btn btn-primary btn-rounded waves-effect waves-light">Ubah Data PTK</a></li>
                        </ol>
                    </div> -->

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-3">
                                                <h5 class="text-primary">Welcome Back !</h5>
                                                <p>It will seem like simplified</p>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <img src="<?= base_url() ?>/assets/images/profile-img.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <img style="height: 72px; width: 72px; object-fit: cover;" src="<?= $data->image ? base_url() . '/upload/user/' . $data->image : base_url() . '/assets/images/users/avatar-1.jpg' ?>" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                            <h5 class="font-size-15 text-truncate"><?= $data->fullname ?></h5>
                                            <p class="text-muted mb-0 text-truncate">E-mail: <?= $data->email ?></p>
                                            <p class="text-muted mb-0 text-truncate">No HP: <?= $data->no_hp ?></p>
                                            <!-- <p class="text-muted mb-0 text-truncate">Role User: <?php //echo $data->role 
                                                                                                        ?></p> -->
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="pt-4">

                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">Email Verified</h5>
                                                        <p class="text-muted mb-0"><?= $data->email_verified == 1 ? '<span class="badge rounded-pill badge-soft-success">Ya</span>' : '<a href="javascript:actionAktivasi(\'Email\', \'aktivasi_email\');"><span class="badge rounded-pill badge-soft-danger">Tidak</span></a>' ?></p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">WA Verified</h5>
                                                        <p class="text-muted mb-0"><?= $data->wa_verified == 1 ? '<span class="badge rounded-pill badge-soft-success">Ya</span>' : '<a href="javascript:actionAktivasi(\'WA\', \'aktivasi_wa\');"><span class="badge rounded-pill badge-soft-danger">Tidak</span></a>' ?></p>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Edit Profil <i class="mdi mdi-chevron-down"></i></button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:actionEdit('DATA','edit');"><i class="mdi mdi-square-edit-outline font-size-16 align-middle"></i> &nbsp;Data Akun</a>
                                                            <a class="dropdown-item" href="javascript:actionEdit('PASSWORD', 'password');"><i class="mdi mdi-folder-key-network-outline font-size-16 align-middle"></i> &nbsp;Password Akun</a>
                                                            <a class="dropdown-item" href="javascript:actionEdit('FOTO', 'foto');"><i class="mdi mdi-image-edit font-size-16 align-middle"></i> &nbsp;Foto Akun</a>
                                                        </div>
                                                    </div>
                                                    <!-- <a href="javascript: actionEdit();" class="btn btn-primary waves-effect waves-light btn-sm">Edit Profile <i class="mdi mdi-arrow-right ms-1"></i></a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Akun Tertaut</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                                <?php if ($data->kk !== NULL) { ?>
                                                    <tr>
                                                        <th scope="row">Nama Lengkap</th>
                                                        <td>: <?= $data->fullname ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">NIK</th>
                                                        <td>: <?= $data->nik ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">KK</th>
                                                        <td>: <?= $data->kk ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Tempat Lahir</th>
                                                        <td>: <?= $data->tempat_lahir ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Tanggal Lahir</th>
                                                        <td>: <?= $data->tgl_lahir === NULL || $data->tgl_lahir === "" ? '-' : tgl_indo($data->tgl_lahir) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Jenis Kelamin</th>
                                                        <td>: <?= $data->jenis_kelamin === NULL || $data->jenis_kelamin === "" ? '-' : ($data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Pekerjaan</th>
                                                        <td>: <?= $data->pekerjaan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Kecamatan</th>
                                                        <td>: <?= getNamaKecamatan($data->kecamatan) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Kelurahan</th>
                                                        <td>: <?= getNamaKelurahan($data->kelurahan) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Alamat</th>
                                                        <td>: <?= $data->alamat ?></td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <th scope="row">Tidak ada yang tertaut.</th>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Aktifitas</h4>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Kegiatan</th>
                                                    <th scope="col">Waktu</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Skote admin UI</td>
                                                    <td>20 Oct, 2019</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
        </div>
        <!-- End Page-content -->
    </div>
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">
                <h5 class="m-0 me-2">Settings</h5>
                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>
            <div class="p-4">
                <div class="mb-2">
                    <img src="<?= base_url() ?>/assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>
                <div class="mb-2">
                    <img src="<?= base_url() ?>/assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" checked>
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>
                <div class="mb-2">
                    <img src="<?= base_url() ?>/assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
                <div class="mb-2">
                    <img src="<?= base_url() ?>/assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                    <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                </div>
            </div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>

    <!-- Modal -->
    <div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-loading">
                <div class="modal-header">
                    <h5 class="modal-title" id="content-detailModalLabel">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="contentBodyModal">
                </div>
            </div>
        </div>
    </div>

    <div id="content-aktivasiModal" class="modal fade content-aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="content-aktivasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-loading-aktivasi">
                <div class="modal-header">
                    <h5 class="modal-title" id="content-aktivasiModalLabel">Aktivasi</h5>
                </div>
                <div class="contentAktivasiBodyModal">
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
    <script src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/blockUI.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/dropzone/min/dropzone.min.js"></script>

    <script>
        function actionAktivasi(event, ak) {
            $.ajax({
                url: "./act",
                type: 'POST',
                data: {
                    action: ak,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.main-content').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.main-content').unblock();
                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {
                        $('#content-aktivasiModalLabel').html('AKTIVASI ' + event + ' AKUN <?= $data->fullname ?>');
                        $('.contentAktivasiBodyModal').html(resul.data);
                        $('.content-aktivasiModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-aktivasiModal').modal('show');
                    }
                },
                error: function() {
                    $('div.main-content').unblock();
                    Swal.fire(
                        'Failed!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }

        function actionEdit(event, ak) {
            $.ajax({
                url: "./edit",
                type: 'POST',
                data: {
                    action: ak,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.main-content').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.main-content').unblock();
                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {
                        $('#content-detailModalLabel').html('UBAH ' + event + ' AKUN <?= $data->fullname ?>');
                        $('.contentBodyModal').html(resul.data);
                        $('.content-detailModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-detailModal').modal('show');
                    }
                },
                error: function() {
                    $('div.main-content').unblock();
                    Swal.fire(
                        'Failed!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }

        function changeValidation(event) {
            $('.' + event).css('display', 'none');
        };

        function inputFocus(id) {
            const color = $(id).attr('id');
            $(id).removeAttr('style');
            $('.' + color).html('');
        }

        function inputChange(event) {
            console.log(event.value);
            if (event.value === null || (event.value.length > 0 && event.value !== "")) {
                $(event).removeAttr('style');
            } else {
                $(event).css("color", "#dc3545");
                $(event).css("border-color", "#dc3545");
                // $('.nama_instansi').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
            }
        }

        function ambilId(id) {
            return document.getElementById(id);
        }

        $('#content-detailModal').on('click', '.btn-remove-preview-image', function(event) {
            $('.imagePreviewUpload').removeAttr('src');
            document.getElementsByName("_file")[0].value = "";
        });

        function initSelect2(event, parrent) {
            $('#' + event).select2({
                dropdownParent: parrent
            });
        }

        $(document).ready(function() {

            // let tableDatatables = $('#data-datatables').DataTable({
            //     "processing": true,
            //     "serverSide": true,
            //     "order": [],
            //     "ajax": {
            //         "url": "./getAll",
            //         "type": "POST",

            //     },
            //     language: {
            //         processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            //     },
            //     "columnDefs": [{
            //         "targets": 0,
            //         "orderable": false,
            //     }],
            // });

        });

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
                text: "Keluar Dari Aplikasi.",
                icon: 'question',
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
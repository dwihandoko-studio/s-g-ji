<?= $this->extend('t-silastri/peng/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex align-items-center">
                    <img src="<?= base_url() ?>/assets/images/users/avatar-1.jpg" alt="" class="avatar-sm rounded">
                    <div class="ms-3 flex-grow-1">
                        <h5 class="mb-2 card-title">Hello, Henry Franklin</h5>
                        <p class="text-muted mb-0">Ready to jump back in?</p>
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-primary"><i class="bx bx-plus align-middle"></i> Add New Jobs</a>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex">
                    <h4 class="card-title mb-4 flex-grow-1">STATISTIK PERMOHONAN</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Jumlah Permohonan</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-success", "--bs-transparent"]' dir="ltr" id="eathereum_sparkline_charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-success me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 18.89%</span> Increase last month</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Permohonan Selesai</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-success", "--bs-transparent"]' dir="ltr" id="new_application_charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-success me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 24.07%</span> Increase last month</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Rejected</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-danger", "--bs-transparent"]' dir="ltr" id="total_rejected_charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-danger me-1"><i class="bx bx-trending-down align-bottom me-1"></i> 20.63%</span> Decrease last month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex">
                    <h4 class="card-title mb-4 flex-grow-1">DAFTAR LAYANAN</h4>
                    <!-- <div>
                        <a href="job-list.html" class="btn btn-primary btn-sm">View All <i class="bx bx-right-arrow-alt"></i></a>
                    </div> -->
                </div>
            </div>
            <?php if (isset($layanans)) { ?>
                <?php if (count($layanans) > 0) { ?>
                    <?php foreach ($layanans as $key => $v) { ?>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card text-center  _sorot-mouse">
                                <a href="<?= $v['layanan_url_peng'] ?>">
                                    <div class="card-body" style="min-height: 230px;">
                                        <div class="mb-4">
                                            <img class="avatar-lg" src="<?= base_url('uploads/layanan') . '/' . $v['layanan_image'] ?>" alt="">
                                        </div>
                                        <h5 class="font-size-15 mb-1"><a href="<?= $v['layanan_url_peng'] ?>" style="color: rgba(var(--bs-dark-rgb),var(--bs-text-opacity));" class="_color-h-hover"><?= $v['layanan_singkatan'] ?></a></h5>
                                        <p><a class="_color-p-hover" style="color: #747474;" href="<?= $v['layanan_url_peng'] ?>"><?= $v['layanan_deskripsi'] ?></a></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <!-- <div class="col-xl-4 col-sm-6">
                <div class="card text-center  _sorot-mouse">
                    <a href="<?= base_url('silastri/peng/layanan/keringananbiaya') ?>">
                        <div class="card-body">
                            <div class="mb-4">
                                <img class="avatar-lg" src="<?= base_url() ?>/assets/images/companies/mailchimp.svg" alt="">
                            </div>
                            <h5 class="font-size-15 mb-1"><a href="<?= base_url('silastri/peng/layanan/keringananbiaya') ?>" style="color: rgba(var(--bs-dark-rgb),var(--bs-text-opacity));" class="_color-h-hover">Keringanan Biaya</a></h5>
                            <p><a class="_color-p-hover" style="color: #747474;" href="<?= base_url('silastri/peng/layanan/keringananbiaya') ?>">Keringan Biaya Rumah Sakit Bagi yang Tidak Mampu.</a></p>

                        </div>
                    </a>
                </div>
            </div> -->
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Riwayat Aktifitas</h4>
                        <div data-simplebar style="max-height: 376px;">
                            <ul class="verti-timeline list-unstyled">
                                <li class="event-list">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle font-size-18"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="<?= base_url() ?>/assets/images/users/avatar-5.jpg" alt="" class="avatar-xs rounded-circle">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <b>Charles Brown</b> applied for the job <b>Sr.frontend Developer</b>
                                                <p class="mb-0 text-muted">3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="event-list">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle font-size-18"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                                                    <i class='bx bx-revision font-size-14'></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                Your subscription expires today <a href="javascript: void(0);">Renew Now</a>
                                                <p class="text-muted mb-0">53 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="event-list">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle font-size-18"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                                                    JA
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <b>Jennifer Alexandar</b> created a new account as a <b>Freelance</b>.
                                                <p class="text-muted mb-0">1 hrs ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="event-list">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle font-size-18"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="<?= base_url() ?>/assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <b>Mark Ellison</b> applied for the job <b>Project Manager</b>
                                                <p class="mb-0 text-muted">3 hrs ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="event-list">
                                    <div class="event-timeline-dot">
                                        <i class="bx bx-right-arrow-circle font-size-18"></i>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                                                    AZ
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div>
                                                <b>Acolin Zelton</b> created a new account as a <b>Freelance</b>.
                                                <p class="text-muted mb-0">1 hrs ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="text-center mt-4"><a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Riwayat Permohonan</h4>
                        <div data-simplebar style="max-height: 376px;">
                            <div class="vstack gap-4">
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/wechat.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Marketing Director</a></h6>
                                        <p class="text-muted mb-0">Themesbrand, USA - <b>53</b> sec ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/sass.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Frontend Developer</a></h6>
                                        <p class="text-muted mb-0">Themesbrand, Hong-Kong - <b>47</b> min ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/adobe.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">React Developer</a></h6>
                                        <p class="text-muted mb-0">Creative Agency, Danemark - <b>1</b> hrs ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/airbnb.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">NodeJs Developer</a></h6>
                                        <p class="text-muted mb-0">Skote Themes, Louisiana - <b>2</b> hrs ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/flutter.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Digital Marketing</a></h6>
                                        <p class="text-muted mb-0">Web Technology pvt.Ltd, Danemark - <b>8</b> hrs ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/mailchimp.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Marketing Director</a></h6>
                                        <p class="text-muted mb-0">Skote Technology, Dominica - <b>1</b> days ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/spotify.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Business Associate</a></h6>
                                        <p class="text-muted mb-0">Themesbrand, Russia - <b>2</b> days ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <img src="<?= base_url() ?>/assets/images/companies/reddit.svg" alt="" height="40" class="rounded">
                                    <div class="ms-2 flex-grow-1">
                                        <h6 class="mb-1 font-size-15"><a href="job-details.html" class="text-body">Backend Developer</a></h6>
                                        <p class="text-muted mb-0">Adobe Agency, Malaysia - <b>3</b> days ago</p>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                            <li><a class="dropdown-item" href="job-details.html">View Details</a></li>
                                            <li><a class="dropdown-item" href="#">Apply Now</a></li>
                                        </ul>
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
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/dashboard-job.init.js"></script>

<!-- <script src="<?= base_url() ?>/assets/libs/owl.carousel/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/coming-soon.init.js"></script>
<script>
    $(document).ready(function() {
        $("#timeline-carousel").owlCarousel({
            items: 1,
            loop: !1,
            margin: 0,
            nav: !0,
            navText: ["<i class='mdi mdi-chevron-left'></i>", "<i class='mdi mdi-chevron-right'></i>"],
            dots: !1,
            responsive: {
                576: {
                    items: 3
                },
                768: {
                    items: 6
                }
            }
        });
    });

    function aksiAktivasiWa(event) {
        $.ajax({
            url: './home/getAktivasiWa',
            type: 'POST',
            data: {
                id: 'wa',
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('.aktivasi-button-wa').attr('disabled', true);
                $('div.modal-content-loading').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(resul) {
                $('div.modal-content-loading').unblock();
                if (resul.status == 200) {
                    $('.contentAktivasiBodyModal').html(resul.data);
                } else {
                    if (resul.status == 404) {
                        Swal.fire(
                            'PERINGATAN!',
                            resul.message,
                            'warning'
                        ).then((valRes) => {
                            reloadPage(resul.redirrect);
                        })
                    } else {
                        if (resul.status == 401) {
                            Swal.fire(
                                'PERINGATAN!',
                                resul.message,
                                'warning'
                            ).then((valRes) => {
                                reloadPage();
                            })
                        } else {
                            $('.aktivasi-button-wa').attr('disabled', false);
                            Swal.fire(
                                'PERINGATAN!!!',
                                resul.message,
                                'warning'
                            );
                        }
                    }
                }
            },
            error: function(data) {
                $('.aktivasi-button-wa').attr('disabled', false);
                $('div.modal-content-loading').unblock();
                Swal.fire(
                    'PERINGATAN!',
                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    } -->
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
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
<!-- <link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" /> -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.carousel.min.css"> -->

<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.theme.default.min.css"> -->
<?= $this->endSection(); ?>
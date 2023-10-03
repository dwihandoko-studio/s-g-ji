<?= $this->extend('t-silastri/peksos/index'); ?>

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
                    <h4 class="card-title mb-4 flex-grow-1">STATISTIK PENGADUAN</h4>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Antrian</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-info", "--bs-transparent"]' dir="ltr" id="eathereum_sparkline_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-info me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 0%</span> Increase last month</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Selesai</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-success", "--bs-transparent"]' dir="ltr" id="new_application_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-success me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 24.07%</span> Increase last month</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Ditolak</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-danger", "--bs-transparent"]' dir="ltr" id="total_rejected_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-danger me-1"><i class="bx bx-trending-down align-bottom me-1"></i> 20.63%</span> Decrease last month</p>
                    </div> -->
                </div>
            </div>
        </div>

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
                                <p class="text-muted fw-medium">Antrian</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-info", "--bs-transparent"]' dir="ltr" id="eathereum_sparkline_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-info me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 0%</span> Increase last month</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Selesai</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-success", "--bs-transparent"]' dir="ltr" id="new_application_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-success me-1"><i class="bx bx-trending-up align-bottom me-1"></i> 24.07%</span> Increase last month</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Ditolak</p>
                                <h4 class="mb-0">0</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div data-colors='["--bs-danger", "--bs-transparent"]' dir="ltr" id="total_rejected_charts"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-body border-top py-3">
                        <p class="mb-0"> <span class="badge badge-soft-danger me-1"><i class="bx bx-trending-down align-bottom me-1"></i> 20.63%</span> Decrease last month</p>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
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
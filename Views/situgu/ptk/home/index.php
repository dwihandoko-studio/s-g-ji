<?= $this->extend('t-situgu/ptk/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">DASHBOARD</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                            <li class="breadcrumb-item active">Blog</li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <?php if (!$data) {
                    if ($data_antrian_tamsil) { ?>
                        <?php if ($data_antrian_tamsil->status_usulan == 0 || $data_antrian_tamsil->status_usulan == 1) { ?>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak Karena : <?= $data_antrian_tamsil->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil->date_reject ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan. (Ditolak Karena : <?= $data_antrian_tamsil->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else if ($data_antrian_tpg) { ?>
                        <?php if ($data_antrian_tpg->status_usulan == 0 || $data_antrian_tpg->status_usulan == 1) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak karena : <?= $data_antrian_tpg->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN. (Ditolak karena : <?= $data_antrian_tpg->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg->date_matching ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary  down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else if ($data_antrian_pghm) { ?>
                        <?php if ($data_antrian_pghm->status_usulan == 0 || $data_antrian_pghm->status_usulan == 1) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak Karena : <?= $data_antrian_pghm->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm->date_reject ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan. (Ditolak Karena : <?= $data_antrian_pghm->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else if ($data_antrian_tamsil_transfer) { ?>
                        <?php if ($data_antrian_tamsil_transfer->status_usulan == 0 || $data_antrian_tamsil_transfer->status_usulan == 1) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak Karena : <?= $data_antrian_tamsil_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_reject ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan. (Ditolak Karena : <?= $data_antrian_tamsil_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan Tamsil</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tamsil_transfer->date_prosestransfer ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else if ($data_antrian_tpg_transfer) { ?>
                        <?php if ($data_antrian_tpg_transfer->status_usulan == 0 || $data_antrian_tpg_transfer->status_usulan == 1) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak karena : <?= $data_antrian_tpg_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN. (Ditolak karena : <?= $data_antrian_tpg_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_matching ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary  down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 6) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_matching ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_terbitsk ?></div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_tpg_transfer->status_usulan == 7) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan TPG Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan TPG</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_matching ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_terbitsk ?></div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_tpg_transfer->date_prosestransfer ?></div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else if ($data_antrian_pghm_transfer) { ?>
                        <?php if ($data_antrian_pghm_transfer->status_usulan == 0 || $data_antrian_pghm_transfer->status_usulan == 1) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm_transfer->status_usulan == 2) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm_transfer->status_usulan == 3) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_reject ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin. (Ditolak Karena : <?= $data_antrian_pghm_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm_transfer->status_usulan == 4) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_reject ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan. (Ditolak Karena : <?= $data_antrian_pghm_transfer->keterangan_reject ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data_antrian_pghm_transfer->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan PGHM Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan PGHM</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_ks ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve_sptjm ?></div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_approve ?></div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data_antrian_pghm_transfer->date_prosestransfer ?></div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading">Anda Belum Mengajukan Usulan Tunjangan</h4>
                                        <p>Silahkan mengajukan usulan tunjangan berdasarkan kriteria yang sudah ditentukan. </p>
                                    </div>
                                </div>
                                <!-- <br />
                                <br />
                                <div class="d-grid gap-2">
                                    <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN USULAN TUNJANGAN</button>
                                </div> -->
                            </div>
                        </div>
                    <?php } ?>

                    <?php } else {
                    if ($data->status_usulan == 1) { ?>
                        <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_reject ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah. (Tidak Lolos Dikarenakan : <b><?= $data->keterangan_reject ?></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_reject ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah. (Tidak Lolos Dikarenakan : <b><?= $data->keterangan_reject ?></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_reject ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-no-entry h1 text-danger down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah. (Tidak Lolos Dikarenakan : <b><?= $data->keterangan_reject ?></b></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                        <?php } ?>
                    <?php } else if ($data->status_usulan == 2) { ?>
                        <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_approve ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_approve ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->date_approve ?></div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Matching Dengan SIMTUN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">6</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Penerbitan SKTP.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">7</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?> Anda</h4>

                                    <div class="hori-timeline">
                                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1"><?= $data->created_at ?></div>
                                                        <h5 class="mb-4">1</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-check-circle h1 text-success down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Mengajukan Usulan Tunjangan <?= strtoupper($data->jenis_tunjangan) ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list active">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-primary mb-1">...</div>
                                                        <h5 class="mb-4">2</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-repost h1 text-primary down-arrow-icon"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">3</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Generate dan Upload SPTJM Kepala Sekolah.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">4</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Verifikasi dan Validasi oleh Admin.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="item event-list">
                                                <div>
                                                    <div class="event-date">
                                                        <div class="text-Opacity mb-1">...</div>
                                                        <h5 class="mb-4">5</h5>
                                                    </div>
                                                    <div class="event-down-icon">
                                                        <i class="bx bx-timer h1 text-Opacity"></i>
                                                    </div>

                                                    <div class="mt-3 px-3">
                                                        <p class="text-muted">Proses Transfer Pembayaran Tunjangan.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>

                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-12">

                <!-- </div> -->
                <div class="row justify-content-center mb-4">
                    <center>
                        <h4>PENGAJUAN TUNJANGAN</h4>
                    </center>
                    <div class="col-md-4">
                        <div class="alert alert-success" role="alert">
                            <center><b>CUT OFF PENGAJUAN TPG TAHAP 1</b></center>
                            <div data-countdown="<?= isset($cut_off_pengajuan) ? (count($cut_off_pengajuan) > 0 ? $cut_off_pengajuan[0]->max_upload_sptjm : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <center><b>CUT OFF PENGAJUAN TAMSIL TAHAP 1</b></center>
                            <div data-countdown="<?= isset($cut_off_pengajuan) ? (count($cut_off_pengajuan) > 0 ? $cut_off_pengajuan[1]->max_upload_sptjm : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                <div class="alert alert-warning" role="alert">
                    <center><b>CUT OFF PENGAJUAN PGHM TAHAP 1</b></center>
                    <div data-countdown="<?= isset($cut_off_pengajuan) ? (count($cut_off_pengajuan) > 0 ? $cut_off_pengajuan[2]->max_upload_sptjm : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                </div>
            </div> -->
                </div>
                <hr />
                <div class="row justify-content-center mb-4">
                    <center>
                        <h4>PELAPORAN TUNJANGAN</h4>
                    </center>
                    <div class="col-md-4">
                        <div class="alert alert-info" role="alert">
                            <center><b>CUT OFF UPLOAD SPJ TPG TAHAP 1</b></center>
                            <div data-countdown="<?= isset($cut_off_spj) ? (count($cut_off_spj) > 0 ? $cut_off_spj[0]->max_upload_spj : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning" role="alert">
                            <center><b>CUT OFF UPLOAD SPJ TAMSIL TAHAP 1</b></center>
                            <div data-countdown="<?= isset($cut_off_spj) ? (count($cut_off_spj) > 0 ? $cut_off_spj[1]->max_upload_spj : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                <div class="alert alert-success" role="alert">
                    <center><b>CUT OFF UPLOAD SPJ PGHM TAHAP 1</b></center>
                    <div data-countdown="<?= isset($cut_off_spj) ? (count($cut_off_spj) > 0 ? $cut_off_spj[2]->max_upload_spj : '2020/02/08 00:00:00') : '2020/02/08 00:00:00' ?>" class="counter-number"></div>
                </div>
            </div> -->
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-2">
                                <h5 class="card-title mb-4">Informasi</h5>
                            </div>

                        </div>
                        <hr style="margin-top: 0px; padding-top: 0px;" />
                        <div data-simplebar class="mt-2">
                            <ul class="verti-timeline list-unstyled content-informasis" id="content-informasis">
                                <?php if (isset($informasis)) {
                                    if (count($informasis) > 0) {
                                        foreach ($informasis as $key => $value) { ?>
                                            <li class="event-list<?= $key == 0 ? ' active' : '' ?>">
                                                <div class="event-timeline-dot">
                                                    <i class="bx bxs-right-arrow-circle font-size-18<?= $key == 0 ? ' bx-fade-right' : '' ?>"></i>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <h5 class="font-size-14"><?= tgl_bulan_indo($value->created_at) ?> <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i></h5>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-headingOne-<?= $value->id ?>">
                                                                    <button class="accordion-button fw-medium <?= $key == 0 ? '' : 'collapsed' ?>" style="padding: 0px !important;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-<?= $value->id ?>" aria-expanded="<?= $key == 0 ? 'true' : 'false' ?>" aria-controls="flush-collapseOne-<?= $value->id ?>">
                                                                        <?= $value->judul ?>
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapseOne-<?= $value->id ?>" class="accordion-collapse collapse <?= $key == 0 ? 'show' : '' ?>" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                                    <div class="accordion-body text-muted" style="padding-left: 0px !important;"><?= $value->isi ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }
                                    } else { ?>
                                        <li class="event-list">
                                            <center>Tidak ada informasi.</center>
                                        </li>
                                    <?php }
                                } else { ?>
                                    <li class="event-list">
                                        <center>Tidak ada informasi.</center>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (isset($informasis)) {
                            if (count($informasis) > 0) {
                                if ($informasis[0]->jumlah_all > 5) { ?>
                                    <div class="text-center mt-4"><a href="javascript:;" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ms-1"></i></a></div>
                        <?php }
                            }
                        } ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?= base_url() ?>/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <img style="height: 72px; width: 72px; object-fit: cover;" src="<?= isset($user) ? ($user->image !== null ? base_url() . '/upload/user/' . $user->image : base_url() . '/assets/images/users/avatar-1.jpg') : base_url() . '/assets/images/users/avatar-1.jpg' ?>" alt="" class="avatar-sm rounded-circle img-thumbnail">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div class="text-muted">
                                            <h5 class="mb-1"><?= isset($user) ? $user->fullname : '-' ?></h5>
                                            <p class="mb-0"><?= isset($user) ? $user->no_hp : '-' ?></p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown ms-2">
                                        <a class="btn btn-light btn-sm" href="<?= base_url('situgu/ptk/profil') ?>">
                                            <i class="bx bxs-cog align-middle me-1"></i> Setting
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">Email Verified</h5>
                                        <p class="text-muted mb-0"><?= $user->email_verified == 1 ? '<span class="badge rounded-pill badge-soft-success">Ya</span>' : '<span class="badge rounded-pill badge-soft-danger">Tidak</span>' ?></p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">WA Verified</h5>
                                        <p class="text-muted mb-0"><?= $user->wa_verified == 1 ? '<span class="badge rounded-pill badge-soft-success">Ya</span>' : '<span class="badge rounded-pill badge-soft-danger">Tidak</span>' ?></p>
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

<div id="content-aktivasiModal" class="modal fade content-aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="content-aktivasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-aktivasiModalLabel">Aktivasi</h5>
            </div>
            <div class="contentAktivasiBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/owl.carousel/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/coming-soon.init.js"></script>
<script>
    $(document).ready(function() {
        <?php if (!$verified_wa) { ?>
            $('#content-aktivasiModalLabel').html('PERINGATAN AKUN BELUM AKTIVASI WHATSAPP');
            let aktivasiWa = '';
            aktivasiWa += '<div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">';
            aktivasiWa += '<div class="alert alert-danger" role="alert">';
            aktivasiWa += 'Akun anda terdeteksi belum melakukan aktivasi Nomor Whatsapp.\nSilahkan untuk melakukan aktivasi Nomor Whatsapp terlebih dahulu.';
            aktivasiWa += '</div>';
            aktivasiWa += '</div>';
            aktivasiWa += '<div class="modal-footer">';
            aktivasiWa += '<button type="button" onclick="aksiLogout(this);" class="btn btn-secondary waves-effect waves-light">Keluar</button>';
            aktivasiWa += '<button type="button" onclick="aksiAktivasiWa(this);" id="aktivasi-button-wa" class="btn btn-primary waves-effect waves-light aktivasi-button-wa">Aktivasi Sekarang</button>';
            aktivasiWa += '</div>';
            $('.contentAktivasiBodyModal').html(aktivasiWa);
            $('.content-aktivasiModal').modal({
                backdrop: 'static',
                keyboard: false,
            });
            $('.content-aktivasiModal').modal('show');

        <?php } ?>
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
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.carousel.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.theme.default.min.css">
<?= $this->endSection(); ?>
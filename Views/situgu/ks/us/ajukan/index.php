<?= $this->extend('t-situgu/ks/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">AJUKAN USULAN TUNJANGAN</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="./" class="btn btn-primary btn-rounded waves-effect waves-light">Tambah Absen Semua PTK</a></li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <?php if (!$data) {
                    if ($data_antrian_tamsil) {
                        if ($data_antrian_tamsil->status_usulan == 0 || $data_antrian_tamsil->status_usulan == 1 || $data_antrian_tamsil->status_usulan == 2 || $data_antrian_tamsil->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_tamsil->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_tamsil->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } else if ($data_antrian_tpg) {
                        if ($data_antrian_tpg->status_usulan == 0 || $data_antrian_tpg->status_usulan == 1 || $data_antrian_tpg->status_usulan == 2 || $data_antrian_tpg->status_usulan == 5 || $data_antrian_tpg->status_usulan == 6 || $data_antrian_tpg->status_usulan == 7) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_tpg->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Matching Dengan Simtun</span>';
                                                            break;
                                                        case 6:
                                                            echo '<span class="badge rounded-pill bg-dark">Terbit SKTP</span>';
                                                            break;
                                                        case 7:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_tpg->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } else if ($data_antrian_pghm) {
                        if ($data_antrian_pghm->status_usulan == 0 || $data_antrian_pghm->status_usulan == 1 || $data_antrian_pghm->status_usulan == 2 || $data_antrian_pghm->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_pghm->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_pghm->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } else if ($data_antrian_tamsil_transfer) {
                        if ($data_antrian_tamsil_transfer->status_usulan == 0 || $data_antrian_tamsil_transfer->status_usulan == 1 || $data_antrian_tamsil_transfer->status_usulan == 2 || $data_antrian_tamsil_transfer->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_tamsil_transfer->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_tamsil_transfer->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } else if ($data_antrian_tpg_transfer) {
                        if ($data_antrian_tpg_transfer->status_usulan == 0 || $data_antrian_tpg_transfer->status_usulan == 1 || $data_antrian_tpg_transfer->status_usulan == 2 || $data_antrian_tpg_transfer->status_usulan == 5 || $data_antrian_tpg_transfer->status_usulan == 6 || $data_antrian_tpg_transfer->status_usulan == 7) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_tpg_transfer->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Matching Dengan SIMTUN</span>';
                                                            break;
                                                        case 6:
                                                            echo '<span class="badge rounded-pill bg-dark">Terbit SKTP</span>';
                                                            break;
                                                        case 7:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_tpg_transfer->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } else if ($data_antrian_pghm_transfer) {
                        if ($data_antrian_pghm_transfer->status_usulan == 0 || $data_antrian_pghm_transfer->status_usulan == 1 || $data_antrian_pghm_transfer->status_usulan == 2 || $data_antrian_pghm_transfer->status_usulan == 5) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-success" role="alert">
                                            <h4 class="alert-heading">Anda Sudah Dalam Pengajuan Usulan Tunjangan!</h4>
                                            <p>Silahkan cek pada menu Usulan TPG / Tamsil / PGHM Anda.</p>
                                            <p class="mb-0">Status pengajuan usulan tunjangan anda saat ini berada dalam tahap : <b>
                                                    <?php
                                                    switch ($data_antrian_pghm_transfer->status_usulan) {
                                                        case 0:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian SPTJM Kepala Sekolah</span>';
                                                            break;
                                                        case 1:
                                                            echo '<span class="badge rounded-pill bg-dark">Antrian Verifikasi Admin</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge rounded-pill bg-dark">Lolos Verifikasi Admin</span>';
                                                            break;
                                                        case 5:
                                                            echo '<span class="badge rounded-pill bg-dark">Proses Transfer</span>';
                                                            break;

                                                        default:
                                                            echo '<span class="badge rounded-pill bg-dark">Unuknown</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </b>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                            <p>Namun pengajuan anda telah ditolak / dibatalkan, dengan Keterangan: </p>
                                            <p class="mb-0"><b>
                                                    <span class="badge rounded-pill bg-dark"><?= $data_antrian_pghm_transfer->keterangan_reject ?></span>
                                                </b>.</p>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <div class="d-grid gap-2">
                                        <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
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
                                <br />
                                <br />
                                <div class="d-grid gap-2">
                                    <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN USULAN TUNJANGAN</button>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    if ($data->status_usulan == 1) { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                        <p>Namun pengajuan anda telah ditolak / dibatalkan dalam proses verifikasi Kepala Sekolah, dengan Keterangan: </p>
                                        <p class="mb-0"><b>
                                                <span class="badge rounded-pill bg-dark"><?= $data->keterangan_reject ?></span>
                                            </b>.</p>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div class="d-grid gap-2">
                                    <button type="button" onclick="actionAjukan()" class="btn btn-primary btn-lg waves-effect waves-light">AJUKAN KEMBALI USULAN TUNJANGAN</button>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($data->status_usulan == 2) { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                        <p>Saat ini proses usulan anda menunggu proses Upload SPTJM dari Kepala Sekolah. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="">
                                    <div class="alert alert-info" role="alert">
                                        <h4 class="alert-heading">Anda Sebelumnya Sudah Mengajukan Usulan Tunjangan</h4>
                                        <p>Saat ini proses usulan anda menunggu verifikasi oleh Kepala Sekolah untuk proses generate SPTJM. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
            <?php if (!$data) {
                if ($data_antrian_tamsil) { ?>
                    <?php if ($data_antrian_tamsil->status_usulan == 0 || $data_antrian_tamsil->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else if ($data_antrian_tpg) { ?>
                    <?php if ($data_antrian_tpg->status_usulan == 0 || $data_antrian_tpg->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg->status_usulan == 5) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else if ($data_antrian_pghm) { ?>
                    <?php if ($data_antrian_pghm->status_usulan == 0 || $data_antrian_pghm->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else if ($data_antrian_tamsil_transfer) { ?>
                    <?php if ($data_antrian_tamsil_transfer->status_usulan == 0 || $data_antrian_tamsil_transfer->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tamsil_transfer->status_usulan == 5) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else if ($data_antrian_tpg_transfer) { ?>
                    <?php if ($data_antrian_tpg_transfer->status_usulan == 0 || $data_antrian_tpg_transfer->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 5) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 6) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_tpg_transfer->status_usulan == 7) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else if ($data_antrian_pghm_transfer) { ?>
                    <?php if ($data_antrian_pghm_transfer->status_usulan == 0 || $data_antrian_pghm_transfer->status_usulan == 1) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm_transfer->status_usulan == 2) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm_transfer->status_usulan == 3) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm_transfer->status_usulan == 4) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data_antrian_pghm_transfer->status_usulan == 5) { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } ?>
                <?php } else {
                } ?>

                <?php } else {
                if ($data->status_usulan == 1) { ?>
                    <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else { ?>
                    <?php } ?>
                <?php } else if ($data->status_usulan == 2) { ?>
                    <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else { ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php if ($data->jenis_tunjangan == 'tpg') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'tamsil') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else if ($data->jenis_tunjangan == 'pghm') { ?>
                        <div class="col-lg-12">
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
                        </div>
                    <?php } else { ?>

                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Modal -->
<div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
<!-- end modal -->
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/owl.carousel/owl.carousel.min.js"></script>

<script>
    function actionAjukan() {
        $.ajax({
            url: "./aksiajukan",
            type: 'POST',
            data: {
                action: 'ajukan',
                tw: '<?= $tw->id ?>',
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
                    $('#content-detailModalLabel').html('Ajukan Usulan Tunjangan');
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
        // initSelect2("filter_tw", ".main-content");
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
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.carousel.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/owl.carousel/assets/owl.theme.default.min.css">

<style>
    .preview-image-upload {
        position: relative;
    }

    .preview-image-upload .imagePreviewUpload {
        max-width: 300px;
        max-height: 300px;
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
<?= $this->endSection(); ?>
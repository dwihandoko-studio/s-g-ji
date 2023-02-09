<?= $this->extend('t-situgu/ops/index'); ?>

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
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">

                                <div class="d-flex flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-2">Jumlah PTK</p>
                                        <h5 class="mb-0"><?= isset($jumlah) ? ($jumlah ? $jumlah->jumlah_ptk : '0') : '0' ?></h5>
                                    </div>

                                    <div class="avatar-sm ms-auto">
                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                            <i class="mdi mdi-account-group"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="card blog-stats-wid">
                            <div class="card-body">

                                <div class="d-flex flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-2">Jumlah PTK Sertifikasi</p>
                                        <h5 class="mb-0"><?= isset($jumlah) ? ($jumlah ? $jumlah->jumlah_ptk_tpg : '0') : '0' ?></h5>
                                    </div>

                                    <div class="avatar-sm ms-auto">
                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                            <i class="mdi mdi-account-star"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card blog-stats-wid">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-2">Jumlah PTK Tamsil</p>
                                        <h5 class="mb-0"><?= isset($jumlah) ? ($jumlah ? $jumlah->jumlah_ptk_tamsil : '0') : '0' ?></h5>
                                    </div>

                                    <div class="avatar-sm ms-auto">
                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                            <i class="mdi mdi-account-switch-outline"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card blog-stats-wid">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-2">Jumlah PTK PGHM</p>
                                        <h5 class="mb-0"><?= isset($jumlah) ? ($jumlah ? $jumlah->jumlah_ptk_pghm : '0') : '0' ?></h5>
                                    </div>

                                    <div class="avatar-sm ms-auto">
                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                            <i class="mdi mdi-account-tie-outline"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <a class="btn btn-light btn-sm" href="#">
                                            <i class="bx bxs-cog align-middle me-1"></i> Setting
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Total Post</p>
                                            <h5 class="mb-0">32</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Replays</p>
                                            <h5 class="mb-0">10k</h5>
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
</div>
<!-- End Page-content -->

<!-- Modal -->
<div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transaction-detailModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
                <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <div>
                                        <img src="<?= base_url() ?>/assets/images/product/img-7.png" alt="" class="avatar-sm">
                                    </div>
                                </th>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-14">Wireless Headphone (Black)</h5>
                                        <p class="text-muted mb-0">$ 225 x 1</p>
                                    </div>
                                </td>
                                <td>$ 255</td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <div>
                                        <img src="<?= base_url() ?>/assets/images/product/img-4.png" alt="" class="avatar-sm">
                                    </div>
                                </th>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-14">Phone patterned cases</h5>
                                        <p class="text-muted mb-0">$ 145 x 1</p>
                                    </div>
                                </td>
                                <td>$ 145</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Sub Total:</h6>
                                </td>
                                <td>
                                    $ 400
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Shipping:</h6>
                                </td>
                                <td>
                                    Free
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Total:</h6>
                                </td>
                                <td>
                                    $ 400
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/coming-soon.init.js"></script>
<!-- <script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js"></script> -->
<!-- <script src="<?= base_url() ?>/assets/js/pages/dashboard-blog.init.js"></script> -->
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<?= $this->endSection(); ?>
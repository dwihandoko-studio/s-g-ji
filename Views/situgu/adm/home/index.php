<?= $this->extend('t-situgu/adm/index'); ?>

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
<script src="<?= base_url() ?>/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>
<script src="<?= base_url() ?>/assets/js/pages/coming-soon.init.js"></script>
<script>
    $(document).ready(function() {
        <?php if (!$registered || $registered->surat_tugas === NULL) { ?>
            $('#content-aktivasiModalLabel').html('PERINGATAN AKUN BELUM MELAKUKAN AKTIVASI');
            let aktivasiWa = '';
            aktivasiWa += '<div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">';
            aktivasiWa += '<div class="alert alert-danger" role="alert">';
            aktivasiWa += 'Akun anda terdeteksi belum melakukan aktivasi.\nSilahkan untuk melakukan aktivasi Admin Kecamatan terlebih dahulu.';
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
    });

    function aksiAktivasiWa(event) {
        $.ajax({
            url: './home/getAktivasi',
            type: 'POST',
            data: {
                id: 'admin',
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

    $('#content-aktivasiModal').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });

    $('#content-aktivasiModal').on('click', '.btn-remove-preview-image-file', function(event) {
        $('.imagePreviewUploadFile').removeAttr('src');
        document.getElementsByName("_surat_tugas")[0].value = "";
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>

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

    .preview-image-upload-file {
        position: relative;
    }

    .preview-image-upload-file .imagePreviewUploadFile {
        max-width: 200px;
        max-height: 200px;
        cursor: pointer;
    }

    .preview-image-upload-file .btn-remove-preview-image-file {
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

    .imagePreviewUploadFile:hover+.btn-remove-preview-image-file,
    .btn-remove-preview-image-file:hover {
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
<?= $this->extend('t-situgu/ptk/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">INFO GTK DIGITAL</h4>

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
                <?php if (isset($infogtk)) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Progress Pengajuan Usulan Tunjangan Tamsil Anda</h4>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Tautkan Kartu NUPTK QRCode Geisa Anda.</h4>
                            <div id="camera"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="content-aktivasiModal" class="modal fade content-aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="content-aktivasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-aktivasiModalLabel">TAUTKAN INFO GTK DIGITAL ANDA</h5>
            </div>
            <div class="contentAktivasiBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>

<!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
<script>
    $(document).ready(function() {
        <?php if (!isset($infogtk)) { ?>
            // $('#content-aktivasiModalLabel').html('INFO GTK DIGITAL BELUM TERKAIT KE DATA PTK');
            // let akuntertautNya = '';
            // akuntertautNya += '<div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">';
            // akuntertautNya += '<div class="alert alert-danger" role="alert">';
            // akuntertautNya += 'Silahkan hubungi admin SITUGU Sekolah untuk melakukan taut Akun terlebih dahulu.';
            // akuntertautNya += '</div>';
            // akuntertautNya += '</div>';
            // akuntertautNya += '<div class="modal-footer">';
            // akuntertautNya += '<button type="button" onclick="aksiLogout(this);" class="btn btn-secondary waves-effect waves-light">Keluar</button>';
            // akuntertautNya += '</div>';
            // $('.contentAktivasiBodyModal').html(akuntertautNya);
            // $('.content-aktivasiModal').modal({
            //     backdrop: 'static',
            //     keyboard: false,
            // });
            // $('.content-aktivasiModal').modal('show');

            let scanner = new Instascan.Scanner({
                video: document.getElementById('camera')
            });
            scanner.addListener('scan', function(content) {
                console.log(content);
                // alert(content);
                // Lakukan pengolahan data QR Code di sini, misalnya dengan mengirim data ke server
            });
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('Tidak ditemukan kamera pada perangkat Anda');
                }
            }).catch(function(e) {
                console.error(e);
            });
        <?php } ?>
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
<script type="text/javascript" src="<?= base_url() ?>/assets/js/instascan.min.js"></script>
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>
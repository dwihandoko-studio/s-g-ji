<?= $this->extend('t-situgu/ks/index'); ?>

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
                        <div class="card-body iframe-maximal-view" style="height: 750px;">
                            <!-- <h4 class="card-title mb-4">INFO GTK DIGITAL</h4> -->
                            <iframe src="<?= $infogtk->qrcode ?>"></iframe>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Tautkan Kartu NUPTK QRCode Geisa Anda.</h4>
                            <center>
                                <p style="color:red;font-weight:bold;margin-top:10px"><i class="fas fa-video"></i> Camera
                                </p>
                                <div class="card">
                                    <div class="card-body">
                                        <video id="my_camera" class="solid"></video>
                                    </div>
                                </div>
                                <br>
                                <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                                    <label class="btn btn-primary active">
                                        <input type="radio" name="options" value="1" autocomplete="off" checked> 1st Camera
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" value="2" autocomplete="off"> 2nd Camera
                                    </label>
                                </div>
                            </center>


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
<?php if (!isset($infogtk)) { ?>
    <script type="text/javascript">
        // Configure a few settings and attach camera

        Webcam.set({
            width: 560,
            height: 340,
            image_format: 'jpeg',
            jpeg_quality: 100
        });
        Webcam.attach('#my_camera');

        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = true;
        shutter.src = navigator.userAgent.match(/Firefox/) ? '<?= base_url() ?>/assets/shutter.ogg' : '<?= base_url() ?>/assets/shutter.mp3';


        // SELESAI-----Configure a few settings and attach camera
        //===========================================ajax
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('my_camera'),
                mirror: false
            });
            scanner.addListener('scan', function(content) {
                let data14 = content;
                // play sound effect
                shutter.play();
                let angka_random = Math.floor(Math.random() * 1000000) + 1000;
                let sekarang = Date.now();
                let random = angka_random + sekarang;

                if (data14.includes("https://opstore.id/url/")) {
                    const linkInfoGtk = data14.replace("https://opstore.id/url/", "https://bridge.opstore.id/?id=");

                    $.ajax({
                        url: './taut',
                        type: 'POST',
                        data: {
                            id: linkInfoGtk,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.modal-content-loading').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.main-content').unblock();
                            if (resul.status == 200) {
                                Swal.fire(
                                    'SELAMAT!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
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
                            $('div.main-content').unblock();
                            Swal.fire(
                                'Failed!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                } else {
                    Swal.fire(
                        'PERINGATAN!!!',
                        "Kartu yang anda miliki saat ini belum terkoneksi (Terintegrasi dengan Info GTK).",
                        'warning'
                    );
                }

                // console.log(data14);


            });

            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);

                    //ini pakai vanilla js
                    if (document.querySelector('input[name="options"]')) {
                        document.querySelectorAll('input[name="options"]').forEach((element) => {
                            element.addEventListener("change", function(event) {
                                var item = event.target.value;
                                //console.log(item);
                                if (item == 1) {
                                    if (cameras[0] != "") {
                                        scanner.start(cameras[0]);
                                    } else {
                                        alert('No Front camera found!');
                                    }
                                } else if (item == 2) {
                                    if (cameras[1] != "") {
                                        scanner.start(cameras[1]);
                                    } else {
                                        alert('No Back camera found!');
                                    }
                                }
                            });
                        });
                    }

                    //Ini kalau pakai JQUERY
                    /* $('[name="options"]').on('change', function() {
                        if ($(this).val() == 1) {
                            if (cameras[0] != "") {
                                scanner.start(cameras[0]);
                            } else {
                                alert('No Front camera found!');
                            }
                        } else if ($(this).val() == 2) {
                            if (cameras[1] != "") {
                                scanner.start(cameras[1]);
                            } else {
                                alert('No Back camera found!');
                            }
                        }
                    }); */
                } else {
                    console.error('No cameras found.');
                    alert('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
                alert(e);
            });
        });
    </script>
<?php } else { ?>
    <script>
        const cardBodyIframe = document.querySelector(".iframe-maximal-view");
        const iframeView = cardBodyIframe.querySelector("iframe");
        const aspectRatioIframe = 9 / 16; // ubah sesuai aspek rasio video yang ditampilkan

        function resizeIframeView() {
            const width = cardBodyIframe.clientWidth;
            const height = width * aspectRatioIframe;
            iframeView.style.height = `${height}px`;
        }

        window.addEventListener("resize", resizeIframeView);
        resizeIframeView();
    </script>
<?php } ?>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<style>
    /* Style untuk membuat full page iFrame */
    .iframe-maximal-view {
        position: relative;
        padding: 0;
    }

    .iframe-maximal-view iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
</style>
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

<?php if (!isset($infogtk)) { ?>
    <!--Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/js/instascan.min.js"></script> -->
    <!-- Webcam -->
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/webcam.min.js"></script>
<?php } ?>
<?= $this->endSection(); ?>
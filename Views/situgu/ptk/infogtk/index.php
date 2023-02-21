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

<!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
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

                if (a.includes("https://opstore.id/url/")) {
                    Swal.fire(
                        'PERINGATAN!!!',
                        "Hasil Scan : " + a,
                        'warning'
                    );
                } else {
                    console.log("Lakukan Scanning");
                }

                // console.log(data14);

                // $.ajax({
                //     type: 'POST',
                //     url: "index_webcam_action.php",
                //     data: {
                //         qrcode: data14
                //     },
                //     success: function(response) {
                //         if (response != null && response != "") {
                //             response = JSON.parse(response);
                //             console.log(response)
                //             //amibl data JSON
                //             $('#no_daftar').html(response.no_daftar);
                //             $('#giat_penerimaan').html(response.giat_penerimaan);
                //             $('#nama').html(response.nama_calon);
                //             $('#ttl').html(response.ttl);
                //             $('#hasil').html(response.hasil);
                //             $('#karena').html(response.karena);
                //             $('#id_data').val(response.id_data);
                //             $('#results').load('index_webcam_action.php')
                //             const Toast = Swal.mixin({
                //                 toast: true,
                //                 position: 'top-end',
                //                 showConfirmButton: false,
                //                 timer: 3000,
                //                 timerProgressBar: true,
                //                 didOpen: (toast) => {
                //                     toast.addEventListener('mouseenter', Swal.stopTimer)
                //                     toast.addEventListener('mouseleave', Swal
                //                         .resumeTimer)
                //                 }
                //             })

                //             Toast.fire({
                //                 icon: 'success',
                //                 title: 'Surat terdaftar, cek isi surat!'
                //             })

                //             if (response == 1) {

                //                 Swal.fire({
                //                     icon: 'error',
                //                     title: 'Oops...',
                //                     text: 'Surat tidak terdaftar!',
                //                 })

                //             }

                //         }

                //     }

                // });


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
<?php } ?>
<script>
    $(document).ready(function() {
        <?php if (!isset($infogtk)) { ?>
            // load();
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

            // let scanner = new Instascan.Scanner({
            //     video: document.getElementById('camera_preview')
            // });
            // scanner.addListener('scan', function(content) {
            //     console.log(content);
            //     // alert(content);
            //     // Lakukan pengolahan data QR Code di sini, misalnya dengan mengirim data ke server
            // });
            // Instascan.Camera.getCameras().then(function(cameras) {
            //     if (cameras.length > 0) {
            //         scanner.start(cameras[0]);
            //     } else {
            //         console.error('Tidak ditemukan kamera pada perangkat Anda');
            //     }
            // }).catch(function(e) {
            //     console.error(e);
            // });
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
<!-- <script type="text/javascript" src="<?= base_url() ?>/assets/js/instascan.min.js"></script> -->
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

<?php if (!isset($infogtk)) { ?>
    <!--Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/js/instascan.min.js"></script> -->
    <!-- Webcam -->
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/webcam.min.js"></script>
<?php } ?>
<?php if (!isset($infogtks)) { ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/llqrcode.js"></script>
    <script>
        // QRCODE reader Copyright 2011 Lazar Laszlo
        // http://www.webqr.com

        var gCtx = null;
        var gCanvas = null;
        var c = 0;
        var stype = 0;
        var gUM = false;
        var webkit = false;
        var moz = false;
        var v = null;

        var imghtml = '<div id="qrfile"><canvas id="out-canvas" width="320" height="240"></canvas>' +
            '<div id="imghelp">drag and drop a QRCode here' +
            '<br>or select a file' +
            '<input type="file" onchange="handleFiles(this.files)"/>' +
            '</div>' +
            '</div>';

        var vidhtml = '<video id="v_preview" autoplay></video>';

        function dragenter(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function dragover(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function drop(e) {
            e.stopPropagation();
            e.preventDefault();

            var dt = e.dataTransfer;
            var files = dt.files;
            if (files.length > 0) {
                handleFiles(files);
            } else
            if (dt.getData('URL')) {
                qrcode.decode(dt.getData('URL'));
            }
        }

        function handleFiles(f) {
            var o = [];

            for (var i = 0; i < f.length; i++) {
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                        gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);

                        qrcode.decode(e.target.result);
                    };
                })(f[i]);
                reader.readAsDataURL(f[i]);
            }
        }

        function initCanvas(w, h) {
            gCanvas = document.getElementById("qr-canvas");
            gCanvas.style.width = w + "px";
            gCanvas.style.height = h + "px";
            gCanvas.width = w;
            gCanvas.height = h;
            gCtx = gCanvas.getContext("2d");
            gCtx.clearRect(0, 0, w, h);
        }


        function captureToCanvas() {
            console.log(gUM);
            if (stype != 1) {
                console.log(stype);
                return;
            }
            if (gUM) {
                try {
                    gCtx.drawImage(v, 0, 0);
                    try {
                        qrcode.decode();
                    } catch (e) {
                        console.log(e);
                        setTimeout(captureToCanvas, 500);
                    };
                } catch (e) {
                    console.log(e);
                    setTimeout(captureToCanvas, 500);
                };
            }
        }

        function htmlEntities(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function read(a) {
            if (a.includes("https://opstore.id/url/")) {
                console.log(a);
            } else {
                console.log("Lakukan Scanning");
            }

            // var html = "<br>";
            // if (a.indexOf("http://") === 0 || a.indexOf("https://") === 0)
            //     html += "<a target='_blank' href='" + a + "'>" + a + "</a><br>";
            // html += "<b>" + htmlEntities(a) + "</b><br><br>";
            // document.getElementById("result").innerHTML = html;

            // var dataString = {
            //     send: true,
            //     credential: htmlEntities(a)
            // };

            // $.ajax({

            //     type: "POST",
            //     url: "authenticate.php",
            //     data: dataString,
            //     dataType: "json",
            //     cache: false,
            //     success: function(data) {

            //         if (data.success == true) {
            //             alert("You have successfully logged in!");
            //             self.location.replace('home.php');
            //         } else {
            //             alert("The credentials not match!");
            //             self.location.replace('index.php');
            //         }

            //         setwebcam();


            //     },
            //     error: function(xhr, status, error) {
            //         alert(error);
            //     },
            // });

        }

        function isCanvasSupported() {
            var elem = document.createElement('canvas');
            return !!(elem.getContext && elem.getContext('2d'));
        }

        function success(stream) {
            if (webkit)
                v.src = window.webkitURL.createObjectURL(stream);
            else
            if (moz) {
                v.mozSrcObject = stream;
                v.play();
            } else
                v.src = stream;
            gUM = true;
            setTimeout(captureToCanvas, 500);
        }

        function error(error) {
            console.log(error);
            gUM = false;
            return;
        }

        function load() {
            if (isCanvasSupported() && window.File && window.FileReader) {
                initCanvas(800, 600);
                qrcode.callback = read;
                document.getElementById("mainbody").style.display = "inline";
                setwebcam();
            } else {
                document.getElementById("mainbody").style.display = "inline";
                document.getElementById("mainbody").innerHTML = '<p id="mp1">QR code scanner for HTML5 capable browsers</p><br>' +
                    '<br><p id="mp2">sorry your browser is not supported</p><br><br>' +
                    '<p id="mp1">try <a href="http://www.mozilla.com/firefox"><img src="firefox.png"/></a> or <a href="http://chrome.google.com"><img src="chrome_logo.gif"/></a> or <a href="http://www.opera.com"><img src="Opera-logo.png"/></a></p>';
            }
        }

        function setwebcam() {
            document.getElementById("result_preview").innerHTML = "- scanning -";
            if (stype == 1) {
                setTimeout(captureToCanvas, 500);
                return;
            }
            var n = navigator;
            // console.log(n);
            document.getElementById("outdiv").innerHTML = vidhtml;
            v = document.getElementById("v_preview");

            console.log(n.mediaDevices.getUserMedia);

            if (n.mediaDevices && n.mediaDevices.getUserMedia)

                n.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                }, success, error);
            else
            if (n.mediaDevices && n.mediaDevices.webkitGetUserMedia) {
                webkit = true;
                n.mediaDevices.webkitGetUserMedia({
                    video: true,
                    audio: false
                }, success, error);
            } else
            if (n.mediaDevices && n.mediaDevices.mozGetUserMedia) {
                moz = true;
                n.mediaDevices.mozGetUserMedia({
                    video: true,
                    audio: false
                }, success, error);
            }

            //document.getElementById("qrimg").src="qrimg2.png";
            //document.getElementById("webcamimg").src="webcam.png";
            document.getElementById("qrimg").style.opacity = 0.2;
            document.getElementById("webcamimg").style.opacity = 1.0;

            stype = 1;
            setTimeout(captureToCanvas, 500);
        }

        function setimg() {
            document.getElementById("result_preview").innerHTML = "";
            if (stype == 2)
                return;
            document.getElementById("outdiv").innerHTML = imghtml;
            //document.getElementById("qrimg").src="qrimg.png";
            //document.getElementById("webcamimg").src="webcam2.png";
            document.getElementById("qrimg").style.opacity = 1.0;
            document.getElementById("webcamimg").style.opacity = 0.2;
            var qrfile = document.getElementById("qrfile");
            qrfile.addEventListener("dragenter", dragenter, false);
            qrfile.addEventListener("dragover", dragover, false);
            qrfile.addEventListener("drop", drop, false);
            stype = 2;
        }
    </script>
    <!-- <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('camera_preview')
        });
        scanner.addListener('scan', function(content) {
            console.log(content);
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });
    </script> -->
<?php } ?>
<?= $this->endSection(); ?>
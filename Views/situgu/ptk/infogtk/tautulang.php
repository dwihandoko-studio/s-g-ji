<?php if (isset($data)) { ?>
    <div class="modal-body">
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
                        <!-- <label class="btn btn-secondary">
                            <input type="radio" name="options" value="2" autocomplete="off"> 2nd Camera
                        </label> -->
                    </div>
                </center>


            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
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
                            $('div.modal-content-loading').unblock();
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
                            $('div.modal-content-loading').unblock();
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
                    // if (document.querySelector('input[name="options"]')) {
                    //     document.querySelectorAll('input[name="options"]').forEach((element) => {
                    //         element.addEventListener("change", function(event) {
                    //             var item = event.target.value;
                    //             //console.log(item);
                    //             if (item == 1) {
                    //                 if (cameras[0] != "") {
                    //                     scanner.start(cameras[0]);
                    //                 } else {
                    //                     alert('No Front camera found!');
                    //                 }
                    //             } else if (item == 2) {
                    //                 if (cameras[1] != "") {
                    //                     scanner.start(cameras[1]);
                    //                 } else {
                    //                     alert('No Back camera found!');
                    //                 }
                    //             }
                    //         });
                    //     });
                    // }

                    //Ini kalau pakai JQUERY
                    $('[name="options"]').on('change', function() {
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
                    });
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
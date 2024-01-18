<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA PEMOHON</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik ?>" readonly />
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">KK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="kk" aria-label="KK" value="<?= $data->kk ?>" readonly />
                </div>
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DATA PERMOHONAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Kode Permohonan:</label>
                <input type="text" class="form-control" value="<?= $data->kode_permohonan ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis:</label>
                <textarea rows="3" class="form-control" readonly><?= getJenisSubLayanan($data->layanan, $data->jenis) ?></textarea>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Layanan:</label>
                <input type="text" class="form-control" value="<?= $data->layanan ?>" readonly />
            </div>

            <?php if (isset($data->lampiran_ktp)) { ?>
                <div class="col-lg-12 mt-2">
                    <label class="col-form-label">Lampiran Dokumen:</label>
                    <br />
                    <?php if (isset($data->lampiran_ktp)) { ?>
                        <?php if ($data->lampiran_ktp === null || $data->lampiran_ktp === "") { ?>
                        <?php } else { ?>
                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_ktp ?>" id="nik">
                                KTP
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($data->lampiran_kk)) { ?>
                        <?php if ($data->lampiran_kk === null || $data->lampiran_kk === "") { ?>
                        <?php } else { ?>
                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_kk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_kk ?>" id="nik">
                                Kartu Keluarga
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($data->lampiran_pernyataan)) { ?>
                        <?php if ($data->lampiran_pernyataan === null || $data->lampiran_pernyataan === "") { ?>
                        <?php } else { ?>
                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_pernyataan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_pernyataan ?>" id="nik">
                                Pernyataan
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($data->lampiran_foto_rumah)) { ?>
                        <?php if ($data->lampiran_foto_rumah === null || $data->lampiran_foto_rumah === "") { ?>
                        <?php } else { ?>
                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_foto_rumah ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_foto_rumah ?>" id="nik">
                                Foto Rumah
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DOKUMEN</h2>
            <div class="col-lg-12">
                <label class="col-form-label">Dokumen yang akan di TTE:</label>
                <object data="<?= base_url('upload') . '/' . $file ?>" type="application/pdf" style="max-width: 100%; min-width: 100%; height: 600px;">
                    <embed src="<?= base_url('upload') . '/' . $file ?>" width="auto" height="auto" />
                </object>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionTolak(this)" class="btn btn-danger waves-effect waves-light">Tolak Untuk TTE</button>
        <button type="button" onclick="actionApprove(this)" class="btn btn-success waves-effect waves-light">Setujui dan Tandatangani</button>
    </div>
    <script>
        function actionTolak(e) {
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menolak permohonan TTE Surat layanan ini?',
                text: "Tolak permohonan TTE Surat layanan : <?= $data->layanan ?> - dari : <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./formtolak",
                        type: 'POST',
                        data: {
                            id: '<?= $data->id ?>',
                            nama: nama,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.modal-content-loading').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.modal-content-loading').unblock();
                            if (resul.status !== 200) {
                                Swal.fire(
                                    'Failed!',
                                    resul.message,
                                    'warning'
                                );
                            } else {
                                $('#content-tolakModalLabel').html('TOLAK TTE PERMOHONAN LAYANAN <?= $data->layanan ?> dari ' + nama);
                                $('.contentTolakBodyModal').html(resul.data);
                                $('.content-tolakModal').modal({
                                    backdrop: 'static',
                                    keyboard: false,
                                });
                                $('.content-tolakModal').modal('show');
                            }
                        },
                        error: function() {
                            $('div.modal-content-loading').unblock();
                            Swal.fire(
                                'Failed!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                }
            })
        }

        function simpanTolak(e) {
            const id = '<?= $data->id ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            const keterangan = document.getElementsByName('_keterangan_tolak')[0].value;

            $.ajax({
                url: "./tolak",
                type: 'POST',
                data: {
                    id: id,
                    nama: nama,
                    keterangan: keterangan,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

                    if (resul.status !== 200) {
                        if (resul.status !== 201) {
                            if (resul.status === 401) {
                                Swal.fire(
                                    'Failed!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage(resul.redirrect);
                                });
                            } else {
                                e.disabled = false;
                                Swal.fire(
                                    'GAGAL!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        } else {
                            Swal.fire(
                                'Peringatan!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage(resul.redirrect);
                            })
                        }
                    } else {
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage(resul.redirrect);
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // e.attr('disabled', false);
                    e.disabled = false
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        };

        function actionApprove(e) {
            // e.preventDefault();

            const id = '<?= $data->id ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';

            Swal.fire({
                title: 'Apakah anda yakin ingin menyetujui permohonan surat layanan ini untuk di TTE?',
                text: "Setujui dan TTE Permohonan Layanan : <?= $data->layanan ?> - dari : <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui dan Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    const html = '<form id="formApproveTte" class="form-horizontal form-ApproveTte" method="post">' +
                        '<div class="modal-body" style="padding-top: 1.25rem; padding-left: 1.25rem; padding-right: 1.25rem; padding-bottom: 0;">' +
                        '<div class="col-lg-12">' +
                        '<div class="form-group" id="password-error">' +
                        '<label class="form-control-label" for="password">Masukkan Password Untuk TTE</label>' +
                        '<div class="input-group input-group-merge">' +
                        '<input type="password" class="form-control password" id="password" name="password" reqired/>' +
                        '<div class="input-group-append">' +
                        '<span class="input-group-text" onclick="showPassword(this);"><i class="fas fa-eye" id="iconshowpassword" style="height: 100%"></i></span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="help-block password" for="password"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tutup</button>' +
                        '<button onclick="sendActionApproved(this)" type="button" data-id="' + id + '" data-name="' + name + '" class="btn btn-outline-success simpan-approve-tte">SUBMIT</button>' +
                        '</div>' +
                        '</form>';

                    $('#content-roleModalLabel').html('KONFIRMASI PASSWORD UNTUK TTE DOKUMEN ' + nama);
                    $('.contentroleBodyModal').html(html);
                    $('.content-roleModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('.content-roleModal').modal('show');
                }
            })
        };

        function sendActionApproved(e) {
            // e.preventDefault();
            const id = '<?= $data->id ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            const password = document.getElementsByName('password')[0].value;
            $.ajax({
                url: "./prosestte",
                type: 'POST',
                data: {
                    id: id,
                    nama: nama,
                    password: password,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

                    if (resul.status !== 200) {
                        if (resul.status === 401) {
                            Swal.fire(
                                'Failed!',
                                resul.message,
                                'warning'
                            ).then((valRes) => {
                                reloadPage();
                            });
                        } else {
                            e.disabled = false;
                            Swal.fire(
                                'GAGAL!',
                                resul.message,
                                'warning'
                            );
                        }
                    } else {
                        // Swal.fire(
                        //     'SELAMAT!',
                        //     resul.message,
                        //     'success'
                        // ).then((valRes) => {
                        //     reloadPage(resul.redirrect);
                        // })
                        Swal.fire({
                            title: 'Berhasil!',
                            text: resul.message,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Download'
                        }).then((result) => {
                            if (result.value) {
                                downloadPDF(resul.data, resul.filename);
                                document.location.href = "<?= base_url('silastri/kepala/layanan/antrian'); ?>";
                            } else {
                                document.location.href = "<?= base_url('silastri/kepala/layanan/antrian'); ?>";
                            }
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // e.attr('disabled', false);
                    e.disabled = false
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        };


        function downloadPDF(pdf, filename) {
            // const linkSource = `data:application/pdf;base64,${pdf}`;
            const linkSource = `data:application/octet-stream;base64,${pdf}`;
            const downloadLink = document.createElement("a");
            const fileName = filename;
            downloadLink.href = linkSource;
            downloadLink.download = fileName;
            downloadLink.click();
        }

        function showPassword(event) {
            let temp = document.getElementById("password");
            let iconpassowrd = document.getElementById('iconshowpassword');
            // console.log(iconpassowrd.className);
            if (temp.type === "password") {
                temp.type = "text";
                // event.html('<i class="fas fa-eye-slash"></i>');
                iconpassowrd.classList.remove('fa-eye');
                iconpassowrd.classList.add('fa-eye-slash');
            } else {
                temp.type = "password";
                iconpassowrd.classList.remove('fa-eye-slash');
                iconpassowrd.classList.add('fa-eye');
                // event.html('<i class="fas fa-eye"></i>');
            }
        }
    </script>
<?php } ?>
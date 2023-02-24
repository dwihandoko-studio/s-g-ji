<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA ADUAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Pengadu:</label>
                <input type="text" class="form-control" value="<?= $data->fullname ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPSN:</label>
                <input type="text" class="form-control" value="<?= $data->npsn ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis Aduan:</label>
                <input type="text" class="form-control" value="<?= $data->jenis ?>" readonly />
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Konten Aduan:</label>
                <textarea rows="15" class="form-control" readonly><?= $data->isi ?></textarea>
            </div>
            <div class="col-lg-12 mt-4">
                <h4>Data PTK:</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NUPTK</th>
                                <th>Status Kepegawaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($ptks)) {
                                if (count($ptks) > 0) {
                                    foreach ($ptks as $key => $v) { ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $v->nama ?></td>
                                            <td><?= $v->nuptk ?></td>
                                            <td><span class="badge badge-pill badge-soft-success"><?= $v->status_kepegawaian ?></span></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tidak ada PTK yang dilampirkan.</td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6">Tidak ada PTK yang dilampirkan.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="row">
            <h2>DATA LAMPIRAN ADUAN</h2>
            <div class="col-lg-4">
                <label class="col-form-label">Lampiran Aduan:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="absen_1" aria-label="ABSEN 1" value="Lampirannya" readonly />
                    <?php if ($data->lampiran !== NULL) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/aduan') . '/' . $data->lampiran ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/aduan') . '/' . $data->lampiran ?>" id="nik">Lampiran</a>
                    <?php } else { ?>
                        <a class="btn btn-primary" href="javascript:;" id="nik">Tidak ada Lampiran</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionTolak(this)" class="btn btn-danger waves-effect waves-light">Tolak Aduan</button>
        <button type="button" onclick="actionApprove(this)" class="btn btn-success waves-effect waves-light">Proses Aduan</button>
    </div>
    <script>
        function actionTolak(e) {
            const nama = '<?= $data->fullname ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menolak aduan admin sekolah ini?',
                text: "Tolak Aduan Admin Sekolah: <?= $data->fullname ?>",
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
                                $('#content-tolakModalLabel').html('TOLAK ADUAN ADMIN SEKOLAH ' + nama);
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
            const nama = '<?= $data->fullname ?>';
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
                            Swal.fire(
                                'Peringatan!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage();
                            })
                        }
                    } else {
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
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
            const id = '<?= $data->id ?>';
            const nama = '<?= $data->fullname ?>';

            $.ajax({
                url: "./approve",
                type: 'POST',
                data: {
                    id: id,
                    nama: nama,
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
                            Swal.fire(
                                'Peringatan!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage();
                            })
                        }
                    } else {
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
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
    </script>
<?php } ?>
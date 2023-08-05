<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA PENGADU</h2>
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
                <label class="col-form-label">No Handphone:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nohp" aria-label="NO HP" value="<?= $data->nohp ?>" readonly />
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Alamat:</label>
                <textarea class="form-control" readonly><?= $data->alamat ?></textarea>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kecamatan:</label>
                <input type="text" class="form-control" value="<?= getNamaKecamatan($data->kecamatan) ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kelurahan:</label>
                <input type="text" class="form-control" value="<?= getNamaKelurahan($data->kelurahan) ?>" readonly />
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DATA YANG DIADUKAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Kode Adukan:</label>
                <input type="text" class="form-control" value="<?= $data->kode_aduan ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kategori:</label>
                <input type="text" class="form-control" value="<?= $data->kategori ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Nama (Yang Diadukan):</label>
                <input type="text" class="form-control" value="<?= $data->nama_aduan ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK (Yang Diadukan):</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik_aduan ?>" readonly />
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Handphone (Yang Diadukan):</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nohp" aria-label="NO HP" value="<?= $data->nohp_aduan ?>" readonly />
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Alamat (Yang Diadukan):</label>
                <textarea class="form-control" readonly><?= $data->alamat_aduan ?></textarea>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kecamatan (Yang Diadukan):</label>
                <input type="text" class="form-control" value="<?= getNamaKecamatan($data->kecamatan_aduan) ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kelurahan (Yang Diadukan):</label>
                <input type="text" class="form-control" value="<?= getNamaKelurahan($data->kelurahan_aduan) ?>" readonly />
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Uraian Pengaduan:</label>
                <textarea rows="5" class="form-control" readonly><?= $data->uraian_aduan ?></textarea>
            </div>
            <?php if (isset($data->lampiran_aduan)) { ?>
                <div class="col-lg-12 mt-2">
                    <label class="col-form-label">Lampiran Aduan:</label>
                    <br />
                    <?php if (isset($data->lampiran_aduan)) { ?>
                        <?php if ($data->lampiran_aduan === null || $data->lampiran_aduan === "") { ?>
                        <?php } else { ?>
                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/aduan') . '/' . $data->lampiran_aduan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/aduan') . '/' . $data->lampiran_aduan ?>" id="nik">
                                Dokumen Pengaduan
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" onclick="actionTolak(this)" class="btn btn-danger waves-effect waves-light">Tolak Pengaduan</button>
        <button type="button" onclick="actionApprove(this)" class="btn btn-success waves-effect waves-light">Teruskan Pengaduan</button> -->
    </div>
    <script>
        function actionTolak(e) {
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            const kode = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->kode_aduan)) ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menolak pengaduan layanan ini?',
                text: "Tolak pengaduan layanan : <?= $data->kategori ?> - dari : <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?> , dengan Kode Aduan: <?= $data->kode_aduan ?>",
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
                                $('#content-tolakModalLabel').html('TOLAK PENGADUAN LAYANAN <?= $data->kategori ?> dari ' + nama + ', dengan Kode Aduan: ' + kode);
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
            const id = '<?= $data->id ?>';
            const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            const kode = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin meneruskan pengaduan layanan ini?',
                text: "Teruskan Pengaduan : <?= $data->kategori ?> - dari : <?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?> , dengan Kode Aduan: <?= $data->kode_aduan ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Teruskan!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./proses",
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
                                $('#content-approveModalLabel').html('TERUSKAN PENGADUAN LAYANAN <?= $data->kategori ?> dari ' + nama + ', dengan Kode Aduan: ' + kode);
                                $('.contentApproveBodyModal').html(resul.data);
                                $('.content-approveModal').modal({
                                    backdrop: 'static',
                                    keyboard: false,
                                });
                                $('.content-approveModal').modal('show');
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
                }
            })
        };
    </script>
<?php } ?>
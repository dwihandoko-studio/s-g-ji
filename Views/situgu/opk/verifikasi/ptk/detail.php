<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA INDIVIDU</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" value="<?= $data->nama ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/ktp') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/ktp') . '/' . $data->lampiran_ktp ?>" id="nik">Lampiran KTP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nik ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nuptk" aria-label="NUPTK" value="<?= $data->nuptk ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/nuptk') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/nuptk') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NUPTK</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nip" aria-label="NIP" value="<?= $data->nip ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/karpeg') . '/' . $data->lampiran_karpeg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/karpeg') . '/' . $data->lampiran_karpeg ?>" id="nik">Lampiran Karpeg</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nip ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NRG:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nrg" aria-label="NRG" value="<?= $data->nrg ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/nrg') . '/' . $data->lampiran_nrg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/nrg') . '/' . $data->lampiran_nrg ?>" id="nik">Lampiran NRG</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nrg ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Peserta:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_peserta" aria-label="No Peserta" value="<?= $data->no_peserta ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/serdik') . '/' . $data->lampiran_serdik ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/serdik') . '/' . $data->lampiran_serdik ?>" id="no_peserta">Lampiran Serdik</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_peserta ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPWP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="npwp" aria-label="NPWP" value="<?= $data->npwp ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/npwp') . '/' . $data->lampiran_npwp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/npwp') . '/' . $data->lampiran_npwp ?>" id="nik">Lampiran NPWP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->npwp ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Rekening:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_rekening" aria-label="NO REKENING" value="<?= $data->no_rekening ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/ptk/bukurekening') . '/' . $data->lampiran_buku_rekening ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/bukurekening') . '/' . $data->lampiran_buku_rekening ?>" id="nik">Lampiran Rekening</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_rekening ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Cabang Bank:</label>
                <input type="text" class="form-control" value="<?= $data->cabang_bank ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tempat Lahir:</label>
                <input type="text" class="form-control" value="<?= $data->tempat_lahir ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tanggal Lahir:</label>
                <input type="text" class="form-control" value="<?= $data->tgl_lahir ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis Kelamin:</label>
                <div><?php switch ($data->jenis_kelamin) {
                            case 'P':
                                echo '<span class="badge badge-pill badge-soft-primary">Perempuan</span>';
                                break;
                            case 'L':
                                echo '<span class="badge badge-pill badge-soft-primary">Laki-Laki</span>';
                                break;
                            default:
                                echo '-';
                                break;
                        } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Email Dapodik:</label>
                <input type="text" class="form-control" value="<?= $data->email ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Hanphone Dapodik:</label>
                <input type="text" class="form-control" value="<?= $data->no_hp ?>" readonly />
            </div>
        </div>
        <div class="row">
            <h2>DATA PENUGASAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">NPSN:</label>
                <input type="text" class="form-control" value="<?= $data->npsn ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tempat Tugas:</label>
                <input type="text" class="form-control" value="<?= $data->tempat_tugas ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Status Tugas:</label>
                <div><span class="badge badge-pill badge-soft-secondary"><?= $data->status_tugas ?></span></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kecamatan:</label>
                <input type="text" class="form-control" value="<?= $data->kecamatan ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Status PTK:</label>
                <div><span class="badge badge-pill badge-soft-secondary"><?= $data->status_kepegawaian ?></span></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Mapel Diajarkan:</label>
                <input type="text" class="form-control" value="<?= $data->mapel_diajarkan ?>" readonly />
            </div>
            <?php switch ($data->bidang_studi_sertifikasi) {
                case '':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case null:
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case '-':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case ' ':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;

                default:
                    echo `<div class="col-lg-6">
                        <label class="col-form-label">Sudah Sertifikasi:</label>
                        <div><span class="badge badge-pill badge-soft-success">Sudah</span></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Bidang Studi Sertifikasi:</label>
                        <input type="text" class="form-control" value="$data->bidang_studi_sertifikasi" readonly />
                    </div>`;
                    break;
            } ?>

            <div class="col-lg-6">
                <label class="col-form-label">Jam Mengajar Perminggu:</label>
                <input type="text" class="form-control" value="<?= $data->jam_mengajar_perminggu ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">SK Pengangkatan:</label>
                <input type="text" class="form-control" value="<?= $data->sk_pengangkatan ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">TMT Pengangkatan:</label>
                <input type="text" class="form-control" value="<?php switch ($data->tmt_pengangkatan) {
                                                                    case '':
                                                                        echo '';
                                                                        break;
                                                                    case '-':
                                                                        echo '';
                                                                        break;
                                                                    case NULL:
                                                                        echo '';
                                                                        break;
                                                                    case '1900-01-01':
                                                                        echo '';
                                                                        break;

                                                                    default:
                                                                        echo $data->tmt_pengangkatan;
                                                                        break;
                                                                } ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">SK CPNS:</label>
                <input type="text" class="form-control" value="<?= $data->sk_cpns ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tanggal CPNS:</label>
                <input type="text" class="form-control" value="<?php switch ($data->tgl_cpns) {
                                                                    case '':
                                                                        echo '';
                                                                        break;
                                                                    case '-':
                                                                        echo '';
                                                                        break;
                                                                    case NULL:
                                                                        echo '';
                                                                        break;
                                                                    case '1900-01-01':
                                                                        echo '';
                                                                        break;

                                                                    default:
                                                                        echo $data->tgl_cpns;
                                                                        break;
                                                                } ?>" readonly />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionTolak(this)" class="btn btn-danger waves-effect waves-light">Tolak Usulan Penghapusan</button>
        <button type="button" onclick="actionApprove(this)" class="btn btn-success waves-effect waves-light">Setujui Usulan Penghapusan</button>
    </div>
    <script>
        function actionTolak(e) {
            const nama = '<?= $data->nama ?>';
            Swal.fire({
                title: 'Apakah anda yakin ingin menolak usulan Penghapusan PTK ini?',
                text: "Tolak Usulan Penghapusan PTK: <?= $data->nama ?>",
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
                                $('#content-tolakModalLabel').html('TOLAK USULAN TAMSIL ' + nama);
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
            const nama = '<?= $data->nama ?>';
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
            const nama = '<?= $data->nama ?>';

            Swal.fire({
                title: 'Apakah anda yakin ingin menyetujui usulan Penghapusan PTK ini?',
                text: "Setujui Usulan Penghapusan PTK: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui untuk Hapus!'
            }).then((result) => {
                if (result.value) {

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
                }
            })
        };
    </script>
<?php } ?>
<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <div class="table-responsive">
                <h4>Generate SPTJM Verifikasi Tunjangan Penghasilan Guru PNS Non Sertifikasi (Tamsil).</h4>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Aksi</th>
                            <th>Jumlah</th>
                            <th>Konfirm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Verifikasi Tunjangan Tamsil</td>
                            <td><?= $data->jumlah ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="_confirm" value="<?= $value->kode_usulan ?>" name="_confirm">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionSubmit(this)" class="btn btn-success waves-effect waves-light button-submit">Generate SPTJM Verifikasi Tamsil</button>
    </div>
    <script>
        function actionSubmit(event) {

            let status;
            if ($('#_confirm').is(":checked")) {

                Swal.fire({
                    title: 'Apakah anda yakin ingin mengenerate SPTJM Verifikasi Tunjangan Tamsil?',
                    text: "Generate SPTJM Verifikasi Tunjangan Tamsil",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Generate SPTJM Verifikasi Tamsil!',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./generatesptjm",
                            type: 'POST',
                            data: {
                                jenis: 'tamsil',
                                tw: '<?= $tw ?>',
                                jumlah: '<?= $data->jumlah ?>',
                            },
                            dataType: 'JSON',
                            beforeSend: function() {
                                $('.button-submit').attr('disabled', true);
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
                                            $('.button-submit').attr('disabled', false);
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
                            error: function() {
                                $('.button-submit').attr('disabled', false);
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
            } else {
                Swal.fire(
                    'PERINGATAN!',
                    "Silahkan ceklis konfirmasi terlebih dahulu.",
                    'warning'
                );
            }

        };
    </script>
<?php } ?>
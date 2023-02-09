<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <div class="table-responsive">
                <h4>Generate SPTJM Usulan Tunjangan Penghasilan Guru PNS Non Sertifikasi (Tamsil).</h4>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NUPTK</th>
                            <th>Konfirm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $key => $value) { ?>
                            <tr>
                                <th scope="row">1</th>
                                <td><?= $value->nama ?></td>
                                <!-- <td><label class="form-check-label" for="_nama"><?= $value->nama ?></label></td> -->
                                <td><?= $value->nuptk ?></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="_nama" value="<?= $value->id_ptk_usulan ?>" onchange="changeChecked(this)" name="hasil[]">
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="actionSubmit(this)" class="btn btn-success waves-effect waves-light button-submit">Generate SPTJM Usulan Tamsil</button>
    </div>
    <script>
        let ptks = [];

        function changeChecked(event) {
            let checkedCount = document.getElementsByName('hasil[]');
            // for (let i = 0, n = checkedCount.length; i < n; i++) {
            // if (checkedCount[i].checked) {
            if (event.checked) {
                ptks.push(event.value);
                // if (tpks === "") {
                //     tpks = checkedCount[i].value();
                // } else {
                //     tpks = tpsk + "," + checkedCount[i].value();
                // }
                // $('.submit-button-ajuan').attr('disabled', true);
                // return;
            } else {
                const ptkIndex = ptks.findIndex((ptk) => ptk === event.value);
                if (ptkIndex === -1) {
                    return;
                }
                ptks.splice(ptkIndex, 1);
            }
            // }

            // $('.submit-button-ajuan').attr('disabled', false);
        }

        // $("#formEditModalData").on("submit", function(e) {
        //     e.preventDefault();
        function actionSubmit(event) {
            if (ptks.length > 0) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin mengenerate SPTJM Usulan Tunjangan Tamsil?',
                    text: "Generate SPTJM Tunjangan Tamsil",
                    showCancelButton: true,
                    icon: 'question',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Generate SPTJM Tamsil!',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "./generatesptjm",
                            type: 'POST',
                            data: {
                                jenis: 'tamsil',
                                tw: '<?= $tw ?>',
                                jumlah: ptks.length,
                                ptks: ptks
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
                    'PERINGATAN!!!',
                    "Silahkan pilih data ptk yang akan digenerate SPTJM.",
                    'warning'
                );
            }
        };
    </script>
<?php } ?>
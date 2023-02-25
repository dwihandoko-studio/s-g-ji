<?php if (isset($id)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <label class="col-form-label">Keterangan Approval:</label>
            <textarea rows="10" class="form-control" id="_keterangan_tolak" name="_keterangan_tolak" required></textarea>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="simpanApprove(this)" class="btn btn-primary waves-effect waves-light">Approve Aduan Pengguna</button>
    </div>
    <script>
        function simpanApprove(e) {
            const keterangan = document.getElementsByName('_keterangan_tolak')[0].value;
            if (keterangan === "" || keterangan === undefined) {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Keterangan penolakan tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            $.ajax({
                url: "./solved",
                type: 'POST',
                data: {
                    id: '<?= $id ?>',
                    nama: '<?= $nama ?>',
                    keterangan: keterangan,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading-tolak').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading-tolak').unblock();

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
                    $('div.modal-content-loading-tolak').unblock();
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
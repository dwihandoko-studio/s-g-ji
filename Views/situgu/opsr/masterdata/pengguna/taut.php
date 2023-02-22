<form id="formAddModalData" action="./tautkan" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $id ?>">
    <input type="hidden" id="_nama" name="_nama" value="<?= $nama ?>">
    <input type="hidden" id="_npsn" name="_npsn" value="<?= $npsn ?>">
    <input type="hidden" id="_email" name="_email" value="<?= $email ?>">
    <div class="modal-body">
        <p><code>*)</code>Jika data PTK tidak ada dalam daftar dibawah ini, Silahkan untuk melakukan Tarik Data terlebih dahulu. <a href="<?= base_url('situgu/ops/masterdata/ptk') ?>"><i class="bx bx-log-in-circle"></i></a></p>
        <div class="mb-3">
            <label for="_ptk" class="col-form-label">Pilih PTK:</label>
            <select class="form-control ptk" id="_ptk" name="_ptk" style="width: 100%">
                <option value="">&nbsp;</option>
                <?php if (isset($data)) {
                    if (count($data) > 0) {
                        foreach ($data as $key => $value) { ?>
                            <option value="<?= $value->id_ptk ?>"><?= $value->nama ?> - (NUPTK: <?= $value->nuptk ?>)</option>
                <?php }
                    }
                } ?>
            </select>
            <div class="help-block _ptk"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    initSelect2("_ptk", ".content-detailModal");

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const id = document.getElementsByName('_id')[0].value;
        const nama = document.getElementsByName('_nama')[0].value;
        const email = document.getElementsByName('_email')[0].value;
        const npsn = document.getElementsByName('_npsn')[0].value;
        const ptk = document.getElementsByName('_ptk')[0].value;

        if (ptk === "") {
            $("select#_ptk").css("color", "#dc3545");
            $("select#_ptk").css("border-color", "#dc3545");
            $('._ptk').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih PTK.</li></ul>');
            return false;
        }
        if (id === "") {
            Swal.fire(
                'Warning!',
                "Kesalahan dalam memuat data.",
                'warning'
            ).then((valRes) => {
                reloadPage();
            });
        }

        Swal.fire({
            title: 'Apakah anda yakin ingin menautkan Akun' + nama + ' ke PTK yang dipilih?',
            text: "Tautkan PTK Ke Akun : " + nama,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tautkan!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./tautkan",
                    type: 'POST',
                    data: {
                        id: id,
                        nama: nama,
                        email: email,
                        npsn: npsn,
                        ptk: ptk,
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
                        $('div.modal-content-loading').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }

                });
            }
        });
    });
</script>
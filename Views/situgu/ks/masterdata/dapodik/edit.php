<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id_ptk ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_nrg" class="form-label">NRG</label>
                <input type="text" class="form-control nrg" value="<?= $data->nrg ?>" id="_nrg" name="_nrg" placeholder="NRG..." onfocusin="inputFocus(this);">
                <div class="help-block _nrg"></div>
            </div>
            <div class="mb-3">
                <label for="_no_peserta" class="form-label">No Peserta</label>
                <input type="text" class="form-control no_peserta" value="<?= $data->no_peserta ?>" id="_no_peserta" name="_no_peserta" placeholder="No Peserta..." onfocusin="inputFocus(this);">
                <div class="help-block _no_peserta"></div>
            </div>
            <div class="mb-3">
                <label for="_npwp" class="form-label">NPWP</label>
                <input type="text" class="form-control npwp" value="<?= $data->npwp ?>" id="_npwp" name="_npwp" placeholder="NPWP..." onfocusin="inputFocus(this);">
                <div class="help-block _npwp"></div>
            </div>
            <div class="mb-3">
                <label for="_no_rekening" class="form-label">No Rekening Bank</label>
                <input type="text" class="form-control no_rekening" id="_no_rekening" name="_no_rekening" value="<?= $data->no_rekening ?>" placeholder="No Rekening..." onfocusin="inputFocus(this);">
                <div class="help-block _no_rekening"></div>
            </div>
            <div class="mb-3">
                <label for="_cabang_bank" class="form-label">Cabang Bank</label>
                <input type="text" class="form-control cabang_bank" id="_cabang_bank" name="_cabang_bank" value="<?= $data->cabang_bank ?>" placeholder="Cabang Bank..." onfocusin="inputFocus(this);">
                <div class="help-block _cabang_bank"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const nrg = document.getElementsByName('_nrg')[0].value;
            const no_peserta = document.getElementsByName('_no_peserta')[0].value;
            const npwp = document.getElementsByName('_npwp')[0].value;
            const no_rekening = document.getElementsByName('_no_rekening')[0].value;
            const cabang_bank = document.getElementsByName('_cabang_bank')[0].value;

            if (nrg === "") {
                $("input#_nrg").css("color", "#dc3545");
                $("input#_nrg").css("border-color", "#dc3545");
                $('._nrg').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NRG tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }
            if (no_peserta === "") {
                $("input#_no_peserta").css("color", "#dc3545");
                $("input#_no_peserta").css("border-color", "#dc3545");
                $('._no_peserta').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Peserta tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }
            if (npwp === "") {
                $("input#_npwp").css("color", "#dc3545");
                $("input#_npwp").css("border-color", "#dc3545");
                $('._npwp').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NPWP tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }
            if (no_rekening === "") {
                $("input#_no_rekening").css("color", "#dc3545");
                $("input#_no_rekening").css("border-color", "#dc3545");
                $('._no_rekening').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Rekening tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }
            if (cabang_bank === "") {
                $("input#_cabang_bank").css("color", "#dc3545");
                $("input#_cabang_bank").css("border-color", "#dc3545");
                $('._cabang_bank').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Cabang Bank tidak boleh kosong. Silahkan isi dengan tanda (-) jika tidak ada.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data PTK: <?= $data->nama ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "./editSave",
                        type: 'POST',
                        data: {
                            id: id,
                            nrg: nrg,
                            no_peserta: no_peserta,
                            npwp: npwp,
                            no_rekening: no_rekening,
                            cabang_bank: cabang_bank,
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
            })
        });
    </script>

<?php } ?>
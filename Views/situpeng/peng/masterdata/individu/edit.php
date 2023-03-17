<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="row mb-3">
                <div class="col-lg-6">
                    <label for="_nik" class="col-form-label">NIK</label>
                    <input type="text" class="form-control nik" value="<?= $data->nik ?>" id="_nik" name="_nik" placeholder="NIK..." onfocusin="inputFocus(this);">
                    <div class="help-block _nik"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tempat_lahir" class="col-form-label">Tempat Lahir</label>
                    <input type="text" class="form-control tempat-lahir" value="<?= $data->tempat_lahir ?>" id="_tempat_lahir" name="_tempat_lahir" placeholder="Tempat Lahir..." onfocusin="inputFocus(this);">
                    <div class="help-block _tempat_lahir"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tgl_lahir" class="col-form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control tgl-lahir" value="<?= $data->tgl_lahir ?>" id="_tgl_lahir" name="_tgl_lahir" onfocusin="inputFocus(this);">
                    <div class="help-block _tgl_lahir"></div>
                </div>
                <div class="col-lg-6">
                    <h5 class="font-size-14 mt-4 mb-4">Jenis Kelamin</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="L" name="_jk" id="_jk1" <?= $data->jenis_kelamin == NULL ? 'checked' : ($data->jenis_kelamin == 'L' ? 'checked' : '') ?>>
                        <label class="form-check-label" for="_jk1">
                            Laki - laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="P" name="_jk" id="_jk2" <?= $data->jenis_kelamin == NULL ? '' : ($data->jenis_kelamin == 'P' ? 'checked' : '') ?>>
                        <label class="form-check-label" for="_jk2">
                            Perempuan
                        </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="_nohp" class="col-form-label">No Handphone</label>
                    <input type="text" class="form-control nohp" value="<?= $data->no_hp ?>" id="_nohp" name="_nohp" placeholder="No HP..." onfocusin="inputFocus(this);">
                    <div class="help-block _nohp"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_email" class="col-form-label">Email</label>
                    <input type="email" class="form-control email" value="<?= $data->email ?>" id="_email" name="_email" placeholder="Email..." onfocusin="inputFocus(this);">
                    <div class="help-block _email"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_nrg" class="col-form-label">NRG</label>
                    <input type="text" class="form-control nrg" value="<?= $data->nrg ?>" id="_nrg" name="_nrg" placeholder="NRG..." onfocusin="inputFocus(this);">
                    <div class="help-block _nrg"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_no_peserta" class="col-form-label">No Peserta</label>
                    <input type="text" class="form-control no_peserta" value="<?= $data->no_peserta ?>" id="_no_peserta" name="_no_peserta" placeholder="No Peserta..." onfocusin="inputFocus(this);">
                    <div class="help-block _no_peserta"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_npwp" class="col-form-label">NPWP</label>
                    <input type="text" class="form-control npwp" value="<?= $data->npwp ?>" id="_npwp" name="_npwp" placeholder="NPWP..." onfocusin="inputFocus(this);">
                    <div class="help-block _npwp"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_no_rekening" class="col-form-label">No Rekening Bank</label>
                    <input type="text" class="form-control no_rekening" id="_no_rekening" name="_no_rekening" value="<?= $data->no_rekening ?>" placeholder="No Rekening..." onfocusin="inputFocus(this);">
                    <div class="help-block _no_rekening"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_cabang_bank" class="col-form-label">Cabang Bank</label>
                    <input type="text" class="form-control cabang_bank" id="_cabang_bank" name="_cabang_bank" value="<?= $data->cabang_bank ?>" placeholder="Cabang Bank..." onfocusin="inputFocus(this);">
                    <div class="help-block _cabang_bank"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">SIMPAN</button>
        </div>
    </form>

    <script>
        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const nik = document.getElementsByName('_nik')[0].value;
            const email = document.getElementsByName('_email')[0].value;
            const tempat_lahir = document.getElementsByName('_tempat_lahir')[0].value;
            const tgl_lahir = document.getElementsByName('_tgl_lahir')[0].value;
            const jk = $("input[type='radio'][name='_jk']:checked").val();
            const nohp = document.getElementsByName('_nohp')[0].value;
            const nrg = document.getElementsByName('_nrg')[0].value;
            const no_peserta = document.getElementsByName('_no_peserta')[0].value;
            const npwp = document.getElementsByName('_npwp')[0].value;
            const no_rekening = document.getElementsByName('_no_rekening')[0].value;
            const cabang_bank = document.getElementsByName('_cabang_bank')[0].value;

            if (nik === "") {
                $("input#_nik").css("color", "#dc3545");
                $("input#_nik").css("border-color", "#dc3545");
                $('._nik').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK tidak boleh kosong.</li></ul>');
                return false;
            }

            if (tempat_lahir === "") {
                $("input#_tempat_lahir").css("color", "#dc3545");
                $("input#_tempat_lahir").css("border-color", "#dc3545");
                $('._tempat_lahir').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tempat lahir tidak boleh kosong.</li></ul>');
                return false;
            }

            if (tgl_lahir === "") {
                $("input#_tgl_lahir").css("color", "#dc3545");
                $("input#_tgl_lahir").css("border-color", "#dc3545");
                $('._tgl_lahir').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal lahir tidak boleh kosong.</li></ul>');
                return false;
            }

            if (nohp === "") {
                $("input#_nohp").css("color", "#dc3545");
                $("input#_nohp").css("border-color", "#dc3545");
                $('._nohp').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No handphone tidak boleh kosong.</li></ul>');
                return false;
            }

            if (email === "") {
                $("input#_email").css("color", "#dc3545");
                $("input#_email").css("border-color", "#dc3545");
                $('._email').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Email tidak boleh kosong.</li></ul>');
                return false;
            }

            if (nrg === "") {
                $("input#_nrg").css("color", "#dc3545");
                $("input#_nrg").css("border-color", "#dc3545");
                $('._nrg').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NRG tidak boleh kosong.</li></ul>');
                return false;
            }
            if (no_peserta === "") {
                $("input#_no_peserta").css("color", "#dc3545");
                $("input#_no_peserta").css("border-color", "#dc3545");
                $('._no_peserta').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Peserta tidak boleh kosong.</li></ul>');
                return false;
            }
            if (npwp === "") {
                $("input#_npwp").css("color", "#dc3545");
                $("input#_npwp").css("border-color", "#dc3545");
                $('._npwp').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NPWP tidak boleh kosong.</li></ul>');
                return false;
            }
            if (no_rekening === "") {
                $("input#_no_rekening").css("color", "#dc3545");
                $("input#_no_rekening").css("border-color", "#dc3545");
                $('._no_rekening').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Rekening tidak boleh kosong.</li></ul>');
                return false;
            }
            if (cabang_bank === "") {
                $("input#_cabang_bank").css("color", "#dc3545");
                $("input#_cabang_bank").css("border-color", "#dc3545");
                $('._cabang_bank').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Cabang Bank tidak boleh kosong.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Pengawas: <?= $data->nama ?>",
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
                            nik: nik,
                            tempat_lahir: tempat_lahir,
                            tgl_lahir: tgl_lahir,
                            jk: jk,
                            nohp: nohp,
                            email: email,
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
<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="row mb-3">
                <div class="col-lg-6 jenis-role">
                    <div class="mb-3">
                        <label for="_jenis" class="col-form-label">Pilih Jenis Dokumen:</label>
                        <select class="select2 form-control select2" id="_jenis" name="_jenis" onchange="changeJenis(this)" style="width: 100%" data-placeholder="Pilih jenis ...">
                            <option value="">--Pilih Jenis Dokumen---</option>
                            <option value="pangkat" <?= $data->us_pang_jenis == "pangkat" ? 'selected' : '' ?>>PANGKAT</option>
                            <option value="kgb" <?= $data->us_pang_jenis == "kgb" ? 'selected' : '' ?>>KGB</option>
                        </select>
                        <div class="help-block _jenis"></div>
                    </div>
                </div>
                <div class="col-lg-6 pangkat-role">
                    <div class="mb-3">
                        <label for="_pangkat" class="col-form-label">Pilih Pangkat Golongan:</label>
                        <select class="select2 form-control select2" id="_pangkat" name="_pangkat" onchange="changePangkat(this)" style="width: 100%" data-placeholder="Pilih pangkat ...">
                            <option value="" selected>Pilih pangkat</option>
                            <?php if (isset($pangkats)) {
                                if (count($pangkats) > 0) {
                                    foreach ($pangkats as $key => $value) { ?>
                                        <option value="<?= $value->pangkat ?>" <?= $data->us_pang_golongan == $value->pangkat ? 'selected' : '' ?>><?= $value->pangkat ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <div class="help-block _pangkat"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="_nomor_sk" class="col-form-label">Nomor SK:</label>
                    <input type="text" class="form-control nomor_sk" value="<?= $data->nomor_sk ?>" id="_nomor_sk" name="_nomor_sk" placeholder="Nomor SK..." onfocusin="inputFocus(this);">
                    <div class="help-block _nomor_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tgl_sk" class="col-form-label">Tanggal SK</label>
                    <input type="date" class="form-control tgl_sk" value="<?= $data->no_hp ?>" id="_tgl_sk" name="_tgl_sk" onfocusin="inputFocus(this);">
                    <div class="help-block _tgl_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tmt_sk" class="col-form-label">TMT SK</label>
                    <input type="date" class="form-control tmt_sk" value="<?= $data->tmt_sk ?>" id="_tmt_sk" name="_tmt_sk" onfocusin="inputFocus(this);">
                    <div class="help-block _tmt_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_mk_tahun" class="col-form-label">Masa Kerja Tahun</label>
                    <input type="text" class="form-control mk_tahun" value="<?= $data->mk_tahun ?>" id="_mk_tahun" name="_mk_tahun" placeholder="Masa kerja tahun..." onfocusin="inputFocus(this);">
                    <div class="help-block _mk_tahun"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_mk_bulan" class="col-form-label">Masa Kerja Bulan</label>
                    <input type="number" class="form-control mk_bulan" value="<?= $data->mk_bulan ?>" id="_mk_bulan" name="_mk_bulan" placeholder="Masa kerja bulan..." onfocusin="inputFocus(this);">
                    <div class="help-block _mk_bulan"></div>
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
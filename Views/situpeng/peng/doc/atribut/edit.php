<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="row mb-3">
                <div class="col-lg-6 jenis-role">
                    <div class="mb-3">
                        <label for="_jenis" class="col-form-label">Pilih Jenis Dokumen:</label>
                        <select class="select2 form-control select2" id="_jenis" name="_jenis" style="width: 100%" data-placeholder="Pilih jenis ..." onfocusin="inputFocus(this);">
                            <option value="">--Pilih Jenis Dokumen---</option>
                            <option value="pangkat" <?= $data->pang_jenis == "pangkat" ? 'selected' : '' ?>>PANGKAT</option>
                            <option value="kgb" <?= $data->pang_jenis == "kgb" ? 'selected' : '' ?>>KGB</option>
                        </select>
                        <div class="help-block _jenis"></div>
                    </div>
                </div>
                <div class="col-lg-6 pangkat-role">
                    <div class="mb-3">
                        <label for="_pangkat" class="col-form-label">Pilih Pangkat Golongan:</label>
                        <select class="select2 form-control select2" id="_pangkat" name="_pangkat" style="width: 100%" data-placeholder="Pilih pangkat ..." onfocusin="inputFocus(this);">
                            <option value="" selected>Pilih pangkat</option>
                            <?php if (isset($pangkats)) {
                                if (count($pangkats) > 0) {
                                    foreach ($pangkats as $key => $value) { ?>
                                        <option value="<?= $value->pangkat ?>" <?= $data->pang_golongan == $value->pangkat ? 'selected' : '' ?>><?= $value->pangkat ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <div class="help-block _pangkat"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="_nomor_sk" class="col-form-label">Nomor SK:</label>
                    <input type="text" class="form-control nomor_sk" value="<?= $data->pang_no ?>" id="_nomor_sk" name="_nomor_sk" placeholder="Nomor SK..." onfocusin="inputFocus(this);">
                    <div class="help-block _nomor_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tgl_sk" class="col-form-label">Tanggal SK</label>
                    <input type="date" class="form-control tgl_sk" value="<?= $data->pang_tgl ?>" id="_tgl_sk" name="_tgl_sk" onfocusin="inputFocus(this);">
                    <div class="help-block _tgl_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_tmt_sk" class="col-form-label">TMT SK</label>
                    <input type="date" class="form-control tmt_sk" value="<?= $data->pang_tmt ?>" id="_tmt_sk" name="_tmt_sk" onfocusin="inputFocus(this);">
                    <div class="help-block _tmt_sk"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_mk_tahun" class="col-form-label">Masa Kerja Tahun</label>
                    <input type="text" class="form-control mk_tahun" value="<?= $data->pang_tahun ?>" id="_mk_tahun" name="_mk_tahun" placeholder="Masa kerja tahun..." onfocusin="inputFocus(this);">
                    <div class="help-block _mk_tahun"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_mk_bulan" class="col-form-label">Masa Kerja Bulan</label>
                    <input type="number" class="form-control mk_bulan" value="<?= $data->pang_bulan ?>" id="_mk_bulan" name="_mk_bulan" placeholder="Masa kerja bulan..." onfocusin="inputFocus(this);">
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
            const jenis = document.getElementsByName('_jenis')[0].value;
            const pangkat = document.getElementsByName('_pangkat')[0].value;
            const nomor_sk = document.getElementsByName('_nomor_sk')[0].value;
            const tgl_sk = document.getElementsByName('_tgl_sk')[0].value;
            const tmt_sk = document.getElementsByName('_tmt_sk')[0].value;
            const mk_tahun = document.getElementsByName('_mk_tahun')[0].value;
            const mk_bulan = document.getElementsByName('_mk_bulan')[0].value;

            if (jenis === "") {
                $("select#_jenis").css("color", "#dc3545");
                $("select#_jenis").css("border-color", "#dc3545");
                $('._jenis').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih jenis dokumen.</li></ul>');
                return false;
            }
            if (pangkat === "") {
                $("select#_pangkat").css("color", "#dc3545");
                $("select#_pangkat").css("border-color", "#dc3545");
                $('._pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih pangkat golongan.</li></ul>');
                return false;
            }
            if (nomor_sk === "") {
                $("input#_nomor_sk").css("color", "#dc3545");
                $("input#_nomor_sk").css("border-color", "#dc3545");
                $('._nomor_sk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nomor tidak boleh kosong.</li></ul>');
                return false;
            }
            if (tgl_sk === "") {
                $("input#_tgl_sk").css("color", "#dc3545");
                $("input#_tgl_sk").css("border-color", "#dc3545");
                $('._tgl_sk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal SK tidak boleh kosong.</li></ul>');
                return false;
            }
            if (tmt_sk === "") {
                $("input#_tmt_sk").css("color", "#dc3545");
                $("input#_tmt_sk").css("border-color", "#dc3545");
                $('._tmt_sk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT SK tidak boleh kosong.</li></ul>');
                return false;
            }
            if (mk_tahun === "") {
                $("input#_mk_tahun").css("color", "#dc3545");
                $("input#_mk_tahun").css("border-color", "#dc3545");
                $('._mk_tahun').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Masa kerja tahun tidak boleh kosong.</li></ul>');
                return false;
            }
            if (mk_bulan === "") {
                $("input#_mk_bulan").css("color", "#dc3545");
                $("input#_mk_bulan").css("border-color", "#dc3545");
                $('._mk_bulan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Masa kerja bulan tidak boleh kosong.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Attribut Tahun : <?= $tahun ?> / TW : <?= $tw ?>",
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
                            jenis: jenis,
                            pangkat: pangkat,
                            nomor_sk: nomor_sk,
                            tgl_sk: tgl_sk,
                            tmt_sk: tmt_sk,
                            mk_tahun: mk_tahun,
                            mk_bulan: mk_bulan,
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
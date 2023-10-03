<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="_fullname" class="form-label">Nama</label>
                        <input type="text" class="form-control fullname" value="<?= $data->fullname ?>" id="_fullname" name="_fullname" placeholder="Nama..." onfocusin="inputFocus(this);">
                        <div class="help-block _fullname"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_nik" class="form-label">NIK</label>
                        <input type="text" class="form-control nik" value="<?= $data->nik ?>" id="_nik" name="_nik" placeholder="NIK..." onfocusin="inputFocus(this);">
                        <div class="help-block _nik"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_kk" class="form-label">KK</label>
                        <input type="text" class="form-control kk" value="<?= $data->kk ?>" id="_kk" name="_kk" placeholder="KK..." onfocusin="inputFocus(this);">
                        <div class="help-block _kk"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control tempat_lahir" value="<?= $data->tempat_lahir ?>" id="_tempat_lahir" name="_tempat_lahir" placeholder="Tempat lahir..." onfocusin="inputFocus(this);">
                        <div class="help-block _tempat_lahir"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control tgl_lahir" value="<?= $data->tgl_lahir ?>" id="_tgl_lahir" name="_tgl_lahir" placeholder="Tanggal lahir..." onfocusin="inputFocus(this);">
                        <div class="help-block _tgl_lahir"></div>
                    </div>

                    <div class="mb-3">
                        <label for="_email" class="form-label">E-mail</label>
                        <input type="email" class="form-control email" value="<?= $data->email ?>" id="_email" name="_email" placeholder="Email akun..." onfocusin="inputFocus(this);">
                        <div class="help-block _email"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_nohp" class="form-label">No Handphone</label>
                        <input type="text" class="form-control nohp" value="<?= $data->no_hp ?>" id="_nohp" name="_nohp" placeholder="No handphone..." onfocusin="inputFocus(this);">
                        <div class="help-block _nohp"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="_jenis_kelamin" class="col-form-label">Jenis Kelamin :</label>
                        <select class="form-control" id="_jenis_kelamin" name="_jenis_kelamin" required>
                            <option value="L" <?= ($data->jenis_kelamin == 'L') ? ' selected' : '' ?>>Laki-Laki</option>
                            <option value="P" <?= ($data->jenis_kelamin == 'P') ? ' selected' : '' ?>>Perempuan</option>
                        </select>
                        <div class="help-block _jenis_kelamin"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_pekerjaan" class="col-form-label">Pekerjaan :</label>
                        <select class="form-control select2 pekerjaan" id="_pekerjaan" name="_pekerjaan" style="width: 100%" onchange="changePekerjaan(this)">
                            <option value="">&nbsp;</option>
                            <?php if (isset($pekerjaans)) {
                                if (count($pekerjaans) > 0) {
                                    foreach ($pekerjaans as $key => $value) { ?>
                                        <option value="<?= $value->pekerjaan ?>" <?= ($data->pekerjaan == $value->pekerjaan) ? ' selected' : '' ?>><?= $value->pekerjaan ?></option>
                            <?php }
                                }
                            } ?>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <input type="text" style="display: none; margin-top: 10px;" class="form-control perkerjaan-lain" value="<?= $data->tgl_lahir ?>" id="_pekerjaan_lain" name="_pekerjaan_lain" placeholder="Input pekerjaan..." onfocusin="inputFocus(this);">
                        <div class="help-block _pekerjaan"></div>
                        <div class="help-block _pekerjaan_lain"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_kecamatan" class="col-form-label">Kecamatan :</label>
                        <select class="form-control select2 kecamatan" id="_kecamatan" name="_kecamatan" style="width: 100%" onchange="changeKecamatan(this)">
                            <option value="">&nbsp;</option>
                            <?php if (isset($kecamatans)) {
                                if (count($kecamatans) > 0) {
                                    foreach ($kecamatans as $key => $value) { ?>
                                        <option value="<?= $value->id ?>" <?= ($data->kecamatan == $value->id) ? ' selected' : '' ?>><?= $value->kecamatan ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <div class="help-block _kecamatan"></div>
                    </div>
                    <div class="mb-3 select2-kelurahan-loading">
                        <label for="_kelurahan" class="col-form-label">Kelurahan :</label>
                        <select class="form-control select2 kelurahan" id="_kelurahan" name="_kelurahan" style="width: 100%">
                            <option value="">&nbsp;</option>
                            <?php if (isset($kelurahans)) {
                                if (count($kelurahans) > 0) {
                                    foreach ($kelurahans as $key => $value) { ?>
                                        <option value="<?= $value->id ?>" <?= ($data->kelurahan == $value->id) ? ' selected' : '' ?>><?= $value->kelurahan ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <div class="help-block _kelurahan"></div>
                    </div>
                    <div class="mb-3">
                        <label for="_alamat" class="form-label">Alamat</label>
                        <textarea rows="5" class="form-control alamat" id="_alamat" name="_alamat" placeholder="Alamat lengkap..." onfocusin="inputFocus(this);"><?= $data->alamat ?></textarea>
                        <div class="help-block _alamat"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        initSelect2("_pekerjaan", ".content-aktivasiCompleteModal");
        initSelect2("_kecamatan", ".content-aktivasiCompleteModal");
        initSelect2("_kelurahan", ".content-aktivasiCompleteModal");

        function changePekerjaan(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value === "lainnya") {
                document.getElementById("_pekerjaan_lain").style.display = "block";
            } else {
                document.getElementById("_pekerjaan_lain").style.display = "none";
            }
        }

        function changeKecamatan(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: '../portal/getKelurahan',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.kelurahan').html("");
                        $('div.select2-kelurahan-loading').block({
                            message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.select2-kelurahan-loading').unblock();
                        if (resul.status == 200) {
                            $('.kelurahan').html(resul.data);
                        } else {
                            if (resul.status == 401) {
                                Swal.fire(
                                    'PERINGATAN!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage(resul.redirrect);
                                })
                            } else {
                                Swal.fire(
                                    'PERINGATAN!!!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        }
                    },
                    error: function(data) {
                        $('div.select2-kelurahan-loading').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        }

        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const nama = document.getElementsByName('_fullname')[0].value;
            const nik = document.getElementsByName('_nik')[0].value;
            const kk = document.getElementsByName('_kk')[0].value;
            const tempat_lahir = document.getElementsByName('_tempat_lahir')[0].value;
            const tgl_lahir = document.getElementsByName('_tgl_lahir')[0].value;
            const jenis_kelamin = document.getElementsByName('_jenis_kelamin')[0].value;
            const pekerjaan = document.getElementsByName('_pekerjaan')[0].value;
            const kecamatan = document.getElementsByName('_kecamatan')[0].value;
            const kelurahan = document.getElementsByName('_kelurahan')[0].value;
            const alamat = document.getElementsByName('_alamat')[0].value;
            const email = document.getElementsByName('_email')[0].value;
            const nohp = document.getElementsByName('_nohp')[0].value;
            const pekerjaan_lain = document.getElementsByName('_pekerjaan_lain')[0].value;

            if (nama === "") {
                $("input#_fullname").css("color", "#dc3545");
                $("input#_fullname").css("border-color", "#dc3545");
                $('._fullname').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama tidak boleh kosong.</li></ul>');
                return false;
            }
            if (nik === "") {
                $("input#_nik").css("color", "#dc3545");
                $("input#_nik").css("border-color", "#dc3545");
                $('._nik').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK tidak boleh kosong.</li></ul>');
                return false;
            }
            if (kk === "") {
                $("input#_kk").css("color", "#dc3545");
                $("input#_kk").css("border-color", "#dc3545");
                $('._kk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">KK tidak boleh kosong.</li></ul>');
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
            if (jenis_kelamin === "") {
                $("select#_jenis_kelamin").css("color", "#dc3545");
                $("select#_jenis_kelamin").css("border-color", "#dc3545");
                $('._jenis_kelamin').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis kelamin tidak boleh kosong.</li></ul>');
                return false;
            }
            if (pekerjaan === "") {
                $("select#_pekerjaan").css("color", "#dc3545");
                $("select#_pekerjaan").css("border-color", "#dc3545");
                $('._pekerjaan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pekerjaan tidak boleh kosong.</li></ul>');
                return false;
            }

            if (pekerjaan === "lainnya" && pekerjaan_lain === "") {
                $("input#_pekerjaan_lain").css("color", "#dc3545");
                $("input#_pekerjaan_lain").css("border-color", "#dc3545");
                $('._pekerjaan_lain').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pekerjaan lain tidak boleh kosong.</li></ul>');
                return false;
            }
            if (kecamatan === "") {
                $("select#_kecamatan").css("color", "#dc3545");
                $("select#_kecamatan").css("border-color", "#dc3545");
                $('._kecamatan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kecamatan tidak boleh kosong.</li></ul>');
                return false;
            }
            if (kelurahan === "") {
                $("select#_kelurahan").css("color", "#dc3545");
                $("select#_kelurahan").css("border-color", "#dc3545");
                $('._kelurahan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kelurahan tidak boleh kosong.</li></ul>');
                return false;
            }
            if (alamat === "") {
                $("textarea#_alamat").css("color", "#dc3545");
                $("textarea#_alamat").css("border-color", "#dc3545");
                $('._alamat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Alamat tidak boleh kosong.</li></ul>');
                return false;
            }
            if (email === "") {
                $("input#_email").css("color", "#dc3545");
                $("input#_email").css("border-color", "#dc3545");
                $('._email').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Email tidak boleh kosong.</li></ul>');
                return false;
            }
            if (nohp === "") {
                $("input#_nohp").css("color", "#dc3545");
                $("input#_nohp").css("border-color", "#dc3545");
                $('._nohp').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No HP tidak boleh kosong.</li></ul>');
                return false;
            }

            let pekerjaan_fix;
            if (pekerjaan === "lainnya") {
                pekerjaan_fix = pekerjaan_lain;
            } else {
                pekerjaan_fix = pekerjaan;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Akun: <?= $data->fullname ?>",
                showCancelButton: true,
                icon: 'question',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "../portal/editSave",
                        type: 'POST',
                        data: {
                            id: id,
                            nama: nama,
                            nik: nik,
                            kk: kk,
                            tempat_lahir: tempat_lahir,
                            tgl_lahir: tgl_lahir,
                            jenis_kelamin: jenis_kelamin,
                            pekerjaan: pekerjaan_fix,
                            kecamatan: kecamatan,
                            kelurahan: kelurahan,
                            alamat: alamat,
                            email: email,
                            nohp: nohp,
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
<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id_usulan" name="_id_usulan" value="<?= $data->id_usulan ?>" />
        <input type="hidden" id="_id_ptk" name="_id_ptk" value="<?= $data->id_pengawas ?>" />
        <input type="hidden" id="_id_tahun_tw" name="_id_tahun_tw" value="<?= $data->id_tahun_tw ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <h4>Data Pada Usulan</h4>
            <div class="mb-3">
                <label for="_us_pang_jenis" class="form-label">Usulan Jenis (Pangkat / KGB)</label>
                <select class="form-control us_pang_jenis" id="_us_pang_jenis" name="_us_pang_jenis" required>
                    <option value="pangkat" <?= $data->us_pang_jenis == "pangkat" ? ' selected' : '' ?>>Pangkat</option>
                    <option value="kgb" <?= $data->us_pang_jenis == "kgb" ? ' selected' : '' ?>>KGB</option>
                </select>
                <div class="help-block _us_pang_jenis"></div>
            </div>
            <div class="mb-3">
                <label for="_us_pang_golongan" class="form-label">Pangkat Golongan</label>
                <input type="text" class="form-control us_pang_golongan" value="<?= $data->us_pang_golongan ?>" id="_us_pang_golongan" name="_us_pang_golongan" placeholder="Pangkat Golonga Usulan..." onfocusin="inputFocus(this);">
                <div class="help-block _us_pang_golongan"></div>
            </div>
            <div class="mb-3">
                <label for="_us_pang_tmt" class="form-label">TMT</label>
                <input type="date" class="form-control us_pang_tmt" value="<?= $data->us_pang_tmt ?>" id="_us_pang_tmt" name="_us_pang_tmt" onfocusin="inputFocus(this);">
                <div class="help-block _us_pang_tmt"></div>
            </div>
            <div class="mb-3">
                <label for="_us_pang_tgl" class="form-label">Tanggal SK</label>
                <input type="date" class="form-control us_pang_tgl" value="<?= $data->us_pang_tgl ?>" id="_us_pang_tgl" name="_us_pang_tgl" onfocusin="inputFocus(this);">
                <div class="help-block _us_pang_tgl"></div>
            </div>
            <div class="mb-3">
                <label for="_us_pang_mk_tahun" class="form-label">MK Tahun</label>
                <input type="number" class="form-control us_pang_mk_tahun" value="<?= $data->us_pang_mk_tahun ?>" id="_us_pang_mk_tahun" name="_us_pang_mk_tahun" onfocusin="inputFocus(this);">
                <div class="help-block _us_pang_mk_tahun"></div>
            </div>
            <div class="mb-3">
                <label for="_us_pang_mk_bulan" class="form-label">MK Bulan</label>
                <input type="number" class="form-control us_pang_mk_bulan" value="<?= $data->us_pang_mk_bulan ?>" id="_us_pang_mk_bulan" name="_us_pang_mk_bulan" onfocusin="inputFocus(this);">
                <div class="help-block _us_pang_mk_bulan"></div>
            </div>
            <div class="mb-3">
                <label for="_us_gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="number" class="form-control us_gaji_pokok" value="<?= $data->us_gaji_pokok ?>" id="_us_gaji_pokok" name="_us_gaji_pokok" onfocusin="inputFocus(this);">
                <div class="help-block _us_gaji_pokok"></div>
            </div>

            <hr />
            <h4 class="mt-4">Data Pada Atribut</h4>
            <div class="mb-3">
                <label for="_attr_pang_jenis" class="form-label">Attribut Jenis (Pangkat / KGB)</label>
                <select class="form-control attr_pang_jenis" id="_attr_pang_jenis" name="_attr_pang_jenis" required>
                    <option value="pangkat" <?= $data->attr_pang_jenis == "pangkat" ? ' selected' : '' ?>>Pangkat</option>
                    <option value="kgb" <?= $data->attr_pang_jenis == "kgb" ? ' selected' : '' ?>>KGB</option>
                </select>
                <div class="help-block _attr_pang_jenis"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_golongan" class="form-label">Attribut Pangkat Golongan</label>
                <input type="text" class="form-control attr_pang_golongan" value="<?= $data->attr_pang_golongan ?>" id="_attr_pang_golongan" name="_attr_pang_golongan" placeholder="Pangkat Golonga Usulan..." onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_golongan"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_no" class="form-label">Attribut No SK</label>
                <input type="text" class="form-control attr_pang_no" value="<?= $data->attr_pang_no ?>" id="_attr_pang_no" name="_attr_pang_no" onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_no"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_tmt" class="form-label">Attribut TMT</label>
                <input type="date" class="form-control attr_pang_tmt" value="<?= $data->attr_pang_tmt ?>" id="_attr_pang_tmt" name="_attr_pang_tmt" onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_tmt"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_tgl" class="form-label">Attribut Tanggal SK</label>
                <input type="date" class="form-control attr_pang_tgl" value="<?= $data->attr_pang_tgl ?>" id="_attr_pang_tgl" name="_attr_pang_tgl" onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_tgl"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_mk_tahun" class="form-label">Attribut MK Tahun</label>
                <input type="number" class="form-control attr_pang_mk_tahun" value="<?= $data->attr_pang_mk_tahun ?>" id="_attr_pang_mk_tahun" name="_attr_pang_mk_tahun" onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_mk_tahun"></div>
            </div>
            <div class="mb-3">
                <label for="_attr_pang_mk_bulan" class="form-label">Attribut MK Bulan</label>
                <input type="number" class="form-control attr_pang_mk_bulan" value="<?= $data->attr_pang_mk_bulan ?>" id="_attr_pang_mk_bulan" name="_attr_pang_mk_bulan" onfocusin="inputFocus(this);">
                <div class="help-block _attr_pang_mk_bulan"></div>
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
            const id_usulan = document.getElementsByName('_id_usulan')[0].value;
            const id_ptk = document.getElementsByName('_id_ptk')[0].value;
            const id_tahun_tw = document.getElementsByName('_id_tahun_tw')[0].value;

            const us_pang_jenis = document.getElementsByName('_us_pang_jenis')[0].value;
            const us_pang_golongan = document.getElementsByName('_us_pang_golongan')[0].value;
            const us_pang_tmt = document.getElementsByName('_us_pang_tmt')[0].value;
            const us_pang_tgl = document.getElementsByName('_us_pang_tgl')[0].value;
            const us_pang_mk_tahun = document.getElementsByName('_us_pang_mk_tahun')[0].value;
            const us_pang_mk_bulan = document.getElementsByName('_us_pang_mk_bulan')[0].value;
            const us_gaji_pokok = document.getElementsByName('_us_gaji_pokok')[0].value;

            const attr_pang_jenis = document.getElementsByName('_attr_pang_jenis')[0].value;
            const attr_pang_golongan = document.getElementsByName('_attr_pang_golongan')[0].value;
            const attr_pang_no = document.getElementsByName('_attr_pang_no')[0].value;
            const attr_pang_tmt = document.getElementsByName('_attr_pang_tmt')[0].value;
            const attr_pang_tgl = document.getElementsByName('_attr_pang_tgl')[0].value;
            const attr_pang_mk_tahun = document.getElementsByName('_attr_pang_mk_tahun')[0].value;
            const attr_pang_mk_bulan = document.getElementsByName('_attr_pang_mk_bulan')[0].value;

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data PTK Pada Usulan Yang Sudah Lolosberkas: <?= $data->nama ?>",
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
                            id_usulan: id_usulan,
                            id_ptk: id_ptk,
                            id_tahun_tw: id_tahun_tw,
                            us_pang_jenis: us_pang_jenis,
                            us_pang_golongan: us_pang_golongan,
                            us_pang_tmt: us_pang_tmt,
                            us_pang_tgl: us_pang_tgl,
                            us_pang_mk_tahun: us_pang_mk_tahun,
                            us_pang_mk_bulan: us_pang_mk_bulan,
                            us_gaji_pokok: us_gaji_pokok,
                            attr_pang_jenis: attr_pang_jenis,
                            attr_pang_golongan: attr_pang_golongan,
                            attr_pang_no: attr_pang_no,
                            attr_pang_tmt: attr_pang_tmt,
                            attr_pang_tgl: attr_pang_tgl,
                            attr_pang_mk_tahun: attr_pang_mk_tahun,
                            attr_pang_mk_bulan: attr_pang_mk_bulan,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.modal-content-loading-edit').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.modal-content-loading-edit').unblock();

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
                            $('div.modal-content-loading-edit').unblock();
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
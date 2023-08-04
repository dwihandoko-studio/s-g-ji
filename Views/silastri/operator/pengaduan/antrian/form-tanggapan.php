<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <label class="col-form-label">Uraian Pengaduan:</label>
            <textarea rows="5" class="form-control" id="_uraian_pengaduan" name="_uraian_pengaduan" readonly><?= $data->uraian_aduan ?></textarea>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Permasalahan:</label>
            <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" required></textarea>
            <div class="help-block _permasalahan"></div>
        </div>
        <div class="col-lg-6">
            <div class="row mb-2">
                <label for="_teruskan_ke" class="col-sm-3 col-form-label">Teruskan Ke Bidang :</label>
                <div class="col-sm-8">
                    <select class="form-control select2 teruskan_ke" id="_teruskan_ke" name="_teruskan_ke" style="width: 100%">
                        <option value=""> --- Pilih Bidang --- </option>
                        <?php if (isset($bidangs)) { ?>
                            <?php if (count($bidangs) > 0) { ?>
                                <?php foreach ($bidangs as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->bidang ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _teruskan_ke"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="teruskanPengaduan(this)" class="btn btn-primary waves-effect waves-light">Teruskan Pengaduan</button>
    </div>
    <script>
        function teruskanPengaduan(e) {
            const uraian = document.getElementsByName('_uraian_pengaduan')[0].value;
            const permasalahan = document.getElementsByName('_permasalahan')[0].value;
            const teruskan_ke = document.getElementsByName('_teruskan_ke')[0].value;
            if (uraian === "" || uraian === undefined) {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Uraian aduan tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            if (permasalahan === "" || permasalahan === undefined) {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Permasalahan tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            if (teruskan_ke === "") {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Diteruskan ke tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            $.ajax({
                url: "./teruskan",
                type: 'POST',
                data: {
                    id: '<?= $data->id ?>',
                    nama: '<?= str_replace('&#039;', "`", str_replace("'", "`", $nama)) ?>',
                    permasalahan: permasalahan,
                    teruskan_ke: teruskan_ke,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading-approve').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading-approve').unblock();

                    if (resul.status !== 200) {
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
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage(resul.redirrect);
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // e.attr('disabled', false);
                    e.disabled = false
                    $('div.modal-content-loading-approve').unblock();
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
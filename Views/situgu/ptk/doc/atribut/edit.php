<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <p class="mb-4">Untuk infomasi penginputan Data Inpassing, Silahkan lihat di Info GTK terlebih dahulu. </p>
            <div class="mb-3">
                <label for="_pangkat" class="form-label">Pangkat Inpassing</label>
                <select class="form-control _pangkat" id="_pangkat" name="_pangkat" required>
                    <option value="">--Pilih--</option>
                    <?php if (isset($pangkats)) {
                        if (count($pangkats) > 0) {
                            foreach ($pangkats as $key => $value) { ?>
                                <option value="<?= $value->pangkat ?>" <?= $data->pang_golongan == $value->pangkat ? ' selected' : '' ?>><?= $value->pangkat ?></option>
                    <?php }
                        }
                    } ?>
                </select>
                <div class="help-block _pangkat"></div>
            </div>
            <div class="mb-3">
                <label for="_no_sk" class="form-label">No SK Inpassing</label>
                <input type="text" class="form-control no_sk" value="<?= $data->pang_no ?>" id="_no_sk" name="_no_sk" placeholder="No SK Inpassing..." onfocusin="inputFocus(this);">
                <div class="help-block _no_sk"></div>
            </div>
            <div class="mb-3">
                <label for="_mkt_pangkat" class="form-label">Masa Kerja Tahun Inpassing</label>
                <input type="number" class="form-control mkt-pangkat" value="<?= $data->pang_tahun ?>" id="_mkt_pangkat" name="_mkt_pangkat" onfocusin="inputFocus(this);">
                <div class="help-block _mkt_pangkat"></div>
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
            const pangkat = document.getElementsByName('_pangkat')[0].value;
            const no_sk = document.getElementsByName('_no_sk')[0].value;
            const mkt_pangkat = document.getElementsByName('_mkt_pangkat')[0].value;
            if (pangkat === "") {
                $("select#_pangkat").css("color", "#dc3545");
                $("select#_pangkat").css("border-color", "#dc3545");
                $('._nrg').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih pangkat golongan.</li></ul>');
                return false;
            }
            if (no_sk === "") {
                $("input#_no_sk").css("color", "#dc3545");
                $("input#_no_sk").css("border-color", "#dc3545");
                $('._no_sk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan isi no SK Inpassing.</li></ul>');
                return false;
            }
            if (mkt_pangkat === "") {
                $("input#_mkt_pangkat").css("color", "#dc3545");
                $("input#_mkt_pangkat").css("border-color", "#dc3545");
                $('._mkt_pangkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan isi masa kerja.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Data Inpassing PTK",
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
                            pangkat: pangkat,
                            no_sk: no_sk,
                            mkt_pangkat: mkt_pangkat,
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
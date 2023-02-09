<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $data->jid ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_name" class="col-form-label">Tingkat Jabatan:</label>
                <select class="form-control" onchange="changeTingkat(this)" id="_tingkat" name="_tingkat" required>
                    <option value="">--Pilih--</option>
                    <option value="1" <?= (int)$data->tingkat === 1 ? ' selected' : '' ?>>Kepala</option>
                    <option value="2" <?= (int)$data->tingkat === 2 ? ' selected' : '' ?>>Sekertaris</option>
                    <option value="3" <?= (int)$data->tingkat === 3 ? ' selected' : '' ?>>Kabid / Setingkat Kabid</option>
                    <option value="4" <?= (int)$data->tingkat === 4 ? ' selected' : '' ?>>Kasi / Setingkat Kasi</option>
                    <option value="5" <?= (int)$data->tingkat === 5 ? ' selected' : '' ?>>Staff / Setingkat Staff</option>
                    <option value="6" <?= (int)$data->tingkat === 6 ? ' selected' : '' ?>>TKS</option>
                </select>
                <div class="help-block _tingkat"></div>
            </div>
            <div class="mb-3 _parent-block">
                <label for="_name" class="col-form-label">Parent Jabatan:</label>
                <select class="form-control parent-jabatan" id="_parent" name="_parent" style="width: 100%">
                    <option value="">&nbsp;</option>
                    <?php if (isset($parents)) {
                        if (count($parents) > 0) {
                            foreach ($parents as $key => $value) { ?>
                                <option value="<?= $value->jid ?>" <?= $data->parent !== null ? ((int)$data->parent === (int)$value->jid ? ' selected' : '') : '' ?>><?= $value->jabatan ?></option>
                    <?php }
                        }
                    } ?>
                </select>
                <div class="help-block _parent"></div>
            </div>
            <div class="mb-3">
                <label for="_name" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control name" value="<?= $data->jabatan ?>" id="_name" name="_name" placeholder="Nama jabatan..." onfocusin="inputFocus(this);">
                <div class="help-block _name"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        initSelect2("_parent", ".content-detailModal");

        function changeTingkat(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getParent',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('div._parent-block').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(msg) {
                        $('div._parent-block').unblock();
                        if (msg.status == 200) {
                            let html = "";
                            html += '<option value="">&nbsp;</option>';
                            if (msg.data.length > 0) {
                                for (let step = 0; step < msg.data.length; step++) {
                                    html += '<option value="';
                                    html += msg.data[step].jid;
                                    html += '">';
                                    html += msg.data[step].jabatan;
                                    html += '</option>';
                                }

                            }

                            $('.parent-jabatan').html(html);
                        }
                    },
                    error: function(data) {
                        $('div._parent-block').unblock();
                    }
                })
            }
        }


        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const name = document.getElementsByName('_name')[0].value;
            const tingkat = document.getElementsByName('_tingkat')[0].value;
            const parent = document.getElementsByName('_parent')[0].value;

            if (tingkat === "") {
                $("select#_tingkat").css("color", "#dc3545");
                $("select#_tingkat").css("border-color", "#dc3545");
                $('._tingkat').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tingkat jabatan.</li></ul>');
                return false;
            }
            if (name === "") {
                $("input#_name").css("color", "#dc3545");
                $("input#_name").css("border-color", "#dc3545");
                $('._name').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama kategori tidak boleh kosong.</li></ul>');
                return false;
            }

            Swal.fire({
                title: 'Apakah anda yakin ingin mengupdate data ini?',
                text: "Update Jabatan: <?= $data->jabatan ?>",
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
                            name: name,
                            tingkat: tingkat,
                            parent: parent,
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
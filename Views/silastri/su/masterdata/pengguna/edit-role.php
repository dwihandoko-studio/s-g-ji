<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $data->id ?>" id="_id" name="_id" />
        <div class="modal-body loading-get-data">
            <div class="row">
                <div class="col-lg-12">
                    <label for="_fullname" class="col-form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control fullname" value="<?= $data->fullname ?>" id="_fullname" name="_fullname" placeholder="Fullname..." onfocusin="inputFocus(this);" readonly />
                    <div class="help-block _fullname"></div>
                </div>
                <div class="col-lg-12">
                    <label for="_nik" class="col-form-label">NIK:</label>
                    <input type="text" class="form-control nik" value="<?= $data->email ?>" id="_nik" name="_nik" placeholder="NIK..." onfocusin="inputFocus(this);" readonly />
                    <div class="help-block _nik"></div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="_role" class="col-form-label">Pilih Role:</label>
                        <select class="form-control select2" id="_role" name="_role" style="width: 100%" required>
                            <option value="">&nbsp;</option>
                            <?php if (isset($roles)) {
                                if (count($roles) > 0) {
                                    foreach ($roles as $key => $value) { ?>
                                        <option value="<?= $value->id ?>" <?= $value->id == $data->role_user ? ' selected' : '' ?>><?= $value->role ?></option>
                            <?php }
                                }
                            } ?>
                        </select>
                        <div class="help-block _role"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-8">
                <div>
                    <progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress>
                </div>
                <div>
                    <h3 id="status" style="font-size: 15px; margin: 8px auto;"></h3>
                </div>
                <div>
                    <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
                </div>
            </div>
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
        </div>
    </form>

    <script>
        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const fullname = document.getElementsByName('_fullname')[0].value;
            const nik = document.getElementsByName('_nik')[0].value;
            const role = document.getElementsByName('_role')[0].value;

            if (fullname === "") {
                $("input#_fullname").css("color", "#dc3545");
                $("input#_fullname").css("border-color", "#dc3545");
                $('._fullname').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Fullname tidak boleh kosong.</li></ul>');
                return false;
            }

            if (role === "") {
                $("select#_role").css("color", "#dc3545");
                $("select#_role").css("border-color", "#dc3545");
                $('._role').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih role pengguna.</li></ul>');
                return false;
            }

            const formUpload = new FormData();

            formUpload.append('id', id);
            formUpload.append('role', role);

            $.ajax({
                xhr: function() {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                            var percent = (evt.loaded / evt.total) * 100;
                            ambilId("progressBar").value = Math.round(percent);
                            // ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                        }
                    }, false);
                    return xhr;
                },
                url: "./editSaveRole",
                type: 'POST',
                data: formUpload,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                beforeSend: function() {
                    ambilId("progressBar").style.display = "block";
                    // ambilId("status").innerHTML = "Mulai mengupload . . .";
                    ambilId("status").style.color = "blue";
                    ambilId("progressBar").value = 0;
                    ambilId("loaded_n_total").innerHTML = "";
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

                    if (resul.status !== 200) {
                        ambilId("status").innerHTML = "";
                        ambilId("status").style.color = "red";
                        ambilId("progressBar").value = 0;
                        ambilId("loaded_n_total").innerHTML = "";
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
                        ambilId("status").innerHTML = "";
                        ambilId("status").style.color = "green";
                        ambilId("progressBar").value = 100;
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    ambilId("status").innerHTML = "";
                    ambilId("status").style.color = "red";
                    $('div.modal-content-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        });
    </script>
<?php } ?>
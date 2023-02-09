<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post" enctype="multipart/form-data">
        <input type="hidden" id="_id" name="_id" value="<?= $data->uid ?>">
        <input type="hidden" id="_old_image" name="_old_image" value="<?= $data->image ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <label for="_fullname" class="col-form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control fullname" value="<?= $data->fullname ?>" id="_fullname" name="_fullname" placeholder="Fullname..." onfocusin="inputFocus(this);" required />
                    <div class="help-block _fullname"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_nip" class="col-form-label">NIP / NIK:</label>
                    <input type="number" class="form-control nip" value="<?= $data->nip ?>" id="_nip" name="_nip" placeholder="NIP / NIK..." onfocusin="inputFocus(this);" required />
                    <div class="help-block _nip"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_email" class="col-form-label">E-mail:</label>
                    <input type="email" class="form-control email" value="<?= $data->email ?>" id="_email" name="_email" placeholder="E-mail..." onfocusin="inputFocus(this);" required />
                    <div class="help-block _email"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_nohp" class="col-form-label">No Handphone:</label>
                    <input type="tel" class="form-control nohp" value="<?= $data->no_hp ?>" id="_nohp" name="_nohp" placeholder="+62..." onfocusin="inputFocus(this);" required />
                    <div class="help-block _nohp"></div>
                </div>
                <div class="col-lg-12">
                    <label for="_alamat" class="col-form-label">Alamat:</label>
                    <textarea rows="2" id="_alamat" class="form-control alamat" name="_alamat"><?= $data->alamat ?></textarea>
                </div>
                <div class="col-lg-12 mt-4">
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label for="_file" class="form-label">Foto: </label>
                                <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*" onchange="loadFileImage()">
                                <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Images</code> and Maximum File Size <code>500 Kb</code></p>
                                <div class="help-block _file" for="_file"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="preview-image-upload">
                                    <?php if ($data->image !== null) { ?>
                                        <img class="imagePreviewUpload" src="<?= base_url('uploads/user') . '/' . $data->image ?>" id="imagePreviewUpload" />
                                    <?php } else { ?>
                                        <img class="imagePreviewUpload" id="imagePreviewUpload" />
                                    <?php } ?>
                                    <button type="button" class="btn-remove-preview-image">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-end">
                    <h5 class="font-size-14 mb-3">Status Aktif</h5>
                    <div>
                        <input type="checkbox" id="status_publikasi" name="status_publikasi" switch="success" <?= (int)$data->is_active === 1 ? ' checked' : '' ?> />
                        <label for="status_publikasi" data-on-label="Yes" data-off-label="No"></label>
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
            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
        </div>
    </form>

    <script>
        function loadFileImage() {
            const input = document.getElementsByName('_file')[0];
            if (input.files && input.files[0]) {
                var file = input.files[0];

                var mime_types = ['image/jpg', 'image/jpeg', 'image/png'];

                if (mime_types.indexOf(file.type) == -1) {
                    input.value = "";
                    $('.imagePreviewUpload').attr('src', '');
                    Swal.fire(
                        'Warning!!!',
                        "Hanya file type gambar yang diizinkan.",
                        'warning'
                    );
                    return false;
                }

                if (file.size > 1 * 512 * 1000) {
                    input.value = "";
                    $('.imagePreviewUpload').attr('src', '');
                    Swal.fire(
                        'Warning!!!',
                        "Ukuran file tidak boleh lebih dari 500 Kb.",
                        'warning'
                    );
                    return false;
                }

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.imagePreviewUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                console.log("failed Load");
            }
        }

        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const old_image = document.getElementsByName('_old_image')[0].value;
            const fullname = document.getElementsByName('_fullname')[0].value;
            const nip = document.getElementsByName('_nip')[0].value;
            const email = document.getElementsByName('_email')[0].value;
            const nohp = document.getElementsByName('_nohp')[0].value;
            const alamat = document.getElementsByName('_alamat')[0].value;
            const fileName = document.getElementsByName('_file')[0].value;

            let status;
            if ($('#status_publikasi').is(":checked")) {
                status = "1";
            } else {
                status = "0";
            }

            if (fullname === "") {
                $("input#_fullname").css("color", "#dc3545");
                $("input#_fullname").css("border-color", "#dc3545");
                $('._fullname').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Fullname tidak boleh kosong.</li></ul>');
                return false;
            }

            if (fullname.length < 3) {
                $("input#_fullname").css("color", "#dc3545");
                $("input#_fullname").css("border-color", "#dc3545");
                $('._fullname').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Fullname minimal 3 karakter.</li></ul>');
                return false;
            }

            if (nip === "") {
                $("input#_nip").css("color", "#dc3545");
                $("input#_nip").css("border-color", "#dc3545");
                $('._nip').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NIP/NIK tidak boleh kosong.</li></ul>');
                return false;
            }

            if (nip.length < 16) {
                $("input#_nip").css("color", "#dc3545");
                $("input#_nip").css("border-color", "#dc3545");
                $('._nip').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NIP/NIK minimal 16 karakter.</li></ul>');
                return false;
            }

            if (email === "") {
                $("input#_email").css("color", "#dc3545");
                $("input#_email").css("border-color", "#dc3545");
                $('._email').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Email tidak boleh kosong.</li></ul>');
                return false;
            }

            if (nohp === "") {
                $("input#_nohp").css("color", "#dc3545");
                $("input#_nohp").css("border-color", "#dc3545");
                $('._nohp').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">No Handphone tidak boleh kosong.</li></ul>');
                return false;
            }

            if (nohp.length < 9) {
                $("input#_nohp").css("color", "#dc3545");
                $("input#_nohp").css("border-color", "#dc3545");
                $('._nohp').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">No Handphone minimal 9 karakter.</li></ul>');
                return false;
            }

            if (alamat === "") {
                $("textarea#_alamat").css("color", "#dc3545");
                $("textarea#_alamat").css("border-color", "#dc3545");
                $('._alamat').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Alamat tidak boleh kosong.</li></ul>');
                return false;
            }

            if (old_image === "") {
                if (fileName === "") {
                    Swal.fire(
                        "Peringatan!",
                        "Foto pengguna belum dipilih.",
                        "warning"
                    );
                    return true;
                }
            }

            const formUpload = new FormData();
            if (fileName !== "") {
                const file = document.getElementsByName('_file')[0].files[0];
                formUpload.append('file', file);
            }
            formUpload.append('id', id);
            formUpload.append('nama', fullname);
            formUpload.append('nip', nip);
            formUpload.append('email', email);
            formUpload.append('nohp', nohp);
            formUpload.append('alamat', alamat);
            formUpload.append('status', status);

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
                url: "./editSave",
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
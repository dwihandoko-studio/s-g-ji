<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post" enctype="multipart/form-data">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>">
        <input type="hidden" id="_old_image" name="_old_image" value="<?= $data->image ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <label for="_jenjang" class="col-form-label">Jenjang Sekolah:</label>
                    <select class="form-control" id="_jenjang" name="_jenjang" required>
                        <option value="">--Pilih--</option>
                        <option value="TK" <?= $data->jenjang == "TK" ? ' selected' : '' ?>>TK / PAUD</option>
                        <option value="SD" <?= $data->jenjang == "SD" ? ' selected' : '' ?>>SD</option>
                        <option value="SMP" <?= $data->jenjang == "SMP" ? ' selected' : '' ?>>SMP</option>
                    </select>
                    <div class="help-block _jenjang" for="_jenjang"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_npsn" class="col-form-label">NPSN Sekolah:</label>
                    <input type="text" class="form-control npsn" value="<?= $data->npsn ?>" id="_npsn" name="_npsn" placeholder="NPSN Sekolah..." onfocusin="inputFocus(this);">
                    <div class="help-block _npsn"></div>
                </div>
                <div class="col-lg-12">
                    <label for="_nama" class="col-form-label">Nama Sekolah:</label>
                    <input type="text" class="form-control nama" value="<?= $data->sekolah ?>" id="_nama" name="_nama" placeholder="Nama Sekolah..." onfocusin="inputFocus(this);">
                    <div class="help-block _nama"></div>
                </div>
                <div class="col-lg-12">
                    <label for="_url" class="col-form-label">URL Website Sekolah:</label>
                    <input type="text" class="form-control url" value="<?= $data->url_web ?>" id="_url" name="_url" placeholder="Example: https://sekolah.sch.id" onfocusin="inputFocus(this);">
                    <div class="help-block _url"></div>
                </div>
                <div class="col-lg-12 mt-4">
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="mt-3">
                                <label for="_file" class="form-label">Gambar Berita: </label>
                                <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*" onchange="loadFileImage()">
                                <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Images</code> and Maximum File Size <code>500 Kb</code></p>
                                <div class="help-block _file" for="_file"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <div class="preview-image-upload">
                                    <?php if ($data->image !== null) { ?>
                                        <img class="imagePreviewUpload" src="<?= base_url('uploads/sekolah') . '/' . $data->image ?>" id="imagePreviewUpload" />
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
                    <h5 class="font-size-14 mb-3">Status Publikasi</h5>
                    <div>
                        <input type="checkbox" id="status_publikasi" name="status_publikasi" switch="success" <?= (int)$data->status === 1 ? ' checked' : '' ?> />
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
            const jenjang = document.getElementsByName('_jenjang')[0].value;
            const npsn = document.getElementsByName('_npsn')[0].value;
            const nama = document.getElementsByName('_nama')[0].value;
            const url = document.getElementsByName('_url')[0].value;
            const fileName = document.getElementsByName('_file')[0].value;

            let status;
            if ($('#status_publikasi').is(":checked")) {
                status = "1";
            } else {
                status = "0";
            }

            if (jenjang === "") {
                $("select#_jenjang").css("color", "#dc3545");
                $("select#_jenjang").css("border-color", "#dc3545");
                $('._jenjang').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih jenjang dulu.</li></ul>');
                return false;
            }

            if (npsn === "") {
                $("input#_npsn").css("color", "#dc3545");
                $("input#_npsn").css("border-color", "#dc3545");
                $('._npsn').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NPSN Sekolah tidak boleh kosong.</li></ul>');
                return false;
            }

            if (npsn.length !== 8) {
                $("input#_npsn").css("color", "#dc3545");
                $("input#_npsn").css("border-color", "#dc3545");
                $('._npsn').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NPSN Sekolah tidak valid.</li></ul>');
                return false;
            }

            if (nama === "") {
                $("input#_nama").css("color", "#dc3545");
                $("input#_nama").css("border-color", "#dc3545");
                $('._nama').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama sekolah tidak boleh kosong.</li></ul>');
                return false;
            }

            if (url === "") {
                $("input#_url").css("color", "#dc3545");
                $("input#_url").css("border-color", "#dc3545");
                $('._url').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">URL Website sekolah tidak boleh kosong.</li></ul>');
                return false;
            }

            if (old_image === "") {
                if (fileName === "") {
                    Swal.fire(
                        "Peringatan!",
                        "Gambar berita belum dipilih.",
                        "warning"
                    );
                    return true;
                }
            }

            const formUpload = new FormData();
            if (fileName !== "") {
                const file = document.getElementsByName('_file')[0].files[0];
                formUpload.append('_file', file);
            }
            formUpload.append('id', id);
            formUpload.append('jenjang', jenjang);
            formUpload.append('npsn', npsn);
            formUpload.append('sekolah', nama);
            formUpload.append('url', url);
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
<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post" enctype="multipart/form-data">
        <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-10">
                    <label for="_judul" class="col-form-label">Nama Menu Publik:</label>
                    <input type="text" class="form-control judul" value="<?= $data->judul ?>" id="_judul" name="_judul" placeholder="Nama menu publik..." onfocusin="inputFocus(this);">
                    <div class="help-block _judul"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_urut" class="col-form-label">Urutan Tampil Menu:</label>
                    <input type="number" class="form-control urut" value="<?= $data->urut ?>" id="_urut" name="_urut" placeholder="Urutan tampil menu..." onfocusin="inputFocus(this);">
                    <div class="help-block _urut"></div>
                </div>
                <div class="col-lg-6">
                    <label for="_parent" class="col-form-label">Parent Menu:</label>
                    <select class="form-control select2" name="_parent" id="_parent" style="width: 100%" required>
                        <option value="0" <?= (int)$data->parent == 0 ? ' selected' : '' ?>>Utama</option>
                        <?php if (isset($parents)) {
                            if (count($parents) > 0) {
                                foreach ($parents as $key => $val) { ?>
                                    <option value="<?= $val->id ?>" <?= (int)$data->parent == (int)$val->id ? ' selected' : '' ?>><?= $val->judul ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _parent"></div>
                </div>
                <div class="col-lg-12 mt-4 mb-4">
                    <div class="row">
                        <div class="col-lg-2">
                            <h5 class="font-size-14">External Link</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" onchange="changeExternalLink()" type="radio" name="external_link" id="external_link_1" value="1" <?= (int)$data->external_link === 1 ? ' checked' : '' ?>>
                                <label class="form-check-label" for="external_link_1">
                                    Ya
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="font-size-14">&nbsp;</h5>
                            <div class="form-check">
                                <input class="form-check-input" onchange="changeExternalLink()" value="0" type="radio" name="external_link" id="external_link_2" <?= (int)$data->external_link === 1 ? '' : ' checked' ?>>
                                <label class="form-check-label" for="external_link_2">
                                    Tidak (Buat Content Manual)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 url-content-app" style="display: <?= (int)$data->external_link === 1 ? 'block' : 'none' ?>;">
                    <label for="_url_external_link" class="col-form-label">URL External Link:</label>
                    <input type="text" class="form-control url_external_link" value="<?= $data->url ?>" id="_url_external_link" name="_url_external_link" placeholder="Url eksternal link..." onfocusin="inputFocus(this);">
                    <div class="help-block _url_external_link"></div>
                </div>
                <div class="col-lg-12 isi-content-app" style="display: <?= (int)$data->external_link === 1 ? 'none' : 'block' ?>;">
                    <label for="_isi" class="col-form-label">Isi Content:</label>
                    <textarea id="_isi" name="_isi"><?= $data->isi ?></textarea>
                </div>
                <div class="col-lg-12 mt-4 text-end">
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
        ClassicEditor.create(document.querySelector('#_isi'), {
            simpleUpload: {
                uploadUrl: "./uploadImage"
            }
        }).then(editors => {
            editorAdd = editors
        }).catch(error => {
            console.log(error);
        });

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

                if (file.size > 1 * 1024 * 1000) {
                    input.value = "";
                    $('.imagePreviewUpload').attr('src', '');
                    Swal.fire(
                        'Warning!!!',
                        "Ukuran file tidak boleh lebih dari 1 Mb.",
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

        function changeExternalLink() {
            if ($('#external_link_1').is(":checked")) {
                $('.url-content-app').css("display", "block");
                $('.isi-content-app').css("display", "none");
            } else {
                $('.url-content-app').css("display", "none");
                $('.isi-content-app').css("display", "block");
            }
        }

        $("#formEditModalData").on("submit", function(e) {
            e.preventDefault();
            const id = document.getElementsByName('_id')[0].value;
            const judul = document.getElementsByName('_judul')[0].value;
            const urut = document.getElementsByName('_urut')[0].value;
            const parent = document.getElementsByName('_parent')[0].value;
            const url = document.getElementsByName('_url_external_link')[0].value;
            const isi = editorAdd.getData();

            let status;
            if ($('#status_publikasi').is(":checked")) {
                status = "1";
            } else {
                status = "0";
            }

            let externalLink;
            if ($('#external_link_1').is(":checked")) {
                externalLink = "1";
            } else {
                externalLink = "0";
            }

            if (judul === "") {
                $("input#_judul").css("color", "#dc3545");
                $("input#_judul").css("border-color", "#dc3545");
                $('._judul').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama menu tidak boleh kosong.</li></ul>');
                return false;
            }

            if (judul.length < 5) {
                $("input#_judul").css("color", "#dc3545");
                $("input#_judul").css("border-color", "#dc3545");
                $('._judul').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama menu minimal 5 karakter.</li></ul>');
                return false;
            }

            if (judul.length > 50) {
                $("input#_judul").css("color", "#dc3545");
                $("input#_judul").css("border-color", "#dc3545");
                $('._judul').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama menu maksimal 50 karakter.</li></ul>');
                return false;
            }

            if (urut === "") {
                $("input#_urut").css("color", "#dc3545");
                $("input#_urut").css("border-color", "#dc3545");
                $('._urut').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Urutan tampil menu tidak boleh kosong.</li></ul>');
                return false;
            }

            if (externalLink === "1") {
                if (url === "") {
                    $("input#_url_external_link").css("color", "#dc3545");
                    $("input#_url_external_link").css("border-color", "#dc3545");
                    $('._url_external_link').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">External link menu tidak boleh kosong.</li></ul>');
                    return false;
                }
            }

            if (externalLink === "0") {
                if (isi.length < 5) {
                    Swal.fire(
                        "Peringatan!",
                        "Isi dari konten manual minimal 5 kata.",
                        "warning"
                    );
                    return false;
                }
            }

            const formUpload = new FormData();
            formUpload.append('id', id);
            formUpload.append('judul', judul);
            formUpload.append('external_link', externalLink);
            formUpload.append('isi', isi);
            formUpload.append('status', status);
            formUpload.append('urut', urut);
            formUpload.append('parent', parent);
            formUpload.append('url', url);

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
<form id="formAddModalData" action="./website/save" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <label for="_judul" class="col-form-label">Judul:</label>
                <input type="text" value="<?= isset($data) ? ($data->judul !== null ? $data->judul : '') : '' ?>" class="form-control fullname" id="_judul" name="_judul" placeholder="Judul..." onfocusin="inputFocus(this);" required />
                <div class="help-block _judul"></div>
            </div>
            <div class="col-lg-12">
                <label for="_deskripsi" class="col-form-label">Deskripsi:</label>
                <textarea rows="5" class="form-control deskripsi" id="_deskripsi" name="_deskripsi" placeholder="Deskripsi..." onfocusin="inputFocus(this);" required><?= isset($data) ? ($data->deskripsi !== null ? $data->deskripsi : '') : '' ?></textarea>
                <div class="help-block _deskripsi"></div>
            </div>
            <div class="col-lg-12">
                <label for="_alamat" class="col-form-label">Alamat:</label>
                <textarea rows="5" class="form-control alamat" id="_alamat" name="_alamat" placeholder="Alamat..." onfocusin="inputFocus(this);" required><?= isset($data) ? ($data->alamat !== null ? $data->alamat : '') : '' ?></textarea>
                <div class="help-block _alamat"></div>
            </div>
            <div class="col-lg-6">
                <label for="_telp" class="col-form-label">Telp:</label>
                <input type="tel" value="<?= isset($data) ? ($data->telp !== null ? $data->telp : '') : '' ?>" class="form-control nohp" id="_telp" name="_telp" placeholder="0725..." onfocusin="inputFocus(this);" required />
                <div class="help-block _telp"></div>
            </div>
            <div class="col-lg-6">
                <label for="_email" class="col-form-label">E-mail:</label>
                <input type="email" value="<?= isset($data) ? ($data->email !== null ? $data->email : '') : '' ?>" class="form-control email" id="_email" name="_email" placeholder="E-mail..." onfocusin="inputFocus(this);" required />
                <div class="help-block _email"></div>
            </div>
            <div class="col-lg-6">
                <label for="_facebook" class="col-form-label">Facebook:</label>
                <input type="text" value="<?= isset($data) ? ($data->facebook !== null ? $data->facebook : '') : '' ?>" class="form-control email" id="_facebook" name="_facebook" placeholder="Url facebook..." onfocusin="inputFocus(this);" required />
                <div class="help-block _facebook"></div>
            </div>
            <div class="col-lg-6">
                <label for="_twitter" class="col-form-label">Twitter:</label>
                <input type="text" value="<?= isset($data) ? ($data->twitter !== null ? $data->twitter : '') : '' ?>" class="form-control email" id="_twitter" name="_twitter" placeholder="Url twitter..." onfocusin="inputFocus(this);" required />
                <div class="help-block _twitter"></div>
            </div>
            <div class="col-lg-6">
                <label for="_instagram" class="col-form-label">Instagram:</label>
                <input type="text" value="<?= isset($data) ? ($data->instagram !== null ? $data->instagram : '') : '' ?>" class="form-control email" id="_instagram" name="_instagram" placeholder="Url instagram..." onfocusin="inputFocus(this);" required />
                <div class="help-block _instagram"></div>
            </div>
            <div class="col-lg-12">
                <label for="_maps" class="col-form-label">Maps:</label>
                <textarea rows="5" class="form-control maps" id="_maps" name="_maps" placeholder="<iframe></iframe>..." onfocusin="inputFocus(this);" required><?= isset($data) ? ($data->maps !== null ? $data->maps : '') : '' ?></textarea>
                <div class="help-block _maps"></div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="_warna" class="col-form-label">Warna:</label>
                    <input type="text" name="_warna" class="form-control" id="_warna" value="<?= isset($data) ? ($data->warna !== null ? $data->warna : '#daa520') : '#daa520' ?>" required>
                    <div class="help-block _warna"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mb-3">
                    <label for="_thema" class="col-form-label">Thema:</label>
                    <select class="form-control" id="_thema" name="_thema" onchange="changeTingkat(this)" required>
                        <option value="thema1" <?= isset($data) ? ($data->thema !== null ? ($data->thema == "thema1" ? ' selected' : ' selected') : ' selected') : ' selected' ?>>Thema 1</option>
                    </select>
                    <div class="help-block _thema"></div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Foto Pegawai: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/png" onchange="loadFileImage()" required>
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="png">Images</code> and Maximum File Size <code>200 Kb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mt-4">
                            <div class="preview-image-upload mt-4">
                                <?php if (isset($data)) {
                                    if ($data->logo !== null) { ?>
                                        <img class="imagePreviewUpload" src="<?= base_url('uploads') . '/' . $data->logo ?>" id="imagePreviewUpload" />
                                    <?php } else { ?>
                                        <img class="imagePreviewUpload" id="imagePreviewUpload" />
                                    <?php } ?>
                                <?php } else { ?>
                                    <img class="imagePreviewUpload" id="imagePreviewUpload" />
                                <?php } ?>
                                <button type="button" class="btn-remove-preview-image">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <label for="_css_map_googleapis" class="col-form-label">CSS Map Googleapis:</label>
                <textarea rows="3" class="form-control css-map-googleapis" id="_css_map_googleapis" name="_css_map_googleapis" placeholder="Link css..." onfocusin="inputFocus(this);" required><?= isset($data) ? ($data->css_map_googleapis !== null ? $data->css_map_googleapis : '') : '' ?></textarea>
                <div class="help-block _css_map_googleapis"></div>
            </div>
            <div class="col-lg-6">
                <label for="_js_map_googleapis" class="col-form-label">JS Map Googleapis:</label>
                <textarea rows="3" class="form-control js-map-googleapis" id="_js_map_googleapis" name="_js_map_googleapis" placeholder="Link js..." onfocusin="inputFocus(this);" required><?= isset($data) ? ($data->js_map_googleapis !== null ? $data->js_map_googleapis : '') : '' ?></textarea>
                <div class="help-block _js_map_googleapis"></div>
            </div>
            <div class="col-lg-12 text-end">
                <h5 class="font-size-14 mb-3">Status Maintenance</h5>
                <div>
                    <input type="checkbox" id="status_publikasi" name="status_publikasi" switch="success" <?= isset($data) ? ((int)$data->maintenance === 1 ? ' checked' : '') : '' ?> />
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
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    $("#_warna").spectrum({
        showPaletteOnly: !0,
        showPalette: !0,
        color: "#daa520",
        palette: [
            ["#4169e1", "#8a2be2", "#daa520", "#72b626", "#ff00ff", "#fa5b0f", "#6957af", "#ff0000", "#ffb400", "#9acd32"],
        ],
    });

    function loadFileImage() {
        const input = document.getElementsByName('_file')[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var mime_types = ['image/png'];

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

            if (file.size > 1 * 256 * 1000) {
                input.value = "";
                $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 200 Kb.",
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

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const judul = document.getElementsByName('_judul')[0].value;
        const deskripsi = document.getElementsByName('_deskripsi')[0].value;
        const alamat = document.getElementsByName('_alamat')[0].value;
        const telp = document.getElementsByName('_telp')[0].value;
        const email = document.getElementsByName('_email')[0].value;
        const facebook = document.getElementsByName('_facebook')[0].value;
        const twitter = document.getElementsByName('_twitter')[0].value;
        const instagram = document.getElementsByName('_instagram')[0].value;
        const maps = document.getElementsByName('_maps')[0].value;
        const warna = document.getElementsByName('_warna')[0].value;
        const thema = document.getElementsByName('_thema')[0].value;
        const css_map_googleapis = document.getElementsByName('_css_map_googleapis')[0].value;
        const js_map_googleapis = document.getElementsByName('_js_map_googleapis')[0].value;
        const fileName = document.getElementsByName('_file')[0].value;

        let status;
        if ($('#status_publikasi').is(":checked")) {
            status = "1";
        } else {
            status = "0";
        }

        if (judul === "") {
            $("input#_judul").css("color", "#dc3545");
            $("input#_judul").css("border-color", "#dc3545");
            $('._judul').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Judul tidak boleh kosong.</li></ul>');
            return false;
        }

        if (deskripsi === "") {
            $("textarea#_deskripsi").css("color", "#dc3545");
            $("textarea#_deskripsi").css("border-color", "#dc3545");
            $('._deskripsi').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Deskripsi tidak boleh kosong.</li></ul>');
            return false;
        }

        if (alamat === "") {
            $("textarea#_alamat").css("color", "#dc3545");
            $("textarea#_alamat").css("border-color", "#dc3545");
            $('._alamat').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Deskripsi tidak boleh kosong.</li></ul>');
            return false;
        }

        if (telp === "") {
            $("input#_telp").css("color", "#dc3545");
            $("input#_telp").css("border-color", "#dc3545");
            $('._telp').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Telp tidak boleh kosong.</li></ul>');
            return false;
        }

        if (email === "") {
            $("input#_email").css("color", "#dc3545");
            $("input#_email").css("border-color", "#dc3545");
            $('._email').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Email tidak boleh kosong.</li></ul>');
            return false;
        }

        if (facebook === "") {
            $("input#_facebook").css("color", "#dc3545");
            $("input#_facebook").css("border-color", "#dc3545");
            $('._facebook').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Facebook tidak boleh kosong.</li></ul>');
            return false;
        }

        if (twitter === "") {
            $("input#_twitter").css("color", "#dc3545");
            $("input#_twitter").css("border-color", "#dc3545");
            $('._twitter').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Twitter tidak boleh kosong.</li></ul>');
            return false;
        }

        if (instagram === "") {
            $("input#_instagram").css("color", "#dc3545");
            $("input#_instagram").css("border-color", "#dc3545");
            $('._instagram').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Instagram tidak boleh kosong.</li></ul>');
            return false;
        }

        if (maps === "") {
            $("textarea#_maps").css("color", "#dc3545");
            $("textarea#_maps").css("border-color", "#dc3545");
            $('._maps').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Maps tidak boleh kosong.</li></ul>');
            return false;
        }

        if (warna === "") {
            $("select#_warna").css("color", "#dc3545");
            $("select#_warna").css("border-color", "#dc3545");
            $('._warna').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih warna.</li></ul>');
            return false;
        }

        if (thema === "") {
            $("select#_thema").css("color", "#dc3545");
            $("select#_thema").css("border-color", "#dc3545");
            $('._thema').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih thema.</li></ul>');
            return false;
        }

        if (css_map_googleapis === "") {
            $("textarea#_css_map_googleapis").css("color", "#dc3545");
            $("textarea#_css_map_googleapis").css("border-color", "#dc3545");
            $('._css_map_googleapis').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">CSS Map googleapis tidak boleh kosong.</li></ul>');
            return false;
        }

        if (js_map_googleapis === "") {
            $("textarea#_js_map_googleapis").css("color", "#dc3545");
            $("textarea#_js_map_googleapis").css("border-color", "#dc3545");
            $('._js_map_googleapis').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">JS Map googleapis tidak boleh kosong.</li></ul>');
            return false;
        }

        const formUpload = new FormData();
        if (fileName !== "") {
            const file = document.getElementsByName('_file')[0].files[0];
            formUpload.append('_file', file);
        }
        formUpload.append('judul', judul);
        formUpload.append('deskripsi', deskripsi);
        formUpload.append('alamat', alamat);
        formUpload.append('telp', telp);
        formUpload.append('email', email);
        formUpload.append('facebook', facebook);
        formUpload.append('twitter', twitter);
        formUpload.append('instagram', instagram);
        formUpload.append('maps', maps);
        formUpload.append('warna', warna);
        formUpload.append('thema', thema);
        formUpload.append('js_map_googleapis', js_map_googleapis);
        formUpload.append('css_map_googleapis', css_map_googleapis);
        formUpload.append('maintenance', status);

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
            url: "./website/save",
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
                    // ambilId("status").innerHTML = "gagal";
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
                    // ambilId("status").innerHTML = resul.message;
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
                // ambilId("status").innerHTML = "Upload Failed";
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
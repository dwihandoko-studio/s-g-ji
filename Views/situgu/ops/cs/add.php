<form id="formAddModalData" action="./addSave" method="post" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <!-- <div class="mb-3"> -->
                <label class="col-form-label">Jenis Aduan: </label>
                <select class="form-control select2" name="_jenis" id="_jenis" style="width: 100%" required>
                    <option value="">-- Pilih --</option>
                    <option value="tarik-data">Tarik Data</option>
                    <option value="riwayat-sertifikasi">Riwayat Sertifikasi</option>
                    <option value="riwayat-pangkat">Riwayat Pangkat / Berkala</option>
                    <option value="akun-ptk">Akun PTK</option>
                    <option value="jumlah-ptk">Jumlah PTK</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <!-- </div> -->
                <div class="help-block _jenis" for="_jenis"></div>
            </div>
            <div class="col-lg-6">
                <label for="_npsn" class="col-form-label">NPSN:</label>
                <input type="text" class="form-control npsn" id="_npsn" name="_npsn" placeholder="NPSN Sekolah..." onfocusin="inputFocus(this);">
                <div class="help-block _npsn"></div>
            </div>
            <div class="col-lg-12">
                <div class="mt-3">
                    <label class="form-label">Pilih PTK: </label>
                    <select class="select2 form-control select2-multiple" style="width: 100%" id="_ptks" name="_ptks[]" multiple="multiple" data-placeholder="Pilih PTK ...">
                        <?php
                        if (isset($ptks)) {
                            if (count($ptks) > 0) {
                                foreach ($ptks as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?> - <?= $value->nuptk ?? "-" ?></option>
                        <?php }
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="help-block _ptks" for="_ptks"></div>
            </div>
            <div class="col-lg-12">
                <label for="_isi" class="col-form-label">Deskripsi Aduan:</label>
                <textarea class="form-control isi" id="_isi" name="_isi" placeholder="Deskripsi..." onfocusin="inputFocus(this);"></textarea>
                <div class="help-block _isi"></div>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Screenshot: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="image/*" onchange="loadFileImage()">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg">Images</code> and Maximum File Size <code>500 Kb</code></p>
                            <div class="help-block _file" for="_file"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="preview-image-upload">
                                <img class="imagePreviewUpload" id="imagePreviewUpload" />
                                <button type="button" class="btn-remove-preview-image">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-end">
                <h5 class="font-size-14 mb-3">Status Urgent</h5>
                <div>
                    <input type="checkbox" id="status_urgent" name="status_urgent" switch="success" />
                    <label for="status_urgent" data-on-label="Yes" data-off-label="No"></label>
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
        <button type="submit" class="btn btn-primary waves-effect waves-light">KIRIM</button>
    </div>
</form>

<script>
    initSelect2('_ptks', '#content-detailModal');
    // let editorAdd;

    // ClassicEditor.create(document.querySelector('#_isi'), {}).then(editors => {
    //     editorAdd = editors
    // }).catch(error => {
    //     console.log(error);
    // });

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

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const jenis = document.getElementsByName('_jenis')[0].value;
        const npsn = document.getElementsByName('_npsn')[0].value;
        const ptks = document.getElementsByName('_ptks[]');
        // const isi = editorAdd.getData();
        const isi = document.getElementsByName('_isi')[0].value;
        const fileName = document.getElementsByName('_file')[0].value;

        console.log(ptks);

        var selectedPtks = [];

        for (var i = 0; i < ptks.length; i++) {
            if (ptks[i].selected) {
                selectedPtks.push(ptks[i].value);
                console.log(selectedPtks);
            }
        }

        let status;
        if ($('#status_urgent').is(":checked")) {
            status = "1";
        } else {
            status = "0";
        }

        if (jenis === "") {
            $("select#_jenis").css("color", "#dc3545");
            $("select#_jenis").css("border-color", "#dc3545");
            $('._jenis').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih jenis aduan.</li></ul>');
            return false;
        }

        if (npsn === "") {
            $("input#_npsn").css("color", "#dc3545");
            $("input#_npsn").css("border-color", "#dc3545");
            $('._npsn').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NPSN tidak boleh kosong.</li></ul>');
            return false;
        }

        if (isi === "") {
            $("textarea#_isi").css("color", "#dc3545");
            $("textarea#_isi").css("border-color", "#dc3545");
            $('._isi').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Deskripsi tidak boleh kosong.</li></ul>');
            return false;
        }

        // if (isi.length < 2) {
        //     Swal.fire(
        //         "Peringatan!",
        //         "Silahkan masukkan deskripsi.",
        //         "warning"
        //     );
        //     return true;
        // }

        const formUpload = new FormData();
        if (fileName !== "") {
            const file = document.getElementsByName('_file')[0].files[0];
            formUpload.append('_file', file);
        }
        formUpload.append('jenis', jenis);
        formUpload.append('npsn', npsn);
        formUpload.append('ptks', selectedPtks);
        formUpload.append('isi', isi);
        formUpload.append('status', status);

        var form_data = new FormData(this);

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
            url: "./addSave",
            type: 'POST',
            data: form_data,
            // data: formUpload,
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
                // console.log(erro);
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
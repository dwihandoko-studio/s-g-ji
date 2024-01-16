<form id="formAddModalData" action="./uploadSaveSktm" method="post" enctype="multipart/form-data">
    <input type="hidden" id="_id" name="_id" value="<?= $id ?>" />
    <input type="hidden" id="_nama" name="_nama" value="<?= $nama ?>" />
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="_kecamatan" class="col-form-label">Kecamatan :</label>
                    <select class="form-control select2 kecamatan" id="_kecamatan" name="_kecamatan" style="width: 100%" onchange="changeKecamatan(this)">
                        <option value="">&nbsp;</option>
                        <?php if (isset($kecamatans)) {
                            if (count($kecamatans) > 0) {
                                foreach ($kecamatans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _kecamatan"></div>
                </div>
                <div class="mb-3 select2-kelurahan-loading">
                    <label for="_kelurahan" class="col-form-label">Kelurahan :</label>
                    <select class="form-control select2 kelurahan" id="_kelurahan" name="_kelurahan" style="width: 100%">
                        <option value="">&nbsp;</option>
                        <?php if (isset($kelurahans)) {
                            if (count($kelurahans) > 0) {
                                foreach ($kelurahans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->kelurahan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _kelurahan"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="_nomor_sktm" class="form-label">Nomor SKTM</label>
                    <input type="text" class="form-control nomor_sktm" id="_nomor_sktm" name="_nomor_sktm" placeholder="Nomor SKTM..." onfocusin="inputFocus(this);">
                    <div class="help-block _nomor_sktm"></div>
                </div>
                <div class="mb-3">
                    <label for="_tgl_sktm" class="form-label">Tanggal SKTM</label>
                    <input type="date" class="form-control tgl_sktm" id="_tgl_sktm" name="_tgl_sktm" onfocusin="inputFocus(this);">
                    <div class="help-block _tgl_sktm"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="_tujuan_surat_sktm" class="form-label">Tujuan Surat SKTM</label>
                    <input type="text" class="form-control tujuan_surat_sktm" id="_tujuan_surat_sktm" name="_tujuan_surat_sktm" placeholder="Tujuan surat SKTM..." onfocusin="inputFocus(this);">
                    <div class="help-block _tujuan_surat_sktm"></div>
                </div>
                <div class="mb-3">
                    <label for="_tujuan_tempat_sktm" class="form-label">Tujuan Tempat SKTM</label>
                    <input type="text" class="form-control tujuan_tempat_sktm" id="_tujuan_tempat_sktm" name="_tujuan_tempat_sktm" placeholder="Tujuan tempat SKTM..." onfocusin="inputFocus(this);">
                    <div class="help-block _tujuan_tempat_sktm"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="_tujuan_rs" class="form-label">Tujuan Rumah Sakit</label>
                    <input type="text" class="form-control _tujuan_rs" id="_tujuan_rs" name="_tujuan_rs" placeholder="Tujuan Rumah Sakit..." onfocusin="inputFocus(this);">
                    <div class="help-block _tujuan_rs"></div>
                </div>
            </div>
            <!-- <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Upload File Dokumen yang akan di TTE: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept="application/pdf" onchange="loadFile()">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
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
            </div> -->
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
    initSelect2("_kecamatan", ".content-detailModal");
    initSelect2("_kelurahan", ".content-detailModal");

    function changeKecamatan(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value !== "") {
            $.ajax({
                url: './getKelurahan',
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('.kelurahan').html("");
                    $('div.select2-kelurahan-loading').block({
                        message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.select2-kelurahan-loading').unblock();
                    if (resul.status == 200) {
                        $('.kelurahan').html(resul.data);
                    } else {
                        if (resul.status == 401) {
                            Swal.fire(
                                'PERINGATAN!',
                                resul.message,
                                'warning'
                            ).then((valRes) => {
                                reloadPage(resul.redirrect);
                            })
                        } else {
                            Swal.fire(
                                'PERINGATAN!!!',
                                resul.message,
                                'warning'
                            );
                        }
                    }
                },
                error: function(data) {
                    $('div.select2-kelurahan-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    }

    function loadFilePdf() {
        const inputF = document.getElementsByName('_file_lampiran')[0];
        if (inputF.files && inputF.files[0]) {
            var fileF = inputF.files[0];

            var mime_typesF = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];

            if (mime_typesF.indexOf(fileF.type) == -1) {
                inputF.value = "";
                // $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (fileF.size > 1 * 5124 * 1000) {
                inputF.value = "";
                // $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 5 Mb.",
                    'warning'
                );
                return false;
            }

            // var reader = new FileReader();

            // reader.onload = function(e) {
            //     $('.imagePreviewUpload').attr('src', e.target.result);
            // }

            // reader.readAsDataURL(input.files[0]);
        } else {
            console.log("failed Load");
        }
    }

    function loadFile() {
        const input = document.getElementsByName('_file')[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var mime_types = ['application/pdf'];

            if (mime_types.indexOf(file.type) == -1) {
                input.value = "";
                $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar dan pdf yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 2 * 1024 * 1000) {
                input.value = "";
                $('.imagePreviewUpload').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 2 Mb.",
                    'warning'
                );
                return false;
            }

            if (file.type === 'application/pdf') {

            } else {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.imagePreviewUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }

        } else {
            console.log("failed Load");
        }
    }

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const id = document.getElementsByName('_id')[0].value;
        const nama = document.getElementsByName('_nama')[0].value;
        const kecamatan = document.getElementsByName('_kecamatan')[0].value;
        const kelurahan = document.getElementsByName('_kelurahan')[0].value;
        const nomor_sktm = document.getElementsByName('_nomor_sktm')[0].value;
        const tgl_sktm = document.getElementsByName('_tgl_sktm')[0].value;
        const tujuan_surat_sktm = document.getElementsByName('_tujuan_surat_sktm')[0].value;
        const tujuan_tempat_sktm = document.getElementsByName('_tujuan_tempat_sktm')[0].value;
        const tujuan_rs = document.getElementsByName('_tujuan_rs')[0].value;
        // const fileName = document.getElementsByName('_file')[0].value;

        // if (fileName === "" || fileName === undefined) {
        //     Swal.fire(
        //         'GAGAL!',
        //         "Silahkan pilih dokumen yang akan di TTE.",
        //         'warning'
        //     );
        // }

        const formUpload = new FormData();
        // if (fileName !== "") {
        //     const file = document.getElementsByName('_file')[0].files[0];
        //     formUpload.append('_file', file);
        // }
        formUpload.append('id', id);
        formUpload.append('nama', nama);
        formUpload.append('kecamatan', kecamatan);
        formUpload.append('kelurahan', kelurahan);
        formUpload.append('nomor_sktm', nomor_sktm);
        formUpload.append('tgl_sktm', tgl_sktm);
        formUpload.append('tujuan_surat', tujuan_surat_sktm);
        formUpload.append('tempat_surat', tujuan_tempat_sktm);
        formUpload.append('tujuan_rs', tujuan_rs);

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
            url: "./savesktm",
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
                        reloadPage(resul.redirrect);
                        // $.ajax({
                        //     url: "./downloadtemp",
                        //     type: 'POST',
                        //     data: {
                        //         id: resul.id,
                        //         nama: nama,
                        //     },
                        //     dataType: 'JSON',
                        //     beforeSend: function() {
                        //         $('div.modal-content-loading').block({
                        //             message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        //         });
                        //     },
                        //     success: function(result) {
                        //         $('div.modal-content-loading').unblock();
                        //         if (result.status !== 200) {
                        //             Swal.fire(
                        //                 'Failed!',
                        //                 result.message,
                        //                 'warning'
                        //             );
                        //         } else {
                        //             Swal.fire(
                        //                 'SELAMAT!',
                        //                 result.message,
                        //                 'success'
                        //             ).then((valRest) => {
                        //                 reloadPage(result.redirrect);
                        //             })
                        //         }
                        //     },
                        //     error: function() {
                        //         $('div.modal-content-loading').unblock();
                        //         Swal.fire(
                        //             'Failed!',
                        //             "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        //             'warning'
                        //         );
                        //     }
                        // });
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
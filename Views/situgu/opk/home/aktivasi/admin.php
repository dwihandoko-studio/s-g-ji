<form id="formAktivasiModalData" action="./home/kirimAktivasi" method="post" enctype="multipart/form-data">
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="mb-3">
            <label for="_nip" class="form-label">NIP/NIK</label>
            <input type="number" class="form-control nip" id="_nip" name="_nip" placeholder="NIP..." onfocusin="inputFocus(this);">
            <div class="help-block _nip"></div>
        </div>
        <div class="mb-3">
            <label for="_nohp" class="form-label">Nomor Handphone</label>
            <input type="number" class="form-control nohp" id="_nohp" name="_nohp" placeholder="No handphone..." onfocusin="inputFocus(this);">
            <p style="padding: 5px 0px;">Silah isi Nomor Handphone dengan format: 08xxxxxxxxxx (Contoh: 081208120812)</p>
            <div class="help-block _nohp"></div>
        </div>
        <div class="mb-3">
            <label for="_jk" class="form-label">Jenis Kelamin</label>
            <select class="form-control jk" id="_jk" name="_jk" style="width: 100%">
                <option value="L" selected>Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            <div class="help-block _jk"></div>
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
                            <img class="imagePreviewUpload" id="imagePreviewUpload" />
                            <button type="button" class="btn-remove-preview-image">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mt-3">
                        <label for="_surat_tugas" class="form-label">Surat Tugas: </label>
                        <input class="form-control" type="file" id="_surat_tugas" name="_surat_tugas" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile()">
                        <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                        <div class="help-block _surat_tugas" for="_surat_tugas"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="preview-image-upload-file">
                            <img class="imagePreviewUploadFile" id="imagePreviewUploadFile" />
                            <button type="button" class="btn-remove-preview-image-file">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="col-lg-6">
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
        <button type="button" onclick="aksiLogout(this);" class="btn btn-sm btn-secondary waves-effect waves-light">Keluar</button>
        <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light">Kirim Aktivasi</button>
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

    function loadFile() {
        const input = document.getElementsByName('_surat_tugas')[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var mime_types = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];

            if (mime_types.indexOf(file.type) == -1) {
                input.value = "";
                $('.imagePreviewUploadFile').attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar dan pdf yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 2 * 1024 * 1000) {
                input.value = "";
                $('.imagePreviewUploadFile').attr('src', '');
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
                    $('.imagePreviewUploadFile').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }

        } else {
            console.log("failed Load");
        }
    }


    $("#formAktivasiModalData").on("submit", function(e) {
        e.preventDefault();
        const nip = document.getElementsByName('_nip')[0].value;
        const nohp = document.getElementsByName('_nohp')[0].value;
        const jk = document.getElementsByName('_jk')[0].value;
        const fileName = document.getElementsByName('_file')[0].value;
        const fileNameSurat = document.getElementsByName('_surat_tugas')[0].value;

        if (nip === "") {
            $("input#_nip").css("color", "#dc3545");
            $("input#_nip").css("border-color", "#dc3545");
            $('._nip').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NIP tidak boleh kosong. Jika belum mempunya NIP silahkan isi dengan NIK. </li></ul>');
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

        if (fileName === "") {
            Swal.fire(
                "Peringatan!",
                "Foto pengguna belum dipilih.",
                "warning"
            );
            return true;
        }

        if (fileNameSurat === "") {
            Swal.fire(
                "Peringatan!",
                "Surat tugas belum dipilih.",
                "warning"
            );
            return true;
        }

        const formUpload = new FormData();
        const file = document.getElementsByName('_file')[0].files[0];
        const fileSurat = document.getElementsByName('_surat_tugas')[0].files[0];
        formUpload.append('file', file);
        formUpload.append('surat_tugas', fileSurat);
        formUpload.append('nip', nip);
        formUpload.append('jk', jk);
        formUpload.append('nohp', nohp);

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
            url: "./home/kirimAktivasi",
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

    // $("#formAktivasiWaModalData").on("submit", function(e) {
    //     e.preventDefault();
    //     const nomor = document.getElementsByName('_no_wa')[0].value;

    //     if (nomor === "") {
    //         $("input#_no_wa").css("color", "#dc3545");
    //         $("input#_no_wa").css("border-color", "#dc3545");
    //         $('._no_wa').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nomor Whatsapp tidak boleh kosong.</li></ul>');
    //         return false;
    //     }

    //     $.ajax({
    //         url: "./home/kirimAktivasiWa",
    //         type: 'POST',
    //         data: {
    //             nomor: nomor,
    //         },
    //         dataType: 'JSON',
    //         beforeSend: function() {
    //             $('div.modal-content-loading').block({
    //                 message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
    //             });
    //         },
    //         success: function(resul) {
    //             $('div.modal-content-loading').unblock();

    //             if (resul.status !== 200) {
    //                 if (resul.status === 401) {
    //                     Swal.fire(
    //                         'Failed!',
    //                         resul.message,
    //                         'warning'
    //                     ).then((valRes) => {
    //                         reloadPage();
    //                     });
    //                 } else {
    //                     Swal.fire(
    //                         'PERINGATAN!',
    //                         resul.message,
    //                         'warning'
    //                     );
    //                 }
    //             } else {
    //                 $('.contentAktivasiBodyModal').html(resul.data);
    //             }
    //         },
    //         error: function() {
    //             $('div.modal-content-loading').unblock();
    //             Swal.fire(
    //                 'PERINGATAN!',
    //                 "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
    //                 'warning'
    //             );
    //         }
    //     });

    // });
</script>
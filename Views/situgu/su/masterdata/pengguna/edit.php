<?php if (isset($data)) { ?>
    <form id="formEditModalData" action="./editSave" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $data->id ?>" id="_id" name="_id" />
        <div class="modal-body loading-get-data">
            <div class="row">
                <div class="col-lg-6">
                    <label for="_fullname" class="col-form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control fullname" value="<?= $data->fullname ?>" id="_fullname" name="_fullname" placeholder="Fullname..." onfocusin="inputFocus(this);" required />
                    <div class="help-block _fullname"></div>
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
                <div class="col-lg-6">
                    <label for="_password" class="col-form-label">Password (Kode Registrasi Dapodik):</label>
                    <input type="text" class="form-control password" id="_password" name="_password" placeholder="********" onfocusin="inputFocus(this);" required />
                    <div class="help-block _password"></div>
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
            const email = document.getElementsByName('_email')[0].value;
            const nohp = document.getElementsByName('_nohp')[0].value;
            const password = document.getElementsByName('_password')[0].value;

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

            const formUpload = new FormData();

            formUpload.append('id', id);
            formUpload.append('nama', fullname);
            formUpload.append('email', email);
            formUpload.append('nohp', nohp);
            formUpload.append('password', password);

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
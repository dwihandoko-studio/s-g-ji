<form id="formAddModalData" action="./addSave" method="post" enctype="multipart/form-data">
    <div class="modal-body loading-get-data">
        <div class="row">
            <div class="col-lg-12">
                <p><code>*)</code>Jika data Pengawas tidak ada dalam daftar dibawah ini, Silahkan untuk melakukan Import Data terlebih dahulu pada menu masterdata pengawas. <a href="<?= base_url('situpeng/su/masterdata/pengawas') ?>"><i class="bx bx-log-in-circle"></i></a></p>
                <div class="mb-3">
                    <label for="_ptk" class="col-form-label">Pilih Pengawas:</label>
                    <select class="form-control select2 ptk" id="_ptk" name="_ptk" style="width: 100%" onchange="changePengawas(this)">
                        <option value="">&nbsp;</option>
                        <?php if (isset($data)) {
                            if (count($data) > 0) {
                                foreach ($data as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?> - (NUPTK: <?= $value->nuptk ?> - NIP: <?= $value->nip ?>)</option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _ptk"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <label for="_fullname" class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control fullname" id="_fullname" name="_fullname" placeholder="Fullname..." onfocusin="inputFocus(this);" required />
                <div class="help-block _fullname"></div>
            </div>
            <div class="col-lg-6">
                <label for="_nip" class="col-form-label">NIP:</label>
                <input type="number" class="form-control nip" id="_nip" name="_nip" placeholder="NIP..." onfocusin="inputFocus(this);" required />
                <div class="help-block _nip"></div>
            </div>
            <div class="col-lg-6">
                <label for="_nuptk" class="col-form-label">NUPTK:</label>
                <input type="text" class="form-control nuptk" id="_nuptk" name="_nuptk" placeholder="NUPTK..." onfocusin="inputFocus(this);" required />
                <div class="help-block _nuptk"></div>
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
    function changePengawas(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value !== "") {
            $.ajax({
                url: './getPengawas',
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.loading-get-data').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.loading-get-data').unblock();
                    if (resul.status == 200) {
                        document.getElementById("_fullname").value = resul.data.nama;
                        document.getElementById("_nip").value = resul.data.nip;
                        document.getElementById("_nuptk").value = resul.data.nuptk;
                    } else {
                        if (resul.status == 404) {
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
                    $('div.loading-get-data').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    }

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const fullname = document.getElementsByName('_fullname')[0].value;
        const nip = document.getElementsByName('_nip')[0].value;
        const nuptk = document.getElementsByName('_nuptk')[0].value;
        const id_pengawas = document.getElementsByName('_ptk')[0].value;

        if (id_pengawas === "") {
            $("select#_ptk").css("color", "#dc3545");
            $("select#_ptk").css("border-color", "#dc3545");
            $('._ptk').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih PTK terlebih dahulu.</li></ul>');
            return false;
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
            $('._nip').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">NIP tidak boleh kosong. Jika belum mempunya NIP silahkan isi dengan tanda (-). </li></ul>');
            return false;
        }

        if (nuptk === "") {
            $("input#_nuptk").css("color", "#dc3545");
            $("input#_nuptk").css("border-color", "#dc3545");
            $('._nuptk').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Email tidak boleh kosong.</li></ul>');
            return false;
        }

        const formUpload = new FormData();
        formUpload.append('nama', fullname);
        formUpload.append('nip', nip);
        formUpload.append('nuptk', nuptk);
        formUpload.append('id_pengawas', id_pengawas);

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
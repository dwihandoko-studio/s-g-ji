<form id="formAddModalData" action="./addSave" method="post" enctype="multipart/form-data">
    <div class="modal-body loading-get-data">
        <div class="row">
            <div class="col-lg-6 kecamatan-role">
                <div class="mb-3">
                    <label for="_kecamatan" class="col-form-label">Pilih Kecamatan:</label>
                    <select class="select2 form-control select2" id="_kecamatan" name="_kecamatan" onchange="changeKecamatan(this)" style="width: 100%" data-placeholder="Pilih Kecamatan ...">
                        <option value="" selected>Pilih Kecamatan</option>
                        <?php if (isset($kecamatans)) {
                            if (count($kecamatans) > 0) {
                                foreach ($kecamatans as $key => $value) { ?>
                                    <option value="<?= $value->kode_kecamatan ?>"><?= $value->nama_kecamatan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _kecamatan"></div>
                </div>
            </div>
            <div class="col-lg-12 ptks-role">
                <div class="mb-3">
                    <label for="_sekolah" class="col-form-label">Pilih Sekolah:</label>
                    <select class="select2 form-control select2-multiple" id="_sekolah" name="_sekolah[]" style="width: 100%" multiple="multiple" data-placeholder="Pilih Sekolah ...">
                    </select>
                    <div class="help-block _sekolah"></div>
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
    initSelect2('_kecamatan', {
        dropdownParent: '#content-detailModal',
    });

    function changeKecamatan(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value !== "") {
            $("#_sekolah").select2({
                dropdownParent: '#content-detailModal',
                ajax: {
                    url: './getSekolah/' + event.value,
                    type: "post",
                    dataType: 'json',
                    delay: 200,
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        }
    }

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const sekolahs = document.getElementById('_sekolah');

        var selectedSekolah = [];

        for (var i = 0; i < sekolahs.length; i++) {
            if (sekolahs[i].selected) {
                selectedSekolah.push(sekolahs[i].value);
                console.log(selectedSekolah);
            }
        }

        if (selectedSekolah.length < 1) {
            Swal.fire(
                "Peringatan!",
                "Silahkan pilih Sekolah Binaan terlebih dahulu.",
                "warning"
            );
            return true;
        }

        const formUpload = new FormData();
        formUpload.append('npsns', selectedSekolah);

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
            url: "./addSaveBinaan",
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
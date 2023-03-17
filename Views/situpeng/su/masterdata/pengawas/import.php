<form id="formImportModalData" action="./aksiimport" method="post" enctype="multipart/form-data">
    <div class="modal-body modal-content-loaded">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-3">
                            <label for="_file" class="form-label">Import Data Pengawas: </label>
                            <input class="form-control" type="file" id="_file" name="_file" onFocus="inputFocus(this);" accept=".xls, .xlsx" onchange="loadFileXl(this, '_file');">
                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title=".xls/.xlsx">Files</code> and Maximum File Size <code>2 Mb</code></p>
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
        </div>
        <div class="row mt-4 data-import-pengawas" id="data-import-pengawas" style="display: none;">
            <div class="col-lg-12 mt-4">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NPSN</th>
                                <th>Satuan Pendidikan</th>
                                <th>Nomor Surat Tugas</th>
                                <th>Tanggal Surat</th>
                                <th>Status</th>
                                <th>Jumlah Jam</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
        <button type="submit" id="submit-import" class="btn btn-primary waves-effect waves-light submit-import">Import</button>
    </div>
</form>
<script>
    $("#formImportModalData").on("submit", function(e) {
        e.preventDefault();
        const fileName = document.getElementsByName('_file')[0].value;

        const formUpload = new FormData();
        if (fileName !== "") {
            const file = document.getElementsByName('_file')[0].files[0];
            formUpload.append('file', file);
        }

        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                        var percent = (evt.loaded / evt.total) * 100;
                        ambilId("progressBar").value = Math.round(percent);
                    }
                }, false);
                return xhr;
            },
            url: "./aksiimport",
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
                $(".submit-import").attr('disabled', 'disabled');
                ambilId("loaded_n_total").innerHTML = "";
                $('div.modal-content-loading').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(resul) {
                $('div.modal-content-loading').unblock();

                if (resul.status !== 200) {
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
                            $(".submit-import").attr('disabled', false);
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
                    $('div.modal-content-loaded').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });

                    if (data.success) {
                        ambilId("status").innerHTML = "Menyimpan Data . . .";
                        console.log(data.data);
                        console.log(data.data.length);

                        let sendToServer = function(lines, index) {
                            if (index > lines.length - 1) {
                                $('div.modal-content-loaded').unblock();
                                ambilId("progressBar").style.display = "none";
                                ambilId("status").innerHTML = "Data berhasil diimport semua.";
                                ambilId("status").style.color = "green";
                                ambilId("progressBar").value = 0;

                                Swal.fire(
                                    'SELAMAT!',
                                    "Data berhasil diimport semua.",
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
                                return;
                            }

                            item = lines[index];
                            let total = ((index + 1) / lines.length) * 100;
                            total = total.toFixed(2);

                            $.ajax({
                                url: "./importData",
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    nama: item.nama,
                                    nuptk: item.nuptk,
                                    nip: item.nip,
                                    tgl_lahir: item.tgl_lahir,
                                    jenis_pengawas: item.jenis_pengawas,
                                    tmt_cpns: item.tmt_cpns,
                                    tmt_pns: item.tmt_pns,
                                    tmt_pengangkatan: item.tmt_pengangkatan,
                                    sk_pengangkatan: item.sk_pengangkatan,
                                    tgl_pensiun: item.tgl_pensiun,
                                    pendidikan: item.pendidikan,
                                    nomor_surat_tugas: item.nomor_surat_tugas,
                                    tmt_surat_tugas: item.tmt_surat_tugas,
                                    jenjang_pengawas: item.jenjang_pengawas,
                                    keaktifan: item.keaktifan,
                                    tgl_nonaktif: item.tgl_nonaktif,
                                },
                                success: function(msg) {
                                    if (msg.status != 200) {

                                        ambilId("status").style.color = "blue";
                                        ambilId("progressBar").value = total;
                                        ambilId("loaded_n_total").innerHTML = total + '%';
                                        console.log(msg.message);
                                        if (index + 1 === lines.length) {

                                            $('div.modal-content-loaded').unblock();
                                            ambilId("progressBar").style.display = "none";
                                            ambilId("status").innerHTML = msg.message;
                                            ambilId("status").style.color = "green";
                                            ambilId("progressBar").value = 0;

                                            Swal.fire(
                                                'SELAMAT!',
                                                msg.message,
                                                'success'
                                            ).then((valRes) => {
                                                reloadPage();
                                            })
                                        }
                                    } else {

                                        ambilId("status").style.color = "blue";
                                        ambilId("progressBar").value = total;
                                        ambilId("loaded_n_total").innerHTML = total + '%';
                                        if (index + 1 === lines.length) {
                                            $('div.modal-content-loaded').unblock();
                                            ambilId("progressBar").style.display = "none";
                                            ambilId("status").innerHTML = msg.message;
                                            ambilId("status").style.color = "green";
                                            ambilId("progressBar").value = 0;

                                            Swal.fire(
                                                'SELAMAT!',
                                                msg.message,
                                                'success'
                                            ).then((valRes) => {
                                                reloadPage();
                                            })

                                        }
                                    }

                                    setTimeout(
                                        function() {
                                            sendToServer(lines, index + 1);
                                        },
                                        350 // delay in ms
                                    );
                                },
                                error: function(error) {
                                    $('div.modal-content-loaded').unblock();
                                    ambilId("progressBar").style.display = "none";
                                    ambilId("status").innerHTML = msg.message;
                                    ambilId("status").style.color = "green";
                                    ambilId("progressBar").value = 0;
                                    $(".submit-import").attr('disabled', false);
                                    Swal.fire(
                                        'Failed!',
                                        "Gagal.",
                                        'warning'
                                    );
                                }
                            });
                        };

                        sendToServer(data.data, 0);

                    }

                    if (data.error) {
                        ambilId("progressBar").style.display = "none";
                        ambilId("status").innerHTML = data.error;
                        ambilId("status").style.color = "red";
                        ambilId("progressBar").value = 0;
                        ambilId("loaded_n_total").innerHTML = "";
                        $(".submit-import").attr('disabled', false);
                        $('div.modal-content-loaded').unblock();

                        Swal.fire(
                            'Failed!',
                            data.error,
                            'warning'
                        );
                    }



                    // Swal.fire(
                    //     'SELAMAT!',
                    //     resul.message,
                    //     'success'
                    // ).then((valRes) => {
                    //     reloadPage();
                    // })
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

    function loadFileXl(fil, event) {
        const input = document.getElementsByName('_file')[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            // allowed MIME types
            var mime_types = ['application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

            if (mime_types.indexOf(file.type) == -1) {
                input.value = "";
                Swal.fire(
                    'Warning!!!',
                    "Hanya file berekstensi .xls atau .xlsx yang diizinkan.",
                    'warning'
                );
                return;
            }

            // console.log(file.size);

            // validate file size
            if (file.size > 1 * 1024 * 5 * 1000) {
                input.value = "";
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 5 Mb.",
                    'warning'
                );
                return;
            }

            $('.' + event).css('display', 'none');
        } else {
            console.log("failed Load");
        }
    }
</script>
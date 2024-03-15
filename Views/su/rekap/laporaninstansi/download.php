<?php if (isset($instansis) && isset($tws)) { ?>
    <form id="formAddModalData" action="./uploadSave" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">

                    <label for="_tw" class="form-label">Tahun Bulan:</label>
                    <select class="form-control" id="_tw" name="_tw" required>
                        <option value="">--------------------------------------------</option>
                        <?php if (isset($tws)) {
                            if (count($tws) > 0) {
                                foreach ($tws as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= ($value->id == $tw->id) ? ' selected' : '' ?>><?= $value->tahun ?> || Bulan: <?= $value->bulan ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _tw"></div>
                </div>
                <div class="col-lg-12 mt-2">
                    <label for="_instansi" class="form-label">Instansi:</label>
                    <select class="form-control" id="_instansi" name="_instansi" style="width: 100%" required>
                        <option value="">-- PILIH --</option>
                        <?php if (isset($instansis)) {
                            if (count($instansis) > 0) {
                                foreach ($instansis as $key => $value) { ?>
                                    <option value="<?= $value->kode_instansi ?>"><?= $value->nama_instansi ?> (<?= $value->nama_kecamatan ?>)</option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _instansi"></div>
                </div>
                <div class="col-lg-12">
                    <div class="mt-4">
                        <h5 class="font-size-14 mb-4">Format Download</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" value="pdf" name="_type_file" id="formRadios1" checked="">
                            <label class="form-check-label" for="formRadios1">
                                PDF
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="xlsx" name="_type_file" id="formRadios2">
                            <label class="form-check-label" for="formRadios2">
                                Excel
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">Download</button>
        </div>
    </form>

    <script>
        initSelect2("_instansi", ".content-detailModal");

        $("#formAddModalData").on("submit", function(e) {
            e.preventDefault();
            const tahun = document.getElementsByName('_tw')[0].value;
            const instansi = document.getElementsByName('_instansi')[0].value;
            var radios = document.getElementsByName('_type_file');
            var selectedValue = "";
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    selectedValue = radios[i].value;
                    break;
                }
            }

            if (tahun === "" || instansi === "") {
                Swal.fire(
                    'PERINGATAN!',
                    "tahun bulan dan instansi harus dipilih",
                    'warning'
                );
                return;
            }

            const formUpload = new FormData();
            formUpload.append('tahun', tahun);
            formUpload.append('instansi', instansi);
            formUpload.append('type_file', selectedValue);

            $.ajax({
                url: "./aksidownload",
                type: 'POST',
                data: formUpload,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.modal-content-loading').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.modal-content-loading').unblock();

                    if (resul.status !== 200) {
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
                        window.open(resul.url, "_blank");
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage();
                            window.open(resul.url, "_blank");
                            // window.open(resul.url, 'popup', 'width=600,height=600');
                            return false;
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
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
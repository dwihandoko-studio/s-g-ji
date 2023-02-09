<form id="formAddModalData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-8">
                <div class="col-3">
                    <label for="_tw" class="form-label">Tahun TW:</label>
                    <select class="form-control" id="_tw" name="_tw" required>
                        <option value="">--------------------------------------------</option>
                        <?php if (isset($tw)) {
                            if (count($tw) > 0) {
                                foreach ($tw as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->tahun ?> || TW: <?= $value->tw ?></option>
                        <?php }
                            }
                        } ?>
                    </select>
                    <div class="help-block _tw"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    initSelect2("_tw", ".content-detailModal");

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const tw = document.getElementsByName('_tw')[0].value;

        if (tw === "") {
            $("select#_tw").css("color", "#dc3545");
            $("select#_tw").css("border-color", "#dc3545");
            $('._tw').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tahun tw.</li></ul>');
            return false;
        }

        $.ajax({
            url: "./addSave",
            type: 'POST',
            data: {
                tw: tw,
            },
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
                    Swal.fire(
                        'SELAMAT!',
                        resul.message,
                        'success'
                    ).then((valRes) => {
                        reloadPage();
                    })
                }
            },
            error: function() {
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
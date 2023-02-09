<?php if (isset($ptk)) { ?>
    <form id="formEditModalData" action="./prosesajukan" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $ptk->id ?>" />
        <input type="hidden" id="_tw" name="_tw" value="<?= $tw->id ?>" />
        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
            <div class="mb-3">
                <label for="_jenis" class="col-form-label">Pilih Jenis Tunjangan:</label>
                <select class="form-control" onchange="changeJenis(this)" id="_jenis" name="_jenis" required>
                    <option value="">--Pilih--</option>
                    <option value="tpg">TPG</option>
                    <option value="tamsil">TAMSIL</option>
                    <option value="pghm">PGHM</option>
                </select>
                <div class="help-block _jenis"></div>
            </div>
            <div id="validation-ajuan" class="col-lg-12 validation-ajuan">

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="submit-button-ajuan" class="btn btn-primary waves-effect waves-light submit-button-ajuan" disabled="true">Lanjutkan & Ajukan</button>
        </div>
    </form>

    <script>
        function changeJenis(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getValidationAjuan',
                    type: 'POST',
                    data: {
                        id: event.value,
                        id_ptk: '<?= $ptk->id ?>',
                        tw: '<?= $tw->id ?>',
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.validation-ajuan').html("");
                        $('.submit-button-ajuan').attr('disabled', true);
                        $('div.validation-ajuan').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.validation-ajuan').unblock();
                        if (resul.status == 200) {
                            $('.validation-ajuan').html(resul.data);
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
                        $('div.validation-ajuan').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        }
    </script>

<?php } ?>
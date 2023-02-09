<form id="formAddModalData" action="./addSave" method="post">
    <div class="modal-body">
        <div class="mb-3">
            <label for="_name" class="col-form-label">Tingkat Jabatan:</label>
            <select class="form-control" id="_tingkat" name="_tingkat" onchange="changeTingkat(this)" required>
                <option value="">--Pilih--</option>
                <option value="1">Kepala</option>
                <option value="2">Sekertaris</option>
                <option value="3">Kabid / Setingkat Kabid</option>
                <option value="4">Kasi / Setingkat Kasi</option>
                <option value="5">Staff / Setingkat Staff</option>
                <option value="6">TKS</option>
            </select>
            <div class="help-block _tingkat"></div>
        </div>
        <div class="mb-3 _parent-block">
            <label for="_name" class="col-form-label">Parent Jabatan:</label>
            <select class="form-control parent-jabatan" id="_parent" name="_parent" style="width: 100%">
                <option value="">&nbsp;</option>
                <?php if (isset($parents)) {
                    if (count($parents) > 0) {
                        foreach ($parents as $key => $value) { ?>
                            <option value="<?= $value->jid ?>"><?= $value->jabatan ?></option>
                <?php }
                    }
                } ?>
            </select>
            <div class="help-block _parent"></div>
        </div>
        <div class="mb-3">
            <label for="_name" class="col-form-label">Nama Jabatan:</label>
            <input type="text" class="form-control name" id="_name" name="_name" placeholder="Nama jabatan..." onfocusin="inputFocus(this);">
            <div class="help-block _name"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
    </div>
</form>

<script>
    initSelect2("_parent", ".content-detailModal");

    function changeTingkat(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value !== "") {
            $.ajax({
                url: './getParent',
                type: 'POST',
                data: {
                    id: event.value,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div._parent-block').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(msg) {
                    $('div._parent-block').unblock();
                    if (msg.status == 200) {
                        let html = "";
                        html += '<option value="">&nbsp;</option>';
                        if (msg.data.length > 0) {
                            for (let step = 0; step < msg.data.length; step++) {
                                html += '<option value="';
                                html += msg.data[step].jid;
                                html += '">';
                                html += msg.data[step].jabatan;
                                html += '</option>';
                            }

                        }

                        $('.parent-jabatan').html(html);
                    }
                },
                error: function(data) {
                    $('div._parent-block').unblock();
                }
            })
        }
    }

    $("#formAddModalData").on("submit", function(e) {
        e.preventDefault();
        const name = document.getElementsByName('_name')[0].value;
        const tingkat = document.getElementsByName('_tingkat')[0].value;
        const parent = document.getElementsByName('_parent')[0].value;

        if (tingkat === "") {
            $("select#_tingkat").css("color", "#dc3545");
            $("select#_tingkat").css("border-color", "#dc3545");
            $('._tingkat').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tingkat jabatan.</li></ul>');
            return false;
        }
        if (name === "") {
            $("input#_name").css("color", "#dc3545");
            $("input#_name").css("border-color", "#dc3545");
            $('._name').html('<ul role="alert" style="color: #dc3545; list-style-type:none; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama jabatan tidak boleh kosong.</li></ul>');
            return false;
        }

        $.ajax({
            url: "./addSave",
            type: 'POST',
            data: {
                name: name,
                tingkat: tingkat,
                parent: parent,
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
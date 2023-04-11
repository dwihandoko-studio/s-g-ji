<form id="formEditModalData" action="./addSave" method="post">
    <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="mb-3">
            <label for="_nama" class="form-label">Nama</label>
            <input type="text" class="form-control nama" id="_nama" name="_nama" placeholder="Nama Lengkap..." onfocusin="inputFocus(this);">
            <div class="help-block _nama"></div>
        </div>
        <div class="mb-3">
            <label for="_nuptk" class="form-label">NUPTK</label>
            <input type="text" class="form-control nuptk" id="_nuptk" name="_nuptk" placeholder="NUPTK..." onfocusin="inputFocus(this);">
            <div class="help-block _nuptk"></div>
        </div>
        <div class="mb-3">
            <label for="_nip" class="form-label">NIP</label>
            <input type="text" class="form-control nip" id="_nip" name="_nip" placeholder="NIP..." onfocusin="inputFocus(this);">
            <div class="help-block _nip"></div>
        </div>
        <div class="mb-3">
            <label for="_tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control tgl_lahir" id="_tgl_lahir" name="_tgl_lahir" onfocusin="inputFocus(this);">
            <div class="help-block _tgl_lahir"></div>
        </div>
        <div class="mb-3">
            <label for="_jenis_pengawas" class="col-form-label">Pilih Jenis Pengawas:</label>
            <select class="select2 form-control select2" id="_jenis_pengawas" name="_jenis_pengawas" style="width: 100%" data-placeholder="Pilih jenis pengawas ..." onfocusin="inputFocus(this);">
                <option value="">--Pilih--</option>
                <option value="Pengawas Satuan Pendidikan">Pengawas Satuan Pendidikan</option>
                <option value="Pengawas Mata Pelajaran">Pengawas Mata Pelajaran</option>
            </select>
            <div class="help-block _jenis_pengawas"></div>
        </div>
        <div class="mb-3">
            <label for="_jenjang_pengawas" class="col-form-label">Pilih Jenjang Pengawas:</label>
            <select class="select2 form-control select2" id="_jenjang_pengawas" name="_jenjang_pengawas" style="width: 100%" data-placeholder="Pilih jenjang pengawas ..." onfocusin="inputFocus(this);">
                <option value="">--Pilih--</option>
                <option value="TK">TK</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
            </select>
            <div class="help-block _jenjang_pengawas"></div>
        </div>
        <div class="mb-3">
            <label for="_pendidikan" class="col-form-label">Pilih Pendidikan Terakhir:</label>
            <select class="select2 form-control select2" id="_pendidikan" name="_pendidikan" style="width: 100%" data-placeholder="Pilih pendidikan terakhir ..." onfocusin="inputFocus(this);">
                <option value="">--Pilih--</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
            </select>
            <div class="help-block _pendidikan"></div>
        </div>
        <div class="mb-3">
            <label for="_tgl_pensiun" class="form-label">Tanggal Pensiun</label>
            <input type="date" class="form-control tgl_pensiun" id="_tgl_pensiun" name="_tgl_pensiun" onfocusin="inputFocus(this);">
            <div class="help-block _tgl_pensiun"></div>
        </div>
        <div class="mb-3">
            <label for="_tmt_cpns" class="form-label">TMT CPNS</label>
            <input type="date" class="form-control tmt_cpns" id="_tmt_cpns" name="_tmt_cpns" onfocusin="inputFocus(this);">
            <div class="help-block _tmt_cpns"></div>
        </div>
        <div class="mb-3">
            <label for="_tmt_pns" class="form-label">TMT PNS</label>
            <input type="date" class="form-control tmt_pns" id="_tmt_pns" name="_tmt_pns" onfocusin="inputFocus(this);">
            <div class="help-block _tmt_pns"></div>
        </div>
        <div class="mb-3">
            <label for="_tmt_pengangkatan" class="form-label">TMT PENGANGKATAN</label>
            <input type="date" class="form-control tmt_pengangkatan" id="_tmt_pengangkatan" name="_tmt_pengangkatan" onfocusin="inputFocus(this);">
            <div class="help-block _tmt_pengangkatan"></div>
        </div>
        <div class="mb-3">
            <label for="_no_sk_pengangkatan" class="form-label">No SK PENGANGKATAN</label>
            <input type="text" class="form-control no_sk_pengangkatan" id="_no_sk_pengangkatan" name="_no_sk_pengangkatan" placeholder="No SK pengangkatan..." onfocusin="inputFocus(this);">
            <div class="help-block _no_sk_pengangkatan"></div>
        </div>
        <div class="mb-3">
            <label for="_nomor_surat_tugas" class="form-label">No Surat Tugas</label>
            <input type="text" class="form-control nomor_surat_tugas" id="_nomor_surat_tugas" name="_nomor_surat_tugas" placeholder="No Surat Tugas..." onfocusin="inputFocus(this);">
            <div class="help-block _nomor_surat_tugas"></div>
        </div>
        <div class="mb-3">
            <label for="_tmt_surat_tugas" class="form-label">TMT Surat Tugas</label>
            <input type="date" class="form-control tmt_surat_tugas" id="_tmt_surat_tugas" name="_tmt_surat_tugas" onfocusin="inputFocus(this);">
            <div class="help-block _tmt_surat_tugas"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">SIMPAN</button>
    </div>
</form>

<script>
    $("#formEditModalData").on("submit", function(e) {
        e.preventDefault();
        const nama = document.getElementsByName('_nama')[0].value;
        const nuptk = document.getElementsByName('_nuptk')[0].value;
        const nip = document.getElementsByName('_nip')[0].value;
        const tgl_lahir = document.getElementsByName('_tgl_lahir')[0].value;
        const jenis_pengawas = document.getElementsByName('_jenis_pengawas')[0].value;
        const jenjang_pengawas = document.getElementsByName('_jenjang_pengawas')[0].value;
        const pendidikan = document.getElementsByName('_pendidikan')[0].value;
        const tgl_pensiun = document.getElementsByName('_tgl_pensiun')[0].value;
        const tmt_cpns = document.getElementsByName('_tmt_cpns')[0].value;
        const tmt_pns = document.getElementsByName('_tmt_pns')[0].value;
        const tmt_pengangkatan = document.getElementsByName('_tmt_pengangkatan')[0].value;
        const no_sk_pengangkatan = document.getElementsByName('_no_sk_pengangkatan')[0].value;
        const nomor_surat_tugas = document.getElementsByName('_nomor_surat_tugas')[0].value;
        const tmt_surat_tugas = document.getElementsByName('_tmt_surat_tugas')[0].value;

        if (nama === "") {
            $("input#_nama").css("color", "#dc3545");
            $("input#_nama").css("border-color", "#dc3545");
            $('._nama').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama tidak boleh kosong.</li></ul>');
            return false;
        }
        if (nuptk === "") {
            $("input#_nuptk").css("color", "#dc3545");
            $("input#_nuptk").css("border-color", "#dc3545");
            $('._nuptk').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NUPTK tidak boleh kosong.</li></ul>');
            return false;
        }
        if (nip === "") {
            $("input#_nip").css("color", "#dc3545");
            $("input#_nip").css("border-color", "#dc3545");
            $('._nip').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIP tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tgl_lahir === "") {
            $("input#_tgl_lahir").css("color", "#dc3545");
            $("input#_tgl_lahir").css("border-color", "#dc3545");
            $('._tgl_lahir').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal Lahir tidak boleh kosong.</li></ul>');
            return false;
        }
        if (jenis_pengawas === "") {
            $("select#_jenis_pengawas").css("color", "#dc3545");
            $("select#_jenis_pengawas").css("border-color", "#dc3545");
            $('._jenis_pengawas').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis Pengawas tidak boleh kosong.</li></ul>');
            return false;
        }
        if (jenjang_pengawas === "") {
            $("select#_jenjang_pengawas").css("color", "#dc3545");
            $("select#_jenjang_pengawas").css("border-color", "#dc3545");
            $('._jenjang_pengawas').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenjang Pengawas tidak boleh kosong.</li></ul>');
            return false;
        }
        if (pendidikan === "") {
            $("select#_pendidikan").css("color", "#dc3545");
            $("select#_pendidikan").css("border-color", "#dc3545");
            $('._pendidikan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pendidikan Terakhir tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tgl_pensiun === "") {
            $("input#_tgl_pensiun").css("color", "#dc3545");
            $("input#_tgl_pensiun").css("border-color", "#dc3545");
            $('._tgl_pensiun').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal Pensiun tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tmt_cpns === "") {
            $("input#_tmt_cpns").css("color", "#dc3545");
            $("input#_tmt_cpns").css("border-color", "#dc3545");
            $('._tmt_cpns').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT CPNS tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tmt_pns === "") {
            $("input#_tmt_pns").css("color", "#dc3545");
            $("input#_tmt_pns").css("border-color", "#dc3545");
            $('._tmt_pns').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT PNS tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tmt_pengangkatan === "") {
            $("input#_tmt_pengangkatan").css("color", "#dc3545");
            $("input#_tmt_pengangkatan").css("border-color", "#dc3545");
            $('._tmt_pengangkatan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT Pengangkatan tidak boleh kosong.</li></ul>');
            return false;
        }
        if (no_sk_pengangkatan === "") {
            $("input#_no_sk_pengangkatan").css("color", "#dc3545");
            $("input#_no_sk_pengangkatan").css("border-color", "#dc3545");
            $('._no_sk_pengangkatan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No. SK Pengangkatan tidak boleh kosong.</li></ul>');
            return false;
        }
        if (no_surat_tugas === "") {
            $("input#_no_surat_tugas").css("color", "#dc3545");
            $("input#_no_surat_tugas").css("border-color", "#dc3545");
            $('._no_surat_tugas').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No. Surat Tugas tidak boleh kosong.</li></ul>');
            return false;
        }
        if (tmt_surat_tugas === "") {
            $("input#_tmt_surat_tugas").css("color", "#dc3545");
            $("input#_tmt_surat_tugas").css("border-color", "#dc3545");
            $('._tmt_surat_tugas').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">TMT Surat Tugas tidak boleh kosong.</li></ul>');
            return false;
        }

        Swal.fire({
            title: 'Apakah anda yakin ingin menyimpan data ini?',
            text: "Simpan Data Pengawas Baru",
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "./addSave",
                    type: 'POST',
                    data: {
                        nama: nama,
                        nuptk: nuptk,
                        nip: nip,
                        tgl_lahir: tgl_lahir,
                        jenis_pengawas: jenis_pengawas,
                        jenjang_pengawas: jenjang_pengawas,
                        pendidikan: pendidikan,
                        tgl_pensiun: tgl_pensiun,
                        tmt_cpns: tmt_cpns,
                        tmt_pns: tmt_pns,
                        tmt_pengangkatan: tmt_pengangkatan,
                        no_sk_pengangkatan: no_sk_pengangkatan,
                        no_surat_tugas: no_surat_tugas,
                        tmt_surat_tugas: tmt_surat_tugas,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('div.modal-content-loading-edit').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.modal-content-loading-edit').unblock();

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
                        $('div.modal-content-loading-edit').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        })
    });
</script>
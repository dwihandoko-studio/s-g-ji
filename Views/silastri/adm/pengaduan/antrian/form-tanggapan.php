<?php if (isset($data)) : ?>
    <form id="tindakLanjutPengaduanForm">
        <div class="modal-body">
            <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
            <input type="hidden" id="_nama" name="_nama" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $nama)) ?>" />
            <div class="col-lg-12">
                <label class="col-form-label">Media Pengaduan (Dari Pengadu):</label>
                <input type="text" class="form-control" id="_media_pengaduan" name="_media_pengaduan" value="<?= $data->media_pengaduan ?>" readonly />
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Uraian Pengaduan (Dari Pengadu):</label>
                <textarea rows="5" class="form-control" id="_uraian_pengaduan" name="_uraian_pengaduan" readonly><?= $data->uraian_aduan ?></textarea>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Permasalahan (Dari Frontoffice):</label>
                <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" readonly><?= $data->permasalahan ?></textarea>
                <div class="help-block _permasalahan"></div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Uraian Permasalahan (Backoffice):</label>
                <textarea rows="5" class="form-control" id="_uraian_permasalahan" name="_uraian_permasalahan" required></textarea>
                <div class="help-block _uraian_permasalahan"></div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Pokok Permasalahan (Backoffice):</label>
                <textarea rows="5" class="form-control" id="_pokok_permasalahan" name="_pokok_permasalahan" required></textarea>
                <div class="help-block _pokok_permasalahan"></div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Kepesertaan Bansos (Backoffice):</label>
                <table id="table-bansos" class="table-bansos">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>DTKS</th>
                            <th>PKH</th>
                            <th>BPNT</th>
                            <th>PBI JK</th>
                            <th>RST</th>
                            <th>Bansos Lainnya</th>
                            <th>Keterangan</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="nama_pemilik_bansos[]" />
                                <div class="help-block nama_pemilik_bansos_0"></div>
                            </td>
                            <td><input class="form-control" type="text" name="nik_pemilik_bansos[]" />
                                <div class="help-block nik_pemilik_bansos_0"></div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_dtks_bansos_0" value="ya" id="_dtks_bansos_1_0">
                                        <label class="form-check-label" for="_dtks_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_dtks_bansos_0" value="tidak" id="_dtks_bansos_2_0">
                                        <label class="form-check-label" for="_dtks_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _dtks_bansos_0"></div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_pkh_bansos_0" value="ya" id="_pkh_bansos_1_0">
                                        <label class="form-check-label" for="_pkh_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_pkh_bansos_0" value="tidak" id="_pkh_bansos_2_0">
                                        <label class="form-check-label" for="_pkh_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _pkh_bansos_0"></div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_bpnt_bansos_0" value="ya" id="_bpnt_bansos_1_0">
                                        <label class="form-check-label" for="_bpnt_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_bpnt_bansos_0" value="tidak" id="_bpnt_bansos_2_0">
                                        <label class="form-check-label" for="_bpnt_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _bpnt_bansos_0"></div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_pbi_jk_bansos_0" value="ya" id="_pbi_jk_bansos_1_0">
                                        <label class="form-check-label" for="_pbi_jk_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_pbi_jk_bansos_0" value="tidak" id="_pbi_jk_bansos_2_0">
                                        <label class="form-check-label" for="_pbi_jk_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _pbi_jk_bansos_0"></div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_rst_bansos_0" value="ya" id="_rst_bansos_1_0">
                                        <label class="form-check-label" for="_rst_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_rst_bansos_0" value="tidak" id="_rst_bansos_2_0">
                                        <label class="form-check-label" for="_rst_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _rst_bansos_0"></div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div class="mt-2">
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_bansos_lain_bansos_0" value="ya" id="_bansos_lain_bansos_1_0">
                                        <label class="form-check-label" for="_bansos_lain_bansos_1_0">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input" type="radio" name="_bansos_lain_bansos_0" value="tidak" id="_bansos_lain_bansos_2_0">
                                        <label class="form-check-label" for="_bansos_lain_bansos_2_0">
                                            Tidak
                                        </label>
                                    </div>
                                    <br />
                                    <div class="help-block _bansos_lain_bansos_0"></div>
                                </div>
                            </td>
                            <td><textarea class="form-control" name="keterangan_pemilik_bansos[]"></textarea>
                                <div class="help-block keterangan_pemilik_bansos_0"></div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button type="button" id="btnAddRowBansos" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bxs-add-to-queue label-icon"></i> Tambah Peserta Bansos</button>
                <br>
            </div>
            <hr />
            <div class="col-lg-12">
                <label class="col-form-label">Jawaban (Backoffice):</label>
                <textarea rows="5" class="form-control" id="_jawaban" name="_jawaban" required></textarea>
                <div class="help-block _jawaban"></div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Saran Tindaklanjut (Backoffice):</label>
                <textarea rows="5" class="form-control" id="_saran_tindaklanjut" name="_saran_tindaklanjut" required></textarea>
                <div class="help-block _saran_tindaklanjut"></div>
            </div>
            <div class="col-lg-12">
                <div class="row mt-2">
                    <label for="_tembusan" class="col-sm-3 col-form-label">Tembusan :</label>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                    <input class="form-check-input" type="checkbox" id="_kepala_dinas" name="_kepala_dinas" onchange="changeTembusan(this)">
                                    <label class="form-check-label" for="_kepala_dinas">
                                        Kepala Dinas
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3 _kepala_dinas_pilihan_content" id="_kepala_dinas_pilihan_content" style="display: none;">
                                    <label class="form-label">Pilih Kepala Dinas :</label>
                                    <select class="form-control select2" id="_kepala_dinas_pilihan" name="_kepala_dinas_pilihan" style="width: 100%">
                                        <option value=""> --- Pilih Kepala Dinas --- </option>
                                        <?php if (isset($dinass)) { ?>
                                            <?php if (count($dinass) > 0) { ?>
                                                <?php foreach ($dinass as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->instansi ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <div class="help-block _kepala_dinas_pilihan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                    <input class="form-check-input" type="checkbox" id="_camat" name="_camat" onchange="changeTembusan(this)">
                                    <label class="form-check-label" for="_camat">
                                        Camat
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3 _camat_pilihan_content" id="_camat_pilihan_content" style="display: none;">
                                    <label class="form-label">Pilih Camat :</label>
                                    <select class="form-control select2 camat_pilihan" onchange="changeKecamatan(this)" id="_camat_pilihan" name="_camat_pilihan" style="width: 100%">
                                        <option value=""> --- Pilih Camat --- </option>
                                        <?php if (isset($kecamatans)) { ?>
                                            <?php if (count($kecamatans) > 0) { ?>
                                                <?php foreach ($kecamatans as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <div class="help-block _camat_pilihan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                    <input class="form-check-input" type="checkbox" id="_kampung" name="_kampung" onchange="changeTembusan(this)">
                                    <label class="form-check-label" for="_kampung">
                                        Kepala Kampung
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3 _kampung_pilihan_content" id="_kampung_pilihan_content" style="display: none;">
                                    <label class="form-label">Pilih Kepala Kampung :</label>
                                    <select class="form-control select2 kampung_pilihan" id="_kampung_pilihan" name="_kampung_pilihan" style="width: 100%">
                                        <option value=""> --- Pilih Kepala Kampung --- </option>
                                        <?php if (isset($kelurahans)) { ?>
                                            <?php if (count($kelurahans) > 0) { ?>
                                                <?php foreach ($kelurahans as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->kelurahan ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <div class="help-block _kampung_pilihan"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="saveTanggapanPengaduan(this)" class="btn btn-primary waves-effect waves-light">Simpan Tanggapan Pengaduan</button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            initSelect2("_kepala_dinas_pilihan", ".contentApproveBodyModal");
            initSelect2("_camat_pilihan", ".contentApproveBodyModal");
            initSelect2("_kampung_pilihan", ".contentApproveBodyModal");

            $("#btnAddRowBansos").on("click", function() {
                addRowBansos('table-bansos');
            });
        });

        function addRowBansos(event) {
            const table = document.getElementById(event);
            const rowCountBansos = table.rows.length - 1;

            const newRow = table.insertRow(-1);
            const cells = [];

            for (let i = 0; i < 10; i++) {
                cells[i] = newRow.insertCell(i);
                if (i > 1 && i < 8) {
                    cells[i].setAttribute("style", "vertical-align: top;");
                }
                if (i === 9) {
                    cells[i].setAttribute("style", "vertical-align: center;");
                }
            }

            cells[0].innerHTML = `<input class="form-control" type="text" name="nama_pemilik_bansos[]" /><br />
                        <div class="help-block nama_pemilik_bansos_${rowCountBansos}"></div>`;
            cells[1].innerHTML = `<input class="form-control" type="text" name="nik_pemilik_bansos[]" /><br />
                        <div class="help-block nik_pemilik_bansos_${rowCountBansos}"></div>`;
            const radioNames = ['_dtks', '_pkh', '_bpnt', '_pbi_jk', '_rst', '_bansos_lain'];
            for (let i = 0; i < radioNames.length; i++) {
                cells[i + 2].innerHTML = `
            <div class="mt-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="${radioNames[i]}_bansos_${rowCountBansos}" value="ya" id="${radioNames[i]}_bansos_1_${rowCountBansos}">
                    <label class="form-check-label" for="${radioNames[i]}_bansos_1_${rowCountBansos}">Ya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="${radioNames[i]}_bansos_${rowCountBansos}" value="tidak" id="${radioNames[i]}_bansos_2_${rowCountBansos}">
                    <label class="form-check-label" for="${radioNames[i]}_bansos_2_${rowCountBansos}">Tidak</label>
                </div>
                <br />
                        <div class="help-block ${radioNames[i]}_bansos_${rowCountBansos}"></div>
            </div>`;
            }
            cells[8].innerHTML = `<textarea class="form-control" name="keterangan_pemilik_bansos[]"></textarea><div class="help-block keterangan_pemilik_bansos_${rowCountBansos}"></div>`;
            cells[9].innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRowBansos(this)"><i class="bx bx-trash"></i></button>';
        }

        function deleteRowBansos(button) {
            const row = button.parentNode.parentNode;
            const table = row.parentNode;
            table.removeChild(row);
        }

        function changeTembusan(event) {
            const kadis = $(event).attr('id');
            if ($('#' + kadis).is(":checked")) {
                document.getElementById(kadis + "_pilihan_content").style.display = "block";
            } else {
                document.getElementById(kadis + "_pilihan_content").style.display = "none";
            }
        }

        function changeMediaPengaduan(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value === "Lainnya") {
                document.getElementById("_media_pengaduan_detail").style.display = "block";
            } else {
                document.getElementById("_media_pengaduan_detail").style.display = "none";
            }
        }

        function changeKecamatan(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getKelurahan',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.kelurahan').html("");
                        $('div._kampung_pilihan_content').block({
                            message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div._kampung_pilihan_content').unblock();
                        if (resul.status == 200) {
                            $('.kampung_pilihan').html(resul.data);
                        } else {
                            if (resul.status == 401) {
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
                        $('div._kampung_pilihan_content').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        }

        function validateForm() {
            const uraianPermasalahan = document.getElementById('_uraian_permasalahan').value;
            const pokokPermasalahan = document.getElementById('_pokok_permasalahan').value;
            const jawaban = document.getElementById('_jawaban').value;
            const saran_tindaklanjut = document.getElementById('_saran_tindaklanjut').value;
            const bansosRows = document.querySelectorAll('#table-bansos tbody tr');

            let isValid = true;

            if (uraianPermasalahan.trim() === '') {
                isValid = false;
                document.querySelector('._uraian_permasalahan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian permasalahan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._uraian_permasalahan').innerHTML = '';
            }

            if (pokokPermasalahan.trim() === '') {
                isValid = false;
                document.querySelector('._pokok_permasalahan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pokok permasalahan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._pokok_permasalahan').innerHTML = '';
            }

            if (jawaban.trim() === '') {
                isValid = false;
                document.querySelector('._jawaban').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jawaban tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._jawaban').innerHTML = '';
            }

            if (saran_tindaklanjut.trim() === '') {
                isValid = false;
                document.querySelector('._saran_tindaklanjut').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Saran tindaklanjut tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._saran_tindaklanjut').innerHTML = '';
            }

            if ($('#_kepala_dinas').is(":checked")) {
                const kepala_dinas_pilihan = document.getElementById('_kepala_dinas_pilihan').value;
                if (kepala_dinas_pilihan.trim() === '') {
                    isValid = false;
                    document.querySelector('._kepala_dinas_pilihan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan kepala dinas.</li></ul>';
                } else {
                    document.querySelector('._kepala_dinas_pilihan').innerHTML = '';
                }
            }

            if ($('#_camat').is(":checked")) {
                const camat_pilihan = document.getElementById('_camat_pilihan').value;
                if (camat_pilihan.trim() === '') {
                    isValid = false;
                    document.querySelector('._camat_pilihan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan camat.</li></ul>';
                } else {
                    document.querySelector('._camat_pilihan').innerHTML = '';
                }
            }

            if ($('#_kampung').is(":checked")) {
                const kampung_pilihan = document.getElementById('_kampung_pilihan').value;
                if (kampung_pilihan.trim() === '') {
                    isValid = false;
                    document.querySelector('._kampung_pilihan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan kepala kampung/kelurahan.</li></ul>';
                } else {
                    document.querySelector('._kampung_pilihan').innerHTML = '';
                }
            }

            // console.log(bansosRows.length);

            bansosRows.forEach(function(row, index) {
                // if (index === 0) {

                // } else {
                const namaF = row.querySelector('input[name="nama_pemilik_bansos[]"]');
                const nikF = row.querySelector('input[name="nik_pemilik_bansos[]"]');

                if (!namaF || namaF === undefined || !nikF || nikF === undefined) {
                    isValid = false;
                    if (!namaF || namaF === undefined) {
                        row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama tidak boleh kosong</li></ul>';
                    } else {
                        const nama = namaF.value;
                        if (nama.trim() === '') {
                            row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama tidak boleh kosong</li></ul>';
                        } else {
                            row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '';
                        }
                    }
                    if (!nikF || nikF === undefined) {
                        row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK tidak boleh kosong</li></ul>';
                    } else {
                        const nik = nikF.value;
                        if (nik.trim() === '') {
                            row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK tidak boleh kosong</li></ul>';
                        } else {
                            row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '';
                        }
                    }

                } else {

                    const nama = namaF.value;
                    const nik = nikF.value;

                    if (nama.trim() === '' || nik.trim() === '') {
                        isValid = false;
                        if (nama.trim() === '') {
                            row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama tidak boleh kosong</li></ul>';
                        } else {
                            row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '';
                        }
                        if (nik.trim() === '') {
                            row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK tidak boleh kosong</li></ul>';
                        } else {
                            row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '';
                        }
                    } else {
                        row.querySelector('.nama_pemilik_bansos_' + index).innerHTML = '';
                        row.querySelector('.nik_pemilik_bansos_' + index).innerHTML = '';
                    }
                }

                const dtks = row.querySelector("input[type='radio'][name='_dtks_bansos_" + index + "']:checked");
                // const dtks = row.querySelector("input[type='radio'][name='_dtks_bansos_" + index + "']:checked").val();
                const pkh = row.querySelector("input[type='radio'][name='_pkh_bansos_" + index + "']:checked");
                const bpnt = row.querySelector("input[type='radio'][name='_bpnt_bansos_" + index + "']:checked");
                const pbi_jk = row.querySelector("input[type='radio'][name='_pbi_jk_bansos_" + index + "']:checked");
                const rst = row.querySelector("input[type='radio'][name='_rst_bansos_" + index + "']:checked");
                const bansos_lain = row.querySelector("input[type='radio'][name='_bansos_lain_bansos_" + index + "']:checked");

                // console.log(dtks);
                // console.log(pkh);
                // console.log(bpnt);
                // console.log(pbi_jk);
                // console.log(rst);

                if (!dtks || dtks === undefined || !pkh || pkh === undefined || !bpnt || bpnt === undefined || !pbi_jk || pbi_jk === undefined || !rst || rst === undefined || !bansos_lain || bansos_lain === undefined) {
                    isValid = false;
                    if (!dtks || dtks === undefined) {
                        row.querySelector('._dtks_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih DTKS dulu.</li></ul>';
                    } else {
                        row.querySelector('._dtks_bansos_' + index).innerHTML = '';
                    }
                    if (!pkh || pkh === undefined) {
                        row.querySelector('._pkh_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih PKH dulu.</li></ul>';
                    } else {
                        row.querySelector('._pkh_bansos_' + index).innerHTML = '';
                    }
                    if (!bpnt || bpnt === undefined) {
                        row.querySelector('._bpnt_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih BPNT dulu.</li></ul>';
                    } else {
                        row.querySelector('._bpnt_bansos_' + index).innerHTML = '';
                    }
                    if (!pbi_jk || pbi_jk === undefined) {
                        row.querySelector('._pbi_jk_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih PBI JK dulu.</li></ul>';
                    } else {
                        row.querySelector('._pbi_jk_bansos_' + index).innerHTML = '';
                    }
                    if (!rst || rst === undefined) {
                        row.querySelector('._rst_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih RST dulu.</li></ul>';
                    } else {
                        row.querySelector('._rst_bansos_' + index).innerHTML = '';
                    }
                    if (!bansos_lain || bansos_lain === undefined) {
                        row.querySelector('._bansos_lain_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Bansos lain dulu.</li></ul>';
                    } else {
                        row.querySelector('._bansos_lain_bansos_' + index).innerHTML = '';
                    }
                } else {
                    const dtksv = dtks.value;
                    console.log(dtksv);
                    const pkhv = pkh.value;
                    const bpntv = bpnt.value;
                    const pbi_jkv = pbi_jk.value;
                    const rstv = rst.value;
                    const bansos_lainv = bansos_lain.value;
                    if (dtksv.trim() === '') {
                        row.querySelector('._dtks_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih DTKS dulu.</li></ul>';
                    } else {
                        row.querySelector('._dtks_bansos_' + index).innerHTML = '';
                    }
                    if (pkhv.trim() === '') {
                        row.querySelector('._pkh_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih PKH dulu.</li></ul>';
                    } else {
                        row.querySelector('._pkh_bansos_' + index).innerHTML = '';
                    }
                    if (bpntv.trim() === '') {
                        row.querySelector('._bpnt_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih BPNT dulu.</li></ul>';
                    } else {
                        row.querySelector('._bpnt_bansos_' + index).innerHTML = '';
                    }
                    if (pbi_jkv.trim() === '') {
                        row.querySelector('._pbi_jk_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih PBI JK dulu.</li></ul>';
                    } else {
                        row.querySelector('._pbi_jk_bansos_' + index).innerHTML = '';
                    }
                    if (rstv.trim() === '') {
                        row.querySelector('._rst_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih RST dulu.</li></ul>';
                    } else {
                        row.querySelector('._rst_bansos_' + index).innerHTML = '';
                    }
                    if (bansos_lainv.trim() === '') {
                        row.querySelector('._bansos_lain_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Bansos lain dulu.</li></ul>';
                    } else {
                        row.querySelector('._bansos_lain_bansos_' + index).innerHTML = '';
                    }
                    // row.querySelector('._dtks_bansos_' + (index - 1)).innerHTML = '';
                    // row.querySelector('._pkh_bansos_' + (index - 1)).innerHTML = '';
                    // row.querySelector('._bpnt_bansos_' + (index - 1)).innerHTML = '';
                    // row.querySelector('._pbi_jk_bansos_' + (index - 1)).innerHTML = '';
                    // row.querySelector('._rst_bansos_' + (index - 1)).innerHTML = '';
                    // row.querySelector('._bansos_lain_bansos_' + (index - 1)).innerHTML = '';
                }

                const keteranganF = row.querySelector('textarea[name="keterangan_pemilik_bansos[]"]');

                if (!keteranganF || keteranganF === undefined) {
                    row.querySelector('.keterangan_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Keterangan tidak boleh kosong</li></ul>';
                } else {
                    const keterangan = keteranganF.value;
                    if (keterangan.trim() === '') {
                        row.querySelector('.keterangan_pemilik_bansos_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Keterangan tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.keterangan_pemilik_bansos_' + index).innerHTML = '';
                    }
                }
                // }
            });

            return isValid;
        }


        function downloadPDF(pdf, fileName, redirrect) {
            // const linkSource = `data:application/octet-stream;base64,${pdf}`;
            const linkSource = `${pdf}`;
            const newTab = window.open(linkSource, '_blank');
            if (!newTab) {
                Swal.fire(
                    'WARNING!',
                    "Popup blocked. Please allow popups for this website and try again.",
                    'warning'
                );
            } else {
                reloadPage(redirrect);
            }
            // const linkSource = `data:application/octet-stream;base64,${pdf}`;
            // const downloadLink = document.createElement("a");
            // downloadLink.href = linkSource;
            // downloadLink.download = fileName + ".pdf";
            // downloadLink.click();
        }


        function saveTanggapanPengaduan(e) {
            // console.log(e.form);
            if (validateForm()) {
                $('div.modal-content-loading-approve').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
                let formData = new FormData(document.getElementById('tindakLanjutPengaduanForm'));
                // var formData = new FormData(e.form);

                fetch('./tanggapi', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(resul => {
                        $('div.modal-content-loading-approve').unblock();
                        if (resul.status !== 200) {
                            if (resul.status === 401) {
                                Swal.fire(
                                    'Failed!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage();
                                });
                            } else {
                                // e.disabled = false;
                                Swal.fire(
                                    'GAGAL!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        } else {
                            Swal.fire({
                                title: 'SELAMAT!',
                                text: resul.message,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Tutup',
                                confirmButtonText: 'Download'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    downloadPDF(resul.filenya, resul.filename, resul.redirrect);
                                    // setTimeout(function() {
                                    //     reloadPage(resul.redirrect);
                                    // }, 3000);
                                } else {
                                    reloadPage(resul.redirrect);
                                }
                            })
                            // Swal.fire(
                            //     'SELAMAT!',
                            //     resul.message,
                            //     'success'
                            // ).then((valRes) => {
                            //     reloadPage(resul.redirrect);
                            // })
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                        $('div.modal-content-loading-approve').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    });
            }


            // const uraian_permasalahan = document.getElementsByName('_uraian_permasalahan')[0].value;
            // const pokok_permasalahan = document.getElementsByName('_pokok_permasalahan')[0].value;

            // const dtks = $("input[type='radio'][name='_dtks']:checked").val();
            // const pkh = $("input[type='radio'][name='_pkh']:checked").val();
            // const bpnt = $("input[type='radio'][name='_bpnt']:checked").val();
            // const rst = $("input[type='radio'][name='_rst']:checked").val();
            // const bansos_lain_option = $("input[type='radio'][name='_bansos_lain_option']:checked").val();
            // const bansos_lain = document.getElementsByName('_bansos_lain')[0].value;
            // const kepersertaan_jamkesnas_option = $("input[type='radio'][name='_kepersertaan_jamkesnas_option']:checked").val();
            // const kepersertaan_jamkesnas = document.getElementsByName('_kepersertaan_jamkesnas')[0].value;

            // const jawaban = document.getElementsByName('_jawaban')[0].value;
            // const saran_tindaklanjut = document.getElementsByName('_saran_tindaklanjut')[0].value;

            // let kepala_dinas;
            // if ($('#_kepala_dinas').is(":checked")) {
            //     kepala_dinas = 1;
            // } else {
            //     kepala_dinas = 0;
            // }
            // const kepala_dinas_pilihan = document.getElementsByName('_kepala_dinas_pilihan')[0].value;

            // let camat;
            // if ($('#_camat').is(":checked")) {
            //     camat = 1;
            // } else {
            //     camat = 0;
            // }
            // const camat_pilihan = document.getElementsByName('_camat_pilihan')[0].value;

            // let kampung;
            // if ($('#_kampung').is(":checked")) {
            //     kampung = 1;
            // } else {
            //     kampung = 0;
            // }
            // const kampung_pilihan = document.getElementsByName('_kampung_pilihan')[0].value;

            // const media_pengaduan = document.getElementsByName('_media_pengaduan')[0].value;
            // const media_pengaduan_detail = document.getElementsByName('_media_pengaduan_detail')[0].value;

            // if (media_pengaduan === "" || media_pengaduan === undefined) {
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Media pengaduan tidak boleh kosong.",
            //         'warning'
            //     );
            //     return;
            // }
            // if (media_pengaduan === "lainnya") {
            //     if (media_pengaduan_detail === "" || media_pengaduan_detail === undefined) {
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Silahkan masukkan jenis media pengaduan lain.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // if (uraian_permasalahan === "" || uraian_permasalahan === undefined) {
            //     $("textarea#_uraian_permasalahan").css("color", "#dc3545");
            //     $("textarea#_uraian_permasalahan").css("border-color", "#dc3545");
            //     $('._uraian_permasalahan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan masukkan uraian permasalahan.</li></ul>');
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Uraian Permasalahan tidak boleh kosong.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (pokok_permasalahan === "" || pokok_permasalahan === undefined) {
            //     $("textarea#_pokok_permasalahan").css("color", "#dc3545");
            //     $("textarea#_pokok_permasalahan").css("border-color", "#dc3545");
            //     $('._pokok_permasalahan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan masukkan pokok permasalahan.</li></ul>');
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Pokok Permasalahan tidak boleh kosong.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (dtks === "ya" || dtks === "tidak") {} else {
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Kepersertaan bansos DTKS harus dipilih.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (pkh === "ya" || pkh === "tidak") {} else {
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Kepersertaan bansos PKH harus dipilih.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (bpnt === "ya" || bpnt === "tidak") {} else {
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Kepersertaan bansos BPNT harus dipilih.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (rst === "ya" || rst === "tidak") {} else {
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Kepersertaan bansos RST(Rumah Sederhana Terpadu) harus dipilih.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (bansos_lain === "" || bansos_lain === undefined) {} else {
            //     if (bansos_lain_option === "ya" || bansos_lain_option === "tidak") {} else {
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Kepersertaan bansos lainya harus dipilih.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // if (kepersertaan_jamkesnas === "" || kepersertaan_jamkesnas === undefined) {} else {
            //     if (kepersertaan_jamkesnas_option === "aktif" || kepersertaan_jamkesnas_option === "tidak") {} else {
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Kepersertaan jaminan kesehatan nasional (JKN) harus dipilih.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // if (jawaban === "" || jawaban === undefined) {
            //     $("textarea#_jawaban").css("color", "#dc3545");
            //     $("textarea#_jawaban").css("border-color", "#dc3545");
            //     $('._jawaban').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan masukkan jawaban.</li></ul>');
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Jawaban tidak boleh kosong.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (saran_tindaklanjut === "" || saran_tindaklanjut === undefined) {
            //     $("textarea#_saran_tindaklanjut").css("color", "#dc3545");
            //     $("textarea#_saran_tindaklanjut").css("border-color", "#dc3545");
            //     $('._saran_tindaklanjut').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan masukkan saran tidaklanjut.</li></ul>');
            //     Swal.fire(
            //         'PERINGATAN!!!',
            //         "Saran tindaklanjut tidak boleh kosong.",
            //         'warning'
            //     );
            //     return;
            // }

            // if (kepala_dinas === 1) {
            //     if (kepala_dinas_pilihan === "" || kepala_dinas_pilihan === undefined) {
            //         $("select#_kepala_dinas_pilihan").css("color", "#dc3545");
            //         $("select#_kepala_dinas_pilihan").css("border-color", "#dc3545");
            //         $('._kepala_dinas_pilihan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan kepala dinas.</li></ul>');
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Tembusan kepala dinas harus di pilih.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // if (camat === 1) {
            //     if (camat_pilihan === "" || camat_pilihan === undefined) {
            //         $("select#_camat_pilihan").css("color", "#dc3545");
            //         $("select#_camat_pilihan").css("border-color", "#dc3545");
            //         $('._camat_pilihan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan camat.</li></ul>');
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Tembusan camat harus di pilih.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // if (kampung === 1) {
            //     if (kampung_pilihan === "" || kampung_pilihan === undefined) {
            //         $("select#_kampung_pilihan").css("color", "#dc3545");
            //         $("select#_kampung_pilihan").css("border-color", "#dc3545");
            //         $('._kampung_pilihan').html('<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih tembusan kepala kampung.</li></ul>');
            //         Swal.fire(
            //             'PERINGATAN!!!',
            //             "Tembusan kepala kampung harus di pilih.",
            //             'warning'
            //         );
            //         return;
            //     }
            // }

            // $.ajax({
            //     url: "./tanggapi",
            //     type: 'POST',
            //     data: {
            //         id: '<?= $data->id ?>',
            //         nama: '<?= str_replace('&#039;', "`", str_replace("'", "`", $nama)) ?>',
            //         media_pengaduan: media_pengaduan,
            //         media_pengaduan_detail: media_pengaduan_detail,
            //         uraian_permasalahan: uraian_permasalahan,
            //         pokok_permasalahan: pokok_permasalahan,
            //         dtks: dtks,
            //         pkh: pkh,
            //         bpnt: bpnt,
            //         rst: rst,
            //         bansos_lain: bansos_lain,
            //         bansos_lain_option: bansos_lain_option,
            //         kepersertaan_jamkesnas: kepersertaan_jamkesnas,
            //         kepersertaan_jamkesnas_option: kepersertaan_jamkesnas_option,
            //         jawaban: jawaban,
            //         saran_tindaklanjut: saran_tindaklanjut,
            //         kepala_dinas: kepala_dinas,
            //         kepala_dinas_pilihan: kepala_dinas_pilihan,
            //         camat: camat,
            //         camat_pilihan: camat_pilihan,
            //         kampung: kampung,
            //         kampung_pilihan: kampung_pilihan,
            //     },
            //     dataType: 'JSON',
            //     beforeSend: function() {
            //         e.disabled = true;
            //         $('div.modal-content-loading-approve').block({
            //             message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            //         });
            //     },
            //     success: function(resul) {
            //         $('div.modal-content-loading-approve').unblock();

            //         if (resul.status !== 200) {
            //             if (resul.status === 401) {
            //                 Swal.fire(
            //                     'Failed!',
            //                     resul.message,
            //                     'warning'
            //                 ).then((valRes) => {
            //                     reloadPage();
            //                 });
            //             } else {
            //                 e.disabled = false;
            //                 Swal.fire(
            //                     'GAGAL!',
            //                     resul.message,
            //                     'warning'
            //                 );
            //             }
            //         } else {
            //             Swal.fire(
            //                 'SELAMAT!',
            //                 resul.message,
            //                 'success'
            //             ).then((valRes) => {
            //                 reloadPage(resul.redirrect);
            //             })
            //         }
            //     },
            //     error: function(erro) {
            //         console.log(erro);
            //         // e.attr('disabled', false);
            //         e.disabled = false
            //         $('div.modal-content-loading-approve').unblock();
            //         Swal.fire(
            //             'PERINGATAN!',
            //             "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
            //             'warning'
            //         );
            //     }
            // });
        };
    </script>
<?php endif; ?>
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
                <div class="row">
                    <div class="col-lg-6">
                        <label class="col-form-label">Nama (Subjek):</label>
                        <input type="text" class="form-control" value="<?= $data->nama_aduan ?>" readonly />
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Alamat (Subjek):</label>
                        <textarea class="form-control" readonly><?= $data->alamat_aduan ?></textarea>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Kecamatan (Subjek):</label>
                        <input type="text" class="form-control" value="<?= getNamaKecamatan($data->kecamatan_aduan) ?>" readonly />
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Kelurahan (Subjek):</label>
                        <input type="text" class="form-control" value="<?= getNamaKelurahan($data->kelurahan_aduan) ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">SPT Assesment PPKS (Backoffice):</label>
                <table id="table-spt" class="table-spt">
                    <thead>
                        <tr>
                            <th width="40%">Nama</th>
                            <th width="15%">NIK</th>
                            <th width="25%">Jabatan</th>
                            <th width="15%">Keterangan</th>
                            <th width="5%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="vertical-align: top;"><select class="form-control select2" id="nama_spt_0" name="nama_spt[]" onchange="changeSdm(this, 0)" style="width: 100%;">
                                    <option value=""> --- Pilih SDM 1 --- </option>
                                    <?php if (isset($sdm)) { ?>
                                        <?php if (count($sdm) > 0) { ?>
                                            <?php foreach ($sdm as $key => $value) { ?>
                                                <option value="<?= $value->nik ?>"><?= str_replace('&#039;', " ", str_replace("'", " ", str_replace("`", " ", $value->nama))) ?> - <?= $value->nik ?> - <?= $value->jabatan ?> <?= $value->kecamatan ? '(' . ($value->kelurahan ? ' - ' . $value->kelurahan : '') . ')' : '' ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <br />
                                <div class="help-block nama_spt_0"></div>
                            </td>
                            <td style="vertical-align: top;"><input class="form-control" type="text" id="nik_spt_0" name="nik_spt[]" readonly />
                                <div class="help-block nik_spt_0"></div>
                            </td>
                            <td style="vertical-align: top;"><input class="form-control" type="text" id="jabatan_spt_0" name="jabatan_spt[]" readonly />
                                <div class="help-block jabatan_spt_0"></div>
                            </td>
                            <td style="vertical-align: top;"><textarea class="form-control" id="keterangan_spt_0" name="keterangan_spt[]" readonly></textarea>
                                <div class="help-block keterangan_spt_0"></div>
                            </td>
                            <td style="vertical-align: top;">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button type="button" id="btnAddRow" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bxs-add-to-queue label-icon"></i> Tambah Peserta SPT PPKS</button>
                <br>
            </div>
            <hr />
            <div class="col-lg-6">
                <label class="col-form-label">Tanggal SPT PPKS (Backoffice):</label>
                <input type="date" class="form-control" id="_tgl_spt" name="_tgl_spt" required></input>
                <div class="help-block _tgl_spt"></div>
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Lokasi Tujuan (Backoffice):</label>
                <textarea rows="5" class="form-control" id="_lokasi_tujuan" name="_lokasi_tujuan" required></textarea>
                <div class="help-block _lokasi_tujuan"></div>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="saveTanggapanPengaduan(this)" class="btn btn-primary waves-effect waves-light">Simpan & Teruskan SPT</button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            initSelect2("nama_spt_0", ".contentApproveBodyModal");
            // initSelect2("_camat_pilihan", ".contentApproveBodyModal");
            // initSelect2("_kampung_pilihan", ".contentApproveBodyModal");

            $("#btnAddRow").on("click", function() {
                addRow('table-spt');
            });
        });

        function addRow(event) {
            const table = document.getElementById(event);
            const rowCount = table.rows.length - 1;

            const newRow = table.insertRow(-1);
            const cells = [];

            for (let i = 0; i < 6; i++) {
                cells[i] = newRow.insertCell(i);
                // if (i > 1 && i < 8) {
                cells[i].setAttribute("style", "vertical-align: top;");
                // }
                // if (i === 9) {
                //     cells[i].setAttribute("style", "vertical-align: center;");
                // }
            }

            cells[0].innerHTML = `<select class="form-control select2" id="nama_spt_${rowCount}" name="nama_spt[]" onchange="changeSdm(this, ${rowCount})" style="width: 100%">
                                    <option value=""> --- Pilih SDM ${rowCount + 1} --- </option>
                                    <?php if (isset($sdm)) { ?>
                                        <?php if (count($sdm) > 0) { ?>
                                            <?php foreach ($sdm as $key => $value) { ?>
                                                <option value="<?= $value->nik ?>"><?= str_replace('&#039;', " ", str_replace("'", " ", str_replace("`", " ", $value->nama))) ?> - <?= $value->nik ?> - <?= $value->jabatan ?> <?= $value->kecamatan ? '(' . ($value->kelurahan ? ' - ' . $value->kelurahan : '') . ')' : '' ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <br />
                                <div class="help-block nama_spt_${rowCount}"></div>`;
            initSelect2(`nama_spt_${rowCount}`, ".contentApproveBodyModal");
            cells[1].innerHTML = `<input class="form-control" type="text" id="nik_spt_${rowCount}" name="nik_spt[]" readonly /><br />
                        <div class="help-block nik_spt_${rowCount}"></div>`;
            cells[2].innerHTML = `<input class="form-control" type="text" id="jabatan_spt_${rowCount}" name="jabatan_spt[]" readonly /><br />
                        <div class="help-block jabatan_spt_${rowCount}"></div>`;

            cells[3].innerHTML = `<textarea class="form-control" id="keterangan_spt_${rowCount}" name="keterangan_spt[]" readonly></textarea><div class="help-block keterangan_spt_${rowCount}"></div>`;
            cells[4].innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)"><i class="bx bx-trash"></i></button>';

        }

        function deleteRow(button) {
            const row = button.parentNode.parentNode;
            const table = row.parentNode;
            table.removeChild(row);
        }

        function changeSdm(event, key) {
            const color = $(event).attr('id');
            // $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getSdm',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Now loading',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        })

                        $('div._kampung_pilihan_content').block({
                            message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        Swal.close();
                        if (resul.status == 200) {
                            const nik_spt_auto = document.getElementById('nik_spt_' + key);
                            const jabatan_spt_auto = document.getElementById('jabatan_spt_' + key);
                            const keterangan_spt_auto = document.getElementById('keterangan_spt_' + key);
                            nik_spt_auto.value = resul.data.nik;
                            jabatan_spt_auto.value = resul.data.jabatan;
                            if (key !== 0) {
                                keterangan_spt_auto.value = 'Pengikut';
                            } else {
                                keterangan_spt_auto.value = '-';
                            }

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
                        Swal.close()
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
            const tgl_spt = document.getElementById('_tgl_spt').value;
            const lokasi_tujuan = document.getElementById('_lokasi_tujuan').value;
            const sptRows = document.querySelectorAll('#table-sptj tbody tr');

            let isValid = true;

            if (tgl_spt.trim() === '') {
                isValid = false;
                document.querySelector('._tgl_spt').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal SPT tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tgl_spt').innerHTML = '';
            }

            if (lokasi_tujuan.trim() === '') {
                isValid = false;
                document.querySelector('._lokasi_tujuan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Lokasi tujuan SPT tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._lokasi_tujuan').innerHTML = '';
            }

            sptRows.forEach(function(row, index) {
                // if (index === 0) {

                // } else {
                const namaF = row.querySelector('input[name="nama_spt[]"]');

                if (!namaF || namaF === undefined) {
                    isValid = false;
                    row.querySelector('.nama_spt_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih peserta SPT</li></ul>';
                } else {
                    const nama = namaF.value;
                    if (nama.trim() === '') {
                        row.querySelector('.nama_spt_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Silahkan pilih peserta SPT</li></ul>';
                    } else {
                        row.querySelector('.nama_spt_' + index).innerHTML = '';
                    }
                }

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

                fetch('./tanggapispt', {
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
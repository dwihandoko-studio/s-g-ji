<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <label class="col-form-label">Uraian Pengaduan (Dari Pengadu):</label>
            <textarea rows="5" class="form-control" id="_uraian_pengaduan" name="_uraian_pengaduan" readonly><?= $data->uraian_aduan ?></textarea>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Permasalahan (Dari Frontoffice):</label>
            <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" readonly></textarea>
            <div class="help-block _permasalahan"></div>
        </div>
        <div class="col-lg-12 mt-2">
            <div class="row mb-2">
                <label for="_media_pengaduan" class="col-sm-3 col-form-label">Media Pengaduan :</label>
                <div class="col-sm-8">
                    <select class="form-control select2 media_pengaduan" id="_media_pengaduan" name="_media_pengaduan" style="width: 100%" onchange="changeMediaPengaduan(this)">
                        <option value=""> --- Pilih Media Pengaduan ---</option>
                        <option value="Loket Pengaduan">Loket Pengaduan</option>
                        <option value="Website">Website</option>
                        <option value="Email">Email</option>
                        <option value="Aplikasi Layanan">Aplikasi Layanan</option>
                        <option value="E-lapor">E-lapor</option>
                        <option value="Call Center">Call Center</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <textarea rows="3" style="display: none; margin-top: 10px;" id="_media_pengaduan_detail" name="_media_pengaduan_detail" class="form-control" placeholder="Masukan keterangan peruntukan SKTM.."></textarea>
                    <div class="help-block _media_pengaduan"></div>
                    <div class="help-block _media_pengaduan_detail"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Uraian Permasalahan (Backoffice):</label>
            <textarea rows="5" class="form-control" id="_uraian_permasalahan" name="_uraian_permasalahan" required></textarea>
            <div class="help-block _uraian_permasalahan"></div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Pokok Permasalahan (Backoffice):</label>
            <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" required></textarea>
            <div class="help-block _permasalahan"></div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Kepesertaan Bansos (Backoffice):</label>
            <div class="row">
                <div class="col-lg-6 mt-2 mr-2" style="border: 1px solid #ced4da; border-radius: .25rem; padding-top: 20px;">
                    <h5 class="font-size-14">DTKS</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="_dtks" value="ya" id="_dtks_1">
                                    <label class="form-check-label" for="_dtks_1">
                                        Ya
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="_dtks" value="tidak" id="_dtks_2">
                                    <label class="form-check-label" for="_dtks_2">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mr-2" style="border: 1px solid #ced4da; border-radius: .25rem; padding-top: 20px;">
                    <h5 class="font-size-14">PKH</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="_pkh" value="ya" id="_pkh_1">
                                    <label class="form-check-label" for="_pkh_1">
                                        Ya
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="_pkh" value="tidak" id="_pkh_2">
                                    <label class="form-check-label" for="_pkh_2">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mr-2" style="border: 1px solid #ced4da; border-radius: .25rem; padding-top: 20px;">
                    <h5 class="font-size-14">BPNT (Sembako)</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="_bpnt" value="ya" id="_bpnt_1">
                                    <label class="form-check-label" for="_bpnt_1">
                                        Ya
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="_bpnt" value="tidak" id="_bpnt_2">
                                    <label class="form-check-label" for="_bpnt_2">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2 mr-2" style="border: 1px solid #ced4da; border-radius: .25rem; padding-top: 20px;">
                    <h5 class="font-size-14">RST (Rumah Sederhana Terpadu)</h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="_rst" value="ya" id="_rst_1">
                                    <label class="form-check-label" for="_rst_1">
                                        Ya
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="_rst" value="tidak" id="_rst_2">
                                    <label class="form-check-label" for="_rst_2">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-2 mr-2" style="border: 1px solid #ced4da; border-radius: .25rem; padding-top: 20px; padding-bottom: 20px;">
                    <h5 class="font-size-14">Bansos lainnya</h5>
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" class="form-control bansos_lain" id="_bansos_lain" name="_bansos_lain" placeholder="Bansos Lainnya.. " />
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mt-1">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="_bansos_lain_option" value="ya" id="_bansos_lain_option_1">
                                            <label class="form-check-label" for="_bansos_lain_option_1">
                                                Ya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="_bansos_lain_option" value="tidak" id="_bansos_lain_option_2">
                                            <label class="form-check-label" for="_bansos_lain_option_2">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Kepesertaan Jaminan Kesehatan Nasional (JKN):</label>
            <div class="row">
                <div class="col-lg-6">
                    <input type="text" class="form-control kepersertaan_jamkesnas" id="_kepersertaan_jamkesnas" name="_kepersertaan_jamkesnas" placeholder="Kepersertaan Jaminan Kesehatan.. " />
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mt-1">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="_kepersertaan_jamkesnas_option" value="aktif" id="_kepersertaan_jamkesnas_option_1">
                                    <label class="form-check-label" for="_kepersertaan_jamkesnas_option_1">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="_bansos_lain_option" value="tidak" id="_bansos_lain_option_2">
                                    <label class="form-check-label" for="_bansos_lain_option_2">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Jawaban (Backoffice):</label>
            <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" required></textarea>
            <div class="help-block _permasalahan"></div>
        </div>
        <div class="col-lg-12">
            <label class="col-form-label">Saran Tindaklanjut (Backoffice):</label>
            <textarea rows="5" class="form-control" id="_permasalahan" name="_permasalahan" required></textarea>
            <div class="help-block _permasalahan"></div>
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
                                                <option value="<?= $value->id ?>"><?= $value->dinas ?></option>
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
                                <select class="form-control select2 camat_pilihan" id="_camat_pilihan" name="_camat_pilihan" style="width: 100%">
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
                                <select class="form-control select2" id="_kampung_pilihan" name="_kampung_pilihan" style="width: 100%">
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
    <script>
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

        function saveTanggapanPengaduan(e) {
            const uraian = document.getElementsByName('_uraian_pengaduan')[0].value;
            const permasalahan = document.getElementsByName('_permasalahan')[0].value;
            const teruskan_ke = document.getElementsByName('_teruskan_ke')[0].value;
            if (uraian === "" || uraian === undefined) {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Uraian aduan tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            if (permasalahan === "" || permasalahan === undefined) {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Permasalahan tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            if (teruskan_ke === "") {
                Swal.fire(
                    'PERINGATAN!!!',
                    "Diteruskan ke tidak boleh kosong.",
                    'warning'
                );
                return;
            }
            $.ajax({
                url: "./teruskan",
                type: 'POST',
                data: {
                    id: '<?= $data->id ?>',
                    nama: '<?= str_replace('&#039;', "`", str_replace("'", "`", $nama)) ?>',
                    permasalahan: permasalahan,
                    teruskan_ke: teruskan_ke,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    e.disabled = true;
                    $('div.modal-content-loading-approve').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
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
                            e.disabled = false;
                            Swal.fire(
                                'GAGAL!',
                                resul.message,
                                'warning'
                            );
                        }
                    } else {
                        Swal.fire(
                            'SELAMAT!',
                            resul.message,
                            'success'
                        ).then((valRes) => {
                            reloadPage(resul.redirrect);
                        })
                    }
                },
                error: function(erro) {
                    console.log(erro);
                    // e.attr('disabled', false);
                    e.disabled = false
                    $('div.modal-content-loading-approve').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        };
    </script>
<?php } ?>
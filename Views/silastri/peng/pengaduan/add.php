<?= $this->extend('t-silastri/peng/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Buat Pengaduan</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="col-xl-12">
            <form id="formAddData" action="./addSave" method="post" enctype="multipart/form-data">
                <div class="card mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Permohonan Pengaduan</h4>
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nama" name="_nama" value="<?= $data->fullname ?>" placeholder="Nama lengkap.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nik" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nik" name="_nik" value="<?= $data->nik ?>" placeholder="NIK.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nohp" class="col-sm-3 col-form-label">No Handphone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nohp" name="_nohp" value="<?= $data->no_hp ?>" placeholder="No Handphone.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarean rows="2" class="form-control alamat" id="_alamat" name="_alamat" readonly><?= $data->alamat ?></textarean>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" id="_kecamatan" name="_kecamatan" value="<?= $data->kecamatan ?>" readonly />
                                        <input type="text" class="form-control kecamatan" id="_nama_kecamatan" name="_nama_kecamatan" value="<?= getNamaKecamatan($data->kecamatan) ?>" readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kampung" class="col-sm-3 col-form-label">Kampung</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" id="_kampung" name="_kampung" value="<?= $data->kelurahan ?>" readonly />
                                        <input type="text" class="form-control kampung" id="_nama_kampung" name="_nama_kampung" value="<?= getNamaKelurahan($data->kelurahan) ?>" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row mb-2">
                                    <label for="_kategori" class="col-sm-3 col-form-label">Kategori Aduan :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 kategori_aduan" id="_kategori" name="_kategori" style="width: 100%" onchange="changeJenis(this)">
                                            <option value=""> --- Pilih Kategori Aduan ---</option>
                                            <?php if (isset($jeniss)) {
                                                if (count($jeniss) > 0) {
                                                    foreach ($jeniss as $key => $value) { ?>
                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                            <?php }
                                                }
                                            } ?>
                                        </select>
                                        <textarea rows="3" style="display: none; margin-top: 10px;" id="_kategori_detail" name="_kategori_detail" class="form-control" placeholder="Masukan keterangan peruntukan SKTM.."></textarea>
                                        <div class="help-block _kategori"></div>
                                        <div class="help-block _kategori_detail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Identitas Subject Yang Diadukan</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-1">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="_identitas_pemohon" value="sama" id="_identitas_subject" onchange="changePengadu(this)" checked="">
                                                <label class="form-check-label" for="_identitas_subject">
                                                    Sama dengan pemohon
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="_identitas_pemohon" value="beda" onchange="changePengadu(this)" id="_identitas_subject_lain">
                                                <label class="form-check-label" for="_identitas_subject_lain">
                                                    Orang lain
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 data-aduan" id="data-aduan" style="display: none;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <label for="_nama_aduan" class="col-sm-3 col-form-label">Nama Lengkap yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nama_aduan" id="_nama_aduan" name="_nama_aduan" placeholder="Nama lengkap yang diadukan.. " />
                                                <div class="help-block _nama_aduan"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_nik_aduan" class="col-sm-3 col-form-label">NIK yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nik_aduan" id="_nik_aduan" name="_nik_aduan" placeholder="NIK yang diadukan.. " />
                                                <div class="help-block _nik_aduan"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_nohp_aduan" class="col-sm-3 col-form-label">No Handphone yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nohp_aduan" id="_nohp_aduan" name="_nohp_aduan" placeholder="No Handphone yang diadukan.. " />
                                                <div class="help-block _nohp_aduan"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <label for="_alamat_aduan" class="col-sm-3 col-form-label">Alamat yang diadukan</label>
                                            <div class="col-sm-9">
                                                <textarea rows="3" class="form-control alamat_aduan" id="_alamat_aduan" name="_alamat_aduan"></textarea>
                                                <div class="help-block _alamat_aduan"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_kecamatan_aduan" class="col-sm-3 col-form-label">Kecamatan (yang diadukan) :</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2 kecamatan_aduan" id="_kecamatan_aduan" name="_kecamatan_aduan" style="width: 100%" onchange="changeKecamatan(this)">
                                                    <option value=""> --- Pilih Kecamatan --- </option>
                                                    <?php if (isset($kecamatans)) { ?>
                                                        <?php if (count($kecamatans) > 0) { ?>
                                                            <?php foreach ($kecamatans as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <div class="help-block _kecamatan_aduan"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 select2-kelurahan-loading">
                                            <label for="_kelurahan_aduan" class="col-sm-3 col-form-label">Kelurahan (yang diadukan) :</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2 kelurahan_aduan" id="_kelurahan_aduan" name="_kelurahan_aduan" style="width: 100%">
                                                    <option value=""> --- Pilih Kecamatan Dulu --- </option>
                                                </select>
                                                <div class="help-block _kelurahan_aduan"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row mb-2">
                                    <label for="_uraian_aduan" class="col-sm-3 col-form-label">Uraian Pengaduan</label>
                                    <div class="col-sm-12">
                                        <textarea rows="4" class="form-control uraian_aduan" id="_uraian_aduan" name="_uraian_aduan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Lampiran Pengaduan</h4>
                                <p style="margin-bottom: 30px;">Silahkan lampirkan dokumen pengaduan jika ada.</p>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-3">
                                            <label for="_file_lampiran" class="form-label">Lampiran dokumen pengaduan: </label>
                                            <input class="form-control" type="file" id="_file_lampiran" name="_file_lampiran" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_lampiran', 'Lampiran Dokumen Pengaduan')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_lampiran" for="_file_lampiran"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 justify-content-end">
                                <button type="submit" id="save_button" name="save_button" class="btn btn-primary w-md save_button">KIRIM</button>
                            </div>
                            <div class="col-lg-9">
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="content-aktivasiModal" class="modal fade content-aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="content-aktivasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-aktivasi-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-aktivasiModalLabel">TAUTKAN INFO GTK DIGITAL ANDA</h5>
            </div>
            <div class="contentAktivasiBodyModal">
            </div>
        </div>
    </div>
</div>
<div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-content-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-detailModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="contentBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>

<script>
    initSelect2("_kategori", ".page-content");
    initSelect2("_kecamatan_aduan", ".page-content");
    initSelect2("_kelurahan_aduan", ".page-content");

    $("#formAddData").on("submit", function(e) {
        e.preventDefault();
        const identitasAduan = $("input[type='radio'][name='_identitas_pemohon']:checked").val();

        const nama = document.getElementsByName('_nama')[0].value;
        const nik = document.getElementsByName('_nik')[0].value;
        const nohp = document.getElementsByName('_nohp')[0].value;
        const alamat = document.getElementsByName('_alamat')[0].value;
        const nama_kecamatan = document.getElementsByName('_kecamatan')[0].value;
        const nama_kampung = document.getElementsByName('_kampung')[0].value;

        let nama_aduan = document.getElementsByName('_nama_aduan')[0].value;
        let nik_aduan = document.getElementsByName('_nik_aduan')[0].value;
        let nohp_aduan = document.getElementsByName('_nohp_aduan')[0].value;
        let alamat_aduan = document.getElementsByName('_alamat_aduan')[0].value;
        let kecamatan_aduan = document.getElementsByName('_kecamatan_aduan')[0].value;
        let kelurahan_aduan = document.getElementsByName('_kelurahan_aduan')[0].value;

        const kategori = document.getElementsByName('_kategori')[0].value;
        const keterangan = document.getElementsByName('_kategori_detail')[0].value;

        const fileLampiran = document.getElementsByName('_file_lampiran')[0].value;

        const uraian_aduan = document.getElementsByName('_uraian_aduan')[0].value;

        if (jenis === "") {
            $("select#_kategori").css("color", "#dc3545");
            $("select#_kategori").css("border-color", "#dc3545");
            $('._kategori-error').html('Silahkan pilih kategori Pengaduan');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih kategori Pengaduan.",
                'warning'
            );
            return false;
        }

        if (identitasAduan === "beda") {
            if (nama_aduan === "") {
                $("input#_nama_aduan").css("color", "#dc3545");
                $("input#_nama_aduan").css("border-color", "#dc3545");
                $('._nama_aduan').html('Silahkan masukkan nama yang diadukan');
                return;
            }
            if (nik_aduan === "") {
                $("input#_nik_aduan").css("color", "#dc3545");
                $("input#_nik_aduan").css("border-color", "#dc3545");
                $('._nik_aduan').html('Silahkan masukkan NIK yang diadukan');
                return;
            }
            if (nohp_aduan === "") {
                $("input#_nohp_aduan").css("color", "#dc3545");
                $("input#_nohp_aduan").css("border-color", "#dc3545");
                $('._nohp_aduan').html('Silahkan masukkan no handphone yang diadukan');
                return;
            }
            if (alamat_aduan === "") {
                $("input#_alamat_aduan").css("color", "#dc3545");
                $("input#_alamat_aduan").css("border-color", "#dc3545");
                $('._alamat_aduan').html('Silahkan masukkan alamat yang diadukan');
                return;
            }
            if (kecamatan_aduan === "") {
                $("select#_kecamatan_aduan").css("color", "#dc3545");
                $("select#_kecamatan_aduan").css("border-color", "#dc3545");
                $('._kecamatan_aduan').html('Silahkan pilih kecamatan yang diadukan');
                return;
            }
            if (kelurahan_aduan === "") {
                $("select#_kelurahan_aduan").css("color", "#dc3545");
                $("select#_kelurahan_aduan").css("border-color", "#dc3545");
                $('._kelurahan_aduan').html('Silahkan pilih kelurahan yang diadukan');
                return;
            }
        } else {
            nama_aduan = nama;
            nik_aduan = nik;
            nohp_aduan = nohp;
            alamat_aduan = alamat;
            kecamatan_aduan = nama_kecamatan;
            kelurahan_aduan = nama_kampung;
        }

        if (uraian_aduan === "") {
            $("input#_uraian_aduan").css("color", "#dc3545");
            $("input#_uraian_aduan").css("border-color", "#dc3545");
            $('._uraian_aduan').html('Silahkan masukkan uraian aduan');
            return;
        }

        const formUpload = new FormData();

        if (fileLampiran !== "") {
            const file_lampiran = document.getElementsByName('_file_lampiran')[0].files[0];
            formUpload.append('_file', file_lampiran);
        }

        formUpload.append('nama', nama);
        formUpload.append('nik', nik);
        formUpload.append('nohp', nohp);
        formUpload.append('alamat', alamat);
        formUpload.append('kecamatan', nama_kecamatan);
        formUpload.append('kelurahan', nama_kampung);
        formUpload.append('nama_aduan', nama_aduan);
        formUpload.append('nik_aduan', nik_aduan);
        formUpload.append('nohp_aduan', nohp_aduan);
        formUpload.append('alamat_aduan', alamat_aduan);
        formUpload.append('kecamatan_aduan', kecamatan_aduan);
        formUpload.append('kelurahan_aduan', kelurahan_aduan);
        formUpload.append('kategori', kategori);
        formUpload.append('identitas_aduan', identitasAduan);
        formUpload.append('keterangan', keterangan);

        Swal.fire({
            title: 'Apakah anda yakin ingin mengirim pengaduan ini?',
            text: "Kirim pengaduan : " + kategori,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!'
        }).then((result) => {
            if (result.value) {
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
                    url: "./addSave",
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
                        $('div.main-content').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.main-content').unblock();

                        if (resul.status !== 200) {
                            // ambilId("status").innerHTML = "gagal";
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
                            // ambilId("status").innerHTML = resul.message;
                            ambilId("status").style.color = "green";
                            ambilId("progressBar").value = 100;
                            Swal.fire(
                                'SELAMAT!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage(resul.redirect);
                            })
                        }
                    },
                    error: function(erro) {
                        console.log(erro);
                        // ambilId("status").innerHTML = "Upload Failed";
                        ambilId("status").style.color = "red";
                        $('div.main-content').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        });

    });

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
                    $('.kelurahan_aduan').html("");
                    $('div.select2-kelurahan-loading').block({
                        message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.select2-kelurahan-loading').unblock();
                    if (resul.status == 200) {
                        $('.kelurahan_aduan').html(resul.data);
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
                    $('div.select2-kelurahan-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    }

    function changeJenis(event) {
        const color = $(event).attr('name');

        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value === "Lainnya") {
            document.getElementById("_kategori_detail").style.display = "block";
        } else {
            document.getElementById("_kategori_detail").style.display = "none";
        }
    }

    function changePengadu(event) {
        const color = $(event).attr('name');
        const vPengadu = $("input[type='radio'][name='" + color + "']:checked").val();

        $('.data-aduan').removeAttr('style');

        if (vPengadu === "sama") {
            document.getElementById("data-aduan").style.display = "none";
        } else {
            document.getElementById("data-aduan").style.display = "block";
        }
    }

    function changeValidation(event) {
        $('.' + event).css('display', 'none');
    };

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function inputChange(event) {
        console.log(event.value);
        if (event.value === null || (event.value.length > 0 && event.value !== "")) {
            $(event).removeAttr('style');
        } else {
            $(event).css("color", "#dc3545");
            $(event).css("border-color", "#dc3545");
            // $('.nama_instansi').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
        }
    }

    function ambilId(id) {
        return document.getElementById(id);
    }

    $('#formAddData').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });

    function initSelect2(event, parrent) {
        $('#' + event).select2({
            dropdownParent: parrent
        });
    }

    function removeLampiran(event, preview) {
        $('.imagePreviewUpload' + preview).removeAttr('src');
        document.getElementsByName(event)[0].value = "";
    }

    function loadFile(event, preview) {
        const input = document.getElementsByName(event)[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var mime_types = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];

            if (mime_types.indexOf(file.type) == -1) {
                input.value = "";
                $('.imagePreviewUpload' + preview).attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar dan pdf yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 2 * 1024 * 1000) {
                input.value = "";
                $('.imagePreviewUpload' + preview).attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 2 Mb.",
                    'warning'
                );
                return false;
            }

            if (file.type === 'application/pdf') {

            } else {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.imagePreviewUpload' + preview).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }

        } else {
            console.log("failed Load");
        }
    }

    $(document).ready(function() {});
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style>
    .preview-image-upload-ktp {
        position: relative;
    }

    .preview-image-upload-ktp .imagePreviewUploadKtp {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-ktp .btn-remove-preview-image-ktp {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadKtp:hover+.btn-remove-preview-image-ktp,
    .btn-remove-preview-image-ktp:hover {
        display: block;
    }

    .preview-image-upload-kk {
        position: relative;
    }

    .preview-image-upload-kk .imagePreviewUploadKk {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-kk .btn-remove-preview-image-kk {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadKk:hover+.btn-remove-preview-image-kk,
    .btn-remove-preview-image-kk:hover {
        display: block;
    }

    .preview-image-upload-pernyataan {
        position: relative;
    }

    .preview-image-upload-pernyataan .imagePreviewUploadPernyataan {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-pernyataan .btn-remove-preview-image-pernyataan {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadPernyataan:hover+.btn-remove-preview-image-pernyataan,
    .btn-remove-preview-image-pernyataan:hover {
        display: block;
    }

    .preview-image-upload-foto-rumah {
        position: relative;
    }

    .preview-image-upload-foto-rumah .imagePreviewUploadFotoRumah {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-foto-rumah .btn-remove-preview-image-foto-rumah {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadFotoRumah:hover+.btn-remove-preview-image-foto-rumah,
    .btn-remove-preview-image-foto-rumah:hover {
        display: block;
    }

    .ul-custom-style-sub-menu-action {
        list-style: none;
        padding-left: 0.5rem;
        border: 1px solid #ffffff2e;
        padding-top: 0.5rem;
        padding-right: 0.5rem;
        border-radius: 1.5rem;
    }

    .li-custom-style-sub-menu-action {
        border: 1px solid white;
        display: inline-block !important;
        padding: 0.3rem 0.5rem 0rem 0.3rem;
        margin-right: 0.3rem;
        margin-bottom: 0.5rem;
        border-radius: 2rem;
    }

    .custom-style-sub-menu-action {
        font-size: 1em;
        line-height: 1;
        height: 24px;
        color: #f6f6f6;
        display: inline-block;
        position: relative;
        text-align: center;
        font-weight: 500;
        box-sizing: border-box;
        margin-top: -15px;
        vertical-align: -webkit-baseline-middle;
    }
</style>
<?= $this->endSection(); ?>
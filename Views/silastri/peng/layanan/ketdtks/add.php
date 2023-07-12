<?= $this->extend('t-silastri/peng/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Buat Permohonan Surat Keterangan DTKS</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="col-xl-12">
            <form id="formAddData" action="./addSave" method="post" enctype="multipart/form-data">
                <div class="card mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Permohonan Surat Keterangan DTKS</h4>
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
                                    <label for="_kk" class="col-sm-3 col-form-label">KK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_kk" name="_kk" value="<?= $data->kk ?>" placeholder="KK.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control nama" id="_tempat_lahir" name="_tempat_lahir" value="<?= $data->tempat_lahir ?>" placeholder="Tempat lahir.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_tgl_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control nama" id="_tgl_lahir" name="_tgl_lahir" value="<?= $data->tgl_lahir ?>" readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control nama" id="_jenis_kelamin" name="_jenis_kelamin" value="<?= $data->jenis_kelamin === NULL || $data->jenis_kelamin === "" ? '-' : ($data->jenis_kelamin == "L" ? 'Laki-laki' : 'Perempuan') ?>" placeholder="Jenis kelamin.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <!-- 
                <div class="row justify-content-end">
                    <div class="col-sm-9">

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="horizontalLayout-Check">
                            <label class="form-check-label" for="horizontalLayout-Check">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </div>
                </div> -->
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_no_hp" class="col-sm-3 col-form-label">No HP.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_no_hp" name="_no_hp" value="<?= $data->no_hp ?>" placeholder="No handphone.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_kecamatan" name="_kecamatan" value="<?= getNamaKecamatan($data->kecamatan) ?>" placeholder="Kecamatan.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kelurahan" class="col-sm-3 col-form-label">Kelurahan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_kelurahan" name="_kelurahan" value="<?= getNamaKelurahan($data->kelurahan) ?>" placeholder="Kelurahan.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" class="form-control" id="_alamat" name="_alamat" readonly><?= $data->alamat ?></textarea>
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
                                    <label for="_jenis" class="col-sm-3 col-form-label">Jenis Keperluan :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 pekerjaan" id="_jenis" name="_jenis" style="width: 100%" onchange="changeJenis(this)">
                                            <option value=""> --- Pilih Keperluan ---</option>
                                            <?php if (isset($jeniss)) {
                                                if (count($jeniss) > 0) {
                                                    foreach ($jeniss as $key => $value) { ?>
                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                            <?php }
                                                }
                                            } ?>
                                        </select>
                                        <textarea rows="3" style="display: none; margin-top: 10px;" id="_jenis_detail" name="_jenis_detail" class="form-control" placeholder="Masukan keterangan peruntukan surat DTKS.."></textarea>
                                        <div class="help-block _jenis"></div>
                                        <div class="help-block _jenis_detail"></div>
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

<script>
    $("#formAddData").on("submit", function(e) {
        e.preventDefault();

        const nama = document.getElementsByName('_nama')[0].value;
        const nik = document.getElementsByName('_nik')[0].value;
        const kk = document.getElementsByName('_kk')[0].value;
        const jenis = document.getElementsByName('_jenis')[0].value;
        const keterangan = document.getElementsByName('_jenis_detail')[0].value;

        if (jenis === "") {
            $("select#_jenis").css("color", "#dc3545");
            $("select#_jenis").css("border-color", "#dc3545");
            $('._jenis-error').html('Silahkan pilih jenis SKTM');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih peruntukan SKTM.",
                'warning'
            );
            return false;
        }

        const formUpload = new FormData();

        formUpload.append('nama', nama);
        formUpload.append('nik', nik);
        formUpload.append('kk', kk);
        formUpload.append('jenis', jenis);
        formUpload.append('keterangan', keterangan);

        Swal.fire({
            title: 'Apakah anda yakin ingin mengajukan permohonan data ini?',
            text: "Ajukan permohonan " + jenis,
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan!'
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

    function changeJenis(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value === "Lainnya") {
            document.getElementById("_jenis_detail").style.display = "block";
        } else {
            document.getElementById("_jenis_detail").style.display = "none";
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
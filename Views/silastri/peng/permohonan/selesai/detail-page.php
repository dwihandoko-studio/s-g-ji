<?= $this->extend('t-silastri/su/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">DETAIL PERMOHONAN LAYANAN TELAH SELESAI</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="./data" class="btn btn-info btn-rounded waves-effect waves-light">Kembali</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">Detail Permohonan Layanan - <?= $data->jenis ?> - <?= $data->nik ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4>DATA PEMOHON</h4>
                            <div class="col-lg-6">
                                <label class="col-form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NIK:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik ?>" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">KK:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-describedby="kk" aria-label="KK" value="<?= $data->kk ?>" readonly />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Tempat Lahir:</label>
                                <input type="text" class="form-control" value="<?= $data->tempat_lahir ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Tanggal Lahir:</label>
                                <input type="text" class="form-control" value="<?= $data->tgl_lahir ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Jenis Kelamin:</label>
                                <div><?php switch ($data->jenis_kelamin) {
                                            case 'P':
                                                echo '<span class="badge badge-pill badge-soft-primary">Perempuan</span>';
                                                break;
                                            case 'L':
                                                echo '<span class="badge badge-pill badge-soft-primary">Laki-Laki</span>';
                                                break;
                                            default:
                                                echo '-';
                                                break;
                                        } ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Email:</label>
                                <input type="text" class="form-control" value="<?= $data->email ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">No Handphone:</label>
                                <input type="text" class="form-control" value="<?= $data->no_hp ?>" readonly />
                            </div>
                        </div>
                        <hr />
                        <div class="row mt-2">
                            <h4>DATA PERMOHONAN</h4>
                            <div class="col-lg-6">
                                <label class="col-form-label">Kode Permohonan:</label>
                                <input type="text" class="form-control" value="<?= $data->kode_permohonan ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Layanan:</label>
                                <input type="text" class="form-control" value="<?= $data->layanan ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Jenis:</label>
                                <textarea rows="3" class="form-control" readonly><?= $data->jenis ?></textarea>
                            </div>

                            <?php if (isset($data->lampiran_ktp)) { ?>
                                <div class="col-lg-12 mt-2">
                                    <label class="col-form-label">Lampiran Dokumen:</label>
                                    <br />
                                    <?php if (isset($data->lampiran_ktp)) { ?>
                                        <?php if ($data->lampiran_ktp === null || $data->lampiran_ktp === "") { ?>
                                        <?php } else { ?>
                                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_ktp ?>" id="nik">
                                                KTP
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($data->lampiran_kk)) { ?>
                                        <?php if ($data->lampiran_kk === null || $data->lampiran_kk === "") { ?>
                                        <?php } else { ?>
                                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_kk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_kk ?>" id="nik">
                                                Kartu Keluarga
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($data->lampiran_pernyataan)) { ?>
                                        <?php if ($data->lampiran_pernyataan === null || $data->lampiran_pernyataan === "") { ?>
                                        <?php } else { ?>
                                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_pernyataan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_pernyataan ?>" id="nik">
                                                Pernyataan
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (isset($data->lampiran_foto_rumah)) { ?>
                                        <?php if ($data->lampiran_foto_rumah === null || $data->lampiran_foto_rumah === "") { ?>
                                        <?php } else { ?>
                                            <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('uploads/sktm') . '/' . $data->lampiran_foto_rumah ?>','popup','width=600,height=600'); return false;" href="<?= base_url('uploads/sktm') . '/' . $data->lampiran_foto_rumah ?>" id="nik">
                                                Foto Rumah
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <hr />
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <button type="button" onclick="actionDownload(this)" class="btn btn-success waves-effect waves-light">Download Hasil Pengajuan Permohonan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Modal -->
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
<div id="content-tolakModal" class="modal fade content-tolakModal" tabindex="-1" role="dialog" aria-labelledby="content-tolakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-loading-tolak">
            <div class="modal-header">
                <h5 class="modal-title" id="content-tolakModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="contentTolakBodyModal">
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/dropzone/min/dropzone.min.js"></script>

<script>
    function downloadPDF(pdf, fileName) {
        // const linkSource = `data:application/pdf;base64,${pdf}`;
        const linkSource = `data:application/octet-stream;base64,${pdf}`;
        const downloadLink = document.createElement("a");
        // const fileName = "abc.pdf";
        downloadLink.href = linkSource;
        downloadLink.download = fileName;
        downloadLink.click();
    }

    function actionDownload(e) {
        const id = '<?= $data->id ?>';
        const nama = '<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>';

        $.ajax({
            url: "./download",
            type: 'POST',
            data: {
                id: id,
                nama: nama,
            },
            dataType: 'JSON',
            beforeSend: function() {
                e.disabled = true;
                $('div.main-content').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(resul) {
                $('div.main-content').unblock();

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
                    downloadPDF(msg.data, msg.filename);
                }
            },
            error: function(erro) {
                console.log(erro);
                // e.attr('disabled', false);
                e.disabled = false
                $('div.main-content').unblock();
                Swal.fire(
                    'PERINGATAN!',
                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    };

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

    $('#content-detailModal').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });

    function initSelect2(event, parrent) {
        $('#' + event).select2({
            dropdownParent: parrent
        });
    }

    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />

<style>
    .preview-image-upload {
        position: relative;
    }

    .preview-image-upload .imagePreviewUpload {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload .btn-remove-preview-image {
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

    .imagePreviewUpload:hover+.btn-remove-preview-image,
    .btn-remove-preview-image:hover {
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
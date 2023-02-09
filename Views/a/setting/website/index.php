<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">INFORMASI WEBSITE</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                            <li class="breadcrumb-item active">Horizontal Boxed Width</li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Informasi Website</h4>
                                <p class="card-title-desc">Informasi website instansi.</p>
                            </div>
                            <?php if (listHakAksesCustomAllowNew('setting', 'website', 'edit')) { ?>
                                <div class="col-6 text-end">
                                    <a href="javascript:actionEdit('1','informasi');" class="btn btn-primary btn-rounded waves-effect waves-light" style="min-width: 6rem;"><i class="bx bx-edit font-size-16 align-middle me-2"></i> Edit </a>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (isset($data)) { ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="_judul" class="col-form-label">Judul:</label>
                                    <input type="text" class="form-control fullname" value="<?= $data->judul ?>" readonly />
                                </div>
                                <div class="col-lg-12">
                                    <label for="_deskripsi" class="col-form-label">Deskripsi:</label>
                                    <textarea rows="5" class="form-control" readonly><?= $data->deskripsi ?></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label for="_alamat" class="col-form-label">Alamat:</label>
                                    <textarea rows="5" class="form-control" readonly><?= $data->alamat ?></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label for="_telp" class="col-form-label">Telp:</label>
                                    <input type="tel" class="form-control nohp" value="<?= $data->telp ?>" readonly />
                                </div>
                                <div class="col-lg-6">
                                    <label for="_email" class="col-form-label">E-mail:</label>
                                    <input type="text" class="form-control email" value="<?= $data->email ?>" readonly />
                                </div>
                                <div class="col-lg-12">
                                    <label for="_facebook" class="col-form-label">Facebook:</label>
                                    <input type="text" class="form-control email" value="<?= $data->facebook ?>" readonly />
                                </div>
                                <div class="col-lg-12">
                                    <label for="_twitter" class="col-form-label">Twitter:</label>
                                    <input type="text" class="form-control email" value="<?= $data->twitter ?>" readonly />
                                </div>
                                <div class="col-lg-12">
                                    <label for="_instagram" class="col-form-label">Instagram:</label>
                                    <input type="text" class="form-control email" value="<?= $data->instagram ?>" readonly />
                                </div>
                                <div class="col-lg-12">
                                    <label for="_maps" class="col-form-label">Maps:</label>
                                    <textarea rows="5" class="form-control" readonly><?= $data->maps ?></textarea>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="_warna" class="col-form-label">Warna:</label>
                                        <span class="sp-original-input-container" style="margin: 0px; display: flex;">
                                            <div class="sp-colorize-container sp-add-on" style="width: 36.5312px; border-radius: 4px; border: 1px solid rgb(206, 212, 218);">
                                                <div class="sp-colorize" style="background-color: <?php switch ($data->warna) {
                                                                                                        case 'blue':
                                                                                                            echo "royalblue";
                                                                                                            break;
                                                                                                        case 'green':
                                                                                                            echo "#72b626";
                                                                                                            break;
                                                                                                        case 'orange':
                                                                                                            echo "#fa5b0f";
                                                                                                            break;
                                                                                                        case 'purle':
                                                                                                            echo "#6957af";
                                                                                                            break;
                                                                                                        case 'yellow':
                                                                                                            echo "#ffb400";
                                                                                                            break;

                                                                                                        default:
                                                                                                            echo $data->warna;
                                                                                                            break;
                                                                                                    } ?>;"></div>
                                            </div><input type="text" class="form-control spectrum with-add-on" id="colorpicker-default" value="<?= $data->warna ?>" readonly>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="_instagram" class="col-form-label">Thema:</label>
                                    <input type="text" class="form-control email" value="<?= $data->thema ?>" readonly />
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="preview-image-upload">
                                                    <?php if ($data->logo !== null) { ?>
                                                        <img class="imagePreviewUpload" src="<?= base_url('uploads') . '/' . $data->logo ?>" id="imagePreviewUpload" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <label for="_css_map_googleapis" class="col-form-label">CSS Map Googleapis:</label>
                                    <textarea rows="3" class="form-control" readonly><?= $data->css_map_googleapis ?></textarea>
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <label for="_js_map_googleapis" class="col-form-label">JS Map Googleapis:</label>
                                    <textarea rows="3" class="form-control" readonly><?= $data->js_map_googleapis ?></textarea>
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <h5 class="font-size-14 mb-3">Status Maintenance</h5>
                                    <div>
                                        <input type="checkbox" id="status_publikasi" name="status_publikasi" switch="bool" <?= isset($data) ? ((int)$data->maintenance === 1 ? ' checked' : '') : '' ?> disabled />
                                        <label for="status_publikasi" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div style="background-color: #fff; padding: 1rem;">
                                <div class="text-center">Belum ada sejarah.</div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Modal -->
<div class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="content-detailModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="contentBodyModal">
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>
<script>
    function actionEdit(event, title) {
        <?php if (listHakAksesCustomAllowNew('setting', 'website', 'edit')) { ?>
            $.ajax({
                url: "<?= base_url('a/setting/website/edit') ?>",
                type: 'POST',
                data: {
                    id: event,
                    title: title,
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('div.main-content').block({
                        message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.main-content').unblock();

                    if (resul.status !== 200) {
                        Swal.fire(
                            'Failed!',
                            resul.message,
                            'warning'
                        );
                    } else {

                        $('#content-detailModalLabel').html('EDIT INFORMASI WEBSITE');
                        $('.contentBodyModal').html(resul.data);
                        $('.content-detailModal').modal({
                            backdrop: 'static',
                            keyboard: false,
                        });
                        $('.content-detailModal').modal('show');
                    }
                },
                error: function() {
                    $('div.main-content').unblock();
                    Swal.fire(
                        'Failed!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        <?php } else { ?>
            Swal.fire(
                'PERINGATAN!',
                "Anda tidak diizinkan untuk mengakses modul ini.",
                'danger'
            );
        <?php } ?>
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

    $('#contentModal').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });

    function initSelect2(event, parrent) {
        $('#' + event).select2({
            dropdownParent: parrent
        });
    }
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
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
</style>
<?= $this->endSection(); ?>
<?= $this->extend('t-situgu/ptk/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">KELENGKAPAN DOKUMEN MASTER</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="./" class="btn btn-primary btn-rounded waves-effect waves-light">Tambah Absen Semua PTK</a></li>
                        </ol>
                    </div> -->

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
                                <h4 class="card-title">Data Kelengkapan Dokumen Master || <?= $ptk->nama ?> (NUPTK: <?= $ptk->nuptk ?>)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Foto</th>
                                    <th data-orderable="false">Karpeg</th>
                                    <th data-orderable="false">KTP</th>
                                    <th data-orderable="false">NRG</th>
                                    <th data-orderable="false">NUPTK</th>
                                    <th data-orderable="false">Serdik</th>
                                    <th data-orderable="false">NPWP</th>
                                    <th data-orderable="false">Buku Rekening</th>
                                    <th data-orderable="false">Ijazah</th>
                                    <th data-orderable="false">Inpassing</th>
                                    <th data-orderable="false">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $row = [];
                                    switch ($ptk->is_locked) {
                                        case 1:
                                            $row[] = $ptk->lampiran_foto ? '<a href="' . base_url('upload/ptk/foto') . '/' . $ptk->lampiran_foto . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Foto</span></a>' : '-';
                                            $row[] = $ptk->lampiran_karpeg ? '<a href="' . base_url('upload/ptk/karpeg') . '/' . $ptk->lampiran_karpeg . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Karpeg</span></a>' : '-';
                                            $row[] = $ptk->lampiran_ktp ? '<a href="' . base_url('upload/ptk/ktp') . '/' . $ptk->lampiran_ktp . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran KTP</span></a>' : '-';
                                            $row[] = $ptk->lampiran_nrg ? '<a href="' . base_url('upload/ptk/nrg') . '/' . $ptk->lampiran_nrg . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NRG</span></a>' : '-';
                                            $row[] = $ptk->lampiran_nuptk ? '<a href="' . base_url('upload/ptk/nuptk') . '/' . $ptk->lampiran_nuptk . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NUPTK</span></a>' : '-';
                                            $row[] = $ptk->lampiran_npwp ? '<a href="' . base_url('upload/ptk/npwp') . '/' . $ptk->lampiran_npwp . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran NPWP</span></a>' : '-';
                                            $row[] = $ptk->lampiran_serdik ? '<a href="' . base_url('upload/ptk/serdik') . '/' . $ptk->lampiran_serdik . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Serdik</span></a>' : '-';
                                            $row[] = $ptk->lampiran_buku_rekening ? '<a href="' . base_url('upload/ptk/bukurekening') . '/' . $ptk->lampiran_buku_rekening . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Buku Rekening</span></a>' : '-';
                                            $row[] = $ptk->lampiran_ijazah ? '<a href="' . base_url('upload/ptk/ijazah') . '/' . $ptk->lampiran_ijazah . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Ijazah</span></a>' : '-';
                                            $row[] = $ptk->lampiran_impassing ? '<a href="' . base_url('upload/ptk/impassing') . '/' . $ptk->lampiran_impassing . '" target="_blank"><span class="badge rounded-pill badge-soft-primary font-size-11">Lampiran Inpassing</span></a>' : '-';
                                            $row[] = '<div class="text-center">
                                            <span class="badge rounded-pill badge-soft-success font-size-11">Terkunci</span>
                                            </div>';
                                            break;
                                        default:

                                            $row[] = $ptk->lampiran_foto ? '<a target="_blank" href="' . base_url('upload/ptk/foto') . '/' . $ptk->lampiran_foto . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Foto\',\'foto\',\'' . $ptk->lampiran_foto . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'Foto\',\'foto\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            if ($ptk->status_kepegawaian === "PNS" || $ptk->status_kepegawaian === "PPPK" || $ptk->status_kepegawaian === "PNS Diperbantukan" || $ptk->status_kepegawaian === "PNS Depag" || $ptk->status_kepegawaian === "CPNS") {
                                                $row[] = $ptk->lampiran_karpeg ? '<a target="_blank" href="' . base_url('upload/ptk/karpeg') . '/' . $ptk->lampiran_karpeg . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Karpeg\',\'karpeg\',\'' . $ptk->lampiran_karpeg . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                    '<a href="javascript:actionUpload(\'Karpeg\',\'karpeg\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            } else {
                                                $row[] = '-';
                                            }
                                            $row[] = $ptk->lampiran_ktp ? '<a target="_blank" href="' . base_url('upload/ptk/ktp') . '/' . $ptk->lampiran_ktp . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'KTP\',\'ktp\',\'' . $ptk->lampiran_ktp . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'KTP\',\'ktp\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_nrg ? '<a target="_blank" href="' . base_url('upload/ptk/nrg') . '/' . $ptk->lampiran_nrg . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'NRG\',\'nrg\',\'' . $ptk->lampiran_nrg . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'NRG\',\'nrg\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_nuptk ? '<a target="_blank" href="' . base_url('upload/ptk/nuptk') . '/' . $ptk->lampiran_nuptk . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'NUPTK\',\'nuptk\',\'' . $ptk->lampiran_nuptk . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'NUPTK\',\'nuptk\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_serdik ? '<a target="_blank" href="' . base_url('upload/ptk/serdik') . '/' . $ptk->lampiran_serdik . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Sertifikat Pendidik\',\'serdik\',\'' . $ptk->lampiran_serdik . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'Sertifikat Pendidik\',\'serdik\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_npwp ? '<a target="_blank" href="' . base_url('upload/ptk/npwp') . '/' . $ptk->lampiran_npwp . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'NPWP\',\'npwp\',\'' . $ptk->lampiran_npwp . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'NPWP\',\'npwp\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_buku_rekening ? '<a target="_blank" href="' . base_url('upload/ptk/bukurekening') . '/' . $ptk->lampiran_buku_rekening . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Buku Rekening\',\'buku_rekening\',\'' . $ptk->lampiran_buku_rekening . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'Buku Rekening\',\'buku_rekening\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            $row[] = $ptk->lampiran_ijazah ? '<a target="_blank" href="' . base_url('upload/ptk/ijazah') . '/' . $ptk->lampiran_ijazah . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Ijazah\',\'ijazah\',\'' . $ptk->lampiran_ijazah . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                '<a href="javascript:actionUpload(\'Ijazah\',\'ijazah\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            if ($ptk->status_kepegawaian === "PNS" || $ptk->status_kepegawaian === "PPPK" || $ptk->status_kepegawaian === "PNS Diperbantukan" || $ptk->status_kepegawaian === "PNS Depag" || $ptk->status_kepegawaian === "CPNS") {
                                                $row[] = '-';
                                            } else {
                                                $row[] = $ptk->lampiran_impassing ? '<a target="_blank" href="' . base_url('upload/ptk/impassing') . '/' . $ptk->lampiran_impassing . '"><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-show font-size-16 align-middle"></i></button>
                                            </a>
                                            <a href="javascript:actionEditFile(\'Inpassing\',\'inpassing\',\'' . $ptk->lampiran_impassing . '\');"><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1">
                                                <i class="bx bxs-edit-alt font-size-16 align-middle"></i></button>
                                            </a>' :
                                                    '<a href="javascript:actionUpload(\'Inpassing\',\'inpassing\')" class="btn btn-primary waves-effect waves-light">
                                                <i class="bx bx-upload font-size-16 align-middle me-2"></i> Upload
                                            </a>';
                                            }
                                            $row[] = '<div class="text-center">
                                                <span class="badge rounded-pill badge-soft-danger font-size-11">Terbuka</span>
                                            </div>';
                                            break;
                                    }

                                    foreach ($row as $key => $value) {
                                        echo '<td>' . $value . '</td>';
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- Modal -->
<div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
<!-- end modal -->
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/dropzone/min/dropzone.min.js"></script>

<script>
    function actionUpload(title, bulan) {
        $.ajax({
            url: "./formupload",
            type: 'POST',
            data: {
                bulan: bulan,
                title: title,
                id_ptk: '<?= $ptk->id ?>',
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
                    $('#content-detailModalLabel').html('Upload Lampiran ' + title);
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
    }

    function actionEditFile(title, bulan, old) {
        $.ajax({
            url: "./editformupload",
            type: 'POST',
            data: {
                bulan: bulan,
                old: old,
                id_ptk: '<?= $ptk->id ?>',
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
                    $('#content-detailModalLabel').html('Edit Lampiran ' + title);
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
        initSelect2("filter_tw", ".main-content");

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>/assets/libs/ckeditor5-custom/build/ckeditor.js"></script>
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
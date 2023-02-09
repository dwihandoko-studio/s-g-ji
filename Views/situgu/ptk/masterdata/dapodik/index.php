<?= $this->extend('t-situgu/ptk/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">PTK | DATA DAPODIK</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:actionEdit('<?= $data->nama ?>');" class="btn btn-primary btn-rounded waves-effect waves-light">Ubah Data PTK</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h2>DATA INDIVIDU</h2>
                            <div class="col-lg-6">
                                <label class="col-form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control" value="<?= $data->nama ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NIK:</label>
                                <input type="text" class="form-control" value="<?= $data->nik ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NUPTK:</label>
                                <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NIP:</label>
                                <input type="text" class="form-control" value="<?= $data->nip ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NRG:</label>
                                <input type="text" class="form-control" value="<?= $data->nrg ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">No Peserta:</label>
                                <input type="text" class="form-control" value="<?= $data->no_peserta ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">NPWP:</label>
                                <input type="text" class="form-control" value="<?= $data->npwp ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">No Rekening:</label>
                                <input type="text" class="form-control" value="<?= $data->no_rekening ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Cabang Bank:</label>
                                <input type="text" class="form-control" value="<?= $data->cabang_bank ?>" readonly />
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
                                <label class="col-form-label">Email Dapodik:</label>
                                <input type="text" class="form-control" value="<?= $data->email ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Email Akun:</label>
                                <input type="text" class="form-control" value="<?= $data->emailAkun ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">No Hanphone Dapodik:</label>
                                <input type="text" class="form-control" value="<?= $data->no_hp ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">No Hanphone Akun:</label>
                                <input type="text" class="form-control" value="<?= $data->nohpAkun ?>" readonly />
                                <?php switch ((int)$data->wa_verified) {
                                    case 1:
                                        echo '<span class="badge badge-pill badge-soft-success">WA Terverifikasi</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-pill badge-soft-danger">WA Tidak Tertaut</span>';
                                        break;
                                } ?>
                            </div>
                            <div class="col-lg-4 mt-4">

                                <?php if ($data->image !== null) { ?>
                                    <img class="imagePreviewUpload" src="<?= base_url('upload/user') . '/' . $data->image ?>" id="imagePreviewUpload" />
                                <?php } ?>

                            </div>
                        </div>
                        <div class="row">
                            <h2>DATA PENUGASAN</h2>
                            <div class="col-lg-6">
                                <label class="col-form-label">NPSN:</label>
                                <input type="text" class="form-control" value="<?= $data->npsn ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Tempat Tugas:</label>
                                <input type="text" class="form-control" value="<?= $data->tempat_tugas ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Status Tugas:</label>
                                <div><span class="badge badge-pill badge-soft-secondary"><?= $data->status_tugas ?></span></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Kecamatan:</label>
                                <input type="text" class="form-control" value="<?= $data->kecamatan ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Status PTK:</label>
                                <div><span class="badge badge-pill badge-soft-secondary"><?= $data->status_kepegawaian ?></span></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Mapel Diajarkan:</label>
                                <input type="text" class="form-control" value="<?= $data->mapel_diajarkan ?>" readonly />
                            </div>
                            <?php switch ($data->bidang_studi_sertifikasi) {
                                case '':
                                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                                    break;
                                case null:
                                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                                    break;
                                case '-':
                                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                                    break;
                                case ' ':
                                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                                    break;

                                default:
                                    echo `<div class="col-lg-6">
                        <label class="col-form-label">Sudah Sertifikasi:</label>
                        <div><span class="badge badge-pill badge-soft-success">Sudah</span></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Bidang Studi Sertifikasi:</label>
                        <input type="text" class="form-control" value="$data->bidang_studi_sertifikasi" readonly />
                    </div>`;
                                    break;
                            } ?>

                            <div class="col-lg-6">
                                <label class="col-form-label">Jam Mengajar Perminggu:</label>
                                <input type="text" class="form-control" value="<?= $data->jam_mengajar_perminggu ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">SK Pengangkatan:</label>
                                <input type="text" class="form-control" value="<?= $data->sk_pengangkatan ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">TMT Pengangkatan:</label>
                                <input type="text" class="form-control" value="<?php switch ($data->tmt_pengangkatan) {
                                                                                    case '':
                                                                                        echo '';
                                                                                        break;
                                                                                    case '-':
                                                                                        echo '';
                                                                                        break;
                                                                                    case NULL:
                                                                                        echo '';
                                                                                        break;
                                                                                    case '1900-01-01':
                                                                                        echo '';
                                                                                        break;

                                                                                    default:
                                                                                        echo $data->tmt_pengangkatan;
                                                                                        break;
                                                                                } ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">SK CPNS:</label>
                                <input type="text" class="form-control" value="<?= $data->sk_cpns ?>" readonly />
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Tanggal CPNS:</label>
                                <input type="text" class="form-control" value="<?php switch ($data->tgl_cpns) {
                                                                                    case '':
                                                                                        echo '';
                                                                                        break;
                                                                                    case '-':
                                                                                        echo '';
                                                                                        break;
                                                                                    case NULL:
                                                                                        echo '';
                                                                                        break;
                                                                                    case '1900-01-01':
                                                                                        echo '';
                                                                                        break;

                                                                                    default:
                                                                                        echo $data->tgl_cpns;
                                                                                        break;
                                                                                } ?>" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <h2>DATA KEPEGAWAIAN</h2>
                            <div class="col-lg-6">
                                <label class="col-form-label">Pangkat/Golongan:</label>
                                <div><?= $data->pangkat_golongan ?></div>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">TMT Pangkat:</label>
                                <div><?= $data->tmt_pangkat ?></div>
                            </div>
                            <div class="col-lg-3">
                                <label class="col-form-label">Masa Kerja Tahun:</label>
                                <div><?= $data->masa_kerja_tahun ?></div>
                            </div>
                            <div class="col-lg-3">
                                <label class="col-form-label">Masa Kerja Bulan:</label>
                                <div><?= $data->masa_kerja_bulan ?></div>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
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
    function actionEdit(event) {
        $.ajax({
            url: "./edit",
            type: 'POST',
            data: {
                action: 'edit',
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
                    $('#content-detailModalLabel').html('UBAH DATA PTK ' + event);
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

        // let tableDatatables = $('#data-datatables').DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     "order": [],
        //     "ajax": {
        //         "url": "./getAll",
        //         "type": "POST",

        //     },
        //     language: {
        //         processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        //     },
        //     "columnDefs": [{
        //         "targets": 0,
        //         "orderable": false,
        //     }],
        // });

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
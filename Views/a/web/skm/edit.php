<?= $this->extend('templates/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">UBAH SURVERI KEPUASAN MASYARAKAT</h4>

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

                        <h4 class="card-title">Survei Kepuasan Masyarakat</h4>
                        <p class="card-title-desc">Ubah survei kepuasan masyarakat.</p>

                        <form method="post" action="./save">
                            <input type="hidden" id="_id" name="_id" value="<?= isset($data) ? $data->id : '' ?>" />
                            <textarea id="isi" name="isi"><?= isset($data) ? $data->isi : '' ?></textarea>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success waves-effect waves-light" style="min-width: 20rem;">
                                    <i class="bx bx-save font-size-16 align-middle me-2"></i> S I M P A N
                                </button>
                            </div>
                        </form>

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

<script>
    let editorAdd;

    function initCkeditor() {
        ClassicEditor.create(document.querySelector('#isi'), {
            simpleUpload: {
                uploadUrl: "./uploadImage"
            }
        }).then(editors => {
            editorAdd = editors
        }).catch(error => {
            console.log(error);
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

    $('#contentModal').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });


    function initSelect2(event, parrent) {
        $('#' + event).select2({
            dropdownParent: parrent
        });
    }

    $(document).ready(function() {
        initCkeditor();
    });

    $("form").on("submit", function(e) {
        e.preventDefault();
        const isi = editorAdd.getData();

        if (isi.length < 5) {
            Swal.fire(
                "Peringatan!",
                "Isi dari konten skm minimal 5 kata.",
                "warning"
            );
            return true;
        }

        $.ajax({
            type: "POST",
            url: './save',
            data: {
                isi: isi,
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('div.main-content').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(msg) {
                if (msg.status != 200) {
                    if (msg.status !== 201) {
                        $('div.main-content').unblock();
                        Swal.fire(
                            "Gagal!",
                            msg.message,
                            "warning"
                        );
                    } else {
                        Swal.fire(
                            'Peringatan!',
                            msg.message,
                            'success'
                        ).then((valRes) => {
                            document.location.href = msg.redirect;
                        })
                    }
                } else {
                    Swal.fire(
                        'Berhasil!',
                        msg.message,
                        'success'
                    ).then((valRes) => {
                        document.location.href = msg.redirect;
                    })
                }
            },
            error: function(data) {
                $('div.main-content').unblock();
                Swal.fire(
                    'Gagal!',
                    "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<script src="<?= base_url() ?>/assets/libs/ckeditor5-custom/build/ckeditor.js"></script>
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
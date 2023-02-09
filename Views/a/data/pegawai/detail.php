<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="col-form-label">Judul Berita:</label>
                <div><?= $data->judul ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kategori Berita:</label>
                <div><?= $data->kategori ?></div>
            </div>
            <div class="col-lg-3">
                <label class="col-form-label">Tanggal Berita:</label>
                <div><?= $data->tanggal ?></div>
            </div>
            <div class="col-lg-3">
                <label class="col-form-label">Status Publikasi:</label>
                <div><?php switch ((int)$data->status) {
                            case 1:
                                $row[] = '<span class="badge badge-pill badge-soft-success">Terpublish</span>';
                                break;
                            default:
                                $row[] = '<span class="badge badge-pill badge-soft-danger">Tidak Terpublish</span>';
                                break;
                        } ?>
                </div>
            </div>
            <div class="col-lg-12">
                <label for="_isi" class="col-form-label">Isi Berita:</label>
                <div><?= $data->deskripsi ?></div>
            </div>
            <div class="col-lg-12 mt-4">

                <?php if ($data->image !== null) { ?>
                    <img class="imagePreviewUpload" src="<?= base_url('uploads/berita') . '/' . $data->image ?>" id="imagePreviewUpload" />
                <?php } ?>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
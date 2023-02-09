<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <label for="_fullname" class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control fullname" value="<?= $data->fullname ?>" readonly />
                <div class="help-block _fullname"></div>
            </div>
            <div class="col-lg-6">
                <label for="_nip" class="col-form-label">NIP / NIK:</label>
                <input type="text" class="form-control nip" value="<?= $data->nip ?>" readonly />
                <div class="help-block _nip"></div>
            </div>
            <div class="col-lg-6">
                <label for="_email" class="col-form-label">E-mail:</label>
                <input type="text" class="form-control email" value="<?= $data->email ?>" readonly />
                <div class="help-block _email"></div>
            </div>
            <div class="col-lg-6">
                <label for="_nohp" class="col-form-label">No Handphone:</label>
                <input type="text" class="form-control nohp" value="<?= $data->no_hp ?>" readonly />
                <div class="help-block _nohp"></div>
            </div>
            <div class="col-lg-12">
                <label for="_alamat" class="col-form-label">Alamat:</label>
                <textarea rows="5" class="form-control alamat" readonly><?= $data->alamat ?></textarea>
            </div>
            <div class="col-lg-4">
                <label for="_nohp" class="col-form-label">Status Aktif:</label>
                <input type="text" class="form-control nohp" value="<?= (int)$data->is_active === 1 ? ' Aktif' : ' Tidak Aktif' ?>" readonly />
                <div class="help-block _nohp"></div>
            </div>
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-6 mt-4">
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="preview-image-upload">
                                <?php if ($data->image !== null) { ?>
                                    <img class="imagePreviewUpload" src="<?= base_url('uploads/user') . '/' . $data->image ?>" id="imagePreviewUpload" />
                                <?php } else { ?>
                                    <img class="imagePreviewUpload" id="imagePreviewUpload" />
                                <?php } ?>
                                <button type="button" class="btn-remove-preview-image">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
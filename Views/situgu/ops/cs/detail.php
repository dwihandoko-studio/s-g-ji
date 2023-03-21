<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA ADUAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Pengadu:</label>
                <input type="text" class="form-control" value="<?= $data->fullname ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPSN:</label>
                <input type="text" class="form-control" value="<?= $data->npsn ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis Aduan:</label>
                <input type="text" class="form-control" value="<?= $data->jenis ?>" readonly />
            </div>
            <div class="col-lg-12">
                <label class="col-form-label">Konten Aduan:</label>
                <textarea rows="15" class="form-control" readonly><?= $data->isi ?></textarea>
            </div>
            <div class="col-lg-12 mt-4">
                <h4>Data PTK:</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NUPTK</th>
                                <th>Status Kepegawaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($ptks)) {
                                if (count($ptks) > 0) {
                                    foreach ($ptks as $key => $v) { ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $v->nama ?></td>
                                            <td><?= $v->nuptk ?></td>
                                            <td><span class="badge badge-pill badge-soft-success"><?= $v->status_kepegawaian ?></span></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tidak ada PTK yang dilampirkan.</td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6">Tidak ada PTK yang dilampirkan.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="row">
            <h2>DATA LAMPIRAN ADUAN</h2>
            <div class="col-lg-4">
                <label class="col-form-label">Lampiran Aduan:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="absen_1" aria-label="ABSEN 1" value="Lampirannya" readonly />
                    <?php if ($data->lampiran !== NULL) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/aduan') . '/' . $data->lampiran ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/aduan') . '/' . $data->lampiran ?>" id="nik">Lampiran</a>
                    <?php } else { ?>
                        <a class="btn btn-primary" href="javascript:;" id="nik">Tidak ada Lampiran</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if ($data->status_ajuan == 1 || $data->status_ajuan == 2) { ?>
                <?php if ($data->status_ajuan == 1) { ?>
                    <h2>ADUAN ANDA DITOLAK</h2>
                    <div class="col-lg-12">
                        <div class="">
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">Dengan Keterangan: </h4>
                                <p class="mb-0"><?= $data->keterangan ?></p>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <h2>ADUAN ANDA SELESAI DI PROSES</h2>
                    <div class="col-lg-12">
                        <div class="">
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Dengan Keterangan: </h4>
                                <p class="mb-0"><?= $data->keterangan ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
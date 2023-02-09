<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="col-form-label">Absen 1:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="absen_1" aria-label="ABSEN 1" value="<?= $data->bulan_1 ?> Hari" readonly />
                            <?php if ($data->lampiran_absen1 !== NULL) { ?>
                                <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen1 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen1 ?>" id="nik">Lihat Lampiran Absen 1</a>
                            <?php } else { ?>
                                <a href="<?= base_url('situgu/ops/doc/upkelengkapan/data') ?>" class="btn btn-warning">Belum Upload Lampiran Absen 1</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label">Absen 2:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="absen_2" aria-label="ABSEN 2" value="<?= $data->bulan_2 ?> Hari" readonly />
                            <?php if ($data->lampiran_absen2 !== NULL) { ?>
                                <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen2 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen2 ?>" id="nik">Lihat Lampiran Absen 2</a>
                            <?php } else { ?>
                                <a href="<?= base_url('situgu/ops/doc/upkelengkapan/data') ?>" class="btn btn-warning">Belum Upload Lampiran Absen 2</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label">Absen 3:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="absen_3" aria-label="ABSEN 3" value="<?= $data->bulan_3 ?> Hari" readonly />
                            <?php if ($data->lampiran_absen3 !== NULL) { ?>
                                <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen3 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $data->lampiran_absen3 ?>" id="nik">Lihat Lampiran Absen 3</a>
                            <?php } else { ?>
                                <a href="<?= base_url('situgu/ops/doc/upkelengkapan/data') ?>" class="btn btn-warning">Belum Upload Lampiran Absen 3</a>
                            <?php } ?>
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
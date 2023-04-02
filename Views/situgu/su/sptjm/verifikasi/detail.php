<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NUPTK</th>
                            <th>NPSN</th>
                            <th>Satuan Pendidikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data) > 0) { ?>
                            <?php $i = 0; ?>
                            <?php foreach ($data as $key => $value) {
                                $i++; ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $value->nama_ptk ?></td>
                                    <td><?= $value->nuptk ?></td>
                                    <td><?= $value->npsn ?></td>
                                    <td><?= $value->nama_sekolah ?></td>
                                    <td><?= $value->aksi ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if ($data[0]->lampiran_sptjm == NULL || $data[0]->lampiran_sptjm == "") { ?>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/verifikasi/sptjm') . '/' . $data[0]->lampiran_sptjm ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/verifikasi/sptjm') . '/' . $data[0]->lampiran_sptjm ?>" id="nik">
                        Lampiran SPTJM
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>

<?php } ?>
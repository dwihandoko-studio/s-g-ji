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
                            <?php foreach ($variable as $key => $value) {
                                $i++; ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $nama_ptk ?></td>
                                    <td><?= $nuptk ?></td>
                                    <td><?= $npsn ?></td>
                                    <td><?= $nama_sekolah ?></td>
                                    <td><?= $aksi ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>

<?php } ?>
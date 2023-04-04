<?php if (isset($import)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th colspan="6">DATA SIMTUN</th>
                                <th colspan="6">DATA USULAN</th>
                                <th>KETERANGAN</th>
                                <th>AKSI</th>
                            </tr>
                            <tr>
                                <th>NUPTK</th>
                                <th>NAMA</th>
                                <th>GOLONGAN</th>
                                <th>MK</th>
                                <th>GAJI POKOK</th>
                                <th>JJM SESUAI</th>
                                <th>NUPTK</th>
                                <th>NAMA</th>
                                <th>GOLONGAN</th>
                                <th>MK</th>
                                <th>GAJI POKOK</th>
                                <th>KET</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($import) > 0) { ?>
                                <?php foreach ($import as $key => $v) { ?>
                                    <?php if ($v->data_usulan == NULL || $v->data_usulan == "") { ?>
                                        <tr class="table-light">
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $v->nuptk ?></td>
                                            <td><?= $v->nama ?></td>
                                            <td><?= $v->golongan_code ?></td>
                                            <td><?= $v->masa_kerja ?></td>
                                            <td><?= $v->gaji_pokok ?></td>
                                            <td><?= $v->total_jjm_sesuai ?></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>Belum Mengusulkan</td>
                                            <td>Aksi</td>
                                        </tr>
                                    <?php } else { ?>
                                        <?php $keterangan = "";
                                        if (($v->data_usulan->lampiran_cuti == NULL || $v->data_usulan->lampiran_cuti == "") && ($v->data_usulan->lampiran_pensiun == NULL || $v->data_usulan->lampiran_pensiun == "") && ($v->data_usulan->lampiran_kematian == NULL || $v->data_usulan->lampiran_kematian == "")) {
                                            $keterangan .= "- ";
                                        }

                                        if (!($v->data_usulan->lampiran_cuti == NULL || $v->data_usulan->lampiran_cuti == "")) {
                                            $keterangan .= "Cuti ";
                                        }

                                        if (!($v->data_usulan->lampiran_pensiun == NULL || $v->data_usulan->lampiran_pensiun == "")) {
                                            $keterangan .= "Pensiun ";
                                        }

                                        if (!($v->data_usulan->lampiran_kematian == NULL || $v->data_usulan->lampiran_kematian == "")) {
                                            $keterangan .= "Kematian ";
                                        }
                                        ?>

                                        <?php if ($v->total_jjm_sesuai >= 24 && $v->total_jjm_sesuai <= 40) { ?>

                                            <?php if ($v->golongan == "" && !($v->nip == NULL || $v->nip == "")) { ?>
                                                <?php if ("IX" == $v->data_usulan->us_pang_golongan && $v->masa_kerja == $v->data_usulan->us_pang_mk_tahun && $v->gaji_pokok == $v->data_usulan->us_gaji_pokok) { ?>
                                                    <tr class="table-success">
                                                        <th scope="row"><?= $key + 1 ?></th>
                                                        <td><?= $v->nuptk ?></td>
                                                        <td><?= $v->nama ?></td>
                                                        <td><?= $v->golongan_code ?></td>
                                                        <td><?= $v->masa_kerja ?></td>
                                                        <td><?= $v->gaji_pokok ?></td>
                                                        <td><?= $v->total_jjm_sesuai ?></td>
                                                        <td><?= $v->data_usulan->nuptk ?></td>
                                                        <td><?= $v->data_usulan->nama ?></td>
                                                        <td><?= $v->data_usulan->us_pang_golongan ?></td>
                                                        <td><?= $v->data_usulan->us_pang_mk_tahun ?></td>
                                                        <td><?= $v->data_usulan->us_gaji_pokok ?></td>
                                                        <td><?= $keterangan ?></td>
                                                        <td>Siap Diusulkan SKTP</td>
                                                        <td>Aksi</td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr class="table-danger">
                                                        <th scope="row"><?= $key + 1 ?></th>
                                                        <td><?= $v->nuptk ?></td>
                                                        <td><?= $v->nama ?></td>
                                                        <td><?= $v->golongan_code ?></td>
                                                        <td><?= $v->masa_kerja ?></td>
                                                        <td><?= $v->gaji_pokok ?></td>
                                                        <td><?= $v->total_jjm_sesuai ?></td>
                                                        <td><?= $v->data_usulan->nuptk ?></td>
                                                        <td><?= $v->data_usulan->nama ?></td>
                                                        <td><?= $v->data_usulan->us_pang_golongan ?></td>
                                                        <td><?= $v->data_usulan->us_pang_mk_tahun ?></td>
                                                        <td><?= $v->data_usulan->us_gaji_pokok ?></td>
                                                        <td><?= $keterangan ?></td>
                                                        <td>Belum Update Dapodik</td>
                                                        <td>Aksi</td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if ($v->golongan == $v->data_usulan->us_pang_golongan && $v->masa_kerja == $v->data_usulan->us_pang_mk_tahun && $v->gaji_pokok == $v->data_usulan->us_gaji_pokok) { ?>
                                                    <tr class="table-success">
                                                        <th scope="row"><?= $key + 1 ?></th>
                                                        <td><?= $v->nuptk ?></td>
                                                        <td><?= $v->nama ?></td>
                                                        <td><?= $v->golongan_code ?></td>
                                                        <td><?= $v->masa_kerja ?></td>
                                                        <td><?= $v->gaji_pokok ?></td>
                                                        <td><?= $v->total_jjm_sesuai ?></td>
                                                        <td><?= $v->data_usulan->nuptk ?></td>
                                                        <td><?= $v->data_usulan->nama ?></td>
                                                        <td><?= $v->data_usulan->us_pang_golongan ?></td>
                                                        <td><?= $v->data_usulan->us_pang_mk_tahun ?></td>
                                                        <td><?= $v->data_usulan->us_gaji_pokok ?></td>
                                                        <td><?= $keterangan ?></td>
                                                        <td>Siap Diusulkan SKTP</td>
                                                        <td>Aksi</td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr class="table-danger">
                                                        <th scope="row"><?= $key + 1 ?></th>
                                                        <td><?= $v->nuptk ?></td>
                                                        <td><?= $v->nama ?></td>
                                                        <td><?= $v->golongan_code ?></td>
                                                        <td><?= $v->masa_kerja ?></td>
                                                        <td><?= $v->gaji_pokok ?></td>
                                                        <td><?= $v->total_jjm_sesuai ?></td>
                                                        <td><?= $v->data_usulan->nuptk ?></td>
                                                        <td><?= $v->data_usulan->nama ?></td>
                                                        <td><?= $v->data_usulan->us_pang_golongan ?></td>
                                                        <td><?= $v->data_usulan->us_pang_mk_tahun ?></td>
                                                        <td><?= $v->data_usulan->us_gaji_pokok ?></td>
                                                        <td><?= $keterangan ?></td>
                                                        <td>Belum Update Dapodik</td>
                                                        <td>Aksi</td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr class="table-danger">
                                                <th scope="row"><?= $key + 1 ?></th>
                                                <td><?= $v->nuptk ?></td>
                                                <td><?= $v->nama ?></td>
                                                <td><?= $v->golongan_code ?></td>
                                                <td><?= $v->masa_kerja ?></td>
                                                <td><?= $v->gaji_pokok ?></td>
                                                <td><?= $v->total_jjm_sesuai ?></td>
                                                <td><?= $v->data_usulan->nuptk ?></td>
                                                <td><?= $v->data_usulan->nama ?></td>
                                                <td><?= $v->data_usulan->us_pang_golongan ?></td>
                                                <td><?= $v->data_usulan->us_pang_mk_tahun ?></td>
                                                <td><?= $v->data_usulan->us_gaji_pokok ?></td>
                                                <td><?= $keterangan ?></td>
                                                <td>Belum Memenuhi Syarat</td>
                                                <td>Aksi</td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>

                            <!-- <tr class="table-success">
                                <th scope="row">2</th>
                                <td>Column content</td>
                                <td>Column content</td>
                                <td>Column content</td>
                            </tr>

                            <tr class="table-info">
                                <th scope="row">3</th>
                                <td>Column content</td>
                                <td>Column content</td>
                                <td>Column content</td>
                            </tr>

                            <tr class="table-warning">
                                <th scope="row">4</th>
                                <td>Column content</td>
                                <td>Column content</td>
                                <td>Column content</td>
                            </tr>

                            <tr class="table-danger">
                                <th scope="row">5</th>
                                <td>Column content</td>
                                <td>Column content</td>
                                <td>Column content</td>
                            </tr> -->
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="col-8">
            <div>
                <progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress>
            </div>
            <div>
                <h3 id="status" style="font-size: 15px; margin: 8px auto;"></h3>
            </div>
            <div>
                <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
            </div>
        </div>
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <!-- <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button> -->
    </div>
    </form>

    <script>

    </script>
<?php } ?>
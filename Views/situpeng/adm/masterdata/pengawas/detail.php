<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA INDIVIDU</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $data->nama)) ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nik" aria-label="NIK" value="<?= $data->nik ?>" readonly />
                    <?php if (!($data->lampiran_ktp == NULL || $data->lampiran_ktp == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/ktp') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/ktp') . '/' . $data->lampiran_ktp ?>" id="nik">Lampiran KTP</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nuptk" aria-label="NUPTK" value="<?= $data->nuptk ?>" readonly />
                    <?php if (!($data->lampiran_nuptk == NULL || $data->lampiran_nuptk == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/nuptk') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/nuptk') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NUPTK</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nip" aria-label="NIP" value="<?= $data->nip ?>" readonly />
                    <?php if (!($data->lampiran_karpeg == NULL || $data->lampiran_karpeg == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/karpeg') . '/' . $data->lampiran_karpeg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/karpeg') . '/' . $data->lampiran_karpeg ?>" id="nik">Lampiran Karpeg</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NRG:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nrg" aria-label="NRG" value="<?= $data->nrg ?>" readonly />
                    <!-- <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/nrg') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/nrg') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NRG</a> -->
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Peserta:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_peserta" aria-label="No Peserta" value="<?= $data->no_peserta ?>" readonly />
                    <?php if (!($data->lampiran_serdik == NULL || $data->lampiran_serdik == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/serdik') . '/' . $data->lampiran_serdik ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/serdik') . '/' . $data->lampiran_serdik ?>" id="no_peserta">Lampiran Serdik</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPWP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="npwp" aria-label="NPWP" value="<?= $data->npwp ?>" readonly />
                    <?php if (!($data->lampiran_npwp == NULL || $data->lampiran_npwp == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/npwp') . '/' . $data->lampiran_npwp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/npwp') . '/' . $data->lampiran_npwp ?>" id="nik">Lampiran NPWP</a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Rekening:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_rekening" aria-label="NO REKENING" value="<?= $data->no_rekening ?>" readonly />
                    <?php if (!($data->lampiran_buku_rekening == NULL || $data->lampiran_buku_rekening == "")) { ?>
                        <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/bukurekening') . '/' . $data->lampiran_buku_rekening ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/bukurekening') . '/' . $data->lampiran_buku_rekening ?>" id="nik">Lampiran Rekening</a>
                    <?php } ?>
                </div>
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
                <label class="col-form-label">Email:</label>
                <input type="text" class="form-control" value="<?= $data->email ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Handphone:</label>
                <input type="text" class="form-control" value="<?= $data->no_hp ?>" readonly />
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>DATA BINAAN</h2>
            <div class="col-lg-12 mt-4">
                <?php if (!($data->npsn_naungan == NULL || $data->npsn_naungan == "")) { ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NPSN</th>
                                    <th>Satuan Pendidikan</th>
                                    <th>Kecamatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $npsns = explode(",", $data->npsn_naungan);
                                if (count($npsns) > 0) {
                                    foreach ($npsns as $key => $v) { ?>
                                        <?php $sekolah = getDetailSekolahNaungan($v); ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $v ?></td>
                                            <td><?= $sekolah ? $sekolah->nama : 'Unuknown' ?></td>
                                            <td><?= $sekolah ? $sekolah->kecamatan : 'Unuknown' ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tidak ada sekolah binaan</td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-12 mt-4">
                <?php if (!($data->guru_naungan == NULL || $data->guru_naungan == "")) { ?>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NUPTK</th>
                                    <th>NPSN</th>
                                    <th>Satuan Pendidikan</th>
                                    <th>Jenis PTK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $gurus = explode(",", $data->guru_naungan);
                                if (count($gurus) > 0) {
                                    foreach ($gurus as $key => $v) { ?>
                                        <?php $guru = getDetailGuruNaungan($v); ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $guru ? $guru->nama : 'Unuknown' ?></td>
                                            <td><?= $guru ? $guru->nuptk : 'Unuknown' ?></td>
                                            <td><?= $guru ? $guru->npsn : 'Unuknown' ?></td>
                                            <td><?= $guru ? $guru->tempat_tugas : 'Unuknown' ?></td>
                                            <td><?= $guru ? $guru->jenis_ptk : 'Unuknown' ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tidak ada guru binaan</td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Jenis Pengawas:</label>
                <div><?= $data->jenis_pengawas ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Pendidikan Terakhir:</label>
                <div><?= $data->pendidikan ?></div>
            </div>
        </div>
        <hr />
        <div class="row mt-2">
            <h2>LAMPIRAN DOKUMEN</h2>

            <div class="col-lg-12 mt-2">
                <br />
                <?php if (!($data->lampiran_serpeng == NULL || $data->lampiran_serpeng == "")) { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/serpeng') . '/' . $data->lampiran_serpeng ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/serpeng') . '/' . $data->lampiran_serpeng ?>" id="nik">
                        Sertifikat Pengawas
                    </a>
                <?php } ?>
                <?php if (!($data->lampiran_sk80 == NULL || $data->lampiran_sk80 == "")) { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/sk80') . '/' . $data->lampiran_sk80 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/sk80') . '/' . $data->lampiran_sk80 ?>" id="nik">
                        SK 80%
                    </a>
                <?php } ?>
                <?php if (!($data->lampiran_sk100 == NULL || $data->lampiran_sk100 == "")) { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/sk100') . '/' . $data->lampiran_sk100 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/sk100') . '/' . $data->lampiran_sk100 ?>" id="nik">
                        SK 100%
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
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
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/ktp') . '/' . $data->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/ktp') . '/' . $data->lampiran_ktp ?>" id="nik">Lampiran KTP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nik ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nuptk" aria-label="NUPTK" value="<?= $data->nuptk ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/nuptk') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/nuptk') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NUPTK</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nip" aria-label="NIP" value="<?= $data->nip ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/karpeg') . '/' . $data->lampiran_karpeg ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/karpeg') . '/' . $data->lampiran_karpeg ?>" id="nik">Lampiran Karpeg</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nip ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NRG:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="nrg" aria-label="NRG" value="<?= $data->nrg ?>" readonly />
                    <!-- <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/nrg') . '/' . $data->lampiran_nuptk ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/nrg') . '/' . $data->lampiran_nuptk ?>" id="nik">Lampiran NRG</a> -->
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->nrg ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Peserta:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_peserta" aria-label="No Peserta" value="<?= $data->no_peserta ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/serdik') . '/' . $data->lampiran_serdik ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/serdik') . '/' . $data->lampiran_serdik ?>" id="no_peserta">Lampiran Serdik</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_peserta ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPWP:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="npwp" aria-label="NPWP" value="<?= $data->npwp ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/npwp') . '/' . $data->lampiran_npwp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/npwp') . '/' . $data->lampiran_npwp ?>" id="nik">Lampiran NPWP</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->npwp ?>" readonly /> -->
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Rekening:</label>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="no_rekening" aria-label="NO REKENING" value="<?= $data->no_rekening ?>" readonly />
                    <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/bukurekening') . '/' . $data->lampiran_buku_rekening ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/bukurekening') . '/' . $data->lampiran_buku_rekening ?>" id="nik">Lampiran Rekening</a>
                </div>
                <!-- <input type="text" class="form-control" value="<?= $data->no_rekening ?>" readonly /> -->
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
            <h2>DATA ATRIBUT USULAN</h2>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-8">
                        <label class="col-form-label">Pangkat Golongan:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-describedby="pangkat_golongan" aria-label="PANGKAT GOLONGAN" value="<?= $data->us_pang_golongan ?>" readonly />
                            <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/pangkat') . '/' . $data->lampiran_pangkat ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/pangkat') . '/' . $data->lampiran_pangkat ?>" id="nik">Lampiran Pangkat</a>
                            <?php if (!($data->lampiran_kgb == NULL || $data->lampiran_kgb == "")) { ?>
                                <a class="btn btn-primary" target="popup" onclick="window.open('<?= base_url('upload/pengawas/kgb') . '/' . $data->lampiran_kgb ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/kgb') . '/' . $data->lampiran_kgb ?>" id="nik">Lampiran KGB</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label class="col-form-label">Jenis Dokumen:</label>
                        <input type="text" class="form-control" value="<?= strtoupper($data->us_pang_jenis) ?>" readonly />
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">TMT:</label>
                        <input type="text" class="form-control" value="<?= $data->us_pang_tmt ?>" readonly />
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Tanggal:</label>
                        <input type="text" class="form-control" value="<?= $data->us_pang_tgl ?>" readonly />
                    </div>
                    <div class="col-sm-3">
                        <label class="col-form-label">MK Tahun:</label>
                        <input type="text" class="form-control" value="<?= $data->us_pang_mk_tahun ?>" readonly />
                    </div>
                    <div class="col-sm-3">
                        <label class="col-form-label">MK Bulan:</label>
                        <input type="text" class="form-control" value="<?= $data->us_pang_mk_bulan ?>" readonly />
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label">Gaji Pokok:</label>
                        <input type="text" class="form-control" value="<?= rpAwalan($data->gaji_pokok_referensi) ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <label class="col-form-label">Lampiran Dokumen:</label>
                <br />
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/penugasan') . '/' . $data->lampiran_penugasan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/penugasan') . '/' . $data->lampiran_penugasan ?>" id="nik">
                    Penugasan
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/kunjunganbinaan') . '/' . $data->lampiran_kunjungan_binaan ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/kunjunganbinaan') . '/' . $data->lampiran_kunjungan_binaan ?>" id="nik">
                    Kunjungan Binaan
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/serpeng') . '/' . $data->lampiran_serpeng ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/serpeng') . '/' . $data->lampiran_serpeng ?>" id="nik">
                    Sertifikat Pengawas
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/sk80') . '/' . $data->lampiran_sk80 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/sk80') . '/' . $data->lampiran_sk80 ?>" id="nik">
                    SK 80%
                </a>
                <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/sk100') . '/' . $data->lampiran_sk100 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/sk100') . '/' . $data->lampiran_sk100 ?>" id="nik">
                    SK 100%
                </a>

                <?php if ($data->lampiran_cuti === null || $data->lampiran_cuti === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/keterangancuti') . '/' . $data->lampiran_cuti ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/keterangancuti') . '/' . $data->lampiran_cuti ?>" id="nik">
                        Cuti
                    </a>
                <?php } ?>
                <?php if ($data->lampiran_pensiun === null || $data->lampiran_pensiun === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/pensiun') . '/' . $data->lampiran_pensiun ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/pensiun') . '/' . $data->lampiran_pensiun ?>" id="nik">
                        Pensiun
                    </a>
                <?php } ?>
                <?php if ($data->lampiran_kematian === null || $data->lampiran_kematian === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/kematian') . '/' . $data->lampiran_kematian ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/kematian') . '/' . $data->lampiran_kematian ?>" id="nik">
                        Kematian
                    </a>
                <?php } ?>
                <?php if ($data->lampiran_attr_lainnya === null || $data->lampiran_attr_lainnya === "") {
                } else { ?>
                    <a class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light mr-2 mb-1" target="popup" onclick="window.open('<?= base_url('upload/pengawas/lainnya') . '/' . $data->lampiran_attr_lainnya ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/pengawas/lainnya') . '/' . $data->lampiran_attr_lainnya ?>" id="nik">
                        Atribut Lainnya
                    </a>
                <?php } ?>
            </div>
            <div class="col-lg-12 mt-2">
                <label class="col-form-label">Keterangan Penolakan:</label>
                <textarea role="10" class="form-control" readonly><?= $data->keterangan_reject ?></textarea>
            </div>
            <div class="col-lg-12 mt-2">
                <label class="col-form-label">Verifikator:</label>
                <input type="text" class="form-control" value="<?= $data->verifikator ?>" readonly />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
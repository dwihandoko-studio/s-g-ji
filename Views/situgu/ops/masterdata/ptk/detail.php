<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <h2>DATA INDIVIDU</h2>
            <div class="col-lg-6">
                <label class="col-form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" value="<?= $data->nama ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIK:</label>
                <input type="text" class="form-control" value="<?= $data->nik ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NUPTK:</label>
                <input type="text" class="form-control" value="<?= $data->nuptk ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NIP:</label>
                <input type="text" class="form-control" value="<?= $data->nip ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NRG:</label>
                <input type="text" class="form-control" value="<?= $data->nrg ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Peserta:</label>
                <input type="text" class="form-control" value="<?= $data->no_peserta ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">NPWP:</label>
                <input type="text" class="form-control" value="<?= $data->npwp ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Rekening:</label>
                <input type="text" class="form-control" value="<?= $data->no_rekening ?>" readonly />
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
                <label class="col-form-label">Email Dapodik:</label>
                <input type="text" class="form-control" value="<?= $data->email ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Email Akun:</label>
                <input type="text" class="form-control" value="<?= $data->emailAkun ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Hanphone Dapodik:</label>
                <input type="text" class="form-control" value="<?= $data->no_hp ?>" readonly />
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">No Hanphone Akun:</label>
                <input type="text" class="form-control" value="<?= $data->nohpAkun ?>" readonly />
                <?php switch ((int)$data->wa_verified) {
                    case 1:
                        echo '<span class="badge badge-pill badge-soft-success">WA Terverifikasi</span>';
                        break;
                    default:
                        echo '<span class="badge badge-pill badge-soft-danger">WA Tidak Tertaut</span>';
                        break;
                } ?>
            </div>
            <div class="col-lg-4 mt-4">

                <?php if ($data->image !== null) { ?>
                    <img class="imagePreviewUpload" src="<?= base_url('upload/user') . '/' . $data->image ?>" id="imagePreviewUpload" />
                <?php } ?>

            </div>
        </div>
        <div class="row mt-2">
            <h2>DATA PENUGASAN</h2>

            <?php switch ($data->bidang_studi_sertifikasi) {
                case '':
                    echo '<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>';
                    break;
                case null:
                    echo '<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>';
                    break;
                case '-':
                    echo '<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>';
                    break;
                case ' ':
                    echo '<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>';
                    break;

                default:
                    echo '<div class="col-lg-6">
                        <label class="col-form-label">Sudah Sertifikasi:</label>
                        <div><span class="badge badge-pill badge-soft-success">Sudah</span></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Bidang Studi Sertifikasi:</label>
                        <input type="text" class="form-control" value="' . $data->bidang_studi_sertifikasi . '" readonly />
                    </div>';
                    break;
            } ?>
            <div class="col-lg-12 mt-4">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NPSN</th>
                                <th>Satuan Pendidikan</th>
                                <th>Nomor Surat Tugas</th>
                                <th>Tanggal Surat</th>
                                <th>Status</th>
                                <th>Jumlah Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($penugasans)) {
                                if (count($penugasans) > 0) {
                                    foreach ($penugasans as $key => $v) { ?>
                                        <tr>
                                            <th scope="row"><?= $key + 1 ?></th>
                                            <td><?= $v->npsn ?></td>
                                            <td><?= $v->namaSekolah ?></td>
                                            <td><?= $v->nomor_surat_tugas ?></td>
                                            <td><?= $v->tanggal_surat_tugas ?></td>
                                            <td><?= $v->ptk_induk == "1" ? '<span class="badge badge-pill badge-soft-success">INDUK</span>' : '<span class="badge badge-pill badge-soft-warning">NON INDUK</span>' ?></td>
                                            <td><?= $v->jumlah_total_jam_mengajar_perminggu ?> Jam</td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tidak ada penugasan</td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="6">Tidak ada penugasan</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <h2>DATA KEPEGAWAIAN</h2>
            <div class="col-lg-6">
                <label class="col-form-label">NPSN:</label>
                <div><?= $data->npsn ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Tempat Tugas:</label>
                <div><?= $data->tempat_tugas ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Status Tugas:</label>
                <div><?= $data->status_tugas ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Kecamatan:</label>
                <div><?= $data->nip ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Status PTK:</label>
                <div><?= $data->status_kepegawaian ?></div>
            </div>
            <div class="col-lg-6">
                <label class="col-form-label">Mapel Diajarkan:</label>
                <div><?= $data->mapel_diajarkan ?></div>
            </div>
            <?php switch ($data->bidang_studi_sertifikasi) {
                case '':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case null:
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case '-':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;
                case ' ':
                    echo `<div class="col-lg-6">
                            <label class="col-form-label">Sudah Sertifikasi:</label>
                            <div><span class="badge badge-pill badge-soft-danger">Belum</span></div>
                        </div>`;
                    break;

                default:
                    echo `<div class="col-lg-6">
                        <label class="col-form-label">Sudah Sertifikasi:</label>
                        <div><span class="badge badge-pill badge-soft-success">Sudah</span></div>
                    </div>
                    <div class="col-lg-6">
                        <label class="col-form-label">Bidang Studi Sertifikasi:</label>
                        <div>$data->bidang_studi_sertifikasi</div>
                    </div>`;
                    break;
            } ?>

            <div class="col-lg-6">
                <label class="col-form-label">Jam Mengajar Perminggu:</label>
                <div><?= $data->jam_mengajar_perminggu ?> Jam</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
    </div>
<?php } ?>
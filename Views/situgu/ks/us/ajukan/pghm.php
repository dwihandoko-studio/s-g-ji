<?php if (isset($ptk)) { ?>
    <div class="table-responsive">
        <h4>Konfirmasi Pengajuan Usulan Tunjangan Penghasilan Guru Honor Murni.</h4>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Variabel</th>
                    <th>Isian</th>
                    <th>Konfirm</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row" colspan="4">Data Individu</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><label class="form-check-label" for="_nama">Nama</label></td>
                    <td><label class="form-check-label" for="_nama"><?= $ptk->nama ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_nama" name="_nama">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td><label class="form-check-label" for="_nuptk">NUPTK</label></td>
                    <td><label class="form-check-label" for="_nuptk"><?= $ptk->nuptk ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_nuptk" name="_nuptk">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td><label class="form-check-label" for="_status_kepegawaian">Status Kepegawaian</label></td>
                    <td><label class="form-check-label" for="_status_kepegawaian"><?= $ptk->status_kepegawaian ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_status_kepegawaian" name="_status_kepegawaian">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td><label class="form-check-label" for="_pendidikan_terakhir">Pendidikan Terakhir</label></td>
                    <td><label class="form-check-label" for="_pendidikan_terakhir"><?= $ptk->pendidikan ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_pendidikan_terakhir" name="_pendidikan_terakhir">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">6</th>
                    <td><label class="form-check-label" for="_no_rekening">No Rekening</label></td>
                    <td><label class="form-check-label" for="_no_rekening"><?= $ptk->no_rekening ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_no_rekening" name="_no_rekening">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">7</th>
                    <td><label class="form-check-label" for="_cabang_bank">Cabang Bank</label></td>
                    <td><label class="form-check-label" for="_cabang_bank"><?= $ptk->cabang_bank ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_cabang_bank" name="_cabang_bank">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row" colspan="4">Data Absensi</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><label class="form-check-label" for="_absen_1">Absen 1</label></td>
                    <td><label class="form-check-label" for="_absen_1"><?= $ptk->bulan_1 ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_absen_1" name="_absen_1">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td><label class="form-check-label" for="_absen_2">Absen 2</label></td>
                    <td><label class="form-check-label" for="_absen_2"><?= $ptk->bulan_2 ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_absen_2" name="_absen_2">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td><label class="form-check-label" for="_absen_3">Absen 3</label></td>
                    <td><label class="form-check-label" for="_absen_3"><?= $ptk->bulan_3 ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_absen_3" name="_absen_3">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td><label class="form-check-label" for="_cuti">Cuti</label></td>
                    <td><label class="form-check-label" for="_cuti"><?= $ptk->lampiran_cuti == null || $ptk->lampiran_cuti == "-" ? 'Tidak' : 'Ya' ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_cuti" name="_cuti">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td><label class="form-check-label" for="_pensiun">Pensiun</label></td>
                    <td><label class="form-check-label" for="_pensiun"><?= $ptk->lampiran_pensiun == null || $ptk->lampiran_pensiun == "-" ? 'Tidak' : 'Ya' ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_pensiun" name="_pensiun">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">6</th>
                    <td><label class="form-check-label" for="_kematian">Kematian</label></td>
                    <td><label class="form-check-label" for="_kematian"><?= $ptk->lampiran_kematian == null || $ptk->lampiran_kematian == "-" ? 'Tidak' : 'Ya' ?></label></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_kematian" name="_kematian">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td scope="row" colspan="4">Lampiran Dokumen</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td><label class="form-check-label" for="_lampiran_ktp">KTP</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/ktp') . '/' . $ptk->lampiran_ktp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/ktp') . '/' . $ptk->lampiran_ktp ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_ktp" name="_lampiran_ktp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td><label class="form-check-label" for="_lampiran_npwp">NPWP</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/npwp') . '/' . $ptk->lampiran_npwp ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/npwp') . '/' . $ptk->lampiran_npwp ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_npwp" name="_lampiran_npwp">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td><label class="form-check-label" for="_lampiran_ijazah">Ijazah</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/ijazah') . '/' . $ptk->lampiran_ijazah ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/ijazah') . '/' . $ptk->lampiran_ijazah ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_ijazah" name="_lampiran_ijazah">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">6</th>
                    <td><label class="form-check-label" for="_lampiran_buku_rekening">Buku Rekening</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/bukurekening') . '/' . $ptk->lampiran_buku_rekening ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/bukurekening') . '/' . $ptk->lampiran_buku_rekening ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_buku_rekening" name="_lampiran_buku_rekening">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">7</th>
                    <td><label class="form-check-label" for="_lampiran_absen_1">Absen 1</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen1 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen1 ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_absen_1" name="_lampiran_absen_1">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">8</th>
                    <td><label class="form-check-label" for="_lampiran_absen_2">Absen 2</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen2 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen2 ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_absen_2" name="_lampiran_absen_2">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">9</th>
                    <td><label class="form-check-label" for="_lampiran_absen_3">Absen 3</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen3 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/kehadiran') . '/' . $ptk->lampiran_absen3 ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_absen_3" name="_lampiran_absen_3">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">10</th>
                    <td><label class="form-check-label" for="_lampiran_pembagian_tugas">Pembagian Tugas</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/pembagian-tugas') . '/' . $ptk->lampiran_pembagian_tugas ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/pembagian-tugas') . '/' . $ptk->lampiran_pembagian_tugas ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_pembagian_tugas" name="_lampiran_pembagian_tugas">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">11</th>
                    <td><label class="form-check-label" for="_lampiran_slip_gaji">Slip Gaji</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/spj-gaji') . '/' . $ptk->lampiran_slip_gaji ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/spj-gaji') . '/' . $ptk->lampiran_slip_gaji ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_slip_gaji" name="_lampiran_slip_gaji">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">12</th>
                    <td><label class="form-check-label" for="_lampiran_pernyataan24">Pernyataan 24Jam</label></td>
                    <td><a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/pernyataanindividu') . '/' . $ptk->lampiran_pernyataan24 ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/pernyataanindividu') . '/' . $ptk->lampiran_pernyataan24 ?>">Lihat Lampiran</a></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="_lampiran_pernyataan24" name="_lampiran_pernyataan24">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">13</th>
                    <td><label class="form-check-label" for="_lampiran_cuti">Cuti</label></td>
                    <td>
                        <?php if ($ptk->lampiran_cuti == null || $ptk->lampiran_cuti == "") {
                            echo 'Tidak ada';
                        } else { ?>
                            <a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/keterangancuti') . '/' . $ptk->lampiran_cuti ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/keterangancuti') . '/' . $ptk->lampiran_cuti ?>">Lihat Lampiran</a>
                    </td>
                <?php } ?>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="_lampiran_cuti" name="_lampiran_cuti">
                    </div>
                </td>
                </tr>
                <tr>
                    <th scope="row">14</th>
                    <td><label class="form-check-label" for="_lampiran_pensiun">Pensiun</label></td>
                    <td>
                        <?php if ($ptk->lampiran_pensiun == null || $ptk->lampiran_pensiun == "") {
                            echo 'Tidak ada';
                        } else { ?>
                            <a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/pensiun') . '/' . $ptk->lampiran_pensiun ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/pensiun') . '/' . $ptk->lampiran_pensiun ?>">Lihat Lampiran</a>
                    </td>
                <?php } ?>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="_lampiran_pensiun" name="_lampiran_pensiun">
                    </div>
                </td>
                </tr>
                <tr>
                    <th scope="row">15</th>
                    <td><label class="form-check-label" for="_lampiran_kematian">Kematian</label></td>
                    <td>
                        <?php if ($ptk->lampiran_kematian == null || $ptk->lampiran_kematian == "") {
                            echo 'Tidak ada';
                        } else { ?>
                            <a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/kematian') . '/' . $ptk->lampiran_kematian ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/kematian') . '/' . $ptk->lampiran_kematian ?>">Lihat Lampiran</a>
                    </td>
                <?php } ?>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="_lampiran_kematian" name="_lampiran_kematian">
                    </div>
                </td>
                </tr>
                <tr>
                    <th scope="row">16</th>
                    <td><label class="form-check-label" for="_lampiran_atribut_lainnya">Atribut Lainnya</label></td>
                    <td>
                        <?php if ($ptk->lampiran_att_lain == null || $ptk->lampiran_att_lain == "") {
                            echo 'Tidak ada';
                        } else { ?>
                            <a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/ptk/lainnya') . '/' . $ptk->lampiran_att_lain ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/ptk/lainnya') . '/' . $ptk->lampiran_att_lain ?>">Lihat Lampiran</a>
                    </td>
                <?php } ?>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="_lampiran_atribut_lainnya" name="_lampiran_atribut_lainnya">
                    </div>
                </td>
                </tr>
                <tr>
                    <th scope="row">17</th>
                    <td><label class="form-check-label" for="_lampiran_absen_lain">Lainnya</label></td>
                    <td>
                        <?php if ($ptk->lampiran_doc_absen_lain == null || $ptk->lampiran_doc_absen_lain == "") {
                            echo 'Tidak ada';
                        } else { ?>
                            <a class="badge rounded-pill badge-soft-dark" target="popup" onclick="window.open('<?= base_url('upload/sekolah/doc-lainnya') . '/' . $ptk->lampiran_doc_absen_lain ?>','popup','width=600,height=600'); return false;" href="<?= base_url('upload/sekolah/doc-lainnya') . '/' . $ptk->lampiran_doc_absen_lain ?>">Lihat Lampiran</a>
                    </td>
                <?php } ?>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="_lampiran_absen_lain" name="_lampiran_absen_lain">
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php } ?>
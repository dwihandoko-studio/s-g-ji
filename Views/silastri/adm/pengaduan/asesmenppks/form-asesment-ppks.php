<?php if (isset($data)) : ?>
    <form id="tindakLanjutPengaduanForm">
        <div class="modal-body">
            <input type="hidden" id="_id" name="_id" value="<?= $data->id ?>" />
            <input type="hidden" id="_id_petugas_assesment" name="_id_petugas_assesment" value="<?= $petugas ? $petugas->id : '' ?>" />
            <input type="hidden" id="_nama" name="_nama" value="<?= str_replace('&#039;', "`", str_replace("'", "`", $nama)) ?>" />
            <div class="row">
                <h2>DATA PENUGASAN</h2>
                <div class="col-lg-6">
                    <label class="col-form-label">Tanggal Assesment:</label>
                    <input type="text" class="form-control" id="_tgl_asesment" name="_tgl_asesment" value="<?= date("Y-m-d") ?>" readonly />
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Nama Petugas Assesment:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="_petugas_asesment" name="_petugas_asesment" value="<?= $petugas ? $petugas->nama : '' ?>" readonly />
                    </div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Satuan Kerja:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="_satuan_kerja_asesment" name="_satuan_kerja_asesment" value="<?= $petugas ? $petugas->jabatan : '' ?>" readonly />
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <h3>PROFIL LENGKAP PPKS</h3>
                <h4>Alamat Sesuai KTP</h4>
                <div class="col-lg-6">
                    <label class="col-form-label">Provinsi:</label>
                    <input type="text" class="form-control" id="_provinsi_ktp" name="_provinsi_ktp" value="<?= "Lampung" ?>" readonly />
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Kabupaten:</label>
                    <input type="text" class="form-control" id="_kabupaten_ktp" name="_kabupaten_ktp" value="<?= "Lampung Tengah" ?>" readonly />
                </div>
                <div class="col-lg-6 mt-2 mb-2">
                    <label class="form-label">Kecamatan:</label>
                    <select class="form-control select2 kecamatan_ktp" onchange="changeKecamatanKtp(this)" id="_kecamatan_ktp" name="_kecamatan_ktp" style="width: 100%">
                        <option value=""> --- Pilih Kecamatan --- </option>
                        <?php if (isset($kecamatans)) { ?>
                            <?php if (count($kecamatans) > 0) { ?>
                                <?php foreach ($kecamatans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= $value->id == $data->kecamatan_aduan ? ' selected' : '' ?>><?= $value->kecamatan ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _kecamatan_ktp"></div>
                </div>
                <div class="col-lg-6 mt-2 mb-2 select2-kelurahan-ktp-loading">
                    <label class="form-label">Kelurahan:</label>
                    <select class="form-control select2 kelurahan_ktp" id="_kelurahan_ktp" name="_kelurahan_ktp" style="width: 100%">
                        <option value=""> --- Pilih Kelurahan --- </option>
                        <?php if (isset($kelurahans)) { ?>
                            <?php if (count($kelurahans) > 0) { ?>
                                <?php foreach ($kelurahans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= $value->id == $data->kelurahan_aduan ? ' selected' : '' ?>><?= $value->kelurahan ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _kelurahan_ktp"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Alamat:</label>
                    <textarea class="form-control" id="_alamat_ktp" name="_alamat_ktp"><?= $data->alamat_aduan ?></textarea>
                    <div class="help-block _alamat_ktp"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>Alamat Sesuai Domisili</h4>
                <div class="col-lg-6">
                    <label class="col-form-label">Provinsi:</label>
                    <input type="text" class="form-control" id="_provinsi_domisili" name="_provinsi_domisili" value="<?= "Lampung" ?>" readonly />
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Kabupaten:</label>
                    <input type="text" class="form-control" id="_kabupaten_domisili" name="_kabupaten_domisili" value="<?= "Lampung Tengah" ?>" readonly />
                </div>
                <div class="col-lg-6 mt-2 mb-2">
                    <label class="form-label">Kecamatan:</label>
                    <select class="form-control select2 kecamatan_domisili" onchange="changeKecamatanDomisili(this)" id="_kecamatan_domisili" name="_kecamatan_domisili" style="width: 100%">
                        <option value=""> --- Pilih Kecamatan --- </option>
                        <?php if (isset($kecamatans)) { ?>
                            <?php if (count($kecamatans) > 0) { ?>
                                <?php foreach ($kecamatans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= $value->id == $data->kecamatan_aduan ? ' selected' : '' ?>><?= $value->kecamatan ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _kecamatan_domisili"></div>
                </div>
                <div class="col-lg-6 mt-2 mb-2 select2-kelurahan-domisili-loading">
                    <label class="form-label">Kelurahan:</label>
                    <select class="form-control select2 kelurahan_domisili" id="_kelurahan_domisili" name="_kelurahan_domisili" style="width: 100%">
                        <option value=""> --- Pilih Kelurahan --- </option>
                        <?php if (isset($kelurahans)) { ?>
                            <?php if (count($kelurahans) > 0) { ?>
                                <?php foreach ($kelurahans as $key => $value) { ?>
                                    <option value="<?= $value->id ?>" <?= $value->id == $data->kelurahan_aduan ? ' selected' : '' ?>><?= $value->kelurahan ?></option>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _kelurahan_domisili"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Alamat:</label>
                    <textarea class="form-control" id="_alamat_domisili" name="_alamat_domisili"><?= $data->alamat_aduan ?></textarea>
                    <div class="help-block _alamat_domisili"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>IDENTITAS PPKS</h4>
                <div class="col-lg-6">
                    <label class="col-form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="_nama_identitas" name="_nama_identitas" />
                    <div class="help-block _nama_identitas"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Tempat Lahir:</label>
                    <input type="text" class="form-control" id="_tempat_lahir_identitas" name="_tempat_lahir_identitas" />
                    <div class="help-block _tempat_lahir_identitas"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Tanggal Lahir:</label>
                    <input type="date" class="form-control" id="_tgl_lahir_identitas" name="_tgl_lahir_identitas" />
                    <div class="help-block _tgl_lahir_identitas"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Jenis Kelamin:</label>
                    <select class="form-control select2 jenis_kelamin_identitas" id="_jenis_kelamin_identitas" name="_jenis_kelamin_identitas" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="L"> Laki - laki </option>
                        <option value="P"> Perempuan </option>
                    </select>
                    <div class="help-block _jenis_kelamin_identitas"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Agama:</label>
                    <select class="form-control select2 agama_identitas" id="_agama_identitas" name="_agama_identitas" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Islam"> Islam </option>
                        <option value="Katolik"> Katolik </option>
                        <option value="Kristen"> Kristen </option>
                        <option value="Hindu"> Hindu </option>
                        <option value="Budha"> Budha </option>
                        <option value="Konghuchu"> Konghuchu </option>
                    </select>
                    <div class="help-block _agama_identitas"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">NIK**:</label>
                    <input type="text" class="form-control" id="_nik_identitas" name="_nik_identitas" />
                    <div class="help-block _nik_identitas"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Nomor Kartu Keluarga (KK)**:</label>
                    <input type="text" class="form-control" id="_kk_identitas" name="_kk_identitas" />
                    <div class="help-block _kk_identitas"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Nomor Akta Lahir**:</label>
                    <input type="text" class="form-control" id="_akta_identitas" name="_akta_identitas" />
                    <div class="help-block _akta_identitas"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Apakah sudah masuk DTKS?:</label>
                    <select class="form-control select2 dtks_identitas" id="_dtks_identitas" name="_dtks_identitas" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="1"> Sudah </option>
                        <option value="0"> Belum </option>
                    </select>
                    <div class="help-block _dtks_identitas"></div>
                </div>
                <div class="col-lg-12 mt-2">
                    <label class="col-form-label"><b>Bantuan Sosial yang Pernah / Sedang diterima saat ini:</b></label>
                    <table id="table-bansos-identitas" class="table-bansos-identitas">
                        <thead>
                            <tr>
                                <th>Waktu Pelaksanaan</th>
                                <th>Nama Bantuan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Sumber Dana / Instansi Pemberi</th>
                                <th>Keterangan</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-control" type="date" id="waktu_bansos_identitas_0" name="waktu_bansos_identitas[]" />
                                    <div class="help-block waktu_bansos_identitas_0"></div>
                                </td>
                                <td><input class="form-control" type="text" id="nama_bansos_identitas_0" name="nama_bansos_identitas[]" />
                                    <div class="help-block nama_bansos_identitas_0"></div>
                                </td>
                                <td><input class="form-control" type="number" id="jumlah_bansos_identitas_0" name="jumlah_bansos_identitas[]" />
                                    <div class="help-block jumlah_bansos_identitas_0"></div>
                                </td>
                                <td><input class="form-control" type="text" id="satuan_bansos_identitas_0" name="satuan_bansos_identitas[]" />
                                    <div class="help-block satuan_bansos_identitas_0"></div>
                                </td>
                                <td><input class="form-control" type="text" id="sumber_anggaran_identitas_0" name="sumber_anggaran_identitas[]" />
                                    <div class="help-block sumber_anggaran_identitas_0"></div>
                                </td>
                                <td><textarea class="form-control" rows="1" id="keterangan_identitas_0" name="keterangan_identitas[]"></textarea>
                                    <div class="help-block keterangan_identitas_0"></div>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <button type="button" id="btnAddRowBansosIdentitas" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bxs-add-to-queue label-icon"></i> Tambah Bansos</button>
                    <br>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Pendidikan Terakhir:</label>
                    <select class="form-control select2 pendidikan_terakhir_identitas" id="_pendidikan_terakhir_identitas" name="_pendidikan_terakhir_identitas" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Tidak Sekolah"> Tidak Sekolah </option>
                        <option value="Belum Sekolah"> Belum Sekolah </option>
                        <option value="SD"> SD </option>
                        <option value="SMP"> SMP </option>
                        <option value="SMA"> SMA </option>
                        <option value="Perguruan Tinggi"> Perguruan Tinggi </option>
                    </select>
                    <div class="help-block _pendidikan_terakhir_identitas"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Status Kawin:</label>
                    <select class="form-control select2 status_kawin_identitas" id="_status_kawin_identitas" name="_status_kawin_identitas" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Belum Kawin"> Belum Kawin </option>
                        <option value="Kawin"> Kawin </option>
                        <option value="Cerai Hidup"> Cerai Hidup </option>
                        <option value="Cerai Mati"> Cerai Mati </option>
                    </select>
                    <div class="help-block _status_kawin_identitas"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>Profil Pengampu PPKS</h4>
                <div class="col-lg-6">
                    <label class="col-form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="_nama_pengampu" name="_nama_pengampu" />
                    <div class="help-block _nama_pengampu"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">No Handphone / Telp:</label>
                    <input type="text" class="form-control" id="_nohp_pengampu" name="_nohp_pengampu" />
                    <div class="help-block _nohp_pengampu"></div>
                </div>
                <div class="col-lg-6">
                    <div class="row mb-2 mt-2">
                        <label for="_hubungan_pengampu" class="col-sm-3 col-form-label">Hubungan dengan PPKS :</label>
                        <div class="col-sm-8 mt-2">
                            <select class="form-control select2 pekerjaan" id="_hubungan_pengampu" name="_hubungan_pengampu" style="width: 100%" onchange="changeHubungan(this)">
                                <option value=""> --- Pilih Hubungan ---</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Kakek">Kakek</option>
                                <option value="Nenek">Nenek</option>
                                <option value="Saudara Kandung">Saudara Kandung</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <textarea rows="3" style="display: none; margin-top: 10px;" id="_hubungan_pengampu_detail" name="_hubungan_pengampu_detail" class="form-control" placeholder="Masukan hubungan dengan PPKS.."></textarea>
                            <div class="help-block _hubungan_pengampu"></div>
                            <div class="help-block _hubungan_pengampu_detail"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Tempat Lahir:</label>
                    <input type="text" class="form-control" id="_tempat_lahir_pengampu" name="_tempat_lahir_pengampu" />
                    <div class="help-block _tempat_lahir_pengampu"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Tanggal Lahir:</label>
                    <input type="date" class="form-control" id="_tgl_lahir_pengampu" name="_tgl_lahir_pengampu" />
                    <div class="help-block _tgl_lahir_pengampu"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Jenis Kelamin:</label>
                    <select class="form-control select2 jenis_kelamin_pengampu" id="_jenis_kelamin_pengampu" name="_jenis_kelamin_pengampu" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="L"> Laki - laki </option>
                        <option value="P"> Perempuan </option>
                    </select>
                    <div class="help-block _jenis_kelamin_pengampu"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Agama:</label>
                    <select class="form-control select2 agama-pengampu" id="_agama_pengampu" name="_agama_pengampu" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Islam"> Islam </option>
                        <option value="Katolik"> Katolik </option>
                        <option value="Kristen"> Kristen </option>
                        <option value="Hindu"> Hindu </option>
                        <option value="Budha"> Budha </option>
                        <option value="Konghuchu"> Konghuchu </option>
                    </select>
                    <div class="help-block _agama_pengampu"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">NIK**:</label>
                    <input type="text" class="form-control" id="_nik_pengampu" name="_nik_pengampu" />
                    <div class="help-block _nik_pengampu"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Nomor Kartu Keluarga (KK)**:</label>
                    <input type="text" class="form-control" id="_kk_pengampu" name="_kk_pengampu" />
                    <div class="help-block _kk_pengampu"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Apakah sudah masuk DTKS?:</label>
                    <select class="form-control select2 dtks_pengampu" id="_dtks_pengampu" name="_dtks_pengampu" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="1"> Sudah </option>
                        <option value="0"> Belum </option>
                    </select>
                    <div class="help-block _dtks_pengampu"></div>
                </div>
                <div class="col-lg-12 mt-2">
                    <label class="col-form-label"><b>Bantuan Sosial yang Pernah / Sedang diterima saat ini:</b></label>
                    <table id="table-bansos-pengampu" class="table-bansos-pengampu">
                        <thead>
                            <tr>
                                <th>Nama Bansos</th>
                                <th>Tahun</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-control" type="text" id="nama_bansos_pengampu_0" name="nama_bansos_pengampu[]" />
                                    <div class="help-block nama_bansos_pengampu_0"></div>
                                </td>
                                <td><input class="form-control" type="number" id="tahun_bansos_pengampu_0" name="tahun_bansos_pengampu[]" />
                                    <div class="help-block tahun_bansos_pengampu_0"></div>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <button type="button" id="btnAddRowBansosPengampu" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bxs-add-to-queue label-icon"></i> Tambah Bansos</button>
                    <br>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Pendidikan Terakhir:</label>
                    <select class="form-control select2 pendidikan_terakhir_pengampu" id="_pendidikan_terakhir_pengampu" name="_pendidikan_terakhir_pengampu" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Tidak Sekolah"> Tidak Sekolah </option>
                        <option value="Belum Sekolah"> Belum Sekolah </option>
                        <option value="SD"> SD </option>
                        <option value="SMP"> SMP </option>
                        <option value="SMA"> SMA </option>
                        <option value="Perguruan Tinggi"> Perguruan Tinggi </option>
                    </select>
                    <div class="help-block _pendidikan_terakhir_pengampu"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label class="form-label">Status Kawin:</label>
                    <select class="form-control select2 status_kawin_pengampu" id="_status_kawin_pengampu" name="_status_kawin_pengampu" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Belum Kawin"> Belum Kawin </option>
                        <option value="Kawin"> Kawin </option>
                        <option value="Cerai Hidup"> Cerai Hidup </option>
                        <option value="Cerai Mati"> Cerai Mati </option>
                    </select>
                    <div class="help-block _status_kawin_pengampu"></div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_pekerjaan_pengampu" class="col-form-label">Pekerjaan :</label>
                    <select class="form-control select2 pekerjaan_pengampu" id="_pekerjaan_pengampu" name="_pekerjaan_pengampu" style="width: 100%" onchange="changePekerjaanPengampu(this)">
                        <option value="">&nbsp;</option>
                        <?php if (isset($pekerjaans)) {
                            if (count($pekerjaans) > 0) {
                                foreach ($pekerjaans as $key => $value) { ?>
                                    <option value="<?= $value->pekerjaan ?>"><?= $value->pekerjaan ?></option>
                        <?php }
                            }
                        } ?>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <input type="text" style="display: none; margin-top: 10px;" class="form-control perkerjaan-detail" id="_pekerjaan_pengampu_detail" name="_pekerjaan_pengampu_detail" placeholder="Input pekerjaan..." onfocusin="inputFocus(this);">
                    <div class="help-block _pekerjaan_pengampu"></div>
                    <div class="help-block _pekerjaan_pengampu_detail"></div>
                </div>
                <div class="col-lg-6">
                    <label class="col-form-label">Pengeluaran Perbulan:</label>
                    <input type="number" class="form-control" id="_pengeluaran_perbulan_pengampu" name="_pengeluaran_perbulan_pengampu" />
                    <div class="help-block _pengeluaran_perbulan_pengampu"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>Kondisi PPKS</h4>
                <div class="col-lg-12 mb-2 mt-2">
                    <label class="form-label">Kategori PPKS:</label>
                    <select class="form-control select2 kategori_ppks" id="_kategori_ppks" name="_kategori_ppks" style="width: 100%">
                        <option value=""> --- Pilih Kategori --- </option>
                        <?php if (isset($kategori_ppkss)) { ?>
                            <?php if (count($kategori_ppkss) > 0) { ?>
                                <?php foreach ($kategori_ppkss as $kat) { ?>
                                    <optgroup label="<?= $kat['name'] ?>">
                                        <?php foreach ($kat['value'] as $val) { ?>
                                            <option value="<?= $kat['id'] . '--' . $val ?>"><?= $val ?></option>
                                        <?php } ?>
                                    </optgroup>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <div class="help-block _kategori_ppks"></div>
                </div>
                <div class="col-lg-4 mb-2 mt-2">
                    <label class="form-label">Kondisi Fisik PPKS:</label>
                    <select class="form-control select2 kondisi_fisik_ppks" id="_kondisi_fisik_ppks" name="_kondisi_fisik_ppks" style="width: 100%">
                        <option value=""> --- Pilih --- </option>
                        <option value="Sehat"> Sehat </option>
                        <option value="Sakit"> Sakit </option>
                    </select>
                    <div class="help-block _kondisi_fisik_ppks"></div>
                </div>
                <div class="col-lg-8">
                    <label class="col-form-label">Jelaskan Kondisi Fisik (Penjelasan terkait kondisi kesehatan, kemampuan mobilitas, dst):</label>
                    <textarea rows="3" class="form-control" id="_detail_kondisi_fisik_ppks" name="_detail_kondisi_fisik_ppks"></textarea>
                    <div class="help-block _detail_kondisi_fisik_ppks"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>Kondisi Perekonomi</h4>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_penghasilan_ekonomi" class="col-form-label">Rata - Rata Penghasilan Kepala Keluarga Perbulan:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 penghasilan_ekonomi" id="_penghasilan_ekonomi" name="_penghasilan_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Lebih dari 3 Jt</option>
                            <option value="2">500 Rb s/d 3 Jt</option>
                            <option value="3">Kurang dari 500 Rb</option>
                        </select>
                        <div class="help-block _penghasilan_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_penghasilan_makan_ekonomi" class="col-form-label">Penghasilan dan Makan:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 penghasilan_makan_ekonomi" id="_penghasilan_makan_ekonomi" name="_penghasilan_makan_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Sebagaian besar untuk investasi</option>
                            <option value="2">Sebagian besar untuk konsumsi dasar</option>
                        </select>
                        <div class="help-block _penghasilan_makan_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_makan_ekonomi" class="col-form-label">Makan:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 makan_ekonomi" id="_makan_ekonomi" name="_makan_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Tiga kali/hari</option>
                            <option value="2">Dua kali/hari</option>
                            <option value="3">Satu kali/hari</option>
                        </select>
                        <div class="help-block _makan_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_kemampuan_pakaian_ekonomi" class="col-form-label">Kemampuan membeli pakaian:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 kemampuan_pakaian_ekonomi" id="_kemampuan_pakaian_ekonomi" name="_kemampuan_pakaian_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Tiga kali pertahun</option>
                            <option value="2">Dua kali pertahun</option>
                            <option value="3">Satu kali pertahun</option>
                        </select>
                        <div class="help-block _kemampuan_pakaian_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_tempat_tinggal_ekonomi" class="col-form-label">Tempat Tinggal Saat ini:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 tempat_tinggal_ekonomi" id="_tempat_tinggal_ekonomi" name="_tempat_tinggal_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Milik sendiri</option>
                            <option value="2">Sewa</option>
                            <option value="3">Menumpang</option>
                            <option value="4">Lembaga</option>
                            <option value="5">Terlantar / Menggelandang</option>
                        </select>
                        <div class="help-block _tempat_tinggal_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_tinggal_bersama_ekonomi" class="col-form-label">Tinggal Bersama:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 tinggal_bersama_ekonomi" id="_tinggal_bersama_ekonomi" name="_tinggal_bersama_ekonomi" style="width: 100%" onchange="changeTinggalBersamaEkonomi(this)">
                            <option value="">&nbsp;</option>
                            <option value="Sendiri"> Sendiri </option>
                            <option value="Keluarga Inti">Keluarga Inti </option>
                            <option value="Keluarga Besar">Keluarga Besar </option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <input type="text" style="display: none; margin-top: 10px;" class="form-control tinggal_bersama_ekonomi-detail" id="_tinggal_bersama_ekonomi_detail" name="_tinggal_bersama_ekonomi_detail" placeholder="Input tinggal bersama..." onfocusin="inputFocus(this);">
                        <div class="help-block _tinggal_bersama_ekonomi"></div>
                        <div class="help-block _tinggal_bersama_ekonomi_detail"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_luas_lantai_ekonomi" class="col-form-label">Luas lantai (yang beratap) bangunan tempat tinggal:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 luas_lantai_ekonomi" id="_luas_lantai_ekonomi" name="_luas_lantai_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Lebih dari 8 m²</option>
                            <option value="2">Sampai dengan 8 m²</option>
                        </select>
                        <div class="help-block _luas_lantai_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_jenis_lantai_ekonomi" class="col-form-label">Jenis lantai terluas:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 jenis_lantai_ekonomi" id="_jenis_lantai_ekonomi" name="_jenis_lantai_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Marmer / Granit</option>
                            <option value="2">Keramik</option>
                            <option value="3">Parket / Vinil / Permadani</option>
                            <option value="4">Ubin / Tegel / Teraso kondisi bagus</option>
                            <option value="5">Kayu / Papan kualitas tinggi</option>
                            <option value="6">Ubin / Tegel / Teraso kondisi jelek/rusak</option>
                            <option value="7">Kayu / Papan kualitas rendah</option>
                            <option value="8">Semen/bata merah</option>
                            <option value="9">Bambu</option>
                            <option value="10">Tanah</option>
                        </select>
                        <div class="help-block _jenis_lantai_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_jenis_dinding_ekonomi" class="col-form-label">Jenis dinding terluas:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 jenis_dinding_ekonomi" id="_jenis_dinding_ekonomi" name="_jenis_dinding_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Tembok kondisi bagus</option>
                            <option value="2">Plesteran anyaman bambu/kawat kondisi bagus</option>
                            <option value="3">Kayu/papan/gypsum/GRC kondisi bagus</option>
                            <option value="4">Tembok kondisi jelek/rusak</option>
                            <option value="5">Plesteran anyaman bambu/kawat kondisi jelek/rusak</option>
                            <option value="6">Kayu/papan/gypsum/GRC kondisi jelek/rusak</option>
                            <option value="7">Anyaman bamboo</option>
                            <option value="8">Batang kayu</option>
                            <option value="9">Bambu</option>
                        </select>
                        <div class="help-block _jenis_dinding_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_jenis_atap_ekonomi" class="col-form-label">Jenis Atap terluas:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 jenis_atap_ekonomi" id="_jenis_atap_ekonomi" name="_jenis_atap_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Beton / Genteng beton</option>
                            <option value="2">Genteng keramik</option>
                            <option value="3">Genteng metal</option>
                            <option value="4">Genteng tanah liat kondisi bagus</option>
                            <option value="5">Genteng tanah liat kondisi jelek</option>
                            <option value="6">Seng</option>
                            <option value="7">Sirap</option>
                            <option value="8">Jerami/ijuk/daun daunan/rumbia</option>
                            <option value="9">Asbes</option>
                            <option value="10">Lainnya</option>
                        </select>
                        <div class="help-block _jenis_atap_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_milik_wc_ekonomi" class="col-form-label">Kepemilikan dan penggunaan fasilitas tempat buang air besar:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 milik_wc_ekonomi" id="_milik_wc_ekonomi" name="_milik_wc_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Ada, digunakan hanya anggota keluarga sendiri</option>
                            <option value="2">Ada, digunakan bersama anggota keluarga dari keluarga tertentu</option>
                            <option value="3">Ada, di MCK komunal</option>
                            <option value="4">Ada, di MCK umum/siapapun menggunakan</option>
                            <option value="5">Ada, anggota keluarga tidak menggunakan</option>
                            <option value="6">Tidak ada fasilitas</option>
                        </select>
                        <div class="help-block _milik_wc_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_jenis_wc_ekonomi" class="col-form-label">Jenis kloset (tempat buang air besar):</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 jenis_wc_ekonomi" id="_jenis_wc_ekonomi" name="_jenis_wc_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Duduk / Leher angsa</option>
                            <option value="2">Plengsengan</option>
                            <option value="3">Cemplung/cubluk</option>
                            <option value="4">Tidak pakai</option>
                        </select>
                        <div class="help-block _jenis_wc_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_penerangan_ekonomi" class="col-form-label">Sumber penerangan utama:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 penerangan_ekonomi" id="_penerangan_ekonomi" name="_penerangan_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Listrik PLN > 2.200 volt ampere</option>
                            <option value="2">Listrik PLN 2.200 volt ampere</option>
                            <option value="3">Listrik PLN 1.300 volt ampere</option>
                            <option value="4">Listrik Non PLN > 2.200 volt ampere</option>
                            <option value="5">Listrik Non PLN 2.200 volt ampere</option>
                            <option value="6">Listrik Non PLN 1.300 volt ampere</option>
                            <option value="7">Listrik PLN 900 volt ampere</option>
                            <option value="8">Listrik Non PLN 900 volt ampere</option>
                            <option value="9">Listrik PLN 450 volt ampere</option>
                            <option value="10">Listrik Non PLN 450 volt ampere</option>
                            <option value="11">Bukan Listrik</option>
                        </select>
                        <div class="help-block _penerangan_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_sumber_air_minum_ekonomi" class="col-form-label">Sumber air minum:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 sumber_air_minum_ekonomi" id="_sumber_air_minum_ekonomi" name="_sumber_air_minum_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Air kemasan bermerk</option>
                            <option value="2">Air isi ulang</option>
                            <option value="3">Leding</option>
                            <option value="4">Sumur bor/pompa</option>
                            <option value="5">Sumur terlindungi</option>
                            <option value="6">Sumur tak terlindungi</option>
                            <option value="7">Mata air terlindungi</option>
                            <option value="8">Mata air tak terlindungi</option>
                            <option value="9">Air permukaan (Sungai/danau/waduk/kolam/irigasi)</option>
                            <option value="10">Air hujan</option>
                            <option value="11">Lainnya</option>
                        </select>
                        <div class="help-block _sumber_air_minum_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_bahan_bakar_masak_ekonomi" class="col-form-label">Bahan bakar/energi utama untuk memasak:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 bahan_bakar_masak_ekonomi" id="_bahan_bakar_masak_ekonomi" name="_bahan_bakar_masak_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Listrik</option>
                            <option value="2">Gas > 3 Kg</option>
                            <option value="3">Gas kota / biogas</option>
                            <option value="4">Gas 3 Kg</option>
                            <option value="5">Minyak tanah</option>
                            <option value="6">Briket</option>
                            <option value="7">Arang</option>
                            <option value="8">Kayu bakar</option>
                            <option value="9">Tidak memasak di rumah</option>
                        </select>
                        <div class="help-block _bahan_bakar_masak_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_berobat_ekonomi" class="col-form-label">Kemampuan berobat:</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 berobat_ekonomi" id="_berobat_ekonomi" name="_berobat_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Dokter</option>
                            <option value="2">Mantri</option>
                            <option value="3">Puskesmas</option>
                        </select>
                        <div class="help-block _berobat_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2 mt-2">
                    <label for="_rata_pendidikan_ekonomi" class="col-form-label">Rata - rata tingkat pendidikan keluarga (berdasarkan kepemilikan ijazah):</label>
                    <div class="col-sm-8 mt-2">
                        <select class="form-control select2 rata_pendidikan_ekonomi" id="_rata_pendidikan_ekonomi" name="_rata_pendidikan_ekonomi" style="width: 100%">
                            <option value=""> --- Pilih --- </option>
                            <option value="1">Perguruan tinggi</option>
                            <option value="2">SMA/sederajat</option>
                            <option value="3">SMP/sederajat</option>
                            <option value="4">SD/sederajat</option>
                            <option value="5">Tidak bersekolah</option>
                        </select>
                        <div class="help-block _rata_pendidikan_ekonomi"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Catatan tambahan lainnya:</label>
                    <textarea rows="3" class="form-control" id="_catatan_tambahan" name="_catatan_tambahan"></textarea>
                    <div class="help-block _catatan_tambahan"></div>
                </div>
                <hr style="margin-top: 10px;" />
                <h4>Laporan Assesment</h4>
                <div class="col-lg-12">
                    <label class="col-form-label">Gambaran Kasus:</label>
                    <textarea rows="3" class="form-control" id="_gambaran_kasus" name="_gambaran_kasus"></textarea>
                    <div class="help-block _gambaran_kasus"></div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Uraian Kondisi Kesehatan:</label>
                    <textarea rows="3" class="form-control" id="_kondisi_kesehatan" name="_kondisi_kesehatan"></textarea>
                    <div class="help-block _kondisi_kesehatan"></div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Uraian Permasalahan:</label>
                    <textarea rows="3" class="form-control" id="_permasalahan" name="_permasalahan"></textarea>
                    <div class="help-block _permasalahan"></div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Uraian Identifikasi Kebutuhan:</label>
                    <textarea rows="3" class="form-control" id="_identifikasi_kebutuhan" name="_identifikasi_kebutuhan"></textarea>
                    <div class="help-block _identifikasi_kebutuhan"></div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Uraian Intervernsi yang Telah Dilakukan:</label>
                    <textarea rows="3" class="form-control" id="_intervensi_telah_dilakukan" name="_intervensi_telah_dilakukan"></textarea>
                    <div class="help-block _intervensi_telah_dilakukan"></div>
                </div>
                <div class="col-lg-12">
                    <label class="col-form-label">Uraian Saran / Rencana Tindak Lanjut:</label>
                    <textarea rows="3" class="form-control" id="_saran_tindak_lanjut" name="_saran_tindak_lanjut"></textarea>
                    <div class="help-block _saran_tindak_lanjut"></div>
                </div>
            </div>
            <hr />
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="saveAssesmentPengaduan(this)" class="btn btn-primary waves-effect waves-light">Simpan Assesment PPKS</button>
        </div>
    </form>
    <script>
        function validateForm() {
            const kecamatan_ktp = document.getElementById('_kecamatan_ktp').value;
            const kelurahan_ktp = document.getElementById('_kelurahan_ktp').value;
            const alamat_ktp = document.getElementById('_alamat_ktp').value;
            const kecamatan_domisili = document.getElementById('_kecamatan_domisili').value;
            const kelurahan_domisili = document.getElementById('_kelurahan_domisili').value;
            const alamat_domisili = document.getElementById('_alamat_domisili').value;
            const nama_identitas = document.getElementById('_nama_identitas').value;
            const tempat_lahir_identitas = document.getElementById('_tempat_lahir_identitas').value;
            const tgl_lahir_identitas = document.getElementById('_tgl_lahir_identitas').value;
            const jenis_kelamin_identitas = document.getElementById('_jenis_kelamin_identitas').value;
            const agama_identitas = document.getElementById('_agama_identitas').value;
            const nik_identitas = document.getElementById('_nik_identitas').value;
            const kk_identitas = document.getElementById('_kk_identitas').value;
            const akta_identitas = document.getElementById('_akta_identitas').value;
            const dtks_identitas = document.getElementById('_dtks_identitas').value;
            const identitasRows = document.querySelectorAll('#table-bansos-identitas tbody tr');
            const pendidikan_terakhir_identitas = document.getElementById('_pendidikan_terakhir_identitas').value;
            const status_kawin_identitas = document.getElementById('_status_kawin_identitas').value;

            const nama_pengampu = document.getElementById('_nama_pengampu').value;
            const nohp_pengampu = document.getElementById('_nohp_pengampu').value;
            const hubungan_pengampu = document.getElementById('_hubungan_pengampu').value;
            const hubungan_pengampu_detail = document.getElementById('_hubungan_pengampu_detail').value;
            const tempat_lahir_pengampu = document.getElementById('_tempat_lahir_pengampu').value;
            const tgl_lahir_pengampu = document.getElementById('_tgl_lahir_pengampu').value;
            const jenis_kelamin_pengampu = document.getElementById('_jenis_kelamin_pengampu').value;
            const agama_pengampu = document.getElementById('_agama_pengampu').value;
            const nik_pengampu = document.getElementById('_nik_pengampu').value;
            const kk_pengampu = document.getElementById('_kk_pengampu').value;
            const dtks_pengampu = document.getElementById('_dtks_pengampu').value;
            const pengampuRows = document.querySelectorAll('#table-bansos-pengampu tbody tr');
            const pendidikan_terakhir_pengampu = document.getElementById('_pendidikan_terakhir_pengampu').value;
            const status_kawin_pengampu = document.getElementById('_status_kawin_pengampu').value;
            const pekerjaan_pengampu = document.getElementById('_pekerjaan_pengampu').value;
            const pekerjaan_pengampu_detail = document.getElementById('_pekerjaan_pengampu_detail').value;
            const pengeluaran_perbulan_pengampu = document.getElementById('_pengeluaran_perbulan_pengampu').value;

            const kategori_ppks = document.getElementById('_kategori_ppks').value;
            const kondisi_fisik_ppks = document.getElementById('_kondisi_fisik_ppks').value;
            const detail_kondisi_fisik_ppks = document.getElementById('_detail_kondisi_fisik_ppks').value;

            const penghasilan_ekonomi = document.getElementById('_penghasilan_ekonomi').value;
            const penghasilan_makan_ekonomi = document.getElementById('_penghasilan_makan_ekonomi').value;
            const makan_ekonomi = document.getElementById('_makan_ekonomi').value;
            const kemampuan_pakaian_ekonomi = document.getElementById('_kemampuan_pakaian_ekonomi').value;
            const tempat_tinggal_ekonomi = document.getElementById('_tempat_tinggal_ekonomi').value;
            const tinggal_bersama_ekonomi = document.getElementById('_tinggal_bersama_ekonomi').value;
            const luas_lantai_ekonomi = document.getElementById('_luas_lantai_ekonomi').value;
            const jenis_lantai_ekonomi = document.getElementById('_jenis_lantai_ekonomi').value;
            const jenis_dinding_ekonomi = document.getElementById('_jenis_dinding_ekonomi').value;
            const jenis_atap_ekonomi = document.getElementById('_jenis_atap_ekonomi').value;
            const milik_wc_ekonomi = document.getElementById('_milik_wc_ekonomi').value;
            const jenis_wc_ekonomi = document.getElementById('_jenis_wc_ekonomi').value;
            const penerangan_ekonomi = document.getElementById('_penerangan_ekonomi').value;
            const sumber_air_minum_ekonomi = document.getElementById('_sumber_air_minum_ekonomi').value;
            const bahan_bakar_masak_ekonomi = document.getElementById('_bahan_bakar_masak_ekonomi').value;
            const berobat_ekonomi = document.getElementById('_berobat_ekonomi').value;
            const rata_pendidikan_ekonomi = document.getElementById('_rata_pendidikan_ekonomi').value;

            const catatan_tambahan = document.getElementById('_catatan_tambahan').value;

            const gambaran_kasus = document.getElementById('_gambaran_kasus').value;
            const kondisi_kesehatan = document.getElementById('_kondisi_kesehatan').value;
            const permasalahan = document.getElementById('_permasalahan').value;
            const identifikasi_kebutuhan = document.getElementById('_identifikasi_kebutuhan').value;
            const intervensi_telah_dilakukan = document.getElementById('_intervensi_telah_dilakukan').value;
            const saran_tindak_lanjut = document.getElementById('_saran_tindak_lanjut').value;

            let isValid = true;

            if (kecamatan_ktp.trim() === '') {
                console.log(1);
                isValid = false;
                document.querySelector('._kecamatan_ktp').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih kecamatan sesuai KTP PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._kecamatan_ktp').innerHTML = '';
            }

            if (kelurahan_ktp.trim() === '') {
                console.log(2);
                isValid = false;
                document.querySelector('._kelurahan_ktp').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih kelurahan sesuai KTP PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._kelurahan_ktp').innerHTML = '';
            }

            if (alamat_ktp.trim() === '') {
                console.log(3);
                isValid = false;
                document.querySelector('._alamat_ktp').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Alamat KTP PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._alamat_ktp').innerHTML = '';
            }

            if (kecamatan_domisili.trim() === '') {
                console.log(4);
                isValid = false;
                document.querySelector('._kecamatan_domisili').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih kecamatan sesuai Domisili PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._kecamatan_domisili').innerHTML = '';
            }

            if (kelurahan_domisili.trim() === '') {
                console.log(5);
                isValid = false;
                document.querySelector('._kelurahan_domisili').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih kelurahan sesuai Domisili PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._kelurahan_domisili').innerHTML = '';
            }

            if (alamat_domisili.trim() === '') {
                console.log(6);
                isValid = false;
                document.querySelector('._alamat_domisili').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Alamat Domisi PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._alamat_domisili').innerHTML = '';
            }

            if (nama_identitas.trim() === '') {
                console.log(7);
                isValid = false;
                document.querySelector('._nama_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._nama_identitas').innerHTML = '';
            }

            if (tempat_lahir_identitas.trim() === '') {
                console.log(8);
                isValid = false;
                document.querySelector('._tempat_lahir_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tempat Lahir PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tempat_lahir_identitas').innerHTML = '';
            }

            if (tgl_lahir_identitas.trim() === '') {
                console.log(9);
                isValid = false;
                document.querySelector('._tgl_lahir_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal Lahir PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tgl_lahir_identitas').innerHTML = '';
            }

            if (jenis_kelamin_identitas.trim() === '') {
                console.log(10);
                isValid = false;
                document.querySelector('._jenis_kelamin_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Jenis Kelamin PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._jenis_kelamin_identitas').innerHTML = '';
            }

            if (agama_identitas.trim() === '') {
                console.log(11);
                isValid = false;
                document.querySelector('._agama_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Agama PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._agama_identitas').innerHTML = '';
            }

            if (nik_identitas.trim() === '') {
                console.log(12);
                isValid = false;
                document.querySelector('._nik_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._nik_identitas').innerHTML = '';
            }

            if (kk_identitas.trim() === '') {
                console.log(13);
                isValid = false;
                document.querySelector('._kk_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nomor Kartu Keluarga (KK) PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kk_identitas').innerHTML = '';
            }

            if (akta_identitas.trim() === '') {
                console.log(14);
                isValid = false;
                document.querySelector('._akta_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nomor Akta Kelahiran (Akta Lahir) PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._akta_identitas').innerHTML = '';
            }

            if (dtks_identitas.trim() === '') {
                console.log(15);
                isValid = false;
                document.querySelector('._dtks_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih DTKS PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._dtks_identitas').innerHTML = '';
            }

            identitasRows.forEach(function(row, index) {
                // if (index === 0) {

                // } else {
                const namaI = row.querySelector('input[name="nama_bansos_identitas[]"]');

                if (!namaI || namaI === undefined) {
                    console.log(16);
                    isValid = false;
                    row.querySelector('.nama_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const namaidentitas = namaI.value;
                    if (namaidentitas.trim() === '') {
                        console.log(17);
                        isValid = false;
                        row.querySelector('.nama_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.nama_bansos_identitas_' + index).innerHTML = '';
                    }
                }

                const waktuI = row.querySelector('input[name="waktu_bansos_identitas[]"]');

                if (!waktuI || waktuI === undefined) {
                    console.log(18);
                    isValid = false;
                    row.querySelector('.waktu_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">waktu Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const waktuidentitas = waktuI.value;
                    if (waktuidentitas.trim() === '') {
                        console.log(19);
                        isValid = false;
                        row.querySelector('.waktu_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">waktu Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.waktu_bansos_identitas_' + index).innerHTML = '';
                    }
                }
                const sumberI = row.querySelector('input[name="sumber_anggaran_identitas[]"]');

                if (!sumberI || sumberI === undefined) {
                    console.log(20);
                    isValid = false;
                    row.querySelector('.sumber_anggaran_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Sumber Anggaran Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const sumberidentitas = sumberI.value;
                    if (sumberidentitas.trim() === '') {
                        console.log(21);
                        isValid = false;
                        row.querySelector('.sumber_anggaran_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Sumber Anggaran Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.sumber_anggaran_identitas_' + index).innerHTML = '';
                    }
                }
                const jumlahI = row.querySelector('input[name="jumlah_bansos_identitas[]"]');

                if (!jumlahI || jumlahI === undefined) {
                    console.log(22);
                    isValid = false;
                    row.querySelector('.jumlah_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jumlah Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const jumlahidentitas = jumlahI.value;
                    if (jumlahidentitas.trim() === '') {
                        console.log(23);
                        isValid = false;
                        row.querySelector('.jumlah_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jumlah Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.jumlah_bansos_identitas_' + index).innerHTML = '';
                    }
                }
                const satuanI = row.querySelector('input[name="satuan_bansos_identitas[]"]');

                if (!satuanI || satuanI === undefined) {
                    console.log(24);
                    isValid = false;
                    row.querySelector('.satuan_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">satuan Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const satuanidentitas = satuanI.value;
                    if (satuanidentitas.trim() === '') {
                        console.log(25);
                        isValid = false;
                        row.querySelector('.satuan_bansos_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">satuan Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.satuan_bansos_identitas_' + index).innerHTML = '';
                    }
                }
                const keteranganI = row.querySelector('textarea[name="keterangan_identitas[]"]');

                if (!keteranganI || keteranganI === undefined) {
                    console.log(26);
                    isValid = false;
                    row.querySelector('.keterangan_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;"Keterangan Bansos PPKS tidak boleh kosong</li></ul>';
                } else {
                    const keteranganidentitas = keteranganI.value;
                    if (keteranganidentitas.trim() === '') {
                        console.log(27);
                        isValid = false;
                        row.querySelector('.keterangan_identitas_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Keterangan Bansos PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.keterangan_identitas_' + index).innerHTML = '';
                    }
                }

            });

            if (pendidikan_terakhir_identitas.trim() === '') {
                console.log(28);
                isValid = false;
                document.querySelector('._pendidikan_terakhir_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pendidikan Terakhir PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._pendidikan_terakhir_identitas').innerHTML = '';
            }

            if (status_kawin_identitas.trim() === '') {
                console.log(29);
                isValid = false;
                document.querySelector('._status_kawin_identitas').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Status Perkawinan PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._status_kawin_identitas').innerHTML = '';
            }

            if (nama_pengampu.trim() === '') {
                console.log(30);
                isValid = false;
                document.querySelector('._nama_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._nama_pengampu').innerHTML = '';
            }

            if (nohp_pengampu.trim() === '') {
                console.log(31);
                isValid = false;
                document.querySelector('._nohp_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">No Handphone / Telp pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._nohp_pengampu').innerHTML = '';
            }

            if (hubungan_pengampu.trim() === '') {
                console.log(32);
                isValid = false;
                document.querySelector('._hubungan_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Hubungan pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                if (hubungan_pengampu.trim() === 'Lainnya') {
                    if (hubungan_pengampu_detail.trim() === '') {
                        console.log(33);
                        isValid = false;
                        document.querySelector('._hubungan_pengampu_detail').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Masukkan Hubungan pengampu PPKS.</li></ul>';
                    } else {
                        document.querySelector('._hubungan_pengampu_detail').innerHTML = '';
                    }
                } else {
                    document.querySelector('._hubungan_pengampu').innerHTML = '';
                }
            }

            if (tempat_lahir_pengampu.trim() === '') {
                console.log(34);
                isValid = false;
                document.querySelector('._tempat_lahir_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tempat Lahir Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tempat_lahir_pengampu').innerHTML = '';
            }

            if (tgl_lahir_pengampu.trim() === '') {
                console.log(35);
                isValid = false;
                document.querySelector('._tgl_lahir_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tanggal Lahir Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tgl_lahir_pengampu').innerHTML = '';
            }

            if (jenis_kelamin_pengampu.trim() === '') {
                console.log(36);
                isValid = false;
                document.querySelector('._jenis_kelamin_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Jenis Kelamin Pengampu PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._jenis_kelamin_pengampu').innerHTML = '';
            }

            if (agama_pengampu.trim() === '') {
                console.log(37);
                isValid = false;
                document.querySelector('._agama_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih Agama Pengampu PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._agama_pengampu').innerHTML = '';
            }

            if (nik_pengampu.trim() === '') {
                console.log(38);
                isValid = false;
                document.querySelector('._nik_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">NIK Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._nik_pengampu').innerHTML = '';
            }

            if (kk_pengampu.trim() === '') {
                console.log(39);
                isValid = false;
                document.querySelector('._kk_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nomor Kartu Keluarga (KK) Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kk_pengampu').innerHTML = '';
            }

            if (dtks_pengampu.trim() === '') {
                console.log(40);
                isValid = false;
                document.querySelector('._dtks_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pilih DTKS Pengampu PPKS terlebih dahulu.</li></ul>';
            } else {
                document.querySelector('._dtks_pengampu').innerHTML = '';
            }

            pengampuRows.forEach(function(row, index) {
                // if (index === 0) {

                // } else {
                const namaP = row.querySelector('input[name="nama_bansos_pengampu[]"]');

                if (!namaP || namaP === undefined) {
                    console.log(41);
                    isValid = false;
                    row.querySelector('.nama_bansos_pengampu_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama Bansos Pengampu PPKS tidak boleh kosong</li></ul>';
                } else {
                    const namapengampu = namaP.value;
                    if (namapengampu.trim() === '') {
                        console.log(42);
                        isValid = false;
                        row.querySelector('.nama_bansos_pengampu_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Nama Bansos Pengampu PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.nama_bansos_pengampu_' + index).innerHTML = '';
                    }
                }

                const tahunP = row.querySelector('input[name="tahun_bansos_pengampu[]"]');

                if (!tahunP || tahunP === undefined) {
                    console.log(43);
                    isValid = false;
                    row.querySelector('.tahun_bansos_pengampu_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tahun Bansos Pengampu PPKS tidak boleh kosong</li></ul>';
                } else {
                    const tahunpengampu = tahunP.value;
                    if (tahunpengampu.trim() === '') {
                        console.log(44);
                        isValid = false;
                        row.querySelector('.tahun_bansos_pengampu_' + index).innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tahun Bansos Pengampu PPKS tidak boleh kosong</li></ul>';
                    } else {
                        row.querySelector('.tahun_bansos_pengampu_' + index).innerHTML = '';
                    }
                }

            });

            if (pendidikan_terakhir_pengampu.trim() === '') {
                console.log(45);
                isValid = false;
                document.querySelector('._pendidikan_terakhir_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pendidikan Terakhir Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._pendidikan_terakhir_pengampu').innerHTML = '';
            }

            if (status_kawin_pengampu.trim() === '') {
                console.log(46);
                isValid = false;
                document.querySelector('._status_kawin_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Status Perkawinan Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._status_kawin_pengampu').innerHTML = '';
            }

            if (pekerjaan_pengampu.trim() === '') {
                console.log(47);
                isValid = false;
                document.querySelector('._pekerjaan_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pekerjaan pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                if (pekerjaan_pengampu.trim() === 'Lainnya') {
                    if (pekerjaan_pengampu_detail.trim() === '') {
                        console.log(48);
                        isValid = false;
                        document.querySelector('._pekerjaan_pengampu_detail').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Masukkan Pekerjaan pengampu PPKS.</li></ul>';
                    } else {
                        document.querySelector('._pekerjaan_pengampu_detail').innerHTML = '';
                    }
                } else {
                    document.querySelector('._pekerjaan_pengampu').innerHTML = '';
                }
            }

            if (pengeluaran_perbulan_pengampu.trim() === '') {
                console.log(49);
                isValid = false;
                document.querySelector('._pengeluaran_perbulan_pengampu').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Pengeluaran Perbulan Pengampu PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._pengeluaran_perbulan_pengampu').innerHTML = '';
            }

            if (kategori_ppks.trim() === '') {
                console.log(50);
                isValid = false;
                document.querySelector('._kategori_ppks').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kategori PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kategori_ppks').innerHTML = '';
            }

            if (kondisi_fisik_ppks.trim() === '') {
                console.log(51);
                isValid = false;
                document.querySelector('._kondisi_fisik_ppks').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kondisi Fisik PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kondisi_fisik_ppks').innerHTML = '';
            }

            if (detail_kondisi_fisik_ppks.trim() === '') {
                console.log(52);
                isValid = false;
                document.querySelector('._detail_kondisi_fisik_ppks').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Detail Kondisi Fisik PPKS tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._detail_kondisi_fisik_ppks').innerHTML = '';
            }

            if (penghasilan_ekonomi.trim() === '') {
                console.log(53);
                isValid = false;
                document.querySelector('._penghasilan_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Rata-rata penghasilan Kepala Keluarga perbulan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._penghasilan_ekonomi').innerHTML = '';
            }

            if (penghasilan_makan_ekonomi.trim() === '') {
                console.log(54);
                isValid = false;
                document.querySelector('._penghasilan_makan_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Penghasilan dan Makan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._penghasilan_makan_ekonomi').innerHTML = '';
            }

            if (makan_ekonomi.trim() === '') {
                console.log(55);
                isValid = false;
                document.querySelector('._makan_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Makan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._makan_ekonomi').innerHTML = '';
            }

            if (kemampuan_pakaian_ekonomi.trim() === '') {
                console.log(56);
                isValid = false;
                document.querySelector('._kemampuan_pakaian_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kemampuan membeli pakaian pertahun tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kemampuan_pakaian_ekonomi').innerHTML = '';
            }

            if (tempat_tinggal_ekonomi.trim() === '') {
                console.log(57);
                isValid = false;
                document.querySelector('._tempat_tinggal_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tempat tinggal saat ini tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._tempat_tinggal_ekonomi').innerHTML = '';
            }

            if (tinggal_bersama_ekonomi.trim() === '') {
                console.log(58);
                isValid = false;
                document.querySelector('._tinggal_bersama_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Tinggal bersama tidak boleh kosong.</li></ul>';
            } else {
                if (tinggal_bersama_ekonomi.trim() === 'Lainnya') {
                    if (tinggal_bersama_ekonomi_detail.trim() === '') {
                        console.log(59);
                        isValid = false;
                        document.querySelector('._tinggal_bersama_ekonomi_detail').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Masukkan tinggal bersama.</li></ul>';
                    } else {
                        document.querySelector('._tinggal_bersama_ekonomi_detail').innerHTML = '';
                    }
                } else {
                    document.querySelector('._tinggal_bersama_ekonomi').innerHTML = '';
                }
            }

            if (luas_lantai_ekonomi.trim() === '') {
                console.log(60);
                isValid = false;
                document.querySelector('._luas_lantai_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Luas lantai tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._luas_lantai_ekonomi').innerHTML = '';
            }

            if (jenis_lantai_ekonomi.trim() === '') {
                console.log(61);
                isValid = false;
                document.querySelector('._jenis_lantai_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis lantai tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._jenis_lantai_ekonomi').innerHTML = '';
            }

            if (jenis_dinding_ekonomi.trim() === '') {
                console.log(62);
                isValid = false;
                document.querySelector('._jenis_dinding_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis dinding tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._jenis_dinding_ekonomi').innerHTML = '';
            }

            if (jenis_atap_ekonomi.trim() === '') {
                console.log(63);
                isValid = false;
                document.querySelector('._jenis_atap_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis atap tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._jenis_atap_ekonomi').innerHTML = '';
            }

            if (milik_wc_ekonomi.trim() === '') {
                console.log(64);
                isValid = false;
                document.querySelector('._milik_wc_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kepemilikan dan penggunaan fasilitas tempat buang air besar tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._milik_wc_ekonomi').innerHTML = '';
            }

            if (jenis_wc_ekonomi.trim() === '') {
                console.log(65);
                isValid = false;
                document.querySelector('._jenis_wc_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Jenis kloset (tempat buang air besar) tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._jenis_wc_ekonomi').innerHTML = '';
            }

            if (penerangan_ekonomi.trim() === '') {
                console.log(66);
                isValid = false;
                document.querySelector('._penerangan_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Sumber penerangan utama tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._penerangan_ekonomi').innerHTML = '';
            }

            if (sumber_air_minum_ekonomi.trim() === '') {
                console.log(67);
                isValid = false;
                document.querySelector('._sumber_air_minum_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Sumber air minum tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._sumber_air_minum_ekonomi').innerHTML = '';
            }

            if (bahan_bakar_masak_ekonomi.trim() === '') {
                console.log(68);
                isValid = false;
                document.querySelector('._bahan_bakar_masak_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Bahan bakar memasak tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._bahan_bakar_masak_ekonomi').innerHTML = '';
            }

            if (berobat_ekonomi.trim() === '') {
                console.log(69);
                isValid = false;
                document.querySelector('._berobat_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Kemampuan berobat tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._berobat_ekonomi').innerHTML = '';
            }

            if (rata_pendidikan_ekonomi.trim() === '') {
                console.log(70);
                isValid = false;
                document.querySelector('._rata_pendidikan_ekonomi').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Rata-rata tingkat pendidikan dalam keluarga tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._rata_pendidikan_ekonomi').innerHTML = '';
            }

            if (catatan_tambahan.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._catatan_tambahan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Catatan tambahan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._catatan_tambahan').innerHTML = '';
            }

            if (gambaran_kasus.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._gambaran_kasus').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian gambaran kasus tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._gambaran_kasus').innerHTML = '';
            }
            if (kondisi_kesehatan.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._kondisi_kesehatan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian kondisi kesehatan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._kondisi_kesehatan').innerHTML = '';
            }
            if (permasalahan.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._permasalahan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian permasalahan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._permasalahan').innerHTML = '';
            }
            if (identifikasi_kebutuhan.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._identifikasi_kebutuhan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian identifikasi kebutuhan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._identifikasi_kebutuhan').innerHTML = '';
            }
            if (intervensi_telah_dilakukan.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._intervensi_telah_dilakukan').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian intervensi yang telah dilakukan tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._intervensi_telah_dilakukan').innerHTML = '';
            }
            if (saran_tindak_lanjut.trim() === '') {
                console.log(71);
                isValid = false;
                document.querySelector('._saran_tindak_lanjut').innerHTML = '<ul role="alert" style="color: #dc3545; list-style-type: none; margin-block-start: 0px; padding-inline-start: 10px;"><li style="color: #dc3545;">Uraian Saran / Rencana tindak lanjut tidak boleh kosong.</li></ul>';
            } else {
                document.querySelector('._saran_tindak_lanjut').innerHTML = '';
            }

            return isValid;
        }

        function changeKecamatanKtp(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getKelurahan',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.kelurahan_ktp').html("");
                        $('div.select2-kelurahan-ktp-loading').block({
                            message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.select2-kelurahan-ktp-loading').unblock();
                        if (resul.status == 200) {
                            $('.kelurahan_ktp').html(resul.data);
                        } else {
                            if (resul.status == 401) {
                                Swal.fire(
                                    'PERINGATAN!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage(resul.redirrect);
                                })
                            } else {
                                Swal.fire(
                                    'PERINGATAN!!!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        }
                    },
                    error: function(data) {
                        $('div.select2-kelurahan-ktp-loading').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        }

        function changeKecamatanDomisili(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value !== "") {
                $.ajax({
                    url: './getKelurahan',
                    type: 'POST',
                    data: {
                        id: event.value,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.kelurahan_domisili').html("");
                        $('div.select2-kelurahan-domisili-loading').block({
                            message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.select2-kelurahan-domisili-loading').unblock();
                        if (resul.status == 200) {
                            $('.kelurahan_domisili').html(resul.data);
                        } else {
                            if (resul.status == 401) {
                                Swal.fire(
                                    'PERINGATAN!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage(resul.redirrect);
                                })
                            } else {
                                Swal.fire(
                                    'PERINGATAN!!!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        }
                    },
                    error: function(data) {
                        $('div.select2-kelurahan-domisili-loading').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        }

        $(document).ready(function() {
            initSelect2("_kecamatan_ktp", ".contentApproveBodyModal");
            initSelect2("_kelurahan_ktp", ".contentApproveBodyModal");
            initSelect2("_kecamatan_domisili", ".contentApproveBodyModal");
            initSelect2("_kelurahan_domisili", ".contentApproveBodyModal");
            initSelect2("_kategori_ppks", ".contentApproveBodyModal");

            $("#btnAddRowBansosIdentitas").on("click", function() {
                addRowIdentitas('table-bansos-identitas');
            });

            $("#btnAddRowBansosPengampu").on("click", function() {
                addRowPengampu('table-bansos-pengampu');
            });
        });

        function addRowIdentitas(event) {
            const table = document.getElementById(event);
            const rowCount = table.rows.length - 1;

            const newRow = table.insertRow(-1);
            const cells = [];

            for (let i = 0; i < 6; i++) {
                cells[i] = newRow.insertCell(i);
                // if (i > 1 && i < 8) {
                cells[i].setAttribute("style", "vertical-align: top;");
                // }
                // if (i === 9) {
                //     cells[i].setAttribute("style", "vertical-align: center;");
                // }
            }

            cells[0].innerHTML = `<input class="form-control" type="date" id="waktu_bansos_identitas_${rowCount}" name="waktu_bansos_identitas[]" /><br />
                        <div class="help-block waktu_bansos_identitas_${rowCount}"></div>`;
            cells[1].innerHTML = `<input class="form-control" type="text" id="nama_bansos_identitas_${rowCount}" name="nama_bansos_identitas[]" /><br />
                        <div class="help-block nama_bansos_identitas_${rowCount}"></div>`;
            cells[2].innerHTML = `<input class="form-control" type="number" id="jumlah_bansos_identitas_${rowCount}" name="jumlah_bansos_identitas[]" /><br />
                        <div class="help-block jumlah_bansos_identitas_${rowCount}"></div>`;
            cells[3].innerHTML = `<input class="form-control" type="text" id="satuan_bansos_identitas_${rowCount}" name="satuan_bansos_identitas[]" /><br />
                        <div class="help-block satuan_bansos_identitas_${rowCount}"></div>`;
            cells[4].innerHTML = `<input class="form-control" type="text" id="sumber_anggaran_identitas_${rowCount}" name="sumber_anggaran_identitas[]" /><br />
                                    <div class="help-block sumber_anggaran_identitas_${rowCount}"></div>`;
            cells[5].innerHTML = `<textarea class="form-control" rows="1" id="keterangan_identitas_${rowCount}" name="keterangan_identitas[]"></textarea><br />
                                    <div class="help-block keterangan_identitas_${rowCount}"></div>`;
            cells[6].innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRowIdentitas(this)"><i class="bx bx-trash"></i></button>';

        }

        function addRowPengampu(event) {
            const tablePengampu = document.getElementById(event);
            const rowCountPengampu = tablePengampu.rows.length - 1;

            const newRowPengampu = tablePengampu.insertRow(-1);
            const cellsPengampu = [];

            for (let i = 0; i < 6; i++) {
                cellsPengampu[i] = newRowPengampu.insertCell(i);
                // if (i > 1 && i < 8) {
                cellsPengampu[i].setAttribute("style", "vertical-align: top;");
                // }
                // if (i === 9) {
                //     cells[i].setAttribute("style", "vertical-align: center;");
                // }
            }

            cellsPengampu[0].innerHTML = `<input class="form-control" type="text" id="nama_bansos_pengampu_${rowCountPengampu}" name="nama_bansos_pengampu[]" /><br />
                        <div class="help-block nama_bansos_pengampu_${rowCountPengampu}"></div>`;
            cellsPengampu[1].innerHTML = `<input class="form-control" type="number" id="tahun_bansos_pengampu_${rowCountPengampu}" name="tahun_bansos_pengampu[]" /><br />
                        <div class="help-block tahun_bansos_pengampu_${rowCountPengampu}"></div>`;
            cellsPengampu[2].innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRowPengampu(this)"><i class="bx bx-trash"></i></button>';

        }

        function deleteRowIdentitas(button) {
            const row = button.parentNode.parentNode;
            const table = row.parentNode;
            table.removeChild(row);
        }

        function deleteRowPengampu(button) {
            const rowPengampu = button.parentNode.parentNode;
            const tablePengampu = rowPengampu.parentNode;
            tablePengampu.removeChild(rowPengampu);
        }

        function changeHubungan(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value === "Lainnya") {
                document.getElementById("_hubungan_pengampu_detail").style.display = "block";
            } else {
                document.getElementById("_hubungan_pengampu_detail").style.display = "none";
            }
        }

        function changePekerjaanPengampu(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value === "Lainnya") {
                document.getElementById("_pekerjaan_pengampu_detail").style.display = "block";
            } else {
                document.getElementById("_pekerjaan_pengampu_detail").style.display = "none";
            }
        }

        function changeTinggalBersamaEkonomi(event) {
            const color = $(event).attr('name');
            $(event).removeAttr('style');
            $('.' + color).html('');

            if (event.value === "Lainnya") {
                document.getElementById("_tinggal_bersama_ekonomi_detail").style.display = "block";
            } else {
                document.getElementById("_tinggal_bersama_ekonomi_detail").style.display = "none";
            }
        }

        function downloadPDF(pdf, fileName, redirrect) {
            // const linkSource = `data:application/octet-stream;base64,${pdf}`;
            const linkSource = `${pdf}`;
            const newTab = window.open(linkSource, '_blank');
            if (!newTab) {
                Swal.fire(
                    'WARNING!',
                    "Popup blocked. Please allow popups for this website and try again.",
                    'warning'
                );
            } else {
                reloadPage(redirrect);
            }
            // const linkSource = `data:application/octet-stream;base64,${pdf}`;
            // const downloadLink = document.createElement("a");
            // downloadLink.href = linkSource;
            // downloadLink.download = fileName + ".pdf";
            // downloadLink.click();
        }

        function saveAssesmentPengaduan(e) {
            // console.log(e.form);
            if (validateForm()) {
                console.log("mulai");
                $('div.modal-content-loading-approve').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
                let formData = new FormData(document.getElementById('tindakLanjutPengaduanForm'));
                // var formData = new FormData(e.form);

                console.log("going send");
                fetch('./simpanassesment', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(resul => {
                        $('div.modal-content-loading-approve').unblock();
                        if (resul.status !== 200) {
                            if (resul.status === 401) {
                                Swal.fire(
                                    'Failed!',
                                    resul.message,
                                    'warning'
                                ).then((valRes) => {
                                    reloadPage();
                                });
                            } else {
                                // e.disabled = false;
                                Swal.fire(
                                    'GAGAL!',
                                    resul.message,
                                    'warning'
                                );
                            }
                        } else {
                            // Swal.fire({
                            //     title: 'SELAMAT!',
                            //     text: resul.message,
                            //     icon: 'success',
                            //     showCancelButton: true,
                            //     confirmButtonColor: '#3085d6',
                            //     cancelButtonColor: '#d33',
                            //     cancelButtonText: 'Tutup',
                            //     confirmButtonText: 'Download'
                            // }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         downloadPDF(resul.filenya, resul.filename, resul.redirrect);
                            //         // setTimeout(function() {
                            //         //     reloadPage(resul.redirrect);
                            //         // }, 3000);
                            //     } else {
                            //         reloadPage(resul.redirrect);
                            //     }
                            // })
                            // Swal.fire(
                            //     'SELAMAT!',
                            //     resul.message,
                            //     'success'
                            // ).then((valRes) => {
                            //     reloadPage(resul.redirrect);
                            // })
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                        $('div.modal-content-loading-approve').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    });
            } else {
                console.log("tidak valid");
            }
        };
    </script>
<?php endif; ?>
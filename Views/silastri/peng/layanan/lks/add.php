<?= $this->extend('t-silastri/peng/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Buat Permohonan Izin LKS/LKSA</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="col-xl-12">
            <form id="formAddData" action="./addSave" method="post" enctype="multipart/form-data">
                <div class="card mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Permohonan Izin LKS / LKSA</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nama" name="_nama" value="<?= $data->fullname ?>" placeholder="Nama lengkap.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nik" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nik" name="_nik" value="<?= $data->nik ?>" placeholder="NIK.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kk" class="col-sm-3 col-form-label">KK</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_kk" name="_kk" value="<?= $data->kk ?>" placeholder="KK.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control nama" id="_tempat_lahir" name="_tempat_lahir" value="<?= $data->tempat_lahir ?>" placeholder="Tempat lahir.. " readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_tgl_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control nama" id="_tgl_lahir" name="_tgl_lahir" value="<?= $data->tgl_lahir ?>" readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control nama" id="_jenis_kelamin" name="_jenis_kelamin" value="<?= $data->jenis_kelamin === NULL || $data->jenis_kelamin === "" ? '-' : ($data->jenis_kelamin == "L" ? 'Laki-laki' : 'Perempuan') ?>" placeholder="Jenis kelamin.. " readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Data Lembaga</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_nama_lembaga" class="col-sm-3 col-form-label">Nama Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nama_lembaga" name="_nama_lembaga" placeholder="Nama lembaga.. " required />
                                        <div class="help-block _nama_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jenis_lembaga" class="col-sm-3 col-form-label">Jenis Lembaga :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 jenis_lembaga" id="_jenis_lembaga" name="_jenis_lembaga" style="width: 100%" required>
                                            <option value=""> --- Pilih Jenis Lembaga --- </option>
                                            <option value="LKS"> LKS </option>
                                            <option value="YAYASAN"> YAYASAN </option>
                                        </select>
                                        <div class="help-block _jenis_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_tgl_berdiri" class="col-sm-3 col-form-label">Tanggal Berdiri</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="_tgl_berdiri" name="_tgl_berdiri" required />
                                        <div class="help-block _tgl_berdiri"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nama_notaris" class="col-sm-3 col-form-label">Nama Notaris</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nama_notaris" name="_nama_notaris" placeholder="Nama notaris.. " required />
                                        <div class="help-block _nama_notaris"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_no_tanggal_notaris" class="col-sm-3 col-form-label">Nama Notaris</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_no_tanggal_notaris" name="_no_tanggal_notaris" placeholder="Contoh: 02/27-02/2000 " required />
                                        <div class="help-block _no_tanggal_notaris"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_no_pendaftaran_kemenkumham" class="col-sm-3 col-form-label">Nomor Pendaftaran / Pengesahan Kemenkumham</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_no_pendaftaran_kemenkumham" name="_no_pendaftaran_kemenkumham" placeholder="No pengesahan... " required />
                                        <div class="help-block _no_pendaftaran_kemenkumham"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_akreditasi_lembaga" class="col-sm-3 col-form-label">Akreditasi Lembaga :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 akreditasi_lembaga" id="_akreditasi_lembaga" name="_akreditasi_lembaga" style="width: 100%" required>
                                            <option value=""> --- Pilih Akreditasi Lembaga --- </option>
                                            <option value="A"> A </option>
                                            <option value="B"> B </option>
                                            <option value="C"> C </option>
                                            <option value="D"> D </option>
                                            <option value="Belum Terakreditasi"> Belum Terakreditasi </option>
                                        </select>
                                        <div class="help-block _akreditasi_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_no_surat_akreditasi" class="col-sm-3 col-form-label">Nomor Surat Akreditasi (Kosongkan Jika Belum Terakreditasi)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_no_surat_akreditasi" name="_no_surat_akreditasi" placeholder="No akreditasi... " />
                                        <div class="help-block _no_surat_akreditasi"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_tgl_habis_berlaku_akreditasi" class="col-sm-3 col-form-label">Tanggal Habis Masa Berlaku Akreditasi</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="_tgl_habis_berlaku_akreditasi" name="_tgl_habis_berlaku_akreditasi" />
                                        <div class="help-block _tgl_habis_berlaku_akreditasi"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nomor_wajib_pajak" class="col-sm-3 col-form-label">Nomor Pokok Wajib Pajak (NPWP)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nomor_wajib_pajak" name="_nomor_wajib_pajak" required />
                                        <div class="help-block _nomor_wajib_pajak"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_modal_usaha" class="col-sm-3 col-form-label">Modal Usaha (UEP) *tidak wajib</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="_modal_usaha" name="_modal_usaha" />
                                        <div class="help-block _modal_usaha"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_status_lembaga" class="col-sm-3 col-form-label">Status Lembaga :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 status_lembaga" id="_status_lembaga" name="_status_lembaga" style="width: 100%" required>
                                            <option value=""> --- Pilih Status Lembaga --- </option>
                                            <option value="PUSAT"> PUSAT </option>
                                            <option value="CABANG"> CABANG </option>
                                        </select>
                                        <div class="help-block _status_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_lingkup_wilayah_kerja" class="col-sm-3 col-form-label">Lingkup Wilayah Kerja :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 lingkup_wilayah_kerja" id="_lingkup_wilayah_kerja" name="_lingkup_wilayah_kerja" style="width: 100%" required>
                                            <option value=""> --- Pilih Lingkup Wilayah Kerja --- </option>
                                            <option value="KABUPATEN LAMPUNG TENGAH"> KABUPATEN LAMPUNG TENGAH </option>
                                        </select>
                                        <div class="help-block _lingkup_wilayah_kerja"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_bidang_kegiatan" class="col-sm-3 col-form-label">Bidang Kegiatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_bidang_kegiatan" name="_bidang_kegiatan" required />
                                        <div class="help-block _bidang_kegiatan"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_no_telp_lembaga" class="col-sm-3 col-form-label">No Telp Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="phone" class="form-control" id="_no_telp_lembaga" name="_no_telp_lembaga" required />
                                        <div class="help-block _no_telp_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_email_lembaga" class="col-sm-3 col-form-label">Email Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="_email_lembaga" name="_email_lembaga" required />
                                        <div class="help-block _email_lembaga"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_alamat_lembaga" class="col-sm-2 col-form-label">Alamat Lembaga</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" class="form-control" id="_alamat_lembaga" name="_alamat_lembaga" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label" for="_rt_lembaga">RT</label>
                                            <input class="form-control" id="_rt_lembaga" name="_rt_lembaga" type="text" placeholder="RT" required>
                                            <div class="help-block _rt_lembaga"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label" for="_rw_lembaga">RW</label>
                                            <input class="form-control" id="_rw_lembaga" name="_rw_lembaga" type="text" placeholder="RT" required>
                                            <div class="help-block _rw_lembaga"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kecamatan_lembaga" class="col-sm-3 col-form-label">Kecamatan (Lembaga) :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 kecamatan_lembaga" id="_kecamatan_lembaga" name="_kecamatan_lembaga" style="width: 100%" onchange="changeKecamatan(this)" required>
                                            <option value=""> --- Pilih Kecamatan --- </option>
                                            <?php if (isset($kecamatans)) { ?>
                                                <?php if (count($kecamatans) > 0) { ?>
                                                    <?php foreach ($kecamatans as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block _kecamatan_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2 select2-kelurahan-loading">
                                    <label for="_kelurahan_lembaga" class="col-sm-3 col-form-label">Kelurahan (Lembaga) :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 kelurahan_lembaga" id="_kelurahan_lembaga" name="_kelurahan_lembaga" style="width: 100%" required>
                                            <option value=""> --- Pilih Kecamatan Dulu --- </option>
                                        </select>
                                        <div class="help-block _kelurahan_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nama_ketua" class="col-sm-3 col-form-label">Nama Pengurus (Ketua)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nama_ketua" name="_nama_ketua" required />
                                        <div class="help-block _nama_ketua"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nik_ketua" class="col-sm-3 col-form-label">NIK Pengurus (Ketua)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nik_ketua" name="_nik_ketua" required />
                                        <div class="help-block _nik_ketua"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nohp_ketua" class="col-sm-3 col-form-label">Nomor HP Pengurus (Ketua)</label>
                                    <div class="col-sm-8">
                                        <input type="phone" class="form-control" id="_nohp_ketua" name="_nohp_ketua" required />
                                        <div class="help-block _nohp_ketua"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nama_sekretaris" class="col-sm-3 col-form-label">Nama Pengurus (Sekretaris)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nama_sekretaris" name="_nama_sekretaris" required />
                                        <div class="help-block _nama_sekretaris"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nik_sekretaris" class="col-sm-3 col-form-label">NIK Pengurus (Sekretaris)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nik_sekretaris" name="_nik_sekretaris" required />
                                        <div class="help-block _nik_sekretaris"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nohp_sekretaris" class="col-sm-3 col-form-label">Nomor HP Pengurus (Sekretaris)</label>
                                    <div class="col-sm-8">
                                        <input type="phone" class="form-control" id="_nohp_sekretaris" name="_nohp_sekretaris" required />
                                        <div class="help-block _nohp_sekretaris"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nama_bendahara" class="col-sm-3 col-form-label">Nama Pengurus (Bendahara)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nama_bendahara" name="_nama_bendahara" required />
                                        <div class="help-block _nama_bendahara"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nik_bendahara" class="col-sm-3 col-form-label">NIK Pengurus (Bendahara)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="_nik_bendahara" name="_nik_bendahara" required />
                                        <div class="help-block _nik_bendahara"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_nohp_bendahara" class="col-sm-3 col-form-label">Nomor HP Pengurus (Bendahara)</label>
                                    <div class="col-sm-8">
                                        <input type="phone" class="form-control" id="_nohp_bendahara" name="_nohp_bendahara" required />
                                        <div class="help-block _nohp_bendahara"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jumlah_pengurus" class="col-sm-3 col-form-label">Jumlah Pengurus</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="_jumlah_pengurus" name="_jumlah_pengurus" required />
                                        <div class="help-block _jumlah_pengurus"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jumlah_binaan_dalam_lembaga" class="col-sm-3 col-form-label">Jumlah Binaan Dalam Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="_jumlah_binaan_dalam_lembaga" name="_jumlah_binaan_dalam_lembaga" required />
                                        <div class="help-block _jumlah_binaan_dalam_lembaga"></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_jumlah_binaan_luar_lembaga" class="col-sm-3 col-form-label">Jumlah Binaan Luar Lembaga</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="_jumlah_binaan_luar_lembaga" name="_jumlah_binaan_luar_lembaga" required />
                                        <div class="help-block _jumlah_binaan_luar_lembaga"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group _koordinat-block">
                                    <label for="_koordinat" class="form-control-label">Koordinat Tempat Tinggal</label>
                                    <div class="input-group input-group-merge">
                                        <input type="hidden" name="_latitude" id="_latitude">
                                        <input type="hidden" name="_longitude" id="_longitude">
                                        <input type="text" class="form-control koordinat" style="padding-left: 15px;" name="_koordinat" id="_koordinat" onFocus="inputFocus(this);" readonly>
                                        <div class="input-group-append action-location" onmouseover="actionMouseHoverLocation(this)" onmouseout="actionMouseOutHoverLocation(this)" onclick="pickCoordinat()">
                                            <span class="input-group-text action-location-icon" style="background-color: transparent;"><i class="fas fa-map-marker"></i></span>
                                        </div>
                                    </div>

                                    <div class="help-block _koordinat"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Lampiran Dokumen Permohonan</h4>
                                <p style="margin-bottom: 30px;">Silahkan lampirkan dokumen permohonan (KTP Pengurus, Akta Notaris, Pengesahan Kemenkumham, ADRT, Keterangan Domisili, Akreditasi, Struktur Organisasi, NPWP, Foto Lokasi Tampak Depan, Foto Usaha Ekonomi Produktif, Logo Lembaga, dan File Binaan).</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_ktp_ketua" class="form-label">Lampiran KTP Pengurus (Ketua) : </label>
                                            <input class="form-control" type="file" id="_file_ktp_ketua" name="_file_ktp_ketua" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_ktp_ketua', 'KTP Ketua')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_ktp_ketua" for="_file_ktp_ketua"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_ktp_sekretaris" class="form-label">Lampiran KTP Pengurus (Sekretaris) : </label>
                                            <input class="form-control" type="file" id="_file_ktp_sekretaris" name="_file_ktp_sekretaris" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_ktp_sekretaris', 'KTP Sekretaris')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_ktp_sekretaris" for="_file_ktp_sekretaris"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_ktp_bendahara" class="form-label">Lampiran KTP Pengurus (Bendahara) : </label>
                                            <input class="form-control" type="file" id="_file_ktp_bendahara" name="_file_ktp_bendahara" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_ktp_bendahara', 'KTP Bendahara')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_ktp_bendahara" for="_file_ktp_bendahara"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_akta_notaris" class="form-label">Lampiran Akta Notaris : </label>
                                            <input class="form-control" type="file" id="_file_akta_notaris" name="_file_akta_notaris" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_akta_notaris', 'Akta Notaris')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_akta_notaris" for="_file_akta_notaris"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_pengesahan_kemenkumham" class="form-label">Lampiran Pengesahan Kemenkumham : </label>
                                            <input class="form-control" type="file" id="_file_pengesahan_kemenkumham" name="_file_pengesahan_kemenkumham" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_pengesahan_kemenkumham', 'Pengesahan Kemenkumham')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_pengesahan_kemenkumham" for="_file_pengesahan_kemenkumham"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_adrt" class="form-label">Lampiran ADRT : </label>
                                            <input class="form-control" type="file" id="_file_adrt" name="_file_adrt" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_adrt', 'ADRT')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_adrt" for="_file_adrt"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_keterangan_domisili" class="form-label">Lampiran Keterangan Domisili : </label>
                                            <input class="form-control" type="file" id="_file_keterangan_domisili" name="_file_keterangan_domisili" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_keterangan_domisili', 'Keterangan Domisili')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_keterangan_domisili" for="_file_keterangan_domisili"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_akreditasi" class="form-label">Lampiran Akreditasi : </label>
                                            <input class="form-control" type="file" id="_file_akreditasi" name="_file_akreditasi" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_akreditasi', 'Akreditasi')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb (Jika Ada)</code></p>
                                            <div class="help-block _file_akreditasi" for="_file_akreditasi"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_struktur_organisasi" class="form-label">Lampiran Struktur Organisasi : </label>
                                            <input class="form-control" type="file" id="_file_struktur_organisasi" name="_file_struktur_organisasi" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_struktur_organisasi', 'Struktur Organisasi')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_struktur_organisasi" for="_file_struktur_organisasi"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_npwp" class="form-label">Lampiran NPWP : </label>
                                            <input class="form-control" type="file" id="_file_npwp" name="_file_npwp" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_npwp', 'NPWP')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_npwp" for="_file_npwp"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_foto_lokasi" class="form-label">Lampiran Foto Lokasi : </label>
                                            <input class="form-control" type="file" id="_file_foto_lokasi" name="_file_foto_lokasi" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_foto_lokasi', 'Foto Lokasi')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_foto_lokasi" for="_file_foto_lokasi"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_foto_usaha_ekonomi_produktif" class="form-label">Lampiran Foto Usaha Ekonomi Produktif (UEP) : </label>
                                            <input class="form-control" type="file" id="_file_foto_usaha_ekonomi_produktif" name="_file_foto_usaha_ekonomi_produktif" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_foto_usaha_ekonomi_produktif', 'Foto Usaha Ekonomi Produktif')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb (Jika Ada)</code></p>
                                            <div class="help-block _file_foto_usaha_ekonomi_produktif" for="_file_foto_usaha_ekonomi_produktif"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-3">
                                            <label for="_file_logo_lembaga" class="form-label">Lampiran Logo Lembaga : </label>
                                            <input class="form-control" type="file" id="_file_logo_lembaga" name="_file_logo_lembaga" onFocus="inputFocus(this);" accept="image/*,application/pdf" onchange="loadFile('_file_logo_lembaga', 'Logo Lembaga')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="jpg, png, jpeg, pdf">Files</code> and Maximum File Size <code>2 Mb (Jika Ada)</code></p>
                                            <div class="help-block _file_logo_lembaga" for="_file_logo_lembaga"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-3">
                                            <label for="_file_data_binaan" class="form-label">Lampiran Data Binaan : </label>
                                            <p class="font-size-11">&nbsp;&nbsp;Template data binaan dapat di download pada : <a class="menu-badge badge-info" href="#">Link Berikut...</a></p>
                                            <input class="form-control" type="file" id="_file_data_binaan" name="_file_data_binaan" onFocus="inputFocus(this);" accept=".xls, .xlsx" onchange="loadFileExcel('_file_data_binaan', 'Data Binaan')">
                                            <p class="font-size-11">Format : <code data-toggle="tooltip" data-placement="bottom" title="xls, xlsx">Files</code> and Maximum File Size <code>2 Mb</code></p>
                                            <div class="help-block _file_data_binaan" for="_file_data_binaan"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 justify-content-end">
                                <button type="submit" id="save_button" name="save_button" class="btn btn-primary w-md save_button">KIRIM</button>
                            </div>
                            <div class="col-lg-9">
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="content-aktivasiModal" class="modal fade content-aktivasiModal" tabindex="-1" role="dialog" aria-labelledby="content-aktivasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-aktivasi-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-aktivasiModalLabel">TAUTKAN INFO GTK DIGITAL ANDA</h5>
            </div>
            <div class="contentAktivasiBodyModal">
            </div>
        </div>
    </div>
</div>
<div id="content-detailModal" class="modal fade content-detailModal" tabindex="-1" role="dialog" aria-labelledby="content-detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-content-loading">
            <div class="modal-header">
                <h5 class="modal-title" id="content-detailModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="contentBodyModal">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scriptBottom'); ?>
<script src="<?= base_url() ?>/assets/libs/select2/js/select2.min.js"></script>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?key=AIzaSyChdWD-7HQXG7sI1tqbQ43WJuMx7TJ7uuY&sensor=false&libraries=places'></script>
<script src="<?= base_url('assets'); ?>/js/locationpicker.jquery.min.js"></script>
<script>
    initSelect2("_kecamatan_lembaga", ".page-content");
    initSelect2("_kelurahan_lembaga", ".page-content");

    $("#formAddData").on("submit", function(e) {
        e.preventDefault();
        // const indikator1 = $("input[type='radio'][name='_indikator_1']:checked").val();
        // const indikator2 = $("input[type='radio'][name='_indikator_2']:checked").val();
        // const indikator3 = $("input[type='radio'][name='_indikator_3']:checked").val();
        // const indikator4 = $("input[type='radio'][name='_indikator_4']:checked").val();
        // const indikator5 = $("input[type='radio'][name='_indikator_5']:checked").val();
        // const indikator6 = $("input[type='radio'][name='_indikator_6']:checked").val();

        const nama = document.getElementsByName('_nama')[0].value;
        const nik = document.getElementsByName('_nik')[0].value;
        const kk = document.getElementsByName('_kk')[0].value;
        const nama_lembaga = document.getElementsByName('_nama_lembaga')[0].value;
        const jenis_lembaga = document.getElementsByName('_jenis_lembaga')[0].value;
        const tgl_berdiri = document.getElementsByName('_tgl_berdiri')[0].value;
        const nama_notaris = document.getElementsByName('_nama_notaris')[0].value;
        const no_tanggal_notaris = document.getElementsByName('_no_tanggal_notaris')[0].value;
        const no_pendaftaran_kemenkumham = document.getElementsByName('_no_pendaftaran_kemenkumham')[0].value;
        const akreditasi_lembaga = document.getElementsByName('_akreditasi_lembaga')[0].value;
        const no_surat_akreditasi = document.getElementsByName('_no_surat_akreditasi')[0].value;
        const tgl_habis_berlaku_akreditasi = document.getElementsByName('_tgl_habis_berlaku_akreditasi')[0].value;
        const nomor_wajib_pajak = document.getElementsByName('_nomor_wajib_pajak')[0].value;
        const modal_usaha = document.getElementsByName('_modal_usaha')[0].value;
        const status_lembaga = document.getElementsByName('_status_lembaga')[0].value;
        const lingkup_wilayah_kerja = document.getElementsByName('_lingkup_wilayah_kerja')[0].value;
        const bidang_kegiatan = document.getElementsByName('_bidang_kegiatan')[0].value;
        const no_telp_lembaga = document.getElementsByName('_no_telp_lembaga')[0].value;
        const email_lembaga = document.getElementsByName('_email_lembaga')[0].value;
        const alamat_lembaga = document.getElementsByName('_alamat_lembaga')[0].value;
        const rt_lembaga = document.getElementsByName('_rt_lembaga')[0].value;
        const rw_lembaga = document.getElementsByName('_rw_lembaga')[0].value;
        const kecamatan_lembaga = document.getElementsByName('_kecamatan_lembaga')[0].value;
        const kelurahan_lembaga = document.getElementsByName('_kelurahan_lembaga')[0].value;
        const nama_ketua = document.getElementsByName('_nama_ketua')[0].value;
        const nik_ketua = document.getElementsByName('_nik_ketua')[0].value;
        const nohp_ketua = document.getElementsByName('_nohp_ketua')[0].value;
        const nama_sekretaris = document.getElementsByName('_nama_sekretaris')[0].value;
        const nik_sekretaris = document.getElementsByName('_nik_sekretaris')[0].value;
        const nohp_sekretaris = document.getElementsByName('_nohp_sekretaris')[0].value;
        const nama_bendahara = document.getElementsByName('_nama_bendahara')[0].value;
        const nik_bendahara = document.getElementsByName('_nik_bendahara')[0].value;
        const nohp_bendahara = document.getElementsByName('_nohp_bendahara')[0].value;
        const jumlah_pengurus = document.getElementsByName('_jumlah_pengurus')[0].value;
        const jumlah_binaan_dalam_lembaga = document.getElementsByName('_jumlah_binaan_dalam_lembaga')[0].value;
        const jumlah_binaan_luar_lembaga = document.getElementsByName('_jumlah_binaan_luar_lembaga')[0].value;
        const koordinat = document.getElementsByName('_koordinat')[0].value;
        // const keterangan = document.getElementsByName('_jenis_detail')[0].value;

        const fileKtpKetua = document.getElementsByName('_file_ktp_ketua')[0].value;
        const fileKtpSekretaris = document.getElementsByName('_file_ktp_sekretaris')[0].value;
        const fileKtpBendahara = document.getElementsByName('_file_ktp_bendahara')[0].value;
        const fileAktaNotaris = document.getElementsByName('_file_akta_notaris')[0].value;
        const filePengesahanKemenkumham = document.getElementsByName('_file_pengesahan_kemenkumham')[0].value;
        const fileAdrt = document.getElementsByName('_file_adrt')[0].value;
        const fileKeteranganDomisili = document.getElementsByName('_file_keterangan_domisili')[0].value;
        const fileAkreditasi = document.getElementsByName('_file_akreditasi')[0].value;
        const fileStrukturOrganisasi = document.getElementsByName('_file_struktur_organisasi')[0].value;
        const fileNpwp = document.getElementsByName('_file_npwp')[0].value;
        const fileFotoLokasi = document.getElementsByName('_file_foto_lokasi')[0].value;
        const fileFotoUsahaEkonomiProduktif = document.getElementsByName('_file_foto_usaha_ekonomi_produktif')[0].value;
        const fileLogoLembaga = document.getElementsByName('_file_logo_lembaga')[0].value;
        const fileDataBinaan = document.getElementsByName('_file_data_binaan')[0].value;

        if (nama_lembaga === "" || nama_lembaga === undefined) {
            $("input#_nama_lembaga").css("color", "#dc3545");
            $("input#_nama_lembaga").css("border-color", "#dc3545");
            $('._nama_lembaga').html('Masukkan Nama Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nama lembaga.",
                'warning'
            );
            return false;
        }

        if (jenis_lembaga === "") {
            $("select#_jenis_lembaga").css("color", "#dc3545");
            $("select#_jenis_lembaga").css("border-color", "#dc3545");
            $('._jenis_lembaga').html('Silahkan pilih jenis Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih jenis Lembaga.",
                'warning'
            );
            return false;
        }

        if (tgl_berdiri === "" || tgl_berdiri === undefined) {
            $("input#_tgl_berdiri").css("color", "#dc3545");
            $("input#_tgl_berdiri").css("border-color", "#dc3545");
            $('._tgl_berdiri').html('Masukkan Tanggal Berdiri Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan tanggal berdiri lembaga.",
                'warning'
            );
            return false;
        }

        if (nama_notaris === "" || nama_notaris === undefined) {
            $("input#_nama_notaris").css("color", "#dc3545");
            $("input#_nama_notaris").css("border-color", "#dc3545");
            $('._nama_notaris').html('Masukkan nama notaris');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nama notaris.",
                'warning'
            );
            return false;
        }

        if (no_pendaftaran_kemenkumham === "" || no_pendaftaran_kemenkumham === undefined) {
            $("input#_no_pendaftaran_kemenkumham").css("color", "#dc3545");
            $("input#_no_pendaftaran_kemenkumham").css("border-color", "#dc3545");
            $('._no_pendaftaran_kemenkumham').html('Masukkan no pendaftaran kemenkumham');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no pendaftaran kemenkumham.",
                'warning'
            );
            return false;
        }

        if (akreditasi_lembaga === "") {
            $("select#_akreditasi_lembaga").css("color", "#dc3545");
            $("select#_akreditasi_lembaga").css("border-color", "#dc3545");
            $('._akreditasi_lembaga').html('Silahkan pilih akreditasi Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih akreditasi Lembaga.",
                'warning'
            );
            return false;
        }

        if (no_surat_akreditasi === "" || no_surat_akreditasi === undefined) {
            $("input#_no_surat_akreditasi").css("color", "#dc3545");
            $("input#_no_surat_akreditasi").css("border-color", "#dc3545");
            $('._no_surat_akreditasi').html('Masukkan no surat akreditasi');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no surat akreditasi.",
                'warning'
            );
            return false;
        }

        if (tgl_habis_berlaku_akreditasi === "" || tgl_habis_berlaku_akreditasi === undefined) {
            $("input#_tgl_habis_berlaku_akreditasi").css("color", "#dc3545");
            $("input#_tgl_habis_berlaku_akreditasi").css("border-color", "#dc3545");
            $('._tgl_habis_berlaku_akreditasi').html('Masukkan tanggal habis masa berlaku akreditasi');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan tanggal habis masa berlaku akreditasi.",
                'warning'
            );
            return false;
        }

        if (nomor_wajib_pajak === "" || nomor_wajib_pajak === undefined) {
            $("input#_nomor_wajib_pajak").css("color", "#dc3545");
            $("input#_nomor_wajib_pajak").css("border-color", "#dc3545");
            $('._nomor_wajib_pajak').html('Masukkan npwp lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan npwp lembaga.",
                'warning'
            );
            return false;
        }

        // if (modal_usaha === "" || modal_usaha === undefined) {
        //     $("input#_modal_usaha").css("color", "#dc3545");
        //     $("input#_modal_usaha").css("border-color", "#dc3545");
        //     $('._modal_usaha').html('Masukkan modah usaha (UEP) lembaga');

        //     Swal.fire(
        //         'Peringatan..!!',
        //         "Silahkan masukkan modah usaha (UEP) lembaga.",
        //         'warning'
        //     );
        //     return false;
        // }

        if (status_lembaga === "") {
            $("select#_status_lembaga").css("color", "#dc3545");
            $("select#_status_lembaga").css("border-color", "#dc3545");
            $('._status_lembaga').html('Silahkan pilih status Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih status Lembaga.",
                'warning'
            );
            return false;
        }

        if (lingkup_wilayah_kerja === "") {
            $("select#_lingkup_wilayah_kerja").css("color", "#dc3545");
            $("select#_lingkup_wilayah_kerja").css("border-color", "#dc3545");
            $('._lingkup_wilayah_kerja').html('Silahkan pilih lingkup wilayah kerja Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih lingkup wilayah kerja Lembaga.",
                'warning'
            );
            return false;
        }

        if (bidang_kegiatan === "" || bidang_kegiatan === undefined) {
            $("input#_bidang_kegiatan").css("color", "#dc3545");
            $("input#_bidang_kegiatan").css("border-color", "#dc3545");
            $('._bidang_kegiatan').html('Masukkan bidang kegiatan lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan bidang kegiatan lembaga.",
                'warning'
            );
            return false;
        }

        if (no_telp_lembaga === "" || no_telp_lembaga === undefined) {
            $("input#_no_telp_lembaga").css("color", "#dc3545");
            $("input#_no_telp_lembaga").css("border-color", "#dc3545");
            $('._no_telp_lembaga').html('Masukkan no telp lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no telp lembaga.",
                'warning'
            );
            return false;
        }

        if (email_lembaga === "" || email_lembaga === undefined) {
            $("input#_email_lembaga").css("color", "#dc3545");
            $("input#_email_lembaga").css("border-color", "#dc3545");
            $('._email_lembaga').html('Masukkan email lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan email lembaga.",
                'warning'
            );
            return false;
        }

        if (alamat_lembaga === "" || alamat_lembaga === undefined) {
            $("textarea#_alamat_lembaga").css("color", "#dc3545");
            $("textarea#_alamat_lembaga").css("border-color", "#dc3545");
            $('._alamat_lembaga').html('Masukkan alamat lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan alamat lembaga.",
                'warning'
            );
            return false;
        }

        if (rt_lembaga === "" || rt_lembaga === undefined) {
            $("input#_rt_lembaga").css("color", "#dc3545");
            $("input#_rt_lembaga").css("border-color", "#dc3545");
            $('._rt_lembaga').html('Masukkan alamat RT lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan alamat RT lembaga.",
                'warning'
            );
            return false;
        }

        if (rw_lembaga === "" || rw_lembaga === undefined) {
            $("input#_rw_lembaga").css("color", "#dc3545");
            $("input#_rw_lembaga").css("border-color", "#dc3545");
            $('._rw_lembaga').html('Masukkan alamat RW lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan alamat RW lembaga.",
                'warning'
            );
            return false;
        }

        if (kecamatan_lembaga === "") {
            $("select#_kecamatan_lembaga").css("color", "#dc3545");
            $("select#_kecamatan_lembaga").css("border-color", "#dc3545");
            $('._kecamatan_lembaga').html('Silahkan pilih alamat kecamatan Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih alamat kecamatan Lembaga.",
                'warning'
            );
            return false;
        }

        if (kelurahan_lembaga === "") {
            $("select#_kelurahan_lembaga").css("color", "#dc3545");
            $("select#_kelurahan_lembaga").css("border-color", "#dc3545");
            $('._kelurahan_lembaga').html('Silahkan pilih alamat kelurahan Lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih alamat kelurahan Lembaga.",
                'warning'
            );
            return false;
        }

        if (nama_ketua === "" || nama_ketua === undefined) {
            $("input#_nama_ketua").css("color", "#dc3545");
            $("input#_nama_ketua").css("border-color", "#dc3545");
            $('._nama_ketua').html('Masukkan nama ketua lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nama ketua lembaga.",
                'warning'
            );
            return false;
        }

        if (nik_ketua === "" || nik_ketua === undefined) {
            $("input#_nik_ketua").css("color", "#dc3545");
            $("input#_nik_ketua").css("border-color", "#dc3545");
            $('._nik_ketua').html('Masukkan nik ketua lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nik ketua lembaga.",
                'warning'
            );
            return false;
        }

        if (nohp_ketua === "" || nohp_ketua === undefined) {
            $("input#_nohp_ketua").css("color", "#dc3545");
            $("input#_nohp_ketua").css("border-color", "#dc3545");
            $('._nohp_ketua').html('Masukkan no handphone ketua lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no handphone ketua lembaga.",
                'warning'
            );
            return false;
        }

        if (nama_sekretaris === "" || nama_sekretaris === undefined) {
            $("input#_nama_sekretaris").css("color", "#dc3545");
            $("input#_nama_sekretaris").css("border-color", "#dc3545");
            $('._nama_sekretaris').html('Masukkan nama sekretaris lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nama sekretaris lembaga.",
                'warning'
            );
            return false;
        }

        if (nik_sekretaris === "" || nik_sekretaris === undefined) {
            $("input#_nik_sekretaris").css("color", "#dc3545");
            $("input#_nik_sekretaris").css("border-color", "#dc3545");
            $('._nik_sekretaris').html('Masukkan nik sekretaris lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nik sekretaris lembaga.",
                'warning'
            );
            return false;
        }

        if (nohp_sekretaris === "" || nohp_sekretaris === undefined) {
            $("input#_nohp_sekretaris").css("color", "#dc3545");
            $("input#_nohp_sekretaris").css("border-color", "#dc3545");
            $('._nohp_sekretaris').html('Masukkan no handphone sekretaris lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no handphone sekretaris lembaga.",
                'warning'
            );
            return false;
        }

        if (nama_bendahara === "" || nama_bendahara === undefined) {
            $("input#_nama_bendahara").css("color", "#dc3545");
            $("input#_nama_bendahara").css("border-color", "#dc3545");
            $('._nama_bendahara').html('Masukkan nama bendahara lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nama bendahara lembaga.",
                'warning'
            );
            return false;
        }

        if (nik_bendahara === "" || nik_bendahara === undefined) {
            $("input#_nik_bendahara").css("color", "#dc3545");
            $("input#_nik_bendahara").css("border-color", "#dc3545");
            $('._nik_bendahara').html('Masukkan nik bendahara lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan nik bendahara lembaga.",
                'warning'
            );
            return false;
        }

        if (nohp_bendahara === "" || nohp_bendahara === undefined) {
            $("input#_nohp_bendahara").css("color", "#dc3545");
            $("input#_nohp_bendahara").css("border-color", "#dc3545");
            $('._nohp_bendahara').html('Masukkan no handphone bendahara lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan no handphone bendahara lembaga.",
                'warning'
            );
            return false;
        }

        if (jumlah_pengurus === "" || jumlah_pengurus === undefined) {
            $("input#_jumlah_pengurus").css("color", "#dc3545");
            $("input#_jumlah_pengurus").css("border-color", "#dc3545");
            $('._jumlah_pengurus').html('Masukkan jumlah pengurus lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan jumlah pengurus lembaga.",
                'warning'
            );
            return false;
        }

        if (jumlah_binaan_dalam_lembaga === "" || jumlah_binaan_dalam_lembaga === undefined) {
            $("input#_jumlah_binaan_dalam_lembaga").css("color", "#dc3545");
            $("input#_jumlah_binaan_dalam_lembaga").css("border-color", "#dc3545");
            $('._jumlah_binaan_dalam_lembaga').html('Masukkan jumlah binaan dalam lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan jumlah binaan dalam lembaga.",
                'warning'
            );
            return false;
        }

        if (jumlah_binaan_luar_lembaga === "" || jumlah_binaan_luar_lembaga === undefined) {
            $("input#_jumlah_binaan_luar_lembaga").css("color", "#dc3545");
            $("input#_jumlah_binaan_luar_lembaga").css("border-color", "#dc3545");
            $('._jumlah_binaan_luar_lembaga').html('Masukkan jumlah binaan luar lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan jumlah binaan luar lembaga.",
                'warning'
            );
            return false;
        }

        if (koordinat === "" || koordinat === undefined) {
            $("input#_koordinat").css("color", "#dc3545");
            $("input#_koordinat").css("border-color", "#dc3545");
            $('._koordinat').html('Masukkan koordinat domisili lembaga');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan masukkan koordinat domisili lembaga.",
                'warning'
            );
            return false;
        }

        if (fileKtpKetua === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen KTP Ketua.",
                'warning'
            );
            return;
        }

        if (fileKtpSekretaris === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen KTP Sekretaris.",
                'warning'
            );
            return;
        }

        if (fileKtpBendahara === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen KTP Bendahara.",
                'warning'
            );
            return;
        }

        if (fileAktaNotaris === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Akta Notaris.",
                'warning'
            );
            return;
        }

        if (filePengesahanKemenkumham === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Pengesahan Kemenkumham.",
                'warning'
            );
            return;
        }

        if (fileAdrt === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen ADRT.",
                'warning'
            );
            return;
        }

        if (fileKeteranganDomisili === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Keterangan Domisili.",
                'warning'
            );
            return;
        }

        if (fileAkreditasi === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Akreditasi.",
                'warning'
            );
            return;
        }

        if (fileStrukturOrganisasi === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Struktur Organisasi.",
                'warning'
            );
            return;
        }

        if (fileNpwp === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen NPWP Lembaga.",
                'warning'
            );
            return;
        }

        if (fileFotoLokasi === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Foto Lokasi.",
                'warning'
            );
            return;
        }

        if (fileFotoUsahaEkonomiProduktif === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Foto Usaha Ekonomi Produktif (UEP).",
                'warning'
            );
            return;
        }

        if (fileLogoLembaga === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Logo Lembaga.",
                'warning'
            );
            return;
        }

        if (fileDataBinaan === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan data binaan.",
                'warning'
            );
            return;
        }

        const formUpload = new FormData();

        const file_ktp_ketua = document.getElementsByName('_file_ktp_ketua')[0].files[0];
        formUpload.append('_file_ktp_ketua', file_ktp_ketua);
        const file_ktp_sekretaris = document.getElementsByName('_file_ktp_sekretaris')[0].files[0];
        formUpload.append('_file_ktp_sekretaris', file_ktp_sekretaris);
        const file_ktp_bendahara = document.getElementsByName('_file_ktp_bendahara')[0].files[0];
        formUpload.append('_file_ktp_bendahara', file_ktp_bendahara);
        const file_akta_notaris = document.getElementsByName('_file_akta_notaris')[0].files[0];
        formUpload.append('_file_akta_notaris', file_akta_notaris);
        const file_pengesahan_kemenkumham = document.getElementsByName('_file_pengesahan_kemenkumham')[0].files[0];
        formUpload.append('_file_pengesahan_kemenkumham', file_pengesahan_kemenkumham);
        const file_adrt = document.getElementsByName('_file_adrt')[0].files[0];
        formUpload.append('_file_adrt', file_adrt);
        const file_keterangan_domisili = document.getElementsByName('_file_keterangan_domisili')[0].files[0];
        formUpload.append('_file_keterangan_domisili', file_keterangan_domisili);
        const file_akreditasi = document.getElementsByName('_file_akreditasi')[0].files[0];
        formUpload.append('_file_akreditasi', file_akreditasi);
        const file_struktur_organisasi = document.getElementsByName('_file_struktur_organisasi')[0].files[0];
        formUpload.append('_file_struktur_organisasi', file_struktur_organisasi);
        const file_npwp = document.getElementsByName('_file_npwp')[0].files[0];
        formUpload.append('_file_npwp', file_npwp);
        const file_foto_lokasi = document.getElementsByName('_file_foto_lokasi')[0].files[0];
        formUpload.append('_file_foto_lokasi', file_foto_lokasi);
        const file_foto_usaha_ekonomi_produktif = document.getElementsByName('_file_foto_usaha_ekonomi_produktif')[0].files[0];
        formUpload.append('_file_foto_usaha_ekonomi_produktif', file_foto_usaha_ekonomi_produktif);
        const file_logo_lembaga = document.getElementsByName('_file_logo_lembaga')[0].files[0];
        formUpload.append('_file_logo_lembaga', file_logo_lembaga);
        const file_data_binaan = document.getElementsByName('_file_data_binaan')[0].files[0];
        formUpload.append('_file_data_binaan', file_data_binaan);

        formUpload.append('nama', nama);
        formUpload.append('nik', nik);
        formUpload.append('kk', kk);
        formUpload.append('nama_lembaga', nama_lembaga);
        formUpload.append('jenis_lembaga', jenis_lembaga);
        formUpload.append('tgl_berdiri', tgl_berdiri);
        formUpload.append('nama_notaris', nama_notaris);
        formUpload.append('no_tanggal_notaris', no_tanggal_notaris);
        formUpload.append('no_pendaftaran_kemenkumham', no_pendaftaran_kemenkumham);
        formUpload.append('akreditasi_lembaga', akreditasi_lembaga);
        formUpload.append('no_surat_akreditasi', no_surat_akreditasi);
        formUpload.append('tgl_habis_berlaku_akreditasi', tgl_habis_berlaku_akreditasi);
        formUpload.append('nomor_wajib_pajak', nomor_wajib_pajak);
        formUpload.append('modal_usaha', modal_usaha);
        formUpload.append('status_lembaga', status_lembaga);
        formUpload.append('lingkup_wilayah_kerja', lingkup_wilayah_kerja);
        formUpload.append('bidang_kegiatan', bidang_kegiatan);
        formUpload.append('no_telp_lembaga', no_telp_lembaga);
        formUpload.append('email_lembaga', email_lembaga);
        formUpload.append('alamat_lembaga', alamat_lembaga);
        formUpload.append('rt_lembaga', rt_lembaga);
        formUpload.append('rw_lembaga', rw_lembaga);
        formUpload.append('kecamatan_lembaga', kecamatan_lembaga);
        formUpload.append('kelurahan_lembaga', kelurahan_lembaga);
        formUpload.append('nama_ketua', nama_ketua);
        formUpload.append('nik_ketua', nik_ketua);
        formUpload.append('nohp_ketua', nohp_ketua);
        formUpload.append('nama_sekretaris', nama_sekretaris);
        formUpload.append('nik_sekretaris', nik_sekretaris);
        formUpload.append('nohp_sekretaris', nohp_sekretaris);
        formUpload.append('nama_bendahara', nama_bendahara);
        formUpload.append('nik_bendahara', nik_bendahara);
        formUpload.append('nohp_bendahara', nohp_bendahara);
        formUpload.append('jumlah_pengurus', jumlah_pengurus);
        formUpload.append('jumlah_binaan_dalam_lembaga', jumlah_binaan_dalam_lembaga);
        formUpload.append('jumlah_binaan_luar_lembaga', jumlah_binaan_luar_lembaga);
        formUpload.append('koordinat', koordinat);

        Swal.fire({
            title: 'Apakah anda yakin ingin mengajukan permohonan data ini?',
            text: "Ajukan permohonan : LKSA",
            showCancelButton: true,
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    xhr: function() {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                ambilId("loaded_n_total").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                                var percent = (evt.loaded / evt.total) * 100;
                                ambilId("progressBar").value = Math.round(percent);
                                // ambilId("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                            }
                        }, false);
                        return xhr;
                    },
                    url: "./addSave",
                    type: 'POST',
                    data: formUpload,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        ambilId("progressBar").style.display = "block";
                        // ambilId("status").innerHTML = "Mulai mengupload . . .";
                        ambilId("status").style.color = "blue";
                        ambilId("progressBar").value = 0;
                        ambilId("loaded_n_total").innerHTML = "";
                        $('div.page-content').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.page-content').unblock();

                        if (resul.status !== 200) {
                            // ambilId("status").innerHTML = "gagal";
                            ambilId("status").style.color = "red";
                            ambilId("progressBar").value = 0;
                            ambilId("loaded_n_total").innerHTML = "";
                            if (resul.status !== 201) {
                                if (resul.status === 401) {
                                    Swal.fire(
                                        'Failed!',
                                        resul.message,
                                        'warning'
                                    ).then((valRes) => {
                                        reloadPage();
                                    });
                                } else {
                                    Swal.fire(
                                        'GAGAL!',
                                        resul.message,
                                        'warning'
                                    );
                                }
                            } else {
                                Swal.fire(
                                    'Peringatan!',
                                    resul.message,
                                    'success'
                                ).then((valRes) => {
                                    reloadPage();
                                })
                            }
                        } else {
                            // ambilId("status").innerHTML = resul.message;
                            ambilId("status").style.color = "green";
                            ambilId("progressBar").value = 100;
                            Swal.fire(
                                'SELAMAT!',
                                resul.message,
                                'success'
                            ).then((valRes) => {
                                reloadPage(resul.redirect);
                            })
                        }
                    },
                    error: function(erro) {
                        console.log(erro);
                        // ambilId("status").innerHTML = "Upload Failed";
                        ambilId("status").style.color = "red";
                        $('div.page-content').unblock();
                        Swal.fire(
                            'PERINGATAN!',
                            "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                            'warning'
                        );
                    }
                });
            }
        });

    });

    function changeJenis(event) {
        const color = $(event).attr('name');
        $(event).removeAttr('style');
        $('.' + color).html('');

        if (event.value === "Lainnya") {
            document.getElementById("_jenis_detail").style.display = "block";
        } else {
            document.getElementById("_jenis_detail").style.display = "none";
        }
    }

    function actionMouseHoverLocation(event) {
        event.style.color = '#fff';
        event.style.background = '#0A48B3';
        $('.action-location-icon').css('color', '#fff');
    }

    function actionMouseOutHoverLocation(event) {
        event.style.color = '#adb5bd';
        event.style.background = '#fff';
        $('.action-location-icon').css('color', '#adb5bd');
    }

    function pickCoordinat() {
        const lat = document.getElementsByName('_latitude')[0].value;
        const long = document.getElementsByName('_longitude')[0].value;

        $.ajax({
            url: "./location",
            type: 'POST',
            data: {
                lat: lat,
                long: long,
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('div.page-content').block({
                    message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                });
            },
            success: function(resul) {
                $('div.page-content').unblock();

                if (resul.status !== 200) {
                    Swal.fire(
                        'Failed!',
                        resul.message,
                        'warning'
                    );
                } else {
                    $('#content-detailModalLabel').html('AMBIL LOKASI');
                    $('.contentBodyModal').html(resul.data);
                    $('.content-detailModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('.content-detailModal').modal('show');

                    var map = L.map("map_inits").setView([lat, long], 12);
                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors | Supported By <a href="https://kntechline.id">Kntechline.id</a>'
                    }).addTo(map);

                    var lati = lat;
                    var longi = long;
                    var marker;

                    marker = L.marker({
                        lat: lat,
                        lng: long
                    }, {
                        draggable: true
                    }).addTo(map);
                    document.getElementById('_lat').value = lati;
                    document.getElementById('_long').value = longi;

                    var onDrag = function(e) {
                        var latlng = marker.getLatLng();
                        lati = latlng.lat;
                        longi = latlng.lng;
                        document.getElementById('_lat').value = latlng.lat;
                        document.getElementById('_long').value = latlng.lng;
                    };

                    var onClick = function(e) {
                        map.removeLayer(marker);
                        // map.off('click', onClick); //turn off listener for map click
                        marker = L.marker(e.latlng, {
                            draggable: true
                        }).addTo(map);
                        lati = e.latlng.lat;
                        longi = e.latlng.lng;
                        document.getElementById('_lat').value = lati;
                        document.getElementById('_long').value = longi;

                        // marker.on('drag', onDrag);
                    };
                    marker.on('drag', onDrag);
                    map.on('click', onClick);

                    setTimeout(function() {
                        map.invalidateSize();
                        // console.log("maps opened");
                        $("h6#title_map").css("display", "block");
                    }, 1000);

                }
            },
            error: function() {
                $('div.page-content').unblock();
                Swal.fire(
                    'Failed!',
                    "Trafik sedang penuh, silahkan ulangi beberapa saat lagi.",
                    'warning'
                );
            }
        });
    }

    function takedKoordinat() {
        const latitu = document.getElementsByName('_lat')[0].value;
        const longitu = document.getElementsByName('_long')[0].value;

        document.getElementById('_latitude').value = latitu;
        document.getElementById('_longitude').value = longitu;
        document.getElementById('_koordinat').value = latitu + "," + longitu;

        $('.content-detailModal').modal('hide');
    }

    function changeKecamatan(event) {
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
                    $('.kelurahan_lembaga').html("");
                    $('div.select2-kelurahan-loading').block({
                        message: '<i class="las la-spinner la-spin la-3x la-fw"></i><span class="sr-only">Loading...</span>'
                    });
                },
                success: function(resul) {
                    $('div.select2-kelurahan-loading').unblock();
                    if (resul.status == 200) {
                        $('.kelurahan_lembaga').html(resul.data);
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
                    $('div.select2-kelurahan-loading').unblock();
                    Swal.fire(
                        'PERINGATAN!',
                        "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                        'warning'
                    );
                }
            });
        }
    }

    function changeValidation(event) {
        $('.' + event).css('display', 'none');
    };

    function inputFocus(id) {
        const color = $(id).attr('id');
        $(id).removeAttr('style');
        $('.' + color).html('');
    }

    function inputChange(event) {
        console.log(event.value);
        if (event.value === null || (event.value.length > 0 && event.value !== "")) {
            $(event).removeAttr('style');
        } else {
            $(event).css("color", "#dc3545");
            $(event).css("border-color", "#dc3545");
            // $('.nama_instansi').html('<ul role="alert" style="color: #dc3545;"><li style="color: #dc3545;">Isian tidak boleh kosong.</li></ul>');
        }
    }

    function ambilId(id) {
        return document.getElementById(id);
    }

    $('#formAddData').on('click', '.btn-remove-preview-image', function(event) {
        $('.imagePreviewUpload').removeAttr('src');
        document.getElementsByName("_file")[0].value = "";
    });

    function initSelect2(event, parrent) {
        $('#' + event).select2({
            dropdownParent: parrent
        });
    }

    function removeLampiran(event, preview) {
        $('.imagePreviewUpload' + preview).removeAttr('src');
        document.getElementsByName(event)[0].value = "";
    }

    function loadFile(event, preview) {
        const input = document.getElementsByName(event)[0];
        if (input.files && input.files[0]) {
            var file = input.files[0];

            var mime_types = ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'];

            if (mime_types.indexOf(file.type) == -1) {
                input.value = "";
                $('.imagePreviewUpload' + preview).attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Hanya file type gambar dan pdf yang diizinkan.",
                    'warning'
                );
                return false;
            }

            if (file.size > 2 * 1024 * 1000) {
                input.value = "";
                $('.imagePreviewUpload' + preview).attr('src', '');
                Swal.fire(
                    'Warning!!!',
                    "Ukuran file tidak boleh lebih dari 2 Mb.",
                    'warning'
                );
                return false;
            }

            if (file.type === 'application/pdf') {

            } else {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.imagePreviewUpload' + preview).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }

        } else {
            console.log("failed Load");
        }
    }

    $(document).ready(function() {

    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.js"></script>
<link href="<?= base_url() ?>/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style>
    #map_inits {
        width: 100%;
        height: 400px;
    }

    .leaflet-tooltip {
        pointer-events: auto
    }

    .preview-image-upload-ktp {
        position: relative;
    }

    .preview-image-upload-ktp .imagePreviewUploadKtp {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-ktp .btn-remove-preview-image-ktp {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadKtp:hover+.btn-remove-preview-image-ktp,
    .btn-remove-preview-image-ktp:hover {
        display: block;
    }

    .preview-image-upload-kk {
        position: relative;
    }

    .preview-image-upload-kk .imagePreviewUploadKk {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-kk .btn-remove-preview-image-kk {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadKk:hover+.btn-remove-preview-image-kk,
    .btn-remove-preview-image-kk:hover {
        display: block;
    }

    .preview-image-upload-pernyataan {
        position: relative;
    }

    .preview-image-upload-pernyataan .imagePreviewUploadPernyataan {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-pernyataan .btn-remove-preview-image-pernyataan {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadPernyataan:hover+.btn-remove-preview-image-pernyataan,
    .btn-remove-preview-image-pernyataan:hover {
        display: block;
    }

    .preview-image-upload-foto-rumah {
        position: relative;
    }

    .preview-image-upload-foto-rumah .imagePreviewUploadFotoRumah {
        max-width: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .preview-image-upload-foto-rumah .btn-remove-preview-image-foto-rumah {
        display: none;
        position: absolute;
        top: 5px;
        left: 5px;
        background-color: #555;
        color: white;
        font-size: 16px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
    }

    .imagePreviewUploadFotoRumah:hover+.btn-remove-preview-image-foto-rumah,
    .btn-remove-preview-image-foto-rumah:hover {
        display: block;
    }

    .ul-custom-style-sub-menu-action {
        list-style: none;
        padding-left: 0.5rem;
        border: 1px solid #ffffff2e;
        padding-top: 0.5rem;
        padding-right: 0.5rem;
        border-radius: 1.5rem;
    }

    .li-custom-style-sub-menu-action {
        border: 1px solid white;
        display: inline-block !important;
        padding: 0.3rem 0.5rem 0rem 0.3rem;
        margin-right: 0.3rem;
        margin-bottom: 0.5rem;
        border-radius: 2rem;
    }

    .custom-style-sub-menu-action {
        font-size: 1em;
        line-height: 1;
        height: 24px;
        color: #f6f6f6;
        display: inline-block;
        position: relative;
        text-align: center;
        font-weight: 500;
        box-sizing: border-box;
        margin-top: -15px;
        vertical-align: -webkit-baseline-middle;
    }
</style>
<?= $this->endSection(); ?>
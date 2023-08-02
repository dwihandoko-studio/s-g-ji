<?= $this->extend('t-silastri/peng/index'); ?>

<?= $this->section('content'); ?>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Buat Pengaduan</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="col-xl-12">
            <form id="formAddData" action="./addSave" method="post" enctype="multipart/form-data">
                <div class="card mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Permohonan Pengaduan</h4>
                        <div class="row">
                        </div>
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
                                    <label for="_nohp" class="col-sm-3 col-form-label">No Handphone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control nama" id="_nohp" name="_nohp" value="<?= $data->no_hp ?>" placeholder="No Handphone.. " readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <label for="_alamat" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarean rows="2" class="form-control alamat" id="_alamat" name="_alamat" readonly><?= $data->alamat ?></textarean>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" id="_kecamatan" name="_kecamatan" value="<?= $data->kecamatan ?>" readonly />
                                        <input type="text" class="form-control kecamatan" id="_nama_kecamatan" name="_nama_kecamatan" value="<?= getNamaKecamatan($data->kecamatan) ?>" readonly />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label for="_kampung" class="col-sm-3 col-form-label">Kampung</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" id="_kampung" name="_kampung" value="<?= $data->kelurahan ?>" readonly />
                                        <input type="text" class="form-control kecamatan" id="_nama_kampung" name="_nama_kampung" value="<?= getNamaKelurahan($data->kelurahan) ?>" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row mb-2">
                                    <label for="_kategori" class="col-sm-3 col-form-label">Kategori Aduan :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 kategori_aduan" id="_kategori" name="_kategori" style="width: 100%" onchange="changeJenis(this)">
                                            <option value=""> --- Pilih Kategori Aduan ---</option>
                                            <?php if (isset($jeniss)) {
                                                if (count($jeniss) > 0) {
                                                    foreach ($jeniss as $key => $value) { ?>
                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                            <?php }
                                                }
                                            } ?>
                                        </select>
                                        <textarea rows="3" style="display: none; margin-top: 10px;" id="_kategori_detail" name="_kategori_detail" class="form-control" placeholder="Masukan keterangan peruntukan SKTM.."></textarea>
                                        <div class="help-block _kategori"></div>
                                        <div class="help-block _kategori_detail"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-0 mb-1">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Identitas Subject Yang Diadukan</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mt-1">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="radio" name="_identitas_pemohon" value="sama" id="_identitas_subject" checked="">
                                                <label class="form-check-label" for="_identitas_subject">
                                                    Sama dengan pemohon
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="_identitas_pemohon" value="sama" id="_identitas_subject_lain">
                                                <label class="form-check-label" for="_identitas_subject_lain">
                                                    Orang lain
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="display: block;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <label for="_nama_aduan" class="col-sm-3 col-form-label">Nama Lengkap yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nama_aduan" id="_nama_aduan" name="_nama_aduan" placeholder="Nama lengkap yang diadukan.. " required />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_nik_aduan" class="col-sm-3 col-form-label">NIK yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nik_aduan" id="_nik_aduan" name="_nik_aduan" placeholder="NIK yang diadukan.. " required />
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_nohp_aduan" class="col-sm-3 col-form-label">No Handphone yang diadukan</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control nohp_aduan" id="_nohp_aduan" name="_nohp_aduan" placeholder="No Handphone yang diadukan.. " required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <label for="_alamat_aduan" class="col-sm-3 col-form-label">Alamat yang diadukan</label>
                                            <div class="col-sm-9">
                                                <textarea rows="3" class="form-control alamat_aduan" id="_alamat_aduan" name="_alamat_aduan" required></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_kecamatan_aduan" class="col-sm-3 col-form-label">Kecamatan (yang diadukan) :</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2 kecamatan_aduan" id="_kecamatan_aduan" name="_kecamatan_aduan" style="width: 100%" onchange="changeKecamatan(this)" required>
                                                    <option value=""> --- Pilih Kecamatan --- </option>
                                                    <?php if (isset($kecamatans)) { ?>
                                                        <?php if (count($kecamatans) > 0) { ?>
                                                            <?php foreach ($kecamatans as $key => $value) { ?>
                                                                <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <div class="help-block _kecamatan_aduan"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label for="_kelurahan_aduan" class="col-sm-3 col-form-label">Kelurahan (yang diadukan) :</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2 kelurahan_aduan" id="_kelurahan_aduan" name="_kelurahan_aduan" style="width: 100%" required>
                                                    <option value=""> --- Pilih Kecamatan Dulu --- </option>
                                                </select>
                                                <div class="help-block _kelurahan_aduan"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row mb-2">
                                    <label for="_uraian_aduan" class="col-sm-3 col-form-label">Uraian Pengaduan</label>
                                    <div class="col-sm-12">
                                        <textarea rows="4" class="form-control uraian_aduan" id="_uraian_aduan" name="_uraian_aduan" required></textarea>
                                    </div>
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

<script>
    $("#formAddData").on("submit", function(e) {
        e.preventDefault();
        const indikator1 = $("input[type='radio'][name='_indikator_1']:checked").val();
        const indikator2 = $("input[type='radio'][name='_indikator_2']:checked").val();
        const indikator3 = $("input[type='radio'][name='_indikator_3']:checked").val();
        const indikator4 = $("input[type='radio'][name='_indikator_4']:checked").val();
        const indikator5 = $("input[type='radio'][name='_indikator_5']:checked").val();
        const indikator6 = $("input[type='radio'][name='_indikator_6']:checked").val();

        const nama = document.getElementsByName('_nama')[0].value;
        const nik = document.getElementsByName('_nik')[0].value;
        const kk = document.getElementsByName('_kk')[0].value;
        const jenis = document.getElementsByName('_jenis')[0].value;
        const keterangan = document.getElementsByName('_jenis_detail')[0].value;

        const fileKtp = document.getElementsByName('_file_ktp')[0].value;
        const fileKk = document.getElementsByName('_file_kk')[0].value;
        const filePernyataan = document.getElementsByName('_file_pernyataan')[0].value;
        const fileFotoRumah = document.getElementsByName('_file_foto_rumah')[0].value;

        if (jenis === "") {
            $("select#_jenis").css("color", "#dc3545");
            $("select#_jenis").css("border-color", "#dc3545");
            $('._jenis-error').html('Silahkan pilih jenis SKTM');

            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih peruntukan SKTM.",
                'warning'
            );
            return false;
        }

        if (indikator1 === undefined || indikator1 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 1.",
                'warning'
            );
            return;
        }
        if (indikator2 === undefined || indikator2 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 2.",
                'warning'
            );
            return;
        }
        if (indikator3 === undefined || indikator3 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 3.",
                'warning'
            );
            return;
        }
        if (indikator4 === undefined || indikator4 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 4.",
                'warning'
            );
            return;
        }
        if (indikator5 === undefined || indikator5 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 5.",
                'warning'
            );
            return;
        }
        if (indikator6 === undefined || indikator6 === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan pilih isian indikator 6.",
                'warning'
            );
            return;
        }
        if (fileKtp === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen KTP.",
                'warning'
            );
            return;
        }
        if (fileKk === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen KK.",
                'warning'
            );
            return;
        }
        if (filePernyataan === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Pernyataan.",
                'warning'
            );
            return;
        }
        if (fileFotoRumah === "") {
            Swal.fire(
                'Peringatan..!!',
                "Silahkan lampirkan dokumen Foto Rumah.",
                'warning'
            );
            return;
        }

        const formUpload = new FormData();

        const file_ktp = document.getElementsByName('_file_ktp')[0].files[0];
        formUpload.append('_file_ktp', file_ktp);
        const file_kk = document.getElementsByName('_file_kk')[0].files[0];
        formUpload.append('_file_kk', file_kk);
        const file_pernyataan = document.getElementsByName('_file_pernyataan')[0].files[0];
        formUpload.append('_file_pernyataan', file_pernyataan);
        const file_foto_rumah = document.getElementsByName('_file_foto_rumah')[0].files[0];
        formUpload.append('_file_foto_rumah', file_foto_rumah);

        formUpload.append('nama', nama);
        formUpload.append('nik', nik);
        formUpload.append('kk', kk);
        formUpload.append('jenis', jenis);
        formUpload.append('indikator1', indikator1);
        formUpload.append('indikator2', indikator2);
        formUpload.append('indikator3', indikator3);
        formUpload.append('indikator4', indikator4);
        formUpload.append('indikator5', indikator5);
        formUpload.append('indikator6', indikator6);
        formUpload.append('keterangan', keterangan);

        Swal.fire({
            title: 'Apakah anda yakin ingin mengajukan permohonan data ini?',
            text: "Ajukan permohonan : SKTM",
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
                        $('div.main-content').block({
                            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                        });
                    },
                    success: function(resul) {
                        $('div.main-content').unblock();

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
                        $('div.main-content').unblock();
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
            document.getElementById("_kategori_detail").style.display = "block";
        } else {
            document.getElementById("_kategori_detail").style.display = "none";
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

    $(document).ready(function() {});
</script>
<?= $this->endSection(); ?>

<?= $this->section('scriptTop'); ?>
<style>
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
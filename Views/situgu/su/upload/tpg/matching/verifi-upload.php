<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered border-primary mb-0 modals-datatables-datanya" id="modals-datatables-datanya">
                        <thead>
                            <tr>
                                <th rowspan="2">#</th>
                                <th colspan="6">DATA SIMTUN</th>
                                <th colspan="6">DATA USULAN</th>
                                <th rowspan="2">KETERANGAN</th>
                                <th rowspan="2">AKSI</th>
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
                            <?php if (count($data) > 0) { ?>
                                <?php foreach ($data as $key => $v) { ?>
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
        const table = document.getElementById("modals-datatables-datanya");
        const tbody = table.getElementsByTagName("tbody")[0];

        fetch("./get_data_json?id=<?= $id ?>")
            .then(response => response.json())
            .then(data => {
                for (let i = 0; i < data.length; i++) {
                    const row = document.createElement("tr");
                    const numberCell = document.createElement("td");
                    const nuptkCell = document.createElement("td");
                    const namaCell = document.createElement("td");
                    const golonganCodeCell = document.createElement("td");
                    const masaKerjaCell = document.createElement("td");
                    const gajiPokokCell = document.createElement("td");
                    const totalJjmCell = document.createElement("td");
                    const usNuptkCell = document.createElement("td");
                    const usNamaCell = document.createElement("td");
                    const usGolonganCell = document.createElement("td");
                    const usMkCell = document.createElement("td");
                    const usGapokCell = document.createElement("td");
                    const usKetCell = document.createElement("td");
                    const ketCell = document.createElement("td");
                    const aksiCell = document.createElement("td");
                    numberCell.textContent = data[i].id;
                    nuptkCell.textContent = data[i].nuptk;
                    namaCell.textContent = data[i].nama;
                    golonganCodeCell.textContent = data[i].golongan_code;
                    masaKerjaCell.textContent = data[i].masa_kerja;
                    gajiPokokCell.textContent = data[i].gaji_pokok;
                    totalJjmCell.textContent = data[i].total_jjm_sesuai;
                    usNuptkCell.textContent = data[i].us_nuptk;
                    usNamaCell.textContent = data[i].us_nama;
                    usGolonganCell.textContent = data[i].us_golongan;
                    usMkCell.textContent = data[i].us_masa_kerja;
                    usGapokCell.textContent = data[i].us_gaji_pokok;
                    usKetCell.textContent = data[i].us_keterangan;
                    ketCell.textContent = data[i].keterangan;
                    aksiCell.textContent = data[i].aksi;
                    row.appendChild(numberCell);
                    row.appendChild(nuptkCell);
                    row.appendChild(namaCell);
                    row.appendChild(golonganCodeCell);
                    row.appendChild(masaKerjaCell);
                    row.appendChild(gajiPokokCell);
                    row.appendChild(totalJjmCell);
                    row.appendChild(usNuptkCell);
                    row.appendChild(usNamaCell);
                    row.appendChild(usGolonganCell);
                    row.appendChild(usGapokCell);
                    row.appendChild(usKetCell);
                    row.appendChild(ketCell);
                    row.appendChild(aksiCell);
                    row.classList.add(data[i].status);
                    tbody.appendChild(row);
                }
            });
    </script>
<?php } ?>
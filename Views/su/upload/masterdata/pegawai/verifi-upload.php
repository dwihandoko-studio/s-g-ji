<?php if (isset($data)) { ?>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="row">
                    <div class="col-lg-10 align-self-center">
                        <div class="text-lg-center mt-4 mt-lg-0">
                            <div class="row">
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Data Matching</p>
                                        <h5 class="mb-0 text-info result_total" id="result_total"><i class="mdi mdi-reload mdi-spin"></i></h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Lolos</p>
                                        <h5 class="mb-0 text-success result_lolos" id="result_lolos"><i class="mdi mdi-reload mdi-spin"></i></h5>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Gagal</p>
                                        <h5 class="mb-0 text-danger result_gagal" id="result_gagal"><i class="mdi mdi-reload mdi-spin"></i></h5>

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div>
                                        <p class="text-muted text-truncate mb-2">Jumlah Belum Usul</p>
                                        <h5 class="mb-0 text-warning result_belumusul" id="result_belumusul"><i class="mdi mdi-reload mdi-spin"></i></h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block">
                        <div class="clearfix mt-4 mt-lg-0">
                            <div class="dropdown float-end">
                                <button class="btn btn-primary button_aksi_matching" id="button_aksi_matching" type="button" onclick="aksiMatching()">
                                    <i class="mdi mdi-relation-zero-or-many-to-zero-or-many align-middle me-1"></i> Proses Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-none d-lg-block mb-2 mt-2">
                        <div>
                            <progress id="progressBar" value="0" max="100" style="width:100%; display: none;"></progress>
                        </div>
                        <div>
                            <h3 id="status" style="font-size: 12px; margin: 8px auto;"></h3>
                        </div>
                        <div>
                            <p id="loaded_n_total" style="margin-bottom: 0px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered border-primary mb-0 modals-datatables-datanya" id="modals-datatables-datanya">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NAMA</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>GOLONGAN</th>
                            </tr>
                        </thead>
                        <tbody>
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
        const buttonAksiMatching = document.getElementById("button_aksi_matching");
        buttonAksiMatching.setAttribute("disabled", true);

        let dataSendMatching;

        fetch("./get_data_json?id=<?= $id ?>")
            .then(response => response.json())
            .then(data => {
                dataSendMatching = data;
                buttonAksiMatching.removeAttribute("disabled");

                const result_total = document.getElementById("result_total");
                result_total.textContent = data.total.toString();
                const result_lolos = document.getElementById("result_lolos");
                result_lolos.textContent = data.lolos.toString();
                const result_gagal = document.getElementById("result_gagal");
                result_gagal.textContent = data.gagal.toString();
                const result_belumusul = document.getElementById("result_belumusul");
                result_belumusul.textContent = data.belumusul.toString();
                // const result_total = document.querySelector(".result_total");
                // result_total.textContent = data.total.toString();
                // const result_lolos = document.querySelector(".result_lolos");
                // result_lolos.textContent = data.lolos.toString();
                // const result_gagal = document.querySelector(".result_gagal");
                // result_gagal.textContent = data.gagal.toString();

                for (let i = 0; i < data.data.length; i++) {
                    const row = document.createElement("tr");
                    const numberCell = document.createElement("td");
                    const nipCell = document.createElement("td");
                    const namaCell = document.createElement("td");
                    const nikCell = document.createElement("td");
                    const golonganCell = document.createElement("td");

                    numberCell.textContent = 1 + i;
                    nipCell.textContent = data.data[i].nip;
                    namaCell.textContent = data.data[i].nama;
                    nikCell.textContent = data.data[i].nik;
                    golonganCell.textContent = data.data[i].golongan;

                    row.appendChild(numberCell);
                    row.appendChild(nipCell);
                    row.appendChild(namaCell);
                    row.appendChild(nikCell);
                    row.appendChild(golonganCell);
                    row.classList.add(data.data[i].status);
                    tbody.appendChild(row);
                }
            });

        function aksiMatching() {
            buttonAksiMatching.setAttribute("disabled", true);
            console.log(dataSendMatching);
            const progBar = document.getElementById("progressBar");

            progBar.style.display = "block";

            ambilId("status").innerHTML = "Menyimpan Data . . .";

            let jumlahDataBerhasil = 0;
            let jumlahDataGagal = 0;

            let sendToServer = function(lines, index) {
                if (index > lines.length - 1) {
                    ambilId("progressBar").style.display = "none";
                    ambilId("status").innerHTML = "Proses Matching Berhasil.";
                    ambilId("status").style.color = "green";
                    ambilId("progressBar").value = 0;

                    Swal.fire(
                        'SELAMAT!',
                        "Proses Matching Data Berhasil.",
                        'success'
                    ).then((valRes) => {
                        document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
                    })
                    return; // guard condition
                }

                item = lines[index];
                let total = ((index + 1) / lines.length) * 100;
                total = total.toFixed(2);

                $.ajax({
                    url: "./prosesmatching",
                    type: 'POST',
                    data: item,
                    dataType: 'JSON',
                    success: function(msg) {
                        if (msg.code != 200) {
                            ambilId("status").style.color = "blue";
                            ambilId("progressBar").value = total;
                            ambilId("loaded_n_total").innerHTML = total + '%';
                            console.log(msg.message);
                            if (index + 1 === lines.length) {
                                ambilId("progressBar").style.display = "none";
                                ambilId("status").innerHTML = msg.message;
                                ambilId("status").style.color = "green";
                                ambilId("progressBar").value = 0;

                                Swal.fire(
                                    'SELAMAT!',
                                    "Proses Matching Data Berhasil.",
                                    'success'
                                ).then((valRes) => {
                                    document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
                                })
                            }
                        } else {
                            ambilId("status").style.color = "blue";
                            ambilId("progressBar").value = total;
                            ambilId("loaded_n_total").innerHTML = total + '%';

                            if (index + 1 === lines.length) {
                                ambilId("progressBar").style.display = "none";
                                ambilId("status").innerHTML = msg.message;
                                ambilId("status").style.color = "green";
                                ambilId("progressBar").value = 0;

                                Swal.fire(
                                    'SELAMAT!',
                                    "Proses Matching Data Berhasil.",
                                    'success'
                                ).then((valRes) => {
                                    document.location.href = "<?= base_url('su/masterdata/pegawai'); ?>";
                                })
                            }
                        }

                        setTimeout(
                            function() {
                                sendToServer(lines, index + 1);
                            },
                            350 // delay in ms
                        );
                    },
                    error: function(error) {
                        ambilId("progressBar").style.display = "none";
                        ambilId("status").innerHTML = msg.message;
                        ambilId("status").style.color = "green";
                        ambilId("progressBar").value = 0;
                        buttonAksiMatching.removeAttribute("disabled");
                        Swal.fire(
                            'Failed!',
                            "Gagal.",
                            'warning'
                        );
                    }
                });
            };

            sendToServer(dataSendMatching.aksi, 0);
        }
    </script>
<?php } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Usulan TPG Lolos Berkas Tahun <?= $tw->tahun ?> - TW. <?= $tw->tw ?></title>
</head>

<body>
    <?php
    header('Content-Type: application/vnd-ms-excel');
    header('Content-Disposition: attachment; filename=Data Usulan TPG Lolos Berkas Tahun ' . $tw->tahun . ' - Tw ' . $tw->tw . '.xls');
    ?>

    <center>
        <h2>Data Usulan TPG Lolos Berkas Tahun <?= $tw->tahun ?> - TW. <?= $tw->tw ?></h2>
    </center>

    <table border="1">
        <tr>
            <th>No</th>
            <th>NUPTK</th>
            <th>NAMA</th>
            <th>TEMPAT TUGAS</th>
            <th>NIP</th>
            <th>GOL</th>
            <th>MASA KERJA TAHUN</th>
            <th>JML. BLN</th>
            <th>ML. Uang</th>
            <th>IURAN BPJS 1%</th>
            <th>PPH.21</th>
            <th>JML. DITERIMA</th>
            <th>NO REKENING</th>
            <th>NPSN</th>
            <th>KECAMATAN</th>
            <th>JENJANG SEKOLAH</th>
            <th>KETERANGAN</th>
            <th>VERIFIKATOR</th>
        </tr>
        <?php if (isset($datas)) { ?>
            <?php if (count($datas) > 0) { ?>
                <?php foreach ($datas as $key => $item) { ?>
                    <?php
                    $keterangan = "";
                    $pph = "0%";
                    $pph21 = 0;
                    if ($item->us_pang_golongan == NULL || $item->us_pang_golongan == "") {
                    } else {
                        $pang = explode("/", $item->us_pang_golongan);
                        if ($pang[0] == "III" || $pang[0] == "IX") {
                            $pph21 = (5 / 100);
                            $pph = "5%";
                        } else if ($pang[0] == "IV") {
                            $pph21 = (15 / 100);
                            $pph = "15%";
                        } else {
                            $pph21 = 0;
                            $pph = "0%";
                        }
                    }

                    if (($item->lampiran_cuti == NULL || $item->lampiran_cuti == "") && ($item->lampiran_pensiun == NULL || $item->lampiran_pensiun == "") && ($item->lampiran_kematian == NULL || $item->lampiran_kematian == "")) {
                        $keterangan .= "- ";
                    }

                    if (!($item->lampiran_cuti == NULL || $item->lampiran_cuti == "")) {
                        $keterangan .= "Cuti ";
                    }

                    if (!($item->lampiran_pensiun == NULL || $item->lampiran_pensiun == "")) {
                        $keterangan .= "Pensiun ";
                    }

                    if (!($item->lampiran_kematian == NULL || $item->lampiran_kematian == "")) {
                        $keterangan .= "Kematian ";
                    }
                    ?>
                    <tr>
                        <td><?= $key + 1 ?> </td>
                        <td><?= substr($item->nuptk, 0) ?> </td>
                        <td><?= $item->nama ?> </td>
                        <td><?= $item->tempat_tugas ?> </td>
                        <td><?= substr($item->nip, 0) ?> </td>
                        <td><?= $item->us_pang_golongan ?> </td>
                        <td><?= $item->us_pang_mk_tahun ?> </td>
                        <td><?= $item->us_gaji_pokok ?> </td>
                        <td><?= 3 ?> </td>
                        <td><?= $item->us_gaji_pokok * 3 ?> </td>
                        <td><?= ($item->us_gaji_pokok * 3) * 0.01 ?> </td>
                        <td><?= ($item->us_gaji_pokok * 3) * $pph21 ?> </td>
                        <td><?= ($item->us_gaji_pokok * 3) - (($item->us_gaji_pokok * 3) * 0.01) - (($item->us_gaji_pokok * 3) * $pph21) ?> </td>
                        <td><?= substr($item->no_rekening, 0) ?> </td>
                        <td><?= $item->npsn ?> </td>
                        <td><?= $item->kecamatan ?> </td>
                        <td><?= $item->bentuk_pendidikan ?> </td>
                        <td><?= $keterangan ?> </td>
                        <td><?= $item->verifikator ?> </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </table>
</body>

</html>
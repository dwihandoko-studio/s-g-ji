<?php if (isset($files)) {
    $file = explode(";", $files);
    if (count($file) > 0) { ?>
        <html>

        <body>
            <?php foreach ($file as $key => $value) {
                if ($value == "" || $value == NULL) {
                } else { ?>
                    <?php $ext = explode(".", $value);
                    $i = count($ext) - 1;

                    if ($ext[$i] == "pdf") {
                        // $dataFileGambarF = file_get_contents(FCPATH . './uploads/assesment/lampiran/' . $value);
                        // $base64F = "data:application/pdf;base64," . base64_encode($dataFileGambarF);
                    ?>
                        <!-- <h1>Lampiran Assesment <?php // $key + 1 
                                                    ?></h1>
                    <embed src="<?php // base_url('uploads/assesment/lampiran') 
                                ?>/<?php // $value 
                                    ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" />
                    <pagebreak /> -->
                    <?php } else {

                        $dataFileGambar = file_get_contents(FCPATH . './uploads/assesment/lampiran/' . $value);
                        $base64 = "data:image/" . $ext[$i] . ";base64," . base64_encode($dataFileGambar);
                    ?>
                        <h1>Lampiran Assesment <?= $key + 1 ?></h1>
                        <img src="<?= $base64 ?>" alt="Image" width="100%">

                        <pagebreak />
                <?php
                    }
                } ?>
            <?php } ?>

        </body>

        </html>

    <?php } ?>
<?php } ?>
<option value=""> --- Pilih Kampung/Kelurahan ---</option>
<?php if (isset($kels)) {
    if (count($kels) > 0) {
        foreach ($kels as $key => $value) { ?>
            <option value="<?= $value->id ?>"><?= $value->kelurahan ?></option>
<?php }
    }
} ?>
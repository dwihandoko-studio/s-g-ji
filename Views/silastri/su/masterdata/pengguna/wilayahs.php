<div class="mb-3">
    <label for="_wilayah" class="col-form-label">Pilih Wilayah:</label>
    <select class="form-control select2 ptk" id="_wilayah" name="_wilayah" style="width: 100%">
        <option value="">&nbsp;</option>
        <option value="all">Semua</option>
        <?php if (isset($wilayahs)) {
            if (count($wilayahs) > 0) {
                foreach ($wilayahs as $key => $value) { ?>
                    <option value="<?= $value->id ?>"><?= $value->kecamatan ?></option>
        <?php }
            }
        } ?>
    </select>
    <div class="help-block _wilayah"></div>
</div>
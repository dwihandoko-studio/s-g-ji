<?php if (isset($access)) { ?>
    <form class="form-horizontal" action="" method="post">
        <input type="hidden" id="_id" name="_id" value="<?= $u_id ?>">
        <div class="modal-body">
            <div class="row">
                <?php if (count($access['apps']) > 0) { ?>
                    <?php foreach ($access['apps'] as $keyApp => $vApp) { ?>
                        <div class="col-lg-12">
                            <div class="card" style="background-color: #11131c8c;">
                                <div class="card-body">
                                    <h4 class="card-title">Menu <?= $vApp['menu_title'] ?></h4>
                                    <hr />
                                    <div class="row">
                                        <?php if (count($vApp['sub_menu']) > 0) { ?>
                                            <?php foreach ($vApp['sub_menu'] as $keySm => $vSm) { ?>
                                                <div class="col-lg-6">
                                                    <h5 class="font-size-14 mb-3"><?= $vSm['sub_menu_title'] ?></h5>
                                                    <ul class="ul-custom-style-sub-menu-action">
                                                        <?php if (count($vSm['aksi']) > 0) { ?>
                                                            <?php foreach ($vSm['aksi'] as $keySmA => $vSmA) { ?>
                                                                <li class="li-custom-style-sub-menu-action" style="border: 1px solid white; display: inline-block !important;">
                                                                    <input type="checkbox" switch="success" onchange="aksiChange(this, '<?= $vApp['menu'] ?>', '<?= $vSm['sub_menu_key'] ?>', '<?= $vSmA['key'] ?>', '<?= $u_id ?>')" name="item-sub-<?= $vApp['menu'] ?>-<?= $vSm['sub_menu_key'] ?>-<?= $vSmA['key'] ?>" id="item-sub-<?= $vApp['menu'] ?>-<?= $vSm['sub_menu_key'] ?>-<?= $vSmA['key'] ?>" <?= isset($data) ? ((access_checked_new($data, $vApp['menu'], $vSm['sub_menu_key'], $vSmA['key'])) ? ' checked' : '') : '' ?> />
                                                                    <label for="item-sub-<?= $vApp['menu'] ?>-<?= $vSm['sub_menu_key'] ?>-<?= $vSmA['key'] ?>" data-on-label="Yes" data-off-label="No" style="padding-bottom: 0px; margin-bottom: 0px;"></label>
                                                                    <span class="custom-style-sub-menu-action"><?= $vSmA['key'] ?></span>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
        </div>
    </form>

    <script>
        function aksiChange(event, menu, submenu, aksi, userid) {
            let title = "";
            if (event.checked) {
                title = "Izinkan mengakses menu : " + menu + ", submenu : " + submenu + ", aksi : " + aksi;
            } else {
                title = "Hapus akses menu : " + menu + ", submenu : " + submenu + ", aksi : " + aksi;
            }
            Swal.fire({
                title: 'Apakah anda yakin ingin mengubah akses pengguna ini?',
                text: title,
                icon: 'question',
                showCancelButton: true,
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?= base_url('a/setting/hakaccess/save') ?>",
                        type: 'POST',
                        data: {
                            user_id: userid,
                            menu: menu,
                            submenu: submenu,
                            aksi: aksi,
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('div.content-detailModal').block({
                                message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                            });
                        },
                        success: function(resul) {
                            $('div.content-detailModal').unblock();

                            if (resul.status !== 200) {
                                event.checked = !event.checked;
                                Swal.fire(
                                    'Peringatan!',
                                    resul.message,
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'SELAMAT!',
                                    resul.message,
                                    'success'
                                );
                            }
                        },
                        error: function() {
                            $('div.content-detailModal').unblock();
                            event.checked = !event.checked;
                            Swal.fire(
                                'Failed!',
                                "Server sedang sibuk, silahkan ulangi beberapa saat lagi.",
                                'warning'
                            );
                        }
                    });
                } else {
                    event.checked = !event.checked;
                }
            })
        }
    </script>
<?php } ?>
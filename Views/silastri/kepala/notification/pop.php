<?php if (isset($datas)) { ?>
    <?php if (count($datas) > 0) { ?>
        <?php foreach ($datas as $key => $v) { ?>
            <div data-simplebar style="max-height: 230px;">
                <a href="javascript: void(0);" class="text-reset notification-item">
                    <div class="d-flex">
                        <img src="assets/images/users/avatar-4.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= $v->judul ?></h6>
                            <div class="font-size-12 text-muted">
                                <p class="mb-1" key="t-occidental"><?= $v->isi ?></p>
                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago"><?= make_time_long_ago_new($v->created_at) ?></span></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div data-simplebar style="max-height: 230px;">
            <p style="padding-left: 20px; padding-right: 20px;">Belum ada</p>
        </div>
    <?php } ?>
<?php } else { ?>
    <div data-simplebar style="max-height: 230px;">
        <p style="padding-left: 20px; padding-right: 20px;">Belum ada</p>
    </div>
<?php } ?>
<div class="p-2 border-top d-grid">
    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
    </a>
</div>
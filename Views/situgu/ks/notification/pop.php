<?php if (isset($datas)) { ?>
    <?php if (count($datas) > 0) { ?>
        <button type="button" class="btn header-item noti-icon waves-effect page-header-notifications-dropdown" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-bell bx-tada"></i>
            <?php if ($datas[0]->jumlah > 0) { ?>
                <span class="badge bg-danger rounded-pill"><?= $datas[0]->jumlah ?></span>
            <?php } ?>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0" key="t-notifications"> Notifikasi </h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="small" key="t-view-all"> View All</a>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                <?php foreach ($datas as $key => $value) { ?>
                    <?php if ($value->image_user == NULL || $value->image_user == "") { ?>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-<?= $value->token ?> rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= $value->judul ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-simplified"><?= $value->isi ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago"><?= make_time_long_ago_new($value->created_at) ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="<?= $value->image_user == NULL || $value->image_user == "" ? base_url('assets/images/users/avatar-3.jpg') : base_url() . '/upload/user/' . $user->image_user ?>" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= $value->judul ?></h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1" key="t-simplified"><?= $value->isi ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago"><?= make_time_long_ago_new($value->created_at) ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                </a>
            </div>
        </div>
    <?php } else { ?>
        <button type="button" class="btn header-item noti-icon waves-effect page-header-notifications-dropdown" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-bell bx-tada"></i>
            <!-- <span class="badge bg-danger rounded-pill">3</span> -->
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0" key="t-notifications"> Notifications </h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="small" key="t-view-all"> View All</a>
                    </div>
                </div>
            </div>
            <div data-simplebar style="max-height: 230px;">
                <p style="padding-left: 20px; padding-right: 20px;">Belum ada</p>
            </div>
            <div class="p-2 border-top d-grid">
                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                </a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <button type="button" class="btn header-item noti-icon waves-effect page-header-notifications-dropdown" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-bell bx-tada"></i>
        <!-- <span class="badge bg-danger rounded-pill">3</span> -->
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0" key="t-notifications"> Notifications </h6>
                </div>
                <div class="col-auto">
                    <a href="#!" class="small" key="t-view-all"> View All</a>
                </div>
            </div>
        </div>
        <div data-simplebar style="max-height: 230px;">
            <p style="padding-left: 20px; padding-right: 20px;">Belum ada</p>
        </div>
        <div class="p-2 border-top d-grid">
            <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
            </a>
        </div>
    </div>
<?php } ?>
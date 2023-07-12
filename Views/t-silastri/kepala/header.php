<?php $uri = current_url(true); ?>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?= ($uri->getSegment(2) == "kepala" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('silastri/kepala/home') ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>/assets/images/lastri.svg" alt="" width="120">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url() ?>/assets/images/lastri.svg" alt="" width="150">
                    </span>
                </a>

                <a href="<?= ($uri->getSegment(2) == "kepala" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('silastri/kepala/home') ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>/assets/images/lastri.svg" alt="" width="120">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url() ?>/assets/images/lastri.svg" alt="" width="150">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="bx bx-search-alt"></span>
                </div>
            </form>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- <i class="mdi mdi-reload mdi-spin"> -->
            <div class="dropdown d-inline-block loading_content_notification" id="loading_content_notification">
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
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="<?= isset($user) ? ($user->image !== null ? base_url() . '/upload/user/' . $user->image : base_url() . '/assets/images/users/avatar-1.jpg') : base_url() . '/assets/images/users/avatar-1.jpg' ?>" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= isset($user) ? $user->fullname : '-' ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= base_url('/profil/data') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <a class="dropdown-item" href="<?= base_url('portal') ?>"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Kembali Ke Portal</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:aksiLogout(this);"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

        </div>
    </div>
</header>
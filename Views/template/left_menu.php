<?php $uri = current_url(true); ?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="dashboard.html">
                    <div class="brand-logo"><img src="<?= base_url('assets') ?>/images/logo.svg" width="40px" style="margin-top: -20px;"></div>
                    <h2 class="brand-text mb-0">SUBEJO</h2>
                </a></li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <?php if (isset($user)) { ?>
            <?php //if ((int)$user->level == 1) : 
            ?>
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == "home") ? ' active' : '' ?>">
                    <a href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == "home") ? 'javascript:;' : base_url('a/home') ?>" <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == "home") ? ' class="active"' : '' ?>><i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                    </a>
                </li>

                <?php $dataRoles = listHakAkses();
                if ($dataRoles) { ?>
                    <?php if (count($dataRoles['menus']['apps']) > 0) { ?>
                        <?php $showedApp = true;
                        foreach ($dataRoles['menus']['apps'] as $key => $value) {
                            if (menu_showed_access($dataRoles['access'], $value['menu'])) {
                                if ($showedApp) {
                                    echo '<li class=" navigation-header"><span>Apps</span></li>';
                                }
                                $showedApp = false; ?>
                                <li class=" nav-item <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu']) ? ' active' : '' ?>">
                                    <a href="#"><i class="feather icon-<?= $value['icon'] ?>" <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu']) ? ' class="active"' : '' ?>></i>
                                        <span class="menu-title" data-i18n="<?= $value['title'] ?>"><?= $value['title'] ?></span>
                                    </a>
                                    <ul class="menu-content">
                                        <?php if (submenu_showed_access($dataRoles['accesses'], $value['menu'], 'add')) { ?>
                                            <li <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>>
                                                <a href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "add") ? 'javascript:;' : base_url('a') . '/' . $value['menu'] . '/add' ?>" <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                                    <span class="menu-item" data-i18n="Tambah <?= $value['title'] ?>">Tambah <?= $value['title'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (submenu_showed_access($dataRoles['accesses'], $value['menu'], 'data')) { ?>
                                            <li <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>>
                                                <a href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "data") ? 'javascript:;' : base_url('a') . '/' . $value['menu'] . '/data' ?>" <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                                    <span class="menu-item" data-i18n="Data <?= $value['title'] ?>">Data <?= $value['title'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                        <?php continue;
                            }
                            continue;
                        }
                        ?>
                        <?php $showedMaster = true;
                        foreach ($dataRoles['menus']['master_data'] as $keyM => $valueM) {
                            if (menu_showed_access($dataRoles['access'], $valueM['menu'])) {
                                if ($showedMaster) {
                                    echo '<li class=" navigation-header"><span>Data Master</span></li>';
                                }
                                $showedMaster = false; ?>
                                <li class=" nav-item <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $valueM['menu']) ? ' active' : '' ?>">
                                    <a href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $valueM['menu']) ? 'javascript:;' : base_url('a') . '/' . $valueM['menu'] ?>" <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $valueM['menu']) ? ' class="active"' : '' ?>><i class="feather icon-<?= $valueM['icon'] ?>"></i>
                                        <span class="menu-title" data-i18n="<?= $valueM['title'] ?>"><?= $valueM['title'] ?></span>
                                    </a>
                                </li>
                        <?php continue;
                            }
                            continue;
                        }
                        ?>
                    <?php } ?>
                <?php } ?>


            </ul>
            <?php //endif; 
            ?>
            <?php if ((int)$user->level == 12) :
            ?>
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class=" nav-item <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "home") ? ' active' : '' ?>">
                        <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "home") ? 'javascript:;' : base_url('sp/home') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "home") ? ' class="active"' : '' ?>><i class="feather icon-home"></i>
                            <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                        </a>
                    </li>

                    <li class=" navigation-header"><span>Apps</span></li>
                    <li class=" nav-item <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin") ? ' active' : '' ?>">
                        <a href="#"><i class="feather icon-slack" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin") ? ' class="active"' : '' ?>></i>
                            <span class="menu-title" data-i18n="Data Perizinan">Perizinan</span>
                        </a>
                        <ul class="menu-content">
                            <li <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>>
                                <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "add") ? 'javascript:;' : base_url('sp/izin/add') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                    <span class="menu-item" data-i18n="Tambah Perizinan">Tambah Perizinan</span>
                                </a>
                            </li>
                            <li <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>>
                                <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "data") ? 'javascript:;' : base_url('sp/izin/data') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "izin" && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                    <span class="menu-item" data-i18n="Data Perizinan">Data Perizinan</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class=" navigation-header"><span>Data Master</span></li>
                    <li class=" nav-item <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "kategori") ? ' active' : '' ?>">
                        <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "kategori") ? 'javascript:;' : base_url('sp/kategori') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "kategori") ? ' class="active"' : '' ?>><i class="feather icon-layers"></i>
                            <span class="menu-title" data-i18n="Dashboard">Kategori Perizinan</span>
                        </a>
                    </li>
                    <li class=" nav-item <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa") ? ' active' : '' ?>">
                        <a href="#"><i class="feather icon-database" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa") ? ' class="active"' : '' ?>></i>
                            <span class="menu-title" data-i18n="Kategori">AAAAAAA</span>
                        </a>
                        <ul class="menu-content">
                            <li <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>>
                                <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "add") ? 'javascript:;' : base_url('sp/aa/add') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "add") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                    <span class="menu-item" data-i18n="Tambah Kategori Perizinan">Tambah Kategori Perizinan</span>
                                </a>
                            </li>
                            <li <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>>
                                <a href="<?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "data") ? 'javascript:;' : base_url('sp/aa/data') ?>" <?= ($uri->getSegment(1) == "sp" && $uri->getSegment(2) == "aa" && $uri->getSegment(3) == "data") ? ' class="active"' : '' ?>><i class="feather icon-circle"></i>
                                    <span class="menu-item" data-i18n="Data Kategori Perizinan">Data Kategori Perizinan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif;
            ?>
        <?php } ?>
    </div>
</div>
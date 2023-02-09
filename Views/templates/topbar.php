<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == "home") ? 'javascript:;' : base_url('a/home') ?>">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                            </a>
                        </li>
                        <?php $dataRoles = listHakAkses();
                        if ($dataRoles) { ?>
                            <?php if (count($dataRoles['menus']['apps']) > 0) { ?>

                                <?php foreach ($dataRoles['menus']['apps'] as $key => $value) {
                                    if (menu_showed_access($dataRoles['access'], $value['menu'])) {
                                        if (count($value['sub_menu']) > 0) { ?>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu']) ? ' active-menu-href' : '' ?>" href="#" id="topnav-<?= $value['menu'] ?>" role="button">
                                                    <i class="<?= $value['menu_icon'] ?> me-2"></i><span key="t-<?= $value['menu'] ?>"><?= $value['menu_title'] ?></span>
                                                    <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-<?= $value['menu'] ?>">
                                                    <?php foreach ($value['sub_menu'] as $keyS => $valueS) { ?>
                                                        <?php if (submenu_showed_access($dataRoles['accesses'], $value['menu'], $valueS['sub_menu_key'])) { ?>
                                                            <a href="<?= base_url('a') . '/' . $value['menu'] . '/' . $valueS['sub_menu_key'] ?>" class="dropdown-item <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu'] && $uri->getSegment(3) == $valueS['sub_menu_key']) ? ' active-menu-href' : '' ?>" key="t-<?= $value['menu'] ?>-<?= $valueS['sub_menu_key'] ?>"><?= $valueS['sub_menu_title'] ?></a>
                                                        <?php } else {
                                                            continue;
                                                        } ?>
                                                    <?php } ?>
                                                </div>
                                            </li>
                                        <?php } else { ?>
                                            <li class="nav-item">
                                                <a class="nav-link <?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu']) ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(1) == "a" && $uri->getSegment(2) == $value['menu']) ? 'javascript:;' : base_url('a') . '/' . $value['menu'] ?>">
                                                    <i class="<?= $value['menu_icon'] ?> me-2"></i><span key="t-<?= $value['menu'] ?>"><?= $value['menu_title'] ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                <?php continue;
                                    }
                                    continue;
                                }
                                ?>

                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
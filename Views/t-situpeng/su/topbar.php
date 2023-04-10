<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('situpeng/su/home') ?>">
                                <i class="bx bx-home-circle me-2"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="#" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">MASTER DATA</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('situpeng/su/masterdata/sekolah') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "sekolah") ? ' active-menu-href' : '' ?>" key="t-masterdata-sekolah">Sekolah</a>
                                <a href="<?= base_url('situpeng/su/masterdata/pengawas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengawas") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengawas">Pengawas</a>
                                <a href="<?= base_url('situpeng/su/masterdata/refgaji') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "refgaji") ? ' active-menu-href' : '' ?>" key="t-masterdata-refgaji">Referensi Gaji</a>
                                <a href="<?= base_url('situpeng/su/masterdata/pengguna') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengguna") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengguna">Pengguna</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "verifikasi") ? ' active-menu-href' : '' ?>" href="#" id="topnav-verifikasi" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-verifikasi">VERIFIKASI</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-verifikasi">
                                <a href="<?= base_url('situpeng/su/verifikasi/pengguna') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "pengguna") ? ' active-menu-href' : '' ?>" key="t-verifikasi-pengguna">Pengguna Admin Sekolah</a>
                                <a href="<?= base_url('situpeng/su/verifikasi/pengawas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "pengawas") ? ' active-menu-href' : '' ?>" key="t-verifikasi-pengawas">Penghapusan Pengawas</a>
                                <a href="<?= base_url('situpeng/su/verifikasi/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tpg">Tunjangan Profesi Guru</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting") ? ' active-menu-href' : '' ?>" href="#" id="topnav-setting" role="button">
                                <i class="bx bx-cog me-2"></i><span key="t-setting">SETTING</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-setting">
                                <a href="<?= base_url('situpeng/su/setting/grantedverifikasi') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "grantedverifikasi") ? ' active-menu-href' : '' ?>" key="t-setting-grantedverifikasi">Acess Verifikasi</a>
                                <a href="<?= base_url('situpeng/su/setting/role') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "role") ? ' active-menu-href' : '' ?>" key="t-setting-role">Role Access</a>
                                <a href="<?= base_url('situpeng/su/setting/sptjm') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "sptjm") ? ' active-menu-href' : '' ?>" key="t-setting-sptjm">SPTJM</a>
                                <a href="<?= base_url('situpeng/su/setting/upspj') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "upspj") ? ' active-menu-href' : '' ?>" key="t-setting-upspj">Upload SPJ</a>
                                <a href="<?= base_url('situpeng/su/setting/mt') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "mt") ? ' active-menu-href' : '' ?>" key="t-setting-mt">Maintenance</a>
                                <a href="<?= base_url('situpeng/su/setting/accessmt') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "setting" && $uri->getSegment(4) == "accessmt") ? ' active-menu-href' : '' ?>" key="t-setting-accessmt">Granted Access MT</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "cs") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "su" && $uri->getSegment(3) == "cs") ? 'javascript:;' : base_url('situpeng/su/cs') ?>">
                                <i class="bx bx-help-circle me-2"></i><span key="t-dashboards">ADUAN</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:aksiLogout(this);">
                                <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i><span key="t-logout">Logout</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
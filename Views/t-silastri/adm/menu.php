<?php $uri = current_url(true); ?>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- <li class="menu-title" key="t-menu">Menu</li> -->
                <li <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "home") ? ' class="mm-active"' : '' ?>>
                    <a href="<?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "home") ? 'javascript: void(0);' : base_url('silastri/adm/home') ?>" class="waves-effect <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "home") ? ' mm-active' : '' ?>">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan") ? ' class="mm-active"' : '' ?>>
                    <a href="javascript: void(0);" class="has-arrow waves-effect <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan") ? ' mm-active' : '' ?>">
                        <i class="bx bx-package"></i>
                        <span key="t-layanans">Layanan</span>
                    </a>
                    <ul class="sub-menu  <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan") ? ' mm-collapse mm-active' : '' ?>" aria-expanded="false">
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan" && $uri->getSegment(4) == "antrian") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/layanan/antrian') ?>" key="t-layanan-antrian">Antrian</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan" && $uri->getSegment(4) == "proses") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/layanan/proses') ?>" key="t-layanan-proses">Diproses</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan" && $uri->getSegment(4) == "selesai") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/layanan/selesai') ?>" key="t-layanan-selesai">Selesai</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "layanan" && $uri->getSegment(4) == "ditolak") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/layanan/ditolak') ?>" key="t-layanan-ditolak">Ditolak</a></li>
                    </ul>
                </li>
                <li <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan") ? ' class="mm-active"' : '' ?>>
                    <a href="javascript: void(0);" class="has-arrow waves-effect <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan") ? ' mm-active' : '' ?>">
                        <i class="bx bx-package"></i>
                        <span key="t-pengaduans">Pengaduan</span>
                    </a>
                    <ul class="sub-menu  <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan") ? ' mm-collapse mm-active' : '' ?>" aria-expanded="false">
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan" && $uri->getSegment(4) == "antrian") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/pengaduan/antrian') ?>" key="t-pengaduan-antrian">Antrian</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan" && $uri->getSegment(4) == "selesai") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/pengaduan/selesai') ?>" key="t-pengaduan-selesai">Selesai</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan" && $uri->getSegment(4) == "ditolak") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/pengaduan/ditolak') ?>" key="t-pengaduan-ditolak">Ditolak</a></li>
                        <li><a <?= ($uri->getSegment(2) == "adm" && $uri->getSegment(3) == "pengaduan" && $uri->getSegment(4) == "asesmenppks") ? ' class="mm-active"' : '' ?> href="<?= base_url('silastri/adm/pengaduan/asesmenppks') ?>" key="t-pengaduan-asesmenppks">Assesment PPKS</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>



<!-- 
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "peng" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "peng" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('silastri/peng/home') ?>">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Home</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "peng" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="#" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">Master Data</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('situgu/ks/masterdata/dapodik') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "dapodik") ? ' active-menu-href' : '' ?>" key="t-masterdata-ptk">Dapodik</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? 'javascript:;' : base_url('situgu/ks/absen') ?>">
                                <i class="bx bx-fingerprint me-2"></i><span key="t-absen">Absen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? 'javascript:;' : base_url('situgu/ks/infogtk') ?>">
                                <i class="mdi mdi-bus-stop-covered me-2"></i><span key="t-absen">IGD</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc") ? ' active-menu-href' : '' ?>" href="#" id="topnav-updokument" role="button">
                                <i class="bx bx-receipt me-2"></i><span key="t-updokument">DOKUMEN</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-updokument">
                                <a href="<?= base_url('situgu/ks/doc/master') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "master") ? ' active-menu-href' : '' ?>" key="t-updokument-master">Data Master</a>
                                <a href="<?= base_url('situgu/ks/doc/atribut') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "atribut") ? ' active-menu-href' : '' ?>" key="t-updokument-atribut">Data Atribut</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi") ? ' active-menu-href' : '' ?>" href="#" id="topnav-verifikasi" role="button">
                                <i class="bx bx-rename me-2"></i><span key="t-verifikasi">Verifikasi</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-verifikasi">
                                <a href="<?= base_url('situgu/ks/verifikasi/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('situgu/ks/verifikasi/tamsil') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tamsil") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tamsil">Tamsil</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "sptjm") ? ' active-menu-href' : '' ?>" href="#" id="topnav-sptjm" role="button">
                                <i class="bx bx-spreadsheet me-2"></i><span key="t-sptjm">SPTJM</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-sptjm">
                                <a href="<?= base_url('situgu/ks/sptjm/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-sptjm-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('situgu/ks/sptjm/tamsil') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "sptjm" && $uri->getSegment(4) == "tamsil") ? ' active-menu-href' : '' ?>" key="t-sptjm-tamsil">Tamsil</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us") ? ' active-menu-href' : '' ?>" href="#" id="topnav-usulan" role="button">
                                <i class="bx bx-columns me-2"></i>
                                <span key="t-usulan"> USULAN</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-usulan">
                                <div>
                                    <a href="<?= base_url('situgu/ks/us/ajukan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "create") ? ' active-menu-href' : '' ?>" key="t-us-create">Ajukan Usulan Tunjangan</a>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ks/us/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ks/us/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ks/us/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('situgu/ks/us/tpg/siapsk') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "siapsk") ? ' active-menu-href' : '' ?>" key="t-us-siapsk">Siap SK</a>
                                            <a href="<?= base_url('situgu/ks/us/tpg/skterbit') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active-menu-href' : '' ?>" key="t-us-skterbit">SK Terbit</a>
                                            <a href="<?= base_url('situgu/ks/us/tpg/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ks/us/tamsil/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ks/us/tamsil/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ks/us/tamsil/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('situgu/ks/us/tamsil/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-spj" role="button">
                                <i class="bx bx-task me-2"></i>
                                <span key="t-spj"> SPJ</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-spj">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ks/spj/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-spj-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ks/spj/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-spj-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ks/spj/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-spj-lolosberkas">Lolos Verifikasi</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ks/spj/tamsil/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-spj-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ks/spj/tamsil/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-spj-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ks/spj/tamsil/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-spj-lolosberkas">Lolos Verifikasi</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
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
</div> -->
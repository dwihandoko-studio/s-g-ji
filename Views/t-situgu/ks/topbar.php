<?php $uri = current_url(true); ?>
<!--
<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if (isset($user)) { ?>
                <?php } ?>
                <li>
                    <a href="javascript: void(0);" class="waves-effect <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "home") ? ' active' : '' ?>">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">HOME</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-masterdata">MASTER DATA</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata") ? 'true' : 'false' ?>">
                        <li><a href="<?= base_url('situgu/ks/masterdata/dapodik') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "dapodik") ? 'active' : '' ?>" key="t-masterdata-ptk">Dapodik</a></li>
                        <li><a href="<?= base_url('situgu/ks/masterdata/pengguna') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengguna") ? 'active' : '' ?>" key="t-masterdata-pengguna">Pengguna</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? 'javascript:;' : base_url('situgu/ks/absen') ?>" class="waves-effect <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? ' active' : '' ?>">
                        <i class="bx bx-fingerprint"></i>
                        <span key="t-absen">ABSEN</span>
                    </a>
                </li>
                <li>
                    <a href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? 'javascript:;' : base_url('situgu/ks/infogtk') ?>" class="waves-effect <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? ' active' : '' ?>">
                        <i class="mdi mdi-bus-stop-covered"></i>
                        <span key="t-absen">INFO GTK DIGITAL</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-receipt"></i>
                        <span key="t-updocument">DOKUMEN</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc") ? 'true' : 'false' ?>">
                        <li><a href="<?= base_url('situgu/ks/doc/master') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "master") ? 'active' : '' ?>" key="t-doc-master">Data Master</a></li>
                        <li><a href="<?= base_url('situgu/ks/doc/atribut') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "atribut") ? 'active' : '' ?>" key="t-doc-atribut">Data Atribut</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-rename"></i>
                        <span key="t-verifikasi">VERIFIKASI</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi") ? 'true' : 'false' ?>">
                        <li><a href="<?= base_url('situgu/ks/verifikasi/tpg') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tpg") ? 'active' : '' ?>" key="t-verifikasi-tpg">Tunjangan Profesi Guru</a></li>
                        <li><a href="<?= base_url('situgu/ks/verifikasi/tamsil') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tamsil") ? 'active' : '' ?>" key="t-verifikasi-tamsil">Tamsil</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-spreadsheet"></i>
                        <span key="t-spjtm">SPTJM USULAN</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spjtm") ? 'true' : 'false' ?>">
                        <li><a href="<?= base_url('situgu/ks/spjtm/tpg') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spjtm" && $uri->getSegment(4) == "tpg") ? 'active' : '' ?>" key="t-spjtm-tpg">Tunjangan Profesi Guru</a></li>
                        <li><a href="<?= base_url('situgu/ks/spjtm/tamsil') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spjtm" && $uri->getSegment(4) == "tamsil") ? 'active' : '' ?>" key="t-spjtm-tamsil">Tamsil</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-spreadsheet"></i>
                        <span key="t-usulan">USULAN</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us") ? 'true' : 'false' ?>">
                        <li><a href="<?= base_url('situgu/ks/us/ajukan') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "ajukan") ? 'active' : '' ?>" key="t-us-ajukan">Ajukan Usulan Tunjangan</a></li>
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow" key="t-us-tpg" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg") ? 'tru' : 'false' ?>">TPG (Sertifikasi)</a>
                            <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg") ? 'tru' : 'false' ?>" style="height: 0px;">
                                <li><a href="<?= base_url('situgu/ks/us/tpg/antrian') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active' : '' ?>" key="t-us-tpg-antrian">Antrian</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tpg/ditolak') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active' : '' ?>" key="t-us-tpg-ditolak">Ditolak</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tpg/lolosberkas') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active' : '' ?>" key="t-us-tpg-loloberkas">Lolos Verifikasi</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tpg/siapsk') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "siapsk") ? ' active' : '' ?>" key="t-us-tpg-siapsk">Siap SK</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tpg/skterbit') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active' : '' ?>" key="t-us-tpg-skterbit">Siap Terbit</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tpg/prosestransfer') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active' : '' ?>" key="t-us-tpg-prosestransfer">Proses Transfer</a></li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow" key="t-us-tamsil" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil") ? 'tru' : 'false' ?>">Tamsil</a>
                            <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil") ? 'tru' : 'false' ?>" style="height: 0px;">
                                <li><a href="<?= base_url('situgu/ks/us/tamsil/antrian') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active' : '' ?>" key="t-us-tamsil-antrian">Antrian</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tamsil/ditolak') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active' : '' ?>" key="t-us-tamsil-ditolak">Ditolak</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tamsil/lolosberkas') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active' : '' ?>" key="t-us-tamsil-loloberkas">Lolos Verifikasi</a></li>
                                <li><a href="<?= base_url('situgu/ks/us/tamsil/prosestransfer') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "prosestransfer") ? ' active' : '' ?>" key="t-us-tamsil-prosestransfer">Proses Transfer</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-task"></i>
                        <span key="t-spj">SPJ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj") ? 'true' : 'false' ?>">
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow" key="t-spj-tpg" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg") ? 'tru' : 'false' ?>">TPG (Sertifikasi)</a>
                            <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg") ? 'tru' : 'false' ?>" style="height: 0px;">
                                <li><a href="<?= base_url('situgu/ks/spj/tpg/antrian') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active' : '' ?>" key="t-spj-tpg-antrian">Antrian</a></li>
                                <li><a href="<?= base_url('situgu/ks/spj/tpg/ditolak') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active' : '' ?>" key="t-spj-tpg-ditolak">Ditolak</a></li>
                                <li><a href="<?= base_url('situgu/ks/spj/tpg/lolosberkas') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active' : '' ?>" key="t-spj-tpg-loloberkas">Lolos Verifikasi</a></li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="javascript: void(0);" class="has-arrow" key="t-spj-tamsil" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil") ? 'tru' : 'false' ?>">Tamsil</a>
                            <ul class="sub-menu" aria-expanded="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil") ? 'tru' : 'false' ?>" style="height: 0px;">
                                <li><a href="<?= base_url('situgu/ks/spj/tamsil/antrian') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active' : '' ?>" key="t-spj-tamsil-antrian">Antrian</a></li>
                                <li><a href="<?= base_url('situgu/ks/spj/tamsil/ditolak') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active' : '' ?>" key="t-spj-tamsil-ditolak">Ditolak</a></li>
                                <li><a href="<?= base_url('situgu/ks/spj/tamsil/lolosberkas') ?>" class="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active' : '' ?>" key="t-spj-tamsil-loloberkas">Lolos Verifikasi</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:aksiLogout(this);">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        <span key="t-logout">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> -->

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('situgu/ks/home') ?>">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="#" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">MASTER DATA</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('situgu/ks/masterdata/dapodik') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "dapodik") ? ' active-menu-href' : '' ?>" key="t-masterdata-ptk">Dapodik</a>
                                <a href="<?= base_url('situgu/ks/masterdata/pengguna') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "pengguna") ? ' active-menu-href' : '' ?>" key="t-masterdata-pengguna">Pengguna</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "absen") ? 'javascript:;' : base_url('situgu/ks/absen') ?>">
                                <i class="bx bx-fingerprint me-2"></i><span key="t-absen">Absen</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "infogtk") ? 'javascript:;' : base_url('situgu/ks/infogtk') ?>">
                                <i class="mdi mdi-bus-stop-covered me-2"></i><span key="t-absen">Info GTK Digital</span>
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
                                <i class="bx bx-rename me-2"></i><span key="t-verifikasi">VERIFIKASI</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-verifikasi">
                                <a href="<?= base_url('situgu/ks/verifikasi/tpg') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tpg") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tpg">Tunjangan Profesi Guru</a>
                                <a href="<?= base_url('situgu/ks/verifikasi/tamsil') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "verifikasi" && $uri->getSegment(4) == "tamsil") ? ' active-menu-href' : '' ?>" key="t-verifikasi-tamsil">Tamsil</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ks" && $uri->getSegment(3) == "sptjm") ? ' active-menu-href' : '' ?>" href="#" id="topnav-sptjm" role="button">
                                <i class="bx bx-spreadsheet me-2"></i><span key="t-sptjm">SPTJM USULAN</span>
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
</div>
<?php $uri = current_url(true); ?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <?php if (isset($user)) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "home") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "home") ? 'javascript:;' : base_url('situgu/ptk/home') ?>">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Dashboards</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "masterdata") ? ' active-menu-href' : '' ?>" href="#" id="topnav-masterdata" role="button">
                                <i class="bx bx-layout me-2"></i><span key="t-masterdata">MASTER DATA</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-masterdata">
                                <a href="<?= base_url('situgu/ptk/masterdata/dapodik') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "masterdata" && $uri->getSegment(4) == "dapodik") ? ' active-menu-href' : '' ?>" key="t-masterdata-ptk">Dapodik</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "absen") ? ' active-menu-href' : '' ?>" href="<?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "absen") ? 'javascript:;' : base_url('situgu/ptk/absen') ?>">
                                <i class="bx bx-fingerprint me-2"></i><span key="t-absen">Absen</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "doc") ? ' active-menu-href' : '' ?>" href="#" id="topnav-updokument" role="button">
                                <i class="bx bx-receipt me-2"></i><span key="t-updokument">DOKUMEN</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-updokument">
                                <a href="<?= base_url('situgu/ptk/doc/master') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "master") ? ' active-menu-href' : '' ?>" key="t-updokument-master">Data Master</a>
                                <a href="<?= base_url('situgu/ptk/doc/atribut') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "doc" && $uri->getSegment(4) == "atribut") ? ' active-menu-href' : '' ?>" key="t-updokument-atribut">Data Atribut</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us") ? ' active-menu-href' : '' ?>" href="#" id="topnav-usulan" role="button">
                                <i class="bx bx-columns me-2"></i>
                                <span key="t-usulan"> USULAN</span>
                                <div class="arrow-down"></div>
                            </a>

                            <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-usulan">
                                <div>
                                    <a href="<?= base_url('situgu/ptk/us/ajukan') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "create") ? ' active-menu-href' : '' ?>" key="t-us-create">Ajukan Usulan Tunjangan</a>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6> TPG (Sertifikasi)</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/siapsk') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "siapsk") ? ' active-menu-href' : '' ?>" key="t-us-siapsk">Siap SK</a>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/skterbit') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "skterbit") ? ' active-menu-href' : '' ?>" key="t-us-skterbit">SK Terbit</a>
                                            <a href="<?= base_url('situgu/ptk/us/tpg/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ptk/us/tamsil/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-us-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ptk/us/tamsil/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-us-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ptk/us/tamsil/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-us-lolosberkas">Lolos Verifikasi</a>
                                            <a href="<?= base_url('situgu/ptk/us/tamsil/prosestransfer') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "us" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "prosestransfer") ? ' active-menu-href' : '' ?>" key="t-us-prosestransfer">Proses Transfer</a>
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
                                            <a href="<?= base_url('situgu/ptk/spj/tpg/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-spj-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ptk/spj/tpg/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-spj-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ptk/spj/tpg/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tpg"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-spj-lolosberkas">Lolos Verifikasi</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6> TAMSIL</h6>
                                        <div>
                                            <a href="<?= base_url('situgu/ptk/spj/tamsil/antrian') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "antrian") ? ' active-menu-href' : '' ?>" key="t-spj-antrian">Antrian</a>
                                            <a href="<?= base_url('situgu/ptk/spj/tamsil/ditolak') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "ditolak") ? ' active-menu-href' : '' ?>" key="t-spj-ditolak">Ditolak</a>
                                            <a href="<?= base_url('situgu/ptk/spj/tamsil/lolosberkas') ?>" class="dropdown-item <?= ($uri->getSegment(2) == "ptk" && $uri->getSegment(3) == "spj" && $uri->getSegment(4) == "tamsil"  && $uri->getSegment(5) == "lolosberkas") ? ' active-menu-href' : '' ?>" key="t-spj-lolosberkas">Lolos Verifikasi</a>
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
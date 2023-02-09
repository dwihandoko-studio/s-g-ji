<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?= isset($user) ? $user->fullname : '-' ?></span>
                                <span class="user-status">
                                    <?php if (isset($user)) {
                                        switch ((int)$user->level) {
                                            case 1:
                                                echo "Superadmin";
                                                break;
                                            case 2:
                                                echo "Admin DPMPTSP";
                                                break;
                                            case 3:
                                                echo "Admin Bapenda";
                                                break;

                                            default:
                                                echo "Monitoring";
                                                break;
                                        }
                                    } else {
                                        echo "-";
                                    } ?>
                                </span>
                            </div><span><img class="round" src="<?= base_url() ?>/assets/images/logo.svg" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?= base_url('a/profil') ?>"><i class="feather icon-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:aksiLogout(this)"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
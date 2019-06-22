<header class="main-header">
    <a href="<?= base_url() ?>" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><strong><?= htmlchars($settingGeneral->site_name) ?></strong></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url("media/users/{$userAuth->picture}") ?>" class="user-image img-circle" alt="User Image">
                        <span class="hidden-xs"><?= htmlchars($userAuth->firstname . " " . $userAuth->lastname) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?= base_url("media/users/{$userAuth->picture}") ?>" class="img-circle" alt="User Image">

                            <p>
                                <?= htmlchars($userAuth->firstname . " " . $userAuth->lastname) ?>
                                <small><?= htmlchars($userAuth->email) ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url("profile") ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= base_url("signout") ?>" class="btn btn-default btn-flat">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
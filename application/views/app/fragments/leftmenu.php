<aside class="main-sidebar">
    <section class="sidebar">
        <form action="<?= current_url() ?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Pencarian..."
                    value="<?= $this->input->get("q") ?>">
                <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU UTAMA</li>
            <li class="<?= activeLeftMenu("dashboard") ?>">
                <a href="<?= base_url("dashboard") ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php if ($this->UserModel->isAdmin()): ?>
            <li class="header">MENU ADMINISTRATOR</li>
            <li class="<?= activeLeftMenu("users") ?>">
                <a href="<?= base_url("users") ?>">
                    <i class="fa fa-users"></i> <span>Pengguna</span>
                </a>
            </li>
            <li class="<?= activeLeftMenu("settings") ?>">
                <a href="<?= base_url("settings") ?>">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </section>
</aside>
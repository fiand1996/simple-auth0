<div class="box login-box">
    <div class="login-logo bg-blue">
        <a href="<?= base_url() ?>"><b><?= htmlchars($settingGeneral->site_name) ?></b></a>
    </div>
    <div class="box-body">
        <div id="message">
            <div class="alert alert-success" role="alert">Selamat akun Anda berhasil diverifikasi!</div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
                <a class="btn btn-default btn-block" href="<?= base_url("dashboard") ?>">Dashboard</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-default btn-block" href="<?= base_url("profile") ?>">Profile</a>
            </div>
        </div>
    </div>
</div>
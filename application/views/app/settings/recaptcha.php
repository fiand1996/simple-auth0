<section class="content">

    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings") ?>">Pengaturan Umum</a>
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings/email") ?>">Pengaturan
                    Email</a>
                <a class="list-group-item list-group-item-action active"
                    href="<?= base_url("settings/recaptcha") ?>">Pengaturan reCAPTCHA</a>
                <a class="list-group-item list-group-item-action"
                    href="<?= base_url("settings/social-login") ?>">Pengaturan Sosial Login</a>
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings/db-backup") ?>">Database
                    Backup</a>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="box box-solid">
                <form id="form-ajax" action="<?= current_url() ?>" method="post">
                    <input type="hidden" name="action" value="recaptcha">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pengaturan reCAPTCHA</h3>
                    </div>
                    <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>
                        <div class="row mb-2">
                            <div class="form-group col-md-6">
                                <label for="site_key">Site Key</label>
                                <input id="site_key" name="site_key" class="form-control" type="text"
                                    value="<?= $settingRecaptcha->site_key ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="secret_key">Secret key</label>
                                <input id="secret_key" name="secret_key" class="form-control" type="text"
                                    value="<?= $settingRecaptcha->secret_key ?>">
                            </div>
                        </div>
                        <?php $disabled = isset($settingRecaptcha->site_key) && isset($settingRecaptcha->secret_key) ? "" : "disabled" ?>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingRecaptcha->signin ? "checked" : "" ?> id="signin" name="signin"
                                <?= $disabled ?>>
                            <label for="signin">Masuk</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingRecaptcha->signup ? "checked" : "" ?> id="signup" name="signup"
                                <?= $disabled ?>>
                            <label for="signup">Daftar</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingRecaptcha->forgot ? "checked" : "" ?> id="forgot" name="forgot"
                                <?= $disabled ?>>
                            <label for="forgot">Reset Password</label>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
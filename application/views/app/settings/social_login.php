<section class="content">

    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings") ?>">Pengaturan Umum</a>
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings/email") ?>">Pengaturan
                    Email</a>
                <a class="list-group-item list-group-item-action"
                    href="<?= base_url("settings/recaptcha") ?>">Pengaturan reCAPTCHA</a>
                <a class="list-group-item list-group-item-action active"
                    href="<?= base_url("settings/social-login") ?>">Pengaturan Sosial Login</a>
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings/db-backup") ?>">Database
                    Backup</a>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="box box-solid">
                <form id="form-ajax" action="<?= current_url() ?>" method="post">
                    <input type="hidden" name="action" value="oauth">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pengaturan Sosial Login</h3>
                    </div>
                    <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>
                        <div class="form-group">
                            <label for="api_key">Oauth App keys</label>
                            <input id="api_key" name="api_key" class="form-control" type="text"
                                value="<?= htmlchars($settingOauth->api_key) ?>">
                        </div>
                        <?php $disabled = isset($settingOauth->api_key) ? "" : "disabled" ?>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingOauth->facebook ? "checked" : "" ?> id="facebook" name="facebook"
                                <?= $disabled ?>>
                            <label for="facebook">Facebook</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingOauth->google ? "checked" : "" ?> id="google" name="google"
                                <?= $disabled ?>>
                            <label for="google">Google</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingOauth->twitter ? "checked" : "" ?> id="twitter" name="twitter"
                                <?= $disabled ?>>
                            <label for="twitter">Twitter</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue"
                                <?= $settingOauth->github ? "checked" : "" ?> id="github" name="github"
                                <?= $disabled ?>>
                            <label for="github">Github</label>
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
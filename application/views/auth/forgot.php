<div class="box login-box">
    <div class="login-logo bg-blue">
        <a href="<?= base_url() ?>"><b><?= htmlchars($settingGeneral->site_name) ?></b></a>
    </div>
    <div class="box-body">
        <div class="text-center">
            <span class="text-blue">PEMULIHAN PASSWORD</span>
        </div>
        <div class="text-center" style="margin-bottom:15px;margin-top: 20px;"></div>
        <div id="message"><?= showAlert() ?></div>
        <form id="form-ajax" action="<?= current_url() ?>" method="post" autocomplete="off">
            <input type="hidden" name="action" value="forgot">
            <div class="form-group has-feedback">
                <input type="email" id="email" name="email" class="required form-control" placeholder="Email">
            </div>

            <?php if (isset($settingRecaptcha->site_key) &&
                      isset($settingRecaptcha->secret_key) &&
                      $settingRecaptcha->forgot): ?>
            <div class="form-label-group text-center">
                <div id="recaptcha" data-site-key="<?= $settingRecaptcha->site_key ?>" data-theme="light">
                </div>
            </div>
            <?php endif; ?>

            <div class="text-center" style="margin-top: 10px">
                <button type="submit" class="btn btn-block btn-primary">Atur ulang password</button>
                <p style="margin-top: 15px"> <a href="<?= base_url("signin") ?>">Kembali</a></p>
            </div>
        </form>
    </div>
</div>
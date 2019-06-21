<div class="box login-box">
    <div class="login-logo bg-blue">
        <a href="<?= base_url() ?>"><b><?= $settingGeneral->site_name ?></b></a>
    </div>
    <div class="box-body">
        <div class="text-center">
            <span class="text-blue">GANTI PASSWORD</span>
        </div>
        <div class="text-center" style="margin-bottom:15px;margin-top: 20px;"></div>
        <div id="message"><?= showAlert() ?></div>
        <form id="form-ajax" action="<?= current_url() ?>" method="post" autocomplete="off">
            <input type="hidden" name="action" value="reset">
            <div class="form-group has-feedback">
                <input type="password" id="password" name="password" class="required form-control"
                    placeholder="Password baru">
            </div>
            <div class="form-group has-feedback">
                <input type="password" d="passconfirm" name="passconfirm" class="required form-control"
                    placeholder="Konfirmasi password baru">
            </div>

            <div class="text-center" style="margin-top: 10px">
                <button type="submit" class="btn btn-block btn-primary">Simpan password</button>
            </div>
        </form>
    </div>
</div>
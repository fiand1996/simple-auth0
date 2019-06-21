<div class="box login-box">
    <div class="login-logo bg-blue">
        <a href="<?= base_url() ?>"><b><?= $settingGeneral->site_name ?></b></a>
    </div>
    <div class="box-body">
        <div class="text-center">
            <span class="text-blue">DAFTAR AKUN BARU</span>
        </div>
        <div class="text-center" style="margin-bottom:15px;margin-top: 20px;">
            <?php if (isset($settingOauth->api_key) && $settingOauth->facebook): ?>
            <a href="javascript:void(0)" class="btn oauth-facebook btn-social-icon btn-facebook"><i
                    class="fa fa-facebook"></i></a>
            <?php endif;?>
            <?php if (isset($settingOauth->api_key) && $settingOauth->github): ?>
            <a href="javascript:void(0)" class="btn oauth-github btn-social-icon btn-github"><i
                    class="fa fa-github"></i></a>
            <?php endif;?>
            <?php if (isset($settingOauth->api_key) && $settingOauth->google): ?>
            <a href="javascript:void(0)" class="btn oauth-google btn-social-icon btn-google"><i
                    class="fa fa-google-plus"></i></a>
            <?php endif;?>
            <?php if (isset($settingOauth->api_key) && $settingOauth->twitter): ?>
            <a href="javascript:void(0)" class="btn oauth-twitter btn-social-icon btn-twitter"><i
                    class="fa fa-twitter"></i></a>
            <?php endif;?>
        </div>
        <div id="message"><?= showAlert() ?></div>
        <form id="form-ajax" action="<?= current_url() ?>" method="post" autocomplete="off">
            <input type="hidden" name="action" value="signup">
            <?php if ($this->input->get('redirect')): ?>
            <input type="hidden" name="redirect" value="<?=$this->input->get('redirect')?>">
            <?php endif;?>
            <div class="form-group has-feedback">
                <input type="text" id="firstname" name="firstname" class="required form-control"
                    placeholder="Nama Depan">
            </div>
            <div class="form-group has-feedback">
                <input type="text" id="lastname" name="lastname" class="required form-control"
                    placeholder="Nama Belakang">
            </div>
            <div class="form-group has-feedback">
                <input type="email" id="email" name="email" class="required form-control" placeholder="Email">
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="password" name="password" class="required form-control"
                    placeholder="Password">
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="passconfirm" name="passconfirm" class="required form-control"
                    placeholder="Konfirmasi password">
            </div>
            <div class="form-group has-feedback">
                <select class="required form-control" id="timezone" name="timezone">
                    <option value="">Pilih Zona Waktu</option>
                    <?php 
                        $tz = $IpInfo->timezone;
                        if ($this->input->post("timezone")) {
                            $tz = $this->input->post("timezone");
                        }
                    ?>
                    <?php foreach ($TimeZones as $k => $v): ?>
                        <option value="<?= $k ?>" <?= $k == $tz ? "selected" : "" ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p class="text-center" style="font-size:1.0em; color: #666">Dengan mendaftar, Anda setuju dengan <a
                    href="<?= base_url("terms-services") ?>">Ketentuan layanan</a> kami</p>

            <?php if (isset($settingRecaptcha->site_key) &&
                      isset($settingRecaptcha->secret_key) &&
                      $settingRecaptcha->signup): ?>
            <div class="form-label-group text-center">
                <div id="recaptcha" data-site-key="<?= $settingRecaptcha->site_key ?>" data-theme="light">
                </div>
            </div>
            <?php endif; ?>

            <div class="text-center" style="margin-top: 10px">
                <button type="submit" class="btn btn-block btn-primary">Daftar</button>
                <p style="margin-top: 15px">Sudah mempunyai akun?</p>
                <a class="btn btn-default btn-block" href="<?= base_url("signin") ?>">Masuk</a>
            </div>
        </form>
    </div>
</div>
<div class="box login-box">
  <div class="login-logo bg-blue">
    <a href="<?= base_url() ?>"><b><?= $settingGeneral->site_name ?></b></a>
  </div>
  <div class="box-body">
    <div class="text-center">
      <span class="text-blue">MASUK UNTUK MELANJUTKAN</span>
    </div>
    <div class="text-center" style="margin-bottom:15px;margin-top: 20px;">
      <?php if (isset($settingOauth->api_key) && $settingOauth->facebook): ?>
      <a href="javascript:void(0)" class="btn oauth-facebook btn-social-icon btn-facebook"><i
          class="fa fa-facebook"></i></a>
      <?php endif; ?>
      <?php if (isset($settingOauth->api_key) && $settingOauth->github): ?>
      <a href="javascript:void(0)" class="btn oauth-github btn-social-icon btn-github"><i class="fa fa-github"></i></a>
      <?php endif; ?>
      <?php if (isset($settingOauth->api_key) && $settingOauth->google): ?>
      <a href="javascript:void(0)" class="btn oauth-google btn-social-icon btn-google"><i
          class="fa fa-google-plus"></i></a>
      <?php endif; ?>
      <?php if (isset($settingOauth->api_key) && $settingOauth->twitter): ?>
      <a href="javascript:void(0)" class="btn oauth-twitter btn-social-icon btn-twitter"><i
          class="fa fa-twitter"></i></a>
      <?php endif; ?>
    </div>
    <div id="message"><?= showAlert() ?></div>
    <form id="form-ajax" action="<?= current_url() ?>" method="post" autocomplete="off">
      <input type="hidden" name="action" value="signin">
      <?php if ($this->input->get('redirect')): ?>
      <input type="hidden" name="redirect" value="<?=$this->input->get('redirect')?>">
      <?php endif;?>
      <div class="form-group has-feedback">
        <input type="email" class="form-control required" id="email" name="email" placeholder="Email">
        <span class="fa fa-envelope form-control-feedback text-muted"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control required" id="password" name="password" placeholder="Password">
        <span class="fa fa-lock form-control-feedback text-muted"></span>
      </div>

      <?php if (isset($settingRecaptcha->site_key) &&
                isset($settingRecaptcha->secret_key) &&
                $settingRecaptcha->signin): ?>
      <div class="form-label-group text-center">
        <div id="recaptcha" data-site-key="<?= $settingRecaptcha->site_key ?>" data-theme="light">
        </div>
      </div>
      <?php endif; ?>


      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input id="remember" class="icheck-flat-blue" name="remember" type="checkbox"> Ingat saya
            </label>
          </div>
        </div>
        <div class="col-xs-6">
          <p style="margin-top: 10px">
            <a class="pull-right text-muted" href="<?= base_url("forgot") ?>">Lupa password?</a>
          </p>
        </div>
      </div>
      <div class="text-center" style="margin-top: 10px">
        <button type="submit" class="btn btn-block btn-primary">Masuk</button>
        <p style="margin-top: 15px">Tidak mempunyai akun?</p>
        <a class="btn btn-default btn-block" href="<?= base_url("signup") ?>">Daftar</a>
      </div>
    </form>
  </div>
</div>
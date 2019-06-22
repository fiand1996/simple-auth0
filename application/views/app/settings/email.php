<section class="content">

    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings") ?>">Pengaturan Umum</a>
                <a class="list-group-item list-group-item-action active"
                    href="<?= base_url("settings/email") ?>">Pengaturan Email</a>
                <a class="list-group-item list-group-item-action"
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
                    <input type="hidden" name="action" value="email">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pengaturan Email</h3>
                    </div>
                    <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="host">Server SMTP</label>
                                <input id="host" name="host" class="form-control" type="text"
                                    value="<?=htmlchars($settingEmail->host)?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="port">Port</label>
                                <input id="port" name="port" class="form-control" type="text"
                                    value="<?=htmlchars($settingEmail->port)?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="from">Email Dari</label>
                                <input id="from" name="from" class="form-control" type="text"
                                    value="<?=htmlchars($settingEmail->from)?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="encryption">Enkripsi</label>
                                <select class="form-control" id="encryption" name="encryption">
                                    <option value="">Tidak ada</option>
                                    <option value="ssl" <?=$settingEmail->encryption == "ssl" ? "selected" : ""?>>SSL
                                    </option>
                                    <option value="tls" <?=$settingEmail->encryption == "tls" ? "selected" : ""?>>TLS
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="icheck-flat-blue"
                                    <?= $settingEmail->auth ? "checked" : "" ?> id="auth" name="auth">
                                <label for="auth">Otentikasi</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">Nama Pengguna</label>
                                <input id="username" name="username" class="form-control" type="text"
                                    value="<?=htmlchars($settingEmail->username)?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input id="password" name="password" class="form-control" type="password"
                                    value="<?=$settingEmail->password?>">
                            </div>
                        </div>
                        <div class="collapse" id="collapseTestEmail">
                            <div class="input-group input-group">
                                <input type="email" id="e-mail" name="e-mail" class="form-control"
                                    placeholder="Masukkan alamat email yang akan dituju"
                                    aria-label="Masukkan alamat email yang akan dituju">
                                <span class="input-group-btn">
                                    <button type="button" data-action="<?=current_url()?>"
                                        class="btn-send-email btn btn-primary">Kirim</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <button type="button" class="btn btn-info" data-toggle="collapse"
                            data-target="#collapseTestEmail" aria-expanded="false"
                            aria-controls="collapseTestEmail">Test Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
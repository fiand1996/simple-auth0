<section class="content">

    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings") ?>">Pengaturan Umum</a>
                <a class="list-group-item list-group-item-action" href="<?= base_url("settings/email") ?>">Pengaturan
                    Email</a>
                <a class="list-group-item list-group-item-action"
                    href="<?= base_url("settings/recaptcha") ?>">Pengaturan reCAPTCHA</a>
                <a class="list-group-item list-group-item-action"
                    href="<?= base_url("settings/social-login") ?>">Pengaturan Sosial Login</a>
                <a class="list-group-item list-group-item-action active"
                    href="<?= base_url("settings/db-backup") ?>">Database Backup</a>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="box box-solid">
                <form action="<?= current_url() ?>" method="post">
                    <input type="hidden" name="action" value="backup">
                    <div class="box-header with-border">
                        <h3 class="box-title">Database Backup</h3>
                    </div>
                    <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>
                        <div class="callout callout-info">
                            <span>Pilih nama tabel yang akan dicadangkan, jika tidak ada satupun yang
                            dipilih, maka semua tabel yang ada akan dicadangkan.</span>
                        </div>

                        <?php foreach ($this->db->list_tables() as $table): ?>
                        <div class="form-check">
                            <input type="checkbox" class="icheck-flat-blue" id="tables" name="tables[]"
                                value="<?= $table ?>">
                            <label for="tables"><?= $table ?></label>
                        </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Cadangkan</button>
                        <input type="checkbox" class="icheck-flat-blue" id="download" name="download">
                        <label for="download">Unduh File</label>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
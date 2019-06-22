 <section class="content">

     <div class="row">
         <div class="col-md-4">
             <ul class="list-group">
                 <a class="list-group-item list-group-item-action active" href="<?= base_url("settings") ?>">Pengaturan
                     Umum</a>
                 <a class="list-group-item list-group-item-action" href="<?= base_url("settings/email") ?>">Pengaturan
                     Email</a>
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
                     <input type="hidden" name="action" value="general">
                     <div class="box-header with-border">
                         <h3 class="box-title">Pengaturan Umum</h3>
                     </div>
                     <div class="box-body">
                         <div id="message"><?= showAlert() ?></div>
                         <div class="form-group">
                             <label for="site_name">Nama Situs</label>
                             <input id="site_name" name="site_name" class="form-control" type="text"
                                 value="<?= htmlchars($settingGeneral->site_name) ?>">
                         </div>
                         <div class="form-group">
                             <label for="site_title">Judul Situs</label>
                             <input id="site_title" name="site_title" class="form-control" type="text"
                                 value="<?= htmlchars($settingGeneral->site_title) ?>">
                         </div>
                         <div class="form-group">
                             <label for="site_description">Deskripsi Situs</label>
                             <textarea name="site_description" id="site_description" cols="30" class="form-control"
                                 rows="5"><?= htmlchars($settingGeneral->site_description) ?></textarea>
                         </div>
                         <div class="form-group">
                             <label for="site_keywords">Kata Kunci Situs</label>
                             <textarea name="site_keywords" id="site_keywords" cols="30" class="form-control"
                                 rows="5"><?= htmlchars($settingGeneral->site_keywords) ?></textarea>
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
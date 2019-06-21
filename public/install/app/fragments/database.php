<div class="box box-solid db-fragment hide">
    <form class="ajax-form" action="<?= APPURL . "/install/install.php"?>" method="post">
        <div class="box-header with-border text-center bg-blue">
            <h3 class="box-title">Koneksi Database</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label for="hostname">Host</label>
                <input type="text" class="form-control" name="hostname" id="hostname" value="localhost">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="database">Nama Database</label>
                <input type="text" class="form-control" name="database" id="database">
            </div>

        </div>
        <div class="box-footer text-center">
            <div id="message"></div>
            <input type="hidden" name="action" value="install">
            <button class="btn btn-primary" type="submit">Instal Sekarang</button>
        </div>
    </form>
</div>
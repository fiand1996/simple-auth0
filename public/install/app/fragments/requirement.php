<div class="box box-solid requirement-fragment hide">
            <div class="box-header with-border text-center bg-blue">
                <h3 class="box-title">Persyaratan</h3>
            </div>
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <a href="#">PHP 5.6.0+
                            <?php $installable = true;?>
                            <?php if (version_compare(PHP_VERSION, '5.6.0') >= 0): ?>
                            <span class="label label-success pull-right"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                            <span class="label label-danger pull-right"><i class="fa fa-times-circle"></i></span>
                            <?php $installable = false; ?>
                            <?php endif ?>
                        </a>
                    </li>
                    <li>
                        <a href="#">allow_url_fopen
                            <?php if (ini_get("allow_url_fopen")): ?>
                            <span class="label label-success pull-right"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                            <span class="label label-danger pull-right"><i class="fa fa-times-circle"></i></span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <a href="#">cURL 7.19.4+
                            <?php $curl = function_exists("curl_version") ? curl_version() : false;?>
                            <?php if (!empty($curl["version"]) && version_compare($curl["version"], '7.19.4') >= 0): ?>
                            <span class="label label-success pull-right"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                            <span class="label label-danger pull-right"><i class="fa fa-times-circle"></i></span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <a href="#">EXIF
                            <?php if (function_exists('exif_read_data')): ?>
                            <span class="label label-success pull-right"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                            <span class="label label-danger pull-right"><i class="fa fa-times-circle"></i></span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <a href="#">GD
                            <?php if (extension_loaded('gd') && function_exists('gd_info')): ?>
                            <span class="label label-success pull-right"><i class="fa fa-check-circle"></i></span>
                            <?php else: ?>
                            <span class="label label-danger pull-right"><i class="fa fa-times-circle"></i></span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <code>/public/index.php</code>
                            <?php if (is_writeable(PUBLICPATH . "index.php")): ?>
                            <span class="label label-success pull-right">writable</span>
                            <?php else: ?>
                            <span class="label label-danger pull-right">not writable</span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <?php 
                            if (!file_exists(PUBLICPATH . "media/users/")) {
                                @mkdir(PUBLICPATH . "media/users/", "0777", true);
                            }
                        ?>
                        <a href="#">
                            <code>/public/media/users/</code>
                            <?php if (is_writeable(PUBLICPATH . "media/users/")): ?>
                            <span class="label label-success pull-right">writable</span>
                            <?php else: ?>
                            <span class="label label-danger pull-right">not writable</span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <code>/application/config/database.php</code>
                            <?php if (is_writeable(ROOTPATH . "application/config/database.php")): ?>
                            <span class="label label-success pull-right">writable</span>
                            <?php else: ?>
                            <span class="label label-danger pull-right">not writable</span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                    <li>
                        <?php 
                            if (!file_exists(ROOTPATH . "storage/session/")) {
                                @mkdir(ROOTPATH . "storage/session/", "0777", true);
                            }
                        ?>
                        <a href="#">
                            <code>/storage/session/</code>
                            <?php if (is_writeable(ROOTPATH . "storage/session/")): ?>
                            <span class="label label-success pull-right">writable</span>
                            <?php else: ?>
                            <span class="label label-danger pull-right">not writable</span>
                            <?php $installable = false;?>
                            <?php endif?>
                        </a>
                    </li>
                </ul>
                </ul>
            </div>
            <div class="box-footer text-center">
                <?php if ($installable): ?>
                <button class="btn btn-primary next-btn" type="submit">Lanjutkan</button>
                <?php else: ?>
                <div class="alert callout-danger">
                    <span class="text-red">Mohon maaf! Konfigurasi server Anda tidak sesuai dengan persyaratan aplikasi!</span>
                </div>
                <button class="btn btn-primary" type="submit" disabled>Lanjutkan</button>
                <?php endif; ?>
            </div>
        </div>
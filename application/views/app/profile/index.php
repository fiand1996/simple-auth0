<section class="content">
    <div class="row">
        <?php if ($userAuth->is_active == 0 && $userAuth->account_type !== "admin"): ?>
        <div class="col-md-12">
            <div class="alert alert-warning">
                <div class="msg">
                    Anda perlu memverifikasi email Anda. Periksa instruksi yang
                    dikirim ke <strong><?= $userAuth->email ?></strong> untuk verifikasi email Anda.
                    <a href="javascript:void(0)" class="btn btn-primary btn-xs js-resend-verification-email"
                        data-url="<?= base_url("profile") ?>">Kirim ulang email</a>
                    <em class="js-resend-result"></em>
                </div>
                <i class="fa fa-spinner fa-spin progress"></i>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-5">
            <div class="box box-solid">
                <form id="form-ajax" action="<?= current_url() ?>" method="post">
                    <div class="box-header with-border">
                        <h3 class="box-title">Akun Saya</h3>
                    </div>
                    <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>

                        <div class="form-group  text-center">
                            <img height="100" width="100" class="profile-user-img img-responsive img-circle"
                                src="<?= base_url("media/users/{$userAuth->picture}") ?>" alt="User profile picture">
                            <span class="btn btn-default btn-xs btn-file"> Ganti Foto
                                <input name="file-upload-input" class="file-upload-input" id="input" type='file'
                                accept=".jpg, .png" />
                            </span>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="firstname">Nama Depan</label>
                                <input id="firstname" name="firstname" class="form-control" type="text"
                                    value="<?= $userAuth->firstname ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastname">Nama Belakang</label>
                                <input id="lastname" name="lastname" class="form-control" type="text"
                                    value="<?= $userAuth->lastname ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" class="form-control" type="email"
                                value="<?= $userAuth->email ?>">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="time_format">Format Jam</label>
                                <select id="time_format" name="time_format" class="form-control">
                                    <?php $tf = $userAuth->time_format == "12" ? "12" : "24" ?>
                                    <option value="24" <?= $tf == "24" ? "selected" : "" ?>><?= "24 jam" ?>
                                    </option>
                                    <option value="12" <?= $tf == "12" ? "selected" : "" ?>><?= "12 jam" ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_format">Format Tanggal</label>
                                <select id="date_format" name="date_format" class="form-control">
                                    <?php
                                        \Moment\Moment::setLocale('id_ID');
                                        $date_now = new \Moment\Moment(date('Y-m-d H:i:s'), date_default_timezone_get());

                                        $date_now->setTimezone($userAuth->timezone);
    
                                        $udf = $userAuth->date_format;

                                        $avaiable_format = [
                                            "Y-m-d", "d-m-Y", "d/m/Y", "m/d/Y",
                                            "d F Y", "F d, Y", "d M, Y", "M d, Y"
                                        ];

                                        foreach ($avaiable_format as $df) {
                                            $selected = ($udf == $df) ? "selected" : "";
                                            echo '<option value="' . $df . '"' . $selected .'>' . $date_now->format($df) . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="timezone">Zona Waktu</label>
                            <select id="timezone" name="timezone" class="form-control select2">
                                <?php $t = $userAuth->timezone; ?>
                                <?php foreach (getTimezones() as $k => $v): ?>
                                <option value="<?= $k ?>" <?= $k == $t ? "selected" : "" ?>><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input id="password" name="password" class="form-control" type="password">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passconfirm">Konfirmasi Password</label>
                                <input id="passconfirm" name="passconfirm" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="app_theme">Tema Aplikasi</label>
                                <?php 
                                $at = $userAuth->app_theme; 
                                $avaiable_themes = [
                                    "skin-blue" => "Blue",
                                    "skin-blue-light" => "Blue Light",
                                    "skin-yellow" => "Yellow",
                                    "skin-yellow-light" => "Yellow Light",
                                    "skin-green" => "Green",
                                    "skin-green-light" => "Grren Light",
                                    "skin-purple" => "Purple",
                                    "skin-purple-light" => "Purple Light",
                                    "skin-red" => "Red",
                                    "skin-red-light" => "Red Light",
                                    "skin-black" => "Black",
                                    "skin-black-light" => "Black Light"
                                ];
                                ?>
                                <?php foreach ($avaiable_themes as $key => $val): ?>
                                <div class="checkbox">
                                    <input type="radio" class="icheck-flat-blue" name="app_theme" value="<?=$key?>"
                                        <?=$key == $at ? "checked" : ""?>>
                                    <span><?=$val?></span>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="app_layout">Tampilan Aplikasi</label>
                                <div class="form-group">
                                    <?php 
                                    $al = explode(" ", $userAuth->app_layout); 
                                    $avaiable_layouts = [
                                        "fixed" => "Fixed",
                                        "sidebar-collapse" => "Sidebar Collapse",
                                        "layout-boxed" => "Boxed"
                                    ];
                                    ?>
                                    <?php foreach ($avaiable_layouts as $key => $val): ?>
                                    <div class="checkbox">
                                        <input type="checkbox" class="icheck-flat-blue" name="app_layout[]"
                                            value="<?= $key ?>" <?= in_array($key, $al) ? "checked" : "" ?>>
                                        <span><?= $val ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="action" value="update">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Paket Saya</h3>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">Paket Anda <span class="pull-right badge bg-blue">Paket Madesu</span></a></li>

                        <?php 
                            \Moment\Moment::setLocale('id_ID');
                            $expire_date = new \Moment\Moment($userAuth->expire_date, date_default_timezone_get());

                            $expire_date->setTimezone($userAuth->timezone);
                        ?>

                        <li>
                            <a href="#">Tanggal Kadaluwarsa
                                <span class="pull-right badge bg-blue">
                                    <?= $expire_date->format($userAuth->date_format) ?>
                                    <?= $expire_date->format($userAuth->time_format == "12" ? "h:i A" : "H:i") ?>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="box-footer">
                    <a href="#" class="btn btn-sm btn-info">Perbaharui Paket</a>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title text-gray">Ganti Gambar Profile</h4>
            </div>
            <div class="modal-body no-padding">
                <div class="image_container" style="max-height:350px"> <img id="img-upload" src="#" alt="your image" /> </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="crop_button">Simpan</button> </div>
        </div>
    </div>
</div>
 <section class="content">
     <div class="row">
         <div class="col-md-6">
             <div class="box box-solid">
                 <form id="form-ajax" action="<?= base_url("users") ?>" method="post" autocomplete="off">
                     <input type="hidden" name="action" value="save">
                     <input type="hidden" name="id" value=" <?= $User->id ?>">
                     <div class="box-header with-border">
                         <h3 class="box-title">Edit Pengguna</h3>
                     </div>
                     <div class="box-body">
                         <div id="message"><?= showAlert() ?></div>
                         <div class="row">
                             <div class="form-group col-md-6">
                                 <label for="account_type">Tipe Akun</label>
                                 <select id="account_type" name="account_type" class="form-control"
                                     <?= $User->account_type == "admin" && $User->id == $userAuth->id ? "disabled" : "" ?>>
                                     <option value="admin" <?= $User->account_type == "admin" ? "selected" : "" ?>>Admin
                                     </option>
                                     <option value="member" <?= $User->account_type == "member" ? "selected" : "" ?>>
                                         Member
                                     </option>
                                 </select>
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="status">Status</label>
                                 <select id="status" name="status" class="form-control"
                                     <?= $User->account_type == "admin" && $User->id == $userAuth->id ? "disabled" : "" ?>>
                                     <option value="1" <?= $User->is_active == 1 ? "selected" : "" ?>>
                                         Aktif</option>
                                     <option value="0" <?= $User->is_active == 0 ? "selected" : "" ?>>
                                         Tidak Aktif</option>
                                 </select>
                             </div>
                         </div>
                         <div class="form-group">
                             <label for="expire_date">Tanggal kadaluarsa</label>

                             <?php 
                                $date = new DateTime($User->expire_date);
                                $date->setTimezone(new DateTimeZone($userAuth->timezone));
                            ?>

                             <input id="expire_date" name="expire_date" class="form-control js-datepicker"
                                 data-position="bottom right" value="<?= $date->format("Y-m-d H:i") ?>" type="text"
                                 maxlength="20" <?= $User->account_type == "admin" && $User->id == $userAuth->id ? "disabled" : "readonly" ?>>
                         </div>
                         <div class="row">
                             <div class="form-group col-md-6">
                                 <label for="firstname">Nama Depan</label>
                                 <input id="firstname" name="firstname" class="required form-control" type="text"
                                     value="<?= $User->firstname ?>">
                             </div>
                             <div class="form-group col-md-6">
                                 <label for="lastname">Nama Belakang</label>
                                 <input id="lastname" name="lastname" class="required form-control" type="text"
                                     value="<?= $User->lastname ?>">
                             </div>
                         </div>
                         <div class="form-group">
                             <label for="email">Email</label>
                             <input id="email" name="email" class="form-control" type="email"
                                 value="<?= $User->email ?>">
                         </div>
                         <div class="row">
                             <div class="form-group col-md-6">
                                 <label for="time_format">Format Jam</label>
                                 <select id="time_format" name="time_format" class="form-control">
                                     <?php $tf = $User->time_format == "12" ? "12" : "24" ?>
                                     <option value="24" <?= $tf == "24" ? "selected" : "" ?>>
                                         24
                                     </option>
                                     <option value="12" <?= $tf == "12" ? "selected" : "" ?>>
                                         12
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

                                        $udf = $User->date_format;

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
                                 <?php $t = $User->timezone; ?>
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
                                $at = $User->app_theme; 
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
                                        <input type="radio" class="icheck-flat-blue" name="app_theme"
                                                value="<?=$key?>"
                                                <?=$key == $at ? "checked" : ""?>>
                                        <span><?=$val?></span>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="app_layout">Tampilan Aplikasi</label>
                                <div class="form-group">
                                    <?php 
                                    $al = explode(" ", $User->app_layout); 
                                    $avaiable_layouts = [
                                        "fixed" => "Fixed",
                                        "sidebar-collapse" => "Sidebar Collapse",
                                        "layout-boxed" => "Boxed"
                                    ];
                                    ?>
                                    <?php foreach ($avaiable_layouts as $key => $val): ?>
                                    <div class="checkbox">
                                        <input type="checkbox" class="icheck-flat-blue" name="app_layout[]"
                                                value="<?= $key ?>"
                                                <?= in_array($key, $al) ? "checked" : "" ?>>
                                        <span><?= $val ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                     </div>
                     <div class="box-footer">
                         <a href="<?= base_url("users") ?>" class="btn btn-warning">Kembali</a>
                         <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </section>
 <section class="content">
     <div class="row">
         <div class="col-md-6">
             <div class="box box-solid">
                 <form id="form-ajax" action="<?= base_url("users") ?>" method="post" autocomplete="off">
                     <input type="hidden" name="action" value="save">
                     <div class="box-header with-border">
                         <h3 class="box-title">Tambah Pengguna</h3>
                     </div>
                     <div class="box-body">
                        <div id="message"><?= showAlert() ?></div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="account_type">Tipe Akun</label>
                                <select id="account_type" name="account_type" class="form-control">
                                    <option value="member">Member</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expire_date">Tanggal kadaluarsa</label>

                            <?php
                                $date = new DateTime(date("Y-m-d H:i:s", time() + 30*86400));
                                $date->setTimezone(new DateTimeZone($userAuth->timezone));
                            ?>

                            <input id="expire_date" name="expire_date" class="form-control js-datepicker"
                                data-position="bottom right" value="<?= $date->format("Y-m-d H:i") ?>" type="text"
                                maxlength="20" readonly>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="firstname">Nama Depan</label>
                                <input id="firstname" name="firstname" class="required form-control" type="text">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastname">Nama Belakang</label>
                                <input id="lastname" name="lastname" class="required form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" class="form-control" type="email">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="time_format">Format Jam</label>
                                <select id="time_format" name="time_format" class="form-control">
                                    <option value="24">24</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_format">Format Tanggal</label>
                                <select id="date_format" name="date_format" class="form-control">
                                    <?php
                                        \Moment\Moment::setLocale('id_ID');
                                        $date_now = new \Moment\Moment(date('Y-m-d H:i:s'), date_default_timezone_get());

                                        $date_now->setTimezone($userAuth->timezone);

                                        $avaiable_format = [
                                            "Y-m-d", "d-m-Y", "d/m/Y", "m/d/Y",
                                            "d F Y", "F d, Y", "d M, Y", "M d, Y"
                                        ];
                                    ?>
                                    <?php foreach ($avaiable_format as $df): ?>
                                    <option value="<?= $df ?>"><?= $date_now->format($df) ?></option>
                                    <?php endforeach; ?>
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
                                <input id="password" name="password" class="required form-control" type="password">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passconfirm">Konfirmasi Password</label>
                                <input id="passconfirm" name="passconfirm" class="required form-control" type="password">
                            </div>
                        </div>
                     </div>
                     <div class="box-footer">
                         <a href="<?= base_url("users") ?>" class="btn btn-warning">Kembali</a>
                         <button type="submit" class="btn btn-primary">Simpan</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </section>
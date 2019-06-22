<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Pengguna</h3>
                </div>
                <div class="box-filter">
                    <div class="row">
                        <form action="<?= base_url("users") ?>" class="filter-box" method="GET" autocomplete="off">
                            <div class="col-lg-5">
                                <a href="<?= base_url("users/new") ?>" class="btn btn-primary">Tambah baru</a>
                                <button type="button" data-url="<?= base_url("users") ?>" class="rows-delete btn btn-danger" disabled>Hapus masal</button>
                               <span class="filter-loading pull-right hide"><i class="fa fa-spinner fa-spin"></i></span>
                            </div>
                            <div class="col-lg-4">
                                
                                <div class="has-feedback">
                                    
                                    <input type="text" name="q" class="form-control input-sm"
                                        placeholder="Cari berdasarkan nama atau email"
                                        value="<?= $this->input->get("q") ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="float-right">
                                    <select class="form-control" name="group">
                                        <?php $group = $this->input->get("group") ?>
                                        <option value="">Semua</option>
                                        <option value="2" <?= $group == "2" ? "selected" : "" ?>>Kadaluwarsa</option>
                                        <option value="1" <?= $group == "1" ? "selected" : "" ?>>Aktif</option>
                                        <option value="0" <?= $group == "0" ? "selected" : "" ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="row-checkall icheck-flat-blue" name="app_theme"></th>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tipe Akun</th>
                                <th scope="col">Kadaluwarsa</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="js-loadmore-content" data-loadmore-id="1">
                            <?php if (count($Users) > 0): ?>
                            <?php $no = $form; ?>
                            <?php foreach ($Users as $u): ?>
                            <tr>
                                <td><input type="checkbox" data-id="<?= $u->id ?>" class="row-checkbox icheck-flat-blue" name="app_theme"></td>
                                <td scope="row" class="numberRow"><strong><?= $no++ ?></strong></td>
                                <td><?= htmlchars($u->firstname . " " . $u->lastname) ?></td>
                                <td><?= htmlchars($u->email) ?></td>
                                <td>
                                    <?php 
                                    $expire = new DateTime($u->expire_date);
                                    $now = new DateTime();
                                    ?>

                                    <?php if ($expire < $now): ?>
                                    <span class="badge bg-yellow"> Kadaluarsa</span>
                                    <?php elseif ($u->is_active == 0): ?>
                                    <span class="badge bg-red">Tidak Aktif</span>
                                    <?php else: ?>
                                    <span class="badge bg-green">Aktif</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?php if ($u->account_type == "admin"): ?>
                                    <span>Admin</span>
                                    <?php else: ?>
                                    <span>Member</span>
                                    <?php endif;?>
                                </td>
                                <td>
                                    <?php 
                                    \Moment\Moment::setLocale('id_ID');
                                    $expire_date = new \Moment\Moment($u->expire_date, date_default_timezone_get());

                                    $expire_date->setTimezone($userAuth->timezone);
                                    ?>
                                    <span><?= $expire_date->format($userAuth->date_format) ?></span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                        <button type="button"
                                            onclick="window.location='<?=base_url("users/" . $u->id)?>';"
                                            class="btn btn-warning">Edit</button>
                                        <button type="button" class="remove-list-item btn btn-danger"
                                            data-id="<?=$u->id?>" data-url="<?=base_url("users")?>"
                                            data-name="<?= htmlchars($u->firstname) ?>"
                                            <?= ($u->id != $userAuth->id) && ($u->account_type != "admin") ? "" : "disabled" ?>>Hapus</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>

                            <tr>
                                <td colspan="8" class="text-danger text-center">Tidak ditemukan data</td>
                            </tr>

                            <?php endif;?>

                        </tbody>
                    </table>
                </div>
                <div class="box-footer loadmore">
                    <?php 
                        $url = parse_url($_SERVER["REQUEST_URI"]);
                        $path = $url["path"];
                        if(isset($url["query"])){
                            $qs = parse_str($url["query"], $qsarray);
                            unset($qsarray["page"]);

                            $url = $path."?".(count($qsarray) > 0 ? http_build_query($qsarray)."&" : "")."page=";
                        }else{
                            $url = $path."?page=";
                        }
                    ?>

                    <div class="pull-right">
                    <?php if($currentPage != 1): ?>
                    <a class="btn btn-primary js-previous-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= $url . ($currentPage - 1) ?>">
                                <span class="icon sli sli-refresh"></span><</a>
                                 <?php endif; ?>
                                <?php if($currentPage < $totalPages): ?>
                    <a class="btn btn-primary js-next-btn js-autoloadmore-btn" data-loadmore-id="1" href="<?= $url . ($currentPage + 1) ?>">
                    <span class="icon sli sli-refresh"></span>></a>
                                <?php endif; ?>

                    </div>
                </div>
                 

            </div>
        </div>
    </div>
</section>
 <section class="content">
     
     <?php if ($this->UserModel->isAdmin()): ?>
     <div class="row">
         <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                 <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                 <div class="info-box-content">
                     <span class="info-box-text">Total Pengguna</span>
                     <span class="info-box-number"><?= count($this->db->get("users")->result()) ?></span>
                 </div>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                 <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

                 <div class="info-box-content">
                     <span class="info-box-text">Pengguna Aktif</span>
                     <span
                         class="info-box-number"><?= count($this->db->where("is_active", 1)->get("users")->result()) ?></span>
                 </div>
             </div>
         </div>
         <div class="clearfix visible-sm-block"></div>
         <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                 <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                 <div class="info-box-content">
                     <span class="info-box-text">Pengguna Tidak Aktif</span>
                     <span
                         class="info-box-number"><?= count($this->db->where("is_active", 0)->get("users")->result()) ?></span>
                 </div>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="info-box">
                 <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                 <div class="info-box-content">
                     <span class="info-box-text">Pengguna Kadaluwarsa</span>

                    <?php
                    $date = new DateTime("now");
                    $curr_date = $date->format("Y-m-d H:i:s");
                    ?>

                     <span
                         class="info-box-number"><?= count($this->db->where("DATE(expire_date) <", $curr_date)->get("users")->result()) ?></span>
                 </div>
             </div>
         </div>
     </div>
     <?php endif; ?>

 </section>
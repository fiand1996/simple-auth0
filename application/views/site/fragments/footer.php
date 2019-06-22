<section id="contact" name="contact">
  <div id="footerwrap">
    <div class="container">
      <div class="col-lg-4">
        <h3>Kontak Kami</h3>
        <p>
          Jl. Ring Road Utara, Condong Catur, Sleman, Yogyakarta <br>
          Telp: (0274) 884201 - 207 <br>
          E-Mail: amikom@amikom.ac.id
        </p>
      </div>
      <div class="col-lg-4">
        <h3>Tautan</h3>
        <ul class="list-unstyled no-margin">
          <li><a href="<?= base_url("terms-services") ?>">Syarat dan ketentuan</a></li>
          <li><a href="<?= base_url("privacy-policy") ?>">Kebijakan privasi</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h3>Temukan Kami</h3>
        <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i></a>
        <a href="#" class="btn btn-danger"><i class="fa fa-google"></i></a>
        <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i></a>
      </div>
    </div>
  </div>
</section>

<footer>
  <div id="c">
    <div class="container">
      <div class="text-center">
        Copyright &copy; <?= date("Y") ?>
          <strong><a href="<?= base_url() ?>"><?= htmlchars($settingGeneral->site_name) ?></a></strong> |
          Created by <strong><a href="https://github.com/fiand1996">Fiand T</a></strong> |
        Version <strong><?= APP_VERSION ?></strong>
      </div>
    </div>
  </div>
</footer>
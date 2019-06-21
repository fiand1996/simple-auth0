<div id="navigation" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url()?>"><b><?= $settingGeneral->site_name ?></b></a>
    </div>
    <div class="navbar-collapse collapse">

      <?php if ($this->uri->segment(1) == null): ?>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#home" class="smoothScroll">Home</a></li>
        <li><a href="#intro-wrap" class="smoothScroll">Intro</a></li>
        <li><a href="#features-wrap" class="smoothScroll">Features</a></li>
        <li><a href="#pricing-wrap" class="smoothScroll">Pricing</a></li>
      </ul>
      <?php endif; ?>

      <ul class="nav navbar-nav navbar-right">
        <?php if ($this->UserModel->isLogged()): ?>
        <li class="dropdown bt-dropdown-click hidden-xs"> <a class="dropdown-toggle" data-toggle="dropdown"
            role="button" aria-haspopup="true" aria-expanded="true"> <strong>Hai, <?=$userAuth->firstname?></strong> <span
              class="caret"></span> </a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url('profile')?>">Profile Saya</a></li>
            <li><a href="<?=base_url('dashboard')?>">Dashboard</a></li>
            <li><a href="<?=base_url('signout')?>">Keluar</a></li>
          </ul>
        </li>
        <?php else: ?>
        <li><a href="<?=base_url('signin')?>">Masuk</a></li>
        <li><a href="<?=base_url('signup')?>">Daftar</a></li>
        <?php endif;?>
      </ul>
    </div>
  </div>
</div>
<section id="home" name="home">
    <div id="headerwrap">
        <div class="container">
            <div class="row centered">
                <div class="col-lg-12">
                    <h1><b><a href=""><?= $settingGeneral->site_name ?></a></b> Bootstrap Admin Template </h1>
                    <h3>Best open source admin dashboard & control panel theme. Built on top of Bootstrap, AdminLTE
                        provides a range of responsive, reusable, and commonly used components.</h3>
                    <h3>
                        <?php if ($this->UserModel->isLogged()): ?>
                        <a href="<?= base_url("dashboard") ?>" class="btn btn-lg btn-primary">Dashboard</a>
                        <?php else: ?>
                        <a href="<?= base_url("signup") ?>" class="btn btn-lg btn-success">Daftar gratis!</a>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="col-lg-2">
                    <h5>Amazing admin template</h5>
                    <p>Based on adminlte bootstrap theme</p>
                    <img class="hidden-xs hidden-sm hidden-md" src="<?= base_url("assets/img/arrow1.png") ?>">
                </div>
                <div class="col-lg-8">
                    <img class="img-responsive" src="<?= base_url("assets/img/") ?>app-bg.png" alt="">
                </div>
                <div class="col-lg-2">
                    <br>
                    <img class="hidden-xs hidden-sm hidden-md" src="<?= base_url("assets/img/arrow2.png") ?>">
                    <h5>Awesome packaged...</h5>
                    <p>... by <a href="https://github.com/fiand1996">Fiand T</a> at <a href="#">adminlte.io</a> ready to
                        use!</p>
                </div>
            </div>
        </div>
        <!--/ .container -->
    </div>
    <!--/ #headerwrap -->
</section>

<section id="intro-wrap" name="intro-wrap">
    <!-- INTRO WRAP -->
    <div id="intro">
        <div class="container">
            <div class="row centered">
                <h1>Designed To Excel</h1>
                <br>
                <br>
                <div class="col-lg-4">
                    <img src="<?= base_url("assets/img/intro01.png") ?>" alt="">
                    <h3>Community</h3>
                    <p>See <a href="#">Github project</a>, post <a href="#">issues</a> and <a href="#">Pull requests</a>
                    </p>
                </div>
                <div class="col-lg-4">
                    <img src="<?= base_url("assets/img/intro02.png") ?>" alt="">
                    <h3>Schedule</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
                <div class="col-lg-4">
                    <img src="<?= base_url("assets/img/intro03.png") ?>" alt="">
                    <h3>Monitoring</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
            <br>
            <hr>
        </div>
        <!--/ .container -->
    </div>
    <!--/ #introwrap -->
</section>

<section id="features-wrap" name="features-wrap">
    <!-- FEATURES WRAP -->
    <div id="features">
        <div class="container">
            <div class="row">
                <h1 class="centered">What&#039;s New?</h1>
                <br>
                <br>
                <div class="col-lg-6 centered">
                    <img class="centered" src="<?= base_url("assets/img/mobile.png") ?>" alt="">
                </div>

                <div class="col-lg-6">
                    <h3>Some Features</h3>
                    <br>
                    <!-- ACCORDION -->
                    <div class="accordion ac" id="accordion2">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                    href="#collapseOne">
                                    First Class Design
                                </a>
                            </div><!-- /accordion-heading -->
                            <div id="collapseOne" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                    <p>It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div><!-- /accordion-inner -->
                            </div><!-- /collapse -->
                        </div><!-- /accordion-group -->
                        <br>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                    href="#collapseTwo">
                                    Retina Ready Theme
                                </a>
                            </div>
                            <div id="collapseTwo" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p>It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div><!-- /accordion-inner -->
                            </div><!-- /collapse -->
                        </div><!-- /accordion-group -->
                        <br>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                    href="#collapseThree">
                                    Awesome Support
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p>It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div><!-- /accordion-inner -->
                            </div><!-- /collapse -->
                        </div><!-- /accordion-group -->
                        <br>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                    href="#collapseFour">
                                    Responsive Design
                                </a>
                            </div>
                            <div id="collapseFour" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <p>It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div><!-- /accordion-inner -->
                            </div><!-- /collapse -->
                        </div><!-- /accordion-group -->
                        <br>
                    </div><!-- Accordion -->
                </div>
            </div>
        </div>
        <!--/ .container -->
    </div>
    <!--/ #features -->
</section>

<section id="pricing-wrap" name="pricing-wrap">
    <div class="" id="pricing">
        <div class="container">
            <div class="row ">
                <h1 class="centered">Pricing</h1>

                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">
                    <div class="price_table_container">
                        <div class="price_table_heading">Starter</div>
                        <div class="price_table_body">
                            <div class="price_table_row cost warning-bg"><strong>$ 19</strong><span>/MONTH</span></div>
                            <div class="price_table_row">1 Website</div>
                            <div class="price_table_row">10 GB Storage</div>
                            <div class="price_table_row">10 GB Bandwidth</div>
                            <div class="price_table_row">10 Email Addresses</div>
                            <div class="price_table_row">Free Backup</div>
                            <div class="price_table_row">Full Time Support</div>
                        </div>
                        <a href="#" class="btn btn-warning btn-lg btn-block">Sign Up</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">
                    <div class="recommended"><strong><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                            RECOMMENDED</strong></div>
                    <div class="price_table_container">
                        <div class="price_table_heading">Basic</div>
                        <div class="price_table_body">
                            <div class="price_table_row cost primary-bg"><strong>$ 29</strong><span>/MONTH</span></div>
                            <div class="price_table_row">10 Websites</div>
                            <div class="price_table_row">100 GB Storage</div>
                            <div class="price_table_row">100 GB Bandwidth</div>
                            <div class="price_table_row">50 Email Addresses</div>
                            <div class="price_table_row">Free Backup</div>
                            <div class="price_table_row">Full Time Support</div>
                        </div>
                        <a href="#" class="btn btn-primary btn-lg btn-block">Sign Up</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">
                    <div class="price_table_container">
                        <div class="price_table_heading">Premium</div>
                        <div class="price_table_body">
                            <div class="price_table_row cost success-bg"><strong>$ 39</strong><span>/MONTH</span></div>
                            <div class="price_table_row">100 Websites</div>
                            <div class="price_table_row">1 TB Storage</div>
                            <div class="price_table_row">1 TB Bandwidth</div>
                            <div class="price_table_row">100 Email Addresses</div>
                            <div class="price_table_row">Free Backup</div>
                            <div class="price_table_row">Full Time Support</div>
                        </div>
                        <a href="#" class="btn btn-success btn-lg btn-block">Sign Up</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">
                    <div class="price_table_container">
                        <div class="price_table_heading">Master</div>
                        <div class="price_table_body">
                            <div class="price_table_row cost info-bg"><strong>$ 60</strong><span>/MONTH</span></div>
                            <div class="price_table_row">Unlimited Websites</div>
                            <div class="price_table_row">10 TB Storage</div>
                            <div class="price_table_row">100 TB Bandwidth</div>
                            <div class="price_table_row">1000 Email Addresses</div>
                            <div class="price_table_row">Free Backup</div>
                            <div class="price_table_row">Full Time Support</div>
                        </div>
                        <a href="#" class="btn btn-info btn-lg btn-block">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
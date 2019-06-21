<?php

class Expired extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->requireLogged();
    }

    public function index()
    {
        if (!$this->UserModel->isAdmin() &&
            !$this->UserModel->isExpire()) {
            show_404();
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Akun Kadaluwarsa",
        ];

        $this->template->app("expired/index", $VIEW_DATA);
    }
}

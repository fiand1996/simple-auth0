<?php

class Site extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
        ];

        $this->template->site("home", $VIEW_DATA);
    }

    public function privacy_policy()
    {
        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Kebijakan Privasi",
        ];

        $this->template->site("privacy_policy", $VIEW_DATA);
    }

    public function terms_services()
    {
        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Syarat dan Ketentuan",
        ];

        $this->template->site("terms_services", $VIEW_DATA);
    }
}

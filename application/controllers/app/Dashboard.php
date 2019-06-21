<?php

class Dashboard extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->requireLogged();
    }

    public function index()
    {
        if (!$this->UserModel->isAdmin() &&
            $this->userAuth->is_active == 0) {
            redirect("profile?activation=true");
        } else if ($this->UserModel->isExpire()) {
            redirect("expired");
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Dashboard",
        ];

        $this->template->app("dashboard/index", $VIEW_DATA);
    }
}

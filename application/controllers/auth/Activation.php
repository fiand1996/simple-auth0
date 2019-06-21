<?php

class Activation extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($hash = null)
    {
        $userCode = $this->UserModel->getCode($hash, "activation");

        if (!$userCode) {
            show_404();
        }

        $this->UserModel->unsetCode($userCode->id, "activation");

        if ($this->UserModel->isLogged()) {
            sendAlert("Selamat akun Anda berhasil diverifikasi!", "success");
            redirect("profile");
        }

        $userdata = [
            "IS_LOGGED" => true,
            "ACCOUNT_TYPE" => $userCode->account_type,
            "SESSION_ID" => $this->encryption->encrypt($userCode->id),
        ];

        $this->session->set_userdata($userdata);

        $hash = $userCode->id . "." . md5($userCode->password);
        set_cookie("UID", $this->encryption->encrypt($hash), 1209600);

        $VIEW_DATA = [
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Aktivasi akun",
        ];

        $this->template->auth("activation", $VIEW_DATA);
    }
}

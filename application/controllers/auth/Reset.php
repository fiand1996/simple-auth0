<?php

class Reset extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->UserModel->isLogged()) {
            redirect("dashboard");
        }
    }

    public function index($hash = null)
    {
        $userCode = $this->UserModel->getCode($hash, "recovery");

        if (!$userCode) {
            show_404();
        }

        if ($this->input->is_ajax_request() &&
            $this->input->post("action") == "reset") {
            $this->reset($userCode->id);
        }

        $VIEW_DATA = [
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Ganti Password",
        ];

        $this->template->auth("reset", $VIEW_DATA);
    }

    private function reset($id = null)
    {
        $this->response->result = 0;

        $required_fields = ["password", "passconfirm"];

        $required_ok = true;
        foreach ($required_fields as $field) {
            if (!$this->input->post($field)) {
                $required_ok = false;
            }
        }

        if (!$required_ok) {
            $this->response->message = "Semua bidang wajib di isi!";
            $this->jsonecho();
        }

        if (mb_strlen($this->input->post("password")) < 6) {
            $this->response->message = "Password tidak boleh kurang dari 6 karakter!";
            $this->jsonecho();
        } else if ($this->input->post("passconfirm") != $this->input->post("password")) {
            $this->response->message = "Konfirmasi password tidak sama dengan password!";
            $this->jsonecho();
        }

        $data = [
            'password' => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
        ];

        if ($this->UserModel->update($id, $data)) {
            $this->UserModel->unsetCode($id, "recovery");

            sendAlert("Password berhasil diubah", "success");

            $this->response->result = 1;
            $this->response->redirect = base_url("signin");
            $this->jsonecho();
        }

        $this->response->message = "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi.";
        $this->jsonecho();

    }
}

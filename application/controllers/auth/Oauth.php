<?php

class Oauth extends APP_Controller
{
    private $settingOauth;

    public function __construct()
    {
        parent::__construct();

        if ($this->UserModel->isLogged()) {
            redirect("dashboard");
        }

        $this->settingOauth = $this->SettingModel->get("oauth");
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->Oauth();
        }
        show_404();
    }

    private function Oauth()
    {
        $this->response->result = 0;

        $dialog = $this->input->post("dialog");

        if (!isset($this->settingOauth->api_key) ||
            !isset($this->settingOauth->$dialog)) {

            $this->response->message = "Otentikasi " . ucfirst($dialog) . " tidak tersedia!";
            $this->jsonecho();
        }

        $required_fields = ["firstname", "lastname", "email", "token", "userid"];

        $required_ok = true;
        foreach ($required_fields as $field) {
            if (!$this->input->post($field)) {
                $required_ok = false;
            }
        }

        if (!$required_ok) {
            $this->response->message = "Kehilangan beberapa data wajib!";
            $this->jsonecho();
        }

        if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
            $this->response->message = "Email tidak valid!";
            $this->jsonecho();
        }

        if ($dialog = "facebook") {
            $content = @file_get_contents("https://graph.facebook.com/me?access_token=" . $this->input->post("token"));
            $response = @json_decode($content);
            if (!isset($response->id)) {
                $this->response->message = "Token tidak valid!";
                $this->jsonecho();
            }
        }

        $User = $this->db->where("email", $this->input->post("email"))->get("users");

        if ($User->num_rows() > 0) {

            if ($User->row("is_active") != 1) {
                sendAlert("Akun Anda tidak aktif.", "danger");
                redirect("signin");
            }

            $userdata = [
                "IS_LOGGED" => true,
                "ACCOUNT_TYPE" => $User->row("account_type"),
                "SESSION_ID" => $this->encryption->encrypt($User->row("id")),
            ];

            $this->session->set_userdata($userdata);

            $this->response->result = 1;
            $this->response->redirect = base_url("dashboard");
            $this->jsonecho();

        } else {
            $data = [
                "account_type" => "member",
                "firstname" => $this->input->post("firstname"),
                "lastname" => $this->input->post("lastname"),
                "email" => strtolower($this->input->post("email")),
                "password" => password_hash(readableRandomString(10), PASSWORD_DEFAULT),
                "expire_date" => date("Y-m-d H:i:s", time() + 7 * 86400),
                "date" => date("Y-m-d H:i:s"),
                "is_active" => 1,
            ];

            if ($this->UserModel->add($data)) {
                $User = $this->db->where("email", $this->input->post("email"))->get("users");

                $userdata = [
                    "IS_LOGGED" => true,
                    "ACCOUNT_TYPE" => $User->row("account_type"),
                    "SESSION_ID" => $this->encryption->encrypt($User->row("id")),
                ];

                $this->session->set_userdata($userdata);

                $hash = $User->row("id") . "." . md5($User->row("password"));
                set_cookie("UID", $this->encryption->encrypt($hash), 1209600);

                $this->response->result = 1;
                $this->response->redirect = base_url("dashboard");
                $this->jsonecho();
            }
        }

        $this->response->result = 0;
        $this->response->message = "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi.";
        $this->jsonecho();
    }
}

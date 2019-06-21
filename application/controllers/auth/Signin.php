<?php

class Signin extends APP_Controller
{
    private $settingRecaptcha;

    public function __construct()
    {
        parent::__construct();

        if ($this->UserModel->isLogged()) {
            redirect("dashboard");
        }

        $this->settingRecaptcha = $this->SettingModel->get("recaptcha");
    }

    public function index()
    {
        if ($this->input->is_ajax_request() &&
            $this->input->post("action") == "signin") {
            $this->signin();
        }

        $VIEW_DATA = [
            "settingGeneral" => $this->settingGeneral,
            "settingOauth" => $this->SettingModel->get("oauth"),
            "settingRecaptcha" => $this->settingRecaptcha,
            "siteTitle" => "Masuk"
        ];

        $this->template->auth("signin", $VIEW_DATA);
    }

    private function signin()
    {
        $this->response->result = 0;

        $required_fields = [
            "email",
            "password",
        ];

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

        if (!filter_var($this->input->post("email"), FILTER_VALIDATE_EMAIL)) {
            $this->response->message = "Email yang Anda masukkan tidak valid!";
            $this->jsonecho();
        }

        if (isset($this->settingRecaptcha->site_key) &&
            isset($this->settingRecaptcha->secret_key) &&
            $this->settingRecaptcha->signin) {
                
            if (!$this->input->post('g-recaptcha-response')) {
                $this->response->message = "Harap mengisi Captcha untuk memastikan Anda bukan robot.";
                $this->jsonecho();
            }

            $secret = $this->settingRecaptcha->secret_key;
            $response = $this->input->post('g-recaptcha-response');

            $verify = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
            $response = @json_decode($verify);

            if (empty($response->success)) {
                if (isset($response->{"error-codes"})) {
                    foreach ($response->{"error-codes"} as $error_code) {
                        switch ($error_code) {
                            case 'missing-input-secret':
                            case 'invalid-input-secret':
                                $this->response->message = "Kunci rahasia tidak ada atau tidak valid untuk reCaptcha.";
                                break;

                            case 'timeout-or-duplicate':
                                $this->response->message = "Batas waktu atau duplikat untuk Recaptcha";
                                break;

                            default:
                                $this->response->message = "Recaptcha error: " . $error_code;
                                break;
                        }
                    }
                } else {
                    $this->response->message = "Tidak dapat memverifikasi recaptcha";
                }

                $this->jsonecho();
            }
        }

        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $remember = $this->input->post("rememberMe");

        if ($this->UserModel->signin($email, $password, $remember)) {
            
            if ($this->UserModel->getUserdata("is_active") == 0) {
                $this->session->unset_userdata(["IS_LOGGED", "SESSION_ID", "ACCOUNT_TYPE"]);
                delete_cookie("UID");

                $this->response->message = "Maaf akun Anda belum aktif! Silahkan cek email Anda untuk proses verifikasi.";
                $this->jsonecho();
            }

            $redirect = $this->input->post("redirect")
                      ? base_url($this->input->post("redirect"))
                      : base_url("dashboard");

            $this->response->result = 1;
            $this->response->redirect = $redirect;
            $this->jsonecho();
        }

        $this->response->message = "Email atau password salah!";
        $this->jsonecho();
    }
}

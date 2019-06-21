<?php

class Forgot extends APP_Controller
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
            $this->input->post("action") == "forgot") {
            $this->forgot();
        }

        $VIEW_DATA = [
            "settingGeneral" => $this->settingGeneral,
            "settingRecaptcha" => $this->settingRecaptcha,
            "siteTitle" => "Lupa Password"
        ];

        $this->template->auth("forgot", $VIEW_DATA);
    }

    private function forgot()
    {
        $this->response->result = 0;

        $required_fields = [
            "email",
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
            $this->settingRecaptcha->forgot) {
                
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

        $getUserByEmail = $this->db->where("email", $this->input->post("email"))->get("users");

        if ($getUserByEmail->num_rows() == 1) {
            $this->load->library("mail");

            if ($this->mail->sendNotification("recovery", $getUserByEmail->row_array())) {
                sendAlert("Tautan untuk reset password telah terkirim. Silahkan cek email Anda.", "success");
            } else {
                sendAlert("Tautan untuk reset password gagal terkirim. Silahkan Coba lagi nanti.", "danger");
                $this->UserModel->unsetCode($getUserByEmail->row("id"), "recovery");
            }

            $this->response->result = 1;
            $this->response->redirect = base_url("forgot");
            $this->jsonecho();
        }

        $this->response->message = "Email yang Anda masukkan tidak ditemukan!";
        $this->jsonecho();
    }
}

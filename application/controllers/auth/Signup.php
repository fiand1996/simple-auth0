<?php

class Signup extends APP_Controller
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
            $this->input->post("action") == "signup") {
            $this->signup();
        }

        $VIEW_DATA = [
            "settingGeneral" => $this->settingGeneral,
            "settingOauth" => $this->SettingModel->get("oauth"),
            "settingRecaptcha" => $this->settingRecaptcha,
            "IpInfo" => $this->IpInfo,
            "TimeZones" => getTimezones(),
            "siteTitle" => "Daftar"
        ];

        $this->template->auth("signup", $VIEW_DATA);
    }

    private function signup()
    {
        $this->response->result = 0;

        $required_fields = [
            "firstname",
            "lastname",
            "email",
            "password",
            "passconfirm",
            "timezone"
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
        } else {
            $User = $this->db->where("email", $this->input->post("email"))->get("users");
            if ($User->num_rows() > 0) {
                $this->response->message = "Email yang Anda masukkan tidak tersedia!";
                $this->jsonecho();
            }
        }

        if (mb_strlen($this->input->post("password")) < 6) {
            $this->response->message = "Password tidak boleh kurang dari 6 karakter!";
            $this->jsonecho();
        } else if ($this->input->post("passconfirm") != $this->input->post("password")) {
            $this->response->message = "Konfirmasi password tidak sama dengan password!";
            $this->jsonecho();
        }

        if (isset($this->settingRecaptcha->site_key) &&
            isset($this->settingRecaptcha->secret_key) &&
            $this->settingRecaptcha->signup) {

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

        $data = [
            "firstname" => $this->input->post("firstname"),
            "lastname" => $this->input->post("lastname"),
            "account_type" => "member",
            "email" => strtolower($this->input->post("email")),
            "password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
            "timezone" => $this->input->post("timezone"),
            "is_active" => 0,
            "expire_date" => date("Y-m-d H:i:s", time() + 7 * 86400),
            "date" => date("Y-m-d H:i:s"),
        ];

        if ($this->UserModel->add($data)) {
            sendAlert("Selamat pendaftaran berhasil! Silahkan cek email Anda untuk proses verifikasi.", "success");

            $redirect = $this->input->post("redirect")
                      ? base_url($this->input->post("redirect"))
                      : base_url("signin");

            $getUserByEmail = $this->db->where("email", strtolower($this->input->post("email")))->get("users");

            $this->load->library("mail");

            if (!$this->mail->sendNotification("activation", $getUserByEmail->row_array())) {
                sendAlert("Selamat pendaftaran berhasil! Silahkan masuk untuk melanjutkan.", "success");
                $this->UserModel->unsetCode($getUserByEmail->row("id"), "activation");
            }

            $this->response->result = 1;
            $this->response->redirect = $redirect;
            $this->jsonecho();
        }

        $this->response->message = "Terjadi kesalahan! Silahkan ulangi beberapa saat lagi.";
        $this->jsonecho();
    }
}

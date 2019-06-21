<?php

class Settings extends APP_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->requireLogged();

        if (!$this->UserModel->isAdmin()) {
            show_404();
        }
    }

    public function index()
    {
        if ($this->input->is_ajax_request() &&
            $this->input->post("action") == "general") {
            $this->saveGaneralSetting();
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Pengaturan Umum",
        ];

        $this->template->app("settings/index", $VIEW_DATA);
    }

    public function email()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post("action") == "test-email") {
                $this->sendTestEmail();
            } else if ($this->input->post("action") == "email") {
                $this->saveEmailSetting();
            }
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "settingEmail" => $this->SettingModel->get("email"),
            "siteTitle" => "Pengaturan Email",
        ];

        $this->template->app("settings/email", $VIEW_DATA);
    }

    public function recaptcha()
    {
        if ($this->input->is_ajax_request() &&
            $this->input->post("action") == "recaptcha") {
            $this->saveRecaptchaSetting();
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "settingRecaptcha" => $this->SettingModel->get("recaptcha"),
            "siteTitle" => "Pengaturan reCAPTCHA",
        ];

        $this->template->app("settings/recaptcha", $VIEW_DATA);
    }

    public function social_login()
    {
        if ($this->input->is_ajax_request() &&
            $this->input->post("action") == "oauth") {
            $this->saveOauthSetting();
        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "settingOauth" => $this->SettingModel->get("oauth"),
            "siteTitle" => "Pengaturan Sosial Login",
        ];

        $this->template->app("settings/social_login", $VIEW_DATA);
    }

    public function db_backup()
    {
        if ($this->input->post("action")) {

            $this->load->dbutil();

            $prefs = [
                "format" => "txt",
                "add_drop" => true,
                "add_insert" => true,
                "newline" => "\n",
            ];

            $tables = $this->input->post("tables") ? $this->input->post("tables") : [];
            $file_name = "backup_" . date("Y-m-d H-i-s") . ".sql";

            if (count($tables) > 0) {
                $prefs["tables"] = $tables;
                $file_name = implode("_", $tables) . "_backup_" . date("Y-m-d H-i-s") . ".sql";
            }

            $backup = $this->dbutil->backup($prefs);

            $backup_path = dirname(BASEPATH) . "/storage/database/";

            if (!file_exists($backup_path)) {
                mkdir($backup_path);
            }

            $this->load->helper("file");

            @write_file($backup_path . $file_name, $backup);

            if ($this->input->post("download")) {
                $this->load->helper("download");
                force_download($file_name, $backup);
            }

        }

        $VIEW_DATA = [
            "userAuth" => $this->userAuth,
            "settingGeneral" => $this->settingGeneral,
            "siteTitle" => "Database Backup",
        ];

        $this->template->app("settings/db_backup", $VIEW_DATA);
    }

    private function saveGaneralSetting()
    {
        $this->SettingModel->set("general", [
            "site_name" => $this->input->post("site_name"),
            "site_title" => $this->input->post("site_title"),
            "site_description" => $this->input->post("site_description"),
            "site_keywords" => $this->input->post("site_keywords"),
        ]);

        $this->session->set_userdata("settingGeneral", $this->SettingModel->get("general"));
        $this->settingGeneral = $this->session->userdata("settingGeneral");

        $this->response->result = 1;
        $this->response->message = "Data berhasil disimpan!";
        $this->jsonecho();
    }

    private function saveEmailSetting()
    {
        $this->SettingModel->set("email", [
            "host" => $this->input->post("host"),
            "port" => $this->input->post("port"),
            "from" => $this->input->post("from"),
            "encryption" => $this->input->post("encryption"),
            "auth" => $this->input->post("auth") ? 1 : 0,
            "username" => $this->input->post("username"),
            "password" => $this->input->post("password"),
        ]);

        $this->response->result = 1;
        $this->response->message = "Data berhasil disimpan!";
        $this->jsonecho();
    }

    public function saveOauthSetting()
    {
        $this->SettingModel->set("oauth", [
            "api_key" => $this->input->post("api_key"),
            "facebook" => $this->input->post("facebook") ? 1 : 0,
            "twitter" => $this->input->post("twitter") ? 1 : 0,
            "google" => $this->input->post("google") ? 1 : 0,
            "github" => $this->input->post("github") ? 1 : 0,
        ]);

        $this->response->result = 1;
        $this->response->message = "Data berhasil disimpan!";
        $this->jsonecho();
    }

    private function saveRecaptchaSetting()
    {
        $this->SettingModel->set("recaptcha", [
            "site_key" => $this->input->post("site_key"),
            "secret_key" => $this->input->post("secret_key"),
            "signin" => $this->input->post("signin") ? 1 : 0,
            "signup" => $this->input->post("signup") ? 1 : 0,
            "forgot" => $this->input->post("forgot") ? 1 : 0,
        ]);

        $this->response->result = 1;
        $this->response->message = "Data berhasil disimpan!";
        $this->jsonecho();
    }

    private function sendTestEmail()
    {
        $this->load->library("mail");

        if (!$this->mail->sendTestEmail(["email" => $this->input->post("email")])) {
            $this->response->result = 0;
            $this->response->message = "Email gagal terkirim! Pastikan konfigurasi Anda benar!";
            $this->jsonecho();
        } else {
            $this->response->result = 1;
            $this->response->message = "Email berhasil terkirim!";
            $this->jsonecho();
        }
    }
}
